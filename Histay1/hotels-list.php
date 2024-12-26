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
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
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

			<?php
			$_SESSION['check_in_out'] = $_GET['check_in_out'];
			$check_io = explode(" - ",$_GET['check_in_out']);
			$_SESSION['check_in'] = date('Y-m-d', strtotime($check_io[0]));
			$disp_checkin = date('m/d/Y', strtotime($check_io[0]));
			$_SESSION['check_out'] = date('Y-m-d', strtotime($check_io[1]));
			$disp_checkout = date('m/d/Y', strtotime($check_io[1]));

			foreach($_GET['adults'] as $key => $v)
			{
				if(trim($v) != 0)
				{
					$adults[] = trim($v);
					$childerns[] = trim($_GET['childerns'][$key]);
				}
			}
			?>

			<!-- Search -->
			<section class="search tt_sfilter tt_hlsearch">

				<div class="row">
					<div class="col-md-12">

							<form method="get" class="" action="hotels-list.php">
								<div class="main-search-input">
									<!--<div class="main-search-input-item">
										<input type="text" placeholder="Destinations" value=""/>
									</div>-->
									<div class="main-search-input-item">
										<select data-placeholder="Destinations" class="form-control" name="destination_id">
											<option value="">Destination</option>
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
            				                  	$sel_att = "";
            				                  	if(isset($_GET['destination_id']))
            				                  	{
            				                  		if($_GET['destination_id'] == $result['destination_list'][$key]['destination_id'])
            				                  			$sel_att = "selected";
            				                  	}
            				                  ?>
            				                    <option value="<?php echo $result['destination_list'][$key]['destination_id'];?>" <?php echo $sel_att; ?>><?php echo $result['destination_list'][$key]['name'];?></option>
            				                    <?php
            				                  }
            				                ?>
            				            </select>
									</div>
									<div class="main-search-input-item">
										<select data-placeholder="Destinations" class="form-control" name="property_type_id">
											<option value="">Property Type</option>
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
            				                  foreach($result['property_type_list'] as $key => $value)
            				                  {
            				                  	$sel_att = "";
            				                  	if(isset($_GET['property_type_id']))
            				                  	{
            				                  		if($_GET['property_type_id'] == $result['property_type_list'][$key]['property_type_id'])
            				                  			$sel_att = "selected";
            				                  	}
            				                  ?>
            				                    <option value="<?php echo $result['property_type_list'][$key]['property_type_id'];?>" <?php echo $sel_att; ?>><?php echo $result['property_type_list'][$key]['name'];?></option>
            				                    <?php
            				                  }
            				                ?>
            				            </select>
									</div>
                                </div>
                                <div class="main-search-input b">
									<div class="main-search-input-item location">
										<div id="autocomplete-container">
											<input type="text" placeholder="<?php echo $disp_checkin." - ".$disp_checkout; ?>" id="booking-date-search" name="check_in_out" autocomplete="off" required value="">
										</div>
										<a href="#"><i class="fa fa-calender"></i></a>
									</div>

									<div class="main-search-input-item">
									    <?php
									    $total_guests = 0;
									    $total_rooms = 0;
									    foreach($_GET['adults'] as $k => $v)
									    {
									        if($v != 0)
									        {
									            $total_rooms++;
									            $total_guests += $_GET['adults'][$k] + $_GET['childerns'][$k];
									        }
									    }
									    ?>
										<div class="panel-dropdown">
											<a href="#" id="dropdownMenuButton"><?php echo $total_rooms; ?> Room(s), <?php echo $total_guests; ?> Guest(s) <span class="qtyTotal" name="qtyTotal">1</span></a>
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
									<button class="button" onclick="window.location">Search</button>
								</div>
							</form>

							<div class="tt_sort_filter">
								<span>Sort By: </span>
								<!-- Box -->
								<?php
								$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
								?>
								<a href="<?php echo $url."&sort_by=1"; ?>" class="tt_filter_btn">
							    	<i class="fa fa-thumbs-up"></i> Our Top Picks
								</a>
								<a href="<?php echo $url."&sort_by=2"; ?>" class="tt_filter_btn">
							    	<i class="fa fa-star"></i> Top Rating
								</a>	
								<a href="<?php echo $url."&sort_by=3"; ?>" class="tt_filter_btn">
							    	<i class="fa fa-long-arrow-up"></i> Price (Lowest first)
								</a>	
							</div>
					</div>
				</div>

			</section>
			<!-- Search / End -->

			<?php
			if(isset($_GET['search']))
			{
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
    
    	   		if(isset($_GET['property_type_id']))
    	   			$property_type_id = $_GET['property_type_id'];
    	   		else
    	   			$property_type_id = 0;
    
    	   		if(isset($_GET['sort_by']))
    	   		{
    	   			if($_GET['sort_by'] == "1")
    	   			{
    	   				$sort_type = "sort_no";
    	   				$sort_order = "ASC";
    	   			}
    	   			elseif($_GET['sort_by'] == "2")
    	   			{
    	   				$sort_type = "rating";
    	   				$sort_order = "DESC";
    	   			}
    	   			elseif($_GET['sort_by'] == "3")
    	   			{
    	   				$sort_type = "price";
    	   				$sort_order = "ASC";
    	   			}
    	   		}
    	   		else
    	   		{
    	   			$sort_type = "sort_no";
     					$sort_order = "ASC";
    	   		}
    
    	        $data = array(
    	        'key' => $json_key,
    	        'action' => 'hotel_list_wmi',
    	        'destination_id' => $destination_id,
    	        'property_type_id' => $property_type_id,
    	        'sort_type' => $sort_type,
    	        'sort' => $sort_order,
    	        'slug' =>'',
    	        'limit_st' => '0',
    	        'limit_cnt' => '0',
    	       	);
	  	    }
	        $result = call_json($data);
            ?>

		<section class="listings-container margin-top-30">
			<!-- Sorting / Layout Switcher -->
			<div class="row fs-switcher">

				<div class="col-md-6">
					<!-- Showing Results -->
					<p class="showing-results"><?php echo count($result['hotels_list']); ?> Results Found </p>
				</div>

			</div>


			<!-- Listings -->
			<div class="row fs-listings">

				<?php
        foreach($result['hotels_list'] as $key => $value)
        {
        	$hotel_id[] = $result['hotels_list'][$key]['hotel_id'];
        	$discount_percentage = 100 - round(100 / ($result['hotels_list'][$key]['actual_cost'] / $result['hotels_list'][$key]['cost']));
          ?>
					<div class="col-lg-12 col-md-12">
						<div class="listing-item-container list-layout">
							
							<div class="listing-item">	
								<!-- Image -->
								<div class="listing-item-image">
									<div id="gallery<?php echo $result['hotels_list'][$key]['hotel_id']; ?>" style="display:none;min-width:300px !important;">
										<?php
										foreach($result['hotels_list'][$key]['hotel_images'] as $ikey => $ivalue)
										{
											?>
											<img alt="Preview Image 1"
												 src="<?php echo $ivalue['hotel_image'];?>"
												 data-image="<?php echo $ivalue['hotel_image'];?>"
												 data-description="Preview Image 1 Description" style="top:0 !important;">
											<?php
										}	
										?>										
									</div>
									<span class="tag"><?php echo $result['hotels_list'][$key]['star']; ?> Star</span>
								</div>
															
								<!-- Content -->
								<div class="listing-item-content">
									<a href="hotel-details.php?hotel=<?php echo $result['hotels_list'][$key]['slug']; ?>">
										<div class="listing-badge now-open"><?php echo $discount_percentage; ?>% OFF</div>

										<div class="listing-item-inner">
											<h4><?php echo $result['hotels_list'][$key]['property_type']; ?></h4>
											<h3><?php echo $result['hotels_list'][$key]['name']; ?> <i class="verified-icon"></i></h3>
											<span><i class="fa fa-map-marker"></i> <?php echo $result['hotels_list'][$key]['address']; ?></span>
											<div class="star-rating" data-rating="<?php echo $result['hotels_list'][$key]['rating']; ?>">
												<div class="rating-counter">(<?php echo $result['hotels_list'][$key]['review_count']; ?> reviews)</div>
											</div>

											<div>
												<h5>Starts from ₹<?php echo $result['hotels_list'][$key]['cost']; ?> 
													<span class="line-through">₹<?php echo $result['hotels_list'][$key]['actual_cost']; ?></span> / Per night</h5>
											</div>
										</div>
										<!--<span class="like-icon"></span>-->
									</a>
								</div>
							</div>
						</div>
					</div>					
					<?php
        	}
      	?>
			</div>
			<!-- Listings Container / End -->

			<!-- Pagination Container -->
			<div class="row fs-listings">
				<div class="col-md-12">

					<!--
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12">
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
					-->
					
					<!-- Copyrights -->
					<div class="copyrights margin-top-0">© 2021 ECRCheckin. All Rights Reserved.</div>

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

