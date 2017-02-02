<?php

    session_start();

    require('connect.php');

    /*if(!isset($_SESSION['type'])||!isset($_SESSION['loggedin'])){
        header("Location: index.php");
    }*/

    $owners_name = "";
    $schools_name = "";
    $email = "";
    $phone = "";
    $about = "";
    $address = "";
    $services = "";
    $schoolId = "";
    $about_owner = "";
    $package_counter = 0;
    $table = "";
    $tb = "";

    /* user details */

    $user_name = "";
    $user_email = "";
    $user_phone = "";
    $user_id = "";    

    if(isset($_SESSION['loggedin'])){
        $user_table = ret_user_table($_SESSION['login_type']);
        $user_id = $_SESSION['loggedin'];
        $query = "SELECT * FROM $user_table WHERE id = $user_id";
        if($query_run = mysqli_query($mysqli, $query)){
            while($row = mysqli_fetch_assoc($query_run)){
                $user_name = $row['name'];
                $user_email = $row['email'];
                $user_phone = $row['phone'];
            }
        } else {
            echo mysqli_error($mysqli);
        }
    }

    if(isset($_GET['tb'])){
        $tb = $_GET['tb'];

        if($tb == 3){
            $table = "fb_schools";
          }else if($tb == 2){
            $table = "g_schools";
          }else if($tb == 1){
            $table = "schools";
          }
    }

    echo $table;

    if(isset($_GET['hash'])){
        $schoolId = $_GET['hash'];

        $query = "SELECT * FROM schools WHERE id = $schoolId";
        if($query_run = mysqli_query($mysqli, $query)){
            while($row = mysqli_fetch_assoc($query_run)){
                $owners_name = $row['owners_name'];
                $schools_name = $row['schools_name'];
                $email = $row['email'];
                $phone = $row['phone'];
                $about = $row['about'];
                $address = $row['address'];
                $services = $row['services'];
            }
        } else {
            echo mysqli_error($mysqli);
        }

        $query1 = "SELECT * FROM $table WHERE id = $schoolId";
        if($query1_run = mysqli_query($mysqli, $query1)){
            while($row = mysqli_fetch_assoc($query1_run)){
                $about_owner = $row['about_owner'];
            }
        } else {
            echo mysqli_error($mysqli);
        }

        $query2 = "SELECT * FROM packages WHERE school_id = $schoolId";
        if($query2_run = mysqli_query($mysqli, $query2)){
            while($row = mysqli_fetch_assoc($query2_run)){
                $package_name[$package_counter] = $row['package_name'];
                $price[$package_counter] = $row['price'];
                $detail_one[$package_counter] = $row['detail_one'];
                $detail_two[$package_counter] = $row['detail_two'];
                $detail_three[$package_counter] = $row['detail_three'];
                $package_id[$package_counter] = $row['id'];
                $package_counter++;
            }
        } else {
            echo mysqli_error($mysqli);
        }
    }

    function display_edit_details(){
        $flag = false;
        global $schoolId;
        
            if($_SESSION['type'] == 'd_school' && $schoolId == $_SESSION['loggedin']){
                $flag = true;
            } 
        
        return $flag;
    }


    function ret_user_table($lg_type){
        $user_table = "";
        if($lg_type == "normal"){
            $user_table = "users";
        } else if($lg_type == "facebook"){
            $user_table = "fb_users";
        } else if($lg_type == "google"){
            $user_table = "g_users";
        }
        return $user_table;
    }
    

