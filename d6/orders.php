<!DOCTYPE html>
<!DOCTYPE html>
<html>
	<head>
		<title>My orders</title>
		<meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    
	    <link rel="stylesheet" href="materialize/css/materialize.min.css">
	    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	    
	    <link href='//fonts.googleapis.com/css?family=Alegreya Sans' rel='stylesheet'>
	    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>


		<script>
			

		</script>


		<style>
			
			body{
				background: #C04848; /* fallback for old browsers */
	            background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
	            background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+,*/
	            margin: 8px;
			}

			.gradient{
				background: #C04848; /* fallback for old browsers */
	            background: -webkit-linear-gradient(to left, #C04848 , #480048); /* Chrome 10-25, Safari 5.1-6 */
	            background: linear-gradient(to left, #C04848 , #480048); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+,*/
			}

			table {
			    border-collapse: collapse;
			    border-spacing: 0;
			    width: 100%;
			    border: 1px solid #ddd;
			}

			th, td {
			    border: none;
			    text-align: left;
			    padding: 8px;
			}

			tr:nth-child(even){background-color: #f2f2f2;}

			tr:nth-child(odd){ color: white;}

		</style>
	</head>
	<body>

		<div class="row">
			<h3 class="center-align" style="color: white; font-family: 'Alegreya Sans';">ORDERS</h3>
		</div>

		<div style="overflow-x:auto;">
		  <table>
		    <tr style="box-shadow: 0px 6px 20px 0px rgba(26,20,26,1);color: white;font-size: 1.5em;font-family: 'Alegreya Sans';">
		      <th>Serial No.</th>
		      <th>User Name</th>
		      <th>Package Name</th>
		      <th>Mode of Payment</th>
		      <th>Price</th>
		      <th>Time</th>
		      <th>Action</th>
		    </tr>
		    <tr>
		      <td>1.</td>
		      <td>Sarang kartikey</td>
		      <td>Cars</td>
		      <td>Cash on delivery</td>
		      <td>Rs. 3000</td>
		      <td>12.00.11</td>
		      <td><input type="button" value="approve" /></td>
		    </tr>
		    <tr>
		      <td>2.</td>
		      <td>Sarang kartikey</td>
		      <td>Cars</td>
		      <td>Cash on delivery</td>
		      <td>Rs. 3000</td>
		      <td>12.00.11</td>
		      <td><input type="button" value="approve" /></td>
		    </tr>
		    <tr>
		      <td>3.</td>
		      <td>Sarang kartikey</td>
		      <td>Cars</td>
		      <td>Cash on delivery</td>
		      <td>Rs. 3000</td>
		      <td>12.00.11</td>
		      <td><input type="button" value="approve" /></td>
		    </tr>
		  </table>
		</div>

	</body>
</html>