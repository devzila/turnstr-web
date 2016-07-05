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
         <div ng-app='Turnstr' ng-controller="TagController">
			<div  infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='0'>
                <div class="w-row profile-image-grid explorer" >           
			        <div class="w-row "  >
				        <div class="w-col w-col-4 profile-image-grid " ng-repeat="post in reddit.items">
					        <div class="profile-upload-items">
						        <a href="@{{post.shareUrl}}"><img src="@{{post.media1_thumb_url}}" height="300px" width="100%"></a>
					        </div>
						</div>
					</div>
				</div> 
             </div>
             <div ng-show='reddit.busy'><img src="/assets/images/preloader.gif"></div>
          </div>          
        </div>
      </div>
 @endsection   