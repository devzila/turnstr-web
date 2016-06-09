@extends('layouts.app')
@section('content')
      <div class="w-section profile-header">
        <div class="w-container profile-header-content">
          <div class="w-row">
		  @if($userdetail->profile_image)
            <div class="w-col w-col-4 profile-image">
              <div class="profile-pic"><img src="{{$userdetail->profile_image}}" ></div>
            </div>
		  @endif
            <div class="w-col w-col-8 w-clearfix">
              <div class="profile-info">
                <h3 class="user-name">{{$userdetail->name}}</h3>
				@if($AuthUser != 1)
					<a class="w-button following" href="#">Following</a>
					<div class="profile_intro">{{$userdetail->bio}}</div>
                @else
					<div class="profile-subheading">{{$userdetail->username}}</div>
					<a href="/users/edit" class="w-button edit-profile">Edit Profile</a>
				@endif
				
                <div class="profile-stats">
                  <div class="profile-stat-item">
                    <h4 class="stat-posts-number">{{count($posts)}}</h4>
                    <div class="stat-label">Posts</div>
                  </div>
                  <div class="profile-stat-item">
                    <h4 class="stat-posts-number">{{$userdetail->followers}}</h4>
                    <div class="stat-label">followers</div>
                  </div>
                  <div class="profile-stat-item">
                    <h4 class="stat-posts-number">{{$userdetail->following}}</h4>
                    <div class="stat-label">following</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-section content">
        <div class="w-container">
		  <?php $i=0; ?>
		  @if(count($posts)!= 0)
			  @foreach($posts as $post)
				@if(!$post->media1_thumb_url)
				@continue;
				@endif
			  <?php ++$i;?>
				  @if($i%3 == 0 || $i==1)
					<div class="w-row profile-image-grid">
				  @endif
					<div class="w-col w-col-4">
					  <div class="profile-upload-items">
						<a href="<?php echo App\Helpers\UniversalClass::shareUrl($post->id) ?>"><img src="{{$post->media1_thumb_url}}"></a>
					  </div>
					</div>
				
				  @if($i%3 == 0)
					</div>
				  @endif
			  @endforeach
			  @if($i!=0 || $i%3!=0)
				  </div>			  
			  @endif
		  @endif
		  
        </div>
      </div>
	  
   
@endsection
