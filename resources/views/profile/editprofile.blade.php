@extends('layouts.app')
@section('content')
<div class="w-section content-wrapper">
    <div class="w-container edit-profile-wrapper">
      <div class="w-tabs" data-duration-in="300" data-duration-out="100">
        <div class="w-tab-menu v-tab-menu">
          <a class="w-tab-link w--current w-inline-block v-tab" data-w-tab="Tab 1">
            <div>Edit Profile</div>
          </a>
          <a class="w-tab-link w-inline-block v-tab" data-w-tab="Tab 2">
            <div>Change Password</div>
          </a>
        </div>
        <div class="w-tab-content v-tab-content">
          <div class="w-tab-pane w--tab-active" data-w-tab="Tab 1">
            <div class="edit-profile-info">
              <div class="w-row">
                <div class="w-col w-col-4 edit-profile-image">
                  <div class="profile-pic edit"></div>
                </div>
                <div class="w-col w-col-8">
                  <h3 class="user-name edit">Jim Baker</h3>
                </div>
              </div>
            </div>
            <div class="edit-profile-form">
              <div class="w-form">
                <form data-name="Email Form" id="email-form" name="email-form">
                  <label class="edit-profile-label" for="name">Name</label>
                  <input class="w-input edit-profile-field" data-name="Name" id="name" maxlength="256" name="name" placeholder="Enter your name" type="text" value="{{$user->name}}">
				  
                  <label class="edit-profile-label" for="username">Username</label>
                  <input class="w-input edit-profile-field" data-name="Username" id="username" maxlength="256" name="username" placeholder="Enter your username address" required="required" value="{{$user->username}}">
				  
                  <label class="edit-profile-label" for="website">Website</label>
                  <input class="w-input edit-profile-field" data-name="Website" id="website" maxlength="256" name="website" placeholder="Enter Website" required="required" value="{{$user->website}}">
				  
                  <label class="edit-profile-label" for="bio">Bio</label>
                  <textarea class="w-input edit-profile-field" id="bio" maxlength="5000" name="bio" placeholder="">{{$user->bio}}</textarea>
                  
				  <div class="edit-profile-heading-3">Private Information</div>
                  
				  <label class="edit-profile-label" for="email">Email</label>
                  <input class="w-input edit-profile-field" data-name="Email" id="email" maxlength="256" name="email" placeholder="Enter your email address" required="required" type="email" value="{{$user->email}}">
				  
                  <label class="edit-profile-label" for="phone_number">Phone Number</label>
                  <input class="w-input edit-profile-field" data-name="Email 4" id="phone_number" maxlength="256" name="phone_number" placeholder="Enter your Phone Number" required="required" type="number" value="{{$user->phone_number}}">
                  <label class="edit-profile-label" for="gender">Gender</label>
                  <select class="w-select edit-profile-select" id="gender" name="gender">
                    <option value="">Select</option>
                    <option value="Male" @if($user->gender == 'Male') {{ 'selected' }} @endif >Male</option>
                    <option value="Female" @if($user->gender == 'Female') {{ 'selected' }} @endif >Female</option>
                  </select>
                  <input class="w-button edit-profile-submit" data-wait="Please wait..." type="submit" value="Submit">
                </form>
                <!--<div class="w-form-done">
                  <p>Thank you! Your submission has been received!</p>
                </div>
                <div class="w-form-fail">
                  <p>Oops! Something went wrong while submitting the form</p>
                </div>-->
              </div>
            </div>
          </div>
          <div class="w-tab-pane " data-w-tab="Tab 2">
            <div class="w-row">
              <div class="w-col w-col-4 w-col-medium-6 w-col-small-4 w-col-tiny-6 edit-profile-image">
                <div class="profile-pic edit"></div>
              </div>
              <div class="w-col w-col-8 w-col-medium-6 w-col-small-8 w-col-tiny-6">
                <h3 class="user-name edit">Jim Baker</h3>
              </div>
            </div>
            <div class="w-form">
              <form data-name="Email Form" id="email-form" name="email-form">
                <label class="edit-profile-label" for="name-2">Old Password</label>
                <input class="w-input edit-profile-field" data-name="Name 2" id="name-2" maxlength="256" name="name-2" placeholder="Enter your name" type="text">
                <label class="edit-profile-label" for="email-5">New Password</label>
                <input class="w-input edit-profile-field" data-name="Email 5" id="email-5" maxlength="256" name="email-5" placeholder="Enter your email address" required="required" type="email">
                <label class="edit-profile-label" for="email-6">New Password again</label>
                <input class="w-input edit-profile-field" data-name="Email 6" id="email-6" maxlength="256" name="email-6" placeholder="Enter your email address" required="required" type="email">
                <input class="w-button edit-profile-submit" data-wait="Please wait..." type="submit" value="Change Password">
              </form>
              <div class="w-form-done">
                <p>Thank you! Your submission has been received!</p>
              </div>
              <div class="w-form-fail">
                <p>Oops! Something went wrong while submitting the form</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
 @endsection