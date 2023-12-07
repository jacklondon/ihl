<?php 

	include("ayar.php");
	
$i1="Web Alanı / Database Alanı|1";
$i2="E-Posta|1";
$i3="Yıllık Trafik / Sunucu Kullanımı|1";
$i4="Ürün / Kategori / Marka Yönetimi|1";
$i5="Otomatik Aktif Sanal POS|1";
$i6="Teknik Destek|1";
$i7="Hazır Tema Tasarımları|1";
$i8="Arama Motoru (SEO) Optimizasyonu|1";
$i9="Havale / Kapıda Ödeme Sistemi|1";
$i10="Toplu Mail Gönderimi|1";
$i11="Blog / Haber ve İçerik Yönetimi|1";
$i12="Detaylı Kargo Yönetimi|1";
$i13="İstatistik ve Raporlama|1";
$i14="Sosyal Medya Pazarlama|1";
$i15="RSS Desteği (Son 50 Ürün)|1";
$i16="Gelişmiş Slide Show Yönetimi|1";
$i17="Yurtiçi, MNG , Aras Kargo Entegrasyonu|2";
$i18="Bayi (B2B) Altyapısı|2";
$i19="Mobil Ödeme (Tüm Operatörler)|2";
$i20="SSL Sertifikası / Statik IP|2";
$i21="Kredi Kartı Modülü|2";
$i22="Hediye Çeki / Puan Sistemi|3";
$i23="Fiyat Karşılaştırma Siteleri|3";
$i24="XML Entegrasyonları|3";
$i25="Facebook Store|3";
$i26="Google Richsnippets|4";
$i27="Ürün Karşılaştırma Modülü|4";
$i28="Akıllı Filtre ve Ürün Seçenekleri|4";
$i29="Davet Sistemi|4";
$i30="Online Fatura Kesme Modülü|5";
$i31="Excel Ürün Aktarım Robotu|5";
$i32="Promosyon Modülü|5";
$i33="Seo Etiket|5";
$i34="Mobil E-ticaret Sitesi|5";

/*
	for ($i=1; $i<=34; $i++)
	{
		$cek=explode('|',${'i'.$i});
		mysql_query("insert into lisanslar_moduller (id,modul,paket,hak)values(null,'".$cek[0]."','".$cek[1]."','1')")or die(mysql_error());
	}
*/

echo mktime('0','0','0','10','15','2014');
echo '<br/>';
echo mktime('0','0','0','10','15','2015');

	

?>