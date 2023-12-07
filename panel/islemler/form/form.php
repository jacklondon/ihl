<?php 
	if(re('islemleri') == "Kaydet")
	{
		
		if(re('y_soru_adi') != "" and re('y_soru_tur') != 0 and re('y_input_adi') != "")
		{
			$kat_sor = mysql_query("select * from s_sorular where input='".re('y_input_adi')."' and durum='1' ");
			
			if(mysql_num_rows($kat_sor) == 0)
			{
				mysql_query("insert into s_sorular (soru,soru_tur,input,zorunlu,ozellik,e_tarihi,durum,kategori) values ('".re('y_soru_adi')."','".re('y_soru_tur')."','".re('y_input_adi')."','".re('y_zorunlu')."','".re('y_ozellik')."','".mktime()."','1','".re('y_kategori')."') ");
				
				mysql_query("alter table s_sorular_veriler add ".re('y_input_adi')." TEXT not null");
			}
		}
		
		$sorulari_cek = mysql_query("select * from s_sorular where durum!='0' ORDER BY e_tarihi ASC ");
		while($sorulari_oku = mysql_fetch_array($sorulari_cek))
		{
			if(re('soru_'.$sorulari_oku['id']) != "" and re('soru_tur_'.$sorulari_oku['id']) != 0)
			{
				mysql_query("update s_sorular set soru='".re('soru_'.$sorulari_oku['id'])."', soru_tur='".re('soru_tur_'.$sorulari_oku['id'])."', ozellik='".re('ozellik_'.$sorulari_oku['id'])."', zorunlu='".re('zorunlu_'.$sorulari_oku['id'])."', g_tarihi='".mktime()."', kategori='".re('kategori_'.$sorulari_oku['id'])."' where id='".$sorulari_oku['id']."' ");
				
				if(re('sil_'.$sorulari_oku['id']) == 1)
				{
					mysql_query("update s_sorular set durum='0', s_tarihi='".mktime()."' where id='".$sorulari_oku['id']."' ");
					mysql_query("ALTER TABLE s_sorular_veriler DROP ".re('input_'.$sorulari_oku['id'])." ");
				}
			}
		}
	}
	
	
	
	
	
	$sayi = 0;
	$basilacak = '';
	$sorulari_cek = mysql_query("select * from s_sorular where durum!='0' ORDER BY e_tarihi ASC ");
	while($sorulari_oku = mysql_fetch_array($sorulari_cek))
	{
		$bas = true;
		
		if($bas == true)
		{
			$sayi++;
			
			$soru_turler = '';
			$soru_tur_cek = mysql_query("select * from s_sorular_turleri where durum='1' ORDER BY id ASC ");
			while($soru_tur_oku = mysql_fetch_array($soru_tur_cek))
			{
				$secili = '';
				if($soru_tur_oku['id'] == $sorulari_oku['soru_tur']) { $secili = 'selected'; }
				$soru_turler .= '<option value="'.$soru_tur_oku['id'].'" '.$secili.' >'.$soru_tur_oku['adi'].'</option>';
			}
			
			$zorunlumu = '';
			if($sorulari_oku['zorunlu'] == 1)
			{
				$zorunlumu = 'checked';
			}
			
			$kat_ler = 0;
			$kategorileri = '<option value="0">Hepsi</option>';
			$kat_cek = mysql_query("select * from urunler_kategoriler where durum!='0' and kategori='0' ORDER BY id ASC ");
			while($kat_oku = mysql_fetch_array($kat_cek))
			{
				$kat_ler++;
				
				$secili = '';
				if($sorulari_oku['kategori'] == $kat_oku['id']) { $secili = 'selected'; }
				
				$kategorileri .= '<option value="'.$kat_oku['id'].'" '.$secili.' >'.$kat_oku['tanim'].'</option>';
			}
			
			
			$basilacak .= '<tr>
							<td>
								'.$sayi.'
							</td>
							<td>
								<input type="text" style="width:160px;" class="yeni_inputlar" name="soru_'.$sorulari_oku['id'].'" id="soru_'.$sorulari_oku['id'].'" value="'.$sorulari_oku['soru'].'" />
								<div style="float:left; width:160px;"></div>
							</td>
							<td>
								<select style="width:160px;" class="yeni_inputlar_slc" name="soru_tur_'.$sorulari_oku['id'].'" id="soru_tur_'.$sorulari_oku['id'].'" >
									'.$soru_turler.'
								</select>
								<div style="float:left; width:160px;"></div>
							</td>
							<td>
								<select style="width:160px;" class="yeni_inputlar_slc" name="kategori_'.$sorulari_oku['id'].'" id="kategori_'.$sorulari_oku['id'].'" >
									'.$kategorileri.'
								</select>
								<div style="float:left; width:160px;"></div>
							</td>
							<td>
								<input type="text" style="width:160px;" class="yeni_inputlar" name="input_'.$sorulari_oku['id'].'" id="input_'.$sorulari_oku['id'].'" value="'.$sorulari_oku['input'].'" />
								<div style="float:left; width:160px;"></div>
							</td>
							<td>
								 <textarea style="width:180px;" class="yeni_inputlar_texta" rows="1" name="ozellik_'.$sorulari_oku['id'].'" id="ozellik_'.$sorulari_oku['id'].'" >'.$sorulari_oku['ozellik'].'</textarea>
								 <div style="float:left; width:180px;"></div>
							</td>
							<td>
								<label class="checkbox">
									<input type="checkbox" value="1" name="zorunlu_'.$sorulari_oku['id'].'" id="zorunlu_'.$sorulari_oku['id'].'" '.$zorunlumu.' />
								</label>
							</td>
							<td>
								<label class="checkbox">
									<input type="checkbox" value="1" name="sil_'.$sorulari_oku['id'].'" id="sil_'.$sorulari_oku['id'].'" />
								</label>
							</td>
						</tr>';
		}
	}
?>