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
    $ihale_cek = mysql_query("SELECT * FROM ilanlar ORDER BY ihale_tarihi DESC");
    $dogrudan_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar");
    $dogrudan_satis_sayisi = mysql_num_rows($dogrudan_cek);
    $ihale_sayisi = mysql_num_rows($ihale_cek);
    $kullanici_cek = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$uye_token'");
    include 'template/sayi_getir.php';
    include 'alert.php';

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

      <!-- Bootstrap CSS -->
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
	.container
	{
		max-width:100%!important;
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
        <div class="col-sm-8" style="margin-top:5%;">
            <form method="POST" enctype="multipart/form-data">
            <?php include 'islemler/evrak_yukle.php'; ?>
              <!-- <div class="form-group">
                <input type="file" name="files[]" class="form-control-file" id="exampleFormControlFile1" multiple>
              </div> -->
              <div class="form-group">
                  <br/>
                  <text>Dosyaları seçmek için aşağıdaki alana tıklayabilir veya dosyaları alanın içine sürükleyebilirsiniz.</text>
                  <input  id="file_input" name="files[]" type="file" multiple>
              </div>
              <div class="form-group">
                <label for="IDofInput">Not</label>
                <textarea name="not" id="not" class="form-control" rows="4"></textarea>
              </div>
              <!-- <div class="form-group">
                <label for="IDofInput">Gizlilik</label>
                <select name="gizlilik" id="gizlilik" class="form-control">
                  <option value="1">Herkes görebilir (Tüm adminler görebilir)</option>
                  <option value="2">Sadece tam yetkililer görebilir.</option>
                  <option value="3">Sadece ben</option>
                </select>
              </div> -->
              <div class="row mt-5">
                <input type="submit" name="evragi" class="btn btn-primary" value="Yukle">
              </div>
            </form>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php include 'template/footer.php'; ?>
 


      <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
      <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
	     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	  	  <script src="../js/cikis_yap.js?v=<?php echo time(); ?>"></script>

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
				console.log(file);
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
		<script >
		 setInterval(function() {
   cikis_yap("<?=$uye_token?>");
 }, 300001);
		   son_islem_guncelle("<?=$uye_token?>");
	 setInterval(function(){ bildirim_sms(); }, 1000);
		</script>
   </body>
</html>