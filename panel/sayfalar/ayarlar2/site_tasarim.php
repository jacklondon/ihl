<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/ayarlar/site_tasarim.php'); ?>
	<div class="row-fluid" style="margin-top:-25px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Site Özellikleri</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
				
					<h3> Genel Özellikler </h3>
					
					<div class="control-group">
					  <label class="control-label">Site Title</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_title" id="site_title" value="<?php echo $site_oku['site_title']; ?>" />
						 <span class="help-inline"><small>Arama Motorunda Site Sekmesinde Bulunan Texti Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group hide">
					  <label class="control-label">Tamamlama Eki</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="tamamlama_eki" id="tamamlama_eki" value="<?php echo $site_oku['tamamlama_eki']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Ön İsim</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_on_isim" id="site_on_isim" value="<?php echo $site_oku['site_on_isim']; ?>" />
						 <span class="help-inline"><small>Site Ön İsim Eklemek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Konu</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_konu" id="site_konu" value="<?php echo $site_oku['site_konu']; ?>" />
						 <span class="help-inline"><small>SiteKonusunu Belirtmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Anahtar Kelimeler</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_anahtar_kelime" id="site_anahtar_kelime" value="<?php echo $site_oku['site_anahtar_kelime']; ?>" />
						 <span class="help-inline"><small>Site Seo İçin Önemli Olan Anahtar Kelimeleri Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Kısa İsim</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_kisa_isim" id="site_kisa_isim" value="<?php echo $site_oku['site_kisa_isim']; ?>" />
						 <span class="help-inline"><small>Sitede Kısa İsmi DEğiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Telefon</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_telefon" id="site_telefon" value="<?php echo $site_oku['site_telefon']; ?>" />
						 <span class="help-inline"><small>Sitede Telefon Numarasını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Facebook Adresi</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_face" id="site_face" value="<?php echo $site_oku['site_face']; ?>" />
						 <span class="help-inline"><small>Sitede Facebook Linkini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Twitter Adresi</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_twitter" id="site_twitter" value="<?php echo $site_oku['site_twitter']; ?>" />
						 <span class="help-inline"><small>Sitede Twitter Linkini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Twitter Adresi</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_instagram" id="site_instagram" value="<?php echo $site_oku['site_instagram']; ?>" />
						 <span class="help-inline"><small>Sitede Twitter Linkini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Hakkında Bilgisi</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_hakkinda_bilgisi" id="site_hakkinda_bilgisi" value="<?php echo $site_oku['site_hakkinda_bilgisi']; ?>" />
						 <span class="help-inline"><small>Sitede Hakkında Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Anasayfa Başlıklar</label>
					  <div class="controls">
						<select class="span6 m-wrap" name="ana_sayfa_basliklar" id="ana_sayfa_basliklar">
							<option value="true" <?php echo $ana_sayfa_basliklar_true; ?>>Açık</option>
							<option value="false" <?php echo $ana_sayfa_basliklar_false; ?>>Kapalı</option>
						</select>
						 <span class="help-inline"></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Anasayfa Başlık Sektör</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="ana_sayfa_baslik_sektor" id="ana_sayfa_baslik_sektor" value="<?php echo $site_oku['ana_sayfa_baslik_sektor']; ?>" />
						 <span class="help-inline"><small>Sitede Sektör Adını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Buton Sipariş</label>
					  <div class="controls">
							<select class="span6 m-wrap" name="buton_siparis" id="buton_siparis">
								<option value="true" <?php echo $buton_siparis_true; ?>>Açık</option>
								<option value="false" <?php echo $buton_siparis_false; ?>>Kapalı</option>
							</select>
							<span class="help-inline"><small>Sitede E-Ticaret Modüllerini Aktif Etmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">E-Ticaret</label>
					  <div class="controls">
							<select class="span6 m-wrap" name="e_ticaret" id="e_ticaret">
								<option value="true" <?php echo $e_ticaret_true; ?>>Açık</option>
								<option value="false" <?php echo $e_ticaret_false; ?>>Kapalı</option>
							</select>
						 <span class="help-inline"><small>Sitede E-Ticaret Modüllerini Aktif Etmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<?php 
					
						echo $uyeliksiz_satis_html;
						echo $uyeliksiz_pos_html;
						echo $ssl_modul_html;
					
					?>
					
					
					
					<div class="control-group">
					  <label class="control-label">Seçilen Şehir</label>
					  <div class="controls">
							<select class="span6 m-wrap" name="secilen_sehir" id="secilen_sehir">
								<?php echo $sehir_liste; ?>
							</select>
						 <span class="help-inline"><small>Sitede Şehir Bilgisini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<h3> Tasarımsal Özellikler </h3>
					
					<div class="control-group">
					  <label class="control-label">Site Favicon</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="site_favicon_resim" id="site_favicon_resim" />
							<input type="text" class="span6 m-wrap hide" name="site_favicon" id="site_favicon" value="<?php echo $site_oku['site_favicon']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['site_favicon']; ?>" style="height:50px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Arama Motorunda Site Sekmesinde Title Sol Köşesinde Bulunan İconu Değiştirmek İçin Kullanılır.</small></span>
						</div>
					</div>
					
					
					
					<div class="control-group">
					  <label class="control-label">Site Logo</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="site_logo_resim" id="site_logo_resim" />
							<input type="text" class="span6 m-wrap hide" name="site_logo" id="site_logo" value="<?php echo $site_oku['site_logo']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['site_logo']; ?>" style="height:50px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Sitede Logoyu Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Logo Boyut</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_logo_boyut" id="site_logo_boyut" value="<?php echo $site_oku['logo_boyut']; ?>" />
						 <span class="help-inline"><small>Logonun Boyutunu Belirlemek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Logo Margin</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_logo_margin" id="site_logo_margin" value="<?php echo $site_oku['logo_margin']; ?>" />
						 <span class="help-inline"><small>Logonun Pozisyonunu Üstten Belirlemek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Logo Şeffaf</label>
					  
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="site_logo_seffaf_resim" id="site_logo_seffaf_resim" />
							<input type="text" class="span6 m-wrap hide" name="site_logo_seffaf" id="site_logo_seffaf" value="<?php echo $site_oku['site_logo_seffaf']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['site_logo_seffaf']; ?>" style="height:50px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Footer Sol Alt Köşede Bulunan Logoyu Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Logo Durum</label>
					  <div class="controls">
							<select class="span6 m-wrap" name="logo_durum" id="logo_durum">
								<option value="sagda" <?php echo $logo_durum_sagda; ?>>Sağda</option>
								<option value="ortada" <?php echo $logo_durum_ortada; ?>>Ortada</option>
								<option value="solda" <?php echo $logo_durum_solda; ?>>Solda</option>
							</select>
						 <span class="help-inline"><small>Logonun Yerini Belirtmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					
					
					<div class="control-group">
					  <label class="control-label">Site Color Border</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="site_color_border" id="site_color_border" value="<?php echo $site_oku['site_color_border']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					
					
					
					<div class="control-group">
					  <label class="control-label">Site Arkaplan</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="site_arkaplan_resim" id="site_arkaplan_resim" />
							 <input type="text" class="span6 m-wrap hide" name="site_arkaplan" id="site_arkaplan" value="<?php echo $site_oku['site_arkaplan']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['site_arkaplan']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Site Arkaplan Görselini Değiştirmek İçin Kullanılır.</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Arkaplan Boyut</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_arkaplan_boyut" id="site_arkaplan_boyut" value="<?php echo $site_oku['site_arkaplan_boyut']; ?>" />
						 <span class="help-inline"><small>Site Arkaplan Boyutunu DEğiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group hide">
					  <label class="control-label">Site Arkaplan 2</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_arkaplan_2" id="site_arkaplan_2" value="<?php echo $site_oku['site_arkaplan_2']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					
					<div class="control-group hide">
					  <label class="control-label">Site Arkaplan 2 Boyut</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="site_arkaplan_2_boyut" id="site_arkaplan_2_boyut" value="<?php echo $site_oku['site_arkaplan_2_boyut']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Site Ana Renk</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="site_ana_renk" id="site_ana_renk" value="<?php echo $site_oku['site_ana_renk']; ?>" />
						 <span class="help-inline"><small>Site İçerisinde Genel Olarak Textlerin Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Footer Arkaplan</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="footer_arkaplan_resim" id="footer_arkaplan_resim" />
							<input type="text" class="span6 m-wrap hide" name="footer_arkaplan" id="footer_arkaplan" value="<?php echo $site_oku['footer_arkaplan']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['footer_arkaplan']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Footer Arkaplan Resmini Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Footer Arkaplan Boyut</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="footer_arkaplan_boyut" id="footer_arkaplan_boyut" value="<?php echo $site_oku['footer_arkaplan_boyut']; ?>" />
						 <span class="help-inline"><small>Footer Arkaplan Resminin Boyutunu Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Vitrin Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="vitrin_baslik" id="vitrin_baslik" value="<?php echo $site_oku['vitrin_baslik']; ?>" />
						 <span class="help-inline"><small>Anasayfada Bulunan Vitrin Şeridinin Başlığını Değiştirmek İçin</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Görüşleriniz Arkaplan</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="gorusleriniz_arkaplan_resim" id="gorusleriniz_arkaplan_resim" />
							<input type="text" class="span6 m-wrap hide" name="gorusleriniz_arkaplan" id="gorusleriniz_arkaplan" value="<?php echo $site_oku['gorusleriniz_arkaplan']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['gorusleriniz_arkaplan']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Anasayfada Bulunan 'Görüş Ve Önerileriniz' Formunun Arkaplan Resmini Değişrtirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					
					<div class="control-group">
					  <label class="control-label">Slider Renk</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="slider_renk" id="slider_renk" value="<?php echo $site_oku['slider_renk']; ?>" />
						 <span class="help-inline"><small>Slider Araçlarının Renklerini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Menu Üst Renk</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="menu_ust_renk" id="menu_ust_renk" value="<?php echo $menu_ust_renk_hex; ?>" />
						 <span class="help-inline"><small>Menü Üst Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Menu Üst Renk Opaklık</label>
					  <div class="controls">
						 <input type="range" class="span6 m-wrap" name="menu_ust_renk_opacity" id="menu_ust_renk_opacity" value="<?php echo $menu_ust_renk_opacity[1]; ?>" />
						 <span class="help-inline"><small>Menü Üst Renginin Opaklığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Menu Renk</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="menu_renk" id="menu_renk" value="<?php echo $menu_renk_hex; ?>" />
						 <span class="help-inline"><small>Menü Şeridinin Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Menu Renk Opaklık</label>
					  <div class="controls">
						 <input type="range" class="span6 m-wrap"  name="menu_renk_opacity" id="menu_renk_opacity" value="<?php echo $menu_renk_opacity[1]; ?>" />
						 <span class="help-inline"><small>Menü Şeridi Renginin Opaklığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt 1</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="slider_alt_1" id="slider_alt_1" value="<?php echo $slider_alt_1_hex; ?>" />
						 <span class="help-inline"><small>Slider 1. Alt Bölümü Arkaplan Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt 1 Opaklık</label>
					  <div class="controls">
						 <input type="range" class="span6 m-wrap" name="slider_alt_1_opacity" id="slider_alt_1_opacity" value="<?php echo $slider_alt_1_opacity[1]; ?>" />
						 <span class="help-inline"><small>Slider 1. Alt Bölümü Arkaplan Rengi Opaklığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt 2</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="slider_alt_2" id="slider_alt_2" value="<?php echo $slider_alt_2_hex; ?>" />
						 <span class="help-inline"><small>Slider 2. Alt Bölümü Arkaplan Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt 2 Opaklık</label>
					  <div class="controls">
						 <input type="range" class="span6 m-wrap" name="slider_alt_2_opacity" id="slider_alt_2_opacity" value="<?php echo $slider_alt_2_opacity[1]; ?>" />
						 <span class="help-inline"><small>Slider 1. Alt Bölümü Arkaplan Rengi Opaklığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutular</label>
					  <div class="controls">
						<select class="span6 m-wrap" name="slider_alt_kutular_durum" id="slider_alt_kutular_durum">
							<option value="1" <?php if($site_oku['slider_alt_kutular_durum']==1){ echo 'selected'; } ?>>Aktif</option>
							<option value="2" <?php if($site_oku['slider_alt_kutular_durum']==2){ echo 'selected'; } ?>>Pasif</option>
						</select>
						 <span class="help-inline"><small>Slider Alt Kutuların Aktif/Pasif Ayarlarını Yapmak İçin Kullanılır.</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 1 Resim</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="slider_alt_kutu1_resim_resim" id="slider_alt_kutu1_resim_resim" />
							<input type="text" class="span6 m-wrap hide" name="slider_alt_kutu1_resim_text" id="slider_alt_kutu1_resim_text" value="<?php echo $site_oku['slider_alt_kutu1_resim']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['slider_alt_kutu1_resim']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Slider Alt Bölümde Bulunan 1. Kutunun Resmini Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 1 Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu1" id="slider_alt_kutu1" value="<?php echo $site_oku['slider_alt_kutu1']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 1. Kutunun Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 1 Alt Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu1_alt" id="slider_alt_kutu1_alt" value="<?php echo $site_oku['slider_alt_kutu1_alt']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 1. Kutunun Alt Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 1 Link</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu1_link" id="slider_alt_kutu1_link" value="<?php echo $site_oku['slider_alt_kutu1_link']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 1. Kutunun Linkini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 2 Resim</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="slider_alt_kutu2_resim_resim" id="slider_alt_kutu2_resim_resim" />
							<input type="text" class="span6 m-wrap hide" name="slider_alt_kutu2_resim_text" id="slider_alt_kutu2_resim_text" value="<?php echo $site_oku['slider_alt_kutu2_resim']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['slider_alt_kutu2_resim']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Slider Alt Bölümde Bulunan 2. Kutunun Resmini Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 2 Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu2" id="slider_alt_kutu2" value="<?php echo $site_oku['slider_alt_kutu2']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 2. Kutunun Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 2 Alt Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu2_alt" id="slider_alt_kutu2_alt" value="<?php echo $site_oku['slider_alt_kutu2_alt']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 2. Kutunun Alt Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 2 Link</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu2_link" id="slider_alt_kutu2_link" value="<?php echo $site_oku['slider_alt_kutu2_link']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 2. Kutunun Linkini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 3 Resim</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="slider_alt_kutu3_resim_resim" id="slider_alt_kutu3_resim_resim" />
							<input type="text" class="span6 m-wrap hide" name="slider_alt_kutu3_resim_text" id="slider_alt_kutu3_resim_text" value="<?php echo $site_oku['slider_alt_kutu3_resim']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['slider_alt_kutu3_resim']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Slider Alt Bölümde Bulunan 3. Kutunun Resmini Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 3 Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu3" id="slider_alt_kutu3" value="<?php echo $site_oku['slider_alt_kutu3']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 3. Kutunun Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 3 Alt Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu3_alt" id="slider_alt_kutu3_alt" value="<?php echo $site_oku['slider_alt_kutu3_alt']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 3. Kutunun Alt Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 3 Link</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu3_link" id="slider_alt_kutu3_link" value="<?php echo $site_oku['slider_alt_kutu3_link']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 3. Kutunun Linkini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 4 Resim</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="slider_alt_kutu4_resim_resim" id="slider_alt_kutu4_resim_resim" />
							<input type="text" class="span6 m-wrap hide" name="slider_alt_kutu4_resim_text" id="slider_alt_kutu4_resim_text" value="<?php echo $site_oku['slider_alt_kutu4_resim']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['slider_alt_kutu4_resim']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Slider Alt Bölümde Bulunan 4. Kutunun Resmini Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 4 Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu4" id="slider_alt_kutu4" value="<?php echo $site_oku['slider_alt_kutu4']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 4. Kutunun Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 4 Alt Başlık</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu4_alt" id="slider_alt_kutu4_alt" value="<?php echo $site_oku['slider_alt_kutu4_alt']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 4. Kutunun Alt Başlığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Slider Alt Kutu 4 Link</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="slider_alt_kutu4_link" id="slider_alt_kutu4_link" value="<?php echo $site_oku['slider_alt_kutu4_link']; ?>" />
						 <span class="help-inline"><small>Slider Alt Bölümde Bulunan 4. Kutunun Linkini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Footer Line</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="footer_line" id="footer_line" value="<?php echo $footer_line_hex; ?>" />
						 <span class="help-inline"><small>Footer Üstündeki Şerit Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Footer Line Opaklık</label>
					  <div class="controls">
						 <input type="range" class="span6 m-wrap" name="footer_line_opacity" id="footer_line_opacity" value="<?php echo $footer_line_opacity[1]; ?>" />
						 <span class="help-inline"><small>Footer Üstündeki Şerit Rengi Opaklığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Footer Arkaplan Rengi</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="footer_arkaplan_renk" id="footer_arkaplan_renk" value="<?php echo $footer_arkaplan_renk_hex; ?>" />
						 <span class="help-inline"><small>Footer Arkaplan Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Footer Arkaplan Rengi Opaklık</label>
					  <div class="controls">
						 <input type="range" class="span6 m-wrap" class="span6 m-wrap" name="footer_arkaplan_renk_opacity" id="footer_arkaplan_renk_opacity" value="<?php echo $footer_arkaplan_renk_opacity[1]; ?>" />
						 <span class="help-inline"><small>Footer Arkaplan Rengi Opaklığını Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Footer Text Rengi</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="footer_text" id="footer_text" value="<?php echo $site_oku['footer_text']; ?>" />
						 <span class="help-inline"><small>Footer İçerisindeki Text Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<h3> İç Sayfa Özellikleri </h3>
					
					<div class="control-group">
					  <label class="control-label">Profil Resim 1</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="profil_resim_1_resim" id="profil_resim_1_resim" />
							<input type="text" class="span6 m-wrap hide" name="profil_resim_1" id="profil_resim_1" value="<?php echo $site_oku['profil_resim_1']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['profil_resim_1']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Kullanıcı Menüsünde Bulunan 1. Resmi Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Profil Resim 2</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="profil_resim_2_resim" id="profil_resim_2_resim" />
							<input type="text" class="span6 m-wrap hide" name="profil_resim_2" id="profil_resim_2" value="<?php echo $site_oku['profil_resim_2']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['profil_resim_2']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Kullanıcı Menüsünde Bulunan 2. Resmi Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Profil Resim 3</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="profil_resim_3_resim" id="profil_resim_3_resim" />
							<input type="text" class="span6 m-wrap hide" name="profil_resim_3" id="profil_resim_3" value="<?php echo $site_oku['profil_resim_3']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['profil_resim_3']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Kullanıcı Menüsünde Bulunan 3. Resmi Değiştirmek İçin Kullanılır</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Kutu 1 Üst Resmi</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="kutu_1_ust_resim" id="kutu_1_ust_resim" />
							<input type="text" class="span6 m-wrap hide" name="kutu_1_ust" id="kutu_1_ust" value="<?php echo $site_oku['kutu_1_ust']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['kutu_1_ust']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Slider Altında Bulunan 1. Linkin İçerik Üst Görselini Değiştirmek İçin Kullanılır.</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Kutu 2 Üst Resmi</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="kutu_2_ust_resim" id="kutu_2_ust_resim" />
							<input type="text" class="span6 m-wrap hide" name="kutu_2_ust" id="kutu_2_ust" value="<?php echo $site_oku['kutu_2_ust']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['kutu_2_ust']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Slider Altında Bulunan 2. Linkin İçerik Üst Görselini Değiştirmek İçin Kullanılır.</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Kutu 3 Üst Resmi</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="kutu_3_ust_resim" id="kutu_3_ust_resim" />
							<input type="text" class="span6 m-wrap hide" name="kutu_3_ust" id="kutu_3_ust" value="<?php echo $site_oku['kutu_3_ust']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['kutu_3_ust']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Slider Altında Bulunan 3. Linkin İçerik Üst Görselini Değiştirmek İçin Kullanılır.</small></span>
						</div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Kutu 4 Üst Resmi</label>
						<div class="controls" style="margin-top:10px;">
							<input type="file" name="kutu_4_ust_resim" id="kutu_4_ust_resim" />
							<input type="text" class="span6 m-wrap hide" name="kutu_4_ust" id="kutu_4_ust" value="<?php echo $site_oku['kutu_4_ust']; ?>" />
						</div>
						<div class="controls" style="min-height:30px;">
							<img src="../images/<?php echo $site_oku['kutu_4_ust']; ?>" style="height:100px;" />
						</div>
						<div class="controls" style="min-height:30px;">
							<span class="help-inline"><small>Slider Altında Bulunan 4. Linkin İçerik Üst Görselini Değiştirmek İçin Kullanılır.</small></span>
						</div>
					</div>
					
					<h3> Ürün Özellikleri</h3>
					
					<div class="control-group">
					  <label class="control-label">Buton Renk</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="buton_renk" id="buton_renk" value="<?php echo $site_oku['buton_renk']; ?>" />
						 <span class="help-inline"><small>Ürün Kartlarında Bulunan Detay Butonunun Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Buton Renk 2</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="buton_renk2" id="buton_renk2" value="<?php echo $site_oku['buton_renk2']; ?>" />
						 <span class="help-inline"><small>Ürün Kartlarında Bulunan Sipariş Ver Butonunun Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>

					<div class="control-group hide">
					  <label class="control-label">Ürün Arkaplan</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="urun_arka" id="urun_arka" value="<?php echo $site_oku['urun_arka']; ?>" />
						 <span class="help-inline"></span>
					  </div>
					</div>
					
					<div class="control-group hide">
					  <label class="control-label">Ürün Text Rengi</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="urun_text" id="urun_text" value="<?php echo $site_oku['urun_text']; ?>" />
						 <span class="help-inline"><small>Ürün Kartlarında Bulunan Ürün Adı Rengini Değiştirmek İçin Kullanılır</small></span>
					  </div>
					</div>

					<div class="control-group">
					  <label class="control-label">Ürün Arkaplan Rengi</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="urun_arkaplan" id="urun_arkaplan" value="<?php echo $urun_arkaplan_hex; ?>" />
						 <span class="help-inline">Ürün Kartlarının Arkaplan Rengini Değiştirmek İçin Kullanılır</span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Ürün Arkaplan Opaklık Değeri</label>
					  <div class="controls">
						 <input type="range" class="span6 m-wrap" name="urun_arkaplan_opacity" id="urun_arkaplan_opacity" value="<?php echo $urun_arkaplan_opacity[1]; ?>">
						 <span class="help-inline"><small>Ürün Kartlarının Arkaplan Opaklığını Değiştirmek İçin Kullanılır.</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Ürün Border Rengi</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="urun_kenarlık" id="urun_kenarlık" value="<?php echo $site_oku['urun_kenarlık']; ?>" />
						 <span class="help-inline"><small>Ürün Kartlarının Kenarlık Rengini Değiştirir</small></span>
					  </div>
					</div>
					
					<div class="control-group">
					  <label class="control-label">Ürün Text Rengi</label>
					  <div class="controls">
						 <input type="color" class="span6 m-wrap" name="urun_text_rengi" id="urun_text_rengi" value="<?php echo $site_oku['urun_text_rengi']; ?>" />
						 <span class="help-inline"><small>Ürün Kartlarının Yazı Rengini Değiştirir</small></span>
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