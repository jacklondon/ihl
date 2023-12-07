<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/ayarlar/tanimlamalar.php'); ?>
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
					<div class="control-group">
					  <label class="control-label">Site Adı</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_adi" id="site_adi" value="<?php echo $site_oku['site_adi']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Site Kısa Adı</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_kisa_adi" id="site_kisa_adi" value="<?php echo $site_oku['site_kisa_adi']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Title</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="title" id="title" value="<?php echo $site_oku['title']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Author</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="author" id="author" value="<?php echo $site_oku['author']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Description</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="description" id="description" value="<?php echo $site_oku['description']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Keywords</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="keywords" id="keywords" value="<?php echo $site_oku['keywords']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Facebook</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="facebook" id="facebook" value="<?php echo $site_oku['facebook']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Twitter</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="twitter" id="twitter" value="<?php echo $site_oku['twitter']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">İnstagram</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="instagram" id="instagram" value="<?php echo $site_oku['instagram']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Youtube</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="youtube" id="youtube" value="<?php echo $site_oku['youtube']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Google+</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="google" id="google" value="<?php echo $site_oku['google']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Adres</label>
					  <div class="controls">
						  <textarea class="span6 m-wrap" name="adres" id="adres" ><?php echo $site_oku['adres']; ?></textarea>
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Telefon</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="tel" id="tel" value="<?php echo $site_oku['tel']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Email</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="email" id="email" value="<?php echo $site_oku['email']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Maps</label>
					  <div class="controls">
						 <textarea class="span6 m-wrap" name="maps" id="maps" ><?php echo $site_oku['maps']; ?></textarea>
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Site Ana Renk</label>
					  <div class="controls">
						<input type="text" class="span6 m-wrap" name="site_ana_renk" id="site_ana_renk" value="<?php echo $site_oku['site_ana_renk']; ?>" />
						<span class="help-inline">
							<div style="width:20px; height:20px; float:left; background-color:<?php echo $site_oku['site_ana_renk']; ?>; border:1px solid #dadada;"></div>
						</span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Site Geçiş Renk</label>
					  <div class="controls">
						<input type="text" class="span6 m-wrap" name="site_gecis_renk" id="site_gecis_renk" value="<?php echo $site_oku['site_gecis_renk']; ?>" />
						<span class="help-inline">
							<div style="width:20px; height:20px; float:left; background-color:<?php echo $site_oku['site_gecis_renk']; ?>; border:1px solid #dadada;"></div>
						</span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Logo</label>
					  <div class="controls">
						<input type="file" name="site_logo" id="site_logo" />
						<span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Logo</label>
						<div class="controls">
							<div style="float:left; width:100%; margin-top:5px;">
								<div style="float:left; width:100%;">
									<img src="../images/<?php echo $site_oku['site_logo']; ?>" style="float:left; width:150px;" >
								</div>
							</div>
						</div>
					</div>
					<div class="control-group">
					  <label class="control-label">Fav İcon</label>
					  <div class="controls">
						 <input type="file" name="site_favicon" id="site_favicon" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Fav İcon</label>
						<div class="controls">
							<div style="float:left; width:100%; margin-top:5px;">
								<div style="float:left; width:100%;">
									<img src="../images/<?php echo $site_oku['site_favicon']; ?>" style="float:left; width:150px;" >
								</div>
							</div>
						</div>
					</div>
					<div class="control-group">
					  <label class="control-label">Üst Alan Reklamı</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_haber" id="site_haber" value="<?php echo $site_oku['site_haber']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Menü Üst Banner</label>
					  <div class="controls">
						  <input type="file" name="kat_alt_reklam" id="kat_alt_reklam" />
						  <span class="help-inline"></span>
					  </div>
					</div>
					<div class="control-group">
					  <label class="control-label">Menü Üst Banner</label>
						<div class="controls">
							<div style="float:left; width:100%; margin-top:5px;">
								<div style="float:left; width:100%;">
									<img src="../images/<?php echo $site_oku['kat_alt_reklam']; ?>" style="float:left; width:150px;" >
								</div>
							</div>
						</div>
					</div>
				   
				   <div class="form-actions">
						<input type="submit" name="tanimlari" class="btn blue" value="Kaydet" />
				   </div>
				</div>
			</div>
		</div>
	  </div>
	</div>
</form>