<?php
	$soru_cek=mysql_query("select * from sss where id='".re("id")."'");
	$soru_oku=mysql_fetch_object($soru_cek);
	
	
 ?>

<script src="assets/ckeditor4/ckeditor.js"></script>
<div class="row-fluid" style="margin-top: 2%;">
	<div class="span12">
		<form method="POST" style="margin-top:2%;" id="yeni_ekle" enctype="multipart/form-data">
			<?php include('islemler/ayarlar/sik_sorulan_soru_ekle.php'); ?>
			<label for="IDofInput" class="span12">Soru Adı</label>
			<input type="text" name="soru" value="<?=$soru_oku->soru ?>" class="span12">
			<label for="IDofInput">Cevap</label>
			<textarea name="cevap" id="cevap" class="span12"  rows="5"><?=$soru_oku->cevap ?></textarea>
			<div class="row-fluid" style="margin-top: 10px;">
				<div class="span6">
					<input type="submit" class="btn blue btn-block" name="soruyu" value="Güncelle">
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	CKEDITOR.replace( 'cevap', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	} );
</script>

<style>
	.ck-editor__editable_inline {
		min-height: 200px !important;
	}
</style>
<?php
	if(re("soruyu")=="Güncelle"){
		if(re("soru")=="" || re("cevap")=="" ){
			echo "<script>alert('Soru ve cevap kısımları boş olamaz')</script>";
		}else{
			$guncelle=mysql_query("update sss set soru='".re("soru")."' , cevap='".re("cevap")."' where id='".re("id")."' ");
			var_dump("update sss set soru='".re("soru")."' , cevap='".re("cevap")."' where id='".re("id")."' ");
			if($guncelle){
				echo "<script>alert('Başarıyla güncellendi.')</script>";
				echo "<script>window.location.href='?modul=ayarlar&sayfa=iletisim_sss' </script>";
			}
		}
	}

 ?>


