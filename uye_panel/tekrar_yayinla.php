<?php 
	include '../ayar.php';
	$gelen_id = re('id');
	$today = date('Y-m-d');
	$yayinda_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum <> 0 AND id = '".$gelen_id."'");
	$yayin_say = mysql_num_rows($yayinda_cek);
	if($yayin_say != 0){
		mysql_query("UPDATE dogrudan_satisli_ilanlar SET durum = 0,bitis_tarihi='".date("Y-m-d",strtotime("+30 Days"))."' WHERE id = '".$gelen_id."'");
		echo '<script>alert("Tebrikler ilanınız admin onayından sonra tekrar yayınlanacaktır");</script>';
		echo "<script>window.location.href = 'dogrudan_satisli_ilanlarim.php';</script>";
	}else{
		echo '<script>alert("İlanınız şuanda tekrar yayınlanmaya uygun değil");</script>';
		echo "<script>window.location.href = 'dogrudan_satisli_ilanlarim.php';</script>";
	}
?>