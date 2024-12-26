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
					<h2>Signin</h2>
				</div>
			</div>
			
			  <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                   
                            <form method="post" class="login">

								<p class="form-row2 form-row-wide">
									<label for="username" style="width: 100%;">Email:
										<i class="im im-icon-Male"></i>
										<input type="text" class="input-text" name="email" id="username" value="" />
									</label>
								</p>

								<p class="form-row2 form-row-wide">
									<label for="password" style="width: 100%;">Password:
										<i class="im im-icon-Lock-2"></i>
										<input class="input-text" type="password" name="password" id="password"/>
									</label>
									<span class="lost_password">
										<a href="#" >Lost Your Password?</a>
									</span>
								</p>

								<div class="form-row2">
									<input type="submit" class="button border margin-top-5" name="login" value="Login" />
									<!--<div class="checkboxes margin-top-10">
										<input id="remember-me" type="checkbox" name="check">
										<label for="remember-me">Remember Me</label>
									</div>-->
								</div>
								<div class="form-row2 text-center">
									<br>
									<a class="button border margin-top-5" href="google_login/"><i class="fa fa-google"></i> Continue with Google</a>
									<a class="button border margin-top-5" href="fb_login/"><i class="fa fa-facebook"></i> Continue with Facebook</a>
								</div>
								
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
