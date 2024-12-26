<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	//DB connect
	$con = new mysqli($host, $user,$pass,$db_name);

	$update = false;
	$select = false;

	$page_title = "Master Teachers";
	$sub_page_title = "Master Teachers";
	$msg_title = "Master Teachers";
	$THIS_TABLE = $teachers_master_table;

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
				$insert_query = "insert into $THIS_TABLE(name,designation,thumb_image,image,short_description,about,experience,	expertise,education,mobile,email,fb_url,twitter_url,insta_url,sort_no,created_at,created_by,status)
												values('$name','$designation','$thumb_image','$image','$short_description','$about','$experience','$expertise','$education','$mobile','$email','$fb_url','$twitter_url','$insta_url','$sort_no','$created_at','$created_by','$status')";
				$inst_res = $con->query($insert_query) or die(mysqli_error($con));

				if($inst_res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Teachers Added successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Teachers Not Added!';
				}
			} else {
				$response['status'] = 'error';
				$response = 'Teachers Title Already exists!';
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

			$update_sql = "update $THIS_TABLE set name='$name',designation='$designation',thumb_image='$thumb_image',image='$image',short_description='$short_description',about='$about',experience='$experience',expertise='$expertise',education='$education',mobile='$mobile',email='$email',fb_url='$fb_url',twitter_url='$twitter_url',insta_url='$insta_url',sort_no='$sort_no',updated_by='$updated_by' where id='$id'";
			$up_res = $con->query($update_sql);
			if($up_res === true) {
				$response['status'] = 'success';
				$response['message'] = 'Teachers updated successfully!';
			} else {
				$response['status'] = 'error';
				$response['message'] = 'Teachers are Not Updated!';
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
					$response['message'] = 'Teachers Status changed successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Teachers Status NOT changed.';
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
					$response['message'] = 'Teachers Record deleted Successfuly...';
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
		 			<th>Name </th>
					<th>Designation</th>
					<th>Thumb Image</th>
					<th>Image</th>
					<th>Mobile</th>
					<th>Email</th>
		 			<th>Created at</th>
		 			<th>Status</th>
		 			<th>Action</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
		 		<?php

		 			$select_query = "select * from $THIS_TABLE where status!='E' order by id asc";
		 			$result = $con->query($select_query) or die(mysqli_error($con));
		 			if($result->num_rows > 0){
		 				while($data = $result->fetch_array()) {
		 					if($data['status'] == "A") {
		 						$status = '<span class="badge badge-success badge-shadow">ACTIVE</span>';
		 					} else {
		 						$status = '<span class="badge badge-danger badge-shadow">INACTIVE</span>';
		 					}
							//$image = "<img src=$profile_img_dir/$data[image] width='50' height='50'>";
		 					echo "<tr>
		 							<td> $data[name]</td>
									<td> $data[designation]</td>
									<td> $data[thumb_image]</td>
									<td> $data[image]</td>
									<td> $data[mobile]</td>
									<td> $data[email]</td>
		 							<td> $data[created_at]</td>
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
		 					echo "<tr colspan='7'><td>No Course found.</td></tr>";
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
					  <div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						<form id="register_form" method="POST" autocomplete="off">
						    <div class="modal-body">
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="text" id="name" name="name" class="form-control" required />
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Designation</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="designation" name="designation" class="form-control" required />
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumb Image</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="text" id="thumb_image" name="thumb_image" class="form-control" required />
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="text" id="image" name="image" class="form-control" />
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Short Description</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="4" type="text" id="short_description" name="short_description" class="form-control"  /></textarea> 
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">About</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="4" type="text" id="about" name="about" class="form-control"  /></textarea> 
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Experiance</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="4" type="text" id="experience" name="experience" class="form-control" required /></textarea> 
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Expertise</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="4" type="text" id="expertise" name="expertise" class="form-control" required /></textarea> 
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Education</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="8" type="text" id="education" name="education" class="form-control" required /></textarea> 
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mobile</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="number" id="mobile" name="mobile" class="form-control" required />
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="email" id="email" name="email" class="form-control" required />
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Fb Url</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="8" type="text" id="fb_url" name="fb_url" class="form-control"  /></textarea> 
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Twitter Url</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="8" type="text" id="twitter_url" name="twitter_url" class="form-control" /></textarea> 
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Insta Url</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="8" type="text" id="insta_url" name="insta_url" class="form-control" /></textarea> 
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sort No</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="number" id="sort_no" name="sort_no" class="form-control" required />
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
				$('.modal-title').html('<i class="fas fa-list-alt"></i> Add Course');
				$('#save').val('Course Add');
				$('#save').css({"visibility": "visible"});
			});

			//Filter
				$(document).on('submit','#filter_form', function(event){
				event.preventDefault();
				$.ajax({
				url: "<?php echo $page_url; ?>",
				method: "POST",
				data: $(this).serialize(),
				success:function(response)
				{
				$('#branch-table').html(response);
				}
			});
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
				$('#name').val(data.name);
				$('#designation').val(data.designation);
				$('#thumb_image').val(data.thumb_image);
				$('#image').val(data.image);
				$('#short_description').val(data.short_description);
				$('#about').val(data.about);
				$('#experience').val(data.experience);
				$('#expertise').val(data.expertise);
				$('#education').val(data.education);
				$('#mobile').val(data.mobile);
				$('#email').val(data.email);
				$('#fb_url').val(data.fb_url);
				$('#twitter_url').val(data.twitter_url);
				$('#insta_url').val(data.insta_url);
				$('#sort_no').val(data.sort_no);
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
				   $('#title').val(data.title);
	   			   $('#name').val(data.name);
				   $('#designation').val(data.designation);
				   $('#thumb_image').val(data.thumb_image);
				   $('#image').val(data.image);
				   $('#short_description').val(data.short_description);
				   $('#about').val(data.about);
				   $('#experience').val(data.experience);
				   $('#expertise').val(data.expertise);
				   $('#education').val(data.education);
				   $('#mobile').val(data.mobile);
				   $('#email').val(data.email);
				   $('#fb_url').val(data.fb_url);
				   $('#twitter_url').val(data.twitter_url);
				   $('#insta_url').val(data.insta_url);
				   $('#sort_no').val(data.sort_no);
	   			   $('#action').val('ac_view');
				   $('#save').css({"visibility": "hidden"});
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
