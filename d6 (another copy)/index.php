<?php 

session_start();
//session_destroy();

$user_firstname = '';
$user_lastname = '';
$user_email = '';
$user_picture = '';
$user_name = '';
$table = "";
$user_phone = '';
$user_profile_url = "";



require_once('connect.php');
    if(isset($_SESSION['activated'])){
        echo 'Your Account has been activated Successfully';
        unset($_SESSION['activated']);
    }
    
    
        

   if(isset($_POST['logout']))   {

      if($_SESSION['login_type'] == 'facebook'){
        header("Location: fblogin/index.php?logout=true");
      }else if($_SESSION['login_type'] == 'google'){
        header('Location: glogin/logout.php');
      }
      session_destroy(); 

      header('Location: index.php');
    }

    if(isset($_SESSION['user_type']) && isset($_SESSION['login_type'])){
      if($_SESSION['user_type'] == 'user' && $_SESSION['login_type'] == 'facebook'){
        $table = "fb_users";
      } else if($_SESSION['user_type'] == 'user' && $_SESSION['login_type'] == 'google'){
        $table = "g_users";
      }else if($_SESSION['user_type'] == 'school' && $_SESSION['login_type'] == 'facebook'){
        $table = "fb_schools";
      }else if($_SESSION['user_type'] == 'school' && $_SESSION['login_type'] == 'google'){
        $table = "g_schools";
      }
    }

      if(isset($_POST['loginbtn'])){
       $lemail = $_POST['loginemail'];
       $lpass = $_POST['loginpassword'];
       echo $type = $_POST['group1'];
       
      if($type== 'user'){
           $query = "SELECT * FROM `users` WHERE `email` = '$lemail' AND `pass` = '$lpass' ";
             if($query_run = mysqli_query($mysqli, $query)){
                if(mysqli_num_rows($query_run)==1){
                     while($row = mysqli_fetch_assoc($query_run)){
                      $_SESSION['loggedin'] = $row['id'];
                      $_SESSION['type'] = $type;
                      $_SESSION['user_type'] = $type;
                      $_SESSION['login_type'] = 'normal';
                      $_SESSION['table'] = 'users';
                      $user_name = $row['name'];
                      $user_email = $row['email'];
                      $user_picture = "img/beautiful.jpg";
                      $user_phone = $row['phone'];
                    }
               }
          }else{
               echo 'Some Error Occured';
          }
      }else{
           $query = "SELECT * FROM `schools` WHERE `email` = '$lemail' AND `pass` = '$lpass' ";
                 if($query_run = mysqli_query($mysqli, $query)){
                if(mysqli_num_rows($query_run)==1){
                     while($row = mysqli_fetch_assoc($query_run)){
                      $_SESSION['loggedin'] = $row['id'];
                      $_SESSION['type'] = $type;
                      $_SESSION['user_type'] = 'school';
                      $_SESSION['login_type'] = 'normal';
                      $_SESSION['table'] = 'schools';
                      $user_name = $row['owners_name'];
                      $user_email = $row['email'];
                      $user_picture = "img/beautiful.jpg";
                      $user_phone = $row['phone'];
                    }
               }
          }else{
               echo 'Some Error Occured';
          }
      }

    
       
   }

   if(isset($_SESSION['login_type']) && isset($_SESSION['id'])){
      $_SESSION['loggedin'] = $_SESSION['id'];
      $user_id = $_SESSION['id'];
      $login_type = $_SESSION['login_type'];

      if($login_type == "google"){
        $query = "SELECT * FROM $table WHERE id = $user_id";
        if($query_run = mysqli_query($mysqli, $query)){
            while($row = mysqli_fetch_assoc($query_run)){
                $user_firstname = $row['first_name'];
                $user_lastname = $row['last_name'];
                $user_email = $row['email'];
                $user_picture = $row['picture'];
                $user_name = $user_firstname.' '.$user_lastname;
                $user_phone = $row['phone'];
            }
        } else {
          echo mysqli_error($mysqli);
        }
      } else if($login_type == "facebook"){
        $query = "SELECT * FROM $table WHERE id = $user_id";
        if($query_run = mysqli_query($mysqli, $query)){
            while($row = mysqli_fetch_assoc($query_run)){
                $user_name = $row['name'];
                $user_email = $row['email'];
                $user_picture = $row['image'];
                $user_phone = $row['phone'];
            }
        } else {
          echo mysqli_error($mysqli);
        }
      }
   }

   function update(){
      global $table;
      global $mysqli;

      if(isset($table) && isset($_SESSION['user_type']) && isset($_SESSION['loggedin'])){
        $user_type = $_SESSION['user_type'];

        if($user_type == 'user'){
          $query1 = "SELECT * FROM $table WHERE `id` = '".$_SESSION['loggedin']."'";
          if($query1_run = mysqli_query($mysqli, $query1)){
            while($row = mysqli_fetch_assoc($query1_run)){
              if(strlen($row['phone']) == 0){
                return true;
              } else {
                return false;
              }
            }
          }
        } else if ($user_type == 'school'){
          $query2 = "SELECT * FROM $table WHERE `id` = '".$_SESSION['loggedin']."'";
          if($query2_run = mysqli_query($mysqli, $query2)){
            while($row = mysqli_fetch_assoc($query2_run)){
              if(strlen($row['phone']) == 0 || strlen($row['school_name']) == 0 || strlen($row['address']) == 0 || strlen($row['about']) == 0){
                return true;
              } else {
                return false;
              }
            }
          }
        }
      }
  }

  if(isset($_SESSION['user_type']) && isset($table)){
    $user_type = $_SESSION['user_type'];

    if($user_type == 'user'){
      if(isset($_POST['update_phone'])){
        $user_phone = $_POST['update_phone'];

        $query = "UPDATE $table SET phone = $user_phone WHERE id = '".$_SESSION['loggedin']."'";
        if(!mysqli_query($mysqli, $query)){
          echo mysqli_error($mysqli);
        }
      }
    } else if($user_type == 'school'){
      if(isset($_POST['update_phone']) && isset($_POST['update_school']) && isset($_POST['update_about']) && isset($_POST['update_address']) && isset($_POST['services'])  && isset($_POST['update_lat']) && isset($_POST['update_lng'])){
        $user_phone = $_POST['update_phone'];
        $user_school = $_POST['update_school'];
        $user_about = $_POST['update_about'];
        $user_address = $_POST['update_address'];
        $services = $_POST['services'];
        $lat = $_POST['update_lat'];
        $lng = $_POST['update_lng'];
        $user_services = '';
        if(!empty($services)){
          $n = count($services);
          for($i = 0; $i< $n; $i++){
            if($i==$n-1) $user_services.= $services[$i];
            else $user_services.= $services[$i].'/';
          }
        }

        $query = "UPDATE $table SET phone = '$user_phone', school_name = '$user_school', about = '$user_about', address = '$user_address', services = '$user_services', lat = '$lat', lng = '$lng' WHERE id = '".$_SESSION['loggedin']."'";
        if(mysqli_query($mysqli, $query)){
           $query1 = "SELECT email FROM $table WHERE id = '".$_SESSION['loggedin']."'";
           if($query1_run = mysqli_query($mysqli, $query1)){
                while($row = mysqli_fetch_assoc($query1_run)){
                    upload_image($row['email']);
                }
           } else {
              echo mysqli_error($mysqli);
           }
        } else {
          echo mysqli_error($mysqli);
        }

      }
    }
  }
  
  if(isset($_SESSION['login_type']) && isset($_SESSION['loggedin']) && $_SESSION['user_type'] == 'school'){
      $login_type = $_SESSION['login_type'];
      $user_id = $_SESSION['loggedin'];
      $tb = "";
      if($login_type == 'normal'){
        $tb = '1';
      } else if($login_type == 'google'){
        $tb = '2';
      } else if($login_type == 'facebook'){
        $tb = '3';
      }
      
      $user_profile_url = "profile.php?hash=".$user_id."&tb=".$tb;
    } 

    function upload_image($email){
            
            $target_dir = "uploads/".$email;
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            if (!file_exists($target_dir.'/gallery')) {
                mkdir($target_dir.'/gallery', 0777, true);
            }
            $target_dir.="/";
            echo $file_name = $_FILES['d_cover_photo']['name'];
            echo $file_tmp = $_FILES['d_cover_photo']['tmp_name'];
             if(move_uploaded_file($file_tmp,$target_dir.'cover_photo.jpg')){
                   
             }else echo 'file upload failed';
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
        <link rel="stylesheet" href="css/animate.css">
        <link href='//fonts.googleapis.com/css?family=Alegreya Sans' rel='stylesheet'>
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
                
                $('.profile').hide();
                $('#loginform_details').hide();
                $('#myDiv').hide();
                $('select').material_select();
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
            
            function verifyAddress(addressId, btnId, latId, lngId){
                var schoolAddress = $(addressId).val();
                shoolLocation(schoolAddress, btnId, latId, lngId);
            }
            
            function shoolLocation(schoolAddress, btnId, latId, lngId){
                var geocoder = new google.maps.Geocoder();

                if(schoolAddress.length){
                      geocoder.geocode({'address': schoolAddress}, function(results, status) {
                      if (status === 'OK') {                      
                        schoolLat = results[0].geometry.location.lat();
                        schoolLng = results[0].geometry.location.lng();
                        
                        $(latId).val(schoolLat);
                        $(lngId).val(schoolLng);
                        
                        
                        $(btnId).click();
                          
                      } else {
                        alert('Unable to fetch the location: ' + status + ' please provide valid address!');
                      }
                    });
                } else {
                    alert('please enter any location!');
                }
            }

            function openProfile(){
              $('#profile_modal').toggle();
            }

            function closeProfile(){
              $('#profile_modal').hide();
            }

            function showLoginFormDetails(id, type){
              if(type == 1){
                $('#loginform_hidden_type').val('user');
                $('#facebook_btn_link').attr('href','fblogin/index.php?user_type=user');
                $('#google_btn_link').attr('href','glogin/index.php?user_type=user');
              } else {
                $('#loginform_hidden_type').val('d_school');
                $('#facebook_btn_link').attr('href','fblogin/index.php?user_type=school');
                $('#google_btn_link').attr('href','glogin/index.php?user_type=school');
              }

              $(id).show();
            }
            
        </script>
        
        
        <!-- styling portion -->
        
        <style>
            .alert-modal-data{
                font-size: 2em;
                font-weight: 300;
            }

            .select-wrapper input.select-dropdown {
                position: relative;
                cursor: pointer;
                background-color: white;
                border: none;
                border-bottom: 1px solid #9e9e9e;
                outline: none;
                height: 3rem;
                line-height: 3rem;
                width: 100%;
                font-size: 1.3rem;
                margin: 0 0 20px 0;
                padding: 0;
                display: block;
                margin-bottom: 0px;
                margin-top: -47px;
                padding-bottom: 3px;
                padding-left: 12px;
                padding-right: 4px;
                color: #8B78AC;
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

            .profile{
              position: fixed;
              top: 6em;
              width: 300px;
              background: white;
              right: 2em;
              box-shadow: 0px 6px 20px 0px rgba(26,20,26,1);
              z-index: 102;
            }

            .profile_image{
              margin: 1em;
              box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            }

            .profile_name{
              margin-top: 33px;
              font-size: 1.3em;
              font-weight: 300;
            }

            .profile_mobile{
              margin-top: 4px;
              margin-left: -15px
            }

            .profile_image_container{
              position: relative;
              margin-bottom: 0px;
            }

            .profile_close_icon{
              position: relative;
              left: 87%;
              font-size: 1.5em;
              top: 10px;
              cursor: pointer;
            }

            .update_window{
              position: fixed;
              top: 10%;
              left: 28%;
              width: 44%;
              z-index: 101;
              background: white;
              box-shadow: 0px 6px 20px 0px rgba(26,20,26,1);
            }

            .update_header{
              font-size: 2em;
              margin-bottom: 0px;
              color: #560848;
            }

            .time-icon {
                float: right;
                position: relative;
                top: -42px;
                font-size: 1.7em;
                color: #560848;
                margin-right: 8px;
                cursor: pointer;
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

              .profile {
                  position: fixed;
                  top: 6em;
                  width: 300px;
                  background: white;
                  right: 11px;
                  box-shadow: 0px 6px 20px 0px rgba(26,20,26,1);
                  z-index: 100;
              }

              .update_window {
                    position: fixed;
                    top: 10%;
                    left: 4%;
                    width: 92%;
                    z-index: 101;
                    background: white;
                    box-shadow: 0px 6px 20px 0px rgba(26,20,26,1);
                    overflow-y: auto;
                    height: 420px;
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
                            <!--div class="col s10 m3 l3 datepicker-top">
                                <input name="time" placeholder="Preferred time" id="time" type="text" class="validate" required>
                                <span class="location-icon"><i class="fa fa-clock-o fa" aria-hidden="true"></i></span>
                            </div-->
                            <div class="input-field col s10 m3 l3 ">
                              <select name="time">
                                <option value="" disabled selected>Preffered time...</option>
                                <option value="4:00 AM">4:00 AM</option>
                                <option value="5:00 AM">5:00 AM</option>
                                <option value="6:00 AM">6:00 AM</option>
                                <option value="6:00 AM">6:00 AM</option>
                                <option value="7:00 AM">7:00 AM</option>
                                <option value="8:00 AM">8:00 AM</option>
                                <option value="9:00 AM">9:00 AM</option>
                                <option value="10:00 AM">10:00 AM</option>
                                <option value="11:00 AM">11:00 AM</option>
                                <option value="12:00 AM">12:00 AM</option>
                                <option value="1:00 PM">1:00 PM</option>
                                <option value="2:00 PM">2:00 PM</option>
                                <option value="3:00 PM">3:00 PM</option>
                                <option value="4:00 PM">4:00 PM</option>
                                <option value="5:00 PM">5:00 PM</option>
                                <option value="6:00 PM">6:00 PM</option>
                                <option value="7:00 PM">7:00 PM</option>
                                <option value="8:00 PM">8:00 PM</option>
                                <option value="9:00 PM">9:00 PM</option>
                                <option value="10:00 PM">10:00 PM</option>
                                <option value="11:00 PM">11:00 PM</option>
                                <option value="12:00 PM">12:00 PM</option>
                              </select>
                              <span class="time-icon"><i class="fa fa-clock-o fa" aria-hidden="true"></i></span>
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
                                  <li onclick="openProfile();"><a>Profile</a></li>
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
                            <!--div class="row center-align" style="margin-top: -10px;margin-bottom: -10px;">
                                <a class="mobile-nav-bar-options" onclick="openProfile();" href="#">profile</a>
                            </div-->
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
                                <input type="button" onclick="verifyAddress('#school_address', '#schoolHiddenBtn','#schoolLat', '#schoolLng');" value="Submit" class="btn btn-large file_btn">  
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
                    <div class="col m5"></div>
                    <div class="col m6">
                        <p style="float: left;margin-right: 2em; font-weight: 400;" onclick="showLoginFormDetails('#loginform_details', 1);">
                            <input name="group1" value="user" type="radio" id="test15"/>
                            <label for="test15">As a user</label>
                        </p>
                        <p style="float: left; font-weight: 400;" onclick="showLoginFormDetails('#loginform_details', 2);">
                            <input name="group1" value="d_school" type="radio" id="test16" />
                            <label for="test16">As a school</label>
                        </p>
                    </div>
                </div>
                <div id="loginform_details">
                  <div class="row center-align">
                      <a href="fblogin/" id="facebook_btn_link"><button class=" modal-action modal-close waves-effect waves-green btn blue darken-4 fb-btn" type="button">FACEBOOK</button></a>
                      <a href="glogin/" id="google_btn_link"><button class=" modal-action modal-close waves-effect waves-green btn red darken-4 google-btn" type="button">GOOGLE</button></a>
                  </div>
                  <h5 class="center-align white-text" style="font-weight: 200;">Or</h5>
                  <h4 class="center-align white-text" style="font-weight: 200;">Enter your login details.</h4>
                  <div class="row">
                      <form class="col s12" action="index.php" method="post">
                          <input type="hidden" name="group1" value="" id="loginform_hidden_type">
                          <div class="row">
                              <div class="input-field col s12 m6">
                                  <input id="loginemail" type="email" class="validate" name="loginemail" placeholder="Email">
                              </div>
                                    
                              <div class="input-field col s12 m6">
                                  <input id="loginpassword" type="password" class="validate" name="loginpassword" placeholder="Password">
                              </div>                  
                          </div>
                          <div class="row center-align">
                              <button class=" modal-action modal-close waves-effect waves-green btn login-btn" type="submit" name="loginbtn">Login</button>
                          </div>
                      </form>
                  </div>
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

            <div class="profile animated pulse" id="profile_modal" style="color: #4B0248;font-family: 'Alegreya Sans';font-size: 12pt;">
                <div class="profile_close_icon" onclick="closeProfile();">
                  <i class="fa fa-times" aria-hidden="true"></i>
                </div>
                <div class="row profile_image_container">
                  <div class="col s4">
                    <img src="<?php echo $user_picture; ?>" height="60" width="60" class="circle profile_image" />
                  </div>
                  <div class="col s8">
                    <p class="profile_name"><?php echo $user_name; ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col s1"></div>
                  <div class="col s2">
                    <i class="fa fa-mobile fa-2x" aria-hidden="true"></i>
                  </div>
                  <div class="col s9">
                    <p class="profile_mobile"><?php echo $user_phone; ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col s1"></div>
                  <div class="col s2" style="padding-left: 0px;">
                    <i class="fa fa-vcard-o fa-2x" aria-hidden="true"></i>
                  </div>
                  <div class="col s9">
                    <p class="profile_mobile"><?php echo $user_email; ?></p>
                  </div>
                </div>
                <?php if(strlen($user_profile_url) > 0) { ?>
                  <div class="row">
                    <div class="center-align">
                      <a href="<?php echo $user_profile_url; ?>"><p>See yourself</p></a>
                    </div>
                  </div>
                <?php } ?>
                <div class="row">
                  <form method="post" action="index.php">
                    <li class="center-align" style="list-style: none;">
                      <input style="color: #4B0248;font-family: 'Alegreya Sans';" type="submit" class="btn btn-flat" value="Logout" name="logout" />
                    </li>
                  </form>
                </div>
            </div>

            <!-- update window -->

            <?php if(update()){ ?>

              <div class="update_window">
                <div class="row center-align" style="margin-bottom: 0px;">
                  <p class="update_header center-align">UPDATE</p>
                </div>
                <form action="index.php" method="post" enctype="multipart/form-data">
                  <div class="row" style="margin-bottom: 0px;">
                    <div class="col s1"></div>
                    <div class="input-field col s10">
                      <input id="update_phone" type="text" name="update_phone" class="validate" style="background: transparent;border-bottom: 2px solid;color: #560848;box-shadow: none;width: 97%;">
                      <label for="update_phone">Phone number</label>
                    </div>
                  </div>

                  <?php if($_SESSION['user_type'] == 'school'){ ?>

                    <div class="row" style="margin-bottom: 0px;">
                      <div class="col s1"></div>
                      <div class="input-field col s10">
                        <input name="update_school" type="text" class="validate" style="background: transparent;border-bottom: 2px solid;color: #560848;box-shadow: none;width: 97%;">
                        <label for="update_school">School name</label>
                      </div>
                    </div>
                    <div class="row" style="margin-bottom: 0px;">
                      <div class="col s1"></div>
                      <div class="input-field col s10">
                        <input name="update_about" type="text" class="validate" style="background: transparent;border-bottom: 2px solid;color: #560848;box-shadow: none;width: 97%;">
                        <label for="update_about">About</label>
                      </div>
                    </div>
                    <div class="row" style="margin-bottom: 0px;">
                      <div class="col s1"></div>
                      <div class="input-field col s10">
                        <input name="update_address" id="update_address" type="text" class="validate" style="background: transparent;border-bottom: 2px solid;color: #560848;box-shadow: none;width: 97%;">
                        <label for="update_address">Address</label>
                      </div>
                    </div>
                    <div class="row" style="margin-bottom: 0px;">
                      <div class="col s1"></div>
                      <div class="col s10">
                        <div class="file-field input-field">
                          <div class="btn searchBtn">
                            <span>Cover photo</span>
                            <input type="file" name="d_cover_photo" required>
                          </div>
                          <div class="file-path-wrapper">
                            <input style="padding-right: 20px;" class="file-path validate" type="text">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" style="margin-left: 4em;color:#560848;margin-bottom:0px;">
                      <div class="col s12 m4 l4">
              
                          <p class="service_header" style="color: #560848;margin-left: 0;">Vehicles</p>
                          <p>
                            <input type="checkbox" id="test51" name="services[]" value="CARS" />
                            <label class="checkbox_label" for="test51" style="color:#560848;">CARS</label>
                          </p>
                          <p>
                            <input type="checkbox" id="test61" name="services[]" value="SUVS"/>
                            <label class="checkbox_label" for="test61" style="color:#560848;">SUVS</label>
                          </p>
                          <p>
                            <input type="checkbox" id="test71" name="services[]" value="TRUCKS"/>
                            <label class="checkbox_label" for="test71" style="color:#560848;">TRUCKS</label>
                          </p>          

                      </div>  

                      <div class="col s12 m4 l4">
              
                          <p class="service_header" style="color: #560848;margin-left: 0;">Services</p>
                          <p>
                            <input type="checkbox" id="test81" name="services[]" value="TRAINING" />
                            <label class="checkbox_label" for="test81" style="color:#560848;">ONLY TRAINING</label>
                          </p>
                          <p>
                            <input type="checkbox" id="test91" name="services[]" value="LICENSE"/>
                            <label class="checkbox_label" for="test91" style="color:#560848;">TRAINING + LICENSE</label>
                          </p>
                          <p>
                            <input type="checkbox" id="test101" name="services[]" value="STUNT"/>
                            <label class="checkbox_label" for="test101" style="color:#560848;">BIKE STUNTS</label>
                          </p>          

                      </div>

                    </div>
                    <input type="hidden" value="" id="updateLat"  name="update_lat">
                    <input type="hidden" value="" id="updateLng" name="update_lng">

                  <?php } ?>  

                  <div class="row">
                    <button class="btn searchBtn right" type="button" onclick="verifyAddress('#update_address', '#updateHiddenBtn','#updateLat', '#updateLng');" style="margin-right: 15px;">SAVE</button>
                    <input id="updateHiddenBtn" type="submit" class="hide" value="send">
                  </div>
                </form>
              </div>
            
            <?php } ?>

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