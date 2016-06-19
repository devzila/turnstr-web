<!DOCTYPE html>
<!-- This site was created in Webflow. http://www.webflow.com-->
<!-- Last Published: Wed May 25 2016 07:55:25 GMT+0000 (UTC) -->
<html data-wf-site="5702ae184536faf83a83cb9a" data-wf-page="574542e370166f8515d7bdd3">
<head>
    <meta charset="utf-8">
    <title>turnstr - Login</title>
    <meta property="og:title" content="login">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Webflow">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/webflow.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/turnstr.webflow.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic","Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic"]
            }
        });
    </script>
    <link rel="shortcut icon" type="image/x-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico">
    <link rel="apple-touch-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png">
</head>
<body>
<div class="body-container">
    <div class="w-section login-container">
        <div class="w-container content-container">
            <div class="logo"><img width="120" src="{{URL::asset('assets/images/logo_login.png')}}">
            </div>
            <div class="login-form-container">
                <div class="phones"><img src="{{URL::asset('assets/images/phones.png')}}">
                </div>
                <div class="form-container">
                    <div class="w-form">
                        <form method="post" id="email-form" name="email-form" data-name="Email Form" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <input id="email"   placeholder="Email/Username"  name="email" value="{{ old('email') }}" required="required" class="w-input formfield">
                            <input id="password" type="password" placeholder="password" name="password" required="required" class="w-input formfield">
                            <input type="submit" value="login" data-wait="Please wait..." class="w-button submit_btn">
                        </form>

                        @if ($errors->first('error') )
                            <div class="w-form-fail">
                                <p>Oops! Login/Password did not match. Try again.</p>
                            </div>
                        @endif
                    </div>
                        <a href="/password/reset" class="forgotpwlink">Forgot password?</a>
                        <!--<a href="#" class="facebooklogin">Login with facebook</a>-->
                    <p>&nbsp;</p>
                        <a href="/register" class="register_new">Don't have an account? <span class="link">Sign up</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="w-section footer">
        <div class="w-container">
            <ul class="w-list-unstyled w-clearfix footerlist">
                <li class="listitem">About us</li>
                <li class="listitem">Support</li>
                <li class="listitem">Blog</li>
                <li class="listitem">Press</li>
                <li class="listitem">API</li>
            </ul>
            <div class="copyright">© 2016 turnstr</div>
        </div>
    </div>
</div>
</body>
</html>