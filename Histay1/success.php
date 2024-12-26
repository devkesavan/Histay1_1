<?php
session_start();
require("wadmin/db-config.php");
$page_url = basename($_SERVER['PHP_SELF']);


$customers_order = DBPRE."_customers_order";
$settings_table = DBPRE."_settings";
$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="aqtE7emL9H5M4mB73BaEORFPvEsGDXRf";
//$salt="rTIO38xoPJ";

If (isset($_POST["additionalCharges"]))
{
	$additionalCharges=$_POST["additionalCharges"];
	$retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
}
else
{	  
	$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
}
$hash = hash("sha512", $retHashSeq);

if ($hash != $posted_hash)
{
	echo "Error code: 1 Invalid Transaction. Please try again";
}
else
{
	//if($_SESSION['payumoney_txnid'] == $txnid && $_SESSION['payumoney_order_total'] == round($amount) && $_SESSION['payumoney_customer_email'] == $email)
	//{
	    $booking_id = $_GET['booking_id'];
	    
	    /*$booking_id = $_SESSION['payumoney_txnid'];
	    $booking_code = $_SESSION['payumoney_booking_code'];
	    $customer_name = $_SESSION['payumoney_customer_name'];
	    $customer_email = $_SESSION['payumoney_customer_email'];*/
	    
	    /*$booked_rooms = array();
		$rooms = $total_cost = 0;
		$room_names = "";
		$rooms_arr = array_reverse($_SESSION['room_id']);
		foreach($rooms_arr as $key => $value)
		{
			if($_SESSION['room_id'][$key] != "")
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
			    $room_names .= $rooms_result['hotel_room_list'][0]['name'];
			    $booked_rooms[] = array('room_id' => $_SESSION['room_id'][$key], 'adults' => $_SESSION['adults'][$key], 'childerns' => $_SESSION['childerns'][$key], 'cost' => $rooms_result['hotel_room_list'][0]['final_cost']);
			}
		}
		
		$data = array(
    	  'key' => $json_key,
    	  'action' => 'hotel_booking_confirm',
    	  'booking_id' => $booking_id,
    	  'booked_rooms' => $booked_rooms
	    );*/
	    
	    /*$data = array(
    	  'key' => $json_key,
    	  'action' => 'hotel_booking_confirm',
    	  'booking_id' => $booking_id
	    );
	    $booking_result = call_json($data);
	    $booking_code = $booking_result['booking_code'];
	    $customer_name = $booking_result['customer_name'];
	    $customer_email = $booking_result['customer_email'];
	    
		$data = array(
    	'key' => $json_key,
    	'action' => 'hotel_details',
    	'hotel_id' => $_SESSION['hotel_id'],
    	'sort' => 'ASC',
    	'slug' =>'',
    	'limit_st' => '0',
    	'limit_cnt' => '0',
    	);
    	$hotel_result = call_json($data);
		
    	$guests = array_sum($_SESSION['adults'])." Adults, ".array_sum($_SESSION['childerns'])." Children";
    	$booked_rooms_count = count($booked_rooms);
	  
	    $mail_h4 = "Booking ";
    	$mail_h1 = "Confirmaion";
    
    	$from_mail = "info@ecrcheckin.in";
    	$from_name = "Booking Confirmaion - Ecrcheckin";
    	$to_mail = $customer_email.",booking@ecrcheckin.com,dhava.dhavasi@gmail.com";
    	$subject = "Booking Confirmaion | Ecrcheckin";
    
    	//Headers
    	$headers ="";
    	$headers .= "Reply-To: The Sender <$from_mail>\r\n";
    	$headers .= "Cc: $from_mail\r\n";
    	$headers .= "Return-Path: $from_name <$from_mail>\r\n";
    	$headers .= "From: $from_name <$from_mail>\r\n";
    
    	$headers .= "Organization: Sender Organization\r\n";
    	$headers .= "MIME-Version: 1.0\r\n";
    	//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    	$headers .= "X-Priority: 3\r\n";
    	$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
    
    	$htmlcontent = '<div style="width:650px;background:#ddd;padding:10px;font-family: -webkit-pictograph;">
        	<table>
        		<tr>
        			<td><h3 style="display:inline;">Booking Confirmaion</h3>
        				<img src="https://ecrcheckin.in/images/logo.png" style="width: 100px;float: right;padding: 0 0 10px 0;"></td>
            		</tr>
            		<tr>
            			<td style="background:#fff;padding:10px;">
            				<table>
            					<tr><td>Dear '.$customer_name.',</td></tr>
            					<tr><td><h4 style="color:green;margin: 0;">Your Booking is Confirmed!</h4></td></tr>
            					<tr><td>Booking ID: <b>'.$booking_code.'</b><br><br></td></tr>
            					<tr><td style="background:#eee;border:1px solid #ccc;padding:10px;">To know more about inclusions, cancellation policy and additional details, please refer to the attached PDF document.</td></tr>
            				</table>
            			</td>
            		</tr>
            		<tr>
            			<td>
            				<table>
            					<tr><td colspan="2"><h3 style="margin:0;padding-top:10px;font-weight:500;">HOTEL DETAILS</h3></td></tr>
            					<tr>
            						<td><img src="'.$hotel_result['hotels_details_list']['hotel_images'][0]['hotel_image'].'" style="width:250px;"></td>
            						<td valign="top" style="background:#fff;padding:10px;"><h4 style="margin:0;padding-bottom:5px">'.$hotel_result['hotels_details_list']['name'].'</h4>
            							'.$hotel_result['hotels_details_list']['address'].'<br><br>
            							<b>Contact:</b> '.$hotel_result['hotels_details_list']['phone_number'].'<br>
            							<b>Email:</b> '.$hotel_result['hotels_details_list']['email_id'].'</td></tr>
            					<tr><td colspan="2" style="padding: 20px 0;">
            						<a href="#" style="padding:8px 20px;background:#333;color:#fff;text-decoration:none;font-weight:bold;">Manage Bookings</a>
            					</td></tr>
            				</table>
            			</td>
            		</tr>
            		<tr>
            			<td>
            				<table style="width:100%;">
            					<tr><td><h3 style="margin:0;padding-top:10px;font-weight:500;">RESERVATION DETAILS</h3></td>
            						<td><h3 style="margin:0;padding-top:10px;font-weight:500;">FARE DETAILS</h3></td></tr>
            					<tr>
            						<td style="width:50%;">
            							<table width="100%" style="background:#fff;padding: 0 7px;">
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0"> Check in </td>
            									<td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0" align="right">'.$_SESSION['check_in'].'</td>
            								</tr>
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0"> Check out </td><td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0" align="right">'.$_SESSION['check_out'].'</td>
            								</tr>
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0"> Room Type </td><td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0" align="right">'.$room_names.'</td>
            								</tr>
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0"> Reservation </td><td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0" align="right">'.$booked_rooms_count.'</td>
            								</tr>
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0"> No of Guests </td><td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0" align="right">'.$guests.'</td>
            								</tr>
            							</table>
            						</td>
            						<td style="width:50%;vertical-align: text-bottom;background: #fff;">
            							<table width="100%" style="background:#fff;padding: 0 7px;">
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0"> Base Amount </td>
            									<td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0" align="right">Rs.'.$total_cost.'</td>
            								</tr>
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0"> Discount </td><td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0" align="right">Rs.0</td>
            								</tr>
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0"> Sub Total </td><td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0" align="right">Rs.'.$total_cost.'</td>
            								</tr>
            								<tr>
            									<td style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 2px #ddd"> GST </td><td width="170" style="font-size:12px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 2px #ddd" align="right">Rs.'.$gst_value.'</td>
            								</tr>
            								<tr>
            									<td style="font-size:14px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0;font-weight:bold"> Grand Total </td><td width="170" style="font-size:14px;color:#666666;padding:5px 0 5px 0;border-bottom:solid 1px #ebebf0;font-weight:bold" align="right">Rs.'.$final_cost.'</td>
            								</tr>
            							</table>
            						</td>
            					</tr>
            				</table>
            			</td>
            		</tr>
            		<tr>
            			<td>
            				<table style="width:100%;">
            					<tr><td><h3 style="margin:0;padding-top:10px;font-weight:500;">FOOT NOTES</h3></td></tr>
            					<tr>
            						<td>
            							<table style="width:100%;background:#fff;">
            								<tr>
            									<td><p style="font-size:12px">It is mandatory for guests to present valid photo identification at the time of check-in.</p>
            										<p style="font-size:12px">If your hotel includes a complimentary car transfer, you will need to call the hotel directly to let them know of your travel details.</p>
            									</td>
            								</tr>
            							</table>
            						</td>
            					</tr>
            				</table>
            			</td>
            		</tr>
            		<tr>
            			<td>
            				<table style="width:100%;">
            					<tr><td><h3 style="margin:0;padding-top:10px;font-weight:500;">ECRCHECKIN CUSTOMER SUPPORT</h3></td></tr>
            					<tr>
            						<td style="background:#fff;">
            							<table style="width:75%;margin: 0 auto;">
            								<tr>
            									<td>
            										<h3 style="margin: 0;color: #222;">+91 99999 99999</h3>
            										<small>Customer Support</small>
            									</td>
            									<td>
            										<h3 style="margin: 0;color: #222;">+91 99999 99999</h3>
            										<small>Sales Support</small>
            									</td>
            								</tr>
            								<tr><td style="padding:5px;"></td></tr>
            								<tr>
            									<td>
            										<h3 style="margin: 0;color: #222;">support@ecrcheckin.in</h3>
            										<small>Email Support</small>
            									</td>
            									<td>
            										<h3 style="margin: 0;color: #222;">sales@ecrcheckin.in</h3>
            										<small>Sales Email Support</small>
            									</td>
            								</tr>
            							</table>
            						</td>
            					</tr>
            				</table>
            			</td>
            		</tr>
            		<tr>
            			<td>&nbsp;</td>
            		</tr>
            	</table>
            </div>';
    
    	// Send email
    	//echo $htmlcontent;
    	if(mail($to_mail, $subject, $htmlcontent, $headers));
    	{
    	    //echo $to_mail;
    	    echo "<script>window.location.href='booking_success.php?booking_code=$booking_code';</script>";
    	}*/
    	echo "<script>window.location.href='booking_success.php?booking_code=$booking_code&booking_id=$booking_id';</script>";
	/*}
	else
	{
		echo "<h4>Error code: 2 Invalid Transaction. Please try again</h4>";
	}*/
}      
?>	