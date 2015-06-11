<?php namespace App\Http\Controllers;

use App\Http\Requests\StorePengajuanRequest as StoreRequest;
use App\Http\Controllers\Controller;
use App\Corporation;
use App\Group;
use App\Member;
use Auth;

class PengajuanController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inside.pengajuan');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StoreRequest $request)
	{
		$req = $request->all();
		$creq = $req['corporation'];
		$greq = $req['group'];

		# fill corporation
		$corp = Corporation::firstOrNew(array_only($creq, ['name', 'city']));
		$corp->fill($creq);
		$corp->save();

		# make group
		$group = new Group($greq);
		$group->corporation()->associate($corp);
		$group->save();

		# connect group to student
		$member = new Member();
		$member->group()->associate($group);
		$member->student()->associate(Auth::user()->personable);
		$member->status = 1;
		$member->save();
		// dd(compact('member', 'group', 'corp'));
		// diredirect kemana nih?
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
