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
			
					redirect($schoolId);

				} else {
					echo mysqli_error($msyqli);
				}

			} else {
				
				$query2 = "INSERT INTO profile_school (school_id, about) VALUES($schoolId, '$about')";
				if($query2_run = mysqli_query($mysqli, $query2)){
					echo 'success';
			
					redirect($schoolId);

				} else {
					echo mysqli_error($mysqli);
				}

			}

		} else {

			echo mysqli_error($mysqli);
		}
	} else {
		redirect($_POST['schoolId']);
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

			redirect($schoolId);

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

			redirect($schoolId);
		} else {
			echo mysqli_error($mysqli);
		}
	}

	if(isset($_POST['schoolId'])&&isset($_FILES['file'])){
		$filename = $_FILES['file']['name'];
		$tmp_filename = $_FILES['file']['tmp_name'];
		$schoolId = $_POST['schoolId'];

		if($semail = getSid($schoolId)){
			$directory = "uploads/$semail/gallery";
			if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
			
				

				// Returns array of files
				$files = scandir($directory);

				// Count number of files and store them to variable..
				$num_files = count($files)-2;
				$imageFileType = pathinfo($filename,PATHINFO_EXTENSION);

				if(move_uploaded_file($tmp_filename, $directory.'/'.($num_files+1).'.'.$imageFileType)){
					echo 'uploaded';

					redirect($schoolId);

				}else{
					echo 'fail';
				}
			
			
		}

		
	}

	function getSid($sid){
		global $mysqli;
		$query = "SELECT * from `schools` where `id` = '".$sid."'";
		if($query_run = mysqli_query($mysqli, $query)){
			if(mysqli_num_rows($query_run)>=1){
				$row = mysqli_fetch_assoc($query_run);
				return $row['email'];
			}
		}
		return false;
	}

	function redirect($id){
		header('Location: profile.php?hash='.$id);
	}

?>