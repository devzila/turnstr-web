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
use URL;
use Input;
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
