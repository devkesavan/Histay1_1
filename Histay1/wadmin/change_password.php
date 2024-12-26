<?php
	session_start();
	if(isset($_SESSION['admin_uid']))
	{
		$uid = $_SESSION['admin_uid'];
		include_once("header.php");
		include_once("db-config.php");

		$page_title = "Change Password";
		$sub_page_title = "Change Password";
		$msg_title = "Password";
		$page_url = basename($_SERVER['PHP_SELF']);
		$page_logout ='logout.php';

		//Update click
		if(isset($_POST['change_password']))
		{
			$current_password = $_POST['current_password'];
			$new_password = $_POST['new_password'];
			$confirm_password = $_POST['confirm_password'];
			//Check already exists
			$con = new mysqli($host, $user,$pass,$db_name);
			if($new_password == $confirm_password)
			{
				$select_check_query = " select id from $admin_table where id='$uid' and paswd='$current_password' ";
				$check_result = $con->query($select_check_query)or die(mysqli_error($con));
				$check_count = $check_result->num_rows;
				if($check_count > 0)
				{
					$update_query = "update $admin_table set paswd='$new_password' where id='$uid'";
					$update_qu = $con->query($update_query) or die(mysqli_error($con));
					if($update_qu == true)
					{
						echo "<script>alert('Password changed successfully!');</script>";
						echo "<script>window.location.href='".$page_logout."';</script>";
					}
					else
					{
						echo "<script>alert('ERROR. Contact administrator.');</script>";
						echo "<script>window.location.href='index.php';</script>";
					}
				}
				else
				{
					echo "<script>alert('Current Password does not match');</script>";
					echo "<script>window.location.href='change-password.php';</script>";
				}
			}
			else
			{
				echo "<script>alert('Password does not match');</script>";
				echo "<script>window.location.href='change-password.php';</script>";
			}
		}
?>
	<!-- Section Start -->
        <section class="section">
          <div class="section-header">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div class="section-header-breadcrumb-content">
									<h1><?php echo $page_title; ?></h1>
									  <div class="section-header-breadcrumb">
										<div class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a></div>
										<div class="breadcrumb-item"><a href="#profile.php">Profile</a></div>
										<div class="breadcrumb-item"><a href="change-password.php">Change Password</a></div>
									  </div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div class="section-header-breadcrumb-chart float-right">
									<div class="breadcrumb-chart m-l-50">
										<div class="float-right">
											<div class="icon m-b-10">
												<div class="chart header-bar">
													<canvas width="49" height="40" ></canvas>
												</div>
											</div>
										</div>
										<div class="float-right m-r-5 m-l-10 m-t-1">
											<div class="chart-info">
												<span>$10,415</span>
												<p>Last Week</p>
											</div>
										</div>
									</div>

									<div class="breadcrumb-chart m-l-50">
										<div class="float-right">
											<div class="icon m-b-10">
												<div class="chart header-bar2">
													<canvas width="49" height="40" ></canvas>
												</div>
											</div>
										</div>
										<div class="float-right m-r-5 m-l-10 m-t-1">
											<div class="chart-info">
												<span>$22,128</span>
												<p>Last Month</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				  <div class="section-body">
					<div class="row">

					  <div class="col-12 col-md-5 col-lg-5 m-auto">
						<div class="card">
						  <div class="card-header">
							<h4>Change Password</h4>
						  </div>
						  <div class="card-body">
							  <form method="POST" action="#" class="needs-validation" novalidate="" autocomplete="off">
									<div class="form-group">
									  <label> Old Password</label>
									  <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text">
											<i class="fas fa-lock"></i>
										  </div>
										</div>
										<input type="password" id="current_password" name="current_password" class="form-control" tabindex="1" required autofocus>
										<div class="invalid-feedback">
										  Please fill in your Old Password
										</div>
									  </div>
									</div>
									<div class="form-group">
									  <label>New Password</label>
									  <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text">
											<i class="fas fa-key"></i>
										  </div>
										</div>
										<input type="password"id="new_password" name="new_password" class="form-control" tabindex="2" required>
										<div class="invalid-feedback">
										  Please enter new Password
										</div>
									  </div>
									  <div id="pwindicator" class="pwindicator">
										<div class="bar"></div>
										<div class="label"></div>
									  </div>
									</div>
									<div class="form-group">
									  <label>Confirm Password</label>
									  <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text">
											<i class="fas fa-key"></i>
										  </div>
										</div>
										<input type="password" id="confirm_password" name="confirm_password" class="form-control" tabindex="3" required>
										<div class="invalid-feedback" id="pass_alert">
										  Password not Match
										</div>
									  </div>
									</div>
									<div class="form-group">
										<button type="submit" name="change_password" class="btn btn-lg btn-block btn-auth-color"> Change Password </button>
									</div>
							</form>
						  </div>
						</div>
					  </div>

					  </div>
					 </div>

		 </section>
		<!-- Section Start -->
		<?php
			include('footer.php');
			} else {
				echo "<script>window.location.href='login.php';</script>";
			}
		?>
		<script>
			$(document).ready(function () {
			   $("#confirm_password").keyup(checkPasswordMatch);
			});
			//password match
			function checkPasswordMatch() {
				var password = $("#new_password").val();
				var confirmPassword = $("#confirm_password").val();
				if (password != confirmPassword)
				{
					$("#pass_alert").fadeIn().html('<span><strong>Passwords do not match!</strong></span>');
				}
				else
				{
					$("#pass_alert").fadeOut(1000,0).html('<span><strong> Passwords match</strong></span>');
				}
			}
		</script>
