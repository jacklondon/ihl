<?php 
session_start();
include 'ayar.php';
$token = $_SESSION['u_token'];
$k_token = $_SESSION['k_token'];
if(!empty($token)){
  $uye_token = $token;
}elseif(!empty($k_token)){
  $kurumsal_token = $k_token;
}

   $ihale_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = '1'");
   ?>
<?php 
   // Sayfalama
           if (isset($_GET['sayfa'])) {
              $sayfa = $_GET['sayfa'];
          } else {
              $sayfa = 1;
          }
          $sayfada = 10;
          $offset = ($sayfa-1) * $sayfada;
          $bugun = date("Y-m-d");
   
          $toplam_sayfa_sql = mysql_query("SELECT COUNT(*) FROM dogrudan_satisli_ilanlar");
          $toplam_ihale = mysql_fetch_array($toplam_sayfa_sql)[0];
          $toplam_sayfa = ceil($toplam_ihale / $sayfada);
   
          $sql = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND bitis_tarihi > '".$bugun."'  ORDER BY id DESC LIMIT $offset, $sayfada");?>
<!doctype html>
<html lang="tr">
   <head>
      <title>Pert &mdash; Dünyası</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="fonts/icomoon/style.css">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/bootstrap-datepicker.css">
      <link rel="stylesheet" href="css/jquery.fancybox.min.css">
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
      <link rel="stylesheet" href="css/aos.css">
      <!-- MAIN CSS -->
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/custom.css">
      <link rel="stylesheet" href="css/ihaledekiler.css">
      <style>
         .ihale ul{height:400px; width:100%; list-style-type:none; 
         }
         .ihale ul{overflow:hidden; overflow-y:scroll;
         }
         .list-group-item{background: rgb(28, 1, 102); color: rgb(255, 255, 255);
         }
         .list-group-item:hover{ background: rgb(5, 22, 39); color: rgb(255, 255, 255);
         }
         /* .ihale{
         margin-top: -60px;
         } */
         /* .list-group{
         margin-top: 10px;
         } */
      </style>
      <style>
   .ilan_karti_dis
   {
      min-height:10px;
      float:left;
      margin:10px 0px;
      padding:0px;
   }

   .ilan_karti_baslik
   {
      height: 35px;
      background-color: orange;
      float: left;
      padding: 0px;
      line-height: 35px;
      padding-left: 10px;
      font-weight: 600;
   }

   .ilan_karti_icerik_dis
   {
      min-height:20px;
      background-color:#ffffff;
      float:left;
      border:1px solid #dadada;
      border-top:0px;
      padding:0px;
   }

   .ilan_karti_gorsel_dis
   {
      width:200px;
      float:left;
      background-color:maroon;
      position:relative;
      background-position:center;
      background-size:cover;
   }

   .ilan_karti_gorsel_dis:after
   {
      content:"";
      display:block;
      padding-bottom:100%;
   }

   .ilan_karti_kod
   {
      height: 40px;
      float: left;
      position: absolute;
      left: 0px;
      bottom: 0px;
      background-color: gray;
      display: flex;
      align-items: center;
      padding: 10px;
      color: #fff;
   }

   .ilan_karti_gorsel_icerik
   {
      width:calc(100% - 200px);
      min-height:200px;
      float:left;
      padding:10px;
   }

   .ilan_karti_taglar_dis
   {
      min-height:20px;
      float:left;
      padding:0px;
   }

   .ilan_karti_tag
   {
      min-width: 10px;
      height: 30px;
      float: left;
      background-color: #f1f1f1;
      margin-right: 10px;
      margin-bottom: 10px;
      padding: 0px 8px;
      line-height: 30px;
      font-weight: 600;
      font-size: 12px;
   }

   .ilan_karti_alt_alan
   {
      min-height:10px;
      float:left;
      padding:0px;
   }

   .ilan_karti_notlar_dis
   {
      min-height:10px;
      float:left;
      padding:0px;
   }

   .ilan_karti_not_baslik
   {
      min-height:10px;
      float:left;
      padding:0px;
   }

   .ilan_karti_not_alan
   {
      height: 75px;
      float: left;
      background-color: #f7f7f7;
      float: left;
      margin-top: 10px;
      padding: 8px;
      font-size: 13px;
      overflow-y: scroll;
      border: 1px solid #eaeaea;
   }

   .ilan_karti_begeni_dis
   {
      height: 26px;
      float: left;
      margin-top: 5px;
      padding: 0px;
   }

   .ilan_karti_begeni_dis span
   {
      width: 26px;
      height: 26px;
      background-color: #e6e6e6;
      margin-right: 10px;
      float: left;
      text-align: center;
      line-height: 27px;
      color: orange;
      border-radius: 3px;
   }

   .ilan_karti_teklif_dis
   {
      min-height:10px;
      float:left;
   }

   .ilan_karti_teklif_baslik
   {
      height: 30px;
      float: left;
      text-align: center;
      line-height: 30px;
      font-weight: 600;
      font-size: 18px;
   }

   .ilan_karti_teklif_fiyat
   {
      min-height: 20px;
      float: left;
      text-align: center;
      font-size: 35px;
      font-weight: 700;
   }

   .ilan_karti_teklif_btnlar
   {
      min-height:20px;
      float:left;
      padding:0px;
   }

   .ilan_karti_teklif_btn
   {
      width: calc(50% - 10px);
      height: 47px;
      float: left;
      margin: 5px;
      text-align: center;
      line-height: 47px;
      color: #ffffff;
      border-radius: 4px;
      font-weight: 500;
   }

   @media only screen and (max-width: 600px) {
      .ilan_karti_baslik
      {
         font-size:9px;
         padding-left:5px;
      }

      .ilan_karti_gorsel_dis
      {
         width:100%;
      }

      .ilan_karti_gorsel_icerik
      {
         width:100%;
      }

      .ilan_karti_begeni_dis
      {
         display:flex;
         align-items:center;
         justify-content:center;
         margin-bottom:15px;
         margin-top:15px;
      }

      .ilan_karti_begeni_dis span
      {
         width:35px;
         height:35px;
         line-height:35px;
      }

      .ilan_karti_begeni_dis span:last-child
      {
         margin:0px;
      }
   }
