<!--<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>-->
<?php 
	$gelen_id = re('id');
	$cek = mysql_query("select * from duyurular where id = '".$gelen_id."'");
	$oku = mysql_fetch_object($cek);
	if(re('a') == "b"){
		$duyuru_id = re("duyuru_id");
		$duyuru_image = re("duyuru_image");
		$baslik = re("baslik");
		$kisa_icerik = re("kisa_icerik");
		$icerik = re("icerik");
		$date_time = date('Y-m-d H:i:s');
		if (isset($_FILES['files']))
		{ // dosya tanımlanmıs mı?
			$errors = array();
			foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name)
			{
				if ($_FILES['files']['name'][$key] != "")
				{
					$dosyaUzantisi = pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION);
					$dosya_adi = $_FILES['files']['name'][$key]; // uzantiya beraber dosya adi
					$dosya_boyutu = $_FILES['files']['size'][$key]; // byte cinsinden dosya boyutu
					$dosya_gecici = $_FILES['files']['tmp_name'][$key]; //gecici dosya adresi
					$yenisim = md5(microtime()) . '.' . $dosyaUzantisi; //karmasik yeni isim.png
					if ($dosya_boyutu > 20971520)
					{
						$errors[] = 'Maksimum 20 Mb lık dosya yuklenebilir.';
					}
					$klasor = "../duyurular/"; // yuklenecek dosyalar icin yeni klasor
					if (empty($errors) == true)
					{ //eger hata yoksa
						if (is_dir("$klasor/" . $yenisim) == false)
						{ //olusturdugumuz isimde dosya var mı?
							move_uploaded_file($dosya_gecici, "$klasor/" . $yenisim); //yoksa yeni ismiyle kaydet
						}
						else
						{ //eger varsa
							$new_dir = "$klasor/" . $yenisim . time(); //yeni ismin sonuna eklenme zamanını ekle
							rename($dosya_gecici, $new_dir);
						}
					}
					else
					{
						print_r($errors); //varsa hataları yazdır
						
					}
					$yol = $yenisim;
				}else{
					$yol = $duyuru_image;
				}
				if (empty($error))
				{
					$sql = mysql_query("update duyurular set baslik = '".$baslik."', kisa_icerik = '".$kisa_icerik."', icerik = '".$icerik."', resim = '".$yol."',
					guncelleme_zamani = '".$date_time."' where id = '".$duyuru_id."'");
					if ($sql)
					{
						echo '<script>alert("Duyuru başarıyla güncellendi.")</script>';
						echo '<script>window.location.href="?modul=ayarlar&sayfa=edit_duyuru&id='.$duyuru_id.'" </script>';
					}
					else
					{
						echo '<script>alert("Hata Oluştu.Lütfen Tekrar Deneyiniz.")</script>';
					}
				}
			}
		}
	}
?>
<script src="assets/ckeditor4/ckeditor.js"></script>
<div class="row-fluid" style="margin-top: 2%;">
	<div class="span12">
		<form method="POST" style="margin-top:2%;" id="yeni_ekle" enctype="multipart/form-data">
			<input type="hidden" name="duyuru_id" value="<?= $gelen_id ?>">
			<input type="hidden" name="duyuru_image" value="<?= $oku->resim ?>">
			<label for="IDofInput" class="span12">Başlık</label>
			<input type="text" name="baslik" class="span12" value="<?= $oku->baslik ?>" required>
			<label for="IDofInput" class="span12" style="margin-left: 0;">Kısa İçerik</label>
			<textarea name="kisa_icerik" class="span12" rows="2" required><?= $oku->kisa_icerik ?></textarea>
			<label for="IDofInpıt">Resim</label>
			<input type="file" name="files[]" id="files[]">
			<label for="IDofInput">İçerik</label>
			<textarea name="icerik" id="icerik" class="span12" rows="5" required><?= $oku->icerik ?></textarea>
			<div class="row-fluid" style="margin-top: 10px;">
				<div class="span6">
					<button type="submit" name="a" value="b" class="btn blue btn-block">Güncelle</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	CKEDITOR.replace( 'icerik', {
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


