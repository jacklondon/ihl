<?php 

	$olay_say=0;
	$olay_listesi='';
	$olay_sor=mysql_query("select * from server where durum>'60' order by id");
	while ($olay_cek=mysql_fetch_array($olay_sor))
	{
		$olay_say++;
		$cubuk='';
		if ( $olay_cek['durum'] <= 75 ) { $cubuk='progress-success'; }
		if ( $olay_cek['durum'] > 75 &&   $olay_cek['durum'] <= 85 ) { $cubuk='progress-success'; }
		if ( $olay_cek['durum'] > 85 &&   $olay_cek['durum'] <= 90 ) { $cubuk='progress-warning'; }
		if ( $olay_cek['durum'] > 90 &&   $olay_cek['durum'] <= 100 ) { $cubuk='progress-warning progress-striped active'; }
		$olay_listesi.='<li>
								<a href="#">
								<span class="task">
								<span class="desc">'.$olay_cek['aciklama'].'</span>
								<span class="percent">'.$olay_cek['durum'].'%</span>
								</span>
								<span class="progress '.$cubuk.'">
								<span style="width: '.$olay_cek['durum'].'%;" class="bar"></span>
								</span>
								</a>
							</li>';
	}
	
	if ( $olay_say == 0 )
	{
		$genel_olay_cumle='Sunucu ile kritik olay bulunmamaktadır.';
		$olay_isaret='';
	}
	else
	{
		$genel_olay_cumle='Sunucu ile ilgili '.$olay_say.' olay';
		$olay_isaret='<span class="badge">'.$olay_say.'</span>';
	}
	
	$server_durum='<li class="dropdown" id="header_task_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-tasks"></i>
						'.$olay_isaret.'
						</a>
						<ul class="dropdown-menu extended tasks">
							<li>
								<p>'.$genel_olay_cumle.'</p>
							</li>
							'.$olay_listesi.'
							<li class="external">
								<a href="#">Diğer olaylar için tıklayınız <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>';
					
	
	$mesaj_say=0;
	$mesaj_listesi='';
	$mesaj_sor=mysql_query("select * from mesajlar where durum='1' and o_tarihi='' and giden_gelen='0' ORDER BY e_tarihi DESC, id DESC ");
	while($mesaj_cek=mysql_fetch_array($mesaj_sor))
	{
		/*
		$karsi_kullanici_sor=mysql_query("select * from lisanslar_uyeler where id='".$mesaj_cek['kullanici']."'");
		$karsi_kullanici_cek=mysql_fetch_assoc($karsi_kullanici_sor);
		
		$mesaj_say++;
		$mesaj_bas='';
		$teslim_bilgisi=date('d.m.Y H:i:s',$mesaj_cek['tarih']);
		$sny_bul=time()- $mesaj_cek['tarih'];
		if ( $sny_bul < 3600 )
		{
			$sure=$sny_bul/60;
			$teslim_bilgisi=$sure.' Dk.';
		}
		
		if ( $sny_bul == 3600 )
		{
			$teslim_bilgisi=$sure.' Saat.';
		}
		
		if ( $sny_bul > 3600 && $sny_bul < 7200 )
		{
			$teslim_bilgisi=$sure.' Saat/dk.';
		}
		
		if (strlen($mesaj_cek['mesaj']<=62)) 
		{ 
			for ($i=0; $i<62; $i++)
			{
				$mesaj_bas.=$mesaj_cek['mesaj'][$i];
			}
		}
		else 
		{$mesaj_bas=$mesaj_cek['mesaj']; }
		*/
		
		$adi_soyadi = $mesaj_cek['adi_soyadi'];
		if($mesaj_cek['kullanici_id'] != 0)
		{
			$kullanicisini_cek = mysql_query("select * from kullanicilar where id='".$mesaj_cek['kullanici_id']."' ");
			$kullanicisini_oku = mysql_fetch_assoc($kullanicisini_cek);
			
			$adi_soyadi = $kullanicisini_oku['adi'].' '.$kullanicisini_oku['soyadi'];
		}
		
		$mesaj_say++;
		$mesaj_listesi.='<li>
								<a href="?modul=istatistikler&sayfa=mesajlar_gor&sira=1&mesaj='.$mesaj_cek['id'].'">
								<span class="subject">
								<span class="from">'.$adi_soyadi.'</span>
								<span class="time">'.date('d.m.Y H:i:s',$mesaj_cek['e_tarihi']).'</span>
								</span>
								<span class="message">
								'.$mesaj_cek['konu'].'
								</span>  
								</a>
							</li>';
	}
	
	if ( $mesaj_say == 0 )
	{
		$genel_mesaj_cumle='Hiç yeni mesajınız yok.';
		$mesaj_isaret='';
	}
	else
	{
		$genel_mesaj_cumle=$mesaj_say.' Yeni mesajınız var';
		$mesaj_isaret='<span class="badge">'.$mesaj_say.'</span>';
	}
	
	
	$mesaj_durum='<li class="dropdown" id="header_inbox_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-envelope-alt"></i>
						'.$mesaj_isaret.'
						</a>
						<ul class="dropdown-menu extended inbox">
							<li>
								<p>'.$genel_mesaj_cumle.'</p>
							</li>
							'.$mesaj_listesi.'
							<li class="external">
								<a href="?modul=istatistikler&sayfa=mesajlar">Tüm mesajlar için tıklayınız <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					';
	/*		
	$bildirim__say=0;
	$bildirim__listesi='';
	$bildirim__sor=mysql_query("select * from bildirimler where durum='1' && alici='".$_SESSION['kid']."' order by tarih DESC");
	while ($bildirim__cek=mysql_fetch_array($bildirim__sor))
	{
		$karsi_kullanici_sor=mysql_query("select * from lisanslar_uyeler where id='".$bildirim__cek['kullanici']."'");
		$karsi_kullanici_cek=mysql_fetch_assoc($karsi_kullanici_sor);
		
		$bildirim__say++;
		$bildirim__bas='';
		$teslim_bilgisi=date('d.m.Y H:i:s',$bildirim__cek['tarih']);
		$sny_bul=time()- $bildirim__cek['tarih'];
		if ( $sny_bul < 3600 )
		{
			$sure=$sny_bul/60;
			$teslim_bilgisi=$sure.' Dk.';
		}
		
		if ( $sny_bul == 3600 )
		{
			$teslim_bilgisi=$sure.' Saat.';
		}
		
		if ( $sny_bul > 3600 && $sny_bul < 7200 )
		{
			$teslim_bilgisi=$sure.' Saat/dk.';
		}
		
		if (strlen($bildirim__cek['mesaj']<=62)) 
		{ 
			for ($i=0; $i<62; $i++)
			{
				$bildirim__bas.=$bildirim__cek['mesaj'][$i];
			}
		} else {$bildirim__bas=$bildirim__cek['mesaj']; }
		$bildirim__listesi.='<li>
								<a href="#">
								<span class="photo"><img src="'.$karsi_kullanici_cek['resim'].'" alt="" style="width:45px; height:45px;" /></span>
								<span class="subject">
								<span class="from">'.$bildirim__cek['kullanici_adi'].'</span>
								<span class="time">'.$teslim_bilgisi.'</span>
								</span>
								<span class="message">
								'.$bildirim__bas.'
								</span>  
								</a>
							</li>';
	}
	
	if ( $bildirim__say == 0 )
	{
		$genel_bildirim__cumle='Hiç yeni bildirim yok.';
		$bildirim__isaret='';
	}
	else
	{
		$genel_bildirim__cumle=$bildirim__say.' Yeni bildirim var';
		$bildirim__isaret='<span class="badge">'.$bildirim__say.'</span>';
	}
	
	*/
	

	
	$basvurulari_bu = '';
	$bayi_bas_sayisi = 0;
	$bayi_basvuru_cek = mysql_query("select * from kullanicilar where durum='1' and bayi='1' and grup='2' and g_tarihi='' ORDER BY e_tarihi DESC ");
	while($bayi_basvuru_oku = mysql_fetch_array($bayi_basvuru_cek))
	{
		$bayi_bas_sayisi++;
		$basvurulari_bu .= '<li>
								<a href="?modul=kullanicilar&sayfa=yeni_kullanici_ekle&sira=1&kullanici='.$bayi_basvuru_oku['id'].'" onclick="App.onNotificationClick(1)">
								<span class="label label-success"><i class="icon-plus"></i></span>
								'.$bayi_basvuru_oku['adi'].' '.$bayi_basvuru_oku['soyadi'].'
								<span class="time" style="display:none;">Just now</span>
								</a>
							</li>';
	}
	
	$uyarisi = '';
	$uyari_mesaji = '';
	if($bayi_bas_sayisi == 0)
	{
		$uyarisi = '';
		$uyari_mesaji = '';
	}
	else
	{
		$uyarisi = '<span class="badge">'.$bayi_bas_sayisi.'</span>';
		$uyari_mesaji = '<li>
							<p>'.$bayi_bas_sayisi.' Yeni Bayi Başvurunuz var</p>
						</li>';
	}
	
	$sip_say = 0;
	$a_siparisleri_cek = mysql_query("select * from s_sepet where durum='2' and sip_durum='1' ORDER BY sip_tarihi DESC, e_tarihi DESC, id DESC ");
	while($a_siparisleri_oku = mysql_fetch_array($a_siparisleri_cek))
	{
		$sip_say++;
		$basvurulari_bu .= '<li>
								<a href="?modul=siparisler&sayfa=siparis_detay&sira=1&siparis='.$a_siparisleri_oku['id'].'" onclick="App.onNotificationClick(1)">
								<span class="label label-success"><i class="icon-plus"></i></span>
								'.$a_siparisleri_oku['adi'].' '.$a_siparisleri_oku['soyadi'].'
								<span class="time" style="display:none;">Just now</span>
								</a>
							</li>';
	}
	
	if($sip_say != 0)
	{
		$uyarisi = '<span class="badge">'.$sip_say.'</span>';
		$uyari_mesaji = '<li>
							<p>'.$sip_say.' Yeni Siparişiniz Var</p>
						</li>';
	}
	
	
	$bildirim_durum='<li class="dropdown" id="header_notification_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-warning-sign"></i>
						'.$uyarisi.'
						</a>
						<ul class="dropdown-menu extended notification">
							'.$uyari_mesaji.'
							'.$basvurulari_bu.'
						</ul>
					</li>
					';
					
	$tahsil_sayi = 0;
	$tahsil_tutar = 0;
	$kasayi_cek = mysql_query("select * from kasa where durum='1' ORDER BY e_tarihi DESC ");
	while($kasayi_oku = mysql_fetch_array($kasayi_cek))
	{
		$tahsil_sayi++;
		$tahsil_tutar = $tahsil_tutar + $kasayi_oku['fiyat'];
	}
	
	
	
	$tum_ziyaretciler = '';
	$toplam_ziyaretci = 0;
	$toplam_tik = 0;
	$ziyaretcileri_cek = mysql_query("select * from i_ziyaretciler where durum='1' ORDER BY e_tarihi DESC ");
	while($ziyaretcileri_oku = mysql_fetch_array($ziyaretcileri_cek))
	{
		$toplam_ziyaretci++;
		$toplam_tik = $toplam_tik + $ziyaretcileri_oku['sayi'];
		
		$adi_soyadi = '';
		if($ziyaretcileri_oku['kullanici_id'] != 0)
		{
			$kullanicimizi_cek = mysql_query("select * from kullanicilar where id='".$ziyaretcileri_oku['kullanici_id']."' ");
			$kullanicimizi_oku = mysql_fetch_assoc($kullanicimizi_cek);
			
			$adi_soyadi = $kullanicimizi_oku['adi'].' '.$kullanicimizi_oku['soyadi'];
		}
		
		$tum_ziyaretciler .= '<tr style="font-size:14px;">
								<td>'.$toplam_ziyaretci.'</td>
								<td>'.$ziyaretcileri_oku['ip'].'</td>
								<td>'.$adi_soyadi.'</td>
								<td>'.$ziyaretcileri_oku['sayi'].'</td>
								<td>'.date('d.m.Y H:i:s',$ziyaretcileri_oku['e_tarihi']).'</td>
								<td>'.date('d.m.Y H:i:s',$ziyaretcileri_oku['g_tarihi']).'</td>
							</tr>';
	}
	
	$tum_siparisler = '';
	$toplam_siparis = 0;
	$t_siparisleri_cek = mysql_query("select * from s_sepet where durum='2' ORDER BY sip_tarihi DESC, e_tarihi DESC, id DESC ");
	while($t_siparisleri_oku = mysql_fetch_array($t_siparisleri_cek))
	{
		$toplam_siparis++;
		$tum_siparisler .= '';
	}
	
	$toplam_mesaj_sayisi = mysql_num_rows(mysql_query("select * from mesajlar where durum='1' and giden_gelen='0' ORDER BY e_tarihi DESC, id DESC "));
	
	$basilan_sip_sayisi = 0;
	$uye_siparisler_listesi = '';
	$toplam_kullanici_sayisi = 0;
	$tum_kullanicilari_cek = mysql_query("select * from kullanicilar where durum='1' and yetki='1' ORDER BY e_tarihi DESC, id DESC ");
	while($tum_kullanicilari_oku = mysql_fetch_array($tum_kullanicilari_cek))
	{
		$toplam_kullanici_sayisi++;
		
		$sip_bas = false;
		
		$siparisini_say = 0;
		$siparisini_cek2 = mysql_query("select * from s_sepet where durum='2' and kullanici_id='".$tum_kullanicilari_oku['id']."' ORDER BY sip_tarihi DESC, e_tarihi DESC, id DESC ");
		while($siparisini_oku2 = mysql_fetch_array($siparisini_cek2))
		{
			$siparisini_say++;
		}
		if($siparisini_say != 0) { $sip_bas = true; }
		
		if($sip_bas == true)
		{	
			$basilan_sip_sayisi++;
			$adi_soyadi = '<a href="?modul=kullanicilar&sayfa=yeni_kullanici_ekle&sira=1&kullanici='.$tum_kullanicilari_oku['id'].'">'.$tum_kullanicilari_oku['adi'].' '.$tum_kullanicilari_oku['soyadi'].'</a>';
			$uye_siparisler_listesi .= '<tr style="font-size:14px;">
								<td>'.$basilan_sip_sayisi.'</td>
								<td>'.$adi_soyadi.'</td>
								<td>'.$siparisini_say.'</td>
							</tr>';
		}
	}
	
	
	
	
	
	$tum_urun_ziyaretciler = '';
	$toplam_urun_ziyaretci = 0;
	$toplam_urun_tik = 0;
	$urun_ziyaret_cek = mysql_query("select * from i_ziyaretciler_urun where durum='1' ORDER BY e_tarihi DESC ");
	while($urun_ziyaret_oku = mysql_fetch_array($urun_ziyaret_cek))
	{
		$toplam_urun_ziyaretci++;
		$toplam_urun_tik = $toplam_urun_tik + $urun_ziyaret_oku['sayi'];
		
		$adi_soyadi = '';
		if($urun_ziyaret_oku['kullanici_id'] != 0)
		{
			$kullanicimizi_cek = mysql_query("select * from kullanicilar where id='".$urun_ziyaret_oku['kullanici_id']."' ");
			$kullanicimizi_oku = mysql_fetch_assoc($kullanicimizi_cek);
			
			$adi_soyadi = $kullanicimizi_oku['adi'].' '.$kullanicimizi_oku['soyadi'];
		}
		
		$urunum_cek = mysql_query("select * from s_urunler where id='".$urun_ziyaret_oku['urun_id']."' ");
		$urunum_oku = mysql_fetch_assoc($urunum_cek);
		
		$urunumuz = '<a href="?modul=urunler&sayfa=urun_ekle&urun='.$urun_ziyaret_oku['urun_id'].'">'.$urunum_oku['adi'].'</a>';
		
		$tum_urun_ziyaretciler .= '<tr style="font-size:14px;">
								<td>'.$toplam_urun_ziyaretci.'</td>
								<td>'.$urunumuz.'</td>
								<td>'.$urun_ziyaret_oku['ip'].'</td>
								<td>'.$adi_soyadi.'</td>
								<td>'.$urun_ziyaret_oku['sayi'].'</td>
								<td>'.date('d.m.Y H:i:s',$urun_ziyaret_oku['e_tarihi']).'</td>
								<td>'.date('d.m.Y H:i:s',$urun_ziyaret_oku['g_tarihi']).'</td>
							</tr>';
	}
	
	$toplam_satilan_urun_sayisi = 0;
	$urun_siparis_cek2 = mysql_query("select * from s_sepet where durum='2' ORDER BY sip_tarihi DESC, e_tarihi DESC, id DESC ");
	while($urun_siparis_oku2 = mysql_fetch_array($urun_siparis_cek2))
	{
		$siparisin_urunlerini_cek2 = mysql_query("select * from s_sepet_urunler where sepet_id='".$urun_siparis_oku2['id']."' and durum='1' ORDER BY e_tarihi DESC ");
		while($siparisin_urunlerini_oku2 = mysql_fetch_array($siparisin_urunlerini_cek2))
		{
			$toplam_satilan_urun_sayisi = $toplam_satilan_urun_sayisi + $siparisin_urunlerini_oku2['adet'];
		}
	}
	
	$urun_liste_sayisi = 0;
	$urun_siparisler_listesi = '';
	$tum_urun_sayisi = 0;
	$tum_urun_ziyaretciler_liste = '';
	$tum_urun_ziyaretcilerini_cek = mysql_query("select * from s_urunler where durum='1' ORDER BY e_tarihi DESC ");
	while($tum_urun_ziyaretcilerini_oku = mysql_fetch_array($tum_urun_ziyaretcilerini_cek))
	{
		$bassan = true;
		$siparis_bas = false;
		
		$urunumuz = '<a href="?modul=urunler&sayfa=urun_ekle&urun='.$tum_urun_ziyaretcilerini_oku['id'].'">'.$tum_urun_ziyaretcilerini_oku['adi'].'</a>';
		
		$toplam_urun_siparis_sayisi = 0;
		$urun_siparis_cek = mysql_query("select * from s_sepet where durum='2' ORDER BY sip_tarihi DESC, e_tarihi DESC, id DESC ");
		while($urun_siparis_oku = mysql_fetch_array($urun_siparis_cek))
		{
			$siparisin_urunlerini_cek = mysql_query("select * from s_sepet_urunler where sepet_id='".$urun_siparis_oku['id']."' and durum='1' ORDER BY e_tarihi DESC ");
			while($siparisin_urunlerini_oku = mysql_fetch_array($siparisin_urunlerini_cek))
			{
				if($tum_urun_ziyaretcilerini_oku['id'] == $siparisin_urunlerini_oku['urun_id'])
				{
					$toplam_urun_siparis_sayisi = $toplam_urun_siparis_sayisi + $siparisin_urunlerini_oku['adet'];
					$siparis_bas = true;
				}
			}
		}
		
		if($siparis_bas == true)
		{
			$urun_liste_sayisi++;
			$urun_siparisler_listesi .= '<tr style="font-size:14px;">
								<td>'.$urun_liste_sayisi.'</td>
								<td>'.$urunumuz.'</td>
								<td>'.$toplam_urun_siparis_sayisi.'</td>
							</tr>';
		}
		
		$ilk_giris_tarihi = 0;
		$son_giris_tarihi = 0;
		
		$toplam_giris_sayisi = 0;
		$son_ipsi = '';
		$ziyaretciler_toplam = 0;
		$ziyaret_cek2 = mysql_query("select * from i_ziyaretciler_urun where urun_id='".$tum_urun_ziyaretcilerini_oku['id']."' and durum='1' ORDER BY e_tarihi DESC ");
		while($ziyaret_oku2 = mysql_fetch_array($ziyaret_cek2))
		{
			$ziyaretciler_toplam++;
			$son_ipsi = $ziyaret_oku2['ip'];
			$toplam_giris_sayisi = $toplam_giris_sayisi + $ziyaret_oku2['sayi'];
			
			if($ziyaretciler_toplam == 1)
			{
				$ilk_giris_tarihi = $ziyaret_oku2['e_tarihi'];
				$son_giris_tarihi = $ziyaret_oku2['g_tarihi'];
			}
			
			if($ziyaret_oku2['e_tarihi'] < $ilk_giris_tarihi)
			{
				$ilk_giris_tarihi = $ziyaret_oku2['e_tarihi'];
			}
			
			if($ziyaret_oku2['g_tarihi'] > $son_giris_tarihi)
			{
				$son_giris_tarihi = $ziyaret_oku2['g_tarihi'];
			}
		}
		
		if($ziyaretciler_toplam == 0) { $bassan = false; }
		
		if($bassan == true)
		{
			$tum_urun_sayisi++;
			$tum_urun_ziyaretciler_liste .= '<tr style="font-size:14px;">
								<td>'.$tum_urun_sayisi.'</td>
								<td>'.$urunumuz.'</td>
								<td>'.$son_ipsi.'</td>
								<td>'.$toplam_giris_sayisi.'</td>
								<td>'.date('d.m.Y H:i:s',$ilk_giris_tarihi).'</td>
								<td>'.date('d.m.Y H:i:s',$son_giris_tarihi).'</td>
							</tr>';
		}
	}
	
	
	
	if(re('islem_r') == "depo_resim")
	{
		if($_FILES['resim_depo']['name'] != "")
		{
			include('simpleimage.php');
			
			$dosya_sayi=count($_FILES['resim_depo']['name']);
			for($i=0;$i<$dosya_sayi;$i++)
			{
				if(!empty($_FILES['resim_depo']['name'][$i]))
				{
					$dosya_adi=$_FILES["resim_depo"]["name"][$i];
					$dizim=array("iz","et","se","du","yr","nk");
					$uzanti=substr($dosya_adi,-4,4);
				
					$rasgele=rand(1,10000000000);
					$ad=$dizim[rand(0,5)].$rasgele.$dizim[rand(0,5)].$uzanti;
					$yeni_ad="../images/resimler/".$ad;
					move_uploaded_file($_FILES["resim_depo"]['tmp_name'][$i],$yeni_ad);
					
					$k_ad = "../images/resimler/k_".$ad;
					copy($yeni_ad,$k_ad);
					
					$image = new SimpleImage();
					$image->load($k_ad);
					$image->resizeToWidth(250);
					$image->save($k_ad);
					
					mysql_query("insert into resim_depo (resim,resim2,e_tarihi,durum) values ('".$ad."','k_".$ad."','".mktime()."','1') ");
				}
			}
			alert("Resimler Yüklendi..");
		}
	}
	
	if(re('g_resim_sil') != "")
	{
		$resimi_cek = mysql_query("select * from resim_depo where id='".re('g_resim_sil')."' and durum='1' ");
		$resimi_oku = mysql_fetch_assoc($resimi_cek);
		
		unlink('../images/resimler/'.$resimi_oku['resim']);
		unlink('../images/resimler/'.$resimi_oku['resim2']);
		mysql_query("update resim_depo set durum='0',s_tarihi='".mktime()."' where id='".re('g_resim_sil')."' ");
	}
	
	$tum_resimler = '';
	$resim_sayi = 0;
	$resim_depo_cek = mysql_query("select * from resim_depo where durum='1' ORDER BY e_tarihi DESC, id DESC ");
	while($resim_depo_oku = mysql_fetch_array($resim_depo_cek))
	{
		$resim_sayi++;
		$tum_resimler .= '<div class="resim_ustu_disi" ><img src="../images/resimler/'.$resim_depo_oku['resim2'].'" class="ust_resim_img" onclick="depo_resim_tik(\''.$resim_depo_oku['resim'].'\');" />
			<a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&g_resim_sil='.$resim_depo_oku['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn red" style="position:relative; background-color:#A32618; height:6px !important; float:left; width:8px !important; margin-top:-26px;"><i class="icon-trash" ></i></a>
			</div>';
	}
	
	
	
	
	$resim_deposu='<li class="dropdown" id="header_task_bar">
						<a href="#" class="dropdown-toggle" style="height:20px;" onclick="depo_islem();">
						<i class="resim_depo_icon" style="margin-top:-3px;"></i>
						</a>
						<ul class="dropdown-menu extended" id="depo_acilan">
							<li>
								<p>
									'.$resim_sayi.' Resim Bulunmaktadır
								</p>
								<div style="float:right; width:32px; height:32px; margin-top:-36px; position:relative; margin-right:5px; cursor:pointer;">
									<input type="file" name="resim_depo[]" id="resim_depo" multiple="multiple" class="foto_sec" onchange="resim_secildi();">
									<img src="images/upload.png" />
									<div id="up_konum"></div>
								</div>
							</li>
							<li class="tum_resimler_disi">
								'.$tum_resimler.'
							</li>
							<li class="external" style="display:none;">
								<a href="#">Tüm Resimler için tıklayınız <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>';
	
	
	
	
?>