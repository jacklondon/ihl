<?php 
	$detay_cek=mysql_query("select * from pos_ayari_detay where p_id='".re('p_id')."' and tip_id='".re('tip_id')."'");
	$detay_oku=mysql_fetch_assoc($detay_cek);
	
	if(re('islemleri')=='Tümünü Kaydet')
	{
		$kontrol=mysql_num_rows($detay_cek);
		if($kontrol>0)
		{
			mysql_query("UPDATE pos_ayari_detay SET 
			uc_taksit='".re('uc_taksit')."',
			alti_taksit='".re('alti_taksit')."',
			dokuz_taksit='".re('dokuz_taksit')."',
			oniki_taksit='".re('oniki_taksit')."',
			yirmidort_taksit='".re('yirmidort_taksit')."',
			e_tarihi='".mktime()."',
			durum='1'
			WHERE p_id='".re('p_id')."' and tip_id='".re('tip_id')."'")or die(mysql_error());
			header('Location: ?modul=ayarlar&sayfa=pos_ayari_taksit&p_id='.re('p_id').'&tip_id='.re('tip_id'));
		}
		else
		{
			mysql_query("INSERT INTO pos_ayari_detay (
			p_id,
			tip_id,
			uc_taksit,
			alti_taksit,
			dokuz_taksit,
			oniki_taksit,
			yirmidort_taksit,
			e_tarihi,
			durum
			) VALUES (
			'".re('p_id')."',
			'".re('tip_id')."',
			'".re('uc_taksit')."',
			'".re('alti_taksit')."',
			'".re('dokuz_taksit')."',
			'".re('oniki_taksit')."',
			'".re('yirmidort_taksit')."',
			'".mktime()."',
			'1')");
			header('Location: ?modul=ayarlar&sayfa=pos_ayari_taksit&p_id='.re('p_id').'&tip_id='.re('tip_id'));
		}
	}
?>

<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="tab-pane" style="margin-top:20px;">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs"></i>Pos Detay</h4>
			</div>
			<div class="portlet-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>3 Taksit</th>
							<th>6 Taksit</th>
							<th>9 Taksit</th>
							<th>12 Taksit</th>
							<th>24 Taksit</th>
							<th>İşlem</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								#
							</td>
							<td>
								<input type="text" placeholder="3 Taksit Oranı" name="uc_taksit" id="uc_taksit" style="width:95%;" value="<?php echo $detay_oku['uc_taksit']; ?>"/>
							</td>
							<td>
								<input type="text" placeholder="6 Taksit Oranı" name="alti_taksit" id="alti_taksit" style="width:95%;" value="<?php echo $detay_oku['alti_taksit']; ?>"/>
							</td>
							<td>
								<input type="text" placeholder="9 Taksit Oranı" name="dokuz_taksit" id="dokuz_taksit" style="width:95%;" value="<?php echo $detay_oku['dokuz_taksit']; ?>"/>
							</td>
							<td>
								<input type="text" placeholder="12 Taksit Oranı" name="oniki_taksit" id="oniki_taksit" style="width:95%;" value="<?php echo $detay_oku['oniki_taksit']; ?>"/>
							</td>
							<td>
								<input type="text" placeholder="24 Taksit Oranı" name="yirmidort_taksit" id="yirmidort_taksit" style="width:95%;" value="<?php echo $detay_oku['yirmidort_taksit']; ?>"/>
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