<?php //include_once('footer.php'); ?>

<?php
if(basename($_SERVER['PHP_SELF']) != "hotel-details.php")
    echo '<script type="text/javascript" src="scripts/jquery-3.5.1.min.js"></script>';
?>
<script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>.
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="scripts/mmenu.min.js"></script>
<script type="text/javascript" src="scripts/chosen.min.js"></script>
<script type="text/javascript" src="scripts/slick.min.js"></script>
<script type="text/javascript" src="scripts/rangeslider.min.js"></script>
<script type="text/javascript" src="scripts/magnific-popup.min.js"></script>
<script type="text/javascript" src="scripts/waypoints.min.js"></script>
<script type="text/javascript" src="scripts/counterup.min.js"></script>
<script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="scripts/tooltips.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>

<script type="text/javascript" src="scripts/customs/scriptown.js"></script>
 <script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.1/vue.min.js'></script>
<script type="text/javascript" src="scripts/customs/scriptresort.js"></script>


<!-- REVOLUTION SLIDER SCRIPT -->
<script type="text/javascript" src="scripts/themepunch.tools.min.js"></script>
<script type="text/javascript" src="scripts/themepunch.revolution.min.js"></script>

<script type="text/javascript">
	var tpj=jQuery;			
	var revapi4;
	tpj(document).ready(function() {
		if(tpj("#rev_slider_4_1").revolution == undefined){
			revslider_showDoubleJqueryError("#rev_slider_4_1");
		}else{
			revapi4 = tpj("#rev_slider_4_1").show().revolution({
				sliderType:"standard",
				jsFileLocation:"scripts/",
				sliderLayout:"auto",
				dottedOverlay:"none",
				delay:9000,
				navigation: {
					keyboardNavigation:"off",
					keyboard_direction: "horizontal",
					mouseScrollNavigation:"off",
					onHoverStop:"on",
					touch:{
						touchenabled:"on",
						swipe_threshold: 75,
						swipe_min_touches: 1,
						swipe_direction: "horizontal",
						drag_block_vertical: false
					}
					,
					arrows: {
						style:"zeus",
						enable:true,
						hide_onmobile:true,
						hide_under:600,
						hide_onleave:true,
						hide_delay:200,
						hide_delay_mobile:1200,
						tmp:'<div class="tp-title-wrap"></div>',
						left: {
							h_align:"left",
							v_align:"center",
							h_offset:40,
							v_offset:0
						},
						right: {
							h_align:"right",
							v_align:"center",
							h_offset:40,
							v_offset:0
						}
					}
					,
					bullets: {
				enable:false,
				hide_onmobile:true,
				hide_under:600,
				style:"hermes",
				hide_onleave:true,
				hide_delay:200,
				hide_delay_mobile:1200,
				direction:"horizontal",
				h_align:"center",
				v_align:"bottom",
				h_offset:0,
				v_offset:32,
				space:5,
				tmp:''
					}
				},
				viewPort: {
					enable:true,
					outof:"pause",
					visible_area:"80%"
			},
			responsiveLevels:[1200,992,768,480],
			visibilityLevels:[1200,992,768,480],
			gridwidth:[1180,1024,778,480],
			gridheight:[500,500,400,300],
			lazyType:"none",
			parallax: {
				type:"mouse",
				origo:"slidercenter",
				speed:2000,
				levels:[2,3,4,5,6,7,12,16,10,25,47,48,49,50,51,55],
				type:"mouse",
			},
			shadow:0,
			spinner:"off",
			stopLoop:"off",
			stopAfterLoops:-1,
			stopAtSlide:-1,
			shuffle:"off",
			autoHeight:"off",
			hideThumbsOnMobile:"off",
			hideSliderAtLimit:0,
			hideCaptionAtLimit:0,
			hideAllCaptionAtLilmit:0,
			debugMode:false,
			fallbacks: {
				simplifyAll:"off",
				nextSlideOnWindowFocus:"off",
				disableFocusListener:false,
			}
		});
		}
	});	/*ready*/
