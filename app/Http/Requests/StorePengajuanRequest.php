<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Semester;
use Auth;

class StorePengajuanRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$now = Semester::now();
		$user = Auth::user();
		$groups = $user->personable->groups->where('semester_id', $now->id);
		foreach ($groups as $group) {
			if ($group->status['status'] >= 0) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'corporation.name' => 'required',
			'corporation.address' => 'required',
			'corporation.post_code' => 'required',
			'corporation.business_type' => 'required',
			'corporation.description' => 'required',
			'corporation.city' => 'required',
			'group.start_date' => 'required|date|before:'
					. $this->request->get('group')['end_date'],
			'group.end_date' => 'required|date',
		];
	}

}
