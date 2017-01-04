<?php
	require_once('connect.php');
        $homeURL = "http://finesolution.tk/d2";
	
	function send_mail($email, $type){
		$hash = md5( rand(0,1000) );
		global $mysqli;
		$query = "INSERT INTO `email_act` VALUES ('','$email', '$type', '$hash' )";
		if($query_run = mysqli_query($mysqli, $query)){
			if(mysqli_affected_rows($mysqli) == 1){
				$url = "http://finesolution.tk/d2/verify_email.php?email=".$email."&key=".$hash."&type=".$type;
		
				$subject = "Verify Your Email to activate your account on Drivingo ";
				$txt = "Click on the link to verify your account \n".urldecode($url);
				$headers = "From: noreply@drivingo.in";
					
				if(mail($email,$subject,$txt,$headers)){
					return true;
				}
			}
		}
		
		
	}
	
	if(isset($_POST['reg_user'])){
		$name = $_POST['u_name'];
		$phone = $_POST['u_phone'];
		$email =  $_POST['u_email'];
		$pass = $_POST['u_pass'];
		$cpass = $_POST['u_cpass'];
		
		if($pass != $cpass){
			echo 'Password Mismatch';
		}else{
			echo $query = "SELECT * FROM `users` where `email` = '$email' ";
			if($query_run = mysqli_query($mysqli,$query)){
				if(mysqli_num_rows($query_run)>=1){
					echo 'User Already registered';
				}else{
					echo $query = "INSERT INTO `users`VALUES ('', '$name', '$phone', '$email', '$pass', '$sex', '0')";
					if($query_run = mysqli_query($mysqli, $query)){
						if(mysqli_affected_rows($mysqli) == 1){
							send_mail($email, 'user');
                                                        header('Location: '.$homeURL.'');
						}else{
							echo 'Registration failed';
						}
					}else{
						echo "Some error Occure";
					}
				}
			}else{
				echo "Some error Occured";
			}
		}
		
	}
?>

