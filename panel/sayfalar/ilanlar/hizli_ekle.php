<?php 
if(re('veriyi')=="kaydet"){
    $tarih = date('Y-m-d H:i:s');
    $kat_ekle = mysql_query("INSERT INTO `hizli_ekle_kategori` (`id`, `adi`, `tarih`, `durum`) VALUES (NULL, '".re('kategori_adi')."', '".date('Y-m-d H:i:s')."', '1');");
    if($kat_ekle){
        $kati_getir = mysql_query("select * from hizli_ekle_kategori where adi = '".re('kategori_adi')."' and tarih = '".$tarih."'");
        $kati_oku = mysql_fetch_assoc($kati_getir);
        $icine_ekle = mysql_query("INSERT INTO `hizli_ekle_detay` (`id`, `kategori_id`, `sayi`, `plaka`, `arac_kodu`, `hesaplama`, `sigorta`, `marka`, `model`, `tip`, `model_yili`, 
        `piyasa_degeri`, `tsrsb_degeri`, `acilis_fiyati`, `son_teklif`, `profil`, `sehir`, `ilce`, `ihale_tarihi`, `ihale_saati`, `pd_hizmet`, `otopark_giris`, `otopark_ucreti`, `cekici_ucreti`, `dosya_masrafi`, 
        `link`, `kilometre`, `uyari_notu`, `hasar_bilgileri`, `notlar`, `adres`, `donanimlar`, `vitrin`, `eklenme_zamani`, `ilan_url`, `ihale_sahibi`, `ihale_acilis`, `durum`, `ihale_turu`, `vites_tipi`, `yakit_tipi`)
         VALUES
         (NULL, '".$kati_oku['id']."', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');");
        echo "<script>alert('Kategori Eklendi');</script>";
        echo "<script>window.location.href = '?modul=ilanlar&sayfa=hizli_ekle';</script>";
    }else{
        echo "<script>alert('Hata! Lütfen Tekrar Deneyiniz');</script>";
        echo "<script>window.location.href = '?modul=ilanlar&sayfa=hizli_ekle';</script>";
    }
}
$kat_cek = mysql_query("select * from hizli_ekle_kategori where durum = 1");
$kat_bas = '';
$sira = 1;
while($kat_oku = mysql_fetch_array($kat_cek)){
    $kat_bas .= '
	<tr>
        <td>'.$sira++.'</td>
        <td>'.$kat_oku["adi"].'</td>
        <td>'. date("d-m-Y H:i:s", strtotime($kat_oku["tarih"])).'</td>
        <td><a href="?modul=ilanlar&sayfa=ilan_ekle&hizli_ekle_kategori_id='.$kat_oku["id"].'"><button type="button" class="btn-primary">İlan Ekle</button></a></td>
        <td><a href="?modul=ilanlar&sayfa=hizli_ilan_duzenle&id='.$kat_oku["id"].'"><button type="button" class="btn-success">Kategoriyi Düzenle</button></a></td>
        <td><a href="?modul=ayarlar&sayfa=data_sil&id='.$kat_oku["id"].'&q=hizli_kategori_sil"><button type="button" class="btn-danger">Sil</button></a></td>
    </tr>';
}
?>
<div class="row-fluid">
<form method="POST" style="margin-top: 25px;">
  <fieldset>
    <legend>Yeni Kategori Oluşturma</legend>
    <label>Kategori Adı</label>
    <input type="text" name="kategori_adi" class="span6 m-wrap" placeholder="Eklemek istediğiniz kategori adı"><br>    
    <button type="submit" class="btn-primary" name="veriyi" value="kaydet">Kategoriyi Ekle</button>
  </fieldset>
</form>
</div>
<hr>
<div class="row-fluid">
<legend>KATEGORİLER</legend>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sıra</th>
                <th>Kategori Adı</th>
                <th>Ekleme Tarihi</th>
                <th>İlan Ekle</th>
                <th>Düzenle</th>
                <th>Sil</th>
            </tr>
        </thead>
        <tbody>
            <?= $kat_bas ?>
        </tbody>
    </table>
</div>






