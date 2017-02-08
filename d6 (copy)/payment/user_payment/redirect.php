<?php

	$prid = $_GET['payment_request_id'];
	$pid = $_GET['payment_id'];
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://www.instamojo.com/api/1.1/payment-requests/$prid/$pid/");
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER,
	            array("X-Api-Key:bcb810ff7da9b88b4f27cbf40052a04e",
	                  "X-Auth-Token:bb6aa696a5fe8d968f4fd0beb26aabb6"));
	$payload = Array(
	    'purpose' => 'FIFA 16',
	    'amount' => '2500',
	    'phone' => '9999999999',
	    'buyer_name' => 'John Doe',
	    'redirect_url' => 'http://www.example.com/redirect/',
	    'send_email' => true,
	    'webhook' => 'http://www.example.com/webhook/',
	    'send_sms' => true,
	    'email' => 'foo@example.com',
	    'allow_repeated_payments' => false
	);
	$response = curl_exec($ch);
	curl_close($ch); 
	
	$data = json_decode($response,true);
	
	$success = $data['success'];
	
	if($success){
		$payment = $data['payment_request']['payment'];
		$status = $payment['status'];
		if($status == 'Credit'){
			header('Location: status.php?status=success&pid='.$pid);	
		} else {
			header('Location: status.php?status=fail&pid='.$pid);
		}
	}
	

?>