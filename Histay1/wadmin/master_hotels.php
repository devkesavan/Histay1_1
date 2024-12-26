<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	//DB connect
	$con = new mysqli($host, $user,$pass,$db_name);

	$update = false;
	$select = false;

	$page_title = "Master Hotels";
	$sub_page_title = "Master Hotels";
	$msg_title = "Master Hotels";
	$THIS_TABLE = $hotels_table;

	include('img_crop_function.php');
	//Settings
	$max_file_size = 1024*10000;
	$max_file_size_disp = "10MB";
	$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
	$img_sizes = array(300=>200,900=>600);
	$disp_img_sizes = "900px x 600px";

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
			/*$select_query = " select id from $THIS_TABLE where name='$name'and status!='E'";
			$result = $con->query($select_query) or die(mysqli_error($con));
			if($result->num_rows == 0)
			{*/
				if($_SESSION['uType'] == 'HA')
					$hotel_admin_id = "0";

				$insert_query = "insert into $THIS_TABLE(hotel_admin_id,category_type_id,destination_id,city_id,code,name,short_description,description,address,phone_number,email_id,star,slug,map,sort_no,created_at,created_by,status)
												values('$hotel_admin_id','$category_type_id','$destination_id','$city_id','$code','$name','$short_description','$description','$address','$phone_number','$email_id','$star','$slug','$map','$sort_no','$created_at','$created_by','$status')";
				$inst_res = $con->query($insert_query) or die(mysqli_error($con));
				$hotel_id = $con->insert_id;

				if(isset($facilities))
				{
					$sno = 0;
					foreach($facilities as $val)
					{
						$sno++;
						$insert_query = "insert into $hotel_facilities_table(hotel_id,facility_id,sort_no,created_at,created_by,status)
													values('$hotel_id','$val','$sno','$created_at','$created_by','$status')";
						$inst_res = $con->query($insert_query) or die(mysqli_error($con));
					}
				}

				//image upload
				foreach($_FILES['hotel_image']['name'] as $key => $val)
				{
					if($_FILES['hotel_image']['name'][$key] != "")
					{
						$j = 0;
						if($_FILES['hotel_image']['name'] != '')
		            	{            		
		            		$file_name = $_FILES['hotel_image']['name'][$key];
		            		$file_size = $_FILES['hotel_image']['size'][$key];
		            		$file_tmp = $_FILES['hotel_image']['tmp_name'][$key];
		            		$file_type = $_FILES['hotel_image']['type'][$key];
		            
		            		if($file_size > $max_file_size){
		            			$errors[] = "File size must be less than $max_file_size_disp";
		            		}

		            		$j++;
		            		if($j == 1)
		            			$default_image = "Y";
		            		else
		            			$default_image = "N";
		            		$isort_no = $_POST['isort_no'][$key];
		            		$ins_query = "insert into $hotel_images_table (hotel_id,hotel_image,default_image,sort_no,created_at,created_by,status) 
		            									  VALUES('$hotel_id','','$default_image','$isort_no','$created_at','$created_by','$status')";
	            			$con->query($ins_query) or die(mysqli_error($con));
	            			$hotel_img_id = $con->insert_id;
		            
		            		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		            		$new_file_name = "hotel_img_".$hotel_img_id;
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
		                                /*$folder = "large";
		                                list($width, $height) = getimagesize($_FILES['hotel_image']['tmp_name']);
		                                $h = $w / ($width / $height);*/
		                            }
		                            $img_path = "../".$hotel_img_dir;
		                            $files[] = resize_key('hotel_image', $key, $w, $h, $new_file_name, $img_path, $folder);
		            			}
		            			$upd_query = "update $hotel_images_table set hotel_image='$new_up_file_name' where id='$hotel_img_id'";
		            			$con->query($upd_query) or die(mysqli_error($con));
		            		}
		            		else
		            		{
		            		    //echo "<script>alert(".print_r($errors).");</script>";
		            		}
		            	}
		            }
	            }

				if($inst_res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Hotels Added successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Hotels Not Added!';
				}
			/*} else {
				$response['status'] = 'error';
				$response = 'Hotels Title Already exists!';
			}*/
			echo json_encode($response);
		}

		//Editdata fetch
		if($_POST['action'] == 'ac_edit_fetch')
		{
			extract($_POST);
			$editquery = "SELECT ht.*,hi.hotel_image FROM $THIS_TABLE ht
			inner join $hotel_images_table hi on hi.hotel_id=ht.id WHERE hi.default_image='Y' and ht.id='$id'";
			$record = $con->query($editquery);
			$output = array();
			if($record->num_rows > 0)
			{
				$data = $record->fetch_array();
			}
			echo json_encode($data);
		}

		//Editdata fetch facilities
		if($_POST['action'] == 'ac_edit_fetch_faci')
		{
			extract($_POST);
			?>
			<!-- Multi select CSS -->
			<link rel="stylesheet" type="text/css" href="multiselect/css/multi-select.css">
			<select id='pre-selected-options' multiple='multiple' name="facilities[]">
			  <?php
				$select_query = "select id,name as facility_name from $master_facilities_table where status='A'";
            	$result = $con->query($select_query) or die(mysqli_error($con));
            	while($data = $result->fetch_array())
            	{
            		$select_fquery = "select id from $hotel_facilities_table where hotel_id='$hotel_id' and facility_id='$data[id]' and status='A'";
            		$result_f = $con->query($select_fquery) or die(mysqli_error($con));
            		if($result_f->num_rows > 0)
	            		echo "<option value='$data[id]' selected>$data[facility_name]</option>";
	            	else
	            		echo "<option value='$data[id]'>$data[facility_name]</option>";
            	}
			 ?>
			</select>
			<!-- Multi select jQuery -->
			<script src="multiselect/js/jquery.multi-select.js"></script>
			<script type="text/javascript">
			$('#pre-selected-options').multiSelect();
			</script>
			<?php
		}

		//Editdata fetch images
		if($_POST['action'] == 'ac_edit_fetch_img')
		{
			extract($_POST);
			?>
			<?php
			echo "<div class='row tt_mimg'>";
			$select_query = "select * from $hotel_images_table where hotel_id='$hotel_id' and status!='E'";
        	$result = $con->query($select_query) or die(mysqli_error($con));
        	while($data = $result->fetch_array())
        	{
        		$checked = "";
        		if($data['default_image'] == "Y")
        			$checked = "checked";
        		echo "<div class='col-md-3' id='img_box_$data[id]'>
    					<img src='../$hotel_img_dir/small/$data[hotel_image]'>
    					<label><input type='radio' name='default' required value='$data[id]' $checked> Default</label>&nbsp;&nbsp;
    					<a class='btn btn-danger' onclick='del_img($data[id]);'>Delete</a>
					</div>";
        	}
        	echo "</div>";
			?>
			<script type="text/javascript">
			function del_img(img_id){
				$.ajax({
				 url: "<?php echo $page_url; ?>",
				 method: "POST",
				 data: 'action=ac_delete_img&img_id='+img_id,
				 success:function(response)
				 {
				 	$('#img_box_'+img_id).remove();
				 },
				 error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			 });
			}
			</script>
			<?php
		}

		//delete image
		if($_POST['action'] == 'ac_delete_img')
		{
			extract($_POST);
			$update_query = "update $hotel_images_table set status='E' where id='$img_id'";
        	$result = $con->query($update_query) or die(mysqli_error($con));
			?>
			<?php
		}

		//Update section
		if($_POST['action'] == 'ac_edit')
		{
			extract($_POST);
			$updated_at = date('Y-m-d H:i:s');
			$updated_by = $_SESSION['admin_uid'];
			$status = "A";

			$update_sql = "update $THIS_TABLE set hotel_admin_id='$hotel_admin_id',category_type_id='$category_type_id',destination_id='$destination_id',city_id='$city_id',code='$code',name='$name',short_description='$short_description',description='$description',address='$address',phone_number='$phone_number',email_id='$email_id',star='$star',slug='$slug',map='$map',sort_no='$sort_no',updated_at='$updated_at',updated_by='$updated_by' where id='$id'";
			$up_res = $con->query($update_sql);
			$hotel_id = $id;

			$del_sql = "delete from $hotel_facilities_table where hotel_id='$id'";
			$con->query($del_sql);
			
			if(isset($facilities))
			{
				$sno = 0;
				foreach($facilities as $val)
				{
					$sno++;
					$insert_query = "insert into $hotel_facilities_table(hotel_id,facility_id,sort_no,created_at,created_by,status)
												values('$id','$val','$sno','$updated_at','$updated_by','A')";
					$inst_res = $con->query($insert_query) or die(mysqli_error($con));
				}
			}

			//image upload
			foreach($_FILES['hotel_image']['name'] as $key => $val)
			{
				if($_FILES['hotel_image']['name'][$key] != "")
				{
					$j = 0;
					if($_FILES['hotel_image']['name'] != '')
	            	{            		
	            		$file_name = $_FILES['hotel_image']['name'][$key];
	            		$file_size = $_FILES['hotel_image']['size'][$key];
	            		$file_tmp = $_FILES['hotel_image']['tmp_name'][$key];
	            		$file_type = $_FILES['hotel_image']['type'][$key];
	            
	            		if($file_size > $max_file_size){
	            			$errors[] = "File size must be less than $max_file_size_disp";
	            		}

	            		$j++;
	            		if($j == 1)
	            			$default_image = "Y";
	            		else
	            			$default_image = "N";
	            		$isort_no = $_POST['isort_no'][$key];
	            		$ins_query = "insert into $hotel_images_table (hotel_id,hotel_image,default_image,sort_no,created_at,created_by,status) 
	            									  VALUES('$hotel_id','','$default_image','$isort_no','$updated_at','$updated_by','$status')";
            			$con->query($ins_query) or die(mysqli_error($con));
            			$hotel_img_id = $con->insert_id;
	            
	            		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	            		$new_file_name = "hotel_img_".$hotel_img_id;
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
	                                /*$folder = "large";
	                                list($width, $height) = getimagesize($_FILES['hotel_image']['tmp_name']);
	                                $h = $w / ($width / $height);*/
	                            }
	                            $img_path = "../".$hotel_img_dir;
	                            $files[] = resize_key('hotel_image', $key, $w, $h, $new_file_name, $img_path, $folder);
	            			}
	            			$upd_query = "update $hotel_images_table set hotel_image='$new_up_file_name' where id='$hotel_img_id'";
	            			$con->query($upd_query) or die(mysqli_error($con));
	            		}
	            		else
	            		{
	            		    //echo "<script>alert(".print_r($errors).");</script>";
	            		}
	            	}
	            }
            }

			if($up_res === true) {
				$response['status'] = 'success';
				$response['message'] = 'Hotels updated successfully!';
			} else {
				$response['status'] = 'error';
				$response['message'] = 'Hotels are Not Updated!';
			}
			echo json_encode($response);
		}
		//viewdata fetch
		if($_POST['action'] == 'ac_view_fetch')
		{
			extract($_POST);
			$editquery = "SELECT ht.*,hi.hotel_image FROM $THIS_TABLE ht
			inner join $hotel_images_table hi on hi.hotel_id=ht.id WHERE hi.default_image='Y' and ht.id= '$id'";
			$record = $con->query($editquery);
			$output = array();
			if($record->num_rows > 0)
			{
					$data = $record->fetch_array();
			}
			echo json_encode($data);
		}
		
		//View Address
		if($_POST['action'] == 'ac_additional_data')
		{
			extract($_POST);
			?>
			<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
		 		<thead>
		 		  <tr align="center">
					<th>Name</th>
					<th>Max Childrens</th>
					<th>Max Adults</th>
					<th>Max People</th>
					<th>Min People</th>
					<th>Num Of Rooms</th>
					<th>Actual Cost</th>
					<th>Final Cost</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
				<?php
			 	$select_query = "SELECT ht.*,hr.*,ri.id,ri.room_image,ri.default_image FROM $THIS_TABLE ht 
			 	INNER JOIN $hotel_rooms_tables hr ON hr.hotel_id=ht.id 
			 	INNER JOIN $hotel_room_images_table ri ON hr.id=ri.room_id WHERE ri.default_image='Y'";
				$record = $con->query($select_query);
				$output = array();
				if($record->num_rows > 0){
					while($data = $record->fetch_array()) {	
							echo "<tr>
								<td> $data[name]</td>
								<td> $data[max_childerns]</td>
								<td> $data[max_adults]</td>
								<td> $data[max_people]</td>
								<td> $data[min_people]</td>
								<td> $data[num_of_rooms]</td>
								<td> $data[actual_cost]</td>
								<td> $data[final_cost]</td>
							 </tr>";
						}
					}
				?>
 				</tbody>
 	  		</table>
 	  		<?php
 	  		echo "<input type='hidden' name='id' value='$id'>";
		}

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
					$response['message'] = 'Hotels Status changed successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Hotels Status NOT changed.';
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
					$response['message'] = 'Hotels Record deleted Successfuly...';
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
		 			<th>Property Type</th>
		 			<th>Destination</th>
		 			<th>City Name</th>
		 			<th>Hotel Name</th>
		 			<th>Phone Number</th>
		 			<th>Created At</th>
		 			<th>Status</th>
		 			<th>Action</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
		 		<?php
		 			if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
		 			{
		 				$select_query = "SELECT ctt.name as category_type_name,dt.id,dt.name as destination_name,ct.id,ct.city as city_name,ht.* FROM $THIS_TABLE ht
		 			         		INNER JOIN $master_property_type_table ctt ON ctt.id=ht.category_type_id 
		 			         		INNER JOIN $master_destination_table dt ON dt.id=ht.destination_id 
		 			         		INNER JOIN $master_city_table ct ON ct.id=ht.city_id WHERE ht.status!='E'";
		 			}
		 			elseif($_SESSION['uType'] == 'HA')
		 			{
		 				$select_query = "SELECT ctt.name as category_type_name,dt.id,dt.name as destination_name,ct.id,ct.city as city_name,ht.* FROM $THIS_TABLE ht
		 							INNER JOIN $master_property_type_table ctt ON ctt.id=ht.category_type_id 
		 			         		INNER JOIN $master_destination_table dt ON dt.id=ht.destination_id 
		 			         		INNER JOIN $master_city_table ct ON ct.id=ht.city_id WHERE ht.hotel_admin_id='$_SESSION[admin_uid]'";
		 			}
		 			$result = $con->query($select_query) or die(mysqli_error($con));
		 			if($result->num_rows > 0){
		 				while($data = $result->fetch_array()) {
		 					if($data['status'] == "A") {
		 						$status = '<span class="badge badge-success badge-shadow">ACTIVE</span>';
		 					} else {
		 						$status = '<span class="badge badge-danger badge-shadow">INACTIVE</span>';
		 					}
		 					echo "<tr>
		 							<td>$data[category_type_name]</td>
		 							<td>$data[destination_name]</td>
		 							<td>$data[city_name]</td>
		 							<td>$data[name]</td>
									<td>$data[phone_number]</td>
		 							<td>$data[created_at]</td>
		 							<td class='text-center'>$status</td>
		 							<td class='text-center'>
		 									<a href='calendar_bookings.php?hotel_id=$data[id]' class='btn btn-success btn-sm'><i class='fas fa-calendar'></i></i></a>
		 									<button type='button' class='btn btn-warning btn-sm view1' data-id='$data[id]'><i class='fas fa-street-view'></i></i></button>
		 									<button type='button' class='btn btn-success btn-sm edit' data-id='$data[id]'><i class='far fa-edit'></i></button>
		 									<button type='button' class='btn btn-info btn-sm view' data-id='$data[id]'><i class='far fa-eye'></i></button>
		 									<button type='button' class='btn btn-primary btn-sm status' data-id='$data[id]' data-status='$data[status]'><i class='fas fa-sync-alt'></i></button>
		 									<button type='button' class='btn btn-danger btn-sm del' data-id='$data[id]'><i class='far fa-trash-alt'></i></button>
		 							  </td>
		 						  </tr>";
		 					}
		 				}
		 				else {
		 					echo "<tr colspan='7'><td>No Hotels found.</td></tr>";
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
		<!-- Multi select CSS -->
		<link rel="stylesheet" type="text/css" href="multiselect/css/multi-select.css">

		<!-- Text Editor-->
		<!--
		<script src="ckeditor/js/ckeditor.js"></script>
		<link rel="stylesheet" href="ckeditor/css/neo.css">-->

		<!--
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="text_editor/editor.js"></script>		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href="text_editor/editor.css" type="text/css" rel="stylesheet"/>
		<textarea type="text" id="short_description" name="short_description" class="txtEditor"></textarea> -->

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
							<?php
							if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
		 					{
			 					?>
			 					<div class="card-header-action">
									<a href="export_hotels.php"><button type="button" id="export" class="btn btn-warning">Export</button></a>
								</div>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div class="card-header-action">
									<button type="button" id="usermodal" class="btn btn-success">Add New</button>
								</div>
								<?php
							}
							else
							{
								$select_query = "select id from $hotels_table where hotel_admin_id='$_SESSION[admin_uid]' and status!='E'";
                            	$result = $con->query($select_query) or die(mysqli_error($con));
                            	if($result->num_rows == 0)
                            	{
									?>
									<div class="card-header-action">
										<button type="button" id="usermodal" class="btn btn-success">Add New</button>
									</div>
									<?php
								}
							}
							?>
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
						    <div class="modal-body row">

						    	<?php
								if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
			 					{
			 					?>
						    	<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Hotel Admin</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<select class="form-control" name="hotel_admin_id" id="hotel_admin_id" required/>
											<option value=''>Select Hotel Admin</option>
										 	<?php
												$select_query = "select id,full_name as admin_name from $admin_table where status!='E' and user_type='HA'";
	                                        	$result = $con->query($select_query) or die(mysqli_error($con));
	                                        	while($data = $result->fetch_array())
	                                        	{
	                                        		echo "<option value='$data[id]'>$data[admin_name]</option>";
	                                        	}
	                                        ?>
										</select>
									  </div>
									</div>
								</div>
								<?php
								}
								?>

								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Property Type</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<select class="form-control" name="category_type_id" id="category_type_id" required/>
										<option value=''>Select Property Type</option>
										 <?php
											$select_query = "select id,name from $master_property_type_table where status!='E'";
                                        	$result = $con->query($select_query) or die(mysqli_error($con));
                                        	while($data = $result->fetch_array())
                                        	{
                                        		echo "<option value='$data[id]'>$data[name]</option>";
                                        	}
                                         ?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Destination Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<select class="form-control" name="destination_id" id="destination_id" required/>
										<option value=''>Select Destination</option>
										 <?php
											$select_query = "select id,name as destination_name from $master_destination_table where status!='E'";
                                        	$result = $con->query($select_query) or die(mysqli_error($con));
                                        	while($data = $result->fetch_array())
                                        	{
                                        		echo "<option value='$data[id]'>$data[destination_name]</option>";
                                        	}
                                         ?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">City Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<select class="form-control" name="city_id" id="city_id" required/>
										<option value=''>Select City</option>
										 <?php
											$select_query = "select id,city as city_name from $master_city_table where status!='E'";
                                        	$result = $con->query($select_query) or die(mysqli_error($con));
                                        	while($data = $result->fetch_array())
                                        	{
                                        		echo "<option value='$data[id]'>$data[city_name]</option>";
                                        	}
                                         ?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Star</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="number" id="star" name="star" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Code</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="code" name="code" class="form-control" /> 
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
										 <input type="text" id="name" name="name" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
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
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Short Description</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <textarea type="text" id="short_description" name="short_description" class="form-control"></textarea> 
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-12">
									<label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Description</label>
									<div class="col-sm-12 col-md-10">
									 <div class="input-group">
										 <textarea type="text" id="description" name="description" class="summernote"></textarea> 
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <textarea type="text" id="address" name="address" class="form-control"></textarea> 
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Phone Number</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="phone_number" name="phone_number" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="email_id" name="email_id" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Map</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="map" name="map" class="form-control" /> 
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
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
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Facilities</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group" id="faci_div">
									 	<select id='pre-selected-options' multiple='multiple' name="facilities[]">
										  <?php
											$select_query = "select id,name as facility_name from $master_facilities_table where status='A'";
                                        	$result = $con->query($select_query) or die(mysqli_error($con));
                                        	while($data = $result->fetch_array())
                                        	{
                                        		echo "<option value='$data[id]'>$data[facility_name]</option>";
                                        	}
										 ?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-12">
									<table class="table table-striped table-hover tt_imgtb" style="width:100%;">
										<tbody id="mi_tb">
											<tr style="text-align: center;">
												<th>Image <?php echo $disp_img_sizes; ?></th>
												<th>Sort No</th>
												<th>Default</th>
												<th>Action</th>
											</tr>
											<tr>
												<td><input type="file" id="hotel_image" name="hotel_image[]" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="hotel_image_pre.src=window.URL.createObjectURL(this.files[0])"/>
												<!--<img id="hotel_image_pre" src="" class="img-fluid" style="width:150px;" /></td>-->
												<td><input type="number" id="isort_no" name="isort_no[]" value="1" class="form-control" /></td>
												<td><input type="radio" id="default" name="default" class="form-control" checked style="height: 20px;" /></td>
												<td><button type="button" class="btn btn-danger">X</button></td>
											</tr>
										</tbody>
									</table>
									<table style="display:none;">
										<tbody id="mi_add">
											<tr>
												<td><input type="file" id="hotel_image" name="hotel_image[]" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="hotel_image_pre.src=window.URL.createObjectURL(this.files[0])"/>
												<!--<img id="hotel_image_pre" src="" class="img-fluid" style="width:150px;" /></td>-->
												<td><input type="number" id="isort_no" name="isort_no[]" value="1" class="form-control" /></td>
												<td><input type="radio" id="default" name="default" class="form-control" style="height: 20px;" /></td>
												<td><button type="button" class="btn btn-danger">X</button></td>
											</tr>
										</tbody>
										<tbody id="mi_clear_add">
											<tr style="text-align: center;">
												<th>Image <?php echo $disp_img_sizes; ?></th>
												<th>Sort No</th>
												<th>Default</th>
												<th>Action</th>
											</tr>
											<tr>
												<td><input type="file" id="hotel_image" name="hotel_image[]" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="hotel_image_pre.src=window.URL.createObjectURL(this.files[0])"/>
												<!--<img id="hotel_image_pre" src="" class="img-fluid" style="width:150px;" /></td>-->
												<td><input type="number" id="isort_no" name="isort_no[]" value="1" class="form-control" /></td>
												<td><input type="radio" id="default" name="default" class="form-control" checked style="height: 20px;" /></td>
												<td><button type="button" class="btn btn-danger">X</button></td>
											</tr>
										</tbody>
									</table>
									<button type="button" class="btn btn-success" id="add_multiple">+ ADD</button>
									<div class="container" id="img_div"></div>
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

				<!--Modal2 Popup Start -->
					<div class="modal fade" id="formModal2" tabindex="-1" role="dialog"
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

								<div class="row" id="data_div">
								</div>

								<div class="modal-footer bg-whitesmoke br">
									<input type="hidden" id="id" name="id" value="0" />
									<input type="hidden" id="page" name="page" value="master" />
									<input type="hidden" id="action" name="action" value="ac_add" />
									<!-- <input type="submit" name="save" id="save" class="btn btn-auth-color" value="Save" /> -->
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						  </form>
						</div>
					  </div>
					</div>
				<!-- Modal2 Popup End  -->


	<?php
		include('footer.php');
	?>
	<!-- Multi select jQuery -->
	<script src="multiselect/js/jquery.multi-select.js"></script>
	<script type="text/javascript">
	$('#pre-selected-options').multiSelect();
	</script>

	<script>
			$(document).ready(function() {
				$('.txtEditor').Editor();
			});
		</script>

	<script>

		function checkFile(item){
			var extension = $(item).val().split('.').pop().toLowerCase();
			var validExtensions = ['jpeg', 'jpg', 'png', 'pdf'];
			if ($.inArray(extension, validExtensions) == -1) {
				$(item).replaceWith($(item).val('').clone(true));
				//$('#save').prop('disabled', true);
				swal.fire({
					  icon: "warning",
					  title: "Failed",
					  text: "Failed! Please upload png, jpg, jpeg, pdf file only.",
					  type: 'success',
					  timer: 5000,
					});
			}
			else {
			// Check and restrict the file size to 32 KB.
				if ($(item).get(0).files[0].size > (10971000)) {
					swal.fire({
					  icon: "warning",
					  title: "Failed",
					  text: "Failed!! Max allowed file size is 10 MB.",
					  type: 'success',
					  timer: 5000,
					});
					$(item).replaceWith($(item).val('').clone(true));
					//$('#save').prop('disabled', true);
				}
				else {
					$('#errormsg').text('').hide();
					$('#save').prop('disabled', false);
				}
			}
		};

		$(document).ready(function (){

		  jQuery('#add_multiple').on('click', function (e) {
		    $( "#mi_tb" ).append( $("#mi_add").html() );
		  });

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
			function load_facilities(hotel_id){
				$.ajax({
				 url: "<?php echo $page_url; ?>",
				 method: "POST",
				 data: 'action=ac_edit_fetch_faci&hotel_id='+hotel_id,
				 success:function(response)
				 {
					 $('#faci_div').html(response);
				 },
				 error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			 });
			}
			function load_images(hotel_id){
				$.ajax({
				 url: "<?php echo $page_url; ?>",
				 method: "POST",
				 data: 'action=ac_edit_fetch_img&hotel_id='+hotel_id,
				 success:function(response)
				 {
					 $('#img_div').html(response);
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
			//$('#save').attr('disabled', 'disabled');
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
					$('#action').val('ac_add');
					$('#mi_tb').html( $("#mi_clear_add").html() );
					$('#description').html('');
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
                    window.location.href='<?php echo basename($_SERVER['PHP_SELF']); ?>';
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
				$('#hotel_admin_id').val(data.hotel_admin_id);
				$('#category_type_id').val(data.category_type_id);
				$('#destination_id').val(data.destination_id);
				$('#city_id').val(data.city_id);
				$('#code').val(data.code);
				$('#name').val(data.name);
				$('#short_description').val(data.short_description);
				$('#description').html(data.description);
				$('#address').val(data.address);
				$('#phone_number').val(data.phone_number);
				$('#email_id').val(data.email_id);
				$('#star').val(data.star);
				$('#slug').val(data.slug);
				$('#map').val(data.map);
				$('#sort_no').val(data.sort_no);
				//$('#hotel_image_pre').attr("src", "<?php echo "../$hotel_img_dir/small/"; ?>"+data.hotel_image).show;
				$('#sort_no').val(data.sort_no);
				$('#id').val(id);
				$('#action').val('ac_edit');
				$('#save').val('Update');
				$('#save').css({"display": "visible"});
				load_facilities(id);
				load_images(id);
				$('#pre-selected-options').multiSelect();
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
					$('#hotel_admin_id').val(data.hotel_admin_id);
					$('#category_type_id').val(data.category_type_id);
					$('#destination_id').val(data.destination_id);
					$('#city_id').val(data.city_id);
					$('#code').val(data.code);
					$('#name').val(data.name);
					$('#short_description').val(data.short_description);
					$('#description').html(data.description);
					$('#address').val(data.address);
					$('#phone_number').val(data.phone_number);
					$('#email_id').val(data.email_id);
					$('#star').val(data.star);
					$('#slug').val(data.slug);
					$('#map').val(data.map);
					$('#sort_no').val(data.sort_no);
					$('#hotel_image_pre').attr("src", "<?php echo "../$hotel_img_dir/small/"; ?>"+data.hotel_image).show;
					$('#sort_no').val(data.sort_no);
					$('#action').val('ac_view');
					$('#save').css({"display": "none"});
				},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			});
		});

		//additional data
		$(document).on('click','.view1', function(event){
			event.preventDefault();
			var id = $(this).data('id');
			var page   = 'master';
			var action = 'ac_additional_data';
			$.ajax({
				url:"<?php echo $page_url; ?>",
				method:"POST",
				data:{id:id,action:action,page:page},
				dataType:"html",
				success:function(data)
				{
				   $('#formModal2').modal('show');
				   $('.modal-title').html('<i class="far fa-eye"></i>Additional Data');
				   $('#data_div').html(data);

	   			   $('#action').val('ac_additional_data');
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
