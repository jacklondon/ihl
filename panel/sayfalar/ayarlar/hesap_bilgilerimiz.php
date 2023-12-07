<!--<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>-->
<script src="assets/ckeditor4/ckeditor.js"></script>
<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>

<form action="" method="POST" name="form" id="form" enctype="multipart/form-data">
<?php include 'islemler/ayarlar/hesap_bilgileri_ekle.php'; ?>
<div class="row-fluid" style="margin-top: 2%;">
    <label for="IDofInput">Açıklamalar</label>
    <textarea class="span12" rows="8" name="aciklamalar" id="aciklamalar"></textarea>
</div>
<!-- <div class="row-fluid">
    <label for="IDofInput">Resimler</label>
    <input class="span12" type="file" class="span12" name="resim[]" multiple>
</div> -->
<!-- <div class="row-fluid" style="margin-top: 2%;">
    <label for="IDofInput">Resmin Altında olacak açıklamalar</label>
    <textarea class="span12" rows="8" name="aciklama_yeni" id="aciklama_yeni"></textarea>
</div> -->

<div class="row-fluid">
<div class="span3">
        </div>
        <div class="span6" style="margin-top: 5%;">
        <input type="submit" name="hesap_bilgilerini" value="Kaydet" class="btn-primary btn-block">
        </div>
        <div class="span3">
        </div>
</div>
</form>

<script>
    /*ClassicEditor
        .create(document.querySelector('#aciklamalar'))
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );*/

    CKEDITOR.replace( 'aciklamalar', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
        
</script>


<?php $cek = mysql_query("SELECT * FROM hesap_bilgileri");
while($oku = mysql_fetch_array($cek)){
    $gelen_id = $oku['id'];
    $resim_cek = mysql_query("SELECT * FROM hesap_resimler WHERE hesap_id = '".$gelen_id."'");
?>
<div class="row-fluid">
<?= $oku['icerik'] ?>
</div>
<form method="POST">
<div class="row-fluid">
    <input type="submit" class="btn-danger" onclick="return confirm('Silmek istediğinize emin misiniz ?')" name="hesap_bilgisini" value="Sil">
</div>
</form>

<?php 
    if(re('hesap_bilgisini')=="Sil"){
		mysql_query("DELETE FROM hesap_bilgileri");
        mysql_query("DELETE FROM hesap_resimler");
    }
?>


<?php } ?>

