<?php 
    $gelen_id = re('id');
    $cek = mysql_query("select * from kutlama_gorseli where id = '".$gelen_id."'");
    $oku = mysql_fetch_object($cek);


    if(re('action') == "edit_kutlama"){
        $id = re('id');
        $reklam_baslangic = re('reklam_baslangic');
        $reklam_bitis = re('reklam_bitis');
        $yazi_renk = re('yazi_renk');
        $arkaplan_renk = re('arkaplan_renk');
        $icerik = re('icerik');
        $sql = mysql_query("update kutlama_gorseli set yazi_renk = '".$yazi_renk."', arkaplan_renk = '".$arkaplan_renk."', icerik = '".$icerik."',
        reklam_baslangic = '".$reklam_baslangic."', reklam_bitis = '".$reklam_bitis."' where id = '".$id."'");
        header('refresh: 0');
    }


?>
<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Kutlama Görseli</h3>
<form name="reklam" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="edit_kutlama">
    <input type="hidden" name="id" value="<?= $gelen_id ?>">
    <div class="row-fluid">
        <div class="span6">
            <label for="BegınofAdvertisement">Reklam Başlangıç Tarihi</label>
            <input type="date" class="span12" name="reklam_baslangic" value="<?= $oku->reklam_baslangic ?>">
        </div>
        <div class="span6">
            <label for="EndofAdvertisiment">Reklam Bitiş Tarihi</label>
            <input type="date" class="span12" name="reklam_bitis" value="<?= $oku->reklam_bitis ?>">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <label for="BegınofAdvertisement">Yazı Rengi Seçin</label>
            <input type="color" class="span12" name="yazi_renk" value="<?= $oku->yazi_renk ?>">
        </div>
        <div class="span6">
            <label for="EndofAdvertisiment">Arkaplan Rengi Seçin</label>
            <input type="color" class="span12" name="arkaplan_renk" value="<?= $oku->arkaplan_renk ?>">
        </div>
    </div>
    <div class="row-fluid">
        <label for="IDofInput">Mesaj İçeriği</label>
        <textarea name="icerik" id="icerik"><?= $oku->icerik ?></textarea>
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
