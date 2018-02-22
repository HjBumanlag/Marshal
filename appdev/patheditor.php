<html>
	<head>
		<title>TRACK.IO | Path Editor</title>
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
		
		//no get for creating new paths
		$mode = $_GET['mode'];
		if ($mode == 1)
		{
			$tracking = $_GET['tr']; //for editing an individual document path
			$title = $_GET['t']; //for editing an individual document path
			$startdate = $_GET['d']; //for editing an individual document path
		} 
		else if ($mode == 3)
		{
			$doctype = $_GET['dt']; //for editing a default document path
			$doccode = $_GET['dc']; //for editing a default document path
		}
		$steps = 0;
		$findpath = "";
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
		<form action='pathsuccess.php' method='post' id='pathform'>
				<?php
					if ($mode == 1) //specific document path editor
					{
						echo "<h3>Edit Document Path</h3>";
						echo "<div class='row'>";
						echo "<div class='col-sm-4'>";
						echo "<h4>Title: ".$title."</p>";
						echo "Tracking Number: ".$tracking."</p>";
						echo "Date Started: ".$startdate."</p></h4>";
						
						$findpath = "SELECT officeCode, status, sequence 
										FROM document_path 
										WHERE trackingNumber =".$tracking." 
										ORDER BY sequence ASC;";
										
						echo "<input type='hidden' name='mode' value='1'>";
						echo "<input type='hidden' name='tracking' value='".$tracking."'>";
						echo "<input type='hidden' name='title' value='".$title."'>";
						echo "<input type='hidden' name='startdate' value='".$startdate."'>";
					}
					else if ($mode == 3) //document type path editor
					{
						echo "<h3>Edit Document Path</h3>";
						echo "<div class='row'>";
						echo "<div class='col-sm-4'>";
						echo "<h4>Document Type: ".$doctype."</p>";
						
						$findpath = "SELECT officeCode, sequence, pathName
										FROM doc_path_ref 
										WHERE doctype ='".$doccode."' 
										ORDER BY sequence ASC;";
										
						echo "<input type='hidden' name='mode' value='3'>";
						echo "<input type='hidden' name='doccode' value='".$doccode."'>";
					}
					else //new path editor
					{
						echo "<h3>Create Document Path</h3>";
						echo "<div class='row'>";
						echo "<div class='col-sm-4'>";
						echo "<h4>Document Type: <select name='doctypes'>";
						
						$query = "SELECT description, code
									FROM doc_type_ref;";
						$querying = mysqli_query($dbc, $query);
						
						while ($row = $querying->fetch_assoc())
						{
							echo "<option value='".$row['code']."'>".$row['description']."</option>";
						}
						
						echo "</select></p>";
						echo "Path Name: <input type='text' name='pathname'></p></h4>";
						
						echo "<input type='hidden' name='mode' value='2'>";
					}
				
				echo "</div>";
				echo "<div class='col-sm-8' style='font-size: 16px'>";
						
						if ($mode == 1 || $mode == 3) //getting the already set path
						{
							$pathfound = mysqli_query($dbc, $findpath);
							
							if ($pathfound->num_rows > 0)
							{
								while ($path = $pathfound->fetch_assoc())
								{	
									$buttontype = "btn btn-default";
									$edit = "enabled";
									$input = "";
									$color = "none";
									
									if ($mode == 1)
									{
										if ($path['status'] == 'In Progress') 
										{ 
											$buttontype = 'btn'; 
											$edit = "disabled"; 
											$input = "input-disable";
											$color = "#e5e5e5"; 
										}
										else if ($path['status'] == 'Done') 
										{ 
											$buttontype = 'btn'; 
											$edit = "disabled"; 
											$input = "input-disable";
											$color = "#e5e5e5"; 
										}
									}
									else
									{
										echo "<input type='hidden' name='pathname' value='".$path['pathName']."'>";
									}
									
									echo "<div id='path".$path['sequence']."'>
											<p><button type='button' class='".$buttontype." btn-circle btn-disable'><h4>".$path['sequence']."</h4 id='no".$path['sequence']."'></button>
											&nbsp Office: <select name='office[]' id='office".$path['sequence']."' class='".$input."' style='width: 200px; height: 30px; background-color: ".$color.";'>";
											
											$getoffices = "SELECT officeCode FROM office;";
											$officesfound = mysqli_query($dbc, $getoffices);
											
											while ($offices = $officesfound->fetch_assoc())
											{
												if ($offices['officeCode'] == $path['officeCode'])
												{
													echo "<option value='".$offices['officeCode']."' selected>".$offices['officeCode']."</option>";
												} 
												else
												{
													echo "<option value='".$offices['officeCode']."'>".$offices['officeCode']."</option>";
												}
											}
											
									echo "</select>
											<p style='margin-left: 2px'><button id='btn".$path['sequence']."' type='button' class='btn btn-danger btn-xs' value=".$path['sequence']." onclick='removeStep(this.id)' ".$edit.">Delete</button> 
											<p style='margin-left: 53px; padding-top: 5px;'>
											<input type='hidden' name='sequence[]' value='".$path['sequence']."'>
											<input type='hidden' name='status[]' value='".$path['status']."'>
										</div>";
										
									$steps = $steps + 1;
								}
							}
						}
				?>
						<p id="step"></p>
						<p><button id="addbutton" type="button" class="btn btn-primary btn-circle"><h4>+</h4></button> &nbsp Add another step or 
						<button type="submit" form="pathform" class="btn btn-success" value="Submit">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</body>
	
	<script type="text/javascript">
		document.getElementById("addbutton").addEventListener("click", newStep);
		var step = <?php echo $steps; ?>;
		
		function newStep () 
		{
			step += 1;
			document.getElementById("step").innerHTML += "<div id='path"+step+"'><p><button type='button' class='btn btn-default btn-circle btn-disable'><h4 id='no"+step+"'>"+step+"</h4></button>&nbsp Office: <select name='office[]' id='office"+step+"' style='width: 200px; height: 30px;' enabled> <?php $getoffices = "SELECT officeCode FROM office;";$officesfound = mysqli_query($dbc, $getoffices); while ($offices = $officesfound->fetch_assoc()) { echo "<option value='".$offices['officeCode']."'>".$offices['officeCode']."</option>"; } ?> </select><p style='margin-left: 2px'><button id='btn"+step+"' type='button' class='btn btn-danger btn-xs' onclick='removeStep(this.id)' enabled>Delete</button><input type='hidden' name='sequence[]' value='"+step+"'><input type='hidden' name='status[]' value='Queued'></div>";
		}
		
		function removeStep (clicked_id)
		{	
			btnName = clicked_id;
			toRemove = parseInt(btnName.substr(3));
			document.getElementById("path" + toRemove).remove();
			count = step;
			
			while (count > toRemove)
			{	
				document.getElementById("no" + (toRemove + 1)).innerText = toRemove;
				document.getElementById("no" + (toRemove + 1)).id = "no" + toRemove;
				document.getElementById("btn" + (toRemove + 1)).id = "btn" + toRemove;
				document.getElementById("path" + (toRemove + 1)).id = "path" + toRemove;
				document.getElementById("office" + (toRemove + 1)).id = "office" + toRemove;
				toRemove = toRemove + 1;
			}
			
			step = step - 1;
		}
	</script>
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
	
	.input-disable
	{
		pointer-events: none;
	}
</style>
