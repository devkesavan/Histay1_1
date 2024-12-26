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

<?php
include_once('header.php');

if(isset($_POST['update']))
{
    $data = array(
    'key' => $json_key,
    'action' => 'member_update',
    'login_token' => $_SESSION['member_login_token'],
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'address' => $_POST['address'],
    'mobile' => $_POST['mobile'],
    );
    $update_result = call_json($data);
    
    //echo "<script>alert('Profile updated successfully!!');</script>";
    echo "<script>
            Swal.fire(
              'Updated!',
              'Profile updated successfully!',
              'success'
            )
          </script>";
    //echo "<script>window.location.href='my_profile.php';</script>";
}
?>

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->


<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>My Profile</h2><span></span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Account</a></li>
						<li>My Profile</li>
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
				<h4 class="gray">Profile Details</h4>
				<div class="dashboard-list-box-static">

                    <form method="post">
    					<!-- Details -->
    					<div class="my-profile">
    					    <?php
    					    $data = array(
                                'key' => $json_key,
                                'action' => 'member_edit',
                                'login_token' => $_SESSION['member_login_token']
                                );
                            $edit_result = call_json($data);
                            ?>
    						<label>Your Name</label>
    						<input placeholder="Name" type="text" name="name" value="<?php echo $edit_result['name']; ?>">
    
    						<label>Mobile</label>
    						<input placeholder="Mobile" type="text" name="mobile" value="<?php echo $edit_result['mobile']; ?>">
    
    						<label>Email</label>
    						<input placeholder="Email" type="email" name="email" value="<?php echo $edit_result['email']; ?>">
    
    						<label>Address</label>
    						<textarea name="address" placeholder="Address" cols="30" rows="3"><?php echo $edit_result['address']; ?></textarea>
    					</div>
    
    					<button class="button margin-top-15" name="update">Save Changes</button>
                    </form>
				</div>
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