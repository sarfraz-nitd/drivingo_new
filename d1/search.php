<?php 

    $curLat = "";
    $curLng = "";
    
    if(isset($_GET['lat'])&&isset($_GET['lng'])){
        $curLat = $_GET['lat'];
        $curLng = $_GET['lng'];
        echo $curLat + ' ' + $curLng;
    }

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Near connaught place</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="materialize/js/materialize.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJh5axYNsWa63hSjco7pySOpX-IJsZ7SM" type="text/javascript"></script>
      
    <script>
        
        var curLat = parseFloat('<?php echo $curLat; ?>');
        var curLng = parseFloat('<?php echo $curLng; ?>');
        var curLatLng,curAddress;
        var map;
        var markers = [];
        var infoWindow;
        
        $(document).ready(function() {
            $(".review").hide();
            $('.mobile-nav-bar').hide();
            $('ul.tabs').tabs();
            $('select').material_select();
            
            getLocation();
            
            if(window.innerWidth < 600){
                $('#filters').hide();
            }
            
            var address = document.getElementById('address');
            address.addEventListener('keydown', function(event){
               if(event.keyCode == 13){
                   getCoordinates(address.value);
               } 
            });
        });
        
        function radiusChange(){
            load();
        }
      
        function showReviews(id){
            $(id).slideToggle('slow');
        }
        
        function mobileNavBar(){
            $('.mobile-nav-bar').slideToggle('slow');
        }
        
        function showFilters(){
            $('#sortby').hide();
            $('#filters').show('fast');
        }
        
        function showSortBy(){
            $('#filters').hide();
            $('#sortby').show('fast');
        }
        
        function getLocation(){
            curLatLng = new google.maps.LatLng(
              parseFloat(curLat),
              parseFloat(curLng));
            var geocoder = new google.maps.Geocoder;
            geocoder.geocode({'location': curLatLng}, function(results, status) {
              if (status === 'OK') {
                if (results[1]) {
                  curAddress = results[1].formatted_address;
                  $('#search-bar-header').text(results[1].address_components[1].short_name);
                  
                } else {
                  window.alert('No results found');
                }
              } else {
                window.alert('Geocoder failed due to: ' + status);
              }
            });
        }
        
        function getCoordinates(address){
            var geocoder = new google.maps.Geocoder();
            if(address.length){
                geocoder.geocode({'address': address}, function(results, status) {
                    if (status === 'OK') {                      
                        if (results[0]) {
                          curAddress = results[0].formatted_address;
                          curLat = results[0].geometry.location.lat();
                          curLng = results[0].geometry.location.lng();
                          curLatLng = new google.maps.LatLng(
                              parseFloat(curLat),
                              parseFloat(curLng));
                          load();
                          $('#search-bar-header').text(results[0].address_components[0].short_name);
                        } else {
                          window.alert('No results found');
                        }
                        
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            } else {
                alert('please enter any location!');
            }
        }
          
        function load() {
          map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(curLat, curLng),
            zoom: 10,
            mapTypeId: 'roadmap',
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
          });
          infoWindow = new google.maps.InfoWindow();
          searchLocationsNear(curLat, curLng);
       }
        
       function clearLocations() {
         infoWindow.close();
         for (var i = 0; i < markers.length; i++) {
           markers[i].setMap(null);
         }
         markers.length = 0;
       }
        
       function searchLocationsNear(lat, lng) {
         clearLocations(); 
         var bounds = new google.maps.LatLngBounds();
           
         // for current location

          bounds.extend(curLatLng);
          var image = "img/current_location_50px.png";
          createMarker(curLatLng, "Your location",curAddress,"",image);
         
         var radius = document.getElementById('radiusSelect').value;
         var searchUrl = 'include/search_genxml.php?lat=' + lat + '&lng=' + lng + '&radius=' + radius;
         downloadUrl(searchUrl, function(data) {
           var xml = parseXml(data);
           var markerNodes = xml.documentElement.getElementsByTagName("marker");
             
             if(!markerNodes.length){
                 alert('No result found! please try increasing the radius.');
             }
                
           for (var i = 0; i < markerNodes.length; i++) {
             var name = markerNodes[i].getAttribute("name");
             var address = markerNodes[i].getAttribute("address");
             var type = markerNodes[i].getAttribute("type");
             var distance = parseFloat(markerNodes[i].getAttribute("distance"));
             var latlng = new google.maps.LatLng(
                  parseFloat(markerNodes[i].getAttribute("lat")),
                  parseFloat(markerNodes[i].getAttribute("lng")));

             createMarker(latlng, name, address, type, "");
             bounds.extend(latlng);
           }
           map.fitBounds(bounds);
           locationSelect.style.visibility = "visible";
           locationSelect.onchange = function() {
             var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
             google.maps.event.trigger(markers[markerNum], 'click');
           };
          });
        }
        
        function createMarker(latlng, name, address, type, image) {
          var html = "<div style='color: black;'><b>" + name + "</b> <br/>" + address + "<br/>" + type + "</div><br/><a onclick='getDirections(\""+ latlng.lat() + "\",\"" + latlng.lng() +"\")' style='color: blue;cursor: pointer;'>Get directions</a>";

          var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            icon: image
          });
          google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
          });
          markers.push(marker);
        }

        function downloadUrl(url, callback) {
          var request = window.ActiveXObject ?
              new ActiveXObject('Microsoft.XMLHTTP') :
              new XMLHttpRequest;
          request.onreadystatechange = function() {
            if (request.readyState == 4) {
              //request.onreadystatechange = doNothing;
              callback(request.responseText, request.status);
            }
          };
          request.open('GET', url, true);
          request.send(null);
        }

        function parseXml(str) {
          if (window.ActiveXObject) {
            var doc = new ActiveXObject('Microsoft.XMLDOM');
            doc.loadXML(str);
            return doc;
          } else if (window.DOMParser) {
            return (new DOMParser).parseFromString(str, 'text/xml');
          }
        }
        
        function getDirections(lat, lng){
            var directionsDisplay = new google.maps.DirectionsRenderer;
            directionsDisplay.setMap(null);
             var toLatLng = new google.maps.LatLng(
                  parseFloat(lat),
                  parseFloat(lng));
            var directionsService = new google.maps.DirectionsService;
            directionsDisplay.setMap(map);
            calculateAndDisplayRoute(directionsService, directionsDisplay, toLatLng);

        }
        
        function calculateAndDisplayRoute(directionsService, directionsDisplay, toLatLng) {
            //var selectedMode = document.getElementById('mode').value;
            directionsService.route({
              origin: curLatLng,
              destination: toLatLng,
              travelMode: 'DRIVING',
              provideRouteAlternatives: true,
            }, function(response, status) {
              if (status === 'OK') {
                directionsDisplay.setDirections(response);
              } else {
                window.alert('Directions request failed due to ' + status);
              }
            });
        }
        
    </script>
      
    <style>
        body{
            overflow-x: hidden;
        }
        
        .gradient{
            background: #C04848; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        
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
                font-weight: 400;
                margin: 0 0 20px 0;
                padding-left: 10px;
                box-shadow: none;
                box-sizing: content-box;
                transition: all 0.3s;
                color: #fff;
        }
        
        [type="radio"]:not(:checked) + label, [type="radio"]:checked + label {
            position: relative;
            padding-left: 35px;
            cursor: pointer;
            display: inline-block;
            height: 25px;
            line-height: 25px;
            font-size: 1.2rem;
            transition: .28s ease;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        [type="checkbox"] + label {
            position: relative;
            padding-left: 35px;
            cursor: pointer;
            display: inline-block;
            height: 25px;
            line-height: 25px;
            font-size: 1.2rem;
            -webkit-user-select: none;
            -moz-user-select: none;
            -khtml-user-select: none;
            -ms-user-select: none;
        }
        
        [type="radio"]:checked + label:after,
        [type="radio"].with-gap:checked + label:before,
        [type="radio"].with-gap:checked + label:after {
          border: 2px solid #ee6e73;
        }

        [type="radio"]:checked + label:after,
        [type="radio"].with-gap:checked + label:after {
          background-color: #ee6e73;
          z-index: 0;
        }
        
        [type="checkbox"]:checked + label:before {
          top: -4px;
          left: -5px;
          width: 12px;
          height: 22px;
          border-top: 2px solid transparent;
          border-left: 2px solid transparent;
          border-right: 2px solid #ee6e73;
          border-bottom: 2px solid #ee6e73;
          -webkit-transform: rotate(40deg);
                  transform: rotate(40deg);
          -webkit-backface-visibility: hidden;
                  backface-visibility: hidden;
          -webkit-transform-origin: 100% 100%;
                  transform-origin: 100% 100%;
        }
        
        /* Indeterminate checkbox */
        
        [type="checkbox"]:indeterminate + label:before {
          top: -11px;
          left: -12px;
          width: 10px;
          height: 22px;
          border-top: none;
          border-left: none;
          border-right: 2px solid #ee6e73;
          border-bottom: none;
          -webkit-transform: rotate(90deg);
                  transform: rotate(90deg);
          -webkit-backface-visibility: hidden;
                  backface-visibility: hidden;
          -webkit-transform-origin: 100% 100%;
                  transform-origin: 100% 100%;
        }
        
        [type="checkbox"].filled-in:checked + label:after {
          top: 0;
          width: 20px;
          height: 20px;
          border: 2px solid #ee6e73;
          background-color: #ee6e73;
          z-index: 0;
        }
        
        [type="checkbox"].filled-in.tabbed:checked:focus + label:after {
          border-radius: 2px;
          background-color: #ee6e73;
          border-color: #ee6e73;
        }
        
        input[type="range"] {
            border: none;
        }
        input[type="range"]:focus, input[type="range"]:active {
            border: none;
        }
        
        .select-wrapper input.select-dropdown {
            position: relative;
            cursor: pointer;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid white;
            outline: none;
            height: 3rem;
            line-height: 3rem;
            width: 100%;
            font-size: 1rem;
            margin: 0 0 20px 0;
            padding: 0;
            display: block;
        }
        
        .select-wrapper span.caret {
            color: white;
            position: absolute;
            right: 0;
            top: 16px;
            font-size: 10px;
        }
        
        .dropdown-content li > a, .dropdown-content li > span {
            font-size: 16px;
            color: #ee6e73;
            display: block;
            line-height: 22px;
            padding: 14px 16px;
        }
        
        .head{
            background: #360033; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #360033 , #0b8793); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #360033 , #0b8793); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
        
        .main-section{
            margin-top: 6em;
            color: white;
            position: relative;
            top: 2em;
            width: 95%;
            left: 2.5%;
            background: #f3f3f3;
            box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
            padding-top: 4em;
            border-radius: 5px;
        }
        
        nav{
            height: none;
            line-height: none;
            color: #fff;
            background-color: none;
            width: 100%;
            height: none;
            line-height: none;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
        }
        
        .search-bar-header{
            text-align: center;
            font-size: 2em;
            font-weight: 400;
            margin-bottom: 1.5em;
        }
        
        .card-position{
            width: 95%;
            position: relative;
            left: 2.5%;
        }
        
        .btn-subscribe{
            background: #C04848; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            float: left;
        }
        
        .btn-subscribe:hover{
            background: #C04848; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
        
        .card-reveal-inner{
            height: 80%;overflow-y: auto;
        }
        
        .direction-icon{
            display: none;
        }
        
        .direction-text{
            display: block;
            width: 125px;
            float: left;
            margin-left: 1em;
        }
        
        i.right{
        }
        
        i.right-cross{
            float: right;
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
        
        .search-bar{
            position: relative;
            top: 5em;
            color: white;
        }
        
        .main-section-header{
            color: #ee6e73;
            font-size: 1.5em;
            font-weight: 400;
        }
        
        .main-section-side-panel{
            position: relative;
            border-bottom-width: 10px;
            border-bottom-style: solid;
            width: 80%;
            background: white;
            left: 15%;
            top: -14px;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
            border-radius: 3px;
            color: #ee6e73;
        }
        
        .divider{
            height: 2px;
            overflow: hidden;
            background-color: white;
            width: 50%;
            position: relative;
            left: 25%;
            top: -55px;
        }
        
        .filter-header{
            font-size: 1.5em;
            margin-left: 12px;
            padding-top: 20px;
            margin-bottom: 15px;
        }
        
        .main-section-result{
            margin-top: 8px;
        }
        
        .sort-by{
            margin:0; 
            margin-top: 10px;
            position: relative;
            left: 1em;
            color: #ee6e73;
        }
        
        .sort-by-tabs{
            position: relative;
            left: -1em;
            padding-left: 0;
        }
        
        .radius-selector{
            left: 7px;
            top: -30px;
        }
        
        #map{
            width: 100%;
            height: 620px;
            top: -4em;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
            border-top-left-radius: 1em;
            border-top-right-radius: 1em;
        }
        
        .radius-select{
           position: relative;
        }
        
        @media screen and (max-width: 768px) {
            .main-section{
                position: relative;
                margin-top: 0em;
                color: white;
                width: 100%;
                left: 0%;
                top: 0;
                border-radius: 0;
                box-shadow: none;
            }
            
            .search-bar-header{
                text-align: center;
                font-size: 1.5em;
                font-weight: 400;
                padding-bottom: 10px;
            }
            
            .card-position{
                width: 106%;
                position: relative;
                left: -3%;
            }
            
            .card-reveal-inner{
                height: 70%;overflow-y: auto;
            }
            
            .direction-icon{
                display: block;
                float: left;
                position: relative;
                top: 3px;
                left: 30px;
            }

            .direction-text{
                display: none;
            }
            
            i.right{
                margin-left: 4px;
                position: relative;
                top: 12px;
            }
            
            input:not([type]), input[type="text"], input[type="password"], input[type="email"], input[type="url"], input[type="time"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="tel"], input[type="number"], input[type="search"], textarea.materialize-textarea {
                    background-color: transparent;
                    border: none;
                    border: 2px solid #fff;
                    border-radius: 0;
                    outline: none;
                    height: 3rem;
                    width: 100%;
                    font-size: 1rem;
                    font-weight: 400;
                    margin: 0 0 20px 0;
                    padding-left: 10px;
                    box-shadow: none;
                    box-sizing: content-box;
                    transition: all 0.3s;
                    color: #fff;
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
                font-weight: 600;
            }
                
            .mobile-nav-bar-options:hover{
                color: white;
                font-weight: 200;
            }
            
            .main-section-side-panel{
                position: relative;
                border-bottom-width: 10px;
                border-bottom-style: solid;
                width: 100%;
                background: white;
                left: 0%;
                top: -14px;
                box-shadow: none;
                border-radius: 3px;
                color: #ee6e73;
                top: -55px;
            }
            
            .search-bar{
                position: relative;
                top: 6em;
                color: white;
            }
            
            .sort-by-small{
                background: white;
                height: 150px;
                position: relative;
                top: 8px;
                padding-top: 15px;
            }
            
            #map{
                width: 100%;
                height: 300px;
                top: -4em;
                box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
                border-top-left-radius: none;
                 border-top-right-radius: none;
            }
            
            .radius-select{
                position: relative;
            }
        }
        
        @media screen and (min-width: 768px) and (max-width: 990px){
            .main-section-side-panel{
                position: relative;
                border-bottom-width: 10px;
                border-bottom-style: solid;
                width: 105%;
                background: white;
                left: 5%;
                top: -14px;
                box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
                border-radius: 3px;
                color: #ee6e73;
            }
            
            .main-section-header{
                color: #ee6e73;
                font-size: 1em;
                font-weight: 400;
                margin-bottom: 0;
            }
            
            .main-section-result{
                margin-top: 20px;
            }
            
            .sort-by{
                margin:0; 
                margin-top: 20px;
                position: relative;
                left: 10px;
                color: #ee6e73;
            }
            
            .sort-by-tabs{
                position: relative;
                left: 0em;
                padding-left: 0;
                top: 5px;
            }
            
            .menu-icon{
                display: block;
                position: relative;
                left: 95%;
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

  <body class="gradient" onload="load()">

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
      
      
    <!-- search bar section -->
      
    <section class="search-bar">
        <div class="row">
            <p class="search-bar-header">Driving schools near <b id="search-bar-header">Delhi</b></p>
        </div>
        <div class="row" style="position: relative;top: -50px;">
            <div class="col s1 m2"></div>
            <div class="col s10 m6">
                    <input type="text" id="address" placeholder="Try other location..."/>
            </div>  
            <div class="row hide-on-med-and-up"></div>
            <div class="col s1 m2 hide-on-med-and-up"></div>
            <div class="col m2 s10">
                <div class="input-field col s12">
                    <select id="radiusSelect" onchange="radiusChange();">
                      <option value="50">50KM</option>
                      <option value="100">100KM</option>
                      <option value="150">150KM</option>
                      <option value="200">200KM</option>
                    </select>
                    <label>RADIUS</label>
                </div>
            </div>
            
        </div>  
        <div class="row">
            <div class="col m5"></div>
            <div class="col m2">
                <div class="divider center-align"></div>
            </div>
        </div>
    </section>
      
    <!-- map -->
      
      
      
    <!-- driving school section -->
      
    <section class="main-section">
        <div id="map"></div>
        <div class="row main-section-header">
            <div class="col s12 m4 l4">
                <p class="center-align main-section-result">Showing <b>7</b> schools in <b>Delhi</b></p>
            </div>
            <div class="col s12 m8 l8">
                <div>
                    <div class="row hide-on-med-and-up">
                        <ul class="tabs">
                            <li class="tab col s3"><a class="active" onclick="showSortBy();">Sort by</a></li>
                            <li class="tab col s3"><a href="#test2" onclick="showFilters();">Filters</a></li>
                        </ul>
                        <div class="sort-by-small" id="sortby">
                            <div class="col s11" style="font-size: 5px;">
                                <p>
                                  <input name="group1" type="radio" id="test15" />
                                  <label for="test15">Popularity</label>
                                </p>
                                <p>
                                  <input name="group1" type="radio" id="test16" />
                                  <label for="test16">Price - Low</label>
                                </p>
                                <p>
                                  <input name="group1" type="radio" id="test17"  />
                                  <label for="test17">Price - High</label>
                                </p>
                                <p>
                                    <input name="group1" type="radio" id="test18" />
                                    <label for="test18">Other</label>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row hide-on-small-only">
                        <div class="col m2">
                            <p  class="sort-by">SORT BY</p>
                        </div>
                        <div class="col m10 sort-by-tabs">
                            <ul class="tabs">
                                <li class="tab col s3"><a class="active" href="#test1">Popularity</a></li>
                                <li class="tab col s3"><a href="#test2">Price - Low</a></li>
                                <li class="tab col s3"><a href="#test3">Price - High</a></li>
                                <li class="tab col s3"><a href="#test4">other</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col m4">
                <div class="main-section-side-panel" id="filters">
                    <div class="row">
                        <p class="filter-header">Location</p>
                        <div class="col s11">
                                <input style="border: 2px solid #ee6e73;color: #ee6e73;" type="text" id="inputName" placeholder="Search in Delhi"/>
                        </div>
                        <div class="col s11" style="font-size: 5px;">
                            <p>
                              <input name="group1" type="radio" id="test5" />
                              <label for="test5">central secretariat</label>
                            </p>
                            <p>
                              <input name="group1" type="radio" id="test6" />
                              <label for="test6">connaught place</label>
                            </p>
                            <p>
                              <input name="group1" type="radio" id="test7"  />
                              <label for="test7">Narela</label>
                            </p>
                            <p>
                                <input name="group1" type="radio" id="test8" />
                                <label for="test8">Malviya Nagar</label>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <p class="filter-header">Prices</p>
                        <div class="col s11" style="font-size: 5px;">
                            <p>
                              <input type="checkbox" id="test9" />
                              <label for="test9">2000</label>
                            </p>
                            <p>
                              <input type="checkbox" id="test10" checked="checked" />
                              <label for="test10">4000</label>
                            </p>
                            <p>
                              <input type="checkbox" id="test11" />
                              <label for="test11">6000</label>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <p class="filter-header">Facilities</p>
                        <div class="col s11" style="font-size: 5px;">
                            <p>
                              <input type="checkbox" id="test19" />
                              <label for="test19">Transport vehicle</label>
                            </p>
                            <p>
                              <input type="checkbox" id="test12" checked="checked" />
                              <label for="test12">SUV</label>
                            </p>
                            <p>
                              <input type="checkbox" id="test13" />
                              <label for="test13">Cars</label>
                            </p>
                            <p>
                              <input type="checkbox" id="test14" />
                              <label for="test14">school provides vehicle</label>
                            </p>
                        </div>1
                    </div>
                </div>
            </div>
            <div class="col m8">
                <div class="row">
                    <div class="col s12 m12 l6">
                        <div class="card card-position sticky-action">
                            <div class="card-image waves-effect waves-block waves-light">
                              <img class="activator" src="img/driving-1.jpg">
                            </div>
                            <div class="card-content">
                              <span class="card-title activator grey-text text-darken-4">Mellisa Driving School<i class="material-icons right">more_vert</i></span>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;
                                <a href="" style="color: #2C204A;" class="direction-text">Get directions</a>
                                <a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Mellisa Driving School<i class="material-icons right-cross">close</i></span>
                              <div class="card-reveal-inner">
                                  <p style="color: black;font-size: 1.2em;font-weight: 100;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <div class="row center-align" style="color: #2C204A;">
                                        <div class="col s12">
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                        </div>    
                                    </div>
                                    <div>
                                        <p style="color: #2C204A;" class="center-align" onclick="showReviews('#review-1');">See reviews</p>   
                                            <div class="review" id="review-1">
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                            </div>
                                    </div>  
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="col s12 m12 l6">
                        <div class="card card-position sticky-action">
                            <div class="card-image waves-effect waves-block waves-light">
                              <img class="activator" src="img/School.jpg">
                            </div>
                            <div class="card-content">
                              <span class="card-title activator grey-text text-darken-4">Raul's Driving School<i class="material-icons right">more_vert</i></span>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;
                                <a href="" style="color: #2C204A;" class="direction-text">Get directions</a>
                                <a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Raul's Driving School<i class="material-icons right-cross">close</i></span>
                              <div class="card-reveal-inner">
                                  <p style="color: black;font-size: 1.2em;font-weight: 100;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <div class="row center-align" style="color: #2C204A;">
                                        <div class="col s12">
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                        </div>    
                                    </div>
                                    <div>
                                        <p style="color: #2C204A;" class="center-align" onclick="showReviews('#review-2');">See reviews</p>   
                                            <div class="review" id="review-2">
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                            </div>
                                    </div>  
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l6">
                        <div class="card card-position sticky-action">
                            <div class="card-image waves-effect waves-block waves-light">
                              <img class="activator" src="img/bg-1.jpg">
                            </div>
                            <div class="card-content">
                              <span class="card-title activator grey-text text-darken-4">Rello Driving School<i class="material-icons right">more_vert</i></span>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;
                                <a href="" style="color: #2C204A;" class="direction-text">Get directions</a>
                                <a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Rello Driving School<i class="material-icons right-cross">close</i></span>
                              <div class="card-reveal-inner">
                                  <p style="color: black;font-size: 1.2em;font-weight: 100;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <div class="row center-align" style="color: #2C204A;">
                                        <div class="col s12">
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                        </div>    
                                    </div>
                                    <div>
                                        <p style="color: #2C204A;" class="center-align" onclick="showReviews('#review-3');">See reviews</p>   
                                            <div class="review" id="review-3">
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                            </div>
                                    </div>  
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="col s12 m12 l6">
                        <div class="card card-position sticky-action">
                            <div class="card-image waves-effect waves-block waves-light">
                              <img class="activator" src="img/bg-3.jpg">
                            </div>
                            <div class="card-content">
                              <span class="card-title activator grey-text text-darken-4">Louisa Driving School<i class="material-icons right">more_vert</i></span>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;
                                <a href="" style="color: #2C204A;" class="direction-text">Get directions</a>
                                <a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Louisa Driving School<i class="material-icons right-cross">close</i></span>
                              <div class="card-reveal-inner">
                                  <p style="color: black;font-size: 1.2em;font-weight: 100;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <div class="row center-align" style="color: #2C204A;">
                                        <div class="col s12">
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                        </div>    
                                    </div>
                                    <div>
                                        <p style="color: #2C204A;" class="center-align" onclick="showReviews('#review-4');">See reviews</p>   
                                            <div class="review" id="review-4">
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                            </div>
                                    </div>  
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l6">
                        <div class="card card-position sticky-action">
                            <div class="card-image waves-effect waves-block waves-light">
                              <img class="activator" src="img/bg-header.jpg">
                            </div>
                            <div class="card-content">
                              <span class="card-title activator grey-text text-darken-4">Jacob Driving School<i class="material-icons right">more_vert</i></span>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;
                                <a href="" style="color: #2C204A;" class="direction-text">Get directions</a>
                                <a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Jacob Driving School<i class="material-icons right-cross">close</i></span>
                              <div class="card-reveal-inner">
                                  <p style="color: black;font-size: 1.2em;font-weight: 100;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <div class="row center-align" style="color: #2C204A;">
                                        <div class="col s12">
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                        </div>    
                                    </div>
                                    <div>
                                        <p style="color: #2C204A;" class="center-align" onclick="showReviews('#review-5');">See reviews</p>   
                                            <div class="review" id="review-5">
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                            </div>
                                    </div>  
                              </div>
                            </div>
                          </div>
                    </div>
                    <div class="col s12 m12 l6">
                        <div class="card card-position sticky-action">
                            <div class="card-image waves-effect waves-block waves-light">
                              <img class="activator" src="img/School.jpg">
                            </div>
                            <div class="card-content">
                              <span class="card-title activator grey-text text-darken-4">Jetallo Driving School<i class="material-icons right">more_vert</i></span>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;
                                <a href="" style="color: #2C204A;" class="direction-text">Get directions</a>
                                <a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Jetallo Driving School<i class="material-icons right-cross">close</i></span>
                              <div class="card-reveal-inner">
                                  <p style="color: black;font-size: 1.2em;font-weight: 100;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <div class="row center-align" style="color: #2C204A;">
                                        <div class="col s12">
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                        </div>    
                                    </div>
                                    <div>
                                        <p style="color: #2C204A;" class="center-align" onclick="showReviews('#review-6');">See reviews</p>   
                                            <div class="review" id="review-6">
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                            </div>
                                    </div>  
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l6">
                        <div class="card card-position sticky-action">
                            <div class="card-image waves-effect waves-block waves-light">
                              <img class="activator" src="img/School.jpg">
                            </div>
                            <div class="card-content">
                              <span class="card-title activator grey-text text-darken-4">Jetallo Driving School<i class="material-icons right">more_vert</i></span>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;
                                <a href="" style="color: #2C204A;" class="direction-text">Get directions</a>
                                <a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Jetallo Driving School<i class="material-icons right-cross">close</i></span>
                              <div class="card-reveal-inner">
                                  <p style="color: black;font-size: 1.2em;font-weight: 100;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <div class="row center-align" style="color: #2C204A;">
                                        <div class="col s12">
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                            <span><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></span>
                                        </div>    
                                    </div>
                                    <div>
                                        <p style="color: #2C204A;" class="center-align" onclick="showReviews('#review-7');">See reviews</p>   
                                            <div class="review" id="review-7">
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                                <div class="row">
                                                    <span class="reviewer-name text-left" style="color: grey">sarang kartikey</span>
                                                    <p style="color: black;">It's a very good driving school with lots of facilities.</p>
                                                </div>
                                            </div>
                                    </div>  
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        
    <!-- Footer
    ================================================-->
  </body>
</html>
