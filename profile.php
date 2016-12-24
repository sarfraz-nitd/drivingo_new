<<<<<<< HEAD
<<<<<<< HEAD
<!DOCTYPE html>
<html>
    <head>
        <title>Drivingo, version 1.0</title>
        <link rel="stylesheet" href="materialize/css/materialize.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script> 
        <script src="materialize/js/materialize.min.js"></script>
        
        <script>
            $(document).ready(function(){
                $('.scrollspy').scrollSpy();
                $('.mobile-nav-bar').hide();
            });
            
            function mobileNavBar(){
                $('.mobile-nav-bar').slideToggle('slow');
            }
        </script>
        
        <style>
            .gradient{
                background: #C04848; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        
            }
            
            .fixed-side-nav{
                position: fixed;
                height: 610px;
                width: 300px;
                left: 5%;
                background: white;
                top: 15%;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }
            
            .main-section{
                position: absolute;
                height: 180em;
                width: 66%;
                left: 28%;
                background: white;
                top: 15%;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }
            
            .table-of-contents-inner{
                width: 18em;
            }
            
            * {
                box-sizing: border-box;
            }

            .columns {
                float: left;
                width: 33.3%;
                padding: 8px;
            }

            .price {
                list-style-type: none;
                border: 1px solid #eee;
                margin: 0;
                padding: 0;
                -webkit-transition: 0.3s;
                transition: 0.3s;
            }

            .price:hover {
                box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
            }

            .price .header {
                background-color: #111;
                color: white;
                font-size: 25px;
            }

            .price li {
                border-bottom: 1px solid #eee;
                padding: 20px;
                text-align: center;
            }

            .price .grey {
                background-color: #eee;
                font-size: 20px;
            }

            .button {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 10px 25px;
                text-align: center;
                text-decoration: none;
                font-size: 18px;
            }

            @media only screen and (max-width: 600px) {
                .columns {
                    width: 100%;
                }
            }
            
            
            .mySlides {display:none}

            /* Slideshow container */
            .slideshow-container {
              max-width: 1000px;
              position: relative;
              margin: auto;
              box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }

            /* Caption text */
            .text {
              color: #f2f2f2;
              font-size: 15px;
              padding: 8px 12px;
              position: absolute;
              bottom: 8px;
              width: 100%;
              text-align: center;
            }

            /* Number text (1/3 etc) */
            .numbertext {
              color: #f2f2f2;
              font-size: 12px;
              padding: 8px 12px;
              position: absolute;
              top: 0;
            }

            /* The dots/bullets/indicators */
            .dot {
              height: 13px;
              width: 13px;
              margin: 0 2px;
              background-color: #bbb;
              border-radius: 50%;
              display: inline-block;
              transition: background-color 0.6s ease;
            }

            .active_dot {
              background-color: #717171;
            }

            /* Fading animation */
            .fade {
              -webkit-animation-name: fade;
              -webkit-animation-duration: 1.5s;
              animation-name: fade;
              animation-duration: 1.5s;
            }

            @-webkit-keyframes fade {
              from {opacity: .4} 
              to {opacity: 1}
            }

            @keyframes fade {
              from {opacity: .4} 
              to {opacity: 1}
            }

            /* On smaller screens, decrease text size */
            @media only screen and (max-width: 300px) {
              .text {font-size: 11px}
            }
            
            #gallery{
                padding-top: 33rem;
            }
            
            input:not([type]), input[type="text"], input[type="password"], input[type="email"], input[type="url"], input[type="time"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="tel"], input[type="number"], input[type="search"], textarea.materialize-textarea {
                background-color: transparent;
                border: none;
                border-bottom: 3px solid #490147;
                border-radius: 0;
                outline: none;
                height: 3rem;
                width: 100%;
                font-size: 1rem;
                margin: 0 0 20px 0;
                padding: 0;
                box-shadow: none;
                box-sizing: content-box;
                transition: all 0.3s;
            }
            
            .scrollspy-header{
                font-weight: 100;
            }
            
            .move-right{
                padding-left: 1rem;
            }
            
            .comment-by{
                font-size: 1.2em;
                font-weight: 300;
                color: grey;
            }
            
            .comment-section{
                height: 400px;
                overflow-y: auto;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                padding: 1em;
            }
            
            .comment-body{
                color: white;
            }
            
            .feedback{
                position: fixed;
                width: 19em;
                bottom: 3em;
            }
            
            .navigation-bar{
                position: fixed;
                top: 0;
                overflow: hidden;
                width: 100%;
                z-index: 100;
            }

            .menu-icon{
                display: none;
            }

            .mobile-nav-bar{
                display: none;
            }

            .logo1{
                top: 8px;
                left: 10px;
            } 
            
            .footer-p{
                color: white;
            }
            
            footer{
                background: #000000; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #000000 , #434343); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #000000 , #434343); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                position: relative;
                top: 191em;
            }
            
            @media screen and (max-width: 768px){
                
                .main-section{
                    position: absolute;
                    height: 281em;
                    width: 90%;
                    left: 5%;
                    background: white;
                    top: 15%;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                }
                
                .scrollspy-header{
                    font-weight: 200;
                    font-size: 2em;
                }
                
                .columns{
                    width: 111%;
                    position: relative;
                    left: -8%;
                }
                
                .menu-icon{
                    display: block;
                    position: relative;
                    left: 85%;
                    top: 8px;
                }

                .menu-icon:hover{
                    cursor: pointer;
                }

                .mobile-nav-bar{
                    display: block;
                    z-index: 2;
                    position: fixed;
                    top: 55px;
                    width: 100%;
                    color: white;
                    height: 100px;
                }

                .mobile-nav-bar-options{
                    color: white;
                    font-weight: 400;
                }

                .mobile-nav-bar-options:hover{
                    color: white;
                    font-weight: 200;
                }
                
                footer{
                    background: #000000; /* fallback for old browsers */
                    background: -webkit-linear-gradient(to left, #000000 , #434343); /* Chrome 10-25, Safari 5.1-6 */
                    background: linear-gradient(to left, #000000 , #434343); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                    position: relative;
                    top: 288em;
                }
                
                .comment-section {
                    height: 400px;
                    overflow-y: auto;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    padding: 1em;
                    width: 105%;
                    position: relative;
                    left: -5%;
                }
                
                #gallery {
                    padding-top: 106rem;
                }
                
                .slideshow-container {
                    max-width: 1000px;
                    position: relative;
                    margin: auto;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    width: 285px;
                    left: -23px;
                }
            }
        </style>
    </head>
    <body class="gradient" style="margin-top: 1px;">
        
        <!-- Navigation
        ================================================== -->

        <nav class="navigation-bar gradient">
            <a href="./index.php" class="brand-logo logo1 left"><img style="height: 40px;" src="img/logo1.png" /></a>
            <span class="menu-icon" id="menu-icon" onclick="mobileNavBar();"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></span>
            <div class="nav-wrapper">
                <ul class="right hide-on-med-and-down">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="#">About us</a></li>
                </ul>
                <div class="mobile-nav-bar gradient">
                    <div class="row center-align" style="margin-bottom: -10px">
                        <a class="mobile-nav-bar-options" href="./index.php">Home</a>
                    </div>
                    <div class="row center-align" style="margin-top: -10px;margin-bottom: -10px;">
                        <a class="mobile-nav-bar-options" href="#">About us</a>
                    </div>
                </div>
            </div>
        </nav>
        
        <section class="fixed-side-nav hide-on-small-only">        
          <div class="row">
            <div class="col hide-on-small-only m3 l2">
              <ul class="section table-of-contents">
                <li class="table-of-contents-inner"><a href="#introduction">About Ronnie's Driving school</a></li>
                <li class="table-of-contents-inner"><a href="#structure">About Owner</a></li>
                <li class="table-of-contents-inner"><a href="#initialization">Packages</a></li>
                <li class="table-of-contents-inner"><a href="#gallery">Gallery</a></li>
                <li class="table-of-contents-inner"><a href="#comments">Comments</a></li>
              </ul>
              <div class="row feedback">
                <div class="input-field col s12">
                  <input id="first_name" type="text" class="validate">
                  <label for="first_name">Give us your feedback!</label>
                </div>  
              </div>
            </div>
          </div>
        </section>
        
        <section class="main-section">
            <div class="row">
                <div class="col s12 m9 l12">
                  <div id="introduction" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">About Ronnie's Driving School</h2>
                    <p>Road safety is a key concern area for both the Government and the people on Indian roads. Safe driving today requires a higher level of confidence and competence, given the poor traffic planning, increasing number of vehicles, lack of professionalism in driving and untrained drivers on road. In a bid to address these issues, Maruti Suzuki India Ltd. has launched Maruti Driving School — its initiative for promoting safe driving.

                    MDS not just imparts better driving skills but also tries to inculcate safe driving culture through special theoretical sessions for behavioural training and road sense. The school was the first to introduce advanced driving training simulator for better judgment and concept of route maps for holistic on-road practice. </p>
                  </div>

                  <div id="structure" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">About Owner</h2>
                    <p>Ronnie's driving school is owned by Mr. Ronnie Hira.</p>
                    <p>This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.</p>
                  </div>

                  <div id="initialization" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">Packages</h2>
                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">Truck/ Big vehicles</li>
                        <li class="grey">Rs. 11000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>

                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">SUV</li>
                        <li class="grey">Rs. 7000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>

                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">Cars/ Small vehicles</li>
                        <li class="grey">Rs. 4000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>
                  </div>
                    
                  <div id="gallery" class="section scrollspy move-right">
                    
                    <h2 class="scrollspy-header">Gallery</h2>
                    <div class="slideshow-container">

                    <div class="mySlides fade">
                      <div class="numbertext">1 / 3</div>
                      <img src="img/beautiful.jpg" style="width:100%">
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">2 / 3</div>
                      <img src="img/driving-1.jpg" style="width:100%">
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">3 / 3</div>
                      <img src="img/license.jpg" style="width:100%">
                    </div>

                    </div>
                    <br>

                    <div style="text-align:center">
                      <span class="dot"></span> 
                      <span class="dot"></span> 
                      <span class="dot"></span> 
                    </div>
                  
                  </div>
                    
                  <div id="comments" class="section scrollspy move-right">
                     <h2 class="scrollspy-header">Comments</h2>
                     <div class="row">
                        <div class="input-field col s12">
                          <input id="" type="text" class="validate" placeholder="Post a comment...">
                        </div> 
                     </div>
                     <div class="comment-section gradient">
                        <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div>
                         <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div>
                         <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div> 
                     </div>
                  </div>
                </div>
            </div>
        </section>
        
        <footer>
            <div class="row" style="margin-bottom: 0;">
                <div class="col l1 m1"></div>
                <div class="col s12 m4 l4 footer-p">
                    <div class="footer-p1"><p>© drivigo 2016.</p></div>
                    <div class="footer-p2"><p>Designed & developed by Sarang Kartikey & Sarfraz Ahmad, exclusively for Drivigo Pvt. Ltd. </p></div>
                </div>
            </div>
        </footer>
        
        <script>
            var slideIndex = 0;
            showSlides();

            function showSlides() {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                for (i = 0; i < slides.length; i++) {
                   slides[i].style.display = "none";  
                }
                slideIndex++;
                if (slideIndex> slides.length) {slideIndex = 1}    
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active_dot", "");
                }
                slides[slideIndex-1].style.display = "block";  
                dots[slideIndex-1].className += " active_dot";
                setTimeout(showSlides, 2000); // Change image every 2 seconds
            }
        </script>
    </body>
