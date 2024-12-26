<?php
session_start();
include("wadmin/db-config.php");

extract($_POST);

$rooms = $total_cost = 0;
$rooms_arr = array_reverse($_SESSION['room_id']);
foreach($rooms_arr as $key => $value)
{
	if($value != "")
	{
		$rooms++;
		$data = array(
	    'key' => $json_key,
	    'action' => 'hotel_rooms',
	    'room_id' => $value,
	    'hotel_id' => '0',
	    'sort' => 'ASC',
	    'limit_st' => '0',
	    'limit_cnt' => '0',
	    );
	    $rooms_result = call_json($data);
	    $total_cost += $rooms_result['hotel_room_list'][0]['final_cost'];
	}
}

$c_in_out = explode(" - ",$_SESSION['check_in_out']);
$diff = abs(strtotime($c_in_out[1]) - strtotime($c_in_out[0]));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$total_cost = $total_cost * $days;

$data = array(
'key' => $json_key,
'action' => 'coupons_code',
'coupon_code' => $coupon_code,
'hotel_id' => "",
'order_value' => $total_cost
 );
$result = call_json($data);

if($result['vaild'] == "Y")
{
	if($result['coupon_data']['discount_type'] == "PER")
	{
		$discount = $total_cost * $result['coupon_data']['discount_value'] / 100;	
	}
	else
	{
		$discount = $result['coupon_data']['discount_value'];	
	}
	//$output['ck_days'] = $total_cost;
	$output['dis_value'] = $discount;
	$output['after_dis'] = $total_cost - $discount;
	$output['gst_value'] = round($output['after_dis'] * 9 / 100,2);
	$output['final_value'] = $output['after_dis'] + $output['gst_value'];
	$output['coupon_msg'] = "<span class='tt_coupon_msg tt_coupon_suc'>Coupon applied successfully</span>";
}
else
{
	$output['dis_value'] = 0;
	$output['after_dis'] = $total_cost;
	$output['gst_value'] = round($output['after_dis'] * 9 / 100,2);
	$output['final_value'] = $output['after_dis'] + $output['gst_value'];
	$output['coupon_msg'] = "<span class='tt_coupon_msg tt_coupon_fai'>Invalid coupon code</span>";
}
$output['vaild'] = $result['vaild'];

echo json_encode($output);
?>