<style>
	.radio_k_class{float:left; margin-right:10px;}
</style>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/slider/slider_ekle.php'); ?>
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
						 <input type="text"  name="baslik" id="baslik" value="" />
					  </div>
				   </div>
				   	<div class="control-group">
					  <label class="control-label">Açıklama</label>
					  <div class="controls">
						 <textarea type="text" name="aciklama" id="aciklama" ></textarea>
					  </div>
				   </div>
				   	<div class="control-group">
					  <label class="control-label">Durum</label>
					  <div class="controls">
							<label class="radio_k_class">
								<input type="radio" value="1" name="durum" />
								<div style="float:right; padding-top:1px; margin-left:4px;">
									Aktif
								</div>
							</label>
							<label class="radio_k_class">
								<input  type="radio" value="0" name="durum"  />
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
						</div>
					</div>
				   <div class="form-actions">
						<input type="submit" name="slider_kaydet" class="btn blue" value="Slider Kaydet" />
					</div>
				</div>
				<!-- END FORM-->           
			 </div>
		  </div>
		  <!-- END SAMPLE FORM PORTLET-->
	   </div>
	</div>
</form>