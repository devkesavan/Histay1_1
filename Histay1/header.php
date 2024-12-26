<script>
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
session_start();
include("wadmin/db-config.php");

if(isset($_POST['create_account']))
 {
    extract($_POST);
    $data = array(
    'key' => $json_key,
    'action' => 'members_signup',
    'name' => $name, 
    'address' => $address,
    'email' => $email,
    'mobile' => $mobile,  
    'password' => $password,
    );
    $result = call_json($data);
    if($result['success'] == 1)
    {
      /*$_SESSION['temp_member_uid'] = $result['member_id'];
      $_SESSION['temp_member_vtoken'] = $result['verification_token'];

      $otp = rand(1000,9999);
      $_SESSION['otp_code'] = $otp;
      $_SESSION['otp_mobile'] = $mobile;

      //2factor SMS OTP
      $YourAPIKey = 'e05253ef-7926-11eb-a9bc-0200cd936042';
      $From = "ECRCHK";
      $To = $result['mobile'];
      $TemplateName = "OTP_SMS";
      $VAR1 = $otp;
      $VAR2 = "www.ecrcheckin.in";

      //DO NOT Change anything below this line
      $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
      $url = "https://2factor.in/API/V1/$YourAPIKey/ADDON_SERVICES/SEND/TSMS"; 
      $ch = curl_init(); 
      curl_setopt($ch,CURLOPT_URL,$url); 
      curl_setopt($ch,CURLOPT_POST,true); 
      curl_setopt($ch,CURLOPT_POSTFIELDS,"TemplateName=$TemplateName&From=$From&To=$To&VAR1=$VAR1&VAR2=$VAR2"); 
      curl_setopt($ch, CURLOPT_USERAGENT, $agent);
      curl_exec($ch);

      echo "<script>window.location.href='?verify_mobile=1';</script>";*/
      echo "<script>alert('Registered successfully');</script>";
      echo "<script>window.location.href='index.php';</script>";
    }
    elseif($result['success'] == -1)
    {
      echo "<script>alert('Email already exits!');</script>";
      echo "<script>window.location.href='index.php';</script>";
    }
  }
  if(isset($_POST['verify_reg']))
  { 
    if($_POST['otp_code'] == $_SESSION['otp_code'])
    {
      $data = array(
      'key' => $json_key,
      'action' => 'members_signup_verify',
      'id' => $_SESSION['temp_member_uid'], 
      'verification_token' => $_SESSION['temp_member_vtoken']
      );
      $result = call_json($data);

      if($result['success'] == 1)
      {      
        echo "<script>alert('Registered successfully');</script>";
        echo "<script>window.location.href='index.php';</script>";
      }
      else
      {
        echo "<script>window.location.href='logout.php';</script>";
      }
    }
    else
    {
      if(isset($_SESSION['otp_wrong']))
      {
        $_SESSION['otp_wrong']++;

        if($_SESSION['otp_wrong'] >= 5)
        {
          echo "<script>alert('You have reached your maximum attempt!! Please try login again');</script>";
          echo "<script>window.location.href='logout.php';</script>";
        }
      }
      else
        $_SESSION['otp_wrong'] = 1;

      echo "<script>alert('Invalid OTP code');</script>";
      echo "<script>window.location.href='register.php?verify_mobile=1';</script>";
    }
  }

  if(isset($_POST['login']))
  { 
    $data = array(
    'key' => $json_key,
    'action' => 'members_login',
    'email' => $_POST['email'],
    'password' => mysqli_real_escape_string($con,$_POST['password']),
    );
    $result = call_json($data);
    
    if($result['success'] == 1)
    {
      if($result['status'] == 'A')
      {
          $_SESSION['member_uid'] = $result['member_id'];
          $_SESSION['member_email']   = $result['email'];
          $_SESSION['member_name']   = $result['name'];
          $_SESSION['member_mobile']   = $result['mobile'];
          $_SESSION['member_address']   = $result['address'];
          $_SESSION['member_login_token']   = $result['login_token'];
          
          echo "<script>window.location.href='index.php';</script>";

          /*$_SESSION['temp_member_uid'] = $result['member_id'];
          $_SESSION['temp_member_email']   = $result['email'];
          $_SESSION['temp_member_name']   = $result['name'];
          $_SESSION['temp_member_login_token']   = $result['login_token'];

          $otp = rand(1000,9999);
          $_SESSION['otp_code'] = $otp;
          $_SESSION['otp_mobile'] = $result['mobile'];

          //2factor SMS OTP
          $YourAPIKey = 'e05253ef-7926-11eb-a9bc-0200cd936042';
          $From = "ECRCHK";
          $To = $result['mobile'];
          $TemplateName = "OTP_SMS";
          $VAR1 = $otp;
          $VAR2 = "www.ecrcheckin.in";

          //DO NOT Change anything below this line
          $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
          $url = "https://2factor.in/API/V1/$YourAPIKey/ADDON_SERVICES/SEND/TSMS"; 
          $ch = curl_init(); 
          curl_setopt($ch,CURLOPT_URL,$url); 
          curl_setopt($ch,CURLOPT_POST,true); 
          curl_setopt($ch,CURLOPT_POSTFIELDS,"TemplateName=$TemplateName&From=$From&To=$To&VAR1=$VAR1&VAR2=$VAR2"); 
          curl_setopt($ch, CURLOPT_USERAGENT, $agent);
          curl_exec($ch);

          echo "<script>window.location.href='?verify_mobile=1';</script>";*/
      }
      else
      {
          echo "<script>alert('Access Denied');</script>";
          echo "<script>window.location.href='index.php';</script>";
      }
    }
    else
    {
        //echo "<script>alert('The Email ID or password you have entered is incorrect.');</script>";
        //echo "<script>window.location.href='index.php';</script>";
    }
  }

      if(isset($_POST['verify_login']))
      { 
        if($_POST['otp_code'] == $_SESSION['otp_code'])
        {
          $_SESSION['member_uid'] = $_SESSION['temp_member_uid'];
          $_SESSION['member_email']   = $_SESSION['temp_member_email'];
          $_SESSION['member_name']   = $_SESSION['temp_member_name'];
          $_SESSION['member_login_token']   = $_SESSION['temp_member_login_token'];
          
          echo "<script>window.location.href='my-account.php';</script>";
        }
        else
        {
          if(isset($_SESSION['otp_wrong']))
          {
            $_SESSION['otp_wrong']++;

            if($_SESSION['otp_wrong'] >= 5)
            {
              echo "<script>alert('You have reached your maximum attempt!! Please try login again');</script>";
              echo "<script>window.location.href='logout.php';</script>";
            }
          }
          else
            $_SESSION['otp_wrong'] = 1;

          echo "<script>alert('Invalid OTP code');</script>";
          echo "<script>window.location.href='login.php?verify_mobile=1';</script>";
        }
      }
