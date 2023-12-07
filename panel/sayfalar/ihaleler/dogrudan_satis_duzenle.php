<?php 
	session_start();
	$admin_id=$_SESSION['kid'];
	$gelen_id=re("id");



	



	$hepsini_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE id = $gelen_id");
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
	$yetkiler=$admin_yetki_oku["yetki"];
	$yetki_parcala=explode("|",$yetkiler);
	$sehir_cek = mysql_query("SELECT * FROM sehir ORDER BY plaka ASC"); 
	if (!in_array(1, $yetki_parcala)) { 
		$aktiflik = "disabled";
		$gorunme = "none";
	} else{
		$aktiflik = "";
		$gorunme = "block";
	  }
	
	$sehir_cek = mysql_query("SELECT * FROM sehir"); 

	

?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="js/il_ilce.js?v=14"></script>
	<script src="js/marka_model.js?v=4"></script>
	<script src="../js/ckeditor4/ckeditor.js"></script>
	<style>
		.files input {
		   outline: 2px dashed red;
		   outline-offset: -10px;
		   -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
		   transition: outline-offset .15s ease-in-out, background-color .15s linear;
		   padding: 120px 0px 85px 35%;
		   text-align: center !important;
		   margin: 0;
		   width: 100% !important;
		}
		.files input:focus{    
			outline: 2px dashed #92b0b3;  
			outline-offset: -10px;
			-webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
			transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
		}
		.files{ 
			position:relative
		}
		.files:after {  
			pointer-events: none;
			position: absolute;
			top: 60px;
			left: 0;
			width: 50px;
			right: 0;
			height: 56px;
			content: "";
			background-image: url(images/dosya_yukleme.png);
			display: block;
			margin: 0 auto;
			background-size: 100%;
			background-repeat: no-repeat;
		}
		.color input{
			background-color:#f1f1f1;
		}
		.files:before {
			position: absolute;
			bottom: 10px;
			left: 0;  pointer-events: none;
			width: 100%;
			right: 0;
			height: 57px;
			content: "veya Dosyaları buraya sürükle bırak yapabilirsiniz ";
			display: block;
			margin: 0 auto;
			color: red;
			font-weight: 600;
			text-align: center;
		}
	</style>
	<style>
		.blue-text {
		  color: blue;
		}

		.underline {
		  text-decoration: underline;
		}

		.drop-field {
		  position: relative;
		  text-align: center;
		  vertical-align: middle;
		}

		.drop-field,
		.drop-area {
		margin-top:10px;
		  height: 200px;
		  width: 100%;
		}

		.drop-field .browse {
		  z-index: 0;
		  position: absolute;
		  left: 0;
		  bottom: 0;
		  right: 0;
		  margin: 0 auto;
		}

		.drop-field .drop-area {
		  display: block;
		  border: 3px dashed #ce680d;
		  position: relative;
		}

		.drop-field,
		.drop-area,
		.drop-field .browse {
		  transition: all 0.3s;
		}

		.drop-field.loaded .drop-area {
		  border: 1px solid blue;
		}

		.drop-field .browse {
		  opacity: 0;
		  transform: translateY(100%);
		}

		.drop-field.loaded .browse {
		  opacity: 1;
		  transform: translateY(0);
		}

		.drop-field.hover .drop-area {
		  border: 1px solid black;
		}

		.drop-field .drop-area input[type="file"] {
		  height: 100%;
		  width: 100%;
		  position: absolute;
		  display: block;
		  z-index: 3;
		  top: 0;
		  left: 0;
		  opacity: 0.000001;
		}

		.drop-field .file-list {
		  position: absolute;
		  z-index: 0;
		  top: 0;
		  left: 0;
		  text-align: center;
		}

		.drop-field .remove {
		  position: absolute;
		  left: 20px;
		  top: 20px;
		  z-index: 4;
		  transition: all 0.3s;
		  opacity: 0;
		  transform: translateY(-100%);
		  cursor: pointer;
		}

		.drop-field .remove:hover {
		  color: blue;
		}

		.drop-field.loaded .remove {
		  opacity: 1;
		  transform: translateY(0);
		}

		.drop-field ul li {
			margin-left: 50px;
			font-size: 15px;
		  padding: 0;
		  text-align: center;
		  list-style: none;
		}
	</style>
	<!-- <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script> -->
	<script>
		window.onload = TriggerVarMi;
		function TriggerVarMi() {
			var trigger_sor = localStorage.getItem('gorsel_trigger');
			if(trigger_sor == 1){
				document.getElementById("dogrudan_foto_tab").click();		
				localStorage.removeItem("gorsel_trigger");
			}else{
				var yeni_trigger = localStorage.getItem('dogrudan_trigger');
				if(yeni_trigger != "" && yeni_trigger != undefined ){
					document.getElementById(yeni_trigger).click();		
					//localStorage.removeItem("dogrudan_trigger");
				}

			}
		}
		function dogrudan_trigger(item){
			localStorage.setItem('dogrudan_trigger',item);
		}
	</script>
	<style>
		.row {
			background: #f6f6f6;
			padding: 10px;
		}
		#plaka{
		   text-transform: uppercase;
		}
	</style>
	<?php 
		while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
			if($hepsini_oku["vitrin"=="on"]){
				$vitrin_check="checked";
			}else{
				$vitrin_check="checked";
			}

			if($hepsini_oku["panelden_eklenme"] == 1){
				$ekleyen_admin_cek = mysql_query("select * from kullanicilar where token = '".$hepsini_oku["ilan_sahibi"]."'");
				$ekleyen_admin_oku = mysql_fetch_object($ekleyen_admin_cek);
				$ekleyen = $ekleyen_admin_oku->adi." ".$ekleyen_admin_oku->soyadi;
			}else{
				$bireysel_cek = mysql_query("select * from user where user_token = '".$hepsini_oku["ilan_sahibi"]."'");
				if(mysql_num_rows($bireysel_cek) != 0){
					$bireysel_oku = mysql_fetch_object($bireysel_cek);
					$ekleyen = $bireysel_oku->ad;
				}else{
					$kurumsal_cek = mysql_query("select * from user where kurumsal_user_token = '".$hepsini_oku["ilan_sahibi"]."'");
				$kurumsal_oku = mysql_fetch_object($kurumsal_cek);
				$ekleyen = $kurumsal_oku->unvan;
				}
			}

			$hasarlar=$hepsini_oku["hasar_durumu"];
			$hasar_parcala=explode("|",$hasarlar);
			$ili_cek = mysql_query("SELECT * FROM sehir WHERE plaka ='".$hepsini_oku['sehir']."'"); ?>

			<?php 
			$geleni_cek = mysql_query("select * from dogrudan_satisli_ilanlar where id = '".$gelen_id."'");
			$geleni_oku = mysql_fetch_assoc($geleni_cek);
			?>


			<div class="row-fluid">
				<b style="float:right;font-size:20px;margin:10px;" ><?php echo "#".$geleni_oku["arac_kodu"]." / ".$geleni_oku["model_yili"]." / ".$geleni_oku["marka"]." / ".$geleni_oku["model"]." / ".$geleni_oku["uzanti"] ?></b>
			</div>
			<div class="tabbable"> <!-- Only required for left/right tabs -->
				<ul class="nav nav-tabs">
					<li class="active" onclick="dogrudan_trigger('dogrudan_arac_bilgi_tab')"><a id="dogrudan_arac_bilgi_tab" href="#tab1" data-toggle="tab">Araç Bilgileri</a></li>
					<li onclick="dogrudan_trigger('dogrudan_foto_tab')"><a href="#tab2" id="dogrudan_foto_tab" data-toggle="tab">Araç Fotoğrafları</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<form method="post" id="form" name="form" enctype="multipart/form-data">
							<?php include('islemler/ihaleler/dogrudan_satis_guncelle.php'); ?>
							<div class="row-fluid">
								<div class="span6">
									<label for="IDofInput">Plaka(*)</label>
									<input type="text" class="span12" name="plaka" id="plaka" value="<?=$hepsini_oku["plaka"] ?>" placeholder="01AA0000" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8"  /> 
									
									<label for="IDofInput">Araç Kodu</label> 
									<input type="text" class="span12" name="arac_kodu" value="<?=$hepsini_oku["arac_kodu"] ?>" onkeypress="return boslukEngelle()" /> 
									
									<label for="IDofInput">Yayın Bitiş Tarihi(*)</label> 
									<input type="date" class="span12" name="yayin_bitis" value="<?=date("Y-m-d",strtotime($hepsini_oku["bitis_tarihi"])) ?>" onkeypress="return boslukEngelle()" required /> 
							 
									<label for="IDofInput">Fiyat</label> 
									<input type="text" class="span12" value="<?=$hepsini_oku["fiyat"] ?>" name="fiyat" /> 
									
									<label for="IDofInput">Aracın Şuanki Durumu</label>
									<select name="aracin_durumu" class="span12" id="aracin_durumu" >
										<option <?php if($hepsini_oku["aracin_durumu"]==""){ echo "selected"; } ?>  value="">Seçiniz</option>
										<option <?php if($hepsini_oku["aracin_durumu"]=="Kazalı (En ufak bir onarım görmemiş)"){ echo "selected"; } ?>  value="Kazalı (En ufak bir onarım görmemiş)">Kazalı (En ufak bir onarım görmemiş)</option>
										<option <?php if($hepsini_oku["aracin_durumu"]=="Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlanmış)"){ echo "selected"; } ?>  value="Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlanmış)">Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlanmış)</option>
										<option <?php if($hepsini_oku["aracin_durumu"]=="İkinci El (Pert Kayıtlı)"){ echo "selected"; } ?>  value="İkinci El (Pert Kayıtlı)">İkinci El (Pert Kayıtlı)</option>
										<option <?php if($hepsini_oku["aracin_durumu"]=="İkinci El (Pert Kayıtsız)"){ echo "selected"; } ?>  value="İkinci El (Pert Kayıtsız)">İkinci El (Pert Kayıtsız)</option>
									</select>
									
									<label for="IDofInput">Vites Tipi</label>
									<select  name="vites_tipi" id="vites_tipi" class="span12" >
										<option <?php if($hepsini_oku["vites_tipi"]==""){ echo "selected"; } ?> value="">Seçiniz</option>
										<option <?php if($hepsini_oku["vites_tipi"]=="Düz Vites"){ echo "selected"; } ?> value="Düz Vites">Düz Vites</option>
										<option <?php if($hepsini_oku["vites_tipi"]=="Otomatik Vites"){ echo "selected"; } ?> value="Otomatik Vites">Otomatik Vites</option>
									</select>
									
									<label for="IDofInput">Model Yılı(*)</label>
									<input type="text" name="model_yili" class="span12" required value="<?=$hepsini_oku["model_yili"] ?>">
								</div>
								<div class="span6">
									<label for="IDofInput">Şehir</label>
									<select name="sehir" id="sehir" class="span12" >
										<option value="">Şehir seçin</option>
										<?php  while($sehir_oku = mysql_fetch_array($sehir_cek)){ ?>                        
											<option <?php if($sehir_oku["sehiradi"]==$hepsini_oku['sehir']){ echo "selected"; } ?> value="<?=$sehir_oku["sehiradi"]?>"><?=$sehir_oku["sehiradi"];?></option>  
										<?php } ?>                      
									</select>
									<label for="IDofInput">İlçe</label>
									<select name="ilce" id="ilce" class="span12" disabled>
										<option value="<?=$hepsini_oku["ilce"] ?>"><?=$hepsini_oku["ilce"] ?></option>
									</select>
									<label for="IDofInput">Yakıt Tipi</label>
									<select name="yakit_tipi" class="span12" id="yakit_tipi" >
										<option <?php if($hepsini_oku["yakit_tipi"]==""){ echo "selected"; } ?> value="">Seçiniz</option>
										<option <?php if($hepsini_oku["yakit_tipi"]=="Benzinli"){ echo "selected"; } ?> value="Benzinli">Benzinli</option>
										<option <?php if($hepsini_oku["yakit_tipi"]=="Benzin+Lpg"){ echo "selected"; } ?> value="Benzin+Lpg">Benzin+Lpg</option>
										<option <?php if($hepsini_oku["yakit_tipi"]=="Dizel"){ echo "selected"; } ?> value="Dizel">Dizel</option>
										<option <?php if($hepsini_oku["yakit_tipi"]=="Hybrit"){ echo "selected"; } ?> value="Hybrit">Hybrit</option>
										<option <?php if($hepsini_oku["yakit_tipi"]=="Elektrikli"){ echo "selected"; } ?> value="Elektrikli">Elektrikli</option>
									</select>
									<label for="IDofInput">Evrak Tipi</label>
									<select name="evrak_tipi" id="evrak_tipi" class="span12" >
										<option <?php if($hepsini_oku["evrak_tipi"]==""){ echo "selected"; } ?> value="">Seçiniz..</option>
										<option <?php if($hepsini_oku["evrak_tipi"]=="Çekme Belgeli/Pert Kayıtlı"){ echo "selected"; } ?> value="Çekme Belgeli/Pert Kayıtlı">Çekme Belgeli/Pert Kayıtlı</option>
										<option <?php if($hepsini_oku["evrak_tipi"]=="Çekme Belgeli"){ echo "selected"; } ?> value="Çekme Belgeli">Çekme Belgeli</option>
										<option <?php if($hepsini_oku["evrak_tipi"]=="Hurda Belgeli"){ echo "selected"; } ?> value="Hurda Belgeli">Hurda Belgeli</option>
										<option <?php if($hepsini_oku["evrak_tipi"]=="Plakalı"){ echo "selected"; } ?>value="Plakalı">Plakalı</option>
										<option <?php if($hepsini_oku["evrak_tipi"]=="Diğer"){ echo "selected"; } ?> value="Diğer">Diğer</option>     
									</select>
									
									<label for="IDofInput">Marka(*)</label> 
									<select class="span12" name="dogrudan_marka" id="dogrudan_marka" required onchange="model_getir_dogrudan()">
										<option value="">Seçiniz</option>
										<?php $marka_cek = mysql_query("SELECT * FROM marka"); while($marka_oku = mysql_fetch_array($marka_cek)){ ?>
											<option <?php if($marka_oku['marka_adi']==$hepsini_oku['marka']){ echo "selected"; }?> value="<?=$marka_oku['marka_adi'] ?>"><?=$marka_oku['marka_adi'] ?></option>
										<?php } ?>
									</select>
									<?php 
									$model_cek = mysql_query("select * from model where marka_adi = '".$hepsini_oku["marka"]."'");
									while($model_oku = mysql_fetch_object($model_cek)){
										$model_select = "";
										if($hepsini_oku["model"] == $model_oku->model_adi){
											$model_select = "selected";
										}
										$modeller .= '<option '.$model_select.' value="'.$model_oku->model_adi.'">'.$model_oku->model_adi.'</option>';
									}
									?>
									
									<label for="IDofInput">Model(*)</label>
									<select class="span12" name="dogrudan_model" id="dogrudan_model" required  >
										<?= $modeller ?>
									</select>
									
									<label for="IDofInput">Uzantı</label>
									<input type="text" class="span12" name="uzanti" value="<?= $hepsini_oku['uzanti'] ?>">
									
									<label for="IDofInput">Kilometre</label>
									<input type="number" class="span12" name="kilometre" value="<?= $hepsini_oku['kilometre'] ?>">
								</div>
							</div>
							
							<div class="row-fluid">
								<label for="IDofInput">Hasar Durumu (Bir veya daha fazla işaretlenebilir)</label>
								<label class="d-label">
									<input type="checkbox" value="1"  <?php if (in_array(1, $hasar_parcala)){ echo "checked";} ?> name="hasar_durumu[]">Çarpma, Çarpışma
								</label>
								<label class="d-label">
									<input type="checkbox" value="2"  <?php if (in_array(2, $hasar_parcala)){ echo "checked";} ?> name="hasar_durumu[]">Teknik Arıza
								</label>
								<label class="d-label">
									<input type="checkbox" value="3"  <?php if (in_array(3, $hasar_parcala)){ echo "checked";} ?> name="hasar_durumu[]">Sel/Su Hasarı
								</label>
								<label class="d-label">
									<input type="checkbox" value="4"  <?php if (in_array(4, $hasar_parcala)){ echo "checked";} ?> name="hasar_durumu[]">Yanma Hasarı
								</label>
								<label class="d-label">
									<input type="checkbox" value="5"  <?php if (in_array(5, $hasar_parcala)){ echo "checked";} ?> name="hasar_durumu[]">Çalınma
								</label>
								<label class="d-label">
									<input type="checkbox" value="6"  <?php if (in_array(6, $hasar_parcala)){ echo "checked";} ?> name="hasar_durumu[]">Diğer
								</label>
								<label class="d-label">
									<input type="checkbox" value="7"  <?php if (in_array(7, $hasar_parcala)){ echo "checked";} ?> name="hasar_durumu[]">Hasarsız
								</label>
								
								<label for="IDofInput">Aracın Açık Adresi (Araç şuan nerede Otopark,Servis vs.)</label>
								<textarea name="aracin_adresi" id="aracin_adresi" rows="2" style="width:75%;" ><?= $hepsini_oku['aracin_adresi'] ?></textarea>
								
								<label for="IDofInput">Açıklamalar (Lütfen alıcılar için gerekli herşeyi anlatınız)</label>
								<textarea name="aciklamalar" id="aciklamalar"  rows="8" style="width:75%;" ><?= $hepsini_oku['aciklamalar'] ?></textarea>
							</div>
							<div class="row-fluid">
								<label for="IDofInput">Ekleyen</label>
								<input type="text" disabled value="<?= $ekleyen ?>">
							</div>
							<div class="row-fluid">
								<label for="IDofInput">Eklenme Tarihi</label>
								<input type="datetime" disabled value="<?= date("d-m-Y H:i:s", strtotime($hepsini_oku['eklenme_tarihi']." ".$hepsini_oku["eklenme_saati"])) ?>">
							</div>
							<div class="row-fluid">
								<label class="b-label">
									<label for="IDofInput">Vitrin</label>
									<input type="checkbox" name="vitrin" value="on">
								</label>
							</div>
							<div class="row-fluid">
								<div class="form-actions">
									<input type="submit" <?= $aktiflik ?> name="dogrudan_satisli_ilani" class="btn blue" value="Kaydet" />
								</div>
							</div>
						</form>
					</div>
					<?php 
						$ilan_resimleri_cek = mysql_query("SELECT * FROM dogrudan_satisli_resimler WHERE ilan_id = '".$hepsini_oku['id']."'");
					?>

					<div class="tab-pane" id="tab2">
					
						<form method="POST" id="form" name="form" enctype="multipart/form-data">
							<input type="hidden" name="action" value="dogrudan_ilan_resim_ekle" />
							
							<div class="row-fluid" style="margin-right: 2% !important; margin-left: 2% !important; width:96% !important;">
								<input type="button" class="btn" <?= $aktiflik ?> onclick="dogrudan_butun_resim_sil(<?=$hepsini_oku['id'] ?>)" value="Bütün Resimleri Sil" style="background-color: rgb(251,57,122); color:white;">
								
								<div class="form-group">
									<br/>
									<text>Dosyaları seçmek için aaşağıdaki alana tıklayabilir veya dosyaları alanın içine sürükleyebilirsiniz.</text>
									<input onchange="dogrudan_resim_yukle(<?= $hepsini_oku['id'] ?>)" id="file_input" name="resim[]" type="file" multiple>
								</div>
								<div class="row-fluid" style="margin-left:1px;">
									<ul id="kayitli_resimler" class="thumbnails">
										<?php while($resim_oku = mysql_fetch_array($ilan_resimleri_cek)){
											$resim = "../images/".$resim_oku['resim']; ?>  
											<li id="<?= $resim_oku['id'] ?>" style="margin-left:5px;margin-top:10px;" class="span4">
												<a href="#" class="thumbnail">
													<img src="<?= $resim ?>" style="height:100px;">
												</a><br/>
												<a style="display: <?= $gorunme ?>;" href="#" onclick="dogrudan_resim_sil(<?=$resim_oku['id'] ?>)" class="btn red">Sil</a>
											</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						</form>
						<!--<form method="POST" id="form" name="form" enctype="multipart/form-data">
							<?php include('islemler/ilanlar/dogrudan_resim_duzenle.php'); ?>
							<div class="row-fluid" style="margin-right: 2% !important; margin-left: 2% !important; width:96% !important;">
								<input type="submit" <?= $aktiflik ?> class="btn" name="hepsini_sil" value="Bütün Resimleri Sil" style="background-color: rgb(251,57,122); color:white;">
								<div class="form-group files color">
									<input type="file" name="resim[]" class="form-control" multiple>
								</div>
								<div class="row-fluid" style="margin-top: 50px;">
									<div class="span4">
										<input type="submit" <?= $aktiflik ?> name="resimleri" class="btn-primary btn-block" value="Ekle">
									</div>
								</div>
								<div class="row-fluid" style="margin-left:1px;">
									<ul class="thumbnails">
										<?php while($resim_oku = mysql_fetch_array($ilan_resimleri_cek)){
											$resim = "../images/".$resim_oku['resim']; ?> 
											<li class="span4">
												<a href="#" class="thumbnail">
												<img src="<?= $resim ?>" value="<?= $resim_oku['id'] ?>" style="height:100px;">
												</a><br>
												<a style="display: <?= $gorunme ?>;" href="?modul=ayarlar&sayfa=data_sil&id=<?= $resim_oku['id'] ?>&q=dogrudan_resim&g=<?= $gelen_id?>" class="btn red">Sil</a>
											</li>
										<?php } ?>
									</ul>
							   </div>
						   </div>
						</form>-->
					</div>
				</div>
			</div>
		<?php } ?>
	<?php 
		if(re('hepsini_sil')=="Bütün Resimleri Sil"){
		   mysql_query("DELETE FROM dogrudan_satisli_resimler WHERE ilan_id = '".$gelen_id."'");
		   header('Location: ?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id='.$gelen_id.'');
		}
	?>
	<script>
		CKEDITOR.replace( 'aciklamalar', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	});


	// Set focus and blur listeners for all editors to be created.
	CKEDITOR.on( 'instanceReady', function( evt ) {
			var editor = evt.editor,
				body = CKEDITOR.document.getBody();
			editor.on( 'focus', function() {
				// Use jQuery if you want.
				var $sira = this.id;
				$('.'+$sira).addClass('ckeditor_focus');
				//body.addClass( 'fix' );
			} );
			editor.on( 'blur', function() {
				// Use jQuery if you want.
				var $sira = this.id;
				$('.'+$sira).removeClass('ckeditor_focus');
				//body.removeClass( 'fix' );
			} );    
		} );



		$("#plaka").keypress(function(event) {
			var character = String.fromCharCode(event.keyCode);
			return isValid(character);     
		});
		function isValid(str) {
			return !/[~`!@#$%\^&*()+=\-\[\]\\';.,/{}|\\":<>\?]/g.test(str);
		}
	</script>
	<script>
		function boslukEngelle() {
			if (event.keyCode == 32) {
				return false;
			}
		}
	</script>
	<script>
		var input = document.getElementById('plaka');
		input.oninvalid = function(event) {
			event.target.setCustomValidity('Lütfen plakayı düzgün yazın.');
		}
	</script>
	<script>
		var globalFunctions = {};
		globalFunctions.ddInput = function(elem) {
			if ($(elem).length == 0 || typeof FileReader === "undefined") return;
			var $fileupload = $('input[type="file"]');
			var noitems = '<li class="no-items"></li>';
			var hasitems = '<div class="browse hasitems">Dosya Seçimi </div>';
			var file_list = '<ul class="file-list"></ul>';
			var rmv = '<div class="remove"><i style="font-size:30px" class="icon-close icons">x</i></div>'
			$fileupload.each(function() {
				var self = this;
				var $dropfield = $('<div class="drop-field"><div class="drop-area"></div></div>');
				$(self).after($dropfield).appendTo($dropfield.find('.drop-area'));
				var $file_list = $(file_list).appendTo($dropfield);
				$dropfield.append(hasitems);
				$dropfield.append(rmv);
				$(noitems).appendTo($file_list);
				var isDropped = false;
				$(self).on("change", function(evt) {
					if ($(self).val() == "") {
						$file_list.find('li').remove();
						$file_list.append(noitems);
					} else {
						if(!isDropped) {
							$dropfield.removeClass('hover');
							$dropfield.addClass('loaded');
							var files = $(self).prop("files");
							traverseFiles(files);
						}
					}
				});
				
				$dropfield.on("dragleave", function(evt) {
					$dropfield.removeClass('hover');
					evt.stopPropagation();
				});

				$dropfield.on('click', function(evt) {
					$(self).val('');
					$file_list.find('li').remove();
					$file_list.append(noitems);
					$dropfield.removeClass('hover').removeClass('loaded');
				});

				$dropfield.on("dragenter", function(evt) {
					$dropfield.addClass('hover');
					evt.stopPropagation();
				});

				$dropfield.on("drop", function(evt) {
					isDropped = true;
					$dropfield.removeClass('hover');
					$dropfield.addClass('loaded');
					var files = evt.originalEvent.dataTransfer.files;
					traverseFiles(files);
					isDropped = false;
				});


				function appendFile(file) {

					$file_list.append('<li>' + file.name + '</li>');
				}

				function traverseFiles(files) {
					if ($dropfield.hasClass('loaded')) {
						$file_list.find('li').remove();
					}
					if (typeof files !== "undefined") {
						for (var i = 0, l = files.length; i < l; i++) {
							appendFile(files[i]);
						}
					} else {
						alert("Tarayıcının dosya yükleme özelliği yok.");
					}
				}

			});
		};

		function model_getir_dogrudan(){
			var $marka = $('select[name="dogrudan_marka"]').val();
			var $model = "";
			jQuery.ajax({
            url: "https://ihale.pertdunyasi.com/check.php",
            type: "POST",
            dataType: "JSON",
            data: {
                action: "model_getir",
                marka: $marka,
              },
            success: function (response) {
                jQuery.each(response.data, function(index, value){
					$model += `<option value="${value.model_adi}">${value.model_adi}</option>`;
				});
				$('select[name="dogrudan_model"]').html($model);
            }
        });
		}

		$(document).ready(function() {
			globalFunctions.ddInput('input[type="file"]');
		});
		function dogrudan_resim_yukle(id){
			   
			var formData = new FormData(document.getElementById('form'));
			formData.append('id', id);  
			formData.append("action", "dogrudan_ilan_resim_ekle");
			var filesLength=document.getElementById('file_input').files.length;
			for(var i=0;i<filesLength;i++){
				formData.append("resim[]", document.getElementById('file_input').files[i]);
			}
			$.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					var gorunme=<?php echo json_encode($gorunme); ?>;
					alert("Yükleme Başarılı");
					var dosya_sayisi=response.yukleme_sayisi;
					
				var li_html=$("#kayitli_resimler").html();
					li_html=$("#kayitli_resimler").html();
					var li_html2="";
					for(var j=0;j<filesLength;j++){
						li_html+="<li id='"+response.resim_id[j]["resim_id"]+"' style='margin-left:5px;margin-top:10px;' class='span4'><a href='#' class='thumbnail'><img src=../images/"+ response.resim[j]["ad"] +" value='' style='height:100px;'></a><br/><a style='display: "+gorunme +"' href='?modul=ayarlar&sayfa=data_sil&id="+response.resim_id[j]["resim_id"]+"&q=resim&g="+id+"' class='btn red'>Sil</a></li>";
					}
					$("#kayitli_resimler").html(li_html+li_html2);
					var file_list = '<ul class="file-list"></ul>';
					var dropfield = $('<div class="drop-field"><div class="drop-area"></div></div>');
					var noitems = '<li class="no-items"></li>';
					$('input[type="file"]').val('');
					$(".file-list").remove();
					$(".drop-field").removeClass("loaded");


				},
				cache: false,
				contentType: false,
				processData: false
			});
			 
		}
		function dogrudan_resim_sil(id){ 

				$.ajax({
					url: "https://ihale.pertdunyasi.com/check.php",
					method: 'POST',
					data: {
						action: "dogrudan_resim_sil",
						id: id
				   },
					success: function(data) {
						alert("İşlem Başarılı");
						$("#"+id).remove();
					},
					error: function(data) {
						
					}
				});

		}
		function dogrudan_butun_resim_sil(id){
			var a=confirm("Tüm resimleri silmek istediğinize emin misiniz");
			if(a){
				$.ajax({
					url: "https://ihale.pertdunyasi.com/check.php",
					method: 'POST',
					data: {
						action: "dogrudan_resimleri_sil",
						id: id
				   },
					success: function(data) {
						alert("İşlem Başarılı");
						$("#kayitli_resimler").remove();
					},
					error: function(data) {
						
					}
				});	
			}
			
		}
	</script>