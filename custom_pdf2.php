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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 site-section">
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
                            Kaynak Firma Üyesi TEKLİF DETAYLARIDIR
                        </div>
                        <div class="page_table_outer">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>ARAÇ KODU</td>
                                        <td>: 09695124</td>
                                    </tr>
                                    <tr>
                                        <td>PLAKA</td>
                                        <td>: 68SYO258</td>
                                    </tr>
                                    <tr>
                                        <td>VERİLEN TEKLİF</td>
                                        <td>: 105.800 TL</td>
                                    </tr>
                                    <tr>
                                        <td>TEKLİF ZAMANI</td>
                                        <td>: 14-02-2023 13:45:14</td>
                                    </tr>
                                    <tr>
                                        <td>İP ADRESİ</td>
                                        <td>: 78.167.0.94</td>
                                    </tr>
                                    <tr>
                                        <td>KULLANILAN İŞLETİM SİSTEMİ</td>
                                        <td>: Windows 10</td>
                                    </tr>
                                    <tr>
                                        <td>KULLANILAN TARAYICI </td>
                                        <td>: Chrome</td>
                                    </tr>
                                    <tr>
                                        <td>TC KİMLİK</td>
                                        <td>: 99999999999</td>
                                    </tr>
                                    <tr>
                                        <td>TELEFON</td>
                                        <td>: 0(530)000-0000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button onclick="PrintDiv('custom_pdf')">Yazdır!</button>
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