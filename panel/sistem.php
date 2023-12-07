<?php 
	session_start();
	
	include("ayar.php");
	$admin_id=$_SESSION['kid'];
	//include('assets/ckeditor5');
	$modul_is = false;
	
	if(re('sayfa') == "") { $modul_is = true; }
	if(re('sayfa') == "index") { $modul_is = true; }
	if(re('modul') == "istatistikler") { $modul_is = true; }
	
	if($modul_is == true)
	{
		include("genel_moduller.php");
	}
	
	if ( $_SESSION['kid'] == "" )
	{
		header("Location: index.php");
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--[if IE 8]> <html lang="tr" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="tr" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="tr"> <!--<![endif]-->
<head>
	<?php include("head.php"); ?>
	<link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  
	

	<!-- <link rel="stylesheet" href="assets/summernote/summernote-bs4.min.css"> -->
</head>
<body class="fixed-top" >
<style>
	.custom-large-modal
	{
		width:80%!important;
		left:10%!important;
		margin-left:0px!important;
	}	
	
	.custom-large-modal .modal-body
	{
		width: 100%!important;
		float: left!important;
		box-sizing: border-box!important;
		margin-top: 30px!important;
		/* max-height:calc(100vh - 170px); */
		max-height:calc(100vh - 210px);
	}
	@media only screen and (min-width: 1600px) {
		.custom-large-modal .modal-body
		{
			max-height:calc(100vh - 300px)!important;
		}
	}
	input:focus
	{
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}	
	.ckeditor_focus
	{
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}

	.b-label {
		margin:1em;
		display: inline-block;
		padding:.25em;
	}
	.d-label {
		display: inline-block;
		padding:.05em;
		width: 100%;
	}

	.b-label:focus-within {
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}
	.d-label:focus-within {
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}


	input[type=checkbox]:focus
	{
		-webkit-box-shadow:none!important; 
		box-shadow: none!important;
		border-color:none!important;
	}
	input[type=radio]:focus
	{
		-webkit-box-shadow:none!important; 
		box-shadow: none!important;
		border-color:none!important;
	}
	select:focus
	{
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}
	textarea:focus
	{
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}

	table.dataTable
	{
		width:100%!important;
	}
</style>
<script>
function playSound() {
	//swal("Hello world!");
}
setInterval(function(){ 
jQuery.ajax({
	url: "bildirim.php",
	type: "POST",
	dataType: "JSON",
	data: {
		action: "teklif_say", 
	},
	success: function(response) { 
		jQuery.each(response.data, function(index, value) {  
			var teklifler = localStorage.getItem("aktif_teklif_sayisi");
			if(value.ilan_sayisi > teklifler){
				var audio = document.getElementById("audio");
				audio.play();
		}
		});
	},
}); 
}, 100000);
 setInterval(function(){ 
    jQuery.ajax({
        url: "bildirim.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "teklif_say", 
        },
        success: function(response) { 
			jQuery.each(response.data, function(index, value) {  					
					localStorage.setItem("aktif_teklif_sayisi",value.ilan_sayisi);
			});
        },
    });  
 }, 1500000);

	

