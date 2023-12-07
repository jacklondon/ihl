<?php 
   $sehir_cek = mysql_query("SELECT * FROM sehir order by sehiradi asc"); 
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/il_ilce.js?v=14"></script>
<script src="js/marka_model.js?v=4"></script>
<!--<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>-->
<script src="../js/ckeditor4/ckeditor.js"></script>
<style>
   .row {
	   background: #f6f6f6;
	   padding: 10px;
   }
   #plaka{
		text-transform: uppercase;
   }
</style>
<form method="post" id="form" name="form" enctype="multipart/form-data">
	<?php include('islemler/ilanlar/dogrudan_satis_ekle.php'); ?>
	<div class="row-fluid">
		<div class="span6">
			<label for="IDofInput">Plaka(*)</label>
			<input type="text" class="span12" name="plaka" id="plaka" placeholder="01AA0000" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8"  /> 
			
			<label for="IDofInput">Araç Kodu</label> 
			<input type="text" class="span12" name="arac_kodu" onkeypress="return boslukEngelle()" /> 
			
			<label for="IDofInput">Yayın Bitiş Tarihi(*)</label> 
			<input type="date" class="span12" name="yayin_bitis" onkeypress="return boslukEngelle()" required /> 
     
			<label for="IDofInput">Fiyat</label> 
			<input type="text" class="span12" name="fiyat" /> 
			
			<label for="IDofInput">Aracın Şuanki Durumu</label>
			<select name="aracin_durumu" class="span12" id="aracin_durumu" >
				<option value="">Seçiniz</option>
				<option value="Kazalı (En ufak bir onarım görmemiş)">Kazalı (En ufak bir onarım görmemiş)</option>
				<option value="Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlanmış)">Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlanmış)</option>
				<option value="İkinci El (Pert Kayıtlı)">İkinci El (Pert Kayıtlı)</option>
				<option value="İkinci El (Pert Kayıtsız)">İkinci El (Pert Kayıtsız)</option>
			</select>
			
			<label for="IDofInput">Vites Tipi</label>
			<select  name="vites_tipi" id="vites_tipi" class="span12" >
				<option value="">Seçiniz</option>
				<option value="Düz Vites">Düz Vites</option>
				<option value="Otomatik Vites">Otomatik Vites</option>
			</select>
			
			<label for="IDofInput">Model Yılı(*)</label>
			<input type="text" name="model_yili" class="span12" required>
		</div>
		<div class="span6">
			<label for="IDofInput">Şehir</label>
            <select name="sehir" id="sehir" class="span12" >
                <option value="">Şehir seçin</option>
                <?php  while($sehir_oku = mysql_fetch_array($sehir_cek)){ ?>                        
					<option value="<?=$sehir_oku["sehirID"]?>"><?=$sehir_oku["sehiradi"];?></option>  
                <?php } ?>                      
            </select>
            <label for="IDofInput">İlçe</label>
            <select name="ilce" id="ilce" class="span12" disabled>
                <option value="">İlçe seçin</option>
            </select>
			<label for="IDofInput">Yakıt Tipi</label>
			<select name="yakit_tipi" class="span12" id="yakit_tipi" >
				<option value="">Seçiniz</option>
				<option value="Benzinli">Benzinli</option>
				<option value="Benzin+Lpg">Benzin+Lpg</option>
				<option value="Dizel">Dizel</option>
				<option value="Hybrit">Hybrit</option>
				<option value="Elektrikli">Elektrikli</option>
			</select>
			<label for="IDofInput">Evrak Tipi</label>
			<select name="evrak_tipi" id="evrak_tipi" class="span12" >
				<option value="">Seçiniz..</option>
				<option selected value="Çekme Belgeli/Pert Kayıtlı">Çekme Belgeli/Pert Kayıtlı</option>
				<option value="Çekme Belgeli">Çekme Belgeli</option>
				<option value="Hurda Belgeli">Hurda Belgeli</option>
				<option value="Plakalı">Plakalı</option>
				<option value="Diğer">Diğer</option>     
			</select>
			
			<label for="IDofInput">Marka(*)</label> 
			<select class="span12" name="marka" id="marka" required >
				<option value="">Seçiniz</option>
				<?php $marka_cek = mysql_query("SELECT * FROM marka"); while($marka_oku = mysql_fetch_array($marka_cek)){ ?>
					<option value="<?=$marka_oku['markaID'] ?>"><?=$marka_oku['marka_adi'] ?></option>
				<?php } ?>
			</select>
			
			<label for="IDofInput">Model(*)</label>
			<select class="span12" name="model" id="model" required disabled >
			</select>
			
			<label for="IDofInput">Uzantı</label>
			<input type="text" class="span12" name="uzanti">
			
			<label for="IDofInput">Kilometre</label>
			<input type="text" class="span12" name="kilometre">
		</div>
	</div>
	
	<div class="row-fluid">
		<label class="d-label">
			<label for="IDofInput">Hasar Durumu (Bir veya daha fazla işaretlenebilir)</label>
			<input type="checkbox" name="hasar[]" value="1">Çarpma, Çarpışma
		</label>
		<label class="d-label">
			<input type="checkbox" name="hasar[]" value="2">Teknik Arıza
		</label>
		<label class="d-label">
			<input type="checkbox" name="hasar[]" value="3">Sel/Su Hasarı
		</label>
		<label class="d-label">
			<input type="checkbox" name="hasar[]" value="4">Yanma Hasarı
		</label>
		<label class="d-label">
			<input type="checkbox" name="hasar[]" value="5">Çalınma
		</label>
		<label class="d-label">
			<input type="checkbox" name="hasar[]" value="6">Diğer
		</label>
		<label class="d-label">
			<input type="checkbox" name="hasar[]" value="7">Hasarsız
		</label>
		
		<label for="IDofInput">Aracın Açık Adresi (Araç şuan nerede Otopark,Servis vs.)</label>
		<textarea name="aracin_adresi" id="aracin_adresi" rows="2" style="width:75%;" ></textarea>
		
		<label for="IDofInput">Açıklamalar (Lütfen alıcılar için gerekli herşeyi anlatınız)</label>
		<textarea name="aciklamalar" id="aciklamalar"  rows="8" style="width:75%;" ></textarea>
		
		<!--<label for="IDofInput">Resim</label>
		<input type="file" class="span12" name="resim[]" multiple>-->
		
		
	</div>
	<div class="row-fluid">
		<label class="b-label">
			<label for="IDofInput">Vitrin</label>
			<input type="checkbox" name="vitrin" value="on">
		</label>
	</div>
	<div class="row-fluid">
		<div class="form-actions">
			<input type="submit" name="dogrudan_satisli_ilani" class="btn blue" value="Kaydet" />
		</div>
	</div>
</form>
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