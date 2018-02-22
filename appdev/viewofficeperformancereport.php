<html>
	<head>
		<title>TRACK.IO | Reports</title>
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
		
		$office_id = $_POST['officeid'];
		$start_date = $_POST['startdate'];
		$end_date = $_POST['enddate'];
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
			<h3>Office Performance Report</h3>
			<div class="row">
				<div class="col-sm-9">
					<h4>Office Name: <?php $q = "SELECT name FROM office WHERE officeCode = '".$office_id."';"; $r = mysqli_query($connect, $q); while ($row = $r->fetch_assoc()) { echo $row['name']." (".$office_id.")"; } ?></p>
						Starting Date: <?php echo $start_date; ?></p>
						Ending Date: <?php echo $end_date; ?></p></h4>
						Report generated on <?php date_default_timezone_set('Asia/Manila'); $date = date('Y-m-d H:i', time()); echo $date." by ".$username; ?>
				</div>
				<div class="col-sm-3" style="text-align: right;">
					<a href="createofficeperformancereport.php"><button type="button" class="btn btn-primary btn-md">Create Another Report</button></a>
				</div>
			</div>
			<div class="row" style="margin-top: 15px;">
				<div class="col-sm-12" style="font-size: 16px">
					<p><?php
						$query = "SELECT d.trackingNumber, d.startingDate, d.title, rp.name, sr.description
									FROM document_path dp
									JOIN documents d ON dp.trackingNumber = d.trackingNumber
									JOIN requesting_party rp ON d.requestingPartyID = rp.idNumber
									JOIN status_ref sr ON sr.code = d.status
									WHERE dp.officeCode = '".$office_id."' && d.startingDate >= '".$start_date."' && d.startingDate <= '".$end_date."'
									GROUP BY d.trackingNumber;";

						$result = mysqli_query($dbc, $query);

						if ($result->num_rows > 0)
						{
							echo "<table class='table table-hover'>
								<thead>
									<tr>
										<th style='text-align: center;'>Starting Date</th>
										<th style='text-align: center;'>Title</th>
										<th style='text-align: center;'>Requesting Party</th>
										<th>Overall Processing Duration</th>
										<th>Overall Processing Status</th>
										<th style='text-align: center;'>Actions</th>
									</tr>
								</thead>
								<tbody>";	
							while ($row = $result->fetch_assoc())
							{
								if ($row['description'] == "Completed")
								{
									$dur = "SELECT DATEDIFF(da.dateApproved, d.startingDate) AS 'duration'
												FROM documents d
												JOIN document_approved da ON da.trackingNumber = d.trackingNumber
												WHERE d.trackingNumber = '".$row['trackingNumber']."';";
								}
								else
								{
									$dur = "SELECT DATEDIFF(NOW(), d.startingDate) AS 'duration'
												FROM documents d
												WHERE d.trackingNumber = '".$row['trackingNumber']."';";
								}
								
								$getdur = mysqli_query($dbc, $dur);
								while ($d = $getdur->fetch_assoc()) { $duration = $d['duration']; }
								
								echo "<tr>
										<td>" .$row['startingDate']. "</td>
										<td>" .$row['title']. "</td>
										<td>" .$row['name']. "</td>
										<td>" .$duration. " day/s</td>
										<td>" .$row['description']. "</td>
										<td style='text-align: center; padding-top: 17px;'><span class='label label-warning'><a data-toggle='modal' href='#myModal' style='color: white'>View Details</a></span></td>
									</tr>";
									
								echo '<div id="myModal" class="modal fade" role="dialog">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">'.$row['title'].'</h4>
											</div>
											<div class="modal-body">
												<p>Tracking Number: '.$row['trackingNumber'].'</p>
												Start Date: '.$row['startingDate'].'<br>
												<h4>This Document in '.$office_id.' </h4>';
												
								$off = "SELECT status, officeCode
											FROM document_path
											WHERE officeCode = '".$office_id."' AND trackingNumber = '".$row['trackingNumber']."'";
								
								$getoff = mysqli_query($dbc, $off);
								while ($o = $getoff->fetch_assoc()) 
								{ 
									if ($o['status'] == "Done") 
									{
										$details = "SELECT status, dateReceived, dateReleased, DATEDIFF(dateReleased, dateReceived) AS 'duration'
													FROM document_path
													WHERE trackingNumber = '".$row['trackingNumber']."' AND officeCode = '".$office_id."'";
									}
									else
									{
										$details = "SELECT status, dateReceived, dateReleased, DATEDIFF(NOW(), dateReceived) AS 'duration'
													FROM document_path
													WHERE trackingNumber = '".$row['trackingNumber']."' AND officeCode = '".$office_id."'";
									}
								}
								
								$getdetails = mysqli_query($dbc, $details);
								while ($deets = $getdetails->fetch_assoc())
								{
									$status = $deets['status'];
									$recdate = $deets['dateReceived'];
									$reldate = $deets['dateReleased'];
									$duration = $deets['duration'];
								}
												
												echo '<p style="margin-left: 20px;">Duration in Office: '.$duration.' day/s</p>
												<p style="margin-left: 20px;">Status in Office: '.$status.'</p>
												<p style="margin-left: 20px;">Date Received by Office: '.$recdate.'</p>
												<p style="margin-left: 20px;">Date Released from Office: '.$reldate.'</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>';
							}
							echo "</tbody></table>";
							echo "<div style='font-size: 14px; text-align: center;'>-- END OF REPORT --</div>";
							}
							else
							{
							echo "No results!";
						}
					?>
				</div>
			</div>
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
