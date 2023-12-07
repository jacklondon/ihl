<?php 
include("resize.php");
	if ( re('si') == "" || empty($_REQUEST['si']) )
	{
		re('si') == 0;
	}
	
	/*
	if ( $_REQUEST['calisan'] != "alper" || empty($_REQUEST['calisan']) )
	{
		echo "guncelleme var";
		exit;
	}
	*/
	
	if ( re('islem') == "tasi" )
	{
		if ( re('gorev') == "down" )
		{
			$tut=false;
			$listeyi_sor_is=mysql_query("select * from urunler_listesi where kategori='".re('si')."' order by sira");
			while( $listeyi_cek_is=mysql_fetch_array($listeyi_sor_is) )
			{
			
				if ( $tut == true )
				{
					$sonraki_id=$listeyi_cek_is['id'];
					$sonraki_sira=$listeyi_cek_is['sira'];
					$tut=false;
				}
			
			
				if ( $listeyi_cek_is['id'] == re('mid') ) 
				{
					$basilan_id=$listeyi_cek_is['id'];
					$basilan_sira=$listeyi_cek_is['sira'];
					$tut=true;
				}
			}
			
			mysql_query("update urunler_listesi set sira='".$basilan_sira."' where id='".$sonraki_id."'");
			mysql_query("update urunler_listesi set sira='".$sonraki_sira."' where id='".$basilan_id."'");
		}
		
		if ( re('gorev') == "up" )
		{
			$birak=true;
			$listeyi_sor_is=mysql_query("select * from urunler_listesi where kategori='".re('mgrup')."' order by sira");
			while( $listeyi_cek_is=mysql_fetch_array($listeyi_sor_is) )
			{
			
				if ( $listeyi_cek_is['id'] == re('mid') ) 
				{
					$basilan_id=$listeyi_cek_is['id'];
					$basilan_sira=$listeyi_cek_is['sira'];
					$birak=false;
					$onceki_id=$tutulan_id;
					$onceki_sira=$tutulan_sira;
				}
				
				if ( $birak == true )
				{
					$tutulan_id=$listeyi_cek_is['id'];
					$tutulan_sira=$listeyi_cek_is['sira'];
				}
			}
			
			mysql_query("update urunler_listesi set sira='".$basilan_sira."' where id='".$onceki_id."'");
			mysql_query("update urunler_listesi set sira='".$onceki_sira."' where id='".$basilan_id."'");
			
		}
	}
	
	if ( re('islem') == "ac_kapa" )
	{
		if (re('durum') == 1 ) { $durum=1; } else { $durum=0; }
		mysql_query("update urunler_listesi set durum='".$durum."' where id='".re('mgrup')."'");
	}
		
	if ( re('islem') == "KAYDET" )
	{
		$image2 = new SimpleImage();
		$image = new SimpleImage();
		/* Önce silinecekleri silsin, sonra güncelllenecekleri güncellesin sonra ise ekleme yapsın. */
		$listeyi_sor_isle=mysql_query("select * from urunler_listesi order by sira");
		while( $listeyi_cek_isle=mysql_fetch_array($listeyi_sor_isle) )
		{
			if ( re('sec_'.$listeyi_cek_isle['id']) == $listeyi_cek_isle['id'] )
			{
				mysql_query("delete from urunler_listesi where id='".$listeyi_cek_isle['id']."'")or die(mysql_error());
			}
			else
			{
				$guncelle=false;
				if ($listeyi_cek_isle['tanim'] != re('urun_adi_'.$listeyi_cek_isle['id']) ) { $guncelle=true; }
				if ($listeyi_cek_isle['stok'] != re('urun_stok_'.$listeyi_cek_isle['id']) ) { $guncelle=true; }
				if ($listeyi_cek_isle['fiyat'] != re('urun_fiyat_'.$listeyi_cek_isle['id']) ) { $guncelle=true; }
				if ($listeyi_cek_isle['ebat'] != re('urun_ebat_'.$listeyi_cek_isle['id']) ) { $guncelle=true; }
				if ($listeyi_cek_isle['kodu'] != re('urun_kod_'.$listeyi_cek_isle['id']) ) { $guncelle=true; }
				if ($listeyi_cek_isle['kategori'] != re('urun_kategori_'.$listeyi_cek_isle['id']) ) { $guncelle=true; }
				
				if($guncelle == true)
				{
					mysql_query("update urunler_listesi set 
					tanim='".re('urun_adi_'.$listeyi_cek_isle['id'])."', 
					stok='".re('urun_stok_'.$listeyi_cek_isle['id'])."', 
					fiyat='".re('urun_fiyat_'.$listeyi_cek_isle['id'])."', 
					ebat='".re('urun_ebat_'.$listeyi_cek_isle['id'])."', 
					kodu='".re('urun_kod_'.$listeyi_cek_isle['id'])."',
					kategori='".re('urun_kategori_'.$listeyi_cek_isle['id'])."'
					where id='".$listeyi_cek_isle['id']."'")or die(mysql_error());
				}
				
				/* Eğer logo seçilmiş ise, logoyu güncellesin */
				if ( $_FILES['urun_dosya_'.$listeyi_cek_isle['id']]['name'] != "" )
				{	
					$dosyaismi=$_FILES['urun_dosya_'.$listeyi_cek_isle['id']]['name'];
					$geciciyer=$_FILES['urun_dosya_'.$listeyi_cek_isle['id']]['tmp_name'];
					$x=substr(md5(rand(9999,99999)),0,5).substr($dosyaismi,-4);
					$gercekisim="image_".$x;
					
					move_uploaded_file($geciciyer,$yukle_scrpt."/small/".$gercekisim);
					$thumbisim2=$yukle_scrpt."/small/".$gercekisim;
					
					$image2->load("$thumbisim2");
					$image2->resize(411,274);
					$image2->save("$thumbisim2");
					
					
					move_uploaded_file($geciciyer,$yukle_scrpt."/genel/".$gercekisim);
					$thumbisim=$yukle_scrpt."/genel/".$gercekisim;
					
					$image->load("$thumbisim");
					$image->resize(200,140);
					$image->save("$thumbisim");
						
						
						
						move_uploaded_file($geciciyer,$yukle_scrpt."/large/".$gercekisim);
						
						$yaz = mysql_query("update urunler_listesi set logo='".$gercekisim."' where id='".$listeyi_cek_isle['id']."'") or die("HATA : Dump2 " . mysql_error());
				}
			}
			
			$simdiki_sira=$listeyi_cek_isle['sira'];
		}
		
		if ( re('urun_adi_yeni') != "" )
		{
			$simdiki_sira++;
			mysql_query("insert into urunler_listesi (
			id,
			sira,
			tanim,
			stok,
			fiyat,
			ebat,
			kodu,
			logo,
			durum,
			kategori
			)values(
			null,
			'".$simdiki_sira."',
			'".re('urun_adi_yeni')."',
			'".re('urun_stok_yeni')."',
			'".re('urun_fiyat_yeni')."',
			'".re('urun_ebat_yeni')."',
			'".re('urun_kodu_yeni')."',
			'".re('urun_logo_yeni')."',
			'1',
			'".re('urun_kategori_yeni')."')")or die(mysql_error());
		}
	}
	
	$sablon_say=0;
	$sablon_dizisi='';
	$sablon_listesi_sor=mysql_query("select * from urunler_kategoriler order by id");
	while( $sablon_listesi_cek=mysql_fetch_array($sablon_listesi_sor) )
	{
		$sablon_say++;
		$ekk='|';
		if ( $sablon_say == 1 ) { $ekk=''; }
		$sablon_dizisi.=$ekk.$sablon_listesi_cek['id'].'~'.$sablon_listesi_cek['tanim'];
	}
	/*$sablon_dizisi=id1~index.php|id2~bindex.pbp*/
	$sablon_dizisi_bol=explode('|',$sablon_dizisi);
	
	
	
	
	$listeyi_sor_on=mysql_query("select * from urunler_listesi where kategori='".re('si')."' order by sira");
	while( $listeyi_cek_on=mysql_fetch_array($listeyi_sor_on) )
	{
		$son_id=$listeyi_cek_on['id'];
	}
	
	$sayi=0;
	$liste='';
	$listeyi_sor=mysql_query("select * from urunler_listesi order by sira");
	while( $listeyi_cek=mysql_fetch_array($listeyi_sor) )
	{
		/*
		if ( $listeyi_cek['kategori'] == "3" && $listeyi_cek['tanim'] < 8364 && $listeyi_cek['tanim'] > 8102 )
		{
			mysql_query("update urunler_listesi set logo='ela".$listeyi_cek['logo']."' where id='".$listeyi_cek['id']."'");
		}
		*/
	
	
		$sablon_listesi='';
		foreach ($sablon_dizisi_bol as $sablonlar)
		{
			$sablon_dizisi_bol2=explode('~',$sablonlar);
			$selected='';
			if ($listeyi_cek['kategori'] == $sablon_dizisi_bol2[0] ) { $selected='selected'; }
			$sablon_listesi.='<option value="'.$sablon_dizisi_bol2[0].'" '.$selected.'>'.$sablon_dizisi_bol2[1].'</option>';
			
		}
		
		$sayi++;
		$acik_kapali='<a href="?modul=urunler&sayfa=kategoriler&islem=ac_kapa&durum=1&mgrup='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." class="btn mini green"><i class="icon-lock"></i> Aç</a>';
		if ( $listeyi_cek['durum'] == 1 ) { $acik_kapali='<a href="?modul=urunler&sayfa=kategoriler&islem=ac_kapa&durum=0&mgrup='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız." class="btn mini red"><i class="icon-unlock"></i> Kapat</a>'; }
		
		$yukari='<a href="?modul=urunler&sayfa=kategoriler&si='.re('mgrup').'&islem=tasi&gorev=up&mid='.$listeyi_cek['id'].'" class="icon-circle-arrow-up"></a>';
		$asagi='<a href="?modul=urunler&sayfa=kategoriler&si='.re('mgrup').'&islem=tasi&gorev=down&mid='.$listeyi_cek['id'].'" class="icon-circle-arrow-down"></a>';
		if ( $sayi == 1 ) { $yukari=''; } 
		if ( $son_id == $listeyi_cek['id'] ) { $asagi=''; }
		
		$liste.='<tr>
						<td><input type="checkbox" name="sec_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['id'].'" ></td>
						<td >
							'.$yukari.$asagi.'
						</td>
						<td >'.$listeyi_cek['sira'].'</td>
						<td >'.$listeyi_cek['id'].'</td>
						<td><input type="text" name="urun_adi_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['tanim'].'" style="width:90%"></td>
						<td><input type="text" name="urun_stok_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['stok'].'" style="width:90%"></td>
						<td><input type="text" name="urun_fiyat_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['fiyat'].'" style="width:90%"></td>
						<td><input type="text" name="urun_ebat_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['ebat'].'" style="width:90%"></td>
						<td><input type="text" name="urun_kod_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['kodu'].'" style="width:90%"></td>
						<td>
							<select name="urun_kategori_'.$listeyi_cek['id'].'" style="width:90%">
								'.$sablon_listesi.'
							
							</select>
						</td>
						<td>
							'.$acik_kapali.'
						</td>
						
						<td>	
							<input type="file" name="urun_dosya_'.$listeyi_cek['id'].'" value="" style="width:90%">
						</td>
						
						<td>	
							<a href="http://minadavetiye.com/images/urunler/small/'.$listeyi_cek['logo'].'" target="_blank"><img src="http://minadavetiye.com/images/urunler/small/'.$listeyi_cek['logo'].'" style="width:30px; height:30px;">
						</td>
					</tr>
					
					';
					
	}
	
	$liste_ust.='<tr>
						<td colspan="14">
							Toplam '.$sayi.' Ürün Listelendi.
						</td>
						
					</tr>';
	
	$liste.='<td colspan="3">Yeni</td>
						<td>*</td>
						<td><input type="text" name="urun_adi_yeni" style="width:90%"></td>
						<td><input type="text" name="urun_stok_yeni" style="width:90%"></td>
						<td><input type="text" name="urun_fiyat_yeni" style="width:90%"></td>
						<td><input type="text" name="urun_ebat_yeni" style="width:90%"></td>
						<td><input type="text" name="urun_kod_yeni" style="width:90%"></td>
						<td>
							<select name="urun_kategori_yeni" style="width:90%">
								'.$sablon_listesi.'
							
							</select>
						</td>
						<td>-</td>
						<td><input type="submit" name="islem" value="KAYDET"></td>
	
	';
	
?>