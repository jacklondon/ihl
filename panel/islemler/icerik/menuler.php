<?php 
	if(re('m_tip') == "" or re('m_tip') == 0)
	{
		if ( re('islem') == "ac_kapa" )
		{
			mysql_query("update m_menu_tip set durum='".re('durum')."' where id='".re('tip_id')."'");
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=menuler">';
		}
		
		if(re('m_tip_sil') != "")
		{
			mysql_query("update m_menu_tip set durum='0', s_tarihi='".mktime()."' where id='".re('m_tip_sil')."' ");
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=menuler">';
		}
		
		if ( re('islem') == "KAYDET" )
		{
			$listeyi_sor=mysql_query("select * from m_menu_tip where durum!='0' ORDER BY e_tarihi ASC, id ASC ");
			while($listeyi_cek=mysql_fetch_array($listeyi_sor))
			{
				mysql_query("update m_menu_tip set adi='".re('menu_adi_'.$listeyi_cek['id'])."' where id='".$listeyi_cek['id']."' ");
			}
			
			if ( re('yeni_menu_adi') != "" )
			{
				mysql_query("insert into m_menu_tip (
				id,
				adi,
				e_tarihi,
				durum
				)values(
				null,
				'".re('yeni_menu_adi')."',
				'".mktime()."',
				'1')");
			}
		}



		$sayi=0;
		$liste='';
		$listeyi_sor=mysql_query("select * from m_menu_tip where durum!='0' ORDER BY e_tarihi ASC, id ASC ");
		while($listeyi_cek=mysql_fetch_array($listeyi_sor))
		{
			if( $listeyi_cek['durum'] == 1 ) 
			{ 
				$acik_kapali='<a href="?modul=icerik&sayfa=menuler&islem=ac_kapa&durum=2&tip_id='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız." class="btn mini red"><i class="icon-unlock"></i> Kapat</a>'; 
			}
			if( $listeyi_cek['durum'] == 2 )
			{ 
				$acik_kapali='<a href="?modul=icerik&sayfa=menuler&islem=ac_kapa&durum=1&tip_id='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." class="btn mini green"><i class="icon-lock"></i> Aç</a>';
			}
			
			$sayi++;
			$liste.='<tr>
							<td>'.$sayi.'</td>
							<td><input type="text" name="menu_adi_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['adi'].'" ></td>
							<td>
								'.$acik_kapali.'
								<a href="?modul=icerik&sayfa=menuler&m_tip='.$listeyi_cek['id'].'" class="btn mini green"><i class="icon-edit"></i>Menüleri Görüntüle</a>
								<a href="?modul=icerik&sayfa=menuler&m_tip_sil='.$listeyi_cek['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a>
							</td>
						</tr>';
		}

		$liste.='<tr>
						<td>Yeni</td>
						<td><input type="text" name="yeni_menu_adi" value=""></td>
						<td><input type="submit" name="islem" class="btn green" value="KAYDET"></td>
					</tr>';
	}
	else
	{
		$kat = 0;
		if(re('kat') != "" or re('kat') != 0)
		{
			$kat = re('kat');
		}
		
		if(re('menu_sil') != "")
		{
			mysql_query("update m_menu_ic set durum='0', s_tarihi='".mktime()."' where id='".re('menu_sil')."' ");
		}
		
		if ( re('islem') == "ac_kapa" )
		{
			if(re('durum') == 1 )
			{ 
				$durum=1; 
			}
			else 
			{
				$durum=2; 
			}
			
			mysql_query("update m_menu_ic set durum='".$durum."' where id='".re('m_tip')."'");
		}
		
		if(re('menuyu') == "KAYDET")
		{
			$son_sira = 0;
			$listeyi_sor=mysql_query("select * from m_menu_ic where durum!='0' order by sira");
			while( $listeyi_cek=mysql_fetch_array($listeyi_sor) )
			{
				if (!isset($_POST['menu_adi_'.$listeyi_cek['id']]))
					continue;
				$query = "update m_menu_ic set adi='".re('menu_adi_'.$listeyi_cek['id'])."', aciklama='".re('menu_aciklama_'.$listeyi_cek['id'])."', sablon_id='".re('sablon_'.$listeyi_cek['id'])."', link='".re('menu_link_'.$listeyi_cek['id'])."', js='".re('menu_js_'.$listeyi_cek['id'])."', icon='".re('menu_icon_'.$listeyi_cek['id'])."', g_tarihi='".mktime()."' where id='".$listeyi_cek['id']."' ";
				mysql_query($query);
				
				$son_sira = $listeyi_cek['sira'];
			}
			
			if(re('yeni_menu_adi') != "")
			{
				$son_sira = $son_sira + 1;
				mysql_query("insert into m_menu_ic (sira,tip_id,kat,adi,aciklama,sablon_id,link,js,icon,e_tarihi,durum) values ('".$son_sira."','".re('m_tip')."','".$kat."','".re('yeni_menu_adi')."','".re('yeni_aciklama')."','".re('yeni_sablon')."','".re('yeni_link')."','".re('yeni_js')."','".re('yeni_icon')."','".mktime()."','1') ");
			}
		}
	
	
	
		if ( re('islem') == "tasi" )
		{
			if ( re('gorev') == "down" )
			{
				$tut=false;
				$listeyi_sor_is=mysql_query("select * from m_menu_ic where kat='".$kat."' and tip_id='".re('m_tip')."' and durum!='0' order by sira");
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
				
				mysql_query("update m_menu_ic set sira='".$basilan_sira."' where id='".$sonraki_id."'");
				mysql_query("update m_menu_ic set sira='".$sonraki_sira."' where id='".$basilan_id."'");
			}
			
			if ( re('gorev') == "up" )
			{
				$birak=true;
				$listeyi_sor_is=mysql_query("select * from m_menu_ic where kat='".$kat."' and tip_id='".re('m_tip')."' and durum!='0' order by sira");
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
				
				mysql_query("update m_menu_ic set sira='".$basilan_sira."' where id='".$onceki_id."'");
				mysql_query("update m_menu_ic set sira='".$onceki_sira."' where id='".$basilan_id."'");
				
			}
		}
	
	
	
		$listeyi_sor_on=mysql_query("select * from m_menu_ic where kat='".$kat."' and tip_id='".re('m_tip')."' and durum!='0' order by sira");
		while( $listeyi_cek_on=mysql_fetch_array($listeyi_sor_on) )
		{
			$son_id=$listeyi_cek_on['id'];
		}

		$sayi=0;
		$liste='';
		$listeyi_sor=mysql_query("select * from m_menu_ic where kat='".$kat."' and tip_id='".re('m_tip')."' and durum!='0' order by sira");
		while( $listeyi_cek=mysql_fetch_array($listeyi_sor) )
		{
			$sayi++;
			
			$yukari='<a href="?modul=icerik&sayfa=menuler&m_tip='.re('m_tip').'&islem=tasi&gorev=up&mid='.$listeyi_cek['id'].'" class="icon-circle-arrow-up"></a>';
			$asagi='<a href="?modul=icerik&sayfa=menuler&m_tip='.re('m_tip').'&islem=tasi&gorev=down&mid='.$listeyi_cek['id'].'" class="icon-circle-arrow-down"></a>';
			if ( $sayi == 1 ) { $yukari=''; } 
			if ( $son_id == $listeyi_cek['id'] ) { $asagi=''; }
			
			$bgsi = '';
			$acik_kapali='<a href="?modul=icerik&sayfa=menuler&islem=ac_kapa&durum='.$listeyi_cek['durum'].'&m_tip='.$listeyi_cek['id'].'" title="'.($listeyi_cek['durum'] == '2' ? 'Açık, kapatmak için tıklayınız.':'Kapalı, açmak için tıklayınız.').'" class="btn mini '.($listeyi_cek['durum'] == '2' ? 'red':'green').'"><i class="icon-unlock"></i> Kapat</a>'; 
			$ac_kapa = '<li><a href="?modul=icerik&sayfa=menuler&islem=ac_kapa&durum='.$listeyi_cek['durum'].'&m_tip='.$listeyi_cek['id'].'" title="'.($listeyi_cek['durum'] == '2' ? 'Açık, kapatmak için tıklayınız.':'Kapalı, açmak için tıklayınız.').'"><i class="icon-unlock" ></i> Kapat</a></li>';
			$bgsi = 'background-color:#'.($listeyi_cek['durum'] == '2' ? 'FFDDDD':'F3FFF5').';';
			/*if( $listeyi_cek['durum'] == 1 ) 
			{ 
				$acik_kapali='<a href="?modul=icerik&sayfa=menuler&islem=ac_kapa&durum=2&m_tip='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız." class="btn mini red"><i class="icon-unlock"></i> Kapat</a>'; 
				$ac_kapa = '<li><a href="?modul=icerik&sayfa=menuler&islem=ac_kapa&durum=2&m_tip='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız."><i class="icon-unlock" ></i> Kapat</a></li>';
				$bgsi = 'background-color:#F3FFF5;';
			}
			if( $listeyi_cek['durum'] == 2 )
			{ 
				$acik_kapali='<a href="?modul=icerik&sayfa=menuler&islem=ac_kapa&durum=1&m_tip='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." class="btn mini green"><i class="icon-lock"></i> Aç</a>';
				$ac_kapa = '<li><a href="?modul=icerik&sayfa=menuler&islem=ac_kapa&durum=1&m_tip='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." ><i class="icon-lock"></i> Aç</a></li>';
				$bgsi = 'background-color:#FFDDDD;';
			}*/
			
			$sablon_id=0;
			$sablon_listesi = '';
			$sablon_cek = mysql_query("select * from m_menu_sablon where durum='1' ORDER BY e_tarihi ASC, id ASC ");
			while($sablon_oku = mysql_fetch_array($sablon_cek))
			{
				$secili = '';
				if($sablon_oku['id'] == $listeyi_cek['sablon_id']) { $secili = 'selected'; $sablon_id=$sablon_oku['id']; }
				$sablon_listesi .= '<option value="'.$sablon_oku['id'].'" '.$secili.' >'.$sablon_oku['adi'].'</option>';
			}
			
			$standart_sablon_link='<li><a href="?modul=icerik&sayfa=menuler_icerik&m_tip='.re('m_tip').'&kat='.$kat.'&menu_id='.$listeyi_cek['id'].'"><i class="icon-magic"></i> Şablonu Düzenle</a></li>';
			if ( $sablon_id == 3 )
			{
				$standart_sablon_link='<li><a href="?modul=icerik&sayfa=magazalar_sablon&m_tip='.re('m_tip').'&kat='.$kat.'&menu_id='.$listeyi_cek['id'].'"><i class="icon-magic"></i> Şablonu Düzenle</a></li>';
			}
			if ( $sablon_id == 8 )
			{
				$standart_sablon_link='<li><a href="?modul=icerik&sayfa=video"><i class="icon-magic"></i> Şablonu Düzenle</a></li>';
			}
			if ( $sablon_id == 9 )
			{
				$standart_sablon_link='<li><a href="?modul=icerik&sayfa=galeri"><i class="icon-magic"></i> Şablonu Düzenle</a></li>';
			}
			if ( $sablon_id == 10 )
			{
				$standart_sablon_link='<li><a href="?modul=icerik&sayfa=referanslar"><i class="icon-magic"></i> Şablonu Düzenle</a></li>';
			}
			
			if ( $sablon_id == 12 )
			{
				$standart_sablon_link='<li><a href="?modul=icerik&sayfa=soru_cevap&menu_id='.$listeyi_cek['id'].'"><i class="icon-magic"></i> Şablonu Düzenle</a></li>';
			}
			
			if ( $sablon_id == 13 )
			{
				$standart_sablon_link='<li><a href="?modul=icerik&sayfa=test_sablonu&menu_id='.$listeyi_cek['id'].'"><i class="icon-magic"></i> Şablonu Düzenle</a></li>';
			}
			
			$acilan = '<div class="btn-group">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							Seçenekler <i class="icon-angle-down"></i>
							</a>
							<ul class="dropdown-menu">
								'.$ac_kapa.'
								<li><a href="?modul=icerik&sayfa=menuler&m_tip='.re('m_tip').'&kat='.$listeyi_cek['id'].'"><i class="icon-edit"></i> <small>Alt Menüleri Yönet</small></a></li>
								'.$standart_sablon_link.'
								<li><a href="?modul=icerik&sayfa=menuler&m_tip='.re('m_tip').'&menu_sil='.$listeyi_cek['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" ><i class="icon-trash"></i> Sil</a></li>
							</ul>
						</div>';
			
			$liste.='<tr style="'.$bgsi.'">
							<td>
								<div style="float:left; width:55px;">
									<div style="float:left;">'.$sayi.'</div>
									<div style="float:left; width:35px; margin-left:4px;">
									'.$yukari.'
									'.$asagi.'
									</div>
								</div>
							</td>
							<td>
								<input type="text" name="menu_adi_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['adi'].'" style="width:90%;">
							</td>
							<td>
								<input type="text" name="menu_aciklama_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['aciklama'].'" style="width:90%;">
							</td>
							<td>
								<select name="sablon_'.$listeyi_cek['id'].'" style="width:120px; height:24px;" >
									<option value="0">Seçiniz</option>
									'.$sablon_listesi.'
								</select>
							</td>
							<td>
								<input type="text" name="menu_link_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['link'].'" style="width:90%;">
							</td>
							<td>
								<input type="text" name="menu_js_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['js'].'" style="width:90%;">
							</td>
							<td>
								<input type="text" name="menu_icon_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['icon'].'" style="width:90%;">
							</td>
							<td>
								'.$acilan.'
							</td>
						</tr>';
		}
		
		/*
			'.$acik_kapali.'
								<a href="?modul=icerik&sayfa=menuler&mgrup='.$listeyi_cek['id'].'" class="btn mini green">Yönet</a>
								<a href="?modul=icerik&sayfa=menuler&m_tip='.$listeyi_cek['id'].'" class="btn mini green"><i class="icon-edit"></i>İçeriği Düzenle</a>
								<a href="?modul=icerik&sayfa=menuler&m_tip_sil='.$listeyi_cek['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a>
		*/
		
		$sablon_listesi = '';
		$sablon_cek = mysql_query("select * from m_menu_sablon where durum='1' ORDER BY e_tarihi ASC, id ASC ");
		while($sablon_oku = mysql_fetch_array($sablon_cek))
		{
			$sablon_listesi .= '<option value="'.$sablon_oku['id'].'" >'.$sablon_oku['adi'].'</option>';
		}
		
		$liste.='<tr>
						<td>Yeni</td>
						<td><input type="text" name="yeni_menu_adi" value="" style="width:90%;"></td>
						<td><input type="text" name="yeni_aciklama" value="" style="width:90%;"></td>
						<td>
							<select name="yeni_sablon" style="width:120px; height:24px;" >
								<option value="0">Seçiniz</option>
								'.$sablon_listesi.'
							</select>
						</td>
						<td><input type="text" name="yeni_link" value="" style="width:90%;"></td>
						<td><input type="text" name="yeni_js" value="" style="width:90%;"></td>
						<td><input type="text" name="yeni_icon" value="" style="width:90%;"></td>
						<td><input type="submit" name="menuyu" class="btn green" value="KAYDET"></td>
					</tr>';
	}
?>