?>
<!-- Sign In Popup -->
			<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">

				<div class="small-dialog-header">
					<h3>Sign In</h3>
				</div>

				<!--Tabs -->
				<div class="sign-in-form style-1">

					<ul class="tabs-nav">
						<li class=""><a href="#tab1">Log In</a></li>
						<li><a href="#tab2">Register</a></li>
					</ul>

					<div class="tabs-container alt">

						<!-- Login -->
						<div class="tab-content" id="tab1" style="display: none;">
							<form method="post" class="login">

								<p class="form-row2 form-row-wide">
									<label for="username">Email:
										<i class="im im-icon-Male"></i>
										<input type="text" class="input-text" name="email" id="username" value="" />
									</label>
								</p>

								<p class="form-row2 form-row-wide">
									<label for="password">Password:
										<i class="im im-icon-Lock-2"></i>
										<input class="input-text" type="password" name="password" id="password"/>
									</label>
									<span class="lost_password">
										<a href="#" >Lost Your Password?</a>
									</span>
								</p>

								<div class="form-row2">
									<input type="submit" class="button border margin-top-5" name="login" value="Login" />
									<!--<div class="checkboxes margin-top-10">
										<input id="remember-me" type="checkbox" name="check">
										<label for="remember-me">Remember Me</label>
									</div>-->
								</div>
								<div class="form-row2 text-center">
									<br>
									<a class="button border margin-top-5" href="google_login/"><i class="fa fa-google"></i> Continue with Google</a>
									<a class="button border margin-top-5" href="fb_login/"><i class="fa fa-facebook"></i> Continue with Facebook</a>
								</div>
								
							</form>
						</div>

						<!-- Register -->
						<div class="tab-content" id="tab2" style="display: none;">

							<form method="post" class="register">
								
							<p class="form-row2 form-row-wide">
								<label for="username2">Name:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="name" id="username2" value="" />
								</label>
							</p>

							<p class="form-row2 form-row-wide">
								<label for="email2">Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="address" id="email2" value="" />
								</label>
							</p>
								
							<p class="form-row2 form-row-wide">
								<label for="email2">Email Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="email" id="email2" value="" />
								</label>
							</p>

							<p class="form-row2 form-row-wide">
								<label for="password1">Mobile:
									<i class="im im-icon-Lock-2"></i>
									<input class="input-text" type="text" name="mobile" id="password1"/>
								</label>
							</p>

							<p class="form-row2 form-row-wide">
								<label for="password2">Password:
									<i class="im im-icon-Lock-2"></i>
									<input class="input-text" type="password" name="password" id="password2"/>
								</label>
							</p>

							<input type="submit" class="button border fw margin-top-10" name="create_account" value="Register" />
	
							</form>
						</div>

					</div>
				</div>
			</div>
			<!-- Sign In Popup / End -->


