<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Book your Stay</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/main-color.css" id="colors">

<!--<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>-->
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


<!-- Content
================================================== -->
<div class="fs-container">

	<div class="fs-inner-container content">
		<div class="fs-content">

			<!-- Search -->
			<section class="search">

				<div class="row">
					<div class="col-md-12">

							<!-- Row With Forms -->
							<div class="row with-forms">

								<!-- Main Search Input -->
								<div class="col-fs-6">
									<div class="input-with-icon">
										<i class="sl sl-icon-magnifier"></i>
										<input type="text" placeholder="What are you looking for?" value=""/>
									</div>
								</div>

								<!-- Main Search Input -->
								<div class="col-fs-6">
									<div class="input-with-icon location">
										<div id="autocomplete-container">
											<input id="autocomplete-input" type="text" placeholder="Location">
										</div>
										<a href="#"><i class="fa fa-map-marker"></i></a>
									</div>
								</div>
						

								<!-- Filters -->
								<div class="col-fs-12">

									<!-- Panel Dropdown / End -->
									<div class="panel-dropdown">
										<a href="#">Categories</a>
										<div class="panel-dropdown-content checkboxes categories">
											
											<!-- Checkboxes -->
											<div class="row">
												<div class="col-md-6">
													<input id="check-1" type="checkbox" name="check" checked class="all">
													<label for="check-1">All Categories</label>

													<input id="check-2" type="checkbox" name="check">
													<label for="check-2">Shops</label>

													<input id="check-3" type="checkbox" name="check">
													<label for="check-3">Hotels</label>
												</div>	

												<div class="col-md-6">
													<input id="check-4" type="checkbox" name="check" >
													<label for="check-4">Eat & Drink</label>

													<input id="check-5" type="checkbox" name="check">
													<label for="check-5">Fitness</label>	

													<input id="check-6" type="checkbox" name="check">
													<label for="check-6">Events</label>
												</div>
											</div>
											
											<!-- Buttons -->
											<div class="panel-buttons">
												<button class="panel-cancel">Cancel</button>
												<button class="panel-apply">Apply</button>
											</div>

										</div>
									</div>
									<!-- Panel Dropdown / End -->

									<!-- Panel Dropdown -->
									<div class="panel-dropdown wide">
										<a href="#">More Filters</a>
										<div class="panel-dropdown-content checkboxes">

											<!-- Checkboxes -->
											<div class="row">
												<div class="col-md-6">
													<input id="check-a" type="checkbox" name="check">
													<label for="check-a">Elevator in building</label>

													<input id="check-b" type="checkbox" name="check">
													<label for="check-b">Friendly workspace</label>

													<input id="check-c" type="checkbox" name="check">
													<label for="check-c">Instant Book</label>

													<input id="check-d" type="checkbox" name="check">
													<label for="check-d">Wireless Internet</label>
												</div>	

												<div class="col-md-6">
													<input id="check-e" type="checkbox" name="check" >
													<label for="check-e">Free parking on premises</label>

													<input id="check-f" type="checkbox" name="check" >
													<label for="check-f">Free parking on street</label>

													<input id="check-g" type="checkbox" name="check">
													<label for="check-g">Smoking allowed</label>	

													<input id="check-h" type="checkbox" name="check">
													<label for="check-h">Events</label>
												</div>
											</div>
											
											<!-- Buttons -->
											<div class="panel-buttons">
												<button class="panel-cancel">Cancel</button>
												<button class="panel-apply">Apply</button>
											</div>

										</div>
									</div>
									<!-- Panel Dropdown / End -->

									<!-- Panel Dropdown -->
									<div class="panel-dropdown">
										<a href="#">Distance Radius</a>
										<div class="panel-dropdown-content">
											<input class="distance-radius" type="range" min="1" max="100" step="1" value="50" data-title="Radius around selected destination">
											<div class="panel-buttons">
												<button class="panel-cancel">Disable</button>
												<button class="panel-apply">Apply</button>
											</div>
										</div>
									</div>
									<!-- Panel Dropdown / End -->
									
								</div>
								<!-- Filters / End -->
	
							</div>
							<!-- Row With Forms / End -->

					</div>
				</div>

			</section>
			<!-- Search / End -->


		<section class="listings-container margin-top-30">
			<!-- Sorting / Layout Switcher -->
			<div class="row fs-switcher">

				<div class="col-md-6">
					<!-- Showing Results -->
					<p class="showing-results">14 Results Found </p>
				</div>

			</div>


			<!-- Listings -->
			<div class="row fs-listings">
				
				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="1">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-01.jpg" alt="">
								<span class="tag">Eat & Drink</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">
								<div class="listing-badge now-open">Now Open</div>

								<div class="listing-item-inner">
									<h3>Tom's Restaurant <i class="verified-icon"></i></h3>
									<span>964 School Street, New York</span>
									<div class="star-rating" data-rating="3.5">
										<div class="rating-counter">(12 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->

				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="2">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-02.jpg" alt="">
								<span class="tag">Events</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">

								<div class="listing-item-inner">
								<h3>Sticky Band</h3>
								<span>Bishop Avenue, New York</span>
									<div class="star-rating" data-rating="5.0">
										<div class="rating-counter">(23 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>

								<div class="listing-item-details">Friday, August 10</div>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->

				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="3">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-03.jpg" alt="">
								<span class="tag">Hotels</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">

								<div class="listing-item-inner">
								<h3>Hotel Govendor</h3>
								<span>778 Country Street, New York</span>
									<div class="star-rating" data-rating="2.0">
										<div class="rating-counter">(17 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>

								<div class="listing-item-details">Starting from $59 per night</div>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->

				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="4">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-04.jpg" alt="">
								<span class="tag">Eat & Drink</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">
								<div class="listing-badge now-open">Now Open</div>
								
								<div class="listing-item-inner">
								<h3>Burger House <i class="verified-icon"></i></h3>
								<span>2726 Shinn Street, New York</span>
									<div class="star-rating" data-rating="5.0">
										<div class="rating-counter">(31 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->

				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="5">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-05.jpg" alt="">
								<span class="tag">Other</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">

								<div class="listing-item-inner">
								<h3>Airport</h3>
								<span>1512 Duncan Avenue, New York</span>
									<div class="star-rating" data-rating="3.5">
										<div class="rating-counter">(46 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->

				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="6">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-06.jpg" alt="">
								<span class="tag">Eat & Drink</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">
								<div class="listing-badge now-closed">Now Closed</div>

								<div class="listing-item-inner">
								<h3>Think Coffee</h3>
								<span>215 Terry Lane, New York</span>
									<div class="star-rating" data-rating="5.0">
										<div class="rating-counter">(31 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->
				
				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="6">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-06.jpg" alt="">
								<span class="tag">Eat & Drink</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">
								<div class="listing-badge now-closed">Now Closed</div>

								<div class="listing-item-inner">
								<h3>Think Coffee</h3>
								<span>215 Terry Lane, New York</span>
									<div class="star-rating" data-rating="5.0">
										<div class="rating-counter">(31 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->
				
				
				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="6">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-06.jpg" alt="">
								<span class="tag">Eat & Drink</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">
								<div class="listing-badge now-closed">Now Closed</div>

								<div class="listing-item-inner">
								<h3>Think Coffee</h3>
								<span>215 Terry Lane, New York</span>
									<div class="star-rating" data-rating="5.0">
										<div class="rating-counter">(31 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->
				
				
				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="6">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-06.jpg" alt="">
								<span class="tag">Eat & Drink</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">
								<div class="listing-badge now-closed">Now Closed</div>

								<div class="listing-item-inner">
								<h3>Think Coffee</h3>
								<span>215 Terry Lane, New York</span>
									<div class="star-rating" data-rating="5.0">
										<div class="rating-counter">(31 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->
				
				
				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="6">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-06.jpg" alt="">
								<span class="tag">Eat & Drink</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">
								<div class="listing-badge now-closed">Now Closed</div>

								<div class="listing-item-inner">
								<h3>Think Coffee</h3>
								<span>215 Terry Lane, New York</span>
									<div class="star-rating" data-rating="5.0">
										<div class="rating-counter">(31 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->
				
				
				<!-- Listing Item -->
				<div class="col-lg-12 col-md-12">
					<div class="listing-item-container list-layout" data-marker-id="6">
						<a href="listings-single-page.html" class="listing-item">
							
							<!-- Image -->
							<div class="listing-item-image">
								<img src="images/listing-item-06.jpg" alt="">
								<span class="tag">Eat & Drink</span>
							</div>
							
							<!-- Content -->
							<div class="listing-item-content">
								<div class="listing-badge now-closed">Now Closed</div>

								<div class="listing-item-inner">
								<h3>Think Coffee</h3>
								<span>215 Terry Lane, New York</span>
									<div class="star-rating" data-rating="5.0">
										<div class="rating-counter">(31 reviews)</div>
									</div>
								</div>

								<span class="like-icon"></span>
							</div>
						</a>
					</div>
				</div>
				<!-- Listing Item / End -->

			</div>
			<!-- Listings Container / End -->


			<!-- Pagination Container -->
			<div class="row fs-listings">
				<div class="col-md-12">

					<!-- Pagination -->
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12">
							<!-- Pagination -->
							<div class="pagination-container margin-top-15 margin-bottom-40">
								<nav class="pagination">
									<ul>
										<li><a href="#" class="current-page">1</a></li>
										<li><a href="#">2</a></li>
										<li><a href="#">3</a></li>
										<li><a href="#"><i class="sl sl-icon-arrow-right"></i></a></li>
									</ul>
								</nav>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<!-- Pagination / End -->
					
					<!-- Copyrights -->
					<div class="copyrights margin-top-0">© 2019 Listeo. All Rights Reserved.</div>

				</div>
			</div>
			<!-- Pagination Container / End -->
		</section>

		</div>
	</div>
	<div class="fs-inner-container map-fixed">

		<!-- Map -->
		<div id="map-container">
		    <!-- <div id="map" class="map" data-map-zoom="9" data-map-scroll="true">
		        map goes here -->  <div id="map"></div>
		    </div>
		</div>

	</div>
</div>


</div>

<script>
	let map;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(12.859673460038564, 80.24604230331109),
    zoom: 13,
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
  const features = [
    {
      position: new google.maps.LatLng(12.826845110804886,  80.2442001219068),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.823997023942649, 80.24176719714924), 
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.789239249445103, 80.24978912131512),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.761856494561245, 80.24744930000472),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.776381575491788, 80.24458114424304),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.744206368157268, 80.2395059772029),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.734768011343863, 80.23642069504862),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.685058226317151, 80.21547140196715),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.658200981931598, 80.2088846052036),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.897394043172696, 80.2525950054915),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.916834963559127, 80.2491930394745),
      type: "info",
    },
    {
      position: new google.maps.LatLng(12.87225492626581, 80.24955258948027),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(12.859154703275705, 80.24273956801679),
      type: "parking",
    },
    {
      position: new google.maps.LatLng(12.846666668121731, 80.24369955524303),
      type: "parking",
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
	<script type="text/javascript" src="scripts/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>



</body>
</html>