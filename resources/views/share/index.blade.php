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
                        <div class='slide'><img src="<?php echo $post->media1_thumb_url;?>" /></div>
                        <div class='slide'><img src="<?php echo $post->media2_thumb_url;?>" /></div>
                        <div class='slide'><img src="<?php echo $post->media3_thumb_url;?>" /></div>
                        <div class='slide'>
                            <div class="js-media-player">
                                <video poster="https://cdn.selz.com/plyr/1.5/View_From_A_Blue_Moon_Trailer-HD.jpg" controls crossorigin>
                                    <!-- Video files -->
                                    <source src="https://cdn.selz.com/plyr/1.5/View_From_A_Blue_Moon_Trailer-HD.mp4" type="video/mp4">
                                    <source src="https://cdn.selz.com/plyr/1.5/View_From_A_Blue_Moon_Trailer-HD.webm" type="video/webm">

                                    <!-- Text track file -->
                                    <track kind="captions" label="English" srclang="en" src="https://cdn.selz.com/plyr/1.5/View_From_A_Blue_Moon_Trailer-HD.en.vtt" default>

                                    <!-- Fallback for browsers that don't support the <video> element -->
                                    <a href="https://cdn.selz.com/plyr/1.0/movie.mp4">Download</a>
                                </video>
                            </div>
                        </div>

                    </div>
                </div>
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
        debugger;
    </script>
@endsection