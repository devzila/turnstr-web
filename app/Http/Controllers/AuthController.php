<?php namespace App\Http\Controllers;

use Config;

use App\Models\DeviceSession;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Passwordreset;
use App\Helpers\ResponseClass;
use Hash;
use Response;
use App\Models\UserDevice;
use Mail;
use URL,Redirect;
use Input;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
class AuthController extends Controller {
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
    
    public function index(){
    
            return view('auth.login')->withSuccess( 'Successfully logged in.' );
        
    }
    public function login(){
        
            
        $field = filter_var($this->request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($field, $this->request->get('email'))->first();
        
        if(!$user){
            $errors['email'] = "Email/Password did not match";
            $errors['password'] = "Email/Password did not match";
//            return ResponseClass::Prepare_Response('','Email/Password did not match',false,200);
            return Redirect::back()->withInput()->withErrors($errors);
        }

        if (!Hash::check($this->request->get('password'), $user->password))
        {
            $errors['email'] = "Email/Password did not match";
            $errors['password'] = "Email/Password did not match";
//            return ResponseClass::Prepare_Response('','Email/Password did not match',false,200);
            return Redirect::back()->withInput()->withErrors($errors);
        }
        Auth::loginUsingId($user->id, true);
        return view('WELCOME')->withSuccess( 'Successfully logged in.' );
//        $this->request['device_id']='122';
//        $this->request['os_type']='122';
//        $this->request['os_version']='122';
//        $this->request['hardware']='122';
//        $this->request['app_version']='122';
//        $device = UserDevice::add($user, $this->request->all());
//        $data = "";
//        //print_r($device);die;
//         return view('WELCOME')->withSuccess( 'Successfully logged in.' );
//         
//        return Redirect::intended('posts')->withSuccess( 'Successfully logged in.' );
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

}
