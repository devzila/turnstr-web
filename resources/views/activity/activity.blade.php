
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
						<div class="userthumb">						
						@if($activity->user_info->profile_image)
							<a href="/userprofile/{{$activity->user_info->id}}">
								<img src="{{$activity->user_info->profile_image}}">
							</a>
						@else
							<a href="#"><img class="img-circle" src="/assets/images/defaultprofile.png" /></a>
						@endif
						</div>
					  
					  <div class="activity-text">
						  <div><span class="activity-username username">
						  <a class="link-anchor" href="/userprofile/{{$activity->user_info->id}}">
							{{$activity->user_info->username}}
						  </a>
						  </span>
						  @if($activity->activity == 'liked')
								&nbsp;has liked your Turn.
						  @else
								&nbsp; has started following you. 
						  @endif
						  <span class="activity-time">{{ App\Helpers\UniversalClass::timeString(strtotime($activity->activity_time))}}</span>
						  <span class="post-thumb">
								@if(isset($activity->post_info->media1_thumb_url))
									<a href="<?php echo App\Helpers\UniversalClass::shareUrl($activity->post_info->id) ?>"><img src="{{$activity->post_info->media1_thumb_url}}" height="50" width="50"></a>
								@endif
						  </span>
						  </div>
						</div>
					  </div>
				@endforeach
			@endif          
        </div>
      </div>
  @endsection 