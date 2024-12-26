<?php
$body_class = "";
include("header.php");

if(isset($_POST['book_now']))
{
	extract($_POST);
	if(isset($_SESSION['member_uid']))
	  $member_uid=$_SESSION['member_uid'];
	else
	  $member_uid=0;

	$booked_rooms = array();
	$rooms = $total_cost = 0;
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
		    $booked_rooms[] = array('room_id' => $_SESSION['room_id'][$key], 'adults' => $_SESSION['adults'][$key], 'childerns' => $_SESSION['childerns'][$key], 'cost' => $rooms_result['hotel_room_list'][0]['final_cost']);
		}
	}

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
		$discount_type = $result['coupon_data']['discount_type'];
		if($discount_type == "PER")
		{
			$discount = $total_cost * $result['coupon_data']['discount_value'] / 100;	
		}
		else
		{
			$discount = $result['coupon_data']['discount_value'];	
		}
		$dis_value = $discount;
		$after_dis = $total_cost - $discount;
		$gst_value = round($after_dis * 9 / 100,2);
		$final_value = $after_dis + $gst_value;
	}
	else
	{
		$coupons_code = "";
		$discount_type = "NONE";
		$dis_value = 0;
		$after_dis = $total_cost;
		$gst_value = round($after_dis * 9 / 100,2);
		$final_value = $after_dis + $gst_value;
	}
	$output['vaild'] = $result['vaild'];

  $data = array(
  'key' => $json_key,
  'action' => 'hotel_booking',
  'member_id' => $member_uid,
  'hotel_id' => $_SESSION['hotel_id'],
  'room_id' => "1",
  'checkin_date' => $_SESSION['check_in'],
  'checkout_date' => $_SESSION['check_out'],
  'adults' => array_sum($_SESSION['adults']),
  'childerns' => array_sum($_SESSION['childerns']),
  'first_name' => $first_name, 
  'last_name' => $last_name,
  'email' => $email,
  'address' => $address,
  'phone_number' => $phone_number,  
  'mobile_number' => "",  
  'postal_code' => $postal_code,
  'city_id' => $city_id,
  'state_id' => $state_id,
  'country_id' => $country_id,
  'special_request' => $special_request,
  'coupon_code' => $coupon_code,
  'discount_type' => $discount_type,
  'discount_value' => $dis_value,
  'order_total' => $total_cost,
  'tax_id' => 1,
  'tax_per' => 9,
  'tax_value' => $gst_value,
  'final_total' => $final_value,
  'payment_method' => $payment_method,
  'booked_rooms' => $booked_rooms
  );
  //echo json_encode($data, JSON_UNESCAPED_SLASHES);
  $result = call_json($data);
  print_r($result);
  /*if($result['success'] == 1)
  {
    echo "<script>alert('Booking successfully');</script>";
    echo "<script>window.location.href='logout.php';</script>";
  }
  elseif($result['success'] == -1) 
  {
    echo "<script>alert('Selected Room is booked for chosen date! So Please Try Some Other Rooms. Thank You!!');</script>";
    echo "<script>window.location.href='booking.php';</script>";
  }*/
  echo "<script>alert('Booked successfully');</script>";
  echo "<script>window.location.href='index.php';</script>";
}


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
?>

<style>
#dropdownMenuButton
{
	display:none;
}
</style>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Booking</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Booking</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->

