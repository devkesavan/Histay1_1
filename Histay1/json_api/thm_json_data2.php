<?php
session_start();
header('Content-Type: application/json');

// header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

include("../wadmin/db-config.php");
$con = new mysqli($host,$user,$pass,$db_name);

$json_data = json_decode(file_get_contents('php://input'), true);
//print_r($json_data);
extract($json_data);

//DESIGNATION LIST
if($action == "destination")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	if($destination_id != 0)
		$des_qry = "and id='$destination_id'";
	else
		$des_qry = "";
	
	$arr = array();
	$select_query = "select * from $master_destination_table where status='A' $des_qry $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$des_image = $MAIN_URL."/".$desc_img_dir."/small/".$data['des_image'];
	    $arr[] = array("destination_id" => $data['id'], "name" => $data['name'], "slug" => $data['slug'],"short_description" => $data['short_description'], "image" => $des_image, "sort_no" => $data['sort_no']);
	}
    
    $output = array("success" => 1, "destination_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//PERPERTY TYPE LIST
if($action == "property_type")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	if($destination_id != 0)
		$des_qry = "and id='$destination_id'";
	else
		$des_qry = "";
	
	$arr = array();
	$select_query = "select * from $master_property_type_table where status='A' $des_qry $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$des_image = $MAIN_URL."/".$pro_type_img_dir."/small/".$data['des_image'];
	    $arr[] = array("property_type_id" => $data['id'], "name" => $data['name'], "slug" => $data['slug'],"short_description" => $data['short_description'], "image" => $des_image, "sort_no" => $data['sort_no']);
	}
    
    $output = array("success" => 1, "property_type_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//HOTEL LIST
if($action == "hotel_list")
{
	if($sort == "ASC")
		$sort_qry = "order by ht.sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by ht.sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";
	elseif($sort == "PHL")
		$sort_qry = "order by rm.final_cost desc";
	elseif($sort == "PLH")
		$sort_qry = "order by rm.final_cost asc";
	elseif($sort == "RHL")
		$sort_qry = "order by hr.id asc";
	elseif($sort == "RLH")
		$sort_qry = "order by hr.id desc";
	else
		$sort_qry = "order by ht.sort_no asc";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	$arr = array();
	/*$select_query = "SELECT ht.*,cm.city as city_name,hi.hotel_image as hotel_image,round(AVG(hr.rating),1) as rating,COUNT(DISTINCT hr.id) as review_count,COUNT(DISTINCT hb.id) as booking_count,min(rm.final_cost) as cost FROM $hotels_table ht 
					inner join $master_city_table cm on ht.city_id=cm.id 
					inner join $hotel_images_table hi on ht.id=hi.hotel_id 
					inner join $hotel_rating_tables hr on ht.id=hr.hotel_id 
					inner join $hotel_booking_table hb on hb.hotel_id=ht.id 
					inner join $hotel_rooms_tables rm on rm.hotel_id=ht.id where ht.status='A' and hi.default_image='Y' and rm.status='A' group by ht.id $sort_qry $limit_qry";*/

	$select_query = "SELECT ht.*,cm.city as city_name,hi.hotel_image as hotel_image,min(rm.final_cost) as cost FROM $hotels_table ht 
					inner join $master_property_type_table ctt on ctt.id=ht.category_type_id 
					inner join $master_city_table cm on ht.city_id=cm.id 
					inner join $hotel_images_table hi on ht.id=hi.hotel_id 
					inner join $hotel_rooms_tables rm on rm.hotel_id=ht.id where ht.status='A' and hi.default_image='Y' and rm.status='A' group by ht.id $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$select_rquery = "SELECT round(AVG(rating),1) as rating,COUNT(DISTINCT id) as review_count from $hotel_rating_tables where hotel_id='$data[id]'";
		$sel_rquery =$con->query($select_rquery) or die(mysqli_error($con));
		$rdata = $sel_rquery->fetch_array();

		$booking_count = 0;
		$hotel_image = $MAIN_URL."/".$hotel_img_dir."/small/".$data['hotel_image'];
	    $arr[] = array("hotel_id" => $data['id'], "destination_id" => $data['destination_id'], "city_name" => $data['city_name'], "star" => $data['star'], "code" => $data['code'], "name" => $data['name'], "slug" => $data['slug'], "short_description" => $data['short_description'], 
	    	"description" => $data['description'], "address" => $data['address'], "phone_number" => $data['phone_number'], "email_id" => $data['email_id'], 
	    	"map" => $data['map'],"rating" => $rdata['rating'],"review_count" => $rdata['review_count'],"booking_count" => $booking_count,"cost" => $data['cost'],"hotel_image" => $hotel_image);
	}
    
    $output = array("success" => 1, "hotels_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//HOTEL LIST with multiple images
if($action == "hotel_list_wmi")
{
	if($destination_id != 0)
		$filter_qry = "and ht.destination_id='$destination_id'";
	else
		$filter_qry = "";

	if($sort == "ASC")
		$sort_qry = "order by ht.sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by ht.sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";
	elseif($sort == "PHL")
		$sort_qry = "order by rm.final_cost desc";
	elseif($sort == "PLH")
		$sort_qry = "order by rm.final_cost asc";
	elseif($sort == "RHL")
		$sort_qry = "order by hr.id asc";
	elseif($sort == "RLH")
		$sort_qry = "order by hr.id desc";
	else
		$sort_qry = "order by ht.sort_no asc";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	$arr = array();
	/*$select_query = "SELECT ht.*,cm.city as city_name,hi.hotel_image as hotel_image,round(AVG(hr.rating),1) as rating,COUNT(DISTINCT hr.id) as review_count,COUNT(DISTINCT hb.id) as booking_count,min(rm.final_cost) as cost FROM $hotels_table ht 
					inner join $master_city_table cm on ht.city_id=cm.id 
					inner join $hotel_images_table hi on ht.id=hi.hotel_id 
					inner join $hotel_rating_tables hr on ht.id=hr.hotel_id 
					inner join $hotel_booking_table hb on hb.hotel_id=ht.id 
					inner join $hotel_rooms_tables rm on rm.hotel_id=ht.id where ht.status='A' and hi.default_image='Y' and rm.status='A' group by ht.id $sort_qry $limit_qry";*/

	$select_query = "SELECT ht.*,cm.city as city_name,min(rm.final_cost) as cost,min(rm.actual_cost) as actual_cost,ctt.name as property_type FROM $hotels_table ht 
					inner join $master_property_type_table ctt on ctt.id=ht.category_type_id 
					inner join $master_city_table cm on ht.city_id=cm.id 
					inner join $hotel_rooms_tables rm on rm.hotel_id=ht.id where ht.status='A' and rm.status='A' $filter_qry group by ht.id $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$hi_arr = "";
		$hi_arr = array();
		$select_rquery = "SELECT round(AVG(rating),1) as rating,COUNT(DISTINCT id) as review_count from $hotel_rating_tables where hotel_id='$data[id]'";
		$sel_rquery =$con->query($select_rquery) or die(mysqli_error($con));
		$rdata = $sel_rquery->fetch_array();

		//Hotel Images
		$select_query3 = "select * from $hotel_images_table where status='A' and hotel_id='$data[id]'";
		$sel_query3 =$con->query($select_query3) or die(mysqli_error($con));
		while($data3 = $sel_query3->fetch_array())
		{
			$hotel_image = $MAIN_URL."/".$hotel_img_dir."/small/".$data3['hotel_image'];
			$hi_arr[] = array("hotel_image_id" => $data3['id'], "hotel_image" => $hotel_image, "default_image" => $data3['default_image']);
		}

		/*$select_rmquery = "SELECT actual_cost,final_cost from $hotel_rooms_tables where hotel_id='$data[id]' and status='A' order by final_cost limit 1";
		$sel_rmquery =$con->query($select_rmquery) or die(mysqli_error($con));
		$rmdata = $sel_rmquery->fetch_array();*/

		$booking_count = 0;
	    $arr[] = array("hotel_id" => $data['id'], "property_type" => $data['property_type'],"destination_id" => $data['destination_id'], "city_name" => $data['city_name'], "star" => $data['star'], "code" => $data['code'], "name" => $data['name'], "slug" => $data['slug'], "short_description" => $data['short_description'], 
	    	"description" => $data['description'], "address" => $data['address'], "phone_number" => $data['phone_number'], "email_id" => $data['email_id'], 
	    	"map" => $data['map'],"rating" => $rdata['rating'],"review_count" => $rdata['review_count'],"booking_count" => $booking_count,"cost" => $data['cost'],"actual_cost" => $data['actual_cost'],"hotel_images" => $hi_arr);
	}
    
    $output = array("success" => 1, "hotels_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//HOTEL DETAILS LIST
if($action == "hotel_details")
{
	if($sort == "ASC")
		$sort_qry = "order by ht.sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by ht.sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	if($hotel_id != 0)
		$hotel_qry = "and ht.id='$hotel_id'";
	else
		$hotel_qry = "";

	if($slug != "")
		$slug_qry = "and ht.slug='$slug'";
	else
		$slug_qry = "";

	$hf_arr = array();
	$hi_arr = array();

	//Hotel List
	$select_query = "SELECT ht.*,cm.city as city_name,min(rm.final_cost) as cost,min(rm.actual_cost) as actual_cost FROM $hotels_table ht 
					inner join $master_city_table cm on ht.city_id=cm.id 
					inner join $hotel_rooms_tables rm on rm.hotel_id=ht.id 
					where ht.status='A' and rm.status='A' $hotel_qry $slug_qry $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	$data = $sel_query->fetch_array();	

	$select_rquery = "SELECT round(AVG(rating),1) as rating,COUNT(DISTINCT id) as review_count from $hotel_rating_tables where hotel_id='$data[id]'";
	$sel_rquery =$con->query($select_rquery) or die(mysqli_error($con));
	$rdata = $sel_rquery->fetch_array();

	//Hotel_Facilities
	$select_query2 = "SELECT hf.id,hf.sort_no,hf.hotel_id,fm.name,fm.icon_image from $hotel_facilities_table hf 
						inner join $master_facilities_table fm on hf.facility_id=fm.id 
						WHERE fm.status='A' and hf.hotel_id='$data[id]'";
	$sel_query2 =$con->query($select_query2) or die(mysqli_error($con));
	while($data2 = $sel_query2->fetch_array())
	{
		$hf_arr[] = array("hotel_facilities_id" => $data2['id'], "name" => $data2['name'], "icon_image" => $data2['icon_image']);
	}

	//Hotel Images
	$select_query3 = "select * from $hotel_images_table where status='A' and hotel_id='$data[id]'";
	$sel_query3 =$con->query($select_query3) or die(mysqli_error($con));
	while($data3 = $sel_query3->fetch_array())
	{
		$hotel_image = $MAIN_URL."/".$hotel_img_dir."/large/".$data3['hotel_image'];
		$hi_arr[] = array("hotel_image_id" => $data3['id'], "hotel_image" => $hotel_image, "default_image" => $data3['default_image']);
	}

    $arr = array("hotel_id" => $data['id'], "destination_id" => $data['destination_id'], "city_name" => $data['city_name'], "star" => $data['star'], "code" => $data['code'], "name" => $data['name'], "slug" => $data['slug'], "short_description" => $data['short_description'], 
	    	"description" => $data['description'], "address" => $data['address'], "phone_number" => $data['phone_number'], "email_id" => $data['email_id'], 
	    	"map" => $data['map'],"cost" => $data['cost'],"actual_cost" => $data['actual_cost'],"rating" => $rdata['rating'],"review_count" => $rdata['review_count'],"hotel_facilities" => $hf_arr, "hotel_images" => $hi_arr);
	
	$output = array("success" => 1, "hotels_details_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Rating LIST
if($action == "hotel_rating")
{
	if($sort == "ASC")
		$sort_qry = "order by id asc";
	elseif($sort == "DSC")
		$sort_qry = "order by id desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	if($hotel_id != 0)
		$hotel_qry = "and hotel_id='$hotel_id'";
	else
		$hotel_qry = "";
	
	
	$arr = array();
	$select_query = "select * from ra_hotel_rating where status='A' $hotel_qry $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	    $arr[] = array("rating_id" => $data['id'], "name" => $data['name'], "email" => $data['email'], "comment" => $data['comment'], "rating" => $data['rating'], "sort_no" => $data['sort_no'], "created_at" => $data['created_at']);
	}
    
    $output = array("success" => 1, "hotel_rating_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Slider LIST
if($action == "cms_slider")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";
	
	$arr = array();
	$select_query = "select * from $master_slider_table where status='A' $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$slide_image = $MAIN_URL."/".$slider_img_dir."/large/".$data['slide_image'];
	    $arr[] = array("slider_id" => $data['id'], "title" => $data['title'], "text1" => $data['text1'], "text2" => $data['text2'], "slide_image" => $slide_image, "page_link" => $data['page_link'], "sort_no" => $data['sort_no']);
	}
    
    $output = array("success" => 1, "master_slider_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Testimonial LIST
if($action == "hotel_testimonial")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";
	
	$arr = array();
	$select_query = "select * from $testimonial_table where status='A' $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	    $arr[] = array("testimonial_id" => $data['id'], "name" => $data['name'], "email" => $data['email'], "designation" => $data['designation'], "image" => $data['image'], "stars" => $data['stars'], "message" => $data['message'], "sort_no" => $data['sort_no']);
	}
    
    $output = array("success" => 1, "testimonial_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Hotel category gallery LIST
if($action == "hotel_category_gallery")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";
	
	$arr = array();
	$select_query = "select * from $master_gallery_category_table where status='A' $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	    $arr[] = array("gallery_category_id" => $data['id'], "name" => $data['name'], "description" => $data['description']);
	}
    
    $output = array("success" => 1, "category_gallery_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Hotel gallery LIST
if($action == "hotel_gallery")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";
	
	$arr = array();
	$select_query = "select * from $master_gallery_table where status='A' $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	    $arr[] = array("gallery_id" => $data['id'], "gallery_cat_id" => $data['gallery_cat_id'], "title" => $data['title'], "image" => $data['image']);
	}
    
    $output = array("success" => 1, "gallery_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Pages LIST
if($action == "cms_pages")
{	
	$arr = array();
	$select_query = "select * from $pages_table where status='A' and id='$page_id'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	$data = $sel_query->fetch_array();
	
	$arr = array("page_id" => $data['id'], "name" => $data['name'], "title" => $data['title'], "slug" => $data['slug'], "main_content" => $data['main_content'], "parent_page_id" => $data['parent_id']);

    
    $output = array("success" => 1, "page_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Menus LIST
if($action == "cms_menus")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";
	
	$arr = array();
	$select_query = "select * from $menus_table where status='A' $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	    $arr[] = array("menu_id" => $data['id'], "name" => $data['name'], "title" => $data['title'], "item_type" => $data['item_type'], "page_id" => $data['page_id'],"url" => $data['url'], "main_menu" => $data['main_menu'], "footer_menu" => $data['footer_menu']);
	}
    
    $output = array("success" => 1, "menu_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}


//Coupons Code check
if($action == "coupons_code")
{
	$current_date = date('Y-m-d');

	if($hotel_id != 0)
		$hotel_qry = "and hc.hotel_id='$hotel_id'";
	else
		$hotel_qry = "";

	if($order_value != 0)
		$val_qry = "and cc.min_value<='$order_value'";
	else
		$val_qry = "";

	$date_qry = "and(cc.valid_from<='$current_date' and cc.valid_to>='$current_date')";

	$arr = array();
	/*$select_query = "SELECT cc.* FROM $coupons_code_table cc 
				inner join $coupons_code_hotel_table hc on cc.id=hc.coupon_id where cc.status='A' and cc.coupon_code='$coupon_code' $hotel_qry $val_qry $date_qry";*/
	$select_query = "SELECT cc.* FROM $coupons_code_table cc where cc.status='A' and cc.coupon_code='$coupon_code' $val_qry $date_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	$count = mysqli_num_rows($sel_query);
	if($count > 0)
	{
		$data = $sel_query->fetch_array();
		$arr = array("coupon_id" => $data['id'],"discount_type" => $data['discount_type'], "discount_value" => $data['discount_value'], "max_discount" => $data['max_discount']);
	    $output = array("success" => 1,"vaild"=> 'Y',"coupon_data"=> $arr);
	}
	else
	{
		$output = array("success" => 1,"vaild"=> 'N',"coupon_data"=> $arr);
	}
	echo json_encode($output, JSON_UNESCAPED_SLASHES);

}

//Coupons Code dipslay
if($action == "coupons_code_disp")
{
	$current_date = date('Y-m-d');

	$arr = array();
	$select_query = "SELECT * FROM $coupons_code_table  where status='A'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$image = $MAIN_URL."/".$coupon_img_dir."/small/".$data['image'];
		$arr[] = array("coupon_id" => $data['id'],"coupon_code" => $data['coupon_code'],"name" => $data['name'],"description" => $data['description'],"discount_type" => $data['discount_type'], "discount_value" => $data['discount_value'], "image" => $image);
	}
	$output = array("success" => 1,"offers_list"=> $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);

}

//Hotel Room Rate LIST
if($action == "hotel_room_rate")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";
	
	$arr = array();
	$select_query = "select * from $room_rate_table where status='A' $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	     $arr[] = array("room_rate_id" => $data['id'], "room_id" => $data['room_id'], "start_date" => $data['start_date'], "end_date" => $data['end_date'], "price_night" => $data['price_night'], "num_people" => $data['num_people'], "adult_price" => $data['adult_price'], "child_price" => $data['child_price'], "discount" => $data['discount'], "discount_type" => $data['discount_type']);
	}
    
    $output = array("success" => 1, "hotel_room_card_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Settings LIST
if($action == "settings")
{
	
	$arr = array();
	$select_query = "select * from $settings_table where status='A'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	$data = $sel_query->fetch_array();
	$arr = array("settings_id" => $data['id'], "business_name" => $data['business_name'], "business_logo" => $data['business_logo'], "mobile" => $data['mobile'], "email" => $data['email'], "address" => $data['address'], "city" => $data['city'], "state" => $data['state'], "pincode" => $data['pincode']);
	$output = array("success" => 1, "settings_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Members LIST
if($action == "members")
{
	
	$arr = array();
	$select_query = "select * from $members_table where status='A'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	     $arr[] = array("member_id" => $data['id'], "name" => $data['name'], "address" => $data['address'], "email" => $data['email'], "mobile" => $data['mobile'], "password" => $data['password'], "login_token" => $data['login_token'], "forgot_token" => $data['forgot_token']);
	}
    
    $output = array("success" => 1, "Members_List" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Members Signup
if($action == "members_signup")
{
	$select_query = "select id from $members_table where email='$email' and status!='E'";
	$sel_query = $con->query($select_query) or die(mysqli_error($con));
	$count = mysqli_num_rows($sel_query);
	if($count == 0)
	{
		$created_at = date('Y-m-d H:i:s');
		$signup_type = "W";
		$insert_query = "insert into $members_table(name,email,address,mobile,password,verification_token,signup_type,created_at,status) 
							values('$name','$email','$address','$mobile','$password','','W','$created_at','A')";
		$result = $con->query($insert_query) or die(mysqli_error($con));
		$insert_id = $con->insert_id;

		$raw_token = $insert_id.date('y-m-d H:i:s');
		$verification_token = md5(uniqid($raw_token, true));

		$update_query = "update $members_table set verification_token='$verification_token' where id='$insert_id'";
		$result = $con->query($update_query) or die(mysqli_error($con));

		$output = array("success" => 1,"member_id" => $insert_id,"mobile" => $mobile,"verification_token" => $verification_token);
	}
	else
	{
		$output = array("success" => -1);
	}
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Members Signup Verify
if($action == "members_signup_verify")
{
	$select_query = "select id from $members_table where id='$id' and verification_token='$verification_token' and status!='E'";
	$sel_query = $con->query($select_query) or die(mysqli_error($con));
	$count = mysqli_num_rows($sel_query);
	if($count > 0)
	{
		$update_query = "update $members_table set status='A' where id='$id'";
		$result = $con->query($update_query) or die(mysqli_error($con));

		$output = array("success" => 1);
	}
	else
	{
		$output = array("success" => -1);
	}
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Members Login
if($action == "members_login")
{
	$select_query = "select id,name,mobile,email,email_verified,profile_photo,status from $members_table where email='$email' and password='$password' and status='A'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	$count = mysqli_num_rows($sel_query);
	if($count == 1)
	{
		$data = $sel_query->fetch_array();
		
		$raw_token = $data['id'].date('y-m-d H:i:s');
		$login_token = md5(uniqid($raw_token, true));

		//$upd_query = "update $members_table set email_verified='Y',login_token='$login_token' where id='$data[id]'";
		//$result = $con->query($upd_query) or die(mysqli_error($con));
		$output = array("success" => 1,"member_id" => "$data[id]", "login_token" => "$login_token", "name" => "$data[name]", "email" => "$data[email]", "mobile" => "$data[mobile]","profile_photo" => "$profile_photo","status" => "$data[status]");
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
			
	}
	else
	{
		$output = array("success" => -1);
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
	}
}

//Members Edit Profile
if($action == "members_edit")
{
	$select_query = "select * from $members_table where status!='E' and login_token='$login_token'";
	$sel_query = $con->query($select_query) or die(mysqli_error($con));
	$count = mysqli_num_rows($sel_query);
	if($count == 1)
	{
		$data = $sel_query->fetch_array();
		//update Edit Profile
		$upd_query = "update $members_table set name='$name',address='$address',email='$email',mobile='$mobile',password='$password',email_verified='$email_verified' where login_token='$login_token'";
		$result = $con->query($upd_query) or die(mysqli_error($con));
		$output = array("success" => 1);
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
	}
	else
	{
		$output = array("success" => -1);
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
	}	

}

//Members Forgot Password
if($action == "members_forgot")
{
	$select_query = "select id,name from $members_table where status!='E' and login_token='$login_token'";
	$sel_query = $con->query($select_query) or die(mysqli_error($con));
	$count = mysqli_num_rows($sel_query);
	if($count > 0)
	{
		$data = $sel_query->fetch_array();
		
		//update forgot token
		$upd_query = "update $members_table set forgot_token='$forgot_token' where login_token='$login_token'";
		$result = $con->query($upd_query) or die(mysqli_error($con));
		//Mail
    	$mail_h4 = "Forgot password";
    	$mail_h1 = "Request";
    	$mail_main_msg = "";
    	$mail_button = "Reset Password";
    	$mail_button_url = $mail_website_url."reset_password.php?reset=1&ftoken=".$forgot_token."&email=".$email;
    
    	$from_mail = $mail_email;
    	$from_name = "Reset Password  - $mail_website";
    
    	$to_mail = "$email";
    
    	$subject = "Reset Password | $mail_website";
    
    	//Headers
		$headers = "Reply-To: The Sender <$from_mail>\r\n";
		$headers .= "Return-Path: $from_name <$from_mail>\r\n";
		$headers .= "From: $from_name <$from_mail>\r\n";

		$headers .= "Organization: Sender Organization\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
    
    	$htmlcontent = '<div style="background:'.$mail_bg.';width:100%;padding:50px 0;">
    	<table style="font-family:Arial,Helvetica,sans-serif;color:#222;font-size:13px;width:80%;margin:0 auto;background:#fff;" cellpadding="12">
    		<tr>
    			<td colspan="2" style="width:200px;"><img src="'.$mail_logo.'" width="250"></td>
    			<td colspan="3" style="text-align:right;line-height:1.7"><b>Contact:</b> '.$mail_phone.' <br><b>Email:</b> '.$mail_email.'</td>
    		</tr>
    		<tr>
    			<td colspan="5" style="background:#11D388;padding:15px 0;text-align:center;color:#fff;">
    				<h4>'.$mail_h4.'</h4>
    				<h1>'.$mail_h1.'</h1>
    			</td>
    		</tr>
    		<tr>
    			<td colspan="5">
    				'.$mail_main_msg.'
    				<a href="'.$mail_button_url.'" style="background:#243F4F;color:#fff;padding:15px 20px;text-decoration:none;font-weight:bold;margin:0 auto;display:table;border-radius:7px;">'.$mail_button.'</a>
    			</td>
    		</tr>
    		<tr>
    			<td colspan="5" style="background:#11D388;padding:20px 0;">
    				<p style="font-size:12px;color:#fff;text-align:center;padding:0 30px;">This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</p>
    				<p style="font-size:12px;color:#fff;text-align:center;">Copyright &copy;  '.date('Y').' <a href="'.$mail_copyright_url.'" style="text-decoration:none;font-weight:bold;color:#fff;">'.$mail_copyright.'</a></p>
    			</td>
    		</tr>
    	</table>
    	</div>';
    	
    	// Send email
    	$mail_sent = mail($to_mail, $subject, $htmlcontent, $headers);
		$output = array("success" => 1);
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
	}
}

//Members Change Password
if($action == "members_change_password")
{

	if($new_password == $confirm_password)  
    {
		$select_check_query = "select id from $members_table where login_token='$login_token' and password='$current_password'";
		$check_result = $con->query($select_check_query)or die(mysqli_error($con));
        $check_count = $check_result->num_rows;
        if($check_count > 0)
        {
        	$update_query = "update $members_table set password='$new_password' where login_token='$login_token'";
    		$update_qu = $con->query($update_query) or die(mysqli_error($con));
    		if($update_qu == true)
    		{
    			$output = array("success" => 1);
				echo json_encode($output, JSON_UNESCAPED_SLASHES);
			}
			else
			{
				$output = array("success" => -1);
				echo json_encode($output, JSON_UNESCAPED_SLASHES);	
			}
		}
		else
		{
			$output = array("success" => -2);
			echo json_encode($output, JSON_UNESCAPED_SLASHES);	
		}
	}
	else
	{
		$output = array("success" => -3);
		echo json_encode($output, JSON_UNESCAPED_SLASHES);	
	}

}


//Contact LIST
if($action == "contact_enquiry")
{
	$created_at = date('Y-m-d H:i:s');
	$insert_query = "insert into $contact_table(name,email,address,phone_number,subject,message,created_at,created_by,status) 
						values('$name','$email','$address','$phone_number','$subject','$message','$created_at','1','A')";
	$result = $con->query($insert_query) or die(mysqli_error($con));

    //Mail
    $mail_h4 = "You Registered";
    $mail_h1 = "Successfully";
    $mail_main_msg = "<table style='width:650px;margin:0 auto;border:15px solid #cda085;'>
	                    <tr>
	                        <th>Name: </th><td>$name</td>
	                        <th>Email: </th><td>$email</td>
	                        <th>Email: </th><td>$address</td>
	                        <th>Email: </th><td>$phone_number</td>
	                        <th>Subject: </th><td>$subject</td>
	                        <th>Message: </th><td>$message</td>
	                    </tr>                            
	                </table>";

    $from_mail = $mail_email;
    $from_name = "Registered Successfully - $mail_copyright";

    $to_mail = "";

    $subject = "Registered Successfully | $mail_website";

    //Headers
    $headers = "Reply-To: The Sender <$from_mail>\r\n";
    $headers .= "Return-Path: $from_name <$from_mail>\r\n";
    $headers .= "From: $from_name <$from_mail>\r\n";

    $headers .= "Organization: Sender Organization\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

   $htmlcontent = '<div style="background:'.$mail_bg.';width:100%;padding:50px 0;">
    <table style="font-family:Arial,Helvetica,sans-serif;color:#222;font-size:13px;width:80%;margin:0 auto;background:#fff;" cellpadding="12">
        <tr>
            <td colspan="2" style="width:40%;"><img src="'.$mail_logo.'" width="250"></td>
            <td colspan="3" style="text-align:right;line-height:1.7"><b>Contact:</b> '.$mail_phone.' <br><b>Email:</b> '.$mail_email.'</td>
        </tr>
        <tr>
            <td colspan="5" style="background:#44c980;padding:15px 0;text-align:center;color:#fff;">
                <h4>'.$mail_h4.'</h4>
                <h1>'.$mail_h1.'</h1>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <p style="padding:15px 10px;font-size: 17px;font-family: serif;color: #333;line-height: 1.4;">'.$mail_main_msg .'</p>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="background:#44c980;padding:20px 0;">
                <p style="font-size:12px;color:#fff;text-align:center;padding:0 30px;">This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</p>
                <p style="font-size:12px;color:#fff;text-align:center;">Copyright &copy; 2021 <a href="'.$mail_copyright_url.'" style="text-decoration:none;font-weight:bold;color:#fff;">'.$mail_copyright.'</a></p>
            </td>
        </tr>
    </table>
    </div>';
    
    // Send email
    $mail_sent = mail($to_mail, $subject, $htmlcontent, $headers);
    if($mail_sent)
    {
	    $output = array("success" => 1);
	}
	else
	{
	    $output = array("success" => -1);
	}
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}


//Hotel Room LIST
if($action == "hotel_rooms")
{
	if($sort == "ASC")
		$sort_qry = "order by hr.sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by hr.sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	if($room_id != 0)
		$room_qry = "and hr.id='$room_id'";
	else
		$room_qry = "";

	if($hotel_id != 0)
		$hotel_qry = "and hr.hotel_id='$hotel_id'";
	else
		$hotel_qry = "";

	$arr =array();

	//Hotel room  List
	$select_query = "SELECT hr.* ,tt.value as gst_per from $hotel_rooms_tables hr 
	inner join $master_tax_table tt on tt.id=hr.tax_id where hr.status='A' and hr.admin_status='A' $room_qry $hotel_qry $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data= $sel_query->fetch_array())
	{
		//Room Rates
		$today = date('Y-m-d');
		$select_rate = "SELECT mrr.actual_cost,mrr.final_cost from $hotel_room_rates_table hrr 
		inner join $master_room_rates_table mrr on hrr.rate_id=mrr.id WHERE hrr.start_date<='$today' and hrr.end_date>='$today' and
 hrr.status='A' and hrr.room_id='$data[id]'";
		$result_rate =$con->query($select_rate) or die(mysqli_error($con));
		$data_rate = $result_rate->fetch_array();
		$actual_cost = $data['actual_cost'] + ($data['actual_cost'] * $data_rate['actual_cost'] / 100);
		$final_cost = $data['final_cost'] + ($data['final_cost'] * $data_rate['final_cost'] / 100);


		//Hotel room Facilities
		$hrf_arr = "";
		$hrf_arr = array();
		$select_query2 = "SELECT hr.id,hr.sort_no,hr.room_id,fm.name,fm.icon_image from $hotel_rooms_facilities_table hr 
		inner join $master_facilities_table fm on hr.facility_id=fm.id WHERE fm.status='A' and hr.room_id='$data[id]'";
		$sel_query2 =$con->query($select_query2) or die(mysqli_error($con));
		while($data2 = $sel_query2->fetch_array())
		{
			$hrf_arr[] = array("room_facilities_id" => $data2['id'], "name" => $data2['name'], "icon_image" => $data2['icon_image']);
		}

		//Hotel room Images
		$hri_arr = "";
		$hri_arr = array();
		$select_query3 = "select DISTINCT * from $hotel_room_images_table where default_image='Y' and room_id='$data[id]'";
		$sel_query3 =$con->query($select_query3) or die(mysqli_error($con));
		while($data3 = $sel_query3->fetch_array())
		{
			
			$hri_arr[] = array("room_image_id" => $data3['id'], "room_image" => $data3['room_image']);
		}

	    $arr[] = array("room_id" => $data['id'],"hotel_id" => $data['hotel_id'], "name" => $data['name'], "short_description" => $data['short_description'], 
		     	"hotel_id" => $data['hotel_id'],"max_childerns" => $data['max_childerns'], "max_adults" => $data['max_adults'],
		     	"max_people" => $data['max_people'], "min_people" => $data['min_people'], "num_of_rooms" => $data['num_of_rooms'],
		     	"final_cost" => $final_cost, "actual_cost" => $actual_cost, "gst_per" => $data['gst_per'], "homepage" => $data['homepage'], 
		     	"hotel_room_facilities" => $hrf_arr, "hotel_room_images" => $hri_arr);
 	}
	
	$output = array("success" => 1, "hotel_room_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Hotel Search LIST
if($action == "hotel_search")
{
	if($sort == "ASC")
		$sort_qry = "order by ht.sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by ht.sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	$filter_qry = "";
	if($hotel_id != 0)
		$filter_qry .= "group by ht.id='$hotel_id'";
	else
		$filter_qry .= "";

	if($destination_id != 0)
		$filter_qry .= "and ht.id='$destination_id'";
	else
		$filter_qry .= "";

	if($childerns != 0)
		$filter_qry = "and hr.max_childerns>='$childerns'";
	else
		$filter_qry = "";

	if($adults != 0)
		$filter_qry = "and hr.max_adults>='$adults'";
	else
		$filter_qry = "";

	if($hotel_name != 0)
		$filter_qry = "and ht.name like '%$hotel_name%'";
	else
		$filter_qry = "";

	if($star != 0)
		$filter_qry = "and ht.star='$star'";
	else
		$filter_qry = "";

	if($facility_id != 0)
		$filter_qry = "and hf.id='$facility_id'";
	else
		$filter_qry = "";

	$arr = array();
	$select_query = "SELECT ht.*,cm.city as city_name,hi.hotel_image as hotel_image,round(AVG(hr.rating),1) as rating,COUNT(DISTINCT hr.id) as review_count,COUNT(DISTINCT hb.id) as booking_count,min(rm.final_cost) as cost,ctt.name as property_type FROM $hotels_table ht 
					inner join $master_property_type_table ctt on ctt.id=ht.category_type_id 
					inner join $master_city_table cm on ht.city_id=cm.id 
					inner join $hotel_images_table hi on ht.id=hi.hotel_id 
					inner join $hotel_rating_tables hr on ht.id=hr.hotel_id 
					inner join $hotel_booking_table hb on hb.hotel_id=ht.id 
					inner join $hotel_rooms_tables rm on rm.hotel_id=ht.id 
					inner join $hotel_facilities_table hf on hf.hotel_id=ht.id 
					where ht.status='A' and hi.default_image='Y' and rm.status='A' group by ht.id $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		/*$select_c_query = "SELECT final_cost from $hotel_rooms_tables where ht.status='A' and hi.default_image='Y' and rm.status='A' group by ht.id $sort_qry $limit_qry";
		$sel_cquery =$con->query($select_c_query) or die(mysqli_error($con));
		$cdata = $sel_cquery->fetch_array();*/	

	    $hotel_image = $MAIN_URL."/".$hotel_img_dir."/small/".$data['hotel_image'];
	    $arr[] = array("hotel_id" => $data['id'], "property_type" => $data['property_type'],"destination_id" => $data['destination_id'], "city_name" => $data['city_name'], "star" => $data['star'], "code" => $data['code'], "name" => $data['name'], "slug" => $data['slug'], "short_description" => $data['short_description'], 
	    	"description" => $data['description'], "address" => $data['address'], "phone_number" => $data['phone_number'], "email_id" => $data['email_id'], 
	    	"map" => $data['map'],"rating" => $data['rating'],"review_count" => $data['review_count'],"booking_count" => $data['booking_count'],"cost" => $data['cost'],"hotel_image" => $hotel_image);
	}
    
    $output = array("success" => 1, "hotels_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Members Google Login
if($action == "member_google_login")
{
	$signup_type = "G";
	$created_at = date('Y-m-d H:i:s');
	$select_query = "select * from $members_table where status!='E' and email='$email'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	$count = mysqli_num_rows($sel_query);
	if($count == 0)
	{
		//Register
		$id_token = "";
		$status = "A";
		$ins_query = "insert into $members_table(id_token,name,address,email,mobile,password,otp_code,email_verified,signup_type,profile_photo,created_at,status) 
						values('$id_token','$name','$address','$email','$mobile','$password','0','Y','$signup_type','$profile_photo','$created_at','$status')";
		$result = $con->query($ins_query) or die(mysqli_error($con));
		$reg_id = $con->insert_id;
		
		$raw_token = $reg_id.date('y-m-d H:i:s');
		$login_token = md5(uniqid($raw_token, true));

		$upd_query = "update $members_table set login_token='$login_token' where id='$reg_id'";
		$result = $con->query($upd_query) or die(mysqli_error($con));
		
		$output = array("success" => 1,"member_id" => "$reg_id", "login_token" => "$login_token", "name" => "$name", "email" => "$email", "mobile" => "$mobile","profile_photo" => "$profile_photo","status" => "$status","new_member"=>"Y");
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
	}
	else
	{
	    $data = $sel_query->fetch_array();
	    $update_query = "update $members_table set name='$name',address='$address',email='$email',mobile='$mobile',email_verified='Y',
	                        signup_type='$signup_type',profile_photo='$profile_photo' where id='$data[id]'";
		$result = $con->query($update_query) or die(mysqli_error($con));
		
		$select_query = "select * from $members_table where id='$data[id]'";
	    $sel_query =$con->query($select_query) or die(mysqli_error($con));
	    $data = $sel_query->fetch_array();
	    extract($data);
	    
		$raw_token = $reg_id.date('y-m-d H:i:s');
		$login_token = md5(uniqid($raw_token, true));

		$upd_query = "update $members_table set login_token='$login_token' where id='$reg_id'";
		$result = $con->query($upd_query) or die(mysqli_error($con));
		
		$output = array("success" => 1,"member_id" => "$id", "login_token" => "$login_token", "name" => "$name", "email" => "$email", "mobile" => "$mobile","profile_photo" => "$profile_photo","status" => "$status","new_member"=>"N");
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
	}
}

//Members Facebook Login
if($action == "member_fb_login")
{
	$signup_type = "F";
    $created_at = date('Y-m-d H:i:s');
	$select_query = "select * from $members_table where status!='E' and email='$email'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	$count = mysqli_num_rows($sel_query);
	if($count == 0)
	{
		//Register
		$id_token = "";
		$status = "A";
		$ins_query = "insert into $members_table(id_token,name,address,email,mobile,password,otp_code,email_verified,signup_type,profile_photo,created_at,status) 
						values('$id_token','$name','$address','$email','$mobile','$password','0','Y','$signup_type','$profile_photo','$created_at','$status')";
		$result = $con->query($ins_query) or die(mysqli_error($con));
		$reg_id = $con->insert_id;
		
		$raw_token = $reg_id.date('y-m-d H:i:s');
		$login_token = md5(uniqid($raw_token, true));

		$upd_query = "update $members_table set login_token='$login_token' where id='$reg_id'";
		$result = $con->query($upd_query) or die(mysqli_error($con));
		
		$output = array("success" => 1,"member_id" => "$reg_id", "login_token" => "$login_token", "name" => "$name", "email" => "$email", "mobile" => "$mobile","profile_photo" => "$profile_photo","status" => "$status","new_member"=>"Y");
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
	}
	else
	{
	    $data = $sel_query->fetch_array();
	    $update_query = "update $members_table set name='$name',address='$address',email='$email',mobile='$mobile',email_verified='Y',
	                        signup_type='$signup_type',profile_photo='$profile_photo' where id='$data[id]'";
		$result = $con->query($update_query) or die(mysqli_error($con));
		
		$select_query = "select * from $members_table where id='$data[id]'";
	    $sel_query =$con->query($select_query) or die(mysqli_error($con));
	    $data = $sel_query->fetch_array();
	    extract($data);
	    
		$raw_token = $reg_id.date('y-m-d H:i:s');
		$login_token = md5(uniqid($raw_token, true));

		$upd_query = "update $members_table set login_token='$login_token' where id='$reg_id'";
		$result = $con->query($upd_query) or die(mysqli_error($con));
		
		$output = array("success" => 1,"member_id" => "$id", "login_token" => "$login_token", "name" => "$name", "email" => "$email", "mobile" => "$mobile","profile_photo" => "$profile_photo","status" => "$status","new_member"=>"N");
		echo json_encode($output, JSON_UNESCAPED_SLASHES);
	}
}

//Members Events
if($action == "members_events")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	if($event_id != 0)
		$event_qry = "and et.id='$event_id'";
	else
		$event_qry = "";
	
	$arr = array();
	$select_query = "SELECT et.*,ht.name as hotel_name,ht.address as hotel_address, ht.phone_number,ht.email_id,ht.slug from $events_table et 
	inner join $hotels_table ht on ht.id=et.hotel_id where et.status='A' $event_qry $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$image = $MAIN_URL."/".$events_img_dir."/small/".$data['image'];
	    $arr[] = array("event_id" => $data['id'], "hotel_id" => $data['hotel_id'], "event_date" => $data['event_date'], "event_name" => $data['event_name'], "hotel_name" => $data['hotel_name'], "description" => $data['description'], "image" => $image,  "created_at" => $data['created_at'], "hotel_address" => $data['hotel_address'], "phone_number" => $data['phone_number'], "email_id" => $data['email_id'], "slug" => $data['slug']);
	}
    
    $output = array("success" => 1, "events_List" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Members Events Registration
if($action == "events_registration")
{
	$created_at = date('Y-m-d H:i:s');
	$created_by = "1";
	$insert_query = "insert into $events_registration_table(event_id,name,gender,dob,email,mobile,created_at,created_by,status) 
						values('$event_id','$name','$gender','$dob','$email','$mobile','$created_at','$created_by','A')";
	$result = $con->query($insert_query) or die(mysqli_error($con));
	$output = array("success" => 1);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Hotels Booking
if($action == "hotel_booking")
{
	$current_date = date('Y-m-d');

	$arr = array();
	$created_at = date('Y-m-d H:i:s');
	$created_by = "1";
	$rooms = "1";
	$payment_status	= "PD"; 

	/*$room_no_id_arr = array();
	$select_query = "SELECT id,room_no_id from $hotel_room_booking_table where room_id='$room_id' and ((checkin_date<='$checkin_date' and checkin_date>='$checkout_date') 
					or (checkout_date>='$checkin_date' and checkout_date<='$checkout_date')) and status!='E'";
	$result = $con->query($select_query) or die(mysqli_error($con));
	while($data = $result->fetch_array())
	{
		$room_no_id_arr[] = $data['room_no_id'];
	}
	$count = $result->num_rows;

	$sel_query = "SELECT hr.num_of_rooms,hr.tax_id,tt.value as tax_per,hr.final_cost from $hotel_rooms_tables hr 
	inner join $master_tax_table tt on tt.id=hr.tax_id where hr.id='$room_id' and hr.status!='E'";
	$sel_result = $con->query($sel_query) or die(mysqli_error($con));
	$data = $sel_result->fetch_array();

	$tax_value = $data['final_cost'] * $data['tax_per'] / 100;
    //$final_total = $data['final_cost'] + $tax_value;

	if($count < $data['num_of_rooms'])
	{*/
		$insert_query = "insert into $hotel_booking_table(booking_code,member_id,hotel_id,first_name,last_name,email,address,postal_code,city_id,state_id,
						country_id,phone_number,mobile_number,coupon_code,discount_type,discount_value,order_total,tax_id,tax_per,tax_value,final_total,payment_method,payment_status,special_request,created_at,created_by,status)
						values('','$member_id','$hotel_id','$first_name','$last_name','$email','$address','$postal_code','$city_id',
						'$state_id','$country_id','$phone_number','$mobile_number','$coupon_code','$discount_type','$discount_value','$order_total','$tax_id',
						'$tax_per','$tax_value','$final_total','$payment_method','$payment_status','$special_request','$created_at','$created_by','A')";
		$result = $con->query($insert_query) or die(mysqli_error($con));
		$insert_id = $con->insert_id;

		$booking_int = 1000000 + $insert_id;
	    $booking_code = "HB".$booking_int;

	    $update_query = "update $hotel_booking_table set booking_code ='$booking_code' where id='$insert_id'";
	    $up_res = $con->query($update_query);

		foreach($booked_rooms as $key => $value)
		{
			$room_id = $booked_rooms[$key]['room_id'];			
			$rooms = 1;
			$adults = $booked_rooms[$key]['adults'];
			$childerns = $booked_rooms[$key]['childerns'];
			$cost = $booked_rooms[$key]['cost'];

			//Check available room nos and getting it
			$room_no_id_arr = $room_no_id_qry = "";
			$select_query = "SELECT id,room_no_id from $hotel_room_booking_table where room_id='$room_id' and ((checkin_date<='$checkin_date' and checkin_date>='$checkout_date') 
					or (checkout_date>='$checkin_date' and checkout_date<='$checkout_date')) and status!='E'";
			$result = $con->query($select_query) or die(mysqli_error($con));
			while($data = $result->fetch_array())
			{
				$room_no_id_arr .= $data['room_no_id'].",";
			}
			$room_no_id_arr = rtrim($room_no_id_arr,",");
			if($room_no_id_arr != "")
				$room_no_id_qry = "and id not in($room_no_id_arr)";

			$select_query = "SELECT id from $hotel_room_number_table where room_id='$room_id' and status='A' $room_no_id_qry limit 1";
			$result = $con->query($select_query) or die(mysqli_error($con));
			if($result->num_rows)
			{
				$data = $result->fetch_array();
				$room_no_id = $data['id'];
				
			    $ins_query = "insert into $hotel_room_booking_table(booking_id,checkin_date,checkout_date,room_id,room_no_id,rooms,adults,childerns,cost,created_at,created_by,status)
		    				Values('$insert_id','$checkin_date','$checkout_date','$room_id','$room_no_id','$rooms','$adults','$childerns','$cost','$created_at','$created_by','A')";
				$ins_result = $con->query($ins_query) or die(mysqli_error($con));	
				$booking_room_id = $con->insert_id;	
			}
		}

		$from_date = strtotime($checkin_date); 
		$end_date = strtotime($checkout_date);
		$date_count = abs($end_date - $from_date);
		$total_days = $date_count/86400;
		$total_days = intval($total_days);

		/*for($i=0;$i<=$total_days;$i++)
		{
			$booking_date = date('Y-m-d', strtotime($checkin_date,' +$i day'));
			$insert_query = "insert into $hotel_booking_room_date_table(booking_id,booking_room_id,room_id,booking_date,status)
										values('$insert_id','$booking_room_id','$room_id','$booking_date','A')";
			$insert_result = $con->query($insert_query) or die(mysqli_error($con));
		}*/			

		$output = array("success" => 1);
	/*}
	else
	{
		$output = array("success" => -1);
	}*/
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Master Facility
if($action == "master_facility")
{
	if($sort == "ASC")
		$sort_qry = "order by sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";
	
	$arr = array();
	$select_query = "select * from $master_facilities_table where status='A' $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	     $icon_image = $MAIN_URL."/".$facility_img_dir."/small/".$data['icon_image'];
	     $arr[] = array("facility_id" => $data['id'], "name" => $data['name'], "icon_image" => $icon_image);
	}
    
    $output = array("success" => 1, "master_facility_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Master City
if($action == "master_city")
{
	$arr = array();
	$select_query = "select * from $master_city_table where status='A'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	     $arr[] = array("city_id" => $data['id'], "city" => $data['city']);
	}
    
    $output = array("success" => 1, "master_city_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Master State
if($action == "master_state")
{
	$arr = array();
	$select_query = "select * from $master_state_table where status='A'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	     $arr[] = array("state_id" => $data['id'], "state" => $data['state']);
	}
    
    $output = array("success" => 1, "master_state_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Master Country
if($action == "master_country")
{
	$arr = array();
	$select_query = "select * from $master_country_table where status='A'";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	     $arr[] = array("country_id" => $data['id'], "country_name" => $data['country_name']);
	}
    
    $output = array("success" => 1, "master_country_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Hotel Room Booking
if($action == "room_booking")
{
	$created_at = date('Y-m-d H:i:s');
	$insert_query = "insert into $hotel_room_booking_table(booking_id,room_id,adults,childerns,cost,created_at,status) 
						values('$booking_id','$room_id','$adults','$childerns','$cost','$created_at','A')";
	$result = $con->query($insert_query) or die(mysqli_error($con));
	$output = array("success" => 1);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//hotel booking view
if($action == "booking_history_list")
{
	$arr = array();
	$select_query = "SELECT hb.* ,ht.name as hotel_name,ct.city as city,st.state as state,hbr.checkin_date,hbr.checkout_date,
	count(hbr.id) as rooms_count,sum(hbr.adults) as total_adults,sum(hbr.childerns) as total_childerns,hit.hotel_image from $hotel_booking_table hb 
	inner join $hotel_room_booking_table hbr on hbr.booking_id=hb.id 
	inner join $hotels_table ht on ht.id=hb.hotel_id 
	inner join $hotel_images_table hit on ht.id=hit.hotel_id 
	inner join $master_city_table ct on ct.id=hb.city_id 
	inner join $master_state_table st on st.id=hb.state_id where hb.status='A' and hit.default_image='Y' and hb.member_id='$member_id' group by hb.id";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$hotel_image = $MAIN_URL."/".$hotel_img_dir."/small/".$data['hotel_image'];

	    $arr[] = array("booking_id" => $data['id'],"booking_code" => $data['booking_code'], "hotel_name" => $data['hotel_name'], "hotel_image" => $hotel_image,
	     	"city" => $data['city'], "state" => $data['state'], "order_total" => $data['order_total'], "discount_value" => $data['discount_value'],
	     	"tax_value" => $data['tax_value'],"final_total" => $data['final_total'],
	     	 "checkin_date" => $data['checkin_date'], "checkout_date" => $data['checkout_date'], 
	     	"rooms_count" => $data['rooms_count'],"name" => $data['first_name'],"email" => $data['email'],"mobile" => $data['phone_number'],
	     	"total_adults" => $data['total_adults'], "total_childerns" => $data['total_childerns']);
	}
    
    $output = array("success" => 1, "booking_history_list" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Hotel add raing
if($action == "hotel_add_rating")
{
	$created_at = date('Y-m-d H:i:s');
	$created_by = "1";
	$status = "A";

	$insert_query = "insert into $hotel_rating_tables(hotel_id,name,email,comment,rating,created_at,created_by,status) 
						values('$hotel_id','$name','$email','$comment','$rating','$created_at','$created_by','A')";
	$result = $con->query($insert_query) or die(mysqli_error($con));
	$output = array("success" => 1);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//Member Add Favourite
if($action == "add_fav")
{
	$created_at = date('Y-m-d H:i:s');
	$status = "A";

	$insert_query = "insert into $member_favourite_table(member_id,hotel_id,created_at,status) 
					 values('$member_id','$hotel_id','$created_at','$status')";
	$result = $con->query($insert_query) or die(mysqli_error($con));
	$output = array("success" => 1);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

if($action == "select_fav")
{
	if($sort == "ASC")
		$sort_qry = "order by ht.sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by ht.sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	if($member_id != 0)
		$mem_qry = "and mt.member_id='$member_id'";
	else
		$mem_qry = "";

	
	$arr = array();
	$select_query = "SELECT mt.*,ht.name,ht.slug,min(rm.final_cost) as cost,ht.address,hi.hotel_image as hotel_image from $member_favourite_table mt
	inner join $hotels_table ht on ht.id=mt.hotel_id 
	inner join $hotel_images_table hi on mt.hotel_id=hi.hotel_id
	inner join $hotel_rooms_tables rm on rm.hotel_id=mt.hotel_id  where mt.status='A' $mem_qry group by rm.hotel_id $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
	     
	     $arr[] = array("fav_id" => $data['id'],"name" => $data['name'], "slug" => $data['slug'],"cost" => $data['cost'],"address" => $data['address'],"hotel_image" => $data['hotel_image'],"created_at" => $data['created_at']);
	}
    
    $output = array("success" => 1, "select_favourite" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//delete Favourite
if($action == "del_fav")
{
	$arr = array();
	$update_query = "update $member_favourite_table set status='E' where id='$fav_id'";
	$upd_query =$con->query($update_query) or die(mysqli_error($con));
    $output = array("success" => 1);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}

//ADDONS LIST
if($action == "hotel_addons")
{
	if($sort == "ASC")
		$sort_qry = "order by ha.sort_no asc";
	elseif($sort == "DSC")
		$sort_qry = "order by ha.sort_no desc";
	elseif($sort == "RAND")
		$sort_qry = "order by rand()";

	if($limit_cnt != 0)
		$limit_qry = "limit $limit_st,$limit_cnt";
	else
		$limit_qry = "";

	if($hotel_id != 0)
		$filter_qry = "and ha.hotel_id='$hotel_id'";
	else
		$filter_qry = "";
	
	$arr = array();
	$select_query = "select ha.*,tm.value from $hotel_addons_table ha inner join $master_tax_table tm on ha.tax_id=tm.id 
						where ha.status='A' $filter_qry $sort_qry $limit_qry";
	$sel_query =$con->query($select_query) or die(mysqli_error($con));
	while($data = $sel_query->fetch_array())
	{
		$tax_value = $data['amount'] * $data['value'] / 100;
		$image = $MAIN_URL."/".$addon_img_dir."/small/".$data['image'];
	    $arr[] = array("addon_id" => $data['id'], "hotel_id" => $data['hotel_id'],"name" => $data['name'], "short_description" => $data['short_description'], "image" => $image, "amount" => $data['amount'], "tax_value" => $tax_value);
	}
    
    $output = array("success" => 1, "hotel_addons" => $arr);
	echo json_encode($output, JSON_UNESCAPED_SLASHES);
}
?>
