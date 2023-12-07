<?php 

	if ( re('islem') == "ac_kapa" )
	{
		if (re('durum') == 1 ) { $durum=1; } else { $durum=0; }
		mysql_query("update urunler_kategoriler set durum='".$durum."' where id='".re('mgrup')."'");
	}
	
	if ( re('islem') == "KAYDET" )
	{
		/* Önce silinecekleri silsin, sonra güncelllenecekleri güncellesin sonra ise ekleme yapsın. */
		$listeyi_sor_isle=mysql_query("select * from urunler_kategoriler order by id");
		while( $listeyi_cek_isle=mysql_fetch_array($listeyi_sor_isle) )
		{
			if ( re('sec_'.$listeyi_cek_isle['id']) == $listeyi_cek_isle['id'] )
			{
				mysql_query("delete from urunler_kategoriler where id='".$listeyi_cek_isle['id']."'")or die(mysql_error());
			}
			else
			{
				$guncelle=false;
				if ($listeyi_cek_isle['kategori'] != re('kategori_adi_'.$listeyi_cek_isle['id']) ) { $guncelle=true; }
				
				if($guncelle == true)
				{
					mysql_query("update urunler_kategoriler set kategori='".re('kategori_adi_'.$listeyi_cek_isle['id'])."' where id='".$listeyi_cek_isle['id']."'");
				}
			}
		}
		
		if ( re('yeni_kategori_adi') != "" )
		{
			mysql_query("insert into urunler_kategoriler (
			id,
			kategori,
			durum
			)values(
			null,
			'".re('yeni_kategori_adi')."',
			'1')")or die(mysql_error());
		}
	}
	
	$sayi=0;
	$liste='';
	$listeyi_sor=mysql_query("select * from urunler_kategoriler order by id");
	while( $listeyi_cek=mysql_fetch_array($listeyi_sor) )
	{
		$acik_kapali='<a href="?modul=urunler&sayfa=kategoriler&islem=ac_kapa&durum=1&mgrup='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." class="btn mini green"><i class="icon-lock"></i> Aç</a>';
		if ( $listeyi_cek['durum'] == 1 ) { $acik_kapali='<a href="?modul=urunler&sayfa=kategoriler&islem=ac_kapa&durum=0&mgrup='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız." class="btn mini red"><i class="icon-unlock"></i> Kapat</a>'; }
		
		$sayi++;
		$liste.='<tr>
						<td><input type="checkbox" name="sec_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['id'].'" ></td>
						<td><input type="text" name="kategori_adi_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['kategori'].'" style="width:90%"></td>
						<td>
							'.$acik_kapali.'
							<a href="?modul=urunler&sayfa=kategoriler_ic&mgrup='.$listeyi_cek['id'].'" class="btn mini green"><i class="icon-edit"></i>Alt Kategori</a>
						</td>
					</tr>';
	}
	
	$liste.='<tr>
						<td>Yeni</td>
						<td><input type="text" name="yeni_kategori_adi" value="" style="width:90%"></td>
						<td><input type="submit" name="islem" value="KAYDET"></td>
					</tr>';

?>