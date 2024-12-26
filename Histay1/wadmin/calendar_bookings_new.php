 <?php
include_once("db-config.php");
//DB connect
$con = new mysqli($host, $user,$pass,$db_name);
?>
<style>
.tt_bcal
{
	width:100%;
}
.tt_bcal .tt_intb
{
	width:100%;
}
.tt_bcal .tt_intb th
{
	background: #ddd;
	font-weight: bold;
}
</style>

<?php
$select_query = "SELECT rb.*,bk.first_name from $hotel_room_booking_table rb 
				inner join $hotel_booking_table bk on rb.booking_id=bk.id 
				where rb.status='A'";
$record = $con->query($select_query);
while($data = $record->fetch_array())
{
	$ROOM_NO_ID = $data['room_no_id'];
	$CHICK_IN[$ROOM_NO_ID][] = $data['checkin_date'];
	$CHICK_OUT[$ROOM_NO_ID][] = $data['checkout_date'];
}

$monday = date('Y-m-d', strtotime('monday this week'));
$tuesday = date('Y-m-d', strtotime('tuesday this week'));
$wednesday = date('Y-m-d', strtotime('wednesday this week'));
$thursday = date('Y-m-d', strtotime('thursday this week'));
$friday = date('Y-m-d', strtotime('friday this week'));
$saturday = date('Y-m-d', strtotime('saturday this week'));
$sunday = date('Y-m-d', strtotime('sunday this week'));
$THIS_WEEK = array($monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday);
?>

<table class="tt_bcal">
	<tr>
		<td>
			Show Rooms
			<select>
				<option value="">ALL</option>
				<option value="">1 Bed</option>
			</select>
		</td>
		<td>
			<h3>15-03-2021 - 22-03-2021</h3>
		</td>
		<td>
			<a href=""><</a>
			<a href="">TODAY</a>
			<a href="">></a>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<table class="tt_intb">
				<tr>
					<td>Number</td>
					<td>Type</td>
					<td>Status</td>
					<?php
					foreach($THIS_WEEK as $val)
						echo "<td>$val</td>";
					?>
				</tr>
				<?php
			      $select_query = "SELECT * from $hotel_rooms_tables where hotel_id='$_GET[hotel_id]' and status='A'";
			      $record = $con->query($select_query);
			      while($data = $record->fetch_array())
			      {
			      ?>
			  		<tr>
						<th colspan="3"><?php echo $data['name']; ?></th>
						<td colspan="7"></td>
					</tr>
					<?php
			        $select_rn = "SELECT * from $hotel_room_number_table where room_id='$data[id]' and status='A'";
			        $record_rn = $con->query($select_rn);
			        if($record_rn->num_rows > 0)
			        {
			          while($data_rn = $record_rn->fetch_array())
			          {
			          	//$room_no = 10000 + $data_rn['id'];

			          	if($data_rn['room_status'] == "R")
							$room_status = 'Ready';
						else if($data_rn['room_status'] == "C")
							$room_status = 'Clean Up';
						else if($data_rn['room_status'] == "D")
							$room_status = 'Dirty';
			          	?>
			          	<tr>
							<td><?php echo $data_rn['room_no'] ;?></td>
							<td><?php echo $data_rn['beds']; ?></td>
							<td><?php echo $room_status ;?></td>
							<?php
							foreach($THIS_WEEK as $key => $val)
							{
								echo "<td>$val</td>";
							}
							?>
						</tr>
						<?php
			          }
			        }
			      }
		      	?>
			</table>
		</td>
	</tr>
</table>