<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	$con = new mysqli($host, $user,$pass,$db_name);

	$select_query = "SELECT ht.id,dt.name as destination,ct.city as city_name,ht.star,ht.code,ht.name,ht.slug,ht.short_description,ht.description,ht.address,ht.phone_number,ht.email_id FROM $hotels_table ht 
	inner join $master_destination_table dt on dt.id=ht.destination_id 
	inner join $master_city_table ct on ct.id=ht.city_id where ht.status!='E'";  
	$result = $con->query($select_query) or die(mysqli_error($con));

	$columnHeader = '';  
	$columnHeader = "SI.NO". "\t" ."Destination" . "\t" . "City" . "\t" . "Star" . "\t" . "Code" . "\t" . 
	"Name" . "\t" . "slug" . "\t" . "Short Description" . "\t" . "Description" . "\t" . "Address" . "\t" . "Phone Number" . "\t" . 
	"Email Id" . "\t";  
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
	header("Content-Disposition: attachment; filename=Hotels_Detail.xls");  
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