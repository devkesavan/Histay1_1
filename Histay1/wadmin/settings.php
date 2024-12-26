<?php 
	session_start();
	if(isset($_SESSION['admin_uid']))
	{
		include_once("header.php");
		include_once("db-config.php");
		//DB connect
		$con = new mysqli($host, $user,$pass,$db_name);

		$page_title = "Office Details";
		$sub_page_title = "Office Details";
		$msg_title = "Office";
		$page_url = basename($_SERVER['PHP_SELF']);
		$page_logout ='logout.php';
		$logo = "business_logo/";
		
		//Update click
	if(isset($_POST['update']))
	{
		$business_name 	= mysqli_real_escape_string($con,$_POST['business_name']);
		$name 	         = mysqli_real_escape_string($con,$_POST['name']);
		$address 		= mysqli_real_escape_string($con,$_POST['address']);
		extract($_POST);
		$updated_at 	= date('Y-m-d g:i:s');
		$updated_by 	= $_SESSION['admin_uid'];
		
		echo $ud_query = " update $setting_table set business_name='$business_name',name='$name',business_logo='$business_logo',mobile='$mobile',email='$email',address='$address',city='$city',state='$state',pincode='$pincode',site_title='$site_title',maintenance_mode='$maintenance_mode',main_message='$main_message',sender_email='$sender_email',sender_name='$sender_name',fb_url='$fb_url',insta_url='$insta_url',twitter_url='$twitter_url',youtube_url='$youtube_url',ical_sync='N',auto_ical_sync='N',sync_interval='N',updated_at='$updated_at',updated_by='$updated_by' where id='1'";	
		$ud_result = $con->query($ud_query) or die(mysqli_error($con));
		if($ud_result == true)
		{
			if($_FILES["logo"]["name"] != '')
			{
				$file_name = $_FILES["logo"]["name"];
				$file_ext = explode('.',$file_name);
				$new_file_name = md5("logo").".".$file_ext[1];
				$target_file = $business_logo."".$new_file_name;
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				// Check if image file is a actual image or fake image
				$check = getimagesize($_FILES["logo"]["tmp_name"]);
					if($check !== false) {
						echo "<script>alert('logo is an image - " . $check["mime"] . ".')</script>";
						$uploadOk = 1;
					} else {
						 echo "<script>alert('logo is not an image.')</script>";
						$uploadOk = 0;
					}
				// Check file size
				if ($_FILES["fileToUpload"]["size"] > 500000) {
					echo "<script>alert('Sorry, logo  is too large.')</script>";
					$uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
					$uploadOk = 0;
				}
				if ($uploadOk == 0)
				{
					echo "<script>alert( 'Sorry, logo was not uploaded.')</script>";
				}
				else
				{
					if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) 
					{
						$photo_q = "update $setting_table set business_logo = '".$new_file_name."' where id = '1'";
						$con->query($photo_q) or die(mysqli_error($con));
						echo "<script>alert( 'The file '". basename( $_FILES['logo']['name'])." ' has been uploaded Successfully.')</script>";
					}
					else
					{
						echo "<script>alert( 'Sorry, there was an error uploading logo.')</script>";
					}
				}
			}
			// echo "<script>alert( '$msg_title updated successfully');</script>";
			// echo "<script>window.location.href='$page_url';</script>";
		}
		else{
			echo "<script>alert( '$msg_title update Failed.');</script>";
			echo "<script>window.location.href='$page_url';</script>";
		}		
		$con->close();		
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
										<div class="breadcrumb-item"><a href="settings.php">Settings</a></div>
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
					  <div class="col-12">
						<div class="card">
						  <div class="card-header">
							<h4><?php echo $page_title; ?></h4>
						  </div>
						  
						  <?php
								$con = new mysqli($host, $user,$pass,$db_name); 
								$select_edit = "select * from $setting_table where id='1'";
								$edit_result = $con->query($select_edit) or die(mysqli_error($con));
								$con->close();
								$edit_data = $edit_result->fetch_array();
							?>
						  
						  <div class="card-body">
							<form method="post" action="#"  class="needs-validation" novalidate="" autocomplete="off"  enctype="multipart/form-data" >
						<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Business Name</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="business_name" name="business_name"  value="<?php echo $edit_data['business_name']; ?>"  class="form-control" tabindex="1" />
								<div class="invalid-feedback"> Please fill your Business name </div>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="name" name="name"  value="<?php echo $edit_data['name']; ?>"  class="form-control" tabindex="1" />
								<div class="invalid-feedback"> Please fill The Name </div>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email / Phone</label>
								 <div class="col-sm-12 col-md-4">
									<input type="email" id="email" name="email" value="<?php echo $edit_data['email']; ?>" class="form-control" tabindex="2" >
									<div class="invalid-feedback"> Please fill your office email </div>
								 </div>
								 <div class="col-sm-12 col-md-3">
									<input type="number" id="mobile" name="mobile" value="<?php echo $edit_data['mobile']; ?>"  class="form-control" tabindex="3"  >
									<div class="invalid-feedback"> Please fill your office Phone No </div>
								 </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Office Address</label>
								 <div class="col-sm-12 col-md-7">
									<textarea rows="3" id="address" name="address"  class="form-control"  tabindex="4" > <?php echo $edit_data['address']; ?></textarea>
									<div class="invalid-feedback"> Please fill your office Phone No </div>
								 </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">City / State</label>
								 <div class="col-sm-12 col-md-4">
									<input type="text" name="city" id="city" value="<?php echo $edit_data['city']; ?>"  class="form-control"  tabindex="5" />
									<div class="invalid-feedback"> Please fill your City </div>
								 </div>
								 <div class="col-sm-12 col-md-3">
									<input type="text"  name="state" id="state" value="<?php echo $edit_data['state']; ?>" class="form-control"  tabindex="6" />
									<div class="invalid-feedback"> Please fill your State </div>
								 </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pincode / logo </label>
							   <div class="col-sm-12 col-md-4">
									<input type="text"  name="pincode" id="pincode" value="<?php echo $edit_data['pincode']; ?>" class="form-control"  tabindex="7" />
									<div class="invalid-feedback"> Please fill Pincode </div>
								 </div>
							  <div class="col-sm-12 col-md-3">
								  <input type="file" id="business_logo" name="business_logo" accept="image/*" class="form-control" onchange="document.getElementById('photopreview').src = window.URL.createObjectURL(this.files[0])">
							  </div>							  
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Site Title</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="site_title" name="site_title"  value="<?php echo $edit_data['site_title']; ?>"  class="form-control" tabindex="8"/>
								<div class="invalid-feedback"> Please fill Site Title </div>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Maintenance Mode</label>
							  <div class="col-sm-12 col-md-7">
								 <p>
								 <label><input type="radio" id="maintenance_mode_y" name="maintenance_mode" value="Y" <?php if($edit_data['maintenance_mode'] == "Y") echo "checked"; ?>/> YES</label>&nbsp&nbsp&nbsp
								 <label><input type="radio" id="maintenance_mode_n" name="maintenance_mode" value="N" <?php if($edit_data['maintenance_mode'] == "N") echo "checked"; ?>/> NO</label>
								 </p>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Main Message</label>
							  <div class="col-sm-12 col-md-7">
								<textarea type="text" id="main_message" name="main_message" class="form-control" tabindex="9"><?php echo $edit_data['main_message']; ?></textarea> 
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sender Email</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="sender_email" name="sender_email"  value="<?php echo $edit_data['sender_email']; ?>"  class="form-control" tabindex="8"/>
								<div class="invalid-feedback"> Please fill Sender Email </div>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sender Name</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="sender_name" name="sender_name"  value="<?php echo $edit_data['sender_name']; ?>"  class="form-control" tabindex="8"/>
								<div class="invalid-feedback"> Please fill Sender Name </div>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Facebook Url</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="fb_url" name="fb_url"  value="<?php echo $edit_data['fb_url']; ?>"  class="form-control" tabindex="8"/>
								<div class="invalid-feedback"> Please fill Fb Url </div>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Instgram Url</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="insta_url" name="insta_url"  value="<?php echo $edit_data['insta_url']; ?>"  class="form-control" tabindex="8"/>
								<div class="invalid-feedback"> Please fill Insta Url </div>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Twitter Url</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="twitter_url" name="twitter_url"  value="<?php echo $edit_data['twitter_url']; ?>"  class="form-control" tabindex="8"/>
								<div class="invalid-feedback"> Please fill witter Url </div>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Youtube Url</label>
							  <div class="col-sm-12 col-md-7">
								<input type="text" id="youtube_url" name="youtube_url"  value="<?php echo $edit_data['youtube_url']; ?>"  class="form-control" tabindex="8"/>
								<div class="invalid-feedback"> Please fill Youtube Url </div>
							  </div>
							</div>
							<!-- <div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Enable iCal Syncronization</label>
							  <div class="col-sm-12 col-md-7">
								 <p>
								 <label><input type="radio" id="ical_sync_y" name="ical_sync" value="<?php echo $edit_data['ical_sync_y']; ?>"  /> YES</label>&nbsp&nbsp&nbsp
								 <label><input type="radio" id="ical_sync_n" name="ical_sync" value="<?php echo $edit_data['ical_sync_n']; ?>"  /> NO</label>
								 </p>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Enable Automatic iCal Sync</label>
							  <div class="col-sm-12 col-md-7">
								 <p>
								 <label><input type="radio" id="auto_ical_sync_y" name="auto_ical_sync" value="<?php echo $edit_data['auto_ical_sync_y']; ?>"  /> YES</label>&nbsp&nbsp&nbsp
								 <label><input type="radio" id="auto_ical_sync_n" name="auto_ical_sync" value="<?php echo $edit_data['auto_ical_sync_n']; ?>"  /> NO</label>
								 </p>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Synchronizatiion Interval</label>
							  <div class="col-sm-12 col-md-7">
								 <p>
								 <label><input type="radio" id="sync_interval_y" name="sync_interval" value="<?php echo $edit_data['sync_interval_y']; ?>"/> YES</label>&nbsp&nbsp&nbsp
								 <label><input type="radio" id="sync_interval_n" name="sync_interval" value="<?php echo $edit_data['sync_interval_n']; ?>" /> NO</label>
								 </p>
							  </div>
							</div>
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Synchronizatiion Clock</label>
							  <div class="col-sm-12 col-md-7">
								 <select class="form-control" name="sync_clock" id="sync_clock"/>
								 <option value=''>Select Clock</option>
								 <option value='1'>1.00</option>
								 <option value='2'>2.00</option>
								</select>
							  </div>
							</div> -->
							<div class="form-group row mb-4">
							  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
							  <div class="col-sm-12 col-md-4">
								<button type="submit" name="update" class="btn btn-primary">Update Now</button>
							  </div>
							  <div class="col-sm-12 col-md-3">
								<?php
								   if ($edit_data['business_logo'] == ""){
									   echo "[NO IMAGE]";
								   } else{
									   echo '<img id="photopreview" src="'.$logo.'/'.$edit_data['business_logo'].'" width="100%" />';
								   }
								?>
							  </div>
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