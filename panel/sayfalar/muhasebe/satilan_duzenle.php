<?php 

session_start();
$admin_id=$_SESSION['kid'];
$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
$yetkiler=$admin_yetki_oku["yetki"];
$yetki_parcala=explode("|",$yetkiler);

if (!in_array(10, $yetki_parcala)) { 
	echo '<script>alert("Bu Sayfaya Giriş Yetkiniz Yoktur")</script>';
	echo "<script>window.location.href = 'index.php'</script>";
} 

$gelen_id = re('id');
$satilan_cek = mysql_query("SELECT * FROM satilan_araclar WHERE id = '".$gelen_id."'");
$oku = mysql_fetch_assoc($satilan_cek);
?>

<form method="POST">
    <div class="row-fluid">
        <div class="span6">
            <label for="IDofInput">KOD</label>
            <input type="text" class="span12" name="kod" value="<?= $oku['kod'] ?>">
            <label for="IDofInput">Ödeme Tarihi</label>
            <input type="date" class="span12" name="odeme_tarihi" value="<?= $oku['odeme_tarihi'] ?>">
            <label for="IDofInput">Parayı Gönderen</label>
            <input type="text" class="span12" name="parayi_gonderen" value="<?= $oku['parayi_gonderen'] ?>">
            <label for="IDofInput">Araç Plakası</label>
            <input type="text" class="span12" name="plaka" value="<?= $oku['plaka'] ?>">
            <label for="IDofInput">Marka Model</label>
            <input type="text" class="span12" name="marka_model" value="<?= $oku['marka_model'] ?>">
            <label for="IDofInput">Sigorta</label>
            <input type="text" class="span12" name="sigorta" value="<?= $oku['sigorta'] ?>">
            <label for="IDofInput">Aracı Alan Üye</label>
            <input type="text" class="span12" name="araci_alan" value="<?= $oku['araci_alan'] ?>">
        </div>
        <div class="span6">
            <label for="IDofInput">Satış Kimin Adına Yapıldı</label>
            <input type="text" class="span12" name="satis_adi" value="<?= $oku['satis_adi'] ?>">
            <label for="IDofInput">Satış Tarihi</label>
            <input type="date" class="span12" name="tarih" value="<?= $oku['tarih'] ?>">
            <label for="IDofInput">Maliyet</label>
            <input type="text" class="span12" name="maliyet" value="<?= $oku['maliyet'] ?>">
            <label for="IDofInput">Satılan Fiyat</label>
            <input type="text" class="span12" name="satilan_fiyat" value="<?= $oku['satilan_fiyat'] ?>">
            <label for="IDofInput">PD Hizmet Bedeli</label>
            <input type="text" class="span12" name="pd_hizmet" value="<?= $oku['pd_hizmet'] ?>">
            <label for="IDofInput">Extra Kazanç</label>
            <input type="text" class="span12" name="ekstra_kazanc" value="<?= $oku['ektra_kazanc'] ?>">
            <label for="IDofInput">Açıklayıcı Notlar</label>
            <input type="text" class="span12" name="aciklayici_not" value="<?= $oku['aciklayici_not'] ?>">
            <label for="IDofInput">Toplam Kar Zarar</label>
            <b> <?= money($oku['ciro']) ?> ₺ </b>
        </div>
    </div>
    <div class="row-fluid">
        <input type="submit" name="gunceli" class="btn blue" value="Kaydet">
    </div>
</form>

<?php 
if(re('gunceli')=="Kaydet"){
    $ciro = re('satilan_fiyat') -  re('maliyet')+ re('ekstra_kazanc') + re('pd_hizmet');
  
   mysql_query("UPDATE satilan_araclar SET kod = '".re('kod')."', odeme_tarihi = '".re('odeme_tarihi')."',
    parayi_gonderen = '".re('parayi_gonderen')."',plaka='".re('plaka')."',marka_model = '".re('marka_model')."',
    sigorta = '".re('sigorta')."',araci_alan = '".re('araci_alan')."',satis_adi='".re('satis_adi')."',
    tarih='".re('tarih')."',maliyet='".re('maliyet')."',satilan_fiyat='".re('satilan_fiyat')."',
    pd_hizmet = '".re('pd_hizmet')."',ektra_kazanc='".re('ekstra_kazanc')."', aciklayici_not='".re('aciklayici_not')."',
    ciro = '".$ciro."' WHERE id = '".$gelen_id."'");

    header('Location: ?modul=muhasebe&sayfa=satilan_araclar');
    

     
}

?>