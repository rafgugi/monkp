<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Lecturer;
use App\Group;
use App\Grade;
use App\Mentor;
use App\Member;
use App\Corporation;

class GroupController extends Controller {

	/**
	 * Display either login page or groups listing.
	 *
	 * @return Response
	 */
	public function home()
	{
		if (Auth::check()) {
			return $this->index();
		}
		return redirect('auth/login');
	}

	/**
	 * Display groups listing.
	 *
	 * @return Response
	 */
	public function index()
	{
		$lecturers = Lecturer::getDosen()->sortBy('initial');
		switch (Auth::user()->role) {
			case 'LECTURER':
			case 'STUDENT':
				$groups = Auth::user()->personable->groups;
				$data = compact('groups', 'lecturers');
				return view('inside.kelompok', $data);
				break;
			case 'ADMIN':
				$groups = Group::get();
				$data = compact('groups', 'lecturers');
				return view('inside.kelompok', $data);
				break;
		}
		return view('home');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$group = Group::find($id);
		if ($group == null) {
			return $this->alert('danger', 'ID kelompok tidak terdaftar.');
		}

		$rstat = $request->input('status');
		$rlect = $request->input('dosen');
		$group->start_date = $request->input('start_date');
		$group->end_date = $request->input('end_date');

		if ($rstat == 2) {
			if ($rlect == '-') {
				return $this->alert('warning', 'Silahkan pilih dosen pembimbing.');
			}
			$dosen = Lecturer::find($rlect);
			if ($dosen == null || $dosen->nip == '0') {
				return $this->alert('danger', 'Dosen tidak ada dalam database.');
			}
			$group->status = $rstat;
			$group->lecturer_id = $rlect;
			foreach($group->members as $member) {
				$member->grade()->save(new Grade);
			}
			$group->save();
		} else {
			$group->status = $rstat;
			$group->save();
		}
		return $this->alert('info', 'Kelompok telah berhasil diperbarui.');
	}

	public function updateMentor($id, Request $request) {
		$group = Group::find($id);
		if ($group == null) {
			return $this->alert('danger', 'ID kelompok tidak terdaftar.');
		}
		if ($group->mentor == null) {
			$mentor = new Mentor;
			$mentor->group_id = $id;
			$mentor->name = $request->input('mentor');
			$mentor->save();
		} else {
			$group->mentor->name = $request->input('mentor');
			$group->mentor->save();
		}
		return $this->alert('info', 'Mentor berhasil diperbarui.');
	}

	public function grading($id, Request $request)
	{
		$req = $request->all();
		$lecturer_grade = $req['lecturer_grade'];
		$mentor_grade = $req['mentor_grade'];
		$discipline_grade = $req['discipline_grade'];
		$report_status = $req['report_status'];

		$member = Member::find($id);
		if ($member->grade == null) {
			$member->grade = new Grade;
		}
		$grade = $member->grade;

		$member->grade->lecturer_grade = is_numeric($lecturer_grade) ? $lecturer_grade : '';
		$member->grade->mentor_grade = is_numeric($mentor_grade) ? $mentor_grade : '';
		$member->grade->discipline_grade = is_numeric($discipline_grade) ? $discipline_grade : '';
		$member->grade->report_status = is_numeric($report_status) ? $report_status : '';

		$member->grade->save();
		return $this->alert('info', 'Nilai berhasil diperbarui.');
	}

	/**
	 * Create json alert for view 'inside.kelompok'.
	 *
	 * @return string
	 */
	protected function alert($alert, $body) {
		return json_encode(compact('alert', 'body'));
	}

	/**
	 * Display statistics.
	 *
	 * @return Response
	 */
	public function stats() {
		$groups = Group::get();
		$corps = Corporation::get()->sortBy(
				function($s) { return $s->groups->count(); }
			)->reverse();
		$dosens = Lecturer::getDosen()->take(10)->sortBy(
				function($s) { return $s->groups->count(); }
			)->reverse();
		$data = compact('groups', 'corps', 'dosens');
		return view('inside.statistic', $data);
	}

	/**
	 * Display groups listing in table.
	 *
	 * @return Response
	 */
	public function table() {
		$members = Member::get();
		$data = compact('members');
		return view('inside.table', $data);
	}

	/**
	 * Export group and corporation to excel.
	 *
	 * @return File .xls
	 */
	public function export() {
		return 'excel';
	}

	/**
	 * Remove the group and related resource.
	 *
	 * @param  int  $id of Group
	 * @return Response
	 */
	public function destroy($id)
	{
		$group = Group::find($id);
		foreach ($group->requests as $request) {
			$request->notif->delete();
			$request->delete();
		}
		foreach ($group->members as $member) {
			$member->delete();
		}
		$group->delete();

		return redirect()->back();
	}

}
