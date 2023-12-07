<?php 

	if ( re('si') == "" || empty($_REQUEST['si']) )
	{
		re('si') == 0;
	}
	
	if ( re('islem') == "tasi" )
	{
		if ( re('gorev') == "down" )
		{
			$tut=false;
			$listeyi_sor_is=mysql_query("select * from urunler_markalar where kategori='".re('si')."' order by sira");
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
			
			mysql_query("update urunler_markalar set sira='".$basilan_sira."' where id='".$sonraki_id."'");
			mysql_query("update urunler_markalar set sira='".$sonraki_sira."' where id='".$basilan_id."'");
		}
		
		if ( re('gorev') == "up" )
		{
			$birak=true;
			$listeyi_sor_is=mysql_query("select * from urunler_markalar where kategori='".re('mgrup')."' order by sira");
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
			
			mysql_query("update urunler_markalar set sira='".$basilan_sira."' where id='".$onceki_id."'");
			mysql_query("update urunler_markalar set sira='".$onceki_sira."' where id='".$basilan_id."'");
			
		}
	}
	
	if ( re('islem') == "ac_kapa" )
	{
		if (re('durum') == 1 ) { $durum=1; } else { $durum=0; }
		mysql_query("update urunler_markalar set durum='".$durum."' where id='".re('mgrup')."'");
	}
		
	if ( re('islem') == "KAYDET" )
	{
		/* Önce silinecekleri silsin, sonra güncelllenecekleri güncellesin sonra ise ekleme yapsın. */
		$listeyi_sor_isle=mysql_query("select * from urunler_markalar where kategori='".re('si')."' order by sira");
		while( $listeyi_cek_isle=mysql_fetch_array($listeyi_sor_isle) )
		{
			if ( re('sec_'.$listeyi_cek_isle['id']) == $listeyi_cek_isle['id'] )
			{
				mysql_query("delete from urunler_markalar where id='".$listeyi_cek_isle['id']."'")or die(mysql_error());
			}
			else
			{
				$guncelle=false;
				if ($listeyi_cek_isle['tanim'] != re('kategori_adi_'.$listeyi_cek_isle['id']) ) { $guncelle=true; }
				
				if($guncelle == true)
				{
					
				}
				mysql_query("update urunler_markalar set tanim='".re('kategori_adi_'.$listeyi_cek_isle['id'])."', tel_ozel='".re('tel_ozel_'.$listeyi_cek_isle['id'])."' where id='".$listeyi_cek_isle['id']."'");
			}
			
			$simdiki_sira=$listeyi_cek_isle['sira'];
		}
		
		if ( re('kategori_adi_yeni') != "" )
		{
			$simdiki_sira++;
			mysql_query("insert into urunler_markalar (
			id,
			kategori,
			sira,
			tanim,
			tel_ozel,
			durum
			)values(
			null,
			'".re('si')."',
			'".$simdiki_sira."',
			'".re('kategori_adi_yeni')."',
			'1',
			'1')")or die(mysql_error());
		}
	}
	
	$listeyi_sor_on=mysql_query("select * from urunler_markalar where kategori='".re('si')."' order by sira");
	while( $listeyi_cek_on=mysql_fetch_array($listeyi_sor_on) )
	{
		$son_id=$listeyi_cek_on['id'];
	}
	
	$sayi=0;
	$liste='';
	
	$liste.='<tr>
						<td colspan="2">Yeni</td>
						<td >*</td>
						<td >*</td>
						<td><input type="text" name="kategori_adi_yeni" style="width:90%"></td>
						<td colspan="8">
							<input type="submit" name="islem" value="KAYDET">
						
						</td>
						
					</tr>';
	
	$listeyi_sor=mysql_query("select * from urunler_markalar where kategori='".re('si')."' order by sira");
	while( $listeyi_cek=mysql_fetch_array($listeyi_sor) )
	{
		$sayi++;
		$acik_kapali='<a href="?modul=urunler&sayfa=markalar&islem=ac_kapa&durum=1&mgrup='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." class="btn mini green"><i class="icon-lock"></i> Aç</a>';
		if ( $listeyi_cek['durum'] == 1 ) { $acik_kapali='<a href="?modul=urunler&sayfa=markalar&islem=ac_kapa&durum=0&mgrup='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız." class="btn mini red"><i class="icon-unlock"></i> Kapat</a>'; }
		
		$yukari='<a href="?modul=urunler&sayfa=markalar&si='.re('mgrup').'&islem=tasi&gorev=up&mid='.$listeyi_cek['id'].'" class="icon-circle-arrow-up"></a>';
		$asagi='<a href="?modul=urunler&sayfa=markalar&si='.re('mgrup').'&islem=tasi&gorev=down&mid='.$listeyi_cek['id'].'" class="icon-circle-arrow-down"></a>';
		if ( $sayi == 1 ) { $yukari=''; } 
		if ( $son_id == $listeyi_cek['id'] ) { $asagi=''; }
		
		$bu_secili = '';
		if($listeyi_cek['tel_ozel'] == '1')
		{
			$bu_secili = 'checked';
		}
		
		$liste.='<tr>
						<td><input type="checkbox" name="sec_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['id'].'" ></td>
						<td >
							'.$yukari.$asagi.'
						</td>
						<td >'.$listeyi_cek['sira'].'</td>
						<td >'.$listeyi_cek['id'].'</td>
						<td><input type="text" name="kategori_adi_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['tanim'].'" style="width:90%"></td>
						
						
						
						<td>
							'.$acik_kapali.'
						</td>
						<td>
							<a href="?modul=urunler&sayfa=markalar&si='.$listeyi_cek['id'].'" class="btn mini green"><i class="icon-edit"></i>Alt Kategori</a>
						</td>
						<td style="text-align:center;">
							<input type="checkbox" name="tel_ozel_'.$listeyi_cek['id'].'" '.$bu_secili.' id="tel_ozel_'.$listeyi_cek['id'].'" value="1" />
						</td>
						<td>	
							<a href="#" class="btn mini green"><i class="icon-edit"></i>Ürünler</a>
						</td>
						<td>
							<a href="#" class="btn mini green"><i class="icon-edit"></i>Vitrin</a>
						</td>
						<td>
							<a href="#" class="btn mini green"><i class="icon-edit"></i>Seçenek</a>
						</td>
						<td>
							<a href="#" class="btn mini green"><i class="icon-edit" title="Detaylari"></i>DT</a>
						</td>
						<td>
							<a href="#" class="btn mini green"><i class="icon-edit" title="Üst Bilgi"></i>ÜB</a>
						</td>
						<td>
							<a href="?modul=urunler&sayfa=markalar_logo&kategori='.$listeyi_cek['id'].'" class="btn mini green"><i class="icon-edit"></i>Logo</a>
						</td>
						
					</tr>';
	}
	
	$liste_ust.='<tr>
						<td colspan="14">
							Toplam '.$sayi.' Tema Listelendi.
						</td>
						
					</tr>';
	
	
	/*$liste.='<tr>
						<td>Yeni</td>
						<td><input type="text" name="yeni_kategori_adi" value="" style="width:90%"></td>
						<td><input type="submit" name="islem" value="KAYDET"></td>
					</tr>';
*/
?>