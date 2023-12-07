<?php 
	if(re('siparis') == "")
	{
		echo '<meta http-equiv="refresh" content="0;URL=?modul=siparisler&sayfa=tum_siparisler&sira='.re('sira').'">';
		exit;
	}
	else
	{
		if(re('siparisi') == "Kaydet")
		{
			$eklesene = '';
			if(re('sip_durum') == 2)
			{
				$eklesene .= ' ,onay_tarihi="'.mktime().'"';
			}
			mysql_query("update s_sepet set sip_durum='".re('sip_durum')."', kargo_id='".re('kargo_id')."', islem_tarihi='".mktime()."', g_tarihi='".mktime()."', tahsil='".re('tahsil')."' ".$eklesene." where id='".re('siparis')."' ");
			
			if(re('tahsil') == 1)
			{
				$siparis_ceksen = mysql_query("select * from s_sepet where id='".re('siparis')."' ");
				$siparis_okusan = mysql_fetch_assoc($siparis_ceksen);
				
				$kasa_cek = mysql_query("select * from kasa where sepet_id='".re('siparis')."' and durum='1' ");
				if(mysql_num_rows($kasa_cek) == 0)
				{
					mysql_query("insert into kasa (sepet_id,kullanici_id,ip,siparis_no,sip_tarihi,fiyat,e_tarihi,durum) values ('".re('siparis')."','".$siparis_okusan['kullanici_id']."','".$siparis_okusan['ip']."','".$siparis_okusan['siparis_no']."','".$siparis_okusan['sip_tarihi']."','".$siparis_okusan['genel_toplam']."','".mktime()."','1') ");
				}
				else
				{
					$kasa_oku = mysql_fetch_assoc($kasa_cek);
					mysql_query("update kasa set kullanici_id='".$siparis_okusan['kullanici_id']."', ip='".$siparis_okusan['ip']."', siparis_no='".$siparis_okusan['siparis_no']."', sip_tarihi='".$siparis_okusan['sip_tarihi']."', fiyat='".$siparis_okusan['genel_toplam']."', g_tarihi='".mktime()."' where id='".$kasa_oku['id']."' ");
				}
			}
			else
			{
				mysql_query("update kasa set durum='0', s_tarihi='".mktime()."' where sepet_id='".re('siparis')."' and durum='1' ");
			}
		}
		
		$siparis_cek = mysql_query("select * from s_sepet where id='".re('siparis')."' and durum='2' ");
		if(mysql_num_rows($siparis_cek) == 0)
		{
			echo '<meta http-equiv="refresh" content="0;URL=?modul=siparisler&sayfa=tum_siparisler&sira='.re('sira').'">';
			exit;
		}
		$siparis_oku = mysql_fetch_assoc($siparis_cek);
		
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
		
		
		$hediye = 'Hayır';
		if($siparis_oku['hediye'] == 1)
		{
			$hediye = 'Evet';
		}
		
		$tahsilmi = '';
		if($siparis_oku['tahsil'] == 1)
		{
			$tahsilmi = 'checked';
		}
	}
?>