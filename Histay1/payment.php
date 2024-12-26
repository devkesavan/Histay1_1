
<?php
session_start();
if(isset($_SESSION['payumoney_txnid']))
{
?>
<script>
function submitPayment()
{
	var paymentForm = document.forms.paymentForm;
	paymentForm.submit();
}
</script>

<body onload="submitPayment()">
	Please wait...
	<form method="post" action="payumoney.php" name="paymentForm" style="display:none;">
		<input type="text" name="key" placeholder="key" value="0IBnwX">
		<!--<input type="text" name="key" placeholder="key" value="u1YgQSTB">-->
		<input type="text" name="txnid" placeholder="txnid" value="<?php echo $_SESSION['payumoney_txnid']; ?>">
		<input type="text" name="amount" placeholder="amount" value="1<?php //echo $_SESSION['payumoney_order_total']; ?>">
		<input type="text" name="productinfo" placeholder="productinfo" value="Ecrcheckin Booking">
		<input type="text" name="firstname" placeholder="firstname" value="<?php echo $_SESSION['payumoney_customer_name']; ?>">
		<input type="text" name="email" placeholder="email" value="<?php echo $_SESSION['payumoney_customer_email']; ?>">
		<input type="text" name="phone" placeholder="phone" value="<?php echo $_SESSION['payumoney_customer_mobile']; ?>">
		<input type="text" name="surl" placeholder="surl" value="https://ecrcheckin.in/success.php?booking_id=<?php echo $_SESSION['payumoney_txnid']; ?>">
		<input type="text" name="furl" placeholder="furl" value="https://ecrcheckin.in/failure.php?booking_id=<?php echo $_SESSION['payumoney_txnid']; ?>">
		<input type="text" name="hash" placeholder="hash" value="">
		<input type="text" name="service_provider" placeholder="service_provider" value="payu_paisa">
	</form>
</body>

<?php
}
else
{
	echo "<script>window.location.href='index.php'</script>";
}
?>