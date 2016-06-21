<?php

namespace App\Http\Controllers\Auth;

use \App\Models\User;
use \App\Models\Useractivity;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Input;
use Redirect;
use Auth;
use Socialite;
use Illuminate\Http\Request;
use Exception;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
			'username' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }


    public function login(Request $request)
    {
        $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('email')]);

        if (Auth::attempt($request->only($field, 'password')))
        {
            return redirect('/');
        }

        return redirect('/login')->withErrors([
            'error' => 'These credentials do not match our records.',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
		$this->autoFollowCreatedUser($user);
		
		return $user;
    }
	
	public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
	
	public function handleProviderCallback()
    {
        try {
			
            $user = Socialite::driver('facebook')->user();	
			
		} catch (Exception $e) {			
		
            return redirect('/auth/facebook');
			
        }
		if(isset($user->email) && filter_var(($user->email), FILTER_VALIDATE_EMAIL)){
			$authUser = User::where('email', $user->email)->first();			
		}else{
			return Socialite::driver('facebook')->with(['auth_type' => 'rerequest'])->redirect();
		}
        if(!$authUser){
			$authUser = User::create([
				'name' => $user->name,
				'email' => $user->email,
				'fb_token' => $user->id,
				//'gender' => ($user->gender == 'male')?'Male':'Female',
				//'profile_image' => $user->avatar
			]);
			$this->autoFollowCreatedUser($authUser);
		}else{
			User::where('id',$authUser->id)->update(array('fb_token'=>$user->id));
		}
		
		
		
        Auth::login($authUser, true);
		return view("generic.close");
        //return redirect()->route('/');
    }
	
	private function autoFollowCreatedUser($user)
    {
		if($user){
            // Auto follow turnstr
            $autofollow = array(
                'user_id' => env('TURNSTR_USER_ID', 2),
                'follower_id' => $user->id,
                'activity' => 'follow',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            Useractivity::insert($autofollow);

            User::where('id',$user->id)->update(array('following'=>1));                       
        } 
        return ;
    }

}
