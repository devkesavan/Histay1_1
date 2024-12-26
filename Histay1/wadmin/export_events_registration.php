<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	$con = new mysqli($host, $user,$pass,$db_name);

	$select_query = "SELECT er.id,et.event_name,er.name,er.gender,er.dob,er.email,er.mobile,er.created_at FROM $events_registration_table er
	inner join $events_table et on et.id=er.event_id where er.status!='E'";  
	$result = $con->query($select_query) or die(mysqli_error($con));

	$columnHeader = '';  
	$columnHeader = "SI.NO". "\t" ."Event Name" . "\t" . "Name" . "\t" . "Gender" . "\t" . "Date Of Birth" . "\t" . 
	"Email ID" . "\t" . "Mobile Number" . "\t" . "Registration Date" . "\t";  
	$setData = '';  
	while ($rec = mysqli_fetch_row($result)) 
	{ 

		$rowData = '';  
	    foreach ($rec as $value) 
	    {  
	        $value = '"' . $value . '"' . "\t";  
	        $rowData .= $value;  
	    }  
	    $setData .= trim($rowData) . "\n";  
	}  

	header("Content-type: application/octet-stream");  
	header("Content-Disposition: attachment; filename=Event_Registration_Details.xls");  
	header("Pragma: no-cache");  
	header("Expires: 0");  

	echo ucwords($columnHeader) . "\n" . $setData . "\n";  
	?>
	<?php
	}
	else
	{
		echo "<script>window.location.href='login.php';</script>";
	}
	?> 