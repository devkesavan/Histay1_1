<?php
session_start();
require("wadmin/db-config.php");

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];

$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="aqtE7emL9H5M4mB73BaEORFPvEsGDXRf";
//$salt="rTIO38xoPJ";
If (isset($_POST["additionalCharges"])) {
       $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        
                  }
	else {	  

        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

         }
		 $hash = hash("sha512", $retHashSeq);
  
		if ($hash != $posted_hash)
		{
			echo "Invalid Transaction. Please try again";
		}
		else
		{  
		    $booking_id = $_GET['booking_id'];
		    //$booking_id = $_SESSION['payumoney_txnid'];
		    
			$qry = "update $hotel_booking_table set payment_status='FA' where id='$booking_id'";
			$con->query($qry) or die(mysqli_error($con));
			
			echo "<script>window.location.href='booking_success.php?booking_code=0';</script>";
		} 
?>
		