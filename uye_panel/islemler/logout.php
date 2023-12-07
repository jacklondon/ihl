<?php
session_start();
include '../../ayar.php';
//mysql_query("DELETE FROM online WHERE token = '".$_SESSION['u_token']."'");
  if(!empty($_SESSION['u_token'])){
	  mysql_query("update user set online_durum=0 where user_token='".$_SESSION['u_token']."'");
	  unset($_SESSION["u_token"]);
  } else if(!empty($_SESSION['u_token'])){
	  mysql_query("update user set online_durum=0 where kurumsal_user_token='".$_SESSION['k_token']."'");
	    unset($_SESSION["k_token"]);
  }
 

header("Location:../../index.php");
?>