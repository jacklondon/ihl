<style>
	.radio_k_class{float:left; margin-right:10px;}
</style>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/iletisim/iletisim_guncelle.php'); ?>
	<div class="row-fluid" style="margin-top:20px;">
		<div class="span12">
			<!-- BEGIN SAMPLE FORM PORTLET-->   
			<div class="portlet box blue">
				<div class="portlet-title">
					<h4><i class="icon-reorder"></i>İletişim Düzenle</h4>
					<div class="tools">
					</div>
				</div>
				<div class="portlet-body form">
					<!-- BEGIN FORM-->
					<div class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Adres</label>
							<div class="controls">
								<textarea type="text" name="adres" id="adres" ><?=$mevcut_adres ?></textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Sabit Hat</label>
							<div class="controls">
								<input type="text"  name="sabit_hat" id="sabit_hat" value="<?=$mevcut_sabit_hat ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Fax ve SMS</label>
							<div class="controls">
								<input type="text"  name="fax_sms" id="fax_sms" value="<?=$mevcut_fax_sms ?>" />
							</div>
						</div>
						<div class="control-group">
							<!--<label class="control-label">Telefon(Birden fazla numaranız varsa numara aralarına "/" koyarak ekleyebilirsiniz. )</label>-->
							<label class="control-label">Telefon</label>
							<div class="controls">
								<input type="text"  name="telefon" id="telefon" value="<?=$mevcut_telefon ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Email</label>
							<div class="controls">
								<input type="text"  name="email" id="email" value="<?=$mevcut_email ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Skype</label>
							<div class="controls">
								<input type="text"  name="skype" id="skype" value="<?=$mevcut_skype ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Facebook</label>
							<div class="controls">
								<input type="text"  name="facebook" id="facebook" value="<?=$mevcut_facebook ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Twitter</label>
							<div class="controls">
								<input type="text"  name="twitter" id="twitter" value="<?=$mevcut_twitter ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Instagram</label>
							<div class="controls">
								<input type="text"  name="instagram" id="instagram" value="<?=$mevcut_instagram ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Youtube</label>
							<div class="controls">
								<input type="text"  name="youtube" id="youtube" value="<?=$mevcut_youtube ?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">iFrame<br>(https://google-map-generator.com/ linkinden iFrame oluşuturup "src" kısmının eşitliğinde yazan metini almalısınız.)</label>
							<div class="controls">
								<input type="text"  name="iframe" id="iframe" value="<?=$mevcut_iframe ?>" />
							</div>
						</div>
						<div class="form-actions">
							<input type="submit" name="iletisim_guncelle" class="btn blue" value="İletişim Güncelle" />
						</div>
					</div>
					<!-- END FORM-->           
				</div>
			</div>
			<!-- END SAMPLE FORM PORTLET-->
		</div>
	</div>
</form>
