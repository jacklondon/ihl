<?php

if(isset($prd->product->specs->spec[1]->name) && $prd->product->specs->spec[1]->name=="Marka")
	$marka = $prd->product->specs->spec[1]->value;
else
	$marka = "";



	mysql_query("insert into 
		s_urunler (
			kullanici_id,
			adi,
			tarih,
			aciklama,
			e_tarihi,
			durum,
			garanti,
			kategoriler,
			k_kategoriler,
			kategori,
			marka,
			model,
			stok,
			anahtar_kelime,
			i1,
			i2,
			i3,
			i4,
			ek_gor
			) 
			values (
			'".$_SESSION['kid']."',
			'".tirnaklar($prd->product->title)."',
			'".mkcevir(date("d.m.Y"))."',
			'".tirnaklar($prd->product->description)."',
			'".mktime()."',
			'1',
			'',
			'',
			'',
			'',
			'".$marka."',
			'".$prd->product->categoryCode."',
			'".$prd->product->productCount."',
			'',
			'',
			'',
			'',
			'',
			''
			) ");
	
	$urun_id = mysql_insert_id();
	$eklebunu_1 = '';
	$eklebunu_2 = '';
	
	$fiyat_cek = mysql_query("select * from s_fiyat_tanim where durum='1' ORDER BY id ASC ");
	while($fiyat_oku = mysql_fetch_array($fiyat_cek))
	{
		mysql_query("update s_urunler set ".$fiyat_oku['tanim']."='".re('fiyat_'.$fiyat_oku['id'])."', ".$fiyat_oku['tanim2']."='".re('doviz_'.$fiyat_oku['id'])."' where id='".$urun_id."' ");
	}
	
	/*
	if(re('eklenecek_kategoriler') != "")
	{
		$bolunen_katler = explode(',',re('eklenecek_kategoriler'));
		$e_uyum_say = 0;
		foreach($bolunen_katler as $bolunenleri)
		{
			$e_uyum_say++;
			
			if($e_uyum_say <= $max_uyum)
			{
				mysql_query("update s_urunler set u".$e_uyum_say."='".$bolunenleri."' where id='".$urun_id."' ");
			}
		}
	}
	*/
	
	/*
	if(re('eklenecek_k_kategoriler') != "")
	{
		$bolunen_katler = explode(',',re('eklenecek_k_kategoriler'));
		$e_kat_say = 0;
		foreach($bolunen_katler as $bolunenleri)
		{
			$e_kat_say++;
			
			if($e_kat_say <= $max_kat)
			{
				mysql_query("update s_urunler set k".$e_kat_say."='".$bolunenleri."' where id='".$urun_id."' ");
			}

		}
	}
	*/


/**  	RESİN EKLEME */
/*

		$ek_res_1 = '';
		$ek_res_2 = '';
		/*
		if($_FILES['ek_img_'.$ek_oz_oku['id']]['name'] != "")
		{
			$dosya_adi=$_FILES['ek_img_'.$ek_oz_oku['id']]["name"];
			$dizim=array("iz","et","se","du","yr","nk");
			$uzanti=substr($dosya_adi,-4,4);
		
			$rasgele=rand(1,1000000);
			$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
			$yeni_ad="../images/urun/".$ad;
			move_uploaded_file($_FILES['ek_img_'.$ek_oz_oku['id']]['tmp_name'],$yeni_ad);
			
			$ek_res_1 = ',resim';
			$ek_res_2 = ",'".$ad."'";
		}
		*/
		//mysql_query("insert into s_stoklar (urun_id,ek_oz_id,stok,e_tarihi,durum".$ek_res_1.") values ('".$urun_id."','".$ek_oz_oku['id']."','".re('ek_oz_'.$ek_oz_oku['id'])."','".mktime()."','1'".$ek_res_2.") ");


		$resimSayisi
$ek_res_1 = '';
$ek_res_2 = '';		
mysql_query("insert into s_stoklar (urun_id,ek_oz_id,stok,e_tarihi,durum".$ek_res_1.") values ('".$urun_id."','0','0','".mktime()."','1'".$ek_res_2.") ");
	
/**/



	
	$ek_oz_cek = mysql_query("select * from s_ek_ozellik_detay where ozellik_id='1' and durum='1' ORDER BY e_tarihi ASC, id ASC ");
	while($ek_oz_oku = mysql_fetch_array($ek_oz_cek))
	{
		$ek_res_1 = '';
		$ek_res_2 = '';
		/*
		if($_FILES['ek_img_'.$ek_oz_oku['id']]['name'] != "")
		{
			$dosya_adi=$_FILES['ek_img_'.$ek_oz_oku['id']]["name"];
			$dizim=array("iz","et","se","du","yr","nk");
			$uzanti=substr($dosya_adi,-4,4);
		
			$rasgele=rand(1,1000000);
			$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
			$yeni_ad="../images/urun/".$ad;
			move_uploaded_file($_FILES['ek_img_'.$ek_oz_oku['id']]['tmp_name'],$yeni_ad);
			
			$ek_res_1 = ',resim';
			$ek_res_2 = ",'".$ad."'";
		}
		*/
		//mysql_query("insert into s_stoklar (urun_id,ek_oz_id,stok,e_tarihi,durum".$ek_res_1.") values ('".$urun_id."','".$ek_oz_oku['id']."','".re('ek_oz_'.$ek_oz_oku['id'])."','".mktime()."','1'".$ek_res_2.") ");
		mysql_query("insert into s_stoklar (urun_id,ek_oz_id,stok,e_tarihi,durum".$ek_res_1.") values ('".$urun_id."','0','0','".mktime()."','1'".$ek_res_2.") ");
		
	}
	
	$ek_oz_cek = mysql_query("select * from s_ek_ozellik_detay where ozellik_id='2' and durum='1' ORDER BY e_tarihi ASC, id ASC ");
	while($ek_oz_oku = mysql_fetch_array($ek_oz_cek))
	{
		$ek_res_1 = '';
		$ek_res_2 = '';
		if($_FILES['ek_img_'.$ek_oz_oku['id']]['name'] != "")
		{
			$dosya_adi=$_FILES['ek_img_'.$ek_oz_oku['id']]["name"];
			$dizim=array("iz","et","se","du","yr","nk");
			$uzanti=substr($dosya_adi,-4,4);
		
			$rasgele=rand(1,1000000);
			$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
			$yeni_ad="../images/urun/".$ad;
			move_uploaded_file($_FILES['ek_img_'.$ek_oz_oku['id']]['tmp_name'],$yeni_ad);
			
			$ek_res_1 = ',resim';
			$ek_res_2 = ",'".$ad."'";
		}
		
		mysql_query("insert into s_stoklar (urun_id,ek_oz_id,stok,e_tarihi,durum".$ek_res_1.") values ('".$urun_id."','".$ek_oz_oku['id']."','".re('ek_oz_'.$ek_oz_oku['id'])."','".mktime()."','1'".$ek_res_2.") ");
	}
	

	/*			
	$soru_cek = mysql_query("select * from s_sorular where durum='1' ORDER BY e_tarihi ASC ");
	while($soru_oku = mysql_fetch_array($soru_cek))
	{
		$say++;
		
		$zorunlu = '';
		if($soru_oku['zorunlu'] == 1)
		{
			
		}
		
		$eklebunu_1 .= ",".$soru_oku['input'];
		
		if($soru_oku['soru_tur'] == 1) // Metin alanı
		{
			$eklebunu_2 .= ",'".re($soru_oku['input'])."'";
		}
		
		if($soru_oku['soru_tur'] == 2) // Açılır Pencere
		{
			$eklebunu_2 .= ",'".re($soru_oku['input'])."'";
		}
		
		if($soru_oku['soru_tur'] == 3) // Çoktan tek seçmeli
		{
			$eklebunu_2 .= ",'".re($soru_oku['input'])."'";
		}
		
		if($soru_oku['soru_tur'] == 4) // Çoktan çok seçmeli
		{
			$ekle_verileri = '';
			$ozellik_icerikler = explode('|',$soru_oku['ozellik']);
			foreach($ozellik_icerikler as $ozellik_ic)
			{
				$ic_bolum = explode(':',$ozellik_ic);
				$ici = 0;
				if(re($soru_oku['input'].'_'.$ic_bolum[0]) != "")
				{
					$ici = 1;
				}
				$ekle_verileri .= $ic_bolum[0].':'.$ici.'|';
			}
			$ekle_verileri = rtrim($ekle_verileri,'|');
			$eklebunu_2 .= ",'".$ekle_verileri."'";
		}
	}
	*/
	
	mysql_query("insert into s_sorular_veriler (kullanici_id,urun_id,durum".$eklebunu_1.") values ('".$_SESSION['kid']."','".$urun_id."','1'".$eklebunu_2.") ");
	
	if($_FILES['resim']['name'] != "")
	{
		include('simpleimage.php');
		
		$dosya_sayi=count($_FILES['resim']['name']);
		for($i=0;$i<$dosya_sayi;$i++)
		{
			if(!empty($_FILES['resim']['name'][$i]))
			{
				$dosya_adi=$_FILES["resim"]["name"][$i];
				$dizim=array("iz","et","se","du","yr","nk");
				$uzanti=substr($dosya_adi,-4,4);
			
				$rasgele=rand(1,1000000);
				$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
				$yeni_ad="../images/urun/".$ad;
				move_uploaded_file($_FILES["resim"]['tmp_name'][$i],$yeni_ad);
				
				$k_ad = "../images/urun/k_".$ad;
				copy($yeni_ad,$k_ad);
				
				$image = new SimpleImage();
				$image->load($yeni_ad);
				$image->resizeToWidth(1000);
				$image->save($yeni_ad);
				
				$image = new SimpleImage();
				$image->load($k_ad);
				$image->resizeToWidth(500);
				$image->save($k_ad);
				
				
				mysql_query("insert into s_urunler_resimler (urun_id,kullanici_id,resim,resim2,e_tarihi,durum) values ('".$urun_id."','".$_SESSION['kid']."','".$ad."','k_".$ad."','".mktime()."','1') ");
			}
		}
	}
	
	alert("Ürün Eklendi..");
	echo '<meta http-equiv="refresh" content="0;URL=?modul=urunler&sayfa=urun_ekle">';


			?>