<?php 
	
	$kosul = '';
	$listeleme_kurali = 'ORDER BY e_tarihi DESC, id DESC';
	$bunuda_ekle = '';
	
	if(re('ara') != "")
	{
		$kosul .= " and (adi like '%".re('ara')."%' or aciklama like '%".re('ara')."%' or fiyat like '%".re('ara')."%')";
		$bunuda_ekle .= '&ara='.re('ara');
	}
	
	/*
	if(re('kategori') != 0)
	{
		$kosul .= " and kategori='".re('kategori')."'";
		$bunuda_ekle .= '&kategori='.re('kategori');
	}
	*/
	if(re('kategori') != 0)
	{
		$bunuda_ekle .= '&kategori='.re('kategori');
	}
	if(re('alt_kategori') != 0)
	{
		$bunuda_ekle .= '&alt_kategori='.re('alt_kategori');
	}
	if(re('alt_kategori2') != 0)
	{
		$bunuda_ekle .= '&alt_kategori2='.re('alt_kategori2');
	}
	if(re('alt_kategori3') != 0)
	{
		$bunuda_ekle .= '&alt_kategori3='.re('alt_kategori3');
	}
	if(re('alt_kategori4') != 0)
	{
		$bunuda_ekle .= '&alt_kategori4='.re('alt_kategori4');
	}
	if(re('marka') != 0)
	{
		$kosul .= " and marka='".re('marka')."'";
		$bunuda_ekle .= '&marka='.re('marka');
	}
	
	
	
	$sayfada = 50; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	 
	//$say = mysql_num_rows(mysql_query("select * from s_urunler where durum='1' ".$kosul." ".$listeleme_kurali));
	
	$say = 0;
	$urun_cek = mysql_query("select * from s_urunler where durum='1' ".$kosul." ".$listeleme_kurali);
	while($urun_oku = mysql_fetch_array($urun_cek))
	{
		$bas = true;
		
		if(re('kategori') != 0)
		{
			$kat_sor = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('kategori')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor) == 0) { $bas = false; }
		}
		if(re('alt_kategori') != 0)
		{
			$kat_sor2 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor2) == 0) { $bas = false; }
		}
		if(re('alt_kategori2') != 0)
		{
			$kat_sor3 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori2')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor3) == 0) { $bas = false; }
		}
		if(re('alt_kategori3') != 0)
		{
			$kat_sor4 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori3')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor4) == 0) { $bas = false; }
		}
		if(re('alt_kategori4') != 0)
		{
			$kat_sor5 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori4')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor5) == 0) { $bas = false; }
		}
		
		if($bas == true)
		{
			$say++;
		}
	}
	 
	 
	$toplam_sayfa = ceil($say / $sayfada);
	

	$sayfa = isset($_GET['sira']) ? (int) $_GET['sira'] : 1;
	 
	if($sayfa < 1) $sayfa = 1; 
	if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
	$limit = ($sayfa - 1) * $sayfada;
	$limit = ' LIMIT '.$limit;
	
	if(re('anasayfa_0') != "") { mysql_query("update s_urunler set anasayfa='0' where id='".re('anasayfa_0')."' "); }
	if(re('anasayfa_1') != "") { mysql_query("update s_urunler set anasayfa='1' where id='".re('anasayfa_1')."' "); }
	
	if(re('yeni_0') != "") { mysql_query("update s_urunler set yeni='0' where id='".re('yeni_0')."' "); }
	if(re('yeni_1') != "") { mysql_query("update s_urunler set yeni='1' where id='".re('yeni_1')."' "); }
	
	if(re('indirimli_0') != "") { mysql_query("update s_urunler set indirimli='0' where id='".re('indirimli_0')."' "); }
	if(re('indirimli_1') != "") { mysql_query("update s_urunler set indirimli='1' where id='".re('indirimli_1')."' "); }
	
	if(re('urunleri') == "Güncelle")
	{
		$urun_cek = mysql_query("select * from s_urunler where durum='1' ".$kosul." ".$listeleme_kurali." ".$limit.', '.$sayfada);
		while($urun_oku = mysql_fetch_array($urun_cek))
		{
			$bas = true;
			
			if(re('kategori') != 0)
			{
				$kat_sor = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('kategori')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
				if(mysql_num_rows($kat_sor) == 0) { $bas = false; }
			}
			if(re('alt_kategori') != 0)
			{
				$kat_sor2 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
				if(mysql_num_rows($kat_sor2) == 0) { $bas = false; }
			}
			if(re('alt_kategori2') != 0)
			{
				$kat_sor3 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori2')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
				if(mysql_num_rows($kat_sor3) == 0) { $bas = false; }
			}
			if(re('alt_kategori3') != 0)
			{
				$kat_sor4 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori3')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
				if(mysql_num_rows($kat_sor4) == 0) { $bas = false; }
			}
			if(re('alt_kategori4') != 0)
			{
				$kat_sor5 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori4')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
				if(mysql_num_rows($kat_sor5) == 0) { $bas = false; }
			}
			
			if($bas == true)
			{
				mysql_query("update s_urunler set adi='".re('adi_'.$urun_oku['id'])."', fiyat='".re('fiyat_'.$urun_oku['id'])."', fiyat2='".re('fiyat2_'.$urun_oku['id'])."', fiyat5='".re('fiyat5_'.$urun_oku['id'])."', stok='".re('stok_'.$urun_oku['id'])."', anasayfa='".re('anasayfa_'.$urun_oku['id'])."', yeni='".re('yeni_'.$urun_oku['id'])."', indirimli='".re('indirimli_'.$urun_oku['id'])."', g_tarihi='".mktime()."', f_doviz='".re('f_doviz_'.$urun_oku['id'])."', f2_doviz='".re('f2_doviz_'.$urun_oku['id'])."', f5_doviz='".re('f5_doviz_'.$urun_oku['id'])."' where id='".$urun_oku['id']."' ");
				
				if(re('sil_'.$urun_oku['id']) == 1)
				{
					mysql_query("update s_urunler set durum='0', s_tarihi='".mktime()."' where id='".$urun_oku['id']."' ");
				}
			}
		}
	}
	
	
	$sayi = 0;
	$urunler = '';
	$urun_cek = mysql_query("select * from s_urunler where durum='1' ".$kosul." ".$listeleme_kurali." ".$limit.', '.$sayfada);
	while($urun_oku = mysql_fetch_array($urun_cek))
	{
		$bas = true;
		
		if(re('kategori') != 0)
		{
			$kat_sor = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('kategori')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor) == 0) { $bas = false; }
		}
		if(re('alt_kategori') != 0)
		{
			$kat_sor2 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor2) == 0) { $bas = false; }
		}
		if(re('alt_kategori2') != 0)
		{
			$kat_sor3 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori2')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor3) == 0) { $bas = false; }
		}
		if(re('alt_kategori3') != 0)
		{
			$kat_sor4 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori3')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor4) == 0) { $bas = false; }
		}
		if(re('alt_kategori4') != 0)
		{
			$kat_sor5 = mysql_query("select * from s_urunler_kategoriler where kat_id='".re('alt_kategori4')."' and urun_id='".$urun_oku['id']."' and durum='1' ");
			if(mysql_num_rows($kat_sor5) == 0) { $bas = false; }
		}
		
		if($bas == true)
		{
			$sayi++;
			$sirasi = '&sira=1';
			if(re('sira') != "")
			{
				$sirasi = '&sira='.re('sira');
			}
			/*
			$kategorisi = '';
			$kat_cek = mysql_query("select * from s_urunler_kategoriler where urun_id='".$urun_oku['id']."' and durum='1' ORDER BY id ASC LIMIT 1 ");
			if(mysql_num_rows($kat_cek) != 0)
			{
				$kat_oku = mysql_fetch_assoc($kat_cek);
				
				$kategori_cek = mysql_query("select * from urunler_kategoriler where id='".$kat_oku['kat_id']."' ");
				$kategori_oku = mysql_fetch_assoc($kategori_cek);
				
				$kategorisi = $kategori_oku['tanim'];
			}
			*/
			
			$kat1 = '';
			if(re('kategori') != "")
			{
				$kat1 = '&kategori='.re('kategori');
			}
			$kat2 = '';
			if(re('alt_kategori') != "")
			{
				$kat2 = '&alt_kategori='.re('alt_kategori');
			}
			$kat3 = '';
			if(re('alt_kategori2') != "")
			{
				$kat3 = '&alt_kategori2='.re('alt_kategori2');
			}
			$kat4 = '';
			if(re('alt_kategori3') != "")
			{
				$kat4 = '&alt_kategori3='.re('alt_kategori3');
			}
			$kat5 = '';
			if(re('alt_kategori4') != "")
			{
				$kat5 = '&alt_kategori4='.re('alt_kategori4');
			}
			
			$ana_link = '?modul='.re('modul').'&sayfa='.re('sayfa').$kat1.$kat2.$kat3.$kat4.$kat5;
			
			$anasayfa = '<input type="checkbox" name="anasayfa_'.$urun_oku['id'].'" id="anasayfa_'.$urun_oku['id'].'" value="1" />';
			$yeni = '<input type="checkbox" name="yeni_'.$urun_oku['id'].'" id="yeni_'.$urun_oku['id'].'" value="1" />';
			$indirimli = '<input type="checkbox" name="indirimli_'.$urun_oku['id'].'" id="indirimli_'.$urun_oku['id'].'" value="1" />';
			
			if($urun_oku['anasayfa'] == 1) 
			{ 
				$anasayfa = '<input type="checkbox" name="anasayfa_'.$urun_oku['id'].'" id="anasayfa_'.$urun_oku['id'].'" checked value="1" />';
			}
			if($urun_oku['yeni'] == 1) 
			{ 
				$yeni = '<input type="checkbox" name="yeni_'.$urun_oku['id'].'" id="yeni_'.$urun_oku['id'].'" checked value="1" />';
			}
			if($urun_oku['indirimli'] == 1) 
			{ 
				$indirimli = '<input type="checkbox" name="indirimli_'.$urun_oku['id'].'" id="indirimli_'.$urun_oku['id'].'" checked value="1" />';
			}
			
			$doviz_1 = '<select name="f_doviz_'.$urun_oku['id'].'" style="float:left; width:25%; float:left; margin-left:3%; height:24px;">';
			$doviz_2 = '<select name="f2_doviz_'.$urun_oku['id'].'" style="float:left; width:25%; float:left; margin-left:3%; height:24px;">';
			$doviz_cek = mysql_query("select * from s_dovizler where durum!='0' ORDER BY id ASC ");
			while($doviz_oku = mysql_fetch_array($doviz_cek))
			{
				
				$secili1 = '';
				$secili2 = '';
				if($doviz_oku['id'] == $urun_oku['f_doviz']) { $secili1 = 'selected'; }
				if($doviz_oku['id'] == $urun_oku['f2_doviz']) { $secili2 = 'selected'; }
				
				$doviz_1 .= '<option value="'.$doviz_oku['id'].'" '.$secili1.' >'.$doviz_oku['sembol'].'</option>';
				$doviz_2 .= '<option value="'.$doviz_oku['id'].'" '.$secili2.' >'.$doviz_oku['sembol'].'</option>';
			
			}
			$doviz_1 .= '</select>';
			$doviz_2 .= '</select>';
			
			
			$doviz_5 = '<select name="f5_doviz_'.$urun_oku['id'].'" style="float:left; width:25%; float:left; margin-left:3%; height:24px;">';
			$doviz_cek2 = mysql_query("select * from s_dovizler where durum!='0' ORDER BY id DESC ");
			while($doviz_oku2 = mysql_fetch_array($doviz_cek2))
			{
				
				$secili = '';
				if($doviz_oku2['id'] == $urun_oku['f5_doviz']) { $secili = 'selected'; }
				
				$doviz_5 .= '<option value="'.$doviz_oku2['id'].'" '.$secili.' >'.$doviz_oku2['sembol'].'</option>';
			
			}
			$doviz_5 .= '</select>';
			
			$urunler .= '<tr>
							<td>'.$sayi.'</td>
							<td>'.$urun_oku['id'].'</td>
							<td><input type="text" name="adi_'.$urun_oku['id'].'" id="adi_'.$urun_oku['id'].'" value="'.$urun_oku['adi'].'" style="width:100%;" /></td>
							<td><input type="text" name="fiyat_'.$urun_oku['id'].'" id="fiyat_'.$urun_oku['id'].'" value="'.$urun_oku['fiyat'].'" style="width:70%; float:left;" />'.$doviz_1.'</td>
							<td><input type="text" name="fiyat2_'.$urun_oku['id'].'" id="fiyat2_'.$urun_oku['id'].'" value="'.$urun_oku['fiyat2'].'" style="width:70%; float:left;" />'.$doviz_2.'</td>
							<td><input type="text" name="fiyat5_'.$urun_oku['id'].'" id="fiyat5_'.$urun_oku['id'].'" value="'.$urun_oku['fiyat5'].'" style="width:70%; float:left;" />'.$doviz_5.'</td>
							<td><input type="text" name="stok_'.$urun_oku['id'].'" id="stok_'.$urun_oku['id'].'" value="'.$urun_oku['stok'].'" style="width:100%;" /></td>
							<td>
								'.$anasayfa.'
							</td>
							<td>
								'.$yeni.'
							</td>
							<td>
								'.$indirimli.'
							</td>
							<td>
								<input type="checkbox" name="sil_'.$urun_oku['id'].'" id="sil_'.$urun_oku['id'].'" value="1" />
							</td>
						</tr>';
		}
	}
	
	
	
	$sayfa_goster = 9; // gösterilecek sayfa sayısı
	 
	$en_az_orta = ceil($sayfa_goster/2);
	$en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;
	 
	$sayfa_orta = $sayfa;
	if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
	if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
	 
	$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
	$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
	 
	if($sol_sayfalar < 1) $sol_sayfalar = 1;
	if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;
	 
	$sayilar = '<ul>';
	if($sayfa != 1)
	{
		$sayilar .= '<li class="prev disabled"><a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&sira=1'.$bunuda_ekle.'"><<</a></li>';
		
		$sayilar .= '<li class="prev disabled"><a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&sira='.($sayfa-1).$bunuda_ekle.'"><</a></li>';
	}
	for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) 
	{
		if($sayfa == $s) {
			$sayilar .= '<li class="active"><a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&sira='.$s.$bunuda_ekle.'">'.$s.'</a></li>';
		} else {
			$sayilar .= '<li><a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&sira='.$s.$bunuda_ekle.'">'.$s.'</a></li>';
		}
	}
	if($sayfa != $toplam_sayfa)
	{
		$sayilar .= '<li class="next"><a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&sira='.($sayfa+1).$bunuda_ekle.'">></a></li>';
		$sayilar .= '<li class="next"><a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&sira='.$toplam_sayfa.$bunuda_ekle.'">>></a></li>';
	}
	$sayilar .= '</ul>';
	
	
	
?>