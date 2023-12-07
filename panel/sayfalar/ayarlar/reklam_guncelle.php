<?php 
	$reklam_cek=mysql_query("select * from reklamlar where id='".re("id")."'");
	$reklam_oku=mysql_fetch_object($reklam_cek);
	$parcala=explode(":",$reklam_oku->baslangic_tarihi);
	$b_tarih=$parcala[0].":".$parcala[1];
	$b_parcala=explode(" ",$b_tarih);
	$b_tarih=$b_parcala[0]."T".$b_parcala[1];
	
	$parcala2=explode(":",$reklam_oku->bitis_tarihi);
	$b_tarih2=$parcala2[0].":".$parcala2[1];
	$b_parcala2=explode(" ",$b_tarih2);
	$b_tarih2=$b_parcala2[0]."T".$b_parcala2[1];

?>

<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Reklam Ekle</h3>

<form name="reklam" method="post" enctype="multipart/form-data">
<?php include 'islemler/ayarlar/reklam_guncelle.php'; ?>
    <div class="row-fluid">
        <div class="span4">
            <input type="file" name="file"> <br/>
			Mevcut Reklam: <br/>
			<img src="../reklamlar/<?=$reklam_oku->resim ?>" style="width:50%;" >
        </div>
        <div class="span8">
            <label for="IDofInput">Yönlendirilecek Url</label>
            <input type="text" name="reklam_url" value="<?=$reklam_oku->url ?>" class="form-control span12">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <label for="BegınofAdvertisement">Reklam Başlangıç Tarihi</label>
            <input type="datetime-local" value="<?=$b_tarih ?>" class="span12" name="reklam_baslangic">
        </div>
        <div class="span6">
            <label for="EndofAdvertisiment">Reklam Bitiş Tarihi</label>
            <input type="datetime-local" value="<?=$b_tarih2 ?>" class="span12" id="reklam_bitis" name="reklam_bitis">
        </div>
    </div>
    <textarea name="reklam_ayarlari" id="reklam_ayarlari"><?=$reklam_oku->icerik ?></textarea>
    <div class="form-actions">
        <input type="submit" name="reklam_ayarlarini" class="btn blue" value="Kaydet" />
    </div>
</form>

<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    CKEDITOR.replace( 'reklam_ayarlari', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
</script>


