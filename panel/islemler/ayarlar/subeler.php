<?php 
	if(re('tanimlari') == "Kaydet")
	{
		$sube_sor1=mysql_query("select * from site_subeler order by id ASC");
		while($sube_cek1=mysql_fetch_array($sube_sor1))
		{
			if(re('sil_'.$sube_cek1['id'])==1)
			{
				mysql_query("delete from site_subeler where id='".$sube_cek1['id']."'");
			}
			else
			{
				$guncelle=false;
				if($sube_cek1['tanim']!=re('tanim_'.$sube_cek1['id'])){$guncelle=true;}
				if($sube_cek1['adres']!=re('adres_'.$sube_cek1['id'])){$guncelle=true;}
				if($sube_cek1['tel']!=re('tel_'.$sube_cek1['id'])){$guncelle=true;}
				if($sube_cek1['fax']!=re('fax_'.$sube_cek1['id'])){$guncelle=true;}
				if($sube_cek1['mail']!=re('mail_'.$sube_cek1['id'])){$guncelle=true;}
				if($guncelle==true)
				{
					mysql_query("update site_subeler set 
					tanim='".re('tanim_'.$sube_cek1['id'])."',
					adres='".re('adres_'.$sube_cek1['id'])."',
					tel='".re('telefon_'.$sube_cek1['id'])."',
					fax='".re('fax_'.$sube_cek1['id'])."',
					mail='".re('mail_'.$sube_cek1['id'])."'
					where id='".$sube_cek1['id']."'");
				}
			}
		}
		if(re('tanim_yeni')!='')
		{
			mysql_query("insert into site_subeler (
			tanim,
			adres,
			tel,
			fax,
			mail
			)values(
			'".re('tanim_yeni')."',
			'".re('adres_yeni')."',
			'".re('telefon_yeni')."',
			'".re('fax_yeni')."',
			'".re('mail_yeni')."'
			)");
		}
	}
	
	$site_cek = mysql_query("select * from site_ozellikleri where durum='1' ");
	$site_oku = mysql_fetch_assoc($site_cek);
	
	$sube_satirlari="";
	$sube_sor=mysql_query("select * from site_subeler order by id ASC");
	while($sube_cek=mysql_fetch_array($sube_sor))
	{
		$sube_satirlari.='
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">'.$sube_cek['id'].'</p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="tanim_'.$sube_cek['id'].'" id="tanim_'.$sube_cek['id'].'" placeholder="Tanım 1" value="'.$sube_cek['tanim'].'" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="adres_'.$sube_cek['id'].'" id="adres_'.$sube_cek['id'].'" placeholder="Adres 1" value="'.$sube_cek['adres'].'" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="telefon_'.$sube_cek['id'].'" id="telefon_'.$sube_cek['id'].'" placeholder="Telefon 1" value="'.$sube_cek['tel'].'" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="fax_'.$sube_cek['id'].'" id="fax_'.$sube_cek['id'].'" placeholder="Fax 1" value="'.$sube_cek['fax'].'" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="mail_'.$sube_cek['id'].'" id="mail_'.$sube_cek['id'].'" placeholder="Mail 1" value="'.$sube_cek['mail'].'" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">
								<input type="checkbox" class="btn red" name="sil_'.$sube_cek['id'].'" value="1" />
							</p>
						</div>';
	}
?>
