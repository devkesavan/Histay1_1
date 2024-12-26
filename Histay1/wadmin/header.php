<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>ECR Checkin</title>
  <link rel="stylesheet" href="assets/css/app.min.css">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="assets/bundles/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/bundles/sweetalert/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <!-- General CSS Files -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/bundles/prism/prism.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="assets/bundles/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/datepicker.css"  />

  <!-- Custom style CSS -->
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />

</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"><i
                  class="fas fa-bars"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                  <i class="fas fa-expand"></i>
                </a>
            </li>
            <li>
              <div class="search-group">
                <span class="nav-link nav-link-lg" id="search">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </span>
                <input type="text" class="search-control" placeholder="search" aria-label="search" aria-describedby="search">
              </div>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i><span class="notification-count bg-green">4</span></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <span class="dropdown-item-icon l-bg-green text-white">
                    <i class="fas fa-shopping-cart"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    5 sales Product
                    <span class="time">8 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <span class="dropdown-item-icon l-bg-orange text-white">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    10 Customers Inquiry
                    <span class="time">7 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon l-bg-yellow text-white">
                    <i class="fa fa-server" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    Your Subscription Expired
                    <span class="time">10 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon l-bg-blue text-white">
                    <i class="fas fa-user-edit" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    Update Profile
                    <span class="time">9 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon l-bg-purple text-white">
                    <i class="far fa-envelope" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    10 Email Notifications
                    <span class="time">Yesterday</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link nav-link-lg beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-5.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Sophie Walker</span>
                    <span class="time messege-text">Project Planning</span>
                    <span class="time">10 Minutes Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-4.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Ryan Porter</span>
                    <span class="time messege-text">Project Analysis</span>
                    <span class="time">2 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-1.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Robert Nelson</span>
                    <span class="time messege-text">Leave application !!</span>
                    <span class="time">4 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-2.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Clara Martin</span>
                    <span class="time messege-text">Client meeting</span>
                    <span class="time">1 Day Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-3.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Kevin Rogers</span>
                    <span class="time messege-text">Discussion about Issues</span>
                    <span class="time">3 Days Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="assets/img/users/user-2.png" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Clara Martin</span>
                    <span class="time messege-text">Team meeting</span>
                    <span class="time text-primary">5 Days Ago</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>

          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="assets/img/users/user-icon.png" class="user-img-radious-style">
              <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Hello Alexa Lopez</div>
              <a href="#profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="change-password.php" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Change password
              </a>
              <a href="settings.php" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.php">
              <img alt="image" src="/images/logo.png" class="header-logo" style="width:75%;height:auto;padding:3px ​0px 0px 0px;" />
            </a>
          </div>
          <ul class="sidebar-menu">
          	<li class="dropdown active" style="display: block;">
          		 <div class="sidebar-profile">
	                 <div class="siderbar-profile-pic">
	                     <img src="assets/img/users/user-icon.png" class="profile-img-circle box-center" alt="User Image">
	                 </div>
	                 <div class="siderbar-profile-details">
	                     <div class="siderbar-profile-name"><?php echo $_SESSION['uname']; ?></div>
	                     <div class="siderbar-profile-position">
                        <?php
                             if($_SESSION['uType'] == 'SA')
                                  echo "super Admin";
                             elseif($_SESSION['uType'] == 'AD')
                                echo "admin";
                               elseif($_SESSION['uType'] == 'HA')
                                echo "Hotel Admin";
                             ?> 
                       </div>
	                 </div>
	                 <div class="sidebar-profile-buttons">
	                     <a class="tooltips waves-effect waves-block toggled" href="profile.html" data-toggle="tooltip" title="" data-original-title="Profile">
	                         <i class="fas fa-user sidebarQuickIcon"></i>
	                     </a>
	                     <a class="tooltips waves-effect waves-block" href="email-inbox.html" data-toggle="tooltip" title="" data-original-title="Mail">
	                         <i class="fas fa-envelope sidebarQuickIcon"></i>
	                     </a>
	                     <a class="tooltips waves-effect waves-block" href="change-password.php" data-toggle="tooltip" title="" data-original-title="change Password">
                        <i class="fas fa-comment-dots  sidebarQuickIcon"></i>
	                     </a>
	                     <a class="tooltips waves-effect waves-block" href="logout.php" data-toggle="tooltip" title="" data-original-title="Logout">
                        <i class="fas fa-share-square sidebarQuickIcon"></i>
	                     </a>
	                 </div>
                 </div>
             </li>
            <li class="menu-header">Main</li>
            <?php
            if($_SESSION['uType']=='SA')
            {
            ?>
             <li><a class="nav-link" href="index.php"><i class="fas fa-desktop"></i><span>Dashboard</span></a></li>
              <li class="dropdown active">
              <a href="#" class="nav-link has-dropdown toggle"><i class="fas fa-user-lock"></i><span>Master</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="master_destination.php">Destination</a></li>
                <li><a class="nav-link" href="master_property_type.php">Property Type</a></li>
                <li><a class="nav-link" href="master_facility.php">Facilities</a></li>
                <li><a class="nav-link" href="master_tax.php">Taxes</a></li>
                <li><a class="nav-link" href="master_room_rates.php">Room Rates</a></li>
              </ul>
            </li>
            <li class="dropdown active">
              <a href="#" class="nav-link has-dropdown toggle"><i class="fas fa-user-lock"></i><span>Management</span></a>
              <ul class="dropdown-menu">
              <li><a class="nav-link" href="calendar_booking_theme.php">Calendar</a></li>
              <li><a class="nav-link" href="master_hotels.php">Hotels</a></li>
              <li><a class="nav-link" href="members_view.php">Members</a></li>
              <li><a class="nav-link" href="hotel_room_rates.php">Hotel Room Rates</a></li>
              <li><a class="nav-link" href="master_hotel_addons.php">Hotel Addons</a></li>
              <li><a class="nav-link" href="master_hotel_rating.php">Hotel Rating</a></li>
              <li><a class="nav-link" href="master_hotel_rooms.php">Hotel Rooms</a></li>
              <li><a class="nav-link" href="master_coupon_code.php">Coupon Code</a></li>
              <li><a class="nav-link" href="master_admin_users.php">Admin Users</a></li>
              <li><a class="nav-link" href="master_events.php">Events</a></li>
              <li><a class="nav-link" href="events_registration.php">Events Registration</a></li>
              <li><a class="nav-link" href="bookings.php">Hotel Booking</a></li>
              </ul>
            </li>
            <li class="dropdown active">
              <a href="#" class="nav-link has-dropdown toggle"><i class="fas fa-user-lock"></i><span>CMS</span></a>
              <ul class="dropdown-menu">
               <li><a class="nav-link" href="master_menus.php">Menus</a></li>
                <li><a class="nav-link" href="master_pages.php">Pages</a></li>
                <li><a class="nav-link" href="master_slider.php">Slider</a></li>
                <li><a class="nav-link" href="master_gallery_category.php">Gallery Category</a></li>
                <li><a class="nav-link" href="master_gallery.php">Gallery</a></li>
                <li><a class="nav-link" href="master_testimonial.php">Testimonial</a></li>
              </ul>
            </li>
            <?php
             }
              elseif($_SESSION['uType']=='AD')
              {
              ?>
              <li><a class="nav-link" href="index.php"><i class="fas fa-desktop"></i><span>Dashboard</span></a></li>
              <li class="dropdown active">
                <a href="#" class="nav-link has-dropdown toggle"><i class="fas fa-user-lock"></i><span>Admin</span></a>
                <ul class="dropdown-menu">
                <li><a class="nav-link" href="master_coupon_code.php">Coupon Code</a></li>
                <li><a class="nav-link" href="master_admin_users.php">Admin Users</a></li>
                <li><a class="nav-link" href="master_events.php">Events</a></li>
                <li><a class="nav-link" href="events_registration.php">Events Registration</a></li>
                <li><a class="nav-link" href="master_gallery_category.php">Gallery Category</a></li>
                <li><a class="nav-link" href="master_gallery.php">Gallery</a></li>
                </ul>
              </li>
             <?php
              }
              elseif($_SESSION['uType']=='HA') 
              {
              ?>
              <li><a class="nav-link" href="index.php"><i class="fas fa-desktop"></i><span>Dashboard</span></a></li>
              <li class="dropdown active">
                <a href="#" class="nav-link has-dropdown toggle"><i class="fas fa-user-lock"></i><span>Hotel Admin</span></a>
                <ul class="dropdown-menu">
                <li><a class="nav-link" href="master_hotels.php">Hotels</a></li>
                <li><a class="nav-link" href="master_hotel_rooms.php">Hotel Rooms</a></li>
                <li><a class="nav-link" href="master_room_rates.php">Hotel Room Rates</a></li>
                <li><a class="nav-link" href="master_hotel_rating.php">Hotel Rating</a></li>
                <li><a class="nav-link" href="bookings.php">Hotel Booking</a></li>
                </ul>
              </li>
              <?php
              }
              ?>
          </ul>
        </aside>
      </div>
	  <!-- Menu End -->
	   <!-- Main Content -->
      <div class="main-content">


  
                
                
                
                
                
                
               