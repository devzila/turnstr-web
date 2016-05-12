@extends('layouts.master')

@section('content')
    <?php
   // echo"<pre>";    print_r($post);
    ?>
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
@endsection
<style>
    .img-circle {
    border-radius: 50%;
}
</style>