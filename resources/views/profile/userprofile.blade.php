@extends('layouts.app')
@section('content')
	<div class="body-wrapper">
	<div class="content-wrapper">
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
					<div class="profile_intro">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</div>
                @else
					<div class="profile-subheading">@JimBaker</div>
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
	  </div>
    </div>
   
@endsection
@section('additional_js')
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic","Raleway:200,300,regular,500,600,700,800,900"]
      }
    });
  </script>
 @endsection