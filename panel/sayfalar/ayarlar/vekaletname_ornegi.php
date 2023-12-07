<style>
	.radio_k_class{float:left; margin-right:10px;}
</style>
<?php include('islemler/ayarlar/vekaletname_ornegi.php'); ?>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>PDF Düzenle</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
				   	<div class="control-group">
						<label class="control-label">Vekaletname PDF</label>
						<div class="controls">
							<input type="file" name="files[]" id="files[]"  />   
							<input type="hidden" name="mevcut_pdf" value="<?=$mevcut_pdf ?>"/>						
						</div>
					</div>				   					
					<div class="form-actions">
						<input type="submit" name="pdf_guncelle" class="btn blue" value="Güncelle" />
					</div>
				</div>
				<!-- END FORM-->           
			 </div>
		  </div>
		  <!-- END SAMPLE FORM PORTLET-->
	   </div>
	</div>		
</form>

<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Word Düzenle</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
				   	<div class="control-group">
						<label class="control-label">Vekaletname Word</label>
						<div class="controls">
							<input type="file" name="files[]" id="files[]"  />   
							<input type="hidden" name="mevcut_word" value="<?=$mevcut_word ?>"/>						
						</div>
					</div>				   					
					<div class="form-actions">
						<input type="submit" name="word_guncelle" class="btn blue" value="Güncelle" />
					</div>
				</div>
				<!-- END FORM-->           
			 </div>
		  </div>
		  <!-- END SAMPLE FORM PORTLET-->
	   </div>
	</div>		
</form>



