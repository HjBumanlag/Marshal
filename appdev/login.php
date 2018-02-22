<html>
	<head>
		<title>TRACK.IO | Login</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
	</head>
	<body>

		<nav class="navbar navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="background-color: white;">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar" style="background-color: black;"></span>
						<span class="icon-bar" style="background-color: black;"></span>
						<span class="icon-bar" style="background-color: black;"></span>
					</button>
					<a class="navbar-brand" href="#" style="color: white">TRACK.IO</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Not Logged In</a>
							<ul class="dropdown-menu">
								<li>Please log in to access your profile.</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<fieldset><legend>Login </legend>

			<p>User Name: <input type="text" name="username" size="20" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"/>
			<p>Password: &nbsp <input type="password" name="password" size="20"/>
			
			<?php
				session_start();
				require_once('mysql_connect.php');

				if (isset($_SESSION['badlogin']))
				{
					if ($_SESSION['badlogin'] >= 3)
					{
						header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/blocked.php");
					}
				}

				if (isset($_POST['submit']))
				{
					$q = "SELECT username FROM users;";
					$qr = mysqli_query($dbc, $q);
					
					$message=NULL;

					if (empty($_POST['username']))
					{
						$_SESSION['username']=FALSE;
						$message.='<p>Please enter your username.';
					} 
					else 
					{
						$_SESSION['username']=$_POST['username']; 
					}

					if (empty($_POST['password']))
					{
						$_SESSION['password']=FALSE;
						$message.='<p>Please enter your password';
					} 
					else 
					{
						$_SESSION['password']=$_POST['password']; 
					}

					if ($_SESSION['username']=="secretary" && $_SESSION['password']=="secretary") 
					{
						$_SESSION['usertype']=104;
					
						if (!$dbc) 
						{
							die("Connection failed: " . mysqli_connect_error());
						}
						
						$query = "INSERT INTO oulcdb.login (loginTicket, userType, username, inTime) VALUES ((SELECT COUNT(l.loginTicket) + 1 FROM oulcdb.login l), 104, 'secretary', NOW());";
						
						$result = mysqli_query($dbc, $query);
						
						if(!$result)
						{
							$message.='<p> Unable to insert record';
						}   
						
						$ticket = "SELECT l.loginTicket FROM oulcdb.login l ORDER BY loginTicket DESC LIMIT 1;";
						
						foreach ($dbc->query($ticket) as $row) 
						{
							if ($row != NULL)
								$logticket = $row['loginTicket'];
						}
						
						$_SESSION['logticket'] = $logticket;
						
						header("Location: home.php");
					}

					else if ($_SESSION['username']=="legalcounsel" &&   $_SESSION['password']=="legalcounsel")
					{     
						$_SESSION['usertype']=102;
				
						if (!$dbc) 
						{
							die("Connection failed: " . mysqli_connect_error());
						}
						
						$query = "INSERT INTO login (loginTicket, userType, username, inTime) VALUES ((SELECT COUNT(l.loginTicket) + 1 FROM oulcdb.login l), 102, 'legalcounsel', NOW());";
						
						$result = mysqli_query($dbc, $query);
						
						if(!$result)
						{
							$message.='<p> Unable to insert record';
						}
						
						$ticket = "SELECT l.loginTicket FROM oulcdb.login l ORDER BY loginTicket DESC LIMIT 1;";
						
						foreach ($dbc->query($ticket) as $row) 
						{
							if ($row != NULL)
								$logticket = $row['loginTicket'];
						}
						
						$_SESSION['logticket'] = $logticket;
						
						header("Location: home.php");
					} 
					
					  
					else if ($_SESSION['username']=="admin" && $_SESSION['password']=="webadmin")
					{
						$_SESSION['usertype']=101;

				
						if (!$dbc) 
						{
							die("Connection failed: " . mysqli_connect_error());
						}
						
						$query="INSERT INTO oulcdb.login (loginTicket, userType, username, inTime) VALUES ((SELECT COUNT(l.loginTicket) + 1 FROM oulcdb.login l), 101, 'admin', NOW());";
						
						$result = mysqli_query($dbc, $query);
						
						if(!$result)
						{
							$message.='<p> Unable to insert record';
						}
						
						$ticket = "SELECT l.loginTicket FROM oulcdb.login l ORDER BY loginTicket DESC LIMIT 1;";
						
						foreach ($dbc->query($ticket) as $row) 
						{
							if ($row != NULL)
								$logticket = $row['loginTicket'];
						}
						
						$_SESSION['logticket'] = $logticket;
						
						header("Location: home.php");
					}
					
					else if ($_SESSION['username']=="assistantlegalcounsel" && $_SESSION['password']=="assistantlegalcounsel")
					{
						$_SESSION['usertype']=103;
						
				
						if (!$dbc) 
						{
							die("Connection failed: " . mysqli_connect_error());
						}
						
						$query = "INSERT INTO oulcdb.login (loginTicket, userType, username, inTime) VALUES ((SELECT COUNT(l.loginTicket) + 1 FROM oulcdb.login l), 103, 'assistantlegalcounsel', NOW());";
						
						$result = mysqli_query($dbc, $query);
						
						if(!$result)
						{
							$message.='<p> Unable to insert record';
						}
						
						$ticket = "SELECT l.loginTicket FROM oulcdb.login l ORDER BY loginTicket DESC LIMIT 1;";
						
						foreach ($dbc->query($ticket) as $row) 
						{
							if ($row != NULL)
								$logticket = $row['loginTicket'];
						}
						
						$_SESSION['logticket'] = $logticket;
						
						header("Location: home.php");
					}
					
					else if (!($_SESSION['username']=="assistantlegalcounsel" && $_SESSION['username']=="legalcounsel" && $_SESSION['username']=="admin" && $_SESSION['username']=="secretary"))
					{
						$_SESSION['usertype']=105;
						
				
						if (!$dbc) 
						{
							die("Connection failed: " . mysqli_connect_error());
						}
						
						$query = "INSERT INTO oulcdb.login (loginTicket, userType, username, inTime) VALUES ((SELECT COUNT(l.loginTicket) + 1 FROM oulcdb.login l), 105, '".$_POST['username']."', NOW());";
						
						$result = mysqli_query($dbc, $query);
						
						if(!$result)
						{
							$message.='<p> Unable to insert record';
						}
						
						$ticket = "SELECT l.loginTicket FROM oulcdb.login l ORDER BY loginTicket DESC LIMIT 1;";
						
						foreach ($dbc->query($ticket) as $row) 
						{
							if ($row != NULL)
								$logticket = $row['loginTicket'];
						}
						
						$_SESSION['logticket'] = $logticket;
						
						header("Location: home.php");
					}
					
					else 
					{
						$message.='<p>Please try again';
						
						if (isset($_SESSION['badlogin']))
							$_SESSION['badlogin']++;
						else
							$_SESSION['badlogin']=1;
					}
				}
				
				if (isset($message))
				{
					echo '<font color="red">'.$message. '</font>';
				}

			?>
			
			<div align="center"><br><input type="submit" name="submit" class="btn btn-primary" value="Submit" /></div>

			</form>
		</div>
	</body>
