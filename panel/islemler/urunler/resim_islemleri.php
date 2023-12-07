<?php

	function resim_yukle($input_adi,$dizin,$ana_dizin,$win,$hei,$win2,$hei2,$win3,$hei3,$dizin2,$dizin3,$dizin4)
	{
		if ( $_FILES[$input_adi]['name'] != "" )
		{
			$tur=$_FILES[$input_adi]['type'];
			
			$tur_kontrol=tur_kontrol($tur);
			
			if ( $tur_kontrol == "evet" ){	}else{ $tur_bas=explode("/",$tur); echo 'Bu dosya türünde kabul edilmiyor.. <p>Tur: '.$tur_bas[1]; exit; }
			$tur=tur_sorgu($tur);
			
			
			$resim1_adim=rasgele(10);
			$resim1_adi=$resim1_adim.'.'.$tur;
			
			$yuklenecek_dosya = $dizin . basename($resim1_adi);
			if (move_uploaded_file($_FILES[$input_adi]['tmp_name'], $yuklenecek_dosya))
			{
				$dosya1 = $dizin2.$resim1_adi;
				$dosya2 = $dizin3.$resim1_adi;
				$dosya3 = $dizin4.$resim1_adi;
				
				$resimi_kirp=resim_kirp($dosya1,$tur,$resim1_adi,$win,$hei,$dizin2);
				$resimi_kirp=resim_kirp($dosya2,$tur,$resim1_adi,$win2,$hei2,$dizin3);
				$resimi_kirp=resim_kirp($dosya3,$tur,$resim1_adi,$win3,$hei3,$dizin4);
			}
			return $resim1_adi;
		}
		else
		{
			return "";
		}
	}
	
	function rasgele($uzunluk)
	{
	   $karakterler = "1234567890abcdefghijklmnopqrstuvwxyz";
	   for($i=0;$i<15;$i++)
	   {
		 $key .= $karakterler{rand(0,35)};
	   }
	   
	   $sorgu = mysql_query("select * from dosya_listesi where isim = '".$key."'");
		if( mysql_num_rows($sorgu) != 1 ){
			$yaz = mysql_query("INSERT INTO dosya_listesi (id,isim,modul) VALUES (null, '".mysql_real_escape_string($key)."','hizmet')") or die("HATA : Dump2 " . mysql_error());
			return $key;
		}else{
			rasgele(10);	
		}
	}
		
	function tur_kontrol($tur)
	{
		$turler="image/jpeg|image/gif|image/png|image/bmp";
		$turler_bol=explode("|",$turler);
		$buldu="hayir";
		foreach ( $turler_bol as $turlerx )
		{
			if ( $tur == $turlerx )
			{
				$buldu="evet";
			}
		}
		return $buldu;
	}

	function tur_sorgu($tur)
	{
		$turler="image/jpeg:jpg|image/gif:gif|image/png:png|image/bmp:bmp";
		$turler_bol=explode("|",$turler);
		foreach ( $turler_bol as $turlerx )
		{
			$turlerx_bol=explode(":",$turlerx);
			
			if ( $tur == $turlerx_bol[0] )
			{
				$turx=$turlerx_bol[1];
			}
		}
		return $turx;
	}
	
	function resim_kirp($dosya,$tur,$resim1_adi,$genislik,$yukseklik,$ana_dizin)
	{
		if ( $tur == "jpg" )
		{
			$resim=imagecreatefromjpeg($dosya); // Yüklenen resimden oluşacak yeni bir JPEG resmi oluşturuyoruz..
		}
		if ( $tur == "gif" )
		{
			$resim=imagecreatefromgif($dosya); // Yüklenen resimden oluşacak yeni bir JPEG resmi oluşturuyoruz..
		}
		if ( $tur == "bmp" )
		{
			$resim=imagecreatefromjpeg($dosya); // Yüklenen resimden oluşacak yeni bir JPEG resmi oluşturuyoruz..
		}
		if ( $tur == "png" )
		{
			
			$hedefdosya=$ana_dizin.$resim1_adi;
			copy($dosya, $hedefdosya);
			return false;
			// $resim=imagecreatefrompng($dosya); // Yüklenen resimden oluşacak yeni bir JPEG resmi oluşturuyoruz..
		}
		
		
		$boyutlar=getimagesize($dosya); // Resmimizin boyutlarını öğreniyoruz
		$resimorani=80/$boyutlar[0]; // Resmi küçültme/büyütme oranımızı hesaplıyoruz..
		$yeniresim=imagecreatetruecolor($genislik,$yukseklik); // Oluşturulan boş resmi istediğimiz boyutlara getiriyoruz..
		imagecopyresampled($yeniresim, $resim, 0, 0, 0, 0, $genislik, $yukseklik, $boyutlar[0], $boyutlar[1]);
		
		$hedefdosya=$ana_dizin.$resim1_adi;// Yeni resimin kaydedileceği konumu belirtiyoruz..
		
		
		if ( $tur == "jpg")
		{
			imagejpeg($yeniresim,$hedefdosya,100); // Ve resmi istediğimiz konuma kaydediyoruz..
		}
		if ( $tur == "gif" )
		{
			imagegif($yeniresim,$hedefdosya,100); // Ve resmi istediğimiz konuma kaydediyoruz..
		}
		if ( $tur == "bmp" )
		{
			imagejpeg($yeniresim,$hedefdosya,100); // Ve resmi istediğimiz konuma kaydediyoruz..
		}
		if ( $tur == "png" )
		{
			imagepng($yeniresim,$hedefdosya,100); // Ve resmi istediğimiz konuma kaydediyoruz..
		}
		
		//Kaydettiğimiz yeni resimin yolunu $hedefdosya değişkeni taşımaktadır..
		chmod ($hedefdosya, 0755); // chmod ayarını yapıyoruz dosyamızın..
	}
?>