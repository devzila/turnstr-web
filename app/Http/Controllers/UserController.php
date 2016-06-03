<?php namespace App\Http\Controllers;

use Config;

use App\Models\DeviceSession;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use App\Models\Passwordreset;
use App\Helpers\ResponseClass;
use Hash;
use Response;
use App\Models\UserDevice;
use Mail;
use URL;
use Input;
use Auth;
class UserController extends Controller {
    /**
     * The Http Request Object
     *
     * @var Object
     */
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
        public function login(UserLoginRequest $userLoginRequest){


        $field = filter_var($this->request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($field, $this->request->get('email'))->first();

        if(!$user){
            return ResponseClass::Prepare_Response('','Email/Password did not match',false,200);
        }

        if (!Hash::check($this->request->get('password'), $user->password))
        {
            return ResponseClass::Prepare_Response('','Email/Password did not match',false,200);
        }

        $device = UserDevice::add($user, $this->request->all());
        return ResponseClass::Prepare_Response($device,'Login successfully',true,200);
        }


    /*
    *   Function to reset password
    */
    public function resetpassword($shortcode = ''){

        $errorMessage = "Link you are trying to access is no more valid.";
        if(!$shortcode){
            return view('errorView',compact('errorMessage'));
            // return ResponseClass::Prepare_Response('','Invalid link',"false",200);
        }
        $userEmail = Passwordreset::where('token',$shortcode)->first();
        if(!$userEmail){
            return view('errorView',compact('errorMessage'));
            // return ResponseClass::Prepare_Response('','Invalid link',"false",200);
        }
        // Passwordreset::where('token',$shortcode)->delete();
        $user = User::where('email',$userEmail->email)->first();

        $randomString = str_random(7);
        // User::where('email',$userEmail->email)->update(array('forgot_password_token'=>'','password'=>$randomString));

        // Mail::send('emails.updatedPassword', ['user' => $user,'password'=>$randomString], function ($m) use ($user) {
        //     $m->from('admin@turnstr.com', 'Turnstr');

        //     $m->to($user->email, $user->username)->subject('New password');
        // });

        // return ResponseClass::Prepare_Response('','Password updated successfully',true,200);
        return view('forgotpassword',compact('user','shortcode'));
    }

    /*
    *   Function to update password
    */
    public function updatePasword(){

        $shortcode = Input::get('confirmationCode');
        $errorMessage = 'Unable to update your password due to invalid link.';
        if(!$shortcode){
            return view('errorView',compact('errorMessage'));
        }
        $userEmail = Passwordreset::where('token',$shortcode)->first();
        if(!$userEmail){
            return view('errorView',compact('errorMessage'));
        }
        // Passwordreset::where('token',$shortcode)->delete();
        $hashedPassword = Hash::make(Input::get('password'));
        User::where('email',$userEmail->email)->update(array('password'=>$hashedPassword));
        return view('successView');
    }
	
	public function userProfile($userId = ""){
		$data = array();
		$data['AuthUser'] =0;
		
		if(empty($userId) || $userId == Auth::user()->id){
			$userId = Auth::user()->id;
			$data['AuthUser'] = 1;
		}
		
		$data['userdetail'] =  User::find($userId);
		$data['posts'] = Posts::GetAllPostsByUserId($userId);
		
		return view('profile.userprofile',$data);
		
	}
	
	public function edit(){
		$userId = Auth::user()->id;
		$data['user'] =  User::find($userId);
		return view('profile.editprofile',$data);
		
	}
	
}
