<!DOCTYPE html>
<html>
    <head>
        <title>Drivingo, version 1.0</title>
        <link rel="stylesheet" href="materialize/css/materialize.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJh5axYNsWa63hSjco7pySOpX-IJsZ7SM" type="text/javascript"></script>
        
        <!-- javascript portion -->
        
        <script>
            
            var curLat, curLng;
            
            $(document).ready(function (){
                $('.carousel.carousel-slider').carousel({full_width: true});
                setInterval(slideImage, 3000);
                
                var screenHeight = window.innerHeight;
                $('#main-carousel').attr("style","height:"+screenHeight+"px;");
                
                
                $('.mobile-nav-bar').hide();
                $('#driving-school').hide();
                $('#user').hide();
                $('.modal').modal();
            });
            
            function slideImage(){
                $('.carousel').carousel('next');
            }
            
            function mobileNavBar(){
                $('.mobile-nav-bar').slideToggle('slow');
            }
            
            function showRegistrationForm(id){
                
                if(id == "#user"){
                    $('#driving-school').hide();
                } else {
                    $('#user').hide();
                }
                
                $(id).slideToggle('slow');    
            }
            
            function signInModal(){
                $('#modal1').openModal('open');
            }
            
            function currentLocation(){
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(function(position) {
                    
                    curLat = position.coords.latitude;
                    curLng = position.coords.longitude;
                      
                    $('#lat').val(curLat);
                    $('#lng').val(curLng);
                    $('#submitHiddenForm').click();

                  }, function() {
                    alert('unable to fetch your location!');
                  });
                } else {
                  // Browser doesn't support Geolocation
                  alert('your browser does not support geolocation!');
                }
            }
            
            function getCoordinates(){
                var geocoder = new google.maps.Geocoder();
                var address = document.getElementById('address').value;
                if(address.length){
                      geocoder.geocode({'address': address}, function(results, status) {
                      if (status === 'OK') {                      
                        curLat = results[0].geometry.location.lat();
                        curLng = results[0].geometry.location.lng();
                        
                        $('#lat').val(curLat);
                        $('#lng').val(curLng);
                        $('#submitHiddenForm').click();
                          
                      } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                      }
                    });
                } else {
                    alert('please enter any location!');
                }
            }
            
        </script>
        
        
        <!-- styling portion -->
        
        <style>
            .carousel-item-one{
                background: url("img/beautiful.jpg") no-repeat top;
                background-size: cover;
            }
            
            .carousel-item-two{
                background: url("img/license.jpg") no-repeat top;
                background-size: cover;
            }
            
            .carousel-item-three{
                background: url("img/key.jpg") no-repeat top;
                background-size: cover;
            }
            
            .carousel-item-four{
                background: #616161 url("img/School.jpg") no-repeat top;
                background-size: cover;
            }
            
            .navigation-bar{
                position: fixed;
                top: 0;
                overflow: hidden;
                width: 100%;
                z-index: 100;
            }
            
            nav{
                background-color: transparent;
            }
            
            .carousel-item-inner{
                position: relative;
                top: 20%;
                z-index: 1;
            }
            
            .carousel-item-header{
                font-size: 5em;
                font-weight: 300;
                margin-bottom: 0;
            }
            
            .carousel-item-subheader{
                font-size: 3em;
                font-weight: 100;
                margin-top: 0;
            }
            
            .register-input{
                background-color: transparent;
                border: none;
                border: 2px solid grey;
                border-radius: 0;
                outline: none;
                height: 3rem;
                width: 100%;
                font-size: 1.5rem;
                font-weight: 200;
                margin: 0 0 20px 0;
                padding-left: 10px;
                box-shadow: none;
                box-sizing: content-box;
                transition: all 0.3s;
                color: grey;
            }
            
            input:not([type]), input[type="text"], input[type="password"], input[type="email"], input[type="url"], input[type="time"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="tel"], input[type="number"], input[type="search"], textarea.materialize-textarea {
                background-color: transparent;
                border: none;
                border: 2px solid #fff;
                border-radius: 0;
                outline: none;
                height: 3rem;
                width: 100%;
                font-size: 1.5rem;
                font-weight: 200;
                margin: 0 0 20px 0;
                padding-left: 10px;
                box-shadow: none;
                box-sizing: content-box;
                transition: all 0.3s;
                color: #fff;
            }
            
            
            ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
              color: #fff;
            }
            ::-moz-placeholder { /* Firefox 19+ */
              color: #fff;
            }
            :-ms-input-placeholder { /* IE 10+ */
              color: #fff;
            }
            :-moz-placeholder { /* Firefox 18- */
              color: #fff;
            }
            
            
            .location-icon{
                float: right;
                position: relative;
                top: -64px;
                font-size: 1.7em;
                color: white;
                margin-right: 8px;
                cursor: pointer;
            }
            
            .menu-icon{
                display: none;
            }
            
            .mobile-nav-bar{
                display: none;
            }
            
            .register-section{
                height: 100%;
                position: relative;
                margin-bottom: 0em;
                padding-top: 1px;
                padding-bottom: 40px;
            }
            
            .register-section-header{
                font-weight: 100;
                font-size: 5em;
                color: #500548;
            }
            
            .register-section-row1{
                position: relative;
                top: -55px;
            }
            
            .btn-register{
                border-radius: 40px;
            }
            
            .pipe{
                font-size: 2em;
                font-weight: 100;
                margin-right: 1em;
            }
            
            
            .grey-gradient-left{
                background: #C04848; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        
            }
            
            .grey-gradient-right{
                background: #C04848; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        
            }
            
            .customer-reviews{
                padding-bottom: 60px;
            }
            
            .customer-reviews-inner{
                position: relative;
                top: 55px;
            }  
            
            .customer-reviews-slider{
                width: 80%;
                position: relative;
                left: 10%;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }
            
            .carousel.carousel-slider .carousel-item p{
                font-size: inherit;
            }
            
            .review-heading{
                font-size: 3em;
                font-weight: 100;
            }
            
            .review-body{
                font-size: 1.5em;
                font-weight: 100;
                margin-top: -35px;
            }
            
            .reviewer-name{
                font-size: 1.3em;
                font-weight: 100;
            }
            
            .register-section-outer{
                background: white;
                box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            }
            
            .customer-reviews-header{
                font-size: 3em;
                font-weight: 100;
                text-align: center;
                color: white;
                padding-top: 1px;
            }
            
            .footer-p{
                color: white;
            }
            
            footer{
                background: #000000; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #000000 , #434343); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #000000 , #434343); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            }
            
            .register-driving-school-inner{
                width: 80%;position: relative; left: 10%;padding:3em; padding-bottom: 1em;
            }
            
            .register-user-inner{
                width: 80%;position: relative; left: 10%;padding:3em; padding-bottom: 1em;
            }
            
            .modal {
                display: none;
                position: fixed;
                left: 0;
                right: 0;
                padding: 0;
                max-height: 70%;
                background-color: grey;
                width: 55%;
                margin: auto;
                overflow-y: auto;
                border-radius: 2px;
                will-change: top, opacity;
            }
            
            .logo1{
                top: 8px;
                left: 10px;
            }            
            
            @media screen and (max-width: 768px){
                .carousel-item-inner{
                    position: relative;
                    top: 10%;
                    z-index: 1;
                }

                .carousel-item-header{
                    font-size: 3em;
                    font-weight: 300;
                    margin-bottom: 0;
                }

                .carousel-item-subheader{
                    font-size: 2em;
                    font-weight: 100;
                    margin-top: 0;
                }
                
                .location-icon{
                    float: right;
                    position: relative;
                    top: -64px;
                    font-size: 1.7em;
                    color: white;
                    margin-right: 8px;
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
                    color: grey;
                    background: white;
                    height: 155px;
                }
                
                .mobile-nav-bar-options{
                    color: grey;
                    font-weight: 400;
                }
                
                .mobile-nav-bar-options:hover{
                    color: #424242;
                    font-weight: 200;
                }
                
                .register-section-header{
                    font-weight: 100;
                    font-size: 3em;
                    color: #500548;
                }
                
                .register-driving-school-inner{
                    width: 100%;position: relative; left: 0%;padding:3em; padding-bottom: 1em;
                }
                
                .register-user-inner{
                    width: 100%;position: relative; left: 0%;padding:3em; padding-bottom: 1em;
                }
                
                .customer-reviews-slider{
                    width: 90%;
                    position: relative;
                    left: 5%;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                }
                
                .customer-reviews-header {
                    font-size: 2em;
                    font-weight: 100;
                    text-align: center;
                    color: white;
                    padding-top: 1px;
                    margin: 0em 1em;
                }
        
            }
        </style>
    </head>
    <body>
        
        <!-- landing page starting section -->
        
        <div class="hide">
            <form action="search.php" method="get">
                <input name="lat" id="lat" value="" type="text"/>
                <input name="lng" id="lng" value="" type="text"/>
                <input id="submitHiddenForm" type="submit" value="post" />
            </form>
        </div>
        
        <section>
            <div class="carousel carousel-slider center" id="main-carousel" data-indicators="true">
                <div class="carousel-item-inner">
                    <h2 class="white-text carousel-item-header">Drivingo</h2>
                    <p class="white-text carousel-item-subheader">Craft your journey.</p>
                </div>
                <div class="carousel-fixed-item center">
                  <div class="row">
                    <div class="col s1 m3 l4"></div>
                    <div class="input-field col s10 m6 l4">
                      <input placeholder="Enter any location..." id="address" type="text" class="validate">
                      <span class="location-icon" onclick="currentLocation()"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                    </div>  
                  </div>  
                  <a class="btn waves-effect white grey-text darken-text-2" onclick="getCoordinates()">Search</a>
                </div>
                <div class="carousel-item carousel-item-one white-text" href="#one!"></div>
                <div class="carousel-item carousel-item-two white-text" href="#two!"></div>
                <div class="carousel-item carousel-item-three white-text" href="#three!"></div>
                <div class="carousel-item carousel-item-four white-text" href="#four!"></div>
            </div>

            <nav class="navigation-bar">
                <a href="#" class="brand-logo logo1 left"><img style="height: 40px;" src="img/logo1.png" /></a>
                <span class="menu-icon" id="menu-icon" onclick="mobileNavBar();"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></span>
                <div class="nav-wrapper">
                    <ul class="right hide-on-med-and-down">
                        <li><a href="#register-section">Register</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a class="waves-effect waves-light btn grey-gradient-left" data-target="modal1" onclick="signInModal();">Sign in</a></li>
                    </ul>
                    <div class="mobile-nav-bar">
                        <div class="row center-align" style="margin-bottom: -10px">
                            <a class="mobile-nav-bar-options" href="#register-section">Register</a>
                        </div>
                        <div class="row center-align" style="margin-top: -10px;margin-bottom: -10px;">
                            <a class="mobile-nav-bar-options" href="#">About us</a>
                        </div>
                        <div class="row center-align" style="margin-top: -10px">
                            <a class="waves-effect waves-light btn grey-gradient-left" onclick="signInModal();">Sign in</a>
                        </div>
                    </div>
                </div>
            </nav>
            
        </section>
        
        <section class="register-section grey-gradient-left" id="register-section">
            <div class="register-section-outer container">
                <div class="row center-align register-section-header">
                    <p style="padding-top: 30px;">REGISTER</p>
                </div>
                <div class="row register-section-row1">
                    <div class="col s2 l3"></div>
                    <div class="col s9 m6 l3">
                        <button class="btn btn-large grey-gradient-left btn-register" onclick="showRegistrationForm('#user');">
                            <span class="right">AS USER</span>
                            <span><i class="fa fa-user-o" aria-hidden="true"></i></span> 
                            <span class="pipe">|</span> 
                        </button>
                    </div>
                    <div class="row hide-on-med-and-up"></div>
                    <div class="col"></div>
                    <div class="col s10 m6 l4">
                        <button class="btn btn-large grey-gradient-left btn-register" onclick="showRegistrationForm('#driving-school');">
                            <span class="right">AS DRIVING SCHOOL</span>
                            <span><i class="fa fa-id-card-o" aria-hidden="true"></i></span> 
                            <span class="pipe">|</span> 
                        </button>
                    </div>
                </div>

                <div class="register-driving-school grey-gradient-left" id="driving-school">
                    <div class="row register-driving-school-inner">
                        <form class="col s12">
                          <div class="row">
                            <div class="input-field col s12">
                              <input placeholder="First Name" id="first_name" type="text" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="last_name" placeholder="Last Name" type="text" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Password" type="password" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Confirm Password" type="password" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="email" placeholder="Email" type="email" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Name of driving school" type="text" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Address" type="text" class="validate">
                            </div>
                          </div>
                        </form>
                      </div>
                </div>

                <div class="register-user grey-gradient-left" id="user">
                    <div class="row register-user-inner">
                        <form class="col s12">
                          <div class="row">
                            <div class="input-field col s12">
                              <input placeholder="First Name" id="first_name" type="text" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="last_name" placeholder="Last Name" type="text" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Password" type="password" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Confirm Password" type="password" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="email" placeholder="Email" type="email" class="validate">
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Address" type="text" class="validate">
                            </div>
                          </div>
                        </form>
                      </div>
                </div>
            </div>
        </section>
        
        
        <section class="customer-reviews grey-gradient-left">
            <div class="customer-reviews-header"><p>What our customers have to say about us</p></div>
            <div class="customer-reviews-slider">
                <div class="carousel carousel-slider center grey-gradient-left" data-indicators="true">
                    <div class="customer-reviews-inner grey-gradient-left">
                        <div class="carousel-item white-text" href="#one!">
                          <div class="review-heading"><p>heading</p></div>
                          <div class="review-body"><p class="white-text">This is the body of the customer review.</p></div>
                          <div class="reviewer-name"><p class="white-text">- <span>name of the customer</span></p></div>
                        </div>
                        <div class="carousel-item customer-reviews-inner white-text" href="#two!">
                          <div class="review-heading"><p>heading</p></div>
                          <div class="review-body"><p class="white-text">This is the body of the customer review.</p></div>
                          <div class="reviewer-name"><p class="white-text">- <span>name of the customer</span></p></div>
                        </div>
                        <div class="carousel-item customer-reviews-inner white-text" href="#three!">
                          <div class="review-heading"><p>heading</p></div>
                          <div class="review-body"><p class="white-text">This is the body of the customer review.</p></div>
                          <div class="reviewer-name"><p class="white-text">- <span>name of the customer</span></p></div>
                        </div>
                        <div class="carousel-item customer-reviews-inner white-text" href="#four!">
                          <div class="review-heading"><p>heading</p></div>
                          <div class="review-body"><p class="white-text">This is the body of the customer review.</p></div>
                          <div class="reviewer-name"><p class="white-text">- <span>name of the customer</span></p></div>
                        </div>
                    </div>    
                </div>
            </div>
        </section>
        
        
      <!-- sign in Structure -->
      <div id="modal1" class="modal bottom-sheet grey-gradient-left">
        <div class="modal-content">
            <div class="row center-align">
                <a href="../facebook_login_with_php/"><button class=" modal-action modal-close waves-effect waves-green btn blue darken-4 fb-btn" type="button">FACEBOOK</button></a>
                <a href="../login-with-google-using-php/"><button class=" modal-action modal-close waves-effect waves-green btn red darken-4 google-btn" type="button">GOOGLE</button></a>
            </div>
            <h5 class="center-align white-text" style="font-weight: 200;">Or</h5>
            <h4 class="center-align white-text" style="font-weight: 200;">Enter your login details.</h4>
            <div class="row">
                <form class="col s12" action="index.php" method="post">
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="loginemail" type="email" class="validate" name="loginemail" placeholder="Email">
                        </div>
                              
                        <div class="input-field col s12 m6">
                            <input id="loginpassword" type="password" class="validate" name="loginpassword" placeholder="Password">
                        </div>
                          
                    </div>
                    <div class="row center-align">
                        <button class=" modal-action modal-close waves-effect waves-green btn login-btn" type="submit">Login</button>
                        <button class="waves-effect modal-close waves-light btn-flat white-text" onclick="openRegisterModal();" type="button">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        
        <footer>
            <div class="row" style="margin-bottom: 0;">
                <div class="col l1 m1"></div>
                <div class="col s12 m4 l4 footer-p">
                    <div class="footer-p1"><p>© drivigo 2016.</p></div>
                    <div class="footer-p2"><p>Designed & developed by Sarang Kartikey & Sarfraz Ahmad, exclusively for Drivigo Pvt. Ltd. </p></div>
                </div>
            </div>
        </footer>
        
        <script src="materialize/js/materialize.min.js"></script>
    </body>
</html>