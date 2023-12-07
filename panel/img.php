<?php
	session_start();
	header("Content-type:image/png"); //dosyanın türünü .png uzantılı image olarak belirtiyoruz
	$a = substr(rand(0,999999999999), -6);
	$b = substr(rand(0,999999999999), -6);
	$c = substr(rand(0,999999999999), -6);
	$sifre = substr(md5($a + $b + $c),-6); //rastgele güvenlik kodu üret

	if($sifre){
		$_SESSION["guvenlik_kodu"] = $sifre; //guvenlik adında session oluşturup güvenlik kodunu session a kaydet
		$width = 150;
		$height = 50;
		$resim = ImageCreate($width, $height); // 150x50 boyutunda bir tuval, kalıp oluştur
		$beyaz = ImageColorAllocate($resim, 255, 255, 255); //beyaz renk oluştur
		$sari = ImageColorAllocate($resim, 255, 255, 0); //sarı renk oluştur
		$kirmizi = ImageColorAllocate($resim, 139, 0, 0); //kırmızı renk oluştur
		$siyah = ImageColorAllocate($resim, 0, 0, 0); //siyah renk oluştur
		ImageFill($resim, 0, 0, $siyah); //tuvali siyaha boya
		ImageString($resim, 10, 50, 16, $_SESSION["guvenlik_kodu"], $beyaz); //tuvale belirtilen konumda session a atılan güvenlik kodunu beyaz renkli olarak yaz
		//ImageLine($resim, 500, 4, 0, 29, $sari); //tuvale belirtilen konumda sarı çizgi çiz
		//ImageLine($resim, 500, 159, 0, 0, $kirmizi); //tuvale belirtilen konumda kırmızı çizgi çiz
		ImagePng($resim); //tuvali resim olarak oluştur
		ImageDestroy($resim); //hafızadan sil
	}
?>