<?php namespace App\Http\Requests\Api;

use App\Http\Requests\Request;
use App\Models\Api;
use App\Helpers\ResponseClass;

class UserForgotpasswordRequest extends Request {

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
			'email'  => 'required|email'
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
        return ResponseClass::Prepare_Response(['message'=> "There were errors in the input sent. Please check your request and try again",'action' => 'Check for errors in the data sent','errors'=>$finalErrors],"false",422);
    }

}
