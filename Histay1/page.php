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
<link rel="stylesheet" href="css/customs/styleown.css">
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="css/customs/stylecorrect.css">
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

				<p><?php echo $result['page_list']['main_content'];?></p>
				
				<div class="clearfix"></div>
			</div>		

		</div>

	</div>
</div>


<?php include_once('footer.php'); ?>

</body>
</html>
