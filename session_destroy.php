<?php 
session_start();
$token = $_SESSION['u_token'];
session_destroy();
header('location:index.php');
?>