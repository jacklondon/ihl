<style>
	.detay_yazisi{font-size:12px; font-weight:bold;}
	.paddingleri{padding-top:13px; padding-bottom:13px;}
</style>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/indirimler/yeni_indirim_ekle.php'); ?>
	<div class="row-fluid" style="margin-top:20px;">
		<div class="span12"> 
			<div class="portlet box blue">
				<div class="portlet-title">
					<h4><i class="icon-reorder"></i>Yeni İndirim Ekle</h4>
					<div class="tools">
					</div>
				</div>
				<div class="portlet-body form">
					<div class="form-horizontal">
						<div class="control-group">
							<label class="control-label detay_yazisi">İndirim Adı</label>
							<div class="controls">
								<input type="text" class="span6 m-wrap" name="adi" id="adi" value="" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label detay_yazisi">İndirimde Tarih Aralığı Geçerli Olsun mu?</label>
							<div class="controls">
								<label class="radio">
									<input type="radio" name="zaman" value="1" onclick="bas_bit_islem(1);" />
									Evet
								</label>
								<label class="radio">
									<input type="radio" name="zaman" value="0" onclick="bas_bit_islem(0);" />
									Hayır
								</label>
							</div>
						</div>
						
						<div id="bas_bit_tar" style="display:none;">
							<div class="control-group">
								<label class="control-label detay_yazisi">İndirim Başlangıç Tarihi</label>
								<div class="controls">
									<input class="span2 m-wrap m-ctrl-medium date-picker" size="16" type="text" name="bas_tarihi" id="bas_tarihi" value="<?php echo date('d.m.Y'); ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label detay_yazisi">İndirim Bitiş Tarihi</label>
								<div class="controls">
									<input class="span2 m-wrap m-ctrl-medium date-picker" size="16" type="text" name="bit_tarihi" id="bit_tarihi" value="<?php $gunu = date('d')+1; echo $gunu.date('.m.Y'); ?>" />
								</div>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label detay_yazisi">İndirim Tanımı</label>
							<div class="controls">
								<label class="radio">
									<input type="radio" name="tanim" value="1" onclick="tanim_tik(1);" />
									Sepet Bazlı İndirim
								</label>
								<label class="radio">
									<input type="radio" name="tanim" value="2" onclick="tanim_tik(2);" />
									Ürün Bazlı İndirim
								</label>
								<label class="radio">
									<input type="radio" name="tanim" value="3" onclick="tanim_tik(3);" />
									Özellik Bazlı İndirim
								</label>
								<label class="radio">
									<input type="radio" name="tanim" value="4" onclick="tanim_tik(4);" />
									Kampanya Bazlı İndirim
								</label>
							</div>
						</div>
						
						<div id="indirim_ozellikleri" style="display:none;">
							<div class="control-group" id="d_max_kullanim">
								<label class="control-label detay_yazisi">Max Kullanım Sayısı</label>
								<div class="controls">
									<input type="text" class="span2 m-wrap" name="max_kullanim" id="max_kullanim" value="" />
								</div>
							</div>
							
							<div class="control-group" id="d_uye_grup">
								<label class="control-label detay_yazisi">Üye/Bayi Grubu</label>
								<div class="controls">
									<select class="span6 chosen" tabindex="1" name="uye_grup" id="uye_grup" >
										<option value="0">Tümü</option>
										<?php 
											$gruplari_cek = mysql_query("select * from kullanicilar_grup where durum='1' ORDER BY id ASC ");
											while($gruplari_oku = mysql_fetch_array($gruplari_cek))
											{
												echo '<option value="'.$gruplari_oku['id'].'">'.$gruplari_oku['adi'].'</option>';
											}
										?>
									</select>
								</div>
							</div>
							
							<div class="control-group" id="d_min_tutar">
								<label class="control-label detay_yazisi">Minimum Alışveriş Tutarı</label>
								<div class="controls">
									<input type="text" class="span2 m-wrap" name="min_tutar" id="min_tutar" value="" />
								</div>
							</div>
							
							<div class="control-group" id="d_min_adet">
								<label class="control-label detay_yazisi">Minimum Ürün Adeti</label>
								<div class="controls">
									<input type="text" class="span2 m-wrap" name="min_adet" id="min_adet" value="" />
								</div>
							</div>
							
							<div class="control-group" id="d_urun_indirimi">
								<label class="control-label detay_yazisi">Ayrıca İndirimli Ürün Tanımlamak İster misiniz?</label>
								<div class="controls">
									<label class="checkbox">
										<input type="checkbox" name="urun_indirimi" id="urun_indirimi" value="1" onclick="indirimlimi_urunler();" />
									</label>
								</div>
							</div>
							
							
							<div class="control-group" id="d_indirimli_urun" style="display:none;">
								<label class="control-label detay_yazisi">İndirimli Ürün ID'leri</label>
								<div class="controls">
									<input type="text" class="span6 m-wrap" name="urunler_id" id="urunler_id" value="" />
									<div class="btn icn-only green paddingleri"><i class="icon-plus"></i></div>
								</div>
							</div>
							
							
							<div class="control-group" id="d_indirim_tipi">
								<label class="control-label detay_yazisi">İndirim Tipi</label>
								<div class="controls">
									<select class="span6 chosen" tabindex="1" name="indirim_tip" id="indirim_tip" >
										<option value="1">İndirim Miktarı (KDV Dahil)</option>
										<option value="2">% İndirim</option>
									</select>
								</div>
							</div>
							
							<div class="control-group" id="d_indirim_degeri">
								<label class="control-label detay_yazisi">İndirim Değeri</label>
								<div class="controls">
									<input type="text" class="span6 m-wrap" name="indirim_miktar" id="indirim_miktar" value="" />
								</div>
							</div>
							
							<div class="control-group" id="d_indirim_aciklamasi">
								<label class="control-label detay_yazisi">İndirim Açıklaması</label>
								<div class="controls">
									<textarea class="span6 m-wrap" rows="3" name="aciklama" id="aciklama" ></textarea>
								</div>
							</div>
						</div>
						
						
						<div class="form-actions">
							<input type="submit" class="btn blue" name="indirimi" value="Kaydet" />
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	
	function bas_bit_islem(sayi)
	{
		if(sayi == 1)
		{
			$("#bas_bit_tar").fadeIn();
		}
		if(sayi == 0)
		{
			$("#bas_bit_tar").fadeOut();
		}
	}
	
	function indirimlimi_urunler()
	{
		if(document.getElementById("urun_indirimi").checked == true)
		{
			$("#d_indirimli_urun").fadeIn();
		}
		else
		{
			$("#d_indirimli_urun").fadeOut();
		}
	}
	
	function tanim_tik(sayi)
	{
		$("#indirim_ozellikleri").fadeIn();
		
		$("#d_min_adet").fadeOut();
		document.getElementById("urun_indirimi").checked = false;
		$("#d_indirimli_urun").fadeOut();
		if(sayi == 1)
		{
		
		}
		if(sayi == 2)
		{
			$("#d_min_adet").fadeIn();
		}
		if(sayi == 3)
		{
			$("#d_min_adet").fadeIn();
		}
	}

	
	var myCalendar;
	function doOnLoad() {
		myCalendar = new dhtmlXCalendarObject(["bas_tar","bit_tar"]);
	}
	
</script>