
<?php

require('../../connect.php');

/*
Basic PHP script to handle Instamojo RAP webhook.
*/

$data = $_POST;
$mac_provided = $data['mac'];  // Get the MAC from the POST data
unset($data['mac']);  // Remove the MAC key from the data.
$ver = explode('.', phpversion());
$major = (int) $ver[0];
$minor = (int) $ver[1];
if($major >= 5 and $minor >= 4){
     ksort($data, SORT_STRING | SORT_FLAG_CASE);
}
else{
     uksort($data, 'strcasecmp');
}
// You can get the 'salt' from Instamojo's developers page(make sure to log in first): https://www.instamojo.com/developers
// Pass the 'salt' without <>
$mac_calculated = hash_hmac("sha1", implode("|", $data), "290aeafc7b074dc49016d713a74aabab");
if($mac_provided == $mac_calculated){

    	$pid = $data['payment_id'];
	$amount = $data['amount'];
	$buyer_email = $data['buyer'];
	$buyer_name = $data['buyer_name'];
	$buyer_phone = $data['buyer_phone'];
	$purpose = $data['purpose'];
	$prid = $data['payment_request_id'];

    if($data['status'] == "Credit"){
        $query = "UPDATE `userPayment` SET `pid`='".$pid."',`status`='success',`amount`='".$amount."',`buyer_email`='".$buyer_email."',`buyer_name`='".$buyer_name."',`buyer_phone`='".$buyer_phone."',`purpose`='".$purpose."' WHERE `prid` = '".$prid."'";
        if($query_run = mysqli_query($mysqli, $query)){
        	
        } 
    }
    else{
    	   	
        $query = "UPDATE `userPayment` SET `pid`='".$pid."',`status`='failed',`amount`='".$amount."',`buyer_email`='".$buyer_email."',`buyer_name`='".$buyer_name."',`buyer_phone`='".$buyer_phone."',`purpose`='".$purpose."' WHERE `prid` = '".$prid."'";
        if($query_run = mysqli_query($mysqli, $query)){
        	
        }
    }
}
else{
    echo "MAC mismatch";
}
?>