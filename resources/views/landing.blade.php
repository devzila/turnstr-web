@extends('layouts.app')

@section('content')
<div class="w-container content">
    <div class="w-clearfix postblock">
        <div class="postimage"><img src="{{URL::asset('assets/images/postImg.png')}}">
        </div>
        <div class="photocaption">This is some text inside of a div block.</div>
        <div class="tag"># Nature</div>
        <div class="options"><img src="{{URL::asset('assets/images/options.png')}}">
        </div>
        <div class="w-clearfix userinfo">
            <div class="userthumb"><img src="{{URL::asset('assets/images/user.png')}}">
            </div><a href="#" class="w-button followbtn">follow</a>
            <div class="usercommentsblock">
                <div class="username">Kevin Smith</div>
            </div>
        </div>
        <div class="w-clearfix userinfo">
            <div class="userthumb"><img src="{{URL::asset('assets/images/user.png')}}">
            </div>
            <div class="usercommentsblock">
                <div class="username">Kevin Smith</div>
                <div class="usercomment">Awesome photography, keep it up!!</div>
            </div>
            <div class="postedtime">3h</div>
        </div>
        <div class="w-clearfix userinfo">
            <div class="userthumb"><img src="{{URL::asset('assets/images/user.png')}}">
            </div>
            <div class="usercommentsblock">
                <div class="username">Kevin Smith</div>
                <div class="usercomment">Awesome photography, keep it up!!</div>
            </div>
            <div class="postedtime">3h</div>
        </div>
    </div>
</div>
@endsection