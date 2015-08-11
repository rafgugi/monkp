<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePengajuanRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
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
