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
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
</head>

<body>

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<header id="header-container">

	<?php include_once('header.php'); ?>

	<?php
$body_class = "";

$data = array(
'key' => $json_key,
'action' => 'hotel_details',
'slug' => $_GET['hotel'],
'sort' => 'ASC',
'hotel_id' => '0',
'limit_st' => '0',
'limit_cnt' => '0',
 );
$result = call_json($data);

if(isset($_POST['add_review']))
{
	extract($_POST);
	$data = array(
	'key' => $json_key,
	'action' => 'hotel_add_rating',
	'hotel_id' => $result['hotels_details_list']['hotel_id'],
	'name' => $name, 
	'email' => $email,
	'comment' => $comment,  
	'rating' => $rating,
	);
	$rating_result = call_json($data);
	//echo "sfdsdf";
	print_r($rating_result);
	if($rating_result['success'] == 1)
	{
		echo "<script>alert('Thanks For Your Feedback !!');</script>";
		echo "<script>window.location.href='hotel-details.php?hotel=$_GET[hotel]';</script>";
	}
} 
?>

<style>
#dropdownMenuButton
{
	display:none;
}
</style>

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->

<link rel="stylesheet" type="text/css" href="popup/jquery.lightbox.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $result['hotels_details_list']['name'];?> Gallery Images</h4>
        </div>
        <div class="modal-body">
          <ul class="gallery">
            <?php
            foreach($result['hotels_details_list']['hotel_images'] as $key => $ivalue)
			{
				?>
				<li><a href="<?php echo $ivalue['hotel_image'];?>"><img src="<?php echo $ivalue['hotel_image'];?>" alt="Image"></a></li>
				<?php
			}
			?>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="popup/jquery.lightbox.js"></script>
<script>
  // Initiate Lightbox
  $(function() {
    $('.gallery a').lightbox();
  });
</script>


<!-- Slider
================================================== -->
<!-- <div class="listing-slider mfp-gallery-container margin-bottom-0">
	<a href="images/single-listing-01.jpg" data-background-image="images/single-listing-01.jpg" class="item mfp-gallery" title="Title 1"></a>
	<a href="images/single-listing-02.jpg" data-background-image="images/single-listing-02.jpg" class="item mfp-gallery" title="Title 3"></a>
	<a href="images/single-listing-03.jpg" data-background-image="images/single-listing-03.jpg" class="item mfp-gallery" title="Title 2"></a>
	<a href="images/single-listing-04.jpg" data-background-image="images/single-listing-04.jpg" class="item mfp-gallery" title="Title 4"></a>
</div> -->
<br>
	<div class="container">
	    <h2><?php echo $result['hotels_details_list']['name'];?> <span class="listing-tag">New</span></h2>
		<a href="#" class="prev">&lt;</a>
		<a href="#" class="next">&gt;</a>
		<main class="container-gallery gallery">
			<?php
			/*$oimg = 0;
			foreach($result['hotels_details_list']['hotel_images'] as $key => $ivalue)
			{
				$oimg++
				?>
				<div class="<?php if($oimg == 1) echo "big"; ?>"><img src="<?php echo $ivalue['hotel_image'];?>" alt=""></div>
				<?php
			}*/
			?>
      <?php
      $oimg = 0;
      foreach($result['hotels_details_list']['hotel_images'] as $key => $ivalue)
			{
				$oimg++
				?>
				<div class="<?php if($oimg == 1) echo "big"; ?>">
				    <a href="<?php echo $ivalue['hotel_image'];?>"><img src="<?php echo $ivalue['hotel_image'];?>" alt="Image"></a>
			    </div>
				<?php
				if($oimg == 5)
					break;
			}
			?>
			<!--<div class="big"><img src="images/rooms/g14.webp" alt=""></div>
			<div><img src="images/rooms/g15.webp" alt=""></div>
			<div><img src="images/rooms/g16.webp" alt=""></div>	
			<div><img src="images/rooms/g21.webp" alt=""></div>
			<div><img src="images/rooms/g23.webp" alt=""></div>			-->					
		</main>
	<div style="float:right; padding-top:2px;">
	    <a href="#"><button class="btn-banner-no-border slide-in-bottom" data-toggle="modal" data-target="#myModal"><span>View Gallery</span></button></a></div>
	</div>

