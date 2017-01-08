<?php  
    require("search_dbinfo.php");

    // Get parameters from URL
    $center_lat = $_GET["lat"];
    $center_lng = $_GET["lng"];
    $radius = $_GET["radius"];

    // Start XML file, create parent node
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);

    if (!@($mysqli = new mysqli("127.0.0.1", "root", "", "drivingo"))||$mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
else
	//echo 'Ok.';

    // Search the rows in the markers table
    $query = sprintf("SELECT id, owners_name, schools_name, email, phone, about, services, address, authorized, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM schools HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
      mysqli_real_escape_string($mysqli, $center_lat),
      mysqli_real_escape_string($mysqli, $center_lng),
      mysqli_real_escape_string($mysqli, $center_lat),
      mysqli_real_escape_string($mysqli, $radius));
    $result = mysqli_query($mysqli, $query);
    if (!$result) {
      die("Invalid query: " . mysql_error());
    }

    header("Content-type: text/xml");

    // Iterate through the rows, adding XML nodes for each
    while ($row = @mysqli_fetch_assoc($result)){
      if($row['authorized'] == 2){
          $node = $dom->createElement("marker");
          $newnode = $parnode->appendChild($node);
          $newnode->setAttribute("id", $row['id']);
          $newnode->setAttribute("owners_name", $row['owners_name']);
          $newnode->setAttribute("schools_name", $row['schools_name']);
          $newnode->setAttribute("email", $row['email']);
          $newnode->setAttribute("phone", $row['phone']);
          $newnode->setAttribute("about", $row['about']);
          $newnode->setAttribute("services", $row['services']);
          $newnode->setAttribute("address", $row['address']);
          $newnode->setAttribute("lat", $row['lat']);
          $newnode->setAttribute("lng", $row['lng']);
          $newnode->setAttribute("distance", $row['distance']);
      }
    }

    echo $dom->saveXML();
?>