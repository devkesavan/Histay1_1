<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	$con = new mysqli($host, $user,$pass,$db_name);

	$select_query = "SELECT hr.id,ht.name,hr.name,hr.short_description,hr.max_childerns,hr.max_adults,hr.max_people,hr.min_people,hr.num_of_rooms,hr.actual_cost,hr.final_cost FROM $hotel_rooms_tables hr
	inner join $hotels_table ht on ht.id=hr.hotel_id where hr.status!='E'";  
	$result = $con->query($select_query) or die(mysqli_error($con));

	$columnHeader = '';  
	$columnHeader = "SI.NO". "\t" ."Hotel Name" . "\t" . "Name" . "\t" . "Short Description" . "\t" . "Childerns" . "\t" . 
	"Adults" . "\t" . "Max People" . "\t" . "Min People" . "\t" . "Num.of.Rooms" . "\t" . "Actual Cost" . "\t" . "Final Cost" . "\t";  
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
	header("Content-Disposition: attachment; filename=Hotels_Rooms_Detail.xls");  
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