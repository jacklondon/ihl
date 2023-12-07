<?php 
	if(re('kullaniciyi') == "Kaydet")
	{
		$kaydet = true;
		$bilgi = '';
		if(re('kullanici_adi') == "") 
		{ 
			$kaydet = false; $bilgi .= 'Kullanıcı Adı Boş,'; 
		}
		else
		{
			$kullanici_cek5 = mysql_query("select * from kullanicilar where kullanici_adi='".re('kullanici_adi')."' ");
			if(mysql_num_rows($kullanici_cek) != 0)
			{
				$kullanici_oku5 = mysql_fetch_assoc($kullanici_cek5);
				if(re('kullanici') != "")
				{
					if(re('kullanici') != $kullanici_oku5['id'])
					{
						$kaydet = false; $bilgi .= 'Bu kullanıcı Adı Zaten bulunmakta';
					}
				}
				else
				{
					$kaydet = false; $bilgi .= 'Bu kullanıcı Adı Zaten bulunmakta';
				}
			}
		}
		
		if(re('kullanici') != "")
		{
			if(re('yeni_sifre') != "" and re('yeni_sifre_tekrar') != "")
			{
				if(re('yeni_sifre') == re('yeni_sifre_tekrar'))
				{
					mysql_query("update kullanicilar set sifre='".md5(sha1(re('yeni_sifre')))."' where id='".re('kullanici')."' ");
				}
				else
				{
					alert("Şifre güncellenebilmesi için -> Yeni Şifre ve Yeni Şifre Tekrar Alanlarının aynı olması gerekmektedir..");
				}
			}
		}
		else
		{
			if(re('yeni_sifre') != "" and re('yeni_sifre_tekrar') != "")
			{
				if(re('yeni_sifre') != re('yeni_sifre_tekrar'))
				{
					$kaydet = false; $bilgi .= "Lütfen Yeni Şifre ve Yeni Şifre Tekrar alanlarını aynı giriniz, ";
				}
			}
			else
			{
				$kaydet = false; $bilgi .= "Lütfen Yeni Şifre ve Yeni Şifre Tekrar Alanlarını doldurunuz, ";
			}
		}
		
		if(re('adi') == "") { $kaydet = false; $bilgi .= 'Adı alanı boş olamaz, '; }
		if(re('soyadi') == "") { $kaydet = false; $bilgi .= 'Soyadı alanı boş olamaz, '; }
		if(re('email') == "") { $kaydet = false; $bilgi .= 'Email alanı boş olamaz, '; }
		if(re('yetki') == 0) { $kaydet = false; $bilgi .= 'Yetki alanı boş olamaz, '; }
		
		if($kaydet == true)
		{
			if(re('kullanici') != "")
			{
				mysql_query("update kullanicilar set kullanici_adi='".re('kullanici_adi')."', adi='".re('adi')."', soyadi='".re('soyadi')."', email='".re('email')."', tel='".re('tel')."', yetki='".re('yetki')."', grup='".re('grup')."', g_tarihi='".mktime()."', bayi='".re('bayi')."', bayi_usd='".re('bayi_usd')."', f_operator='".re('f_operator')."', f_ticari_unvan='".re('f_ticari_unvan')."', f_vergi_dairesi='".re('f_vergi_dairesi')."', f_vergi_no='".re('f_vergi_no')."', f_tc='".re('f_tc')."', f_telefon='".re('f_telefon')."', f_adres='".re('f_adres')."', f_kategori='".re('f_kategori')."' where id='".re('kullanici')."' ");
				alert("Kullanıcı Güncellendi..");
			}
			else
			{
				mysql_query("insert into kullanicilar (
				kullanici_adi,
				sifre,
				adi,
				soyadi,
				email,
				tel,
				yetki,
				grup,
				e_tarihi,
				durum,
				bayi_usd,
				f_operator,
				f_ticari_unvan,
				f_vergi_dairesi,
				f_vergi_no,
				f_tc,
				f_telefon,
				f_adres,
				f_kategori
				) values (
				'".re('kullanici_adi')."',
				'".md5(sha1(re('yeni_sifre')))."',
				'".re('adi')."',
				'".re('soyadi')."',
				'".re('email')."',
				'".re('tel')."',
				'".re('yetki')."',
				'".re('grup')."',
				'".mktime()."',
				'1',
				'".re('bayi_usd')."',
				'".re('f_operator')."',
				'".re('f_ticari_unvan')."',
				'".re('f_vergi_dairesi')."',
				'".re('f_vergi_no')."',
				'".re('f_tc')."',
				'".re('f_telefon')."',
				'".re('f_adres')."',
				'".re('f_kategori')."') ")or die(mysql_error());
				alert("Kullanıcı Eklendi..");
			}
		}
		else
		{
			alert($bilgi);
		}
	}
	
	if(re('kullanici') != "")
	{
		$kullanici_cek4 = mysql_query("select * from kullanicilar where id='".re('kullanici')."' ");
		$kullanici_oku4 = mysql_fetch_assoc($kullanici_cek4);
		
		if($kullanici_oku4['yetki'] == 1)
		{
			$yetki_bir = 'selected';
		}
		if($kullanici_oku4['yetki'] == 9)
		{
			$yetki_dokuz = 'selected';
		}
	}
	
	
?>