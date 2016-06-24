@extends('layouts.app')
@section('content')
<div class="w-section content">
        <div class="w-container">
          <div class="search-module">
            <div class="w-form">
              <form class="w-clearfix search-form" action="/explore">
                <input class="w-input search-field"  id="searchData" maxlength="256" name="searchData" placeholder="Search" type="text" value="{{Input::get('searchData')}}">
                <input class="w-button search-submit" data-wait="Please wait..." type="submit" value="Submit">
              </form>
              <div class="w-form-done">
                <p>Thank you! Your submission has been received!</p>
              </div>
              <div class="w-form-fail">
                <p>Oops! Something went wrong while submitting the form</p>
              </div>
            </div>
          </div>
          <div ng-app='Turnstr' ng-controller="ExplorerController">
                <div  infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='0'>
                        <div class="w-row profile-image-grid explorer" >           
			        <div class="w-row "  >
				        <div class="w-col w-col-4 profile-image-grid " ng-repeat="post in reddit.items">
					        <div class="profile-upload-items">
						        <a href="@{{post.shareUrl}}"><img src="@{{post.media1_thumb_url}}"></a>
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