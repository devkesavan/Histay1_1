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

if(isset($_POST['change_password']))
{
     $data = array(
        'key' => $json_key,
        'action' => 'members_change_password',
        'login_token' => $_SESSION['member_login_token'],
        'current_password' => $_POST['current_password'],
        'new_password' => $_POST['new_password'],
        'confirm_password' => $_POST['confirm_password'],
    );
    $result = call_json($data);
    if($result['success'] == 1)
    {
        echo "<script>
            Swal.fire(
              'Updated!',
              'Password Changed successfully!',
              'success'
            )
          </script>";
        //echo "<script>window.location.href='change_password.php';</script>";
    }
    elseif($result['success'] == -1)
    {
        echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Password Not Changed!'
            })
          </script>";
        //echo "<script>window.location.href='change_password.php';</script>";
    }
    elseif($result['success'] == -2)
    {
        echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Current Password does not match!'
            })
          </script>";
        //echo "<script>window.location.href='change_password.php';</script>";
    }
    elseif($result['success'] == -3)
    {
        echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Confirm Password does not match!'
            })
          </script>";
        //echo "<script>window.location.href='change_password.php';</script>";
    }
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

				<h2>Change Password</h2><span></span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Account</a></li>
						<li>Change Password</li>
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
				<h4 class="gray">Change Password</h4>
				<div class="dashboard-list-box-static">

                    <form method="post">
    					<!-- Details -->
    					<div class="my-profile">
    						<label>Current Password</label>
    						<input placeholder="Current Password" type="password" name="current_password" required>
    						<label>New Password</label>
    						<input placeholder="New Password" type="password" name="new_password" required>
    						<label>Confirm Password</label>
    						<input placeholder="Confirm Password" type="password" name="confirm_password" required>
    					</div>
    
    					<button class="button margin-top-15" name="change_password">Update Password</button>
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