@extends('layouts.master')

@section('content')
	<div>
		<form method='post' action='{{ URL::route("updatePasword") }}'>
			<div>
				<label>New Password</label>
				<input type='password' placeholder="New Password" >
			</div>
			<div>
				<label>Confirm New Password</label>
				<input type='password' placeholder="Confirm New Password" >
			</div>
			<div>
				{!! csrf_field() !!}
				<input type='hidden' name='confirmationCode' value='{!! $shortcode !!}' >
				<input type='submit' value='change' >
			</div>
		</form>
	</div>
@endsection