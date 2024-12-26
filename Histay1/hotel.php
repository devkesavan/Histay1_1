<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Listeo</title>
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
</header>
<div class="clearfix"></div>
<!-- Header Container / End -->


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
						<a href="#" class="prev">&lt;</a>
						<a href="#" class="next">&gt;</a>
						<main class="container-gallery gallery">
							<div class="big"><img src="images/rooms/g14.webp" alt=""></div>
							<div><img src="images/rooms/g15.webp" alt=""></div>
							<div><img src="images/rooms/g16.webp" alt=""></div>	
							<div><img src="images/rooms/g21.webp" alt=""></div>
							<div><img src="images/rooms/g23.webp" alt=""></div>								
						</main>
					<div style="float:right; padding-top:2px;"><a href="#"><button class="btn-banner-no-border slide-in-bottom "><span>View Gallery</span></button></a></div>
					</div>



<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">
		<div class="col-lg-8 col-md-8 padding-right-30">

			<!-- Titlebar -->
			<div id="titlebar" class="listing-titlebar">
				<div class="listing-titlebar-title">
					<h2>Hotel Nakshathira <span class="listing-tag">New</span></h2>
					<span>
						<a href="#listing-location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							NO.37, Nakshatra Enclave, Gopinath Layout,87/3, Amet Opposite, Kanathur, <br>Chennai 603103 
						
						</a>
					</span>
					<div class="star-rating" data-rating="5">
						<div class="rating-counter"><a href="#listing-reviews">(31 reviews)</a></div>
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

				<p>
		Nakshatra is an excellent choice for travellers visiting Chennai (Madras), offering a budget friendly environment alongside many helpful amenities designed to enhance your stay.
