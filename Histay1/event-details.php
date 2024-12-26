<?php
$body_class = "";
include("header.php");

if(isset($_POST['register']))
{
	extract($_POST);

	$data = array(
	'key' => $json_key,
	'action' => 'events_registration',
	'event_id' => $_GET['event_id'],
	'name' => $name, 
	'gender' => $gender,
	'dob' => $dob,
	'email' => $email,  
	'mobile' => $mobile,
	);
	$result = call_json($data);
	if($result)
	{
	  echo "<script>window.location.href='event-details.php?event_id=$_GET[event_id]';</script>";
	} 
}

$data = array(
'key' => $json_key,
'action' => 'members_events',
'event_id' =>$_GET['event_id'],
'sort' => 'ASC',
'limit_st' => '0',
'limit_cnt' => '0',
);
$result = call_json($data);
?>

<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2><?php echo $result['events_List'][0]['event_name']; ?></h2><span></span>

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

	<!-- Blog Posts -->
	<div class="blog-page">
	<div class="row">
		<div class="col-lg-9 col-md-8 padding-right-30">

			<!-- Blog Post -->
			<div class="blog-post">
				
				<!-- Img -->
				<a href="pages-blog-post.html" class="post-img">
					<img src="<?php echo $result['events_List'][0]['image']; ?>" alt="">
				</a>
				
				<!-- Content -->
				<div class="post-content">
					<h3><a href="#"><?php echo $result['events_List'][0]['event_name']; ?></a></h3>

					<ul class="post-meta">
						<li><?php echo $result['events_List'][0]['hotel_address'];?></li>
						<li><a href="#">Tips</a></li>
					</ul>

					<p><?php echo $result['events_List'][0]['description']; ?></p>

					<a href="pages-blog-post.html" class="read-more">Read More <i class="fa fa-angle-right"></i></a>
				</div>

			</div>
			<!-- Blog Post / End -->

		</div>

	<!-- Blog Posts / End -->


	<!-- Widgets -->
	<div class="col-lg-3 col-md-4">
		<div class="sidebar right">

			<!-- Widget -->
			<div class="widget">
				<h3 class="margin-top-0 margin-bottom-25">Register</h3>
				<form method="post" name="contactform" id="contactform" autocomplete="on">

					<div class="row">
						<div class="col-md-12">
							<div>
								<input name="name" type="text" id="name" placeholder="Your Name" required="required" />
							</div>
						</div>

						<div class="col-md-12">
							<div><label>Gender</label>
								<label><input type="radio" name="gender" value="M" required="required" class="tt_radio" /> Male</label>
								<label><input type="radio" name="gender" value="F" required="required" class="tt_radio" /> Female</label>
							</div>
						</div>

						<div class="col-md-12">
							<div>
								<input name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
							</div>
						</div>
					</div>

					<div>
						<input name="subject" type="text" id="subject" placeholder="Subject" required="required" />
					</div>

					<div>
						<textarea name="comments" cols="40" rows="3" id="comments" placeholder="Message" spellcheck="true" required="required"></textarea>
					</div>

					<input type="submit" class="submit button" id="submit" name="register" value="Submit Message" />

				</form>
				<div class="clearfix"></div>
			</div>
			<!-- Widget / End -->

			<!-- Widget -->
			<div class="widget margin-top-40">

				<h3>Popular Posts</h3>
				<ul class="widget-tabs">

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
		                <!-- Post #1 -->
						<li>
							<div class="widget-content">
									<div class="widget-thumb">
									<a href="event-details.php?event_id=<?php echo $result['events_List'][$key]['event_id'];?>"><img src="<?php echo $result['events_List'][$key]['image']; ?>" alt=""></a>
								</div>
								
								<div class="widget-text">
									<h5><a href="event-details.php?event_id=<?php echo $result['events_List'][$key]['event_id'];?>"><?php echo $result['events_List'][$key]['event_name'];?></a></h5>
									<span><?php echo  date("d, M Y", strtotime($result['events_List'][$key]['event_date'])); ?></span>
								</div>
								<div class="clearfix"></div>
							</div>
						</li>
					<?php
					}
					?>
					
					

				</ul>

			</div>
			<!-- Widget / End-->


			<!--
			<div class="widget margin-top-40">
				<h3 class="margin-bottom-25">Social</h3>
				<ul class="social-icons rounded">
					<li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
					<li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>
					<li><a class="gplus" href="#"><i class="icon-gplus"></i></a></li>
					<li><a class="linkedin" href="#"><i class="icon-linkedin"></i></a></li>
				</ul>

			</div>-->

			<div class="clearfix"></div>
			<div class="margin-bottom-40"></div>
		</div>
	</div>
	</div>
	<!-- Sidebar / End -->


</div>
</div>

<?php
include("footer.php");
?>