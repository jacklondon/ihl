<?php 

if(re('silmeyi')=="Kaydet"){
    $silme_cek = mysql_query("select * from eski_ilan_sil");
    $silme_say = mysql_num_rows($silme_cek);
    if($silme_say == 0){
        $sql = mysql_query("INSERT INTO `eski_ilan_sil` (`id`, `ay_sayi`,`silme_tarihi`, `g_tarihi`, `durum`) VALUES (NULL, '".re('ay_sayi')."', '' ,'', '1');");
    }else{
        $sql = mysql_query("update eski_ilan_sil set ay_sayi = '".re('ay_sayi')."', g_tarihi = '".date('Y-m-d H:i:s')."'");
    }
    if($sql){
        // mysql_query("update ilanlar set durum = 2 where ihale_tarihi < '".re('sil_tarih')."'");
        // echo "<script>alert('Eski ilanları silme tarihi ayarlandı, belirttiğiniz tarihten önceki ilanlar silindi.')</script>";
        echo "<script>alert('Eski ilanları silme tarihi ayarlandı.')</script>";
        echo "<script>window.location.href = '?modul=admin&sayfa=eski_ilan_sil';</script>";
    }else{
        echo "<script>alert('Hata Lütfen Tekrar Deneyiniz.')</script>";
        echo "<script>window.location.href = '?modul=admin&sayfa=eski_ilan_sil';</script>";
    }
}
$cek = mysql_query("select * from eski_ilan_sil");
$oku = mysql_fetch_assoc($cek);
for($i=3;$i<=24;$i++){
    $selected = "";
    if($oku["ay_sayi"] == $i){
        $selected = "selected";
    }
    $options .= '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
}
?>
<form method="POST" id="form" name="form">
    <div class="row-fluid" style="margin-top: 2%;">
        <div class="span8">
            <label for="IDofInput">Kaç aydan önceki ilanlar silinsin ?</label>
            <select name="ay_sayi" class="span12">
                <option value="">Seçiniz</option>
                <?= $options ?>
            </select>
            <!-- <input type="date" class="span12" name="sil_tarih" class="span12" value="<?= $oku['silme_tarihi'] ?>"> -->
            <div class="form-actions">
                <input type="submit" name="silmeyi" class="btn blue" value="Kaydet" />
            </div>
        </div>
    </div>
</form>

