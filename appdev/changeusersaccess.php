<html>
	<head>
		<title>TRACK.IO | Form Access Manager</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
	</head>
	<body>
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
		?>
		
		<header>
			<nav class="navbar navbar-fixed-top">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="background-color: white;">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar" style="background-color: black;"></span>
							<span class="icon-bar" style="background-color: black;"></span>
							<span class="icon-bar" style="background-color: black;"></span>
						</button>
						<a class="navbar-brand" href="home.php" style="color: white">TRACK.IO</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-left">
							<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Documents</a>
								<ul class="dropdown-menu">
									<?php
										if ($usertype == "104")
											echo '<li><a href="Addnewdocument.php">New Document Upload</a></li>';
										if ($usertype == "104")
											echo '<li><a href="addrevision.php">Document Revision Upload</a></li>';
										if ($usertype == "104")
											echo '<li><a href="updatedocustatus.php">Update Status</a></li>';
										if ($usertype == "101" || $usertype == "102" || $usertype == "103")
											echo '<li><a href="pathview.php">Document Path</a></li>';
										if ($usertype == "102")
											echo '<li><a href="ApproveDocument.php">Approve Documents</a></li>';
										if ($usertype == "102")
											echo '<li><a href="storesafe.php">Store Document to Safe</a></li>';
									?>
								</ul>
							</li>
							<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Forms</a>
								<ul class="dropdown-menu">
									<?php
										if ($usertype == "102" || $usertype == "103" || $usertype == "104" || $usertype == "105")
											echo '<li><a href="viewForms.php">View Forms</a></li>';
										if ($usertype == "101")
											echo '<li><a href="createform.php">Create a Form</a></li>';
										if ($usertype == "101")
											echo '<li><a href="FormConnect.php">Connect to a Document</a></li>';
										if ($usertype == "101")
											echo '<li><a href="assignformaccesslvl.php">Assign Access Level</a></li>';
										if ($usertype == "101")
											echo '<li><a href="changeusersaccess.php">User Access Requests</a></li>';
										if ($usertype == "105")
											echo '<li><a href="requestformaccess.php">Request Form Access</a></li>';
									?>
								</ul>
							</li>
							<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Reports</a>
								<ul class="dropdown-menu">
									<?php
										if ($usertype == "101")
											echo '<li><a href="createofficeperformancereport.php">Office Performance Report</a></li>';
									?>
								</ul>
							</li>
							<?php if ($usertype != '105') { echo '<li><a href="agendaview.php">Agenda</a></li>'; } ?>
							<?php if ($usertype == '101') { echo '<li><a href="createrequester.php">Create Requester</a></li>'; } ?>
						</ul>
						<?php
							if ($usertype == "101" || $usertype == "102")
								echo '<form class="navbar-form navbar-left" action="createdocreport.php" method="post">
									<input class="form-control mr-sm-2" type="text" name="searcher" placeholder="Find Document to Generate Report" size="25">
									<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
								</form>';
						?>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><?php echo " " . $username; ?></a>
									<ul class="dropdown-menu">
										<li style="margin-left: 20px;"><?php echo $name; ?></li>
										<li><a href="logout.php">Logout</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</nav>
		</header>
		
		<div class="container">
			<h3>Form Access Requests</h3>
			<?php
				if ($_SESSION['usertype']== null)
				{ 
					header("Location: login.php");
				}
				else if ($_SESSION['usertype'] != 101)
				{ 
					header("Location: NoAccess.php");
				}
				else
				{
					$requestquery = mysqli_query($dbc,"SELECT * FROM form_access_request WHERE StatusRequest = 'Pending'");
					$count = mysqli_num_rows($requestquery);
					if ($count == 0)
						echo "No Pending Requests!";
					else
					{
						echo "<table class='table table-hover'>
							<thead>
								<tr>
									<th style='text-align: center;'>Requester</th>
									<th style='text-align: center;'>Form Number</th>
									<th style='text-align: center;'>Actions</th>
								</tr>
							</thead>";
						while ($row = mysqli_fetch_array($requestquery))
						{
							$requestusername = $row['username'];
							$requestformid = $row['formTrackingNumber'];
							echo "<tr><td>{$requestusername}</td>
									<td style='text-align: center;'>{$requestformid}</td>
									<td style='text-align: center;'><form action='changeusersaccess.php' method='post'>
										<span class='label label-primary'><input type= 'submit' class='remstyle' value='Approve' name='approve'></span>
										<span class='label label-danger'><input type= 'submit' class='remstyle' value='Reject' name='reject'></span>
										<input type='hidden' value='{$requestusername}' name='requesetuser'>
										<input type='hidden' value='{$requestformid}' name='requestform'>
										</form></td></tr>";
						}
					}
					
					if (isset($_POST['approve']))
					{
						$approvequery = mysqli_query($dbc,"UPDATE form_access_request SET StatusRequest='Approved' WHERE formTrackingNumber='{$_POST['requestform']}' AND username='{$_POST['requesetuser']}'");
						
						$accessquery = mysqli_query($dbc,"INSERT INTO form_access (formTrackingNumber, username) VALUES ('{$_POST['requestform']}','{$_POST['requesetuser']}')");
			?>
			
						<script>
							alert('User has been granted requested access level to form.');
						</script>
			
			<?php
					}
					else if (isset($_POST['reject']))
					{
						$rejectquery = mysqli_query($dbc,"UPDATE form_access_request SET StatusRequest='Rejected' WHERE formTrackingNumber='{$_POST['requestform']}' AND username='{$_POST['requesetuser']}'");
			?>
			
						<script>
							alert('User has been denied requested access level access to form.');
						</script>
			
			<?php
					}
				}
			?>
		</div>
	</body>
	
	<style>
		body
		{
			background-color: white;
		}
		
		.remstyle
		{
			padding: 0;
			border: none;
			background: none;
			text-decoration: underline;
		}
		
		.container
		{
			padding-top: 80px;
			width: 95%;
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
			height: 30px;
			text-align: center;
			padding: 2px 5px 0px 5px;
			font-size: 12px;
			line-height: 1.428571429;
			border-radius: 15px;
		}
		
		.btn-disable
		{
			pointer-events: none;
		}
	</style>
</html>