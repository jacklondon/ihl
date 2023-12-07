<?php 
$gelen_id = re('id');
if(re('guncellemeyi')=="Kaydet"){ 
    $gelen_plaka        =   re('plaka');
    $plaka              =   strtoupper($gelen_plaka);
    $arac_kodu          =   re('arac_kodu');
    $hesaplama          =   re('hesaplama');
    $sigorta            =   re('sigorta');
    $marka              =   re('marka');
    $model              =   re('model'); 
    $tip                =   re('tip');
    $model_yili         =   re('model_yili');
    //$piyasa_degeri      =   re('piyasa_degeri');
    $tsrsb_degeri       =   re('tsrsb_degeri');
    $acilis_fiyati      =   re('acilis_fiyati');
    $profil             =   re('profil');
    $sehir              =   re('sehir');
    $ilce               =   re('ilce');
    $ihale_acilis       =   re('ihale_baslama');
    $ihale_tarihi       =   re('ihale_tarihi');
    $ihale_saati        =   re('ihale_saati');
    $pd_hizmet          =   re('pd_hizmet');
    $otopark_giris      =   re('otopark_giris');
    $otopark_ucreti     =   re('otopark_ucreti');
    $cekici_ucreti      =   re('cekici_ucreti');
    $dosya_masrafi      =   re('dosya_masrafi');
    $link               =   re('link');
    $kilometre          =   re('kilometre');
    $uyari_notu         =   re('uyari_notu');
    $hasar_bilgileri    =   re('hasar_bilgileri');
    $notlar             =   re('notlar');
    $adres              =   re('adres');
    $donanimlar         =   re('donanimlar');
    $vitrin             =   re('vitrin');
	$ilan_yayin         =   re('yayinda');
    //$ihale_turu         =   re('ihale_turu');
	if($pd_hizmet=="Otomatik Hesaplama"){
		$pd_hizmet="";
	}

    $bugun              =   date("Y.m.d");
	if(re('kategori_adi')=="" ){
		$uyari=" * ile belirtilen alanlar boş bırakılamaz.";
	}else{
		/*if($ilan_yayin==0)
		{
			$ilan_durum=-3;
		}
		else {
			$ilan_durum=1;
		}*/
		$ilan_durum=1;
		$sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = $sehir");
		$sehir_oku = mysql_fetch_assoc($sehir_cek);
		$son_sehir = $sehir_oku['sehiradi'];
		$sorgula=mysql_query("select * from sigorta_ozellikleri where id='".$sigorta."'");
		$sigr_cek=mysql_fetch_object($sorgula);
		$ihale_turu=$sigr_cek->ihale_tipi;  
		mysql_query("UPDATE `hizli_ekle_detay` SET 		
		`sayi` = '".re('ekle_sayi')."', 
		`plaka` = '".$plaka."', 
		`arac_kodu` = '".$arac_kodu."', 
		`hesaplama` = '".$hesaplama."', 
		`sigorta` = '".$sigorta."', 
		`marka` = '".$marka."', 
		`model` = '".$model."', 
		`tip` = '".$tip."', 
		`model_yili` = '".$model_yili."', 
		`piyasa_degeri` = '".$piyasa_degeri."', 
		`tsrsb_degeri` = '".$tsrsb_degeri."', 
		`acilis_fiyati` = '".$acilis_fiyati."', 
		`profil` = '".$profil."', 
		`sehir` = '".$son_sehir."', 
		`ilce` = '".$ilce."', 
		`ihale_acilis` = '".$ihale_acilis."', 
		`ihale_tarihi` = '".$ihale_tarihi."', 
		`ihale_saati` = '".$ihale_saati."', 
		`pd_hizmet` = '".$pd_hizmet."', 
		`otopark_giris` = '".$otopark_giris."', 
		`otopark_ucreti` = '".$otopark_ucreti."', 
		`cekici_ucreti` = '".$cekici_ucreti."', 
		`dosya_masrafi` = '".$dosya_masrafi."', 
		`link` = '".$link."', 
		`kilometre` = '".$kilometre."', 
		`uyari_notu` = '".$uyari_notu."', 
		`hasar_bilgileri` = '".$hasar_bilgileri."', 
		`notlar` = '".$notlar."', 
		`adres` = '".$adres."', 
		`donanimlar` = '".$donanimlar."', 
		`vitrin` = '".$vitrin."',    
		`ihale_turu` = '".$ihale_turu."',
		`durum` ='".$ilan_durum."'    
		WHERE kategori_id = '".$gelen_id."'");
		$updt=mysql_query("update hizli_ekle_kategori set adi='".re("kategori_adi")."' where id='".$gelen_id."'");
		echo "<script>alert('İlan Güncellendi')</script>";
		echo "<script>window.location.href = '?modul=ilanlar&sayfa=hizli_ilan_duzenle&id=$gelen_id'; </script>";
		//header("Location:?modul=ilanlar&sayfa=ilan_ekle&id=$gelen_id");
	}
}

	if(re('resimleri')=="Resim Kaydet"){     
		if ($_FILES['resim']['name'] != "")
		{       
			include ('simpleimage.php');
			$dosya_sayi = count($_FILES['resim']['name']);
			for ($i = 0;$i < $dosya_sayi;$i++)
			{
				if (!empty($_FILES['resim']['name'][$i]))
				{
					$dosya_adi = $_FILES["resim"]["name"][$i];
					$dizim = array("iz","et","se","du","yr","nk");
					$uzanti = substr($dosya_adi, -4, 4);
					$rasgele = rand(1, 1000000);
					$ad = $dizim[rand(0, 5) ] . $rasgele . ".png";
					$yeni_ad = "../images/" . $ad;
					move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);
					copy($yeni_ad, $k_ad);
					$image = new SimpleImage();
					$image->load($yeni_ad);
					$image->resizeToWidth(1000);
					$image->save($yeni_ad);
					mysql_query("INSERT INTO `hizli_ekle_resim` (`id`, `kat_id`, `resim`, `tarih`, `durum`) VALUES (NULL, '".$gelen_id."', '".$ad."', '".$date_time."', '1')");
               
				}
			}
		}
	}


   $resimleri_cek = mysql_query("select * from hizli_ekle_resim where kat_id = '".$gelen_id."'");
   $resimleri_bas = '';
   while($resimleri_oku = mysql_fetch_array($resimleri_cek)){
      $resim = "../images/".$resimleri_oku['resim']; 
      $resim_id = $resimleri_oku['id'];
      $resimleri_bas .='<li class="span2">
      <div class="thumbnail">
        <img src="'.$resim.'">
        <a href="?modul=ilanlar&sayfa=hizli_ilan_resim_sil&id='.$resim_id.'"><button type="button" class="btn red">SİL</button></a>
      </div>
    </li>';
   }

