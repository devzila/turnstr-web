<!DOCTYPE html>
<!-- This site was created in Webflow. http://www.webflow.com-->
<!-- Last Published: Mon Apr 04 2016 18:47:20 GMT+0000 (UTC) -->
<html data-wf-site="5702ae184536faf83a83cb9a" data-wf-page="5702ae184536faf83a83cb9b">
<head>
  <meta charset="utf-8">
  <title>turnstr</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="generator" content="Webflow">
  <link rel="stylesheet" type="text/css" href="../assets/css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/webflow.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/turnstr.webflow.css">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic"]
      }
    });
  </script>
  <script type="text/javascript" src="../assets/js/modernizr.js"></script>
  <link rel="shortcut icon" type="../assets/image/x-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico">
  <link rel="apple-touch-icon" href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png">
</head>
<body class="body">
  <div data-collapse="medium" data-animation="default" data-duration="400" data-contain="1" class="w-nav navbar">
    <div class="w-container">
      <a href="#" class="w-nav-brand brand"><img src="../assets/images/logo_title.png">
      </a>
      <nav role="navigation" class="w-nav-menu"><a href="#" class="w-nav-link navlink">Get the App</a><a href="#" class="w-nav-link navlink">Login</a>
      </nav>
      <div class="w-nav-button">
        <div class="w-icon-nav-menu"></div>
      </div>
    </div>
  </div>
  <div class="w-container content">
            @yield('content')
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
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script type="text/javascript" src="../assets/js/webflow.js"></script>
        <script src="https://cdn.rawgit.com/vinayakjadhav/jR3DCarousel/v0.0.8/dist/jR3DCarousel.min.js"></script>

        <script>
            var slides = [
                {src: 'http://static.dnaindia.com/sites/default/files/2015/11/28/399304-getty2.jpg'},
                {src: 'http://www.beautiful-self.com/wp-content/uploads/2016/02/kim-look-3.jpg'},
                {src: 'http://images.agoramedia.com/wte3.0/gcms/kim-kardashian-reveals-scary-pregnancy-experience.jpeg'},
                {src: 'http://www.allure.com/beauty-trends/blogs/daily-beauty-reporter/2015/12/18/kim-skin.jpg'}
            ];

           $('.jR3DCarouselGallery').jR3DCarousel({
                "width": 400,
                "height": 400,
                "slideLayout": "fill",
                "animation": "slide3D",
                "animationCurve": "ease",
                "animationDuration": 700,
                "animationInterval": 1000,
                "autoplay": false,
                "navigation": null,
                "slideClass": 'slide',
              //  "slides": slides,
            });
        </script>
    </body>
</html>