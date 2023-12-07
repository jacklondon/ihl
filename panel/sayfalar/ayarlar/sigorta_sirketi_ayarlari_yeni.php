<?php 
session_start();
$gelen_id=re("id");
$hepsini_cek = mysql_query("SELECT * FROM sigorta_sirketleri WHERE id = $gelen_id");

?>
<br>
<?php if(!empty($gelen_id)){ ?>
<form method="POST" enctype="multipart/form-data" id="form" action="#" name="form" >
<?php 
        while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
    ?>
<?php include('islemler/ayarlar/sigorta_sirketi_guncelle.php'); ?>
<div class="row-fluid" style="color: rgb(120,127,167);">
  <div class="span6">
      <label for="SirketAdi">Şirket Adı</label>
      <input type="text" name="sirket_adi" class="span12" value="<?= $hepsini_oku['sirket_adi'] ?>">
      <div class="row-fluid">
          <div class="span8">
              <label for="File">Altın üye teklif zil sesi</label>
              <input  type="file" name="zil_sesi" value="<?= $hepsini_oku['altin_uye_zil_sesi'] ?>" class="span12">
          </div>
          <div class="span4">
              <label for="dakika">Dakikası</label>
              <input type="text" name="dakika" value="<?= $hepsini_oku['altin_uye_zil_sesi_dakikasi'] ?>" class="span12">
          </div>
      </div>
      <h4>Teklif Ayarları</h4>
      <div class="row-fluid">          
          <div class="span6">
              <label for="HizliTeklif">Hızlı Teklif Gönder 1</label>
              <input type="text" name="hizli_teklif1" value="<?= $hepsini_oku['hizli_teklif_1'] ?>" class="span12">
              <label for="HizliTeklif">Hızlı Teklif Gönder 2</label>
              <input type="text" name="hizli_teklif2" value="<?= $hepsini_oku['hizli_teklif_2'] ?>" class="span12">
          </div>
          <div class="span6">
              <label for="HizliTeklif">Hızlı Teklif Gönder 3</label>
              <input type="text" name="hizli_teklif3" value="<?= $hepsini_oku['hizli_teklif_3'] ?>" class="span12">
              <label for="HizliTeklif">Hızlı Teklif Gönder 4</label>
              <input type="text" name="hizli_teklif4" value="<?= $hepsini_oku['hizli_teklif_4'] ?>" class="span12">
          </div>
      </div>
      <div class="row-fluid">
          <label for="MisafirUyeAracListeleme">Misafir Üye Araç Listeleme</label>
          <select name="misafir_uye_arac" id="misafir_uye_arac" value="<?= $hepsini_oku['misafir_arac_listeleme'] ?>" class="span12">
              <option value="0">Araçları Göremez</option>
              <option value="1">Sadece Listede Görür</option>
              <option value="2">Tamamen Görür</option>
          </select>
          <input type="checkbox" <?php if($hepsini_oku['misafir_detay_gorme'] == 1) echo "checked='checked'";?> name="misafir_detay_gorebilir" value="1"> Misafir Detay Görebilir<br>
      </div>
      <div class="row-fluid">
          <label for="DemoUyeAracListeleme">Demo Üye Araç Listeleme</label>
          <select name="demo_uye_arac" id="demo_uye_arac" value="<?= $hepsini_oku['demo_arac_listeleme'] ?>" class="span12">
              <option value="0">Araçları Göremez</option>
              <option value="1">Sadece Listede Görür</option>
              <option value="2">Tamamen Görür</option>
          </select>
          <input type="checkbox" <?php if($hepsini_oku['demo_detay_gorme'] == 1) echo "checked='checked'";?> name="demo_detay_gorebilir" value="1"> Demo Detay Görebilir<br>
          <input type="checkbox" <?php if($hepsini_oku['sure_uzatma'] == 1) echo "checked='checked'";?> name="sure_uzatma" value="1"> Süre Uzatma<br>
      </div>
      <div class="row-fluid">
          <div class="span6">
              <label for="DakikaninAltinda">Dakikanın Altında</label>
              <input type="text" class="span12" name="dakikanin_altinda" value="<?= $hepsini_oku['dakikanin_altinda'] ?>">
          </div>
          <div class="span6">
              <label for="DakikaUzar">Dakika Uzar</label>    
              <input type="text" class="span12" name="dakika_uzar" value="<?= $hepsini_oku['dakika_uzar'] ?>">
          </div>
      </div>
      <div class="row-fluid">
          <label for="UyariNotu">Uyarı Notu</label>
          <textarea name="uyari_notu" id="uyari_notu"  class="span12" rows="3"><?= $hepsini_oku['uyari_notu'] ?></textarea>
      </div>
      <div class="row-fluid">
          <label for="SigortaAciklamasi">Sigorta Açıklaması</label>
          <textarea name="sigorta_aciklamasi" id="sigorta_aciklamasi" class="span12"><?= $hepsini_oku['sigorta_aciklamasi'] ?></textarea>
      </div>
  </div>
  <!-- Sol taraf bitiş -->
  <div class="span6">
      <div class="row-fluid">
          <div class="span4">
              <label for="ParkUcreti" >Park Ücreti</label>
              <input type="text" name="park_ucreti" value="<?= $hepsini_oku['park_ucreti'] ?>" class="span12">
          </div>
          <div class="span4">
              <label for="SigortaDosyaMasrafi" style="font-size: smaller;">Sigorta Dosya Masrafı</label>
              <input type="text" name="sigorta_dosya_masrafi" value="<?= $hepsini_oku['sigorta_dosya_masrafi'] ?>" class="span12">
          </div>
          <div class="span4">
              <label for="MinumumArtis">Minumum Artış</label>
              <input type="text" name="minumum_artis" value="<?= $hepsini_oku['minumum_artis'] ?>" class="span12">
          </div>
      </div>
      <div class="row-fluid">
          <div class="span8">
              <label for="File"> Teklif Uyarı sesi</label>
              <input  type="file" name="teklif_uyari_sesi" value="<?= $hepsini_oku['teklif_uyari_sesi'] ?>" class="span12">
          </div>
          <div class="span4">
              <label for="SigortaBitisSaati">Sigorta Bitiş Saati</label>
              <input type="text" name="sigorta_dakika" value="<?= $hepsini_oku['sigorta_bitis_saati'] ?>" class="span12">
          </div>
      </div>
      <h4>Üye İhale Teklif Ayarları</h4>
      <div class="row-fluid">
          <label for="SureAltindaTeklif">Bu Süre Altında Teklif Verilirse</label>
          <input type="text" name="sure_altinda_teklif_verilirse" value="<?= $hepsini_oku['bu_sure_altinda_teklif'] ?>" class="span12">
      </div>
      <div class="row-fluid">
          <label for="BuMesajiAlsin">Bu Mesajı Alsın</label>
          <input type="text" name="bu_mesaji_alsin" value="<?= $hepsini_oku['alacagi_mesaj'] ?>" class="span12">
      </div>
      <div class="row-fluid">
          <label for="VipUyeAracListeleme">Vip Üye Araç Listeleme</label>
          <select name="vip_uye_arac" id="vip_uye_arac" value="<?= $hepsini_oku['vip_arac_listeleme'] ?>" class="span12">
              <option value="0">Araçları Göremez</option>
              <option value="1">Sadece Listede Görür</option>
              <option value="2">Tamamen Görür</option>
          </select>
          <input type="checkbox" <?php if ( $hepsini_oku['vip_detay_gorme'] == 1) echo "checked='checked'"; ?> name="vip_detay_gorebilir" value="1"> Vip Detay Görebilir<br>
      </div>
      <div class="row-fluid">
          <label for="GoldUyeAracListeleme">Gold Üye Araç Listeleme</label>
          <select name="gold_uye_arac" id="gold_uye_arac" value="<?= $hepsini_oku['gold_arac_listeleme'] ?>" class="span12">
              <option value="0">Araçları Göremez</option>
              <option value="1">Sadece Listede Görür</option>
              <option value="2">Tamamen Görür</option>
          </select>
          <input type="checkbox" <?php if ( $hepsini_oku['gold_detay_gorme'] == 1) echo "checked='checked'"; ?> name="gold_detay_gorebilir" value="1"> Gold Detay Görebilir<br>
          <input type="checkbox"  <?php if ( $hepsini_oku['teklif_onay_mekanizmasi'] == 1) echo "checked='checked'"; ?> name="teklif_onay" value="1"> Teklif Onay Mekanizması<br>
      </div>
      <div class="row-fluid">
          <label for="OnayladiktanSonra">Araca teklif verdiğinde bu mesajı onayladıktan sonra teklif iletilsin</label>
          <textarea name="onaylama_mesaji" id="onaylama_mesaji" class="span12" rows="3"><?= $hepsini_oku['teklif_iletme_mesaji'] ?></textarea>
      </div>
      <h4>Gold İhale Teklif Ayarları</h4>
      <div class="row-fluid">
          <label for="TeklifAyniIseSure">Gold üyenin teklifi ile son teklif kısmı aynı rakam ise süre</label>
          <input type="text" name="teklif_ayni_ise_sure" value="<?= $hepsini_oku['gold_teklif_son_teklif_ayni_ise'] ?>" class="span12">
          <label for="AltindaSureEklensin">Altına indiğinde süreye dakika eklensin</label>
          <input type="text" name="sure_eklensin" value="<?= $hepsini_oku['altina_inince_dakika_eklensin'] ?>" class="span12">
          <label for="IhaleTipi">İhale Tipi</label>
          <select name="ihale_tipi" class="span12" value="<?= $hepsini_oku['ihale_tipi'] ?>">
              <option value="Açık Artırma">Açık Artırma</option>
              <option value="Kapalı İhale">Kapalı İhale</option>
          </select>
          <input type="checkbox" name="vitrin" value="on" <?php if ( $hepsini_oku['vitrin'] == 1) echo "checked='checked'"; ?>> Vitrin          
      </div>
      <div class="row-fluid" style="margin-top: 3%;">
        <input type="submit" class="btn" name="guncellenen_sigorta_sirketini" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
      </div>
      <?php } ?>
  </div>
