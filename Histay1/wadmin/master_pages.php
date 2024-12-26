<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	//DB connect
	$con = new mysqli($host, $user,$pass,$db_name);

	$update = false;
	$select = false;

	$page_title = "Pages";
	$sub_page_title = "Hotel Rating";
	$msg_title = "Hotel Rating";
	$THIS_TABLE = $pages_table;

	/* user Register Page */
	if(isset($_POST['action']))
	{
		//add section
		if($_POST['action'] == 'ac_add')
		{
			extract($_POST);
			$main_content = $con->real_escape_string($main_content);
			$created_at = date('Y-m-d H:i:s');
			$created_by = $_SESSION['admin_uid'];
			$status     = "A";
			//Check if already exists
			$select_query = " select id from $THIS_TABLE where name='$name'and status!='E'";
			$result = $con->query($select_query) or die(mysqli_error($con));
			if($result->num_rows == 0)
			{
				$insert_query = "insert into $THIS_TABLE(parent_id,name,title,slug,main_content,header_menu,footer_menu,sort_no,created_at,created_by,status)
												values('$parent_id','$name','$title','$slug','$main_content','$header_menu','$footer_menu','$sort_no','$created_at','$created_by','$status')";
				$inst_res = $con->query($insert_query) or die(mysqli_error($con));

				if($inst_res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Pages Added successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Pages Not Added!';
				}
			} else {
				$response['status'] = 'error';
				$response = 'Pages Title Already exists!';
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
			$main_content 	= mysqli_real_escape_string($con,$_POST['main_content']);
			$updated_at = date('Y-m-d H:i:s');
			$updated_by = $_SESSION['admin_uid'];

			$update_sql = "update $THIS_TABLE set parent_id='$parent_id',name='$name',title='$title',slug='$slug',main_content='$main_content',header_menu='$header_menu',footer_menu='$footer_menu',sort_no='$sort_no',updated_at='$updated_at',updated_by='$updated_by' where id='$id'";
			$up_res = $con->query($update_sql);
			if($up_res === true) {
				$response['status'] = 'success';
				$response['message'] = 'Pages updated successfully!';
			} else {
				$response['status'] = 'error';
				$response['message'] = 'Pages are Not Updated!';
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
		
		// //Additional Data fetch
		// if($_POST['action'] == 'ac_additional_data')
		// {
		// 	extract($_POST);
		// 	$select_query = "SELECT em.name as employee_name,tk.task_name,tk.description,
		// 						ta.*,pr.name as project_name FROM $THIS_TABLE ta 
	 // 							INNER JOIN $master_employees_table em ON em.id=ta.emp_id 
	 // 							INNER JOIN $master_task_table tk ON tk.id=ta.task_id 
	 // 							INNER JOIN $master_projects_table pr ON pr.id=tk.project_id
	 // 							WHERE ta.status!='E' AND ta.id='$id'";
		// 	$record = $con->query($select_query);
		// 	$data = $record->fetch_array();
		// 	echo "<h5>PROJECT: $data[project_name]</h5>
		// 			<h6>TASK: $data[task_name]</h6>
		// 			<p>DESCRIPTION: $data[description]</p>";
		// 	echo "<input type='hidden' name='tast_id' value='$data[task_id]'>
		// 			<input type='hidden' name='emp_id' value='$data[emp_id]'>
		// 			<input type='hidden' name='ta_id' value='$data[id]'>";
		// }

		// //Additional Data save
		// if($_POST['action'] == 'ac_save_additional')
		// {
		// 	extract($_POST);
		// 	$created_at = date('Y-m-d H:i:s');
		// 	$created_by = $_SESSION['admin_uid'];
		// 	$updated_at = date('Y-m-d H:i:s');
		// 	$updated_by = $_SESSION['admin_uid'];
		// 	$status     = "A";
		// 	//Check if already exists
		// 	$select_query = " select id from $workflow_table where tast_id='$task_id' and emp_id='$emp_id' and status!='E'";
		// 	$result = $con->query($select_query) or die(mysqli_error($con));
		// 	if($result->num_rows == 0)
		// 	{
		// 		if($wtime == "ST")
		// 		{
		// 			$insert_query = "insert into $workflow_table(emp_id,task_id,comments,start_time,created_by,status)
		// 											values('$emp_id','$task_id','$comments','$created_at','$created_by','$status')";
		// 			$inst_res = $con->query($insert_query) or die(mysqli_error($con));
		// 		}
		// 		elseif($wtime == "EN")
		// 		{
		// 			$update_sql = "update $workflow_table set comments='$comments',end_time='$end_time',updated_at='$updated_at',updated_by='$updated_by' where id='$ta_id'";
		// 			$up_res = $con->query($update_sql);
		// 		}

		// 		if($inst_res === true ){
		// 			$response['status'] = 'success';
		// 			$response['message'] = 'Task Assignment Added successfully!';
		// 		} else {
		// 			$response['status'] = 'error';
		// 			$response['message'] = 'Task Assignment Not Added!';
		// 		}
		// 	} else {
		// 		$response['status'] = 'error';
		// 		$response = 'Task Assignment Title Already exists!';
		// 	}
		// 	echo json_encode($response);
		// }

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
					$response['message'] = 'Pages Status changed successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Pages Status NOT changed.';
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
					$response['message'] = 'Pages Record deleted Successfuly...';
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
		 			<th>Name</th>
		 			<th>Title</th>
		 			<th>Slug</th>
		 			<th>Header Menu</th>
		 			<th>Footer Menu</th>
		 			<th>Created At</th>
		 			<th>Status</th>
		 			<th>Action</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
		 		<?php
		 			$select_query = "select * from $THIS_TABLE where status!='E'";
		 			$result = $con->query($select_query) or die(mysqli_error($con));
		 			if($result->num_rows > 0){
		 				while($data = $result->fetch_array()) {
		 					if($data['status'] == "A") {
		 						$status = '<span class="badge badge-success badge-shadow">ACTIVE</span>';
		 					} else {
		 						$status = '<span class="badge badge-danger badge-shadow">INACTIVE</span>';
		 					}
		 					if($data['header_menu'] == "Y") {
		 						$header_menu = '<span class="badge badge-success badge-shadow">YES</span>';
		 					}else if($data['header_menu'] == "N"){
		 						$header_menu = '<span class="badge badge-danger badge-shadow">NO</span>';
							}
							if($data['footer_menu'] == "Y") {
		 						$footer_menu = '<span class="badge badge-success badge-shadow">YES</span>';
		 					}else if($data['footer_menu'] == "N"){
		 						$footer_menu = '<span class="badge badge-danger badge-shadow">NO</span>';
							}

		 					echo "<tr>
		 							<td>$data[name]</td>
		 							<td>$data[title]</td>
									<td>$data[slug]</td>
									<td>$header_menu</td>
									<td>$footer_menu</td>
		 							<td>$data[created_at]</td>
		 							<td class='text-center'>$status</td>
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
		 					echo "<tr colspan='7'><td>No Pages found.</td></tr>";
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
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	  <link rel="stylesheet" href="text_editor/css/froala_editor.css">
	  <link rel="stylesheet" href="text_editor/css/froala_style.css">
	  <link rel="stylesheet" href="text_editor/css/plugins/code_view.css">
	  <link rel="stylesheet" href="text_editor/css/plugins/image_manager.css">
	  <link rel="stylesheet" href="text_editor/css/plugins/image.css">
	  <link rel="stylesheet" href="text_editor/css/plugins/table.css">
	  <link rel="stylesheet" href="text_editor/css/plugins/video.css">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
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
						<!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
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
						</div> -->
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
					  <div class="modal-dialog modal-dialog-centered tt_test" role="document">
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
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Parent Page</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <select class="form-control" name="parent_id" id="parent_id" required/>
										<option value=''>Select Name</option>
										 <?php
										 	$select_query = "select id,name as parent_name from $THIS_TABLE where status!='E'";
                                        	$result = $con->query($select_query) or die(mysqli_error($con));
                                        	while($data = $result->fetch_array())
                                        	{	
                                        		echo "<option value='$data[id]'>$data[parent_name]</option>";
                                        	}
										 ?>
										</select>   
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="name" name="name" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="title" name="title" class="form-control" />  
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Slug</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="slug" name="slug" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Main Content</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<textarea type="text" id="main_content" name="main_content" class="summernote"></textarea>
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Header Menu</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<p>
										<label><input type="radio" id="header_menu_y" name="header_menu" value="Y" required /> Yes</label>&nbsp&nbsp&nbsp
										<label><input type="radio" id="header_menu_n" name="header_menu" value="N" required /> No</label>
										</p>
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Footer Menu</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<p>
										<label><input type="radio" id="footer_menu_y" name="footer_menu" value="Y" required /> Yes</label>&nbsp&nbsp&nbsp
										<label><input type="radio" id="footer_menu_n" name="footer_menu" value="N" required /> No</label>
										</p>
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sort No</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="number" id="sort_no" name="sort_no" class="form-control" />  
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

				<!--Modal2 Popup Start 
					<div class="modal fade" id="formModal2" tabindex="-1" role="dialog"
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
						    	<div id="data_div"></div>
						    	<div class="form-group row col-md-12">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Comments</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<textarea type="text" id="comments" name="comments" class="form-control"></textarea>
									  </div>
									</div>
								</div>
								<div class="modal-body">
						    	<div class="form-group row col-md-12">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Task</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<p>
										<label><input type="radio" id="start" name="wtime" value="ST" required /> Start</label>&nbsp&nbsp&nbsp
										<label><input type="radio" id="end" name="wtime" value="EN" required /> End</label>
										</p>
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
				Modal2 Popup End -->


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
				$('#parent_id').val(data.parent_id);
				$('#name').val(data.name);
				$('#title').val(data.title);
				$('#slug').val(data.slug);
				$('#main_content').html(data.main_content);
				$('#parent_page').val(data.parent_page);
				$('#header_menu_y').attr('checked',false);
				$('#header_menu_n').attr('checked',false);
				if(data.header_menu == "N")
					$('#header_menu_n').attr('checked',true);
				else if(data.header_menu == "Y")
					$('#header_menu_y').attr('checked',true);
				$('#footer_menu_y').attr('checked',false);
				$('#footer_menu_n').attr('checked',false);
				if(data.footer_menu == "N")
					$('#footer_menu_n').attr('checked',true);
				else if(data.footer_menu == "Y")
					$('#footer_menu_y').attr('checked',true);
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
					$('#parent_id').val(data.parent_id);
					$('#name').val(data.name);
					$('#title').val(data.title);
					$('#slug').val(data.slug);
					$('#main_content').html(data.main_content);
					$('#parent_page').val(data.parent_page);
					$('#header_menu_y').attr('checked',false);
					$('#header_menu_n').attr('checked',false);
					if(data.header_menu == "N")
						$('#header_menu_n').attr('checked',true);
					else if(data.header_menu == "Y")
						$('#header_menu_y').attr('checked',true);
					$('#footer_menu_y').attr('checked',false);
					$('#footer_menu_n').attr('checked',false);
					if(data.footer_menu == "N")
						$('#footer_menu_n').attr('checked',true);
					else if(data.footer_menu == "Y")
						$('#footer_menu_y').attr('checked',true);
					$('#sort_no').val(data.sort_no);
					$('#action').val('ac_view');
					$('#save').css({"display": "none"});
				},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			});
		});

		// //additional data
		// $(document).on('click','.add_view', function(event){
		// 	event.preventDefault();
		// 	var id = $(this).data('id');
		// 	var page   = 'master';
		// 	var action = 'ac_additional_data';
		// 	$.ajax({
		// 		url:"<?php echo $page_url; ?>",
		// 		method:"POST",
		// 		data:{id:id,action:action,page:page},
		// 		dataType:"html",
		// 		success:function(data)
		// 		{
		// 		   $('#formModal2').modal('show');
		// 		   $('.modal-title').html('<i class="far fa-eye"></i>Additional Data');
		// 		   $('#data_div').html(data);

	 //   			   $('#action').val('ac_save_additional');
		// 		   $('#save').css({"visibility": "hidden"});
		// 		},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
		// 	});
		// });

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

	<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
  <script type="text/javascript" src="text_editor/js/froala_editor.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/align.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/image.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/link.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/table.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/video.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/url.min.js"></script>
  <script type="text/javascript" src="text_editor/js/plugins/entities.min.js"></script>

   <script>
    (function () {
      const editorInstance = new FroalaEditor('.teditor', {
        enter: FroalaEditor.ENTER_P,
        placeholderText: null,
        events: {
          initialized: function () {
            const editor = this
            this.el.closest('form').addEventListener('submit', function (e) {
              console.log(editor.$oel.val())
              e.preventDefault()
            })
          }
        }
      })
    })()
  </script>
<?php
}
}
else {
echo "<script>window.location.href='login.php';</script>";
}
?>
