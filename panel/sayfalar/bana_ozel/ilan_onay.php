<?php 
$date = date('Y-m-d H:i:s');
?>
<?php 
$cek = mysql_query("SELECT * FROM ilan_uyari");
$oku = mysql_fetch_assoc($cek);
?>
<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<div class="row-fluid">
    <form method="POST">
    <label for="IDofInput">İlan Ekleme Onay Mesajı</label>

    <textarea name="icerik" id="donanimlar" class="span12" rows="10"><?= $oku['icerik'] ?></textarea>
    <input type="submit" class="btn blue" name="onayi" value="Kaydet">
    </form>
</div>
<script src="assets/ckeditor4/ckeditor.js"></script>
<script>
 CKEDITOR.replace( 'donanimlar', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} ); 
  
</script>

<?php 
if(re('onayi')=="Kaydet"){
    $sor = mysql_query("SELECT * FROM ilan_uyari");
    $say = mysql_num_rows($sor);
    if($say == 0){
        mysql_query("INSERT INTO `ilan_uyari` (`id`, `icerik`, `tarih`) VALUES (NULL, '".re('icerik')."', '".$date."');");
    }else{
        mysql_query("UPDATE `ilan_uyari` SET icerik = '".re('icerik')."', tarih = '".$date."'");
    }
	header('Location: ?modul=bana_ozel&sayfa=ilan_onay');
}
?>