?>
<?php 
   function pre_up($str){
       $str = str_replace('i', 'İ', $str);
       $str = str_replace('ı', 'I', $str);
       return $str;
   }
   session_start();
   $admin_id=$_SESSION['kid'];
   
   $sehir_cek = mysql_query("SELECT * FROM sehir ORDER BY plaka ASC"); 
   $gelen_id = re("id");
   
   $ilani_cek = mysql_query("SELECT * FROM hizli_ekle_detay WHERE kategori_id = '".$gelen_id."'");
   $kategori_cek=mysql_query("select * from hizli_ekle_kategori where id='".$gelen_id."'");
   $kategori_oku=mysql_fetch_array($kategori_cek);
   
   $admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
   $admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
   $yetkiler=$admin_yetki_oku["yetki"];
   $yetki_parcala=explode("|",$yetkiler);
   
   if (!in_array(1, $yetki_parcala)) { 
       $aktiflik = "disabled";
       $gorunme = "none";
     } else{
   	   $aktiflik = "";
       $gorunme = "block";
     }
   
   ?>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
   .blue-text {
   color: blue;
   }
   .underline {
   text-decoration: underline;
   }
   .drop-field {
   position: relative;
   text-align: center;
   vertical-align: middle;
   }
   .drop-field,
   .drop-area {
   margin-top:10px;
   height: 200px;
   width: 100%;
   }
   .drop-field .browse {
   z-index: 0;
   position: absolute;
   left: 0;
   bottom: 0;
   right: 0;
   margin: 0 auto;
   }
   .drop-field .drop-area {
   display: block;
   border: 3px dashed #ce680d;
   position: relative;
   }
   .drop-field,
   .drop-area,
   .drop-field .browse {
   transition: all 0.3s;
   }
   .drop-field.loaded .drop-area {
   border: 1px solid blue;
   }
   .drop-field .browse {
   opacity: 0;
   transform: translateY(100%);
   }
   .drop-field.loaded .browse {
   opacity: 1;
   transform: translateY(0);
   }
   .drop-field.hover .drop-area {
   border: 1px solid black;
   }
   .drop-field .drop-area input[type="file"] {
   height: 100%;
   width: 100%;
   position: absolute;
   display: block;
   z-index: 3;
   top: 0;
   left: 0;
   opacity: 0.000001;
   }
   .drop-field .file-list {
   position: absolute;
   z-index: 0;
   top: 0;
   left: 0;
   text-align: center;
   }
   .drop-field .remove {
   position: absolute;
   left: 20px;
   top: 20px;
   z-index: 4;
   transition: all 0.3s;
   opacity: 0;
   transform: translateY(-100%);
   cursor: pointer;
   }
   .drop-field .remove:hover {
   color: blue;
   }
   .drop-field.loaded .remove {
   opacity: 1;
   transform: translateY(0);
   }
   .drop-field ul li {
   margin-left: 50px;
   font-size: 15px;
   padding: 0;
   text-align: center;
   list-style: none;
   }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/il_ilce.js?v=14"></script>
