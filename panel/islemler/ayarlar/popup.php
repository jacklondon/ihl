<?php 
	if(re('giriste_gorulecek_pupup')=="Kaydet"){
		//var_dump("asdasdşlaslkd");
		$pop_cek=mysql_query("select * from uye_giris_popup order by id asc");
		$sayi=0;
		while($pop_oku=mysql_fetch_object($pop_cek)){
			if(re("uyelerin_giriste_gorecegi_popup")!=""){
				$metin=$_POST["uyelerin_giriste_gorecegi_popup"];
			}else{
				$metin=$pop_oku->icerik;
			}
			$post=$_POST["gruplar"]; //array
			$pop_guncelle=mysql_query("update uye_giris_popup set icerik='".$metin."',durum='".re("pop_durum")."',secilme_durumu='".$post[$sayi]."' where paket_id='".$pop_oku->paket_id."' ");
			//var_dump("update uye_giris_popup set metin='".$metin."',durum='".re("pop_durum")."',secilme_durum='".$post[$sayi]."' where paket_id='".$pop_oku->paket_id."' ");
			$sayi++;
		}
		
		header('Location: ?modul=ayarlar&sayfa=uyeler_popup');
	}
?>