<?php

	require('connect.php');

	if(isset($_POST['about'])&&!empty($_POST['about'])&&isset($_POST['schoolId'])){
		$about = mysqli_real_escape_string($mysqli, $_POST['about']);
		$schoolId = $_POST['schoolId'];

		$query1 = "SELECT * FROM profile_school WHERE school_id = $schoolId";
		if($query1_run = mysqli_query($mysqli, $query1)){

			if(mysqli_num_rows($query1_run) > 0){

				$query2 = "UPDATE profile_school SET about = '$about' WHERE school_id = $schoolId";
				if($query2_run = mysqli_query($mysqli, $query2)){
					echo 'success';
			
					$url = 'https://localhost/drivingo_new/d4/profile.php';
					$data = array('schoolId' => $schoolId);

					// use key 'http' even if you send the request to https://...
					$options = array(
					    'http' => array(
					        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					        'method'  => 'POST',
					        'content' => http_build_query($data)
					    )
					);

					$context  = stream_context_create($options);
					$result = file_get_contents($url, false, $context);
					if ($result === FALSE) { /* Handle error */ 
						echo 'post error';
					}

					echo $result;

					//var_dump($result);

				} else {
					echo mysqli_error($msyqli);
				}

			} else {
				
				$query2 = "INSERT INTO profile_school (school_id, about) VALUES($schoolId, '$about')";
				if($query2_run = mysqli_query($mysqli, $query2)){
					echo 'success';
			
					$url = 'https://localhost/drivingo_new/d4/profile.php';
					$data = array('schoolId' => '$schoolId');

					// use key 'http' even if you send the request to https://...
					$options = array(
					    'http' => array(
					        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					        'method'  => 'POST',
					        'content' => http_build_query($data)
					    )
					);

					$context  = stream_context_create($options);
					$result = file_get_contents($url, false, $context);
					if ($result === FALSE) { /* Handle error */ 
						echo 'post error';
					}

					var_dump($result);

				} else {
					echo mysqli_error($mysqli);
				}

			}

		} else {

			echo mysqli_error($mysqli);
		}
	}

?>