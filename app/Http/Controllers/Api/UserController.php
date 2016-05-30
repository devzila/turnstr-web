<?php namespace App\Http\Controllers\Api;

use Config;

use App\Models\DeviceSession;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\UserRegistrationRequest;
use App\Http\Requests\Api\UserLogoutRequest;
use App\Http\Requests\Api\UserForgotpasswordRequest ;
use App\Http\Requests\Api\UserUpdateRequest ;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use App\Models\Passwordreset;
use App\Models\Useractivity;
use App\Models\Api;
use App\Helpers\ResponseClass;
use Rhumsaa\Uuid\Uuid;
use Hash;
use Response;
use App\Models\UserDevice;
use Mail;
use URL;
use Input;
use Validator;
use File;
use Image;
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
        ini_set("gd.jpeg_ignore_warning", 1);
        error_reporting(E_ALL & ~E_NOTICE);
    }

    public function test(){
        Mail::send('welcome',[], function($message)
        {
            $message->from('turnstr@devzila.com', 'Turnstr');
            $message->to('nilay@devzila.com');
            $message->subject('Test email from turnstr');
        });


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

            // Auto follow turnstr
            $autofollow = array(
                'user_id'=>50,
                'follower_id'=>$user->id,
                'activity'=>'follow',
                'status'=>1,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            );
            Useractivity::insert($autofollow);

            User::where('id',$user->id)->update(array('following'=>1));
            $device = UserDevice::add($user, $this->request->all());

            return ResponseClass::Prepare_Response($device,'User Registered Succeessfully',true,200);
        }

        return ResponseClass::Prepare_Response('','Unable to create user',false,200);

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
    *   Function to logout from api
    */
    public function logout(UserLogoutRequest $UserLogoutRequest){

        UserDevice::remove($this->request->get('access_token'));
        return ResponseClass::Prepare_Response('','logged out successfully',true,200);
    }

    /*
    *   Function to recover password
    */
    public function forgotpassword(UserForgotpasswordRequest $UserForgotpasswordRequest){

        $user = User::where('email', $this->request->get('email'))->first();

        if(!$user){
            return ResponseClass::Prepare_Response('','Email did not match',false,200);
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

        return ResponseClass::Prepare_Response($link,'Email sent successfully',true,200);
    }

    /*
    *   Function to return user profile data
    */
    public function myProfile(){

        $userId = DeviceSession::get()->user->id;

        if (!$userId) {
            return ResponseClass::Prepare_Response('','Unauthorized user access',false,200);
        }

        $postCount = Posts::where('user_id',$userId)->count();
        $usersData = User::where('id',$userId)->first();

        $usersData->postCount = (string)$postCount;
        if (isset($usersData->following)) {
            $usersData->following = (string)($usersData->following);
        }
        if (isset($usersData->followers)) {
            $usersData->followers = (string)($usersData->followers);
        }

        return ResponseClass::Prepare_Response(['userData'=>$usersData],'Users detail',true,200);
    }

    /*
    *   Function to to update user profile
    */
    public function updateProfile(UserUpdateRequest $UserUpdateRequest){

        $userData = Input::all();
        foreach ($userData as $key => $value) {
            $userData[$key] = ($userData[$key]) ? $value  : '' ;
        }
        $updatedArr = array(
            'name'=>$userData['name'],
            'email'=>$userData['email'],
            'username'=>$userData['username'],
            'phone_number'=>$userData['phone_number'],
            'gender'=>$userData['gender'],
            'bio'=>$userData['bio'],
            'website'=>$userData['website']
        );

        $userId = DeviceSession::get()->user->id;

        if (!$userId) {
            return ResponseClass::Prepare_Response('','Unauthorized user access',false,200);
        }

        $isDataExist = User::where(function ($query)  use ($updatedArr) {
            return $query->where('email',$updatedArr['email'])->orWhere('username',$updatedArr['username']);
        })->where('id','!=',$userId)->get();

        if (count($isDataExist)) {
            return ResponseClass::Prepare_Response('','Username/Email already exist',false,200);
        }

        User::where('id',$userId)->update($updatedArr);
        return ResponseClass::Prepare_Response('Profile updated successfully','Profile updated successfully',true,200);
    }
        

    public function profileImageUpload(Request $request)
    {
        $files = ['profile_image' => $request->file('profile_image')];
        $rules = ['profile_image' => 'required'];

        $validator = Validator::make($files, $rules);
        if ($validator->fails()) {
            return ResponseClass::Prepare_Response('','validation fails',false, 200);
        }

        $userId = DeviceSession::get()->user->id;
        $path = public_path() . '/profile/';
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }
        $destinationPath = $path.$userId; // upload path
        if(!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, $mode = 0777, true, true);
        }
        if(!File::exists($destinationPath.'/thumb')) {
            File::makeDirectory($destinationPath.'/thumb', $mode = 0777, true, true);
        }

            $extension = $request->file("profile_image")->getClientOriginalExtension();
            $fileName = Uuid::uuid1()->toString() . '.' . $extension;
            $request->file("profile_image")->move($destinationPath, $fileName);

            Image::make($destinationPath.'/'.$fileName)->resize(400, 400)->save($destinationPath.'/thumb/thumb_'.$fileName);
            // Image::make($destinationPath.'/'.$fileName)->resize(400, 400)->rotate(90)->save($destinationPath.'/thumb/thumb_'.$fileName);

            $pathToImage = URL::to('/') . '/profile/'.$userId.'/thumb/'. $fileName;
            $pathToThumbImage = URL::to('/') . '/profile/'.$userId.'/thumb/thumb_'. $fileName;
           User::where('id',$userId)->update(['profile_image'=>$pathToThumbImage,'profile_thumb_image'=>$pathToThumbImage]);

        return ResponseClass::Prepare_Response('','uploaded successfuly',true,200);
    }

    public function followersList(Request $request)
    {
        $data = array();
        $userId = DeviceSession::get()->user->id;
        $usersList = Useractivity::getFollowersByUserId($userId);

        foreach ($usersList as $k=>$row) {
            $postCount = Posts::where('user_id',$row->id)->count();
            $usersList[$k]->id = (string)($row->id);
            $usersList[$k]->post_count = (string)$postCount;
        }
//        $data['user']->is_following = 1;
        return ResponseClass::Prepare_Response($usersList,'followers list',true,200);
    }

}
