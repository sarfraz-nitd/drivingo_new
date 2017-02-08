<?php
	session_start();
	require_once('connect.php');
	
	if(isset($_POST['change'])){
		for($i=0;$i<$_SESSION['count'];$i++){
			if(isset($_POST['btn'.$i])){
				$id = $_POST['id'];
				$type = $_POST['type'];
				if($type=='enable'){
					$query = "UPDATE `schools` SET `authorized`='2' WHERE `id` = '".$id."' ";
				}else{
					$query = "UPDATE `schools` SET `authorized`='1' WHERE `id` = '".$id."' ";
				}
				if($query_run = mysqli_query($mysqli, $query)){
					if(mysqli_affected_rows($mysqli) >=1){
						echo "Status Successfully Change";
					}
				}else echo 'Some Error Occured';
			}
		}
	}
	$_SESSION['count']=0;
?>

<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
	<center>
		Schools To Be Approved
		<table>
  <tr>
    <th>Owner's Name</th>
    <th>School Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>About</th>
    <th>Address</th>
    <th>Services</th>
    <th>Approve</th>
    
  </tr>
  <?php
	$query = "SELECT * FROM `schools`";
	if($query_run = mysqli_query($mysqli, $query)){
		$i=0;
		
		while($row = mysqli_fetch_assoc($query_run)){
			?>
		  <tr>
			<td><?php echo $row['owners_name'];?></td>
			<td><?php echo $row['schools_name'];?></td>
			<td><?php echo $row['email'];?>	</td>
			<td>	<?php echo $row['phone'];?></td>
			<td>	<?php echo $row['about'];?></td>
			<td><?php echo $row['address'];?>	</td>
			<td>	<?php echo $row['services'];?></td>
			<td>
				<form action="auth_schools.php" method="POST" >
					<input type="hidden" name="change"/>
					<input type="hidden" value="<?php echo $row['id']; ?>" name="id" >
					<?php
						
						$s = $row['authorized'];
						if($s == 0){
							echo 'Email Not Verified';
						}else if($s==1){
							echo "<input type='submit' value='Enable' name='btn".$i."' >";
							echo "<input type='hidden' value='enable' name='type' />";
						}else{
							echo "<input type='submit' value='Disable' name='btn".$i."'>";
							echo "<input type='hidden' value='disable' name='type' />";
						}
						$i++;
						$_SESSION['count']++;
					?>
				</form>
			</td>
		  </tr>

			
			<?php
		}
	}
  
  ?>

</table>
	</center>
</html>