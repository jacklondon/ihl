 <style>
	.radio_k_class{float:left; margin-right:10px;}
</style>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/iletisim/bayi_ekle.php'); ?>
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Bayi Ekle</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
					<div class="control-group">
					  <label class="control-label">Bayi Adı</label>
					  <div class="controls">
						 <input type="text"  name="bayi_adi" id="bayi_adi" value="" />
					  </div>
				   </div>
				   <div class="form-actions">
						<input type="submit" name="bayi_kaydet" class="btn blue" value="Bayi Kaydet" />
					</div>
				</div>
				<!-- END FORM-->           
			 </div>
		  </div>
		  <!-- END SAMPLE FORM PORTLET-->
	   </div>
	</div>
</form>