<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">
		<div class="col-lg-8 col-md-8 padding-right-30">

			<!-- Titlebar -->
			<div id="titlebar" class="listing-titlebar">
				<div class="listing-titlebar-title">
					<h2><?php echo $result['hotels_details_list']['name'];?> <span class="listing-tag">New</span></h2>
					<span>
						<a href="#listing-location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							<?php echo $result['hotels_details_list']['city_name'];?>						
						</a>
					</span>
					<div class="star-rating" data-rating="<?php echo $result['hotels_details_list']['rating']; ?>">
						<div class="rating-counter"><a href="#listing-reviews">(<?php echo $result['hotels_details_list']['review_count']; ?> reviews)</a></div>
					</div>
				</div>
			</div>

			<!-- Listing Nav -->
			<div id="listing-nav" class="listing-nav-container">
				<ul class="listing-nav">
					<li><a href="#listing-overview" class="active">Overview</a></li>
					<li><a href="#listing-pricing-list">Pricing</a></li>
					<li><a href="#listing-location">Location</a></li>
					<li><a href="#listing-reviews">Reviews</a></li>
					<li><a href="#add-review">Add Review</a></li>
				</ul>
			</div>
			
			<!-- Overview -->
			<div id="listing-overview" class="listing-section">

				<!-- Description -->

				<p><?php echo $result['hotels_details_list']['description'];?></p>
				
				<div class="clearfix"></div>


				<!-- Amenities -->
				<h3 class="listing-desc-headline">Amenities</h3>
				<ul class="listing-features margin-top-0">
					<?php
					foreach($result['hotels_details_list']['hotel_facilities'] as $key => $value)
					{
						?> 
						<li>
							<img src="images/facility/small/<?php echo $value['icon_image'];?>" class="tips" style="width: 18px;"> <?php echo $value['name'];?>
						</li>
						<?php
					}
					?>
					 <!--<li> <i class="fa fa-cutlery"></i> Elevator in building</li>
					 <li> <i class="fa fa-coffee"></i> Friendly workspace</li>
					 <li> <i class="fa fa-binoculars"></i> Instant Book</li>
					 <li> <i class="fa fa-wifi"></i> Wireless Internet</li>
					 <li> <i class="fa fa-car"></i> Free parking on premises</li>
					 <li> <i class="fa fa-black-tie"></i> Free parking on street</li>-->
				</ul>
			</div>	
		
			<!-- Location -->
			<div id="listing-location" class="listing-section">
				<h3 class="listing-desc-headline margin-top-60 margin-bottom-30">Location</h3>

				<div id="singleListingMap-container">
					<!--<div id="singleListingMap" data-latitude="40.70437865245596" data-longitude="-73.98674011230469" data-map-icon="im im-icon-Hamburger"></div>
					<a href="#" id="streetView">Street View</a> -->
					
					<!-- Map -->
					<iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $result['hotels_details_list']['map'];?>&output=embed"></iframe>

					<!--<div id="map-container1"> <div id="map"></div></div>-->
				</div>
			</div>	

		</div>


		<!-- Sidebar
		================================================== -->
		<div class="col-lg-4 col-md-4 margin-top-35 sticky">

				
			<!-- Verified Badge 
			<div class="verified-badge with-tip" data-tip-content="Listing has been verified and belongs the business owner or manager.">
				<i class="sl sl-icon-check"></i> Verified Listing
			</div>-->

			<!-- Book Now -->
			<div id="booking-widget-anchor" class="boxed-widget booking-widget margin-top-35 tt_booking_widget">
				<h3><i class="fa fa-calendar-check-o "></i> Booking</h3>
				<div class="row with-forms  margin-top-0">

					<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
					<div class="col-lg-6">
						<h5 class="tt_pdisp"><small>Starts from</small><br>
								₹<?php echo $result['hotels_details_list']['cost']; ?> 
								<span class="line-through">₹<?php echo $result['hotels_details_list']['actual_cost']; ?></span> / night</h5>
					</div>
					<div class="col-lg-6">
						<h5><small>Rating</small><br>
						<i class="fa fa-star"></i> <?php echo $result['hotels_details_list']['rating']; ?> (<?php echo $result['hotels_details_list']['review_count']; ?> reviews)</h5>
					</div>
					<div class="col-lg-6">
						<h5><small>Check-in</small><br>
								₹<?php echo $_SESSION['check_in']; ?></h5>
					</div>
					<div class="col-lg-6">
						<h5><small>Checkout</small><br>
							<?php echo $_SESSION['check_out']; ?></h5>
					</div>

				</div><br>
				
				<!-- Book Now -->
				<a href="#listing-pricing-list" class="button book-now fullwidth margin-top-5">Book Now</a>
			</div>
			<!-- Book Now / End -->


			<!-- Coupon Widget
			<div class="coupon-widget" style="background-image: url(http://localhost/listeo_html/images/single-listing-01.jpg);">
				<a href="#" class="coupon-top">
					<span class="coupon-link-icon"></span>
					<h3>Order 1 burger and get 50% off on second!</h3>
					<div class="coupon-valid-untill">Expires 25/10/2019</div>
					<div class="coupon-how-to-use"><strong>How to use?</strong> Just show us this coupon on a screen of your smartphone!</div>
				</a>
				<div class="coupon-bottom">
					<div class="coupon-scissors-icon"></div>
					<div class="coupon-code">L1ST30</div>
				</div>
			</div>  -->

		
			<!-- Opening Hours 
			<div class="boxed-widget opening-hours margin-top-35">
				<div class="listing-badge now-open">Now Open</div>
				<h3><i class="sl sl-icon-clock"></i> Opening Hours</h3>
				<ul>
					<li>Monday <span>9 AM - 5 PM</span></li>
					<li>Tuesday <span>9 AM - 5 PM</span></li>
					<li>Wednesday <span>9 AM - 5 PM</span></li>
					<li>Thursday <span>9 AM - 5 PM</span></li>
					<li>Friday <span>9 AM - 5 PM</span></li>
					<li>Saturday <span>9 AM - 3 PM</span></li>
					<li>Sunday <span>Closed</span></li>
				</ul>
			</div>
			<!-- Opening Hours / End -->


			<!-- Contact -->
			<div class="boxed-widget margin-top-35 tt_info_box" style="background-color:#0055a4;color:white;">
				<div class="hosted-by-title">
					<h4><span>Hosted by</span> <a href=""><?php echo $result['hotels_details_list']['name'];?></a></h4>
					<a href="" class="hosted-by-avatar"><img src="images/dashboard-avatar.jpg" alt=""></a>
				</div>
				<ul class="listing-details-sidebar">
					<li><i class="sl sl-icon-phone"></i> <?php echo $result['hotels_details_list']['phone_number'];?></li>
					<!-- <li><i class="sl sl-icon-globe"></i> <a href="#">http://example.com</a></li> -->
					<li><i class="fa fa-envelope-o"></i> <a href="#"><?php echo $result['hotels_details_list']['email_id'];?></a></li>
				</ul>

				<ul class="listing-details-sidebar social-profiles">
					<li><a href="#" class="facebook-profile"><i class="fa fa-facebook-square"></i> Facebook</a></li>
					<li><a href="#" class="twitter-profile"><i class="fa fa-twitter"></i> Twitter</a></li>
					<!-- <li><a href="#" class="gplus-profile"><i class="fa fa-google-plus"></i> Google Plus</a></li> -->
				</ul>
				<a href="#small-dialog" class="send-message-to-owner button popup-with-zoom-anim"><i class="sl sl-icon-envelope-open"></i> Send Message</a>
			</div>
			<!-- Contact / End-->


			<!-- Share / Like -->
			<div class="listing-share margin-top-40 margin-bottom-40 no-border">
				<button class="like-button"><span class="like-icon"></span> Bookmark this Place</button> 
				<span>159 people bookmarked this place</span>

					<!-- Share Buttons -->
					<ul class="share-buttons margin-top-40 margin-bottom-0">
						<li><a class="fb-share" href="#"><i class="fa fa-facebook"></i> Share</a></li>
						<li><a class="twitter-share" href="#"><i class="fa fa-twitter"></i> Tweet</a></li>
						<li><a class="gplus-share" href="#"><i class="fa fa-google-plus"></i> Share</a></li>
						<!-- <li><a class="pinterest-share" href="#"><i class="fa fa-pinterest-p"></i> Pin</a></li> -->
					</ul>
					<div class="clearfix"></div>
			</div>

		</div>
		<!-- Sidebar / End -->


		<div class="col-lg-12 col-md-12 sticky" id="listing-pricing-list">

			<!-- Rooms -->
			<div id="listing-rooms" class="listing-section">
				<h3 class="listing-desc-headline margin-top-20 margin-bottom-20">Rooms</h3>
	            <div class="theme-item-page-rooms-table _p-30 _bg-w _mb-mob-30">
	              <table class="table tt_tbrooms">
	                <thead>
	                  <tr>
	                    <th>Room type</th>
	                    <th>Max People</th>
	                    <th>Description</th>
	                    <th>Select Guest</th>
	                    <th style="width:200px;">Cart</th>
	                  </tr>
	                </thead>
	                <tbody>
	               <?php
	               	$data = array(
	                'key' => $json_key,
	                'action' => 'hotel_rooms',
	                'room_id' =>'0',
	                'hotel_id' => $result['hotels_details_list']['hotel_id'],
	                'check_in' => $_SESSION['check_in'],
	                'check_out' => $_SESSION['check_out'],
	                'sort' => 'ASC',
	                'limit_st' => '0',
	                'limit_cnt' => '0'
	                );
	                $rooms_result = call_json($data);
	                $ntd = 0;
	                foreach($rooms_result['hotel_room_list'] as $key => $value)
	                {
	                	$ntd++;
                    ?>
                        <div class="modal fade" id="myModal_room_<?php echo $rooms_result['hotel_room_list'][$key]['room_id']; ?>" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title"><?php echo $rooms_result['hotel_room_list'][$key]['name']; ?> Images</h4>
                                </div>
                                <div class="modal-body">
                                  <ul class="gallery">
                                    <?php
                                    foreach($rooms_result['hotel_room_list'][$key]['hotel_room_images'] as $ivalue)
                        			{
                        				?>
                        				<li><a href="<?php echo $ivalue['room_image'];?>"><img src="<?php echo $ivalue['room_image'];?>" alt="Image"></a></li>
                        				<?php
                        			}
                        			?>
                                  </ul>
                                  <div class="clearfix"></div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          
	                  <tr>
	                    <td class="theme-item-page-rooms-table-type">
	                      <div class="room-bg"><h4 class="theme-item-page-rooms-table-type-title"><?php echo $rooms_result['hotel_room_list'][$key]['name']; ?></h4></div>
	                      
	                      <main class="tt_gallery gallery">
                            <?php
                            $oimg = 0;
                            foreach($rooms_result['hotel_room_list'][$key]['hotel_room_images'] as $ivalue)
	                        {
                				$oimg++
                				?>
                				<div class="<?php if($oimg == 1) echo "tbig"; if($oimg == 5) echo "tlast"; ?>">
                				    <?php
                				    if($oimg == 5)
                				    {
                				        ?>
                				        <button href="#" data-toggle="modal" data-target="#myModal_room_<?php echo $rooms_result['hotel_room_list'][$key]['room_id']; ?>");">View More</button>
                				        <?php
                				        break;
                				    }
                				    else
                				    {
                				        //if(file_exists($ivalue['room_image']))
                				        //{
                    				        ?>
                    				        <a href="<?php echo $ivalue['room_image'];?>"><img src="<?php echo $ivalue['room_image'];?>" onerror="this.src='images/room_blur.jpg';"></a>
                    				        <?php
                				        //}
                				    }
                				    ?>
                			    </div>
                				<?php
                			}
                			?>
                			<!--<div class="big"><img src="images/rooms/g14.webp" alt=""></div>
                			<div><img src="images/rooms/g15.webp" alt=""></div>
                			<div><img src="images/rooms/g16.webp" alt=""></div>	
                			<div><img src="images/rooms/g21.webp" alt=""></div>
                			<div><img src="images/rooms/g23.webp" alt=""></div>-->
                		  </main>
		
	                      <?php
	                      /*foreach($rooms_result['hotel_room_list'][$key]['hotel_room_images'] as $ivalue)
	                      {
	                          ?>
		                      <img class="tt_img" src="<?php echo $ivalue['room_image'];?>">
		                      <?php
	                      }*/
	                      ?>
	                      <ul class="tt_list2">
	                        <?php
	                        foreach($rooms_result['hotel_room_list'][$key]['hotel_room_facilities'] as $rvalue)
	                        {
	                          ?>
	                          <li> 
	                            <img src="images/facility/small/<?php echo $rvalue['icon_image'];?>" class="tips" style="width:17px;"> <?php echo $rvalue['name'];?>
	                          </li>
	                          <?php
	                        }
	                        ?>
	                      </ul>
	                    </td>
	                    <td>
	                        <span>Adults:</span>
	                        <ul class="tt_list">
    	                      <?php
    	                      echo $rooms_result['hotel_room_list'][$key]['max_adults'];
    	                      for($i=1;$i<=$rooms_result['hotel_room_list'][$key]['max_adults'];$i++)
    	                      {
    	                          //echo '<li><i class="fa fa-male"></i></li>';
    	                      }
    	                      ?>
    	                    </ul>
    	                    <span>Childerns:</span>
    	                    <ul class="tt_list">
    	                      <?php
    	                      echo $rooms_result['hotel_room_list'][$key]['max_childerns'];
    	                      for($i=1;$i<=$rooms_result['hotel_room_list'][$key]['max_childerns'];$i++)
    	                      {
    	                          //echo '<li><i class="fa fa-child"></i></li>';
    	                      }
    	                      ?>
    	                    </ul>
    	                    <span>Min-Max People:</span>
    	                    <ul class="tt_list">
	                            <?php echo $rooms_result['hotel_room_list'][$key]['min_people']."-".$rooms_result['hotel_room_list'][$key]['max_people']; ?>
	                        </ul>
	                    </td>
	                    <td>
	                      <p>
	                      <?php echo $rooms_result['hotel_room_list'][$key]['short_description']; ?>
	                      </p>
	                    </td>
	                    <td>
	                    	<form method="post" id="add_to_cart_form">
	                    		<input type="hidden" name="action" value="add_to_cart">
	                    		<input type="hidden" name="hotel_id" value="<?php echo $rooms_result['hotel_room_list'][$key]['hotel_id']; ?>">
	                    		<input type="hidden" name="room_id" value="<?php echo $rooms_result['hotel_room_list'][$key]['room_id']; ?>">
		                    	<a href="#" id="dropdownMenuButton"><span class="qtyTotal" ></span></a>
		                    	<div class="qtyButtons">
    								<div class="qtyTitle">Adults</div>
    								<input type="number" class="sadults" name="adults" value="1">
    							</div>
    							<div class="qtyButtons">
    								<div class="qtyTitle">Childrens</div>
    								<input type="text" class="schilderns" name="childerns" value="0">
    							</div>
    							<div>
    								<div>
    									<p>₹<?php echo $rooms_result['hotel_room_list'][$key]['final_cost']; ?> 
    										<span style="text-decoration: line-through;display:inline-block;">₹<?php echo $rooms_result['hotel_room_list'][$key]['actual_cost']; ?></span> / Per night</p>
    								</div>
    							</div>
    							<?php
    							$arr = array_count_values($_SESSION['room_id']);
    							$room_id = $rooms_result['hotel_room_list'][$key]['room_id'];
    							if($rooms_result['hotel_room_list'][$key]['available_room_count'] > $arr[$room_id])
    							{
    							    ?>
    							    <button type="submit" name="add_to_cart" class="btn btn-primary-inverse btn-block tt_abtn">+ Add this room</button>
    							    <?php
    							}
    							else
    							{
    							    ?>
    							    <button type="button" style="background:#c3c3c3;cursor:default;" class="btn btn-primary-inverse btn-block tt_abtn">Not Available</button>
    							    <?php
    							}
    							?>
    						</form>
	                  	</td>
	                  	<?php
	                  	if($ntd == 1)
	                  	{
	                  		?>
		                    <td id="cart_td" rowspan="<?php echo count($rooms_result['hotel_room_list']); ?>">
		                    </td>
		                    <?php
		                }
		                ?>
	                  </tr>
	                  <?php
	                  }
	                  ?>
	                </tbody>
	              </table>
	            </div>
	        </div>
				
			<!-- Reviews -->
			<div id="listing-reviews" class="listing-section">
				<h3 class="listing-desc-headline margin-top-75 margin-bottom-20">Reviews <span>(<?php echo $result['hotels_details_list']['review_count']; ?>)</span></h3>

				<?php
				if($result['hotels_details_list']['review_count'] != 0)
				{
					?>
				<!-- Rating Overview -->
					<div class="rating-overview">
						<div class="rating-overview-box">
							<span class="rating-overview-box-total"><?php echo $result['hotels_details_list']['rating']; ?></span>
							<span class="rating-overview-box-percent">out of 5.0</span>
							<div class="star-rating" data-rating="<?php echo $result['hotels_details_list']['rating']; ?>"></div>
						</div>
						<div class="rating-bars">
							<?php
    						$data = array(
                            'key' => $json_key,
                            'action' => 'hotel_rating_summary',
                            'hotel_id' => $result['hotels_details_list']['hotel_id']
            	            );
            	            $rating_sum_result = call_json($data);
            	            foreach($rating_sum_result['hotel_rating_summary'] as $key => $value)
            	            {
                                ?>
    							<div class="rating-bars-item">
    								<span class="rating-bars-name">Rating <?php echo $rating_sum_result['hotel_rating_summary'][$key]['rating']; ?> <i class="tip" data-tip-content="Total rated customers <?php echo $rating_sum_result['hotel_rating_summary'][$key]['rating_count']; ?>"></i></span>
    								<span class="rating-bars-inner">
    									<span class="rating-bars-rating" data-rating="<?php echo $rating_sum_result['hotel_rating_summary'][$key]['avg_rating']; ?>">
    										<span class="rating-bars-rating-inner"></span>
    									</span>
    									<strong><?php echo $rating_sum_result['hotel_rating_summary'][$key]['avg_rating']; ?></strong>
    								</span>
    							</div>
    							<?php
            				}
            				?>
							<!--
							<div class="rating-bars-item">
								<span class="rating-bars-name">Value for Money <i class="tip" data-tip-content="Overall experience received for the amount spent"></i></span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating" data-rating="3.8">
										<span class="rating-bars-rating-inner"></span>
									</span>
									<strong>3.8</strong>
								</span>
							</div>
							<div class="rating-bars-item">
								<span class="rating-bars-name">Location <i class="tip" data-tip-content="Visibility, commute or nearby parking spots"></i></span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating" data-rating="2.7">
										<span class="rating-bars-rating-inner"></span>
									</span>
									<strong>2.7</strong>
								</span>
							</div>
							<div class="rating-bars-item">
								<span class="rating-bars-name">Cleanliness <i class="tip" data-tip-content="The physical condition of the business"></i></span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating" data-rating="5.0">
										<span class="rating-bars-rating-inner"></span>
									</span>
									<strong>5.0</strong>
								</span>
							</div>-->
						</div>
					</div>
					<!-- Rating Overview / End -->
					<div class="clearfix"></div>
					<?php
				}
				?>

				<!-- Reviews -->
				<section class="comments listing-reviews">
					<ul>
					<?php
    	            $data = array(
                    'key' => $json_key,
                    'action' => 'hotel_rating',
                    'hotel_id' => $result['hotels_details_list']['hotel_id'],
                    'sort' => 'DSC',
                    'limit_st' => '0',
                    'limit_cnt' => '0',
    	            );
    	            $rating_result = call_json($data);
    	            foreach($rating_result['hotel_rating_list'] as $key => $value)
    	            {
    	            	?>
							<li>
								<div class="avatar"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&amp;s=70" alt="" /> </div>
								<div class="comment-content"><div class="arrow-comment"></div>
									<div class="comment-by"><?php echo $rating_result['hotel_rating_list'][$key]['name'];?><span class="date"><?php echo $rating_result['hotel_rating_list'][$key]['created_at'];?></span>
										<div class="star-rating" data-rating="<?php echo $rating_result['hotel_rating_list'][$key]['rating'];?>"></div>
									</div>
									<p><?php echo $rating_result['hotel_rating_list'][$key]['comment'];?></p>
									<!--<a href="#" class="rate-review"><i class="sl sl-icon-like"></i> Helpful Review <span>2</span></a>-->
								</div>
							</li>
							<?php
						}
						?>
					 </ul>
				</section>

				<!--
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12">
						<div class="pagination-container margin-top-30">
							<nav class="pagination">
								<ul>
									<li><a href="#" class="current-page">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#"><i class="sl sl-icon-arrow-right"></i></a></li>
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				-->

			</div>

			<!-- Add Review Box -->
			<div id="add-review" class="add-review-box">
				<!-- Add Review -->
				<h3 class="listing-desc-headline margin-bottom-10">Add Review</h3>
				<p class="comment-notes">Your email address will not be published.</p>

				<form method="post">
					<!-- Subratings Container -->
					<div class="sub-ratings-container">
						<!--
						<div class="add-sub-rating">
							<div class="sub-rating-title">Service <i class="tip" data-tip-content="Quality of customer service and attitude to work with you"></i></div>
							<div class="sub-rating-stars">
								<div class="clearfix"></div>
								<form class="leave-rating">
									<input type="radio" name="rating" id="rating-1" value="1"/>
									<label for="rating-1" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-2" value="2"/>
									<label for="rating-2" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-3" value="3"/>
									<label for="rating-3" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-4" value="4"/>
									<label for="rating-4" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-5" value="5"/>
									<label for="rating-5" class="fa fa-star"></label>
								</form>
							</div>
						</div>

						<div class="add-sub-rating">
							<div class="sub-rating-title">Value for Money <i class="tip" data-tip-content="Overall experience received for the amount spent"></i></div>
							<div class="sub-rating-stars">
								<div class="clearfix"></div>
								<form class="leave-rating">
									<input type="radio" name="rating" id="rating-11" value="1"/>
									<label for="rating-11" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-12" value="2"/>
									<label for="rating-12" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-13" value="3"/>
									<label for="rating-13" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-14" value="4"/>
									<label for="rating-14" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-15" value="5"/>
									<label for="rating-15" class="fa fa-star"></label>
								</form>
							</div>
						</div>

						<div class="add-sub-rating">
							<div class="sub-rating-title">Location <i class="tip" data-tip-content="Visibility, commute or nearby parking spots"></i></div>
							<div class="sub-rating-stars">
								<div class="clearfix"></div>
								<form class="leave-rating">
									<input type="radio" name="rating" id="rating-21" value="1"/>
									<label for="rating-21" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-22" value="2"/>
									<label for="rating-22" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-23" value="3"/>
									<label for="rating-23" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-24" value="4"/>
									<label for="rating-24" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-25" value="5"/>
									<label for="rating-25" class="fa fa-star"></label>
								</form>
							</div>
						</div>

						<div class="add-sub-rating">
							<div class="sub-rating-title">Cleanliness <i class="tip" data-tip-content="The physical condition of the business"></i></div>
							<div class="sub-rating-stars">
								<div class="clearfix"></div>
								<form class="leave-rating">
									<input type="radio" name="rating" id="rating-31" value="1"/>
									<label for="rating-31" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-32" value="2"/>
									<label for="rating-32" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-33" value="3"/>
									<label for="rating-33" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-34" value="4"/>
									<label for="rating-34" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-35" value="5"/>
									<label for="rating-35" class="fa fa-star"></label>
								</form>
							</div>
						</div>-->

						<div class="add-sub-rating">
							<div class="sub-rating-title">Rating</div>
							<div class="sub-rating-stars">
								<div class="clearfix"></div>
								<div class="leave-rating">
									<input type="radio" name="rating" id="rating-31" value="5"/>
									<label for="rating-31" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-32" value="4"/>
									<label for="rating-32" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-33" value="3"/>
									<label for="rating-33" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-34" value="2"/>
									<label for="rating-34" class="fa fa-star"></label>
									<input type="radio" name="rating" id="rating-35" value="1"/>
									<label for="rating-35" class="fa fa-star"></label>
								</div>
							</div>
						</div>
						<!--
		                <div class="uploadButton margin-top-15">
		                    <input class="uploadButton-input" type="file"  name="attachments[]" accept="image/*, application/pdf" id="upload" multiple/>
		                    <label class="uploadButton-button ripple-effect" for="upload">Add Photos</label>
		                    <span class="uploadButton-file-name"></span>
		                </div>-->
					</div>
					<!-- Subratings Container / End -->

					<!-- Review Comment -->
					<div id="add-comment" class="add-comment">
						<fieldset>

							<div class="row">
								<div class="col-md-6">
									<label>Name:</label>
									<input type="text" name="name" autocomplete="off" placeholder="Name" required/>
								</div>
									
								<div class="col-md-6">
									<label>Email:</label>
									<input type="text" name="email" autocomplete="off" placeholder="Email Id" required/>
								</div>
							</div>

							<div>
								<label>Review:</label>
								<textarea cols="40" rows="3" name="comment" autocomplete="off" placeholder="Enter Your Review !!"></textarea>
							</div>

						</fieldset>

						<button class="button" type="submit" name="add_review">Submit Review</button>
						<div class="clearfix"></div>
					</div>
				</form>

			</div>
			<!-- Add Review Box / End -->

		</div>

	</div>
