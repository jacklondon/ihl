<style>
	.radio_k_class{float:left; margin-right:10px;}
</style>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/referans/referans_guncelle.php'); ?>
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Referans Ekle</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
				   	<div class="control-group">
						<label class="control-label">Referans Görsel</label>
						<div class="controls">
							<input type="file" name="files[]" id="files[]"  />   
							<input type="hidden" name="mevcut_resim" value="<?=$resim ?>"/>						
						</div>
					</div>
					<div class="control-group">
					  <label class="control-label">Durum</label>
					  <div class="controls">
							<label class="radio_k_class">
								<input type="radio" value="1" name="durum" <?php echo($mevcut_durum==1) ? "checked" : ""   ?> />
								<div style="float:right; padding-top:1px; margin-left:4px;">
									Aktif
								</div>
							</label>
							<label class="radio_k_class">
								<input  type="radio" value="0" name="durum" <?php echo($mevcut_durum==0) ?  "checked" : ""   ?> />
								<div style="float:right; padding-top:1px; margin-left:4px;">
									Pasif
								</div>
							</label>
					  </div>
					</div>	
				   <div class="form-actions">
						<input type="submit" name="referans_guncelle" class="btn blue" value="Referans Güncelle" />
					</div>
				</div>
				
				<!-- END FORM-->           
			 </div>
		  </div>
		  <!-- END SAMPLE FORM PORTLET-->
	   </div>
	</div>
</form>
