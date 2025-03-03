<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Add Property</title>
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

				<h2><i class="sl sl-icon-plus"></i> Add Listing</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Add Listing</li>
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
			<div class="col-lg-12">

				<div class="notification notice large margin-bottom-55">
					<h4>Don't Have an Account? 🙂</h4>
					<p>If you don't have an account you can create one by entering your email address in contact details section. A password will be automatically emailed to you.</p>
				</div>

				<div id="add-listing" class="separated-form">

					<!-- Section -->
					<div class="add-listing-section">

						<!-- Headline -->
						<div class="add-listing-headline">
							<h3><i class="sl sl-icon-doc"></i> Basic Informations</h3>
						</div>

						<!-- Title -->
						<div class="row with-forms">
							<div class="col-md-12">
								<h5>Listing Title <i class="tip" data-tip-content="Name of your business"></i></h5>
								<input class="search-field" type="text" value=""/>
							</div>
						</div>

						<!-- Row -->
						<div class="row with-forms">

							<!-- Status -->
							<div class="col-md-6">
								<h5>Category</h5>
								<select class="chosen-select-no-single" >
									<option label="blank">Select Category</option>	
									<option>Eat & Drink</option>
									<option>Shops</option>
									<option>Hotels</option>
									<option>Restaurants</option>
									<option>Fitness</option>
									<option>Events</option>
								</select>
							</div>

							<!-- Type -->
							<div class="col-md-6">
								<h5>Keywords <i class="tip" data-tip-content="Maximum of 15 keywords related with your business"></i></h5>
								<input type="text" placeholder="Keywords should be separated by commas">
							</div>

						</div>
						<!-- Row / End -->

					</div>
					<!-- Section / End -->

					<!-- Section -->
					<div class="add-listing-section margin-top-45">

						<!-- Headline -->
						<div class="add-listing-headline">
							<h3><i class="sl sl-icon-location"></i> Location</h3>
						</div>

						<div class="submit-section">

							<!-- Row -->
							<div class="row with-forms">

								<!-- City -->
								<div class="col-md-6">
									<h5>City</h5>
									<select class="chosen-select-no-single" >
										<option label="blank">Select City</option>	
										<option>New York</option>
										<option>Los Angeles</option>
										<option>Chicago</option>
										<option>Houston</option>
										<option>Phoenix</option>
										<option>San Diego</option>
										<option>Austin</option>
									</select>
								</div>

								<!-- Address -->
								<div class="col-md-6">
									<h5>Address</h5>
									<input type="text" placeholder="e.g. 964 School Street">
								</div>

								<!-- City -->
								<div class="col-md-6">
									<h5>State</h5>
									<input type="text">
								</div>

								<!-- Zip-Code -->
								<div class="col-md-6">
									<h5>Zip-Code</h5>
									<input type="text">
								</div>

							</div>
							<!-- Row / End -->

						</div>
					</div>
					<!-- Section / End -->


					<!-- Section -->
					<div class="add-listing-section margin-top-45">

						<!-- Headline -->
						<div class="add-listing-headline">
							<h3><i class="sl sl-icon-picture"></i> Gallery</h3>
						</div>

						<!-- Dropzone -->
						<div class="submit-section">
							<form action="/file-upload" class="dropzone" ></form>
						</div>

					</div>
					<!-- Section / End -->


					<!-- Section -->
					<div class="add-listing-section margin-top-45">

						<!-- Headline -->
						<div class="add-listing-headline">
							<h3><i class="sl sl-icon-docs"></i> Details</h3>
						</div>

						<!-- Description -->
						<div class="form">
							<h5>Description</h5>
							<textarea class="WYSIWYG" name="summary" cols="40" rows="3" id="summary" spellcheck="true"></textarea>
						</div>

						<!-- Row -->
						<div class="row with-forms">

							<!-- Phone -->
							<div class="col-md-4">
								<h5>Phone <span>(optional)</span></h5>
								<input type="text">
							</div>

							<!-- Website -->
							<div class="col-md-4">
								<h5>Website <span>(optional)</span></h5>
								<input type="text">
							</div>

							<!-- Email Address -->
							<div class="col-md-4">
								<h5>E-mail <span>(optional)</span></h5>
								<input type="text">
							</div>

						</div>
						<!-- Row / End -->


						<!-- Row -->
						<div class="row with-forms">

							<!-- Phone -->
							<div class="col-md-4">
								<h5 class="fb-input"><i class="fa fa-facebook-square"></i> Facebook <span>(optional)</span></h5>
								<input type="text" placeholder="https://www.facebook.com/">
							</div>

							<!-- Website -->
							<div class="col-md-4">
								<h5 class="twitter-input"><i class="fa fa-twitter"></i> Twitter <span>(optional)</span></h5>
								<input type="text" placeholder="https://www.twitter.com/">
							</div>

							<!-- Email Address -->
							<div class="col-md-4">
								<h5 class="gplus-input"><i class="fa fa-google-plus"></i> Google Plus <span>(optional)</span></h5>
								<input type="text" placeholder="https://plus.google.com">
							</div>

						</div>
						<!-- Row / End -->


						<!-- Checkboxes -->
						<h5 class="margin-top-30 margin-bottom-10">Amenities <span>(optional)</span></h5>
						<div class="checkboxes in-row margin-bottom-20">
					
							<input id="check-a" type="checkbox" name="check">
							<label for="check-a">Elevator in building</label>

							<input id="check-b" type="checkbox" name="check">
							<label for="check-b">Friendly workspace</label>

							<input id="check-c" type="checkbox" name="check">
							<label for="check-c">Instant Book</label>

							<input id="check-d" type="checkbox" name="check">
							<label for="check-d">Wireless Internet</label>

							<input id="check-e" type="checkbox" name="check" >
							<label for="check-e">Free parking on premises</label>

							<input id="check-f" type="checkbox" name="check" >
							<label for="check-f">Free parking on street</label>

							<input id="check-g" type="checkbox" name="check">
							<label for="check-g">Smoking allowed</label>	

							<input id="check-h" type="checkbox" name="check">
							<label for="check-h">Events</label>
					
						</div>
						<!-- Checkboxes / End -->

					</div>
					<!-- Section / End -->


					<!-- Section -->
					<div class="add-listing-section margin-top-45">
						
						<!-- Headline -->
						<div class="add-listing-headline">
							<h3><i class="sl sl-icon-clock"></i> Opening Hours</h3>
							<!-- Switcher -->
							<label class="switch"><input type="checkbox" checked><span class="slider round"></span></label>
						</div>
						
						<!-- Switcher ON-OFF Content -->
						<div class="switcher-content">

							<!-- Day -->
							<div class="row opening-day">
								<div class="col-md-2"><h5>Monday</h5></div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Opening Time">
										<option label="Opening Time"></option>
										<option>Closed</option>
										<option>1 AM</option>
										<option>2 AM</option>
										<option>3 AM</option>
										<option>4 AM</option>
										<option>5 AM</option>
										<option>6 AM</option>
										<option>7 AM</option>
										<option>8 AM</option>
										<option>9 AM</option>
										<option>10 AM</option>
										<option>11 AM</option>
										<option>12 AM</option>	
										<option>1 PM</option>
										<option>2 PM</option>
										<option>3 PM</option>
										<option>4 PM</option>
										<option>5 PM</option>
										<option>6 PM</option>
										<option>7 PM</option>
										<option>8 PM</option>
										<option>9 PM</option>
										<option>10 PM</option>
										<option>11 PM</option>
										<option>12 PM</option>
									</select>
								</div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Closing Time">
										<option label="Closing Time"></option>
										<option>Closed</option>
										<option>1 AM</option>
										<option>2 AM</option>
										<option>3 AM</option>
										<option>4 AM</option>
										<option>5 AM</option>
										<option>6 AM</option>
										<option>7 AM</option>
										<option>8 AM</option>
										<option>9 AM</option>
										<option>10 AM</option>
										<option>11 AM</option>
										<option>12 AM</option>	
										<option>1 PM</option>
										<option>2 PM</option>
										<option>3 PM</option>
										<option>4 PM</option>
										<option>5 PM</option>
										<option>6 PM</option>
										<option>7 PM</option>
										<option>8 PM</option>
										<option>9 PM</option>
										<option>10 PM</option>
										<option>11 PM</option>
										<option>12 PM</option>
									</select>
								</div>
							</div>
							<!-- Day / End -->

							<!-- Day -->
							<div class="row opening-day js-demo-hours">
								<div class="col-md-2"><h5>Tuesday</h5></div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Opening Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Closing Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
							</div>
							<!-- Day / End -->

							<!-- Day -->
							<div class="row opening-day js-demo-hours">
								<div class="col-md-2"><h5>Wednesday</h5></div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Opening Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Closing Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
							</div>
							<!-- Day / End -->

							<!-- Day -->
							<div class="row opening-day js-demo-hours">
								<div class="col-md-2"><h5>Thursday</h5></div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Opening Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Closing Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
							</div>
							<!-- Day / End -->

							<!-- Day -->
							<div class="row opening-day js-demo-hours">
								<div class="col-md-2"><h5>Friday</h5></div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Opening Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Closing Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
							</div>
							<!-- Day / End -->

							<!-- Day -->
							<div class="row opening-day js-demo-hours">
								<div class="col-md-2"><h5>Saturday</h5></div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Opening Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Closing Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
							</div>
							<!-- Day / End -->

							<!-- Day -->
							<div class="row opening-day js-demo-hours">
								<div class="col-md-2"><h5>Sunday</h5></div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Opening Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
								<div class="col-md-5">
									<select class="chosen-select" data-placeholder="Closing Time">
										<!-- Hours added via JS (this is only for demo purpose) -->
									</select>
								</div>
							</div>
							<!-- Day / End -->

						</div>
						<!-- Switcher ON-OFF Content / End -->

					</div>
					<!-- Section / End -->


					<!-- Section -->
					<div class="add-listing-section margin-top-45">
						
						<!-- Headline -->
						<div class="add-listing-headline">
							<h3><i class="sl sl-icon-book-open"></i> Pricing</h3>
							<!-- Switcher -->
							<label class="switch"><input type="checkbox" checked><span class="slider round"></span></label>
						</div>

						<!-- Switcher ON-OFF Content -->
						<div class="switcher-content">

							<div class="row">
								<div class="col-md-12">
									<table id="pricing-list-container">
										<tr class="pricing-list-item pattern">
											<td>
												<div class="fm-move"><i class="sl sl-icon-cursor-move"></i></div>
												<div class="fm-input pricing-name"><input type="text" placeholder="Title" /></div>
												<div class="fm-input pricing-ingredients"><input type="text" placeholder="Description" /></div>
												<div class="fm-input pricing-price"><input type="text" placeholder="Price" data-unit="USD" /></div>
												<div class="fm-close"><a class="delete" href="#"><i class="fa fa-remove"></i></a></div>
											</td>
										</tr>
									</table>
									<a href="#" class="button add-pricing-list-item">Add Item</a>
									<a href="#" class="button add-pricing-submenu">Add Category</a>
								</div>
							</div>

						</div>
						<!-- Switcher ON-OFF Content / End -->

					</div>
					<!-- Section / End -->


					<a href="#" class="button preview">Preview <i class="fa fa-arrow-circle-right"></i></a>

				</div>
			</div>

		</div>

	</div>
	<!-- Content / End -->
