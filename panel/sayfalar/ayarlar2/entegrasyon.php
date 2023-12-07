<?php 
	if(re('tanimlari')=='Kaydet')
	{
		mysql_query("UPDATE entegrasyon SET 
		merchant_id='".re('merchant_id')."',
		merchant_key='".re('merchant_key')."',
		merchant_salt='".re('merchant_salt')."',
		hesap_sahibi='".re('hesap_sahibi')."',
		iban_no	='".re('iban_no')."' WHERE id='1'");
		
		header("Location: ?modul=ayarlar&sayfa=entegrasyon");
	}	
	
	$entegre_cek=mysql_query("select * from entegrasyon where durum='1' and id='1'");
	$entegre_oku=mysql_fetch_assoc($entegre_cek);
?>
<form method="POST" enctype="multipart/form-data" id="form" name="form">
	<div class="row-fluid" style="margin-top:25px;">
		<div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
			<div class="portlet box blue">
				<div class="portlet-title">
					<h4><i class="icon-reorder"></i>Paytr Entegrasyon</h4>
					<div class="tools">
					</div>
				</div>
				<div class="portlet-body form">
				<!-- BEGIN FORM-->
					<div class="form-horizontal">
					
						<h3> Entegre Bilgileri </h3>
						
						<div class="control-group">
						  <label class="control-label">Mağaza Numarası</label>
						  <div class="controls">
							 <input type="text" class="span6 m-wrap" name="merchant_id" id="merchant_id" value="<?php echo $entegre_oku['merchant_id']; ?>">
							 <span class="help-inline"><small>Entegrede "merchant_id" Değerine Eşittir.</small></span>
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label">Mağaza Parola</label>
						  <div class="controls">
							 <input type="text" class="span6 m-wrap" name="merchant_key" id="merchant_key" value="<?php echo $entegre_oku['merchant_key']; ?>">
							 <span class="help-inline"><small>Entegrede "merchant_key" Değerine Eşittir.</small></span>
						  </div>
						</div>
						
						<div class="control-group">
						  <label class="control-label">Mağaza Gizli Anahtar</label>
						  <div class="controls">
							 <input type="text" class="span6 m-wrap" name="merchant_salt" id="merchant_salt" value="<?php echo $entegre_oku['merchant_salt']; ?>">
							 <span class="help-inline"><small>Entegrede "merchant_salt" Değerine Eşittir.</small></span>
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label">Hesap Sahibi</label>
						  <div class="controls">
							 <input type="text" class="span6 m-wrap" name="hesap_sahibi" id="hesap_sahibi" value="<?php echo $entegre_oku['hesap_sahibi']; ?>">
							 <span class="help-inline"><small></small></span>
						  </div>
						</div>
						<div class="control-group">
						  <label class="control-label">IBAN NO</label>
						  <div class="controls">
							 <input type="text" class="span6 m-wrap" name="iban_no" id="iban_no" value="<?php echo $entegre_oku['iban_no']; ?>">
							 <span class="help-inline"><small></small></span>
						  </div>
						</div>
						<div class="form-actions">
							<input type="submit" name="tanimlari" class="btn blue" value="Kaydet">
					   </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p><b>Not : </b>Bu Alanda Girilecek Olan Verilere Ulaşmak İçin "PAYTR" Tarafından Verilmiş Olan Kullanıcı Bilgilerinizle Kontrol Panelinize Giriş Yapınız.
	Ardından Sol Tarafa Yaslı Olan Menülerden "Bilgi" Adlı Menüye Giriş Yapınız.
	Karşınıza Çıkacak Olan Dökümanlardan "API Entegrasyon Bilgileri" Başlığı Altında Olan Verileri Üst Alanda Bulunan İlgili Yerlere Kaydederek İşleminizi Sonlandırabilirsiniz. </p>
</form>
					