<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	$con = new mysqli($host, $user,$pass,$db_name);

	$select_query = "SELECT id,name,address,email,mobile,signup_type,email_verified FROM $members_table where status!='E'";  
	$result = $con->query($select_query) or die(mysqli_error($con));

	$columnHeader = '';  
	$columnHeader = "SI.NO". "\t" . "Name" . "\t" . "Address" . "\t" . "Email ID" . "\t" . 
	"Mobile Number" . "\t" . "Signup Type" . "\t" . "Email Verified" . "\t";  
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
	header("Content-Disposition: attachment; filename=Members_Details.xls");  
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