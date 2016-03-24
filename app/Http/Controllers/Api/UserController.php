<?php namespace App\Http\Controllers\Api;

use Config;

use App\Models\DeviceSession;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\UserRegistrationRequest;
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

    }

    public function login(UserLoginRequest $userLoginRequest){

        $user = User::where('email', $this->request->get('email'))
            ->first();

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

}
