<?php
include_once("db-config.php");
$con = new mysqli($host, $user,$pass,$db_name);

echo "<option value=''>Select Rooms</option>";
$select_query = "select * from $hotel_rooms_tables where status!='E' and hotel_id='$_POST[hotel_id]'";
$result = $con->query($select_query) or die(mysqli_error($con));
while($data = $result->fetch_array())
{
    echo "<option value='$data[id]'>$data[name]</option>";
}
?>