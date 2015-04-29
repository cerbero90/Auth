<?php namespace Cerbero\Auth\Http\Requests;

use Cerbero\Auth\Http\Requests\Request;

class RecoverRequest extends Request {

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
		return config('_auth.recover.rules');
	}

}
