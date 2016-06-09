
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
						<div class="userthumb">@if($activity->user_info->profile_thumb_image)<img src="{{$activity->user_info->profile_thumb_image}}">@endif</div>
					  
					  <div class="activity-text">
						  <div><span class="activity-username">{{$activity->user_info->username}}</span>
						  @if($activity->activity == 'liked')
								&nbsp;has liked your Turn.
						  @else
								&nbsp; has started following you. 
						  @endif
						  <span class="activity-time">{{ App\Helpers\UniversalClass::timeString(strtotime($activity->activity_time))}}</span>
						  </div>
						</div>
					  </div>
				@endforeach
			@endif          
        </div>
      </div>
  @endsection 