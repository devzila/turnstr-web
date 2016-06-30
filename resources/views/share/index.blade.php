@extends('layouts.app')

@section('metadata')
	<meta property="og:title" content="{{$post->caption}}" />
	<meta property="og:description" content="{{$post->caption}}" />
	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ Request::fullUrl() }}" />
	<meta property="og:site_name" content="{{$post->caption}}" />	
	<meta property="og:image" content="{{$post->media1_thumb_url}}" />
	<meta name="author" content="{{$userdetail->name}}" />
	<meta property="twitter:domain" content="http://stage.turnstr.net" />
	<meta property="twitter:site" content="http://stage.turnstr.net" />
	<meta property="twitter:title" content="{{$post->caption}}" />
	<meta property="twitter:description" content="{{$post->caption}}" />
	<meta property="twitter:creator" content="http://stage.turnstr.net" />
	<meta property="twitter:card" content="summary_large_image" />
	<meta property="twitter:image" content="{{$post->media1_thumb_url}}" />
@endsection

@section('modalBody')
<div class="post-modal">
    <div class="w-container modal-contentn">
      <div class="modal-window">
        <h1 class="share-modal-heading">Share Post</h1>
        <div class="share-platforms">
          <ul class="w-list-unstyled">
            <li class="share-platform-list">
				<a class="icon-facebook" onclick="return share_social(this.href);" href="https://www.facebook.com/sharer/sharer.php?u={{ Request::fullUrl()}}&title={{$post->caption}}"><img src="/assets/images/facebook.png" width="120"></a>			
            </li>
            <li class="share-platform-list">
				<a class="icon-twitter" onclick="return share_social(this.href);" href="http://twitter.com/share?url={{ Request::fullUrl()}}&title={{$post->caption}}"><img src="/assets/images/twitter@2x.png" width="120"></a>			
            </li>
            <li class="share-platform-list">
			<a href="http://tumblr.com/widgets/share/tool?canonicalUrl={{ Request::fullUrl()}}" onclick="return share_social(this.href);"><img src="/assets/images/tumblr@2x.png" width="120"></a>
			<!--<script>!function(d,s,id){var js,ajs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://secure.assets.tumblr.com/share-button.js";ajs.parentNode.insertBefore(js,ajs);}}(document, "script", "tumblr-js");</script>-->
			
            </li>
            <!--<li class="share-platform-list"><img src="/assets/images/flickr@2x.png" width="120">
            </li>-->
            <li class="share-platform-list">
				<a  href="mailto:?to=&amp;body={{ Request::fullUrl()}}&subject={{$post->caption}}"><img src="/assets/images/email@2x.png" width="120"></a>			
            </li>
            <li class="share-platform-list"><img src="/assets/images/foursquare@2x.png" width="120">
            </li>
          </ul>
        </div>
        <a class="w-inline-block close-modal" data-ix="dissapear-modal" href="#">
          <div>Close</div>
        </a>
      </div>
    </div>
  </div>
@endsection
@section('content')


<style type="text/css">
    .plyr .plyr__play-large{
            z-index: 9999999 !important;
            position: absolute !important;
    }
    .plyr audio, .plyr video {
        width: 100%;
        min-height: 400px;
        vertical-align: middle;
        border-radius: inherit;
    }
    
.container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
    overflow: hidden;
}

.jR3DCarouselGallery,.jR3DCarouselGallery1 {
    margin: 0 auto; /* optional - if want to center align */
}

.container {
    text-align: center;
}

.wrapper {
    padding-right: 10px;
    padding-left: 10px;
    width: 48%;
    height: 299px;
    float: left;
    overflow: auto;
    border-left: 1px solid #999;
}

.wrapper div {
    margin: 8px auto;
}
</style>


<div hidden="" id="sprite-plyr"><!--?xml version="1.0" encoding="UTF-8"?-->
    <svg xmlns="http://www.w3.org/2000/svg">
        <symbol viewBox="0 0 18 18" id="plyr-play">
            <path d="M15.562 8.1L3.87.225C3.052-.337 2 .225 2 1.125v15.75c0 .9 1.052 1.462 1.87.9L15.563 9.9c.584-.45.584-1.35 0-1.8z"/>
        </symbol>
    </svg>