<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->
				<div id="logo">
					<a href="index.php"><img src="images/logo.png" alt=""></a>
				</div>

				<!-- Mobile Navigation -->
				<div class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</div>

				<!-- Main Navigation -->
				<nav id="navigation" class="style-1">
					<ul id="responsive">
					    <li><a href="index.php">Home</a></li>
					    <li><a href="aboutus.php">About Us</a></li>
					    <li><a href="activities.php">Activities</a></li>
					    <li><a href="contactus.php">Contact Us</a></li>

					<!--	<li><a class="current" href="#">Home</a>
							<ul>
								<li><a href="index.html">Home 1 (Modern)</a></li>
								<li><a href="index-2.html">Home 2 (Default)</a></li>
								<li><a href="index-3.html">Home 3 (Airbnb)</a></li>
								<li><a href="index-4.html">Home 4 (Classic)</a></li>
								<li><a href="index-5.html">Home 5 (Slider)</a></li>
								<li><a href="index-6.html">Home 6 (Map)</a></li>
								<li><a href="index-7.html">Home 7 (Video)</a></li>
							</ul>
						</li> 

						<li><a href="hotelslisting.php">Hotels</a>
							<ul>
								<li><a href="hotel.php">Hote page Layout</a>						
								</li>
								
							</ul>
						</li>-->

						<li><a href="#" class="user-name"><span>
								<?php
							if(isset($_SESSION['member_uid']))
							{
							    $profile_photo = $_SESSION['member_photo'];
							    echo "<img src='$profile_photo'></span>Hi, $_SESSION[member_name]!";
							}
							else
							{
							    echo "<img src='images/dashboard-avatar.png'></span>Hi, Guest!";
							}
							?>
							</a>
    			     	    <ul>
    			     	        <?php
    							if(!isset($_SESSION['member_uid']))
    							{
    							    if(isMobileDevice())
    							    {
    							        ?>
        								<li><a href="sign-up.php"><i class="fa fa-user-plus"></i> Sign Up</a></li>
        								<li><a href="sign-in.php"><i class="sl sl-icon-login"></i> Sign In</a></li>
        								<?php
    							    }
    							    else
    							    {
        								?>
        								<li><a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><i class="fa fa-user-plus"></i> Sign Up</a></li>
        								<li><a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><i class="sl sl-icon-login"></i> Sign In</a></li>
        								<?php
    							    }
    							}
    							else
    							{
    								?>
    								<li><a href="#" class="sign-in"><i class="fa fa-user"></i> My Account</a></li>
    								<li><a href="booking_history.php" class="sign-in"><i class="fa fa-book"></i> Booking Histoy</a></li>
    								<li><a href="logout.php" class="sign-in"><i class="fa fa-sign-out"></i> Logout</a></li>
    								<?php
    							}
    							?>
    							<!--<li><a class="cd-signin"><i class="sl sl-icon-settings"></i> Sign In</a></li>
    							<li><a class="cd-signup"><i class="sl sl-icon-envelope-open"></i> Sing Up</a></li>-->
    						</ul>
							<!--<ul>
								<li><a href="dashboard.html">Dashboard</a></li>
								<li><a href="dashboard-messages.html">Messages</a></li>
								<li><a href="dashboard-bookings.html">Bookings</a></li>
								<li><a href="dashboard-wallet.html">Wallet</a></li>
								<li><a href="dashboard-my-listings.html">My Listings</a></li>
								<li><a href="dashboard-reviews.html">Reviews</a></li>
								<li><a href="dashboard-bookmarks.html">Bookmarks</a></li>
								<li><a href="dashboard-add-listing.html">Add Listing</a></li>
								<li><a href="dashboard-my-profile.html">My Profile</a></li>
								<li><a href="dashboard-invoice.html">Invoice</a></li>
							</ul>-->
						</li> 

					<!--	<li><a href="#">Pages</a>
							<div class="mega-menu mobile-styles three-columns">

									<div class="mega-menu-section">
										<ul>
											<li class="mega-menu-headline">Pages #1</li>
											<li><a href="pages-user-profile.html"><i class="sl sl-icon-user"></i> User Profile</a></li>
											<li><a href="pages-booking.html"><i class="sl sl-icon-check"></i> Booking Page</a></li>
											<li><a href="pages-add-listing.html"><i class="sl sl-icon-plus"></i> Add Listing</a></li>
											<li><a href="pages-blog.html"><i class="sl sl-icon-docs"></i> Blog</a></li>
										</ul>
									</div>
		
									<div class="mega-menu-section">
										<ul>
											<li class="mega-menu-headline">Pages #2</li>
											<li><a href="pages-contact.html"><i class="sl sl-icon-envelope-open"></i> Contact</a></li>
											<li><a href="pages-coming-soon.html"><i class="sl sl-icon-hourglass"></i> Coming Soon</a></li>
											<li><a href="pages-404.html"><i class="sl sl-icon-close"></i> 404 Page</a></li>
											<li><a href="pages-masonry-filtering.html"><i class="sl sl-icon-equalizer"></i> Masonry Filtering</a></li>
										</ul>
									</div>

									<div class="mega-menu-section">
										<ul>
											<li class="mega-menu-headline">Other</li>
											<li><a href="pages-elements.html"><i class="sl sl-icon-settings"></i> Elements</a></li>
											<li><a href="pages-pricing-tables.html"><i class="sl sl-icon-tag"></i> Pricing Tables</a></li>
											<li><a href="pages-typography.html"><i class="sl sl-icon-pencil"></i> Typography</a></li>
											<li><a href="pages-icons.html"><i class="sl sl-icon-diamond"></i> Icons</a></li>
										</ul>
									</div>
									
							</div>
						</li> -->
						
					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->
			

