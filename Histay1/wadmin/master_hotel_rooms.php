<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	//DB connect
	$con = new mysqli($host, $user,$pass,$db_name);

	$update = false;
	$select = false;

	$page_title = "Hotel Rooms";
	$sub_page_title = "Master Hotels";
	$msg_title = "Master Hotels";
	$THIS_TABLE = $hotel_rooms_tables;

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
			$select_query = " select id from $THIS_TABLE where name='$name' and hotel_id='$hotel_id' and status!='E'";
			$result = $con->query($select_query) or die(mysqli_error($con));
			if($result->num_rows == 0)
			{
				$insert_query = "insert into $THIS_TABLE(hotel_id,name,short_description,max_childerns,max_adults,max_people,min_people,num_of_rooms,actual_cost,final_cost,tax_id,homepage,sort_no,created_at,created_by,status)
												values('$hotel_id','$name','$short_description','$max_childerns','$max_adults','$max_people','$min_people','$num_of_rooms','$actual_cost','$final_cost','$tax_id','$homepage','$sort_no','$created_at','$created_by','$status')";
				$inst_res = $con->query($insert_query) or die(mysqli_error($con));
				$room_id = $con->insert_id;

				
				if(isset($facilities))
				{
					$sno = 0;
					foreach($facilities as $val)
					{
						$sno++;
						$insert_query = "insert into $hotel_rooms_facilities_table(room_id,facility_id,sort_no,created_at,created_by,status)
													values('$room_id','$val','$sno','$created_at','$created_by','$status')";
						$inst_res = $con->query($insert_query) or die(mysqli_error($con));
					}
				}

				for($i=1; $i<=$num_of_rooms; $i++)
				{
					$insert_query = "insert into $hotel_room_number_table(hotel_id,room_id,room_no,status)
												values('$hotel_id','$room_id',10000+id,'$status')";
					$inst_res = $con->query($insert_query) or die(mysqli_error($con));
				}

				//image upload
				foreach($_FILES['room_image']['name'] as $key => $val)
				{
				    if($_FILES['room_image']['name'][$key] != "")
					{
						$j = 0;
						if($_FILES['room_image']['name'] != '')
		            	{            		
		            		$file_name = $_FILES['room_image']['name'][$key];
		            		$file_size = $_FILES['room_image']['size'][$key];
		            		$file_tmp = $_FILES['room_image']['tmp_name'][$key];
		            		$file_type = $_FILES['room_image']['type'][$key];
		            
		            		if($file_size > $max_file_size){
		            			$errors[] = "File size must be less than $max_file_size_disp";
		            		}

		            		$j++;
		            		if($j == 1)
		            			$default_image = "Y";
		            		else
		            			$default_image = "N";
		            		$isort_no = $_POST['isort_no'][$key];
		            		$ins_query = "insert into $hotel_room_images_table (room_id,room_image,default_image,sort_no,created_at,created_by,status) 
		            									  VALUES('$room_id','','$default_image','$isort_no','$created_at','$created_by','$status')";
	            			$con->query($ins_query) or die(mysqli_error($con));
	            			$room_img_id = $con->insert_id;
		            
		            		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		            		$new_file_name = "rooms_".$room_img_id;
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
		                            $img_path = "../".$room_img_dir;
		                            $files[] = resize_key('room_image', $key, $w, $h, $new_file_name, $img_path, $folder);
		            			}
		            			$upd_query = "update $hotel_room_images_table set room_image='$new_up_file_name' where id='$room_img_id'";
		            			$con->query($upd_query) or die(mysqli_error($con));
		            		}
		            		else
		            		{
		            		    //echo "<script>alert(".print_r($errors).");</script>";
		            		}
		            	}
		            }
		            
    				/*if($_FILES['room_image']['name'] != '')
                	{            		
                		$file_name = $_FILES['room_image']['name'];
                		$file_size = $_FILES['room_image']['size'];
                		$file_tmp = $_FILES['room_image']['tmp_name'];
                		$file_type = $_FILES['room_image']['type'];
                		$file_ext = explode('.',$file_name);
                
                		if($file_size > $max_file_size){
                			$errors[] = "File size must be less than $max_file_size_disp";
                		}
                
                		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
                		$new_file_name = "rooms_".$room_id;
                		$new_up_file_name = $new_file_name.".".$ext;
                		if(empty($errors)==true)
                		{
                            $f = 0;
                			foreach ($img_sizes as $w => $h)
                			{
                                $f++;
                                if($f == 1)
                                    $folder = "small";
                                elseif($f == 2)
                                {
                                    $folder = "large";
                                    list($width, $height) = getimagesize($_FILES['room_image']['tmp_name']);
                                    $h = $w / ($width / $height);
                                }
                                $img_path = "../".$room_img_dir;
                                $files[] = resize('room_image', $w, $h, $new_file_name, $img_path, $folder);
                			}
                			$ins_query = "insert into $hotel_room_images_table (room_id,room_image,default_image,sort_no,created_at,created_by,status) 
                									  VALUES('$room_id','$new_file_name','Y','$sort_no','$created_at','$created_by','$status')";
                			$con->query($ins_query) or die(mysqli_error($con));
                		}
                		else
                		{
                		    //echo "<script>alert(".print_r($errors).");</script>";
                		}
                	}*/
				}

				if($inst_res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Hotel Rooms Added successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Hotel Rooms Not Added!';
				}
			} else {
				$response['status'] = 'error';
				$response = 'Hotel Rooms Title Already exists!';
			}
			echo json_encode($response);
		}
		
		//Editdata fetch images
		if($_POST['action'] == 'ac_edit_fetch_img')
		{
			extract($_POST);
			?>
			<?php
			echo "<div class='row tt_mimg'>";
			$select_query = "select * from $hotel_room_images_table where room_id='$room_id' and status!='E'";
        	$result = $con->query($select_query) or die(mysqli_error($con));
        	while($data = $result->fetch_array())
        	{
        		$checked = "";
        		if($data['default_image'] == "Y")
        			$checked = "checked";
        		echo "<div class='col-md-3' id='img_box_$data[id]'>
    					<img src='../$room_img_dir/small/$data[room_image]'>
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
			$update_query = "update $hotel_room_images_table set status='E' where id='$img_id'";
        	$result = $con->query($update_query) or die(mysqli_error($con));
			?>
			<?php
		}

		//Editdata fetch
		if($_POST['action'] == 'ac_edit_fetch')
		{
			extract($_POST);
			$editquery = " SELECT hr.*,hi.room_image FROM $THIS_TABLE hr 
			inner join $hotel_room_images_table hi on hi.room_id=hr.id WHERE hi.default_image='Y' and hr.id='$id'";
			$record = $con->query($editquery);
			$output = array();
			if($record->num_rows > 0)
			{
				$data = $record->fetch_array();
			}
			else
			{
				$editquery = " SELECT * FROM $THIS_TABLE WHERE id='$id'";
				$record = $con->query($editquery);
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
            		$select_fquery = "select id from $hotel_rooms_facilities_table where room_id='$room_id' and facility_id='$data[id]' and status='A'";
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

		//Update section
		if($_POST['action'] == 'ac_edit')
		{
			extract($_POST);
			$updated_at = date('Y-m-d H:i:s');
			$updated_by = $_SESSION['admin_uid'];
			$status     = "A";
			$sort_no = 0;

			$update_sql = "update $THIS_TABLE set hotel_id='$hotel_id',name='$name',short_description='$short_description',max_childerns='$max_childerns',max_adults='$max_adults',max_people='$max_people',min_people='$min_people',num_of_rooms='$num_of_rooms',actual_cost='$actual_cost',final_cost='$final_cost',tax_id='$tax_id',homepage='$homepage',sort_no='$sort_no',updated_at='$updated_at',updated_by='$updated_by' where id='$id'";
			$up_res = $con->query($update_sql);
			$room_id = $id;

			$del_sql = "delete from $hotel_rooms_facilities_table where room_id='$id'";
			$con->query($del_sql);
			$sno = 0;
			if(isset($facilities))
			{
				foreach($facilities as $val)
				{
					$sno++;
					$insert_query = "insert into $hotel_rooms_facilities_table(room_id,facility_id,sort_no,created_at,created_by,status)
												values('$id','$val','$sno','$updated_at','$updated_by','$status')";
					$inst_res = $con->query($insert_query) or die(mysqli_error($con));
				}
			}

			//Insert into room nos
			$select_query = "select id from $hotel_room_number_table where room_id='$room_id' and status!='E'";
			$result = $con->query($select_query) or die(mysqli_error($con));
			$rn_count = $result->num_rows;
			$bal_rooms = $num_of_rooms - $rn_count;
			if($bal_rooms > 0)
			{
				for($i=1;$i<=$bal_rooms;$i++)
				{
					$insert_query = "insert into $hotel_room_number_table(hotel_id,room_id,room_no,status)
													values('$hotel_id','$room_id','','$status')";
					$inst_res = $con->query($insert_query) or die(mysqli_error($con));
					$room_no_id = $con->insert_id;

					$room_no = 10000 + $room_no_id;
					$update_query = "update $hotel_room_number_table set room_no='$room_no' where id='$room_no_id'";
					$update_res = $con->query($update_query) or die(mysqli_error($con));
				}
			}
			elseif($bal_rooms < 0)
			{
			    $bal_rooms *= -1;
				$delete_query = "delete from $hotel_room_number_table where room_id='$room_id' limit $bal_rooms";
				$del_res = $con->query($delete_query) or die(mysqli_error($con));
				/*for($i=1;$i<=$bal_rooms;$i++)
				{
					$insert_query = "insert into $hotel_room_number_table(hotel_id,room_id,room_no,status)
													values('$hotel_id','$room_id','','$status')";
					$inst_res = $con->query($insert_query) or die(mysqli_error($con));
					$room_no_id = $con->insert_id;

					$room_no = 10000 + $room_no_id;
					$update_query = "update $hotel_room_number_table set room_no='$room_no' where id='$room_no_id'";
					$update_res = $con->query($insert_query) or die(mysqli_error($con));
				}*/
			}

            //image upload
			foreach($_FILES['room_image']['name'] as $key => $val)
			{
			    if($_FILES['room_image']['name'][$key] != "")
				{
					$j = 0;
					if($_FILES['room_image']['name'] != '')
	            	{            		
	            		$file_name = $_FILES['room_image']['name'][$key];
	            		$file_size = $_FILES['room_image']['size'][$key];
	            		$file_tmp = $_FILES['room_image']['tmp_name'][$key];
	            		$file_type = $_FILES['room_image']['type'][$key];
	            
	            		if($file_size > $max_file_size){
	            			$errors[] = "File size must be less than $max_file_size_disp";
	            		}

	            		$j++;
	            		if($j == 1)
	            			$default_image = "Y";
	            		else
	            			$default_image = "N";
	            		$isort_no = $_POST['isort_no'][$key];
	            		$ins_query = "insert into $hotel_room_images_table (room_id,room_image,default_image,sort_no,created_at,created_by,status) 
	            									  VALUES('$room_id','','$default_image','$isort_no','$updated_at','$updated_by','$status')";
            			$con->query($ins_query) or die(mysqli_error($con));
            			$room_img_id = $con->insert_id;
	            
	            		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	            		$new_file_name = "rooms_".$room_img_id;
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
	                            $img_path = "../".$room_img_dir;
	                            $files[] = resize_key('room_image', $key, $w, $h, $new_file_name, $img_path, $folder);
	            			}
	            			$upd_query = "update $hotel_room_images_table set room_image='$new_up_file_name' where id='$room_img_id'";
	            			$con->query($upd_query) or die(mysqli_error($con));
	            		}
	            		else
	            		{
	            		    //echo "<script>alert(".print_r($errors).");</script>";
	            		}
	            	}
	            }
    			
    			/*//image upload
    			if($_FILES['room_image']['name'] != '')
            	{            		
            		$file_name = $_FILES['room_image']['name'];
            		$file_size = $_FILES['room_image']['size'];
            		$file_tmp = $_FILES['room_image']['tmp_name'];
            		$file_type = $_FILES['room_image']['type'];
            		$file_ext = explode('.',$file_name);
            
            		if($file_size > $max_file_size){
            			$errors[] = "File size must be less than $max_file_size_disp";
            		}
            
            		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
            		$new_file_name = "rooms_".$room_id;
            		$new_up_file_name = $new_file_name.".".$ext;
            		if(empty($errors)==true)
            		{
                         $f = 0;
            			foreach ($img_sizes as $w => $h)
            			{
                            $f++;
                            if($f == 1)
                                $folder = "small";
                            elseif($f == 2)
                            {
                                $folder = "large";
                                list($width, $height) = getimagesize($_FILES['room_image']['tmp_name']);
                                $h = $w / ($width / $height);
                            }
                            $img_path = "../".$room_img_dir;
                            $files[] = resize('room_image', $w, $h, $new_file_name, $img_path, $folder);
            			}
            			$ins_query = "insert into $hotel_room_images_table (room_id,room_image,default_image,created_at,created_by,status) 
            									  VALUES('$room_id','$new_up_file_name','Y','$updated_at','$updated_by','A')";
            			$con->query($ins_query) or die(mysqli_error($con));
    
            		}
            		else
            		{
            		    //echo "<script>alert(".print_r($errors).");</script>";
            		}
            	}*/
			}

			/*if($up_res === true) {
				$response['status'] = 'success';
				$response['message'] = 'Hotel Rooms updated successfully!';
			} else {
				$response['status'] = 'error';
				$response['message'] = 'Hotel Rooms are Not Updated!';
			}*/
			$response['status'] = 'success';
			$response['message'] = 'Hotel Rooms updated successfully!';
			echo json_encode($response);
		}
		//viewdata fetch
		if($_POST['action'] == 'ac_view_fetch')
		{
			extract($_POST);
			$editquery = "SELECT hr.*,hi.room_image FROM $THIS_TABLE hr 
			inner join $hotel_room_images_table hi on hi.room_id=hr.id WHERE hi.default_image='Y' and hr.id='$id'";
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

				if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
					$sql = "update $THIS_TABLE set admin_status='$status' where id='$id'";
				elseif($_SESSION['uType'] == 'HA')
					$sql = "update $THIS_TABLE set status='$status' where id='$id' ";
				
				$res = $con->query($sql);

				if($res === true ){
					$response['status'] = 'success';
					$response['message'] = 'Hotel Rooms Status changed successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Hotel Rooms Status NOT changed.';
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
					$response['message'] = 'Hotel Rooms Record deleted Successfuly...';
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
		 			<th>Hotel Name</th>
		 			<th>Name</th>
		 			<th>Actual Cost</th>
		 			<th>Final Cost</th>
		 			<th>Homepage</th>
		 			<th>Created At</th>
		 			<th>Status</th>
		 			<th>Action</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
		 		<?php

		 			if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
		 			{
		 				$select_query = "SELECT ht.id,ht.name as hotel_name,hr.* FROM $THIS_TABLE hr
		 			         			INNER JOIN $hotels_table ht ON ht.id=hr.hotel_id 
		 			         			WHERE hr.status!='E'";
		 			}
		 			elseif($_SESSION['uType'] == 'HA')
			 		{
			 			$select_query = "SELECT ht.id,ht.name as hotel_name,hr.* FROM $THIS_TABLE hr
		 			         			INNER JOIN $hotels_table ht ON ht.id=hr.hotel_id 
		 			         			WHERE hr.status!='E' and hr.hotel_id='$_SESSION[admin_uid]'";
			 		}
		 			$result = $con->query($select_query) or die(mysqli_error($con));
		 			if($result->num_rows > 0){
		 				while($data = $result->fetch_array()) {

		 					if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
							{
			 					if($data['admin_status'] == "A") {
			 						$status = '<span class="badge badge-success badge-shadow">ACTIVE</span>';
			 					} else {
			 						$status = '<span class="badge badge-danger badge-shadow">INACTIVE</span>';
			 					}
			 					$dstatus = $data['admin_status'];
			 				}
			 				elseif($_SESSION['uType'] == 'HA')
			 				{
			 					if($data['status'] == "A") {
			 						$status = '<span class="badge badge-success badge-shadow">ACTIVE</span>';
			 					} else {
			 						$status = '<span class="badge badge-danger badge-shadow">INACTIVE</span>';
			 					}
			 					$dstatus = $data['status'];
			 				}

		 					if($data['homepage'] == "Y"){
		 						$homepage = '<span class="badge badge-success badge-shadow"> YES</span>';
		 					}else if($data['homepage'] == "N"){
		 						$homepage = '<span class="badge badge-danger badge-shadow"> NO</span>';
		 					}
		 					echo "<tr>
		 							<td>$data[hotel_name]</td>
		 							<td>$data[name]</td>
		 							<td>$data[actual_cost]</td>
		 							<td>$data[final_cost]</td>
									<td>$homepage</td>
		 							<td>$data[created_at]</td>
		 							<td class='text-center'>$status</td>
		 							<td class='text-center'>
		 									<button type='button' class='btn btn-success btn-sm edit' data-id='$data[id]'><i class='far fa-edit'></i></button>
		 									<button type='button' class='btn btn-info btn-sm view' data-id='$data[id]'><i class='far fa-eye'></i></button>
		 									<button type='button' class='btn btn-primary btn-sm status' data-id='$data[id]' data-status='$dstatus'><i class='fas fa-sync-alt'></i></button>
		 									<button type='button' class='btn btn-danger btn-sm del' data-id='$data[id]'><i class='far fa-trash-alt'></i></button>
		 							  </td>
		 						  </tr>";
		 					}
		 				}
		 				else {
		 					echo "<tr colspan='7'><td>No Hotel Rooms found.</td></tr>";
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
								<a href="export_bookings.php"><button type="button" id="export" class="btn btn-warning">Export</button></a>
							</div>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<div class="card-header-action">
								<button type="button" id="usermodal" class="btn btn-success">Add New</button>
							</div>
							<?php
							}
							elseif($_SESSION['uType'] == 'HA')
							{
							?>	
							<div class="card-header-action">
								<button type="button" id="usermodal" class="btn btn-success">Add New</button>
							</div>
							<?php
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
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Hotel Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<select class="form-control" name="hotel_id" id="hotel_id" required/>
											<option value=''>Select Hotel</option>
										 	<?php
											$select_query = "select id,name as hotel_name,hotel_admin_id from $hotels_table where status!='E'";
                                        	$result = $con->query($select_query) or die(mysqli_error($con));
                                        	while($data = $result->fetch_array())
                                        	{
                                        		if($_SESSION['admin_uid'] == $data['hotel_admin_id'])
	                                        		echo "<option value='$data[id]' selected>$data[hotel_name]</option>";
	                                        	else
	                                        		echo "<option value='$data[id]'>$data[hotel_name]</option>";
                                        	}
                                         	?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Room Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										 <input type="text" id="name" name="name" class="form-control" placeholder="Room Name" /> 
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
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Max Childrens</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="number" id="max_childerns" name="max_childerns" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Max Adults</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="number" id="max_adults" name="max_adults" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Max Peoples</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="number" id="max_people" name="max_people" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Min Peoples</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="number" id="min_people" name="min_people" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Of Rooms</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="number" id="num_of_rooms" name="num_of_rooms" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Actual Cost</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="actual_cost" name="actual_cost" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Final Cost</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<input type="text" id="final_cost" name="final_cost" class="form-control" />
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">HomePage</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<p class="input-group-text">
										<label><input type="radio" id="homepage_y" name="homepage" value="Y" required /> YES</label>&nbsp&nbsp&nbsp
										<label><input type="radio" id="homepage_n" name="homepage" value="N" required /> NO</label>
										</p>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tax</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-tags"></i> </div>
										</div>
										<select class="form-control" name="tax_id" id="tax_id" required/>
										<option value=''>Select Tax</option>
										 <?php
											$select_query = "select * from $master_tax_table where status!='E'";
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
												<th>Image (<?php echo $disp_img_sizes; ?>)</th>
												<th>Sort No</th>
												<th>Default</th>
												<th>Action</th>
											</tr>
											<tr>
												<td><input type="file" id="room_image" name="room_image[]" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="room_image_pre.src=window.URL.createObjectURL(this.files[0])"/>
												<!--<img id="room_image_pre" src="" class="img-fluid" style="width:150px;" />--></td>
												<td><input type="number" id="isort_no" name="isort_no[]" value="1" class="form-control" /></td>
												<td><input type="radio" id="default" name="default[]" class="form-control" checked style="height: 20px;" /></td>
												<td><button type="button" class="btn btn-danger">X</button></td>
											</tr>
										</tbody>
									</table>
									<table style="display:none;">
										<tbody id="mi_add">
											<tr>
												<td><input type="file" id="room_image" name="room_image[]" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="room_image_pre.src=window.URL.createObjectURL(this.files[0])"/>
												<!--<img id="room_image_pre" src="" class="img-fluid" style="width:150px;" />--></td>
												<td><input type="number" id="isort_no" name="isort_no[]" value="1" class="form-control" /></td>
												<td><input type="radio" id="default" name="default[]" class="form-control" style="height: 20px;" /></td>
												<td><button type="button" class="btn btn-danger">X</button></td>
											</tr>
										</tbody>
									</table>
									<button type="button" class="btn btn-success" id="add_multiple">+ ADD</button>
									<div class="container" id="img_div"></div>
								</div>
								<!--
								<div class="form-group row col-md-12">
									<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
									<tr style="text-align: center;">
										<th>Image</th>
										<th>Sort No</th>
										<th>Action</th>
									</tr>
									<tr>
										<td><input type="file" id="room_image" name="room_image" class="form-control" onchange="checkFile(this)" accept="image/*" oninput="room_image_pre.src=window.URL.createObjectURL(this.files[0])"/><br>
										<img id="room_image_pre" src="" class="img-fluid" style="width:150px;" /></td>
										<td><input type="text" id="sort_no" name="sort_no" class="form-control"></td>
										<td></td>
									</tr>
									</table>
								</div>-->
								<div class="modal-footer bg-whitesmoke br">
									<input type="hidden" id="id" name="id" value="0" />
									<input type="hidden" id="page" name="page" value="master" />
									<input type="hidden" id="action" name="action" value="ac_add" />
									<input type="submit" name="save" id="save" class="btn btn-success" value="Save" />
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
	<!-- Multi select jQuery -->
	<script src="multiselect/js/jquery.multi-select.js"></script>
	<script type="text/javascript">
	$('#pre-selected-options').multiSelect();
	</script>

	<script>
		function checkFile(item){
			var extension = $(item).val().split('.').pop().toLowerCase();
			var validExtensions = ['jpeg', 'jpg', 'png', 'pdf'];
			if ($.inArray(extension, validExtensions) == -1) {
				$(item).replaceWith($(item).val('').clone(true));
				$('#save').prop('disabled', true);
				//swal('Failed! Please upload png, jpg, jpeg, pdf file only.');
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
					$('#save').prop('disabled', true);
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
			function load_facilities(room_id){
				$.ajax({
				 url: "<?php echo $page_url; ?>",
				 method: "POST",
				 data: 'action=ac_edit_fetch_faci&room_id='+room_id,
				 success:function(response)
				 {
					 $('#faci_div').html(response);
				 },
				 error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			 });
			}
			function load_images(room_id){
				$.ajax({
				 url: "<?php echo $page_url; ?>",
				 method: "POST",
				 data: 'action=ac_edit_fetch_img&room_id='+room_id,
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
					window.location.href='master_hotel_rooms.php';
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
				$('#hotel_id').val(data.hotel_id);
				$('#name').val(data.name);
				$('#short_description').val(data.short_description);
				$('#max_childerns').val(data.max_childerns);
				$('#max_adults').val(data.max_adults);
				$('#max_people').val(data.max_people);
				$('#min_people').val(data.min_people);
				$('#num_of_rooms').val(data.num_of_rooms);
				$('#actual_cost').val(data.actual_cost);
				$('#final_cost').val(data.final_cost);
				if(data.homepage == "Y")
					$('#homepage_y').attr('checked',true);
				else if(data.homepage == "N")
					$('#homepage_n').attr('checked',true);
				$('#tax_id').val(data.tax_id);
				$('#sort_no').val(data.sort_no);
				$('#room_image_pre').attr("src", "<?php echo "../$room_img_dir/small/"; ?>"+data.room_image).show;
				$('#sort_no').val(data.sort_no);
				$('#id').val(id);
				$('#action').val('ac_edit');
				$('#save').val('Update');
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
					$('#hotel_id').val(data.hotel_id);
					$('#name').val(data.name);
					$('#short_description').val(data.short_description);
					$('#max_childerns').val(data.max_childerns);
					$('#max_adults').val(data.max_adults);
					$('#max_people').val(data.max_people);
					$('#min_people').val(data.min_people);
					$('#num_of_rooms').val(data.num_of_rooms);
					$('#actual_cost').val(data.actual_cost);
					$('#final_cost').val(data.final_cost);
					$('#homepage_n').attr('checked',false);
					$('#homepage_y').attr('checked',false);
					if(data.homepage == "N")
						$('#homepage_n').attr('checked',true);
					else if(data.homepage == "Y")
						$('#homepage_y').attr('checked',true);
					$('#tax_id').val(data.tax_id);
					$('#sort_no').val(data.sort_no);
					$('#room_image_pre').attr("src", "<?php echo "../$room_img_dir/small/"; ?>"+data.room_image).show;
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
<?php
}
}
else {
echo "<script>window.location.href='login.php';</script>";
}
?>
