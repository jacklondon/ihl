<?php 
   session_start();
   include('../ayar.php');
     $token = $_SESSION['u_token'];
    if(!empty($token)){
      $uye_token = $token;
    }
    if(!isset($_SESSION['u_token'])){
      echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
      echo '<script>window.location.href = "../index.php"</script>';
      }
    $ihale_cek = mysql_query("SELECT * FROM ilanlar ORDER BY ihale_tarihi DESC");
    $dogrudan_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar");
    $dogrudan_satis_sayisi = mysql_num_rows($dogrudan_cek);
    $ihale_sayisi = mysql_num_rows($ihale_cek);
    $kullanici_cek = mysql_query("SELECT * FROM `user` WHERE user_token = '$uye_token'");
    include 'template/sayi_getir.php';
    include 'alert.php';
   
   ?>
<!doctype html>
<html lang="tr">
   <head>
      <link rel="stylesheet" href="../css/uye_panel.css?v=15">
      <link rel="stylesheet" href="css/menu.css">
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
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
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
         }   .deneme p{
	   margin-bottom:0px!important;
	   margin-top:0px!important;
	   margin-left:15px;
	   
	}

	.container
  {
    max-width:100%!important;
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
		<div style="text-align:center" class="row">
      <div class="col-sm-12" style="text-align:center; font-size: large; padding: 15px;">
				<?= $yaz['icerik'] ?>
			</div>
		</div>
	</nav>
<?php } ?>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark " style="padding-bottom: 0%; padding-top: 0%;">
         <div class="collapse navbar-collapse" id="navbarCollapse" >
  <ul class="navbar-nav mr-auto" >
      <li class="nav-item active" style="font-size: small;">
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
                  <?= $kullanici_oku['ad'] ?>
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
            <div class="col-sm-4">
            <?php include 'template/sidebar.php'; ?>
         </div>
            <div class="col-sm-8">
               <div class="table-responsive">
                  <table class="table table-bordered" style=" white-space: unser;">
                     <thead>
                        <tr style="background-color: rgb(229, 224, 236);">
                           <th scope="col">Detaylar</th>
                           <th scope="col">Yorum Ekleme Tarihi</th>
                           <th scope="col">Yorum </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
							$yorum_cek = mysql_query("SELECT * FROM yorumlar WHERE uye_id = '".$kullanici_oku['id']."' order by id desc");
							while($yorum_oku = mysql_fetch_array($yorum_cek)){       
                        ?>
                        <tr style="background-color: #ffffff;">
                           <td><?= $yorum_oku['arac_bilgileri'] ?></td>
                           <td><?= date('d-m-Y H:i:s',strtotime($yorum_oku['yorum_zamani'])) ?></td>
                           <td><?= $yorum_oku['yorum'] ?></td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <?php } ?>
      <?php include 'template/footer.php'; ?>
      <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
      <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
	  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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