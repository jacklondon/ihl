<?php 
include("resim_islemleri.php");
	if ( re('si') == "" || empty($_REQUEST['si']) )
	{
		re('si') == 0;
	}
	
	if ( re('islem') == "tasi" )
	{
		if ( re('gorev') == "down" )
		{
			$tut=false;
			$listeyi_sor_is=mysql_query("select * from urunler_listesi_katalog where kategori='".re('si')."' order by sira");
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
			
			mysql_query("update urunler_listesi_katalog set sira='".$basilan_sira."' where id='".$sonraki_id."'");
			mysql_query("update urunler_listesi_katalog set sira='".$sonraki_sira."' where id='".$basilan_id."'");
		}
		
		if ( re('gorev') == "up" )
		{
			$birak=true;
			$listeyi_sor_is=mysql_query("select * from urunler_listesi_katalog where kategori='".re('mgrup')."' order by sira");
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
			
			mysql_query("update urunler_listesi_katalog set sira='".$basilan_sira."' where id='".$onceki_id."'");
			mysql_query("update urunler_listesi_katalog set sira='".$onceki_sira."' where id='".$basilan_id."'");
			
		}
	}
	
	if ( re('islem') == "ac_kapa" )
	{
		if (re('durum') == 1 ) { $durum=1; } else { $durum=0; }
		mysql_query("update urunler_listesi_katalog set durum='".$durum."' where id='".re('mgrup')."'");
	}
		
	if ( re('islem') == "KAYDET" )
	{
		/* Önce silinecekleri silsin, sonra güncelllenecekleri güncellesin sonra ise ekleme yapsın. */
		$listeyi_sor_isle=mysql_query("select * from urunler_listesi_katalog order by sira");
		while( $listeyi_cek_isle=mysql_fetch_array($listeyi_sor_isle) )
		{
			if ( re('sec_'.$listeyi_cek_isle['id']) == $listeyi_cek_isle['id'] )
			{
				mysql_query("delete from urunler_listesi_katalog where id='".$listeyi_cek_isle['id']."'")or die(mysql_error());
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
					mysql_query("update urunler_listesi_katalog set 
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
						$ana_dizin=$script_addr.'/images/urunler/large/';
						$dizin = $script_addr.'/images/urunler/large/';
						$dizin411=$script_addr.'/images/urunler/small/';
						$dizin100=$script_addr.'/images/urunler/thumb/';
						$dizin200=$script_addr.'/images/urunler/genel/';
						$resim_yukle1=resim_yukle('urun_dosya_'.$listeyi_cek_isle['id'],$dizin,$ana_dizin,'411','274','100','67','200','140',$dizin411,$dizin100,$dizin200);
						$yaz = mysql_query("update urunler_listesi_katalog set logo='".$resim_yukle1."' where id='".$listeyi_cek_isle['id']."'") or die("HATA : Dump2 " . mysql_error());
				}
			}
			
			$simdiki_sira=$listeyi_cek_isle['sira'];
		}
		
		if ( re('urun_adi_yeni') != "" )
		{
			$simdiki_sira++;
			mysql_query("insert into urunler_listesi_katalog (
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
	$sablon_listesi_sor=mysql_query("select * from urunler_kataloglar order by id");
	while( $sablon_listesi_cek=mysql_fetch_array($sablon_listesi_sor) )
	{
		$sablon_say++;
		$ekk='|';
		if ( $sablon_say == 1 ) { $ekk=''; }
		$sablon_dizisi.=$ekk.$sablon_listesi_cek['id'].'~'.$sablon_listesi_cek['tanim'];
	}
	/*$sablon_dizisi=id1~index.php|id2~bindex.pbp*/
	$sablon_dizisi_bol=explode('|',$sablon_dizisi);
	
	
	
	
	$listeyi_sor_on=mysql_query("select * from urunler_listesi_katalog where kategori='".re('si')."' order by sira");
	while( $listeyi_cek_on=mysql_fetch_array($listeyi_sor_on) )
	{
		$son_id=$listeyi_cek_on['id'];
	}
	
	$sayi=0;
	$liste='';
	$listeyi_sor=mysql_query("select * from urunler_listesi_katalog order by sira");
	while( $listeyi_cek=mysql_fetch_array($listeyi_sor) )
	{
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