?>

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

                var about = document.getElementById('about');
                about.addEventListener('keydown', function(event){
                   if(event.keyCode == 13){
                       $('#editAbout').submit();
                   } 
                });

                $('.scrollspy').scrollSpy();
                $('.mobile-nav-bar').hide();
                $('#image-header').hide();
                $('.modal').modal();
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

            function openPackageModal(){
                $('#package-modal').openModal();
            }

            function removePackage(pid){
                $('#package_id').val(pid);
                $('#package_school_id').val(<?php echo $schoolId; ?>);
                $('#package_remove_form').submit();
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
              max-width: 100%;
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
                top: 265em;
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

            .add-btn{
                margin: 7px;
                border: 1px solid grey;
                box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
            }

            .package-modal{
                width: 30%;
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
                    top: 292em;
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
                
                
                .slideshow-container {
                    max-width: 114%;
                    position: relative;
                    margin: auto;
                    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
                    width: 300px;
                    left: -25px;
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

                .package-modal{
                    width: 85%;
                }

                .add-btn {
                    margin: 7px;
                    border: 1px solid grey;
                    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
                    margin-left: -11px;
                }
            }
            
            @media screen and (min-width: 768px) and (max-width: 990px){
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
                
                .menu-icon{
                    display: block;
                    position: relative;
                    left: 93%;
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
                <li class="table-of-contents-inner"><a href="#introduction">About <?php echo $schools_name; ?></a></li>
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
                    <img src="<?php echo 'uploads/'.$email.'/cover_photo.jpg'; ?>" style="width: 100%;"/>
                    <div class="image-header"  id="image-header"><p><?php echo $schools_name; ?></p></div>
                </div>
                <div class="col s12 mm9 l12" onmouseover="hideName('#image-header');">
                  <div id="introduction" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">About <?php echo $schools_name; ?></h2>
                    <p><?php echo $about; ?></p>
                  </div>

                  <div id="structure" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">About Owner</h2>
                    <p><?php echo $schools_name; ?> is owned by <?php echo $owners_name; ?>.</p>
                    <p id="about_body"><?php if(strlen($about_owner) == 0 && display_edit_details()) echo '<span style="font-size: 1.5em;color: red;">please update your profile!</span>'; else echo '<span style="font-size: 1.1em;font-weight: 400;">'.$about_owner.'</span>'; ?></p>
                  </div>

                  <?php if(display_edit_details()) { ?>

                  <div class="row">
                    <form class="col s12" id="editAbout" action="update_profile.php" method="post">
                      <div class="row">
                        <div class="input-field col s12">
                          <textarea id="about" name="about" class="materialize-textarea"></textarea>
                          <label for="textarea1">Edit about owner.</label>
                        </div>
                      </div>
                      <input type="hidden" name="schoolId" value="<?php echo $schoolId; ?>" />
                    </form>
                  </div>
        
                  <?php 
                        }
                        if($package_counter == 0){ 
                  ?>

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
                    <?php if(display_edit_details()) { ?>
                        <div class="row">
                            <button class="btn add-btn btn-flat" onclick="openPackageModal();">Add package</button>
                        </div>
                    <?php } ?>
                  </div>

                  <?php } else { ?>

                  <div id="initialization" class="section scrollspy move-right">
                    <h2 class="scrollspy-header">Packages</h2>
                    

                    <?php for($i=0; $i < $package_counter; $i++){ ?>
                        <form action="payment/user_payment/request.php" method="post">
                            <div class="columns">
                              <ul class="price">
                                <li class="header gradient"><?php echo $package_name[$i]; ?></li>
                                <li class="grey"><?php echo 'Rs.'.$price[$i]; ?></li>
                                <?php
                                    if(strlen($detail_one[$i]) > 0) echo '<li>'.$detail_one[$i].'</li>';
                                    if(strlen($detail_two[$i]) > 0) echo '<li>'.$detail_two[$i].'</li>';
                                    if(strlen($detail_three[$i]) > 0) echo '<li>'.$detail_three[$i].'</li>';
                                 ?>
                                <li class="grey"><a href="#" class="button gradient"><input type="submit" value="Purchase"></a>&nbsp;&nbsp;&nbsp;<a href="#" class="btn btn-flat" onclick="removePackage('<?php echo $package_id[$i]; ?>')">Remove</a></li>
                              </ul>
                            </div>
                            <input type="hidden" name="name" value="<?php echo $user_name; ?>">
                            <input type="hidden" name="email" value="<?php echo $user_email; ?>">
                            <input type="hidden" name="phone" value="<?php echo $user_phone; ?>">
                            <input type="hidden" name="purpose" value="<?php echo $package_name[$i]; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="hidden" name="school_id" value="<?php echo $schoolId; ?>">
                            <input type="hidden" name="package_id" value="<?php echo $package_id[$i]; ?>">
                            <input type="hidden" name="amount" value="<?php echo $price[$i]; ?>">
                            <input type="hidden" name="tb" value="<?php echo $tb; ?>">
                            
                        </form>

                    <?php } ?>

                    <form action="update_profile.php" id="package_remove_form" method="post">
                        <input id="package_id" name="package_id" type="hidden" value="">
                        <input id="package_school_id" name="schoolId" type="hidden" value="">
                    </form>

                    
                    
                    <div class="row">
                        <?php if(display_edit_details()) { ?>
                        <button class="btn add-btn btn-flat" onclick="openPackageModal();">Add package</button>
                        <?php } ?>
                    </div>

                    
                  </div>

                  <?php } ?>
                    
                  <div id="gallery" class="section scrollspy move-right">
                    
                    <h2 class="scrollspy-header">Gallery</h2>
                    <div class="slideshow-container">

                    <?php
                        $directory = 'uploads/'.$email.'/gallery/';
                        $files = scandir($directory);
                        $n = count($files);
                        for($i=2; $i<$n;$i++){

                    ?>

                    <div class="mySlides fade">
                      <div class="numbertext"><?php echo ($i-1).'/'.($n-2); ?></div>
                      <img src="<?php echo $directory.$files[$i]; ?>" style="width:100%">
                    </div>

                    <?php } ?>
                    </div>

                    <br>

                    <div style="text-align:center">
                        <?php for($i=2; $i<$n;$i++){ 
                                echo '<span class="dot"></span>';
                              }
                        ?>
                    </div>

                    <?php if(display_edit_details()) { ?>

                    <div class="row">                     
                      <form action="update_profile.php" method="post" enctype="multipart/form-data">
                        <div class="file-field input-field col l10 m10 s12">
                          <div class="btn add-btn btn-flat">
                            <span>Upload</span>
                            <input type="file" name="file">
                          </div> 
                          <input type="hidden" name="schoolId" value="<?php echo $schoolId; ?>">
                          <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                          </div>
                        </div>
                        <div class="col l2 m2 s12">
                            <input type="submit" name="imageBtn" class="btn btn-flat" value="ADD" style="margin-top: 2em;">
                        </div>
                      </form>
                    </div>

                    <?php } ?>
                  
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

        <!-- Package Modal Structure -->

          <div id="package-modal" class="modal modal-fixed-footer package-modal">
            <div class="modal-content">
              <h4 style="text-align: center; color: #490147;">ADD PACKAGE</h4>
              <form action="update_profile.php" method="post">
                  <input name="schoolId" type="hidden" value="<?php echo $schoolId; ?>">
                  <div class="row">
                    <div class="input-field col s12">
                      <input type="text" name="package_name" class="validate" required>
                      <label for="email">Package name</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <input name="price" type="text" class="validate" required>
                      <label for="email">Price</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <input name="detail_one" type="text" class="validate">
                      <label for="email">Package detail</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <input name="detail_two" type="text" class="validate">
                      <label for="email">Package detail</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <input name="detail_three" type="text" class="validate">
                      <label for="email">Package detail</label>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">CLOSE</a>
                  <button type="submit" class="btn gradient">ADD</button>
                </div>
            </form>
          </div>
        
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
</html>