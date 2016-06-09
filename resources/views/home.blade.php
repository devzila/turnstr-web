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
                                <img src="<?php echo $post->media1_url;?>" />
                            </a>
                        </div>

                    </div>
                </div>
				<div class="w-clearfix photosharecaption">
					<div class="comments-count"><span>Comments {{$post->total_comments}}  , </span><span> Likes {{$post->total_likes}}</span></div>
				</div>
                <div class="w-clearfix userinfo">
					@if($post->profile_thumb_image)
						<div class="userthumb">
							<img class="img-circle" src="<?php echo $post->profile_thumb_image;?>" />
						</div>
					@endif					
                    <div class="usercommentsblock">
                        <div class="username">{{ $post->name}}</div>
                        <div class="usercomment">{{ $post->caption }}</div>
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
                            <div class="userthumb"><img class="img-circle" src="<?php echo $comment->profile_image;?>" />
                            </div>
                            <div class="usercommentsblock">
                                <div class="username">{{ $comment->username}}</div>
                                <div class="usercomment">{{ $comment->comments }}</div>
                            </div>
                            <?php
                            if(empty($comment->comments)){?>
                            <div class="usercommentsblock">
                                <div class="username">No Comments</div>
                            </div>
                            <?php }?>
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