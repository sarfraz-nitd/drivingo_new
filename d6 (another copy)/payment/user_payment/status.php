<?php

	$status = $_GET['status'];
	$pid = $_GET['pid'];

?>

<html>
	<head>
		<style>
			body{
				background: #C04848;
				background: -webkit-linear-gradient(to left, #C04848 , #480048);
				background: linear-gradient(to left, #C04848 , #480048);
			}	

			.box{
				position: relative;
				height: 600px;
				width: 750px;
				background: white;
				left: 28%;
				top: 9em;
				box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
			}

			.status{
				font-size: 3em;
				font-weight: 100;
				color: green;
				text-align: center;
				padding: 2em;
			}

			.mojoid{
				text-align: center;
				font-size: 1.5em;
				font-weight: 200;
				color: grey;
			}

			.mojoid span{
				color: turquoise;
			}

			@media only screen and (max-width: 768px){
				.box {
				    position: relative;
				    height: 46%;
				    width: 90%;
				    background: white;
				    left: 5%;
				    top: 6em;
				    box-shadow: 0px 6px 50px 0px rgba(26,20,26,1);
				}

				.status {
				    font-size: 2em;
				    font-weight: 100;
				    color: green;
				    text-align: center;
				    padding: 2em;
				}

				.mojoid {
				    text-align: center;
				    font-size: 1.2em;
				    font-weight: 200;
				    color: grey;
				    margin-top: -60px;
				}
			}
		</style>
	</head>
	<body>
		<div class="box">
			
			<p class="status"><?php if($status == 'success') echo 'SUCCESS!'; else echo '<span style="color: red;">FAILED!</span>'; ?></p>
			<p class="mojoid">Your payment id is <span><?php echo $pid; ?></span><br>Please note it for future reference!</p>
		</div>
	</body>
</html>