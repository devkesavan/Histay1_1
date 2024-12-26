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

<style>
#dropdownMenuButton
{
	display:none;
}
</style>

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->

<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">
		<div class="col-lg-12 col-md-12 padding-right-30">

			<!-- Titlebar -->
			<div id="titlebar" class="listing-titlebar">
				<div class="listing-titlebar-title">
					<h2><?php echo $result['page_list']['title'];?></h2>
				</div>
			</div>

			<!-- Overview -->
			<div id="listing-overview" class="listing-section">

				<!-- Description -->

				<p><?php echo $result['page_list']['main_content'];?></p>
				
				<div class="clearfix"></div>
			</div>
			
			<div class="row">
			    <div class="col-lg-12 col-md-12 col-12">
			    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62294.23810026196!2d80.1561224546918!3d12.62240852631006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5254aa30074dc5%3A0x9d00999d9ca8933f!2sMahabalipuram%2C%20Tamil%20Nadu%20603104!5e0!3m2!1sen!2sin!4v1629589731424!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			    </div>
			</div>
			<br>	<br>
			  <div class="row">
                    <div class="col-lg-7 col-md-7 col-7">
                        <h2 class="contact-title">Get in Touch</h2>
                   
                   
  <form action="/action_page.php">
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name..">

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name..">

    <label for="subject">Subject</label>
    <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>

    <input type="submit" value="Submit">
  </form>
</div>

<div class="col-lg-5 col-md-5">
                           <!-- about_main_info_start -->
    <div class="about_main_info">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="single_about_info">
                     
                         <h2> Corporate office: </h2><br>
                         <p>
31-A,Gandhi Main road,<br>
Alwarthirunagar,<br>
Chennai<br>  Tamilnadu<br>   India 600087<br>
Phone: +91 95001 23603<br>
E-Mail: support@ecrcheckin.com<br></p>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="single_about_info">
                    <h2>Branch office:</h2>  <br>  
                    <p>
F.No:4, 2nd Floor,Batuil Noor, Ganesapuram,<br>  
Police Kandasamy street,<br>  
Ramanathapuram,<br>  
Coimabatore<br> Tamilnadu<br>  India 641 045<br>  
Phone: +91 63749 40402<br>  
E-Mail: admin@ecrcheckin.com<br>  </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_main_info_end -->
                      
                        
                    </div>
                 
                </div>
                
                 	<br>	<br>
             

		</div>

	</div>
</div>


<?php include_once('footer.php'); ?>

</body>
</html>
