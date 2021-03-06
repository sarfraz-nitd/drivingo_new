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
    <link rel="stylesheet" href="css/search.css">
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
          createMarker(curLatLng, "Your location", "", "", "",curAddress,"",image);
         
         var radius = document.getElementById('radiusSelect').value;
         var searchUrl = 'include/search_genxml.php?lat=' + lat + '&lng=' + lng + '&radius=' + radius;
         downloadUrl(searchUrl, function(data) {
           var xml = parseXml(data);
           var markerNodes = xml.documentElement.getElementsByTagName("marker");
             
             if(!markerNodes.length){
                 alert('No result found! please try increasing the radius.');
             }
                
           for (var i = 0; i < markerNodes.length; i++) {
             var schools_name = markerNodes[i].getAttribute("schools_name");
             var email = markerNodes[i].getAttribute("email");
             var phone = markerNodes[i].getAttribute("phone");
             var services = markerNodes[i].getAttribute("services");
             var address = markerNodes[i].getAttribute("address");
             var distance = Math.ceil(parseFloat(markerNodes[i].getAttribute("distance")));
             var latlng = new google.maps.LatLng(
                  parseFloat(markerNodes[i].getAttribute("lat")),
                  parseFloat(markerNodes[i].getAttribute("lng")));

             createMarker(latlng, schools_name, email, phone, services, address, distance, "");
             bounds.extend(latlng);
           }
             
            //FOR DISPLAYING CARDS
             
            var k = markerNodes.length;
            var oldData, str;
             
            if(k%2 == 0){
                
                for(i=0;i<k;i+=2){
                     /*var owners_name = markerNodes[i].getAttribute("owners_name");
                     var schools_name = markerNodes[i].getAttribute("schools_name");
                     var email = markerNodes[i].getAttribute("email");
                     var phone = markerNodes[i].getAttribute("phone");
                     var about = markerNodes[i].getAttribute("about");
                     var services = markerNodes[i].getAttribute("services");
                     var address = markerNodes[i].getAttribute("address");
                     var distance = Math.ceil(parseFloat(markerNodes[i].getAttribute("distance")));
                     var id = markerNodes[i].getAttribute("id");*/

                     oldData = $('#cards-wrapper').html();

                     str = oldData +

                       '<div class="row">' +
                            '<div class="col s12 m12 l6">' +
                                '<div class="card card-position sticky-action">' +
                                    '<div class="card-image waves-effect waves-block waves-light">' +
                                      '<img class="activator" src="' + 'uploads/' + markerNodes[i].getAttribute("email") + '/cover.jpg' +'">' +
                                    '</div>' +
                                    '<div class="card-content">' +
                                      '<span class="card-title activator grey-text text-darken-4">' + markerNodes[i].getAttribute("schools_name") + '<i class="material-icons right">more_vert</i></span>' +
                                    '</div>' +
                                    '<div class="card-action">' +
                                        '<button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;' +
                                        '<a href="" style="color: #2C204A;" class="direction-text">Get directions</a>' +
                                        '<a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>' +
                                    '</div>' +
                                    '<div class="card-reveal">' +
                                      '<span class="card-title grey-text text-darken-4">' + markerNodes[i].getAttribute("schools_name") + '<i class="material-icons right-cross">close</i></span>' +
                                      '<div class="card-reveal-inner">' +
                                          '<p style="color: black;font-size: 1.2em;font-weight: 300;margin-top: 2em;">' + markerNodes[i].getAttribute("about") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">ADDRESS</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("address") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">DISTANCE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + Math.ceil(parseFloat(markerNodes[i].getAttribute("distance"))) + ' KM' + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">OWNER</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("owners_name") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">EMAIL</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("email") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">PHONE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("phone") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">SERVICES</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("services") + '</p>' +
                                      '</div>' +
                                    '</div>' +
                                  '</div>' +
                            '</div>' +
                            '<div class="col s12 m12 l6">' +
                                '<div class="card card-position sticky-action">' +
                                    '<div class="card-image waves-effect waves-block waves-light">' +
                                      '<img class="activator" src="' + 'uploads/' + markerNodes[i+1].getAttribute("email") + '/cover.jpg' +'">' +
                                    '</div>' +
                                    '<div class="card-content">' +
                                      '<span class="card-title activator grey-text text-darken-4">' + markerNodes[i+1].getAttribute("schools_name") + '<i class="material-icons right">more_vert</i></span>' +
                                    '</div>' +
                                    '<div class="card-action">' +
                                        '<button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;' +
                                        '<a href="" style="color: #2C204A;" class="direction-text">Get directions</a>' +
                                        '<a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>' +
                                    '</div>' +
                                    '<div class="card-reveal">' +
                                      '<span class="card-title grey-text text-darken-4">' + markerNodes[i+1].getAttribute("schools_name") + '<i class="material-icons right-cross">close</i></span>' +
                                      '<div class="card-reveal-inner">' +
                                          '<p style="color: black;font-size: 1.2em;font-weight: 300;margin-top: 2em;">' + markerNodes[i+1].getAttribute("about") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">ADDRESS</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("address") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">DISTANCE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + Math.ceil(parseFloat(markerNodes[i+1].getAttribute("distance"))) + ' KM' + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">OWNER</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("owners_name") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">EMAIL</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("email") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">PHONE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("phone") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">SERVICES</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("services") + '</p>' + 
                                      '</div>' +
                                    '</div>' +
                                  '</div>' +
                            '</div>' +
                        '</div>';
                }
            } else {
                for(i=0; i< k-1; i+=2){
                    oldData = $('#cards-wrapper').html();

                     str = oldData +

                       '<div class="row">' +
                            '<div class="col s12 m12 l6">' +
                                '<div class="card card-position sticky-action">' +
                                    '<div class="card-image waves-effect waves-block waves-light">' +
                                      '<img class="activator" src="' + 'uploads/' + markerNodes[i].getAttribute("email") + '/cover.jpg' +'">' +
                                    '</div>' +
                                    '<div class="card-content">' +
                                      '<span class="card-title activator grey-text text-darken-4">' + markerNodes[i].getAttribute("schools_name") + '<i class="material-icons right">more_vert</i></span>' +
                                    '</div>' +
                                    '<div class="card-action">' +
                                        '<button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;' +
                                        '<a href="" style="color: #2C204A;" class="direction-text">Get directions</a>' +
                                        '<a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>' +
                                    '</div>' +
                                    '<div class="card-reveal">' +
                                      '<span class="card-title grey-text text-darken-4">' + markerNodes[i].getAttribute("schools_name") + '<i class="material-icons right-cross">close</i></span>' +
                                      '<div class="card-reveal-inner">' +
                                          '<p style="color: black;font-size: 1.2em;font-weight: 300;margin-top: 2em;">' + markerNodes[i].getAttribute("about") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">ADDRESS</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("address") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">DISTANCE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + Math.ceil(parseFloat(markerNodes[i].getAttribute("distance"))) + ' KM' + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">OWNER</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("owners_name") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">EMAIL</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("email") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">PHONE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("phone") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">SERVICES</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("services") + '</p>' + 
                                      '</div>' +
                                    '</div>' +
                                  '</div>' +
                            '</div>' +
                            '<div class="col s12 m12 l6">' +
                                '<div class="card card-position sticky-action">' +
                                    '<div class="card-image waves-effect waves-block waves-light">' +
                                      '<img class="activator" src="' + 'uploads/' + markerNodes[i+1].getAttribute("email") + '/cover.jpg' +'">' +
                                    '</div>' +
                                    '<div class="card-content">' +
                                      '<span class="card-title activator grey-text text-darken-4">' + markerNodes[i+1].getAttribute("schools_name") + '<i class="material-icons right">more_vert</i></span>' +
                                    '</div>' +
                                    '<div class="card-action">' +
                                        '<button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;' +
                                        '<a href="" style="color: #2C204A;" class="direction-text">Get directions</a>' +
                                        '<a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>' +
                                    '</div>' +
                                    '<div class="card-reveal">' +
                                      '<span class="card-title grey-text text-darken-4">' + markerNodes[i+1].getAttribute("schools_name") + '<i class="material-icons right-cross">close</i></span>' +
                                      '<div class="card-reveal-inner">' +
                                          '<p style="color: black;font-size: 1.2em;font-weight: 300;margin-top: 2em;">' + markerNodes[i+1].getAttribute("about") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">ADDRESS</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("address") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">DISTANCE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + Math.ceil(parseFloat(markerNodes[i+1].getAttribute("distance"))) + ' KM' + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">OWNER</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("owners_name") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">EMAIL</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("email") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">PHONE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("phone") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">SERVICES</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i+1].getAttribute("services") + '</p>' +
                                      '</div>' +
                                    '</div>' +
                                  '</div>' +
                            '</div>' +
                        '</div>';
                    
                }
                
                
                str += '<div class="row">' +
                            '<div class="col s12 m12 l6">' +
                                '<div class="card card-position sticky-action">' +
                                    '<div class="card-image waves-effect waves-block waves-light">' +
                                      '<img class="activator" src="' + 'uploads/' + markerNodes[i].getAttribute("email") + '/cover.jpg' +'">' +
                                    '</div>' +
                                    '<div class="card-content">' +
                                      '<span class="card-title activator grey-text text-darken-4">' + markerNodes[i].getAttribute("schools_name") + '<i class="material-icons right">more_vert</i></span>' +
                                    '</div>' +
                                    '<div class="card-action">' +
                                        '<button class="btn btn-md btn-subscribe">subscribe</button>&nbsp;&nbsp;&nbsp;' +
                                        '<a href="" style="color: #2C204A;" class="direction-text">Get directions</a>' +
                                        '<a href="" style="color: #2C204A;" class="direction-icon"><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i></a>' +
                                    '</div>' +
                                    '<div class="card-reveal">' +
                                      '<span class="card-title grey-text text-darken-4">' + markerNodes[i].getAttribute("schools_name") + '<i class="material-icons right-cross">close</i></span>' +
                                      '<div class="card-reveal-inner">' +
                                          '<p style="color: black;font-size: 1.2em;font-weight: 300;margin-top: 2em;">' + markerNodes[i].getAttribute("about") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">ADDRESS</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("address") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">DISTANCE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + Math.ceil(parseFloat(markerNodes[i].getAttribute("distance"))) + ' KM' + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">OWNER</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("owners_name") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">EMAIL</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("email") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">PHONE</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("phone") + '</p>' +
                                          '<p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">SERVICES</p>' +
                                          '<p style="color: black;font-size: 1em; font-weight: 300">' + markerNodes[i].getAttribute("services") + '</p>' + 
                                      '</div>' +
                                    '</div>' +
                                  '</div>' +
                            '</div>' +
                        '</div>';
            }
             
             $('#cards-wrapper').html(str);
             
             
            
           map.fitBounds(bounds);
           locationSelect.style.visibility = "visible";
           locationSelect.onchange = function() {
             var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
             google.maps.event.trigger(markers[markerNum], 'click');
           };
          });
        }
        
        function createMarker(latlng, schools_name, email, phone, services, address, distance, image) {
           
          if(schools_name != "Your location"){
              var html = "<div style='color: black;'><b>" + schools_name + "</b> <br/>" + address + "<br/>" + email + "<br/>" + phone + "<br/>" + services + "<br/> <b> distance : " + distance + " KM</div><br/><a onclick='getDirections(\""+ latlng.lat() + "\",\"" + latlng.lng() +"\")' style='color: blue;cursor: pointer;'>Get directions</a>";
          } else {
              var html = "<div style='color: black;'><b>" + schools_name + "</b> <br/>" + address + "<br/></div>";
          }
            

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
            <div class="col m8" id="cards-wrapper" style="color: black;">
                <!--div class="row">
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
                                  <p style="color: black;font-size: 1.2em;font-weight: 300;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">ADDRESS</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">F-6, Pal Market Main Road, Mandawali, New Delhi, Delhi 110092</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">DISTANCE</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">10 KM</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">OWNER</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">Sarang Kartikey</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">EMAIL</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">sarangkartikey50@gmail.com</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">PHONE</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">8962636894</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">SERVICES</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">CARS/SUV</p>
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
                                  <p style="color: black;font-size: 1.2em;font-weight: 300;margin-top: 2em;">Twenty hours in-class. Ten hours in car. Homelink assignment.</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">ADDRESS</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">F-6, Pal Market Main Road, Mandawali, New Delhi, Delhi 110092</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">DISTANCE</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">10 KM</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">OWNER</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">Sarang Kartikey</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">EMAIL</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">sarangkartikey50@gmail.com</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">PHONE</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">8962636894</p>
                                  <p style="color: #EE6F78; font-size: 1.2em; font-weight: 400;">SERVICES</p>
                                  <p style="color: black;font-size: 1em; font-weight: 300">CARS/SUV</p>
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
                </div-->
            </div>
        </div>
    </section>
        
    <!-- Footer
    ================================================-->
  </body>
</html>
