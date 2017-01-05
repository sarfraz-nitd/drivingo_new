<?php 
session_start();

    if(isset($_SESSION['activated'])){
        echo 'Your Account has been activated Successfully';
        unset($_SESSION['activated']);
    }

   if(isset($_POST['logout']))   {session_destroy(); }

 
?>
<!DOCTYPE html>
<html>
    <head>
        
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drivingo, version 1.0</title>
        <link rel="stylesheet" href="materialize/css/materialize.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/index.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJh5axYNsWa63hSjco7pySOpX-IJsZ7SM" type="text/javascript"></script>
        
        <!-- javascript portion -->
        
        <script>
            
            var curLat, curLng, schoolLat, schoolLng;
            
            $(document).ready(function (){
                $('.carousel.carousel-slider').carousel({full_width: true});
                setInterval(slideImage, 3000);
                
                var screenHeight = window.innerHeight;
                $('#main-carousel').attr("style","height:"+screenHeight+"px;");
                
                
                $('.mobile-nav-bar').hide();
                $('#driving-school').hide();
                $('#user').hide();
                
                var inputAddress = document.getElementById('address');
                inputAddress.addEventListener('keydown', function(event){
                    if(event.keyCode == 13){
                        getCoordinates();
                    }   
                });
                
                $('.modal').modal();
                $('.tooltipped').tooltip({delay: 50});
            
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
            
            function verifyAddress(){
                var schoolAddress = $('#school_address').val();
                shoolLocation(schoolAddress);
            }
            
            function shoolLocation(schoolAddress){
                var geocoder = new google.maps.Geocoder();

                if(schoolAddress.length){
                      geocoder.geocode({'address': schoolAddress}, function(results, status) {
                      if (status === 'OK') {                      
                        schoolLat = results[0].geometry.location.lat();
                        schoolLng = results[0].geometry.location.lng();
                        
                        $('#schoolLat').val(schoolLat);
                        $('#schoolLng').val(schoolLng);
                    
                        $('#schoolHiddenBtn').click();
                          
                      } else {
                        alert('Unable to fetch the location: ' + status + ' please provide valid address!');
                      }
                    });
                } else {
                    alert('please enter any location!');
                }
            }
            
        </script>
        
        
        <!-- styling portion -->
        
        <style>
            .alert-modal-data{
                font-size: 2em;
                font-weight: 300;
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
                      <span class="location-icon tooltipped" data-position="bottom" data-delay="50" data-tooltip="current location" onclick="currentLocation()"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                    </div>  
                  </div>  
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
                 <form method="post" action="index.php">
                    <ul class="right hide-on-med-and-down">
                        <li><a href="#register-section">Register</a></li>
                        <li><a href="#">About us</a></li>
                         <?php if(isset($_SESSION['loggedin'])){
                          ?>
                              <li><input type="submit" value="<?php echo 'Hi, '.$_SESSION['loggedin'].' | LogOut';?> " name="logout" /></li>
                           <?php
                         }else{
                            ?>
                                  <li><a class="waves-effect waves-light btn grey-gradient-left" data-target="modal1" onclick="signInModal();">Sign in</a></li>

                          <?php
                         }?>
                    </ul>
                    </form>
                    <div class="mobile-nav-bar">
                        <div class="row center-align" style="margin-bottom: -10px">
                            <a class="mobile-nav-bar-options" href="#register-section">Register</a>
                        </div>
                        <div class="row center-align" style="margin-top: -10px;margin-bottom: -10px;">
                            <a class="mobile-nav-bar-options" href="#">About us</a>
                        </div>
                        <?php if(isset($_SESSION['loggedin'])){
                          ?>
                              <div class="row center-align" style="margin-top: -10px">
                                <form method="post" action="index.php"><li><input type="submit" value="<?php echo 'Hi, '.$_SESSION['loggedin'].' | LogOut';?> " name="logout1" /></li></form>
                              </div>
                          <?php
                         }else{
                            ?>
                             <div class="row center-align" style="margin-top: -10px">
                               <a class="waves-effect waves-light btn grey-gradient-left" onclick="signInModal();">Sign in</a>
                             </div>
                         <?php
                         }?>
                    </div>
                </div>
            </nav>
            
        </section>
<?php if(!isset($_SESSION['loggedin'])){ ?>
        
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
		    
		    <!--Driving School form starts here -->
                        <form class="col s12" method="POST" action="reg_schools.php">
			
                          <div class="row">
                            <div class="input-field col s12">
                              <input placeholder="Owner's Name" id="first_name" name="o_name" type="text" class="validate" required>
                            </div>
                          </div>
			  
			   <div class="row">
                            <div class="input-field col s12">
                              <input placeholder="School Name" id="d_school_name" name="d_school_name" type="text" class="validate" required>
                            </div>
                          </div>
			  
			 <div class="row">
                            <div class="input-field col s12">
                              <input id="email" placeholder="Email" name="d_email" type="email" class="validate" required>
                            </div>
                          </div>
			  
			      <div class="row">
                            <div class="input-field col s12">
                              <input id="email" placeholder="Phone" name="d_phone" type="tel" class="validate" required>
                            </div>
                          </div>
                        
			  
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Password" name="d_password" type="password" class="validate" required>
                            </div>
                          </div>
			  
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Confirm Password" name="d_confirm_password" type="password" class="validate" required>
                            </div>
                          </div>
                      
			 
                          <div class="row">
                            <div class="input-field col s12">
                              <textarea id="textarea1" class="materialize-textarea" name="d_about" placeholder="Tell us about your driving school."></textarea>
                            </div>
                          </div>
			  
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="school_address" placeholder="Address" type="text" name="d_address" class="validate" required>
                            </div>
                          </div>
			  
                          <div class="row" style="margin-left: 0;">
                            <p class="service_header">Services provided</p>
                            <p>
                              <input type="checkbox" id="test5" name="services[]" value="Cars" />
                              <label class="checkbox_label" for="test5">CARS</label>
                            </p>
                            <p>
                              <input type="checkbox" id="test6" name="services[]" value="SUVs"/>
                              <label class="checkbox_label" for="test6">SUVS</label>
                            </p>
                            <p>
                              <input type="checkbox" id="test7" name="services[]" value="Trucks"/>
                              <label class="checkbox_label" for="test7">TRUCKS</label>
                            </p>  
                          </div>
			  
                          <div class="row">
                            <div class="file-field input-field">
                              <div class="btn file_btn">
                                <span>Cover photo</span>
                                <input type="file" name="d_cover_photo">
                              </div>
                              <div class="file-path-wrapper">
                                <input class="file-path validate" style="border-left: none;border-top: none;" type="text">
                              </div>
                            </div>  
                          </div>
                            
                          <input type="hidden" id="schoolLat" name="lat" value="">
                          <input type="hidden" id="schoolLng" name="lng" value="">
			  
                          <div class="row center-align">
                            <input type="button" onclick="verifyAddress();" value="Submit" class="btn btn-large file_btn">  
                          </div>
                            <input type="submit" id="schoolHiddenBtn" name="reg_d_school" class="hide">
                        </form>
                      </div>
                </div>
		
		<!--User registretion-->
<div class="register-user grey-gradient-left" id="user">
                    <div class="row register-user-inner">
		    
                        <form class="col s12" method="POST" action="reg_users.php">
                          <div class="row">
                            <div class="input-field col s12">
                              <input placeholder="Name" id="first_name" type="text" class="validate" name="u_name" required/>
                            </div>
                          </div>
			  <div class="row">
                            <div class="input-field col s12">
                              <input placeholder="Phone" id="first_name" type="text" class="validate" name="u_phone" required/>
                            </div>
                          </div>
			  
			   <div class="row">
                            <div class="input-field col s12">
                              <input id="email" placeholder="Email" type="email" class="validate" name="u_email" required/>
                            </div>
                          </div>
                         
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Password" type="password" class="validate" name="u_pass" required/>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password" placeholder="Confirm Password" type="password" class="validate" name="u_cpass" required/>
                            </div>
                          </div>
			 <!--div class="row">
                            <div class="input-field col s12">
                              <input  type="radio"  name="gender" value="Male" > Male
                              <input  type="radio"  name="gender" value="Female" >Female
                            </div>
                          </div-->
			     <div class="row center-align">
				    <input type="submit" value="Submit" class="btn btn-large file_btn" name="reg_user"/>  
				</div>
                             
                        
                        </form>
                      </div>
                </div>
            </div>
        </section>
        
<?php }?>
        
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
                        <div class="col m5"></div>
                        <div class="col m6">
                            <p style="float: left;margin-right: 2em; font-weight: 400;">
                                <input name="group1" type="radio" id="test15" />
                                <label for="test15">As a user</label>
                            </p>
                            <p style="float: left; font-weight: 400;">
                                <input name="group1" type="radio" id="test16" />
                                <label for="test16">As a school</label>
                            </p>
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
        
        <!-- Modal Structure -->
          <div id="modal2" class="modal">
            <div class="modal-content" style="background: #FAFAFA;">
              <div class="alert-modal-data" id="alert-modal-data"><p class="center-align">A bunch of text</p></div>
            </div>
            <div class="modal-footer">
              <a class=" modal-action modal-close waves-effect waves-green btn-flat">close</a>
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