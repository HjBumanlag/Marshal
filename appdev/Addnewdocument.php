<html>
	<head>
		<title>TRACK.IO | Add New Document</title>
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
			<h3>Uploading a New Document</h3>
				<div class="row">
					<div class="col-sm-6">
<?php	
	$flag=0;
	$message = '';
	$documenttitlemessage = '';
	$documentamountmessage = '';
	$documentscopemessage = '';
	$documentdurationmessage = '';
	$documentdatemessage = '';
	$documentremarksmessage = '';
	$documentsummarymessage = '';
	$processingtypemessage = '';
	$documenttypemessage = '';
	$requestidmessage = '';
	$filemessage = '';
	if (isset($_POST['submit']))
	{	
		if (empty($_POST['documentsummary']))
			$documentsummary = null;
		else
			$documentsummary =$_POST['documentsummary'];
		if (empty($_POST['documentremarks']))
			$documentremarks = null;
		else
			$documentremarks =$_POST['documentremarks'];
		if (empty($_POST['documentamount']))
			$documentamount = 'null';
		else
			$documentamount =$_POST['documentamount'];
		if (empty($_POST['documentduration']))
			$documentduration = null;
		else
			$documentduration =$_POST['documentduration'];
		
		if (empty($_POST['documenttitle']))
		{
			$documenttitle=FALSE;
			$documenttitlemessage = 'You forgot to enter the document title!';
			$message = 'error';
		}
		else
		{
			$documenttitle=$_POST['documenttitle'];
			$documenttitlemessage = null;
		}	
		if (empty($_POST['requestid']))
		{
			$requestid=FALSE;
			$requestidmessage = 'Please insert requesting party ID';
			$message = 'error';
		}
		else
		{
			$requestid=$_POST['requestid'];
			$requestpartyidquery = mysqli_query($dbc ,"Select * from requesting_party WHERE idNumber = '$requestid'");
			$rowcount = mysqli_num_rows($requestpartyidquery);
			if ($rowcount > 0)
				$requestidmessage = null;
			else 
			{
				$requestid=FALSE;
				$requestidmessage = 'Requesting Party does not exist';
				$message = 'error';
			}
		}	
		if (empty($_POST['documentscope']))
		{
			$documentscope=FALSE;
			$documentscopemessage ='You forgot to enter the scope of the document!';
			$message = 'error';
		}
		else
		{
			$documentscope=$_POST['documentscope'];
			$documentscopemessage = null;
		}
		
		
		if (empty($_POST['documentstartdate']))
		{
			$documentstartdate=FALSE;
			$documentdatemessage ='You forgot to enter the starting date of the document!';
			$message = 'error';
		}
		else
		{
			$documentstartdate=$_POST['documentstartdate'];
			$documentdatemessage = null;
		}
		if (empty($_POST['processingtype']))
		{
			$processingtype=FALSE;
			$processingtypemessage ='You forgot to choose a procesing type!';
			$message = 'error';
		}
		else
		{
			$processingtype=$_POST['processingtype'];
			$processingtypemessage = null;
		}
		if (empty($_POST['documenttype']))
		{
			$documenttype=FALSE;
			$documenttypemessage ='You forgot to choose a document type!';
			$message = 'error';
		}
		else
		{
			$documenttype=$_POST['documenttype'];
			$documenttypemessage = null;
		}
		if (isset($_FILES["filetoUpload"]["name"]))
		{
			$file = $_FILES['filetoUpload']['name'];
			$file_loc = $_FILES['filetoUpload']['tmp_name'];
			$file_size = $_FILES['filetoUpload']['size'];
			$file_type = $_FILES['filetoUpload']['type'];
			$folder="Uploads/";
		}
		else
		{
			$filemessage = "You forgot to upload the file";
			$message = 'error';
		}
		
		if ($message != 'error')
		{
			if(move_uploaded_file($file_loc,$folder.$file))
			{
				$rowcountquery = mysqli_query($dbc ,'Select * from documents');
				$rowcount = mysqli_num_rows($rowcountquery);
				$date = date("Y");
				$date *= 100000;
				$rowcount += $date; 
				$query = "insert into documents 
									(trackingNumber, 
									title, 
									requestingPartyID, 
									status,
									type,
									processingType,
									scope,
									startingDate,
									amount,
									summary,
									remarks,
									duration) 
							values ('$rowcount',
									'$documenttitle',
									'$requestid',
									'IR',
									'$documenttype',
									'$processingtype',
									'$documentscope',
									'$documentstartdate',
									$documentamount,
									'$documentsummary',
									'$documentremarks',
									'$documentduration')";
				$result = mysqli_query($dbc,$query) or die (mysqli_error($dbc));
				$filerowcountquery = mysqli_query($dbc ,'Select * from document_file');
				$filerowcount = mysqli_num_rows($filerowcountquery);
				$date = date("Y");
				$date *= 10000;
				$filerowcount += $date; 
				$filequery="INSERT INTO document_file(fileID,fileName,fileType,filesize,trackingNumber) 
											VALUES
												('$filerowcount',
												'$file',
												'$file_type',
												'$file_size',
												'$rowcount')";
				$fileresult = mysqli_query($dbc ,$filequery) or die (mysqli_error($dbc));
				?>
				<script>
				alert('Successfully uploaded!');
				</script>
				<?php
			}
			else
			{
				?>
				<script>
				alert('Error uploading file.');
				</script>
				<?php
			}
		}
	}
