<?php
	session_start();
	session_destroy();
	unset($_SESSION['admin_uid']);
	unset($_SESSION['eng_uid']);
	echo "<script>window.location.href='login.php';</script>";
?>