<?php 
session_start();
require_once('connect.php');
    if(isset($_SESSION['activated'])){
        echo 'Your Account has been activated Successfully';
        unset($_SESSION['activated']);
    }

   if(isset($_POST['logout']))   {session_destroy(); header('Location: index.php');}
      if(isset($_POST['loginbtn'])){
       $lemail = $_POST['loginemail'];
       $lpass = $_POST['loginpassword'];
       $type = $_POST['group1'];
       
      if($type== 'user'){
           $query = "SELECT * FROM `users` WHERE `email` = '$lemail' AND `pass` = '$lpass' ";
      }else{
           $query = "SELECT * FROM `schools` WHERE `email` = '$lemail' AND `pass` = '$lpass' ";
      }

      if($query_run = mysqli_query($mysqli, $query)){
            if(mysqli_num_rows($query_run)==1){
                 while($row = mysqli_fetch_assoc($query_run)){
                  $_SESSION['loggedin'] = $row['id'];
                  $_SESSION['type'] = $type;
     }
            }
      }else{
           echo 'Some Error Occured';
      }
       
   }
 
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

            var myVar;

            

            function myFunction() {
                myVar = setTimeout(showPage, 3000);
            }

            function showPage() {
              $('#loader').hide();
              $('#myDiv').fadeIn('slow');
            }
            
            $(document).ready(function (){
                
$('#myDiv').hide();
                $('.datepicker').pickadate({
                  selectMonths: true, // Creates a dropdown to control month
                  selectYears: 15 // Creates a dropdown of 15 years to control year
                });

                $('.carousel.carousel-slider').carousel({full_width: true});
                setInterval(slideImage, 3000);
                
                var screenHeight = window.innerHeight;
                $('#main-carousel').attr("style","height:"+screenHeight+"px;");

                $('#search_form').attr("style","top:" + (screenHeight*0.05) + "px;");

                if(screenHeight < 768){
                   searchModal();
                }

                
                
                $('.mobile-nav-bar').hide();
                $('#driving-school').hide();
                $('#user').hide();
                
                /*var inputAddress = document.getElementById('address');
                inputAddress.addEventListener('keydown', function(event){
                    if(event.keyCode == 13){
                        alert('hi');
                    }   
                });*/
                
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

            function searchModal(){
                $('#searchModal').openModal('open');
            }
            
            function searchForm(addressId, btnId, dpId, latId, lngId, timeId){
                if($('#'+timeId).val() == ""){
                  alert('please enter time');
                } else {
                    getCoordinates(addressId, btnId, dpId, latId, lngId);
                }
            }

            function currentLocation(id){
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(function(position) {
                    
                    curLat = position.coords.latitude;
                    curLng = position.coords.longitude;
                      
                    $('#lat').val(curLat);
                    $('#lng').val(curLng);
                    
                    getLocation(id);

                  }, function() {
                    alert('unable to fetch your location!');
                  });
                } else {
                  // Browser doesn't support Geolocation
                  alert('your browser does not support geolocation!');
                }
            }
            
            
            function getCoordinates(id1, id2, id3, id4, id5){
                var geocoder = new google.maps.Geocoder();
                var address = document.getElementById(id1).value;
                
                if(address.length){
                      geocoder.geocode({'address': address}, function(results, status) {
                      if (status === 'OK') {                      
                        curLat = results[0].geometry.location.lat();
                        curLng = results[0].geometry.location.lng();
                        
                        $('#' + id4).val(curLat);
                        $('#' + id5).val(curLng);

                        
                        var dateValue = document.getElementById(id3).value;
                        if(dateValue.length != 0){
                            $("#search_form").submit();
                        } else {
                            alert('Please select any date!');
                        }
                        
                          
                      } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                      }
                    });
                } else {
                    alert('please enter any location!');
                }
            }

            function getLocation(id){
                curLatLng = new google.maps.LatLng(
                  parseFloat(curLat),
                  parseFloat(curLng));
                var geocoder = new google.maps.Geocoder;
                geocoder.geocode({'location': curLatLng}, function(results, status) {
                  if (status === 'OK') {
                    if (results[1]) {
                      curAddress = results[1].formatted_address;
                      $(id).val(curAddress);
                      
                    } else {
                      window.alert('No results found');
                    }
                  } else {
                    window.alert('Geocoder failed due to: ' + status);
                  }
                });
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

            [type="radio"]:not(:checked) + label, [type="radio"]:checked + label {
                position: relative;
                padding-left: 35px;
                cursor: pointer;
                display: inline-block;
                height: 25px;
                line-height: 25px;
                font-size: 1.5rem;
                color: white;
                transition: .28s ease;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            [type="radio"]:checked + label:after,
            [type="radio"].with-gap:checked + label:before,
            [type="radio"].with-gap:checked + label:after {
              border: 2px solid #B34048;
            }


            [type="radio"]:checked + label:after,
            [type="radio"].with-gap:checked + label:after {
              background-color: #B34048;
              z-index: 0;
            }

            .services{
              color: white;
              font-size: 1.8em;
              position: relative;
              top: -22px;
            }

            .services-top{
              position: relative;
              top: -35px;
            }

            .datetime-top{
              position: relative;
              top: 0px;
            }

            .searchBtn{
                background: #C04848; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            }
            
            .searchBtn:hover{
                background: #C04848; /* fallback for old browsers */
                background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            }

            .datepicker-icon{
              position: relative;
              top: 40px;
              left: 195px;
              color: #560848;
            }

            .datepicker-top{
              position: relative;
              top: -32px;
            }

            .clock-icon{
              position: relative;
              top: 40px;
              left: 195px;
              color: #560848;
            }

            .modal.bottom-sheet {
                top: auto;
                bottom: -100%;
                margin: 0;
                width: 100%;
                max-height: 100%;
                border-radius: 0;
                will-change: bottom, opacity;
            }

            .search_form{
              position: relative;
              top: 8%;
            }

            .picUpload{
              margin-top: 50px;
            }



            .loader-text{
              font-size: 5em;
              font-weight: 100;
              float: left;
              color: #560848;
            }

            .loader-icon{
                position: relative;
                top: 7.3em;
            }

            #loader{
              position: relative;
              left: 40%;
              top: 9em;
            }

            .preloader-wrapper.big {
                width: 50px;
                height: 50px;
            }

            .loader-image{
              position: relative;
              top: 9em;
              left: -22em;
            }

            @media only screen and (max-width: 768px){
                .loader-text {
                    font-size: 4em;
                    font-weight: 100;
                    float: left;
                    color: #560848;
                    position: relative;
                    left: -85px;
                    top: -115px;
                }

                .loader-icon {
                    position: relative;
                    top: -2.45em;
                    left: -87px;
                }

                .preloader-wrapper.big {
                    width: 38px;
                    height: 38px;
                }

              .loader-image{
                  position: relative;
                  top: -8em;
                  left: -35%;
              }

              .loader-image img{
                width: 80%;
              }
            }

        </style>
    </head>
    <body onload="myFunction()" style="overflow-x: hidden;">

        <!-- loader -->

        <div id="loader">

            <p class="loader-text">Driving</p>

            <div class="preloader-wrapper big active loader-icon">
              <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>

              <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>
            </div>

            <div class="loader-image">
              <img src="img/loader.jpg">
            </div>
        

        </div>

        <div id="myDiv">
        
            <!-- landing page starting section -->
      
            
            <section>
                <div class="carousel carousel-slider center" id="main-carousel" data-indicators="true">
                    <div class="carousel-item-inner">
                        <h2 class="white-text carousel-item-header">Drivingo</h2>
                        <p class="white-text carousel-item-subheader">Craft your journey.</p>
                    </div>
                    <div class="carousel-fixed-item center">
                      <form action="search.php" id="search_form" method="get" class="hide-on-small-only  search_form">
                        <div class="row">
                          <div class="col s1 m3 l3"></div>
                          <div class="input-field col s10 m6 l6">
                            <input id="location-input1" placeholder="Enter any location..." type="text" class="validate" required>
                            <span class="location-icon tooltipped" data-position="bottom" data-delay="50" data-tooltip="current location" onclick="currentLocation('#location-input1')"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                         </div>  
                        </div>  

                        <div class="row datetime-top">
                            <div class="col s1 m3 l3"></div>
                            <div class="col s10 m3 l3 datepicker-top">
                                <input name="date" id="datepicker1" type="date" class="datepicker" placeholder="pick a date..." required>
                                <span class="location-icon"><i class="fa fa-calendar fa" aria-hidden="true"></i></span>
                            </div>
                            <div class="col s10 m3 l3 datepicker-top">
                                <input name="time" placeholder="Preferred time" id="time" type="text" class="validate" required>
                                <span class="location-icon"><i class="fa fa-clock-o fa" aria-hidden="true"></i></span>
                            </div>
                        </div>

                        <div class="row services-top">
                           <div class="col s1 m3 l3"></div>
                           <div class="col s10 m2 l2">
                             <p class="services center-align">Type of services</p>
                           </div>
                           <div class="col s10 m4 l4">
                              <div class="col m12">
                                  <p style="float: left;margin-right: 4em; font-weight: 400;">
                                      <input name="service" value="training" type="radio" id="test1" checked="checked" required />
                                      <label for="test1">Only training</label>
                                  </p>
                                  <p style="float: left; font-weight: 400;">
                                      <input name="service" value="License" type="radio" id="test2" required />
                                      <label for="test2">Training + License</label>
                                  </p>
                                  <p style="float: left; font-weight: 400;">
                                      <input name="service" value="d_school" type="radio" id="test3" required />
                                      <label for="test3">Bike stunts</label>
                                  </p>
                              </div>
                           </div>
                        </div>

                        <input name="lat" class="hide" id="lat1" value="" type="text"/>
                        <input name="lng" class="hide" id="lng1" value="" type="text"/>

                        <div class="row">
                          <div class="col s1 m3 l3"></div>
                          <div class="col s10 m6 l6">
                              <input type="button" onclick="searchForm('location-input1', 'searchHiddenBtn1', 'datepicker1', 'lat1', 'lng1', 'time')" class="btn searchBtn" value="Search" />
                              <!--input type="submit" onclick="searchForm('location-input1', 'searchHiddenBtn1', 'datepicker1', 'lat1', 'lng1')" id="searchHiddenBtn1" class="hide" value="Search" /-->
                          </div>
                        </div>
                      </form>

                      <div class="row hide-on-med-and-up">
                          <div class="col s1 m3 l3"></div>
                          <div class="col s10 m6 l6">
                              <button type="button" onclick="searchModal()" class="btn searchBtn">Search</button>
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
                            <form class="col s12" method="POST" action="reg_schools.php" enctype="multipart/form-data">
          
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
                                <div class="col s12 m4 l4">
                        
                                    <p class="service_header">Vehicles</p>
                                    <p>
                                      <input type="checkbox" id="test5" name="services[]" value="CARS" />
                                      <label class="checkbox_label" for="test5">CARS</label>
                                    </p>
                                    <p>
                                      <input type="checkbox" id="test6" name="services[]" value="SUVS"/>
                                      <label class="checkbox_label" for="test6">SUVS</label>
                                    </p>
                                    <p>
                                      <input type="checkbox" id="test7" name="services[]" value="TRUCKS"/>
                                      <label class="checkbox_label" for="test7">TRUCKS</label>
                                    </p>          

                                </div>  

                                <div class="col s12 m4 l4">
                        
                                    <p class="service_header">Services</p>
                                    <p>
                                      <input type="checkbox" id="test8" name="services[]" value="TRAINING" />
                                      <label class="checkbox_label" for="test8">ONLY TRAINING</label>
                                    </p>
                                    <p>
                                      <input type="checkbox" id="test9" name="services[]" value="LICENSE"/>
                                      <label class="checkbox_label" for="test9">TRAINING + LICENSE</label>
                                    </p>
                                    <p>
                                      <input type="checkbox" id="test10" name="services[]" value="STUNT"/>
                                      <label class="checkbox_label" for="test10">BIKE STUNTS</label>
                                    </p>          

                                </div>

                              </div>
            
                              <div class="row picUpload">
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
                                    <input name="group1" value="user" type="radio" id="test15" checked="checked" />
                                    <label for="test15">As a user</label>
                                </p>
                                <p style="float: left; font-weight: 400;">
                                    <input name="group1" value="d_school" type="radio" id="test16" />
                                    <label for="test16">As a school</label>
                                </p>
                            </div>
                        </div>
                        <div class="row center-align">
                            <button class=" modal-action modal-close waves-effect waves-green btn login-btn" type="submit" name="loginbtn">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
            <!-- Popup Modal -->
              <div id="modal2" class="modal">
                <div class="modal-content" style="background: #FAFAFA;">
                  <div class="alert-modal-data" id="alert-modal-data"><p class="center-align">A bunch of text</p></div>
                </div>
                <div class="modal-footer">
                  <a class=" modal-action modal-close waves-effect waves-green btn-flat">close</a>
                </div>
              </div>

              <!-- Search Modal -->
              <div id="searchModal" class="modal bottom-sheet hide-on-med-and-up" style="overflow: hidden;background: #C04848;background: -webkit-linear-gradient(to left, #C04848 , #480048);background: linear-gradient(to left, #C04848 , #480048);">
                <div class="modal-content" style="padding-left: 0;padding-top: 0;padding-bottom: 0;">
                  <form action="search.php" method="get">
                        <div class="row">
                          <div class="col m3 l3"></div>
                          <div class="input-field col s12 m6 l6">
                            <input id="location-input2" placeholder="Enter any location..." type="text" class="validate" required>
                            <span class="location-icon tooltipped" data-position="bottom" data-delay="50" data-tooltip="current location" onclick="currentLocation('#location-input2')"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                         </div>  
                        </div>  

                        <div class="row datetime-top">
                            <div class="col m3 l3"></div>
                            <div class="col s12 m3 l3 datepicker-top" style="top: -65px;">
                                <input name="date" type="date" id="datepicker2" class="datepicker" placeholder="pick a date..." required>
                                <span class="location-icon"><i class="fa fa-calendar fa" aria-hidden="true"></i></span>
                            </div>
                            <div class="col s12 m3 l3 datepicker-top" style="top: -108px;">
                                <input name="time" placeholder="Preferred time" type="text" class="validate" required>
                                <span class="location-icon"><i class="fa fa-clock-o fa" aria-hidden="true"></i></span>
                            </div>
                        </div>

                        <div class="row services-top" style="top: -164px;">
                           <div class="col m3 l3"></div>
                           <div class="col s10 m2 l2">
                             <p class="services" style="left: -15px;">Type of services</p>
                           </div>
                           <div class="col s12 m4 l4" style="position: relative; top: -20px;">
                              <div class="col m12">
                                  <!--p style="float: left;margin-right: 4em; font-weight: 400;">
                                      <input name="service" value="training" type="radio" id="test10" checked="checked"/>
                                      <label for="test10">Only training</label>
                                  </p>
                                  <!--p style="float: left; font-weight: 400;">
                                      <input name="service" value="License" type="radio" id="tes19"/>
                                      <label for="test19">Training + License</label>
                                  </p-->
                                  <p style="float: left; font-weight: 400;">
                                      <input name="service" value="training" type="radio" id="test150" checked="checked"/>
                                      <label for="test150">Only Training</label>
                                  </p>
                                  <p style="float: left; font-weight: 400;">
                                      <input name="service" value="License" type="radio" id="test12"/>
                                      <label for="test12">Training + License</label>
                                  </p>
                                  <p style="float: left; font-weight: 400;">
                                      <input name="service" value="stunt" type="radio" id="test13"/>
                                      <label for="test13">Bike stunts</label>
                                  </p>
                              </div>
                           </div>
                        </div>

                        <input name="lat" class="hide" id="lat2" value="" type="text"/>
                        <input name="lng" class="hide" id="lng2" value="" type="text"/>
                  </div>
                  <div class="modal-footer" style="position: fixed;bottom: 0px;">
                    <input type="button" onclick="searchForm('location-input2', 'searchHiddenBtn2', 'datepicker2', 'lat2', 'lng2', 'time')" class="btn searchBtn" value="Search" style="float: left;" />
                    <input type="submit" id="searchHiddenBtn2" class="hide">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">close</a>
                  </div>
                </form>
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

        </div>
        
        <script src="materialize/js/materialize.min.js"></script>
    </body>
</html>