<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	$con = new mysqli($host, $user,$pass,$db_name);

	$select_query = "SELECT hb.id,hb.booking_code,ht.name,hr.name as room,hrn.room_no,checkin_date,hbr.checkin_date,hbr.checkout_date,hb.first_name,hb.last_name, 
	hb.email,hb.address,hb.postal_code,ct.city,st.state,cn.country_name,hb.phone_number,hb.mobile_number,hb.coupon_code,hb.discount_type, 
	hb.order_total,tt.name,hb.tax_per,hb.tax_value,hb.final_total,hb.payment_method,hb.payment_status,hb.special_request,hb.created_at FROM $hotel_booking_table hb 
	inner join $hotel_room_booking_table hbr on hbr.booking_id=hb.id
	inner join $hotel_rooms_tables hr on hr.id=hbr.room_id
	inner join $hotel_room_number_table hrn on hrn.id=hbr.room_no_id
	inner join $hotels_table ht on ht.id=hb.hotel_id
	inner join $master_city_table ct on ct.id=hb.city_id 
	inner join $master_state_table st on st.id=hb.state_id
	inner join $master_country_table cn on cn.id=hb.country_id
	inner join $master_tax_table tt on tt.id=hb.tax_id where hb.status!='E'";  
	$result = $con->query($select_query) or die(mysqli_error($con));

	$columnHeader = '';  
	$columnHeader = "SI.NO". "\t" ."Booking Code" . "\t" . "Hotel Name" . "\t" . "Room Name" . "\t" ."Room No" . "\t" . "Checkin Date" . "\t" . "Checkout Date" . "\t" . 
	"First Name" . "\t" . "Last Name" . "\t" . "Email ID" . "\t" . "Address" . "\t" . "Postal Code" . "\t" . "City" . "\t" . 
	"State" . "\t" . "Country" . "\t" . "Phone Number" . "\t" . "Mobile Number" . "\t" . "Coupon Code" . "\t" . 
	"Discount Type" . "\t" . "Order Total" . "\t" . "Tax Name" . "\t" . "Tax Percentage" . "\t" . "Tax Value" . "\t" . 
	"Final Cost" . "\t" . "Payment Method" . "\t" . "Payment Status" . "\t" . "Special Request" . "\t" . "Booking Date" . "\t";  
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
	header("Content-Disposition: attachment; filename=Booking_Detail.xls");  
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