</div>
    <div class="row">

        <div class="col-md-3"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="postblock">
                <div class="postimage">
                    <div class="jR3DCarouselGallery" style="margin:auto;">
                        <div class='slide'>
                            @if (isset($post->media1_type) && ($post->media1_type=='video'))
                                <div class="js-media-player">
                                    <video poster="{{$post->media1_thumb_url}}" controls crossorigin>
                                        <!-- Video files -->
                                        <source src="{{$post->media1_url}}" type="video/mp4">

                                        <!-- Fallback for browsers that don't support the <video> element -->
                                        <a href="{{$post->media1_url}}">Download</a>
                                    </video>
                                </div>
                            @else
                                <img src="<?php echo $post->media1_thumb_url;?>" />
                            @endif
                        </div>
                        <div class='slide'>
                            @if (isset($post->media2_type) && ($post->media2_type=='video'))
                                <div class="js-media-player">
                                    <video poster="{{$post->media2_thumb_url}}" controls crossorigin>
                                        <!-- Video files -->
                                        <source src="{{$post->media2_url}}" type="video/mp4">

                                        <!-- Fallback for browsers that don't support the <video> element -->
                                        <a href="{{$post->media2_url}}">Download</a>
                                    </video>
                                </div>
                            @else
                                <img src="<?php echo $post->media2_thumb_url;?>" />
                            @endif
                        </div>
                        <div class='slide'>
                            @if (isset($post->media3_type) && ($post->media3_type=='video'))
                                <div class="js-media-player">
                                    <video poster="{{$post->media3_thumb_url}}" controls crossorigin>
                                        <!-- Video files -->
                                        <source src="{{$post->media3_url}}" type="video/mp4">

                                        <!-- Fallback for browsers that don't support the <video> element -->
                                        <a href="{{$post->media3_url}}">Download</a>
                                    </video>
                                </div>
                            @else
                                <img src="<?php echo $post->media3_thumb_url;?>" />
                            @endif
                        </div>
                        <div class='slide'>
                            @if (isset($post->media4_type) && ($post->media4_type=='video'))
                                <div class="js-media-player">
                                    <video poster="{{$post->media4_thumb_url}}" controls crossorigin>
                                        <!-- Video files -->
                                        <source src="{{$post->media4_url}}" type="video/mp4">

                                        <!-- Fallback for browsers that don't support the <video> element -->
                                        <a href="{{$post->media4_url}}">Download</a>
                                    </video>
                                </div>
                            @else
                                <img src="<?php echo $post->media4_thumb_url;?>" />
                            @endif
                        </div>

                    </div>
					
                </div>
				<div class="post-stats">
					<div class="post-stats-label">Comments</div>
					<div class="post-stats-data" id="total_comments">{{$total_comments}}</div>
					<div class="post-stats-label">Likes</div>
					<div class="post-stats-data" id="total_likes">{{$total_likes}}</div>
					
					<div class="post-stats-label">
					@if(isset(Auth::user()->id))
						<a class="" id="likebtn" data-like-status="{{ !$liked }}" data-postId="{{$post->id}}"  href="#">
							<img src="/assets/images/liked.png" id="likeImg" class="likedImg @if($liked) show @else hide @endif" width="23" height="20">
							<img src="/assets/images/unliked.png" id="unlikeImg" class="likedImg @if($liked) hide @else show @endif">
						</a>
					@endif
					</div>
				</div>
				<div class="w-clearfix post-content">
					@if($post->caption)
						<div class="photocaption"><?php echo  App\Helpers\UniversalClass::replaceTagMentionLink($post->caption) ?></div>
					@endif
					
					<div class="dropdown-control">
					  <div>
						<a class="w-inline-block dropdown-menu1" data-ix="dropdown" href="#"><img src="/assets/images/options.png">
						</a>
					  </div>
					  <div class="dropdown-list" data-ix="hoverout"><a class="dropdown-link-item" href="#">Report</a><a class="dropdown-link-item" data-ix="show-modal" href="#">Share</a>
					  </div>
					</div>
				@if($userdetail->name)
					<div class="w-clearfix userinfo m-t-40">	
						
						<div class="userthumb">		
							<a href="/userprofile/{{$userdetail->id}}">
								@if($userdetail->profile_image)
									<img class="img-circle" src="{{$userdetail->profile_image}}" />
								@elseif($userdetail->fb_token)
									<img src="{{ 'http://graph.facebook.com/'.$userdetail->fb_token.'/picture?type=normal'}}">
								@else
									<img class="img-circle" src="/assets/images/defaultprofile.png" />
								@endif
							</a>
						</div>
						
						@if(isset(Auth::user()->id) && Auth::user()->id != $userdetail->id)
							<a class="w-button followbtn followbttn" id="followbtn" data-status-followbtn="{{ !$is_following }}" data-followId-followbtn="{{$userdetail->id}}" href="#">
								@if($is_following) unfollow @else follow @endif
							</a>
						@endif
							<div class="usercommentsblock">
							<div class="username"> 
							<a href="/userprofile/{{$userdetail->id}}"> {{ $userdetail->name }} </a>
							</div>
						</div>
					</div>
				@endif
				<div class="commentBLock">
                @if($comments->isEmpty())
                    <div class="w-clearfix userinfo">
                        <div class="usercommentsblock">
                            <div class="username">No Comment</div>
                        </div>
                    </div>
                @else
                    @foreach($comments as $comment)
                        <div class="w-clearfix userinfo">
                            <div class="userthumb">
								<a href="/userprofile/{{$comment->user_id}}">
									@if(!empty($comment->profile_image))
										<img class="img-circle" src="{{$comment->profile_image }}" />
									@elseif($comment->fb_token)									
										<img src="{{ 'http://graph.facebook.com/'.$comment->fb_token.'/picture?type=normal'}}">
									@else
										<img class="img-circle" src="/assets/images/defaultprofile.png" />
									@endif
								</a>
                            </div>
                            <div class="usercommentsblock">
                                <div class="username"><a href="/userprofile/{{$comment->user_id}}">{{($comment->username)?$comment->username:$comment->name}}</a></div>
                                <div class="usercomment"><?php echo $comment->comments ?></div>
                            </div>
                            <?php
                            if(empty($comment->comments)){?>
                            <div class="usercommentsblock">
                                <div class="username">No Comments</div>
                            </div>
                            <?php }?>
                            <div class="postedtime">{{ App\Helpers\UniversalClass::timeString($comment->created_at)}}</div>
                            <div class="photocaption"></div>
                        </div>
                    @endforeach
                @endif
				</div>
				<div class="w-clearfix userinfo">
                        <div class="">
						<div  class="comments-box comment">
							<form  class="commentsForm" onsubmit="return false;">
								{{ csrf_field() }}
								<input type="hidden" name="commentPostId" id="commentPostId" value="{{$post->id}}">
								<input type="text" class="commentTextarea" name="commentPost" id="commentPost" placeholder="Add a comment" >								
								<div class="has-error">
									<span class="help-block" id="comment-error">
									   {{ $errors->first('comments') }}
									</span>										
								</div>								
							</form>
						</div>                          
                        </div>
                    </div>

				</div>
            </div>

        </div>
        <div class="col-md-3"></div>
    </div>
    
	<!--<div>
		<a class="icon-facebook" onclick="return share_social(this.href);" href="https://www.facebook.com/sharer/sharer.php?u={{ Request::fullUrl()}}&title={{$post->caption}}">FTest</a>

		<a class="icon-twitter" onclick="return share_social(this.href);" href="http://twitter.com/share?url={{ Request::fullUrl()}}&title={{$post->caption}}">Ttest</a>
	
		<a class="tumblr-share-button"  data-notes="right" href="{{ Request::fullUrl()}}" canonicalUrl="{{ Request::fullUrl()}}"></a>
		<script>!function(d,s,id){var js,ajs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://secure.assets.tumblr.com/share-button.js";ajs.parentNode.insertBefore(js,ajs);}}(document, "script", "tumblr-js");</script>
	
	</div>-->
    <style>
        .img-circle {
            border-radius: 50%;
        }
    </style>
@endsection
@section('additional_js')
    <script src="/assets/js/custom/jR3DCarousel.min.js"></script>
    <script>
        var obj = $('.jR3DCarouselGallery').jR3DCarousel({
            "width": 400,
            "height": 400,
            "slideLayout": "fill",
            "animation": "slide3D",
            "animationCurve": "ease",
            "animationDuration": 700,
            "animationInterval": 1000,
            "autoplay": false,
            "navigation": null,
            "slideClass": 'slide',

        });
        document.querySelector('.js-media-player').addEventListener('ended', function(event) {
            player = document.querySelector('.js-media-player').plyr;
            player.play();
        });
           

    </script>
	


@endsection