﻿<?php 
	if(re('mesaj_sil') != "")
	{
		mysql_query("DELETE FROM bilgilendirme_mail WHERE id='".re('mesaj_sil')."'");
		alert('Mesaj Silindi..');
		if(re('sira') == "")
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=istatistikler&sayfa=musteri_mail">';
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=istatistikler&sayfa=musteri_mail">';
		}
	}

	$kosul = ' and giden_gelen="0"';
	$listeleme_kurali = 'ORDER BY e_tarihi DESC, id DESC';
	
	$sayfada = 20; // sayfada gösterilecek içerik miktarını belirtiyoruz.
	 
	$say = mysql_num_rows(mysql_query("select * from mesajlar where durum!='0' ".$kosul." ".$listeleme_kurali));
	 
	$toplam_sayfa = ceil($say / $sayfada);
	

	$sayfa = isset($_GET['sira']) ? (int) $_GET['sira'] : 1;
	 
	if($sayfa < 1) $sayfa = 1; 
	if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 
	$limit = ($sayfa - 1) * $sayfada;
	$limit = ' LIMIT '.$limit;
	
	
	$sayi = 0;
	$mesajlar = '';
	$mesaj_cek = mysql_query("select * from bilgilendirme_mail");
	while($mesaj_oku = mysql_fetch_array($mesaj_cek))
	{
		$sayi++;
		$sirasi = '&sira=1';
		if(re('sira') != "")
		{
			$sirasi = '&sira='.re('sira');
		}
	
		$mesajlar .= '<tr style="font-size:14px;">
						<td>'.$sayi.'</td>
						<td>'.$mesaj_oku['mail'].'</td>
						<td>'.date('d.m.Y H:i:s',$mesaj_oku['tarih']).'</td>
						<td>
							<a href="?modul=istatistikler&sayfa=bilgilendirme_gor&mesaj='.$mesaj_oku['id'].'" class="btn mini green"><i class="icon-search"></i> Görüntüle</a>
							<a href="?modul='.re('modul').'&sayfa='.re('sayfa').''.$sirasi.'&mesaj_sil='.$mesaj_oku['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a>
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