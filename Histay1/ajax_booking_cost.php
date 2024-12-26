<?php
include("wadmin/db-config.php");

extract($_POST);
$rdata['checkin_date'] = $checkin_date;
$rdata['checkout_date'] = $checkout_date;
$checkin_date = date("Y-m-d", strtotime($checkin_date));  
$checkout_date = date("Y-m-d", strtotime($checkout_date));

$days = (strtotime($checkout_date) - strtotime($checkin_date))/60/60/24;
          
$select_query = "SELECT rt.final_cost,tm.value from $hotel_rooms_tables rt inner join $master_tax_table tm on rt.tax_id=tm.id 
                    where rt.id='$room_id' and rt.status='A'";
$result = $con->query($select_query) or die(mysqli_error($con));
$data = $result->fetch_array();
	
$rdata['cost'] = $data['final_cost'] * $rooms * $days;
$rdata['tax'] = $rdata['cost'] * $data['value'] / 100;
$rdata['total'] = $rdata['cost'] + $rdata['tax'];

$rdata['cost'] = "₹".$rdata['cost'];
$rdata['tax'] = "₹".$rdata['tax'];
$rdata['total'] = "₹".$rdata['total'];
$rdata['days'] = $days;

echo json_encode($rdata);
?>