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

<style>

.fullscreen {
	height: 100vh;
	width: 100vw;
	display: flex;
	justify-content: center;
	overflow-y: scroll;
}

/* team container */

.team {
	display: flex;
	flex-direction: column;
	align-items: center;
	height: 300px;
	width: 40%;

}

.team-card {
	position: relative;
	width: 70%;
	height: 450px;
	margin-top: 50px;
	margin-bottom: 50px;
	box-shadow: 0px 6px 10px 2px rgba(167, 167, 167, 0.089);
	background-color: lightblue;
}

.team-text {
	box-sizing: border-box;
	position: absolute;
	bottom: 0;
	background-color: white;
	height: 100px;
	width: 100%;
	padding: 20px 20px 20px 20px;
}
    
</style>

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
   
   <!--Start-->
   
   <div class="row col-md-12">
      <img src="images\abt1.PNG" />
        <img src="images\abt2.PNG" />
          <img src="images\abt3.PNG" />

</div><
   
   
   
   <!-- end -->
			

		</div>

	</div>
</div>


<?php include_once('footer.php'); ?>

</body>
</html>
