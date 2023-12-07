<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="portlet box blue" style="margin-top:20px;">
		<div class="portlet-title">
			<h4><i class="icon-cogs"></i>Ödeme Türleri</h4>
		</div>
		<div class="portlet-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Tanım</th>
						<th>Durum</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
					
						if(re('pasif_yap') != "")
						{
							mysql_query("update s_odeme_tur set durum='0' where id='".re('pasif_yap')."' ");
						}
						
						if(re('aktif_yap') != "")
						{
							
							$islem_devam="evet";
							if(re('aktif_yap')==1)
							{
								if ( $ozellik_oku['site_ssl'] == 1 and $ozellik_oku['pos'] == 1 )
								{
								}
								else
								{
									$mayir=' ve ';
									$m1='<font color="red">POS Modülleri</font>';
									$m2='<font color="red">SSL Modülü</font>';
									if ( $ozellik_oku['site_ssl'] == 1 ) { $m2=''; $mayir=''; }
									if ( $ozellik_oku['pos'] == 1 ) { $m1=''; $mayir=''; }
									
									$islem_devam="hayir";
									$hata_msg='Kredi Kartı Özelliği İçin <b>"Ayarlar > Site Tasarım"</b> bölümünden '.$m1.$mayir.$m2.' Aktif edilmelidir.';
								}
							}
							
							
							if( $islem_devam == "evet" )
							{
								mysql_query("update s_odeme_tur set durum='1' where id='".re('aktif_yap')."' ");
							}
							else
							{
								echo $hata_msg;
							}
						}
					
						$ek_say = 0;
						$fiyat_cek = mysql_query("select * from s_odeme_tur ORDER BY id ASC ");
						while($fiyat_oku = mysql_fetch_array($fiyat_cek))
						{
							$ek_say++;
							$btn='';
							if ($fiyat_oku['id'] == 1)
							{
								$btn='<a href="?modul=ayarlar&sayfa=pos_ayarlari" class="btn mini blue"><i class="icon-edit"></i>Pos Ayarları</a>';
							}
							
							$durum = '';
							if($fiyat_oku['durum'] == 1)
							{
								$durum = '<a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&pasif_yap='.$fiyat_oku['id'].'" class="btn mini green"><i class="icon-edit"></i>Pasif Yap</a>';
							}
							if($fiyat_oku['durum'] == 0)
							{
								$durum = '<a href="?modul='.re('modul').'&sayfa='.re('sayfa').'&aktif_yap='.$fiyat_oku['id'].'" class="btn mini red"><i class="icon-edit"></i>Aktif Yap</a>';
							}
							
							echo '<tr>
									<td>
										'.$ek_say.'
									</td>
									<td>
										'.$fiyat_oku['adi'].'
									</td>
									<td>
										'.$durum.' '.$btn.'
									</td>
								</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</form>