</script>	

<script>
jQuery(document).ready(function($){
	var $form_modal = $('.cd-user-modal'),
		$form_login = $form_modal.find('#cd-login'),
		$form_signup = $form_modal.find('#cd-signup'),
		$form_forgot_password = $form_modal.find('#cd-reset-password'),
		$form_modal_tab = $('.cd-switcher'),
		$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
		$tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
		$forgot_password_link = $form_login.find('.cd-form-bottom-message a'),
		$back_to_login_link = $form_forgot_password.find('.cd-form-bottom-message a'),
		$main_nav = $('.main-nav');

	//open modal
	$main_nav.on('click', function(event){

		if( $(event.target).is($main_nav) ) {
			// on mobile open the submenu
			$(this).children('ul').toggleClass('is-visible');
		} else {
			// on mobile close submenu
			$main_nav.children('ul').removeClass('is-visible');
			//show modal layer
			$form_modal.addClass('is-visible');	
			//show the selected form
			( $(event.target).is('.cd-signup') ) ? signup_selected() : login_selected();
		}

	});

	//close modal
	$('.cd-user-modal').on('click', function(event){
		if( $(event.target).is($form_modal) || $(event.target).is('.cd-close-form') ) {
			$form_modal.removeClass('is-visible');
		}	
	});
	//close modal when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$form_modal.removeClass('is-visible');
	    }
    });

	//switch from a tab to another
	$form_modal_tab.on('click', function(event) {
		event.preventDefault();
		( $(event.target).is( $tab_login ) ) ? login_selected() : signup_selected();
	});

	//hide or show password
	$('.hide-password').on('click', function(){
		var $this= $(this),
			$password_field = $this.prev('input');
		
		( 'password' == $password_field.attr('type') ) ? $password_field.attr('type', 'text') : $password_field.attr('type', 'password');
		( 'Hide' == $this.text() ) ? $this.text('Show') : $this.text('Hide');
		//focus and move cursor to the end of input field
		$password_field.putCursorAtEnd();
	});

	//show forgot-password form 
	$forgot_password_link.on('click', function(event){
		event.preventDefault();
		forgot_password_selected();
	});

	//back to login from the forgot-password form
	$back_to_login_link.on('click', function(event){
		event.preventDefault();
		login_selected();
	});

	function login_selected(){
		$form_login.addClass('is-selected');
		$form_signup.removeClass('is-selected');
		$form_forgot_password.removeClass('is-selected');
		$tab_login.addClass('selected');
		$tab_signup.removeClass('selected');
	}

	function signup_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.addClass('is-selected');
		$form_forgot_password.removeClass('is-selected');
		$tab_login.removeClass('selected');
		$tab_signup.addClass('selected');
	}

	function forgot_password_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.removeClass('is-selected');
		$form_forgot_password.addClass('is-selected');
	}

	//REMOVE THIS - it's just to show error messages 
	$form_login.find('input[type="submit"]').on('click', function(event){
		event.preventDefault();
		$form_login.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
	});
	$form_signup.find('input[type="submit"]').on('click', function(event){
		event.preventDefault();
		$form_signup.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
	});


	//IE9 placeholder fallback
	//credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
	if(!Modernizr.input.placeholder){
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
		  	}
		}).blur(function() {
		 	var input = $(this);
		  	if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.val(input.attr('placeholder'));
		  	}
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
		  	$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
			 		input.val('');
				}
		  	})
		});
	}

});


//credits https://css-tricks.com/snippets/jquery/move-cursor-to-end-of-textarea-or-input/
jQuery.fn.putCursorAtEnd = function() {
	return this.each(function() {
    	// If this function exists...
    	if (this.setSelectionRange) {
      		// ... then use it (Doesn't work in IE)
      		// Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      		var len = $(this).val().length * 2;
      		this.setSelectionRange(len, len);
    	} else {
    		// ... otherwise replace the contents with itself
    		// (Doesn't work in Google Chrome)
      		$(this).val($(this).val());
    	}
	});
};

jQuery('#cody-info ul li').eq(1).on('click', function(){
$('#cody-info').hide();
});
</script>

<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
	(Load Extensions only on Local File Systems ! 
	The following part can be removed on Server for On Demand Loading) -->	
<script type="text/javascript" src="scripts/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.migration.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="scripts/extensions/revolution.extension.video.min.js"></script>


<!--<script type="text/javascript" src="scripts/jquery-3.5.1.min.js"></script>-->
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


<script type='text/javascript' src='unitegallery/js/unitegallery.js'></script>	
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
<script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>


