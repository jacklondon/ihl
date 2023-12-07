<?php 
	
	
	$u_cek = mysql_query("select * from s_urunler where durum='1' ORDER BY id ASC ");
	while($u_oku = mysql_fetch_array($u_cek))
	{
		/*
		for($i=1; $i<=$max_kat; $i++)
		{
			mysql_query("update s_urunler set k".$i."='0' where id='".$u_oku['id']."' ");
		}
		
		for($i=1; $i<=$max_uyum; $i++)
		{
			mysql_query("update s_urunler set u".$i."='0' where id='".$u_oku['id']."' ");
		}
		*/
		
		/*
		$t_kat_say = 0;
		$t_kat_cek = mysql_query("select * from s_urunler_kategoriler where durum='1' and urun_id='".$u_oku['id']."' ORDER BY id ASC ");
		while($t_kat_oku = mysql_fetch_array($t_kat_cek))
		{
			$t_kat_say++;
			
			if($t_kat_say <= $max_kat)
			{
				mysql_query("update s_urunler set k".$t_kat_say."='".$t_kat_oku['kat_id']."' where id='".$u_oku['id']."' ");
			}
		}
		
		
		$t_uyum_say = 0;
		$t_uyum_cek = mysql_query("select * from s_urunler_uyumluluk where urun_id='".$u_oku['id']."' ORDER BY id ASC ");
		while($t_uyum_oku = mysql_fetch_array($t_uyum_cek))
		{
			$t_uyum_say++;
			
			if($t_uyum_say <= $max_uyum)
			{
				mysql_query("update s_urunler set u".$t_uyum_say."='".$t_uyum_oku['m_id']."' where id='".$u_oku['id']."' ");
			}
		}
		*/
		
		
	/*
		$stok_cek = mysql_fetch_assoc("select * from s_stoklar where urun_id='".$u_oku['id']."' and durum='1' ORDER BY id ASC ");
		if(mysql_num_rows($stok_cek) != 0)
		{
			echo $stok_cek['resim'].'</br>';
		}
		*/
		/*
		$u_resim_cek = mysql_query("select * from s_urunler_resimler where urun_id='".$u_oku['id']."' and durum='1' ");
		if(mysql_num_rows($u_resim_cek) != 0)
		{
			mysql_query("update s_urunler set fotograf='1' where id='".$u_oku['id']."' ");
		}
		*/
		
		/*
		$fiyat_cek = mysql_query("select * from s_urunler_fiyatlar where urun_id='".$u_oku['id']."' and durum='1' and fiyat!='' ");
		if(mysql_num_rows($fiyat_cek) != 0)
		{
			$fiyat_oku = mysql_fetch_assoc($fiyat_cek);
			
			mysql_query("update s_urunler set fiyat2='".$fiyat_oku['fiyat']."' where id='".$u_oku['id']."' ");
		}
		*/
	}
	

	if(re('urun_sil') != "")
	{
		mysql_query("update s_urunler set durum='0',s_tarihi='".mktime()."' where id='".re('urun_sil')."' ");
		alert('Ürün Silindi..');
		if(re('sira') == "")
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=urunler&sayfa=urunler&sira=1">';
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=urunler&sayfa=urunler&sira='.re('sira').'">';
		}
	}
	
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
	
	
	
	$sayfada = 10000; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	 
	//$say = mysql_num_rows(mysql_query("select * from s_urunler where durum='1' ".$kosul." ".$listeleme_kurali));
	
	$say = 0;
	$urun_cek = mysql_query("select * from s_urunler where durum='1' ".$kosul." ".$listeleme_kurali);
	while($urun_oku = mysql_fetch_array($urun_cek))
	{
		$bas = true;
		
		$u_resim_cek = mysql_query("select * from s_urunler_resimler where urun_id='".$urun_oku['id']."' and durum='1' ");
		if(mysql_num_rows($u_resim_cek) != 0)
		{
			mysql_query("update s_urunler set fotograf='1' where id='".$urun_oku['id']."' ");
		}
		
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
	
	
	$ek_link = '';
	if(re('kategori') != "") { $ek_link .= '&k_kategori='.re('kategori'); }
	if(re('alt_kategori') != "") { $ek_link .= '&k_alt_kategori='.re('alt_kategori'); }
	if(re('alt_kategori2') != "") { $ek_link .= '&k_alt_kategori2='.re('alt_kategori2'); }
	if(re('alt_kategori3') != "") { $ek_link .= '&k_alt_kategori3='.re('alt_kategori3'); }
	if(re('alt_kategori4') != "") { $ek_link .= '&k_alt_kategori4='.re('alt_kategori4'); }
	
	
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
			
			$kategorisi = '';
			$kat_cek = mysql_query("select * from s_urunler_kategoriler where urun_id='".$urun_oku['id']."' and durum='1' ORDER BY id ASC LIMIT 1 ");
			if(mysql_num_rows($kat_cek) != 0)
			{
				$kat_oku = mysql_fetch_assoc($kat_cek);
				
				$kategori_cek = mysql_query("select * from urunler_kategoriler where id='".$kat_oku['kat_id']."' ");
				$kategori_oku = mysql_fetch_assoc($kategori_cek);
				
				$kategorisi = $kategori_oku['tanim'];
			}
			
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
			
			$anasayfa = '<a href="'.$ana_link.'&anasayfa_1='.$urun_oku['id'].'" title="Anasayfa Vitrini" class="btn mini white l_bor"> </a>';
			$yeni = '<a href="'.$ana_link.'&yeni_1='.$urun_oku['id'].'" title="Yeni Ürün" class="btn mini white l_bor"> </a>';
			$indirimli = '<a href="'.$ana_link.'&indirimli_1='.$urun_oku['id'].'" title="İndirimli Ürün" class="btn mini white l_bor"> </a>';
			
			if($urun_oku['anasayfa'] == 1) 
			{ 
				$anasayfa = '<a href="'.$ana_link.'&anasayfa_0='.$urun_oku['id'].'" title="Anasayfa Vitrini" class="btn mini blue l_bor"> </a>';
			}
			if($urun_oku['yeni'] == 1) 
			{ 
				$yeni = '<a href="'.$ana_link.'&yeni_0='.$urun_oku['id'].'" title="Yeni Ürün" class="btn mini green l_bor"> </a>';
			}
			if($urun_oku['indirimli'] == 1) 
			{ 
				$indirimli = '<a href="'.$ana_link.'&indirimli_0='.$urun_oku['id'].'" title="İndirimli Ürün" class="btn mini yellow l_bor"> </a>';
			}
			
			$dovizi_cek = mysql_query("select * from s_dovizler where id='".$urun_oku['f_doviz']."' and durum='1' ");
			$dovizi_oku = mysql_fetch_assoc($dovizi_cek);
			
			$dovizi_cek2 = mysql_query("select * from s_dovizler where id='".$urun_oku['f2_doviz']."' and durum='1' ");
			$dovizi_oku2 = mysql_fetch_assoc($dovizi_cek2);
			
			
			//#ffcece
			$arkaplan='';
			if($urun_oku['saf_stok']<=5)
			{
				$arkaplan='background-color:#ffcece;';
			}
			
			$urunler .= '<tr style="'.$arkaplan.'">
							<td>'.$sayi.'</td>
							<td>'.$urun_oku['adi'].'</td>
							<td><small>'.$kategorisi.'</small></td>
							<td>'.para($urun_oku['fiyat']).' '.$dovizi_oku['sembol'].'</td>
							<td>'.para($urun_oku['fiyat2']).' '.$dovizi_oku2['sembol'].'</td>
							<td>'.date('d.m.Y',$urun_oku['tarih']).'</td>
							<td>'.$urun_oku['stok'].' Adet</td>
							<td>'.$urun_oku['saf_stok'].' Adet</td>
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
								<a href="?modul=urunler&sayfa=urun_ekle&urun='.$urun_oku['id'].$ek_link.'" class="btn mini green"><i class="icon-search"></i> Düzenle</a>
								<a href="?modul=urunler&sayfa=urunler'.$sirasi.'&urun_sil='.$urun_oku['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a>
							</td>
						</tr>';
			
			//Stok Tazele
			/*
			$stok_toplam = 0;
			$stok_cek_a = mysql_query("select * from s_stoklar where urun_id='".$urun_oku['id']."' and durum='1' ");
			while($stok_oku_a = mysql_fetch_array($stok_cek_a))
			{
				$stok_toplam = $stok_toplam + $stok_oku_a['stok'];
			}
			
			if($stok_toplam != $urun_oku['stok'])
			{
				mysql_query("update s_urunler set stok='".$stok_toplam."' where id='".$urun_oku['id']."' ");
			}
			*/
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
	
	
	
	
	/*
	include('simpleimage.php');
	$sayisi = 0;
	$d_urun_cek = mysql_query("select * from urunler_listesi where durum='1' ");
	while($d_urun_oku = mysql_fetch_array($d_urun_cek))
	{
		$sayisi++;
	
		
		mysql_query("insert into s_urunler (kullanici_id,adi,fiyat,tarih,aciklama,e_tarihi,durum,resim) values ('".$_SESSION['kid']."','".$d_urun_oku['tanim']."','".$d_urun_oku['fiyat']."','".mktime()."','".$d_urun_oku['aciklama']."','".mktime()."','1','".$d_urun_oku['logo']."') ");
		
		$son_urun_id = mysql_insert_id();
		
		mysql_query("insert into s_sorular_veriler (kullanici_id,urun_id,durum,stok,kod,kataloglar) values ('".$_SESSION['kid']."','".$son_urun_id."','1','1','".$d_urun_oku['kodu']."','".$d_urun_oku['kategori']."') ");
		
		
		$dizim=array("iz","et","se","du","yr","nk");
		$uzanti=substr($d_urun_oku['logo'],-4,4);
		$rasgele=rand(1,1000000);
		$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
		$yeni_ad="../images/urun/".$ad;
		$yeni_ad2="../images/urun/k_".$ad;
		
		copy('../images/urunler/genel/'.$d_urun_oku['logo'],$yeni_ad);
		copy('../images/urunler/genel/'.$d_urun_oku['logo'],$yeni_ad2);
		
		$image = new SimpleImage();
		$image->load($yeni_ad);
		$image->resizeToWidth(800);
		$image->save($yeni_ad);
		
		$image = new SimpleImage();
		$image->load($yeni_ad2);
		$image->resizeToWidth(150);
		$image->save($yeni_ad2);
		
		mysql_query("insert into s_urunler_resimler (urun_id,kullanici_id,resim,resim2,e_tarihi,durum) values ('".$son_urun_id."','".$_SESSION['kid']."','".$ad."','k_".$ad."','".mktime()."','1') ");
		
	}
	
	echo "Bitti";
	
	$urun_cek = mysql_query("select * from s_urunler where durum='1' ");
	while($urun_oku = mysql_fetch_array($urun_cek))
	{
		mysql_query("insert into s_urunler_resimler (urun_id,kullanici_id,resim,resim2,e_tarihi,durum) values ('".$urun_oku['id']."','".$_SESSION['kid']."','".$urun_oku['resim']."','".$urun_oku['resim']."','".mktime()."','1') ");
	}
	*/
?>