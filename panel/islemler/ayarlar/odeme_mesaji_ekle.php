<?php 

if(re('odeme_mesajini')=="Kaydet"){   
    /*mysql_query("INSERT INTO odeme_mesaji
    (id,icerik,noter_takipci_gideri)VALUES(NULL,'".re('sms_icerigi')."', '".re('noter_takipci_gideri')."')");*/
	if(re("noter_takipci_gideri")==""){
		echo "<script>alert('Noter && Takipçi Gideri alanı boş olamaz')</script>";
	}else if(re("noter_takipci_gideri")<0){
		echo "<script>alert('Noter && Takipçi Gideri sıfırdan büyük olmalı')</script>";
	}else{
	 /*	mysql_query("
			INSERT INTO odeme_mesaji
				(id,icerik,noter_takipci_gideri)
			VALUES
				(NULL,'', '".re('noter_takipci_gideri')."')
		");*/
		$update=mysql_query("update odeme_mesaji set noter_takipci_gideri='".re("noter_takipci_gideri")."' where id='".re("noter_id")."' ");
		echo "<script>alert('Başarıyla Güncellendi')</script>";
		echo "<script>window.location.href = '?modul=ayarlar&sayfa=odeme_mesaji_noter_ayarlari';</script>";
	}
} 

?>