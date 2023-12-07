<?php 
	if(re('kullanici_sil') != "")
	{
		mysql_query("update kullanicilar set durum='0',s_tarihi='".mktime()."' where id='".re('kullanici_sil')."' ");
		alert('Kullanıcı Silindi..');
		if(re('sira') == "")
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=kullanicilar&sayfa=tum_kullanicilar&sira=1">';
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=kullanicilar&sayfa=tum_kullanicilar&sira='.re('sira').'">';
		}
	}

	$kosul = 'and yetki="9"';
	$listeleme_kurali = 'ORDER BY e_tarihi ASC, id ASC';
	
	$sayfada = 20; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	 
	$say = mysql_num_rows(mysql_query("select * from kullanicilar where durum='1' ".$kosul." ".$listeleme_kurali));
	 
	$toplam_sayfa = ceil($say / $sayfada);
	

	$sayfa = isset($_GET['sira']) ? (int) $_GET['sira'] : 1;
	 
	if($sayfa < 1) $sayfa = 1; 
	if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
	$limit = ($sayfa - 1) * $sayfada;
	$limit = ' LIMIT '.$limit;
	
	
	$sayi = 0;
	$kullanicilar = '';
	$kullanici_cek = mysql_query("select * from kullanicilar where durum='1' ".$kosul." ".$listeleme_kurali." ".$limit.', '.$sayfada);
	while($kullanici_oku = mysql_fetch_array($kullanici_cek))
	{
		$sayi++;
		$sirasi = '&sira=1';
		if(re('sira') != "")
		{
			$sirasi = '&sira='.re('sira');
		}
		
		$grup_cek = mysql_query("select * from kullanicilar_grup where id='".$kullanici_oku['grup']."' ");
		$grup_oku = mysql_fetch_assoc($grup_cek);
		
		$kullanicilar .= '<tr style="font-size:14px;">
						<td>'.$sayi.'</td>
						<td>'.$kullanici_oku['kullanici_adi'].'</td>
						<td>'.$kullanici_oku['adi'].'</td>
						<td>'.$kullanici_oku['soyadi'].'</td>
						<td>'.$grup_oku['adi'].'</td>
						<td>'.$kullanici_oku['email'].'</td>
						<td>'.$kullanici_oku['tel'].'</td>
						<td>'.date('d.m.Y H:i:s',$kullanici_oku['son_giris']).'</td>
						<td>
							<a href="?modul=kullanicilar&sayfa=yeni_kullanici_ekle'.$sirasi.'&kullanici='.$kullanici_oku['id'].'" class="btn mini green"><i class="icon-search"></i> Görüntüle</a>
							<a href="?modul='.re('modul').'&sayfa='.re('sayfa').''.$sirasi.'&kullanici_sil='.$kullanici_oku['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a>
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