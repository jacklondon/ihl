<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Reklam Ekle</h3>

<form name="reklam" method="post" enctype="multipart/form-data">
<?php include 'islemler/ayarlar/reklam_ekle.php'; ?>
    <div class="row-fluid">
        <div class="span4">
            <input type="file" name="file">
        </div>
        <div class="span8">
            <label for="IDofInput">Yönlendirilecek Url</label>
            <input type="text" name="reklam_url" class="form-control span12">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <label for="BegınofAdvertisement">Reklam Başlangıç Tarihi</label>
            <input type="datetime-local" class="span12" name="reklam_baslangic">
        </div>
        <div class="span6">
            <label for="EndofAdvertisiment">Reklam Bitiş Tarihi</label>
            <input type="datetime-local" class="span12" name="reklam_bitis">
        </div>
    </div>
    <textarea name="reklam_ayarlari" id="reklam_ayarlari"></textarea>
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


<?php 
$suan = date('Y-m-d H:i:s');
$reklam_cek = mysql_query("SELECT * FROM reklamlar WHERE baslangic_tarihi <= '".$suan."' AND bitis_tarihi >= '".$dateTime."'");
$sira = 1;
?>
<div class="row-fluid">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sıra</th>
                <th>Ekleyen</th>
                <th>Gidilecek URL</th>
                <th>Bitiş Tarihi</th>
                <th>Düzenle</th>
                <th>Sil</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($reklam_oku = mysql_fetch_array($reklam_cek)){ 
                $ekleyen = $reklam_oku['ekleyen'];
                $admin_bul = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$ekleyen."'");
                $admin_yaz = mysql_fetch_assoc($admin_bul);
            ?>
                <tr>
                    <td><?= $sira++ ?></td>
                    <td><?= $admin_yaz['adi']." ".$admin_yaz['soyadi'] ?></td>
                    <td><?= $reklam_oku['url'] ?></td>
                    <td><?= $reklam_oku['bitis_tarihi'] ?></td>
                      <td><a href="?modul=ayarlar&sayfa=reklam_guncelle&id=<?= $reklam_oku['id'] ?>" ><i style="color:black;" class="fas fa-edit"></i></a></td>
                    <td><a href="?modul=ayarlar&sayfa=data_sil&id=<?= $reklam_oku['id'] ?>&q=reklam_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')"><i style="color:black;" class="fas fa-trash"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>