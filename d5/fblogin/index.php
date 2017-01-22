<?php

require_once('../connect.php');
/* INCLUSION OF LIBRARY FILEs*/
	require_once( 'lib/Facebook/FacebookSession.php');
	require_once( 'lib/Facebook/FacebookRequest.php' );
	require_once( 'lib/Facebook/FacebookResponse.php' );
	require_once( 'lib/Facebook/FacebookSDKException.php' );
	require_once( 'lib/Facebook/FacebookRequestException.php' );
	require_once( 'lib/Facebook/FacebookRedirectLoginHelper.php');
	require_once( 'lib/Facebook/FacebookAuthorizationException.php' );
	require_once( 'lib/Facebook/GraphObject.php' );
	require_once( 'lib/Facebook/GraphUser.php' );
	require_once( 'lib/Facebook/GraphSessionInfo.php' );
	require_once( 'lib/Facebook/Entities/AccessToken.php');
	require_once( 'lib/Facebook/HttpClients/FacebookCurl.php' );
	require_once( 'lib/Facebook/HttpClients/FacebookHttpable.php');
	require_once( 'lib/Facebook/HttpClients/FacebookCurlHttpClient.php');

/* USE NAMESPACES */
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphUser;
	use Facebook\GraphSessionInfo;
	use Facebook\FacebookHttpable;
	use Facebook\FacebookCurlHttpClient;
	use Facebook\FacebookCurl;

/*PROCESS*/
	
	//1.Stat Session
	 session_start();

	//check if users wants to logout
	 if(isset($_REQUEST['logout'])){
	 	unset($_SESSION['fb_token']);
		session_destroy();
		echo "<script type='text/javascript'>window.location.href = '../index.php';</script>";
	 }
	
	//2.Use app id,secret and redirect url 
	$app_id = '1154406691302161';
	$app_secret = '35164cd9da91fd86b18b115c5d959b07';
	//$redirect_url='http://drivingo.in/beta/fblogin/';
	$redirect_url='http://localhost/drivingo_new/d5/fblogin/';

	//3.Initialize application, create helper object and get fb sess
	 FacebookSession::setDefaultApplication($app_id,$app_secret);
	 $helper = new FacebookRedirectLoginHelper($redirect_url);
	 $sess = $helper->getSessionFromRedirect();

	 //check if facebook session exists
	if(isset($_SESSION['fb_token'])){
		$sess = new FacebookSession($_SESSION['fb_token']);
		try{
			$sess->Validate($app_id, $app_secret);
		}catch(FacebookAuthorizationException $e){
			print_r($e);
		}
	}

	
	$loggedin = false;
	//get email as well with user permission
	$login_url = $helper->getLoginUrl(array('email'));
	//logout
	$logout = 'http://localhost/drivingo_new-master_3/drivingo_new-master/d4/fblogin/index.php?logout=true';

	//4. if fb sess exists echo name 
	 	if(isset($sess)){
	 		//store the token in the php session
	 		$_SESSION['fb_token']=$sess->getToken();
	 		//create request object,execute and capture response
	 		$request = new FacebookRequest($sess,'GET','/me?fields=id,gender,email,name');
			// from response get graph object
			$response = $request->execute();
			$graph = $response->getGraphObject(GraphUser::classname());
			// use graph object methods to get user details
			$id = $graph->getId();
			$name= $graph->getName();
			$email = $graph->getProperty('email');
			$gender = $graph->getProperty('gender');
			$image = 'https://graph.facebook.com/'.$id.'/picture?width=300';
			$loggedin  = true;
			if(insertIntoDb($id, $name, $email, $gender, $image)){
				//echo "<script type='text/javascript'>window.location.href = 'index.php?logout=true';</script>";
				echo $query1 = "SELECT * FROM `fblogin` WHERE  `fbId` = '".$id."'";
						if($query1_run = mysqli_query($mysqli, $query1)){
							if(mysqli_num_rows($query1_run)>=1){
								while($row = mysqli_fetch_assoc($query1_run)){
									$_SESSION['id'] = $row['id'];
									$_SESSION['login_type'] = "facebook";
								}
							} 
						}
						
						echo "<script type='text/javascript'>window.location.href = '../index.php';</script>";
			}
	}else{
			echo "<script type='text/javascript'>window.location.href = '".$login_url."';</script>";
	}
	
	//function to insert data in database
	function insertIntoDb($id, $name, $email, $gender, $image){
		global $mysqli;
		$query = "SELECT * FROM `fblogin` WHERE  `fbId` = '".$id."' ";;
		if($query_run = mysqli_query($mysqli, $query)){
			if(mysqli_num_rows($query_run)>=1){
				//update
				$query = "UPDATE `fblogin` SET `name`='".$name."',`email`='".$email."',`gender`='".$gender."',`image`='".$image."' WHERE  `fbId`= '".$id."'";
				if($query_run = mysqli_query($mysqli, $query)){
					return true;
				}
			}else{
				//insert
				$query = "INSERT INTO `fblogin`(`id`, `fbId`, `name`, `email`, `gender`, `image`) VALUES ('','".$id."','".$name."','".$email."','".$gender."','".$image."')";
				if($query_run = mysqli_query($mysqli, $query)){
					if(mysqli_affected_rows($mysqli)==1){
						return true;
					}
				}
			}
		}
		return false;
	}

?>


