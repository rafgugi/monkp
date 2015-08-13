<?php namespace App\Http\Controllers;

use App\Corporation;
use App\Grade;
use App\Group;
use App\Lecturer;
use App\Member;
use App\Semester;
use DB;
use Excel;
use Request;

use Illuminate\Pagination\LengthAwarePaginator as Pagination;

class SettingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$semester = Semester::latest();
		$data = compact('semester');
		return view('inside.settings', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$request = Request::only(['year', 'odd', 'start_date', 'end_date', 'user_due_date']);
		// dd($request);
		$semester = Semester::firstOrNew(Request::only(['year', 'odd']));
		$baru = false;
		if ($semester->id == null) {
			$baru = true;
		}
		$semester->fill($request);
		$semester->save();
		if (!$baru) {
			return redirect()->back()
				->with('alert', ['alert' => 'success', 'body' => 'Berhasil memperbarui semester.']);
		}
		return redirect()->back()
			->with('alert', ['alert' => 'success', 'body' => 'Berhasil membuat semester baru.']);
	}

	/**
	 * Display statistics.
	 *
	 * @return Response
	 */
	public function stats() {
		// $results = DB::select('SELECT groups.*, lecturers.*, corporations.*
		// 			FROM groups, semesters, (
		// 				SELECT corporations.*, COUNT(groups.id) AS corp_count
		// 				FROM corporations, groups
		// 				WHERE groups.corporation_id = corporations.id
		// 			) AS corporations, (
		// 				SELECT lecturers.*, COUNT(groups.id) AS lect_count
		// 				FROM lecturers, groups
		// 				WHERE groups.lecturer_id = lecturers.id    
		// 			) AS lecturers
		// 			WHERE groups.semester_id = semesters.id
		// 			AND lecturers.id = groups.lecturer_id
		// 			AND corporations.id = groups.corporation_id
		// 			AND semesters.id = ?', [1]);
		// dd($results);

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
