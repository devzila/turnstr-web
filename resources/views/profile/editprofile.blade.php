@extends('layouts.app')
@section('content')

<div class="w-section content-wrapper">
    <div class="w-container edit-profile-wrapper">
      <div class="w-tabs" data-duration-in="300" data-duration-out="100">
        <div class="w-tab-menu v-tab-menu">
          <a class="w-tab-link @if(!(Input::get('cp'))) {{ 'w--current'}} @endif w-inline-block v-tab" data-w-tab="Tab 1">
            <div>Edit Profile</div>
          </a>
          <a class="w-tab-link w-inline-block v-tab @if((Input::get('cp'))) {{ 'w--current'}} @endif"  data-w-tab="Tab 2">
            <div>Change Password</div>
          </a>
        </div>
        <div class="w-tab-content v-tab-content text-left">
		
          <div class="w-tab-pane w--tab-active" data-w-tab="Tab 1">
            <div class="edit-profile-info">
              <div class="w-row">
                <div class="w-col w-col-4 edit-profile-image">
                  <div class="profile-pic edit"><img src="{{$user->profile_image}}"></div>
                </div>
                <div class="w-col w-col-8">
                  <h3 class="user-name edit">{{$user->name}}</h3>
                </div>
              </div>
            </div>
              @if(!(Input::get('cp')))
				  @if (Session::has('success'))
					  <div class="w-form-done" style="display:block;">
						<p>{{Session::get('success')}}</p>
					  </div>
				  @endif
				  @if (Session::has('error'))
					  <div class="w-form-fail" style="display:block;">
						<p>{{Session::get('error')}}</p>
					  </div>
				  @endif
			  @endif 
			  <div class="edit-profile-form">
              <div class="w-form">
                <form data-name="Edit Form" id="edit-form" name="edit-form" method="post" action="/users/update">
				  {!! csrf_field() !!}
                  <label class="edit-profile-label" for="name">Name</label>
                  <input class="w-input edit-profile-field" data-name="Name" id="name" maxlength="256" name="name" placeholder="Enter your name" type="text" value="{{$user->name}}">
				  
                  <label class="edit-profile-label" for="username">Username</label>
                  <input class="w-input edit-profile-field" data-name="Username" id="username" maxlength="256" name="username" placeholder="Enter your username address" required="required"  value="{{$user->username}}">
				  
                  <label class="edit-profile-label" for="website">Website</label>
                  <input class="w-input edit-profile-field" data-name="Website" id="website" maxlength="256" name="website" placeholder="Enter Website" value="{{$user->website}}">
				  
                  <label class="edit-profile-label" for="bio">Bio</label>
                  <textarea class="w-input edit-profile-field" id="bio" maxlength="5000" name="bio" placeholder="">{{$user->bio}}</textarea>
                  
				  <div class="edit-profile-heading-3">Private Information</div>
                  
				  <label class="edit-profile-label" for="email">Email</label>
                  <input class="w-input edit-profile-field" data-name="Email" id="email" maxlength="256" name="email" placeholder="Enter your email address" required="required"  type="email" value="{{$user->email}}">
				  
                  <label class="edit-profile-label" for="phone_number">Phone Number</label>
                  <input class="w-input edit-profile-field" data-name="Email 4" id="phone_number" maxlength="256" name="phone_number" placeholder="Enter your Phone Number" type="number" value="{{$user->phone_number}}">
                  <label class="edit-profile-label" for="gender">Gender</label>
                  <select class="w-select edit-profile-select" id="gender" name="gender">
                    <option value="">Select</option>
                    <option value="Male" @if($user->gender == 'Male') {{ 'selected' }} @endif >Male</option>
                    <option value="Female" @if($user->gender == 'Female') {{ 'selected' }} @endif >Female</option>
                  </select>
                  <input class="w-button edit-profile-submit" data-wait="Please wait..." type="submit" value="Submit">
                </form>                
              </div>
            </div>
          </div>
          <div class="w-tab-pane" data-w-tab="Tab 2">
			
            <div class="w-row">
              <div class="w-col w-col-4 w-col-medium-6 w-col-small-4 w-col-tiny-6 edit-profile-image">
                <div class="profile-pic edit"><img src="{{$user->profile_image}}"></div>
              </div>
              <div class="w-col w-col-8 w-col-medium-6 w-col-small-8 w-col-tiny-6">
                <h3 class="user-name edit">{{$user->name}}</h3>
              </div>
            </div>
			<div class="w-form">
			  @if((Input::get('cp')))
				  @if (Session::has('success'))
					  <div class="w-form-done" style="display:block;">
						<p>{{Session::get('success')}}</p>
					  </div>
				  @endif
				  @if (Session::has('error'))
					  <div class="w-form-fail" style="display:block;">
						<p>{{Session::get('error')}}</p>
					  </div>
				  @endif
			  @endif            
              <form data-name="Password Form" id="password-form" name="password-form" action="/users/changepassword" method="post">
                {!! csrf_field() !!}
				<label class="edit-profile-label" for="oldpassword">Old Password</label>
                <input class="w-input edit-profile-field" data-name="oldpassword" id="oldpassword" maxlength="50" name="oldpassword" placeholder="Enter your Old Password" type="password" required="required">
                <label class="edit-profile-label" for="password">New Password</label>
                <input class="w-input edit-profile-field" data-name="password" id="password" maxlength="50" name="password" placeholder="Enter new password" required="required" type="password">
                <label class="edit-profile-label" for="cpassword">Confirm Password</label>
                <input class="w-input edit-profile-field" data-name="cpassword" id="cpassword" maxlength="50" name="cpassword" placeholder="Confirm Password" required="required" type="password">
                <input class="w-button edit-profile-submit" data-wait="Please wait..." type="submit" onclick="return passwordValidate();" value="Change Password">
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('additional_js')
	<script>
	function passwordValidate(){
		if($("#password").val().length  < 4){
			alert("New Password must be at least of 4 digits");
			return false;
		}
		if($("#password").val() != $("#cpassword").val()){
			alert("New Password and Confirm Password Do not Match");
			return false;
		}
		
		return true;
	}
	</script>
@endsection
