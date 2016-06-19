<div class="w-nav navbar" data-animation="default" data-collapse="medium" data-contain="1" data-duration="400">
    <div class="w-container">
        <a href="/" class="w-nav-brand brand"><img src="{{URL::asset('assets/images/logo_title.png')}}">
        </a>
        <!-- Right Side Of Navbar -->
        <nav class="w-nav-menu" role="navigation">
            @if (Auth::guest())
                <a  class="w-nav-link navlink" href="{{ url('/login') }}">Get the App</a>
                <a  class="w-nav-link navlink" href="{{ url('/login') }}">Login</a>
            @else                				
				<a class="w-nav-link navlink loggedin @if(strpos(Request::fullUrl(),'/explore')) {{ 'w--current' }} @endif" href="/explore">Explore</a>
				<a class="w-nav-link navlink loggedin @if(strpos(Request::fullUrl(),'/users/activity')) {{ 'w--current' }} @endif" href="/users/activity">activity</a>
				<a class="w-nav-link navlink loggedin @if(strpos(Request::fullUrl(),'/userprofile')) {{ 'w--current' }} @endif"  href="/userprofile">Profile</a>
				<a class="w-nav-link navlink loggedin" href="/logout">Logout</a>
            @endif
        </nav>
        <!-- Right Side Of Navbar -->

        <div class="w-nav-button menubtn">
			<div class="w-icon-nav-menu"></div>
	    </div>
    </div>
</div>
