<?php session_start(); 
  $sehir_cek = mysql_query("SELECT * FROM sehir ORDER BY plaka ASC"); 
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/il_ilce.js?v=15"></script>
<style>
   .files input {
   outline: 2px dashed red;
   outline-offset: -10px;
   -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
   transition: outline-offset .15s ease-in-out, background-color .15s linear;
   padding: 120px 0px 85px 35%;
   text-align: center !important;
   margin: 0;
   width: 100% !important;
   }
   .files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
   -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
   transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
   }
   .files{ position:relative}
   .files:after {  pointer-events: none;
   position: absolute;
   top: 60px;
   left: 0;
   width: 50px;
   right: 0;
   height: 56px;
   content: "";
   background-image: url(images/dosya_yukleme.png);
   display: block;
   margin: 0 auto;
   background-size: 100%;
   background-repeat: no-repeat;
   }
   .color input{ background-color:#f1f1f1;}
   .files:before {
   position: absolute;
   bottom: 10px;
   left: 0;  pointer-events: none;
   width: 100%;
   right: 0;
   height: 57px;
   content: "veya Dosyaları buraya sürükle bırak yapabilirsiniz ";
   display: block;
   margin: 0 auto;
   color: red;
   font-weight: 600;
   text-align: center;
   }
</style>
<style>
   table {
   border-collapse: collapse;
   border-spacing: 0;
   width: 100%;
   border: 1px solid #ddd;
   }
   th, td {
   text-align: left;
   padding: 8px;
   }
   i{
   color:black;
   padding: 8px;
   }
</style>

<?php 
$gelen_id=re("id");
$ilani_cek = mysql_query("SELECT * FROM ilanlar WHERE id = $gelen_id");
?>


<div class="tabbable">
   <!-- Only required for left/right tabs -->
   <ul class="nav nav-tabs">
      <li class="active"><a href="#arac_bilgileri" data-toggle="tab">Araç Bilgileri</a></li>
      <li><a href="#arac_fotograflari" data-toggle="tab">Araç Fotoğrafları</a></li>
      <li><a href="#statu_bilgileri" data-toggle="tab">Statü Bilgileri</a></li>
      <li><a href="#yuklenen_dosyalar" data-toggle="tab">Yüklenen Dosyalar</a></li>
   </ul>
   <!-- Tab İçerikleri Başlangıç -->
   <div class="tab-content">
      <!-- Araç Bilgileri< Başlangıç -->
      <div class="tab-pane active" id="arac_bilgileri">
         <form method="POST" id="form" name="form" enctype="multipart/form-data">
         <?php include('islemler/ilanlar/ilan_ekle.php'); ?>
         <?php while($ilani_oku = mysql_fetch_array($ilani_cek)){ ?>
            <div class="row-fluid">
               <div class="span6">
                  <div class="row-fluid">
                     <div class="span4">
                        <label for="IDofInput">Plaka</label>
                        <input type="text" value="<?=$ilani_oku['plaka'] ?>" name="plaka" class="span12">
                     </div>
                     <div class="span4">
                        <label for="IDofInput">Araç Kodu*</label>
                        <input type="text" value="<?=$ilani_oku['arac_kodu'] ?>" name="arac_kodu" class="span12">
                     </div>
                     <div class="span4">
                        <label for="IDofInput">Hesaplama</label>
                        <select name="hesaplama" value="<?=$ilani_oku['hesaplama'] ?>" id="" class="span12">
                           <option value="<?=$ilani_oku['hesaplama'] ?>"><?=$ilani_oku['hesaplama'] ?></option>
                           <option value="Standart">Standart</option>
                           <option value="Lüks">Lüks</option>
                        </select>
                     </div>
                  </div>
                  <?php 
                     $sigorta_cek = mysql_query("SELECT DISTINCT sigorta FROM ilanlar"); 
                  ?>
                  <label for="IDofInput">Sigorta Şirketi*</label>
                  <select name="sigorta"  value="<?=$ilani_oku['sigorta'] ?>" id="sigorta" class="span12">
                     <option value="<?=$ilani_oku['sigorta'] ?>"><?=$ilani_oku['sigorta'] ?></option>
                     <?php
                     while($sigorta_oku = mysql_fetch_array($sigorta_cek)){                   
                     ?>                        
                     <option ><?=$sigorta_oku["sigorta"];?></option>  
                     <?php } ?>     
                  </select>
                  <div class="row-fluid">
                     <div class="span6">
                        <label for="IDofInput">Marka*</label>
                        <select name="marka" id="" class="span12">
                        <option value="<?= $ilani_oku['marka'] ?>"><?= $ilani_oku['marka'] ?></option>
                        <option value="Marka 1">Marka 1</option>
                        <option value="Marka 2">Marka 2</option>
                        <option value="Marka 3">Marka 3</option>
                        <option value="Marka 4">Marka 4</option>
                        </select>
                     </div>
                     <div class="span6">
                        <label for="IDofInput">Model*</label>
                        <select name="model" id="" class="span12">
                           <option value="<?= $ilani_oku['model'] ?>"><?= $ilani_oku['model'] ?></option>
                           <option value="Model 1" >Model 1</option>
                           <option value="Model 2" >Model 2</option>
                        </select>
                     </div>
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <label for="IDofInput">Tip*</label>
                        <input type="text" name="tip" value="<?=$ilani_oku['tip'] ?>" class="span12">
                     </div>
                     <div class="span6">
                        <label for="IDofInput">Model Yılı*</label>
                        <input type="text"  value="<?=$ilani_oku['model_yili'] ?>" name="model_yili" class="span12">
                     </div>
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <label for="IDofInput">Piyasa Değeri*</label>
                        <input type="text" name="piyasa_degeri"  value="<?=$ilani_oku['piyasa_degeri'] ?>" class="span12">
                     </div>
                     <div class="span6">
                        <label for="IDofInput">Son Teklif*</label>
                        <input type="text" name="son_teklif" value="<?=$ilani_oku['son_teklif'] ?>" class="span12">
                     </div>
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <label for="IDofInput">Ruhsat Durumu*</label>
                        <select name="profil" class="span12">
                           <option value="<?=$ilani_oku['profil'] ?>"><?=$ilani_oku['profil'] ?></option>
                           <option value="Çekme Belgeli/Pert Kayıtlı">Çekme Belgeli/Pert Kayıtlı</option>
                           <option value="Çekme Belgeli">Çekme Belgeli</option>
                           <option value="Hurda Belgeli">Hurda Belgeli</option>
                           <option value="Plakalı">Plakalı</option>
                           <option value="Diğer">Diğer</option>
                        </select>
                     </div>
                     <div class="span6">
                     <?php $sehir_cek = mysql_query("SELECT * FROM sehir"); ?>
                        <?php $dizi = explode ("/",$ilani_oku['sehir']) ?>
                        <label for="IDofInput">Şehir*</label>
                        <select name="sehir" class="span12" id="sehir">
                        <option value="<?= $ilani_oku['sehir'] ?>"><?= $ilani_oku['sehir'] ?></option>
                        <?php
                        while($sehir_oku = mysql_fetch_array($sehir_cek)){                   
                        ?>                        
                        <option value="<?=$sehir_oku["sehiradi"]?>"><?=$sehir_oku["sehiradi"];?></option>  
                        <?php } ?>                     
                        </select>
                     </div>
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <label for="IDofInput">İhale Tarihi</label>
                        <input type="date" name="ihale_tarihi" value="<?=$ilani_oku['ihale_tarihi'] ?>" class="span12">
                     </div>
                     <div class="span6">
                        <label for="IDofInput">İhale Saati</label>
                        <input type="time" name="ihale_saati" value="<?=$ilani_oku['ihale_saati'] ?>" class="span12">
                     </div>
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <label for="IDofInput">PD Hizmet Bedeli</label>
                        <input type="text" name="pd_hizmet" value="<?=$ilani_oku['pd_hizmet'] ?>" class="span12">
                     </div>
                     <div class="span6">
                        <label for="IDofInput">Otopark Giriş Tarihi</label>
                        <input type="date" name="otopark_giris" value="<?=$ilani_oku['otopark_giris'] ?>" class="span12">
                     </div>
                  </div>
                  <div class="row-fluid">
                     <div class="span6">
                        <label for="IDofInput">Otopark Ücreti</label>
                        <input type="text" name="otopark_ucreti" value="<?=$ilani_oku['otopark_ucreti'] ?>" class="span12">
                     </div>
                     <div class="span6">
                        <label for="IDofInput">Çekici Ücreti</label>
                        <input type="text" name="cekici_ucreti" value="<?=$ilani_oku['cekici_ucreti'] ?>" class="span12">
                     </div>
                  </div>
                  <label for="IDofInput">Dosya Masrafı</label>
                  <input type="text" name="dosya_masrafi" value="<?=$ilani_oku['dosya_masrafi'] ?>" class="span12">
                  <div class="row-fluid">
                     <div class="span6">
                        <label for="IDofInput">Link</label>
                        <input type="text" name="link" value="<?=$ilani_oku['link'] ?>" class="span12">
                     </div>
                     <div class="span6">
                        <label for="IDofInput">Kilometre</label>
                        <input type="text" name="kilometre" value="<?=$ilani_oku['kilometre'] ?>" class="span12">
                     </div>
                  </div>
                  <label for="IDofInput">Uyarı Notu</label>
                  <textarea class="span12" name="uyari_notu" rows="3"><?=$ilani_oku['uyari_notu'] ?></textarea>
                  <label for="IDofInput">Adres</label>
                  <textarea class="span12" name="adres" rows="3"><?=$ilani_oku['adres'] ?></textarea>
               </div>
               <div class="span6">
                  <label for="IDofInput">Notlar</label>
                  <textarea name="notlar" id="notlar" class="span12"><?=$ilani_oku['notlar'] ?></textarea>
                  <label for="IDofInput">Donanımlar</label>
                  <textarea name="donanimlar" id="donanimlar" class="span12"><?=$ilani_oku['donanimlar'] ?></textarea>
                  <div class="form-actions">
                     <input type="submit" name="ilani" class="btn blue" value="Kaydet" />
                  </div>
               </div>
            </div>
         <?php } ?>
         </form>
      </div>
      <!-- Araç Bilgileri Bitiş -->
      <!-- Araç Fotoğrafları Başlangıç -->
      <div class="tab-pane" id="arac_fotograflari">
         <div class="row" style="margin-right: 2% !important; margin-left: 2% !important; width:96% !important;">
            <input type="submit" class="btn" value="Bütün Resimleri Sil" style="background-color: rgb(251,57,122); color:white;">
            <form method="post" action="#" id="#" style="margin-top:20px;">
               <div class="form-group files color">
                  <input type="file" class="form-control" multiple="">
               </div>
            </form>
            <div class="row" style="margin-left:1px;">
               <ul class="thumbnails">
                  <li class="span4">
                     <a href="#" class="thumbnail">
                     <img src="https://cdn.ototeknikveri.com/Files/News/Big/345opel-astra-da-2014-yenilikleri-16-dizel-cdti-ve-intellilink.jpg"alt="">
                     </a>
                  </li>
               </ul>
            </div>
            <div class="row" style="margin-left:1px;">
               <div class="span3"><input type="submit" value="Ana Resim Yap" class="btn blue"></div>
               <div class="span1"><input type="submit" value="Sil" class="btn" style="background-color: rgb(251,57,122); color:white;"></div>
            </div>
         </div>
      </div>
      <!-- Araç Fotoğrafları Bitiş -->
      <!-- Statü Bilgileri Başlangıç -->
      <div class="tab-pane" id="statu_bilgileri">
         <div class="row-fluid">
            <div class="span6">
               <label for="IDofInput">Teklifler</label>       
               <select name="" id="" class="span6">
                  <option value="1">Teklfi1</option>
                  <option value="2">Teklfi2</option>
               </select>
               <div class="row-fluid">
                  <div class="span6">
                     <label for="IDofInput">Serbest Seçim</label>
                     <select name="" id="" class="span12">
                        <option value="1">Seçim1</option>
                        <option value="2">Seçim2</option>
                     </select>
                  </div>
                  <div class="span6">
                     <label for="">&nbsp;</label>
                     <input type="text" class="span12" placeholder="Kazandığı Fiyat">
                  </div>
               </div>
               <div class="row-fluid">
                  <div class="span6">
                     <label for="IDofInput">Statü Bilgileri</label>
                     <select name="" id="" class="span12">
                        <option value="1">Statü1</option>
                        <option value="2">Statü2</option>
                     </select>
                  </div>
                  <div class="span6">
                     <label for="">&nbsp;</label>
                     <input type="text" class="span12" placeholder="Açıklama yaz">
                  </div>
               </div>
               <label for="IDofInput">Son Ödeme Tarihi</label>        
               <input type="date" name="" id="" class="span6">
            </div>
            <div class="span6">
               <h6 class="span12">RİSK BİLGİLERİ</h6>
               <div class="row-fluid">
                  <div class="span4">
                     Ödeme Bekleyenler <br>
                     Onay Bekleyenler <br>
                     Satıldı<br>
                  </div>
                  <div class="span4">
                     0<br>
                     0<br>
                     0
                  </div>
               </div>
               <input type="checkbox">Risk ölçümüne göre teklfi verme yetkisi
               <label for="">&nbsp;</label>
               <input type="text" class="span12" value="Otomatik Mesaj">
               <input type="submit" name="arac_bilgilerini" class="btn blue" value="Kaydet" />
               <div class="row-fluid">
                  <div class="span3">Mesaja Mtv İlave Et</div>
                  <div class="span6">
                     <input type="text" class="span12">
                  </div>
                  <div class="span3">
                     <button class="btn blue" type="button">Tekrar Sms İlet</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="row-fluid" style="margin-top:2%;">
            <div class="span4">Toplam Ödenmesi Gereken Rakam :</div>
            <div class="span8"><input type="text" class="span12"></div>
         </div>
         <div class="row-fluid">
            <div class="span4">PD Hizmet Bedeli Faturası :</div>
            <div class="span8"><input type="text" class="span12"></div>
         </div>
         <div class="row-fluid">
            <div class="span4">Kesilecek Araç Bedeli Faturası :</div>
            <div class="span8"><input type="text" class="span12"></div>
         </div>
         <div class="row-fluid">
            <div class="span4">Toplam Ödenmesi Gereken Rakam :</div>
            <div class="span8"></div>
         </div>
         <div class="row-fluid">
            <div class="span4">Toplam Ödenmesi Gereken Rakam :</div>
            <div class="span8"></div>
         </div>
      </div>
      <!-- Statü Bilgileri Bitiş -->
      <!-- Yüklenen Dosyalar Başlangıç -->
      <div class="tab-pane" id="yuklenen_dosyalar">
         <p>Yüklenen Dosyalar</p>
      </div>
      <!-- Yüklenen Dosyalar Bitiş -->
   </div>
   <!-- Tab İçerikleri Bitiş -->
</div>
<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    ClassicEditor
        .create( document.querySelector( '#notlar' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
        
</script>
<script>
    ClassicEditor
        .create( document.querySelector( '#donanimlar' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
        
</script>

