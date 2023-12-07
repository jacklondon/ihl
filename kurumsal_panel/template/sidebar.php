<?php 
$token = $_SESSION['k_token'];
if (!empty($token)) {
  $uye_token = $token;
}
$kullanici_cek_sidebar = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '".$uye_token."'");
$kullanici_oku_sidebar = mysql_fetch_assoc($kullanici_cek_sidebar);
?>
<style>
@media only screen and (max-width: 600px) {
  .left_sidebar {
    margin-top: 0px!important;
    margin-bottom:50px;
    display:none;
  }

  .left_sidebar * .list-group-item
  {
    padding-left:0px;
    padding-right:0px;
  }

  .navbar-collapse
  {
    display:block!important;
    margin-top:15px;
    padding-bottom:15px;
  }

  .navbar-collapse * .dropdown-menu
  {
    left: 0px!important;
    transform: none!important;
    position:static!important;
  }

  .profile_left_sidebar_btn
  {
    display:block!important;
  }
}
.alt_baslik{
  font-size: large;
}
</style>
<?php 
$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
?>

<style>
  .profile_left_sidebar_btn
  {
    min-height: 10px;
    background-color: #343a40;
    padding: 10px;
    color: #fff;
    font-size: 18px;
    font-weight: 500;
    display:none;
  }

  .profile_left_sidebar_btn span
  {
    float:right;
  }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 profile_left_sidebar_btn" onclick="openItem('profile_left_sidebar')">
  Menüler <span class="icon-menu h3 text-white"></span>
</div>

<script type="text/javascript">
  function openItem(item)
  {
    var status = document.getElementById(item).style.display;

    if(status == "block")
    {
      document.getElementById(item).style.display = "none";
    }
    else
    {
      document.getElementById(item).style.display = "block";
    }
  }
</script>
<style>
  .badge-danger{
    font-size: 15px !important;
  }
  td span{
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  }
  td{
    font-family: auto!important;
  }
</style>
<div class="left_sidebar" id="profile_left_sidebar">
<ul class="list-group list-group-flush">
        <li class="list-group-item">
          <k style="color: red;">KAZANDIKLARIM</k>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="son_islemdekiler.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="son_islemdekiler.php">SON İŞLEMDEKİLER</a>
              <span class="badge badge-danger badge-pill"><?= $son_islemde_sayisi ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="index.php"){ echo 'border-bottom:1px solid red;';} ?>" >
              <a class="alt_baslik" href="index.php">ÖDEME BEKLEYENLER</a>
              <span class="badge badge-danger badge-pill"><?= $odeme_bekleyen_sayisi ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="onay_bekleyenler.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="onay_bekleyenler.php">ONAY BEKLEYENLER</a>
              <span class="badge badge-danger badge-pill"><?= $onay_bekleyen_sayisi ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="satin_alinanlar.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="satin_alinanlar.php">SATIN ALINANLAR</a>
              <span class="badge badge-danger badge-pill"><?= $satin_alinan_sayisi ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="iptal_olanlar.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="iptal_olanlar.php">İPTAL OLANLAR</a>
              <span class="badge badge-danger badge-pill"><?= $iptal_olan_sayisi ?></span>
            </li>
          </ul>
        </li>
        <li class="list-group-item">          
          <k style="color: red;">TAKİP ETTİKLERİM</k>
          <ul class="list-group list-group-flush">
            <!--<li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="favorilerim.php"){ echo 'border-bottom:1px solid red;';} ?>">
				<a class="alt_baslik" href="favorilerim.php">FAVORİLERİM</a>
				<span class="badge badge-danger badge-pill"><?= $fav_sayisi ?></span>
            </li>-->
			<li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="favorilerim.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="favorilerim.php">İHALELİ FAVORİLERİM</a>
              <span class="badge badge-danger badge-pill"><?= $ihale_fav_sayisi ?></span>
            </li>
			<li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="dogrudan_favorilerim.php"){ echo 'border-bottom:1px solid red;';} ?>">
				<a class="alt_baslik" href="dogrudan_favorilerim.php">DOĞRUDAN SATIŞLI FAVORİLERİM</a>
              <span class="badge badge-danger badge-pill"><?= $dogrudan_fav_sayisi ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="tekliflerim.php"){ echo 'border-bottom:1px solid red;';} ?>">
				<a class="alt_baslik" href="tekliflerim.php">TEKLİFLERİM</a>
				<span class="badge badge-danger badge-pill"><?= $teklif_sayisi ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="mesajlarim.php"){ echo 'border-bottom:1px solid red;';} ?>">
				<a class="alt_baslik" href="mesajlarim.php">MESAJLARIM</a>
				<span class="badge badge-danger badge-pill" id="uye_pane_mesaj_sayisi"><?= $mesaj_sayisi ?></span>
            </li>
          </ul>
        </li>
        <li class="list-group-item">
        <k style="color: red;">İLANLARIM</k>          
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="yeni_ilan_ekle.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="yeni_ilan_ekle.php">YENİ İLAN EKLE</a>
              <span class="badge badge-danger badge-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="ihaledeki_ilanlarim.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="ihaledeki_ilanlarim.php"> İHALEDEKİ İLANLARIM</a>
              <span class="badge badge-danger badge-pill"><?= $uye_ihale ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="dogrudan_satisli_ilanlarim.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="dogrudan_satisli_ilanlarim.php">DOĞRUDAN SATIŞLI İLANLARIM</a>
              <span class="badge badge-danger badge-pill"><?= $dogrudaki ?></span>
            </li>
          </ul>
        </li>
        <li class="list-group-item">
        <k style="color: red;">YORUMLAR</k>          
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="yorumlarim.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="yorumlarim.php">YORUMLARIM</a>
              <span class="badge badge-danger badge-pill"><?= $yorumlarim_sayisi ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="tum_yorumlari_oku.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="../yorumlar.php">TÜM YORUMLARI OKU</a>
              <span class="badge badge-danger badge-pill"><?= $tum_yorum_sayisi ?></span>
            </li>
          </ul>
        </li>
        <li class="list-group-item">
        <k style="color: red;">AYARLAR</k>
        
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="profili_duzenle.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="profili_duzenle.php"> PROFİLİ DÜZENLE</a>
              <span class="badge badge-danger badge-pill"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="cayma_bedelleri.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="cayma_bedelleri.php">CAYMA BEDELLERİ</a>
              <span class="badge badge-danger badge-pill"><?= $cayma_sayisi ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php if(basename($url)=="sifre_degistir.php"){ echo 'border-bottom:1px solid red;';} ?>">
            <a class="alt_baslik" href="sifre_degistir.php"> ŞİFRE DEĞİŞTİR</a>
              <span class="badge badge-danger badge-pill"></span>
            </li>
            <?php if($kullanici_oku_sidebar["paket"] != 21){ ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a class="alt_baslik" href="islemler/gold_uyelik_basvuru.php?id=21">GOLD ÜYELİK BAŞVURU</a>
              <span class="badge badge-danger badge-pill"></span>
            </li>
            <?php } ?>
          </ul>
        </li>
      </ul>
      </div>