<!-- Container / End -->


<?php include_once('footer.php'); ?>





<!-- Opening hours added via JS (this is only for demo purpose) -->
<script>
$(".opening-day.js-demo-hours .chosen-select").each(function() {
	$(this).append(''+
        '<option></option>'+
        '<option>Closed</option>'+
        '<option>1 AM</option>'+
        '<option>2 AM</option>'+
        '<option>3 AM</option>'+
        '<option>4 AM</option>'+
        '<option>5 AM</option>'+
        '<option>6 AM</option>'+
        '<option>7 AM</option>'+
        '<option>8 AM</option>'+
        '<option>9 AM</option>'+
        '<option>10 AM</option>'+
        '<option>11 AM</option>'+
        '<option>12 AM</option>'+
        '<option>1 PM</option>'+
        '<option>2 PM</option>'+
        '<option>3 PM</option>'+
        '<option>4 PM</option>'+
        '<option>5 PM</option>'+
        '<option>6 PM</option>'+
        '<option>7 PM</option>'+
        '<option>8 PM</option>'+
        '<option>9 PM</option>'+
        '<option>10 PM</option>'+
        '<option>11 PM</option>'+
        '<option>12 PM</option>');
});
</script>

<!-- DropZone | Documentation: http://dropzonejs.com -->
<script type="text/javascript" src="scripts/dropzone.js"></script>




</body>
</html>