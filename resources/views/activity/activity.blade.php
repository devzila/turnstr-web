
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
				@include('activity.loadactivity')
				@if(count($activities) >= $loadCount)
					<div id="loadMore"></div>
					<div class="w-clearfix load-more">
					<div >
					<a href="javascript:void(0);" class="load_more" data-page="1"><img  class="loader-img" src="/assets/images/loadmore.png"  height="64px" width="64px" /></a>
					<a href="javascript:void(0);" class="loading hide"><img   src="/assets/images/preloader.gif"  height="64px" width="64px"></a>
					</div>
					</div>
				@endif
			@endif          
        </div>
      </div>
  @endsection 
  @section('additional_js')
    
    <script>
(function(e) {
	 var page=1,loadMoreBusy=0;
	 e(document).on('click','.load_more',function(){
        
        e('.load_more').addClass('hide');        
        e('.loading').removeClass('hide');
        
        e.ajax({
            type:'GET',
            url:'/users/activity?page='+ page,          
            success:function(html){
			   if(html == "") loadMoreBusy = 1;
               e('#loadMore').append(html);
			   
            },
			error: function(){
					
			},
			complete: function() {
				page++;
				e('.loading').addClass('hide'); 
				if(loadMoreBusy == 0)
			    e('.load_more').removeClass('hide');
			}	
			
        }); 
    });
	
})(jQuery);	
    </script>
	


@endsection