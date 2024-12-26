<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	//DB connect
	$con = new mysqli($host, $user,$pass,$db_name);

	$update = false;
	$select = false;

	$page_title = "Employees";
	$sub_page_title = "Master Employees";
	$msg_title = "Master Employees";
	$THIS_TABLE =$master_employees_table;

	/* user Register Page */
	if(isset($_POST['action']))
	{
		//add section
		if($_POST['action'] == 'ac_add')
		{
			extract($_POST);
			$created_at = date('Y-m-d H:i:s');
			$created_by = $_SESSION['admin_uid'];
			$status     = "A";
			//Check if already exists
			$select_query = " select id from $THIS_TABLE where name='$name' and status!='E' ";
			$result = $con->query($select_query) or die(mysqli_error($con));
			if($result->num_rows == 0)
			{
				$insert_query = "insert into $THIS_TABLE(employee_code,photo,name,department_id,designation_id,
								date_of_joining,joining_salary,father_name,dob,blood_group,gender,phone,local_address,
								permanent_address,email,password,account_holder,account_number,bank_name,
								ifsc_code,pan_number,branch,resume,offer_letter,joining_letter,contract,
								id_proof,created_at,created_by,status)
								values('$employee_code','$photo','$name','$department_id','$designation_id',
								'$date_of_joining','$joining_salary','$father_name','$dob','$blood_group',
								'$gender','$phone','$local_address','$permanent_address','$email',
								'$password','$account_holder','$account_number','$bank_name','$ifsc_code',
								'$pan_number','$branch','$resume','$offer_letter','$joining_letter','$contract',
								'$id_proof','$created_at','$created_by','$status')";				
				$inst_res = $con->query($insert_query) or die(mysqli_error($con));

				//Inserting into admin_users
				$insert_query = "insert into $admin_table(full_name,username,password,user_type,created_at,created_by,status)
								values('$name','$email','$password','EM','$created_at','$created_by','$status')";				
				$inst_res = $con->query($insert_query) or die(mysqli_error($con));

				if($inst_res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Employees Added successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Employees Not Added!';
				}
			} else {
				$response['status'] = 'error';
				$response = 'Employees Title Already exists!';
			}
			echo json_encode($response);
		}

		//Editdata fetch
		if($_POST['action'] == 'ac_edit_fetch')
		{
			extract($_POST);
			$editquery = " SELECT * FROM $THIS_TABLE WHERE id='$id'";
			$record = $con->query($editquery);
			$output = array();
			if($record->num_rows > 0)
			{
				$data = $record->fetch_array();
			}
			echo json_encode($data);
		}

		//Update section
		if($_POST['action'] == 'ac_edit')
		{
			extract($_POST);
			$updated_at = date('Y-m-d H:i:s');
			$updated_by = $_SESSION['admin_uid'];

			$update_sql = "update $THIS_TABLE set employee_code='$employee_code',photo='$photo',name='$name',department_id='$department_id',designation_id='$designation_id',date_of_joining='$date_of_joining',joining_salary='$joining_salary',father_name='$father_name',dob='$dob',blood_group='$blood_group',gender='$gender',phone='$phone',local_address='$local_address',permanent_address='$permanent_address',email='$email',password='$password',account_holder='$account_holder',account_number='$account_number',bank_name='$bank_name',ifsc_code='$ifsc_code',pan_number='$pan_number',branch='$branch',resume='$resume',offer_letter='$offer_letter',joining_letter='$joining_letter',contract='$contract',id_proof='$id_proof',updated_at='$updated_at',updated_by='$updated_by' where id='$id'";
			$up_res = $con->query($update_sql);
			if($up_res === true) {
				$response['status'] = 'success';
				$response['message'] = 'Employees updated successfully!';
			} else {
				$response['status'] = 'error';
				$response['message'] = 'Employees are Not Updated!';
			}
			echo json_encode($response);
		}
		//viewdata fetch
		if($_POST['action'] == 'ac_view_fetch')
		{
			extract($_POST);
			$editquery = " SELECT * FROM $THIS_TABLE WHERE id= '$id' ";
			$record = $con->query($editquery);
			$output = array();
			if($record->num_rows > 0)
			{
					$data = $record->fetch_array();
			}
			echo json_encode($data);
		}

		//status change
		if($_POST['action'] == 'ac_change_status')
		{
			if($_POST['id'])
			{
				extract($_POST);
				$cur_status = $_POST['status'];
				if($cur_status == "A") {
					$status = "D";
				} elseif ($cur_status == "D"){
					$status = "A";
				}

				$sql = "update $THIS_TABLE set status='$status' where id='$id' ";
				$res = $con->query($sql);

				if($res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Employees Status changed successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Employees Status NOT changed.';
				}
				echo json_encode($response);
			}
	  }

		//delete section
		if($_POST['action'] == 'ac_delete')
		{
			if($_POST['id']){
				extract($_POST);
				$sql="update $THIS_TABLE set status='E' where id='$id'";
				$res = $con->query($sql);
				if($res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Employees Record deleted Successfuly...';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Unable to delete this Record..';
				}
				echo json_encode($response);
			}
		}

		//View Section
		if(isset($_POST['grid_view']))
		{
			?>
			<script>
		 	$(document).ready(function() {
		 		$('#save-stage').DataTable();
		 	});
			 </script>
			 <!-- table load -->
		 	<div class="table-responsive">
		 	  <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
		 		<thead>
		 		  <tr align="center">
		 			<th>Employee Code</th>
		 			<th>Photo</th>
		 			<th>Name</th>
					<th>Dept/Designation
		 			<th>Status</th>
		 			<th>Action</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
		 		<?php
		 			$select_query = "SELECT dt.id,dt.department as department_name,ds.id,ds.designation as designation_name,em.* FROM $THIS_TABLE em INNER JOIN $master_department_table dt ON dt.id=em.department_id INNER JOIN $master_designation_table ds ON ds.id=em.designation_id WHERE em.status!='E'";
		 			$result = $con->query($select_query) or die(mysqli_error($con));
		 			if($result->num_rows > 0){
		 				while($data = $result->fetch_array()) {
		 					if($data['status'] == "A") {
		 						$status = '<span class="badge badge-success badge-shadow">ACTIVE</span>';
		 					} else {
		 						$status = '<span class="badge badge-danger badge-shadow">INACTIVE</span>';
		 					}
							//$cat_image = "<img src=$profile_img_dir/$data[cat_image] width='50' height='50'>";
		 					echo "<tr>
		 							<td> $data[employee_code]</td>
		 							<td> $data[photo]</td>
		 							<td> $data[name]</td>
									<td> $data[department_name]</br>$data[designation_name]</td>
									<td class='text-center'> $status</td>
		 							<td class='text-center'>
		 									<button type='button' class='btn btn-success btn-sm edit' data-id='$data[id]'><i class='far fa-edit'></i></button>
		 									<button type='button' class='btn btn-info btn-sm view' data-id='$data[id]'><i class='far fa-eye'></i></button>
		 									<button type='button' class='btn btn-primary btn-sm status' data-id='$data[id]' data-status='$data[status]'><i class='fas fa-sync-alt'></i></button>
		 									<button type='button' class='btn btn-danger btn-sm del' data-id='$data[id]'><i class='far fa-trash-alt'></i></button>
		 							  </td>
		 						  </tr>";
		 					}
		 				}
		 				else {
		 					echo "<tr colspan='7'><td>No Employees found.</td></tr>";
		 				}
		 			?>
		 		</tbody>
		 	  </table>
		 	</div>
			<?php
		}
	} /* Action End */
	else
	{
		include_once("header.php");
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
									<div class="breadcrumb-item"><a href="dashboard.php">Home</a></div>
									<div class="breadcrumb-item"><a href="<?php echo $page_url; ?>"><?php echo $page_title; ?></a></div>
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
						<span id="alert_action"></span>
				  </div>
				  <div class="col-12">
				  <!-- card Start -->
					<div class="card">
						 <div class="card-header">
							<h4><?php echo $page_title; ?></h4>
							<div class="card-header-action">
								<button type="button" id="usermodal" class="btn btn-success">Add New</button>
							</div>
						 </div>
						 <div class="card-body">
						 	<div id="branch-table"> </div>

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
					  <div class="modal-dialog modal-dialog-centered tt_employee" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						<form id="register_form" method="POST" autocomplete="off">
						    <div class="modal-body row">
						    	<h2>Company Details</h2>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Employee Code</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="text" id="employee_code" name="employee_code" class="form-control" placeholder="Employee Code" required />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Department</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<select class="form-control" name="department_id" id="department_id" />
										<option value=''>Select Department</option>
										 <?php
										 $select_query = "select id,department from $master_department_table where status!='E'";
                                        $result = $con->query($select_query) or die(mysqli_error($con));
                                        while($data = $result->fetch_array())
                                        {

                                        	echo "<option value='$data[id]'>$data[department]</option>";

                                        }

										 ?>

										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Designation</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<select class="form-control" name="designation_id" id="designation_id"/>
										<option value=''>Select Designation</option>
										 <?php
										 $select_query = "select id,designation from $master_designation_table where status!='E'";
                                        $result = $con->query($select_query) or die(mysqli_error($con));
                                        while($data = $result->fetch_array())
                                        {

                                        	echo "<option value='$data[id]'>$data[designation]</option>";

                                        }

										 ?>

										</select>
										</div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date Of Joining</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="date" id="date_of_joining" name="date_of_joining" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Joining Salary</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="joining_salary" name="joining_salary" class="form-control" />
									  </div>
									</div>
								</div>

								<h2>Personal Details</h2>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Photo</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="photo" name="photo" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="name" name="name" class="form-control" placeholder="Name" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Father's Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="father_name" name="father_name" class="form-control" placeholder="Father's Name" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date Of Birth</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="date" id="dob" name="dob" class="form-control"/>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Blood Group</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="blood_group" name="blood_group" class="form-control" placeholder="Name"/>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gender</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<select class="form-control" name="gender" id="gender" />
										<option value='M'>Male</option>
										<option value='F'>female</option>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Phone</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="phone" name="phone" class="form-control"/>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Local Address</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<textarea rows="4" type="text" id="local_address" name="local_address" class="form-control"></textarea>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Permanent Address</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<textarea rows="4" type="text" id="permanent_address" name="permanent_address" class="form-control"></textarea>
									  </div>
									</div>
								</div>
								<h3>Account Login</h3>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="email" id="email" name="email" class="form-control" placeholder="Email" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="password" id="password" name="password" class="form-control" placeholder="Password" />
									  </div>
									</div>
								</div>
								<h2>Bank Account Details</h2>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Account Holder Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="account_holder" name="account_holder" class="form-control" placeholder="Account Holder Name"/>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Account Number</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="account_number" name="account_number" class="form-control" placeholder="Account Number" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Bank Name" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">IFSC Code</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="ifsc_code" name="ifsc_code" class="form-control" placeholder="IFSC Code"/>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">PAN Number</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="pan_number" name="pan_number" class="form-control" placeholder="PAN Number"/>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Branch</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="branch" name="branch" class="form-control" placeholder="Branch"/>
									  </div>
									</div>
								</div>

								<h2>Documents</h2>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Resume</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="resume" name="resume" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Offer Letter</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="offer_letter" name="offer_letter" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Joining Letter</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="joining_letter" name="joining_letter" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Contract And Agreement</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="contract" name="contract" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Proof</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="id_proof" name="id_proof" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="modal-footer bg-whitesmoke br">
									<input type="hidden" id="id" name="id" value="0" />
									<input type="hidden" id="page" name="page" value="master" />
									<input type="hidden" id="action" name="action" value="ac_add" />
									<input type="submit" name="save" id="save" class="btn btn-auth-color" value="Save" />
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
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
		$(document).ready(function (){
			branchDatatable();
			function branchDatatable(){
				$.ajax({
				 url: "<?php echo $page_url; ?>",
				 method: "POST",
				 data: 'action=1&grid_view=1',
				 success:function(response)
				 {
					 $('#branch-table').html(response);
				 },
				 error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			 });
			}
			$('#usermodal').click(function(){
				$('#register_form')[0].reset();
				$('#formModal').modal('show');
				$('.modal-title').html('<i class="fas fa-list-alt"></i> Add Data');
				$('#save').val('Save');
			});

		//Add Data
		$(document).on('submit','#register_form', function(event){
			event.preventDefault();
			$('#save').attr('disabled', 'disabled');
			$.ajax({
			url: "<?php echo $page_url; ?>",
			method: "POST",
			data: $(this).serialize(),
			dataType: 'json',
			async: false,
			proccessData: false,
			success:function(response)
			{
				branchDatatable();
				$('#register_form')[0].reset();
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
				})
				} else{
					swal.fire( 'warning!', response, "error" );
				}
			},
			error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			});
		});
		//Edit data
		$(document).on('click','.edit', function(event){
			event.preventDefault();
			var id = $(this).data('id');
			var page = 'master';
			var action = 'ac_edit_fetch';
			$.ajax({
			url:"<?php echo $page_url; ?>",
			method:"POST",
			data:{id:id,action:action,page:page},
			dataType:"json",
			success:function(data)
			{
				$('#formModal').modal('show');
				$('.modal-title').html('<i class="far fa-edit"></i> Edit Data');
				$('#employee_code').val(data.employee_code);
				$('#department_id').val(data.department_id);
				$('#designation_id').val(data.designation_id);
				$('#date_of_joining').val(data.date_of_joining);
				$('#photo').val(data.photo);
				$('#name').val(data.name);
				$('#father_name').val(data.father_name);
				$('#dob').val(data.dob);
				$('#gender').val(data.gender);
				$('#Phone').val(data.phone);
				$('#local_address').val(data.local_address);
				$('#permanent_address').val(data.permanent_address);
				$('#blood_group').val(data.blood_group);
				$('#email').val(data.email);
				$('#password').val(data.password);
				$('#account_holder').val(data.account_holder);
				$('#account_number').val(data.account_number);
				$('#bank_name').val(data.bank_name);
				$('#ifsc_code').val(data.ifsc_code);
				$('#pan_number').val(data.pan_number);
				$('#branch').val(data.branch);
				$('#resume').val(data.resume);
				$('#offer_letter').val(data.offer_letter);
				$('#joining_letter').val(data.joining_letter);
				$('#contract').val(data.contract);
				$('#id_proof').val(data.id_proof);
				$('#id').val(id);
				$('#action').val('ac_edit');
				$('#save').val('Update');
				},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			});
		});

		//View data
		$(document).on('click','.view', function(event){
			event.preventDefault();
			var id = $(this).data('id');
			var page   = 'master';
			var action = 'ac_view_fetch';
			$.ajax({
				url:"<?php echo $page_url; ?>",
				method:"POST",
				data:{id:id,action:action,page:page},
				dataType:"json",
				success:function(data)
				{
				   $('#formModal').modal('show');
				   $('.modal-title').html('<i class="far fa-eye"></i> View Data');
	   			   $('#department_id').val(data.department_id);
				   $('#designation_id').val(data.designation_id);
				   $('#date_of_joining').val(data.date_of_joining);
				   $('#photo').val(data.photo);
				   $('#name').val(data.name);
				   $('#father_name').val(data.father_name);
				   $('#dob').val(data.dob);
				   $('#gender').val(data.gender);
				   $('#Phone').val(data.phone);
				   $('#local_address').val(data.local_address);
				   $('#permanent_address').val(data.permanent_address);
				   $('#blood_group').val(data.blood_group);
				   $('#email').val(data.email);
				   $('#password').val(data.password);
				   $('#account_holder').val(data.account_holder);
				   $('#account_number').val(data.account_number);
				   $('#bank_name').val(data.bank_name);
				   $('#ifsc_code').val(data.ifsc_code);
				   $('#pan_number').val(data.pan_number);
				   $('#branch').val(data.branch);
				   $('#resume').val(data.resume);
				   $('#offer_letter').val(data.offer_letter);
				   $('#joining_letter').val(data.joining_letter);
				   $('#contract').val(data.contract);
				   $('#id_proof').val(data.id_proof);
	   			   $('#action').val('ac_view');
				   $('#save').css({"display": "none"});
				},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			});
		});

		//status change
		$(document).on("click",".status", function(e) {
			e.preventDefault();
			var id = $(this).data('id');
			var status = $(this).data('status');
			var page = 'master';
			var action = 'ac_change_status';
			swal.fire({
					title: "Are you sure?",
					text: "The status will be changed",
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
								url: "<?php echo $page_url; ?>",
								type: "POST",
								data:{id:id,status:status,action:action,page:page},
								dataType: 'JSON',
							}).then(function(response){
								branchDatatable();
								if(response['status'] === 'success') {
									swal.fire({
										icon: "success",
										title: "Success",
										text: "Status Changed Successfully",
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
			var id = $(this).data('id');
			var parent = $(this).parent("td").parent("tr");
			var page = 'master';
			var action = 'ac_delete';
			swal.fire({
					title: "Are you sure?",
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
								url: "<?php echo $page_url; ?>",
								type: "POST",
								data:{id:id,action:action,page:page},
								dataType: 'JSON',
							}).then(function(response){
								branchDatatable();
								parent.fadeOut('slow');
								if(response['status'] === 'success') {
									swal.fire({
										icon: "success",
										title: "Success",
										text: "Deleted Successfully",
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
}
}
else {
echo "<script>window.location.href='login.php';</script>";
}
?>
