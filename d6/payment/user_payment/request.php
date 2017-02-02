<?php

require('../../connect.php');

if(isset($_POST['pay'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$amount = $_POST['amount'];
	$purpose = $_POST['purpose'];
	$user_id = $_POST['user_id'];
	$school_id = $_POST['school_id'];
	$package_id = $_POST['package_id'];
	$tb = $_POST['tb'];
	$table = "";

	if($tb == 3){
	    $table = "fb_schools";
	  }else if($tb == 2){
	    $table = "g_schools";
	  }else if($tb == 1){
	    $table = "schools";
	  }
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER,
	            array("X-Api-Key:bcb810ff7da9b88b4f27cbf40052a04e",
	                  "X-Auth-Token:bb6aa696a5fe8d968f4fd0beb26aabb6"));
	$payload = Array(
	    'purpose' => $purpose,
	    'amount' => $amount,
	    'phone' => $phone,
	    'buyer_name' => $name,
	    'redirect_url' => 'http://drivingo.in/payment/user_payment/redirect.php',
	    'send_email' => true,
	    'webhook' => 'http://drivingo.in/payment/user_payment/webhook.php',
	    'send_sms' => true,
	    'email' => $email,
	    'allow_repeated_payments' => false
	);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
	$response = curl_exec($ch);
	curl_close($ch); 
	
	//echo $response;
	
	$data = json_decode($response,true);
	
	$status = $data['success'];
	
	if($status){
		$prid = $data['payment_request']['id'];
		$longurl = $data['payment_request']['longurl'];
		if(enter_into_db($user_id, $school_id, $package_id, $prid)){
			header('Location: '.$longurl);
		}
	
	}
}



function enter_into_db($user_id, $school_id, $package_id, $prid){
	global $mysqli;
	$query = "INSERT INTO `userPayment`(`id`, `type`, `user_id`, `school_id`, `package_id`, `prid`) VALUES ('','".$table."','".$user_id."','".$school_id."','".$package_id."','".$prid."')";
	if($query_run = mysqli_query($mysqli, $query)){
		if(mysqli_affected_rows($mysqli)>0){
			return true;
		}
	} else {
		echo mysqli_error($mysqli);
	}
	return false;
}

?>