<?php 
session_start();
$gelen_id=re("id");
?>
<script src="assets/ckeditor4/ckeditor.js"></script>
<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<?php if(!empty($gelen_id)){ 
    $sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$gelen_id."'");
    while($sigorta_oku = mysql_fetch_array($sigorta_cek)){
?>
<form method="POST" style="margin-top: 3%;" enctype="multipart/form-data">
<?php include('islemler/ayarlar/sigorta_sirketi_guncelle.php'); ?>
    <div class="row-fluid">
        <div class="span6">
            <label for="SirketAdi">Şirket Adı</label>
            <input type="text" name="sirket_adi" value="<?= $sigorta_oku['sigorta_adi'] ?>" class="span12">
            <div class="row-fluid">
                <div class="span8">
                    <label for="File">Gold üye teklif zil sesi</label>
                    <input  type="file" name="file"  class="span12">
                </div>
                <div class="span4">
                    <label for="dakika">Dakikası</label>
                    <input type="text" required name="altin_dakika" value="<?= $sigorta_oku['gold_uyari_dakika'] ?>" class="span12">
                </div>
            </div>
            <h4>Teklif Ayarları</h4>
            <div class="row-fluid">          
                <div class="span6">
                    <label for="HizliTeklif">Hızlı Teklif Gönder 1</label>
                    <input type="text" name="hizli_teklif1" value="<?= $sigorta_oku['hizli_teklif_1'] ?>" class="span12">
                    <label for="HizliTeklif">Hızlı Teklif Gönder 2</label>
                    <input type="text" name="hizli_teklif2" value="<?= $sigorta_oku['hizli_teklif_2'] ?>" class="span12">
                </div>
                <div class="span6">
                    <label for="HizliTeklif">Hızlı Teklif Gönder 3</label>
                    <input type="text" name="hizli_teklif3" value="<?= $sigorta_oku['hizli_teklif_3'] ?>" class="span12">
                    <label for="HizliTeklif">Hızlı Teklif Gönder 4</label>
                    <input type="text" name="hizli_teklif4" value="<?= $sigorta_oku['hizli_teklif_4'] ?>" class="span12">
                </div>
            </div>
            <div class="row-fluid">
                <input type="checkbox" onclick="acKapa()" id="sure_uzatma" name="sure_uzatma" value="1" <?php if($sigorta_oku['sure_uzatma']==1){ echo "checked"; } ?>> Süre Uzatma<br>
            </div>
            <div class="row-fluid" id="kapatAc" >
                <div class="span6">
                    <label for="DakikaninAltinda">Dakikanın Altında</label>
                    <input type="number" required class="span12" name="dakikanin_altinda" value="<?= $sigorta_oku['dakikanin_altinda'] ?>">
                </div>
                <div class="span6">
                    <label for="DakikaUzar">Dakika Uzar</label>    
                    <input type="number" required class="span12" name="dakika_uzar" value="<?= $sigorta_oku['dakika_uzar'] ?>">
                </div>
            </div>
			<div class="row-fluid">
               <text>En yüksek teklif bizdeyse belirlenen saniye altında belirlenen saniye eklensin <br/>
            </div>
			<div class="row-fluid">
                <div class="span6">
                    <label for="DakikaninAltinda">Saniyenin Altında</label>
                    <input type="number" required class="span12" name="saniyenin_altinda" value="<?= $sigorta_oku['saniyenin_altinda'] ?>">
                </div>
                <div class="span6">
                    <label for="DakikaUzar">Saniye Uzar</label>    
                    <input type="number" required class="span12" name="saniye_uzar" value="<?= $sigorta_oku['saniye_uzar'] ?>">
                </div>
            </div>
            <div class="row-fluid">
                <label for="UyariNotu">Uyarı Notu</label>
                <textarea name="uyari_notu" id="uyari_notu" class="span12" rows="3"><?= $sigorta_oku['uyari_notu'] ?></textarea>
            </div>
            <div class="row-fluid">
                <label for="SigortaAciklamasi">Sigorta Açıklaması</label>
                <textarea name="sigorta_aciklamasi" id="sigorta_aciklamasi" rows="4" class="span12"><?= $sigorta_oku['sigorta_aciklamasi'] ?></textarea>
            </div>
            <div class="row-fluid">
				 <div class="span3">
                    <label for="ParkUcreti" >Çekici Ücreti</label>
                    <input type="text" name="cekici_ucreti" value="<?= $sigorta_oku['sigorta_cekici_ucreti'] ?>" class="span12">
                </div>
                <div class="span3">
                    <label for="ParkUcreti" >Park Ücreti</label>
                    <input type="text" name="park_ucreti" value="<?= $sigorta_oku['park_ucreti'] ?>" class="span12">
                </div>
                <div class="span3">
                    <label for="SigortaDosyaMasrafi" style="font-size: smaller;">Sigorta Dosya Masrafı</label>
                    <input type="text" name="sigorta_dosya_masrafi" value="<?= $sigorta_oku['sigorta_dosya_masrafi'] ?>" class="span12">
                </div>
                <div class="span3">
                    <label for="MinumumArtis">Minumum Artış</label>
                    <input type="text" required name="minumum_artis" value="<?= $sigorta_oku['minumum_artis'] ?>" class="span12">
                </div>
            </div>
            <div class="row-fluid">
                <input type="checkbox" name="teklif_onay" value="1" <?php if($sigorta_oku['teklif_onay_mekanizmasi']==1){ echo "checked"; } ?> > Teklif Onay Mekanizması<br>
                <label for="OnayladiktanSonra">Araca teklif verdiğinde bu mesajı onayladıktan sonra teklif iletilsin</label>
                <textarea name="onaylama_mesaji" id="onaylama_mesaji" class="span12" rows="3"><?= $sigorta_oku['teklif_iletme_mesaji'] ?></textarea>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <label for="File"> Teklif Uyarı sesi</label>
                    <input  type="file" name="teklif_uyari_sesi" value="<?= $sigorta_oku['teklif_uyari_sesi'] ?>" class="span12">
                </div>
                <div class="span6">
                    <label for="SigortaBitisSaati">Sigorta Bitiş Saati</label>
                    <input type="time" required name="sigorta_dakika" value="<?= $sigorta_oku['sigorta_bitis_saati'] ?>" class="span12">
                </div>
            </div>
            <h4>Üye İhale Teklif Ayarları</h4>
            <div class="row-fluid">
                <label for="SureAltindaTeklif">Bu Süre Altında Teklif Verilirse</label>
                <input type="number" name="sure_altinda_teklif_verilirse" value="<?= $sigorta_oku['bu_sure_altinda_teklif'] ?>" required class="span12">
            </div>
            <div class="row-fluid">
                <label for="BuMesajiAlsin">Bu Mesajı Alsın</label>
                <input type="text" name="bu_mesaji_alsin" value="<?= $sigorta_oku['alacagi_mesaj'] ?>" required class="span12">
            </div>
            <div class="row-fluid">
              <!--  <label for="IDofIpnut"> PD Hizmet Bedeli</label>
                <input type="number" class="span12" name="pd_hizmeti" value="<?= $sigorta_oku['pd_hizmeti'] ?>">-->
                <label for="IhaleTipi">İhale Tipi</label>
                <select name="ihale_tipi" class="span12">
					<option value="1" <?php if($sigorta_oku['ihale_tipi']==1){ echo "selected"; } ?>>Açık Artırma</option>
					<option value="2" <?php if($sigorta_oku['ihale_tipi']==2){ echo "selected"; } ?>>Kapalı İhale</option>
                </select>
               <!-- <input type="checkbox" onclick="vitrin_kontrol()" name="vitrin" id="vitrin" value="on"> Vitrin   <br/>        -->
               <input type="checkbox" onclick="vitrin_kontrol()" <?php if($sigorta_oku["vitrin"] == "on"){ echo "checked"; } ?> name="vitrin" id="vitrin" value="on"> Vitrin   <br/>       
                <input type="number" style="display: <?php if($sigorta_oku["vitrin"] == "on"){ echo "block"; }else{echo "none";} ?>;" 
                placeholder="Adet giriniz" name="vitrin_sayi" id="vitrin_sayi" value="<?= $sigorta_oku["vitrin_adet"] ?>">        
            </div>
      </div>
      <?php 
      $grup_cek = mysql_query("SELECT * FROM uye_grubu");
      ?>
      <div class="span6">
      <h3 style="text-align: center; color:red;">Üye Grubu Yetkileri</h3>
         <?php 
         $sayi = 0;
         $sayi2 = 1;
         while($grup_oku = mysql_fetch_array($grup_cek)){ 
            $sigorta_yetki_cek = mysql_query("SELECT * FROM sigortalar WHERE sigorta_id = '".$sigorta_oku['id']."' AND paket_id = '".$grup_oku['id']."'");
            $sigorta_yetki_oku = mysql_fetch_assoc($sigorta_yetki_cek);
                $grup_yetki_cek = mysql_query("SELECT * FROM uye_grubu_yetkiler WHERE id = '".$sigorta_yetki_oku['secilen_yetki_id']."'");
                $grup_yetki_oku = mysql_fetch_assoc($grup_yetki_cek);
        ?>
         <label for="IDofInput"><h4><?= $grup_oku['grup_adi'] ?></h4></label>
         <label class="radio">
            <input type="radio" value="1" <?php if("1"==$grup_yetki_oku['id']){ echo "checked"; } ?> name="yetki_durum<?=$sayi?>">
            Araçları Göremez
        </label><br>
         <label class="radio">
            <input type="radio" value="2" <?php if("2"==$grup_yetki_oku['id']){ echo "checked"; } ?> name="yetki_durum<?=$sayi ?>">
            Sadece Listede Görür
        </label><br>
         <label class="radio">
            <input type="radio" value="3" <?php if("3"==$grup_yetki_oku['id']){ echo "checked"; } ?> name="yetki_durum<?=$sayi ?>">
            Tamamen Görür
        </label><br>
        <label class="checkbox inline">
        <input type="checkbox"  value="1" name="detay_<?=$sayi ?>" <?php if($sigorta_yetki_oku['detay_gorur']==1){ echo "checked"; } ?> > Detay Görebilir
        </label>
        <?php $sayi++; } ?>
      </div>
    </div>    
    <div class="row-fluid" style="margin-top: 3%;">
        <input type="submit" class="btn blue" name="sigorta_guncellemeyi" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
    </div>
</form>
<?php } }else{ ?>
<form method="POST" style="margin-top: 3%;" id="sigorta_ekle_form" enctype="multipart/form-data">
<?php include('islemler/ayarlar/sigorta_sirketi_ekle_yeni.php'); ?>
<input type="hidden" name="sigorta_sirketini" value="Kaydet">
    <div class="row-fluid">
        <div class="span6">
            <label for="SirketAdi">Şirket Adı</label>
            <input type="text" name="sirket_adi" class="span12">
            <div class="row-fluid">
                <div class="span8">
                    <label for="File">Gold üye teklif zil sesi</label>
                    <input  type="file" name="file"  class="span12">
                </div>
                <div class="span4">
                    <label for="dakika">Dakikası</label>
                    <input type="text"  required name="altin_dakika" class="span12">
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
                <input type="checkbox" onclick="acKapa()" id="sure_uzatma" name="sure_uzatma" value="1"> Süre Uzatma<br>
            </div>
            <div class="row-fluid" id="kapatAc" >
                <div class="span6">
                    <label for="DakikaninAltinda">Dakikanın Altında</label>
                    <input type="number" required class="span12" name="dakikanin_altinda">
                </div>
                <div class="span6">
                    <label for="DakikaUzar">Dakika Uzar</label>    
                    <input type="number" required class="span12" name="dakika_uzar">
                </div>
            </div>
			<div class="row-fluid">
               <text>En yüksek teklif bizdeyse belirlenen saniye altında belirlenen saniye eklensin <br/>
            </div>
			<div class="row-fluid">
                <div class="span6">
                    <label for="DakikaninAltinda">Saniyenin Altında</label>
                    <input type="number" required class="span12" name="saniyenin_altinda" value="">
                </div>
                <div class="span6">
                    <label for="DakikaUzar">Saniye Uzar</label>    
                    <input type="number" required class="span12" name="saniye_uzar" value="">
                </div>
            </div>
            <div class="row-fluid">
                <label for="UyariNotu">Uyarı Notu</label>
                <textarea name="uyari_notu" id="uyari_notu" class="span12" rows="3"></textarea>
            </div>
            <div class="row-fluid">
                <label for="SigortaAciklamasi">Sigorta Açıklaması</label>
                <textarea name="sigorta_aciklamasi" id="sigorta_aciklamasi" rows="4" class="span12"></textarea>
            </div>
            <div class="row-fluid">
                <div class="span3">
                    <label for="ParkUcreti" >Park Ücreti</label>
                    <input type="text" name="park_ucreti" class="span12">
                </div>
				 <div class="span3">
                    <label for="ParkUcreti" >Çekici Ücreti</label>
                    <input type="text" name="cekici_ucreti" class="span12">
                </div>
                <div class="span3">
                    <label for="SigortaDosyaMasrafi" style="font-size: smaller;"> Sigorta Dosya Masrafı </label>
                    <input type="text" name="sigorta_dosya_masrafi" class="span12">
                </div>
                <div class="span3">
                    <label for="MinumumArtis">Minumum Artış</label>
                    <input type="number" name="minumum_artis" class="span12">
                </div>
            </div>
            <div class="row-fluid">
                <input type="checkbox" name="teklif_onay" value="1"> Teklif Onay Mekanizması<br>
                <label for="OnayladiktanSonra">Araca teklif verdiğinde bu mesajı onayladıktan sonra teklif iletilsin</label>
                <textarea name="onaylama_mesaji" id="onaylama_mesaji" class="span12" rows="3"></textarea>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <label for="File"> Teklif Uyarı sesi</label>
                    <input  type="file"  name="teklif_uyari_sesi" class="span12">
                </div>
                <div class="span6">
                    <label for="SigortaBitisSaati">Sigorta Bitiş Saati</label>
                    <input type="time" required name="sigorta_dakika" class="span12">
                </div>
            </div>
            <h4>Üye İhale Teklif Ayarları</h4>
            <div class="row-fluid">
                <label for="SureAltindaTeklif">Bu Süre Altında Teklif Verilirse</label>
                <input type="number" required name="sure_altinda_teklif_verilirse" class="span12">
            </div>
            <div class="row-fluid">
                <label for="BuMesajiAlsin">Bu Mesajı Alsın</label>
                <input type="text" required name="bu_mesaji_alsin" class="span12">
            </div>
            <div class="row-fluid">
            <!--<label for="IDofIpnut"> PD Hizmet Bedeli</label>
                <input type="number" class="span12" name="pd_hizmeti">-->

                <label for="IhaleTipi">İhale Tipi</label>
                <select name="ihale_tipi" class="span12">
					<option value="1">Açık Artırma</option>
					<option value="2">Kapalı İhale</option>
                </select>
                <input type="checkbox" onclick="vitrin_kontrol()" name="vitrin" id="vitrin" value="on"> Vitrin   <br/>       
                <input type="number" placeholder="Adet giriniz" name="vitrin_sayi" id="vitrin_sayi" style="display:none;" value="">        
            </div>
      </div>
      <?php 
      $grup_cek = mysql_query("SELECT * FROM uye_grubu");
      ?>
      <div class="span6">
      <h3 style="text-align: center; color:red;">Üye Grubu Yetkileri</h3>
         <?php 
         $sayi = 0;
         $sayi2 = 1;
         while($grup_oku = mysql_fetch_array($grup_cek)){ ?>
         <label for="IDofInput"><h4><?= $grup_oku['grup_adi'] ?></h4></label>
         <label class="radio">
            <input type="radio" value="1" name="yetki_durum<?=$sayi?>">
            Araçları Göremez
        </label><br>
         <label class="radio">
            <input type="radio" value="2" name="yetki_durum<?=$sayi ?>">
            Sadece Listede Görür
        </label><br>
         <label class="radio">
            <input type="radio" value="3" name="yetki_durum<?=$sayi ?>">
            Tamamen Görür
        </label><br>
        <label class="checkbox inline">
        <input type="checkbox"  value="1" name="detay_<?=$sayi ?>" > Detay Görebilir
        </label>
        <?php $sayi++; } ?>
      </div>
    </div>
    <div class="row-fluid" style="margin-top: 3%;">
        <button type="button" class="btn blue" onclick="document.getElementById('sigorta_ekle_form').submit();" style="background-color: rgb(88,103,221); color:white;">Kaydet</button>
    </div>
</form>
<?php } ?>


<script>
	function vitrin_kontrol(){
		var vit=document.getElementById("vitrin");
		if(vit.checked==true){
			$("#vitrin_sayi").css("display","block");
		}else{
			$("#vitrin_sayi").css("display","none");
		}
	}
    function acKapa() {
		if (document.getElementById("sure_uzatma").checked==true) {
			document.getElementById("kapatAc").style.display="block";
		} else {
			document.getElementById("kapatAc").style.display="none";
		}
	}
		acKapa();
    </script>

<script>
	CKEDITOR.replace( 'sigorta_aciklamasi', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
	CKEDITOR.replace( 'uyari_notu', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	} );
    /*ClassicEditor
        .create(document.querySelector('#sigorta_aciklamasi'))
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );*/
        
</script>

