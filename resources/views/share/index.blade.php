@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-3"></div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="postblock">
                <div class="postimage">
                    <div class="jR3DCarouselGallery" style="margin:auto;">
                        <div class='slide'><img src="<?php echo $post->media1_url;?>" /></div>
                        <div class='slide'><img src="<?php echo $post->media2_url;?>" /></div>
                        <div class='slide'><img src="<?php echo $post->media3_url;?>" /></div>
                        <div class='slide'><img src="<?php echo $post->media4_url;?>" /></div>

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
        $('.jR3DCarouselGallery').jR3DCarousel({
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