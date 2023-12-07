<?php 
$gelen_id = re('id');
$yorumu_getir = mysql_query("SELECT * FROM yorumlar WHERE id = '".$gelen_id."'");
$yorum_cek = mysql_fetch_assoc($yorumu_getir);
$yorum = $yorum_cek['yorum'];
?>

<form method="post" style="margin-top: 3%;">
    <textarea name="gelen_yorum" style="width:100%;" rows="4" readonly><?= $yorum ?></textarea>
    <textarea name="cevap" id="cevap" style="width:100%;" rows="4"><?= $yorum_cek["cevap"] ?></textarea>
    <input type="submit" name="yorumu" class="btn blue btn-block" value="Cevapla">
</form>

<?php 
if(re("yorumu")=="Cevapla"){
    $cevap_zaman = date('Y-m-d H:i:s');
    mysql_query("UPDATE yorumlar SET cevap = '".re('cevap')."', cevap_zamani = '".$cevap_zaman."' WHERE id = '".$gelen_id."'");
    header('refresh: 0');
}
?>