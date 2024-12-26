<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>ECR Checkin</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/main-color.css" id="colors">

</head>

<body>

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<header id="header-container">

	<?php include_once('header.php'); ?>


</header>
<div class="clearfix"></div>
<!-- Header Container / End -->


<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Booking History</h2><span></span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Account</a></li>
						<li>Booking History</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row">

		<!-- Sidebar
		================================================== -->
		<div class="col-lg-3 col-md-4">
			<div class="dashboard-nav" style="position: inherit;">
				<div class="dashboard-nav-inner">
					
					<ul data-submenu-title="Booking">
						<li><a href="booking_history.php"><i class="sl sl-icon-book-open"></i> Booking History</a></li>
					</ul>	

					<ul data-submenu-title="Account">
						<li><a href="my_profile.php"><i class="sl sl-icon-user"></i> My Profile</a></li>
						<li><a href="change_password.php"><i class="im im-icon-Password-Field"></i> Change Password</a></li>						
						<li><a href="logout.php"><i class="sl sl-icon-power"></i> Logout</a></li>
					</ul>

				</div>
			</div>
			<!-- Navigation / End -->
		</div>
		<!-- Sidebar / End -->

		<div class="col-lg-9 col-md-8 padding-right-30">

			<div class="dashboard-list-box margin-top-0">
					
				<!-- Booking Requests Filters  -->
				<div class="booking-requests-filter">

					<!--
					<div class="sort-by">
						<div class="sort-by-select">
							<select data-placeholder="Default order" class="chosen-select-no-single">
								<option>All Listings</option>	
								<option>Burger House</option>
								<option>Tom's Restaurant</option>
								<option>Hotel Govendor</option>
							</select>
						</div>
					</div>-->

					<!--
					<div id="booking-date-range">
					    <span></span>
					</div>-->
				</div>

				<!-- Reply to review popup -->
				<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
					<div class="small-dialog-header">
						<h3>Send Message</h3>
					</div>
					<div class="message-reply margin-top-0">
						<textarea cols="40" rows="3" placeholder="Your Message to Kathy"></textarea>
						<button class="button">Send</button>
					</div>
				</div>

				<h4>My Bookings</h4>
				<ul>
					<?php
	                  $data = array(
	                  'key' => $json_key,
	                  'action' => 'booking_history_list',
	                  'member_id' => $_SESSION['member_uid'],
	                  );
	                  $result = call_json($data);
	                  foreach($result['booking_history_list'] as $key => $value)
	                  {
	                  	$after_dis_value = $result['booking_history_list'][$key]['order_total'] - $result['booking_history_list'][$key]['discount_value'];
	                  ?>
						<li class="pending-booking">
							<div class="list-box-listing bookings">
								<div class="list-box-listing-img"><img src="<?php echo $result['booking_history_list'][$key]['hotel_image'];?> " alt=""></div>
								<div class="list-box-listing-content">
									<div class="inner">
										<h3><?php echo $result['booking_history_list'][$key]['hotel_name'];?> 
											<span class="booking-status pending"><?php echo $result['booking_history_list'][$key]['booking_code'];?></span></h3>

										<div class="inner-booking-list">
											<h5>Booking Date:</h5>
											<ul class="booking-list">
												<li class="highlighted"><?php echo $result['booking_history_list'][$key]['checkin_date']." - ".$result['booking_history_list'][$key]['checkout_date'];?></li>
											</ul>
										</div>													
										<div class="inner-booking-list">
											<h5>Booking Details:</h5>
											<ul class="booking-list">
												<li class="highlighted"><?php echo $result['booking_history_list'][$key]['rooms_count'];?> Rooms,
																		<?php echo $result['booking_history_list'][$key]['total_adults'];?> Adults, 
																		<?php echo $result['booking_history_list'][$key]['total_childerns'];?> Childerns</li>
											</ul>
										</div>													
										<div class="inner-booking-list">
											<h5>Order Total:</h5>
											<ul class="booking-list">
												<li class="highlighted"><?php echo "₹".$result['booking_history_list'][$key]['order_total'];
													if($result['booking_history_list'][$key]['discount_value'] > 0)
														echo " + ₹".$result['booking_history_list'][$key]['discount_value']." Discount = ₹".$after_dis_value;
													echo " + ₹".$result['booking_history_list'][$key]['tax_value']." GST";?></li>
											</ul>
										</div>	
										<div class="inner-booking-list">
											<h5>Final Total:</h5>
											<ul class="booking-list">
												<li class="highlighted"><?php echo "₹".$result['booking_history_list'][$key]['final_total'];?></li>
											</ul>
										</div>		

										<div class="inner-booking-list">
											<h5>Registered Details:</h5>
											<ul class="booking-list">
												<li><?php echo $result['booking_history_list'][$key]['name'];?></li>
												<li><?php echo $result['booking_history_list'][$key]['email'];?></li>
												<li><?php echo $result['booking_history_list'][$key]['mobile'];?></li>
											</ul>
										</div>

										<!--<a href="#small-dialog" class="rate-review popup-with-zoom-anim"><i class="sl sl-icon-envelope-open"></i> Send Message</a>-->

									</div>
								</div>
							</div>
							<!--<div class="buttons-to-right">
								<a href="#" class="button gray reject"><i class="sl sl-icon-close"></i> Reject</a>
								<a href="#" class="button gray approve"><i class="sl sl-icon-check"></i> Approve</a>
							</div>-->
						</li>
						<?php
					}
					?>
					
				</ul>
			</div>

		</div>

	</div>
</div>

<?php include("footer.php"); ?>

<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
<script src="scripts/moment.min.js"></script>
<script src="scripts/daterangepicker.js"></script>

<script>
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#booking-date-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    cb(start, end);
    $('#booking-date-range').daterangepicker({
    	"opens": "left",
	    "autoUpdateInput": false,
	    "alwaysShowCalendars": true,
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});

// Calendar animation and visual settings
$('#booking-date-range').on('show.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-visible calendar-animated bordered-style');
	$('.daterangepicker').removeClass('calendar-hidden');
});
$('#booking-date-range').on('hide.daterangepicker', function(ev, picker) {
	$('.daterangepicker').removeClass('calendar-visible');
	$('.daterangepicker').addClass('calendar-hidden');
});
</script>