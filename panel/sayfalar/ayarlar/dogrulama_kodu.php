<?php 
	session_start();

	$dogrulama_durumu_cek = mysql_query("SELECT * FROM dogrulama_durumu");
	$dogrulama_durumu_oku=mysql_fetch_object($dogrulama_durumu_cek);
?>
<form method="POST" name="form" id="form" action="">
	<div class="row-fluid" style="margin-top:2%;">
		<div class="span2">
			<p>Doğrulama Durumu :</p>
		</div>
		<div class="span10">
			<input type="checkbox" name="dogrulama_durumu" value="1" <?php if($dogrulama_durumu_oku->dogrulama_durumu==1){ echo "checked"; }?> class="span3">
		</div>
	</div>
	<div class="row-fluid">
		
		<div class="span12">
			<input type="submit" class="btn" name="kaydet" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
		</div>
	</div>
</form>

<?php 
	if(re("kaydet")=="Kaydet"){
		$sorgu=mysql_query("
			UPDATE
				dogrulama_durumu
			SET 
				dogrulama_durumu='".$_POST['dogrulama_durumu']."'
			WHERE 
				id=1
		");
		if($sorgu){
			alert("işlem başarılı");
			echo "<script>window.location.href = '?modul=ayarlar&sayfa=dogrulama_kodu'</script>";
		}
		
	}
?>

