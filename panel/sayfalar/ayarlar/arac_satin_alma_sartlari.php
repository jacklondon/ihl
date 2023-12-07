<?php 
session_start();
$arac_satin_alma_sarti_id = re("id");
$sart_cek = mysql_query("SELECT * FROM arac_satin_alma_sartlari");
?>
<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Araç Satın Alma Şartları</h3>
<form name="satin_alma_sartlari" method="post" enctype="multipart/form-data">
    <textarea name="arac_satin_alma_sartlari" id="arac_satin_alma_sartlari"></textarea>
    <div class="form-actions">
        <input type="submit" name="arac_satin_alma_sartlarini" class="btn blue" value="Kaydet" />
    </div>
</form>


<?php 
if(re('arac_satin_alma_sartlarini')=="Kaydet"){
    $sartlar = re('arac_satin_alma_sartlari');
    mysql_query("UPDATE `arac_satin_alma_sartlari` SET `sartlar` = '$sartlar' ");
    header('Location: ?modul=ayarlar&sayfa=arac_satin_alma_sartlari');
}
?>



<h3>Araç Satın Alma Şartları</h3>
    <?php 
        $sayac=1;
        while($sart_oku = mysql_fetch_array($sart_cek)){
    ?>
 <div class="row-fluid">
    <div class="span6" style="background-color: #eaeaea;">
        <p name=><?= $sart_oku["sartlar"] ?></p>
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
CKEDITOR.replace( 'arac_satin_alma_sartlari', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
  
        
</script>


