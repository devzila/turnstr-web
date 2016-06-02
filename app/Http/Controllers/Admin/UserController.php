<?php namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Http\Request;
use Redirect;
use Session;
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
        $this->assertAdmin();
    }

    public function index(){

        $data = array();
        $data['all_users'] = User::get();
        return view('admin/listUsers',$data);

    }

    public function edit($user_id){

        $data = array();
        $data['user_details'] = User::find($user_id);
        return view("admin/editusers",$data);

    }

    public function destroy($user_id){

        $user = User::find($user_id);
        $user->delete();
        Session::flash('success','User Deleted Successfully');
        return redirect("admin/users");

    }
	
	public function update($user_id){
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
		
		if(empty($updatedArr['email']) || empty($updatedArr['username'])){
			Session::flash('error','The Email/Username Field is Required');
			return redirect("admin/users");
		}
		
		$isEmailExist = User::where(function ($query)  use ($updatedArr) {
            return $query->where('email',$updatedArr['email']);
        })->where('id','!=',$user_id)->get();
		
		$isUsernameExist = User::where(function ($query)  use ($updatedArr) {
            return $query->where('username',$updatedArr['username']);
        })->where('id','!=',$user_id)->get();
		
		if (count($isEmailExist)) {
            Session::flash('error','The Email already Exits');
			return redirect("admin/users");
        }
		
		if (count($isUsernameExist)) {
            Session::flash('error','The Username already Exits');
			return redirect("admin/users");
        }
		
		User::where('id',$user_id)->update($updatedArr);
		
		Session::flash('success','User Updated Successfully');
		return redirect("admin/users");
		
	}
	
}
