<?php 
	if(re('konum') == "" or re('konum') == 0)
	{
		if ( re('islem') == "ac_kapa" )
		{
			mysql_query("update m_slider_konum set durum='".re('durum')."' where id='".re('konum_id')."'");
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=slider">';
		}
		
		if(re('konum_sil') != "")
		{
			mysql_query("update m_slider_konum set durum='0', s_tarihi='".mktime()."' where id='".re('konum_sil')."' ");
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=slider">';
		}
		
		if ( re('islem') == "KAYDET" )
		{
			$listeyi_sor=mysql_query("select * from m_slider_konum where durum!='0' ORDER BY e_tarihi ASC, id ASC ");
			while($listeyi_cek=mysql_fetch_array($listeyi_sor))
			{
				mysql_query("update m_slider_konum set adi='".re('konum_adi_'.$listeyi_cek['id'])."' where id='".$listeyi_cek['id']."' ");
			}
			
			if ( re('yeni_konum_adi') != "" )
			{
				mysql_query("insert into m_slider_konum (
				id,
				adi,
				e_tarihi,
				durum
				)values(
				null,
				'".re('yeni_konum_adi')."',
				'".mktime()."',
				'1')");
			}
		}



		$sayi=0;
		$liste='';
		$listeyi_sor=mysql_query("select * from m_slider_konum where durum!='0' ORDER BY e_tarihi ASC, id ASC ");
		while($listeyi_cek=mysql_fetch_array($listeyi_sor))
		{
			if( $listeyi_cek['durum'] == 1 ) 
			{ 
				$acik_kapali='<a href="?modul=icerik&sayfa=slider&islem=ac_kapa&durum=2&konum_id='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız." class="btn mini red"><i class="icon-unlock"></i> Kapat</a>'; 
			}
			if( $listeyi_cek['durum'] == 2 )
			{ 
				$acik_kapali='<a href="?modul=icerik&sayfa=slider&islem=ac_kapa&durum=1&konum_id='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." class="btn mini green"><i class="icon-lock"></i> Aç</a>';
			}
			
			$sayi++;
			$liste.='<tr>
							<td>'.$sayi.'</td>
							<td><input type="text" name="konum_adi_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['adi'].'" ></td>
							<td>
								'.$acik_kapali.'
								<a href="?modul=icerik&sayfa=slider&konum='.$listeyi_cek['id'].'" class="btn mini green"><i class="icon-edit"></i>İçeriğini Görüntüle</a>
								<a href="?modul=icerik&sayfa=slider&konum_sil='.$listeyi_cek['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" class="btn mini red"><i class="icon-trash"></i> Sil</a>
							</td>
						</tr>';
		}

		$liste.='<tr>
						<td>Yeni</td>
						<td><input type="text" name="yeni_konum_adi" value=""></td>
						<td><input type="submit" name="islem" class="btn green" value="KAYDET"></td>
					</tr>';
	}
	else
	{
		if(re('slider_sil') != "")
		{
			mysql_query("update m_slider_icerik set durum='0', s_tarihi='".mktime()."' where id='".re('slider_sil')."' ");
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
			
			mysql_query("update m_slider_icerik set durum='".$durum."' where id='".re('slider_id')."'");
		}
		
		if(re('slideri') == "KAYDET")
		{
			$son_sira = 0;
			$listeyi_sor=mysql_query("select * from m_slider_icerik where konum='".re('konum')."' and durum!='0' order by sira");
			while( $listeyi_cek=mysql_fetch_array($listeyi_sor) )
			{
				$slide1 = '';
				$slide2 = '';
				if($_FILES['resim1_'.$listeyi_cek['id']]['name'] != "")
				{
					$dosya_adi=$_FILES['resim1_'.$listeyi_cek['id']]['name'];
					$dizim=array("iz","et","se","du","yr","nk");
					$uzanti=substr($dosya_adi,-4,4);
				
					$rasgele=time().'-'.rand(1,1000000);
					$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
					$yeni_ad="../images/slider/".$ad;
					move_uploaded_file($_FILES['resim1_'.$listeyi_cek['id']]['tmp_name'],$yeni_ad);
					
					$slide1 = ", resim1='".$ad."' ";
				}
				if($_FILES['resim2_'.$listeyi_cek['id']]['name'] != "")
				{
					$dosya_adi=$_FILES['resim2_'.$listeyi_cek['id']]['name'];
					$dizim=array("iz","et","se","du","yr","nk");
					$uzanti=substr($dosya_adi,-4,4);
				
					$rasgele=time().'-'.rand(1,1000000);
					$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
					$yeni_ad="../images/slider/".$ad;
					move_uploaded_file($_FILES['resim2_'.$listeyi_cek['id']]['tmp_name'],$yeni_ad);
					
					$slide2 = ", resim2='".$ad."' ";
				}
				mysql_query("update m_slider_icerik set icerik1='".re('icerik1_'.$listeyi_cek['id'])."', icerik2='".re('icerik2_'.$listeyi_cek['id'])."', g_tarihi='".mktime()."' ".$slide1.$slide2." where id='".$listeyi_cek['id']."' ");
			}
			
			if(re('yeni_icerik1') != "" and $_FILES['yeni_resim1']['name'] != "")
			{
				$slide1 = '';
				$slide2 = '';
				
				if($_FILES['yeni_resim1']['name'] != "")
				{
					$dosya_adi=$_FILES['yeni_resim1']['name'];
					$dizim=array("iz","et","se","du","yr","nk");
					$uzanti=substr($dosya_adi,-4,4);
				
					$rasgele=time().'-'.rand(1,1000000);
					$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
					$yeni_ad="../images/slider/".$ad;
					move_uploaded_file($_FILES['yeni_resim1']['tmp_name'],$yeni_ad);
					
					$slide1 = $ad;
				}
				if($_FILES['yeni_resim2']['name'] != "")
				{
					$dosya_adi=$_FILES['yeni_resim2']['name'];
					$dizim=array("iz","et","se","du","yr","nk");
					$uzanti=substr($dosya_adi,-4,4);
				
					$rasgele=time().'-'.rand(1,1000000);
					$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
					$yeni_ad="../images/slider/".$ad;
					move_uploaded_file($_FILES['yeni_resim2']['tmp_name'],$yeni_ad);
					
					$slide2 = $ad;
				}
				
				$son_sira = $son_sira + 1;
				mysql_query("insert into m_slider_icerik (sira,konum,icerik1,icerik2,resim1,resim2,e_tarihi,durum) values ('".$son_sira."','".re('konum')."','".re('yeni_icerik1')."','".re('yeni_icerik2')."','".$slide1."','".$slide2."','".mktime()."','1') ");
				
			}
		}
	
	
	
		if ( re('islem') == "tasi" )
		{
			if ( re('gorev') == "down" )
			{
				$tut=false;
				$listeyi_sor_is=mysql_query("select * from m_slider_icerik where konum='".re('konum')."' and durum!='0' order by sira");
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
				$q1 = "update m_slider_icerik set sira='".$basilan_sira."' where id='".$sonraki_id."'";
				$q2 = "update m_slider_icerik set sira='".$sonraki_sira."' where id='".$basilan_id."'";
				mysql_query($q1);
				mysql_query($q2);
			}
			
			if ( re('gorev') == "up" )
			{
				$birak=true;
				$listeyi_sor_is=mysql_query("select * from m_slider_icerik where konum='".re('konum')."' and durum!='0' order by sira");
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
				
				mysql_query("update m_slider_icerik set sira='".$basilan_sira."' where id='".$onceki_id."'");
				mysql_query("update m_slider_icerik set sira='".$onceki_sira."' where id='".$basilan_id."'");
				
			}
		}
	
	
	
		$listeyi_sor_on=mysql_query("select * from m_slider_icerik where konum='".re('konum')."' and durum!='0' order by sira");
		while( $listeyi_cek_on=mysql_fetch_array($listeyi_sor_on) )
		{
			$son_id=$listeyi_cek_on['id'];
		}

		$sayi=0;
		$liste='';
		$listeyi_sor=mysql_query("select * from m_slider_icerik where konum='".re('konum')."' and durum!='0' order by sira");
		while( $listeyi_cek=mysql_fetch_array($listeyi_sor) )
		{
			$sayi++;
			
			$yukari='<a href="?modul=icerik&sayfa=slider&konum='.re('konum').'&islem=tasi&gorev=up&mid='.$listeyi_cek['id'].'" class="icon-circle-arrow-up"></a>';
			$asagi='<a href="?modul=icerik&sayfa=slider&konum='.re('konum').'&islem=tasi&gorev=down&mid='.$listeyi_cek['id'].'" class="icon-circle-arrow-down"></a>';
			if ( $sayi == 1 ) { $yukari=''; } 
			if ( $son_id == $listeyi_cek['id'] ) { $asagi=''; }
			
			$bgsi = '';
			if( $listeyi_cek['durum'] == 1 ) 
			{ 
				$acik_kapali='<a href="?modul=icerik&sayfa=slider&islem=ac_kapa&durum=2&konum='.re('konum').'&slider_id='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız." class="btn mini red"><i class="icon-unlock"></i> Kapat</a>'; 
				$ac_kapa = '<li><a href="?modul=icerik&sayfa=slider&islem=ac_kapa&durum=2&konum='.re('konum').'&slider_id='.$listeyi_cek['id'].'" title="Açık, kapatmak için tıklayınız."><i class="icon-unlock" ></i> Kapat</a></li>';
				$bgsi = 'background-color:#F3FFF5;';
			}
			if( $listeyi_cek['durum'] == 2 )
			{ 
				$acik_kapali='<a href="?modul=icerik&sayfa=slider&islem=ac_kapa&durum=1&konum='.re('konum').'&slider_id='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." class="btn mini green"><i class="icon-lock"></i> Aç</a>';
				$ac_kapa = '<li><a href="?modul=icerik&sayfa=slider&islem=ac_kapa&durum=1&konum='.re('konum').'&slider_id='.$listeyi_cek['id'].'" title="Kapalı, açmak için tıklayınız." ><i class="icon-lock"></i> Aç</a></li>';
				$bgsi = 'background-color:#FFDDDD;';
			}
			
			$acilan = '<div class="btn-group">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							Seçenekler <i class="icon-angle-down"></i>
							</a>
							<ul class="dropdown-menu">
								'.$ac_kapa.'
								<li><a href="?modul=icerik&sayfa=slider&konum='.re('konum').'&slider_sil='.$listeyi_cek['id'].'" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')" ><i class="icon-trash"></i> Sil</a></li>
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
								<input type="text" name="icerik1_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['icerik1'].'" style="width:90%;">
							</td>
							<td>
								<input type="text" name="icerik2_'.$listeyi_cek['id'].'" value="'.$listeyi_cek['icerik2'].'" style="width:90%;">
							</td>
							<td>
								<a href="../images/slider/'.$listeyi_cek['resim1'].'" target="_blank" style="float:left; position:relative; margin-top:3px; margin-right:4px;"><img src="images/resim.png"></a>
								<input type="file" name="resim1_'.$listeyi_cek['id'].'" style="width:90%;">
							</td>
							<td>
								<a href="../images/slider/'.$listeyi_cek['resim2'].'" target="_blank" style="float:left; position:relative; margin-top:3px; margin-right:4px;"><img src="images/resim.png"></a>
								<input type="file" name="resim2_'.$listeyi_cek['id'].'" style="width:90%;">
							</td>
							<td>
								'.$acilan.'
							</td>
						</tr>';
		}
		
		$liste.='<tr>
						<td>Yeni</td>
						<td><input type="text" name="yeni_icerik1" value="" style="width:90%;"></td>
						<td><input type="text" name="yeni_icerik2" value="" style="width:90%;"></td>
						<td><input type="file" name="yeni_resim1" style="width:90%;"></td>
						<td><input type="file" name="yeni_resim2" style="width:90%;"></td>
						<td><input type="submit" name="slideri" class="btn green" value="KAYDET"></td>
					</tr>';
	}
?>