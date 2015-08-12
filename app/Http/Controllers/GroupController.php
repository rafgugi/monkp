<?php namespace App\Http\Controllers;

use App\Corporation;
use App\Grade;
use App\Group;
use App\Lecturer;
use App\Member;
use App\Mentor;
use Auth;
use Excel;
use Illuminate\Pagination\LengthAwarePaginator as Pagination;
use Request;

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
		switch (Auth::user()->role) {
			case 'LECTURER':
			case 'STUDENT':
				$groups = Auth::user()->personable->groups;
				break;
			case 'ADMIN':
				$groups = Group::get();
				break;
			default:
				return view('home');
				break;
		}

		$lecturers = Lecturer::getDosen()->sortBy('initial');

		$total = $groups->count();
		$perPage = 10;
		$page = Request::input('page');
		$page == null ? 1 : $page;
		$option = ['path' => url('home')];

		$groups = new Pagination($groups, $total, $perPage, $page, $option);
		// dd($groups, $groups->render());
		$data = compact('groups', 'lecturers');
		return view('inside.kelompok', $data);
	}

	/**
	 * Update the status and lecturer via json.
	 *
	 * @param  int  $id
	 * @return string
	 */
	public function update($id)
	{
		$group = Group::find($id);
		if ($group == null) {
			return $this->alert('danger', 'ID kelompok tidak terdaftar.');
		}

		$rstat = Request::input('status');
		$rlect = Request::input('dosen');
		$group->start_date = Request::input('start_date');
		$group->end_date = Request::input('end_date');

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

	/**
	 * Update the mentor via json.
	 *
	 * @param  int  $id
	 * @return string
	 */
	public function updateMentor($id) {
		$group = Group::find($id);
		if ($group == null) {
			return $this->alert('danger', 'ID kelompok tidak terdaftar.');
		}
		if ($group->mentor == null) {
			$mentor = new Mentor;
			$mentor->group_id = $id;
			$mentor->name = Request::input('mentor');
			$mentor->save();
		} else {
			$group->mentor->name = Request::input('mentor');
			$group->mentor->save();
		}
		return $this->alert('info', 'Mentor berhasil diperbarui.');
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
		$corps = Corporation::get()->sortByDesc(
				function($s) { return $s->groups->count(); }
			);
		$lects = Lecturer::getDosen()->sortByDesc(
				function($s) { return $s->groups->count(); }
			);
		$data = compact('groups', 'corps', 'lects');
		return view('inside.statistic', $data);
	}

	/**
	 * Display groups listing in table.
	 *
	 * @return Response
	 */
	public function table() {
		$members = Member::get();

		$total = $members->count();
		$perPage = 15;
		$page = Request::input('page');
		$page == null ? 1 : $page;
		$option = ['path' => url('table')];

		$members = new Pagination($members, $total, $perPage, $page, $option);

		$data = compact('members');
		return view('inside.table', $data);
	}


	/**
	 * Update the grades via json.
	 *
	 * @param  int  $id member_id
	 * @return string
	 */
	public function grading($id)
	{
		$req = Request::all();
		if ($req == []) {
			return $this->alert('warning', 'Nilai tidak diperbarui.');
		}
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
	 * Export group and corporation to excel.
	 *
	 * @return File .xls
	 */
	public function export() {
		$excel = Excel::create('export');
		$excel->setTitle('Export List Kelompok KP')
			  ->setCreator('Teknik Informatika')
			  ->setCompany('Teknik Informatika');

		$members = [];
		foreach (Member::get() as $member) {
			$q['Nama'] = $member->student->name;
			$q['NRP'] = $member->student->nrp;
			$q['Kelompok (Status)'] = $member->group->id . ' (' . $member->group->status['name'] . ')';
			$q['Mulai'] = $member->group->start_date;
			$q['Selesai'] = $member->group->end_date;
			$q['Dosen Pembimbing'] = $member->group->lecturer == null ? '-' : $member->group->lecturer->name;
			$q['Perusahaan'] = $member->group->corporation->name_city;
			$q['Pembimbing Lapangan'] = $member->group->mentor == null ? '-' : $member->group->mentor->name;
			$q['NI'] = $member->grade == null ? '-' : $member->grade->lecturer_grade;
			$q['NE'] = $member->grade == null ? '-' : $member->grade->mentor_grade;
			$q['ND'] = $member->grade == null ? '-' : $member->grade->discipline_grade;
			$q['NB'] = $member->grade == null ? '-' : $member->grade->report_status;
			array_push($members, $q);
		}
		// dd($members);
		$excel->sheet('Kelompok', function($sheet) use($members) {
			$sheet->fromArray($members, null, 'A1', true);
			$sheet->setBorder('A1:L' . (count($members) + 1), 'thin');
		});
		return $excel->export('xls');
	}

}
