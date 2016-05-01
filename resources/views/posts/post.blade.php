@extends('layouts.master')

@section('content')
    <?php
   // echo"<pre>";    print_r($post);
    ?>
    <div class="w-clearfix postblock">
      <div class="postimage">
      	<div class="jR3DCarouselGallery">
     	<div class='slide'><img src="<?php echo $post->media1_url;?>" /></div>
     	<div class='slide'><img src="<?php echo $post->media2_url;?>" /></div>
     	<div class='slide'><img src="<?php echo $post->media3_url;?>" /></div>
     	<div class='slide'><img src="<?php echo $post->media4_url;?>" /></div>
     
      	</div>
      </div>
        <?php //print_r($comments);die;?>
        @foreach($comments as $comment)
        <div class="w-clearfix userinfo">
        <div class="userthumb"><img class="img-circle" src="<?php echo $comment->profile_image;?>" />
        </div>
        <div class="usercommentsblock">
          <div class="username">{{ $comment->username}}</div>
          <div class="usercomment">{{ $comment->comments }}</div>
        </div>
        <div class="postedtime">3h</div>
      </div>
      <div class="photocaption"></div>
        @endforeach
      </div>
     
    </div>
@endsection
<style>
    .img-circle {
    border-radius: 50%;
}

</style>