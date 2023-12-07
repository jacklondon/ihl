<?php 
	session_start();
	$token = $_SESSION['u_token'];
	include '../../ayar.php';
	if(re('id')!=""){
		$uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '".$token."'");
		$uye_oku = mysql_fetch_assoc($uye_bul);
		$uye_id = $uye_oku['id'];
		$basvuru = re('id');
		$suan = date("Y-m-d H:i:s");
		$durum="true";

	
		if($uye_oku['tc_kimlik']=="" || $uye_oku['mail']==""  || $uye_oku['telefon']=="" || $uye_oku['sehir']==""|| $uye_oku['ad']=="" || $uye_oku['cinsiyet']==""  || $uye_oku['kargo_adresi']=="" ){
			$durum="false";
		}

		if($durum=="false"){
			echo"<script>window.location.href = '../profili_duzenle_basvuru.php';</script>";                
		}else{
			$basvuru_cek = mysql_query("SELECT * FROM gold_uyelik_talepleri WHERE uye_id = '".$uye_id."' ");
			$basvuru_sayi = mysql_num_rows($basvuru_cek);
			if($basvuru_sayi == 0){
				$basvur = mysql_query("INSERT INTO `gold_uyelik_talepleri` (`id`, `uye_adi`, `tur`, `basvuru_tarihi`, `telefon`, `durum`, `uye_id`) VALUES 
				(NULL, '".$uye_oku['ad']."', '".$basvuru."', '".$suan."', '".$uye_oku['telefon']."', '0', '".$uye_id."');");
			}else{
				$basvuru_oku = mysql_fetch_assoc($basvuru_cek);
				$basvur = mysql_query("update gold_uyelik_talepleri set tur='".$basvuru."', basvuru_tarihi = '".$suan."', durum = 0 where id = '".$basvuru_oku['id']."'");
			}
			if($basvur){
				echo '<script>alert("Başvurunuz alındı.")</script>';
				echo "<script>window.location.href = '../index.php'</script>";
				//echo "<script>location.reload();</script>";
			}else{
				echo '<script>alert("Hata")</script>';
				echo "<script>window.location.href = '../index.php'</script>";
				//echo "<script>location.reload();</script>";
			}		
		}
	}
?>