<?php  
    //require("search_dbinfo.php");

    session_start();

    // Get parameters from URL
    $center_lat = $_GET["lat"];
    $center_lng = $_GET["lng"];
    $radius = $_GET["radius"];
    $service = $_GET["service"];

    // Start XML file, create parent node
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);
    $mysqli="";

    if (!@($mysqli = new mysqli("localhost", "root", "", "drivingo"))||$mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
else
	//echo 'Ok.';

    // Search the rows in the markers table

  
      $query1 = sprintf("SELECT id, owners_name, schools_name, email, phone, about, services, address, authorized, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM schools HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
        mysqli_real_escape_string($mysqli, $center_lat),
        mysqli_real_escape_string($mysqli, $center_lng),
        mysqli_real_escape_string($mysqli, $center_lat),
        mysqli_real_escape_string($mysqli, $radius));
      $result1 = mysqli_query($mysqli, $query1);
      if (!$result1) {
        die("Invalid query: " . mysql_error());
      }
    
      $query2 = sprintf("SELECT id, name, school_name, email, phone, about, services, address, authorized, image, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM fb_schools HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
        mysqli_real_escape_string($mysqli, $center_lat),
        mysqli_real_escape_string($mysqli, $center_lng),
        mysqli_real_escape_string($mysqli, $center_lat),
        mysqli_real_escape_string($mysqli, $radius));
      $result2 = mysqli_query($mysqli, $query2);
      if (!$result2) {
        die("Invalid query: " . mysql_error());
      }
    
      $query3 = sprintf("SELECT id, first_name, last_name, school_name, email, phone, about, services, address, authorized, picture, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM g_schools HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
        mysqli_real_escape_string($mysqli, $center_lat),
        mysqli_real_escape_string($mysqli, $center_lng),
        mysqli_real_escape_string($mysqli, $center_lat),
        mysqli_real_escape_string($mysqli, $radius));
      $result3 = mysqli_query($mysqli, $query3);
      if (!$result3) {
        die("Invalid query: " . mysql_error());
      }
    

    header("Content-type: text/xml");

    // Iterate through the rows, adding XML nodes for each

    
    

    //schools
    while ($row = @mysqli_fetch_assoc($result1)){
      if($row['authorized'] == 2 && strpos($row['services'], strtoupper($service)) != FALSE){
        $node = $dom->createElement("marker");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("id", $row['id']);
        
        $newnode->setAttribute("schools_name", $row['schools_name']);
        $newnode->setAttribute("email", $row['email']);
        $newnode->setAttribute("phone", $row['phone']);
        $newnode->setAttribute("about", $row['about']);
        $newnode->setAttribute("services", $row['services']);
        $newnode->setAttribute("address", $row['address']);
        $newnode->setAttribute("lat", $row['lat']);
        $newnode->setAttribute("lng", $row['lng']);
        $newnode->setAttribute("distance", $row['distance']);
        $newnode->setAttribute("owners_name", $row['owners_name']);
        $newnode->setAttribute("picture", "uploads/".$row['email']."/cover_photo.jpg");
        $newnode->setAttribute("table", "schools");
        $newnode->setAttribute("price", getPrice($row['id'], 'packages'));

      }
    }

    //google
    while ($row = @mysqli_fetch_assoc($result3)){
      if($row['authorized'] == 2 && strpos($row['services'], strtoupper($service)) != FALSE){
        $node = $dom->createElement("marker");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("id", $row['id']);
        
        $newnode->setAttribute("schools_name", $row['school_name']);
        $newnode->setAttribute("email", $row['email']);
        $newnode->setAttribute("phone", $row['phone']);
        $newnode->setAttribute("about", $row['about']);
        $newnode->setAttribute("services", $row['services']);
        $newnode->setAttribute("address", $row['address']);
        $newnode->setAttribute("lat", $row['lat']);
        $newnode->setAttribute("lng", $row['lng']);
        $newnode->setAttribute("distance", $row['distance']);
        $newnode->setAttribute("owners_name", $row['first_name'].' '.$row['last_name']);
        $newnode->setAttribute("picture", "uploads/".$row['email']."/cover_photo.jpg");
        $newnode->setAttribute("table", "g_schools");
        $newnode->setAttribute("price", getPrice($row['id'], 'packages'));
      }
    }

    //facebook
    while ($row = @mysqli_fetch_assoc($result2)){
      if($row['authorized'] == 2 && strpos($row['services'], strtoupper($service)) != FALSE){
        $node = $dom->createElement("marker");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("id", $row['id']);
        
        $newnode->setAttribute("schools_name", $row['school_name']);
        $newnode->setAttribute("email", $row['email']);
        $newnode->setAttribute("phone", $row['phone']);
        $newnode->setAttribute("about", $row['about']);
        $newnode->setAttribute("services", $row['services']);
        $newnode->setAttribute("address", $row['address']);
        $newnode->setAttribute("lat", $row['lat']);
        $newnode->setAttribute("lng", $row['lng']);
        $newnode->setAttribute("distance", $row['distance']);
        $newnode->setAttribute("owners_name", $row['name']);
        $newnode->setAttribute("picture", "uploads/".$row['email']."/cover_photo.jpg");
        $newnode->setAttribute("table", "fb_schools");
        $newnode->setAttribute("price", getPrice($row['id'], 'packages'));
      }
    }

    echo $dom->saveXML();
    
    function getPrice($id, $table){
        global $mysqli;
        $query = "SELECT min(`price`) AS `min_price` FROM $table GROUP BY `school_id` having `school_id` = $id";
        if($query_run = mysqli_query($mysqli, $query)){
            if(mysqli_num_rows($query_run) > 0){
                while($row = mysqli_fetch_assoc($query_run)){
                    return $row['min_price'];
                }
            } else {
                return -1;
            }
        } else {
            return mysqli_error($mysqli);
        }
    }
?>
