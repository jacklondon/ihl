<?php 
	

	//$ek_linki = '';
	if(re('k_kategori') != "") { echo '<input type="hidden" name="h_kategori" value="'.re('k_kategori').'" />'; }
	if(re('k_alt_kategori') != "") { echo '<input type="hidden" name="h_alt_kategori" value="'.re('k_alt_kategori').'" />'; }
	if(re('k_alt_kategori2') != "") { echo '<input type="hidden" name="h_alt_kategori2" value="'.re('k_alt_kategori2').'" />'; }
	if(re('k_alt_kategori3') != "") { echo '<input type="hidden" name="h_alt_kategori3" value="'.re('k_alt_kategori3').'" />'; }
	if(re('k_alt_kategori4') != "") { echo '<input type="hidden" name="h_alt_kategori4" value="'.re('k_alt_kategori4').'" />'; }
	

/*
	$urunleri_cek = mysql_query("select * from s_urunler where durum='1' ORDER BY e_tarihi ASC, id ASC ");
	while($urunleri_oku = mysql_fetch_array($urunleri_cek))
	{
		if($urunleri_oku['kategoriler'] != "")
		{
			$bolunen_katler = explode(',',$urunleri_oku['kategoriler']);
			foreach($bolunen_katler as $bolunenleri)
			{
				$sor_bakalim = mysql_query("select * from s_urunler_uyumluluk where urun_id='".$urunleri_oku['id']."' and m_id='".$bolunenleri."' ");
				if(mysql_num_rows($sor_bakalim) == 0)
				{
					mysql_query("insert into s_urunler_uyumluluk (urun_id,m_id) values ('".$urunleri_oku['id']."','".$bolunenleri."') ");
				}
			}
		}
	}
*/



	$ek_say = 0;

	if(re('urunu') == "Kaydet")
	{
		
		$kayit = true;
		$hata_mesaj = '';
		
		if(re('adi') == "") { $kayit = false; $hata_mesaj .= 'Adı alanı boş olamaz,'; }
		if(re('tarih') == "") { $kayit = false; $hata_mesaj .= 'Adı alanı boş olamaz,'; }
		
		if($kayit == true)
		{
			if(re('urun') == "")
			{
				mysql_query("insert into s_urunler (kullanici_id,f_indirim_oncesi,f2_indirim_oncesi,adi,saf_stok,tarih,aciklama,icindekiler,k_sekli,e_tarihi,durum,garanti,kategoriler,k_kategoriler,kategori,marka,model,stok,anahtar_kelime,i1,i2,i3,i4,ek_gor) values ('".$_SESSION['kid']."','".re('f_indirim_oncesi')."','".re('f2_indirim_oncesi')."','".re('adi')."','".re('saf_stok_adet')."','".mkcevir(re('tarih'))."','".re('aciklama')."','".re('icindekiler')."','".re('k_sekli')."','".mktime()."','1','".re('garanti')."','".re('eklenecek_kategoriler')."','".re('eklenecek_k_kategoriler')."','".re('kategori')."','".re('marka')."','".re('model')."','".re('stok_adet')."','".re('anahtar_kelime')."','".re('i1')."','".re('i2')."','".re('i3')."','".re('i4')."','".re('ek_gor')."') ");
				
				$urun_id = mysql_insert_id();
				$eklebunu_1 = '';
				$eklebunu_2 = '';
				
				$fiyat_cek = mysql_query("select * from s_fiyat_tanim where durum='1' ORDER BY id ASC ");
				while($fiyat_oku = mysql_fetch_array($fiyat_cek))
				{
					mysql_query("update s_urunler set ".$fiyat_oku['tanim']."='".re('fiyat_'.$fiyat_oku['id'])."', ".$fiyat_oku['tanim2']."='".re('doviz_'.$fiyat_oku['id'])."' where id='".$urun_id."' ");
				}
				
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
						/*
						$sor_bakalim = mysql_query("select * from s_urunler_uyumluluk where urun_id='".$urun_id."' and m_id='".$bolunenleri."' ");
						if(mysql_num_rows($sor_bakalim) == 0)
						{
							mysql_query("insert into s_urunler_uyumluluk (urun_id,m_id) values ('".$urun_id."','".$bolunenleri."') ");
						}
						*/
					}
				}
				
				
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
						/*
						$sor_bakalim = mysql_query("select * from s_urunler_kategoriler where urun_id='".$urun_id."' and kat_id='".$bolunenleri."' and durum='1' ");
						if(mysql_num_rows($sor_bakalim) == 0)
						{
							mysql_query("insert into s_urunler_kategoriler (urun_id,kat_id,durum) values ('".$urun_id."','".$bolunenleri."','1') ");
						}
						*/
					}
				}
				
				
				$ek_oz_cek = mysql_query("select * from s_ek_ozellik_detay where ozellik_id='1' and durum='1' ORDER BY e_tarihi ASC, id ASC ");
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
				for($i=1; $i<=re('ek_fiyat_sayi'); $i++)
				{
					if(re('ek_fiyat_'.$i) != "")
					{
						mysql_query("insert into s_urunler_fiyatlar (urun_id,fiyat,yuzde,doviz,grup,kullanici_id,tip_id,e_tarihi,durum) values ('".$urun_id."','".re('ek_fiyat_'.$i)."','".re('ek_yuzde_'.$i)."','".re('ek_doviz_'.$i)."','".re('ek_grup_'.$i)."','".re('ek_kullanici_'.$i)."','".re('ek_tip_'.$i)."','".mktime()."','1') ");
						
					}
				}
				*/
						
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
			}
			else
			{
				/*
				$kat_veri_cek = mysql_query("select * from s_urunler where id='".re('urun')."' ");
				$kat_veri_oku = mysql_fetch_assoc($kat_veri_cek);
				$eski_katler = $kat_veri_oku['kategoriler'];
				*/
				
				mysql_query("update s_urunler set adi='".re('adi')."', f_indirim_oncesi='".re('f_indirim_oncesi')."', f2_indirim_oncesi='".re('f2_indirim_oncesi')."', fiyat='".re('fiyat')."', saf_stok='".re('saf_stok_adet')."', tarih='".mkcevir(re('tarih'))."', aciklama='".re('aciklama')."', icindekiler='".re('icindekiler')."', k_sekli='".re('k_sekli')."', garanti='".re('garanti')."', kategoriler='".re('eklenecek_kategoriler')."', k_kategoriler='".re('eklenecek_k_kategoriler')."', kategori='".re('kategori')."', alt_kategori='".re('alt_kategori')."', marka='".re('marka')."', model='".re('model')."', g_tarihi='".mktime()."', stok='".re('stok_adet')."', anahtar_kelime='".re('anahtar_kelime')."', i1='".re('i1')."', i2='".re('i2')."', i3='".re('i3')."', i4='".re('i4')."', ek_gor='".re('ek_gor')."' where id='".re('urun')."' ");
				
				$urun_id = re('urun');
				$eklebunu_1 = '';
				$eklebunu_2 = '';
				$eklebunu_guncel = '';
				
				$fiyat_cek = mysql_query("select * from s_fiyat_tanim where durum='1' ORDER BY id ASC ");
				while($fiyat_oku = mysql_fetch_array($fiyat_cek))
				{
					mysql_query("update s_urunler set ".$fiyat_oku['tanim']."='".re('fiyat_'.$fiyat_oku['id'])."', ".$fiyat_oku['tanim2']."='".re('doviz_'.$fiyat_oku['id'])."' where id='".$urun_id."' ");
				}
				
				/*
				if($eski_katler != "")
				{
					$bolunen_katler2 = explode(',',$eski_katler);
					foreach($bolunen_katler2 as $bolunenleri3)
					{
						$kati_cek = mysql_query("select * from urunler_markalar where id='".$bolunenleri."' ");
						$kati_oku = mysql_fetch_assoc($kati_cek);
						
						
						$bolunen_katler3 = explode(',',re('eklenecek_kategoriler'));
						foreach($bolunen_katler3 as $bolunenleri4)
						{
							$bolunenleri3;
						}
					}
				}
				*/
				
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
				
				
				/*
				if(re('eklenecek_kategoriler') != "")
				{
					mysql_query("delete from s_urunler_uyumluluk where urun_id='".$urun_id."' ");
					$bolunen_katler = explode(',',re('eklenecek_kategoriler'));
					foreach($bolunen_katler as $bolunenleri)
					{
						$sor_bakalim = mysql_query("select * from s_urunler_uyumluluk where urun_id='".$urun_id."' and m_id='".$bolunenleri."' ");
						if(mysql_num_rows($sor_bakalim) == 0)
						{
							mysql_query("insert into s_urunler_uyumluluk (urun_id,m_id) values ('".$urun_id."','".$bolunenleri."') ");
						}
					}
				}
				
				if(re('eklenecek_k_kategoriler') != "")
				{
					mysql_query("update s_urunler_kategoriler set durum='0' where urun_id='".$urun_id."' ");
					$bolunen_katler = explode(',',re('eklenecek_k_kategoriler'));
					foreach($bolunen_katler as $bolunenleri)
					{
						$sor_bakalim = mysql_query("select * from s_urunler_kategoriler where urun_id='".$urun_id."' and kat_id='".$bolunenleri."' and durum='1' ");
						if(mysql_num_rows($sor_bakalim) == 0)
						{
							$tekrar_sor_bakalim = mysql_query("select * from s_urunler_kategoriler where urun_id='".$urun_id."' and kat_id='".$bolunenleri."' ");
							if(mysql_num_rows($tekrar_sor_bakalim) == 0)
							{
								mysql_query("insert into s_urunler_kategoriler (urun_id,kat_id,durum) values ('".$urun_id."','".$bolunenleri."','1') ");
							}
							else
							{
								$tekrar_oku_bakalim = mysql_fetch_assoc($tekrar_sor_bakalim);
								mysql_query("update s_urunler_kategoriler set durum='1' where id='".$tekrar_oku_bakalim['id']."' ");
							}
						}
					}
				}
				*/
				
				$ek_oz_cek = mysql_query("select * from s_ek_ozellik_detay where ozellik_id='1' and durum='1' ORDER BY e_tarihi ASC, id ASC ");
				while($ek_oz_oku = mysql_fetch_array($ek_oz_cek))
				{
					$oz_stok_cek = mysql_query("select * from s_stoklar where urun_id='".$urun_id."' and ek_oz_id='".$ek_oz_oku['id']."' and durum='1' ");
					
					$ek_res_1 = '';
					$ek_res_2 = '';
					$ek_res_3 = '';
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
						$ek_res_3 = ",resim='".$ad."'";
					}
					
					if(mysql_num_rows($oz_stok_cek) == 0)
					{
						mysql_query("insert into s_stoklar (urun_id,ek_oz_id,stok,e_tarihi,durum".$ek_res_1.") values ('".$urun_id."','".$ek_oz_oku['id']."','".re('ek_oz_'.$ek_oz_oku['id'])."','".mktime()."','1'".$ek_res_2.") ");
					}
					else
					{
						$oz_stok_oku = mysql_fetch_assoc($oz_stok_cek);
						mysql_query("update s_stoklar set stok='".re('ek_oz_'.$ek_oz_oku['id'])."', g_tarihi='".mktime()."'".$ek_res_3." where id='".$oz_stok_oku['id']."' ");
					}
				}
				
				$ek_oz_cek = mysql_query("select * from s_ek_ozellik_detay where ozellik_id='2' and durum='1' ORDER BY e_tarihi ASC, id ASC ");
				while($ek_oz_oku = mysql_fetch_array($ek_oz_cek))
				{
					$oz_stok_cek = mysql_query("select * from s_stoklar where urun_id='".$urun_id."' and ek_oz_id='".$ek_oz_oku['id']."' and durum='1' ");
					
					$ek_res_1 = '';
					$ek_res_2 = '';
					$ek_res_3 = '';
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
						$ek_res_3 = ",resim='".$ad."'";
					}
					
					if(mysql_num_rows($oz_stok_cek) == 0)
					{
						mysql_query("insert into s_stoklar (urun_id,ek_oz_id,stok,e_tarihi,durum".$ek_res_1.") values ('".$urun_id."','".$ek_oz_oku['id']."','".re('ek_oz_'.$ek_oz_oku['id'])."','".mktime()."','1'".$ek_res_2.") ");
					}
					else
					{
						$oz_stok_oku = mysql_fetch_assoc($oz_stok_cek);
						mysql_query("update s_stoklar set stok='".re('ek_oz_'.$ek_oz_oku['id'])."', g_tarihi='".mktime()."'".$ek_res_3." where id='".$oz_stok_oku['id']."' ");
					}
				}
				
				
				$toplam_ek_fiyat = mysql_num_rows(mysql_query("select * from s_urunler_fiyatlar where urun_id='".re('urun')."' and durum='1' ORDER BY e_tarihi ASC "));
				$toplam_ek_fiyat = $toplam_ek_fiyat + 1;
				
				for($i=1; $i<=re('ek_fiyat_sayi'); $i++)
				{
					if(re('ek_fiyat_'.$i) != "" or re('ek_yuzde_'.$i) != "")
					{
						if($i < $toplam_ek_fiyat)
						{
							mysql_query("update s_urunler_fiyatlar set fiyat='".re('ek_fiyat_'.$i)."', yuzde='".re('ek_yuzde_'.$i)."', doviz='".re('ek_doviz_'.$i)."', grup='".re('ek_grup_'.$i)."', kullanici_id='".re('ek_kullanici_'.$i)."', tip_id='".re('ek_tip_'.$i)."', g_tarihi='".mktime()."' where id='".re('ek_fi_id_'.$i)."' ");
							
							if(re('ek_fi_sil_'.$i) == 1)
							{
								mysql_query("update s_urunler_fiyatlar set durum='0', s_tarihi='".mktime()."' where id='".re('ek_fi_id_'.$i)."' ");
							}
						}
						else
						{
							mysql_query("insert into s_urunler_fiyatlar (urun_id,fiyat,yuzde,doviz,grup,kullanici_id,tip_id,e_tarihi,durum) values ('".$urun_id."','".re('ek_fiyat_'.$i)."','".re('ek_yuzde_'.$i)."','".re('ek_doviz_'.$i)."','".re('ek_grup_'.$i)."','".re('ek_kullanici_'.$i)."','".re('ek_tip_'.$i)."','".mktime()."','1') ");
						}
					}
				}
				
				$soru_cek = mysql_query("select * from s_sorular where durum='1' ORDER BY e_tarihi ASC ");
				while($soru_oku = mysql_fetch_array($soru_cek))
				{
					$say++;
					
					$zorunlu = '';
					if($soru_oku['zorunlu'] == 1)
					{
						
					}
					
					$eklebunu_1 = ",".$soru_oku['input'];
					
					if($soru_oku['soru_tur'] == 1) // Metin alanı
					{
						$eklebunu_2 = "='".re($soru_oku['input'])."'";
					}
					
					if($soru_oku['soru_tur'] == 2) // Açılır Pencere
					{
						$eklebunu_2 = "='".re($soru_oku['input'])."'";
					}
					
					if($soru_oku['soru_tur'] == 3) // Çoktan tek seçmeli
					{
						$eklebunu_2 = "='".re($soru_oku['input'])."'";
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
						$eklebunu_2 = "='".$ekle_verileri."'";
					}
					$eklebunu_1 = $eklebunu_1.$eklebunu_2;
					
					$eklebunu_guncel .= $eklebunu_1;
				}
				
				mysql_query("update s_sorular_veriler set g_tarihi='".mktime()."' ".$eklebunu_guncel." where urun_id='".$urun_id."' ");
				
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
				
				$resim_cek = mysql_query("select * from s_urunler_resimler where urun_id='".re('urun')."' and durum='1' ORDER BY e_tarihi ASC ");
				while($resim_oku = mysql_fetch_array($resim_cek))
				{
					if(re('resim_sil_'.$resim_oku['id']) == 1)
					{
						unlink('../images/urun/'.$resim_oku['resim']);
						unlink('../images/urun/'.$resim_oku['resim2']);
						mysql_query("update s_urunler_resimler set durum='0' where id='".$resim_oku['id']."' ");
					}
				}
				
				$ek_linki = '';
				if(re('h_kategori') != "") { $ek_linki .= '&kategori='.re('h_kategori'); }
				if(re('h_alt_kategori') != "") { $ek_linki .= '&alt_kategori='.re('h_alt_kategori'); }
				if(re('h_alt_kategori2') != "") { $ek_linki .= '&alt_kategori2='.re('h_alt_kategori2'); }
				if(re('h_alt_kategori3') != "") { $ek_linki .= '&alt_kategori3='.re('h_alt_kategori3'); }
				if(re('h_alt_kategori4') != "") { $ek_linki .= '&alt_kategori4='.re('h_alt_kategori4'); }
				
				alert("Ürün Güncellendi..");
				echo '<meta http-equiv="refresh" content="0;URL=?modul=urunler&sayfa=urunler'.$ek_linki.'">';
			}
		}
		else
		{
			alert($hata_mesaj);
		}
	}
	
	$resimler = '';
	if(re('urun') != "")
	{
		$urun_cek = mysql_query("select * from s_urunler where id='".re('urun')."' and durum='1' ");
		$urun_oku = mysql_fetch_assoc($urun_cek);
		
		if($urun_oku['id'] == "")
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=urunler&sayfa=urunler">';
		}
		
		/*
		$kategori_toplanan = '';
		if($urun_oku['kategoriler'] != "")
		{
			$bolunen_katler = explode(',',$urun_oku['kategoriler']);
			foreach($bolunen_katler as $bolunenleri)
			{
				$kati_cek = mysql_query("select * from urunler_markalar where id='".$bolunenleri."' ");
				$kati_oku = mysql_fetch_assoc($kati_cek);
				
				$kategori_toplanan .= '<div class="ek_kategorisi" id="eklenmis_kat_'.$bolunenleri.'">'.$kati_oku['tanim'].'<span style="margin-left:8px; margin-top:-2px; cursor:pointer; font-weight:bold; cursor:pointer;" onclick="kategoriyi_cikart('.$bolunenleri.');">x</span></div>';
			}
		}
		*/
		
		$kat_sayisi = 0;
		$kat_ekleri = '';
		$kategori_toplanan = '';
		for($i=1; $i<=$max_uyum; $i++)
		{
			if($urun_oku['u'.$i] != 0)
			{
				$kati_cek = mysql_query("select * from urunler_markalar where id='".$urun_oku['u'.$i]."' ");
				$kati_oku = mysql_fetch_assoc($kati_cek);
				
				if($kati_oku['tanim'] != "")
				{
					$kat_sayisi++;
					if($kat_sayisi == 1) { $kat_ekleri .= $urun_oku['u'.$i]; } else { $kat_ekleri .= ','.$urun_oku['u'.$i]; }
				
					$kategori_toplanan .= '<div class="ek_kategorisi" id="eklenmis_kat_'.$urun_oku['u'.$i].'">'.$kati_oku['tanim'].'<span style="margin-left:8px; margin-top:-2px; cursor:pointer; font-weight:bold; cursor:pointer;" onclick="kategoriyi_cikart('.$urun_oku['u'.$i].');">x</span></div>';
				}
			}
		}
		
		$k_kat_sayisi = 0;
		$k_kat_ekleri = '';
		$k_kategori_toplanan = '';
		for($i=1; $i<=$max_kat; $i++)
		{
			if($urun_oku['k'.$i] != 0)
			{
				$kati_cek = mysql_query("select * from urunler_kategoriler where id='".$urun_oku['k'.$i]."' ");
				$kati_oku = mysql_fetch_assoc($kati_cek);
				
				if($kati_oku['tanim'] != "")
				{
					$k_kat_sayisi++;
					if($k_kat_sayisi == 1) { $k_kat_ekleri .= $urun_oku['k'.$i]; } else { $k_kat_ekleri .= ','.$urun_oku['k'.$i]; }
					
					if($kati_oku['kategori'] == 0)
					{
						$tur = 1;
					}
					else
					{
						$tur = 2;
					}
					
					$k_kategori_toplanan .= '<div class="ek_kategorisi" id="k_eklenmis_kat_'.$urun_oku['k'.$i].'">'.$kati_oku['tanim'].'<span style="margin-left:8px; margin-top:-2px; cursor:pointer; font-weight:bold; cursor:pointer;" onclick="k_kategoriyi_cikart('.$urun_oku['k'.$i].','.$tur.');">x</span></div>';
				}
			}
		}
		
		/*
		$kat_sayisi = 0;
		$kat_ekleri = '';
		$kategori_toplanan = '';
		$uyumluluklari_cek = mysql_query("select * from s_urunler_uyumluluk where urun_id='".re('urun')."' ORDER BY id ASC ");
		while($uyumluluklari_oku = mysql_fetch_array($uyumluluklari_cek))
		{
			$kati_cek = mysql_query("select * from urunler_markalar where id='".$uyumluluklari_oku['m_id']."' ");
			$kati_oku = mysql_fetch_assoc($kati_cek);
			
			if($kati_oku['tanim'] != "")
			{
				$kat_sayisi++;
				if($kat_sayisi == 1) { $kat_ekleri .= $uyumluluklari_oku['m_id']; } else { $kat_ekleri .= ','.$uyumluluklari_oku['m_id']; }
				
				$kategori_toplanan .= '<div class="ek_kategorisi" id="eklenmis_kat_'.$uyumluluklari_oku['m_id'].'">'.$kati_oku['tanim'].'<span style="margin-left:8px; margin-top:-2px; cursor:pointer; font-weight:bold; cursor:pointer;" onclick="kategoriyi_cikart('.$uyumluluklari_oku['m_id'].');">x</span></div>';
			}
		}
		
		
		$k_kat_sayisi = 0;
		$k_kat_ekleri = '';
		$k_kategori_toplanan = '';
		$kategorilerini_cek = mysql_query("select * from s_urunler_kategoriler where urun_id='".re('urun')."' and durum='1' ORDER BY id ASC ");
		while($kategorilerini_oku = mysql_fetch_array($kategorilerini_cek))
		{
			$kati_cek = mysql_query("select * from urunler_kategoriler where id='".$kategorilerini_oku['kat_id']."' ");
			$kati_oku = mysql_fetch_assoc($kati_cek);
			
			if($kati_oku['tanim'] != "")
			{
				$k_kat_sayisi++;
				if($k_kat_sayisi == 1) { $k_kat_ekleri .= $kategorilerini_oku['kat_id']; } else { $k_kat_ekleri .= ','.$kategorilerini_oku['kat_id']; }
				
				if($kati_oku['kategori'] == 0)
				{
					$tur = 1;
				}
				else
				{
					$tur = 2;
				}
				
				$k_kategori_toplanan .= '<div class="ek_kategorisi" id="k_eklenmis_kat_'.$kategorilerini_oku['kat_id'].'">'.$kati_oku['tanim'].'<span style="margin-left:8px; margin-top:-2px; cursor:pointer; font-weight:bold; cursor:pointer;" onclick="k_kategoriyi_cikart('.$kategorilerini_oku['kat_id'].','.$tur.');">x</span></div>';
			}
		}
		*/
		
		
		$ek_fiyatlar = '';
		$ek_fiyat_cek = mysql_query("select * from s_urunler_fiyatlar where durum='1' and urun_id='".re('urun')."' ORDER BY e_tarihi ASC, id ASC ");
		while($ek_fiyat_oku = mysql_fetch_array($ek_fiyat_cek))
		{
			$ek_say++;
			
			$dovizler = '';
			$doviz_cek = mysql_query("select * from s_dovizler where durum='1' ORDER BY e_tarihi, id ASC ");
			while($doviz_oku = mysql_fetch_array($doviz_cek))
			{
				$secili = '';
				if($ek_fiyat_oku['doviz'] == $doviz_oku['id']) { $secili ='selected'; }
				$dovizler .= '<option value="'.$doviz_oku['id'].'" '.$secili.' >'.$doviz_oku['adi'].' ('.$doviz_oku['sembol'].')</option>';
			}
			
			$gruplar = '';
			$gruplari_cek = mysql_query("select * from kullanicilar_grup where durum='1' ORDER BY id ASC ");
			while($gruplari_oku = mysql_fetch_array($gruplari_cek))
			{
				$secili = '';
				if($ek_fiyat_oku['grup'] == $gruplari_oku['id']) { $secili ='selected'; }
				$gruplar .= '<option value="'.$gruplari_oku['id'].'" '.$secili.' >'.$gruplari_oku['adi'].'</option>';
			}
			
			$kullanicilarim = '';
			$kullanicilarini_cek = mysql_query("select * from kullanicilar where durum='1' and yetki='1' ORDER BY e_tarihi ASC, id ASC ");
			while($kullanicilari_oku = mysql_fetch_array($kullanicilarini_cek))
			{
				$secili = '';
				if($ek_fiyat_oku['kullanici_id'] == $kullanicilari_oku['id']) { $secili ='selected'; }
				$kullanicilarim .= '<option value="'.$kullanicilari_oku['id'].'" '.$secili.' >'.$kullanicilari_oku['adi'].' '.$kullanicilari_oku['soyadi'].'</option>';
			}
			
			$tiplerimiz = '';
			$tiplerimizi_cek = mysql_query("select * from s_fiyat_tipler where durum='1' ORDER BY e_tarihi ASC, id ASC ");
			while($tiplerimizi_oku = mysql_fetch_array($tiplerimizi_cek))
			{
				$secili = '';
				if($ek_fiyat_oku['tip_id'] == $tiplerimizi_oku['id']) { $secili ='selected'; }
				$tiplerimiz .= '<option value="'.$tiplerimizi_oku['id'].'" '.$secili.' >'.$tiplerimizi_oku['adi'].'</option>';
			}
			
			$ek_fiyatlar .= '<input type="hidden" name="ek_fi_id_'.$ek_say.'" id="ek_fi_id_'.$ek_say.'" value="'.$ek_fiyat_oku['id'].'" />
							<div class="c_ek_fiyat_dis">
								<input type="text" class="span2 m-wrap" name="ek_fiyat_'.$ek_say.'" id="ek_fiyat_'.$ek_say.'" placeholder="Fiyat" value="'.$ek_fiyat_oku['fiyat'].'" />
								<input type="text" class="span2 m-wrap" name="ek_yuzde_'.$ek_say.'" id="ek_yuzde_'.$ek_say.'" placeholder="Yüzdesi" value="'.$ek_fiyat_oku['yuzde'].'" />
								<select class="span2 m-wrap" tabindex="1" name="ek_doviz_'.$ek_say.'" id="ek_doviz_'.$ek_say.'">
									 <option value="0">Döviz Seçiniz</option>
									 '.$dovizler.'
								  </select>
								  <select class="span2 m-wrap" tabindex="1" name="ek_grup_'.$ek_say.'" id="ek_grup_'.$ek_say.'">
									 <option value="0">Grup Seçiniz</option>
									 '.$gruplar.'
								  </select>
								  <select class="span2 m-wrap" tabindex="1" name="ek_kullanici_'.$ek_say.'" id="ek_kullanici_'.$ek_say.'">
									 <option value="0">Kullanıcı Seçiniz</option>
									 '.$kullanicilarim.'
								  </select>
								  <select class="span2 m-wrap" tabindex="1" name="ek_tip_'.$ek_say.'" id="ek_tip_'.$ek_say.'">
									 <option value="0">Tip Seçiniz</option>
									 '.$tiplerimiz.'
								  </select>
								  <input type="checkbox" value="1" style="opacity: 0;" name="ek_fi_sil_'.$ek_say.'" id="ek_fi_sil_'.$ek_say.'" >Sil
							 </div>';
		}
		
		$resim_sayi = 0;
		$resim_cek = mysql_query("select * from s_urunler_resimler where urun_id='".re('urun')."' and durum='1' ORDER BY e_tarihi ASC ");
		while($resim_oku = mysql_fetch_array($resim_cek))
		{
			$resim_sayi++;
			$resimler .= '<div style="float:left; width:150px; margin-right:10px; background-color:#F7F7F7; padding:3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
							<div style="float:left; width:100%;">
								<div style="float:left; font-size:13px; margin-right:3px;">
									Sil
								</div>
								<div style="float:left;">
									<input type="checkbox" name="resim_sil_'.$resim_oku['id'].'" id="resim_sil_'.$resim_oku['id'].'" value="1" />
								</div>
							</div>
							<div style="float:left; width:100%; text-align:center;">
								<a href="../images/urun/'.$resim_oku['resim2'].'" target="_blank">
									<img src="../images/urun/'.$resim_oku['resim2'].'" style="height:130px;" />
								</a>
							</div>
						</div>';
		}
	}

	
	$say = 0;
	$sorular = '';
	$soru_cek = mysql_query("select * from s_sorular where durum='1' ORDER BY e_tarihi ASC ");
	while($soru_oku = mysql_fetch_array($soru_cek))
	{
		$say++;
		
		$zorunlu = '';
		if($soru_oku['zorunlu'] == 1)
		{
			$zorunlu = '<div style="float:right; color:red; margin-right:4px;">(*)</div>';
		}
		
		if(re('urun') != "")
		{
			$veri_cek = mysql_query("select * from s_sorular_veriler where urun_id='".re('urun')."' ");
			$veri_oku = mysql_fetch_assoc($veri_cek);
		}
		
		if($soru_oku['soru_tur'] == 1) // Metin alanı
		{
			if(re('urun') != "")
			{
				$sorular .= '<div class="control-group">
							  <label class="control-label lbl_bolum_1">'.$soru_oku['soru'].$zorunlu.'</label>
							  <div class="controls">
								 <input type="text" class="span6 m-wrap" name="'.$soru_oku['input'].'" id="'.$soru_oku['input'].'" value="'.$veri_oku[$soru_oku['input']].'" />
							  </div>
							</div>';
			}
			else
			{
				$sorular .= '<div class="control-group">
							  <label class="control-label lbl_bolum_1">'.$soru_oku['soru'].$zorunlu.'</label>
							  <div class="controls">
								 <input type="text" class="span6 m-wrap" name="'.$soru_oku['input'].'" id="'.$soru_oku['input'].'" />
							  </div>
							</div>';
			}
		}
		
		if($soru_oku['soru_tur'] == 2) // Açılır Pencere
		{
			if(re('urun') != "")
			{
				$sorular .= '<div class="control-group">
								  <label class="control-label lbl_bolum_1">'.$soru_oku['soru'].$zorunlu.'</label>
								  <div class="controls">
									 <select class="span6 m-wrap" name="'.$soru_oku['input'].'" id="'.$soru_oku['input'].'" tabindex="1" >
										<option value="0">Seçiniz</option>';
				
				$ozellik_icerikler = explode('|',$soru_oku['ozellik']);
				
				foreach($ozellik_icerikler as $ozellik_ic)
				{
					$ic_bolum = explode(':',$ozellik_ic);
					$secili = '';
					if($veri_oku[$soru_oku['input']] == $ic_bolum[0]) { $secili = 'selected'; }
					$sorular .= '<option value="'.$ic_bolum[0].'" '.$secili.' >'.$ic_bolum[1].'</option>';
				}
				
				$sorular .= '</select></div></div>';
			}
			else
			{
				$sorular .= '<div class="control-group">
				  <label class="control-label lbl_bolum_1">'.$soru_oku['soru'].$zorunlu.'</label>
				  <div class="controls">
					 <select class="span6 m-wrap" name="'.$soru_oku['input'].'" id="'.$soru_oku['input'].'" tabindex="1" >
						<option value="0">Seçiniz</option>';

				$ozellik_icerikler = explode('|',$soru_oku['ozellik']);
				
				foreach($ozellik_icerikler as $ozellik_ic)
				{
					$ic_bolum = explode(':',$ozellik_ic);
					$sorular .= '<option value="'.$ic_bolum[0].'">'.$ic_bolum[1].'</option>';
				}
				
				$sorular .= '</select></div></div>';

			}
		}
		
		if($soru_oku['soru_tur'] == 3) // Çoktan tek seçmeli
		{
			if(re('urun') != "")
			{
				$sorular .= '<div class="control-group">
								  <label class="control-label lbl_bolum_1">'.$soru_oku['soru'].$zorunlu.'</label>
								  <div class="controls">';
								  
			  $sorular .= '<div class="radio_k_class">
					<input type="radio" style="margin-left:5px;" name="'.$soru_oku['input'].'" id="'.$soru_oku['input'].'" value="0">
					<div style="float:right; padding-top:1px; margin-left:4px;">
					  Boş
					</div>
				</div>
				';
				$veri_bol = explode('|',$veri_oku[$soru_oku['input']]);
				$ozellik_icerikler = explode('|',$soru_oku['ozellik']);
				foreach($ozellik_icerikler as $ozellik_ic)
				{
					$ic_bolum = explode(':',$ozellik_ic);
					
					$secili = '';
					$secili2 = '';
					$secili3 = '';
					foreach($veri_bol as $bolunen_veri)
					{
						if($ic_bolum[0] == $veri_bol[0])
						{
							$secili = '<div class="radio" id="uniform-malzemeler"><span class="checked">';
							$secili2 = '</span></div>';
							$secili3 = 'checked';
						}
					}
					$sorular .= '<div class="radio_k_class">
										'.$secili.'<input type="radio" style="margin-left:5px;" name="'.$soru_oku['input'].'" id="'.$soru_oku['input'].'" value="'.$ic_bolum[0].'" '.$secili3.' >'.$secili2.'
										<div style="float:right; padding-top:1px; margin-left:4px;">
										  '.$ic_bolum[1].'
										</div>
									</div>
									';
				}
				$sorular .= '</div></div>';
			}
			else
			{
				$sorular .= '<div class="control-group">
								  <label class="control-label lbl_bolum_1">'.$soru_oku['soru'].$zorunlu.'</label>
								  <div class="controls">';
				$ozellik_icerikler = explode('|',$soru_oku['ozellik']);
				foreach($ozellik_icerikler as $ozellik_ic)
				{
					$ic_bolum = explode(':',$ozellik_ic);
					
					$sorular .= '<div class="radio_k_class">
										<input type="radio" name="'.$soru_oku['input'].'" id="'.$soru_oku['input'].'" value="1">
										<div style="float:right; padding-top:1px; margin-left:4px;">
										  '.$ic_bolum[1].'
										</div>
									</div>
									';
				}
				$sorular .= '</div></div>';
			}
		}
		
		if($soru_oku['soru_tur'] == 4) // Çoktan çok seçmeli
		{
			if(re('urun') != "")
			{
				$sorular .= '<div class="control-group">
								  <label class="control-label lbl_bolum_1">'.$soru_oku['soru'].$zorunlu.'</label>
								  <div class="controls">';
				$veri_bol = explode('|',$veri_oku[$soru_oku['input']]);
				$ozellik_icerikler = explode('|',$soru_oku['ozellik']);
				foreach($ozellik_icerikler as $ozellik_ic)
				{
					$ic_bolum = explode(':',$ozellik_ic);
					
					/*
					$secili = '';
					foreach($veri_bol as $bolunen_veri)
					{
						if($ic_bolum[0] == $veri_bol[0])
						{
							$secili = 'checked';
						}
					}
					*/
					$sorular .= '<div class="radio_k_class">
									  <input type="checkbox" value="1" name="'.$soru_oku['input'].'_'.$ic_bolum[0].'" id="'.$soru_oku['input'].'_'.$ic_bolum[0].'" >
									  <div style="float:right; padding-top:1px; margin-left:4px;">
										'.$ic_bolum[1].'
										</div>
									  </div>';
				}
				$sorular .= '</div></div>';
			}
			else
			{
				$sorular .= '<div class="control-group">
								  <label class="control-label lbl_bolum_1">'.$soru_oku['soru'].$zorunlu.'</label>
								  <div class="controls">';
				$ozellik_icerikler = explode('|',$soru_oku['ozellik']);
				foreach($ozellik_icerikler as $ozellik_ic)
				{
					$ic_bolum = explode(':',$ozellik_ic);
					
					$sorular .= '<div class="radio_k_class">
									  <input type="checkbox" value="1" name="'.$soru_oku['input'].'_'.$ic_bolum[0].'" id="'.$soru_oku['input'].'_'.$ic_bolum[0].'" >
									  <div style="float:right; padding-top:1px; margin-left:4px;">
										'.$ic_bolum[1].'
										</div>
									  </div>';
				}
				$sorular .= '</div></div>';

			}
		}
	}
	
	
	$dovizler = '';
	$doviz_cek = mysql_query("select * from s_dovizler where durum='1' ORDER BY e_tarihi, id ASC ");
	while($doviz_oku = mysql_fetch_array($doviz_cek))
	{
		$dovizler .= '<option value="'.$doviz_oku['id'].'">'.$doviz_oku['adi'].' ('.$doviz_oku['sembol'].')</option>';
	}
	
	$gruplar = '';
	$gruplari_cek = mysql_query("select * from kullanicilar_grup where durum='1' ORDER BY id ASC ");
	while($gruplari_oku = mysql_fetch_array($gruplari_cek))
	{
		$gruplar .= '<option value="'.$gruplari_oku['id'].'">'.$gruplari_oku['adi'].'</option>';
	}
	
	$kullanicilarim = '';
	$kullanicilarini_cek = mysql_query("select * from kullanicilar where durum='1' and yetki='1' ORDER BY e_tarihi ASC, id ASC ");
	while($kullanicilari_oku = mysql_fetch_array($kullanicilarini_cek))
	{
		$kullanicilarim .= '<option value="'.$kullanicilari_oku['id'].'">'.$kullanicilari_oku['adi'].' '.$kullanicilari_oku['soyadi'].'</option>';
	}
	
	$tiplerimiz = '';
	$tiplerimizi_cek = mysql_query("select * from s_fiyat_tipler where durum='1' ORDER BY e_tarihi ASC, id ASC ");
	while($tiplerimizi_oku = mysql_fetch_array($tiplerimizi_cek))
	{
		$tiplerimiz .= '<option value="'.$tiplerimizi_oku['id'].'">'.$tiplerimizi_oku['adi'].'</option>';
	}
	
	/*
	
	<div class="c_ek_fiyat_dis">
		<input type="text" class="span2 m-wrap" name="ek_fiyat_" id="ek_fiyat_" placeholder="Fiyat" />
		<input type="text" class="span2 m-wrap" name="ek_yuzde_" id="ek_yuzde_" placeholder="Yüzdesi" />
		<select class="span2 m-wrap" tabindex="1" name="ek_doviz_" id="ek_doviz_">
			 <option value="0">Döviz Seçiniz</option>
		  </select>
		  <select class="span2 m-wrap" tabindex="1" name="ek_grup_" id="ek_grup_">
			 <option value="0">Grup Seçiniz</option>
		  </select>
		  <select class="span2 m-wrap" tabindex="1" name="ek_kullanici_" id="ek_kullanici_">
			 <option value="0">Kullanıcı Seçiniz</option>
		  </select>
		  <select class="span2 m-wrap" tabindex="1" name="ek_tip_" id="ek_tip_">
			 <option value="0">Tip Seçiniz</option>
		  </select>
	 </div>
	
	*/
	$stok_toplam = 0;
	$stok_cek_a = mysql_query("select * from s_stoklar where urun_id='".re('urun')."' and durum='1' ");
	while($stok_oku_a = mysql_fetch_array($stok_cek_a))
	{
		$stok_toplam = $stok_toplam + $stok_oku_a['stok'];
	}
	
	if($stok_toplam != $urun_oku['stok'])
	{
		mysql_query("update s_urunler set stok='".$stok_toplam."' where id='".re('urun')."' ");
		
		$urun_cek = mysql_query("select * from s_urunler id='".re('urun')."' ");
		$urun_oku = mysql_fetch_assoc($urun_cek);
	}
	
	
	
?>