</div>


<?php include_once('footer.php'); ?>
<script type="text/javascript">
<?php
if(isset($_SESSION['hotel_id']))
{
	if($_SESSION['hotel_id'] == $rooms_result['hotel_room_list'][$key]['hotel_id'])
	{
		?>
		view_cart();
		<?php
	}
}
?>
$(document).ready(function (){	
	$(document).on('submit','#add_to_cart_form', function(event){
		//alert();
		event.preventDefault();
		$('#add_to_cart').attr('disabled', 'disabled');
		var formData = new FormData(this);					
		$.ajax({
			url: "ajax_cart_actions.php",
			method: "POST",
			data:formData,
			cache:false,
			contentType: false,
			async: false,
			processData: false,				
			success:function(response)
			{	
				if(response == 1)
					view_cart();
				else if(response == 2)
				{
				    Swal.fire({
                      icon: 'info',
                      title: 'Oops...',
                      text: 'Room not available!'
                    })
					view_cart();
				}
				else
				{
                    Swal.fire({
                      icon: 'info',
                      title: 'Oops...',
                      text: 'Please check max Adults & Childrens!'
                    })
				}
			},
			error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
		});
	});
});	
function delete_cart(key)
{
	var action = "delete_cart";
	$.ajax({
		url: "ajax_cart_actions.php",
		method: "POST",
		data:{action:action,key:key},			
		success:function(response)
		{				
			view_cart();
		},
		error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
	});
}
function view_cart(key)
{
	var action = "view_cart";
	$.ajax({
		url: "ajax_cart_actions.php",
		method: "POST",
		data:{action:action},			
		success:function(response)
		{				
			$('#cart_td').html(response);
			$('#cart_mobile').html(response);
		},
		error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
	});
}
</script>


