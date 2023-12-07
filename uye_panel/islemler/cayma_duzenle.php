<?php 
	session_start();
	include '../../ayar.php';

	$token = $_SESSION['u_token'];
	if($token){
		$uye_token = $token;
	}
	
	if(re('cayma_bedelini') == "Kaydet"){
		$gelen_id = re('id');
		$sql = "UPDATE cayma_bedelleri SET iban = '".re('iban')."' WHERE id = '".$gelen_id."'";
		mysql_query($sql);
		if($sql){
			echo '<script>alert("Başarıyla Güncellendi")</script>';
			header("Refresh:0");
		}
      
	}
  
?>