=======
<!DOCTYPE html>
<html>
    <head>
        <title>Drivingo, version 1.0</title>
        <link rel="stylesheet" href="materialize/css/materialize.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script> 
        <script src="materialize/js/materialize.min.js"></script>
        
        <script>
            $(document).ready(function(){
                $('.scrollspy').scrollSpy();
                $('.mobile-nav-bar').hide();
                $('#image-header').hide();
            });
            
            function mobileNavBar(){
                $('.mobile-nav-bar').slideToggle('slow');
            }
            
            function showName(id){
                $(id).show('slow');
            }
            
            function hideName(id){
                $(id).hide('fast');
            }
        </script>
        
        <style>
            .gradient{
                background: #C04848; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        
            }
            
            .fixed-side-nav{
                position: fixed;
                height: 79%;
                width: 300px;
                left: 5%;
                background: white;
                top: 15%;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }
            
            .main-section{
                position: absolute;
                width: 71%;
                left: 24%;
                background: white;
                top: 15%;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }
            
            .table-of-contents-inner{
                width: 18em;
            }
            
            * {
                box-sizing: border-box;
            }

            .columns {
                float: left;
                width: 33.3%;
                padding: 8px;
            }

            .price {
                list-style-type: none;
                border: 1px solid #eee;
                margin: 0;
                padding: 0;
                -webkit-transition: 0.3s;
                transition: 0.3s;
            }

            .price:hover {
                box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
            }

            .price .header {
                background-color: #111;
                color: white;
                font-size: 25px;
            }

            .price li {
                border-bottom: 1px solid #eee;
                padding: 20px;
                text-align: center;
            }

            .price .grey {
                background-color: #eee;
                font-size: 20px;
            }

            .button {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 10px 25px;
                text-align: center;
                text-decoration: none;
                font-size: 18px;
            }

            @media only screen and (max-width: 600px) {
                .columns {
                    width: 100%;
                }
            }
            
            
            .mySlides {display:none}

            /* Slideshow container */
            .slideshow-container {
              max-width: 1000px;
              position: relative;
              margin: auto;
              box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }

            /* Caption text */
            .text {
              color: #f2f2f2;
              font-size: 15px;
              padding: 8px 12px;
              position: absolute;
              bottom: 8px;
              width: 100%;
              text-align: center;
            }

            /* Number text (1/3 etc) */
            .numbertext {
              color: #f2f2f2;
              font-size: 12px;
              padding: 8px 12px;
              position: absolute;
              top: 0;
            }

            /* The dots/bullets/indicators */
            .dot {
              height: 13px;
              width: 13px;
              margin: 0 2px;
              background-color: #bbb;
              border-radius: 50%;
              display: inline-block;
              transition: background-color 0.6s ease;
            }

            .active_dot {
              background-color: #717171;
            }

            /* Fading animation */
            .fade {
              -webkit-animation-name: fade;
              -webkit-animation-duration: 1.5s;
              animation-name: fade;
              animation-duration: 1.5s;
            }

            @-webkit-keyframes fade {
              from {opacity: .4} 
              to {opacity: 1}
            }

            @keyframes fade {
              from {opacity: .4} 
              to {opacity: 1}
            }

            /* On smaller screens, decrease text size */
            @media only screen and (max-width: 300px) {
              .text {font-size: 11px}
            }
            
            #gallery{
                padding-top: 33rem;
            }
            
            input:not([type]), input[type="text"], input[type="password"], input[type="email"], input[type="url"], input[type="time"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="tel"], input[type="number"], input[type="search"], textarea.materialize-textarea {
                background-color: transparent;
                border: none;
                border-bottom: 3px solid #490147;
                border-radius: 0;
                outline: none;
                height: 3rem;
                width: 100%;
                font-size: 1rem;
                margin: 0 0 20px 0;
                padding: 0;
                box-shadow: none;
                box-sizing: content-box;
                transition: all 0.3s;
            }
            
            .scrollspy-header{
                font-weight: 100;
            }
            
            .move-right{
                padding-left: 1rem;
            }
            
            .comment-by{
                font-size: 1.2em;
                font-weight: 300;
                color: grey;
            }
            
            .comment-section{
                height: 400px;
                overflow-y: auto;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                padding: 1em;
            }
            
            .comment-body{
                color: white;
            }
            
            .feedback{
                position: fixed;
                width: 19em;
                bottom: 3em;
            }
            
            .navigation-bar{
                position: fixed;
                top: 0;
                overflow: hidden;
                width: 100%;
                z-index: 100;
            }

            .menu-icon{
                display: none;
            }

            .mobile-nav-bar{
                display: none;
            }

            .logo1{
                top: 8px;
                left: 10px;
            } 
            
            .footer-p{
                color: white;
            }
            
            footer{
                background: #000000; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #000000 , #434343); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #000000 , #434343); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                position: relative;
                top: 238em;
            }
            
            .item-img {
              position: relative;
              overflow: hidden;
              width: 100%;
            }
            .item-img img {
              max-width: 100%;

              -moz-transition: all 0.3s;
              -webkit-transition: all 0.3s;
              transition: all 0.3s;
            }
            .item-img:hover img {
              -moz-transform: scale(1.1);
              -webkit-transform: scale(1.1);
              transform: scale(1.1);
              opacity: .8;
            }
            
            .image-header{
                position: absolute;
                top: 4em;
                left: 21%;
                font-size: 4em;
                font-weight: 200;
                color: darkgrey;
                border: 2px solid white;
                width: 56%;
                background: white;
                opacity: 1;
                box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
            }
            
            .image-header p{
                padding-left: 1em;
                padding-right: 1em;
            }
            
            @media screen and (max-width: 768px){
                
                .main-section{
                    position: absolute;
                    width: 90%;
                    left: 5%;
                    background: white;
                    top: 15%;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                }
                
                .scrollspy-header{
                    font-weight: 200;
                    font-size: 2em;
                }
                
                .columns{
                    width: 111%;
                    position: relative;
                    left: -8%;
                }
                
                .menu-icon{
                    display: block;
                    position: relative;
                    left: 85%;
                    top: 8px;
                }

                .menu-icon:hover{
                    cursor: pointer;
                }

                .mobile-nav-bar{
                    display: block;
                    z-index: 2;
                    position: fixed;
                    top: 55px;
                    width: 100%;
                    color: white;
                    height: 100px;
                }

                .mobile-nav-bar-options{
                    color: white;
                    font-weight: 400;
                }

                .mobile-nav-bar-options:hover{
                    color: white;
                    font-weight: 200;
                }
                
                footer{
                    background: #000000; /* fallback for old browsers */
                    background: -webkit-linear-gradient(to left, #000000 , #434343); /* Chrome 10-25, Safari 5.1-6 */
                    background: linear-gradient(to left, #000000 , #434343); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                    position: relative;
                    top: 300em;
                }
                
                .comment-section {
                    height: 400px;
                    overflow-y: auto;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    padding: 1em;
                    width: 105%;
                    position: relative;
                    left: -5%;
                }
                
                #gallery {
                    padding-top: 106rem;
                }
                
                .slideshow-container {
                    max-width: 1000px;
                    position: relative;
                    margin: auto;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    width: 285px;
                    left: -23px;
                }
                
                .image-header {
                    position: absolute;
                    top: 1.4em;
                    left: 14%;
                    font-size: 1.5em;
                    font-weight: 300;
                    color: grey;
                    border: 2px solid white;
                    width: 72%;
                    background: white;
                    opacity: 1;
                    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
                }
            }
            
            @media screen and (min-width: 768px) and (max-width: 900px){
                .fixed-side-nav {
                    position: fixed;
                    height: 79%;
                    width: 30%;
                    left: 2%;
                    background: white;
                    top: 15%;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    max-width: 300px;
                }
                
                .main-section {
                    position: absolute;
                    width: 64%;
                    left: 34%;
                    background: white;
                    top: 15%;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                }
                
                .feedback {
                    position: fixed;
                    width: 16em;
                    bottom: 3em;
                }
                
                footer {
                    background: #000000;
                    background: -webkit-linear-gradient(to left, #000000 , #434343);
                    background: linear-gradient(to left, #000000 , #434343);
                    position: relative;
                    top: 221em;
                }
                
                .price .header {
                    background-color: #111;
                    color: white;
                    font-size: 20px;
                }
                
                .price .grey {
                    background-color: #eee;
                    font-size: 14px;
                }
                
                .columns {
                    float: left;
                    width: 33.3%;
                    padding: 3px;
                }
                
                .image-header {
                    position: absolute;
                    top: 4em;
                    left: 18%;
                    font-size: 2em;
                    font-weight: 300;
                    color: darkgrey;
                    border: 2px solid white;
                    width: 63%;
                    background: white;
                    opacity: 1;
                    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
                }
            }
        </style>
    </head>
    <body class="gradient" style="margin-top: 1px;">
        
        <!-- Navigation
        ================================================== -->

        <nav class="navigation-bar gradient" onmouseover="hideName('#image-header');">
            <a href="./index.php" class="brand-logo logo1 left"><img style="height: 40px;" src="img/logo1.png" /></a>
            <span class="menu-icon" id="menu-icon" onclick="mobileNavBar();"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></span>
            <div class="nav-wrapper">
                <ul class="right hide-on-med-and-down">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="#">About us</a></li>
                </ul>
                <div class="mobile-nav-bar gradient">
                    <div class="row center-align" style="margin-bottom: -10px">
                        <a class="mobile-nav-bar-options" href="./index.php">Home</a>
                    </div>
                    <div class="row center-align" style="margin-top: -10px;margin-bottom: -10px;">
                        <a class="mobile-nav-bar-options" href="#">About us</a>
                    </div>
                </div>
            </div>
        </nav>
        
        <section class="fixed-side-nav hide-on-small-only" onmouseover="hideName('#image-header');">        
          <div class="row">
            <div class="col hide-on-small-only m3 l2">
              <ul class="section table-of-contents">
                <li class="table-of-contents-inner"><a href="#introduction">About Ronnie's Driving school</a></li>
                <li class="table-of-contents-inner"><a href="#structure">About Owner</a></li>
                <li class="table-of-contents-inner"><a href="#initialization">Packages</a></li>
                <li class="table-of-contents-inner"><a href="#gallery">Gallery</a></li>
                <li class="table-of-contents-inner"><a href="#comments">Comments</a></li>
              </ul>
              <div class="row feedback">
                <div class="input-field col s12">
                  <input id="first_name" type="text" class="validate">
                  <label for="first_name">Give us your feedback!</label>
                </div>  
              </div>
            </div>
          </div>
        </section>
        
        <section class="main-section">
            <div class="row">
                <div class="s12 m9 item-img" onmouseover="showName('#image-header');">
                    <img src="img/School.jpg" style="width: 100%;"/>
                    <div class="image-header"  id="image-header"><p>Ronnie's Driving School</p></div>
                </div>
                <div class="col s12 mm9 l12" onmouseover="hideName('#image-header');">
                  <div id="introduction" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">About Ronnie's Driving School</h2>
                    <p>Road safety is a key concern area for both the Government and the people on Indian roads. Safe driving today requires a higher level of confidence and competence, given the poor traffic planning, increasing number of vehicles, lack of professionalism in driving and untrained drivers on road. In a bid to address these issues, Maruti Suzuki India Ltd. has launched Maruti Driving School — its initiative for promoting safe driving.

                    MDS not just imparts better driving skills but also tries to inculcate safe driving culture through special theoretical sessions for behavioural training and road sense. The school was the first to introduce advanced driving training simulator for better judgment and concept of route maps for holistic on-road practice. </p>
                  </div>

                  <div id="structure" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">About Owner</h2>
                    <p>Ronnie's driving school is owned by Mr. Ronnie Hira.</p>
                    <p>This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.</p>
                  </div>

                  <div id="initialization" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">Packages</h2>
                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">Truck/ Big vehicles</li>
                        <li class="grey">Rs. 11000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>

                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">SUV</li>
                        <li class="grey">Rs. 7000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>

                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">Cars/ Small vehicles</li>
                        <li class="grey">Rs. 4000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>
                  </div>
                    
                  <div id="gallery" class="section scrollspy move-right">
                    
                    <h2 class="scrollspy-header">Gallery</h2>
                    <div class="slideshow-container">

                    <div class="mySlides fade">
                      <div class="numbertext">1 / 3</div>
                      <img src="img/beautiful.jpg" style="width:100%">
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">2 / 3</div>
                      <img src="img/driving-1.jpg" style="width:100%">
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">3 / 3</div>
                      <img src="img/license.jpg" style="width:100%">
                    </div>

                    </div>
                    <br>

                    <div style="text-align:center">
                      <span class="dot"></span> 
                      <span class="dot"></span> 
                      <span class="dot"></span> 
                    </div>
                  
                  </div>
                    
                  <div id="comments" class="section scrollspy move-right">
                     <h2 class="scrollspy-header">Comments</h2>
                     <div class="row">
                        <div class="input-field col s12">
                          <input id="" type="text" class="validate" placeholder="Post a comment...">
                        </div> 
                     </div>
                     <div class="comment-section gradient">
                        <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div>
                         <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div>
                         <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div> 
                     </div>
                  </div>
                </div>
            </div>
        </section>
        
        <footer>
            <div class="row" style="margin-bottom: 0;">
                <div class="col l1 m1"></div>
                <div class="col s12 m4 l4 footer-p">
                    <div class="footer-p1"><p>© drivigo 2016.</p></div>
                    <div class="footer-p2"><p>Designed & developed by Sarang Kartikey & Sarfraz Ahmad, exclusively for Drivigo Pvt. Ltd. </p></div>
                </div>
            </div>
        </footer>
        
        <script>
            var slideIndex = 0;
            showSlides();

            function showSlides() {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                for (i = 0; i < slides.length; i++) {
                   slides[i].style.display = "none";  
                }
                slideIndex++;
                if (slideIndex> slides.length) {slideIndex = 1}    
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active_dot", "");
                }
                slides[slideIndex-1].style.display = "block";  
                dots[slideIndex-1].className += " active_dot";
                setTimeout(showSlides, 2000); // Change image every 2 seconds
            }
        </script>
    </body>
>>>>>>> 901ddf06232e0147c503e664c1da1767e3b2ce8f
=======
<!DOCTYPE html>
<html>
    <head>
        <title>Drivingo, version 1.0</title>
        <link rel="stylesheet" href="materialize/css/materialize.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script> 
        <script src="materialize/js/materialize.min.js"></script>
        
        <script>
            $(document).ready(function(){
                $('.scrollspy').scrollSpy();
                $('.mobile-nav-bar').hide();
                $('#image-header').hide();
            });
            
            function mobileNavBar(){
                $('.mobile-nav-bar').slideToggle('slow');
            }
            
            function showName(id){
                $(id).show('slow');
            }
            
            function hideName(id){
                $(id).hide('fast');
            }
        </script>
        
        <style>
            .gradient{
                background: #C04848; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        
            }
            
            .fixed-side-nav{
                position: fixed;
                height: 79%;
                width: 300px;
                left: 5%;
                background: white;
                top: 15%;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }
            
            .main-section{
                position: absolute;
                width: 71%;
                left: 27%;
                background: white;
                top: 15%;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }
            
            .table-of-contents-inner{
                width: 18em;
            }
            
            * {
                box-sizing: border-box;
            }

            .columns {
                float: left;
                width: 33.3%;
                padding: 8px;
            }

            .price {
                list-style-type: none;
                border: 1px solid #eee;
                margin: 0;
                padding: 0;
                -webkit-transition: 0.3s;
                transition: 0.3s;
            }

            .price:hover {
                box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
            }

            .price .header {
                background-color: #111;
                color: white;
                font-size: 25px;
            }

            .price li {
                border-bottom: 1px solid #eee;
                padding: 20px;
                text-align: center;
            }

            .price .grey {
                background-color: #eee;
                font-size: 20px;
            }

            .button {
                background-color: #4CAF50;
                border: none;
                color: white;
                padding: 10px 25px;
                text-align: center;
                text-decoration: none;
                font-size: 18px;
            }

            @media only screen and (max-width: 600px) {
                .columns {
                    width: 100%;
                }
            }
            
            
            .mySlides {display:none}

            /* Slideshow container */
            .slideshow-container {
              max-width: 1000px;
              position: relative;
              margin: auto;
              box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }

            /* Caption text */
            .text {
              color: #f2f2f2;
              font-size: 15px;
              padding: 8px 12px;
              position: absolute;
              bottom: 8px;
              width: 100%;
              text-align: center;
            }

            /* Number text (1/3 etc) */
            .numbertext {
              color: #f2f2f2;
              font-size: 12px;
              padding: 8px 12px;
              position: absolute;
              top: 0;
            }

            /* The dots/bullets/indicators */
            .dot {
              height: 13px;
              width: 13px;
              margin: 0 2px;
              background-color: #bbb;
              border-radius: 50%;
              display: inline-block;
              transition: background-color 0.6s ease;
            }

            .active_dot {
              background-color: #717171;
            }

            /* Fading animation */
            .fade {
              -webkit-animation-name: fade;
              -webkit-animation-duration: 1.5s;
              animation-name: fade;
              animation-duration: 1.5s;
            }

            @-webkit-keyframes fade {
              from {opacity: .4} 
              to {opacity: 1}
            }

            @keyframes fade {
              from {opacity: .4} 
              to {opacity: 1}
            }

            /* On smaller screens, decrease text size */
            @media only screen and (max-width: 300px) {
              .text {font-size: 11px}
            }
            
            #gallery{
                padding-top: 33rem;
            }
            
            input:not([type]), input[type="text"], input[type="password"], input[type="email"], input[type="url"], input[type="time"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="tel"], input[type="number"], input[type="search"], textarea.materialize-textarea {
                background-color: transparent;
                border: none;
                border-bottom: 3px solid #490147;
                border-radius: 0;
                outline: none;
                height: 3rem;
                width: 100%;
                font-size: 1rem;
                margin: 0 0 20px 0;
                padding: 0;
                box-shadow: none;
                box-sizing: content-box;
                transition: all 0.3s;
            }
            
            .scrollspy-header{
                font-weight: 100;
                color: grey;
            }
            
            .move-right{
                padding-left: 1rem;
            }
            
            .comment-by{
                font-size: 1.2em;
                font-weight: 300;
                color: grey;
            }
            
            .comment-section{
                height: 400px;
                overflow-y: auto;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                padding: 1em;
            }
            
            .comment-body{
                color: white;
            }
            
            .feedback{
                position: fixed;
                width: 19em;
                bottom: 3em;
            }
            
            .navigation-bar{
                position: fixed;
                top: 0;
                overflow: hidden;
                width: 100%;
                z-index: 100;
            }

            .menu-icon{
                display: none;
            }

            .mobile-nav-bar{
                display: none;
            }

            .logo1{
                top: 8px;
                left: 10px;
            } 
            
            .footer-p{
                color: white;
            }
            
            footer{
                background: #000000; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #000000 , #434343); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #000000 , #434343); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                position: relative;
                top: 228em;
            }
            
            .item-img {
              position: relative;
              overflow: hidden;
              width: 100%;
            }
            .item-img img {
              max-width: 100%;

              -moz-transition: all 0.3s;
              -webkit-transition: all 0.3s;
              transition: all 0.3s;
            }
            .item-img:hover img {
              -moz-transform: scale(1.1);
              -webkit-transform: scale(1.1);
              transform: scale(1.1);
              opacity: .8;
            }
            
            .image-header{
                position: absolute;
                top: 4em;
                left: 21%;
                font-size: 4em;
                font-weight: 200;
                color: darkgrey;
                border: 2px solid white;
                width: 56%;
                background: white;
                opacity: 1;
                box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
            }
            
            .image-header p{
                padding-left: 1em;
                padding-right: 1em;
            }
            
            @media screen and (max-width: 768px){
                
                .main-section{
                    position: absolute;
                    width: 90%;
                    left: 5%;
                    background: white;
                    top: 15%;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                }
                
                .scrollspy-header{
                    font-weight: 200;
                    font-size: 2em;
                }
                
                .columns{
                    width: 111%;
                    position: relative;
                    left: -8%;
                }
                
                .menu-icon{
                    display: block;
                    position: relative;
                    left: 85%;
                    top: 8px;
                }

                .menu-icon:hover{
                    cursor: pointer;
                }

                .mobile-nav-bar{
                    display: block;
                    z-index: 2;
                    position: fixed;
                    top: 55px;
                    width: 100%;
                    color: white;
                    height: 100px;
                }

                .mobile-nav-bar-options{
                    color: white;
                    font-weight: 400;
                }

                .mobile-nav-bar-options:hover{
                    color: white;
                    font-weight: 200;
                }
                
                footer{
                    background: #000000; /* fallback for old browsers */
                    background: -webkit-linear-gradient(to left, #000000 , #434343); /* Chrome 10-25, Safari 5.1-6 */
                    background: linear-gradient(to left, #000000 , #434343); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                    position: relative;
                    top: 300em;
                }
                
                .comment-section {
                    height: 400px;
                    overflow-y: auto;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    padding: 1em;
                    width: 105%;
                    position: relative;
                    left: -5%;
                }
                
                #gallery {
                    padding-top: 106rem;
                }
                
                .slideshow-container {
                    max-width: 1000px;
                    position: relative;
                    margin: auto;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    width: 285px;
                    left: -23px;
                }
                
                .image-header {
                    position: absolute;
                    top: 1.4em;
                    left: 14%;
                    font-size: 1.5em;
                    font-weight: 300;
                    color: grey;
                    border: 2px solid white;
                    width: 72%;
                    background: white;
                    opacity: 1;
                    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
                }
            }
            
            @media screen and (min-width: 768px) and (max-width: 900px){
                .fixed-side-nav {
                    position: fixed;
                    height: 79%;
                    width: 30%;
                    left: 2%;
                    background: white;
                    top: 15%;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    max-width: 300px;
                }
                
                .main-section {
                    position: absolute;
                    width: 64%;
                    left: 34%;
                    background: white;
                    top: 15%;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                }
                
                .feedback {
                    position: fixed;
                    width: 16em;
                    bottom: 3em;
                }
                
                footer {
                    background: #000000;
                    background: -webkit-linear-gradient(to left, #000000 , #434343);
                    background: linear-gradient(to left, #000000 , #434343);
                    position: relative;
                    top: 221em;
                }
                
                .price .header {
                    background-color: #111;
                    color: white;
                    font-size: 20px;
                }
                
                .price .grey {
                    background-color: #eee;
                    font-size: 14px;
                }
                
                .columns {
                    float: left;
                    width: 33.3%;
                    padding: 3px;
                }
                
                .image-header {
                    position: absolute;
                    top: 4em;
                    left: 18%;
                    font-size: 2em;
                    font-weight: 300;
                    color: darkgrey;
                    border: 2px solid white;
                    width: 63%;
                    background: white;
                    opacity: 1;
                    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
                }
            }
        </style>
    </head>
    <body class="gradient" style="margin-top: 1px;">
        
        <!-- Navigation
        ================================================== -->

        <nav class="navigation-bar gradient" onmouseover="hideName('#image-header');">
            <a href="./index.php" class="brand-logo logo1 left"><img style="height: 40px;" src="img/logo1.png" /></a>
            <span class="menu-icon" id="menu-icon" onclick="mobileNavBar();"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></span>
            <div class="nav-wrapper">
                <ul class="right hide-on-med-and-down">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="#">About us</a></li>
                </ul>
                <div class="mobile-nav-bar gradient">
                    <div class="row center-align" style="margin-bottom: -10px">
                        <a class="mobile-nav-bar-options" href="./index.php">Home</a>
                    </div>
                    <div class="row center-align" style="margin-top: -10px;margin-bottom: -10px;">
                        <a class="mobile-nav-bar-options" href="#">About us</a>
                    </div>
                </div>
            </div>
        </nav>
        
        <section class="fixed-side-nav hide-on-small-only" onmouseover="hideName('#image-header');">        
          <div class="row">
            <div class="col hide-on-small-only m3 l2">
              <ul class="section table-of-contents">
                <li class="table-of-contents-inner"><a href="#introduction">About Ronnie's Driving school</a></li>
                <li class="table-of-contents-inner"><a href="#structure">About Owner</a></li>
                <li class="table-of-contents-inner"><a href="#initialization">Packages</a></li>
                <li class="table-of-contents-inner"><a href="#gallery">Gallery</a></li>
                <li class="table-of-contents-inner"><a href="#comments">Comments</a></li>
              </ul>
              <div class="row feedback">
                <div class="input-field col s12">
                  <input id="first_name" type="text" class="validate">
                  <label for="first_name">Give us your feedback!</label>
                </div>  
              </div>
            </div>
          </div>
        </section>
        
        <section class="main-section">
            <div class="row">
                <div class="s12 m9 item-img" onmouseover="showName('#image-header');">
                    <img src="img/School.jpg" style="width: 100%;"/>
                    <div class="image-header"  id="image-header"><p>Ronnie's Driving School</p></div>
                </div>
                <div class="col s12 mm9 l12" onmouseover="hideName('#image-header');">
                  <div id="introduction" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">About Ronnie's Driving School</h2>
                    <p>Road safety is a key concern area for both the Government and the people on Indian roads. Safe driving today requires a higher level of confidence and competence, given the poor traffic planning, increasing number of vehicles, lack of professionalism in driving and untrained drivers on road. In a bid to address these issues, Maruti Suzuki India Ltd. has launched Maruti Driving School — its initiative for promoting safe driving.

                    MDS not just imparts better driving skills but also tries to inculcate safe driving culture through special theoretical sessions for behavioural training and road sense. The school was the first to introduce advanced driving training simulator for better judgment and concept of route maps for holistic on-road practice. </p>
                  </div>

                  <div id="structure" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">About Owner</h2>
                    <p>Ronnie's driving school is owned by Mr. Ronnie Hira.</p>
                    <p>This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.This will contain all the relevant information about the owner whatever he/she wants to share.</p>
                  </div>

                  <div id="initialization" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">Packages</h2>
                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">Truck/ Big vehicles</li>
                        <li class="grey">Rs. 11000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>

                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">SUV</li>
                        <li class="grey">Rs. 7000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>

                    <div class="columns">
                      <ul class="price">
                        <li class="header gradient">Cars/ Small vehicles</li>
                        <li class="grey">Rs. 4000</li>
                        <li>4 hours per day.</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li>other detail</li>
                        <li class="grey"><a href="#" class="button gradient">Purchase</a></li>
                      </ul>
                    </div>
                  </div>
                    
                  <div id="gallery" class="section scrollspy move-right">
                    
                    <h2 class="scrollspy-header">Gallery</h2>
                    <div class="slideshow-container">

                    <div class="mySlides fade">
                      <div class="numbertext">1 / 3</div>
                      <img src="img/beautiful.jpg" style="width:100%">
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">2 / 3</div>
                      <img src="img/driving-1.jpg" style="width:100%">
                    </div>

                    <div class="mySlides fade">
                      <div class="numbertext">3 / 3</div>
                      <img src="img/license.jpg" style="width:100%">
                    </div>

                    </div>
                    <br>

                    <div style="text-align:center">
                      <span class="dot"></span> 
                      <span class="dot"></span> 
                      <span class="dot"></span> 
                    </div>
                  
                  </div>
                    
                  <div id="comments" class="section scrollspy move-right">
                     <h2 class="scrollspy-header">Comments</h2>
                     <div class="row">
                        <div class="input-field col s12">
                          <input id="" type="text" class="validate" placeholder="Post a comment...">
                        </div> 
                     </div>
                     <div class="comment-section gradient">
                        <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div>
                         <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div>
                         <div class="row">
                            <span class="comment-by">Sarang Kartikey</span>
                            <p class="comment-body">This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. This is a very good school. </p>
                        </div> 
                     </div>
                  </div>
                </div>
            </div>
        </section>
        
        <footer>
            <div class="row" style="margin-bottom: 0;">
                <div class="col l1 m1"></div>
                <div class="col s12 m4 l4 footer-p">
                    <div class="footer-p1"><p>© drivigo 2016.</p></div>
                    <div class="footer-p2"><p>Designed & developed by Sarang Kartikey & Sarfraz Ahmad, exclusively for Drivigo Pvt. Ltd. </p></div>
                </div>
            </div>
        </footer>
        
        <script>
            var slideIndex = 0;
            showSlides();

            function showSlides() {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                for (i = 0; i < slides.length; i++) {
                   slides[i].style.display = "none";  
                }
                slideIndex++;
                if (slideIndex> slides.length) {slideIndex = 1}    
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active_dot", "");
                }
                slides[slideIndex-1].style.display = "block";  
                dots[slideIndex-1].className += " active_dot";
                setTimeout(showSlides, 2000); // Change image every 2 seconds
            }
        </script>
    </body>
>>>>>>> sarangkartikey50
</html>