?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <p>Document Title: <input type="text" name="documenttitle"  value="<?php if (isset($_POST['documenttitle']) &&                          
						   !$flag) echo $_POST['documenttitle']; ?>"/> <?php echo '<font color="red">'.$documenttitlemessage. '</font>' ?> <br>
        <p>Requesting Party ID: <select name="requestid" onmousedown="if(this.options.length>9){this.size=9;}"  onchange='this.size=0;' onblur="this.size=0;">
								 <option disabled selected value> Requesting Party</option>
								 <?php 
								 $requestpartyquery = "SELECT * FROM requesting_party";
								 $queryresult = mysqli_query($dbc,$requestpartyquery);
								 while($fetch2 = $queryresult->fetch_assoc())
								 {
									$requestingpartyIDdropdown = $fetch2['idNumber'];
									$append = $fetch2['college'].': '.$fetch2['department'].' - '.$fetch2['idNumber'];
									echo '<option value = "'.$requestingpartyIDdropdown.'">'.$append.'</option>';
								}
								 ?>
								 </select>
								<?php echo '<font color="red">'.$requestidmessage. '</font>' ?> <br>
        <p>Document Type: <select name="documenttype">
						  <option disabled selected value> Document Type </option>;
						  <option value ="MOA"> Memorandum of Agreement </option>;
						  <option value ="LA"> Licensing Agreement </option>;
						  <option value ="SA"> Sponshorship Agreement </option>;
						  <option value ="SFE"> Studies and Faculty Exchange </option>;
						  <option value ="RA"> Research Agreement </option>;
						  <option value ="D"> Donations </option>;
						  <option value ="G"> Grant </option>;
						  <option value ="ELC"> Employee Labor Contracts  </option>;
						  <option value ="SA"> Service Agreement </option>;
						  <option value ="IL"> Industry Linkages </option>;
						  <option value ="O"> Others </option>;
						  </select> <?php echo '<font color="red">'.$documenttypemessage. '</font>' ?> <br>
        
        <p>Processing Type: <select name="processingtype">
							<option disabled selected value> Processing Type </option>;
						  <option value ="ER"> Express </option>;
						  <option value ="RR"> Normal </option>;
						  </select> <?php echo '<font color="red">'.$processingtypemessage. '</font>' ?> <br>
        
		<p>Duration: <input type="text" name="documentduration"  value="<?php if (isset($_POST['documentduration']) &&                          
					!$flag) echo $_POST['documentduration']; ?>"/> <?php echo '<font color="red">'.$documentdurationmessage. '</font>' ?>
		
        <p>Amount: P<input type="number" name="documentamount"  value="<?php if (isset($_POST['documentamount']) &&                     
							!$flag) echo $_POST['documentamount']; ?>"/> <?php echo '<font color="red">'.$documentamountmessage. '</font>' ?><br>
							
		<p>Starting Date: <input type="date" name="documentstartdate"  value="<?php if (isset($_POST['documentstartdate']) &&                     
							!$flag) echo $_POST['documentstartdate']; ?>"/> <?php echo '<font color="red">'.$documentdatemessage. '</font>' ?><br>
            
        <p>Scope: <select name="documentscope">
						<option disabled selected value> Scope </option>;
						  <option value ="College"> College </option>;
						  <option value ="Department"> Department </option>;
						  </select> <?php echo '<font color="red">'.$documentscopemessage. '</font>' ?><br>
        <div class="col-sm-4">
            <p> Form Tracking Number:
            <input type="int" name="formtn" ><br>
            <p align="center">
            <p> Form Title:</p>
            <input type="text" name="formtitle"><br>
            <input type="submit" name="viewform" value="Search Form" /><br><br>
            <p align="center"><input type="submit" name="connect" value="Connect" /> </p>
						
					</div>
            
		</div>
		<div class="col-sm-6">
		
        <p>Summary: <textarea rows="5" cols="50" name="documentsummary" value="<?php if (isset($_POST['documentsummary']) &&                             
							!$flag) echo $_POST['documentsummary']; ?>"></textarea> <?php echo '<font color="red">'.$documentsummarymessage. '</font>' ?><br>
        
        <p>Remarks: <textarea rows="5" cols="50" name="documentremarks" value="<?php if (isset($_POST['documentremarks']) &&                             
							!$flag) echo $_POST['documentremarks']; ?>"></textarea> <?php echo '<font color="red">'.$documentremarksmessage. '</font>' ?><br>
        
		<input type="file" name="filetoUpload" > <?php echo '<font color="red">'.$filemessage. '</font>' ?>  <br>
        <p><input type="submit" name="submit" value="Upload" />
        </form>
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

