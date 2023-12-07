<style>
	.radio_k_class{float:left; margin-right:10px;}
	.chec
		{
			opacity:1!important;
			z-index:999!important;
		}
</style>
<script src="assets/ckeditor4/ckeditor.js"></script>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/slider/slider_guncelle.php'); ?>
	<div class="row-fluid" style="margin-top:20px;">
		<div class="span12">
			<!-- BEGIN SAMPLE FORM PORTLET-->   
			<div class="portlet box blue">
				<div class="portlet-title">
					<h4><i class="icon-reorder"></i>Slider Ekle</h4>
					<div class="tools">
					</div>
				</div>
				<div class="portlet-body form">
					<!-- BEGIN FORM-->
					<text>1920 * 1080 boyutlarında yükleme yapabilirsiniz.</text>
					<div class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Başlık</label>
							<div class="controls">
								<input type="text"  name="baslik" id="baslik" value="<?=$mevcut_baslik ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Açıklama</label>
							<div class="controls">
								<textarea type="text" name="aciklama" id="aciklama"  ><?=$mevcut_aciklama ?></textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Buton Durum</label>
							<div class="controls">
								<label class="radio_k_class">
									<input style="opacity:1!important; z-index:999;margin-left:1px;margin-top:-1px;" class="chec" type="radio" value="1" name="button" <?php echo($mevcut_button==1) ? "checked" : ""   ?> />
									<div style="float:right; padding-top:1px; margin-left:4px;">
										Aktif
									</div>
								</label>
								<label class="radio_k_class">
									<input style="opacity:1!important; z-index:999;margin-left:1px;margin-top:-1px;" class="chec"  type="radio" value="0" name="button" <?php echo($mevcut_button==0) ?  "checked" : ""   ?> />
									<div style="float:right; padding-top:1px; margin-left:4px;">
										Pasif
									</div>
								</label>
							</div>
						</div>	
						<div class="control-group">
							<label class="control-label">Buton Yeri</label>
							<div class="controls">
								<label class="radio_k_class">
									<input style="opacity:1!important; z-index:999;margin-left:1px;margin-top:-1px;" class="chec" type="radio" value="0" name="button_yer_secimi" <?php echo($mevcut_button_yer==0) ?  "checked" : ""    ?> />
									<div style="float:right; padding-top:1px; margin-left:4px;">
										Aşağı Sol
									</div>
								</label>
								<label class="radio_k_class">
									<input style="opacity:1!important; z-index:999;margin-left:1px;margin-top:-1px;" class="chec"  type="radio" value="1" name="button_yer_secimi" <?php echo($mevcut_button_yer==1) ?  "checked" : ""   ?> />
									<div style="float:right; padding-top:1px; margin-left:4px;">
										Aşağı Sağ
									</div>
								</label>
								<label class="radio_k_class">
									<input style="opacity:1!important; z-index:999;margin-left:1px;margin-top:-1px;" class="chec"  type="radio" value="2" name="button_yer_secimi" <?php echo($mevcut_button_yer==2) ?  "checked" : ""   ?> />
									<div style="float:right; padding-top:1px; margin-left:4px;">
										Yukarı Sol
									</div>
								</label>
								<label class="radio_k_class">
									<input style="opacity:1!important; z-index:999;margin-left:1px;margin-top:-1px;" class="chec" type="radio" value="3" name="button_yer_secimi" <?php echo($mevcut_button_yer==3) ?  "checked" : ""   ?> />
									<div style="float:right; padding-top:1px; margin-left:4px;">
										Yukarı Sağ
									</div>
								</label>
							</div>
						</div>	
						<div class="control-group">
							<label class="control-label">Sayfa İçeriği</label>
							<div class="controls">
								<textarea type="text" name="editor" id="editor"  ><?=$mevcut_button_editor ?></textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Durum</label>
							<div class="controls">
								<label class="radio_k_class">
									<input style="opacity:1!important; z-index:999;margin-left:1px;margin-top:-1px;" class="chec" type="radio" value="1" name="durum" <?php echo($mevcut_durum==1) ? "checked" : ""   ?> />
									<div style="float:right; padding-top:1px; margin-left:4px;">
										Aktif
									</div>
								</label>
								<label class="radio_k_class">
									<input style="opacity:1!important; z-index:999;margin-left:1px;margin-top:-1px;" class="chec" type="radio" value="0" name="durum" <?php echo($mevcut_durum==0) ?  "checked" : ""   ?> />
									<div style="float:right; padding-top:1px; margin-left:4px;">
										Pasif
									</div>
								</label>
							</div>
						</div>		   
						<div class="control-group">
							<label class="control-label">Slider Görsel</label>
							<div class="controls">
								<input type="file" name="files[]" id="files[]"  />   
								<input type="hidden" name="mevcut_resim" value="<?=$resim ?>"/>						
							</div>
						</div>
						<div class="form-actions">
							<input type="submit" name="slider_guncelle" class="btn blue" value="Slider Güncelle" />
						</div>
					</div>
					<!-- END FORM-->           
				</div>
			</div>
			<!-- END SAMPLE FORM PORTLET-->
		</div>
	</div>
</form>
<script>
	CKEDITOR.replace( 'editor', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	} );
</script>