<script>
	let map;

function initMap() {
  	
	const uluru = { lat: 12.859673460038564, lng: 80.24604230331109 };
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 18,
    center: uluru,
  });
  
   const iconBase =
    "http://localhost/ecrcheckin/theme/images/";
  const icons = {
    parking: {
      icon: iconBase + "logomap.png",
    },
    library: {
      icon: iconBase + "logomap.png",
    },
    info: {
      icon: iconBase + "logomap.png",
    },
  };
   
  const contentString =
    '<div id="content">' +
    '<div id="siteNotice">' +
    "</div>" +
    '<h1 id="firstHeading" class="firstHeading">Uluru</h1>' +
    '<div id="bodyContent">' +
    "<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large " +
    "sandstone rock formation in the southern part of the " +
    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
    "south west of the nearest large town, Alice Springs; 450&#160;km " +
    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
    "Aboriginal people of the area. It has many springs, waterholes, " +
    "rock caves and ancient paintings. Uluru is listed as a World " +
    "Heritage Site.</p>" +
    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
    "(last visited June 22, 2009).</p>" +
    "</div>" +
    "</div>";
  const infowindow = new google.maps.InfoWindow({
    content: contentString,
  });
  const marker = new google.maps.Marker({
    position: uluru,
    map,
    title: "Uluru (Ayers Rock)",
	 
  });
  marker.addListener("click", () => {
    infowindow.open(map, marker);
  });
  
  const features = [
    {
      position: uluru,
	  map,
      type: "info",
	  title: "Uluru (Ayers Rock)",
    },
  ];
  
  
  // Create markers.
  for (let i = 0; i < features.length; i++) {
    const marker = new google.maps.Marker({
      position: features[i].position,
      icon: icons[features[i].type].icon,
      map: map,
    });
  }
}

	
	</script>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBD3V_9X325l3uJqI0Lg_IoO5Y9xzp2vUE&callback=initMap&libraries=&v=weekly"
      async
    ></script>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

