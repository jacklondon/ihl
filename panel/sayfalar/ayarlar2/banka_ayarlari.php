<?php 
	
	if(re('islemleri') == "Tümünü Kaydet")
	{
		$banka_cek = mysql_query("select * from s_odeme_banka where durum='1' ORDER BY e_tarihi ASC ");
		while($banka_oku = mysql_fetch_array($banka_cek))
		{

			#mysql_query("update s_odeme_banka set adi='".re('y_adi_'.$banka_oku['id'])."',sube_adi='".re('y_adi_'.$banka_oku['id'])."',sube_kodu='".re('y_sube_kodu_'.$banka_oku['id'])."',hesap_no='".re('y_hesap_no_'.$banka_oku['id'])."',iban='".re('y_iban_'.$banka_oku['id'])."',c_1='".re('y_c1_'.$banka_oku['id'])."',c_3='".re('y_c3_'.$banka_oku['id'])."',c_6='".re('y_c6_'.$banka_oku['id'])."',c_9='".re('y_c9_'.$banka_oku['id'])."',resim='".re('y_resim_'.$banka_oku['id'])."' where id='".$banka_oku['id']."' ")or die(mysql_error());
			mysql_query("update s_odeme_banka set adi='".re('y_adi_'.$banka_oku['id'])."',sube_adi='".re('y_adi_'.$banka_oku['id'])."',sube_kodu='".re('y_sube_kodu_'.$banka_oku['id'])."',hesap_no='".re('y_hesap_no_'.$banka_oku['id'])."',iban='".re('y_iban_'.$banka_oku['id'])."' where id='".$banka_oku['id']."' ")or die(mysql_error());
			
			if(re('sil_'.$banka_oku['id']) == 1)
			{
				mysql_query("update s_odeme_banka set durum='0' where id='".$banka_oku['id']."' ")or die(mysql_error());
			}
		}
		
		if(re('y_adi') != "")
		{
			mysql_query("insert into s_odeme_banka (adi,sube_adi,sube_kodu,hesap_no,iban,e_tarihi,durum) values ('".re('y_adi')."','".re('y_sube_adi')."','".re('y_sube_kodu')."','".re('y_hesap_no')."','".re('y_iban')."','".mktime()."','1') ")or die(mysql_error());
		}
	}
	
	$bankalar = '';
	$k_sayi = 0;
	$banka_cek = mysql_query("select * from s_odeme_banka where durum='1' ORDER BY e_tarihi ASC ");
	while($banka_oku = mysql_fetch_array($banka_cek))
	{
		$k_sayi++;
		
		$c1_s = '';
		$c3_s = '';
		$c6_s = '';
		$c9_s = '';
		if($banka_oku['c_1'] == 1) { $c1_s = 'checked'; }
		if($banka_oku['c_3'] == 1) { $c3_s = 'checked'; }
		if($banka_oku['c_6'] == 1) { $c6_s = 'checked'; }
		if($banka_oku['c_9'] == 1) { $c9_s = 'checked'; }
		
		$bankalar .= '<tr>
							<td>
								'.$k_sayi.'
							</td>
							<td>
								<input type="text" placeholder="Banka Adı" name="y_adi_'.$banka_oku['id'].'" id="y_adi_'.$banka_oku['id'].'" value="'.$banka_oku['adi'].'" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="Şube Adı" name="y_sube_adi_'.$banka_oku['id'].'" id="y_sube_adi_'.$banka_oku['id'].'" value="'.$banka_oku['sube_adi'].'" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="Şube Kodu" name="y_sube_kodu_'.$banka_oku['id'].'" id="y_sube_kodu_'.$banka_oku['id'].'" value="'.$banka_oku['sube_kodu'].'" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="Hesap No" name="y_hesap_no_'.$banka_oku['id'].'" id="y_hesap_no_'.$banka_oku['id'].'" value="'.$banka_oku['hesap_no'].'" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="IBAN" name="y_iban_'.$banka_oku['id'].'" id="y_iban_'.$banka_oku['id'].'" value="'.$banka_oku['iban'].'" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="Resim" name="y_resim_'.$banka_oku['id'].'" id="y_resim_'.$banka_oku['id'].'" value="'.$banka_oku['resim'].'" style="width:95%;" />
							</td>
							<td>
								<input type="checkbox" name="y_c1_'.$banka_oku['id'].'" id="y_c1_'.$banka_oku['id'].'" value="1" '.$c1_s.' />
							</td>
							<td>
								<input type="checkbox" name="y_c3_'.$banka_oku['id'].'" id="y_c3_'.$banka_oku['id'].'" value="1" '.$c3_s.' />
							</td>
							<td>
								<input type="checkbox" name="y_c6_'.$banka_oku['id'].'" id="y_c6_'.$banka_oku['id'].'" value="1" '.$c6_s.' />
							</td>
							<td>
								<input type="checkbox" name="y_c9_'.$banka_oku['id'].'" id="y_c9_'.$banka_oku['id'].'" value="1" '.$c9_s.' />
							</td>
							<td>
								 <input type="checkbox" name="sil_'.$banka_oku['id'].'" id="sil_'.$banka_oku['id'].'" value="1" />
							</td>
						</tr>';
	}
?>

<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="tab-pane" style="margin-top:20px;">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs"></i>Banka Ayarları</h4>
			</div>
			<div class="portlet-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Adı</th>
							<th>Şube Adı</th>
							<th>Şube Kodu</th>
							<th>Hesap No</th>
							<th>IBAN</th>
							<th>Resim</th>
							<th>T 1</th>
							<th>T 3</th>
							<th>T 6</th>
							<th>T 9</th>
							<th>Sil</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $bankalar; ?>
						<tr>
							<td>
								Yeni
							</td>
							<td>
								<input type="text" placeholder="Banka Adı" name="y_adi" id="y_adi" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="Şube Adı" name="y_sube_adi" id="y_sube_adi" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="Şube Kodu" name="y_sube_kodu" id="y_sube_kodu" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="Hesap No" name="y_hesap_no" id="y_hesap_no" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="IBAN" name="y_iban" id="y_iban" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="Resim" name="y_resim" id="y_resim" style="width:95%;" />
							</td>
							<td>
								<input type="checkbox" name="y_c1" id="y_c1" value="1" />
							</td>
							<td>
								<input type="checkbox" name="y_c3" id="y_c3" value="1" />
							</td>
							<td>
								<input type="checkbox" name="y_c6" id="y_c6" value="1" />
							</td>
							<td>
								<input type="checkbox" name="y_c9" id="y_c9" value="1" />
							</td>
							<td>
								 <input type="submit" class="btn blue kat_kayit" name="islemleri" value="Tümünü Kaydet" style="margin-left:auto;" />
							</td>
						</tr>
					</tbody>
				</table>
				
			</div>
			</div>
		</div>
</form>