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
		
		$level = $_POST['level'];
		$eventdate = $_POST['eventdate'];
		$eventname = $_POST['eventname'];
		
		$query = "INSERT INTO `oulcdb`.`calendar` (`priority`, `date`, `name`, `status`) VALUES ('".$level."', '".$eventdate."', '".$eventname."', 'Active')";
		
		$updatedatabase = mysqli_query($dbc, $query);
		
		header("Location: agendaview.php");
	?>
</html>