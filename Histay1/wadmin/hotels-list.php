<?php
$body_class = "";
include("header.php");
?>

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Hotel Listings</h2><span>300+ stays</span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Listings</li>
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
			<div class="sidebar">

				<!-- Widget -->
				<div class="widget margin-bottom-40">
					<h3 class="margin-top-0 margin-bottom-30">Filters</h3>

					<!-- Row -->
					<div class="row with-forms">
						<!-- Cities -->
						<div class="col-md-12">
							<input type="text" placeholder="What are you looking for?" value=""/>
						</div>
					</div>
					<!-- Row / End -->

					<!-- Row -->
					<div class="row with-forms">
						<!-- Type -->
						<div class="col-md-12">
							<select data-placeholder="All Categories" class="chosen-select" >
								<option>All Categories</option>	
								<option>Shops</option>
								<option>Hotels</option>
								<option>Restaurants</option>
								<option>Fitness</option>
								<option>Events</option>
							</select>
						</div>
					</div>
					<!-- Row / End -->

					<!-- Row -->
					<div class="row with-forms">
						<!-- Cities -->
						<div class="col-md-12">

							<div class="input-with-icon location">
								<div id="autocomplete-container">
									<input id="autocomplete-input" type="text" placeholder="Location">
								</div>
								<a href="#"><i class="fa fa-map-marker"></i></a>
							</div>

						</div>
					</div>
					<!-- Row / End -->
					<br>

					<!-- Area Range -->
					<div class="range-slider">
						<input class="distance-radius" type="range" min="1" max="100" step="1" value="50" data-title="Radius around selected destination">
					</div>


					<!-- More Search Options -->
					<a href="#" class="more-search-options-trigger margin-bottom-5 margin-top-20" data-open-title="More Filters" data-close-title="More Filters"></a>

					<div class="more-search-options relative">

						<!-- Checkboxes -->
						<div class="checkboxes one-in-row margin-bottom-15">
					
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
					<!-- More Search Options / End -->

					<button class="button fullwidth margin-top-25">Update</button>

				</div>
				<!-- Widget / End -->

			</div>
		</div>
		<!-- Sidebar / End -->

		<div class="col-lg-9 col-md-8 padding-right-30">

			<!-- Sorting / Layout Switcher -->
			<div class="row margin-bottom-25">

				<div class="col-md-6 col-xs-6">
					<!-- 
					<div class="layout-switcher">
						<a href="listings-grid-with-sidebar-1.html" class="grid"><i class="fa fa-th"></i></a>
						<a href="#" class="list active"><i class="fa fa-align-justify"></i></a>
					</div>-->
				</div>

				<div class="col-md-6 col-xs-6">
					<!-- Sort by -->
					<div class="sort-by">
						<div class="sort-by-select">
							<select data-placeholder="Default order" class="chosen-select-no-single">
								<option>Default Order</option>	
								<option>Highest Rated</option>
								<option>Most Reviewed</option>
								<option>Newest Listings</option>
								<option>Oldest Listings</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<!-- Sorting / Layout Switcher / End -->


			<div class="row">

				<link rel='stylesheet' href='unitegallery/css/unite-gallery.css' type='text/css' />

				<?php
				$_SESSION['check_in_out'] = $_GET['check_in_out'];
				$check_io = explode(" - ",$_GET['check_in_out']);
				$_SESSION['check_in'] = date('Y-m-d', strtotime($check_io[0]));
				$_SESSION['check_out'] = date('Y-m-d', strtotime($check_io[1]));
				if(isset($_GET['search']))
				{
					foreach($_GET['adults'] as $key => $v)
					{
						if(trim($v) != 0)
						{
							$adults[] = trim($v);
							echo $childerns[] = trim($_GET['childerns'][$key]);
						}
					}

	                $data = array(
	                'key' => $json_key,
	                'action' => 'hotel_search',
	                'hotel_id' => '0',
	                'destination_id' => $_GET['destination_id'],
	                'adults' => $adults[0],
	                'childerns' => $childerns[0],
	                'hotel_name' => $_GET['hotel_name'],
	                'star' =>  $_GET['star'],
	                'facility_id' =>  $_GET['facility_id'],
	                'sort' => 'ASC',
	                'slug' =>'',
	                'limit_st' => '0',
	                'limit_cnt' => '0',
	               	);
               	}
               	else
               	{
               		if(isset($_GET['destination_id']))
               			$destination_id = $_GET['destination_id'];
               		else
               			$destination_id = 0;
	                $data = array(
	                'key' => $json_key,
	                'action' => 'hotel_list_wmi',
	                'destination_id' => $destination_id,
	                'sort' => 'ASC',
	                'slug' =>'',
	                'limit_st' => '0',
	                'limit_cnt' => '0',
	               	);
              	}
                $result = call_json($data);
                foreach($result['hotels_list'] as $key => $value)
                {
                	$hotel_id[] = $result['hotels_list'][$key]['hotel_id'];
	                ?>
					<div class="col-lg-12 col-md-12">
						<div class="listing-item-container list-layout">
							
							<div class="listing-item">	
								<!-- Image -->
								<div class="listing-item-image">
									<div id="gallery<?php echo $result['hotels_list'][$key]['hotel_id']; ?>" style="display:none;">
										<?php
										foreach($result['hotels_list'][$key]['hotel_images'] as $ikey => $ivalue)
										{
											?>
											<img alt="Preview Image 1"
												 src="<?php echo $ivalue['hotel_image'];?>"
												 data-image="<?php echo $ivalue['hotel_image'];?>"
												 data-description="Preview Image 1 Description">
											<?php
										}	
										?>										
									</div>
									<span class="tag"><?php echo $result['hotels_list'][$key]['star']; ?> Star</span>
								</div>
															
								<!-- Content -->
								<div class="listing-item-content">
									<a href="hotel-details.php?hotel=<?php echo $result['hotels_list'][$key]['slug']; ?>">
										<div class="listing-badge now-open">Now Open</div>

										<div class="listing-item-inner">
											<h3><?php echo $result['hotels_list'][$key]['name']; ?> <i class="verified-icon"></i></h3>
											<span><i class="fa fa-map-marker"></i> <?php echo $result['hotels_list'][$key]['address']; ?></span>
											<div class="star-rating" data-rating="<?php echo $result['hotels_list'][$key]['rating']; ?>">
												<div class="rating-counter">(<?php echo $result['hotels_list'][$key]['review_count']; ?> reviews)</div>
											</div>
										</div>
										<span class="like-icon"></span>
									</a>
								</div>
							</div>
						</div>
					</div>
					
					<?php
              	}
              	?>
			</div>

			<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12">
					<!-- Pagination -->
					<div class="pagination-container margin-top-20 margin-bottom-40">
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
			<!-- Pagination / End -->

		</div>

	</div>
</div>

<?php include("footer.php"); ?>

<script type='text/javascript' src='unitegallery/js/unitegallery.min.js'></script>	
<script type='text/javascript' src='unitegallery/themes/slider/ug-theme-slider.js'></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	<?php
	foreach($hotel_id as $hid)
	{
		?>
		jQuery("#gallery<?php echo $hid; ?>").unitegallery();
		<?php
	}
	?>
});		
</script>