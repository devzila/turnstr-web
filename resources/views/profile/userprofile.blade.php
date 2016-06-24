@extends('layouts.app')
@section('content')
<div id="followings" class="modal small fade in">
    <div class="w-container modal-content-window">
      <h1 class="followers-heading pull-left">Followings</h1>
      <div>
	  <a class="close-button close close-button-link" data-dismiss="modal">x</a>
      </div>	  
	  @if($followings)
		<?php $i=1; ?>
      @foreach($followings as $fllowi)  
		 <div class="activity-list-item">
			<div class="userthumb">
				<a href="/userprofile/{{$fllowi->id}}">
					@if($fllowi->profile_image)
						<img class="img-circle" src="{{$fllowi->profile_image}}" />
					@elseif($fllowi->fb_token)
						<img src="{{ 'http://graph.facebook.com/'.$fllowi->fb_token.'/picture?type=normal'}}">
					@else
						<img class="img-circle" src="/assets/images/defaultprofile.png" />
					@endif
				</a>
			</div>
			<div class="activity-text">
			  <div><span class="activity-username">
				<a href="/userprofile/{{$fllowi->id}}">{{($fllowi->username)?$fllowi->username:$fllowi->name}}	</a>
			  </span>
			  </div>
			</div>
			@if($AuthUser == 1)
			<a href="#"  data-followid-{{'followbtn'.$i}}="{{$fllowi->id}}" data-status-{{'followbtn'.$i}}="0" id="followbtn{{$i}}" class="w-button follow-button followbttn" > Unfollow</a>
			@endif
			<?php $i++; ?>
		  </div>
		@endforeach
	  @else
      <div class="activity-list-item">
        <div class="userthumb"></div>
        <div class="activity-text">
          <div><span class="activity-username">You are not Following Anyone</span>
          </div>
        </div><a class="w-button follow-button" href="#"></a>
      </div>
		@endif        
    </div>   
</div>


<div id="followers" class="modal small fade in">
    <div class="w-container modal-content-window">
      <h1 class="followers-heading pull-left">Followers</h1>
      <div>
        <a class="close-button close close-button-link" data-dismiss="modal">x</a>
      </div>
	  @if($followers)
		@foreach($followers as $fllow)  
		  <div class="activity-list-item">
			<div class="userthumb">
				<a href="/userprofile/{{$fllow->id}}">
					@if($fllow->profile_image)
						<img class="img-circle" src="{{$fllow->profile_image}}" />
					@elseif($fllow->fb_token)
						<img src="{{ 'http://graph.facebook.com/'.$fllow->fb_token.'/picture?type=normal'}}">
					@else
						<img class="img-circle" src="/assets/images/defaultprofile.png" />
					@endif
				</a>
			</div>
			<div class="activity-text">
			  <div><span class="activity-username">
				<a href="/userprofile/{{$fllow->id}}">{{($fllow->username)?$fllow->username:$fllow->name}}	</a>
			  </span>
			  </div>
			</div>
			<a class="w-button follow-button hide" href="#"></a>
		  </div>
		  @endforeach
	  @else
      <div class="activity-list-item">
        <div class="userthumb"></div>
        <div class="activity-text">
          <div><span class="activity-username">No-one is Following</span>
          </div>
        </div><a class="w-button follow-button" href="#"></a>
      </div>
		@endif
    </div>
  </div>

      <div class="w-section profile-header">
        <div class="w-container profile-header-content">
          <div class="w-row">
		  
            <div class="w-col w-col-4 profile-image">
              <div class="profile-pic">
				@if($userdetail->profile_image)
					<img class="img-circle" src="{{$userdetail->profile_image}}" />
				@elseif($userdetail->fb_token)					
					<img src="{{ 'http://graph.facebook.com/'.$userdetail->fb_token.'/picture?type=large'}}">				
				@else
					<img class="img-circle" src="/assets/images/defaultprofile.png" />
				@endif
			  
			  </div>
            </div>
		  
            <div class="w-col w-col-8 w-clearfix">
              <div class="profile-info">
                <h3 class="user-name">{{$userdetail->name}}</h3>
				@if($AuthUser != 1)
					@if($AuthUser == 2)
						<a class="w-button following followbttn" id="followbtn" data-status-followbtn="{{ !$is_following }}" data-followId-followbtn="{{$userdetail->id}}" href="#">
							@if($is_following) Unfollow @else Follow @endif
						</a>
					@endif				
					@if($userdetail->username)
						<div class="profile-subheading">{{ '@'.$userdetail->username}}</div>
					@endif
					<div class="profile_intro">{{$userdetail->bio}}</div>
                @else
					@if($userdetail->username)
						<div class="profile-subheading">{{ '@'.$userdetail->username}}</div>
					@endif
					<div class="profile_intro">{{$userdetail->bio}}</div>
					<a href="/users/edit" class="w-button edit-profile">Edit Profile</a>
				@endif
				
                <div class="profile-stats">
                  <div class="profile-stat-item">
				  <a class="w-inline-block" href="#">
                    <h4 class="stat-posts-number">{{$postCount}}<!--@{{count($posts)}}--></h4>
                    <div class="stat-label">Posts</div>
				  </a>
                  </div>
                  <div class="profile-stat-item">
					<a class="w-inline-block" data-toggle="modal" href="#followers">
						<h4 class="stat-posts-number">{{$userdetail->followers}}</h4>
						<div class="stat-label">followers</div>
					</a>
                  </div>
                  <div class="profile-stat-item">
					<a class="w-inline-block" data-toggle="modal" href="#followings">
						<h4 class="stat-posts-number">{{$userdetail->following}}</h4>
						<div class="stat-label">following</div>
					</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-section content">
        <div class="w-container">
		<div ng-app='Turnstr' ng-controller="ProfileController">
                <div  infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='0'>
				<div class="w-row profile-image-grid explorer" >           
			        <div class="w-row "  >
				        <div class="w-col w-col-4 profile-image-grid " ng-repeat="post in reddit.items">
					        <div class="profile-upload-items">
						        <a href="@{{post.shareUrl}}"><img src="@{{post.media1_thumb_url}}"></a>
					        </div>
						</div>
					</div>
                </div>  
                </div>
                <div ng-show='reddit.busy'><img src="/assets/images/preloader.gif"></div>
          </div>		  
        </div>
      </div>
	  
   
@endsection
