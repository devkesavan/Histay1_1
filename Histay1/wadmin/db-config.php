<?php
	$host = "localhost";
	$user = "hotel_booking_admin2";
	$pass = "u)XiM@6k#BnM";
	$db_name = "hotel_booking_db";
	$con = new mysqli($host, $user,$pass,$db_name);
	
	$json_key = "6h_3sN;8Un{Qy*Ct";
	date_default_timezone_set("asia/kolkata");

	function call_json($data)
	{
		$url = 'https://msteky.com/hotel_booking_demo_2023/json_api/thm_json_data.php';
		$ch = curl_init($url);
		/*$data = array(
		    'key' => $json_key,
		    'action' => 'designation',
		    'sort' => 'ASC',
		    'limit_st' => '0',
		    'limit_cnt' => '0',
		);*/
		//$payload = json_encode(array("user" => $data));
		$payload = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result = json_decode($result, true);
		//print_r($result);
	}
	
	function isMobileDevice(){
        $aMobileUA = array(
            '/iphone/i' => 'iPhone', 
            '/ipod/i' => 'iPod', 
            '/ipad/i' => 'iPad', 
            '/android/i' => 'Android', 
            '/blackberry/i' => 'BlackBerry', 
            '/webos/i' => 'Mobile'
        );
    
        //Return true if Mobile User Agent is detected
        foreach($aMobileUA as $sMobileKey => $sMobileOS){
            if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
                return true;
            }
        }
        //Otherwise return false..  
        return false;
    }
	
	//include('functions_whasapp.php');

	//Mail Details
	$mail_bg = "";
	$mail_logo = "https://msteky.com/hotel_booking_demo_2023/images/logo.jpg";
	$mail_email = "ECR Checkin";
	$mail_phone = "9894013873";
	$mail_copyright_url = "";
	$mail_copyright = "";
	$mail_button_url="";
	$mail_website="";
	$mail_website_url="";

   /*
   $con = new mysqli($host,$user,$pass,$db_name);
    if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }
    echo "Connected successfully"; */

	define("DBPRE","ra"); //DB prefix
	define("TITLE","ECR Checkin"); //Title
	$page_url = basename($_SERVER['PHP_SELF']);

	//Tables//
	$admin_table = DBPRE."_admin_users";
	$setting_table = DBPRE."_settings";
	$hotels_table = DBPRE."_hotels";
	$hotel_facilities_table = DBPRE."_hotel_facilities";
	$hotel_images_table = DBPRE."_hotel_images";
	$hotel_rating_tables = DBPRE."_hotel_rating";
	$hotel_rooms_tables = DBPRE."_hotel_rooms";
	$hotel_rooms_facilities_table = DBPRE."_hotel_rooms_facilities";
	$hotel_room_images_table = DBPRE."_hotel_room_images";
	$master_destination_table = DBPRE."_master_destination";
	$master_facilities_table = DBPRE."_master_facilities";
	$hotel_addons_table = DBPRE."_hotel_addons";
	$hotel_booking_addons_table = DBPRE."_hotel_booking_addons";
	$master_gallery_table = DBPRE."_master_gallery";
	$master_gallery_category_table = DBPRE."_master_gallery_category";
	$master_hotel_class_table = DBPRE."_master_hotel_class";
	$master_slider_table = DBPRE."_master_slider";
	$settings_table = DBPRE."_settings";
	$testimonial_table = DBPRE."_testimonial";
	$master_city_table=DBPRE."_master_city";
	$master_state_table =DBPRE."_master_state";
	$master_country_table=DBPRE."_master_country";
	$pages_table=DBPRE."_pages";
	$menus_table=DBPRE."_menus";
	$coupons_code_table=DBPRE."_coupons_code";
	$coupons_code_hotel_table=DBPRE."_hotel_coupons_code";
	$master_room_rates_table=DBPRE."_master_room_rates";
	$hotel_room_rates_table=DBPRE."_hotel_room_rates";
	$members_table=DBPRE."_members";
	$contact_table=DBPRE."_contact_enquiry";
	$events_table=DBPRE."_events";
	$events_registration_table=DBPRE."_events_registration";
	$hotel_booking_table=DBPRE."_hotel_booking";
	$hotel_room_booking_table=DBPRE."_hotel_booking_room";
	$master_tax_table =DBPRE."_master_tax";
	$hotel_room_number_table =DBPRE."_hotel_room_nos";
	$hotel_booking_room_date_table =DBPRE."_hotel_booking_room_dates";
	$member_favourite_table =DBPRE."_member_favourite";
	$master_property_type_table =DBPRE."_master_property_type";

	//Paths
	$MAIN_URL = "https://msteky.com/hotel_booking_demo_2023/";
	$desc_img_dir = "images/destinations";
	$pro_type_img_dir = "images/property_type";
	$hotel_img_dir = "images/hotels";
	$room_img_dir = "images/rooms";
	$facility_img_dir = "images/facility";
	$events_img_dir = "images/events";
	$slider_img_dir = "images/slider";
	$testinomial_img_dir = "images/testinomial";
	$coupon_img_dir = "images/coupons";	
	$addon_img_dir  = "images/addon";
?>