<br><br>
While staying at Nakshatra, visitors can check out Tirumala Tirupathi Devasthanam (1.3 mi) and Kapaleeshwar Temple (1.6 mi), some of Chennai (Madras)'s top attractions.
<br><br>
As your “home away from home,” the hotel rooms offer air conditioning and a refrigerator, and getting online is easy, with wifi available.
<br><br>
Guests have access to room service and a concierge while staying at Nakshatra. In addition, Nakshatra offers an on-site restaurant, which will help make your Chennai (Madras) trip additionally gratifying.
<br><br>
If you’re looking for a French restaurant, consider a visit to The Baker Ninja, Old Madras Baking Company, or Amelie's, which are all conveniently located a short distance from Nakshatra.
<br><br>
Best of all, Nakshatra makes it easy to experience many great Chennai (Madras) attractions like San Thome Church, Chennai Central Railway Station, and Sri Ramakrishna Math, which are some popular architectural buildings.
<br><br>
Enjoy your stay in Chennai (Madras)!
				</p>
				
				<div class="clearfix"></div>


				<!-- Amenities -->
				<h3 class="listing-desc-headline">Amenities</h3>
				<ul class="listing-features margin-top-0">
					   
     <li> <i class="fa fa-cutlery"></i> Elevator in building</li>
				 <li> <i class="fa fa-coffee"></i> Friendly workspace</li>
				 <li> <i class="fa fa-binoculars"></i> Instant Book</li>
				 <li> <i class="fa fa-wifi"></i> Wireless Internet</li>
				 <li> <i class="fa fa-car"></i> Free parking on premises</li>
				 <li> <i class="fa fa-black-tie"></i> Free parking on street</li>
				</ul>
			</div>


			<!-- Food Menu -->
			<div id="listing-pricing-list" class="listing-section">
				<h3 class="listing-desc-headline margin-top-70 margin-bottom-30">Rooms & Categories</h3>

				<div class="show-more">
					
				</div>
				<a href="#" class="show-more-button" data-more-title="Show More" data-less-title="Show Less"><i class="fa fa-angle-down"></i></a>
			</div>
			<!-- Food Menu / End -->

		
			<!-- Location -->
			<div id="listing-location" class="listing-section">
				<h3 class="listing-desc-headline margin-top-60 margin-bottom-30">Location</h3>

				<div id="singleListingMap-container">
					<!--<div id="singleListingMap" data-latitude="40.70437865245596" data-longitude="-73.98674011230469" data-map-icon="im im-icon-Hamburger"></div>
					<a href="#" id="streetView">Street View</a> -->
					
					<!-- Map -->
		<div id="map-container1">
		    <!-- <div id="map" class="map" data-map-zoom="9" data-map-scroll="true">
		        map goes here -->  <div id="map"></div>
		    </div>
				</div>
			</div>
				
			<!-- Reviews -->
			<div id="listing-reviews" class="listing-section">
				<h3 class="listing-desc-headline margin-top-75 margin-bottom-20">Reviews <span>(12)</span></h3>

				<!-- Rating Overview -->
				<div class="rating-overview">
					<div class="rating-overview-box">
						<span class="rating-overview-box-total">4.2</span>
						<span class="rating-overview-box-percent">out of 5.0</span>
						<div class="star-rating" data-rating="5"></div>
					</div>

					<div class="rating-bars">
							<div class="rating-bars-item">
								<span class="rating-bars-name">Service <i class="tip" data-tip-content="Quality of customer service and attitude to work with you"></i></span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating" data-rating="4.2">
										<span class="rating-bars-rating-inner"></span>
									</span>
									<strong>4.2</strong>
								</span>
							</div>
							<div class="rating-bars-item">
								<span class="rating-bars-name">Value for Money <i class="tip" data-tip-content="Overall experience received for the amount spent"></i></span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating" data-rating="4.8">
										<span class="rating-bars-rating-inner"></span>
									</span>
									<strong>4.8</strong>
								</span>
							</div>
							<div class="rating-bars-item">
								<span class="rating-bars-name">Location <i class="tip" data-tip-content="Visibility, commute or nearby parking spots"></i></span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating" data-rating="3.7">
										<span class="rating-bars-rating-inner"></span>
									</span>
									<strong>3.7</strong>
								</span>
							</div>
							<div class="rating-bars-item">
								<span class="rating-bars-name">Cleanliness <i class="tip" data-tip-content="The physical condition of the business"></i></span>
								<span class="rating-bars-inner">
									<span class="rating-bars-rating" data-rating="4.0">
										<span class="rating-bars-rating-inner"></span>
									</span>
									<strong>4.0</strong>
								</span>
							</div>
					</div>
				</div>
				<!-- Rating Overview / End -->


				<div class="clearfix"></div>

				<!-- Reviews -->
				<section class="comments listing-reviews">
					<ul>
						<li>
							<div class="avatar"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&amp;s=70" alt="" /> </div>
							<div class="comment-content"><div class="arrow-comment"></div>
								<div class="comment-by">John Doe<span class="date">May 2019</span>
									<div class="star-rating" data-rating="5"></div>
								</div>
								<p>Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit enim. Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis quis nunc tellus sollicitudin mauris.</p>
								<a href="#" class="rate-review"><i class="sl sl-icon-like"></i> Helpful Review</a>
							</div>

						</li>
					 </ul>
				</section>

				
			</div>


			<!-- Add Review Box -->
			<div id="add-review" class="add-review-box">

				<!-- Add Review -->
				<h3 class="listing-desc-headline margin-bottom-10">Add Review</h3>
				<p class="comment-notes">Your email address will not be published.</p>

				<!-- Subratings Container -->
				<div class="sub-ratings-container">

					<!-- Subrating #1 -->
					<div class="add-sub-rating">
						<div class="sub-rating-title">Service <i class="tip" data-tip-content="Quality of customer service and attitude to work with you"></i></div>
						<div class="sub-rating-stars">
							<!-- Leave Rating -->
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

					<!-- Subrating #2 -->
					<div class="add-sub-rating">
						<div class="sub-rating-title">Value for Money <i class="tip" data-tip-content="Overall experience received for the amount spent"></i></div>
						<div class="sub-rating-stars">
							<!-- Leave Rating -->
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

					<!-- Subrating #3 -->
					<div class="add-sub-rating">
						<div class="sub-rating-title">Location <i class="tip" data-tip-content="Visibility, commute or nearby parking spots"></i></div>
						<div class="sub-rating-stars">
							<!-- Leave Rating -->
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
					
					<!-- Subrating #4 -->
					<div class="add-sub-rating">
						<div class="sub-rating-title">Cleanliness <i class="tip" data-tip-content="The physical condition of the business"></i></div>
						<div class="sub-rating-stars">
							<!-- Leave Rating -->
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
					</div>	

					<!-- Uplaod Photos -->
	                <div class="uploadButton margin-top-15">
	                    <input class="uploadButton-input" type="file"  name="attachments[]" accept="image/*, application/pdf" id="upload" multiple/>
	                    <label class="uploadButton-button ripple-effect" for="upload">Add Photos</label>
	                    <span class="uploadButton-file-name"></span>
	                </div>
	                <!-- Uplaod Photos / End -->

				</div>
				<!-- Subratings Container / End -->

				<!-- Review Comment -->
				<form id="add-comment" class="add-comment">
					<fieldset>

						<div class="row">
							<div class="col-md-6">
								<label>Name:</label>
								<input type="text" value=""/>
							</div>
								
							<div class="col-md-6">
								<label>Email:</label>
								<input type="text" value=""/>
							</div>
						</div>

						<div>
							<label>Review:</label>
							<textarea cols="40" rows="3"></textarea>
						</div>

					</fieldset>

					<button class="button">Submit Review</button>
					<div class="clearfix"></div>
				</form>

			</div>
			<!-- Add Review Box / End -->


		</div>


		<!-- Sidebar
		================================================== -->
		<div class="col-lg-4 col-md-4 margin-top-75 sticky">

				
			<!-- Verified Badge -->
			<div class="verified-badge with-tip" data-tip-content="Listing has been verified and belongs the business owner or manager.">
				<i class="sl sl-icon-check"></i> Verified Listing
			</div>

			<!-- Book Now -->
			<div id="booking-widget-anchor" class="boxed-widget booking-widget margin-top-35">
				<h3><i class="fa fa-calendar-check-o "></i> Booking</h3>
				<div class="row with-forms  margin-top-0">

					<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
					<div class="col-lg-12">
						<input type="text" id="date-picker" placeholder="Date" readonly="readonly">
					</div>

					<!-- Panel Dropdown -->
					<div class="col-lg-12">
						<div class="panel-dropdown time-slots-dropdown">
							<a href="#">Time Slots</a>
							<div class="panel-dropdown-content padding-reset">
								<div class="panel-dropdown-scrollable">
									
									<!-- Time Slot -->
									<div class="time-slot">
										<input type="radio" name="time-slot" id="time-slot-1">
										<label for="time-slot-1">
											<strong>8:30 am - 9:00 am</strong>
											<span>1 slot available</span>
										</label>
									</div>

									<!-- Time Slot -->
									<div class="time-slot">
										<input type="radio" name="time-slot" id="time-slot-2">
										<label for="time-slot-2">
											<strong>9:00 am - 9:30 am</strong>
											<span>2 slots available</span>
										</label>
									</div>

									<!-- Time Slot -->
									<div class="time-slot">
										<input type="radio" name="time-slot" id="time-slot-3">
										<label for="time-slot-3">
											<strong>9:30 am - 10:00 am</strong>
											<span>1 slots available</span>
										</label>
									</div>

									<!-- Time Slot -->
									<div class="time-slot">
										<input type="radio" name="time-slot" id="time-slot-4">
										<label for="time-slot-4">
											<strong>10:00 am - 10:30 am</strong>
											<span>3 slots available</span>
										</label>
									</div>

									<!-- Time Slot -->
									<div class="time-slot">
										<input type="radio" name="time-slot" id="time-slot-5">
										<label for="time-slot-5">
											<strong>13:00 pm - 13:30 pm</strong>
											<span>2 slots available</span>
										</label>
									</div>

									<!-- Time Slot -->
									<div class="time-slot">
										<input type="radio" name="time-slot" id="time-slot-6">
										<label for="time-slot-6">
											<strong>13:30 pm - 14:00 pm</strong>
											<span>1 slots available</span>
										</label>
									</div>

									<!-- Time Slot -->
									<div class="time-slot">
										<input type="radio" name="time-slot" id="time-slot-7">
										<label for="time-slot-7">
											<strong>14:00 pm - 14:30 pm</strong>
											<span>1 slots available</span>
										</label>
									</div>

								</div>
							</div>
						</div>
					</div>
					<!-- Panel Dropdown / End -->

					<!-- Panel Dropdown -->
					<div class="col-lg-12">
						<div class="panel-dropdown">
							<a href="#">Guests <span class="qtyTotal" name="qtyTotal">1</span></a>
							<div class="panel-dropdown-content">

								<!-- Quantity Buttons -->
								<div class="qtyButtons">
									<div class="qtyTitle">Adults</div>
									<input type="text" name="qtyInput" value="1">
								</div>

								<div class="qtyButtons">
									<div class="qtyTitle">Childrens</div>
									<input type="text" name="qtyInput" value="0">
								</div>

							</div>
						</div>
					</div>
					<!-- Panel Dropdown / End -->

				</div>
				
				<!-- Book Now -->
				<a href="pages-booking.html" class="button book-now fullwidth margin-top-5">Request To Book</a>
			</div>
			<!-- Book Now / End -->


			<!-- Coupon Widget -->
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
			</div>

		
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
			<div class="boxed-widget margin-top-35" style="background-color:#0055a4;color:white;">
				<div class="hosted-by-title">
					<h4><span>Hosted by</span> <a href="pages-user-profile.html">Tom Perrin</a></h4>
					<a href="pages-user-profile.html" class="hosted-by-avatar"><img src="images/dashboard-avatar.jpg" alt=""></a>
				</div>
				<ul class="listing-details-sidebar">
					<li><i class="sl sl-icon-phone"></i> (123) 123-456</li>
					<!-- <li><i class="sl sl-icon-globe"></i> <a href="#">http://example.com</a></li> -->
					<li><i class="fa fa-envelope-o"></i> <a href="#">tom@example.com</a></li>
				</ul>

				<ul class="listing-details-sidebar social-profiles">
					<li><a href="#" class="facebook-profile"><i class="fa fa-facebook-square"></i> Facebook</a></li>
					<li><a href="#" class="twitter-profile"><i class="fa fa-twitter"></i> Twitter</a></li>
					<!-- <li><a href="#" class="gplus-profile"><i class="fa fa-google-plus"></i> Google Plus</a></li> -->
				</ul>

				<!-- Reply to review popup -->
				<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
					<div class="small-dialog-header">
						<h3>Send Message</h3>
					</div>
					<div class="message-reply margin-top-0">
						<textarea cols="40" rows="3" placeholder="Your message to Tom"></textarea>
						<button class="button">Send Message</button>
					</div>
				</div>

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

	</div>
</div>


<?php include_once('footer.php'); ?>

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
	<div class="container">
		<div class="bsf-left">
			<h4>Starting from $29</h4>
			<div class="star-rating" data-rating="5">
				<div class="rating-counter"></div>
			</div>
		</div>
		<div class="bsf-right">
			<a href="#booking-widget-anchor" class="button">Book Now</a>
		</div>
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