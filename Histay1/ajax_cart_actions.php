<?php
session_start();
include("wadmin/db-config.php");

extract($_POST);
if($action == "add_to_cart")
{
	$data = array(
    'key' => $json_key,
    'action' => 'hotel_rooms',
    'room_id' => $room_id,
    'hotel_id' => '0',
    'check_in' => $_SESSION['check_in'],
    'check_out' => $_SESSION['check_out'],
    'sort' => 'ASC',
    'limit_st' => '0',
    'limit_cnt' => '0',
    );
    $rooms_result = call_json($data);
    if(($rooms_result['hotel_room_list'][0]['max_adults'] >= $_POST['adults']) && ($rooms_result['hotel_room_list'][0]['max_childerns'] >= $_POST['childerns']) && ($rooms_result['hotel_room_list'][0]['max_people'] >= ($_POST['adults'] + $_POST['childerns'])) && ($rooms_result['hotel_room_list'][0]['min_people'] <= ($_POST['adults'] + $_POST['childerns'])) && ($_POST['adults'] >= 1))
    {
		if(isset($_SESSION['hotel_id']))
		{
			if($_SESSION['hotel_id'] != $_POST['hotel_id'])
			{
				unset($_SESSION['hotel_id']);
				unset($_SESSION['room_id']);
				unset($_SESSION['adults']);
				unset($_SESSION['childerns']);
			}
		}
		
		$arr = array_count_values($_SESSION['room_id']);
		
		if($rooms_result['hotel_room_list'][0]['available_room_count'] <= $arr[$room_id])
		    echo "2";
		else
		{
		    $_SESSION['hotel_id'] = $_POST['hotel_id'];
    		$_SESSION['room_id'][] = $_POST['room_id'];
    		$_SESSION['adults'][] = $_POST['adults'];
    		$_SESSION['childerns'][] = $_POST['childerns'];
		    echo "1";
		}
	}
	else
	{
		echo "0";
	}
}
elseif($action == "delete_cart")
{
	$_SESSION['room_id'][$key] = "";
	$_SESSION['adults'][$key] = "";
	$_SESSION['childerns'][$key] = "";
	/*unset($_SESSION['room_id'][$key]);
	unset($_SESSION['adults'][$key]);
	unset($_SESSION['childerns'][$key]);*/
}
elseif($action == "view_cart")
{
	//$rooms_arr = array_reverse($_SESSION['room_id']);
	foreach($_SESSION['room_id'] as $key => $value)
	{
		if($value != "")
		{
			$data = array(
		    'key' => $json_key,
		    'action' => 'hotel_rooms',
		    'room_id' => $value,
		    'hotel_id' => '0',
		    'check_in' => $_SESSION['check_in'],
            'check_out' => $_SESSION['check_out'],
		    'sort' => 'ASC',
		    'limit_st' => '0',
		    'limit_cnt' => '0',
		    );
		    $rooms_result = call_json($data);
			?>
			<div class="cart_box">
				<span onclick="delete_cart(<?php echo $key; ?>);"><i class="fa fa-times"></i></span>
				<h4><?php echo $rooms_result['hotel_room_list'][0]['name']; ?></h4>
				<span><?php echo $_SESSION['adults'][$key]; ?> Adults <?php echo $_SESSION['childerns'][$key]; ?> Child</span>
				<h3>₹<?php echo $rooms_result['hotel_room_list'][0]['final_cost']; ?></h3>
				<span>Per Night</span>
			</div>
			<?php
		}
	}
	echo "<a href='booking.php' class='send-message-to-owner button ck_btn'>Checkout</a>";
}
?>