<?php 
$cek = mysql_query("select * from uyelik_pdf where id = 1");
$oku = mysql_fetch_object($cek);
$bireysel = $oku->bireysel_pdf;
$kurumsal = $oku->kurumsal_pdf;
if(re("bireysel")=="guncelle")
{
	if (isset($_FILES['files']))
	{ // dosya tanımlanmıs mı?
		$errors = array();
		foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name)
		{
			if ($_FILES['files']['name'][$key] != "")
			{
				$dosyaUzantisi = pathinfo($_FILES["files"]["name"][0], PATHINFO_EXTENSION);
				$dosya_adi = $_FILES['files']['name'][$key]; // uzantiya beraber dosya adi
				$dosya_boyutu = $_FILES['files']['size'][$key]; // byte cinsinden dosya boyutu
				$dosya_gecici = $_FILES['files']['tmp_name'][$key]; //gecici dosya adresi
				$yenisim = md5(microtime()) . '.' . $dosyaUzantisi; //karmasik yeni isim.png
				if ($dosya_boyutu > 209715200)
				{
					$errors[] = 'Maksimum 200 Mb lık dosya yuklenebilir.';
				}
				$klasor = "../images/pdf"; // yuklenecek dosyalar icin yeni klasor
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
				$yol = $bireysel;
			}
			if (empty($error))
			{
				$sql = mysql_query("update uyelik_pdf set bireysel_pdf = '".$yol."' where id = 1");
				if ($sql)
				{
					echo '<script>alert("Başarılı")</script>';
					echo "<script>window.location.href = '?modul=ayarlar&sayfa=uyelik_sozlesmesi';</script>";					
				}
				else
				{
					echo '<script>alert("Hata! Lütfen tekrar deneyin")</script>';
				}
			}
		}
	}
}
if(re("kurumsal")=="guncelle")
{
	if (isset($_FILES['files']))
	{ // dosya tanımlanmıs mı?
		$errors = array();
		foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name)
		{
			if ($_FILES['files']['name'][$key] != "")
			{
				$dosyaUzantisi = pathinfo($_FILES["files"]["name"][0], PATHINFO_EXTENSION);
				$dosya_adi = $_FILES['files']['name'][$key]; // uzantiya beraber dosya adi
				$dosya_boyutu = $_FILES['files']['size'][$key]; // byte cinsinden dosya boyutu
				$dosya_gecici = $_FILES['files']['tmp_name'][$key]; //gecici dosya adresi
				$yenisim = md5(microtime()) . '.' . $dosyaUzantisi; //karmasik yeni isim.png
				if ($dosya_boyutu > 209715200)
				{
					$errors[] = 'Maksimum 200 Mb lık dosya yuklenebilir.';
				}
				$klasor = "../images/pdf"; // yuklenecek dosyalar icin yeni klasor
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
				$yol = $kurumsal;
			}
			if (empty($error))
			{
				$sql = mysql_query("update uyelik_pdf set kurumsal_pdf = '".$yol."' where id = 1");
				if ($sql)
				{
					echo '<script>alert("Başarılı")</script>';
					echo "<script>window.location.href = '?modul=ayarlar&sayfa=uyelik_sozlesmesi';</script>";					
				}
				else
				{
					echo '<script>alert("Hata! Lütfen tekrar deneyin")</script>';
				}
			}
		}
	}
}
?>

<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Bireysel Üyelik PDF Düzenle</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<div class="form-horizontal">
				   	<div class="control-group">
						<label class="control-label">Üyelik PDF</label>
						<div class="controls">
							<input type="file" name="files[]" id="files[]"  />					
						</div>
					</div>				   					
					<div class="form-actions">
						<button type="submit" class="btn blue" name="bireysel" value="guncelle">Bireysel Üyelik Sözleşmesini Güncelle</button>
						<a class="btn green" href="../images/pdf/<?= $bireysel ?>" target="_blank">Bireysel Üyelik Sözleşmesini Görüntüle</a>
					</div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>		
</form>

<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Kurumsal Üyelik PDF Düzenle</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<div class="form-horizontal">
				   	<div class="control-group">
						<label class="control-label">Kurumsal Üyelik PDF</label>
						<div class="controls">
							<input type="file" name="files[]" id="files[]"/> 					
						</div>
					</div>				   					
					<div class="form-actions">
					<button type="submit" class="btn blue" name="kurumsal" value="guncelle">Kurumsal Üyelik Sözleşmesini Güncelle</button>
					<a class="btn green" href="../images/pdf/<?= $kurumsal ?>" target="_blank">Kurumsal Üyelik Sözleşmesini Görüntüle</a>
					</div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>		
</form>
