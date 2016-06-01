@extends('layouts.app')

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
</style>
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
				
				<div class="w-clearfix photosharecaption">
					
					<div class="comments-count"><span>Comments {{ $total_comments }}  , </span><span > Likes {{ $total_likes}}</span></div>
					@if($post->caption)					
						<div class="w-clearfix">{{ $post->caption }}</div>
					@endif
				</div>
				@if($userdetail->name)
					<div class="w-clearfix userinfo">	
						@if($userdetail->profile_thumb_image)
							<div class="userthumb">					
								<img class="img-circle" src="{{ $userdetail->profile_thumb_image }}">					
							</div>
						@endif
						<a class="w-button followbtn" href="#">follow</a>
							<div class="usercommentsblock">
							<div class="username"> {{ $userdetail->name }} </div>
						</div>
					</div>
				@endif
                @if($comments->isEmpty())
                    <div class="w-clearfix userinfo">
                        <div class="usercommentsblock">
                            <div class="username">No Comment</div>
                        </div>
                    </div>
                @else
                    @foreach($comments as $comment)
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
                            <div class="postedtime">3h</div>
                            <div class="photocaption"></div>
                        </div>
                    @endforeach
                @endif


            </div>

        </div>
        <div class="col-md-3"></div>
    </div>
    </div>

    <style>
        .img-circle {
            border-radius: 50%;
        }
    </style>

@endsection
@section('additional_js')
    <script src="https://cdn.rawgit.com/vinayakjadhav/jR3DCarousel/v0.0.8/dist/jR3DCarousel.min.js"></script>
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

    </script>
@endsection