<!-- Container -->
<div class="container">
	<div class="row">

		<!-- Content
		================================================== -->
		<form method="post">
			<div class="col-lg-8 col-md-8 padding-right-30">			

				<h3 class="margin-top-0 margin-bottom-30">Hotel Addons</h3>
				<div class="row">
					<?php
	                  $data = array(
	                      'key' => $json_key,
	                      'action' => 'hotel_addons',
	                      'hotel_id' => $hotel_result['hotels_details_list']['hotel_id'],
	                      'sort' => 'ASC',
	                      'limit_st' => '0',
	                      'limit_cnt' => '0',
	                  );
	                  $result = call_json($data);
	                ?>

	                <div class="boxed-widget opening-hours summary margin-top-0">
		                <ul>
		                	<?php
		                	foreach($result['hotel_addons'] as $key => $value)
	                  		{
	                  			?>
								<li class="total-costs">
									<img src="<?php echo $result['hotel_addons'][$key]['image']; ?>" class="tt_ibox">
									<?php echo $result['hotel_addons'][$key]['name']." ₹".$result['hotel_addons'][$key]['amount']; ?>
									<span style="padding:5px 15px;">₹<span class="addon_sum" id="addon_sum_<?php echo $result['hotel_addons'][$key]['addon_id']; ?>">0</span></span>
									<input type="hidden" value="0" class="addon_tax_sum" id="addon_tax_sum_<?php echo $result['hotel_addons'][$key]['addon_id']; ?>">
									<span>
										<a href="#" id="dropdownMenuButton"><span class="qtyTotal" ></span></a>
						                <div class="qtyButtons" onclick="calc_addons(<?php echo $result['hotel_addons'][$key]['addon_id']; ?>,<?php echo $result['hotel_addons'][$key]['amount']; ?>,<?php echo $result['hotel_addons'][$key]['tax_value']; ?>);">
											<div class="qtyTitle"></div>
											<input type="number" class="sadults" name="addon[]" id="addon_<?php echo $result['hotel_addons'][$key]['addon_id']; ?>" value="0">
										</div>
									</span>
								</li>
								<?php
							}
							?>
							<li class="total-costs">
								<b>TOTAL</b>
								<span style="padding:5px 15px;">₹<span id="addon_total">0</span></span>
								<span>
								</span>
							</li>
						</ul>
					</div><br>
				</div><br>

				<h4 class="margin-top-0 margin-bottom-30 text-center">You are not logged in, <a class="sign-in popup-with-zoom-anim tt_ebtn" href="#sign-in-dialog">Login</a> or continue as a Guest</h4>

				<h3 class="margin-top-0 margin-bottom-30">Personal Details</h3>
				<div class="row">
					<div class="col-md-6">
						<label>First Name</label>
						<input type="text" name="first_name" autocomplete="off" placeholder="First Name" required>
					</div>
					<div class="col-md-6">
						<label>Last Name</label>
						<input type="text" name="last_name" autocomplete="off" placeholder="Last Name" required> 
					</div>
					<div class="col-md-6">
						<div class="input-with-icon medium-icons">
							<label>E-Mail Address</label>
							<input type="text" name="email" autocomplete="off" placeholder="Email Address" required>
							<i class="im im-icon-Mail"></i>
						</div>
					</div>
					<div class="col-md-6">
						<div class="input-with-icon medium-icons">
							<label>Phone</label>
							<input type="text" name="phone_number" autocomplete="off" placeholder="Phone Number" required>
							<i class="im im-icon-Phone-2"></i>
						</div>
					</div>
				</div>

				<h3 class="margin-top-0 margin-bottom-30">Billing Details</h3>
				<div class="row">
					<div class="col-md-6">
						<label>Address</label>
						<input type="text" name="address" autocomplete="off" placeholder="Address">
					</div>
					<div class="col-md-6">
						<label>Postal Code</label>
						<input type="text" name="postal_code" autocomplete="off" placeholder="Postal Code"> 
					</div>
					<div class="col-md-6">
						<label>City</label>
						<select class="form-control" name="city_id">
                          <option>Select City</option>
                           <?php
                            $data = array(
                            'key' => $json_key,
                            'action' => 'master_city',
                            );
                            $city_result = call_json($data);
                            foreach($city_result['master_city_list'] as $key => $value)
                            {
                              ?>
                              <option value="<?php echo $city_result['master_city_list'][$key]['city_id'];?>"><?php echo $city_result['master_city_list'][$key]['city'];?></option>
                              <?php
                            }
                            ?>
                        </select>
					</div>
					<div class="col-md-6">
						<label>State</label>
						<select class="form-control" name="state_id">
                          <option>State/Region</option>
                           <?php
                            $data = array(
                            'key' => $json_key,
                            'action' => 'master_state',
                            );
                            $state_result = call_json($data);
                            foreach($state_result['master_state_list'] as $key => $value)
                            {
                              ?>
                              <option value="<?php echo $state_result['master_state_list'][$key]['state_id'];?>"><?php echo $state_result['master_state_list'][$key]['state'];?></option>
                              <?php
                            }
                            ?>
                        </select>
					</div>
					<div class="col-md-6">
						<label>Country</label>
						<select class="form-control" name="country_id">
                          <option>Select Country</option>
                          <?php
                            $data = array(
                            'key' => $json_key,
                            'action' => 'master_country',
                            );
                            $country_result = call_json($data);
                            foreach($country_result['master_country_list'] as $key => $value)
                            {
                              ?>
                              <option value="<?php echo $country_result['master_country_list'][$key]['country_id'];?>"><?php echo $country_result['master_country_list'][$key]['country_name'];?></option>
                              <?php
                            }
                            ?>
                        </select>
					</div>
					<div class="col-md-6">
						<label>Special Request</label>
						<input type="text" name="special_request" autocomplete="off" placeholder="Special Request"> 
					</div>
				</div>

				<h3 class="margin-top-55 margin-bottom-30">Payment Method</h3>

				<!-- Payment Methods Accordion -->
				<div class="payment">

					<div class="payment-tab payment-tab-active">
						<div class="payment-tab-trigger">
							<input checked id="paypal" name="payment_method" type="radio" value="OPG">
							<label for="paypal">Online</label>
							<img class="payment-logo paypal" src="https://i.imgur.com/ApBxkXU.png" alt="">
						</div>

						<div class="payment-tab-content">
							<p>You will be redirected to Online Payment Gateway to complete payment.</p>
						</div>
					</div>

					<div class="payment-tab">
						<div class="payment-tab-trigger">
							<input type="radio" name="payment_method" id="creditCart" value="OFF">
							<label for="creditCart">Pay at Hotel</label>
							<img class="payment-logo" src="https://i.imgur.com/IHEKLgm.png" alt="">
						</div>

						<div class="payment-tab-content">
							<p>You need to pay at the hotel.</p>
						</div>
					</div>

				</div>
				<!-- Payment Methods Accordion / End -->			
				<button type="submit" name="book_now" class="button booking-confirmation-btn margin-top-40 margin-bottom-65">Confirm and Pay</button>			
			</div>

			<!-- Sidebar
			================================================== -->
			<div class="col-lg-4 col-md-4 margin-top-0 margin-bottom-60">
				<!-- Booking Summary -->
				<div class="listing-item-container compact order-summary-widget">
					<div class="listing-item">
						<img src="<?php echo $hotel_result['hotels_details_list']['hotel_images'][0]['hotel_image']; ?>" alt="">

						<div class="listing-item-content">
							<div class="numerical-rating" data-rating="<?php echo $hotel_result['hotels_details_list']['rating']; ?>"></div>
							<h3><?php echo $hotel_result['hotels_details_list']['name']; ?></h3>
							<span><?php echo $hotel_result['hotels_details_list']['address']; ?></span>
						</div>
					</div>
				</div>
				<div class="boxed-widget opening-hours summary margin-top-0">
					<h3><i class="fa fa-calendar-check-o"></i> Booking Summary</h3>
					<ul>
						<li>Date <span><?php echo $_SESSION['check_in_out']; ?></span></li>
						<?php
						$rooms = $total_cost = 0;
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
							    //$gst_value += $rooms_result['hotel_room_list'][0]['final_cost'] * $rooms_result['hotel_room_list'][0]['gst_per'] / 100;
								/*?>
								<div class="cart_box">
									<span onclick="delete_cart(<?php echo $key; ?>);"><i class="fa fa-times"></i></span>
									<h4><?php echo $rooms_result['hotel_room_list'][0]['name']; ?></h4>
									<span><?php echo $_SESSION['adults'][$key]; ?> Adults <?php echo $_SESSION['childerns'][$key]; ?> Child</span>
									<h3>₹<?php echo $rooms_result['hotel_room_list'][0]['final_cost']; ?></h3>
									<span>Per Night</span>
								</div>
								<?php*/
							}
							$gst_value = $total_cost * 9 / 100;
							$final_cost = $total_cost + $gst_value;
						}
						echo "<input type='hidden' id='final_value_c' value='$final_cost'>";
						echo "<input type='hidden' id='taddon_total_sum' value='0'>";
						echo "<input type='hidden' id='taddon_tax_sum' value='0'>";
						?>
						<li>Rooms <span><?php echo $rooms; ?></span></li>
						<li>Total Guests <span><?php echo array_sum($_SESSION['adults']); ?> Adults, <?php echo array_sum($_SESSION['childerns']); ?> Childerns</span></li>
						<li class="total-costs">Total Cost <span>₹<?php echo $total_cost; ?></span></li>
						<li class="total-costs">Discount <span id="dis_value">₹0</span></li>
						<li class="total-costs">Cost after dicount <span id="after_dis_value">₹<?php echo $total_cost; ?></span></li>
						<li class="total-costs">GST <span id="gst_value">₹<?php echo $gst_value; ?></span></li>
						<li class="total-costs">Total <span id="final_value">₹<?php echo $final_cost; ?></span></li>
						<li class="total-costs">Addon Cost <span>₹<span id="addon_total_sum">0</span></span></li>
						<li class="total-costs">Addon GST <span>₹<span id="addon_tax_sum">0</span></span></li>
						<li class="total-costs">Final Total <span id="final_tvalue">₹<?php echo $final_cost; ?></span></li>
					</ul>
				</div>
				
				<div class="boxed-widget opening-hours summary margin-top-0">
					<h3><i class="fa fa-calendar-check-o"></i> Coupon Codes</h3>
					<ul>
						<li>Code</li>					
						<li><input type="text" name="coupon_code" id="coupon_code" class="tt_cpntxt" autocomplete="off">
							<a class="send-message-to-owner button tt_cpnbtn" id="apply_coupon"><i class="fa fa-arrow-right"></i></a></li>	
						<li id="coupon_msg"></li>				
					</ul>

				</div>

			</div>
		</form>

	</div>
