<?php 
session_start();
$metin_cek = mysql_query("SELECT * FROM arac_detay_onemli_metni");
?>
<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Araç Satın Alma Şartları</h3>
<form name="satin_alma_sartlari" method="post" enctype="multipart/form-data">
    <textarea name="arac_detay_onemli_metni" id="arac_detay_onemli_metni"></textarea>
    <div class="form-actions">
        <input type="submit" name="arac_detay_onemli_metnini" class="btn blue" value="Kaydet" />
    </div>
</form>


<?php 
if(re('arac_detay_onemli_metnini')=="Kaydet"){
    $metin = re('arac_detay_onemli_metni');
    mysql_query("UPDATE `arac_detay_onemli_metni` SET `metin` = '$metin' ");
    header('Location: ?modul=ayarlar&sayfa=arac_detay_onemli_metni');
}
?>



<h3>Araç Detay Önemli Metni</h3>
    <?php 
        $sayac=1;
        while($metin_oku = mysql_fetch_array($metin_cek)){
    ?>
  <div class="row-fluid">
    <div class="span6" style="background-color: #eaeaea;">
        <p name=><?= $metin_oku["metin"] ?></p>
    </div>
    <div class="span6">
 
    </div>
</div>
   
<?php } ?>

<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    CKEDITOR.replace( 'arac_detay_onemli_metni', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
</script>


