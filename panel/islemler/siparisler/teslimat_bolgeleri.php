<?php 
	if(re('islem') == "Seçileni Ekle")
	{
		if(re('iller') != "")
		{
			$il_cek = mysql_query("select * from s_teslimat_iller where il_id='".re('iller')."' ");
			if(mysql_num_rows($il_cek) == 0)
			{
				mysql_query("insert into s_teslimat_iller (il_id,e_tarihi,durum) values ('".re('iller')."','".mktime()."','1') ");
			}
			else
			{
				$il_oku = mysql_fetch_assoc($il_cek);
				if($il_oku['durum'] == 0)
				{
					mysql_query("update s_teslimat_iller set durum='1', e_tarihi='".mktime()."' where id='".$il_oku['id']."' ");
				}
			}
		}
	}
	
	if(re('islem') == "Seçileni Çıkart")
	{
		if(re('teslimat_iller') != "")
		{
			mysql_query("update s_teslimat_iller set durum='0' where id='".re('teslimat_iller')."' ");
		}
	}
	if(re('islem')=="Tümünü Çıkart")
	{
		mysql_query("update s_teslimat_iller set durum='0'");
	}
	if(re('islem')=="Tümünü Ekle")
	{
		mysql_query("update s_teslimat_iller set durum='1'");
	}
?>