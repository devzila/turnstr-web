<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Contracts\Auth\PasswordBroker;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserForgotpasswordRequest ;
use App\Helpers\ResponseClass;
use \App\Models\User;
class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
	protected $redirectPath = '/';
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(PasswordBroker $passwords,Request $request)
    {
        $this->middleware('guest');
		$this->passwords = $passwords;
		$this->request = $request;
    }
	
	
	 public function postApiPassword(UserForgotpasswordRequest $UserForgotpasswordRequest){
		 
		$user = User::where('email', $this->request->get('email'))->first();

        if(!$user){
            return ResponseClass::Prepare_Response('','Email did not match',false,200);
        }
		 
		$response = $this->passwords->sendResetLink($this->request->only('email'), function ($m) {
			$m->subject($this->getEmailSubject());
		});

		switch ($response) {
			case PasswordBroker::RESET_LINK_SENT:
				return ResponseClass::Prepare_Response('','Email sent successfully',true,200);
				
			case PasswordBroker::INVALID_USER:
				return ResponseClass::Prepare_Response('','Email sent successfully',true,200);
		}
        
    }
	
	
}
