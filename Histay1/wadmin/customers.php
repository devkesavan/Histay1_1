<?php 
	session_start();
	if(isset($_SESSION['admin_uid']))
	{
		include_once("header.php");
		include_once("db-config.php");
		//DB connect
		$con = new mysqli($host, $user,$pass,$db_name);
		
		$update = false;
		$select = false;
		
		$page_title = "User Details";
		$sub_page_title = "User Details";
		$msg_title = "User";
		$page_url = basename($_SERVER['PHP_SELF']);	
		
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
										<div class="breadcrumb-item"><a href="index.php">Home</a></div>
										<div class="breadcrumb-item"><a href="customers.php"> Customer Master</a></div>
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
					  <!-- card Start -->
						<div class="card">
							 <div class="card-header">
								<h4><?php echo $page_title; ?></h4>
							<!-- <div class="card-header-action">
									<button type="button" id="customermodal" class="btn btn-success">Add New</button>
								</div> -->
							 </div>
							 <div class="card-body">
								<div id="customer-table"></div>
							  </div>
						</div> <!-- card End -->
					  </div>
					</div>
				 </div>			 
			</section>
		<!-- Section Start -->
			
			
			
		
					<!-- Modal Popup Start -->
						<div class="modal fade" id="formModal" tabindex="-1" role="dialog"
						  aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
						  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							<form id="register_form" method="POST" enctype="multipart/form-data" autocomplete="off">									
							    <div class="modal-body">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
											  <label class="sr-only"> Register No</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-address-card"></i>
												  </div>
												</div>
												<input type="text" id="registerno" name="registerno" class="form-control" placeholder="Your Register No" readonly />
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Email</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-envelope"></i>
												  </div>
												</div>
												<input type="email" id="email" name="email" class="form-control" placeholder="Enter Email address" required="">
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Password</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-lock"></i>
												  </div>
												</div>
												<input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required="" readonly >
											  </div>
											</div>
											
											
											
											
											
											<div class="form-group">
											  <label class="sr-only"> First Name</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fab fa-etsy"></i>
												  </div>
												</div>
												<input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" required="">
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Last Name</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fab fa-etsy"></i>
												  </div>
												</div>
												<input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" required="">
											  </div>
											</div>
											<div class="form-group">
											  <label class="sr-only"> Full Name</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fab fa-etsy"></i>
												  </div>
												</div>
												<input type="text" id="fullname" name="fullname" class="form-control" placeholder="Full Name" required="">
											  </div>
											</div>
											<div class="form-group">
											  <label class="sr-only"> Addresss</label>
											  <textarea rows="3" id="addressone" name="addressone" class="form-control" placeholder="Addresss-1" required=""></textarea>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Mobile No</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-mobile-alt"></i>
												  </div>
												</div>
												<input type="text" id="mobileno" name="mobileno" class="form-control" placeholder="Mobile No" required="">
											  </div>
											</div>
											<div class="form-group">
											  <label class="sr-only"> Date of Birth</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-calendar-alt"></i>
												  </div>
												</div>
												<input type="text" id="dob" name="dob" class="form-control datepicker" placeholder="Date of Birth" required />
											  </div>
											</div>
											<div class="form-group">
											  <label class="sr-only"> Identification</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-user-check"></i>
												  </div>
												</div>
												<input type="text" id="identification" name="identification" class="form-control" placeholder="Identification Mark" required="">
											  </div>
											</div>
											<div class="form-group">
											  <label class="sr-only"> Qualification</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-bookmark"></i>
												  </div>
												</div>
												<input type="text" id="qualification" name="qualification" class="form-control" placeholder="Qualification" required="">
											  </div>
											</div>
											
																					
										</div> <!-- col-6 End -->
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
											  <label class="sr-only"> Father Name</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-id-badge"></i>
												  </div>
												</div>
												<input type="text" id="fathername" name="fathername" class="form-control" placeholder="Father Name" required="">
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Blood Group</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-file-medical-alt"></i>
												  </div>
												</div>
												<input type="text" id="bloodgroup" name="bloodgroup" class="form-control" placeholder="Blood Group" required="">
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Joining Date</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-calendar-alt"></i>
												  </div>
												</div>
												<input type="text" id="joindate" name="joindate" class="form-control datepicker" placeholder="Joining Date" required />
											  </div>
											</div>
											
											<div class="form-group mb-2">
											  <label class="sr-only"> DL Number</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-id-card"></i>
												  </div>
												</div>
												<input type="number" id="dlnumber" name="dlnumber" class="form-control" placeholder="DL Number" >
											  </div>
											</div>	
											<div class="form-check form-check-inline">
											  <label class="form-check-label font-weight-bold">Gender</label>
											</div>
											<div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="gender" id="gender" value="M" required >
											  <label class="form-check-label" for="inlineRadio1">Male</label>
											</div>
											<div class="form-check form-check-inline">
											  <input class="form-check-input" type="radio" name="gender" id="gender" value="F">
											  <label class="form-check-label" for="inlineRadio2">Female</label>
											</div>
											
											
											
											
											<div class="form-group my-3">
											  <label class="sr-only"> Addresss-2</label>
											  <textarea rows="3" id="addresstwo" name="addresstwo" class="form-control" placeholder="Addresss-2" required=""></textarea>
											</div>
											
											
											
											<div class="form-group">
											  <label class="sr-only"> Anniversary Date</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-calendar-alt"></i>
												  </div>
												</div>
												<input type="text" id="anniverdate" name="anniverdate" class="form-control datepicker" placeholder="Anniversary Date Name" required="">
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Adhaar Card</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type="text" id="adhaarcardno" name="adhaarcardno" class="form-control" placeholder="Adhaar Card Number" required="">
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Completion Date</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-calendar-alt"></i>
												  </div>
												</div>
												<input type="text" id="completiondate" name="completiondate" class="form-control datepicker" placeholder="Completion Date" required="">
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Due Date</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-calendar-alt"></i>
												  </div>
												</div>
												<input type="text" id="duedate" name="duedate" class="form-control datepicker" placeholder="Due Date" required="">
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="sr-only"> Appointment Date</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-calendar-alt"></i>
												  </div>
												</div>
												<input type="text" id="appointmentdate" name="appointmentdate" class="form-control datepicker" placeholder=" Appointment Date" required="">
											  </div>
											</div>
											
											
											
											<div class="form-group">
											  <label class="sr-only"> Branch</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-home"></i>
												  </div>
												</div>
												<select id="branch_id" name="branch_id" class="form-control" required>
													<option value=''> -- Select Branch -- </option>
													<?php
														$sel_q ="select * from $branch where status='A'";
														$sel_res = $con->query($sel_q) or die(mysqli_error($con));
														if($sel_res->num_rows>0)
														{
															while($branchdata = $sel_res->fetch_array())
															{
																echo "<option value='$branchdata[branch_id]'>$branchdata[shortname]</option>";
															}
														}
													?>
												 </select>
											  </div>
											</div>
										</div>									
									</div> <!-- row End -->
									
									<div class="row">
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Document Type</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<select id="document_type" name="document_type" class="form-control" required>
													<option value=''> -- Select Document -- </option>
													<option value="IN">Insurance </option>
													<option value="FT" selected="">Fitness Certificate</option>
													<option value="PM">Permit</option>
													<option value="TX">Tax</option>
													<option value="OT">Others</option>
												 </select>
											  </div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Document File</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type="file" id="document" name="document" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="documentpre.src=window.URL.createObjectURL(this.files[0])" required />
											  </div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Photo <small> size: W * H (180px * 240px)</small></label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type="file" id="photo" name="photo" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="photopre.src=window.URL.createObjectURL(this.files[0])" required />
											  </div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Aadhaar Front</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type="file" id="adhaarfront" name="adhaarfront" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="adhaarone.src=window.URL.createObjectURL(this.files[0])" required />
											  </div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Aadhaar Back</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type="file" id="adhaarback" name="adhaarback" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="adhaartwo.src=window.URL.createObjectURL(this.files[0])" required />
											  </div>
											</div>
										</div>
																		
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Blood Group Certificate</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-certificate"></i>
												  </div>
												</div>
												<input type="file" id="bloodgroupcerti" name="bloodgroupcerti" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="bloodgroupcerpre.src=window.URL.createObjectURL(this.files[0])" required />
											  </div>
											</div>
										</div>
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Pancard</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type="file" id="pancard" name="pancard" class="form-control"  onchange="checkFile(this)" accept="image/*" oninput="pancardpre.src=window.URL.createObjectURL(this.files[0])" required />
											  </div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Passport</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="fas fa-passport"></i>
												  </div>
												</div>
												<input type="file" id="passport" name="passport" class="form-control"  onchange="checkFile(this)" accept="image/*" oninput="passportpre.src=window.URL.createObjectURL(this.files[0])" required />
											  </div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Payment For</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<select id="payment_for" name="payment_for" class="form-control" required>
													<option value=''> -- Select one -- </option>
													<option value="DL" selected="">Driving License</option>
													<option value="RC">RC</option>
													<option value="LL">LLR</option>
													<option value="RW">Renewal</option>
												 </select>
											  </div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Payment Type</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<select id="payment_type" name="payment_type" class="form-control" required>
													<option value=''> -- Select Type -- </option>
													<option value="CA" selected=""> Cash Payment</option>
													<option value="CH"> Cheque</option>
													<option value="ON"> Online Pay</option>
													<option value="NP">  Notpaid</option>
												 </select>
											  </div>
											</div>
										</div>
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Total Amount</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type="number" id="totalamount" name="totalamount" class="form-control" placeholder="Total Amount" required />
											  </div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Paid Amount</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type="number" id="totalpay" name="totalpay" class="form-control" placeholder="Total Pay" required />
											  </div>
											</div>
										</div>
										<div class="col-lg-4 col-md-12 col-sm-12">											
											<div class="form-group">
											  <label> Balance Amount</label>
											  <div class="input-group">
												<div class="input-group-prepend">
												  <div class="input-group-text">
													<i class="far fa-id-card"></i>
												  </div>
												</div>
												<input type='text' name='balance' id='balance' value='0' class="form-control" readonly >
											  </div>
											</div>
										</div>
									</div>
									
									<div class="row">										
										<div class="col-lg-2 col-md-3 col-sm-4">
										    <img id="documentpre" src="" class="img-fluid" />
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4">
											<img id="photopre" src="" class="img-fluid" />
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4">
											<img id="adhaarone" src="" class="img-fluid" />
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4">
											<img id="adhaartwo" src="" class="img-fluid" />		
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4">
											<img id="bloodgroupcerpre" src="" class="img-fluid" />
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4">
											<img id="pancardpre" src="" class="img-fluid" />
										</div>
										<div class="col-lg-2 col-md-3 col-sm-4">
											<img id="passportpre" src="" class="img-fluid" />
										</div>
									</div> <!-- row End -->
							  </div> <!-- modal-body End -->
							  
							  <div class="modal-footer bg-whitesmoke br">
									<input type="hidden" id="customerId" name="customerId" value="0" /> 
									<input type="hidden" id="page" name="page" value="customer_registration" />
									<input type="hidden" id="action" name="action" value="customer_add" />
									<input type="submit" name="save" id="save" class="btn btn-auth-color" value="Save" />								
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							  </div>
							  </form>
							</div>
						  </div>
						</div>
					<!-- Modal Popup End -->
		
		
		<?php
			include('footer.php');
		?>
		<script>
		     //file upload validation
			    function checkFile(item){
        			var extension = $(item).val().split('.').pop().toLowerCase();
        			var validExtensions = ['jpeg', 'jpg', 'png', 'pdf'];
        			if ($.inArray(extension, validExtensions) == -1) {
        				$(item).replaceWith($(item).val('').clone(true));
        				$('#save').prop('disabled', true);
        				alert('Failed! Please upload png, jpg, jpeg, pdf file only.');
        			}
        			else {
        			// Check and restrict the file size to 32 KB.
        				if ($(item).get(0).files[0].size > (1097100)) {
        					alert('Failed!! Max allowed file size is 1 MB.');
        					$(item).replaceWith($(item).val('').clone(true));
        					$('#save').prop('disabled', true);
        				}
        				else {
        					$('#errormsg').text('').hide();
        					$('#save').prop('disabled', false);
        				}
        			}
        		};
		    
			$(document).ready(function (){
			    customerDatatable();
				function customerDatatable() {
				   $('#customer-table').load('customers_view.php');
				} 
				
				var balance = 0;
				$(document).on('blur','#totalpay', function(){
					var totalpay = $('#totalpay').val();
					var totalamount = $('#totalamount').val();
					balanceprice    = parseFloat(totalamount) - parseFloat(totalpay);
					var totalRound  = parseFloat(balanceprice);
					var balance     = Math.round(totalRound);
					$('#balance').val(balance);
				});
				
				
				$('#customermodal').click(function(){
					$('#register_form')[0].reset();
					$('#athaarfront, #athaarback, #pancard, #bloodgroupcerti, #passport').attr('value', '');
					$('#athaarone, #athaartwo, #pancardpre, #bloodgroupcerpre, #passportpre').attr('value', '');
					$('#formModal').modal('show');
					$('.modal-title').html('<i class="fas fa-list-alt"></i> Add User');
					$('#save').val('customer Add');
				});	
				
				//Add user Data
				$(document).on('submit','#register_form', function(event){
					event.preventDefault();
					$('#save').attr('disabled', 'disabled');
					var formData = new FormData(this);					
					$.ajax({
						url: "customer_action.php",
						method: "POST",
						data:formData,
						dataType: 'json',
						cache:false,
						contentType: false,
						async: false,
						processData: false,				
						success:function(response)
						{	
							customerDatatable();
							$('#register_form')[0].reset();
							$('form#register_form input[type="text"],input[type="file"],texatrea, select').val('');
							$('#adhaarfront, #adhaarback, #pancard, #bloodgroupcerti, #passport').val('');
							$('#adhaarone, #adhaartwo, #pancardpre, #bloodgroupcerpre, #passportpre').val('');
							$('#save').attr('disabled', false);
							$('#save').val('Add Success');
							$('#formModal').modal('hide');
							
							if(response['status'] === 'success') {						
								swal.fire({
								  icon: "success",
								  title: "Success",
								  text: "Save Successfully",
								  type: 'success',
								  showConfirmButton: false,
								  closeOnClickOutside: false,
								  timer: 1000,
								});  
							} else{
								swal.fire( 'warning!', response, "error" );														
							}									
						},
						error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
					});
				});
				
				
			//Edit user data
			$(document).on('click','.edit', function(event){ 
				event.preventDefault();
				var customerId = $(this).data('id');
				var page   = 'customer_registration';
				var action = 'customer_editfetch';
				$.ajax({
					url:"customer_action.php",
					method:"POST",
					data:{customerId:customerId,action:action,page:page},
					dataType:"json",
					success:function(data)
					{
					   $('#register_form')[0].reset();
					   $('#formModal').modal('show');
					   $('.modal-title').html('<i class="far fa-edit"></i> Edit Customer'); 
					   $('#branch_id').val(data.branch_id);
					     
					   $('#email').val(data.email);
					   $('#identification').val(data.identification);
					   $('#registerno').val(data.registerno);
					       
					   $('#branch_id').val(data.branch_id);
					   $('#firstname').val(data.firstname);
					   $('#lastname').val(data.lastname);
					   $('#fullname').val(data.fullname);
					   $('#addressone').val(data.addressone);
					   $('#mobileno').val(data.mobileno);
					   $('#dob').val(data.dob);
					   $('#qualification').val(data.qualification);
					   $('#joindate').val(data.joindate);
					   $('#dlnumber').val(data.dlnumber);
					   $('input:radio[name="gender"][value='+ data.gender +']').prop('checked', true);
					   
					   $('#fathername').val(data.fathername);
					   $('#addresstwo').val(data.addresstwo);
					   $('#bloodgroup').val(data.bloodgroup);
					   $('#anniverdate').val(data.anniverdate);
					   $('#adhaarcardno').val(data.adhaarcardno);
					   $('#completiondate').val(data.completiondate);
					   $('#duedate').val(data.duedate);
					   $('#appointmentdate').val(data.appointmentdate);
					  
					  
					   $('#document').removeAttr('required');
					   $('#photo').removeAttr('required');
					   $('#adhaarfront').removeAttr('required');
					   $('#adhaarback').removeAttr('required');
					   $('#pancard').removeAttr('required');
					   $('#passport').removeAttr('required');
					   $('#bloodgroupcerti').removeAttr('required');
					   
					   $('#payment_for').val(data.payment_for);
					   $('#payment_type').val(data.payment_type);
					   $('#totalamount').val(data.totalamount);
					   $('#totalpay').val(data.totalpay);
					   $('#balance').val(data.balance);
					   $('#balance_status').val(data.balance_status);
					   
					   $('#documentpre').attr("src", data.documentpre).show;
					   $('#photopre').attr("src", data.photopre).show;
					   $('#adhaarone').attr("src", data.adhaarone).show;
					   $('#adhaartwo').attr("src", data.adhaartwo).show;
					   $('#pancardpre').attr("src", data.pancardpre).show;
					   $('#bloodgroupcerpre').attr("src", data.bloodgroupcerpre).show;
					   $('#passportpre').attr("src", data.passportpre).show;
					   
					   $('#customerId').val(data.customerId);
					   $('#action').val('customer_edit');
					   $('#save').val('Edit Customer');
					   
					},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
				});				
			});

			//View user data
			$(document).on('click','.view', function(event){
								
				event.preventDefault();
				var customerId = $(this).data('id');
				var page   = 'customer_registration';
				var action = 'customer_viewfetch';
				$.ajax({
					url:"customer_action.php",
					method:"POST",
					data:{customerId:customerId,action:action,page:page},
					dataType:"json",
					success:function(data)
					{
					   $('#register_form')[0].reset();
					   $('#formModal').modal('show');
					   $('.modal-title').html('<i class="far fa-eye"></i> View Customer'); 
					   
					   $('#email').val(data.email);
					   $('#identification').val(data.identification);
					   $('#registerno').val(data.registerno);
					   
					   $('#branch_id').val(data.branch_id);
					   $('#firstname').val(data.firstname);
					   $('#lastname').val(data.lastname);
					   $('#fullname').val(data.fullname);
					   $('#addressone').val(data.addressone);
					   $('#mobileno').val(data.mobileno);
					   $('#dob').val(data.dob);
					   $('#qualification').val(data.qualification);
					   $('#joindate').val(data.joindate);
					   $('#dlnumber').val(data.dlnumber);
					   $('input:radio[name="gender"][value='+ data.gender +']').prop('checked', true);
					   
					   $('#fathername').val(data.fathername);
					   $('#addresstwo').val(data.addresstwo);
					   $('#bloodgroup').val(data.bloodgroup);
					   $('#anniverdate').val(data.anniverdate);
					   $('#adhaarcardno').val(data.adhaarcardno);
					   $('#completiondate').val(data.completiondate);
					   $('#duedate').val(data.duedate);
					   $('#appointmentdate').val(data.appointmentdate);
					   
					   $('#documentpre').attr("src", data.documentpre).show;
					   $('#photopre').attr("src", data.photopre).show;
					   $('#adhaarone').attr("src", data.adhaarone).show;
					   $('#adhaartwo').attr("src", data.adhaartwo).show;
					   $('#pancardpre').attr("src", data.pancardpre).show;
					   $('#bloodgroupcerpre').attr("src", data.bloodgroupcerpre).show;
					   $('#passportpre').attr("src", data.passportpre).show;					   
					   $('#action').val('customer_view');
					   $('#save').val('View Customer').attr('disabled', true);
					   
					},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
				});				
			});
			
			//status change 
			$(document).on("click",".status", function(e) {				
				e.preventDefault();	
				var statusId = $(this).data('id');
				var status = $(this).data('status');
				var page = 'customer_registration';
				var action = 'customer_status';				
				swal.fire({
						title: "Are you sure",
						text: "It will be Change Status",
						type: 'warning',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: "Status Change!",
						showLoaderOnConfirm: true,						
						preConfirm: function() {
							return new Promise(function(resolve){
								$.ajax({
									url: "customer_action.php",
									type: "POST",
									data:{statusId:statusId,status:status,action:action,page:page},
									dataType: 'JSON',									
								}).then(function(response){
									customerDatatable();
									if(response['status'] === 'success') {
										swal.fire({											
											icon: "success",
											title: "Success",
											text: "Save Successfully",
											type: 'success',
											showConfirmButton: false,
											closeOnClickOutside: false,
											timer: 1000
										})
									} else {
										swal.fire(											
											'warning!',
											response.message,
											response.status,
										);
									}
								});
							});
						},
						allowOutsideClick: false,
				});
			});			
			//delete code
			$(document).on("click",".del", function(e) {				
				e.preventDefault();	
				var deleteId = $(this).data('id');
				var parent = $(this).parent("td").parent("tr");
				var page = 'customer_registration';
				var action = 'customer_delete';
				swal.fire({
						title: "Are you sure",
						text: "It will be deleted Permanently",
						type: 'warning',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: "Yes, Delete it!",
						showLoaderOnConfirm: true,						
						preConfirm: function() {
							return new Promise(function(resolve){
								$.ajax({
									url: "customer_action.php",
									type: "POST",
									data:{deleteId:deleteId,action:action,page:page},
									dataType: 'JSON',									
								}).then(function(response){
									customerDatatable();
									parent.fadeOut('slow');
									if(response['status'] === 'success') {
										swal.fire({											
											icon: "success",
											title: "Success",
											text: "Save Successfully",
											type: 'success',
											showConfirmButton: false,
											closeOnClickOutside: false,
											timer: 1000
										})
									} else {
										swal.fire(											
											'warning!',
											response.message,
											response.status,
										);
									}
								});
							});
						},
						allowOutsideClick: false,
				});
			}); //delete End
									
			});			
		</script>
	<?php
		} else {
			echo "<script>window.location.href='login.php';</script>";
		}
	?>		