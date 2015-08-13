<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Corporation;
use App\Group;
use App\Student;
use App\Semester;
use App\GroupRequest as Friend;
use App\Notification as Notif;
use Auth;

class PengajuanController extends Controller {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$corps = Corporation::get()->sortBy('name')->toJson();
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
	public function store(Request $request)
	{
		$this->validate($request, [
			'corporation.name' => 'required',
			'corporation.city' => 'required',
			'corporation.address' => 'required',
			'corporation.business_type' => 'required',
			'corporation.description' => 'required',
			'group.start_date' => 'required|date|before:'
					. $request['group']['end_date'],
			'group.end_date' => 'required|date',
		]);

		$request = $request->all();
		$creq = $request['corporation'];
		$greq = $request['group'];

		# check if student 1 has created group in the same semester
		$now = Semester::now();
		$student = Auth::user()->personable;
		$student_groups = $student->groups->where('semester_id', $now->id);
		foreach ($student_groups as $group) {
			if ($group->status['status'] >= 0) {
				return redirect()->back()->with('you');
			}
		}

		# check if student 2 has created group in the same semester
		$friend_id = $request['friend'];
		$student2 = Student::find($friend_id);
		if ($student2 != null) {
			$groups = $student2->groups->where('semester_id', $now->id);
			$allowed = true;
			foreach ($groups as $group) {
				if ($group->status['status'] >= 0) {
					return redirect()->back()->with('you');
				}
			}
		}

		# fill corporation
		$corp = Corporation::firstOrNew(array_only($creq, ['name', 'city']));
		$corp->fill($creq);
		$corp->save();

		# make group
		$group = new Group($greq);
		$group->corporation()->associate($corp);
		$group->semester()->associate(Semester::now());
		$group->save();

		# connect group to student
		Auth::user()->personable->groups()->save($group);

		if ($student2 != null) {
			# ngajak orang buat jadi temen kelompok
			$friend = new Friend;
			$friend->group_id = $group->id;
			$friend->status = 0;
			$friend->save();

			# bikin notifnya
			$notif = new Notif;
			$notif->user_id = $student2->user->id;
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
		if ($groupreq != null) {
			$groupreq->status = 1;
			$groupreq->notif->is_read = true;
			$groupreq->notif->save();
			$groupreq->save();

			$student = Auth::user()->personable;
			$student->groups()->attach($groupreq->group_id);
		}
		return redirect()->back();
	}

	public function reject($id)
	{
		$groupreq = Friend::find($id);
		if ($groupreq != null) {
			$groupreq->status = 2;
			$groupreq->notif->is_read = true;
			$groupreq->notif->save();
			$groupreq->save();
			dd($groupreq, $groupreq->notif);
		}
		return redirect()->back();
	}

}