</style>

   </head>
   <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
 <?php
 include 'modal.php';
 include 'alert.php';
  $sehir_cek = mysql_query("SELECT * FROM sehir"); 
  $marka_cek = mysql_query("SELECT * FROM marka"); 
   
?>
	<input type="hidden" id="user_token" value="<?php if(!empty($uye_token)) ? echo($token) : echo($kurumsal_token) ?>"/>
   <div class="site-wrap" id="home-section">
         <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
               <div class="site-mobile-menu-close mt-3">
                  <span class="icon-close2 js-menu-toggle"></span>
               </div>
            </div>
            <div class="site-mobile-menu-body"></div>
         </div>
         <?php include 'header.php'; ?>
<style>
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}
.selectBox select {
  width: 100%;
  font-weight: bold;
}
.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}
#sehirler {
  display: none;
  border: 1px #dadada solid;
}

#sehirler label {
  display: block;
}

#sehirler label:hover {
  background-color: #1e90ff;
}
#markalar {
  display: none;
  border: 1px #dadada solid;
}

#markalar label {
  display: block;
}

#markalar label:hover {
  background-color: #1e90ff;
}
#tarih {
  display: none;
  border: 1px #dadada solid;
}

#tarih label {
  display: block;
}

#tarih label:hover {
  background-color: #1e90ff;
}
#profil {
  display: none;
  border: 1px #dadada solid;
}

#profil label {
  display: block;
}

