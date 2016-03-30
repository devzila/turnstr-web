<?php namespace App\Http\Requests\Api;

use App\Http\Requests\Request;
use App\Models\Api;

class UserLogoutRequest extends Request {

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
            'access_token' => 'required'
		];
	}

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return response()->json([
			'status' => Api::ERROR_CODE,
            'action' => 'Check for errors in the data sent',
            'message' => 'There were errors in the input sent. Please check your request and try again',
            'errors' => $errors
        ], 422);
    }

}
