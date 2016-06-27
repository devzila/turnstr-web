@extends('layouts.app')
@section('content')
<div ng-app='Turnstr' ng-controller='HomeController'>
  <div infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='0'>
    <div ng-repeat='post in reddit.items'>  
	  <div class="row" style="margin-bottom: 40px;">
        <div class="col-md-3"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">


            <div class="postblock">
                <div class="postimage homepostimg">
                    <div class="jR3DCarouselGallery" style="margin:auto;">
                        <div class='slide'>
						
                            <a href="@{{post.shareUrl}}">
                                <img src="@{{ post.media1_thumb_url }}" />
                            </a>
                        </div>

                    </div>
                </div>
				<div class="post-stats">
					<div class="post-stats-label">Comments</div>
					<div class="post-stats-data">@{{post.total_comments}}</div>
					<div class="post-stats-label">Likes</div>
					<div class="post-stats-data">@{{post.total_likes}}</div>
				</div>
				
                <div class="w-clearfix userinfo">					
					<div class="userthumb">
						<a href="/userprofile/@{{post.user_id}}">						
							<img ng-if="post.profile_image" class="img-circle" src="@{{post.profile_image}}" />
							<img ng-if="post.fb_token && !post.profile_image" class="img-circle" src="http://graph.facebook.com/@{{post.fb_token}}/picture?type=normal">						
							<img ng-if="!post.fb_token && !post.profile_image" class="img-circle" src="/assets/images/defaultprofile.png" />						
						</a>
					</div>										
                    <div class="usercommentsblock">
                        <div class="username"><a href="/userprofile/@{{$post.user_id}}">@{{ post.name}}</a></div>
                        <div class="usercomment" ng-bind-html="post.caption"></div>
                    </div>
                </div>
				
				<div ng-if="!post.comments" class="w-clearfix userinfo">
					<div class="usercommentsblock">
						<div class="username">No Comment</div>
					</div>
				</div>
               
				<div ng-if="post.comments" ng-repeat='comment in post.comments'>
                    
                        <div class="w-clearfix userinfo">
                            <div class="userthumb">
								<a href="/userprofile/@{{comment.user_id}}">
									
									<img ng-if="comment.profile_image" class="img-circle" src="@{{comment.profile_image }}" />
																		
									<img class="img-circle" ng-if="!comment.profile_image && comment.fb_token" src="http://graph.facebook.com/@{{comment.fb_token}}/picture?type=normal">
								
									<img class="img-circle" ng-if="!comment.profile_image && !comment.fb_token" src="/assets/images/defaultprofile.png" />
									
								</a>
                            </div>
                            <div class="usercommentsblock">
                                <div class="username">
									<a href="/userprofile/@{{comment.user_id}}">
										<div ng-if="comment.username">@{{comment.username}}</div>
										<div ng-if="!comment.username">@{{comment.name}}</div>
									</a>
								</div>
                                <div class="usercomment" ng-bind-html="comment.commentsHtml"></div>
                            </div>
                            
                            <!--@if(empty($comment->comments))
                            <div class="usercommentsblock">
                                <div class="username">No Comments</div>
                            </div>
                            @endif-->
                            <div class="postedtime"><?php //$created_at = "{{comment.created_at}}"; 
							//echo App\Helpers\UniversalClass::timeString(strtotime($created_at)) ?></div>
                            <div class="photocaption"></div>
                        </div>
						</div>
                    
				
				 <div ng-if="post.total_comments > 2" class="view-share"><a href="@{{ post.shareUrl}}">View More</a></div>
				
            </div>

        </div>
        <div class="col-md-3"></div>
    </div>
    </div>
    <div ng-show='reddit.busy'><img src="/assets/images/preloader.gif"></div>
  </div>
</div>




	<style>
        .img-circle {
            border-radius: 50%;
        }
    </style>
@endsection