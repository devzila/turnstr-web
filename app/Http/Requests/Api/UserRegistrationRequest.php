<?php namespace App\Http\Requests\Api;

use App\Http\Requests\Request;
use App\Models\Api;
use App\Helpers\ResponseClass;

class UserRegistrationRequest extends Request {

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
			     'name'     		=> 'required',
            'email'         => 'required|email|unique:users,email',
            'username'      => 'required|min:4|unique:users,username',
            'password'      => 'required|between:6,15',
            'phone_number'  => 'sometimes|regex:/^\d{10,11}$/',
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
      $finalErrors = array();
        foreach ($errors as $key => $value) {
          $finalErrors[$key] = $value[0];
        }
        return ResponseClass::Prepare_Response(['action' => 'Check for errors in the data sent','errors'=>$finalErrors],'There were errors in the input sent. Please check your request and try again',false,422);
   //      return response()->json([
			// 'status' => Api::ERROR_CODE,
   //          'action' => 'Check for errors in the data sent',
   //          'message' => 'There were errors in the input sent. Please check your request and try again',
   //          'errors' => $errors
   //      ], 422);
    }

}
