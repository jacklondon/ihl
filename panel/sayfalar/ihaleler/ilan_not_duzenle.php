<?php 
 $not_cek=mysql_query("select * from ilan_notlari where id='".re("id")."'");
	$not_oku=mysql_fetch_object($not_cek);
	if($not_oku->gizlilik=="0"){ 
		$gizlilik="selected";
		$gizlilik2="";
		$gizlilik3="";
	}else if($not_oku->gizlilik=="1"){
		$gizlilik="";
		$gizlilik2="selected"; 
		$gizlilik3="";
	}else {
		$gizlilik="";
		$gizlilik2="";
		$gizlilik3="selected";
	}
	
	$ilan_id=$not_oku->ilan_id;
	$aktif_admin=mysql_query("select * from kullanicilar where id='".$_SESSION["kid"]."'");
	$aktif_admin_oku=mysql_fetch_object($aktif_admin);
	$aktif_admin_id=$aktif_admin_oku->id;
	$yetkiler=$aktif_admin_oku->yetki;
 
	$parcala=explode("|",$yetkiler);
	if (!in_array(8, $parcala)) { 
	 	echo '<script>alert("Bu Sayfaya Giriş Yetkiniz Yoktur")</script>';
		echo "<script>window.location.href = 'index.php'</script>";
	}
?>
<form method="POST" enctype="multipart/form-data">
	<div class="row-fluid>
	   <label for="IDofInput">Notunuz</label>
	   <textarea class="span12" name="eklenecek_not" id="eklenecek_not" rows="4"><?=$not_oku->ilan_notu ?></textarea>
	   <input type="hidden" value=<?=re("id") ?> name="gelen_id" id="gelen_id">
	</div>
	<div class="row-fluid">
	   <input type="file" name="files" multiple id="files" >
	   <input type="hidden" name="mevcut_dosya" value="<?=$not_oku->dosya ?>">
	</div>
	<br/>
	<div class="row-fluid">
		<div class="span2"><label>Gizlilik</label></div>
		<div class="span10">
			<select name="gizlilik">
				<option <?=$gizlilik ?> value="0">Sadece Ben </option>             
				<option <?=$gizlilik2 ?> value="1">Tam Yetkili Adminler Görebilir </option> 
				<option <?=$gizlilik3 ?> value="2" >Herkes Görebilir </option> 
			</select>
		</div>
	</div>
	<div class="row-fluid">
	  <div class="span2">
			<input type="submit" class="btn blue" name="notu" value="Güncelle" >
		</div>
		
	</div>
</form>

<?php
	if(re("notu")=="Güncelle"){
		if($_FILES["files"]["name"]==""){
			$guncelle=mysql_query("UPDATE `ilan_notlari` SET ilan_notu = '".re("eklenecek_not")."',tarih='".date("Y-m-d H:i:s")."',gizlilik='".re("gizlilik")."' WHERE `ilan_notlari`.`id` = '".re("id")."';");
			header('refresh: 0');
			// header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
			// echo '<script>javascript: history.go(-2)</script>';
		}else{

   			$dosya_adi =$_FILES['files']['name']; 		// uzantiya beraber dosya adi 
   			$dosya_boyutu =$_FILES['files']['size'];    		// byte cinsinden dosya boyutu 
   			$dosya_gecici =$_FILES['files']['tmp_name'];		//gecici dosya adresi 
   			$yenisim=md5(microtime()).$dosya_adi; 					//karmasik yeni isim.pdf                  
   			$klasor="../assets"; // yuklenecek dosyalar icin yeni klasor 
				//olusturdugumuz isimde dosya var mı?  
			$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 	
			
			$guncelle=mysql_query("UPDATE `ilan_notlari` SET `ilan_notu` = '".re("eklenecek_not")."',tarih='".date("Y-m-d H:i:s")."',dosya='".$yenisim."',gizlilik='".re("gizlilik")."' WHERE `ilan_notlari`.`id` = '".re("id")."';");
			
			mysql_query(
							"INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) 
							VALUES 
						(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','".$ilan_id."','','');"
				); 
			if($guncelle){
				alert("Başarıyla Eklendi..");
				header('refresh: 0');
				// header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
				// echo '<script>javascript: history.go(-2)</script>';
			}

		}
		
	}

 ?>