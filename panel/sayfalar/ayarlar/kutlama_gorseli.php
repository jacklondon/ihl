
<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Kutlama Görseli</h3>
<form name="reklam" method="post" enctype="multipart/form-data">
<?php include('islemler/ayarlar/kutlama_ekle.php'); ?>
    <div class="row-fluid">
        <div class="span6">
            <label for="BegınofAdvertisement">Reklam Başlangıç Tarihi</label>
            <input type="date" class="span12" name="reklam_baslangic">
        </div>
        <div class="span6">
            <label for="EndofAdvertisiment">Reklam Bitiş Tarihi</label>
            <input type="date" class="span12" name="reklam_bitis">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <label for="BegınofAdvertisement">Yazı Rengi Seçin</label>
            <input type="color" class="span12" id="yazi_rengi" name="yazi_rengi" value="#ffee00">
        </div>
        <div class="span6">
            <label for="EndofAdvertisiment">Arkaplan Rengi Seçin</label>
            <input type="color" class="span12" id="arkaplan_rengi" name="arkaplan_rengi" value="#000000">
        </div>
    </div>
    <div class="row-fluid">
        <label for="IDofInput">Mesaj İçeriği</label>
        <textarea name="icerik" id="icerik"></textarea>
    </div>
    <div class="form-actions">
        <input type="submit" name="kutlama_gorselini" class="btn blue" value="Kaydet" />
    </div>
</form>
<script>
CKEDITOR.replace( 'icerik', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
  
        
</script>

<?php $kutlamayi_cek = mysql_query("select * from kutlama_gorseli"); $sayac = 1;?>

<table class="table table-bordered">
    <caption><h2>Kutlama Mesajları</h2></caption>
    <thead>
        <tr>
            <th>Sıra</th>
            <th>Yazı Renk</th>
            <th>Arkaplan</th>
            <th>İçerik</th>
            <th>Başlangıç Tarihi</th>
            <th>Bitiş Tarihi</th>
            <th>Düzenle</th>
            <th>Sil</th>
        </tr>
    </thead>
    <tbody>
        <?php while($kutlama_oku = mysql_fetch_array($kutlamayi_cek)){ 
            $kutlama_id = $kutlama_oku["id"];
        ?>
        <tr>
            <td><?= $sayac++ ?></td>
            <td><input disabled type = "color" style="width:75%;" value="<?= $kutlama_oku['yazi_renk'] ?>"></td>
            <td><input disabled type = "color" style="width:75%;" value="<?= $kutlama_oku['arkaplan_renk'] ?>"></td>
            <td><?= $kutlama_oku['icerik'] ?></td>
            <td><?= date('d-m-Y',strtotime($kutlama_oku["reklam_baslangic"])) ?></td>
            <td><?= date('d-m-Y',strtotime($kutlama_oku["reklam_bitis"])) ?></td>
            <td><a href="?modul=ayarlar&sayfa=edit_kutlama&id=<?= $kutlama_id ?>"><i class="fas fa-edit"></i></a></td>
            <td><a href="?modul=ayarlar&sayfa=data_sil&id=<?= $kutlama_id ?>&q=kutlama_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')"><i class="fas fa-trash"></i></a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>