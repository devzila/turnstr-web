<?php namespace App\Http\Requests\Api;

use App\Http\Requests\Request;
use App\Models\Api;

class UserLoginRequest extends Request {

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
			'email'         => 'required',
            'password'      => 'required|between:6,15',
            'device_id'     => 'required',
            'os_type'       => 'required|in:iOS,Android',
            'os_version'    => 'required',
            'hardware'      => 'required',
            'app_version'   => 'required'
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
		// TODO: add error details in response
   //      return response()->json([
			// 'status' => Api::ERROR_CODE,
   //          'action' => 'Check for errors in the data sent',
   //          'message' => 'There were errors in the input sent. Please check your request and try again'
   //      ], 422);
    	$finalErrors = array();
        foreach ($errors as $key => $value) {
          $finalErrors[$key] = $value[0];
        }
        return ResponseClass::Prepare_Response('',$finalErrors,false,422);
    }

}
