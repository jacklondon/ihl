<style>
	.radio_k_class{float:left; margin-right:10px;}
</style>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/hakkimizda/hakkimizda_islemleri.php'); ?>
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Hakkımızda Düzenle</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
					<div class="control-group">
					  <label class="control-label">Başlık</label>
					  <div class="controls">
						 <input type="text" name="baslik" id="baslik" value="<?=$mevcut_baslik ?>" ></input>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label">Açıklama</label>
					  <div class="controls">
						 <textarea name="aciklama" id="aciklama" ><?=$mevcut_aciklama ?></textarea>
					  </div>
				   </div>
				   	<div class="control-group">
						<label class="control-label">Görsel</label>
						<div class="controls">
							<input type="file" name="files[]" id="files[]"  />   
							<input type="hidden" name="mevcut_resim" value="<?=$mevcut_resim ?>"/>						
						</div>
					</div>				   
				   <div class="form-actions">
						<input type="submit" name="hakkimizda_guncelle" class="btn blue" value="Güncelle" />
					</div>
				</div>
				<!-- END FORM-->           
			 </div>
		  </div>
		  <!-- END SAMPLE FORM PORTLET-->
	   </div>
	</div>
		
</form>



