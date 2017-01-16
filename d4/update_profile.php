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
			
					$url = 'profile.php';
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

					echo $result;

					//var_dump($result);

				} else {
					echo mysqli_error($mysqli);
				}

			}

		} else {

			echo mysqli_error($mysqli);
		}
	}

	if(isset($_POST['schoolId'])&&isset($_POST['package_name'])&&isset($_POST['price'])){
		$package_name = $_POST['package_name'];
		$schoolId = $_POST['schoolId'];
		$price = $_POST['price'];
		$detail_one = $_POST['detail_one'];
		$detail_two = $_POST['detail_two'];
		$detail_three = $_POST['detail_three'];

		$query1 = "INSERT INTO packages (school_id, package_name, price, detail_one, detail_two, detail_three) VALUES($schoolId, '$package_name', $price, '$detail_one', '$detail_two', '$detail_three')";
		if($query1_run = mysqli_query($mysqli, $query1)){
			echo "inserted into packages.";

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

		} else {
			echo mysqli_error($mysqli);
		}
	}

	if(isset($_POST['package_id'])&&isset($_POST['schoolId'])){
		$package_id = $_POST['package_id'];
		$schoolId = $_POST['schoolId'];

		$query3 = "DELETE FROM packages WHERE id = $package_id";
		if(mysqli_query($mysqli, $query3)){
			echo 'successfully deleted';

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
		} else {
			echo mysqli_error($mysqli);
		}
	}

?>