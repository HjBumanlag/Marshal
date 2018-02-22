<html>
	<head>
		<title>TRACK.IO | Connect a Form</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
	</head>
	
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
	
	<body>
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
			<h3>Connecting a Form to Document</h3>
				<div class="row">
					<div class="col-sm-4">
						<h4><form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							<p>Searching for a Form or Document
							<p>Tracking Number:
							<input type="text" name="search" ><br>
							<p align="center"><input type="submit" name="viewdocument" value="Search Document" />
							 or
							<input type="submit" name="viewform" value="Search Form" /><br><br>
							<p>Specifying both Form and Document Number
							<p>Connect Form: <input type="text" name="formconnect" ><p>
							To Document: <input type="text" name="documentconnect"> 
							<p align="center"><input type="submit" name="connect" value="Connect" /> </p>
						</form><h4>
					</div>
					<div class="col-sm-8">

			<?php
			if ($_SESSION['usertype']==null)
			{ 
				header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/login.php");
			}
			else
			{
				if (isset($_POST['viewdocument']))
				{
					$searchdoc = $_POST['search'];
					$searchdoc = preg_replace("#[^0-9a-z]#i","",$searchdoc);
					$query = mysqli_query($dbc,"SELECT * FROM documents WHERE trackingNumber LIKE '%$searchdoc%' AND status != 'RJ' AND status != 'A' AND status != 'AFP' AND status != 'FES'");
					
					$count = mysqli_num_rows($query);
					
					if ($count == 0)
						echo "No results!";
					else
					{
						echo '<table class="table table-hover">
						<thead>
							<tr>
								<th style="text-align: center;">Tracking Number</th>
								<th style="text-align: center;">Title</th>
								<th style="text-align: center;">Type</th>
								<th style="text-align: center;">Processing Type</th>
								<th style="text-align: center;">Status</th>
								<th style="text-align: center;">Connected Form</th> 
							</tr>
						</thead></tbody>';
						while ($row = mysqli_fetch_array($query))
						{
							$TrackingNumber 	= $row['trackingNumber'];
							$Title 				= $row['title'];
							$Type 				= $row['type'];
							$ProcessingType		= $row['processingType'];
							$StartingDate 		= $row['status'];
							
							$formquery = mysqli_query($dbc,"SELECT * FROM forms WHERE docTrackingNUmber = '$row[trackingNumber]'");
							$formcount = mysqli_num_rows($formquery); 
							if ($formcount > 0)
								{
										$ConnectedForm = "There is/are ".$formcount." form connected";
									
								}
							else
									$ConnectedForm = "None";
							echo
							"<tr>
										<td style='text-align: center;'>
										<form action='FormConnect.php' method='post'>
											<input type='submit' value='{$TrackingNumber}' name='connecttoform'>
										</forms></td>
										<td>{$Title}</td>
										<td style='text-align: center;'>{$Type}</td>
										<td style='text-align: center;'>{$ProcessingType}</td>
										<td style='text-align: center;'>{$StartingDate}</td>
										<td>{$ConnectedForm}</td>
							</tr>";
						}
						echo "</tbody></table>";
					}
				}
				if (isset($_POST['viewform']))
				{
					$searchform = $_POST['search'];
					$searchform = preg_replace("#[^0-9a-z]#i","",$searchform);
					$query = mysqli_query($dbc,"SELECT * FROM forms WHERE FormTrackingNumber LIKE '%$searchform%'");
					$count = mysqli_num_rows($query);
					if ($count == 0)
						echo "No results!";
					else
					{
						echo '<table class="table table-hover">
						<thead>
							<tr>
								<th style="text-align: center;">Form Tracking Number</th>
								<th style="text-align: center;">Form Title</th>
								<th style="text-align: center;">Connect Status</th>
							</tr>	
						</thead><tbody>';
						while ($row = mysqli_fetch_array($query))
						{
							$formTrackingNumber 	= $row['formTrackingNumber'];
							$formTitle 				= $row['formTitle'];
							$documentTrack			= $row['docTrackingNumber']; 
							if ($documentTrack != null)
							{
								$documentTrack = "Form is connected";
							}
							else 
							{
								$documentTrack = "Form is not connected";
							}
							echo "<tr><td style='text-align: center;'>";
							
							if ($documentTrack == "Form is not connected")
							{			
								echo "<form action='FormConnect.php' method='post'>
								<input type='submit' value='{$formTrackingNumber}' name='connecttodocument'>
								</forms>";
							}
							else
							{
								echo "{$formTrackingNumber}";
							}
							echo	"</td>
									<td>{$formTitle}</td>
									<td>{$documentTrack}</td>
										
							</tr>";
						}
						echo "</tbody></table>";
					}
				}
				if (isset($_POST['connecttoform']))
				{
					$query = mysqli_query($dbc,"SELECT * FROM forms WHERE docTrackingNumber = null");
					$count = mysqli_num_rows($query);
					if ($count == 0)
						echo "No forms to be connected with!";
					else
					{
						echo '<table class="table table-hover">
							<thead>
								<tr>
									<th style="text-align: center;">Form Tracking Number</th>
									<th style="text-align: center;">Form Title</th>
									<th style="text-align: center;">Actions</th>
								</tr>
							</thead><tbody>';
						while ($row = mysqli_fetch_array($query))
						{
							$formTrackingNumber 	= $row['formTrackingNumber'];
							$formTitle 				= $row['formTitle'];
							echo "<tr>
										<td style='text-align: center;'>{$formTrackingNumber}</td>
										<td>{$formTitle}</td>
										<td style='text-align: center;'>
							<form action='FormConnect.php' method='post'>
							<input type='submit' value='Connect' name='DocuConnectedForm'>
							<input type='hidden' value='{$_POST['connecttoform']}' name='docuconnect' >
							<input type='hidden' value='{$formTrackingNumber}' name='formconnect' >
							</forms></td>
							</tr>";
						}
						echo "</tbody></table>";
					}
				}
				if (isset($_POST['connecttodocument']))
				{
					$query = mysqli_query($dbc,"SELECT * FROM documents WHERE status != 'RJ' AND status != 'A' AND status != 'AFP' AND status != 'FES' ");
					$count = mysqli_num_rows($query);
					if ($count == 0)
						echo "No forms to be connected with!";
					else
					{
						echo '<table class="table table-hover">
							<thead>
								<tr>
									<th style="text-align: center;">Tracking Number</th>
									<th style="text-align: center;">Title</th>
									<th style="text-align: center;">Type</th>
									<th style="text-align: center;">Processing Type</th>
									<th style="text-align: center;">Status</th>
									<th style="text-align: center;">Connect</th> 
								</tr>
							</thead><tbody>';
							while ($row = mysqli_fetch_array($query))
							{
								$TrackingNumber 	= $row['trackingNumber'];
								$Title 				= $row['title'];
								$Type 				= $row['type'];
								$ProcessingType		= $row['processingType'];
								$StartingDate 		= $row['status'];
								
								echo
								"<tr>
											<td style='text-align: center;'>{$TrackingNumber}</td>
											<td>{$Title}</td>
											<td style='text-align: center;'>{$Type}</td>
											<td style='text-align: center;'>{$ProcessingType}</td>
											<td style='text-align: center;'>{$StartingDate}</td>
											<td style='text-align: center;'>
											<form action='FormConnect.php' method='post'>
										<input type='submit' value='Connect' name='FormConnectedDocu'>
										<input type='hidden' value='{$_POST['connecttodocument']}' name='formconnect' >
										<input type='hidden' value='{$TrackingNumber}' name='docuconnect' >
										</forms>
											</td>
								</tr>";
							}
							echo "</tbody></table>";
					}
				}
				if (isset($_POST['DocuConnectedForm']))
				{
					$result = mysqli_query($dbc, "UPDATE forms SET docTrackingNUmber = '{$_POST['docuconnect']}' WHERE formTrackingNumber = '{$_POST['formconnect']}'");
					echo "Form {$_POST['formconnect']} is now connected to document {$_POST['docuconnect']}";
				}
				if (isset($_POST['FormConnectedDocu']))
				{
					$result = mysqli_query($dbc, "UPDATE forms SET docTrackingNUmber = '{$_POST['docuconnect']}' WHERE formTrackingNumber = '{$_POST['formconnect']}'");
					echo "Form {$_POST['formconnect']} is now connected to document {$_POST['docuconnect']}";
				}
				if (isset($_POST['connect']))
				{
					$formconnect = $_POST['formconnect'];
					$docconnect = $_POST['documentconnect'];
					$formquery = mysqli_query($dbc,"SELECT * FROM forms WHERE FormTrackingNumber = '$formconnect'" );
					$doccuquery = mysqli_query($dbc,"SELECT * FROM documents WHERE trackingNumber = '$docconnect'" );
					if ($_POST['formconnect'] == null OR $_POST['documentconnect'] == null)
					{
						echo "Please enter both form tracking ID and document tracking ID.";
					}
					else 
					{
						if (mysqli_num_rows($formquery )==0 OR mysqli_num_rows($doccuquery)==0)
						{
							echo "Invalid inputs: ";
							echo "Form tracking ID or document tracking ID does not exist!";
						}
						else
						{
							while ($formrow = mysqli_fetch_array($formquery))
							{
								$formdoctrackingnumber = $formrow['docTrackingNUmber'];
							}
							while ($doccurow = mysqli_fetch_array($doccuquery))
							{
								
							}
							if ($formdoctrackingnumber == null)
							{
								$result = mysqli_query($dbc, "UPDATE forms SET docTrackingNUmber = '$docconnect' WHERE formTrackingNumber = '$formconnect'");
								echo "Form '$formconnect' is now connected to document $docconnect";
							}
							else 
							{
								echo "Form '$formconnect' is already connected to a document";
							}
						}
					}
				}
		}	
		?>
				</div>
			</div>
		</div>
	</body>
	
	<style>
		body
		{
			background-color: white;
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