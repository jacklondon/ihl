<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="portlet box blue" style="margin-top:20px;">
		<div class="portlet-title">
			<h4><i class="icon-cogs"></i>Döviz Ayarları</h4>
		</div>
		<div class="portlet-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Tanım</th>
						<th>Sembol</th>
						<th>Tutar</th>
						<th>İşlem</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						if(re('fiyatlari') == "Kaydet")
						{
							$doviz_cek = mysql_query("select * from s_dovizler where durum!='0' ORDER BY id ASC ");
							while($doviz_oku = mysql_fetch_array($doviz_cek))
							{
								mysql_query("update s_dovizler set adi='".re('adi_'.$doviz_oku['id'])."', sembol='".re('sembol_'.$doviz_oku['id'])."', tutar='".re('tutar_'.$doviz_oku['id'])."' where id='".$doviz_oku['id']."' ");
							}
							
							if(re('adi') != "" and re('sembol') != "" and re('tutar') != "")
							{
								mysql_query("insert into s_dovizler (adi,sembol,tutar,e_tarihi,durum) values ('".re('adi')."','".re('sembol')."','".re('tutar')."','".mktime()."','1') ");
							}
						}
						
						if(re('ana_yap') != "")
						{
							mysql_query("update s_dovizler set aktif='0' ");
							mysql_query("update s_dovizler set aktif='1' where id='".re('ana_yap')."' ");
						}
					
						$ek_say = 0;
						$doviz_cek = mysql_query("select * from s_dovizler where durum!='0' ORDER BY id ASC ");
						while($doviz_oku = mysql_fetch_array($doviz_cek))
						{
							$ek_say++;
							
							$durum = '';
							if($doviz_oku['aktif'] == 1)
							{
								$durum = '<a class="btn mini green"><i class="icon-edit"></i>Ana Döviz</a>';
							}
							else
							{
								$durum = '<a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&ana_yap='.$doviz_oku['id'].'" class="btn mini gray"><i class="icon-edit"></i>Ana Döviz Yap</a>';
							}
							
							echo '<tr>
									<td>
										'.$ek_say.'
									</td>
									<td>
										<input type="text" name="adi_'.$doviz_oku['id'].'" value="'.$doviz_oku['adi'].'" />
									</td>
									<td>
										<input type="text" name="sembol_'.$doviz_oku['id'].'" value="'.$doviz_oku['sembol'].'" />
									</td>
									<td>
										<input type="text" name="tutar_'.$doviz_oku['id'].'" value="'.$doviz_oku['tutar'].'" />
									</td>
									<td>
										'.$durum.'
										<a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&sil='.$doviz_oku['id'].'" class="btn mini red"><i class="icon-edit"></i>Sil</a>
									</td>
								</tr>';
						}
					?>
					<tr>
						<td>
							Yeni
						</td>
						<td>
							<input type="text" name="adi" />
						</td>
						<td>
							<input type="text" name="sembol" />
						</td>
						<td>
							<input type="text" name="tutar" />
						</td>
						<td>
							<input type="submit" class="btn blue kat_kayit" name="fiyatlari" value="Kaydet" style="margin-left:auto;">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</form>