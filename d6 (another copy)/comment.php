<?php

	require('connect.php');

	if(isset($_POST['school_id']) && isset($_POST['school_table']) && isset($_POST['user_id']) && isset($_POST['user_type']) && isset($_POST['user_table']) && isset($_POST['comment'])){

			$school_id = $_POST['school_id'];
			$school_table = $_POST['school_table'];
			$user_id = $_POST['user_id'];
			$user_type = $_POST['user_type'];
			$user_table = $_POST['user_table'];
			$comment = $_POST['comment'];

			$query = "INSERT INTO comments (school_id, school_table, user_id, user_type, user_table, comment) VALUES('".$school_id."', '".$school_table."', '".$user_id."', '".$user_type."', '".$user_table."', '".$comment."')";

			if(mysqli_query($mysqli, $query)){
				$query1 = "SELECT * FROM comments WHERE school_id = '".$school_id."'";
				if($query1_run = mysqli_query($mysqli, $query1)){
					if(($num_rows = mysqli_num_rows($query1_run)) > 0){
						$json_string = '[';
						$i = 0;

						while($row = mysqli_fetch_assoc($query1_run)){
							$name = "";
							$picture = "";
							if($row['user_type'] == 'user'){
								if($row['user_table'] == 'g_users'){
									$first_name = get_field($row['user_table'], 'first_name', $row['user_id']);
									$last_name = get_field($row['user_table'], 'last_name', $row['user_id']);
									$picture = get_field($row['user_table'], 'picture', $row['user_id']);
									$name = $first_name.' '.$last_name;
								} else if($row['user_table'] == 'fb_users'){
									$name = get_field($row['user_table'], 'name', $row['user_id']);
									$picture = get_field($row['user_table'], 'image', $row['user_id']);
								} else if($row['user_table'] == 'users'){
									$name = get_field($row['user_table'], 'name', $row['user_id']);
									$picture = 'uploads/'.get_field($row['user_table'], 'email', $row['user_id']).'/cover_photo.jpg';
								}
							} else if($row['user_type'] == 'school'){
								if($row['user_table'] == 'g_users'){
									$first_name = get_field($row['user_table'], 'first_name', $row['user_id']);
									$last_name = get_field($row['user_table'], 'last_name', $row['user_id']);
									$picture = get_field($row['user_table'], 'picture', $row['user_id']);
									$name = $first_name.' '.$last_name;
								} else if($row['user_table'] == 'schools'){
									$name = get_field($row['user_table'], 'owners_name', $row['user_id']);
									$picture = get_field($row['user_table'], 'image', $row['user_id']);
								} else {
									$name = get_field($row['user_table'], 'name', $row['user_id']);
									$picture = 'uploads/'.get_field($row['user_table'], 'email', $row['user_id']).'/cover_photo.jpg';
								}
							}

							$comment = get_field('comments', 'comment', $row['id']);
							$time = get_field('comments', 'time', $row['id']);
							$json_string .= '{"comment":"'.$comment.'","name":"'.$name.'","time":"'.$time.'","picture":"'.$picture.'"}';
	                        if($i<$num_rows-1)
	                            $json_string .=',';
	                        $i++;
	                    }

	                    $json_string .= ']';
	                    echo $json_string;
					} else {
						echo 'no_comments';
					}
				} else {
					echo mysqli_error();
				}
			} else {
				echo 'insert_error';
			}

	} else {
		echo 'comment_error';
	}


	function get_field($table, $field, $id){
		global $mysqli;
		$query = "SELECT $field FROM $table WHERE id = $id";
		if($query_run = mysqli_query($mysqli, $query)){
			if(mysqli_num_rows($query_run) > 0){
				while($row = mysqli_fetch_assoc($query_run)){
					return $row[$field];
				}
			} else {
				return 'no_field';
			}
		} else {
			return mysqli_error();
		}
	}

	

?>