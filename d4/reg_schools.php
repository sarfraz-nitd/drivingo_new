<?php
	require_once('connect.php');
	
        $homeURL = "http://finesolution.tk/d3";
	function send_mail($email, $type){
                global $mysqli;
		$hash = md5( rand(0,1000) );
		
		$query = "INSERT INTO `email_act` VALUES ('','$email', '$type', '$hash' )";
		if($query_run = mysqli_query($mysqli, $query)){
			if(mysqli_affected_rows($mysqli) == 1){
		                     
		                  $url = "http://finesolution.tk/d3/verify_email.php?email=".$email."&key=".$hash."&type=".$type;

				$subject = "Verify Your Email to activate your account on Drivingo ";
				$txt = "Click on the link to verify your account \n".urldecode($url);
				$headers = "From: noreply@drivingo.in";
					
				if(mail($email,$subject,$txt,$headers)){
					return true;
				}
			}
		}
		
		
	}

        function upload_image($email){
            
            $target_dir = "uploads/".$email;
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_dir.="/";
            echo $file_name = $_FILES['d_cover_photo']['name'];
            echo $file_tmp = $_FILES['d_cover_photo']['tmp_name'];
             if(move_uploaded_file($file_tmp,$target_dir.'cover_photo.jpg')){
                   echo 'success';
             }else echo 'file upload failed';
        }

	
	if(isset($_POST['reg_d_school'])){
		$oname = mysqli_real_escape_string($mysqli, $_POST['o_name']);
		$d_name = mysqli_real_escape_string($mysqli, $_POST['d_school_name']);
		$d_email = mysqli_real_escape_string($mysqli, $_POST['d_email']);
		$d_phone = mysqli_real_escape_string($mysqli, $_POST['d_phone']);
		$d_pass = mysqli_real_escape_string($mysqli, $_POST['d_password']);
		$d_cpass = mysqli_real_escape_string($mysqli, $_POST['d_confirm_password']);
		$d_abt = mysqli_real_escape_string($mysqli, $_POST['d_about']);
		$d_add = mysqli_real_escape_string($mysqli, $_POST['d_address']);
		$services = $_POST['services'];
        $lat = mysqli_real_escape_string($mysqli, $_POST['lat']);
        $lng = mysqli_real_escape_string($mysqli, $_POST['lng']);
		$s='';
		if(!empty($services)){
			$n = count($services);
			for($i = 0; $i< $n; $i++){
				if($i==$n-1) $s.= $services[$i];
				else $s.= $services[$i].'/';
			}
		}
		
		if($d_pass != $d_cpass){
			echo 'Password Mismatch';
		}else{
			echo $query = "SELECT * FROM `schools` where `email` = '$d_email' ";
			if($query_run = mysqli_query($mysqli,$query)){
				if(mysqli_num_rows($query_run)>=1){
					echo 'User Already registered';
				}else{
					echo $query = "INSERT INTO `schools`VALUES ('','".$oname."', '".$d_name."','".$d_email."', '".$d_phone."', '".$d_pass."', '".$d_abt."', '".$d_add."' , '".$s."', 0,'".$lat."','".$lng."')";
					if($query_run = mysqli_query($mysqli, $query)){
						if(mysqli_affected_rows($mysqli) == 1){
							send_mail($d_email, 'd_school');
                                                        upload_image($d_email);
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

