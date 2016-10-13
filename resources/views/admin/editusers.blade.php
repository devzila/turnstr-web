@extends('layouts/admin')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <h1>Edit Users</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit User
                        </div>
                        <div class="panel-body">
						<form action="/admin/users/{{$user_details->id}}/update" method="post">
                            <div class="row">                                
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<label for='name'>Name</label>
									</div>
									<div class="col-lg-8">
										<input class="form-control" id="name" name="name" value="{{$user_details->name}}" >
									</div>
								</div>                                
                            </div>
                            <div class="row">                               
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<label for='username'>Username</label>
									</div>
									<div class="col-lg-8">
										<input class="form-control" id="username" name="username" value="{{$user_details->username}}" required>
									</div>
								</div>                                
                            </div>
							<div class="row">                               
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<label for='email'>Email</label>
									</div>
									<div class="col-lg-8">
										<input class="form-control" id="email" name="email" value="{{$user_details->email}}" required>
									</div>
								</div>                                
                            </div>
							<div class="row">                               
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<label for='gender'>Gender</label>
									</div>
									<div class="col-lg-8">
										<select name="gender" id="gender" class="form-control">
											<option value="">Select</option>
											<option value="Male" @if ($user_details->gender == "Male") Selected @endif > Male</option>
											<option value="Female" @if ($user_details->gender == "Female") Selected @endif>Female</option>
										</select>
									</div>
								</div>                                
                            </div>
							<div class="row">                               
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<label for='website'>Website</label>
									</div>
									<div class="col-lg-8">
										<textarea class="form-control" id="website" name="website" >{{$user_details->website}}</textarea>
									</div>
								</div>                                
                            </div>
							<div class="row">                               
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<label for='bio'>Bio</label>
									</div>
									<div class="col-lg-8">
										<textarea class="form-control" id="bio" name="bio" >{{$user_details->bio}}</textarea>
									</div>
								</div>                                
                            </div>
							<div class="row">                               
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<label for='phone_number'>Phone Number</label>
									</div>
									<div class="col-lg-8">
										<input  class="form-control" id="phone_number" name="phone_number" value="{{$user_details->phone_number}}">
									</div>
								</div>                                
                            </div>
                            <div class="row">                               
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<label for='is_verified'>Verified</label>
									</div>
									<div class="col-lg-8">
										<select name="is_verified" id="is_verified" class="form-control">
											<option value="1" @if ($user_details->is_verified == 1) Selected @endif >Verified</option>
											<option value="0" @if ($user_details->is_verified == 0) Selected @endif > Not Verified</option>
										</select>
									</div>
								</div>                                
                            </div>
							<div class="row">                               
								<div class="form-group col-lg-10">
									<div class="col-lg-2 text-align-right">
										<input  type="submit" class="form-control btn btn-block btn-primary"  name="submit" value="Update">
									</div>
								</div>                                
                            </div>
							{{ csrf_field() }}
							</form>
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection