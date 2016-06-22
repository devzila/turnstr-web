@extends('layouts.app')

@section('content')
    @foreach($posts as $post)
    <div class="row" style="margin-bottom: 40px;">
        <div class="col-md-3"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">


            <div class="postblock">
                <div class="postimage homepostimg">
                    <div class="jR3DCarouselGallery" style="margin:auto;">
                        <div class='slide'>
                            <a href="<?php echo App\Helpers\UniversalClass::shareUrl($post->id) ?>">
                                <img src="<?php echo $post->media1_thumb_url;?>" />
                            </a>
                        </div>

                    </div>
                </div>
				<div class="post-stats">
					<div class="post-stats-label">Comments</div>
					<div class="post-stats-data">{{$post->total_comments}}</div>
					<div class="post-stats-label">Likes</div>
					<div class="post-stats-data">{{$post->total_likes}}</div>
				</div>
				
                <div class="w-clearfix userinfo">					
					<div class="userthumb">
						<a href="/userprofile/{{$post->user_id}}">
						@if($post->profile_image)
							<img class="img-circle" src="{{$post->profile_image}}" />
						@elseif($post->fb_token)
							<img src="{{ 'http://graph.facebook.com/'.$post->fb_token.'/picture?type=normal'}}">
						@else
							<img class="img-circle" src="/assets/images/defaultprofile.png" />
						@endif
						</a>
					</div>										
                    <div class="usercommentsblock">
                        <div class="username"><a href="/userprofile/{{$post->user_id}}">{{ $post->name}}</a></div>
                        <div class="usercomment"><?php echo  App\Helpers\UniversalClass::replaceTagMentionLink($post->caption) ?></div>
                    </div>
                </div>
				@if($post->comments->isEmpty())
                    <div class="w-clearfix userinfo">
                        <div class="usercommentsblock">
                            <div class="username">No Comment</div>
                        </div>
                    </div>
                @else
                    @foreach($post->comments as $comment)
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
                                <div class="usercomment"><?php echo  App\Helpers\UniversalClass::replaceTagMentionLink($comment->comments) ?></div>
                            </div>
                            
                            @if(empty($comment->comments))
                            <div class="usercommentsblock">
                                <div class="username">No Comments</div>
                            </div>
                            @endif
                            <div class="postedtime">{{ App\Helpers\UniversalClass::timeString(strtotime($comment->created_at))}}</div>
                            <div class="photocaption"></div>
                        </div>
                    @endforeach
                @endif
				@if($post->total_comments > 2)
				 <div class="view-share"><a href="<?php echo App\Helpers\UniversalClass::shareUrl($post->id) ?>">View More</a></div>
				@endif
            </div>

        </div>
        <div class="col-md-3"></div>
    </div>
    @endforeach

    <style>
        .img-circle {
            border-radius: 50%;
        }
    </style>

@endsection