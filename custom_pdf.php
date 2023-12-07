<?php 
	session_start();
	include 'ayar.php';

	//include 'alert.php';
	$token = $_SESSION['u_token'];
	$k_token = $_SESSION['k_token'];
	if(!empty($token)){
		$uye_token = $token;
	}elseif(!empty($k_token)){
		$uye_token = $k_token;
	}
    $teklif_id=re("teklif_id");
    $ihale_id=re("ihale_id");
    
    $teklif = mysql_query("SELECT * FROM teklifler WHERE ilan_id ='".$ihale_id."' and id='".$teklif_id."' ");
    $sorgu = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id ='".$ihale_id."'");
    $cek=mysql_fetch_object($sorgu);
    $hizmet_bedeli=$cek->toplam;
    $sorgu2 = mysql_query("SELECT * FROM ilanlar WHERE id ='".$ihale_id."'");
    $cek2=mysql_fetch_object($sorgu2);
    
    $arac_kodu=$cek2->arac_kodu;
    $plaka=$cek2->plaka;
    
    while($offer = mysql_fetch_array($teklif)){
        /*$query = mysql_query("SELECT * FROM `cayma_bedelleri` WHERE uye_id='".$offer["uye_id"]."' ORDER BY NET DESC LIMIT 1 ");*/
        /*$row=mysql_fetch_object($query);*/
        $query2 = mysql_query("SELECT * FROM `user` WHERE id='".$offer["uye_id"]."' ");
        $row2=mysql_fetch_object($query2);
        /*$cayma_bedeli=$row->net;*/
        $tc=$row2->tc_kimlik;
        $telefon=$row2->telefon;
        if(empty($row2->kurumsal_user_token)){
            $uye_ismi=$row2->ad;
        }else{
            $uye_ismi=$row2->unvan;
        }
        $teklif_date=$offer['teklif_zamani'];
        $teklif_zamani=date('d-m-Y H:i:s', strtotime($teklif_date));
        $ip=$offer["ip"];
        $tarayici=$offer["tarayici"];
        $isletim_sistemi=$offer["isletim_sistemi"];
        $verilen_teklif=money($offer["teklif"]);
        if($cek2->pd_hizmet=="" || $cek2->pd_hizmet==0){
            $hizmet_bedeli=$offer["hizmet_bedeli"];
        }else{
            $hizmet_bedeli=$cek2->pd_hizmet;
        }
    }

?>
<!doctype html>
<html lang="tr">
    <head>
        <!-- <title>Pert &mdash; Dünyası</title> -->
        <?php
            include 'seo_kelimeler.php';
        ?>
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
        <link rel="stylesheet" href="css/style.css?v=<?=time() ?>">
        <link rel="stylesheet" href="css/custom.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300" onload="PrintDiv('custom_pdf')">
        <div class="site-wrap" id="home-section">
            <div class="site-mobile-menu site-navbar-target">
                <div class="site-mobile-menu-header">
                    <div class="site-mobile-menu-close mt-3">
                        <span class="icon-close2 js-menu-toggle"></span>
                    </div>
                </div>
                <div class="site-mobile-menu-body"></div>
            </div>
            <?php 
                include 'modal.php';
                include 'header.php'; 
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 site-section" style="display: flex;justify-content: center;align-items: center;min-height: 400px;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0px; display:none;" id="custom_pdf">
                    <link rel="preconnect" href="https://fonts.gstatic.com">
                    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
                    <style>
                        .printDivOuter
                        {
                            width:100%;
                            height:auto;
                            float:left;
                        }

                        .printDivOuter *
                        {
                            font-family:'Varela Round', sans-serif;
                            box-sizing:border-box;
                        }

                        .page_top_outer
                        {
                            width:100%;
                            height:50px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            margin-bottom:65px;
                            float:left;
                        }
                        
                        .page_top_outer img
                        {
                            width:auto;
                            height:auto;
                            max-width:100%;
                            max-height:100%;
                            float:left;
                        }

                        .page_table_outer
                        {
                            width:100%;
                            min-height:20px;
                            float:left;
                        }

                        .page_table_outer table
                        {
                            width:100%;
                        }

                        .page_table_outer table * tr:nth-child(odd)
                        {
                            background-color:#f5f5f5;
                        }

                        .page_table_outer table * td
                        {
                            padding:10px 0px;
                            font-size:13px;
                            border:0px!important;
                        }

                        .page_table_outer table * td:first-child
                        {
                            width:250px;
                            font-weight:500;
                        }

                        .page_table_title
                        {
                            width:100%;
                            font-size:17px;
                            font-weight:600;
                            color:#333;
                            margin-bottom:25px;
                        }
                    </style>
                    
                    <div class="printDivOuter">
                        <div class="page_top_outer">
                            <img src="https://ihale.pertdunyasi.com/images/pdf_logo2.png" />
                        </div>
                        <div class="page_table_title">
                            <?= $uye_ismi ?> TEKLİF DETAYLARIDIR
                        </div>
                        <div class="page_table_outer">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>ARAÇ KODU</td>
                                        <td>: <?= $arac_kodu ?></td>
                                    </tr>
                                    <tr>
                                        <td>PLAKA</td>
                                        <td>: <?= $plaka ?></td>
                                    </tr>
                                    <tr>
                                        <td>VERİLEN TEKLİF</td>
                                        <td>: <?= $verilen_teklif ?> TL</td>
                                    </tr>
                                    <tr>
                                        <td>TEKLİF ZAMANI</td>
                                        <td>: <?= $teklif_zamani ?></td>
                                    </tr>
                                    <tr>
                                        <td>İP ADRESİ</td>
                                        <td>: <?= $ip ?></td>
                                    </tr>
                                    <tr>
                                        <td>KULLANILAN İŞLETİM SİSTEMİ</td>
                                        <td>: <?= $isletim_sistemi ?></td>
                                    </tr>
                                    <tr>
                                        <td>KULLANILAN TARAYICI </td>
                                        <td>: <?= $tarayici ?></td>
                                    </tr>
                                    <tr>
                                        <td>TC KİMLİK</td>
                                        <td>: <?= $tc ?></td>
                                    </tr>
                                    <tr>
                                        <td>TELEFON</td>
                                        <td>: <?= $telefon ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button onclick="PrintDiv('custom_pdf')" class="btn btn-primary btn-btn-block" style="width: 50%;">Yazdır / İndir</button>
            </div>
            <div class="clearfix"></div>
            <?php include "footer.php" ?>
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
        <script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
        <script>
            setInterval(function() {
                cikis_yap("<?=$uye_token?>");
            }, 300001);
            son_islem_guncelle("<?=$uye_token?>");

            function PrintDiv(item) 
            {    
                var divToPrint = document.getElementById(item);
                var popupWin = window.open('', '_blank', 'width=800,height=800');
                popupWin.document.open();
                popupWin.document.write('<html><body onload="window.print()" style="padding:20px;">' + divToPrint.innerHTML + '</html>');
                popupWin.document.close();   
            }
        </script>
    </body>
</html>