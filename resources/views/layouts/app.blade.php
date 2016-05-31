<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>turnstr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Webflow">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/normalize.css') }}">

    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/webflow.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/css/turnstr.webflow.css')}}">
    <link href="{{URL::asset('assets/css/vendor/bootstrap/dist/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("/assets/css/external/plyr.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("/assets/css/external/docs.css")}}" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic"]
            }
        });
    </script>
    <link rel="apple-touch-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png">
</head>
<body>

<!-- Header -->
@include('layouts/header')


<div class="w-container content">
    @yield('content')
</div>

<!-- Footer -->
@include('layouts/footer')

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="/assets/js/vendor/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ asset("/assets/js/custom/plyr.js") }}" type="text/javascript"></script>
<script src="{{ asset("/assets/js/custom/docs.js") }}" type="text/javascript"></script>

@yield('additional_js')
</body>
</html>