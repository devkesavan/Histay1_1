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
					<h2>Signup</h2>
				</div>
			</div>
			
			  <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                   
                            <form method="post" class="register">
								
							<p class="form-row2 form-row-wide">
								<label for="username2" style="width: 100%;">Name:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="name" id="username2" value="" />
								</label>
							</p>

							<p class="form-row2 form-row-wide">
								<label for="email2" style="width: 100%;">Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="address" id="email2" value="" />
								</label>
							</p>
								
							<p class="form-row2 form-row-wide">
								<label for="email2" style="width: 100%;">Email Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="email" id="email2" value="" />
								</label>
							</p>

							<p class="form-row2 form-row-wide">
								<label for="password1" style="width: 100%;">Mobile:
									<i class="im im-icon-Lock-2"></i>
									<input class="input-text" type="text" name="mobile" id="password1"/>
								</label>
							</p>

							<p class="form-row2 form-row-wide">
								<label for="password2" style="width: 100%;">Password:
									<i class="im im-icon-Lock-2"></i>
									<input class="input-text" type="password" name="password" id="password2"/>
								</label>
							</p>

							<input type="submit" class="button border fw margin-top-10" name="create_account" value="Register" />
	
							</form>
</div>

                 
                </div>
                
                 	<br>	<br>
             

		</div>

	</div>
</div>


<?php include_once('footer.php'); ?>

</body>
</html>
