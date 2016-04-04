<html>
    <head>
        <title>Turnstr</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
        <script src="https://cdn.rawgit.com/vinayakjadhav/jR3DCarousel/v0.0.8/dist/jR3DCarousel.min.js"></script>

        <style>
            body{
            background-color: rgb(254,127,23);   
            }
            header {
                margin: 0 10%;
                padding-top: 2%;
            }

            footer {
                margin: 0 10%;
                padding-top: 2%;
            }

            .headerClass, .footerClass {
                height: 100px;
            }

            .sectionClass {
                background-color: rgb(250, 250, 250);
                padding: 50px;
            }
            .footerMenu span {
                padding-left: 25px;
            }
        </style>

    </head>
    <body>
        <header class='headerClass'>
            <span class='pull-left'><img src='assets/images/logo.png' style='height:55px;width:190px;' /></span>
            <div  class='pull-right'>
                <button> Get the app</button>
                <span>LogIn</span>
            </div>
        </header>
        <section class='sectionClass'>
            @yield('content')
        </section>
        <footer class='footerClass'>
            <div class='pull-left footerMenu'>
                <span>About us</span>
                <span>Support</span>
                <span>Blog</span>
                <span>Press</span>
                <span>API</span>
            </div>
            <div class='pull-right footerCopy'>
                <span> &copy 2016 Turnstr</span>
            </div>
        </footer>

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
                "slides": slides,
            });
        </script>
    </body>
</html>