<?php 
	
	if(re('islemleri') == "Tümünü Kaydet")
	{
		$ipleri_cek = mysql_query("select * from s_engelli_ip where durum='1' ORDER BY e_tarihi ASC ");
		while($ipleri_oku = mysql_fetch_array($ipleri_cek))
		{
			mysql_query("update s_engelli_ip set ip='".re('ip_'.$ipleri_oku['id'])."' where id='".$ipleri_oku['id']."' ");
			
			if(re('sil_'.$ipleri_oku['id']) == 1)
			{
				mysql_query("update s_engelli_ip set durum='0' where id='".$ipleri_oku['id']."' ");
			}
		}
		
		if(re('y_ip') != "")
		{
			mysql_query("insert into s_engelli_ip (ip,e_tarihi,durum) values ('".re('y_ip')."','".mktime()."','1') ");
		}
	}
	
	$engelliler = '';
	$k_sayi = 0;
	$ipleri_cek = mysql_query("select * from s_engelli_ip where durum='1' ORDER BY e_tarihi ASC ");
	while($ipleri_oku = mysql_fetch_array($ipleri_cek))
	{
		$k_sayi++;
		
		$engelliler .= '<tr>
							<td>
								'.$k_sayi.'
							</td>
							<td>
								<input type="text" class="yeni_inputlar" name="ip_'.$ipleri_oku['id'].'" id="ip_'.$ipleri_oku['id'].'" value="'.$ipleri_oku['ip'].'" />
							</td>
							<td>
								 <input type="checkbox" name="sil_'.$ipleri_oku['id'].'" id="sil_'.$ipleri_oku['id'].'" value="1" />
							</td>
						</tr>';
	}
?>

<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="tab-pane" style="margin-top:20px;">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs"></i>Siteye Girişi Engellenen IP'ler</h4>
			</div>
			<div class="portlet-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Grup Adı</th>
							<th>Sil</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $engelliler; ?>
						<tr>
							<td>
								Yeni
							</td>
							<td>
								<input type="text" placeholder="Engellenecek IP" class="yeni_inputlar" name="y_ip" id="y_ip" />
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