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
								&nbsp;has commented on your Turn.
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