</div>
</form>
<?php } else{ ?>

    <br>
<form method="POST" enctype="multipart/form-data" id="form" action="#" name="form" >
<?php include('islemler/ayarlar/sigorta_sirketi_ekle.php'); ?>
<div class="row-fluid" style="color: rgb(120,127,167);">
  <div class="span6">
      <label for="SirketAdi">Şirket Adı</label>
      <input type="text" name="sirket_adi" class="span12">
      <div class="row-fluid">
          <div class="span8">
              <label for="File">Altın üye teklif zil sesi</label>
              <input  type="file" name="zil_sesi" class="span12">
          </div>
          <div class="span4">
              <label for="dakika">Dakikası</label>
              <input type="text" name="dakika" class="span12">
          </div>
      </div>
      <h4>Teklif Ayarları</h4>
      <div class="row-fluid">          
          <div class="span6">
              <label for="HizliTeklif">Hızlı Teklif Gönder 1</label>
              <input type="text" name="hizli_teklif1" class="span12">
              <label for="HizliTeklif">Hızlı Teklif Gönder 2</label>
              <input type="text" name="hizli_teklif2" class="span12">
          </div>
          <div class="span6">
              <label for="HizliTeklif">Hızlı Teklif Gönder 3</label>
              <input type="text" name="hizli_teklif3" class="span12">
              <label for="HizliTeklif">Hızlı Teklif Gönder 4</label>
              <input type="text" name="hizli_teklif4" class="span12">
          </div>
      </div>
      <div class="row-fluid">
          <label for="MisafirUyeAracListeleme">Misafir Üye Araç Listeleme</label>
          <select name="misafir_uye_arac" id="misafir_uye_arac" class="span12">
              <option value="0">Araçları Göremez</option>
              <option value="1">Sadece Listede Görür</option>
              <option value="2">Tamamen Görür</option>
          </select>
          <input type="checkbox" name="misafir_detay_gorebilir"> Misafir Detay Görebilir<br>
      </div>
      <div class="row-fluid">
          <label for="DemoUyeAracListeleme">Demo Üye Araç Listeleme</label>
          <select name="demo_uye_arac" id="demo_uye_arac" class="span12">
              <option value="0">Araçları Göremez</option>
              <option value="1">Sadece Listede Görür</option>
              <option value="2">Tamamen Görür</option>
          </select>
          <input type="checkbox" name="demo_detay_gorebilir"> Demo Detay Görebilir<br>
          <input type="checkbox" onclick="acKapa()" name="sure_uzatma"> Süre Uzatma<br>
      </div>
      <div class="row-fluid" id="kapatAc" style="display: none;">
          <div class="span6">
              <label for="DakikaninAltinda">Dakikanın Altında</label>
              <input type="text" class="span12" name="dakikanin_altinda">
          </div>
          <div class="span6">
              <label for="DakikaUzar">Dakika Uzar</label>    
              <input type="text" class="span12" name="dakika_uzar">
          </div>
      </div>
      <script>
    function acKapa() {
        var x = document.getElementById("kapatAc");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
        }
    </script>
      <div class="row-fluid">
          <label for="UyariNotu">Uyarı Notu</label>
          <textarea name="uyari_notu" id="uyari_notu" class="span12" rows="3"></textarea>
      </div>
      <div class="row-fluid">
          <label for="SigortaAciklamasi">Sigorta Açıklaması</label>
          <textarea name="sigorta_aciklamasi" id="sigorta_aciklamasi" class="span12"></textarea>
      </div>
  </div>
  <!-- Sol taraf bitiş -->
  <div class="span6">
      <div class="row-fluid">
          <div class="span4">
              <label for="ParkUcreti" >Park Ücreti</label>
              <input type="text" name="park_ucreti" class="span12">
          </div>
          <div class="span4">
              <label for="SigortaDosyaMasrafi" style="font-size: smaller;">Sigorta Dosya Masrafı</label>
              <input type="text" name="sigorta_dosya_masrafi" class="span12">
          </div>
          <div class="span4">
              <label for="MinumumArtis">Minumum Artış</label>
              <input type="text" name="minumum_artis" class="span12">
          </div>
      </div>
      <div class="row-fluid">
          <div class="span8">
              <label for="File"> Teklif Uyarı sesi</label>
              <input  type="file" name="teklif_uyari_sesi" class="span12">
          </div>
          <div class="span4">
              <label for="SigortaBitisSaati">Sigorta Bitiş Saati</label>
              <input type="text" name="sigorta_dakika" class="span12">
          </div>
      </div>
      <h4>Üye İhale Teklif Ayarları</h4>
      <div class="row-fluid">
          <label for="SureAltindaTeklif">Bu Süre Altında Teklif Verilirse</label>
          <input type="text" name="sure_altinda_teklif_verilirse" class="span12">
      </div>
      <div class="row-fluid">
          <label for="BuMesajiAlsin">Bu Mesajı Alsın</label>
          <input type="text" name="bu_mesaji_alsin" class="span12">
      </div>
      <div class="row-fluid">
          <label for="VipUyeAracListeleme">Vip Üye Araç Listeleme</label>
          <select name="vip_uye_arac" id="vip_uye_arac" class="span12">
              <option value="0">Araçları Göremez</option>
              <option value="1">Sadece Listede Görür</option>
              <option value="2">Tamamen Görür</option>
          </select>
          <input type="checkbox" name="vip_detay_gorebilir"> Vip Detay Görebilir<br>
      </div>
      <div class="row-fluid">
          <label for="GoldUyeAracListeleme">Gold Üye Araç Listeleme</label>
          <select name="gold_uye_arac" id="gold_uye_arac" class="span12">
              <option value="0">Araçları Göremez</option>
              <option value="1">Sadece Listede Görür</option>
              <option value="2">Tamamen Görür</option>
          </select>
          <input type="checkbox" name="gold_detay_gorebilir"> Gold Detay Görebilir<br>
          <input type="checkbox" name="teklif_onay"> Teklif Onay Mekanizması<br>
      </div>
      <div class="row-fluid">
          <label for="OnayladiktanSonra">Araca teklif verdiğinde bu mesajı onayladıktan sonra teklif iletilsin</label>
          <textarea name="onaylama_mesaji" id="onaylama_mesaji" class="span12" rows="3"></textarea>
      </div>
      <h4>Gold İhale Teklif Ayarları</h4>
      <div class="row-fluid">
          <label for="TeklifAyniIseSure">Gold üyenin teklifi ile son teklif kısmı aynı rakam ise süre</label>
          <input type="text" name="teklif_ayni_ise_sure" class="span12">
          <label for="AltindaSureEklensin">Altına indiğinde süreye dakika eklensin</label>
          <input type="text" name="sure_eklensin" class="span12">
          <label for="IhaleTipi">İhale Tipi</label>
          <select name="ihale_tipi" class="span12">
              <option value="Açık Artırma">Açık Artırma</option>
              <option value="Kapalı İhale">Kapalı İhale</option>
          </select>
          <input type="checkbox" name="vitrin"> Vitrin          
      </div>
      <div class="row-fluid" style="margin-top: 3%;">
        <input type="submit" class="btn" name="sigorta_sirketini" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
      </div>
  </div>
</div>
</form><?php } ?>


<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>
<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    ClassicEditor
        .create( document.querySelector( '#sigorta_aciklamasi' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
        
</script>
