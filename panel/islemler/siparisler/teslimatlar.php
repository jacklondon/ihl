<?php 
	if(re('siparis_sil') != "")
	{
		mysql_query("update s_sepet set durum='0',s_tarihi='".mktime()."' where id='".re('siparis_sil')."' ");
		alert('Sipariş Silindi..');
		if(re('sira') == "")
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=siparisler&sayfa=teslimatlar&sira=1">';
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=siparisler&sayfa=teslimatlar&sira='.re('sira').'">';
		}
	}

	$kosul = 'and sip_durum="5"';
	$listeleme_kurali = 'ORDER BY sip_durum ASC, id ASC';
	
	$sayfada = 20; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	 
	$say = mysql_num_rows(mysql_query("select * from s_sepet where durum='2' ".$kosul." ".$listeleme_kurali));
	 
	$toplam_sayfa = ceil($say / $sayfada);
	

	$sayfa = isset($_GET['sira']) ? (int) $_GET['sira'] : 1;
	 
	if($sayfa < 1) $sayfa = 1; 
	if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
	$limit = ($sayfa - 1) * $sayfada;
	$limit = ' LIMIT '.$limit;
	
	
	
	$sayi = 0;
	$siparisler = '';
	$siparis_cek = mysql_query("select * from s_sepet where durum='2' ".$kosul." ".$listeleme_kurali." ".$limit.', '.$sayfada);
	while($siparis_oku = mysql_fetch_array($siparis_cek))
	{
		$sayi++;
		$sirasi = '&sira=1';
		if(re('sira') != "")
		{
			$sirasi = '&sira='.re('sira');
		}
		
		$kullanici = '';
		if($siparis_oku['kullanici_id'] != "" or $siparis_oku['kullanici_id'] != 0)
		{
			$kullanici_cek = mysql_query("select * from kullanicilar where id='".$siparis_oku['kullanici_id']."' ");
			$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
			
			$kullanici = $kullanici_oku['adi'].' '.$kullanici_oku['soyadi'];
		}
		else
		{
			$kullanici = $siparis_oku['ip'];
		}
		
		$odeme_tur_cek = mysql_query("select * from s_odeme_tur where id='".$siparis_oku['odeme_tur']."' ");
		$odeme_tur_oku = mysql_fetch_assoc($odeme_tur_cek);
		
		$sip_durum_cek = mysql_query("select * from s_siparis_durum where id='".$siparis_oku['sip_durum']."' ");
		$sip_durum_oku = mysql_fetch_assoc($sip_durum_cek);
		
		$hediye = 'Hayır';
		if($siparis_oku['hediye'] == 1)
		{
			$hediye = 'Evet';
		}
		
		$siparisler .= '<tr style="font-size:14px;">
						<td>'.$sayi.'</td>
						<td>'.$kullanici.'</td>
						<td>'.$odeme_tur_oku['adi'].'</td>
						<td>'.$siparis_oku['siparis_no'].'</td>
						<td>'.$sip_durum_oku['adi'].'</td>
						<td>'.$hediye.'</td>
						<td>'.date('d.m.Y H:i:s',$siparis_oku['sip_tarihi']).'</td>
						<td>'.para($siparis_oku['genel_toplam']).' '.$doviz.'</td>
						<td>
							<a href="?modul=siparisler&sayfa=siparis_detay'.$sirasi.'&siparis='.$siparis_oku['id'].'" class="btn mini green"><i class="icon-search"></i> Görüntüle</a>
							<a href="?modul='.re('modul').'&sayfa='.re('sayfa').''.$sirasi.'&siparis_sil='.$siparis_oku['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a>
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