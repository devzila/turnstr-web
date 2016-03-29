<?php namespace App\Http\Controllers\Api;

use Config;

use App\Models\DeviceSession;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\UserRegistrationRequest;
use App\Http\Requests\Api\UserLogoutRequest;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Api;
use Hash;
use App\Models\UserDevice;
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
            'username' =>$this->request->get('username'),
            'phone' => $this->request->get('phone'),
            'password' => bcrypt($this->request->get('password'))
        ]);

        if($user){
            $device = UserDevice::add($user, $this->request->all());
            return response()->json($device, 200);
        }

        return response()->json(["status" => Api::ERROR_CODE, "message" => "Unable to create user"], 200);

    }

    public function login(UserLoginRequest $userLoginRequest){


        $field = filter_var($this->request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($field, $this->request->get('email'))->first();

        if(!$user){
            return response()->json(["status" => Api::ERROR_CODE, "message" => "Email/Password did not match"], 200);
        }

        if (!Hash::check($this->request->get('password'), $user->password))
        {
            return response()->json(["status" => Api::ERROR_CODE, "message" => "Email/Password did not match"], 200);
        }


        // credential is correct
        // create access token for device
        $device = UserDevice::add($user, $this->request->all());

        return response()->json($device, 200);
    }

    /*
    *   
    */
    public function logout(UserLogoutRequest $UserLogoutRequest){

        UserDevice::remove($this->request->get('access_token'));

        return response()->json(["status" => Api::SUCCESS_CODE, "message" => "logged out successfully"], 200);
    }

}
