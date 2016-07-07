
@extends('layouts.app')
@section('content')

<div class="w-section content">
        <div class="w-container activity-container">
			@if(!count($activities))
				<div class="w-clearfix activity-list-item">
					<div class="userthumb"></div>
					<div class="activity-text">
					  <div><span class="activity-username">No Activity Found</span>
					  </div>
					</div>
				 </div>
			@else
				@foreach($activities as $activity)					
					  <div class="w-clearfix activity-list-item">					  
						<div class="userthumb-all">	
						<a href="/userprofile/{{$activity->user_info_id}}">
						@if($activity->user_info_profile_image)							
								<img src="{{$activity->user_info_profile_image}}">
						@else
							<img class="img-circle" src="/assets/images/defaultprofile.png" />
						@endif
						</a>
						</div>
					  
					  <div class="activity-text">
						  <div><span class="activity-username username">
						  <a class="link-anchor" href="/userprofile/{{$activity->user_info_id}}">
							
								{{($activity->user_info_username)?$activity->user_info_username:$activity->user_info_name}}
							
								
						  </a>
						  </span>
						  @if($activity->activity == 'liked')
								&nbsp;has liked your Turn.
						  @elseif($activity->activity == 'comment')
								&nbsp;has commented your Turn.
						  @else
								&nbsp; has started following you. 
						  @endif
						  <span class="activity-time">{{ App\Helpers\UniversalClass::timeString($activity->activity_time)}}</span>
						  <span class="post-thumb">
								@if(isset($activity->media1_thumb_url))
									<a href="<?php echo App\Helpers\UniversalClass::shareUrl($activity->turn_id) ?>"><img src="{{$activity->media1_thumb_url}}" height="50" width="50"></a>
								@endif
						  </span>
						  </div>
						</div>
					  </div>
				@endforeach
				<div class="w-clearfix hide">
				<div >
				<a href="javascript:void(0);" class="load_more" data-page="1"><img  class="loader-img" src="/assets/images/loadmore.png"  height="64px" width="64px" /></a>
				<a href="javascript:void(0);" class="loading hide"><img   src="/assets/images/preloader.gif"  height="64px" width="64px"></a>
				</div>
				</div>
			@endif          
        </div>
      </div>
  @endsection 
  @section('additional_js')
    
    <script>
(function(e) {
	 var page=1;
	 e(document).on('click','.load_more',function(){
        
        e('.load_more').addClass('hide');
        e('.loading').removeClass('hide');
        
        e.ajax({
            type:'POST',
            url:'/loadMoreActivity?'+ page,          
            success:function(html){				
                $('#show_more_main'+ID).remove();
                $('.tutorial_list').append(html);
            }
        }); 
    });
	
})(jQuery);	
    </script>
	


@endsection