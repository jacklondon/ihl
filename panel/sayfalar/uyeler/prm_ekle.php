<?php 

	session_start();
	$admin_id = $_SESSION['kid'];
	$gelen_id = re('id');
	$bugun = date('Y-m-d H:i:s');
	$iki_ay_once = date( 'Y-m-d H:i:s', strtotime('-60 days'));
	$sayi=0;
	$admin_limit_cek = mysql_query("SELECT * FROM prm_notlari WHERE ekleyen = '".$admin_id."' ");
	//$admin_limit_say = mysql_num_rows($admin_limit_cek);
	while($admin_limit_oku=mysql_fetch_array($admin_limit_cek)){
		$tarih=$admin_limit_oku["tarih"];
		$tarih=date("Y-m-d",strtotime($tarih));
		if($tarih==date("Y-m-d")){
			$sayi++;
		}
	}

	$admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$admin_id."'");
	$admin_oku = mysql_fetch_assoc($admin_cek);
	$admin_limit = $admin_oku['prm_limiti'];
	if($sayi >= $admin_limit){
		echo "<script>alert('Günlük limtiniz doldu')</script>";
		echo "<script>window.location.href = '?modul=uyeler&sayfa=uyeler';</script>";
	}else{
		$not_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id = '".$gelen_id."'");
		$not_sayi = mysql_num_rows($not_cek);
		$not_yaz = mysql_fetch_assoc($not_cek);
		$tarih = $not_yaz['tarih'];
		if($not_sayi == 0 ){
			mysql_query("INSERT INTO `prm_notlari` (`id`, `uye_id`, `not`, `tarih`, `gizlilik`, `ekleyen`) VALUES 
			(NULL, '".$gelen_id."', 'Kendisiyle görüştüm Gold üye olma olasılığı yüksektir', '".$bugun."', '', '".$admin_id."')");
			mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
				  (NULL, '".$admin_id."', '4','', '".$bugun."','','','".$gelen_id."');"); 
			echo "<script>alert('PRM notu eklendi')</script>";
			echo "<script>window.location.href = '?modul=uyeler&sayfa=uyeler';</script>";
		}
		if($not_sayi != 0 ){
			$sure_kontrol = mysql_query("SELECT * FROM prm_notlari WHERE uye_id = '".$gelen_id."' AND tarih BETWEEN '".$iki_ay_once."' AND '".$bugun."'");
			$sure_kontrol_sayi = mysql_num_rows($sure_kontrol);
			if($sure_kontrol_sayi > 0){
				echo "<script>alert('PRM notu daha önce eklenmiş')</script>";
				echo "<script>window.location.href = '?modul=uyeler&sayfa=uyeler';</script>";
				
			}else{
				mysql_query("update `prm_notlari` set tarih='".$bugun."',ekleyen='".$admin_id."' where uye_id='".$gelen_id."'");  
				mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					  (NULL, '".$admin_id."', '4','', '".$bugun."','','','".$gelen_id."');"); 
				echo "<script>alert('PRM notu güncellendi')</script>";
				echo "<script>window.location.href = '?modul=uyeler&sayfa=uyeler';</script>";
			}
		}
	}
?>

