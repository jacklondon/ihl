<?php
   session_start();
   include('../ayar.php');
    $token = $_SESSION['k_token'];
    if(!empty($token)){
      $uye_token = $token;
    }
    if(!isset($_SESSION['k_token'])){
      echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
      echo '<script>window.location.href = "../index.php"</script>';
      }
    $plaka = re('q');
    $durum = re('d');
   
    $sehir_cek = mysql_query("SELECT * FROM sehir ORDER BY plaka ASC");
    $kullanici_cek = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$uye_token'");
    include 'template/sayi_getir.php';
    include 'alert.php';
    $gelen_id = re('id');
	
   ?>
<!doctype html>
<html lang="tr">
   <head>
      <link rel="stylesheet" href="../css/uye_panel.css?v=15">
      <!-- Required meta tags -->
      <!-- <title>Pert &mdash; Dünyası</title> -->
      <?php
			include '../seo_kelimeler.php';
		?>
      <meta charset="utf-8">
      <meta http-equiv="content-language" content="tr">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="author" content="EA Bilişim">
      <meta name="Abstract" content="Pert Dünyası sigortadan veya sahibinden kazalı,hasarlı pert araçların
         online ihale ile veya doğrudan satış yapılabileceği online ihale platformudur.">
      <meta name="description" content="Pert Dünyası Pert Kazalı Araç İhale Sistemi">
      <meta name="keywords"
         content="hasarlı oto, hasarlı arabalar, hasarlı araçlar, pert araçlar, pert oto,
         pert arabalar, kazalı araçlar, kazalı oto, kazalı arabalar, hurda araçlar, hurda arabalar,
         hurda oto, hasarlı ve pert kamyon, hasarlı ve kazalı traktör, kazalı çekici, ihale ile satılan hasarlı araçlar,
         sigortadan satılık pert arabalar, ihaleli araçlar, kapalı ihaleli araçlar, açık ihalelli araçlar, 2.el araç,
         hurda kamyon, hurda traktör, ihaleyle kamyon" >
      <meta name="Copyright" content="Ea Bilişim Tüm Hakları Saklıdır.">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="js/il_ilce.js?v=2"></script>
      <script src="js/marka_model.js?v=2"></script>
      <!-- Bootstrap CSS -->
	  	  <script src="../js/ckeditor4/ckeditor.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <link rel="stylesheet" href="css/menu.css">
	  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <title>Pert Dünyası</title>
      <style>
         .uyelik{
         color: yellow !important;
         font-weight: bolder;
         }
         .alt_baslik{
         text-decoration: none !important;
         cursor: pointer;
         color: #000000;
         }
         .alt_baslik:hover{
         color: red;
         }
         .list-group-item{
         padding-bottom: 0px;
         }
         tr:nth-child(odd) {
         background-color: rgb(219,238,244);
         }
         table {
         border-collapse: collapse;
         width: 100%;
         margin-top:1%;
         }
         .kod{
         background-color: rgb(78,79,83);
         color: #ffffff;
         }
		.deneme p{
			margin-bottom:0px!important;
			margin-top:0px!important;
			margin-left:15px;
	   
		}
 
      </style>
   </head>
   <body>
   <?php 
   	$site_acilis_popup_icin_cek = mysql_query("select * from siteye_girenler WHERE ip_adresi = '".getIP()."'");
     $site_acilis_popup_icin_say = mysql_num_rows($site_acilis_popup_icin_cek);
     $site_acilis_popup_icin_oku = mysql_fetch_assoc($site_acilis_popup_icin_cek);
     $siteye_giris_tarih = date('Y-m-d H:i:s');
     $siteye_giris_tarih_before = date("Y-m-d H:i:s", strtotime('-24 hours',strtotime($siteye_giris_tarih)));
     $sitenin_acilis_popupunu_cek = mysql_query("select * from site_acilis_popup");
     $sitenin_acilis_popupunu_say = mysql_num_rows($sitenin_acilis_popupunu_cek);
     $sitenin_acilis_popupunu_oku = mysql_fetch_assoc($sitenin_acilis_popupunu_cek);
     $sitenin_acilis_popupu = $sitenin_acilis_popupunu_oku['icerik'];
	 		if($sitenin_acilis_popupunu_oku['durum']==1){
     if($site_acilis_popup_icin_say == 0){
          $siteye_giren_ekle = mysql_query("INSERT INTO `siteye_girenler` (`id`, `ip_adresi`, `tarih`, `durum`) VALUES (NULL, '".getIP()."', '".$siteye_giris_tarih."', '1');");
			if($sitenin_acilis_popupunu_oku['buton']==1){  
			   echo '
					<script>
						var htmlContent2 = document.createElement("div");
						htmlContent2.innerHTML = `
							'.$sitenin_acilis_popupu.'
						`;
						swal( {
							closeOnEsc: false,
							closeOnClickOutside: false,
							
							content:htmlContent2,
							buttons: {
								defeat: "Tamam",
							},
						})			
						.then((value) => {
							switch (value) {
								case "defeat": 
									
									break;            
								default:
									break;
							}
						});
					</script>	
				';			  
			   
			  //  echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
			  //  echo "<script>window.location.href = 'hazirlaniyor.php';</script>";
		   }else{
			   echo '
					<script>
						var htmlContent2 = document.createElement("div");
						htmlContent2.innerHTML = `
							'.$sitenin_acilis_popupu.'
						`;
						swal( {
							buttons: false,
							showCancelButton: false,
							content:htmlContent2,
						})			
						.then((value) => {
							window.location.href = "hazirlaniyor.php";
						});
					</script>
				';			  
			   // echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
				$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
		   }  
     }else{
          if($site_acilis_popup_icin_oku['tarih'] < $siteye_giris_tarih_before){
               if($sitenin_acilis_popupunu_oku['buton']==1){  
				   echo '
						<script>
							var htmlContent2 = document.createElement("div");
							htmlContent2.innerHTML = `
								'.$sitenin_acilis_popupu.'
							`;
							swal( {
								closeOnEsc: false,
								closeOnClickOutside: false,
								
								content:htmlContent2,
								buttons: {
									defeat: "Tamam",
								},
							})			
							.then((value) => {
								switch (value) {
									case "defeat": 
										
										break;            
									default:
										break;
								}
							});
						</script>	
					';			  
				    $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
                  //  echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
                  //  echo "<script>window.location.href = 'hazirlaniyor.php';</script>";
               }else{
				   echo '
						<script>
							var htmlContent2 = document.createElement("div");
							htmlContent2.innerHTML = `
								'.$sitenin_acilis_popupu.'
							`;
							swal( {
								buttons: false,
								showCancelButton: false,
								content:htmlContent2,
							})			
							.then((value) => {
								window.location.href = "hazirlaniyor.php";
							});
						</script>
					';			  
                   // echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
                   // $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
               }               
          }
          
     }
     }
      
