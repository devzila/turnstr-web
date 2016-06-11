<?php namespace App\Http\Controllers;

use Config;

use App\Models\DeviceSession;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use App\Models\Passwordreset;
use App\Helpers\ResponseClass;
use App\Models\Useractivity;
use Hash;
use Response;
use App\Models\UserDevice;
use Mail;
use URL;
use Input;
use Auth;
use Session;
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
		$authUser = Auth::user()->id;
		if(empty($userId) || $userId == $authUser){
			$userId = $authUser;
			$data['AuthUser'] = 1;
		}
				
		$followingDetails = Useractivity::getFollowDetailByUserId($userId,$authUser);
		$data['is_following'] = (count($followingDetails) && isset($followingDetails->status)) ? (int)($followingDetails->status) : 0 ;
		
		$data['userdetail'] =  User::find($userId);
		$data['posts'] = Posts::GetAllPostsByUserId($userId);
		
		return view('profile.userprofile',$data);
		
	}
	
	public function edit(){
		$userId = Auth::user()->id;
		$data['user'] =  User::find($userId);
		return view('profile.editprofile',$data);
		
	}
	
	public function updateProfile(){
		
		$user_id = Auth::user()->id;
		$user = User::find($user_id);
		$userData = Input::all();
		
		$updatedArr = array(
            'name'=>$userData['name'],
            'email'=>$userData['email'],
            'username'=>$userData['username'],
            'phone_number'=>$userData['phone_number'],
            'gender'=>$userData['gender'],
            'bio'=>$userData['bio'],
            'website'=>$userData['website']
        );
		
		if(empty($updatedArr['email'])){
			Session::flash('error','The Email Field is Required');
			return redirect("users/edit");
		}
		if(!filter_var($updatedArr['email'], FILTER_VALIDATE_EMAIL)){
			Session::flash('error','Enter Email Address in Email Field');
			return redirect("users/edit");
		}
		
		if(empty($updatedArr['username'])){
			Session::flash('error','The Username Field is Required');
			return redirect("users/edit");
		}		
		
		$isEmailExist = User::where(function ($query)  use ($updatedArr) {
            return $query->where('email',$updatedArr['email']);
        })->where('id','!=',$user_id)->get();
		
		$isUsernameExist = User::where(function ($query)  use ($updatedArr) {
            return $query->where('username',$updatedArr['username']);
        })->where('id','!=',$user_id)->get();
		
		if (count($isEmailExist)) {
            Session::flash('error','The Email already Exits');
			return redirect("users/edit");
        }
		
		if (count($isUsernameExist)) {
            Session::flash('error','The Username already Exits');
			return redirect("users/edit");
        }
		
		User::where('id',$user_id)->update($updatedArr);
		
		Session::flash('success','Your Profile Updated Successfully');
		return redirect("users/edit");
	}
	
	public function changePasword(){
		
		$cp = 2;
		$userId = Auth::user()->id;
		
		$oldpassword = $this->request->input('oldpassword');
		$password = $this->request->input('password');
		$cpassword = $this->request->input('cpassword');
		if(empty($oldpassword) || empty($password) || empty($cpassword)){
			Session::flash('error','All Fields are Required.');
			return redirect("users/edit?cp=2");
		}
		if($password != $cpassword){
			Session::flash('error','Confirm Password do not Match with New Password');
			return redirect("users/edit?cp=2");
		}
		
		if(strlen($password)<4){
			Session::flash('error','New Password must be at least 4 Digits.');
			return redirect("users/edit?cp=2");
		}
		
		$userDetails = User::find($userId);
		
		if (!Hash::check($oldpassword, $userDetails->password))
        {
			Session::flash('error','Please enter correct old Password');
			return redirect("users/edit?cp=2");		
		}
		
		
		
		$hashedPassword = Hash::make($password);
        User::where('id',$userDetails->id)->update(array('password'=>$hashedPassword));
		Session::flash('success','Your Password is successfully Changed.');
		return redirect("users/edit?cp=2");
    }
	
	
}
