<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Araç Detay Müşteri Temsilcisi Metni</h3>
<form name="arac_detay" method="POST" name="form" id="form" enctype="multipart/form-data">
<?php include('islemler/ayarlar/temsilci_metni_ekle.php'); ?>
    <textarea name="musteri_temsilcisi_metni" id="musteri_temsilcisi_metni" class="span10" rows="7"></textarea>
    <div class="form-actions">
        <input type="submit" name="musteri_temsilcisi_metnini" class="btn blue" value="Kaydet" />
    </div>
</form>

<?php 
    $metni_cek  = mysql_query("SELECT * FROM arac_detay_musteri_temsilcisi_metni");
?>
<?php 
    while($metni_oku = mysql_fetch_array($metni_cek)){
        $metin_id = $metni_oku['id'];
?>

<div class="row-fluid">
    <div class="span6" style="background-color: #eaeaea;">
        <p name=><?= $metni_oku["icerik"] ?></p>
    </div>
    <div class="span6">
    <!--<a href="?modul=ayarlar&sayfa=data_sil&id=<?= $metin_id ?>&q=metni_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn red">Sil</a>-->
   
    </div>
</div>
<?php } ?>

<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    CKEDITOR.replace( 'musteri_temsilcisi_metni', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
        
</script>

 