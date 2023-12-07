<?php 
	if(re('menu_id') == "" or re('menu_id') == 0)
	{
		echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=menuler&m_tip='.re('m_tip').'&kat='.re('kat').'">';
	}
	else
	{
		if(re('islem') == "Kaydet")
		{
			$resimadi='';
			if ( $_FILES['files']['name'] != "" )
			{
				$resim_target=$site_image_addr;
				$check=true;
				$target_dir = $resim_target;
				$target_file = $target_dir . basename($_FILES['files']);
				$imageFileType = $_FILES['files']['type'];
				if ( $imageFileType == "image/jpeg")
				{
					$imageFileType='jpg';
				}
				if ( $imageFileType == "image/png")
				{
					$imageFileType='png';
				}
				if ( $imageFileType == "image/gif")
				{
					$imageFileType='gif';
				}
				
				$check=true;
				if($check !== false) 
				{	
					$uploadOk=1;
					if ($_FILES['files']['size'] > 5000000) 
					{
						$hata="<br />Dosya boyutu çok büyük";
						$uploadOk=0;
					}
					
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) 
					{
						$uploadOk = 0;
						$hata="<br />Yanlızca JPG - PNG - GIF formatı geçerlidir.";
					}
					 
					if ($uploadOk == 1) 
					{
						$yeniden_adlandir=$_FILES['files']["name"].time().time();
						$yeniden_adlandir=md5($yeniden_adlandir);
						$son_resim=$target_dir.$yeniden_adlandir.".".$imageFileType;
						if (move_uploaded_file($_FILES['files']["tmp_name"], $son_resim)) 
						{
							if ( $imageFileType =="jpg" )
							{
								$kucuk_resim		= imagecreatefromjpeg($son_resim);
								$boyutlar	= getimagesize($son_resim);
								$yeniresim	= imagecreatetruecolor(1349, 160);
								imagecopyresampled($yeniresim, $kucuk_resim, 0, 0, 0, 0, 1349, 160, $boyutlar[0], $boyutlar[1]);
								$hedefdosya=$target_dir.$yeniden_adlandir.".".$imageFileType;
								imagejpeg($yeniresim, $hedefdosya, 1349);
								$resimadi=$yeniden_adlandir.".".$imageFileType;
								chmod ($hedefdosya, 0777);
								
							}
							
							if ( $imageFileType =="png" || $imageFileType =="PNG")
							{
								
								$resimadi=$yeniden_adlandir.".".$imageFileType;
								rename($son_resim, $resimadi);
								chmod ($hedefdosya, 0777);
							}
							
							if ( $imageFileType =="gif" || $imageFileType =="GIF")
							{
								$kucuk_resim		= imagecreatefromgif($son_resim);
								$boyutlar	= getimagesize($son_resim);
								$yeniresim	= imagecreatetruecolor(1349, 160);
								imagecopyresampled($yeniresim, $kucuk_resim, 0, 0, 0, 0, 1349, 160, $boyutlar[0], $boyutlar[1]);
								$hedefdosya=$target_dir.$yeniden_adlandir.".".$imageFileType;
								imagegif($yeniresim, $hedefdosya, 1349);
								$resimadi=$yeniden_adlandir.".".$imageFileType;
								chmod ($hedefdosya, 0777);	
							}
							
							
						} else {
							echo $son_resim;
						}
					}
				} else {
					$uploadOk = 0;
					$hata="<br />Resim formatı hatalı";
					
				}
				$sql_cumle1=", baslik_arka_fon='".$resimadi."'";
				
			}
			$resimadi2='';
			if ( $_FILES['files2']['name'] != "" )
			{
				$resim_target=$site_image_addr;
				$check=true;
				$target_dir = $resim_target;
				$target_file = $target_dir . basename($_FILES['files2']);
				$imageFileType = $_FILES['files2']['type'];
				if ( $imageFileType == "image/jpeg")
				{
					$imageFileType='jpg';
				}
				if ( $imageFileType == "image/png")
				{
					$imageFileType='png';
				}
				if ( $imageFileType == "image/gif")
				{
					$imageFileType='gif';
				}
				
				$check=true;
				if($check !== false) 
				{	
					$uploadOk=1;
					if ($_FILES['files2']['size'] > 5000000) 
					{
						$hata="<br />Dosya boyutu çok büyük";
						$uploadOk=0;
					}
					
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) 
					{
						$uploadOk = 0;
						$hata="<br />Yanlızca JPG - PNG - GIF formatı geçerlidir.";
					}
					 
					if ($uploadOk == 1) 
					{
						$yeniden_adlandir=$_FILES['files2']["name"].time().time();
						$yeniden_adlandir=md5($yeniden_adlandir);
						$son_resim=$target_dir.$yeniden_adlandir.".".$imageFileType;
						if (move_uploaded_file($_FILES['files2']["tmp_name"], $son_resim)) 
						{
							if ( $imageFileType =="jpg" )
							{
								$kucuk_resim		= imagecreatefromjpeg($son_resim);
								$boyutlar	= getimagesize($son_resim);
								$yeniresim	= imagecreatetruecolor(1326, 889);
								imagecopyresampled($yeniresim, $kucuk_resim, 0, 0, 0, 0, 1326, 889, $boyutlar[0], $boyutlar[1]);
								$hedefdosya=$target_dir.$yeniden_adlandir.".".$imageFileType;
								imagejpeg($yeniresim, $hedefdosya, 1326);
								$resimadi2=$yeniden_adlandir.".".$imageFileType;
								chmod ($hedefdosya, 0777);
								
							}
							
							if ( $imageFileType =="png" || $imageFileType =="PNG")
							{
								
								$resimadi2=$yeniden_adlandir.".".$imageFileType;
								rename($son_resim, $resimadi2);
								chmod ($hedefdosya, 0777);
							}
							
							if ( $imageFileType =="gif" || $imageFileType =="GIF")
							{
								$kucuk_resim		= imagecreatefromgif($son_resim);
								$boyutlar	= getimagesize($son_resim);
								$yeniresim	= imagecreatetruecolor(1326, 889);
								imagecopyresampled($yeniresim, $kucuk_resim, 0, 0, 0, 0, 1326, 889, $boyutlar[0], $boyutlar[1]);
								$hedefdosya=$target_dir.$yeniden_adlandir.".".$imageFileType;
								imagegif($yeniresim, $hedefdosya, 1326);
								$resimadi2=$yeniden_adlandir.".".$imageFileType;
								chmod ($hedefdosya, 0777);	
							}
							
							
						} else {
							echo $son_resim;
						}
					}
				} else {
					$uploadOk = 0;
					$hata="<br />Resim formatı hatalı";
					
				}
			
				$sql_cumle2=", yazi_arka_fon='".$resimadi2."'";
			}
			
			mysql_query("update m_menu_icerik set baslik='".re('baslik')."', icerik='".re('icerik')."'".$sql_cumle1."".$sql_cumle2." where menu_id='".re('menu_id')."' and durum='1' ")or die(mysql_error());
			alert("İçerik Güncellendi..");
			echo '<meta http-equiv="refresh" content="0;URL=?modul=icerik&sayfa=menuler&m_tip='.re('m_tip').'&kat='.re('kat').'">';
		}
		
		$icerik_cek = mysql_query("select * from m_menu_icerik where menu_id='".re('menu_id')."' and durum='1' ");
		if(mysql_num_rows($icerik_cek) == 0)
		{
			mysql_query("insert into m_menu_icerik (menu_id,e_tarihi,durum) values ('".re('menu_id')."','".mktime()."','1') ");
			$icerik_cek = mysql_query("select * from m_menu_icerik where menu_id='".re('menu_id')."' and durum='1' ");
			$icerik_oku = mysql_fetch_assoc($icerik_cek);
		}
		else
		{
			$icerik_oku = mysql_fetch_assoc($icerik_cek);
		}
	}
?>