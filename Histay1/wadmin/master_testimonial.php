<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	//DB connect
	$con = new mysqli($host, $user,$pass,$db_name);

	$update = false;
	$select = false;

	$page_title = "Testimonial";
	$sub_page_title = "Testimonial";
	$msg_title = "Testimonial";
	$THIS_TABLE = $testimonial_table;

	include('img_crop_function.php');
	//Settings
	$max_file_size = 1024*10000;
	$max_file_size_disp = "10MB";
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	$img_sizes = array(70=>70,140=>140);
	$disp_img_sizes = "1000 x 1000";

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
				$insert_query = "insert into $THIS_TABLE(name,email,designation,stars,message,created_at,created_by,status)
												values('$name','$email','$designation','$stars','$message',$created_at','$created_by','$status')";
				$inst_res = $con->query($insert_query) or die(mysqli_error($con));
				$insert_id = $con->insert_id;

				if($_FILES['image']['name'] != '')
            	{            		
            		$file_name = $_FILES['image']['name'];
            		$file_size = $_FILES['image']['size'];
            		$file_tmp = $_FILES['image']['tmp_name'];
            		$file_type = $_FILES['image']['type'];
            		$file_ext = explode('.',$file_name);
            
            		if($file_size > $max_file_size){
            			$errors[] = "File size must be less than $max_file_size_disp";
            		}
            
            		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
            		$new_file_name = "testimonial_".$insert_id;
            		$new_up_file_name = $new_file_name.".".$ext;
            		if(empty($errors)==true)
            		{
            			/* resize image */
                         $f = 0;
            			foreach ($img_sizes as $w => $h)
            			{
                            $f++;
                            if($f == 1)
                                $folder = "small";
                            elseif($f == 2)
                            {
                                $folder = "large";
                                list($width, $height) = getimagesize($_FILES['image']['tmp_name']);
                                $h = $w / ($width / $height);
                            }
                            $img_path = "../".$testinomial_img_dir;
                            $files[] = resize('image', $w, $h, $new_file_name, $img_path, $folder);
            			}
            			$ud_query = "update $THIS_TABLE set image='$new_up_file_name' where id='$insert_id'";
            			$con->query($ud_query) or die(mysqli_error($con));
            		}
            		else
            		{
            		    //echo "<script>alert(".print_r($errors).");</script>";
            		}
            	}

				if($inst_res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Course Added successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Course Not Added!';
				}
			} else {
				$response['status'] = 'error';
				$response = 'Course Title Already exists!';
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

			$update_sql = "update $THIS_TABLE set name='$name',email='$email',designation='$designation',
							stars='$stars',message='$message',updated_at='$updated_at',updated_by='$updated_by' where id='$id'";
			$up_res = $con->query($update_sql);
			$insert_id = $id;

				if($_FILES['image']['name'] != '')
            	{            		
            		$file_name = $_FILES['image']['name'];
            		$file_size = $_FILES['image']['size'];
            		$file_tmp = $_FILES['image']['tmp_name'];
            		$file_type = $_FILES['image']['type'];
            		$file_ext = explode('.',$file_name);
            
            		if($file_size > $max_file_size){
            			$errors[] = "File size must be less than $max_file_size_disp";
            		}
            
            		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
            		$new_file_name = "testimonial_".$insert_id;
            		$new_up_file_name = $new_file_name.".".$ext;
            		if(empty($errors)==true)
            		{
            			/* resize image */
                         $f = 0;
            			foreach ($img_sizes as $w => $h)
            			{
                            $f++;
                            if($f == 1)
                                $folder = "small";
                            elseif($f == 2)
                            {
                                $folder = "large";
                                list($width, $height) = getimagesize($_FILES['image']['tmp_name']);
                                $h = $w / ($width / $height);
                            }
                            $img_path = "../".$testinomial_img_dir;
                            $files[] = resize('image', $w, $h, $new_file_name, $img_path, $folder);
            			}
            			$ud_query = "update $THIS_TABLE set image='$new_up_file_name' where id='$insert_id'";
            			$con->query($ud_query) or die(mysqli_error($con));
            		}
            		else
            		{
            		    //echo "<script>alert(".print_r($errors).");</script>";
            		}
            	}



			if($up_res === true) {
				$response['status'] = 'success';
				$response['message'] = 'Course updated successfully!';
			} else {
				$response['status'] = 'error';
				$response['message'] = 'Course are Not Updated!';
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
					$response['message'] = 'Course Status changed successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Course Status NOT changed.';
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
					$response['message'] = 'Gems Record deleted Successfuly...';
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
					<th>Email</th>
					<th>Designation</th>
					<th>Image</th>
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
									<td> $data[email]</td>
									<td> $data[designation]</td>
									<td> $data[image]</td>
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
		 	<?php include_once("ref_action.php")?>
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
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="email" id="email" name="email" class="form-control" required />
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
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="file" id="image" name="image" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="testinomial_image_pre.src=window.URL.createObjectURL(this.files[0])"/><br>
										<img id="testinomial_image_pre" src="" class="img-fluid" style="width:150px;" />
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Stars</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<select class="form-control" name="stars" id="stars" required/>
										<option value="0">Select stars</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										</select>
										</div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Message</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<textarea rows="4" type="text" id="message" name="message" class="form-control" required /></textarea> 
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
			var formData = new FormData(this);					
			$.ajax({
				url: "<?php echo $page_url; ?>",
				method: "POST",
				data:formData,
				dataType: 'json',
				cache:false,
				contentType: false,
				async: false,
				processData: false,				
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
						});  
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
				$('#email').val(data.email);
				$('#designation').val(data.designation);
				$('#testinomial_image_pre').attr("src", "<?php echo "../$testinomial_img_dir/small/"; ?>"+data.image).show;
				$('#stars').val(data.stars);
				$('#message').val(data.message);
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
				   $('#email').val(data.email);
				   $('#designation').val(data.designation);
				   $('#testinomial_image_pre').attr("src", "<?php echo "../$testinomial_img_dir/small/"; ?>"+data.image).show;
				   $('#stars').val(data.stars);
				   $('#message').val(data.message);
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
