<?php namespace App\Http\Controllers;

use App\Grade;
use App\Group;
use App\Lecturer;
use App\Mentor;
use App\Member;
use App\Student;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator as Pagination;
use Request;

class GroupController extends Controller {

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
			case 'TU':
				$groups = Group::get();
				break;
			default:
				return view('home');
				break;
		}
		$stat = null;
		$search = Request::input('search');
		if ($search != null && $search != '') {
			$groups =
				Group::whereHas('corporation', function($q) use ($search) {
					$q->where('name', 'like', '%'.$search.'%');
				})->orWhereHas('students', function($q) use ($search) {
					$q->where('name', 'like', '%'.$search.'%');
				})->orWhereHas('students', function($q) use ($search) {
					$q->where('nrp', 'like', '%'.$search.'%');
				});
			$groups = $groups->get();
		} else {
			$stat = Request::input('status');
			if ($stat != null && $stat != 'null') {
				$groups = $groups->where('status.status', (int)$stat);
			}
		}

		$lecturers = Lecturer::dosen()->get()->sortBy('initial');

		$total = $groups->count();
		$perPage = 10;
		$page = Request::input('page');
		$page == null ? 1 : $page;
		$option = ['path' => url('home')];

		$groups = new Pagination($groups, $total, $perPage, $page, $option);
		$data = compact('groups', 'lecturers', 'stat', 'search');
		return view('inside.kelompok', $data);
	}

	/**
	 * Get group by given group_id with grade.
	 *
	 * @param  int  $id
	 * @return string
	 */
	public function getGroupWithGrade($id) {
		$with = ['members.grade', 'members.student'];
		return Group::with($with)->find($id)->toJson();
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
		return $this->alert('info', 'Kelompok berhasil diperbarui. Silahkan refresh halaman.');
	}

	/**
	 * Update the grade via json.
	 *
	 * @return string
	 */
	public function updateGrade() {
		foreach (Request::input('input') as $input) {
			$lecturer_grade = (int)$input['lecturer_grade'];
			$lecturer_grade = $lecturer_grade < 0 ? 0 : (
				$lecturer_grade > 100 ? 100 : $lecturer_grade
			);

			$mentor_grade = (int)$input['mentor_grade'];
			$mentor_grade = $mentor_grade < 0 ? 0 : (
				$mentor_grade > 100 ? 100 : $mentor_grade
			);

			$discipline_grade = (int)$input['discipline_grade'];
			$discipline_grade = $discipline_grade < 0 ? 0 : (
				$discipline_grade > 100 ? 100 : $discipline_grade
			);

			$report_status = (int)$input['report_status'];
			$report_status = $report_status < 0 ? 0 : (
				$report_status > 100 ? 100 : $report_status
			);

			$fill = compact('lecturer_grade', 'mentor_grade', 'discipline_grade', 'report_status');

			$member = Member::find($input['id']);
			if ($member->grade == null) {
				$member->grade()->save(new Grade);
			}
			$grade = $member->grade;
			$grade->fill($fill);
			$grade->save();
		}
		return $this->alert('info', 'Nilai berhasil diperbarui.');
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

}
