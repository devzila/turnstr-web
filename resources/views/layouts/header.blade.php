<div data-collapse="medium" data-animation="default" data-duration="400" data-contain="1" class="w-nav navbar">
    <div class="w-container">
        <a href="#" class="w-nav-brand brand"><img src="{{URL::asset('assets/images/logo_title.png')}}">
        </a>
        <!-- Right Side Of Navbar -->
        <nav role="navigation" class="w-nav-menu">
            @if (Auth::guest())
                <a  class="w-nav-link navlink" href="{{ url('/login') }}">Get the App</a>
                <a  class="w-nav-link navlink" href="{{ url('/login') }}">Login</a>
            @else
                <!--<ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>-->				
				<a class="w-nav-link navlink loggedin" href="#">Discover</a>
				<a class="w-nav-link navlink loggedin" href="#">activity</a>
				<a class="w-nav-link navlink loggedin" href="/users/edit">Profile</a>
				<a class="w-nav-link navlink loggedin" href="/logout">Logout</a>
            @endif
        </nav>
        <!-- Right Side Of Navbar -->

        <div class="w-nav-button">
            <div class="w-icon-nav-menu"></div>
        </div>
    </div>
</div>
