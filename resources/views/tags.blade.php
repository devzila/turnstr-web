@extends('layouts.app')
@section('content')
<div class="w-section content">
        <div class="w-container">
          <div class="search-module">
            <div class="w-form">
              <form class="w-clearfix search-form" action="/tags">
                <input class="w-input search-field"  id="searchData" maxlength="256" name="searchData" placeholder="Search" type="text" value="{{Input::get('searchData')}}">
                <input class="w-button search-submit" data-wait="Please wait..." type="submit" value="Submit">
              </form>              
            </div>
          </div>
          <div class="w-row profile-image-grid explorer">
           
			  <?php $i=0; ?>
			  @if(count($posts)!= 0)
				  @foreach($posts as $post)
					@if(!$post->media1_thumb_url)
						@continue
					@endif
				  <?php ++$i;?>
					  @if($i%3 == 1)
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
 @endsection   