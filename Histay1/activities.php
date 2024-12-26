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
    $data = array(
    'key' => $json_key,
    'action' => 'cms_pages',
    'page_id' => $_GET['id']
     );
    $result = call_json($data);
    //print_r($result);
    ?>


</header>
<div class="clearfix"></div>
<!-- Header Container / End -->

<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">
		<div class="col-lg-12 col-md-12 padding-right-10">
   
   <!--Start
   
   <div class="row col-md-12">
      <img src="images\abt1.PNG" />
        <img src="images\abt2.PNG" />
          <img src="images\abt3.PNG" />

</div>-->

<div class="container">
	<div class="row sticky-wrapper">
		<div style="text-align: justify;" class="col-lg-12 col-md-12 padding-right-10">

			<!-- Titlebar -->
			<div id="titlebar" class="listing-titlebar">
				<div class="listing-titlebar-title">
					<h2><?php echo $result['page_list']['title'];?></h2>
				</div>
			</div>

			<!-- Overview -->
			<div id="listing-overview" class="listing-section">

				<!-- Description -->

				<p>
				    <b>Birthday party</b><br>
From themed birthday parties to surprise parties, find the perfect place for all the special occasions in your life. 
Book the place @ECR check-in that is best suited for your celebration. <br>
<br>
<b>Corporate Entertainment</b><br>
Simple, classy, grandeur. Find the best place that reflects your company's ideas and professionalism. From food to the venue we got you covered.
 <br><br>
<b>Beach Theme Weddings</b><br>
Perfect place to have your dream wedding with a breathtaking view of the beach.
What are you waiting for? Download the app and book the venue for your dream event.
<br><br>
<b>Swimming Pool entertainment</b><br>
Pool parties are the best way to spend your weekend with your friends. Could there be a better place to do that than ECR Check-In? Download the app now and unlock exciting offers.
<br><br>
<b>Stage Events</b><br>
For events and product launches, we offer the best venues starting from budget-friendly rates to premium rates. 
<br><br>
<b>Hotels </b><br>
We seamlessly blend comfort with hospitality. Explore our staycation rooms and services and book the ones that best suit your budget.
<br><br>
<b>Resorts </b><br>
Find the best resorts to chill and spend time with your family! 
<br><br>
<b>Villas</b> <br>
From luxurious, elegant to modern and minimalist find a villa that you'll love!
<br><br>
<b>Bungalows</b><br><br> 
From beach, lawn, swimming pool to food services ECR check-in is the one-stop destination to enjoy your weekend in every possible way.
<br><br>
<b>Cabins</b> <br>
Not only for a season, but cabins are also enchanting throughout the year.
<br><br>
                                                        
<b>Vacation Homes</b><br>
Best place to get rid of the Monday blues and chill with your fam!
<br><br>
<b>Guest House</b> <br>
Book the Guesthouses @ECR Check-In with all the facilities and budget-friendly prices.
<br><br>
<b>Hotels and Motels</b><br> 
Best hotels and motels within your budget. A perfect getaway from your busy work schedule. 
<br><br>
<b>B&Bs</b> <br>
From the most comfortable rooms to a variety of breakfast options, you will be spoiled with choices. Book your rooms now.
<br><br>
<b>Self Catering Accommodations</b> <br>
We provide self-catering accommodations during the stay. Compare prices and unlock exciting deals. Download the app now.
<br><br>


</p>
				
				<div class="clearfix"></div>
			</div>		

		</div>

	</div>
</div>
   
   
   
   <!-- end -->
			

		</div>

	</div>
</div>


<?php include_once('footer.php'); ?>

</body>
</html>