<!-- Right Side Content / End -->
			<div class="right-side">
				<div class="">
				
				<nav id="navigation" class="style-1">
					<ul id="responsive">

					<!--	<li><a class="current" href="#">Home</a>
							<ul>
								<li><a href="index.html">Home 1 (Modern)</a></li>
								<li><a href="index-2.html">Home 2 (Default)</a></li>
								<li><a href="index-3.html">Home 3 (Airbnb)</a></li>
								<li><a href="index-4.html">Home 4 (Classic)</a></li>
								<li><a href="index-5.html">Home 5 (Slider)</a></li>
								<li><a href="index-6.html">Home 6 (Map)</a></li>
								<li><a href="index-7.html">Home 7 (Video)</a></li>
							</ul>
						</li> -->
                          <li><a class="active" href="index.php">Home</a></li>
							
								<li><a href="aboutus.php">About Us</a></li>
					
						<!-- <ul>
								<li><a href="hotel.php">Beach Houses</a>
<li><a href="hotel.php">Individual properties</a>
<li><a href="hotel.php">Villas</a>
<li><a href="hotel.php">Rooms</a>								
								</li>
								
							</ul> -->
						</li>
							
								
									<li><a href="activities.php">Activities</a>
								<!--	<ul>
								<li><a href="dashboard.html">Dashboard</a></li>
								<li><a href="dashboard-messages.html">Messages</a></li>
								<li><a href="dashboard-bookings.html">Bookings</a></li>
								<li><a href="dashboard-wallet.html">Wallet</a></li>
								<li><a href="dashboard-my-listings.html">My Listings</a></li>
								<li><a href="dashboard-reviews.html">Reviews</a></li>
								<li><a href="dashboard-bookmarks.html">Bookmarks</a></li>
								<li><a href="dashboard-add-listing.html">Add Listing</a></li>
								<li><a href="dashboard-my-profile.html">My Profile</a></li>
								<li><a href="dashboard-invoice.html">Invoice</a></li>
							</ul> -->
									</li>
									<li><a href="contactus.php">Contact Us</a></li>
					<!--	<li><a href="#">User Panel</a>
							<ul>
								<li><a href="dashboard.html">Dashboard</a></li>
								<li><a href="dashboard-messages.html">Messages</a></li>
								<li><a href="dashboard-bookings.html">Bookings</a></li>
								<li><a href="dashboard-wallet.html">Wallet</a></li>
								<li><a href="dashboard-my-listings.html">My Listings</a></li>
								<li><a href="dashboard-reviews.html">Reviews</a></li>
								<li><a href="dashboard-bookmarks.html">Bookmarks</a></li>
								<li><a href="dashboard-add-listing.html">Add Listing</a></li>
								<li><a href="dashboard-my-profile.html">My Profile</a></li>
								<li><a href="dashboard-invoice.html">Invoice</a></li>
							</ul>
						</li> 
						
						
						<li><a href="#">User Panel</a>
							<ul>
								<li><a href="dashboard.html">Dashboard</a></li>
								<li><a href="dashboard-messages.html">Messages</a></li>
								<li><a href="dashboard-bookings.html">Bookings</a></li>
								<li><a href="dashboard-wallet.html">Wallet</a></li>
								<li><a href="dashboard-my-listings.html">My Listings</a></li>
								<li><a href="dashboard-reviews.html">Reviews</a></li>
								<li><a href="dashboard-bookmarks.html">Bookmarks</a></li>
								<li><a href="dashboard-add-listing.html">Add Listing</a></li>
								<li><a href="dashboard-my-profile.html">My Profile</a></li>
								<li><a href="dashboard-invoice.html">Invoice</a></li>
							</ul>
						</li> -->
					</ul>
				</nav>
					<!-- User Menu -->
					<div class="user-menu">
						<div class="user-name"><span>
								<?php
								if(isset($_SESSION['member_uid']))
								{
										if(isset($_SESSION['member_photo']))
								    	$profile_photo = $_SESSION['member_photo'];
								    else
								    	$profile_photo = $MAIN_URL."images/dashboard-avatar.png";
								    echo "<img src='$profile_photo'></span>Hi, $_SESSION[member_name]!";
								}
								else
								{
								    echo "<img src='images/dashboard-avatar.png'></span>Hi, Guest!";
								}
								?>
						</div>
						<ul>
							<?php
							if(!isset($_SESSION['member_uid']))
							{
								?>
								<li><a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><i class="fa fa-user-plus"></i> Sign Up</a></li>
								<li><a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><i class="sl sl-icon-login"></i> Sign In</a></li>
								<?php
							}
							else
							{
								?>
								<li><a href="#" class="sign-in"><i class="fa fa-user"></i> My Account</a></li>
								<li><a href="booking_history.php" class="sign-in"><i class="fa fa-book"></i> Booking Histoy</a></li>
								<li><a href="logout.php" class="sign-in"><i class="fa fa-sign-out"></i> Logout</a></li>
								<?php
							}
							?>
							<!--
							<li><a class="cd-signin"><i class="sl sl-icon-settings"></i> Sign In</a></li>
							<li><a class="cd-signup"><i class="sl sl-icon-envelope-open"></i> Sing Up</a></li>
							<li><a href="#"><i class="fa fa-calendar-check-o"></i> Bookings</a></li>
							<li><a href="#"><i class="sl sl-icon-power"></i> Logout</a></li>-->
						</ul>
						<!--<ul class="main-nav">
							<li><a class="cd-signin"><i class="sl sl-icon-settings"></i> Sign In</a></li>
							<li><a class="cd-signup"><i class="sl sl-icon-envelope-open"></i> Sign Up</a></li>
							
						</ul>-->
					</div>

					<!--<a href="addproperty.php" class="button border with-icon">Add Your Property<i class="sl sl-icon-plus"></i></a>
				-->
				</div>
			</div>
			<!-- Right Side Content / End -->
			
			

		</div>
	</div>
	<!-- Header / End -->
	
