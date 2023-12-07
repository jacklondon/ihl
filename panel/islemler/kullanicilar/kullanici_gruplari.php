<?php 
	
	if(re('islemleri') == "Tümünü Kaydet")
	{
		$grup_cek = mysql_query("select * from kullanicilar_grup where durum='1' ORDER BY id ASC ");
		while($grup_oku = mysql_fetch_array($grup_cek))
		{
			mysql_query("update kullanicilar_grup set adi='".re('adi_'.$grup_oku['id'])."', aktiflik='".re('aktif_'.$grup_oku['id'])."' where id='".$grup_oku['id']."' ");
			
			if(re('sil_'.$grup_oku['id']) == 1)
			{
				mysql_query("update kullanicilar_grup set durum='0' where id='".$grup_oku['id']."' ");
			}
		}
		
		if(re('y_adi') != "")
		{
			mysql_query("insert into kullanicilar_grup (adi,durum) values ('".re('y_adi').",'1') ");
		}
	}
	
	$gruplar = '';
	$k_sayi = 0;
	$grup_cek = mysql_query("select * from kullanicilar_grup where durum='1' ORDER BY id ASC ");
	while($grup_oku = mysql_fetch_array($grup_cek))
	{
		$k_sayi++;
		
		$aktiflik_checked='';
		if($grup_oku['aktiflik']==1)
		{
			$aktiflik_checked='checked';
		}
		
		$gruplar .= '<tr>
							<td>
								'.$k_sayi.'
							</td>
							<td>
								<input type="text" class="yeni_inputlar" name="adi_'.$grup_oku['id'].'" id="adi_'.$grup_oku['id'].'" value="'.$grup_oku['adi'].'" />
							</td>
							<td>
								 <input type="checkbox" name="aktif_'.$grup_oku['id'].'" id="aktif_'.$grup_oku['id'].'" value="1" '.$aktiflik_checked.' />
							</td>
							<td>
								 <input type="checkbox" name="sil_'.$grup_oku['id'].'" id="sil_'.$grup_oku['id'].'" value="1" />
							</td>
						</tr>';
	}
?>