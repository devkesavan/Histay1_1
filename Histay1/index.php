<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title>Home: Ecrcheckin.com</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/main-color.css" id="colors">
<link rel="stylesheet" href="css/customs/styleown.css">
<link rel="stylesheet" href="css/customs/stylecorrect.css">

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
	</div>
<!-- Banner-->

<!-- Content
================================================== -->
<!-- Revolution Slider - ->
<div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="classicslider1" style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">-->

<div id="carouselExampleIndicators" class="carousel banner slide" data-ride="carousel">
		  <ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
		  </ol>
		  <div class="carousel-inner">
	            <?php
                $data = array(
                    'key' => $json_key,
                    'action' => 'cms_slider',
                    'sort' => 'ASC',
                    'limit_st' => '0',
                    'limit_cnt' => '0'
                );
                $result = call_json($data);
                foreach($result['master_slider_list'] as $key => $value)
                {
                    ?>
                    <div class="carousel-item carousel-size active">
        			  <img class="d-block w-100  img-fluid " src="<?php echo $result['master_slider_list'][$key]['slide_image'];?>" alt="#">
        			  	<div class="carousel-caption d-md-block fs">
        				<h1 class="text-focus-in"> <?php echo $result['master_slider_list'][$key]['text1'];?> <br><?php echo $result['master_slider_list'][$key]['text2'];?></h1>
        				 <a href="<?php echo $result['master_slider_list'][$key]['page_link'];?>"><button class="btn-banner-no-border slide-in-bottom "><span>BOOK NOW</span></button></a>
        			  </div> 
        			</div>
                    <?php
                }
                ?>
			 <!--<div class="carousel-item carousel-size">
			  <img class="d-block w-100  img-fluid" src="images/slider/d2.jpg" alt="#">
			  	<div class="carousel-caption d-md-block fs">
				<h1 class="text-focus-in">BEACH RESORT</h1>
				 <a href="#"><button class="btn-banner-no-border slide-in-bottom "><span>Explore More</span></button></a>
			  </div> 			  
			</div>
			<div class="carousel-item carousel-size">
			  <img class="d-block w-100  img-fluid" src="images/slider/d3.jpg" alt="#">
			  	<div class="carousel-caption d-md-block fs">
				<h1 class="text-focus-in">BEACH RESORT</h1>
				 <a href="#"><button class="btn-banner-no-border slide-in-bottom "><span>Explore More</span></button></a>
			  </div> 			  
			</div>
			<div class="carousel-item carousel-size">
			  <img class="d-block w-100  img-fluid" src="images/slider/d4.jpg" alt="#">
			  	<div class="carousel-caption d-md-block fs">
				<h1 class="text-focus-in">BEACH RESORT</h1>
				 <a href="#"><button class="btn-banner-no-border slide-in-bottom "><span>Explore More</span></button></a>
			  </div> 			  
			</div> -->
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		  </a>

		</div>


	<!--<div id="rev_slider_4_1" class="rev_slider home fullwidthabanner" style="display:none;" data-version="5.0.7">
		<ul>

			<li data-index="rs-1" data-transition="fade" data-slotamount="default"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="1000"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="800" data-fsslotamount="7" data-saveperformance="off">

		
				<img src="images/slider/d1.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina data-kenburns="on" data-duration="12000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="100" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0">

			
				<div class="tp-caption custom-caption-2 tp-shape tp-shapewrapper tp-resizeme rs-parallaxlevel-0" 
					id="slide-1-layer-2" 
					data-x="['left','left','left','left']"
					data-hoffset="['0','40','40','40']"
					data-y="['middle','middle','middle','middle']" data-voffset="['0']" 
					data-width="['640','640', 640','420','320']"
					data-height="auto"
					data-whitespace="nowrap"
					data-transform_idle="o:1;"	
					data-transform_in="y:0;opacity:0;s:1000;e:Power2.easeOutExpo;s:400;e:Power2.easeOutExpo" 
					data-transform_out="" 
					data-mask_in="x:0px;y:[20%];s:inherit;e:inherit;" 
					data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" 
					data-start="1000" 
					data-responsive_offset="on">

					<div class="R_title margin-bottom-15"
					id="slide-2-layer-1"
					data-x="['left','center','center','center']"
					data-hoffset="['0','0','40','0']"
					data-y="['middle','middle','middle','middle']"
					data-voffset="['-40','-40','-20','-80']"
					data-fontsize="['42','36', '32','36','22']"
					data-lineheight="['70','60','60','45','35']"
					data-width="['640','640', 640','420','320']"
					data-height="none" data-whitespace="normal"
					data-transform_idle="o:1;"
					data-transform_in="y:-50px;sX:2;sY:2;opacity:0;s:1000;e:Power4.easeOut;"
					data-transform_out="opacity:0;s:300;"
					data-start="600"
					data-splitin="none"
					data-splitout="none"
					data-basealign="slide"
					data-responsive_offset="off"
					data-responsive="off"
					style="z-index: 6; color: #fff; letter-spacing: 0px; font-weight: 600; ">Discover City Gems</div>

					<div class="caption-text">Interactively procrastinate high-payoff content without backward-compatible data. Quickly cultivate optimal processes and tactical architectures.</div>
					<a href="#" class="button medium">Get Started</a>
				</div>

			</li>

		
			<li data-index="rs-2" data-transition="fade" data-slotamount="default"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="1000"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="800" data-fsslotamount="7" data-saveperformance="off">


				<img src="images/slider/d2.jpg"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina data-kenburns="on" data-duration="12000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="112" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0"> 

			
				<div class="tp-caption centered custom-caption-2 tp-shape tp-shapewrapper tp-resizeme rs-parallaxlevel-0" 
					id="slide-2-layer-2" 
					data-x="['center','center','center','center']" data-hoffset="['0']" 
					data-y="['middle','middle','middle','middle']" data-voffset="['0']" 
					data-width="['640','640', 640','420','320']"
					data-height="auto"
					data-whitespace="nowrap"
					data-transform_idle="o:1;"	
					data-transform_in="y:0;opacity:0;s:1000;e:Power2.easeOutExpo;s:400;e:Power2.easeOutExpo" 
					data-transform_out="" 
					data-mask_in="x:0px;y:[20%];s:inherit;e:inherit;" 
					data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" 
					data-start="1000" 
					data-responsive_offset="on">

			
					<div class="R_title margin-bottom-15"
					id="slide-2-layer-3"
					data-x="['center','center','center','center']"
					data-hoffset="['0','0','0','0']"
					data-y="['middle','middle','middle','middle']"
					data-voffset="['-40','-40','-20','-80']"
					data-fontsize="['42','36', '32','36','22']"
					data-lineheight="['70','60','60','45','35']"
					data-width="['640','640', 640','420','320']"
					data-height="none" data-whitespace="normal"
					data-transform_idle="o:1;"
					data-transform_in="y:-50px;sX:2;sY:2;opacity:0;s:1000;e:Power4.easeOut;"
					data-transform_out="opacity:0;s:300;"
					data-start="600"
					data-splitin="none"
					data-splitout="none"
					data-basealign="slide"
					data-responsive_offset="off"
					data-responsive="off"
					style="z-index: 6; color: #fff; letter-spacing: 0px; font-weight: 600; ">Streamline Your Business</div>

					<div class="caption-text">Proactively envisioned multimedia based on expertise cross-media growth strategies. Pontificate installed base portals after maintainable products.</div>
					<a href="#" class="button medium">Read More</a>
				</div>

			</li>
			

			<li data-index="rs-2" data-transition="fade" data-slotamount="default"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="1000"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="800" data-fsslotamount="7" data-saveperformance="off">

		
				<img src="images/slider/d3.jpg"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina data-kenburns="on" data-duration="12000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="112" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0"> 

		
				<div class="tp-caption centered custom-caption-2 tp-shape tp-shapewrapper tp-resizeme rs-parallaxlevel-0" 
					id="slide-2-layer-2" 
					data-x="['center','center','center','center']" data-hoffset="['0']" 
					data-y="['middle','middle','middle','middle']" data-voffset="['0']" 
					data-width="['640','640', 640','420','320']"
					data-height="auto"
					data-whitespace="nowrap"
					data-transform_idle="o:1;"	
					data-transform_in="y:0;opacity:0;s:1000;e:Power2.easeOutExpo;s:400;e:Power2.easeOutExpo" 
					data-transform_out="" 
					data-mask_in="x:0px;y:[20%];s:inherit;e:inherit;" 
					data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" 
					data-start="1000" 
					data-responsive_offset="on">

		
					<div class="R_title margin-bottom-15"
					id="slide-2-layer-3"
					data-x="['center','center','center','center']"
					data-hoffset="['0','0','0','0']"
					data-y="['middle','middle','middle','middle']"
					data-voffset="['-40','-40','-20','-80']"
					data-fontsize="['42','36', '32','36','22']"
					data-lineheight="['70','60','60','45','35']"
					data-width="['640','640', 640','420','320']"
					data-height="none" data-whitespace="normal"
					data-transform_idle="o:1;"
					data-transform_in="y:-50px;sX:2;sY:2;opacity:0;s:1000;e:Power4.easeOut;"
					data-transform_out="opacity:0;s:300;"
					data-start="600"
					data-splitin="none"
					data-splitout="none"
					data-basealign="slide"
					data-responsive_offset="off"
					data-responsive="off"
					style="z-index: 6; color: #fff; letter-spacing: 0px; font-weight: 600; ">Streamline Your Business</div>

					<div class="caption-text">Proactively envisioned multimedia based on expertise cross-media growth strategies. Pontificate installed base portals after maintainable products.</div>
					<a href="#" class="button medium">Read More</a>
				</div>

			</li>
			
			
	
			<li data-index="rs-2" data-transition="fade" data-slotamount="default"  data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="1000"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="800" data-fsslotamount="7" data-saveperformance="off">

				<img src="images/slider/d4.jpg"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina data-kenburns="on" data-duration="12000" data-ease="Linear.easeNone" data-scalestart="100" data-scaleend="112" data-rotatestart="0" data-rotateend="0" data-offsetstart="0 0" data-offsetend="0 0"> 

	
				<div class="tp-caption centered custom-caption-2 tp-shape tp-shapewrapper tp-resizeme rs-parallaxlevel-0" 
					id="slide-2-layer-2" 
					data-x="['center','center','center','center']" data-hoffset="['0']" 
					data-y="['middle','middle','middle','middle']" data-voffset="['0']" 
					data-width="['640','640', 640','420','320']"
					data-height="auto"
					data-whitespace="nowrap"
					data-transform_idle="o:1;"	
					data-transform_in="y:0;opacity:0;s:1000;e:Power2.easeOutExpo;s:400;e:Power2.easeOutExpo" 
					data-transform_out="" 
					data-mask_in="x:0px;y:[20%];s:inherit;e:inherit;" 
					data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;" 
					data-start="1000" 
					data-responsive_offset="on">

					<div class="R_title margin-bottom-15"
					id="slide-2-layer-3"
					data-x="['center','center','center','center']"
					data-hoffset="['0','0','0','0']"
					data-y="['middle','middle','middle','middle']"
					data-voffset="['-40','-40','-20','-80']"
					data-fontsize="['42','36', '32','36','22']"
					data-lineheight="['70','60','60','45','35']"
					data-width="['640','640', 640','420','320']"
					data-height="none" data-whitespace="normal"
					data-transform_idle="o:1;"
					data-transform_in="y:-50px;sX:2;sY:2;opacity:0;s:1000;e:Power4.easeOut;"
					data-transform_out="opacity:0;s:300;"
					data-start="600"
					data-splitin="none"
					data-splitout="none"
					data-basealign="slide"
					data-responsive_offset="off"
					data-responsive="off"
					style="z-index: 6; color: #fff; letter-spacing: 0px; font-weight: 600; ">Streamline Your Business</div>

					<div class="caption-text">Proactively envisioned multimedia based on expertise cross-media growth strategies. Pontificate installed base portals after maintainable products.</div>
					<a href="#" class="button medium">Read More</a>
				</div>

			</li>

		</ul>
		<div class="tp-static-layers"></div>

	</div>-->

