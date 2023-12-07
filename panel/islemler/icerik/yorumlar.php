<?php 
	if(re('yorum_sil') != "")
	{
		mysql_query("update s_urunler_yorumlar set durum='0' where id='".re('yorum_sil')."' ");
		alert('Yorum Silindi..');
		if(re('sira') == "")
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=yorumlar&sira=1">';
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=yorumlar&sira='.re('sira').'">';
		}
	}
	
	if(re('onayla') != "")
	{
		mysql_query("update s_urunler_yorumlar set durum='1' where id='".re('onayla')."' ");
		alert('Yorum Onaylandı..');
		if(re('sira') == "")
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=yorumlar&sira=1">';
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=yorumlar&sira='.re('sira').'">';
		}
	}
	
	if(re('onaylama') != "")
	{
		mysql_query("update s_urunler_yorumlar set durum='2' where id='".re('onaylama')."' ");
		alert('Yorum Onayı Geri Alındı..');
		if(re('sira') == "")
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=yorumlar&sira=1">';
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=yorumlar&sira='.re('sira').'">';
		}
	}

	$kosul = '';
	$listeleme_kurali = 'ORDER BY e_tarihi ASC, id ASC';
	
	$sayfada = 20; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	 
	$say = mysql_num_rows(mysql_query("select * from s_urunler_yorumlar where durum!='0' ".$kosul." ".$listeleme_kurali));
	 
	$toplam_sayfa = ceil($say / $sayfada);
	

	$sayfa = isset($_GET['sira']) ? (int) $_GET['sira'] : 1;
	 
	if($sayfa < 1) $sayfa = 1; 
	if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
	$limit = ($sayfa - 1) * $sayfada;
	$limit = ' LIMIT '.$limit;
	
	
	
	$sayi = 0;
	$yorumlar = '';
	$yorum_cek = mysql_query("select * from s_urunler_yorumlar where durum!='0' ".$kosul." ".$listeleme_kurali." ".$limit.', '.$sayfada);
	while($yorum_oku = mysql_fetch_array($yorum_cek))
	{
		$sayi++;
		$sirasi = '&sira=1';
		if(re('sira') != "")
		{
			$sirasi = '&sira='.re('sira');
		}
		
		$kullanici_cek = mysql_query("select * from kullanicilar where id='".$yorum_oku['kullanici_id']."' ");
		$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
		
		$durumu = '';
		if($yorum_oku['durum'] == 2)
		{
			$durumu = '<a href="?modul=icerik&sayfa=yorumlar'.$sirasi.'&onayla='.$yorum_oku['id'].'" class="btn mini green"><i class=" icon-unlock"></i> Onayla</a>';
		}
		if($yorum_oku['durum'] == 1)
		{
			$durumu = '<a href="?modul=icerik&sayfa=yorumlar'.$sirasi.'&onaylama='.$yorum_oku['id'].'" class="btn mini blue"><i class=" icon-lock"></i> Onaylama</a>';
		}
		
		$yorumlar .= '<tr style="font-size:13px;">
						<td>'.$sayi.'</td>
						<td>'.$kullanici_oku['adi'].' '.$kullanici_oku['soyadi'].'</td>
						<td>'.$yorum_oku['ip'].'</td>
						<td>'.$yorum_oku['baslik'].'</td>
						<td><a href="?modul=urunler&sayfa=urun_ekle&urun='.$yorum_oku['urun_id'].'">'.$yorum_oku['urun_id'].'</a></td>
						<td>'.$yorum_oku['yorum'].'</td>
						<td>'.$yorum_oku['puanlama'].'</td>
						<td>'.date('d.m.Y H:i:s',$yorum_oku['e_tarihi']).'</td>
						<td>'.$durumu.'</td>
						<td>
							<a href="?modul=urunler&sayfa=urun_ekle&urun='.$yorum_oku['urun_id'].'" class="btn mini green"><i class="icon-search"></i> Ürünü Görüntüle</a>
							<a href="?modul=icerik&sayfa=yorumlar'.$sirasi.'&yorum_sil='.$yorum_oku['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a>
						</td>
					</tr>';
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