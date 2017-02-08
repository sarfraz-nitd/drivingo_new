<?php

session_start();
	require_once('connect.php');
	$email = $_GET['email'];
	$key = $_GET['key'];
	$type = $_GET['type'];
	$homeURL = "http://finesolution.tk/d3/index.php";
	
	
		$query = "SELECT * FROM `email_act` WHERE `email`= '$email' AND `key` = '$key' AND `type` = '$type'";
		if($query_run = mysqli_query($mysqli, $query)){
			if(mysqli_affected_rows($mysqli) >= 1){
				// delete from table email activation and change act in table schools
				$query = "DELETE FROM `email_act` WHERE `email`= '$email' AND `key` = '$key' AND `type` = '$type'";
				if($query_run = mysqli_query($mysqli, $query)){
                                        if($type == 'd_school')
					      $query = "UPDATE `schools` SET `authorized`='1' WHERE `email` = '$email'";
                                        else

					      $query = "UPDATE `users` SET `authorized`='1' WHERE `email` = '$email'";
					if($query_run = mysqli_query($mysqli, $query)){
                                                $_SESSION['activated'] = "true";
                                                $_SESSION['loggedin'] = $email;
 						header('Location: '.$homeURL.'');
					}
				}
			}else{
				echo 'Invalid Link';
			}
		}
	
?>