<html>
	<?php
		session_start();
		require_once('mysql_connect.php');
		
		$usertype = $_SESSION['usertype'];
		$logticket = $_SESSION['logticket'];
		$username = $_SESSION['username'];
		$_SESSION['username'] = $username;
		$_SESSION['logticket'] = $logticket;
		
		$query = "SELECT firstName, lastName
					FROM users
					WHERE username = '".$username."';";
					
		$querying = mysqli_query($dbc, $query);
		
		while ($row = $querying->fetch_assoc())
		{
			$name = $row['firstName']." ".$row['lastName'];
		}
		
		$entry = $_GET['no'];
		
		$query = "UPDATE `oulcdb`.`calendar` SET `status`='Completed' WHERE `entryNo`='".$entry."';";
		
		$updatedatabase = mysqli_query($connect, $query);
		
		header("Location: agendaview.php");
	?>
</html>