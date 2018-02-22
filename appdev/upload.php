<?php 
if (isset($_POST['submit'])) {
	session_start();
	require_once('mysql_connect.php');
		
	$file = $_FILES['file'];
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];
	
	$trackingno = $_POST['tnum'];
	
	$fileExt= explode('.',$fileName);
	$fileActualExt = strtolower(end($fileExt));
	
	$allowed=array('txt','pdf','docx');
	
	if (in_array($fileActualExt,$allowed)) {
		if($fileError === 0) {
			if ($fileSize < 500000) {
				$fileNameNew = $fileName.".".$fileActualExt;
				$fileDestination = 'uploads/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
				
				header("Location: uploadrevision.php");
				echo "File successfully uploaded.";
			}else {
				
				include ('uploadrevision.php');
				echo "There was an error uploading the file. The file is too big.";
			}
		}else {
			
			include ('uploadrevision.php');
			echo "There was an error uploading the file.";
		}
	} else {
		
		include ('uploadrevision.php');
		echo "Invalid file type. Only txt, pdf, or docx files are accepted.";
		
		$find = "SELECT revisionTrackingNumber FROM document_revisions ORDER BY revisionTrackingNumber DESC LIMIT 1;";
		$finding = mysqli_query($dbc, $find);
		
		while ($row = $finding->fetch_assoc())
		{
			$lastrevision = $row['revisionTrackingNumber'] + 1;
		}
		
		$find2 = "SELECT version FROM document_revisions WHERE docTrackingNumber = $trackingno ORDER BY version DESC LIMIT 1;";
		$finding2 = mysqli_query($dbc, $find2);
		
		if (mysqli_num_rows($finding2) == 1)
		{
			while ($row = $finding2->fetch_assoc())
			{
				$version = $row['version'] + 1;
			}
		}
		else
		{
			$version = 1;
		}
		
		$query = "INSERT INTO document_revisions ('revisionTrackingNumber', 'docTrackingNumber', 'version') VALUES ('$lastrevision', '$trackingno', '$version');";
		
		$update = mysqli_query($dbc, $query);
	}
	
}