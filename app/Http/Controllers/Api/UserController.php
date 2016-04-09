<?php namespace App\Http\Controllers\Api;

use Config;

use App\Models\DeviceSession;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\UserRegistrationRequest;
use App\Http\Requests\Api\UserLogoutRequest;
use App\Http\Requests\Api\UserForgotpasswordRequest ;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Passwordreset;
use App\Models\Api;
use App\Helpers\ResponseClass;
use Hash;
use Response;
use App\Models\UserDevice;
use Mail;
use URL;
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

    public function test(){
        return response()->json(DeviceSession::get()->user);
    }

    public function register(UserRegistrationRequest $userRegistrationRequest){

        $user = User::create([
            'name' => $this->request->get('name'),
            'email' => $this->request->get('email'),
            'username' => $this->request->get('username'),
            'phone_number' => $this->request->get('phone'),
            'password' => bcrypt($this->request->get('password'))
        ]);

        if($user){
            $device = UserDevice::add($user, $this->request->all());
            return ResponseClass::Prepare_Response($device,true,200);
        }

        return ResponseClass::Prepare_Response('','Unable to create user',"false",200);

    }

    public function login(UserLoginRequest $userLoginRequest){


        $field = filter_var($this->request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($field, $this->request->get('email'))->first();

        if(!$user){
            return ResponseClass::Prepare_Response('','Email/Password did not match',"false",200);
        }

        if (!Hash::check($this->request->get('password'), $user->password))
        {
            return ResponseClass::Prepare_Response('','Email/Password did not match',"false",200);
        }

        $device = UserDevice::add($user, $this->request->all());
        return ResponseClass::Prepare_Response($device,'Login successfully',true,200);
    }

    /*
    *   Function to logout from api
    */
    public function logout(UserLogoutRequest $UserLogoutRequest){

        UserDevice::remove($this->request->get('access_token'));
        return ResponseClass::Prepare_Response('','logged out successfully',false,200);
    }

    /*
    *   Function to recover password
    */
    public function forgotpassword(UserForgotpasswordRequest $UserForgotpasswordRequest){

        $user = User::where('email', $this->request->get('email'))->first();

        if(!$user){
            return ResponseClass::Prepare_Response('','Email did not match',"false",200);
        }

        $randomString = date('YmdHis').str_random(4);
        $isTokenExist = Passwordreset::where('email',$user->email)->first();
        if ($isTokenExist) {
            Passwordreset::where('email','=',$user->email)->update(array('token'=>$randomString));
        } else {
            Passwordreset::insert(array('token'=>$randomString,'email'=>$user->email));
        }

        $link = URL::to('forgotpassword').'/'.$randomString;

        Mail::send('emails.forgotpassword', ['user' => $user,'link'=>$link], function ($m) use ($user) {
            $m->from('admin@turnstr.com', 'Turnstr');

            $m->to($user->email, $user->username)->subject('Forgot Password');
        });

        return ResponseClass::Prepare_Response('','Email sent successfully',"true",200);
    }

}