<script src="js/marka_model.js?v=4"></script>
<!-- <script src="js/teklif.js?v=2"></script> -->
<!-- <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script> -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script> -->
<script src="assets/ckeditor4/ckeditor.js"></script>
<style>
   .row {
   background: #f6f6f6;
   overflow: hidden;
   padding: 10px;
   }
   .col {
   float: left;
   width: 50%
   }
   #plaka{
   text-transform: uppercase;
   }
   .deneme{
   opacity:1 !important; z-index:999;
   }
   .isDisabled {
   color: currentColor;
   cursor: pointer;
   opacity: 0.5;
   text-decoration: none;
   }
</style>
<form method="POST" id="form" name="form" enctype="multipart/form-data" style="margin-top: 50px;">
   <?php $ilani_oku = mysql_fetch_assoc($ilani_cek);
      $max_teklif=$ilani_oku["son_teklif"];
      $marka_cek=mysql_query("select * from marka where markaID='".$ilani_oku["marka"]."' ");
      $marka_oku=mysql_fetch_object($marka_cek);
            $get_sigorta = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$ilani_oku['sigorta']."'");
            $set_sigorta = mysql_fetch_assoc($get_sigorta);
            $sigorta_name = $set_sigorta['sigorta_adi'];
            $get_model = mysql_query("SELECT * FROM model");
            $set_model = mysql_fetch_assoc($get_model);
            $model_adi = $set_model['model_adi'];
          
        ?>
   <?php 
      $sorgu = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '".$ilani_oku['sigorta']."'");
      $sorgu_say = mysql_num_rows($sorgu);
      $arttir = 1;
      $oran = array();
      $standart_net = array();
      $luks_net = array();
      $standart_onbinde = array();
      $luks_onbinde = array();
      
      while($sonuc = mysql_fetch_array($sorgu)){
      
      array_push($oran, $sonuc['komisyon_orani']);
      array_push($standart_net, $sonuc['net']);
      array_push($luks_net, $sonuc['lux_net']);
      array_push($standart_onbinde, $sonuc['onbinde']);
      array_push($luks_onbinde, $sonuc['lux_onbinde']);
        
      ?>
   <input type="hidden" id="standart_net" value="<?= $standart_net ?>">
   <input type="hidden" id="luks_net" value="<?= $luks_net ?>">
   <input type="hidden" id="standart_onbinde" value="<?= $standart_onbinde ?>">
   <input type="hidden" id="luks_onbinde" value="<?= $luks_onbinde ?>">
   <input type="hidden" id="oran" value="<?= $oran ?>">
   <?php } ?>
   <input type="hidden" id="hesaplama" value="<?= $ilani_oku['hesaplama'] ?>">
   <input type="hidden" id="sorgu_sayi" value="<?= $sorgu_say ?>">
   <text style="color:red" ><?=$uyari ?></text>
   <div class="row-fluid">
   <div class="span12">
		   <label for="IDofIpnut">Kategori Adı</label>
		   <input type="text" name="kategori_adi" value="<?= $kategori_oku['adi'] ?>">
	   </div>
   </div>
   <div class="row-fluid">	
      <div class="span6">		  
         <label for="IDofInput">Plaka</label> 
         <input type="text" class="span12" name="plaka" id="plaka" onchange="plaka_sorgu();" placeholder="01AA0000" value="<?= $ilani_oku['plaka'] ?>" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8"  /> 
         <label for="IDofInput">Araç Kodu</label> 
         <input type="text" class="span12" name="arac_kodu" id="arac_kodu" onchange="arac_kodu_sorgu();" value="<?= $ilani_oku['arac_kodu'] ?>" onkeypress="return boslukEngelle()" /> 
         <label for="IDofInput">Hesaplama</label> 
         <select class="span12" name="hesaplama" id="hesaplama"   >
            <option <?php if( $ilani_oku['hesaplama']=="Standart"){ echo "selected"; } ?> value="Standart">Standart</option>
            <option <?php if( $ilani_oku['hesaplama']=="Luks"){ echo "selected"; } ?>  value="Luks">Ticari</option>
         </select>
         <?php $sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri"); ?>
         <label for="IDofInput">Sigorta Şirketi*</label>
         <select class="span12" name="sigorta"   >
            <?php while($sigorta_oku = mysql_fetch_array($sigorta_cek)){ ?>
            <option value="<?= $sigorta_oku['id'] ?>" <?php if($ilani_oku['sigorta']==$sigorta_oku['id']){ echo "selected"; } ?>><?= $sigorta_oku['sigorta_adi'] ?></option>
            <?php } ?>
         </select>
         <label for="IDofInput">Marka*</label> 
         <select class="span12" name="marka" id="marka" reuqired>
			<option value="">SEÇİNİZ</option>
            <?php $marka_bul = mysql_query("select * from marka where markaID = '".$ilani_oku['marka']."'");
               $markayaz = mysql_fetch_assoc($marka_bul);
               $markanin_idsi = $markayaz['markaID'];
               ?>
            <?php $marka_cek = mysql_query("SELECT * FROM marka"); while($marka_oku = mysql_fetch_array($marka_cek)){ ?>
            <option value="<?=$marka_oku['markaID'] ?>" <?php if($marka_oku['markaID'] == $ilani_oku['marka']){ echo "selected"; } ?> ><?=mb_strtoupper(pre_up($marka_oku['marka_adi'])) ?></option>
            <?php } ?>
         </select>
         <label for="IDofInput">Model*</label>
         <select class="span12" name="model" id="model"   >
            <option value="<?= $ilani_oku['model'] ?>" selected><?=mb_strtoupper(pre_up( $ilani_oku['model'])) ?></option>
         </select>
         <label for="IDofInput">Tip</label>
         <input class="span12" type="text" value="<?= $ilani_oku['tip'] ?>" name="tip" id="tip" >
         <?php $anlik_yil = date("Y") ?>
         <label for="IDofInput">Model Yılı</label>
         <input class="span12" type="number" onkeypress="return isNumberKey(event)" value="<?= $ilani_oku['model_yili']?>" name="model_yili" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxLength="4" min="1950" max="<?= $anlik_yil; ?>" id="model_yili" >
         <label for="IDofInput">TSRSB Değeri</label>
         <input class="span12" type="text" value="<?= $ilani_oku['tsrsb_degeri'] ?>" onkeypress="return isNumberKey(event)" name="tsrsb_degeri" id="tsrsb_degeri"  placeholder="sadece rakam">
         <label for="IDofInput">Açılış Fiyatı</label>
         <input class="span12" type="text" value="<?= $ilani_oku['acilis_fiyati'] ?>" onkeypress="return isNumberKey(event)" name="acilis_fiyati" id="acilis_fiyati" >
         <label for="IDofInput">Profil</label>
         <select class="span12" name="profil" id="profil" >
         
            <option  <?php if( $ilani_oku['profil']=="Çekme Belgeli/Pert Kayıtlı"){ echo "selected"; } ?> value="Çekme Belgeli/Pert Kayıtlı">Çekme Belgeli/Pert Kayıtlı</option>
            <option  <?php if( $ilani_oku['profil']=="Çekme Belgeli"){ echo "selected"; } ?> value="Çekme Belgeli">Çekme Belgeli</option>
            <option  <?php if( $ilani_oku['profil']=="Hurda Belgeli"){ echo "selected"; } ?> value="Hurda Belgeli">Hurda Belgeli</option>
            <option  <?php if( $ilani_oku['profil']=="Plakalı"){ echo "selected"; } ?> value="Plakalı">Plakalı Ruhsatlı</option>
            <option  <?php if( $ilani_oku['profil']=="Diğer"){ echo "selected"; } ?> value="Diğer">Diğer</option>
         </select>
         </select>
      </div>
      <div class="span6">
         <label for="IDofInput">Şehir</label>
         <select class="span12" name="sehir" id="sehir" >
            <?php
               while($sehir_oku = mysql_fetch_array($sehir_cek)){                   
               ?>                        
            <option value="<?=$sehir_oku["sehirID"]?>" <?php if($sehir_oku['sehiradi'] == $ilani_oku['sehir']){ echo "selected"; } ?> ><?=$sehir_oku["sehiradi"];?></option>
            <?php } ?>                      
         </select>
         <?php
            $ilce_cek = mysql_query("SELECT * FROM ilce WHERE ilce_adi = '".$ilani_oku['ilce']."'");
            $ilce_oku = mysql_fetch_assoc($ilce_cek);
            $ilce_adi = $ilce_oku['ilce_adi']; 
            ?>
         <label for="IDofInput">İhale Bitiş Tarihi*</label>
         <input class="span12" onfocusout="tarih_sorgula();" type="date" value="<?=$ilani_oku['ihale_tarihi'] ?>" name="ihale_tarihi" id="ihale_tarihi" >
         <label for="IDofInput">İhale Bitiş Saati*</label>
         <?php
            $parcala=explode(":",$ilani_oku["ihale_saati"]);
            $ihale_s=$parcala[0].":".$parcala[1];
            ?>
         <input class="span12" onfocusout="tarih_sorgula();" type="time" value="<?= $ihale_s ?>" name="ihale_saati" id="ihale_saati" >
         <label for="IDofInput">PD Hizmet Bedeli</label>
         <?php
            if($ilani_oku['pd_hizmet'] =="" || $ilani_oku['pd_hizmet'] <= 0 ){
            	$pd_yaz="Otomatik Hesaplama";
            }else{
            	$pd_yaz=$ilani_oku["pd_hizmet"];
            }
            ?>
         <input class="span12" type="text" value="<?= $pd_yaz ?>" name="pd_hizmet" id="pd_hizmet">
         <label for="IDofInput">Otopark Giriş Tarihi</label>
         <input class="span12" type="date" value="<?=$ilani_oku['otopark_giris'] ?>" name="otopark_giris" id="otopark_giris" >
         <label for="IDofInput">Otopark Ücreti</label>
         <input class="span12" type="text" value="<?= $ilani_oku['otopark_ucreti'] ?>"  name="otopark_ucreti" id="otopark_ucreti" >
         <label for="IDofInput">Çekici Ücreti</label>
         <input class="span12" type="text" value="<?= $ilani_oku['cekici_ucreti'] ?>"   name="cekici_ucreti" id="cekici_ucreti" >
         <label for="IDofInput">Dosya Masrafı</label>
         <input class="span12" type="text" value="<?= $ilani_oku['dosya_masrafi'] ?>"  name="dosya_masrafi" id="dosya_masrafi" >
         <label for="IDofInput">Link</label>
         <input class="span12" type="text" value="<?= $ilani_oku['link'] ?>" name="link" id="link" >
         <label for="IDofInput">Kilometre</label>
         <input class="span12" type="text" value="<?= $ilani_oku['kilometre'] ?>" onkeypress="return isNumberKey(event)" name="kilometre" id="kilometre" > 
         <label for="IDofInput">Adres</label>
         <textarea name="adres" class="span12" rows="5"><?= $ilani_oku['adres'] ?></textarea>
      </div>
   </div>
   <?php 
      $ekleyen_cek = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 1 AND ilan_id = '".$gelen_id."'");
      $ekleyen_say = mysql_num_rows($ekleyen_cek);
      $ekleyen_oku = mysql_fetch_assoc($ekleyen_cek);
      $ekleyen_id = $ekleyen_oku['admin_id'];
      
      $ekleyen_bul = mysql_query("select * from kullanicilar where id = '".$ekleyen_id."'");
      $ekleyen_yaz = mysql_fetch_assoc($ekleyen_bul);
      if($ekleyen_say != 0){
          $ekleyen = $ekleyen_yaz['adi']." ".$ekleyen_yaz['soyadi'];
          
          $ekleme_tarihi = date("d-m-Y H:i:s", strtotime($ekleyen_oku['ekleme_zamani']));
      }else{
          $ekleyen = "Kullanıcı tarafından eklenen ilan";
          $ekleme_tarihi = date("d-m-Y H:i:s", strtotime($ilani_oku['eklenme_zamani']));
      }
      ?>      
   <div class="row-fluid" style="margin-top: 30px;">
      <label for="IDofInput">Uyarı Notu</label>
      <textarea style="min-height:200px !important" class="span12" name="uyari_notu" id="uyari_notu"><?= $ilani_oku['uyari_notu'] ?></textarea>
      <label for="IDofInput">Hasar Bilgileri</label>
      <textarea class="span12" name="hasar_bilgileri" id="hasar_bilgileri"><?= $ilani_oku['hasar_bilgileri'] ?></textarea>
      <label for="IDofInput">Notlar</label>
      <textarea class="span12" name="notlar" id="notlar"><?= $ilani_oku['notlar'] ?></textarea>
      <label for="IDofInput">Donanımlar</label>
      <textarea class="span12" name="donanimlar" id="donanimlar"><?= $ilani_oku['donanimlar'] ?></textarea>
      <label for="IDofInput">Vitrin</label>
      <input class="span12" type="checkbox"<?php if($ilani_oku['vitrin'] == 'on') echo "checked='checked'";?>name="vitrin">
      <!--<label for="IDofInput">Yayında</label>
      <input class="span12" type="checkbox"<?php if($ilani_oku['durum'] == 1) echo "checked='checked'";?> value="1" name="yayinda">-->
   </div>
   <div class="form-actions">
      <input type="submit" name="guncellemeyi" class="btn blue" <?= $aktiflik ?> value="Kaydet">
   </div>