</html>
<style>
	body
	{
		background-color: white;
	}
	
	.container
	{
		margin-top: 200px;
		width: 30%;
		padding-top: 20px;
		padding-bottom: 10px;
		background-color: #d1d1d1;
		-webkit-box-shadow: 0px -2px 12px 3px rgba(0,0,0,0.75);
		-moz-box-shadow: 0px -2px 12px 3px rgba(0,0,0,0.75);
		box-shadow: 0px 7px 12px -5px rgba(0,0,0,0.55);
	}
	
	p
	{
		margin-left: 2%;
	}
	
	.navbar
	{
		background-color: #29843b;
		border-width: 5px;
		border-radius: 0px;
		-webkit-box-shadow: 0px -2px 12px 3px rgba(0,0,0,0.75);
		-moz-box-shadow: 0px -2px 12px 3px rgba(0,0,0,0.75);
		box-shadow: 0px -2px 12px 3px rgba(0,0,0,0.75);
	}
	
	.navbar .nav > li > a, .navbar .nav > li > a 
	{
		color: white;
		text-shadow: none;
	}
	
	.navbar .nav > li > a:hover, .navbar .nav > li > a:focus
	{ 
		background-color: transparent;
		color: black;                      
		text-shadow: none;
	}
	
	.navbar .nav > .dropdown > a, .navbar .nav > .dropdown > a:hover, .navbar .nav > .dropdown > a:focus
	{
		background-color: transparent;
	}
	
	.stepwizard-step p 
	{
		margin-top: 10px;    
	}

	.stepwizard-row 
	{
		display: table-row;
	}

	.stepwizard 
	{
		display: table;     
		width: 100%;
		position: relative;
	}

	.stepwizard-step button[disabled] 
	{
		opacity: 1 !important;
		filter: alpha(opacity=100) !important;
	}

	.stepwizard-row:before 
	{
		top: 14px;
		bottom: 0;
		position: absolute;
		content: " ";
		width: 100%;
		height: 1px;
		background-color: #ccc;
		z-order: 0;
		
	}

	.stepwizard-step 
	{    
		display: table-cell;
		text-align: center;
		position: relative;
	}

	.btn-circle 
	{
		width: 50px;
		height: 50px;
		text-align: center;
		padding: 2px 0;
		font-size: 12px;
		line-height: 1.428571429;
		border-radius: 30px;
	}
	
	.btn-disable
	{
		pointer-events: none;
	}
</style>