<!-- Booking Sticky Footer -->
<div class="booking-sticky-footer">
	<div class="container" id="cart_mobile">
	    <!--
		<div class="bsf-left">
			<h4>Starting from $29</h4>
			<div class="star-rating" data-rating="5">
				<div class="rating-counter"></div>
			</div>
		</div>
		<div class="bsf-right">
			<a href="#booking-widget-anchor" class="button">Book Now</a>
		</div>-->
	</div>
</div>

</div>
<!-- Wrapper / End -->



<!-- Booking Widget - Quantity Buttons -->
<script src="scripts/quantityButtons.js"></script>

<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
<script src="scripts/moment.min.js"></script>
<script src="scripts/daterangepicker.js"></script>
<script>
// Calendar Init
$(function() {
	$('#date-picker').daterangepicker({
		"opens": "left",
		singleDatePicker: true,

		// Disabling Date Ranges
		isInvalidDate: function(date) {
		// Disabling Date Range
		var disabled_start = moment('09/02/2018', 'MM/DD/YYYY');
		var disabled_end = moment('09/06/2018', 'MM/DD/YYYY');
		return date.isAfter(disabled_start) && date.isBefore(disabled_end);

		// Disabling Single Day
		// if (date.format('MM/DD/YYYY') == '08/08/2018') {
		//     return true; 
		// }
		}
	});
});

// Calendar animation
$('#date-picker').on('showCalendar.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-animated');
});
$('#date-picker').on('show.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-visible');
	$('.daterangepicker').removeClass('calendar-hidden');
});
$('#date-picker').on('hide.daterangepicker', function(ev, picker) {
	$('.daterangepicker').removeClass('calendar-visible');
	$('.daterangepicker').addClass('calendar-hidden');
});
</script>


<!-- Replacing dropdown placeholder with selected time slot -->
<script>
$(".time-slot").each(function() {
	var timeSlot = $(this);
	$(this).find('input').on('change',function() {
		var timeSlotVal = timeSlot.find('strong').text();

		$('.panel-dropdown.time-slots-dropdown a').html(timeSlotVal);
		$('.panel-dropdown').removeClass('active');
	});
});
</script>


</body>
</html>