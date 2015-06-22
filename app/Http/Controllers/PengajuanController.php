<?php namespace App\Http\Controllers;

use App\Http\Requests\StorePengajuanRequest as StoreRequest;
use App\Http\Controllers\Controller;
use App\Corporation;
use App\Group;
use App\Student;
use App\User;
use App\GroupRequest as Friend;
use App\Notification as Notif;
use Auth;

class PengajuanController extends Controller {

	/**
	 * Only student is allowed to access.
	 */
	public function __construct() {
		$this->middleware('student');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$corps = Corporation::get()->toJson();
		$students = Student::where('id', '!=', Auth::user()->personable_id)->get();
		$data = compact('students', 'corps');
		// dd($data);
		return view('inside.pengajuan', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StoreRequest $request)
	{
		$req = $request->all();
		$creq = array_only($req['corporation'], ['name']);
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
		Auth::user()->personable->groups()->save($group);

		$friend_id = $req['friend'];
		if ($friend_id != 0) {
			# ngajak orang buat jadi temen kelompok
			$friend = new Friend;
			$friend->group_id = $group->id;
			$friend->status = 0;
			$friend->save();

			# bikin notifnya
			$notif = new Notif;
			$notif->user_id = Student::find($friend_id)->user->id;
			$notif->notifiable_id = $friend->id;
			$notif->notifiable_type = 'group request';
			$notif->is_read = false;
			$notif->save();
		}
		// dd(compact('member', 'group', 'corp', 'friend', 'notif'));

		return redirect('home');
	}

	public function accept($id)
	{
		$groupreq = Friend::find($id);
		$groupreq->status = 1;
		$groupreq->notif->is_read = true;
		$groupreq->notif->save();
		$groupreq->save();

		$student = Auth::user()->personable;
		$student->groups()->attach($groupreq->group_id);

		return redirect()->back();
	}

	public function reject($id)
	{
		$groupreq = Friend::find($id);
		$groupreq->status = 2;
		$groupreq->notif->is_read = true;
		$groupreq->notif->save();
		$groupreq->save();

		return redirect()->back();
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
	 * @param  int  $id of Group
	 * @return Response
	 */
	public function destroy($id)
	{
		$group = Group::find($id);
		$group->status = -1;
		foreach ($group->requests as $request) {
			$request->notif->delete();
			$request->delete();
		}

	}

}
