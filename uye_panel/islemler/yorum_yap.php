<?php 
	session_start();
	include '../../ayar.php';

	$token = $_SESSION['u_token'];
	if($token){
		$uye_token = $token;
	}

	if(re('yorumu') == "Gonder"){
		$kullanici_bul = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."' LIMIT 1");
		$kullanici_oku = mysql_fetch_assoc($kullanici_bul);
		$kullanici_id = $kullanici_oku['id'];
		$yorum = re('yorum');
		$ilan_id = re('ilanin_id_degeri');
		$gonderme_zamani = date('Y-m-d H:i:s');
		mysql_query("INSERT INTO `yorumlar` (`id`, `ilan_id`, `uye_id`, `yorum`, `yorum_zamani`, `cevap`, `cevaplayan`, `cevap_zamani`, `durum`) VALUES 
			(NULL, '".$ilan_id."', '".$kullanici_id."', '".$yorum."', '".$gonderme_zamani."','','','',0);");
		echo '<script>alert("Tebrikler yorumunuz yapıldı, yönetici onayından sonra yayına alıncaktır.")</script>';
	}
	

?>