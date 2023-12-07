<?php 
	$admin_id = $_SESSION['kid'];
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
	$yetkiler=$admin_yetki_oku["yetki"];
	$yetki_parcala=explode("|",$yetkiler);
	
	$guncellenecek = $_POST['secim'];
	if($_POST['secili_sil']){
		
		/*foreach ($guncellenecek as $guncelle) {
			if($guncelle!='283'){
				mysql_query("DELETE FROM user WHERE id = '".$guncelle."'");
			}
  
		}*/

		
		if (in_array(7, $yetki_parcala)) { 
			foreach ($guncellenecek as $guncelle) {
				if($guncelle!='283'){
					mysql_query("DELETE FROM user WHERE id = '".$guncelle."'");
				}
			}
			header('Location: ?modul=uyeler&sayfa=uyeler');
		}else{

			echo "<script>alert('Üye silme yetkiniz yok.')</script>";
			echo '<script>window.location.href = "?modul=uyeler&sayfa=uyeler";</script>';
		}
	}
	if($_POST['grup_degistir']){   
		$secili_grup_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$_POST['grup_degistir']."'");
		$secili_grup_oku = mysql_fetch_assoc($secili_grup_cek);
		$secili_limit = $secili_grup_oku['teklif_ust_limit'];
		$secili_standart = $secili_grup_oku['standart_ust_limit'];
		$secili_luks = $secili_grup_oku['luks_ust_limit'];
		foreach($guncellenecek as $guncelle){
			mysql_query("UPDATE `user` SET `paket` = '".$_POST['grup_degistir']."' WHERE `user`.`id` = '".$guncelle."'");
			$limit_cek = mysql_query("select * from teklif_limiti where uye_id='".$guncelle."'");
			$limit_sayi = mysql_num_rows($limit_cek);
			if($limit_sayi > 0){
				mysql_query("UPDATE `teklif_limiti` SET `teklif_limiti` = '".$secili_limit."', standart_limit = '".$secili_standart."',
				luks_limit = '".$secili_luks."' WHERE uye_id='".$guncelle."'");
			}else{
				mysql_query("INSERT INTO `teklif_limiti` (`id`, `uye_id`, `teklif_limiti`, `standart_limit`, `luks_limit`) 
					VALUES 
				(NULL, '".$guncelle."', '".$secili_limit."', '".$secili_standart."', '".$secili_luks."');");
			}
		}
		header("Location:?modul=uyeler&sayfa=uyeler");
	}
	   
?>