</div>
<!-- Container / End -->

<?php
include("footer.php");
?>
<script type="text/javascript">
$(document).ready(function (){
	$(document).on('click','#apply_coupon', function(event){
		event.preventDefault();
		var coupon_code = $('#coupon_code').val();
		$.ajax({
		url:"ajax_check_coupon.php",
		method:"POST",
		data:{coupon_code:coupon_code},
		dataType:"json",
		success:function(data)
		{
			$('#dis_value').html("₹"+data.dis_value);
			$('#after_dis_value').html("₹"+data.after_dis);
			$('#gst_value').html("₹"+data.gst_value);
			$('#final_value').html("₹"+data.final_value);
			$('#final_value_c').html(data.final_value);
			$('#coupon_msg').html(data.coupon_msg);
			calc_final();
			},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
		});
	});
	
});
function calc_addons(id,amount,tax_value)
{
	var v = document.getElementById('addon_'+id).value;
	var sum = Number(amount) * Number(v);
	document.getElementById('addon_sum_'+id).innerHTML = sum;

	var tax_sum = Number(tax_value) * Number(v);
	document.getElementById('addon_tax_sum_'+id).value = tax_sum;

	var addon_total = 0;
	$('.addon_sum').each(function(){
	    addon_total += parseFloat($(this).text());
	});

	var addon_tax_total = 0;
	$('.addon_tax_sum').each(function(){
	    addon_tax_total += parseFloat($(this).val());
	});

	document.getElementById('addon_total').innerHTML = addon_total;
	document.getElementById('addon_total_sum').innerHTML = addon_total;
	document.getElementById('taddon_total_sum').value = addon_total;
	document.getElementById('addon_tax_sum').innerHTML = addon_tax_total;
	document.getElementById('taddon_tax_sum').value = addon_tax_total;
	calc_final();
}
function calc_final()
{
	document.getElementById('final_tvalue').innerHTML = "₹ " + (Number(document.getElementById('final_value_c').value) + Number(document.getElementById('taddon_total_sum').value) + Number(document.getElementById('taddon_tax_sum').value));
}
</script>