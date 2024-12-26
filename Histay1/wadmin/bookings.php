<?php
session_start();
if(isset($_SESSION['admin_uid']))
{
	include_once("db-config.php");
	//DB connect
	$con = new mysqli($host, $user,$pass,$db_name);

	$page_title = "Room Bookings";
	$sub_page_title = "Room Bookings";
	$msg_title = "Room Bookings";
	$THIS_TABLE = $hotel_booking_table;

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
			$rooms = "1";

            if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
 			{
 			    $hotel_id = $_POST['hotel_id'];
 			}
 			else
 			{
    			$select_query = "SELECT id from $hotels_table where hotel_admin_id = '$_SESSION[admin_uid]'";
    			$result = $con->query($select_query) or die(mysqli_error($con));
    			$data = $result->fetch_array();
    			$hotel_id = $data['id'];
 			}

			$select_query = "SELECT id from $hotel_room_booking_table where ((checkin_date<='$checkin_date' and checkin_date>='$checkout_date') 
					or (checkout_date>='$checkin_date' and checkout_date<='$checkout_date')) and status!='E'";
			$result = $con->query($select_query) or die(mysqli_error($con));
			$count = $result->num_rows;

			$sel_query = "SELECT num_of_rooms from $hotel_rooms_tables where id='$room_id' and status!='E'";
			$sel_result = $con->query($sel_query) or die(mysqli_error($con));
			$data = $sel_result->fetch_array();

			if($count < $data['num_of_rooms'])
			{

				$insert_query = "insert into $hotel_booking_table(booking_code,hotel_id,first_name,last_name,email,address,postal_code,city_id,state_id,
					country_id,phone_number,mobile_number,coupon_code,discount_type,discount_value,order_total,tax_id,tax_per,tax_value,final_total,payment_method,payment_status,special_request,created_at,created_by,status)
					values('','$hotel_id','$first_name','$last_name','$email','$address','$postal_code','$city_id',
					'$state_id','$country_id','$phone_number','$mobile_number','$coupon_code','$discount_type','$discount_value','$order_total','$tax_id',
					'$tax_per','$tax_value','$final_total','$payment_method','$payment_status','$special_request','$created_at','$created_by','A')";

				$inst_res = $con->query($insert_query) or die(mysqli_error($con));
				$insert_id = $con->insert_id;

				$booking_int = 1000000 + $insert_id;
			    $booking_code = "HB".$booking_int;

			    $update_query = "update $THIS_TABLE set booking_code ='$booking_code' where id='$insert_id'";
			    $up_res = $con->query($update_query);

			    $ins_query = "insert into $hotel_room_booking_table(booking_id,checkin_date,checkout_date,room_id,rooms,adults,childerns,created_at,created_by,status)
    				Values('$insert_id','$checkin_date','$checkout_date','$room_id','$rooms','$adults','$childerns','$created_at','$created_by','A')";
    			$ins_result = $con->query($ins_query) or die(mysqli_error($con));
    			$booking_room_id = $con->insert_id;
    			
    			$from_date = strtotime($checkin_date); 
				$end_date = strtotime($checkout_date);
				$date_count = abs($end_date - $from_date);
				$total_days = $date_count/86400;
				$total_days = intval($total_days);

    			for ($i=1; $i <= $total_days; $i++)
				{
					$booking_date=date( 'Y-m-d', $i );
					$insert_query = "insert into $hotel_booking_room_date_table(booking_id,booking_room_id,room_id,booking_date,status)
												values('$insert_id','$booking_room_id','$room_id','$booking_date','$status')";
					$insert_result = $con->query($insert_query) or die(mysqli_error($con));
				}
    		}

			if($inst_res === true ){
				$response['status'] = 'success';
				$response['message'] = 'Booking Added successfully!';
			} else {
				$response['status'] = 'error';
				$response['message'] = 'Booking Not Added!';
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

			$update_sql = "update $THIS_TABLE set payment_method='$payment_method',payment_status='$payment_status',updated_at='$updated_at',updated_by='$updated_by' where id='$id'";
			$up_res = $con->query($update_sql);
			if($up_res === true) {
				$response['status'] = 'success';
				$response['message'] = 'Booking updated successfully!';
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
			$editquery = "SELECT me.id,me.name as member_name,ht.id,ht.name as hotel_name,ct.id,ct.city as city_name,st.id,st.state as state_name,
			                        cy.id,cy.country_name,tx.id,tx.name as tax_name,bk.* FROM $THIS_TABLE bk
		 							INNER JOIN $members_table me ON me.id=bk.member_id 
		 							INNER JOIN $hotels_table ht ON ht.id=bk.hotel_id 
		 							INNER JOIN $master_city_table ct ON ct.id=bk.city_id
		 							INNER JOIN $master_state_table st ON st.id=bk.state_id
		 							INNER JOIN $master_country_table cy ON cy.id=bk.country_id
		 							INNER JOIN $master_tax_table tx ON tx.id=bk.tax_id
		 							WHERE bk.member_id='$id' AND bk.status='A'";
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
					<th>Room</th>
					<th>Adults</th>
					<th>Childrens</th>
					<th>Cost</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
				<?php
			 	$select_query = "SELECT rb.*,hr.id,hr.name as room_name FROM $hotel_room_booking_table rb INNER JOIN $hotel_rooms_tables hr ON hr.id=rb.room_id WHERE rb.booking_id='$id' and rb.status='A'";
				$record = $con->query($select_query);
				$output = array();
				if($record->num_rows > 0)
				{
					while($data = $record->fetch_array()) 
					{	
						echo "<tr>
								<td> $data[room_name]</td>
								<td> $data[adults]</td>
								<td> $data[childerns]</td>
								<td> $data[cost].Rs</td>
							 </tr>";
					}
				}
				?>
 				</tbody>
 	  		</table>
 	  		<?php
 	  		echo "<input type='hidden' name='id' value='$id'>";
		}

		//View2 Address
		if($_POST['action'] == 'ac_additional_data2')
		{
			extract($_POST);
			$select_query = "SELECT ht.id,ht.name as hotel_name,ct.id,ct.city,st.id,st.state,cy.id,cy.country_name,tx.id,tx.name as tax_name,bk.* FROM $THIS_TABLE bk
		 							INNER JOIN $hotels_table ht ON ht.id=bk.hotel_id 
		 							INNER JOIN $master_city_table ct ON ct.id=bk.city_id
		 							INNER JOIN $master_state_table st ON st.id=bk.state_id
		 							INNER JOIN $master_country_table cy ON cy.id=bk.country_id
		 							INNER JOIN $master_tax_table tx ON tx.id=bk.tax_id
		 							WHERE bk.status!='E' and bk.id='$id'";
			$record = $con->query($select_query);
			$data = $record->fetch_array();

			if($data['payment_method'] == "OPG") 
			{
				$payment_method = 'Online';
			}
			else if($data['payment_method'] == "OFF")
			{
				$payment_method = 'Offline';
			}
			//Payment Status
			if($data['payment_status'] == "PN") 
			{
				$payment_status = 'PENDING';
			}
			else if($data['payment_status'] == "PD")
			{
				$payment_status = 'PAID';
			}
			else if($data['payment_status'] == "FA")
			{
				$payment_status = 'FAILED';
			}

			?>
			<input type='hidden' name='bid' value='<?php echo $id; ?>' >
			<div>
    			<table>
    				<tr>
    					<th>Booking Code:</th><td><?php echo $data['booking_code']; ?></td>
    					<th>Hotel Name:</th><td><?php echo $data['hotel_name']; ?></td>
    				</tr>
    				<tr>
    					<th>First Name:</th><td><?php echo $data['first_name']; ?></td>
    					<th>Coupon Code:</th><td><?php echo $data['coupon_code']; ?></td>
    				</tr>
    				<tr>
    					<th>Last Name:</th><td><?php echo $data['last_name']; ?></td>
    					<th>Discount_type:</th><td><?php echo $data['discount_type']; ?></td>
    				</tr>
    				<tr>
    					<th>Email:</th><td><?php echo $data['email']; ?></td>
    					<th>Discount Value:</th><td>₹ <?php echo $data['discount_value']; ?></td>
    				</tr>
    				<tr>
    					<th>Address:</th><td><?php echo $data['address']; ?></td>
    					<th>Order Total:</th><td>₹ <?php echo $data['order_total']; ?></td>
    				</tr>
    				<tr>
    					<th>Postal Code:</th><td><?php echo $data['postal_code']; ?></td>
    					<th>Tax:</th><td><?php echo $data['tax_per']; ?></td>
    				</tr>
    				<tr>
    					<th>City:</th><td><?php echo $data['city']; ?></td>
    					<th>Tax Value:</th><td>₹ <?php echo $data['tax_value']; ?></td>
    				</tr>
    				<tr>
    					<th>State:</th><td><?php echo $data['state']; ?></td>
    					<th>Final Total:</th><td>₹ <?php echo $data['final_total']; ?></td>
    				</tr>
    				<tr>
    					<th>Country:</th><td><?php echo $data['country_name']; ?></td>
    					<th>Payment Method:</th><td><?php echo $payment_method; ?></td>
    				</tr>
    				<tr>
    					<th>Phone Number:</th><td><?php echo $data['phone_number']; ?></td>
    					<th>Payment Status:</th><td><?php echo $payment_status; ?></td>
    				</tr>
    				<tr>
    					<th>Mobile Number:</th><td><?php echo $data['mobile_number']; ?></td>
    					<th>Special Request:</th><td><?php echo $data['special_request']; ?></td>
    				</tr>
    			</table>
			</div><br><br>
			
			
			<div id="print_div" style="display:none;">
			    <style>
			    .print_sec
			    {
			    }
			    .print_sec table
			    {
			        margin:0 auto; 
			        display:table;
			        border-collapse: collapse;
			    }
		       .print_sec th, .print_sec td
		       {
		           border:1px solid #333;
		           border-collapse: collapse;
		           text-align:left;
		           padding:5px;
		       }
		       .print_sec .pleft
		       {
		           float:left;
		           width:70%;
		       }
		       .print_sec .pright
		       {
		           float:left;
		           width:30%;
		       }
			    </style>
			    
    			<div class="print_sec">
    			    <div class="pleft">
			            <img src="https://ecrcheckin.in/images/logo.png" style="width:150px;">
			            <p><b>www.ecrcheckin.in</b></p>
		            </div>
    			    <div class="pright">
    			        <p>31-A,Gandhi Main road,<br>
                        Alwarthirunagar,<br>
                        Chennai - Tamilnadu 600087<br>
                        <b>Mobile: </b> +91 95001 23603<br>
                        <b>Email: </b> support@ecrcheckin.com</p>
    			    </div>
    			    <hr>
			        <h4 style="text-align:center;">Invoice</h4>
        			<table>
        				<tr>
        					<th>Booking Code:</th><td><?php echo $data['booking_code']; ?></td>
        					<th>Hotel Name:</th><td><?php echo $data['hotel_name']; ?></td>
        				</tr>
        				<tr>
        					<th>First Name:</th><td><?php echo $data['first_name']; ?></td>
        					<th>Coupon Code:</th><td><?php echo $data['coupon_code']; ?></td>
        				</tr>
        				<tr>
        					<th>Last Name:</th><td><?php echo $data['last_name']; ?></td>
        					<th>Discount_type:</th><td><?php echo $data['discount_type']; ?></td>
        				</tr>
        				<tr>
        					<th>Email:</th><td><?php echo $data['email']; ?></td>
        					<th>Discount Value:</th><td>₹ <?php echo $data['discount_value']; ?></td>
        				</tr>
        				<tr>
        					<th>Address:</th><td><?php echo $data['address']; ?></td>
        					<th>Order Total:</th><td>₹ <?php echo $data['order_total']; ?></td>
        				</tr>
        				<tr>
        					<th>Postal Code:</th><td><?php echo $data['postal_code']; ?></td>
        					<th>Tax:</th><td><?php echo $data['tax_per']; ?></td>
        				</tr>
        				<tr>
        					<th>City:</th><td><?php echo $data['city']; ?></td>
        					<th>Tax Value:</th><td>₹ <?php echo $data['tax_value']; ?></td>
        				</tr>
        				<tr>
        					<th>State:</th><td><?php echo $data['state']; ?></td>
        					<th>Final Total:</th><td>₹ <?php echo $data['final_total']; ?></td>
        				</tr>
        				<tr>
        					<th>Country:</th><td><?php echo $data['country_name']; ?></td>
        					<th>Payment Method:</th><td><?php echo $payment_method; ?></td>
        				</tr>
        				<tr>
        					<th>Phone Number:</th><td><?php echo $data['phone_number']; ?></td>
        					<th>Payment Status:</th><td><?php echo $payment_status; ?></td>
        				</tr>
        				<tr>
        					<th>Mobile Number:</th><td><?php echo $data['mobile_number']; ?></td>
        					<th>Special Request:</th><td><?php echo $data['special_request']; ?></td>
        				</tr>
        			</table><br><br>
        			
        			<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
        		 		<thead>
        		 		  <tr align="center">
        		 		  	<th>Check-In Date</th>
        		 		  	<th>Check-Out Date</th>
        					<th>Rooms</th>
        					<th>Adults</th>
        					<th>Childrens</th>
        					<th>Action</th>
        		 		  </tr>
        		 		</thead>
        		 		<tbody>
        				<?php
        			 	$select_query = "SELECT rb.*,rb.id as broom_id,hr.name as room_name,rb.status FROM $hotel_room_booking_table rb 
        			 					INNER JOIN $hotel_rooms_tables hr ON hr.id=rb.room_id WHERE rb.booking_id='$id' and rb.status!='E'";
        				$record = $con->query($select_query);
        				$output = array();
        				if($record->num_rows > 0)
        				{
        					while($data = $record->fetch_array()) 
        					{
        						$astatus = $dstatus = "";
        						if($data['status'] == 'A')
        							$astatus="selected";
        						elseif($data['status'] == 'D')
        							$dstatus="selected";
        						
        						echo "<tr>
        								<input type='hidden' name='broom_id' value='$data[broom_id]' >
        								<td> $data[checkin_date]</td>
        								<td> $data[checkout_date]</td>
        								<td> $data[room_name]</td>
        								<td> $data[adults]</td>
        								<td> $data[childerns]</td>
        								<td>
        								<select class='form-control' name='br_status' id='br_status'> 
        								<option value='A' $astatus>Booked</option>
        								<option value='D' $dstatus>Cancelled</option>
        								</td>
        							 </tr>";
        					}
        				}
        				?>
         				</tbody>
         	  		</table><br><br>
         	  		
         	  		<?php
         	  		$select_query = "SELECT hba.*,ha.name FROM $hotel_booking_addons_table hba 
		 					INNER JOIN $hotel_addons_table ha ON hba.addon_id=ha.id WHERE hba.booking_id='$id'";
        			$record = $con->query($select_query);
        			if($record->num_rows > 0)
        			{
        				?>
        	 	  		<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
        			 		<thead>
        			 		  <tr align="center">
        			 		  	<th>Addon</th>
        			 		  	<th>Quantity</th>
        			 		  	<th>Cost</th>
        						<th>Gst</th>
        						<th>Total</th>
        			 		  </tr>
        			 		</thead>
        			 		<tbody>
        					<?php
        					while($data = $record->fetch_array()) 
        					{
        						$total = $data['cost'] * $data['tax'];
        						echo "<tr>
        								<td class='text-center'>$data[name]</td>
        								<td class='text-center'>$data[quantity]</td>
        								<td class='text-center'>₹$data[cost]</td>
        								<td class='text-center'>$data[tax]</td>
        								<td class='text-center'>₹$total</td>
        							 </tr>";
        					}
        					?>
        	 				</tbody>
        	 	  		</table>
        	 	  		<?php
         	  		}
         	  		?>
         	  	</div>
			</div>
			
			<script>
                function printDiv() {
                    var divContents = $("#print_div").html();
                    var printWindow = window.open('', '', 'height=400,width=800');
                    printWindow.document.write('<html><head><title></title>');
                    printWindow.document.write('</head><body >');
                    printWindow.document.write(divContents);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    printWindow.print();
                }
            </script>
			<?php
			extract($data);
			?>
			<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
		 		<thead>
		 		  <tr align="center">
		 		  	<th>Check-In Date</th>
		 		  	<th>Check-Out Date</th>
					<th>Rooms</th>
					<th>Adults</th>
					<th>Childrens</th>
					<th>Action</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
				<?php
			 	$select_query = "SELECT rb.*,rb.id as broom_id,hr.name as room_name,rb.status FROM $hotel_room_booking_table rb 
			 					INNER JOIN $hotel_rooms_tables hr ON hr.id=rb.room_id WHERE rb.booking_id='$id' and rb.status!='E'";
				$record = $con->query($select_query);
				$output = array();
				if($record->num_rows > 0)
				{
					while($data = $record->fetch_array()) 
					{
						$astatus = $dstatus = "";
						if($data['status'] == 'A')
							$astatus="selected";
						elseif($data['status'] == 'D')
							$dstatus="selected";
						
						echo "<tr>
								<input type='hidden' name='broom_id' value='$data[broom_id]' >
								<td> $data[checkin_date]</td>
								<td> $data[checkout_date]</td>
								<td> $data[room_name]</td>
								<td> $data[adults]</td>
								<td> $data[childerns]</td>
								<td>
								<select class='form-control' name='br_status' id='br_status'> 
								<option value='A' $astatus>Booked</option>
								<option value='D' $dstatus>Cancelled</option>
								</td>
							 </tr>";
					}
				}
				?>
 				</tbody>
 	  		</table>

 	  		<?php
		 	$select_query = "SELECT hba.*,ha.name FROM $hotel_booking_addons_table hba 
		 					INNER JOIN $hotel_addons_table ha ON hba.addon_id=ha.id WHERE hba.booking_id='$id'";
			$record = $con->query($select_query);
			if($record->num_rows > 0)
			{
				?>
	 	  		<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
			 		<thead>
			 		  <tr align="center">
			 		  	<th>Addon</th>
			 		  	<th>Quantity</th>
			 		  	<th>Cost</th>
						<th>Gst</th>
						<th>Total</th>
			 		  </tr>
			 		</thead>
			 		<tbody>
					<?php
					while($data = $record->fetch_array()) 
					{
						$total = $data['cost'] * $data['tax'];
						echo "<tr>
								<td class='text-center'>$data[name]</td>
								<td class='text-center'>$data[quantity]</td>
								<td class='text-center'>₹$data[cost]</td>
								<td class='text-center'>$data[tax]</td>
								<td class='text-center'>₹$total</td>
							 </tr>";
					}
					?>
	 				</tbody>
	 	  		</table>
	 	  		<?php
 	  		}

 	  		echo "<input type='hidden' name='id' value='$id'>";
 	  		?>
 	  		    <div class="form-group row col-md-12">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Method</label>
					<div class="col-sm-12 col-md-9">
					 <div class="input-group">
						<p>
						<label><input type="radio" id="payment_method_op" name="payment_method" value="OPG" <?php if($payment_method=="Online") echo "checked"; ?> required /> Online</label>&nbsp&nbsp&nbsp
						<label><input type="radio" id="payment_method_of" name="payment_method" value="OFF" <?php if($payment_method=="Offline") echo "checked"; ?> required /> Offline</label>
					 </div>
					</div>
				</div>
		    	<div class="form-group row col-md-12">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Status</label>
					<div class="col-sm-12 col-md-9">
					 <div class="input-group">
						<p>
						<label><input type="radio" id="payment_status_pn" name="payment_status" value="PN" <?php if($payment_status=="PENDING") echo "checked"; ?> required /> PENDING</label>&nbsp&nbsp&nbsp
						<label><input type="radio" id="payment_status_pd" name="payment_status" value="PD" <?php if($payment_status=="PAID") echo "checked"; ?> required /> PAID</label>&nbsp&nbsp&nbsp
						<label><input type="radio" id="payment_status_fa" name="payment_status" value="FA" <?php if($payment_status=="FAILED") echo "checked"; ?> required /> FAILED</label>
						</p>
					  </div>
					</div>
				</div>
				<?php
		}

	//Additional Data save
		if($_POST['action'] == 'ac_save_additional')
		{
			extract($_POST);
			$created_at = date('Y-m-d H:i:s');
			$created_by = $_SESSION['admin_uid'];
			$updated_at = date('Y-m-d H:i:s');
			$updated_by = $_SESSION['admin_uid'];
			$status     = "A";
		
			$update_sql = "update $THIS_TABLE set payment_method='$payment_method',payment_status='$payment_status',
			updated_at='$updated_at',updated_by='$updated_by' where id='$bid'";
			$up_res = $con->query($update_sql);

			$upd_sql = "update $hotel_room_booking_table set status='$br_status',updated_at='$updated_at',updated_by='$updated_by' where id='$broom_id'";
			$update_res = $con->query($upd_sql);

			if($up_res === true ){
				$response['status'] = 'success';
				$response['message'] = 'Booking Added successfully!';
			}else {
				$response['status'] = 'error';
				$response['message'] = 'Booking Not Added!';
			}
			echo json_encode($response);
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
					$response['message'] = 'Booking Status changed successfully!';
				} else {
					$response['status'] = 'error';
					$response['message'] = 'Booking Status NOT changed.';
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
					$response['message'] = 'Task Assignment Record deleted Successfuly...';
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
			<!--Filter-->
			<form id="filter_form" class="row" method="POST" autocomplete="off">
				<input type="hidden" id="grid_view" name="grid_view" value="1" />
				<input type="hidden" id="action" name="action" value="1" />
				<input type="hidden" id="filter" name="filter" value="1" />
				<div class="form-group row md-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">From Date</label>
					<div class="col-sm-12 col-md-9">
					 <div class="input-group">
						<div class="input-group-prepend">
						  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
						</div>
						<input type="date" id="from_date" name="from_date" class="form-control" >
					  </div>
					</div>
				</div>
				<div class="form-group row md-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">To Date</label>
					<div class="col-sm-12 col-md-9">
					 <div class="input-group">
						<div class="input-group-prepend">
						  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
						</div>
						<input type="date" id="to_date" name="to_date" class="form-control" >
					  </div>
					</div>
				</div>
				<div class="form-group row md-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Method</label>
					<div class="col-sm-12 col-md-9">
					 <div class="input-group">
						<div class="input-group-prepend">
						  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
						</div>
						<select class="form-control" name="f_payment_method" id="payment_met">
							<option value=''>Payment Method</option>
							<option value='OPG'>Online</option>
							<option value='OFF'>Offline</option>
						</select>
					  </div>
					</div>
				</div>
				<div class="form-group row md-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Status</label>
					<div class="col-sm-12 col-md-9">
					 <div class="input-group">
						<div class="input-group-prepend">
						  <div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
						</div>
						<select class="form-control" name="f_payment_status" id="payment_stat">
							<option value=''>Payment Status</option>
							<option value='PD'>Paid</option>
							<option value='PN'>Pending</option>
							<option value='FA'>Failed</option>
						</select>
					  </div>
					</div>
				</div>
				<div class="form-group row md-4">
					<div class="col-sm-12 col-md-12">
					 <div class="input-group">
						  <input type="submit" id="search" name="search" value="search" class="btn btn-success">&nbsp;&nbsp;
						  <input type="button" id="reset" name="reset" value="Reset" onclick="branchDatatable()" class="btn btn-auth-color">
					  </div>
					</div>
				</div>
			</form>
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
		 			<th>Booking Id</th>
		 			<th>Hotel</th>
					<th>Member</th>
					<th>Discount</th>
					<th>Total</th>
					<th>Payment Method</th>
					<th>Payment status</th>
		 			<th>Created At</th>
		 			<th>Status</th>
		 			<th>Action</th>
		 		  </tr>
		 		</thead>
		 		<tbody>
		 		<?php

		 		//filters
		 		$filter = "";
				if(isset($_POST['filter']))
				{
					if($_POST['from_date'] != "" && $_POST['to_date'] != "")
						$filter .= " and date(bk.created_at)>='$_POST[from_date]' and date(bk.created_at)<='$_POST[to_date]'";
					if($_POST['f_payment_method'] != "")
						$filter .= " and bk.payment_method='$_POST[f_payment_method]'";
					if($_POST['f_payment_status'] != "")
						$filter .= " and bk.payment_status='$_POST[f_payment_status]'";
				}

		 		if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
		 		{
		 			$select_query = "SELECT ht.name as hotel_name,ct.city,st.state,cy.country_name,tx.name as tax_name,bk.* FROM $THIS_TABLE bk 
		 							INNER JOIN $hotels_table ht ON ht.id=bk.hotel_id 
		 							INNER JOIN $master_city_table ct ON ct.id=bk.city_id
		 							INNER JOIN $master_state_table st ON st.id=bk.state_id
		 							INNER JOIN $master_country_table cy ON cy.id=bk.country_id
		 							INNER JOIN $master_tax_table tx ON tx.id=bk.tax_id
		 							WHERE bk.status!='E' $filter";
		 		}
		 		elseif($_SESSION['uType'] == 'HA')
		 		{
		 			$select_query = "SELECT ht.name as hotel_name,ct.city,st.state,cy.country_name,tx.name as tax_name,bk.* FROM $THIS_TABLE bk 
		 							INNER JOIN $hotels_table ht ON ht.id=bk.hotel_id 
		 							INNER JOIN $master_city_table ct ON ct.id=bk.city_id
		 							INNER JOIN $master_state_table st ON st.id=bk.state_id
		 							INNER JOIN $master_country_table cy ON cy.id=bk.country_id
		 							INNER JOIN $master_tax_table tx ON tx.id=bk.tax_id
		 							WHERE ht.hotel_admin_id='$_SESSION[admin_uid]' $filter";
		 		}
	 			$result = $con->query($select_query) or die(mysqli_error($con));
	 			if($result->num_rows > 0){
	 				while($data = $result->fetch_array()) {
	 					if($data['status'] == "A") {
	 						$status = '<span class="badge badge-success badge-shadow">ACTIVE</span>';
	 					} else {
	 						$status = '<span class="badge badge-danger badge-shadow">INACTIVE</span>';
	 					}

	 					if($data['discount_type'] == "FIX") {
	 						$discount_type = '<span class="badge badge-success badge-shadow">FIXED</span>';
	 					}else if($data['discount_type'] == "PER"){
	 						$discount_type = '<span class="badge badge-primary badge-shadow">%</span>';
	 					}else if($data['discount_type'] == "NONE"){
	 						$discount_type = '<span class="badge badge-danger badge-shadow">-</span>';
	 					}

	 					if($data['payment_method'] == "OPG") {
	 						$payment_method = '<span class="badge badge-success badge-shadow">Online</span>';
	 					}else if($data['payment_method'] == "OFF"){
	 						$payment_method = '<span class="badge badge-primary badge-shadow">Offline</span>';
	 					}
	 					if($data['payment_status'] == "PN") {
	 						$payment_status = '<span class="badge badge-warning badge-shadow">PENDING</span>';
	 					}else if($data['payment_status'] == "PD"){
	 						$payment_status = '<span class="badge badge-success badge-shadow">PAID</span>';
	 					}else if($data['payment_status'] == "FA"){
	 						$payment_status = '<span class="badge badge-danger badge-shadow">FAILED</span>';
	 					}
	 					echo "<tr>
	 							<td>$data[booking_code]</td>
	 							<td>$data[hotel_name]</td>
								<td>$data[first_name]</br>
									$data[email]</br>
									$data[mobile_number]</td>
								<td>$data[coupon_code]</br>
									$discount_type</br>
									$data[discount_value]</td>
								<td>₹ $data[final_total]</td>
								<td>$payment_method</td>
								<td>$payment_status</td>
	 							<td>$data[created_at]</td>
	 							<td class='text-center'>$status</td>
	 							<td class='text-center'>
	 									<button type='button' class='btn btn-warning btn-sm view2' data-id='$data[id]'><i class='fas fa-street-view'></i></i></button>
	 									<button type='button' class='btn btn-primary btn-sm status' data-id='$data[id]' data-status='$data[status]'><i class='fas fa-sync-alt'></i></button>
	 									<button type='button' class='btn btn-danger btn-sm del' data-id='$data[id]'><i class='far fa-trash-alt'></i></button>
	 							  </td>
	 						  </tr>";
	 					}
	 				}
	 				else {
	 					echo "<tr colspan='7'><td>No Hotel Booking found.</td></tr>";
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
				<!-- 		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
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
								<button type="button" id="usermodal" class="btn btn-success">Book Rooms</button>
							</div>
							<?php
							}
							elseif($_SESSION['uType'] == 'HA')
							{
							?>	
							<div class="card-header-action">
								<button type="button" id="usermodal" class="btn btn-success">Book Rooms</button>
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

                                <?php
                                if($_SESSION['uType'] == 'SA' or $_SESSION['uType'] == 'AD')
    		 					{
    		 					    ?>
    								<div class="form-group row col-md-6">
    									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Hotel</label>
    									<div class="col-sm-12 col-md-9">
    									 <div class="input-group">
    										<div class="input-group-prepend">
    										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
    										</div>
    										<select class="form-control" name="hotel_id" id="hotel_id" required onchange="load_rooms(this.value);"/>
    										<option value=''>Select Hotel</option>
    										 <?php
    											$select_query = "select * from $hotels_table where status!='E'";
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
								    <div class="form-group row col-md-6"></div>
								    <?php
    		 					}
    		 					?>
								
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rooms</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<select class="form-control" name="room_id" id="room_id" required/>
										<option value=''>Select Rooms</option>
										 <?php
											$select_query = "select hr.* from $hotel_rooms_tables hr inner join $hotels_table ht on hr.hotel_id=ht.id 
											                        where hr.status!='E' and ht.hotel_admin_id='$_SESSION[admin_uid]'";
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
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Checkin Date</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="far fa-calendar-alt"></i></i> </div>
										</div>
										<input type="date" id="checkin_date" name="checkin_date" class="form-control" />
										</div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Checkout Date</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="far fa-calendar-alt"></i> </div>
										</div>
										<input type="date" id="checkout_date" name="checkout_date" class="form-control" />
										</div>
									</div>
								</div>

								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Adults</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-male"></i> </div>
										</div>
										<input type="number" id="adults" name="adults" class="form-control" />
										</div>
									</div>
								</div>

								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Childerns</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-child"></i> </div>
										</div>
										<input type="number" id="childerns" name="childerns" class="form-control" />
										</div>
									</div>
								</div>


								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">First Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-user"></i> </div>
										</div>
										<input type="text" id="first_name" name="first_name" class="form-control" />
										</div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Last Name</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-user"></i> </div>
										</div>
										<input type="text" id="last_name" name="last_name" class="form-control" />
									</div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-envelope-square"></i> </div>
										</div>
										<input type="email" id="email" name="email" class="form-control" />
										</div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-address-card"></i> </div>
										</div>
										<textarea type="text" id="address" name="address" class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Postal Code</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="text" id="postal_code" name="postal_code" class="form-control" />
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">City</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<select class="form-control" name="city_id" id="city_id" required/>
										<option value=''>Select City</option>
										 <?php
											$select_query = "select * from $master_city_table where status!='E'";
	                                    	$result = $con->query($select_query) or die(mysqli_error($con));
	                                    	while($data = $result->fetch_array())
	                                    	{
	                                    		echo "<option value='$data[id]'>$data[city]</option>";
	                                    	}
	                                     ?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">State</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<select class="form-control" name="state_id" id="state_id" required/>
										<option value=''>Select state</option>
										 <?php
											$select_query = "select * from $master_state_table where status!='E'";
	                                    	$result = $con->query($select_query) or die(mysqli_error($con));
	                                    	while($data = $result->fetch_array())
	                                    	{
	                                    		echo "<option value='$data[id]'>$data[state]</option>";
	                                    	}
	                                     ?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Country</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
										  <div class="input-group-text"> <i class="fas fa-map-pin"></i> </div>
										</div>
										<select class="form-control" name="country_id" id="country_id" required/>
										<option value=''>Select Country</option>
										 <?php
											$select_query = "select * from $master_country_table where status!='E'";
	                                    	$result = $con->query($select_query) or die(mysqli_error($con));
	                                    	while($data = $result->fetch_array())
	                                    	{
	                                    		echo "<option value='$data[id]'>$data[country_name]</option>";
	                                    	}
	                                     ?>
										</select>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Phone Number</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-phone-square"></i> </div>
										</div>
										<input type="text" id="phone_number" name="phone_number" class="form-control" />
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mobile Number</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-phone-square"></i> </div>
										</div>
										<input type="text" id="mobile_number" name="mobile_number" class="form-control" />
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Coupon Code</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-tags"></i> </div>
										</div>
										<input type="text" id="coupon_code" name="coupon_code" class="form-control" />
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Discount Type</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<p>
										<label><input type="radio" id="discount_type_f" name="discount_type" value="FIX" required /> FIXED</label>&nbsp&nbsp&nbsp
										<label><input type="radio" id="discount_type_p" name="discount_type" value="PER" required /> Percentage %</label>
										<label><input type="radio" id="discount_type_n" name="discount_type" value="NONE" required />-</label>
									    </p>
									 </div>
									</div>
								</div>

								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Discount Value</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-tags"></i> </div>
										</div>
										<input type="text" id="discount_value" name="discount_value" class="form-control" />
									 </div>
									</div>
								</div>


								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Order Total</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="text" id="order_total" name="order_total" class="form-control" />
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tax Id</label>
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
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tax Per</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-percentage"></i> </div>
										</div>
										<input type="text" id="tax_per" name="tax_per" class="form-control" />
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tax Value</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-tags"></i> </div>
										</div>
										<input type="text" id="tax_value" name="tax_value" class="form-control" />
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Final Total</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </div>
										</div>
										<input type="text" id="final_total" name="final_total" class="form-control" />
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Method</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<p>
										<label><input type="radio" id="payment_method_op" name="payment_method" value="OPG" required /> Online</label>&nbsp&nbsp&nbsp
										<label><input type="radio" id="payment_method_of" name="payment_method" value="OFF" required /> Offline</label>
									 </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Status</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<p>
										<label><input type="radio" id="payment_status_pn2" name="payment_status" value="PN" required /> PENDING</label>&nbsp&nbsp&nbsp
										<label><input type="radio" id="payment_status_pd2" name="payment_status" value="PD" required /> PAID</label>
									<!-- 	<label><input type="radio" id="payment_status_fa" name="payment_status" value="FA" required /> FAILED</label>&nbsp&nbsp&nbsp -->
										</p>
									  </div>
									</div>
								</div>
								<div class="form-group row col-md-6">
									<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Special Request</label>
									<div class="col-sm-12 col-md-9">
									 <div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"> <i class="fas fa-sticky-note"></i> </div>
										</div>
										<textarea id="special_request" name="special_request" class="form-control" /></textarea>
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

				
				<!-- Modal1 Popup Start -->
				<div class="modal fade" id="formModal1" tabindex="-1" role="dialog"
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
					    	<div id="data_div"></div>
					    	
							<div class="modal-body">
					    	<div class="form-group row col-md-12">
								<div class="col-sm-12 col-md-9">
								 <div class="input-group">

								</div>
							</div>
							<div class="modal-footer bg-whitesmoke br">
								<input type="hidden" id="id" name="id" value="0" />
								<input type="hidden" id="page" name="page" value="master" />
								<input type="hidden" id="action" name="action" value="ac_save_additional" />
								<input type="button" name="print" id="print" class="btn btn-success" value="Print" onclick="printDiv();" />
								<input type="submit" name="save" id="save" class="btn btn-auth-color" value="Update" />
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					  </form>
					</div>
				  </div>
				</div>
				<!-- Modal1 Popup End -->

				<!-- Modal2 Popup Start -->
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
					    <div class="modal-body row">
					    	<div id="data_div2"></div>
							<div class="modal-footer bg-whitesmoke br">
								<input type="hidden" id="id" name="id" value="0" />
								<input type="hidden" id="page" name="page" value="master" />
								<input type="hidden" id="action" name="action" value="ac_save_additional" />
								<input type="submit" name="save" id="save" class="btn btn-auth-color" value="Save" />
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					  </form>
					</div>
				  </div>
				</div>
				<!-- Modal2 Popup End -->



	<?php
		include('footer.php');
	?>
	<script>
	    function load_rooms(hotel_id){
			$.ajax({
			 url: "ajax_hotel_rooms.php",
			 method: "POST",
			 data: 'action=1&hotel_id='+hotel_id,
			 success:function(response)
			 {
				 $('#room_id').html(response);
			 },
			 error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
		 });
		}
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
				$('.modal-title').html('<i class="fas fa-list-alt"></i> Book Rooms');
				$('#save').val('Save');
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
				$('#emp_id').val(data.emp_id);
				$('#task_id').val(data.task_id);
				$('#task_status_y').attr('checked',false);
				$('#task_status_w').attr('checked',false);
				$('#task_status_c').attr('checked',false);
				$('#task_status_p').attr('checked',false);
				$('#task_status_d').attr('checked',false);
				if(data.task_status == "YTS")
					$('#task_status_y').attr('checked',true);
				else if(data.task_status == "WIP")
					$('#task_status_w').attr('checked',true);
				else if(data.task_status == "COM")
					$('#task_status_c').attr('checked',true);
				else if(data.task_status == "PAS")
					$('#task_status_p').attr('checked',true);
				else if(data.task_status == "DRP")
					$('#task_status_d').attr('checked',true);
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
	   			   $('#member_name').val(data.member_name);
				   $('#hotel_name').val(data.hotel_name);
				   $('#checkin_date').val(data.checkin_date);
				   $('#checkout_date').val(data.checkout_date);
				   $('#first_name').val(data.first_name);
				   $('#last_name').val(data.last_name);
				   $('#last_name').val(data.last_name);
				   $('#email').val(data.email);
				   $('#address').val(data.address);
				   $('#postal_code').val(data.postal_code);
				   $('#city_name').val(data.city_name);
				   $('#state_name').val(data.state_name);
				   $('#country_name').val(data.country_name);
				   $('#phone_number').val(data.phone_number);
				   $('#mobile_number').val(data.mobile_number);
				   $('#coupon_code').val(data.coupon_code);
				   $('#discount_type_f').attr('checked',false);
				   $('#discount_type_p').attr('checked',false);
				   $('#discount_type_n').attr('checked',false);
				   if(data.discount_type == "FIX")
						$('#discount_type_f').attr('checked',true);
				   else if(data.discount_type == "PER")
						$('#discount_type_p').attr('checked',true);
				   else if(data.discount_type == "NONE")
						$('#discount_type_n').attr('checked',true);
				   $('#order_total').val(data.order_total);
				   $('#tax_name').val(data.tax_name);
				   $('#tax_per').val(data.tax_per);
				   $('#tax_value').val(data.tax_value);
				   $('#final_total').val(data.final_total);
				   $('#payment_method_op').attr('checked',false);
				   $('#payment_method_of').attr('checked',false);
				   if(data.payment_method == "OPG")
						$('#payment_method_op').attr('checked',true);
				   else if(data.payment_method == "OFF")
						$('#payment_method_of').attr('checked',true);

				   if(data.payment_status == "PN")
						$('#payment_status_pn').attr('checked',true);
				   else if(data.payment_status == "PD")
						$('#payment_status_pd').attr('checked',true);
					else if(data.payment_status == "FA")
						$('#payment_status_fa').attr('checked',true);
				   $('#special_request').val(data.special_request);
	   			   $('#action').val('ac_view');
				   $('#save').css({"display": "none"});
				},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			});
		});

		//View Additional data
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
				   $('#formModal1').modal('show');
				   $('.modal-title').html('<i class="fas fa-street-view"></i> View Data');
				   $('#data_div').html(data);
				   $('#payment_method_op').attr('checked',false);
				   $('#payment_method_of').attr('checked',false);
				   if(data.payment_method == "OPG")
						$('#payment_method_op').attr('checked',true);
				   else if(data.payment_method == "OFF")
						$('#payment_method_of').attr('checked',true);

				   if(data.payment_status == "PN")
						$('#payment_status_pn').attr('checked',true);
				   else if(data.payment_status == "PD")
						$('#payment_status_pd').attr('checked',true);
				   else if(data.payment_status == "FA")
						$('#payment_status_fa').attr('checked',true);
	   			   $('#action').val('ac_save_additional');
				   $('#save').css({"visibility": "hidden"});
				},error:function(xhr, ajaxOptions, thrownError){alert(xhr.responseText); ShowMessage("??? ?? ","fail");}
			});
		});

		//View Additional data2
		$(document).on('click','.view2', function(event){
			event.preventDefault();
			var id = $(this).data('id');
			var page   = 'master';
			var action = 'ac_additional_data2';
			$.ajax({
				url:"<?php echo $page_url; ?>",
				method:"POST",
				data:{id:id,action:action,page:page},
				dataType:"html",
				success:function(data)
				{
				   $('#formModal1').modal('show');
				   $('.modal-title').html('<i class="fas fa-street-view"></i> View Data');
				   $('#data_div').html(data);
	   			   $('#action').val('ac_save_additional');
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
