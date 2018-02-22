<?php
	session_start();
	
	$logticket = $_SESSION['logticket'];
	
	$_SESSION = array();
	
	$connect = mysqli_connect('localhost','root','p@ssword','oulcdb');
	
	if (!$connect) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}
	
	setcookie('PHPSESSID','',time()-300,'/','',0);
	
	$query = "UPDATE `oulcdb`.`login` SET `outTime` = NOW() WHERE `loginTicket` = {$logticket};";
	
	$result = mysqli_query($connect, $query);
	
	header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/login.php");
?>
