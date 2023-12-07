<?php 


	session_start();
	include('../../../ayar.php');
	$admin_id = $_SESSION['kid'];

         
	if(re("action")=="prm_islem"){
		$response=[];
		$durum=re("durum");
		$prm_id=re("id");
		$guncelle=mysql_query("update prm_notlari set durum='".$durum."' where id='".$prm_id."'");  
		if($guncelle){
			$response=["message"=>"İşlem başarılı","status"=>200];
		}else{
			$response=["message"=>"Hata","status"=>500];
		}
		echo json_encode($response);
	}

?>