</script> 


	<div id="submit_st"></div>
		<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<form method="POST" name="form" id="form" enctype="multipart/form-data">		
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="index.php">
					<img src="images/pert_logo.png" alt="logo" style="height:26px;" />
				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
					<img src="assets/img/menu-toggler.png" alt="" />
				</a>
				<input style="margin-top:5px" type="text" id="navbar_aranan" name="navbar_aranan" placeholder="Araç kodu veya plaka giriniz." >		
				<button class="button btn-primary"  style="width:45px;height:30px;margin-bottom:5px;border:none" type="button" onclick="navbar_searchle();" >Ara</button>	
				<!-- END RESPONSIVE MENU TOGGLER -->				
				<!-- BEGIN TOP NAVIGATION MENU -->	
				
				<ul class="nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->	
					<?php /* echo $bildirim_durum; */ ?>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN INBOX DROPDOWN -->
					<?php /* echo $mesaj_durum; */ ?>
					<!-- END INBOX DROPDOWN -->
					<!-- BEGIN TODO DROPDOWN -->
					<?php /* echo $server_durum; */ ?>
					
					<?php /* echo $resim_deposu; */ ?>
					
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					
					<img onclick="playAudio('bildirim.mp3')">
					
					<?php 
					$admin_id=$_SESSION['kid'];
					$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
					$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
				   
					$yetkiler=$admin_yetki_oku["yetki"];
				   
					$yetki_parcala=explode("|",$yetkiler);
				
					if (count($yetki_parcala) != 13  ) { 
						$admin_prfl_btn = '';
					}else{
						$admin_prfl_btn = '<li><a href="?modul=admin&sayfa=admin_ekle&id='.$admin_id.'"><i class="icon-user"></i> Profiliniz</a></li>';
					}
					?>
					<li style="margin-top:5px;" >
						<text style="color:#fff;" ></text>
					</li>
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="username"><?= $admin_yetki_oku["adi"]." ".$admin_yetki_oku["soyadi"] ?> / <?= $admin_yetki_oku["tel"] ?></span>
						<?php if ($kullanici_oku['resim']!="") {?>
						<img alt="" src="images/kullanicilar/<?php echo $kullanici_oku['resim']; ?>" style="width:29px; height:29px; "/>
						<?php } else { ?>
						<i class="icon-user icon-white"></i>
						<?php } ?>
						
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<?= $admin_prfl_btn ?>
							<!-- <li><a href="calendar.html"><i class="icon-calendar"></i> Ajandanız</a></li> -->
							<!-- <li><a href="#"><i class="icon-tasks"></i> Görev Listeniz</a></li> -->
							<li class="divider"></li>
							<li><a href="?sayfa=cikis"><i class="icon-key"></i> Çıkış</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->	
			</div>
		</div>
		</form>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	
	<?php 
	
		
		$ust_menu = "";
		$sayi = 0;
		$sayi_alt = 0;
		$menu_cek = mysql_query("select * from p_menu where durum!='0' and kategori='0' ORDER BY sira ASC");
		while($menu_oku = mysql_fetch_array($menu_cek))
		{
			$secilmis1='';
			$secilmis2='';
			$secilmis3='';
			$alink='?modul='.$menu_oku['modul'].'&sayfa='.$menu_oku['sayfa'].'';
			
			$bas = true;
			$alt_menuler='';
			if($bas == true)
			{
				
				
				$alt_kat_cek = mysql_query("select * from p_menu where durum!='0' and kategori='".$menu_oku['id']."' ORDER BY sira ASC");
				$alt_kat_sayi = mysql_num_rows($alt_kat_cek);
				if($alt_kat_sayi != 0)
				{
					
			
					$alink='javascript:;';
					$secilmis1='has-sub ';
					
					$secilmis2='<span class="selected"></span>';
					$secilmis3='<span class="arrow"></span>';
					
					if ($menu_oku['modul'] == re('modul') ) { $secilmis1.=' active '; $secilmis3='<span class="arrow open"></span>';}
						
					$uyeler = mysql_query("select * from user");					
					$uye_Sayisi = mysql_num_rows($uyeler);
					$online = mysql_query("select * from user where online_durum = 1");
					$onlineler = mysql_num_rows($online);
					$gold_talepleri = mysql_query("select * from gold_uyelik_talepleri where durum=0");
					$gold_talep = mysql_num_rows($gold_talepleri);
					$evrak_yukleyenler = mysql_query("select * from yuklenen_evraklar");
					$evraklar = mysql_num_rows($evrak_yukleyenler);
					//$cayma_talepleri = mysql_query("SELECT * FROM cayma_bedelleri WHERE durum=3");
					$cayma_talepleri = mysql_query("SELECT * FROM cayma_bedelleri");
					$cayma_talep = mysql_num_rows($cayma_talepleri);
					
					$ihalesi_bitenleri_cek = mysql_query("SELECT * FROM ilanlar WHERE CONCAT_WS('', ihale_tarihi, ihale_saati) <= '".date('Y-m-d H:i:s')."' ORDER BY ihale_saati DESC");
					$ihalesi_bitenler = mysql_num_rows($ihalesi_bitenleri_cek);
					
					$son_teklifleri_cek = mysql_query("select * from teklifler as t1 WHERE durum=1 and teklif_zamani=(select max(teklif_zamani) from teklifler as t2 where t1.ilan_id=t2.ilan_id)group by ilan_id order by teklif_zamani desc");
					$son_teklifler = mysql_num_rows($son_teklifleri_cek);
					$statu_bekleyenleri = mysql_query("select distinct ilan_id from kazanilan_ilanlar where durum=0");
					$statuler = mysql_num_rows($statu_bekleyenleri);
					$dogrudan_satislilar = mysql_query("select * from dogrudan_satisli_ilanlar");
					$dogrudanlar = mysql_num_rows($dogrudan_satislilar);
					$uyelerin_ihaleleri = mysql_query("select * from ilanlar where ihale_sahibi != ''");
					$uye_ihale = mysql_num_rows($uyelerin_ihaleleri);
					$uyelerin_dogrulari = mysql_query("select * from dogrudan_satisli_ilanlar where ilan_sahibi !='' ");
					$uye_dogrular = mysql_num_rows($uyelerin_dogrulari);
					$uyelerden_gelenler = $uye_ihale + $uye_dogrular;
					$son_islemdekiler = mysql_query("select * from kazanilan_ilanlar where durum = 2");
					$son_islemler = mysql_num_rows($son_islemdekiler);
					$odeme_bekleyenlerrr = mysql_query("select * from kazanilan_ilanlar where durum = 1");
					$odeme_bekleyenler = mysql_num_rows($odeme_bekleyenlerrr);
					$onay_bekleyenlerrr = mysql_query("select * from kazanilan_ilanlar where durum = 0");
					$onay_bekleyenler = mysql_num_rows($onay_bekleyenlerrr);
					$iptal_edilenler = mysql_query("select * from kazanilan_ilanlar where durum = 4");
					$iptaller = mysql_num_rows($iptal_edilenler);
					$satilanlarr = mysql_query("select * from kazanilan_ilanlar where durum = 3");
					$satilanlar = mysql_num_rows($satilanlarr);
					$satilan_araclar = mysql_query("select * from satilan_araclar");
					$satilan_araclarr = mysql_num_rows($satilan_araclar);
					$sigorta_sirketleri = mysql_query("select * from sigorta_ozellikleri");
					$sig_sir_say = mysql_num_rows($sigorta_sirketleri);
					$uye_gruplari_cek = mysql_query("select * from uye_grubu");
					$uye_gruplari = mysql_num_rows($uye_gruplari_cek);
					$sss_cek = mysql_query("select * from sss");
					$sss = mysql_num_rows($sss_cek);
					$duyuru_cek = mysql_query("select * from duyurular");
					$duyurular = mysql_num_rows($duyuru_cek);
					$adminler_cek = mysql_query("select * from kullanicilar");
					$adminler = mysql_num_rows($adminler_cek);
					$yorumlar_cek = mysql_query("select * from yorumlar");
					$yorum_sayi = 0;
					while($yorumlar_oku = mysql_fetch_object($yorumlar_cek)){
						$ilan_cekkkkk = mysql_query("select * from ilanlar where id = '".$yorumlar_oku->ilan_id."' limit 1");
						while($ilan_okuuuuu = mysql_fetch_array($ilan_cekkkkk)){
							$yorum_sayi += 1;
						}
					}
					// $yorumlar = mysql_num_rows($yorumlar_cek);
					//$iade_cek = mysql_query("select * from cayma_bedelleri where durum = 4");
					$iade_cek = mysql_query("select * from cayma_bedelleri where durum = 4");
					$iadeler = mysql_num_rows($iade_cek);
					// $uyelerim_cek = mysql_query("select * from user where temsilci_id = '".$_SESSION["kid"]."'");
					$uyelerim_cek = mysql_query("SELECT user.*,onayli_kullanicilar.id as o_id FROM `user` inner join onayli_kullanicilar on user.id=onayli_kullanicilar.user_id where onayli_kullanicilar.durum=1 and user.temsilci_id='".$admin_id."' order by id desc");
					$uyelerim = mysql_num_rows($uyelerim_cek);
					$odeme_beklediklerim=0;
					while($uyelerim_oku = mysql_fetch_array($uyelerim_cek)){
						$uyelerim_id = $uyelerim_oku['id'];
						$odeme_beklediklerim_cek = mysql_query("select * from kazanilan_ilanlar where uye_id = '".$uyelerim_id."' and durum=1");
						if(mysql_num_rows($odeme_beklediklerim_cek)!=0){
							$odeme_beklediklerim++;
						}
						
					}
					
					$gun_sonu = date('Y-m-d 23:59:59');
					$gun_basi = date('Y-m-d 00:00:00');
					$performans_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".$gun_basi."' AND '".$gun_sonu."'");
					$performans_say = mysql_num_rows($performans_cek);
					$admin_mesajlar=mysql_query("select * from mesajlar where alan_id=0 and durum=0");
					$amin_mesaj_sayisi=mysql_num_rows($admin_mesajlar);


					$sayi++;
					$sayi_alt++;
					$alt_menuler .= '<ul class="sub">';
					$degisken = '';

					$admin_id = $_SESSION['kid'];
					$destek_bekleyen_say = mysql_num_rows(mysql_query("select ilanlar.*,mesajlar.gonderme_zamani from ilanlar inner join mesajlar on (mesajlar.ilan_id=ilanlar.id and mesajlar.gonderme_zamani>NOW() - INTERVAL 3 DAY) 
					inner join user on (mesajlar.gonderen_token=user.user_token or mesajlar.gonderen_token=user.kurumsal_user_token ) where user.temsilci_id='".$admin_id."' group by ilanlar.id"));
					$uyelerimin_aldiklari_say = mysql_num_rows(mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE user.temsilci_id='".$admin_id."'"));
					$primlerim_say = mysql_num_rows( mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
					WHERE prm_notlari.durum=1 AND satilan_araclar.prim > 0 AND user.temsilci_id='".$admin_id."' $order_by "));
					// $ihale_biten_say = mysql_num_rows(mysql_query("SELECT * FROM ilanlar WHERE CONCAT_WS('', ihale_tarihi, ihale_saati) <= '".date('Y-m-d H:i:s')."' and durum=-1 ORDER BY ihale_tarihi asc "));
					$ihale_biten_say = mysql_num_rows(mysql_query("SELECT * FROM ilanlar WHERE concat(ihale_tarihi, ' ', ihale_saati) <= '".date('Y-m-d H:i:s')."' and durum=-1  ORDER BY ihale_tarihi DESC, ihale_saati DESC "));
					$son_teklif_say = mysql_num_rows(mysql_query("SELECT ilanlar.*,t.teklif_zamani FROM ilanlar INNER JOIN (SELECT t1.* FROM teklifler as t1 WHERE t1.durum=1 and t1.teklif_zamani=(SELECT t2.teklif_zamani FROM 
					teklifler as t2 WHERE t1.ilan_id=t2.ilan_id ORDER BY t2.teklif_zamani DESC LIMIT 1) ) as t ON ilanlar.id = t.ilan_id and t.durum = 1 ORDER BY t.teklif_zamani DESC"));

					// $bugun_bitenleri_cek = mysql_query("select * from ilanlar where ihale_tarihi = '".date('Y-m-d')."' and ihale_saati > date('H:i:s')");
					$bugun = date("Y-m-d");
					$bugun_bitenleri_cek = mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '$bugun' and ihale_saati > '".date('H:i:s')."' ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc ");
					$bugun_bitenler = mysql_num_rows($bugun_bitenleri_cek);
					$yarin = date("Y-m-d",strtotime('+1 days'));
					$yarin_bitenleri_cek = mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '$yarin'");
					$yarin_bitenler = mysql_num_rows($yarin_bitenleri_cek);
					$tum_ihaleler_cek = mysql_query("select * from ilanlar where durum = 1");
					$tum_ihaleler = mysql_num_rows($tum_ihaleler_cek);
					$bugun_eklenenleri = mysql_query("SELECT * FROM ilanlar WHERE DATE(eklenme_zamani) = '".date("Y-m-d")."'");
					$bugun_eklenenler = mysql_num_rows($bugun_eklenenleri);
					$statu_bekleyen_say = mysql_num_rows(mysql_query("SELECT ilanlar.*,t.teklif_zamani,t.ilan_id,t.durum as teklif_durum,t.uye_id FROM ilanlar INNER JOIN ( SELECT * FROM teklifler as t1 WHERE teklif_zamani=( SELECT teklif_zamani FROM 
					teklifler as t2 WHERE t1.ilan_id=t2.ilan_id and t2.durum=1 order by teklif_zamani  desc limit 1 ) AND t1.uye_id!='283' and t1.durum=1 GROUP BY ilan_id ORDER BY teklif_zamani DESC ) as t ON ilanlar.id = t.ilan_id
					WHERE ilanlar.durum=-1 and ilanlar.ihale_turu=1 "));
					$bugun = date('Y-m-d 23:59:59');
					$bugun_bas = date('Y-m-d 00:00:00');
					$performanslar_sayi = mysql_num_rows(mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani > '".$bugun_bas."' AND ekleme_zamani < '".$bugun."'  GROUP BY admin_id order by ekleme_zamani desc"));
					$dogrudan_sayi = mysql_num_rows(mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND bitis_tarihi > '".date("Y-m-d H:i:s")."' order by bitis_tarihi asc"));
					
					// $uye_ilanlari_sayi = mysql_num_rows(mysql_query("select * from ilanlar where ihale_sahibi != '' order by id desc"));
					$uye_ihale_ilan_say = mysql_num_rows(mysql_query("select * from ilanlar where ihale_sahibi != '' order by id desc"));
					$uye_dogrudan_ilan_say = mysql_num_rows(mysql_query("select * from dogrudan_satisli_ilanlar where ilan_sahibi !='' order by id desc"));
					$uye_ilanlari_sayi = $uye_ihale_ilan_say + $uye_dogrudan_ilan_say;
					
					// $mesajlar_sayi = mysql_num_rows(mysql_query("select ilanlar.* from ilanlar inner join mesajlar on mesajlar.ilan_id=ilanlar.id and mesajlar.alan_id='0' and mesajlar.durum=0 group by ilanlar.id"));
					$mesajlar_sayi = mysql_num_rows(mysql_query("select ilanlar.* from ilanlar inner join mesajlar on mesajlar.ilan_id=ilanlar.id group by ilanlar.id"));
					$onay_bekleyen_sayi = mysql_num_rows(mysql_query("select * from teklifler where durum = 2 order by teklif_zamani desc"));
					$son_islem_sayi = mysql_num_rows(mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 2"));
					$odeme_bekleyen_sayi = mysql_num_rows(mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 1"));
					$onay_bekleyen_sayi = mysql_num_rows(mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 0"));
					$iptal_edilen_sayi = mysql_num_rows(mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 4"));
					$satilan_sayi = mysql_num_rows(mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 3"));
					$tum_uyeler_sayi = mysql_num_rows(mysql_query("SELECT user.*,onayli_kullanicilar.id as o_id FROM `user` inner join onayli_kullanicilar on user.id=onayli_kullanicilar.user_id where onayli_kullanicilar.durum=1 order by id desc"));
					$son_bes=date("Y-m-d H:i:s",strtotime("-5 minutes"));
					$now=date("Y-m-d H:i:s");
					$aktif_uyeler_sayi = mysql_num_rows(mysql_query("SELECT user.*,onayli_kullanicilar.id as o_id FROM `user` inner join onayli_kullanicilar on user.id=onayli_kullanicilar.user_id where user.son_islem_zamani between '".$son_bes."' and '".$now."' and onayli_kullanicilar.durum=1 order by id desc"));
					$ziyaret_tarih=date("Y-m-d H:i:s",strtotime("-5 minutes"));
					$ziyaret_tarih2=date("Y-m-d H:i:s");
					$ziyaretci_sayi = mysql_num_rows(mysql_query("SELECT * FROM ziyaretciler where tarih between '".$ziyaret_tarih."' and '".$ziyaret_tarih2."'"));
					$talep_now = date('Y-m-d H:i:s');
					$talep_tarih = date("Y-m-d H:i:s", strtotime('-7 days',strtotime($talep_now)));
					$gold_talep_sayi = mysql_num_rows(mysql_query("SELECT * FROM gold_uyelik_talepleri WHERE basvuru_tarihi > '".$talep_tarih."' ORDER BY id DESC"));
					$evrak_yukleyen_sayi = mysql_num_rows(mysql_query("SELECT * FROM yuklenen_evraklar group by gonderme_zamani ORDER BY id DESC"));
					$cayma_iade_istek_sayi = mysql_num_rows(mysql_query("SELECT * FROM cayma_bedelleri WHERE durum=2"));
					$sms_rapor_sayi = mysql_num_rows(mysql_query("Select * from sms_kaydet order by id desc "));
					$dogrulanmayan_sayi = mysql_num_rows(mysql_query("SELECT user.*,onayli_kullanicilar.id as o_id FROM `user` inner join onayli_kullanicilar on user.id=onayli_kullanicilar.user_id where onayli_kullanicilar.durum=0 order by id desc"));
					$satilan_sayi = mysql_num_rows(mysql_query("SELECT * FROM satilan_araclar"));
					$cayma_iade_sayi = mysql_num_rows(mysql_query("
						SELECT
							cayma_bedelleri.*,
							user.id as user_id,
							user.unvan as user_unvan,
							user.ad as user_ad,
							user.user_token as user_token,
							user.kurumsal_user_token as kurumsal_user_token,
							uye_grubu.grup_adi as user_paket
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=1
						ORDER BY
							paranin_geldigi_tarih desc
					"));
					$sigorta_sirket_sayi = mysql_num_rows(mysql_query("SELECT * FROM sigorta_ozellikleri"));
					$uye_grubu_sayi = mysql_num_rows(mysql_query("SELECT * FROM uye_grubu"));
					$sss_sayi = mysql_num_rows(mysql_query("SELECT * FROM sss order by id asc"));

					$dirname_gorsel = "../images/";
					$images_gorsel = glob($dirname_gorsel."*.png");
					$tum_gorsel_sayi = count($images_gorsel);
					$duyurular_sayi = mysql_num_rows(mysql_query("SELECT * FROM duyurular"));
					$slider_sayi = mysql_num_rows(mysql_query("SELECT * FROM slider"));
					$referans_sayi = mysql_num_rows(mysql_query("SELECT * FROM referans"));
					$admin_sayi = mysql_num_rows(mysql_query("SELECT * FROM kullanicilar"));
					// $yorum_sayi = mysql_num_rows(mysql_query("SELECT * FROM yorumlar"));
					
					
					//Alt menülerin getirildiği alan
					while($alt_kat_oku = mysql_fetch_array($alt_kat_cek))
					{
						$alt_kat = $alt_kat_oku["id"];
						

						$class='';
						$say++;
					
						if($alt_kat == 50){
							$degisken = $uyelerim;
						}elseif($alt_kat == 51){
							$degisken=$odeme_beklediklerim;
						}elseif($alt_kat == 52){
							$degisken=$destek_bekleyen_say;
						}elseif($alt_kat == 53){
							$degisken=$uyelerimin_aldiklari_say;
						}elseif($alt_kat == 54){
							$degisken=$primlerim_say;
						}elseif($alt_kat == 12){
							$degisken=$bugun_bitenler;
						}elseif($alt_kat == 13){
							$degisken=$yarin_bitenler;
						}elseif($alt_kat == 14){
							$degisken=$tum_ihaleler;
						}elseif($alt_kat == 15){
							$degisken=$ihale_biten_say;
						}elseif($alt_kat == 16){
							$degisken=$bugun_eklenenler;
						}elseif($alt_kat == 17){
							$degisken=$son_teklif_say;
						}elseif($alt_kat == 18){
							$degisken=$statu_bekleyen_say;
						}elseif($alt_kat == 19){
							$degisken=$performanslar_sayi;
						}elseif($alt_kat == 20){
							$degisken=$dogrudan_sayi;
						}elseif($alt_kat == 21){
							$degisken=$uye_ilanlari_sayi;
						}elseif($alt_kat == 81){
							$degisken=$mesajlar_sayi;
						}elseif($alt_kat == 86){
							$degisken=$onay_bekleyen_sayi;
						}elseif($alt_kat == 59){
							$degisken=$son_islem_sayi;
						}elseif($alt_kat == 60){
							$degisken=$odeme_bekleyen_sayi;
						}elseif($alt_kat == 61){
							$degisken=$onay_bekleyen_sayi;
						}elseif($alt_kat == 62){
							$degisken=$iptal_edilen_sayi;
						}elseif($alt_kat == 63){
							$degisken=$satilan_sayi;
						}elseif($alt_kat == 4){
							$degisken=$tum_uyeler_sayi;
						}elseif($alt_kat == 5){
							$degisken=$aktif_uyeler_sayi;
						}elseif($alt_kat == 65){
							$degisken=$ziyaretci_sayi;
						}elseif($alt_kat == 6){
							$degisken=$gold_talep_sayi;
						}elseif($alt_kat == 66){
							$degisken=$evrak_yukleyen_sayi;
						}elseif($alt_kat == 67){
							$degisken=$cayma_iade_istek_sayi;
						}elseif($alt_kat == 71){
							$degisken=$sms_rapor_sayi;
						}elseif($alt_kat == 91){
							$degisken=$dogrulanmayan_sayi;
						}elseif($alt_kat == 46){
							$degisken=$satilan_sayi;
						}elseif($alt_kat == 48){
							$degisken=$cayma_iade_sayi;
						}elseif($alt_kat == 57){
							$degisken=$sigorta_sirket_sayi;
						}elseif($alt_kat == 25){
							$degisken=$uye_grubu_sayi;
						}elseif($alt_kat == 30){
							$degisken=$sss_sayi;
						}elseif($alt_kat == 38){
							$degisken=$tum_gorsel_sayi;
						}elseif($alt_kat == 72){
							$degisken=$duyurular_sayi;
						}elseif($alt_kat == 74){
							$degisken=$slider_sayi;
						}elseif($alt_kat == 76){
							$degisken=$referans_sayi;
						}elseif($alt_kat == 43){
							$degisken=$admin_sayi;
						}elseif($alt_kat == 44){
							$degisken=$yorum_sayi;
						}					
							
						
						
						else{$degisken='';}
						if ($alt_kat_oku['sayfa'] == re('sayfa') ) { $class='class="active"'; }
						$alt_menuler.='
							<li '.$class.' id="'.$say.'"><a href="?modul='.$alt_kat_oku['modul'].'&sayfa='.$alt_kat_oku['sayfa'].'">'.$alt_kat_oku['adi'].' '.$degisken.'</a></li>';
					
					}
					$alt_menuler .= '</ul>';
					
					
				}
				else
				{
					if ($menu_oku['sayfa'] == re('sayfa') ) 
					{ 
						$secilmis1='start active ';
						$secilmis2='<span class="selected"></span>';
						
					}
				}
			}
			if($menu_oku['id'] == 78){
				$gelen_mesaj_sayi = mysql_num_rows(mysql_query("SELECT * FROM iletisim_formu order by id desc"));
				$degisken2=$gelen_mesaj_sayi;
			}else{
				$degisken2 = "";
			}
					$sayi++;
					$ust_menu .= '
					<li class="'.$secilmis1.'" >
						<a href="'.$alink.'" >
						<i class="'.$menu_oku['icon'].'" style="color:white"></i> 
						<span class="title">'.$menu_oku['adi'].' '.$degisken2.'</span>
						'.$secilmis2.'
						'.$secilmis3.'
						</a>
						'.$alt_menuler.'
					</li>
					
					';
		}
		
	?>
	
	
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse ">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- <form class="sidebar-search">
						<div class="input-box">
							<a href="javascript:;" class="remove"></a>
							<input type="text" placeholder="Ara..." />				
							<input type="button" class="submit" value=" " />
						</div>
					</form> -->
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<?php 
					
				
					echo $ust_menu;
					
					if($_SESSION['yetki'] == 9)
					{
						echo '<li class="start active ">
									<a href="?modul=form&sayfa=form">
									<i class="icon-home"></i> 
									<span class="title">Form Ayarları</span>
									<span class="selected"></span>
									</a>
								</li>';
					}
				?>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div id="portlet-config" class="modal hide">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button"></button>
					<h3>Bilgi Penceresi</h3>
				</div>
				<div class="modal-body">
					<p>Dikkat sistem ürün yükleme modundadır.</p>
				</div>
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				
				
				<?php 
					
						if(re('modul') == "" or re('sayfa') == "")
						{
							include('sayfalar/anasayfa/anasayfa.php');
						}
						else
						{
							include('sayfalar/'.re('modul').'/'.re('sayfa').'.php');
						}
						
					?>
			</div>
			<!-- END PAGE CONTAINER-->		
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<!-- <div class="footer">
		2021 &copy; Sistemal Pert Dünyası.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div> -->
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>	
	<![endif]-->	
	<script src="js/ea.js?v=<?=time() ?>"></script>	
	<script src="assets/breakpoints/breakpoints.js"></script>		
	<script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>	
	<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>	
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/jqvmap/jqvmap/jquery.vmap.js?v=<?=time() ?>" type="text/javascript"></script>	
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
	<script src="assets/flot/jquery.flot.js"></script>
	<script src="assets/flot/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>	
	<script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>	
	<script src="../js/toastr/toastr.js"></script>
	<script src="assets/js/app.js?v=<?=time() ?>"></script>				
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.js" integrity="sha512-2Pv9x5icS9MKNqqCPBs8FDtI6eXY0GrtBy8JdSwSR4GVlBWeH5/eqXBFbwGGqHka9OABoFDelpyDnZraQawusw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
	<script>
		$(document).ready(function() {
			$('input[type="date"]').attr({
			"max" : "9999-12-31"
			});
		});
		jQuery(document).ready(function() {		
			// $('#ihale_tarihi').mask("99/99/9999", {placeholder: 'MM/DD/YYYY' });
			// $('input[name="ihale_tarihi"]').mask('00/00/0000');
			App.setPage("index");  // set current page
			App.init(); // init the rest of plugins and elements
		});
	</script>	
		
		
		<!--
		<div class="genel_dis">
		
		
		
		
		
		<!--
			<div class="ust_alan" onmouseover="hepsini_gotur();" style="top:50px;">
				<div class="ust_alan_ic">
					<div style="float:left;">
						EA Bilişim Yönetim Paneli
					</div>
					
					<div style="float:right; margin-top:-8px; padding-top:8px; cursor:pointer; padding-left:7px; padding-right:7px;" id="kullanici_p_dis" onmouseover="profil_ac();" >
						<div style="float:right; width:30px; height:35px; margin-top:-8px; overflow:hidden;">
							<img src="images/genel/r_cerceve.png" style="position:absolute; width:30px; height:30px; margin-top:3px;" id="kullanici_r_c_dis" />
							<img src="images/kullanicilar/<?php echo $kullanici_oku['resim']; ?>" width="100%" />
						</div>
						
						<div style="float:right; margin-right:10px;">Hoşgeldin <?php echo $kullanici_oku['adi'].' '.$kullanici_oku['soyadi']; ?></div>
					</div>
					<div style="float:right; background:black; margin-right:10px;">
						aa	
					
					</div>
				</div>
			</div>
			
	
			<div style="width:100%; float:left; position:fixed;  z-index:400; top:80px;" id="kapatmalik_alan_ust" >
				<div style="width:1000px; margin-left:auto; margin-right:auto;">
					<div style="float:left; width:100%; height:100%;" id="kapatmalik_alan" onmouseover="profil_kapat();"></div>
					<div class="profil_acilan_alan" id="acilacak_alan" >
						<a href="#" class="profil_acilan_eleman">
							<img src="images/genel/kullanici.png" style="position:absolute; margin-top:3px; width:16px;" />
							<div style="float:left; margin-left:20px;">Profili Düzenle</div>
						</a>
						<a href="?islem=cikis_yap" class="profil_acilan_eleman">
							<img src="images/genel/cikis_yap.png" style="position:absolute; margin-top:3px; width:15px;" />
							<div style="float:left; margin-left:20px;">Çıkış Yap</div>
						</a>
					</div>
				</div>
			</div>
			
			
			<div style="position:fixed; float:left; width:100%; height:100%; z-index:-10;" onmouseover="hepsini_gotur(), profil_kapat();"></div>
			-->
			<!--
			<div class="genel_ic" >
				<div class="ana_menu_dis" >
					<a href="index.php" class="ust_menu_ic tooltips" title="Anasayfa" data-placement="bottom" data-original-title="Anasayfa" onmouseover="hepsini_gotur(), profil_kapat();" ><img src="images/genel/home.png" style="width:30px;" /></a>
					<?php 
						$ust_menu = "";
						$sayi = 0;
						$sayi_alt = 0;
						$menu_cek = mysql_query("select * from p_menu where durum!='0' and kategori='0' ORDER BY sira ASC");
						while($menu_oku = mysql_fetch_array($menu_cek))
						{
							$bas = true;
							
							if($bas == true)
							{
								$alt_kat_cek = mysql_query("select * from p_menu where durum!='0' and kategori='".$menu_oku['id']."' ORDER BY sira ASC");
								$alt_kat_sayi = mysql_num_rows($alt_kat_cek);
								if($alt_kat_sayi = 0)
								{
									$sayi++;
									$ust_menu .= '<a href="?modul='.$menu_oku['modul'].'&sayfa='.$menu_oku['sayfa'].'" class="ust_menu_ic2" onmouseover="hepsini_gotur(), profil_kapat();" >Ürünler</a>';
								}
								else
								{
									$sayi++;
									$sayi_alt++;
									$ust_menu .= '<div class="etkisiz_menu_eleman" onmouseout="menu_gotur('.$sayi.');">
											<a href="?modul='.$menu_oku['modul'].'&sayfa='.$menu_oku['sayfa'].'" class="ust_menu_ic2" onmouseover="menu_getir('.$sayi.');" >'.$menu_oku['adi'].'</a>
											<div class="ana_alt_menu_dis" id="alt_m_'.$sayi.'" onmouseout="menu_gotur('.$sayi.'), profil_kapat();" >';
									while($alt_kat_oku = mysql_fetch_array($alt_kat_cek))
									{
										$ust_menu .= '<a href="?modul='.$alt_kat_oku['modul'].'&sayfa='.$alt_kat_oku['sayfa'].'" class="ana_alt_menu_eleman" >'.$alt_kat_oku['adi'].'</a>';
									}
									$ust_menu .= '</div></div>';
								}
							}
						}
						
						#echo $ust_menu;
					?>
					<input type="hidden" name="alt_menu_toplam" id="alt_menu_toplam" value="<?php echo $sayi_alt; ?>" />
				</div>
				
				<div class="alt_genel" onmouseover="hepsini_gotur(), profil_kapat();">
					
					<?php 
					/*
						if(re('modul') == "" or re('sayfa') == "")
						{
							include('sayfalar/anasayfa/anasayfa.php');
						}
						else
						{
							include('sayfalar/'.re('modul').'/'.re('sayfa').'.php');
						}
						*/
					?>
					
				</div>
			</div>
		</div>
		-->
		
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<!--<script src="assets/ckeditor/ckeditor.js"></script>-->
		<!--<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>-->
		<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>    <!-- Option 2: Separate Popper and Bootstrap JS -->
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

		<style>
			.dataTables_info{
				position: absolute;
				top: 0;
				right: 35%;
				font-size: 20px;
			}
		</style>
		
		<script>
			$(document).ready( function () {
				$('#dene_table_ugur').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"responsive": true,
					"pageLength" : 100,
					"ordering": false,
					"searching": false,
					searchPanes: {
						viewCount: false
					},
				});			
				$.fn.dataTableExt.pager.numbers_length = 900;	
				$('#uyeler_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 30,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});				
				$('#tum_ihaleler_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok",
						"info": " _TOTAL_ adet ilan bulundu"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": true,
					"ordering": false,					
					"autoWidth": true,
					"responsive": true,
				});
				$('#teklifler_table_data').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
				$('#son_teklifler_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
				$('#bugun_bitenler_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
				$('#yarin_bitenler_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
				$('#ihalesi_bitenler_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
				$('#bugun_eklenenler_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
				$('#statu_bekleyenler_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
				$('#dogrudan_satis_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
				$('#mesajlar_ilan_table').DataTable({
					"language": {
						"paginate": {
							"previous": "Önceki",
							"next": "Sonraki"
						},
						"emptyTable": "Hiç Veri Yok"
					},
					"pageLength" : 100,
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": false,
					"info": false,
					"autoWidth": true,
					"responsive": true,
				});
			
				/*
				$("#satilan_araclar_table").DataTable({
				"responsive": true, "lengthChange": false, "autoWidth": false,"searching": false,"retrieve": true,"retrieve": true,"ordering":false,
				"buttons": ["excel"]	
				}).buttons().container().appendTo('#satilan_araclar_excel_area');
				*/
			} );
		</script>
</body>
</html>

<script>
	function navbar_searchle(){
		var aranan=$("#navbar_aranan").val();
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_arac_kodu",
				aranan:aranan,
			},
			success: function(response) {
				console.log(response);
				if(response.tur=="dogrudan"){
					window.location.href = "?modul=ihaleler&sayfa=navbar_search_dogrudan&navbar_aranan="+aranan;
				}else if(response.tur=="ilan"){
					window.location.href = "?modul=ihaleler&sayfa=navbar_search&navbar_aranan="+aranan;
				}else{
					alert("İstediğiniz kriterlere uygun araç bulunamadı.");
				}
			}
		});
	}
</script>
<script>
	function sehir_display(){
		$('.filtre_sehir').hide();
		var txt = $('#sehir_filtre_input').val();
		$('.filtre_sehir').each(function(){
			if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
				$(this).show();
			}
		});
	}
	function marka_display(){
		$('.filtre_marka').hide();
		var txt = $('#marka_filtre_input').val();
		$('.filtre_marka').each(function(){
			if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
				$(this).show();
			}
		});
	}
	function search_in_div($div_class,$input){
		$('.'+$div_class).hide();
		var txt = $('#'+$input).val();
		$('.'+$div_class).each(function(){
			if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
				$(this).show();
			}
		});
	}
</script>
<!-- Summernote -->
<!-- <script src="assets/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()
  })
</script> -->