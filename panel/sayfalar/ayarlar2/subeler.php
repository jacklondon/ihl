<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/ayarlar/subeler.php'); ?>
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Tanımlamalar</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
					
					<div style="float:left; width:100%;">
						<div style="height:30px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">#ID</p>
						</div>
						<div style="height:30px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">Tanım</p>
						</div>
						<div style="height:30px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">Adres</p>
						</div>
						<div style="height:30px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">Telefon</p>
						</div>
						<div style="height:30px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">Fax</p>
						</div>
						<div style="height:30px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">Mail</p>
						</div>
						<div style="height:30px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">İşlem</p>
						</div>
						
						<?php echo $sube_satirlari; ?>
						
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;">#</p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="tanim_yeni" id="tanim_yeni" placeholder="Tanım 1" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="adres_yeni" id="adres_yeni" placeholder="Adres 1" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="telefon_yeni" id="telefon_yeni" placeholder="Telefon 1" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="fax_yeni" id="fax_yeni" placeholder="Fax 1" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							<p style="font-size:18px; margin-top:3px; margin-left:5px;"><input type="text" style="width:80%;" name="mail_yeni" id="mail_yeni" placeholder="Mail 1" /></p>
						</div>
						<div style="height:37px; width:14.28%; background-color:#f3f2f2; float:left; border-bottom:2px solid gray;">
							
						</div>
					</div>
				   <div class="form-actions">
						<input type="submit" name="tanimlari" class="btn blue" value="Kaydet" style="float:right; margin-top:10px;" />
				   </div>
				</div>
			</div>
		</div>
	  </div>
	</div>
</form>





