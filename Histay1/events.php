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

				<h2>Events</h2><span></span>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Events</li>
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
						<a href="#" class="grid active"><i class="fa fa-th"></i></a>
						<a href="listings-list-with-sidebar.html" class="list"><i class="fa fa-align-justify"></i></a>
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

				<?php
                $data = array(
                'key' => $json_key,
                'action' => 'members_events',
                'event_id' =>'0',
                'sort' => 'ASC',
                'limit_st' => '0',
                'limit_cnt' => '0',
               );
                $result = call_json($data);
                foreach($result['events_List'] as $key => $value)
                {
                ?>

				<!-- Listing Item -->
				<div class="col-lg-6 col-md-12">
					<a href="event-details.php?event_id=<?php echo $result['events_List'][$key]['event_id'];?>" class="listing-item-container compact">
						<div class="listing-item">
							<img src="<?php echo $result['events_List'][$key]['image']; ?>" alt="">
							<div class="listing-item-details">
								<ul>
									<li><?php echo  date("d, M Y", strtotime($result['events_List'][$key]['event_date'])); ?></li>
								</ul>
							</div>
							<div class="listing-item-content">
								<div class="numerical-rating" data-rating="<?php echo $result['events_List'][$key]['hotel_name'];?>"></div>
								<h3><?php echo $result['events_List'][$key]['event_name'];?></h3>
								<span><?php echo $result['events_List'][$key]['description'];?></span>
							</div>
							<span class="like-icon"></span>
						</div>
					</a>
				</div>
				<!-- Listing Item / End -->		
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

<?php
include("footer.php");
?>