$bugun = date("Y-m-d");
$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
while($yaz = mysql_fetch_array($sorgu)){
?>
<nav class="deneme" style="padding-bottom: 0%;width:100%; padding-top: 0%;color:<?= $yaz['yazi_renk']?>; background-color:<?= $yaz['arkaplan_renk'] ?>;padding: 0!important;">
<div class="col-sm-12" style="text-align:center; font-size: large; padding: 15px;">
					<div style="text-align:center" class="col-sm-12">
						<?= $yaz['icerik'] ?>
					</div>
				</div>
			</nav>
<?php } ?>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark " style="padding-bottom: 0%; padding-top: 0%;">
         <div class="collapse navbar-collapse" id="navbarCollapse" >
  <ul class="navbar-nav mr-auto" >
      <li class="nav-item active" style="font-size:small;">
      <?php while($kullanici_oku = mysql_fetch_array($kullanici_cek)){ 
       
		/*$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=1'); 
		$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
		$toplam_cayma = $toplam_getir['net'];
	  
		$toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=2'); 
		$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
		$toplam_borc_cayma = $toplam_getir['net'];
		$cayma=$toplam_cayma+toplam_borc_cayma;*/
		$aktif_cayma_toplam=mysql_query("
			SELECT 
				SUM(tutar) as toplam_aktif_cayma
			FROM
				cayma_bedelleri
			WHERE
				uye_id='".$kullanici_oku['id']."' AND
				durum=1
		");
		$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
		$iade_talepleri_toplam=mysql_query("
			SELECT 
				SUM(tutar) as toplam_iade_talepleri
			FROM
				cayma_bedelleri
			WHERE
				uye_id='".$kullanici_oku['id']."' AND
				durum=2
		");
		$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
		$borclar_toplam=mysql_query("
			SELECT 
				SUM(tutar) as toplam_borclar
			FROM
				cayma_bedelleri
			WHERE
				uye_id='".$kullanici_oku['id']."' AND
				durum=6
		");
		$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
		$cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_borclar["toplam_borclar"];
		
        $paket = $kullanici_oku['paket'];
        $paket_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$paket."'");
        $paket_oku = mysql_fetch_assoc($paket_cek);
        $paket_adi = $paket_oku['grup_adi'];
        if($paket == "1"){          
          $color = "#ffffff";          
        }elseif($paket == "22"){          
          $color = "green";
        }elseif($paket == "21"){
          $color = "yellow";
        }
		$limit_cek = mysql_query("SELECT * FROM teklif_limiti WHERE uye_id = '".$kullanici_oku['id']."'");
        $limit_oku = mysql_fetch_assoc($limit_cek);
		$limit = $limit_oku['standart_limit'];  
		if($limit==0){
			$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$paket."' order by cayma_bedeli asc");
			while($grup_oku=mysql_fetch_array($grup_cek)){
				if($cayma>=$grup_oku["cayma_bedeli"]){
					$limit = money($grup_oku["standart_ust_limit"])."₺ ";
				}
			}
			if($limit==0){
				$limit=$limit." ₺";
			}
			$limit_turu=" (Standart)";
		}else{		
			if($limit>1000000){
				$limit = "Sınırsız ";
				$limit_turu=" (Standart)";
			}else{
				$limit = money($limit_oku['standart_limit'])."₺ ";
				$limit_turu=" (Standart)";
			}
		}
		
		
		$limit2 = $limit_oku['luks_limit']; 
		if($limit2==0){
			$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$paket."' order by cayma_bedeli asc");
			while($grup_oku=mysql_fetch_array($grup_cek)){
				if($cayma>=$grup_oku["cayma_bedeli"]){
					$limit2 = money($grup_oku["luks_ust_limit"])."₺ ";
				}
			}
			if($limit2==0){
				$limit2=$limit2." ₺";
			}
			$limit_turu2=" (Ticari)";
		}else{
			if($limit2>1000000){
				$limit2 = "Sınırsız ";
				$limit_turu2=" (Ticari)";
			}else{
				$limit2 = money($limit_oku['luks_limit'])."₺ ";
				$limit_turu2=" (Ticari)";
			}
		}
      
      ?> 
          <a class="nav-link uyelik" style="font-weight: bold; color:<?= $color ?> !important;" ><b><?= mb_strtoupper($paket_adi,"utf-8") ?> ÜYE</b></a> 
      </li>
      <li class="nav-item active" style="font-size: small;">
        <a class="nav-link"><span style="color: #a4a4a4;" >Cayma Bakiyesi : </span>  <?= money($cayma) ?> ₺</a>
      </li>
      <li class="nav-item active" style="font-size: small;">
        <a class="nav-link" ><span style="color: #a4a4a4;" >Teklif Limiti : </span><?= $limit ?><span style="color: #a4a4a4;" ><?=$limit_turu ?> </span> <?=$limit2 ?> <span style="color: #a4a4a4;" ><?=$limit_turu2 ?> </span></a>
      </li>
    </ul>
            <ul class="navbar-nav" style="font-size: small;">
               <li class="nav-item active dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?= $kullanici_oku['unvan'] ?>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="position: absolute; transform: translate3d(90px, 10px, 0px); top: 15px; left: -190px; will-change: transform;">
                     <a class="dropdown-item" href="index.php">Üye Panelim</a>
                    	<?php if( $paket != "21"){ ?>
						<a class="dropdown-item" href="islemler/gold_uyelik_basvuru.php?id=21" >Gold Üyelik Başvurusu</a>
					<?php } ?>
               <?php 
								$sozlesmeyi_cek = mysql_query("select * from uyelik_pdf where id = 1");
								$sozlesmeyi_bas = mysql_fetch_object($sozlesmeyi_cek);
								if($_SESSION["u_token"] != ""){
									$uyelik_sozlesme = $sozlesmeyi_bas->bireysel_pdf;
								}else{
									$uyelik_sozlesme = $sozlesmeyi_bas->kurumsal_pdf;
								}
							?>
							<?php 
								$sozlesmeyi_cek = mysql_query("select * from uyelik_pdf where id = 1");
								$sozlesmeyi_bas = mysql_fetch_object($sozlesmeyi_cek);
								if($_SESSION["u_token"] != ""){
									$uyelik_sozlesme = $sozlesmeyi_bas->bireysel_pdf;
								}else{
									$uyelik_sozlesme = $sozlesmeyi_bas->kurumsal_pdf;
								}
							?>
							<a class="dropdown-item" href="../images/pdf/<?= $uyelik_sozlesme ?>" target="_blank">Üyelik Sözleşmesi Görüntüle</a>
					<?php 
						$kazanma_sorgula=mysql_query("select * from kazanilan_ilanlar where uye_id='".$kullanici_oku['id']."' ");
						if(mysql_num_rows($kazanma_sorgula)>0 && $paket == "21"){
						/*
							<a class="dropdown-item" href="https://ihale.pertdunyasi.com/pdf.php?id=1&uye_id=<?=$kullanici_oku['id']?>&q=vekaletname_pdf" target="_blank">Vekaletname Örneği Görüntüle(PDF)</a>
							<a class="dropdown-item" href="https://ihale.pertdunyasi.com/word.php?id=1&uye_id=<?=$kullanici_oku['id']?>&q=vekaletname_word" >Vekaletname Örneği Görüntüle(WORD)</a>
						*/
						?> 
							<?php $vekaletname_cek=mysql_fetch_object(mysql_query("select * from vekaletname_pdf")); ?>
							<a class="dropdown-item" href="https://ihale.pertdunyasi.com/<?=$vekaletname_cek->vekaletname ?>" target="_blank">Vekaletname Örneği Görüntüle(PDF)</a>
							<a class="dropdown-item" href="https://ihale.pertdunyasi.com/<?=$vekaletname_cek->vekaletname_word ?>"  target="_blank" >Vekaletname Örneği Görüntüle(WORD)</a>
						
					<?php } ?>
                     <a class="dropdown-item" href="evrak_yukle.php">Evrak Yükle</a>
                  </div>
               </li>
               <li class="nav-item active mr-0">
                  <a class="nav-link" href="islemler/logout.php"> Çıkış Yap</a>
               </li>
            </ul>
         </div>
      </nav>
      <?php  include 'template/header.php'; ?>
      <div class="container" style="margin-top:10%;">
         <div class="row">
            <div class="alert alert-primary" role="alert" style=" width:90%; margin-left: 5%;">
               Değerli üyemiz lütfen aracınıza tramer sorgusu yaparak gelen mesajdaki ekran görüntüsünü
               resimlere ekleyiniz.
            </div>
         </div>
         <div class="row">
            <div class="col-sm-4">
               <?php include 'template/sidebar.php'; ?>
            </div>
            <div class="col-sm-8">
               <?php if($gelen_id){
                  $araci_bul = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE id = '".$gelen_id."'");
                  ?>
               <?php while($araci_oku = mysql_fetch_array($araci_bul)){ ?>
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation" onclick="dogrudan_trigger('home-tab')">
                     <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Araç Bilgileri</a>
                  </li>
                  <li class="nav-item" role="presentation" onclick="dogrudan_trigger('profile-tab')">
                     <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Resimler</a>
                  </li>
               </ul>
               <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                     <form method="POST" name="form" id="form" enctype="multipart/form-data">
                        <?php include 'islemler/dogrudan_duzenle.php' ?>
                        <div class="container mb-5">
                           <div class="row">
                              <div class="col">
                                 <div class="form-group">
                                    <label for="IDofInput">Plaka</label>
                                    <input type="text" name="plaka" id="plaka" value="<?= $araci_oku['plaka'] ?>" class="form-control" style="text-transform: uppercase;" placeholder="01AA0000" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8" required />
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Aracın Şuanki Durumu</label>
                                    <select class="form-control" name="arac_durumu" id="arac_durumu">
                                       <option value="Kazalı (En Ufak Bir Onarım Görmemiş)" <?php if($araci_oku['aracin_durumu']=="Kazalı (En Ufak Bir Onarım Görmemiş)"){echo "selected";} ?>>Kazalı (En Ufak Bir Onarım Görmemiş)</option>
                                       <option value="Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)" <?php if($araci_oku['aracin_durumu']=="Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)"){echo "selected";} ?>>Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)</option>
                                       <option value="İkinci El (Pert Kayıtlı)" <?php if($araci_oku['aracin_durumu']=="İkinci El (Pert Kayıtlı)"){echo "selected";} ?>>İkinci El (Pert Kayıtlı)</option>
                                       <option value="İkinci El (Pert Kayıtsız)" <?php if($araci_oku['aracin_durumu']=="İkinci El (Pert Kayıtsız)"){echo "selected";} ?>> İkinci El (Pert Kayıtsız)</option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Şehir</label>
                                    <select class="form-control" name="sehir" id="sehir">
                                       <option value="">Şehir seçin</option>
                                       <?php
                                          while($sehir_oku = mysql_fetch_array($sehir_cek)){
                                          ?>
                                       <option value="<?=$sehir_oku["sehirID"]?>"<?php if($araci_oku['sehir']==$sehir_oku['sehiradi']){ echo "selected"; } ?> ><?=$sehir_oku["sehiradi"];?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">İlçe</label>
                                    <select class="form-control" name="ilce" id="ilce" >
                                       <option value="<?= $araci_oku['ilce'] ?>" ><?= $araci_oku['ilce'] ?></option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Yakıt Tipi</label>
                                    <select class="form-control" name="yakit_tipi" id="yakit_tipi">
                                       <option value="">Seçiniz</option>
                                       <option value="Benzinli" <?php if($araci_oku['yakit_tipi']=="Benzinli"){echo "selected"; } ?> >Benzinli</option>
                                       <option value="Benzin+Lpg" <?php if($araci_oku['yakit_tipi']=="Benzin+Lpg"){echo "selected"; } ?>>Benzin+Lpg</option>
                                       <option value="Dizel" <?php if($araci_oku['yakit_tipi']=="Dizel"){echo "selected"; } ?>>Dizel</option>
                                       <option value="Hybrit" <?php if($araci_oku['yakit_tipi']=="Hybrit"){echo "selected"; } ?>>Hybrit</option>
                                       <option value="Elektrikli" <?php if($araci_oku['yakit_tipi']=="Elektrikli"){echo "selected"; } ?>>Elektrikli</option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Vites Tipi</label>
                                    <select class="form-control" name="vites_tipi" id="vites_tipi">
                                       <option value="">Seçiniz</option>
                                       <option value="Düz Vites" <?php if($araci_oku['vites_tipi']=="Düz Vites"){echo "selected"; } ?> >Düz Vites</option>
                                       <option value="Otomatik Vites" <?php if($araci_oku['vites_tipi']=="Otomatik Vites"){echo "selected"; } ?> >Otomatik Vites</option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Evrak Tipi</label>
                                    <select class="form-control" name="evrak_tipi" id="evrak_tipi">
                                       <option value="">Seçiniz..</option>
                                       <option value="Plakalı Ruhsatlı" <?php if($araci_oku['evrak_tipi']=="Plakalı Ruhsatlı"){echo "selected"; } ?> >Plakalı Ruhsatlı</option>
                                       <option value="Çekme Belgeli" <?php if($araci_oku['evrak_tipi']=="Çekme Belgeli"){echo "selected"; } ?> >Çekme Belgeli</option>
                                       <option value="Hurda Belgeli" <?php if($araci_oku['evrak_tipi']=="Hurda Belgeli"){echo "selected"; } ?> >Hurda Belgeli</option>
                                    </select>
                                 </div>
                              </div>
                              <?php 
                                 $hasarlar=$araci_oku["hasar_durumu"];
                                 $hasar_parcala_parcala=explode("|",$hasarlar);
                                 ?>
                              <div class="col">
                                 <div class="form-group">
                                    <label for="IDofInput">Hasar Durumu (Bir veya daha fazla işaretlenebilir)</label><br>
                                    <input type="checkbox" name="hasar[]" value="1" <?php if (in_array(1, $hasar_parcala_parcala)){ echo "checked";} ?>>Çarpma, Çarpışma<br>
                                    <input type="checkbox" name="hasar[]" value="2" <?php if (in_array(2, $hasar_parcala_parcala)){ echo "checked";} ?>>Teknik Arıza<br>
                                    <input type="checkbox" name="hasar[]" value="3" <?php if (in_array(3, $hasar_parcala_parcala)){ echo "checked";} ?>>Sel/Su Hasarı<br>
                                    <input type="checkbox" name="hasar[]" value="4" <?php if (in_array(4, $hasar_parcala_parcala)){ echo "checked";} ?>>Yanma Hasarı<br>
                                    <input type="checkbox" name="hasar[]" value="5" <?php if (in_array(5, $hasar_parcala_parcala)){ echo "checked";} ?>>Çalınma<br>
                                    <input type="checkbox" name="hasar[]" value="6" <?php if (in_array(6, $hasar_parcala_parcala)){ echo "checked";} ?>>Diğer<br>
                                    <input type="checkbox" name="hasar[]" value="7" <?php if (in_array(7, $hasar_parcala_parcala)){ echo "checked";} ?>>Hasarsız
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Marka</label>
                                    <select class="form-control" name="marka" id="marka" reuqired>
                                       <option value="">Seçiniz</option>
                                       <?php $marka_cek = mysql_query("SELECT * FROM marka"); while($marka_oku = mysql_fetch_array($marka_cek)){ ?>
                                       <option value="<?=$marka_oku['markaID'] ?>" <?php if($araci_oku['marka']==$marka_oku['marka_adi']){ echo "selected"; } ?> ><?=$marka_oku['marka_adi'] ?></option>
                                       <?php } ?>
                                    </select>
                                    <label for="IDofInput">Model</label>
                                    <select class="form-control" name="model" id="model" required>
                                       <option value="<?= $araci_oku['model'] ?>" ><?= $araci_oku['model'] ?></option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Model Yılı</label>
									  <?php $anlik_yil=date('Y'); ?>
                                    <input type="number" class="form-control" value="<?= $araci_oku['model_yili'] ?>" name="model_yili" maxLength="4" min="1950" max="<?= $anlik_yil; ?>">
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Model Uzantıları</label>
                                    <input type="text" class="form-control" name="uzanti" value="<?= $araci_oku['uzanti'] ?>"  style="text-transform:uppercase"  id="uzanti" placeholder="1.6 DCI Expression vb.">
                                    <small class="form-text text-muted">Paket Silindir Hacmi bilgileri yazınız</small>
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Kilometre (KM)</label>
                                    <input class="form-control" value="<?= $araci_oku['kilometre'] ?>" type="number" name="kilometre">
                                 </div>
                                 <div class="form-group">
                                    <label for="IDofInput">Satış Fiyat (₺)</label>
                                    <input class="form-control" type="number" value="<?= $araci_oku['fiyat'] ?>" name="satis_fiyati">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group" style="width:100% !important;">
                                 <label for="IDofInput">Araç hangi adresten teslim ediiecek adres ve yetkili kişi tel bilgilerini giriniz.</label>
                                 <textarea name="aracin_adresi" id="aracin_adresi" class="form-control"  rows="4"> <?= $araci_oku['aracin_adresi'] ?></textarea>
                              </div>
                              <div class="form-group" style="width:100% !important;">
                                 <label for="IDofInput">Açıklamalar (Lütfen alıcılar için gerekli her şeyi anlatınız.)</label>
                                 <textarea name="aciklamalar" id="aciklamalar" class="form-control" rows="8" > <?= $araci_oku['aciklamalar'] ?></textarea>
                              </div>
                              <!-- <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                 </div>
                                 <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="resim[]" multiple>
                                    <label class="custom-file-label" for="inputGroupFile01">Eklemek İstediğiniz Yeni Resimleri Seçin</label>
                                 </div>
                              </div> -->
                           </div>
                           <div class="row">
                              <input type="submit" class="btn btn-primary" name="dogrudan_guncellemeyi" value="Kaydet">
                           </div>
                        </div>
                     </form>
                  </div>
                  <?php $dogrudan_resim_cek = mysql_query("SELECT * FROM dogrudan_satisli_resimler WHERE ilan_id = '".$gelen_id."'"); ?>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form method="POST" name="form" id="form" enctype="multipart/form-data">
                           <?php include 'islemler/dogrudan_resim_duzenle.php' ?>
                           <div class="row mt-3">
                              <div class="input-group mb-3">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                 </div>
                                 <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="resim[]" multiple>
                                    <label class="custom-file-label" for="inputGroupFile01">Eklemek İstediğiniz Yeni Resimleri Seçin</label>
                                 </div>
                              </div>
                              </div>
                              <div class="row">
                                 <input type="submit" class="btn btn-primary" name="dogrudan_resimleri" value="Kaydet">
                              </div>
                        </form>
                     <div class="row">
                     <?php while($dogrudan_resim_oku = mysql_fetch_array($dogrudan_resim_cek)){ ?>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                     <div class="card" style="width: 10rem; margin-top:5px;">
                        <img src="../images/<?= $dogrudan_resim_oku['resim'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                           <a href="islemler/data_sil.php?id=<?= $dogrudan_resim_oku['id'] ?>&q=dogrudan_resim_sil&g=<?= $gelen_id ?>" class="card-link"><button type="button" class="btn btn-danger btn-block">Sil</button></a>
                        </div>
                     </div>
                     </div>
                     <?php } ?>
                     </div>
                  </div>
               </div>
               <?php } ?>
               <?php } ?>
            </div>
         </div>
      </div>
      <?php } ?>
      <?php include 'template/footer.php'; ?>
      <script>
         function boslukEngelle() {
             if (event.keyCode == 32) {
                 return false;
             }
         }
      </script>
      <script>
         window.onload = TriggerVarMi;
         function TriggerVarMi() {
            var trigger_sor = localStorage.getItem('uye_panel_dogrudan_trigger');
            if(trigger_sor != "" && trigger_sor != null && trigger_sor != undefined){
               document.getElementById(trigger_sor).click();	
            }
         }
         function dogrudan_trigger(item){
            localStorage.setItem('uye_panel_dogrudan_trigger',item);
         }
      </script>
	  <script>

		CKEDITOR.replace( 'aciklamalar', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
	</script>
      <script>
         var input = document.getElementById('plaka');
         input.oninvalid = function(event) {
         event.target.setCustomValidity('Lütfen plakayı düzgün yazın.');
         }
      </script>
      <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
      <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	  	  <script src="../js/cikis_yap.js?v=<?php echo time(); ?>"></script>
		<script >
		 setInterval(function() {
   cikis_yap("<?=$uye_token?>");
 }, 300001);
		   son_islem_guncelle("<?=$uye_token?>");
		   setInterval(function(){ bildirim_sms(); }, 1000);
	
		</script>
   </body>
</html>