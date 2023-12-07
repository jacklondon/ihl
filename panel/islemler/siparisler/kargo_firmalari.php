<?php 
	
	if(re('islemleri') == "Tümünü Kaydet")
	{
		$kargo_cek = mysql_query("select * from s_kargolar where durum='1' ORDER BY e_tarihi ASC, id ASC ");
		while($kargo_oku = mysql_fetch_array($kargo_cek))
		{
			mysql_query("update s_kargolar set adi='".re('adi_'.$kargo_oku['id'])."', k_nakit='".re('k_nakit_'.$kargo_oku['id'])."', k_kart='".re('k_kart_'.$kargo_oku['id'])."', g_tarihi='".mktime()."' where id='".$kargo_oku['id']."' ");
			
			if(re('sil_'.$kargo_oku['id']) == 1)
			{
				mysql_query("update s_kargolar set durum='0', s_tarihi='".mktime()."' where id='".$kargo_oku['id']."' ");
			}
		}
		
		if(re('y_adi') != "")
		{
			mysql_query("insert into s_kargolar (adi,k_nakit,k_kart,e_tarihi,durum) values ('".re('y_adi')."','".re('y_k_nakit')."','".re('y_k_kart')."','".mktime()."','1') ");
		}
	}
	
	$kargolar = '';
	$k_sayi = 0;
	$kargo_cek = mysql_query("select * from s_kargolar where durum='1' ORDER BY e_tarihi ASC, id ASC ");
	while($kargo_oku = mysql_fetch_array($kargo_cek))
	{
		$k_sayi++;
		
		$k_nakit = '';
		$k_kart = '';
		if($kargo_oku['k_nakit'] == 1) { $k_nakit = 'checked'; }
		if($kargo_oku['k_kart'] == 1) { $k_kart = 'checked'; }
		
		$kargolar .= '<tr>
							<td>
								'.$k_sayi.'
							</td>
							<td>
								<input type="text" class="yeni_inputlar" name="adi_'.$kargo_oku['id'].'" id="adi_'.$kargo_oku['id'].'" value="'.$kargo_oku['adi'].'" />
							</td>
							<td>
								<input type="checkbox" '.$k_nakit.' name="k_nakit_'.$kargo_oku['id'].'" id="k_nakit_'.$kargo_oku['id'].'" value="1" />
							</td>
							<td>
								<input type="checkbox" '.$k_kart.' name="k_kart_'.$kargo_oku['id'].'" id="k_kart_'.$kargo_oku['id'].'" value="1" />
							</td>
							<td>
								 <input type="checkbox" name="sil_'.$kargo_oku['id'].'" id="sil_'.$kargo_oku['id'].'" value="1" />
							</td>
						</tr>';
	}
?>