<div class="main-search-container centered" data-background-image="">
<!--<div class="main-search-container" >-->
	<div class="main-search-inner">

				<form method="get" class="main-search-input" action="hotels-list.php">
					<div class="main-search-input">

						<!--<div class="main-search-input-item">
							<input type="text" placeholder="Destinations" value=""/>
						</div>-->
						<div class="main-search-input-item">
							<select data-placeholder="Destinations" class="chosen-select" name="destination_id">
								<option value="">Select Destination</option>
								<?php
                                  $data = array(
                                      'key' => $json_key,
                                      'action' => 'destination',
                                      'destination_id' => '0',
                                      'sort' => 'ASC',
                                      'limit_st' => '0',
                                      'limit_cnt' => '0',
                                  );
                                  $result = call_json($data);
                                  foreach($result['destination_list'] as $key => $value)
                                  {
                                  ?>
                                    <option value="<?php echo $result['destination_list'][$key]['destination_id'];?>"><?php echo $result['destination_list'][$key]['name'];?></option>
                                    <?php
                                  }
                                ?>
							</select>
						</div>

						<div class="main-search-input-item location">
							<div id="autocomplete-container">
								<input type="text" placeholder="Check-In - Check-Out" class="form-control" id="booking-date-search" name="check_in_out" autocomplete="off" required>
							</div>
							<a href="#"><i class="fa fa-calender"></i></a>
						</div>

						<div class="main-search-input-item">
							<div class="panel-dropdown">
								<a href="#" id="dropdownMenuButton">1 Room(s), 1 Guest(s) <span class="qtyTotal" name="qtyTotal">1</span></a>
								<div class="panel-dropdown-content">
									<!-- Quantity Buttons -->
									<div class="qtyButtons">
										<div class="qtyTitle">Adults</div>
										<input type="text" class="sadults" name="adults[]" value="1">
									</div>

									<div class="qtyButtons">
										<div class="qtyTitle">Childrens</div>
										<input type="text" class="schilderns" name="childerns[]" value="0">
									</div>
								
									<div id="room_select">
                    <input type="hidden" id="sri_val" value="2">
                    <?php
                    for($i=2;$i<=10;$i++)
                    {
                      ?>
                      <div class="sroom_inner" id="sroom_inner_<?php echo $i; ?>" style="display: none;">
											<h5>Room <?php echo $i; ?></h5>
											<a class="tt_link" onclick="rmv_room(<?php echo $i; ?>);">Remove</a>
											<!-- Quantity Buttons -->
											<div class="qtyButtons">
												<div class="qtyTitle">Adults</div>
												<input type="text" class="sadults" name="adults[]" value="0">
											</div>

											<div class="qtyButtons">
												<div class="qtyTitle">Childrens</div>
												<input type="text" class="schilderns" name="childerns[]" value="0">
											</div>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                  <a class="tt_sbtn" id="add_room_btn">+ ADD ANOTHER ROOM</a>
                  <a class="tt_srbtn" id="apply_room_btn">APPLY</a>
                </div>
							</div>
						</div>
						<button class="button" onclick="window.location" href='listings-half-screen-map-list.html'>Search</button>

					</div>
				</form>
			</div>

		</div>
		


<!-- Revolution Slider / End -->
<!-- Slider
================================================== -->

<!-- Content
================================================== -->

<!-- Container 
<div class="container">
	<div class="row">

		<div class="col-md-12">
			<h3 class="headline centered margin-bottom-35 margin-top-70">Choose Your NearBy Destinations <span>Browse listings in popular ECR places</span></h3>
		</div>
		
		<div class="col-md-4">

			
			<a href="listings-list-with-sidebar.html" class="img-box" data-background-image="images/destinations/1.jpg">
				<div class="img-box-content visible">
				
					<span>14 Resorts</span>
				</div>
			</a>

		</div>	
			
		<div class="col-md-8">

			
			<a href="listings-list-with-sidebar.html" class="img-box" data-background-image="images/destinations/2.jpg">
				<div class="img-box-content visible">
					
					<span>24 Homestays</span>
				</div>
			</a>

		</div>	

		<div class="col-md-8">

		
			<a href="listings-list-with-sidebar.html" class="img-box" data-background-image="images/destinations/3.jpg">
				<div class="img-box-content visible"> 
				
					<span>12 Resort</span>
				</div>
			</a>

		</div>	
			
		<div class="col-md-4">

		
			<a href="listings-list-with-sidebar.html" class="img-box" data-background-image="images/destinations/4.jpg">
				<div class="img-box-content visible">
				
					<span>9 Resort</span>
				</div>
			</a>

		</div>

	</div>
</div>
<!-- Container / End -->

<section class="pt-5 pb-5">
  <div class="container">
    <div class="row">
        <div class="col-md-6">
				<h3 class="headline margin-bottom-5">
					Discover Your<span> Favourite Location</span>
				</h3>		
				<p class="mb-5 ml-3">We can assist you with your innovation and commercialisation journey!</p>
        </div>
        <div class="col-md-6 slide-arrow">
            <a class="mb-3 mr-3" style="font-size:large; font-weight:inherit;" href="#carouselExampleIndicators21" role="button" data-slide="prev">
                <i class="sl sl-icon-arrow-left" style="font-size:large; font-weight:inherit;"></i>
            </a>
            <a class="mb-3 mr-3" style="font-size:large; font-weight:inherit;" href="#carouselExampleIndicators21" role="button" data-slide="next">
                <i class="sl sl-icon-arrow-right" style="font-size:large; font-weight:inherit;"></i>
            </a>
        </div>
        <div class="col-12">
            <div id="carouselExampleIndicators21" class="carousel slide" data-ride="carousel2">

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">

                        	<?php
												  $data = array(
												      'key' => $json_key,
												      'action' => 'destination',
												      'destination_id' => '0',
												      'sort' => 'ASC',
												      'limit_st' => '0',
												      'limit_cnt' => '0',
												  );
												  $result = call_json($data);
												  $des_count = 0;
												  foreach($result['destination_list'] as $key => $value)
												  {
												  	if($des_count%4 == 0 && $des_count != 0)
												  	{
												  		?>
												  			</div>
					                    </div>
					                    <div class="carousel-item">
					                    	<div class="row">
					                    		<?php
												  	}
												  	$des_count++;
												  	$today = date('Y-m-d');
												  	$next_day = date('Y-m-d', strtotime("+1 day"));
												  	?>
														<a class="col-md-3 mb-3" href="hotels-list.php?destination_id=<?php echo $result['destination_list'][$key]['destination_id'];?>&check_in_out=<?php echo $today; ?> - <?php echo $next_day; ?>&adults[]=1&childerns[]=0&property_type_id=">
															<div class="card1">
															  <img class="img-fluid" alt="100%x280" src="<?php echo $result['destination_list'][$key]['image'];?>" >
																<div class="listing-item-content">
																	<h3 class="rounded"><img height="20%" width="20%" src="images/dashboard-avatar.png" alt="">  <?php echo $result['destination_list'][$key]['name'];?>
																	</h3>
																</div>
															</div>
														</a>
														<?php												    
												  }
												?>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section class="pt-5 pb-5">
  <div class="container">
    <div class="row">
        <div class="col-md-6">
				<h3 class="headline margin-bottom-5">
					Browse by
					<span>Property Type</span>
				</h3>		
				<p class="mb-5 ml-3">We can assist you with your innovation and commercialisation journey!</p>
        </div>
        <div class="col-md-6 slide-arrow">
            <a class="mb-3 mr-3" style="font-size:large; font-weight:inherit;" href="#carouselExampleIndicators212" role="button" data-slide="prev">
                <i class="sl sl-icon-arrow-left" style="font-size:large; font-weight:inherit;"></i>
            </a>
            <a class="mb-3 mr-3" style="font-size:large; font-weight:inherit;" href="#carouselExampleIndicators212" role="button" data-slide="next">
                <i class="sl sl-icon-arrow-right" style="font-size:large; font-weight:inherit;"></i>
            </a>
        </div>
        <div class="col-12">
            <div id="carouselExampleIndicators212" class="carousel slide" data-ride="carousel2">

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">

                        	<?php
												  $data = array(
												      'key' => $json_key,
												      'action' => 'property_type',
												      'destination_id' => '0',
												      'sort' => 'ASC',
												      'limit_st' => '0',
												      'limit_cnt' => '0',
												  );
												  $result = call_json($data);
												  $des_count = 0;
												  foreach($result['property_type_list'] as $key => $value)
												  {
												  	if($des_count%4 == 0 && $des_count != 0)
												  	{
												  		?>
												  			</div>
					                    </div>
					                    <div class="carousel-item">
					                    	<div class="row">
					                    		<?php
												  	}
												  	$des_count++;
												  ?>
														<a class="col-md-3 mb-3" href="hotels-list.php?destination_id=&check_in_out=<?php echo $today; ?> - <?php echo $next_day; ?>&adults[]=1&childerns[]=0&property_type_id=<?php echo $result['property_type_list'][$key]['property_type_id'];?>">
															<div class="card1">
															  <img class="img-fluid" alt="100%x280" src="<?php echo $result['property_type_list'][$key]['image'];?>" >
																<div class="listing-item-content  ">
																	<h3 class="rounded"><img height="20%" width="20%" src="images/dashboard-avatar.png" alt="">  <?php echo $result['property_type_list'][$key]['name'];?>
																	</h3>
																</div>
															</div>
														</a>
												    <?php												    
												  }
												?>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>



<!--<section class="fullwidth margin-top-15 padding-top-15 padding-bottom-5" data-background-color="#FFFF">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="headline margin-bottom-15">
					Explore Property
					<span>Browse by property type</span>
				</h3>
				<p class="mb-5 ml-3">We can assist you with your innovation and commercialisation journey!</p>
			</div>
		<!--	 <div class="col-md-12">
				<div class="simple-slick-carousel dots-nav">
					<div class="carousel-item">
						<a href="listings-single-page.html" class="listing-item-container compact">
							<div class="listing-item">
								<img src="images/listing-item-01.jpg" alt="">
								<div class="listing-item-content">
									<h3>Tom's Restaurant</h3>
								</div>
							</div>
						</a>
					</div>
					
					<div class="carousel-item">
						<a href="listings-single-page.html" class="listing-item-container compact">
							<div class="listing-item">
								<img src="images/listing-item-02.jpg" alt="">
								<div class="listing-item-content">
									<h3>Sticky Band</h3>
								</div>
							</div>
						</a>
					</div>
				
					<div class="carousel-item">
						<a href="listings-single-page.html" class="listing-item-container compact">
							<div class="listing-item">
								<img src="images/listing-item-03.jpg" alt="">
								<div class="listing-item-content">
									<h3>Hotel Govendor</h3>
								</div>
							</div>

						</a>
					</div>
				
					<div class="carousel-item">
						<a href="listings-single-page.html" class="listing-item-container compact">
							<div class="listing-item">
								<img src="images/listing-item-04.jpg" alt="">
								<div class="listing-item-content">
									<h3>Burger House</h3>
								</div>
							</div>
						</a>
					</div>
								
					<div class="carousel-item">
						<a href="listings-single-page.html" class="listing-item-container compact">
							<div class="listing-item">
								<img src="images/listing-item-05.jpg" alt="">
								<div class="listing-item-content">
									<h3>Airport</h3>
								</div>
							</div>
						</a>
					</div>
				

				</div>
				
			</div> --> 
					
	<!--	</div>
		</div>
	</div>

</section> -->



<!-- Pricing Tables - ->
<section class="fullwidth margin-top-5 padding-bottom-20" data-background-color="#fff">

	<!-- Container / Start - ->
	<div class="container">


		<div class="row">
			<div class="col-md-12">
				<h3 class="headline centered margin-bottom-50">
					Get Your Exiting Offers
				</h3>
			</div>
		</div>


<!-- partial:index.part - ->
<div class="custom-accordion">
  <div class="item">
    <div class="icon">10%</div>
    <div class="title">
      <div class="text">Discout 10 %</div>
    </div>
    <div class="content"><img src="images/dis.png" />Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
  </div>
  <div class="item">
    <div class="icon">20%</div>
    <div class="title">
      <div class="text">Discout 20 %</div>
    </div>
     <div class="content"><img src="images/dis.png" />Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
  </div>
  <div class="item">
    <div class="icon">30%</div>
    <div class="title">
      <div class="text">Discout 30 %</div>
    </div>
     <div class="content"><img src="images/dis.png" />Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
  </div>
  <div class="item">
    <div class="icon">40%</div>
    <div class="title">
      <div class="text">Discout 40 %</div>
    </div>
    <div class="content"><img src="images/dis.png" />Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
  </div>
  <div class="item">
    <div class="icon">50%</div>
    <div class="title">
      <div class="text">Discout 50 %</div>
    </div>
    <div class="content"><img src="images/dis.png" />Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
  </div>

  <div class="item">
    <div class="icon">7</div>
    <div class="title">Exiting Party Offer</div>
    <div class="content">
      <div class="heart-icon"><img src="images/off3.png" width="200px; height="130px;" /></div>
    </div>
  </div>
</div>
<!-- partial - ->
		
		</div>
		<!-- Row / End - ->

	</div>
	<!-- Container / End - ->

</section>
<!-- Pricing Tables / End -->

<section class="pt-5 pb-5">
  <div class="container">
    <div class="row">
        <div class="col-md-6">
				<h3 class="headline margin-bottom-15">
					Exclusive <span>Offers</span>
				</h3>
				<p class="mb-5 ml-3">We can assist you with your innovation and commercialisation journey!</p>
        </div>
        <div class="col-md-6 slide-arrow">
            <a class="mb-3 mr-3" style="font-size:large; font-weight:inherit;" href="#carouselExampleIndicators21" role="button" data-slide="prev">
                <i class="sl sl-icon-arrow-left" style="font-size:large; font-weight:inherit;"></i>
            </a>
            <a class="mb-3 mr-3" style="font-size:large; font-weight:inherit;" href="#carouselExampleIndicators21" role="button" data-slide="next">
                <i class="sl sl-icon-arrow-right" style="font-size:large; font-weight:inherit;"></i>
            </a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div id="carouselExampleIndicators212" class="carousel slide" data-ride="carousel22">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">                            
													<?php
													$data = array(
							                'key' => $json_key,
							                'action' => 'coupons_code_disp'
							               	);	
							            $result = call_json($data);
							            $cou_count = 0;
					                foreach($result['offers_list'] as $key => $value)
					                {
					                	if($cou_count%4 == 0 && $cou_count != 0)
												  	{
												  		?>
												  			</div>
					                    </div>
					                    <div class="carousel-item">
					                    	<div class="row">
					                    		<?php
												  	}
												  	$cou_count++;
					                	if($result['offers_list'][$key]['discount_type'] == "FIX")
					                		$coupon_dis = "Rs.".$result['offers_list'][$key]['discount_value'];
					                	else
					                		$coupon_dis = $result['offers_list'][$key]['discount_value']."%";
						                ?>
	                            <div class="col-md-3 mb-3">
	                                <div class="card12">
	                                    <img class="img-fluid" alt="100%x280" src="<?php echo $result['offers_list'][$key]['image']; ?>">
	                                    <div class="rate-body">
																	    	<!--<span class="pr-2">From</span>-->
																		 		<h4 class="rate"><?php echo $coupon_dis; ?></h4>
																		 	</div>
																		 	<div class="card-body">
																		 		<h4 class="card-title"><?php echo $result['offers_list'][$key]['name']; ?></h4>   
																				<div class="star-rating mb-2" data-rating="5.0">
																					<div class="rating-counter"></div>
																				</div>
																				<button class="btn btn-details button-color button-radius tt_btncode"><?php echo $result['offers_list'][$key]['coupon_code']; ?></button>										
	                                    </div>
	                                </div>
	                            </div>
	                          <?php
	                        }
	                        ?>
	                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section class="fullwidth border-top  margin-bottom-0 padding-top-10 padding-bottom-15" data-background-color="#ffffff">
	<!-- Logo Carousel -->
	<div class="container">
		<div class="row">
		<div class="col-md-12">
		<h3 class="headline margin-bottom-15">
					Our  <span>Panelists</span>
				</h3>
				<p class="mb-5 ml-3">We can assist you with your innovation and commercialisation journey!</p>
	</div>
						
			<!-- Carousel -->
			<div class="col-md-12">
				<div class="logo-slick-carousel dot-navigation">
					
					<div class="item">
						<img src="images/clients/spring.png" alt="">
					</div>
					<div class="item">
						<img src="images/clients/clix.png" alt="">
					</div>
					
					<div class="item">
						<img src="images/clients/bmr.png" alt="">
					</div>
					
					
				<div class="item">
						<img src="images/clients/cnf.png" alt="">
					</div>
					
					<div class="item">
						<img src="images/clients/beachbay.png" alt="">
					</div> 
<div class="item">
						<img src="images/clients/clickfactory.png" alt="">
					</div>

					
					<div class="item">
						<img src="images/clients/clix.png" alt="">
					</div>
					

				</div>
			</div>
			<!-- Carousel / End -->

		</div>
	</div>
	<!-- Logo Carousel / End -->
</section>

<!-- partial:index.partial.html 
<div class="wrapper">
  <div data-carousel>
	<ul class="slide__list Wallop-list">
			<li class="slide__item Wallop-item Wallop-item--current">
					<h2 class="slide__heading">Testimonial 1</h2>
					<blockquote>
						<p class="slide__quote">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor rhoncus dolor purus non enim praesent elementum facilisis. In est ante in nibh mauris cursus mattis molestie.</p>
						<cite class="slide__cite">AN Author</cite>
					</blockquote>
			</li>
			<li class="slide__item Wallop-item">
				<h2 class="slide__heading">Testimonial 2</h2>
				<blockquote>
					<p class="slide__quote">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
					<cite class="slide__cite">AN Author</cite>
				</blockquote>
			</li>
			<li class="slide__item Wallop-item">
				<h2 class="slide__heading">Testimonial 3</h2>
					<blockquote>
						<p class="slide__quote">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor rhoncus dolor purus non enim praesent elementum facilisis. In est ante in nibh mauris cursus mattis molestie.</p>
						<cite class="slide__cite">AN Author</cite>
					</blockquote>
			</li>
			<li class="slide__item Wallop-item">
				<h2 class="slide__heading">Testimonial 4</h2>
					<blockquote>
						<p class="slide__quote">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Porttitor rhoncus dolor purus non enim praesent elementum facilisis. In est ante in nibh mauris cursus mattis molestie.</p>
						<cite class="slide__cite">AN Author</cite>
					</blockquote>
			</li>
		</ul>
		<button class="button--prev Wallop-buttonPrevious" title="previous">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.9 50.2"><path d="M25.1 50.2L0 25.1 25.1 0l2.8 2.8L5.7 25.1l22.2 22.2z"/></svg>
		</button>
		<button class="button--next Wallop-buttonNext" title="next">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.9 50.2"><path d="M25.1 50.2L0 25.1 25.1 0l2.8 2.8L5.7 25.1l22.2 22.2z"/></svg>
		</button>
	</div>
	 <script src='https://cdnjs.cloudflare.com/ajax/libs/wallop/2.4.1/js/Wallop.min.js'></script>
</div>
<!-- partial -->



<?php include_once('footer.php'); ?>
<script type="text/javascript">
$( document ).ready(function() {
  jQuery('#add_room_btn').on('click', function (e) {
    var k = $( "#sri_val").val();
    $("#sroom_inner_"+k).css("display", "block");
    $("#sroom_inner_"+k+" .sadults").val(1);
    k++;
    $("#sri_val").val(k);
    //$( "#room_select" ).append( $("#sroom_div").html() );
    //$( "#room_select" ).append( $("#sroom_div").html() );
  });
  
  jQuery('#apply_room_btn').on('click', function (e) {
    var tadults = trooms = 0;
    $(".sadults").each(function() {
      if(!isNaN(this.value) && this.value.length!=0) {
        tadults += parseFloat(this.value);
        if(parseFloat(this.value) != 0)
          trooms += 1;
      }
    });
    var tchilderns = 0;
    $(".schilderns").each(function() {
      if(!isNaN(this.value) && this.value.length!=0) {
        tchilderns += parseFloat(this.value);
      }
    });
    var tguests = tadults + tchilderns;

    $("#dropdownMenuButton").html(trooms+" Room(s), "+tguests+" Guest(s)");

  });
});

function rmv_room(v)
{
    $("#sroom_inner_"+v).html("");
    $("#sroom_inner_"+v).css("display", "none");
}
</script>

<script>
var $item = $('.carousel-size');
var $wHeight = $(window).height();

$item.height($wHeight);
$item.addClass('full-screen');

$('.banner img').each(function() {
  var $src = $(this).attr('src');
  var $color = $(this).attr('data-color');
  $(this).parent().css({
    'background-image' : 'url(' + $src + ')',
    'background-color' : $color
  });
  $(this).remove();
});

$(window).on('resize', function (){
  $wHeight = $(window).height();
  $item.height($wHeight);
});

</script>


<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
<script src="scripts/moment.min.js"></script>
<script src="scripts/daterangepicker.js"></script>

<script>
$(function() {

    var start = moment().subtract(0, 'days');
    var end = moment().add(1, 'days');

    function cb(start, end) {
        $('#booking-date-search').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    cb(start, end);
    $('#booking-date-search').daterangepicker({
    	"opens": "right",
	    "autoUpdateInput": true,
	    "alwaysShowCalendars": true,
        startDate: start,
        endDate: end
    }, cb);

    cb(start, end);

});

// Calendar animation and visual settings
$('#booking-date-search').on('show.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-visible calendar-animated bordered-style');
	$('.daterangepicker').removeClass('calendar-hidden');
});
$('#booking-date-search').on('hide.daterangepicker', function(ev, picker) {
	$('.daterangepicker').removeClass('calendar-visible');
	$('.daterangepicker').addClass('calendar-hidden');
});

$(window).on('load', function() {
    $('#booking-date-search').val('');
});
</script>
<script src="scripts/quantityButtons.js"></script>

</body>
</html>