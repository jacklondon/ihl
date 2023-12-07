<?php 
$gelen_id=re("id");
$silinecek = re("q");
$gidilecek = re("g");

//Sigorta şirketi silme
if($silinecek ==  "sig_sil"){
	if($gelen_id!=1){
		$a=mysql_query("DELETE FROM sigorta_ozellikleri WHERE id='".$gelen_id."'"); 
		$b=mysql_query("DELETE FROM sigortalar WHERE sigorta_id='".$gelen_id."'"); 
		$c=mysql_query("DELETE FROM komisyon_oranlari WHERE sigorta_id='".$gelen_id."'"); 
	}
	echo '<script>javascript: history.go(-1)</script>';
//   header("Location:?modul=ayarlar&sayfa=sigorta_sirketleri");
}
//Komisyon Oranı silme
if($silinecek ==  "kom_sil"){
  mysql_query("DELETE FROM komisyon_oranlari WHERE id='$gelen_id'"); 
//   header("Location:?modul=ayarlar&sayfa=komisyon_oranlari&id=".$gidilecek."");
echo '<script>javascript: history.go(-1)</script>';
}
//Üye grubu silme
if($silinecek ==  "uye_grubu_sil"){
  mysql_query("DELETE FROM uye_grubu WHERE id='".$gelen_id."'"); 
  $uye_paket_bul = mysql_query("SELECT * FROM user WHERE paket = '".$gelen_id."'");
  while($paket_oku = mysql_fetch_array($uye_paket_bul)){
    $uye_paket_id = $paket_oku['id'];
    mysql_query("UPDATE teklif_limiti SET teklif_limiti = 0, standart_limit = 0, luks_limit = 0 
    WHERE uye_id = '".$uye_paket_id."' ");
  }
//   header("Location:?modul=ayarlar&sayfa=uye_gruplari_ve_yetkileri");
echo '<script>javascript: history.go(-1)</script>';
}
//Teklif sınırlaması silme
if($silinecek ==  "sinirlama_sil"){
 /* mysql_query("DELETE FROM uye_grubu WHERE id='".$gelen_id."'"); 
  header("Location:?modul=ayarlar&sayfa=teklif_sinirlamalari");*/
	$uye_grubu_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".re("grup_id")."'");
	$say=mysql_num_rows($uye_grubu_cek);
	if($say>1){
		$sil=mysql_query("delete from uye_grubu_detaylari where id='".$gelen_id."'");
		echo "<script>alert('Başarıyla Silindi');</script>";
		echo '<script>javascript: history.go(-1)</script>';
		// echo '<script>window.location.href = "?modul=ayarlar&sayfa=teklif_sinirlamalari&id='.re("grup_id").'";</script>';
		
	}else{
		echo "<script>alert('Bilgileri silmek için birden fazla kayıt olmalıdır.Tek kayıt silinemez.');</script>";
		echo '<script>javascript: history.go(-1)</script>';
		// echo '<script>window.location.href = "?modul=ayarlar&sayfa=teklif_sinirlamalari&id='.re("grup_id").'";</script>';
	}
	
}
//Sık sorulan sorular silme
if($silinecek ==  "sss_sil"){
  mysql_query("DELETE FROM sss WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ayarlar&sayfa=iletisim_sss");
echo '<script>javascript: history.go(-1)</script>';
}
//Admin silme
if($silinecek ==  "admin_sil"){
//   mysql_query("DELETE FROM kullanicilar WHERE id='".$gelen_id."'"); 
  mysql_query("UPDATE kullanicilar set durum = 0 WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=admin&sayfa=adminler");
echo '<script>javascript: history.go(-1)</script>';
}

//Kutlama mesajı silme
if($silinecek ==  "kutlama_sil"){
  mysql_query("DELETE FROM kutlama_gorseli WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ayarlar&sayfa=kutlama_gorseli");
echo '<script>javascript: history.go(-1)</script>';
}

//Marka silme
if($silinecek ==  "marka_sil"){
  mysql_query("DELETE FROM marka WHERE markaID='".$gelen_id."'"); 
//   header("Location:?modul=ayarlar&sayfa=markalar");
echo '<script>javascript: history.go(-1)</script>';
}

//Model silme
if($silinecek ==  "model_sil"){
  mysql_query("DELETE FROM model WHERE modelID='".$gelen_id."'"); 
//   header("Location:?modul=ayarlar&sayfa=marka_model");
echo '<script>javascript: history.go(-1)</script>';
}
//Araç Detay Müşteri temsilcisi metni silme
if($silinecek ==  "metni_sil"){
  mysql_query("DELETE FROM arac_detay_musteri_temsilcisi_metni WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ayarlar&sayfa=arac_detay_musteri_temsilcisi");
echo '<script>javascript: history.go(-1)</script>';
}
//İlan Resmi
if($silinecek ==  "resim"){
  mysql_query("DELETE FROM ilan_resimler WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ilanlar&sayfa=ilan_ekle&id=".$gidilecek."");
echo '<script>javascript: history.go(-1)</script>';
}
//İlan Ekle Resmi
if($silinecek ==  "resim_ilan_ekle"){
  mysql_query("DELETE FROM ilan_resimler WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ilanlar&sayfa=ilan_resim_ekle&id=".$gidilecek."");
echo '<script>javascript: history.go(-1)</script>';
}

//Duyuru silme
if($silinecek ==  "duyuru_sil"){
  mysql_query("DELETE FROM duyurular WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ayarlar&sayfa=duyurular");
echo '<script>javascript: history.go(-1)</script>';
}

//Slider silme
if($silinecek ==  "slider_sil"){
  mysql_query("DELETE FROM slider WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=slider&sayfa=slider_islemleri");
echo '<script>javascript: history.go(-1)</script>';
}

//Bayi silme
if($silinecek ==  "bayi_sil"){
  mysql_query("DELETE FROM bayiler WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=iletisim&sayfa=iletisim_islemleri");
echo '<script>javascript: history.go(-1)</script>';
}

//Referans silme
if($silinecek ==  "referans_sil"){
  mysql_query("DELETE FROM referans WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=referans&sayfa=referans_islemleri");
echo '<script>javascript: history.go(-1)</script>';
}
//Satılan Araç (muhasebe)
if($silinecek ==  "satilan_sil"){
  mysql_query("DELETE FROM satilan_araclar WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=muhasebe&sayfa=satilan_araclar");
echo '<script>javascript: history.go(-1)</script>';
}
//Satılan Araç (muhasebe)
if($silinecek ==  "reklam_sil"){
  mysql_query("DELETE FROM reklamlar WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ayarlar&sayfa=reklam_ayarlari");
echo '<script>javascript: history.go(-1)</script>';
}
//Sisteme giriş popup sil
if($silinecek ==  "popup_sil"){
  mysql_query("DELETE FROM uye_giris_popup WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ayarlar&sayfa=uyeler_popup");
echo '<script>javascript: history.go(-1)</script>';
}

//Doğrudan Satışlı Resmi
if($silinecek ==  "dogrudan_resim"){
  mysql_query("DELETE FROM dogrudan_satisli_resimler WHERE id='".$gelen_id."'"); 
//   header("Location:?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=".$gidilecek."");
echo '<script>javascript: history.go(-1)</script>';
}

//Hızlı İlan Ekle Kategori
if($silinecek ==  "hizli_kategori_sil"){
  mysql_query("DELETE FROM hizli_ekle_kategori WHERE id='".$gelen_id."'"); 
  mysql_query("DELETE FROM hizli_ekle_detay WHERE kat_id='".$gelen_id."'"); 
//   header("Location:?modul=ilanlar&sayfa=hizli_ekle");
echo '<script>javascript: history.go(-1)</script>';
}

//Uye Not Sil
if($silinecek=="uye_not_sil"){
	$aktif_admin=mysql_query("select * from kullanicilar where id='".$_SESSION["kid"]."'");
	$aktif_admin_oku=mysql_fetch_object($aktif_admin);
	$aktif_admin_id=$aktif_admin_oku->id;
	$yetkiler=$aktif_admin_oku->yetki;
	$parcala=explode("|",$yetkiler);
	if (in_array(9, $parcala)) { 
		$not_cek=mysql_query("select * from uye_notlari where id='".$gelen_id."'");
		$not_oku=mysql_fetch_array($not_cek);
		$not_uye_id=$not_oku["uye_id"];
		$not_tarih=$not_oku["tarih"];
		
		$notlari_cek=mysql_query("select * from uye_notlari where uye_id='".$not_uye_id."' and tarih='".$not_tarih."'");
		while($notlari_oku=mysql_fetch_array($notlari_cek)){

			mysql_query("delete from uye_notlari where id='".$notlari_oku["id"]."'");
		}
		// header("Location:?modul=uyeler&sayfa=uyeler");
		echo '<script>javascript: history.go(-1)</script>';
	} else{
		echo "<script>alert('Not silme yetkiniz yok.');</script>";
		// echo '<script>window.location.href = "?modul=uyeler&sayfa=uyeler";</script>';
		echo '<script>javascript: history.go(-1)</script>';
	}
}

// Uye Evrak Sil
if($silinecek=="uye_evrak_sil"){
	$aktif_admin=mysql_query("select * from kullanicilar where id='".$_SESSION["kid"]."'");
	$aktif_admin_oku=mysql_fetch_object($aktif_admin);
	$aktif_admin_id=$aktif_admin_oku->id;
	$aktif_admin_yetkiler=$aktif_admin_oku->yetki;
	$parcala=explode("|",$aktif_admin_yetkiler);

	if (in_array(9, $parcala)) { 
		$evrak_cek=mysql_query("select * from yuklenen_evraklar where id='".$gelen_id."'");
		$evrak_oku=mysql_fetch_array($evrak_cek);
		$evrak_uye_id=$evrak_oku["user_id"];
		$evrak_tarih=$evrak_oku["gonderme_zamani"];
		
		$evraklari_cek=mysql_query("select * from yuklenen_evraklar where user_id='".$evrak_uye_id."' and gonderme_zamani='".$evrak_tarih."'");
		while($evraklari_oku=mysql_fetch_array($evraklari_cek)){

			mysql_query("delete from yuklenen_evraklar where id='".$evraklari_oku["id"]."'");
		}
		// header("Location:?modul=uyeler&sayfa=uyeler");
		echo '<script>javascript: history.go(-1)</script>';
	} else{
		echo "<script>alert('Not silme yetkiniz yok.');</script>";
		// echo '<script>window.location.href = "?modul=uyeler&sayfa=uyeler";</script>';
		echo '<script>javascript: history.go(-1)</script>';
	}
	
	
}
//İlan notu sil
if($silinecek=="ilan_not_sil"){
	$aktif_admin=mysql_query("select * from kullanicilar where id='".$_SESSION["kid"]."'");
	$aktif_admin_oku=mysql_fetch_object($aktif_admin);
	$aktif_admin_id=$aktif_admin_oku->id;
	$aktif_admin_yetkiler=$aktif_admin_oku->yetki;
	$parcala=explode("|",$aktif_admin_yetkiler);
	if (in_array(9, $parcala)) { 
		$not_cek=mysql_query("select * from ilan_notlari where id='".$gelen_id."'");
		$not_oku=mysql_fetch_array($not_cek);
		$not_ilan_id=$not_oku["ilan_id"];
		$not_tarih=$not_oku["tarih"];
		
		$notlari_cek=mysql_query("select * from ilan_notlari where ilan_id='".$not_ilan_id."' and tarih='".$not_tarih."'");
		while($notlari_oku=mysql_fetch_array($notlari_cek)){

			mysql_query("delete from ilan_notlari where id='".$notlari_oku["id"]."'");
		}
		// header("Location: ?modul=ihaleler&sayfa=tum_ihaleler");
		echo '<script>javascript: history.go(-1)</script>';
	} else{
		echo "<script>alert('Not silme yetkiniz yok.');</script>";
		// echo '<script>window.location.href = "?modul=ihaleler&sayfa=tum_ihaleler";</script>';
		echo '<script>javascript: history.go(-1)</script>';
	}
	/*if (in_array(9, $parcala)) { 
		mysql_query("delete from ilan_notlari where id='".$gelen_id."'");
	} 
	header("Location:?modul=ihaleler&sayfa=tum_ihaleler");*/
}

//Tanıtım SMS sil
if($silinecek=="tanitim_sms_sil"){
	$tanitim_sms_cek=mysql_query("select * from tanitim_sms_ayarlari where id='".$gelen_id."'");
	$tanitim_sms_oku=mysql_fetch_object($tanitim_sms_cek);
	$durum=$tanitim_sms_oku->durum;
	
	if($durum=="1"){
		echo "<script>alert('Aktif tanıtım sms silinemez.');</script>";
		// echo '<script>window.location.href = "?modul=ayarlar&sayfa=tanitim_sms_ayari";</script>';
		echo '<script>javascript: history.go(-1)</script>';
	}else{
		mysql_query("delete from tanitim_sms_ayarlari where id='".$gelen_id."'");
		// echo '<script>window.location.href = "?modul=ayarlar&sayfa=tanitim_sms_ayari";</script>';
		echo '<script>javascript: history.go(-1)</script>';
		
	}

	
	
}

?>