<?php
session_start();
session_destroy();
echo "<script>window.location.href='google_login/logout.php';</script>";
echo "<script>window.location.href='index.php';</script>";
?>