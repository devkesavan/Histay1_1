<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	//DB connect
	$con = new mysqli($host, $user,$pass,$db_name);

	$update = false;
	$select = false;

	$page_title = "Room Rates";
	$sub_page_title = "Room Rates";
	$msg_title = "Room Rates";
	$THIS_TABLE = $master_room_rates_table;

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
			$select_query = " select id from $THIS_TABLE where name='$name'and status!='E'";
			$result = $con->query($select_query) or die(mysqli_error($con));
			if($result->num_rows == 0)
			{
				$insert_query = "insert into $THIS_TABLE(room_id,start_date,end_date,price_night,num_people,adult_price,child_price,discount,discount_type,created_at,created_by,status)
												values('$room_id','$start_date','$end_date','$price_night','$num_people','$adult_price','$child_price','$discount','$discount_type','$created_at','$created_by','$status')";
				$inst_res = $con->query($insert_query) or die(mysqli_error($con));

				if($inst_res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Room Rates Added successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Room Rates Not Added!';
				}
			} else {
				$response['status'] = 'error';
				$response = 'Room Rates Title Already exists!';
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

			$update_sql = "update $THIS_TABLE set room_id='$room_id',start_date='$start_date',end_date='$end_date',price_night='$price_night',num_people='$num_people',adult_price='$adult_price',child_price='$child_price',discount='$discount',discount_type='$discount_type',updated_at='$updated_at',updated_by='$updated_by' where id='$id'";
			$up_res = $con->query($update_sql);
			if($up_res === true) {
				$response['status'] = 'success';
				$response['message'] = 'Room Rates updated successfully!';
			} else {
				$response['status'] = 'error';
				$response['message'] = 'Room Rates are Not Updated!';
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
					$response['message'] = 'Room Rates Status changed successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Room Rates Status NOT changed.';
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
					$response['message'] = 'Room Rates Record deleted Successfuly...';
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
		 			<th>Room Name</th>
		 			<th>Start Date</th>
		 			<th>End Date</th>
		 			<th>Price Per Night</th>
		 			<th>Number Of People</th>
		 			<th>Created At</th>
		 			<th>Status</th>
		 			<th>Action</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
		 		<?php
		 			
		 			$select_query = "SELECT hc.id,hc.name as class_name,ht.* FROM $THIS_TABLE ht INNER JOIN $master_hotel_class_table hc ON hc.id=ht.class_id WHERE ht.status!='E'";
		 			$result = $con->query($select_query) or die(mysqli_error($con));
		 			if($result->num_rows > 0){
		 				while($data = $result->fetch_array()) {
		 					if($data['status'] == "A") {
		 						$status = '<span class="badge badge-success badge-shadow">ACTIVE</span>';
		 					} else {
		 						$status = '<span class="badge badge-danger badge-shadow">INACTIVE</span>';
		 					}
		 					if($data['discount_type'] == "F") {
		 						$discount_type = '<span class="badge badge-danger badge-shadow">$ Fixed</span>';
		 					}else if($data['discount_type'] == "P"){
		 						$discount_type = '<span class="badge badge-primary badge-shadow">% (rate) - Applied to the amount except the fixed supplement</span>';
		 					echo "<tr>
		 							<td>$data[room_name]</td>
		 							<td>$data[start_date]</td>
									<td>$data[end_date]</td>
									<td>$data[price_night]</td>
									<td>$data[num_people]</td>
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
		 					echo "<tr colspan='7'><td>No Room Rates found.</td></tr>";
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
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Room Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<select class="form-control" name="class_id" id="class_id" required/>
										<option value=''>Select Room</option>
										 <?php
											$select_query = "select id,name as room_name from $master_hotel_rooms_table where status!='E'";
                                        	$result = $con->query($select_query) or die(mysqli_error($con));
                                        	while($data = $result->fetch_array())
                                        	{
                                        		echo "<option value='$data[id]'>$data[room_name]</option>";
                                        	}
                                         ?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start Date</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="date" id="start_date" name="start_date" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">End Date</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="date" id="end_date" name="end_date" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Price / Night</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="price_night" name="price_night" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Num People</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="num_people" name="num_people" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Price / Extra Adult / Night</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="adult_price" name="adult_price" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Price / Extra Child / Night</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="child_price" name="child_price" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Discount</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="discount" name="discount" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Discount Type</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <p>
										 <label><input type="radio" id="discount_type_f" name="discount_type" value="F" required /> $ Fixed</label>&nbsp&nbsp&nbsp
										 <label><input type="radio" id="discount_type_p" name="discount_type" value="P" required /> % (rate) - Applied to the amount except the fixed supplement</label>
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
				$('#room_id').val(data.room_id);
				$('#start_date').val(data.start_date);
				$('#end_date').val(data.end_date);
				$('#price_night').val(data.price_night);
				$('#num_people').val(data.num_people);
				$('#adult_price').val(data.adult_price);
				$('#child_price').val(data.child_price);
				$('#discount').val(data.discount);
				$('#discount_type_f').attr('checked',false);
				$('#discount_type_p').attr('checked',false);
				if(data.discount_type == "F")
					$('#discount_type_f').attr('checked',true);
				else if(data.discount_type == "P")
					$('#discount_type_p').attr('checked',true);
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
				   $('#room_id').val(data.room_id);
				   $('#start_date').val(data.start_date);
				   $('#end_date').val(data.end_date);
				   $('#price_night').val(data.price_night);
				   $('#num_people').val(data.num_people);
				   $('#adult_price').val(data.adult_price);
				   $('#child_price').val(data.child_price);
				   $('#discount').val(data.discount);
				   $('#discount_type_f').attr('checked',false);
				   $('#discount_type_p').attr('checked',false);
				   if(data.discount_type == "F")
				   		$('#discount_type_f').attr('checked',true);
				   else if(data.discount_type == "P")
						$('#discount_type_p').attr('checked',true);
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
<?php
}
}
else {
echo "<script>window.location.href='login.php';</script>";
}
?>
