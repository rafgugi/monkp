<?php namespace App\Http\Controllers;

use App\Corporation;
use App\Grade;
use App\Group;
use App\Lecturer;
use App\Member;
use App\Semester;
use DB;
use Excel;
use Illuminate\Pagination\LengthAwarePaginator as Pagination;
use Illuminate\Support\Collection;
use Request;

class AdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getPeriode()
	{
		return view('inside.periode');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postPeriode()
	{
		$request = Request::only(['year', 'odd', 'start_date', 'end_date', 'user_due_date']);
		if ($request['year'] < 2000
				|| $request['end_date'] == '' 
				|| $request['user_due_date'] == ''
				|| $request['start_date'] == '' 
		) {
			return redirect()->back()->withInputs($request)
				->with('alert', ['alert' => 'warning', 'body' => 'Lengkapi. Yang benar.']);
		}
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
	public function stats($semester_id = null) {
		$all = false;
		if (($req = Request::input('semester')) != null) {
			return redirect('stats/' . $req);
		} else if ($semester_id == null || Semester::find($semester_id) == null) {
			$all = true;
		} else {
			$all = false;
		}

		$where = $all ? '' : "WHERE groups.semester_id = $semester_id";

		$groups = $all ? Group::get() : Group::where('semester_id', $semester_id)->get();
		$lects = new Collection(DB::select(
				"SELECT * FROM (
					SELECT lecturers.*, COUNT(groups.id) AS lect_count
					FROM lecturers 
					LEFT JOIN (
						SELECT *
						FROM groups
						$where
					) AS groups ON groups.lecturer_id = lecturers.id
					WHERE nip != 0
					GROUP BY 1) as lecturers
				ORDER BY lect_count DESC, initial"));
		$corps = new Collection(DB::select(
				"SELECT * FROM (
					SELECT corporations.*, COUNT(groups.id) AS corp_count
					FROM corporations 
					LEFT JOIN (
						SELECT *
						FROM groups
						$where
					) AS groups ON groups.corporation_id = corporations.id
					GROUP BY 1) as corporations
				ORDER BY corp_count DESC"));
		
		$data = compact('groups', 'corps', 'lects', 'all', 'semester_id');
		return view('inside.statistic', $data);
	}

	/**
	 * Display groups listing in table.
	 *
	 * @return Response
	 */
	public function table($semester_id = null) {
		$all = false;
		if (($req = Request::input('semester')) != null) {
			return redirect('table/' . $req);
		} else if ($semester_id == null || Semester::find($semester_id) == null) {
			$all = true;
		} else {
			$all = false;
		}

		$members = $all ? Member::get() : Member::whereHas('group',
			function ($q) use($semester_id) {
				$q->where('semester_id', $semester_id);
			}
		)->get();

		$total = $members->count();
		$perPage = 15;
		$page = Request::input('page');
		$page == null ? 1 : $page;
		$option = ['path' => url('table')];

		$members = new Pagination($members, $total, $perPage, $page, $option);

		$data = compact('members', 'semester_id', 'all');
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
	public function export($semester_id = null) {
		$all = false;
		if ($semester_id == null) {
			$all = true;
		} else if (Semester::find($semester_id) == null) {
			$all = true;
		}
		$membera = $all ? Member::get() : Member::whereHas('group',
			function ($q) use($semester_id) {
				$q->where('semester_id', $semester_id);
			}
		)->get();

		$excel = Excel::create('export');
		$excel->setTitle('Export List Kelompok KP')
			  ->setCreator('Teknik Informatika')
			  ->setCompany('Teknik Informatika');

		$members = [];
		foreach ($membera as $member) {
			$q['Nama'] = $member->student->name;
			$q['NRP'] = $member->student->nrp;
			$q['Kelompok (Status)'] = $member->group->id . ' (' . $member->group->status['name'] . ')';
			$q['Semester'] = $member->group->semester->toString();
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