</form>
<form method="POST" enctype="multipart/form-data">
<div class="row-fluid">
      <div class="form-group">
				<br/>
				<text>Dosyaları seçmek için aaşağıdaki alana tıklayabilir veya dosyaları alanın içine sürükleyebilirsiniz.</text>
				<input name="resim[]" type="file" multiple>
			</div>
      </div>
      <div class="form-actions">
      <input type="submit" name="resimleri" class="btn blue" value="Resim Kaydet">
   </div>
</form>

<ul class="thumbnails">  
 <?= $resimleri_bas ?>
</ul>
<script src="https://code.jquery.com/jquery-3.6.0.js" > </script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
      $("#plaka").keypress(function(event) {
      var character = String.fromCharCode(event.keyCode);
      return isValid(character);     
   });
   
   function isValid(str) {
      return !/[~`!@#$%\^&*()+=\-\[\]\\';.,/{}|\\":<>\?]/g.test(str);
   }
</script>
<script>
   function boslukEngelle() {
       if (event.keyCode == 32) {
           return false;
       }
   }
</script>
<script>
   function isNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : event.keyCode;
   if (charCode > 31 && (charCode < 48 || charCode > 57))
       return false;
   return true;
   }
</script>
<style>
   .ck-editor__editable_inline {
   min-height: 200px !important;
   }
</style>
<script>
  /* ClassicEditor
       .create( document.querySelector( '#hasar_bilgileri' ) )
       .then( editor => {
           console.log( editor );
       } )
       .catch( error => {
           console.error( error );
       } );*/
	    CKEDITOR.replace( 'hasar_bilgileri', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
       
</script>
<script>
   /*ClassicEditor
       .create( document.querySelector( '#notlar' ) )
       .then( editor => {
           console.log( editor );
       } )
       .catch( error => {
           console.error( error );
       } );*/
	    CKEDITOR.replace( 'notlar', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
       
</script>
<script>
   /* ClassicEditor
       .create( document.querySelector( '#donanimlar' ) )
       .then( editor => {
           console.log( editor );
       } )
       .catch( error => {
           console.error( error );
       } ); */
        CKEDITOR.replace( 'donanimlar', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
</script>
<script>
   function plaka_sorgu(){
   jQuery.ajax({
   url: "https://ihale.pertdunyasi.com/check.php",
   type: "POST",
   dataType: "JSON",
   data: {
   	action: "panel_plaka_sorgu",
   	plaka:$("#plaka").val(),
   
   },
   success: function(response) {
   
   	if(response.status == 200){
   		var span = document.createElement("span");
   		span.innerHTML = response.data;
   
   		swal({
   			title: "Dikkat", 
   			text:  "Bu plakaya ait bilgiler mevcut.", 
   			content: span,
   		});
   	}
   }
   });
   }
   function arac_kodu_sorgu(){
   jQuery.ajax({
   url: "https://ihale.pertdunyasi.com/check.php",
   type: "POST",
   dataType: "JSON",
   data: {
   action: "panel_arac_kodu_sorgu",
   arac_kodu:$("#arac_kodu").val(),
   
   },
   success: function(response) {
   
   if(response.status == 200){
   	var span = document.createElement("span");
   	span.innerHTML = response.data;
   
   	swal({
   		title: "Dikkat", 
   		text:  "Bu plakaya ait bilgiler mevcut.", 
   		content: span,
   	});
   }
   }
    });
   }
   function tarih_sorgula(){
   jQuery.ajax({
   url: "https://ihale.pertdunyasi.com/check.php",
   type: "POST",
   dataType: "JSON",
   data: {
   action: "panel_tarih_sorgu",
   ihale_tarihi:$("#ihale_tarihi").val(),
   ihale_saati:$("#ihale_saati").val()
   },
   success: function(response) {
   
   if(response.status == 200){
   	swal({
   		title: "Dikkat", 
   		text:  response.message,
   	});
   	
   }
   }
    });
   }
   
   
</script>
<script>
   var globalFunctions = {};
   
   globalFunctions.ddInput = function(elem) {
   if ($(elem).length == 0 || typeof FileReader === "undefined") return;
   var $fileupload = $('input[type="file"]');
   var noitems = '<li class="no-items"></li>';
   var hasitems = '<div class="browse hasitems">Dosya Seçimi </div>';
   var file_list = '<ul class="file-list"></ul>';
   var rmv = '<div class="remove"><i style="font-size:30px" class="icon-close icons">x</i></div>'
   $fileupload.each(function() {
   	var self = this;
   	var $dropfield = $('<div class="drop-field"><div class="drop-area"></div></div>');
   	$(self).after($dropfield).appendTo($dropfield.find('.drop-area'));
   	var $file_list = $(file_list).appendTo($dropfield);
   	$dropfield.append(hasitems);
   	$dropfield.append(rmv);
   	$(noitems).appendTo($file_list);
   	var isDropped = false;
   	$(self).on("change", function(evt) {
   		if ($(self).val() == "") {
   			$file_list.find('li').remove();
   			$file_list.append(noitems);
   		} else {
   			if(!isDropped) {
   				$dropfield.removeClass('hover');
   				$dropfield.addClass('loaded');
   				var files = $(self).prop("files");
   				traverseFiles(files);
   			}
   		}
   	});
   	
   	$dropfield.on("dragleave", function(evt) {
   		$dropfield.removeClass('hover');
   		evt.stopPropagation();
   	});
   
   	$dropfield.on('click', function(evt) {
   		$(self).val('');
   		$file_list.find('li').remove();
   		$file_list.append(noitems);
   		$dropfield.removeClass('hover').removeClass('loaded');
   	});
   
   	$dropfield.on("dragenter", function(evt) {
   		$dropfield.addClass('hover');
   		evt.stopPropagation();
   	});
   
   	$dropfield.on("drop", function(evt) {
   		isDropped = true;
   		$dropfield.removeClass('hover');
   		$dropfield.addClass('loaded');
   		var files = evt.originalEvent.dataTransfer.files;
   		traverseFiles(files);
   		isDropped = false;
   	});
   
   
   	function appendFile(file) {
   
   		$file_list.append('<li>' + file.name + '</li>');
   	}
   
   	function traverseFiles(files) {
   		if ($dropfield.hasClass('loaded')) {
   			$file_list.find('li').remove();
   		}
   		if (typeof files !== "undefined") {
   			for (var i = 0, l = files.length; i < l; i++) {
   				appendFile(files[i]);
   			}
   		} else {
   			alert("Tarayıcının dosya yükleme özelliği yok.");
   		}
   	}
   
   });
   };
   
   $(document).ready(function() {
   globalFunctions.ddInput('input[type="file"]');
   });
   
</script>