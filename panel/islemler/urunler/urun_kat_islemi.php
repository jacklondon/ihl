<?php 
	include('../../../ayar.php');
	
	$gelen = explode('|',re('veri'));
	
	if($gelen[0] == '1')
	{
		$kategorisi = '';
		$kat_say2 = 0;
		$kategorilerini_cek = mysql_query("select * from urunler_kategoriler where durum='1' and kategori='".$gelen[1]."' ORDER BY sira ASC, id ASC ");
		while($kategorilerini_oku = mysql_fetch_array($kategorilerini_cek))
		{
			$bas = true;
			
			if($bas == true)
			{
				$kat_say2++;
				
				$kategorisi .= '<option value="'.$kategorilerini_oku['id'].'">'.$kategorilerini_oku['tanim'].'</option>';
			}
		}
		
		if($kat_say2 != 0)
		{
			echo '<option value="0">Seçiniz</option>'.$kategorisi;
		}
	}
	
	if($gelen[0] == '2')
	{
		$kategorisi = '';
		$kat_say2 = 0;
		$kategorilerini_cek = mysql_query("select * from urunler_markalar where durum='1' and kategori='".$gelen[1]."' ORDER BY sira ASC, id ASC ");
		while($kategorilerini_oku = mysql_fetch_array($kategorilerini_cek))
		{
			$bas = true;
			
			if($bas == true)
			{
				$kat_say2++;
				
				$kategorisi .= '<option value="'.$kategorilerini_oku['id'].'">'.$kategorilerini_oku['tanim'].'</option>';
			}
		}
		
		if($kat_say2 != 0)
		{
			echo '<option value="0">Seçiniz</option>'.$kategorisi;
		}
	}
	
?>