#profil label:hover {
  background-color: #1e90ff;
}
</style>
<script>
var expanded = false;
function showSehirler() {
  var checkboxes = document.getElementById("sehirler");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
function showMarkalar() {
  var checkboxes = document.getElementById("markalar");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
function showBitis() {
  var checkboxes = document.getElementById("tarih");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}  

function showProfil() {
  var checkboxes = document.getElementById("profil");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>           


         <div class="site-section" style="margin-top: 2%;">
            <div class="container">
               <div class="row">
               
               <div class="col-sm-3">
                     <form method="POST" name="filter" id="filter">
                     <div class="form-group">
                           <h5>Kelime ile ara</h5>
                           <input type="search" name="aranan" class="form-control" placeholder="Plaka, araç kodu vb..">
                        </div>
                        <div class="multiselect">
                           <div class="selectBox" onclick="showSehirler()">
                              <select style="height:1.8em;">
                              <option>Şehire Göre</option>
                              </select>
                              <div class="overSelect"></div>
                           </div>
                           <div id="sehirler">
                           <?php while($sehir_oku = mysql_fetch_array($sehir_cek)){?>                        
                              <label for="<?= $sehir_oku['sehirID'] ?>">
                              <input type="checkbox" name="sehir[]" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?></label>
                              <?php } ?> 
                           </div>
                        </div>
                        <div class="multiselect" style="margin-top: 10%;">
                           <div class="selectBox" onclick="showMarkalar()">
                              <select style="height:1.8em;">
                              <option>Markaya Göre</option>
                              </select>
                              <div class="overSelect"></div>
                           </div>
                           <div id="markalar">
                           <?php while($marka_oku = mysql_fetch_array($marka_cek)){?>                        
                              <label for="<?= $marka_oku['markaID'] ?>">
                              <input type="checkbox" name="marka[]" value="<?= $marka_oku['marka_adi'] ?>" /><?= $marka_oku['marka_adi'] ?></label>
                              <?php } ?> 
                           </div>
                        </div>
                        <div class="multiselect" style="margin-top: 10%;">
                           <div class="selectBox" onclick="showBitis()">
                              <select style="height:1.8em;">
                              <option>Tarihe Göre</option>
                              </select>
                              <div class="overSelect"></div>
                           </div>
                           <div id="tarih">                           
                              <input type="checkbox" name="tarih[]" value=" <?= date('Y-m-d') ?>" />Bugün Bitenler</label><br>
                              <input type="checkbox" name="tarih[]" value="<?= date("Y-m-d", strtotime("+1 day")) ?>" />Yarın Bitenler</label>
                           </div>
                        </div>
                        <div class="multiselect" style="margin-top: 10%;">
                           <div class="selectBox" onclick="showProfil()">
                              <select style="height:1.8em;">
                              <option>Profile Göre</option>
                              </select>
                              <div class="overSelect"></div>
                           </div>
                           <div id="profil"> 
                           <label for="Çekme Belgeli/Pert Kayıtlı">                          
                              <input type="checkbox" name="profil[]" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı</label><br>
                              <label for="Çekme Belgeli"> 
                              <input type="checkbox" name="profil[]" value="Çekme Belgeli" />Çekme Belgeli</label><br>
                              <label for="Hurda Belgeli"> 
                              <input type="checkbox" name="profil[]" value="Hurda Belgeli" />Hurda Belgeli</label><br>
                              <label for="Plakalı"> 
                              <input type="checkbox" name="profil[]" value="Plakalı" />Plakalı</label>
                           </div>
                        </div>
                        <div class="form-check" style="margin-top: 5%;">
                           <h5>Yıla Göre</h5>
                        </div>
                        <div class="form-group">
                           <label for="exampleInputEmail1">En düşük</label>
                           <input type="text" name="kucuk_yil" class="form-control">
                        </div>
                        <div class="form-group">
                           <label for="exampleInputPassword1">En yüksek</label>
                           <input type="text" name="buyuk_yil" class="form-control" >
                        </div>
                        <button type="submit" name="filtrele" class="btn btn-primary">Ara</button>
                     </form>
                  </div>

                  
                  <div class="col-sm-9">

                  <?php 
                  if(isset($_POST['filtrele'])){                    
                    $f_kelime = $_POST['aranan'];     
                    $f_marka = $_POST['marka'];
                    $f_sehir = $_POST['sehir'];
                    $f_tarih = $_POST['tarih'];
                    $f_profil = $_POST['profil'];
                    $f_kucuk_yil = $_POST['kucuk_yil'];
                    $f_buyuk_yil = $_POST['buyuk_yil'];
                    
                    if($f_tarih=="1"){
                       $f_tarih =date("Y-m-d");
                    }elseif($f_tarih=="2"){
                       $f_tarih = date("Y-m-d", strtotime("+1 day"));
                    }


                     $where = "WHERE durum = '1'";
                     if($f_kelime !=""){
                        $where .= "AND concat(plaka,model,arac_kodu,model_yili,sehir,ilce,hesaplama) LIKE '%".$f_kelime."%'";
                     }
                     if($f_marka !=""){                    
                     $k = 0;
                     $seciliMarkaSayisi = count($_POST['marka']);
                     $seciliMarka = "";
                     while ($k < $seciliMarkaSayisi) {
                         $seciliMarka = $seciliMarka . "'" . $_POST['marka'][$k] . "'";
                         if ($k < $seciliMarkaSayisi - 1) {
                             $seciliMarka = $seciliMarka . ", ";
                         }
                         $k ++;
                     }
                     $where = $where . " AND marka in (" . $seciliMarka . ")";
                     }
                     if($f_sehir !=""){
                        $i = 0;
                        $seciliSehirSayisi = count($_POST['sehir']);
                        $seciliSehir = "";
                        while ($i < $seciliSehirSayisi) {
                            $seciliSehir = $seciliSehir . "'" . $_POST['sehir'][$i] . "'";
                            if ($i < $seciliSehirSayisi - 1) {
                                $seciliSehir = $seciliSehir . ", ";
                            }
                            $i ++;
                        }
                        $where = $where . " AND sehir in (" . $seciliSehir . ")";
                     }
                     if($f_profil !=""){
                        $p = 0;
                        $seciliProfilSayisi = count($_POST['profil']);
                        $seciliProfil = "";
                        while ($p < $seciliProfilSayisi) {
                            $seciliProfil = $seciliProfil . "'" . $_POST['profil'][$p] . "'";
                            if ($p < $seciliProfilSayisi - 1) {
                                $seciliProfil = $seciliProfil . ", ";
                            }
                            $p ++;
                        }
                        $where = $where . " AND evrak_tipi in (" . $seciliProfil . ")";
                     }
                     if($f_tarih !=""){
                        
                        $t = 0;
                        $seciliTarihSayisi = count($_POST['tarih']);
                        $seciliTarih = "";
                        while ($t < $seciliTarihSayisi) {
                            $seciliTarih = $seciliTarih . "'" . $_POST['tarih'][$t] . "'";
                            if ($t < $seciliTarihSayisi - 1) {
                                $seciliTarih = $seciliTarih . ", ";
                            }
                            $t ++;
                        }
                        $where = $where . " AND bitis_tarihi in (" . $seciliTarih . ")";
                     }
                     
                     if($f_kucuk_yil !="" && $f_buyuk_yil !=""){
                     $where .= "AND  model_yili BETWEEN $f_kucuk_yil AND $f_buyuk_yil";
                     }
                     $filtre_cek = "SELECT * FROM dogrudan_satisli_ilanlar $where";
                     $result = mysql_query($filtre_cek) or die(mysql_error());
                     $sayi = mysql_numrows($result);
                     if($sayi==0){
                        echo '<script type="text/javascript">'; 
                        echo 'alert("İstediğiniz kriterlere uygun araç bulunamadı.");'; 
                        echo 'window.location.href = "dogrudan_satisli_araclar.php";';
                        echo '</script>';                       
                     }else{ ?>
                        <?php while($filtre_oku = mysql_fetch_array($result)){  
                           $resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '".$filtre_oku['id']."'");
                           $resim_oku = mysql_fetch_assoc($resim_cek);
                           $resim = $resim_oku['resim'];
                           $marka_cek2 = mysql_query("select * from marka where markaID = '".$filtre_oku['marka']."'");
                           $marka_oku2 = mysql_fetch_assoc($marka_cek2);
                           $marka_adi2 = $marka_oku2['marka_adi'];
                        
                        ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik">
                     <?= $filtre_oku['model_yili']." ".$filtre_oku['marka']." ".$filtre_oku['model'] . " " . $filtre_oku['uzanti'] ?> 

                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                        <div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $resim ?>');">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                              Kod : <?= $filtre_oku['arac_kodu'] ?>
                           </div>
                        </div>
                        <div class="ilan_karti_gorsel_icerik">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                              <div class="ilan_karti_tag">
                                 <?= $filtre_oku['sehir'] ?>
                              </div>
                              <div class="ilan_karti_tag">
                              <?= $filtre_oku['vites_tipi'] ?>
                              </div>
                              <div class="ilan_karti_tag">
                              <?= $filtre_oku['yakit_tipi'] ?>
                              </div>
                              <div class="ilan_karti_tag">
                              <?= $filtre_oku['kilometre'] ?>
                              </div>
                              <div class="ilan_karti_tag">
                              <?= $filtre_oku['evrak_tipi'] ?>
                              </div>
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_baslik">
                                    Açıklama
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                 <?= $filtre_oku['aciklamalar'] ?>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
                                    <form method="POST" action="" name="form" id="form">
                                       <button type="submit" name="favla" class="btn btn-light btn-sm">
                                          <i style="color: orange;" class="icon-favorite"></i>
                                          <input type="hidden" name="favlanacak" value="<?= $filtre['id'] ?>">
                                       </button>
                                    </form>
                                 </div>
                              </div>
                              <style>
                                 
                              </style>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    Satış Fiyatı
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                 <?= $filtre_oku['fiyat'] ?> ₺
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                                    <div class="ilan_karti_teklif_btn" style="width:calc(100% - 10px); background-color: orange;">
                                    <a style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id=<?= $ihale_oku['id'] ?>&q=dogrudan">İNCELE</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
         
                     <?php  } ?>
                     <?php } ?>
                     <?php }else{ ?>
                     <?php while($ihale_oku = mysql_fetch_array($sql)){  
                         $resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '".$ihale_oku['id']."'");
                         $resim_oku = mysql_fetch_assoc($resim_cek);
                         $resim = $resim_oku['resim'];
                     ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik">
                     <?= $ihale_oku['model_yili']." ".$ihale_oku['marka']." ".$ihale_oku['model'] . " " . $ihale_oku['uzanti'] ?> 

                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                        <div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $resim ?>');">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                              Kod : <?= $ihale_oku['arac_kodu'] ?>
                           </div>
                        </div>
                        <div class="ilan_karti_gorsel_icerik">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                              <div class="ilan_karti_tag">
                                 <?= $ihale_oku['sehir'] ?>
                              </div>
                              <div class="ilan_karti_tag">
                              <?= $ihale_oku['vites_tipi'] ?>
                              </div>
                              <div class="ilan_karti_tag">
                              <?= $ihale_oku['yakit_tipi'] ?>
                              </div>
                              <div class="ilan_karti_tag">
                              <?= $ihale_oku['kilometre'] ?>
                              </div>
                              <div class="ilan_karti_tag">
                              <?= $ihale_oku['evrak_tipi'] ?>
                              </div>
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_baslik">
                                    Açıklama
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                 <?= $ihale_oku['aciklamalar'] ?>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
                                 <form method="POST" action="" name="form" id="form">
                                    <button type="submit" name="favla" class="btn btn-light btn-sm">
                                       <i style="color: orange;" class="icon-favorite"></i>
                                       <input type="hidden" name="favlanacak" value="<?= $ihale_oku['id'] ?>">
                                    </button>
                                 </form>
                                 </div>
                              </div>
                              <style>
                                 
                              </style>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    Satış Fiyatı
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                 <?= $ihale_oku['fiyat'] ?> ₺
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                                    <div class="ilan_karti_teklif_btn" style="width:calc(100% - 10px); background-color: orange;">
										<a onclick="dogrudan_arttir(<?=$ihale_oku['id']?>)" style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id=<?= $ihale_oku['id'] ?>&q=dogrudan">İNCELE</a>
                                       
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>           
                     <?php  } ?>
                     <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                           <li class="page-item">
                              <a class="page-link" href="dogrudan_satisli_araclar.php" tabindex="-1" aria-disabled="true">İlk</a>
                           </li>
                           <li class="page-item <?php if($sayfa <= 1){ echo 'disabled'; } ?>">
                              <a class="page-link" href="<?php if($sayfa <= 1){ echo '#'; } else { echo "?sayfa=".($sayfa - 1); } ?>">Önceki</a>
                           </li>
                           <li class="page-item <?php if($sayfa >= $toplam_sayfa){ echo 'disabled'; } ?>">
                              <a class="page-link" href="<?php if($sayfa >= $toplam_sayfa){ echo '#'; } else { echo "?sayfa=".($sayfa + 1); } ?>">Sonraki</a>
                           </li>
                           <li class="page-item">
                              <a class="page-link" href="?sayfa=<?php echo $toplam_sayfa; ?>">Son</a>
                           </li>
                        </ul>
                     </nav>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
         <?php 
         
               if(isset($_POST['favla'])){
                  $date = date('Y-m-d H:i:s');
                  $id = $_POST['favlanacak'];
                  if($uye_token==$token){
                     $favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
                     while($favi_oku = mysql_fetch_array($favi_cek)){
                        $uyeninID = $favi_oku['id'];
                        mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
                     (NULL, '', '".$id."', '".$uyeninID."', '".$date."', '".$uye_token."', '');");
                     echo'<script> alert("İlan Favorilerinize Eklendi")</script>';
                     }

                  }elseif($uye_token==$k_token){
                     $favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$uye_token."'");
                     while($favi_oku = mysql_fetch_array($favi_cek)){
                        $uyeninID = $favi_oku['id'];
                        mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
                     (NULL, '', '".$id."', '".$uyeninID."', '".$date."', '', '".$uye_token."');");
                     echo'<script> alert("İlan Favorilerinize Eklendi")</script>';
                     }
                  }
               }
                       
                        ?>
         <!-- Footer Başlangıç -->
         <?php include "footer.php" ?>
         <!-- Footer Bitiş -->
      </div>
      <script src="js/jquery-3.3.1.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/owl.carousel.min.js"></script>
      <script src="js/jquery.sticky.js"></script>
      <script src="js/jquery.waypoints.min.js"></script>
      <script src="js/jquery.animateNumber.min.js"></script>
      <script src="js/jquery.fancybox.min.js"></script>
      <script src="js/jquery.easing.1.3.js"></script>
      <script src="js/bootstrap-datepicker.min.js"></script>
      <script src="js/aos.js"></script>
      <script src="js/main.js"></script>
      <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
   </body>
   <script>
			function dogrudan_arttir(id){
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "dogrudan_arttir",
					id:id
				},
				success: function(response) {
					console.log(response);
				}
			});
		}
   </script>
</html>