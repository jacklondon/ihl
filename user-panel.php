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

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/message.css">

    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

</head>
<!-- Modal Add new -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container mb-5">
                    <div class="row">
                        <div class="text-center" style="width: 100%;">
                            <a href="#"><img src="https://via.placeholder.com/298x59.png" class="center"></a>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <form>
                        <div class="row">
                            <div class="col">
                                <label for="">Marka*</label>
                                <div class="col">
                                    <select class="custom-select d-block w-100 text-uppercase" id="brand" required="">
                                        <option value="">Audi</option>
                                        <option>BMW</option>
                                        <option>Mercedes</option>
                                        <option>Renault</option>
                                        <option>Fiat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="">Model*</label>
                                <div class="col">
                                    <select class="custom-select d-block w-100 text-uppercase" id="brand" required="">
                                        <option value="">Model 1</option>
                                        <option>Model 2</option>
                                        <option>Model 3</option>
                                        <option>Model 4</option>
                                        <option>Model 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="">Tip*</label>
                                <div class="col">
                                    <select class="custom-select d-block w-100 text-uppercase" id="brand" required="">
                                        <option value="">1.5 DCI</option>
                                        <option>1.6 TFSI</option>
                                        <option>Tip 3</option>
                                        <option>Tip 4</option>
                                        <option>Tip 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <!-- 1950 ye kadar mevcut yilin sonrasi girilmeyecek -->
                                <label for="">Model Yili*</label>
                                <input type="text" class="form-control" placeholder="ex: 2016">
                            </div>
                            <div class="col">
                                <label for="">En düşük fiyat*</label>
                                <input type="number" class="form-control" placeholder="ex: 15.500">
                            </div>

                        </div>
                        <label class="mt-5">Uyari Notunuz</label>
                        <div class="row align-items-center">
                            <textarea name="editor1" id="editor1" rows="10" cols="40"></textarea>
                            <script>
                                CKEDITOR.replace("editor1");
                            </script>
                        </div>
                        <label class="mt-5">Adres ve Yetkili Bilgileri</label>

                        <div class="row align-items-center">
                            <textarea name="editor2" id="editor2" rows="10" cols="40"></textarea>
                            <script>
                                CKEDITOR.replace("editor2");
                            </script>
                        </div>

                        <div class="row mt-5">
                            <div class="col">
                                <a class="btn btn-primary btn-block" href="#" role="button">Kaydet</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / END Modal Add new -->

<!-- Modal Reset Password -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form>
                        <div class="col">
                            <label for="">Şifre*</label>
                            <input type="password" class="form-control" placeholder="">
                        </div>
                        <div class="col">
                            <label for="">Şifre Tekrar*</label>
                            <input type="password" class="form-control" placeholder="">
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <a class="btn btn-primary btn-block" href="#" role="button">Yenile</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / END Modal Reset Password -->


<!-- Modal Bid Offer -->
<div class="modal fade" id="exampleModal7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="text-center mt-3">
                        <i class="icon-info"></i>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <h6>Sadece Hesap sahibi kısmında belirtilen Şahıs ya da Kuruma ait IBAN Numarası girilmesi
                            gerekmektedir.</h6>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <h6>Hesap sahibi ile IBAN No eşleşmemesi halinde yaşanacak aksaklıklardan üyelik sahibi
                            sorumludur.</h6>
                    </div>
                    <div class="text-center mt-3">
                        <h6><u>Gönder butonuna basmanız halinde;</u></h6>
                    </div>
                    <!-- Kullanici onceden bu arabaya teklif yapmis ise -->
                    <div class="text-center mt-3">
                        <h6>IBAN üzerinde düzenleme yapamayacaksınız.</h6>
                    </div>
                    <div class="text-center mt-3">
                        <h6>Teklif veremeyeceksiniz</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary mt-3 mr-1 float-left"><i class="icon-send-o"> Gonder</i></a>
                <a href="#" class="btn btn-secondary mt-3 mr-1 float-right" data-dismiss="modal"> Vazgeç</a>
            </div>
        </div>
    </div>
</div>
<!-- / END Modal Bid Offer -->

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
    <div class="site-wrap" id="home-section">
        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>

        <header class="site-navbar site-navbar-target" role="banner">
            <div class="container">
              <div class="row align-items-center position-relative">
                <div class="col-3 ">
                  <div class="site-logo">
                    <a href="index.php"><img src="images/logo2.png"></a>
                  </div>
                </div>
                <div class="col-9  text-right">
                  <span class="d-inline-block d-lg-none">
                    <a href="#" class="text-white site-menu-toggle js-menu-toggle py-5 text-white">
                      <span class="icon-menu h3 text-white"></span></a></span>
                  <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav ml-auto ">
                      <li class="active"><a href="index.php" class="nav-link">Ana Sayfa</a></li>
                      <li><a href="showcase.php" class="nav-link">Vitrin</a></li>
                      <li><a href="bulletin.php" class="nav-link">Duyurular</a></li>
                      <li><a href="about.php" class="nav-link">Hakkımızda</a></li>
                      <li><a href="contact.php" class="nav-link">İletişim</a></li>
                      <li><a href="packages.php" class="nav-link">Paketler</a></li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </header>
      
        <div class="ftco-blocks-cover-1">
            <div class="ftco-cover-1 overlay innerpage" style="background-image: url('images/hero_2.jpg')">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h1>Slogan</h1>
                            <p>Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section pt-0 pb-0 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="page-shape"></div>
                        <div class="page-shape-two"></div>
                        <form class="trip-form">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-6">
                                    <h3 class="m-0">Aracını Bul</h3>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <span class="text-primary">12</span> <span>araç uygun</span></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <form action="#" class="pb-3">
                                        <div class="form-group">
                                            <select name="city" class="form-control" id="city"
                                                placeholder="Şehir seçiniz" data-rule="minlen:4">
                                                <option value="0">Şehir seçiniz</option>
                                                <option value="1">Ankara</option>
                                                <option value="2">İstanbul</option>
                                                <option value="3">İzmir</option>
                                                <option value="4">Adana</option>
                                                <option value="5">Bursa</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cf-2">Evrak Durumu</label>
                                    <form action="#">
                                        <input type="checkbox" id="1" name="1" value="2">
                                        <label for="1"> Çekme Belgeli / Pert Kayıtlı</label><br>
                                        <input type="checkbox" id="2" name="2" value="2">
                                        <label for="2"> Çekme Belgeli </label><br>
                                        <input type="checkbox" id="3" name="3" value="3">
                                        <label for="3"> Plakalı </label><br>
                                        <input type="checkbox" id="4" name="4" value="4">
                                        <label for="4"> Hurda Belgeli </label><br>
                                    </form>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cf-3">Model Yılı Aralığı</label>
                                    <form action="#">
                                        <div class="row" style="justify-content: center; align-items: center;">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" id="start"
                                                    placeholder="Başlangıç" value="" required="">
                                            </div>
                                            /
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" id="end" placeholder="Bitiş"
                                                    value="" required="">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cf-4">Marka</label>
                                    <form action="#" class="pb-3">
                                        <div class="form-group">
                                            <select name="city" class="form-control" id="brand"
                                                placeholder="Marka seçiniz" data-rule="minlen:4">
                                                <option value="0">Marka seçiniz</option>
                                                <option value="1">Dodge</option>
                                                <option value="2">Mercedes</option>
                                                <option value="3">BMW</option>
                                                <option value="4">Renault</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <input type="submit" value="Filtrele" class="btn btn-trans">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel -->
        <div class="site-section bg-light">
            <div class="container">
                <div class="row ml-1">
                    <h3>Demo Uye</h3>
                </div>
                <div class="row ml-1">
                    <div class="d-block w-100">
                        <h5><i class="icon-money"></i> Cayma Bakiyesi : TL 0</h5>
                    </div>
                    <div class="d-block w-100">
                        <h5><i class="icon-attach_money"></i> Teklif Limiti : TL 0</h5>
                    </div>
                    <div class="d-block w-100">
                        <h5><i class="icon-user"></i> GURCAN CANKIZ</h5>
                    </div>
                    <div class="d-block w-100">
                        <a class="text-muted" href=""><i class="icon-sign-out"> Cikis</i> </a>
                    </div>
                </div>
                <div class="d-flex align-items-start"></div>
                <div class="row mt-5">
                    <div class="col-md-3 mb-5">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <!-- Kazandıklarım -->
                            <h4 class="menu-titles">Kazandıklarım</h4>
                            <a class="nav-link c-a" id="v-pills-last-tab" data-toggle="pill" href="#v-pills-last"
                                role="tab" aria-controls="v-pills-last" aria-selected="true">Son İşlemdekier <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a active" id="v-pills-pay-tab" data-toggle="pill" href="#v-pills-pay"
                                role="tab" aria-controls="v-pills-pay" aria-selected="true">Ödeme Bekleyenler <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-check-tab" data-toggle="pill" href="#v-pills-check"
                                role="tab" aria-controls="v-pills-check" aria-selected="false">Onay Bekleyenler <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-bought-tab" data-toggle="pill" href="#v-pills-bought"
                                role="tab" aria-controls="v-pills-bought" aria-selected="false">Satın Alınanlar <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-break-tab" data-toggle="pill" href="#v-pills-break"
                                role="tab" aria-controls="v-pills-break" aria-selected="false">İptal Olanlar <span
                                    class="badge badge-danger">1</span></a>
                            <!-- Takip Ettiklerim -->
                            <h5 class="menu-titles mt-5">Takip Ettiklerim</h5>
                            <a class="nav-link c-a" id="v-pills-fav-tab" data-toggle="pill" href="#v-pills-fav"
                                role="tab" aria-controls="v-pills-fav" aria-selected="true">Favorilerim <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-act-tab" data-toggle="pill" href="#v-pills-act"
                                role="tab" aria-controls="v-pills-act" aria-selected="false">Aktif Tekliflerim <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-archive-tab" data-toggle="pill" href="#v-pills-archive"
                                role="tab" aria-controls="v-pills-archive" aria-selected="false">Teklif Arşivim <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-msg-tab" data-toggle="pill" href="#v-pills-msg"
                                role="tab" aria-controls="v-pills-msg" aria-selected="false">Mesajlarim <span
                                    class="badge badge-danger">1</span></a>
                            <!-- İlanlarım -->
                            <h5 class="menu-titles mt-5">İlanlarım</h5>
                            <a class="nav-link c-a" id="v-pills-new-tab" data-toggle="pill" href="#v-pills-new"
                                role="tab" aria-controls="v-pills-new" aria-selected="true">Yeni İlan Ekle <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-bid-tab" data-toggle="pill" href="#v-pills-bid"
                                role="tab" aria-controls="v-pills-bid" aria-selected="false">İhaledeki İlanlarım <span
                                    class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-sell-tab" data-toggle="pill" href="#v-pills-sell"
                                role="tab" aria-controls="v-pills-sell" aria-selected="false">Doğrudan Satışlı İlanlarım
                                <span class="badge badge-danger">1</span></a>
                            <!-- Yorumlar -->
                            <h5 class="menu-titles mt-5">Yorumlar</h5>
                            <a class="nav-link c-a" id="v-pills-comments-tab" data-toggle="pill"
                                href="#v-pills-comments" role="tab" aria-controls="v-pills-comments"
                                aria-selected="true">Yorumlarım <span class="badge badge-danger">1</span></a>
                            <!-- <a class="nav-link c-a" id="v-pills-all-comments-tab" data-toggle="pill"
                                href="#v-pills-all-comments" role="tab" aria-controls="v-pills-all-comments"
                                aria-selected="false">Tüm Yorumlarım <span class="badge badge-danger">1</span></a> -->
                            <!-- Ayarlar -->
                            <h5 class="menu-titles mt-5">Ayarlar</h5>
                            <a class="nav-link c-a" id="v-pills-settings-tab" data-toggle="pill"
                                href="#v-pills-settings" role="tab" aria-controls="v-pills-settings"
                                aria-selected="true">Profili Düzenle <span class="badge badge-danger">1</span></a>
                            <a class="nav-link c-a" id="v-pills-price-tab" data-toggle="pill" href="#v-pills-price"
                                role="tab" aria-controls="v-pills-price" aria-selected="false">Cayma Bedelleri <span
                                    class="badge badge-danger">1</span></a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <!-- Kazandiklarim in #1 -->
                            <!-- Son İşlemdekiler #1-1 last -->
                            <div class="tab-pane fade" id="v-pills-last" role="tabpanel"
                                aria-labelledby="v-pills-pay-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Car #1 -->
                                        <div class="item-1 shadow">
                                            <a href="#"><img src="images/img_1.jpg" alt="Image" class="img-fluid"></a>
                                            <div class="item-1-contents">
                                                <div class="text-center">
                                                    <h3><a href="#" class="c-second">2016 Nissan 1.DCI TEKNA SKY PACK
                                                            X-TRONIC</a></h3>
                                                    <div class="text-center">
                                                        <h6>8 Gun 23:12:56</h6>
                                                    </div>
                                                </div>
                                                <div style="overflow-x: auto;">
                                                    <table class="border bordered mt-3">
                                                        <tr>
                                                            <th>Teklif Verdiği Tarih</th>
                                                            <td>4.10.2020 15:00</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Plaka</th>
                                                            <td>35ABC35</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Şehir</th>
                                                            <td>İzmir</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Profil</th>
                                                            <td>Çekme Belgeli / Pert Kayıtlı</td>
                                                        </tr>
                                                        <tr>
                                                            <th>İhale Kapanış Tarihi</th>
                                                            <td>05.10.2020 15:30</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Statü</th>
                                                            <td>Son İşlemde</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Açıklamalar</th>
                                                            <td>Ödeme yapildi teslim ve satış bekleniyor</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="row no-gutters">
                                                    <div class="col-6">
                                                        <a href="#" class="btn btn-primary mt-3 ml-1"><i
                                                                class="icon-search"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <!-- Car #2 -->
                                        <div class="item-1 shadow">
                                            <a href="#"><img src="images/img_1.jpg" alt="Image" class="img-fluid"></a>
                                            <div class="item-1-contents">
                                                <div class="text-center">
                                                    <h3><a href="#" class="c-second">2016 Nissan 1.DCI TEKNA SKY PACK
                                                            X-TRONIC</a></h3>
                                                    <div class="text-center">
                                                        <h6>8 Gun 23:12:56</h6>
                                                    </div>
                                                </div>
                                                <div style="overflow-x: auto;">
                                                    <table class="border bordered mt-3">
                                                        <tr>
                                                            <th>İhale Kapanış Tarihi</th>
                                                            <td> 05.10.2020 15:30</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Plaka</th>
                                                            <td>35ABC35</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Şehir</th>
                                                            <td>İzmir</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Profil</th>
                                                            <td>Çekme Belgeli / Pert Kayıtlı</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Son Ödeme Tarihi</th>
                                                            <td class="c-red">20.12.2020</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Açıklamalar</th>
                                                            <td>Vekalet Bekliyoruz</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="row no-gutters">
                                                    <div class="col-6">
                                                        <a href="#" class="btn btn-primary mt-3 ml-1"><i
                                                                class="icon-search"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ödeme Bekleyenler #1-2 pay -->
                            <div class="tab-pane fade show active" id="v-pills-pay" role="tabpanel"
                                aria-labelledby="v-pills-pay-tab">
                                <div class="card mb-3">
                                    <div class="card-header my-card-title-primary">
                                        2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC
                                        <div class="float-right">8 Gun 23:12:56</div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-4"><img src="images/img_1.jpg" class="card-img"
                                                alt="Land Rover">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div style="overflow-x: auto;">
                                                    <table class="border bordered mt-3">
                                                        <tr>
                                                            <th>İlan No</th>
                                                            <td>#1</td>
                                                        </tr>
                                                        <tr>
                                                            <th>İhale Kapanış Tarihi</th>
                                                            <td>05.10.2020 15:30</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Plaka</th>
                                                            <td>35ABC35</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Şehir</th>
                                                            <td>İzmir</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Profil</th>
                                                            <td>Çekme Belgeli / Pert Kayıtlı</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Son Ödeme Tarihi</th>
                                                            <td class="red"><b>20.12.2020</b></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Açıklamalar</th>
                                                            <td>Vekalet Bekliyoruz</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="ml-3 m-1">
                                                <a class="btn btn-show" href="#" role="button"><i class="fa fa-search"
                                                        aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Onay Bekleyenler #1-3 check -->
                            <div class="tab-pane fade" id="v-pills-check" role="tabpanel"
                                aria-labelledby="v-pills-check-tab">
                                <div class="card mb-3">
                                    <div class="card-header my-card-title-primary">
                                        2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC
                                        <div class="float-right">8 Gun 23:12:56</div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-4"><img src="images/img_2.jpg" class="card-img"
                                                alt="Land Rover">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div style="overflow-x: auto;">
                                                    <table class="border bordered mt-3">
                                                        <tr>
                                                            <th>İlan No</th>
                                                            <td>#1</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Teklif Verdiği Tarih</th>
                                                            <td>04.10.2020 15:00</td>
                                                        </tr>
                                                        <tr>
                                                            <th>İhale Kapanış Tarihi</th>
                                                            <td>05.10.2020 15:30</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Plaka</th>
                                                            <td>35ABC35</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Şehir</th>
                                                            <td>İzmir</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Profil</th>
                                                            <td>Çekme Belgeli / Pert Kayıtlı</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Teklifim</th>
                                                            <td class="c-red"><b>TL35.000</b></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Statü</th>
                                                            <td>Dosya İpal Edildi / Onaylanmadı</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Açıklamalar</th>
                                                            <td>-</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="ml-3 m-1">
                                                <a class="btn btn-show" href="#" role="button"><i class="fa fa-search"
                                                        aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Satın Alınanlar #1-4 bought -->
                            <div class="tab-pane fade" id="v-pills-bought" role="tabpanel"
                                aria-labelledby="v-pills-bought-tab">
                                <div class="card mb-3">
                                    <div class="card-header my-card-title-primary">
                                        2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC
                                        <div class="float-right">8 Gun 23:12:56</div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-4"><img src="images/img_4.jpg" class="card-img"
                                                alt="Land Rover">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div style="overflow-x: auto;">
                                                    <table class="border bordered mt-3">
                                                        <tr>
                                                            <th>İlan No</th>
                                                            <td>#1</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Teklif Verdiği Tarih</th>
                                                            <td>4.10.2020 15:00</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Plaka</th>
                                                            <td>35ABC35</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Şehir</th>
                                                            <td>İzmir</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Profil</th>
                                                            <td>Çekme Belgeli / Pert Kayıtlı</td>
                                                        </tr>
                                                        <tr>
                                                            <th>İhale Kapanış Tarihi</th>
                                                            <td>05.10.2020 15:30</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Statü</th>
                                                            <td>Son İşlemde</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Açıklamalar</th>
                                                            <td>Ödeme yapildi teslim ve satış bekleniyor</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="ml-3 m-1">
                                                <a class="btn btn-show" href="#" role="button"><i class="fa fa-search"
                                                        aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- İptal Olanlar #1-5 break -->
                            <div class="tab-pane fade" id="v-pills-break" role="tabpanel"
                                aria-labelledby="v-pills-break-tab">
                                <div class="card mb-3">
                                    <div class="card-header my-card-title-primary">
                                        2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC
                                        <div class="float-right">8 Gun 23:12:56</div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-4"><img src="images/img_1.jpg" class="card-img"
                                                alt="Land Rover">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div style="overflow-x: auto;">
                                                    <table class="border bordered mt-3">
                                                        <tr>
                                                            <th>İlan No</th>
                                                            <td>#1</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Teklif Verdiği Tarih</th>
                                                            <td>04.10.2020 15:00</td>
                                                        </tr>
                                                        <tr>
                                                            <th>İhale Kapanış Tarihi</th>
                                                            <td>05.10.2020 15:30</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Plaka</th>
                                                            <td>35ABC35</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Şehir</th>
                                                            <td>İzmir</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Profil</th>
                                                            <td>Çekme Belgeli / Pert Kayıtlı</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Teklifim</th>
                                                            <td class="c-red"><b>TL35.000</b></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Statü</th>
                                                            <td>Dosya İpal Edildi / Onaylanmadı</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Açıklamalar</th>
                                                            <td>-</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="ml-3 m-1">
                                                <a class="btn btn-show" href="#" role="button"><i class="fa fa-search"
                                                        aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Takip Ettiklerim in #2 -->
                            <!-- Favorilerim #2-1 fav -->
                            <div class="tab-pane fade" id="v-pills-fav" role="tabpanel"
                                aria-labelledby="v-pills-fav-tab">
                                <div class="card mb-3 non-show">
                                    <div class="card-header my-card-title-primary">
                                        2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC
                                        <div class="float-right">8 Gun 23:12:56</div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-4"><img src="images/img_3.jpg" class="card-img"
                                                alt="Land Rover">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <table class="border bordered mt-3">
                                                    <tr>
                                                        <th>İlan No</th>
                                                        <td>#1</td>
                                                    </tr>
                                                    <tr>
                                                        <th>İhale Kapanış Tarihi</th>
                                                        <td>Kapanış : 03.11.2020 15:55:00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Plaka</th>
                                                        <td>35ABC35</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Şehir</th>
                                                        <td>İstanbul</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Profil</th>
                                                        <td>Kapali İhale</td>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <td> <textarea class="card-text" id="note" name="note" rows="4"
                                                                cols="30"
                                                                style="color: #5a5a5a;">İlan uyarı notu yayınlanacak.</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Taban Fiyat</th>
                                                        <td>
                                                            <h3><b>TL 102.500</b></h3>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="mt-3">
                                                    <a href="#" class="btn btn-primary"><i class="icon-money"></i></a>
                                                    <a href="#" class="btn btn-primary"><i
                                                            class="icon-info-circle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tekliflerim #2-2 act -->
                            <div class="tab-pane fade" id="v-pills-act" role="tabpanel"
                                aria-labelledby="v-pills-act-tab">
                                <div class="card mb-3 non-show">
                                    <div class="card-header my-card-title-blue">
                                        2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC
                                        <div class="float-right">8 Gun 23:12:56</div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-4"><img src="images/img_3.jpg" class="card-img"
                                                alt="Land Rover">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <table class="border bordered mt-3">
                                                    <tr>
                                                        <th>İlan No</th>
                                                        <td>#1</td>
                                                    </tr>
                                                    <tr>
                                                        <th>İhale Kapanış Tarihi</th>
                                                        <td>Kapanış : 03.11.2020 15:55:00</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Plaka</th>
                                                        <td>35ABC35</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Şehir</th>
                                                        <td>İstanbul</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Profil</th>
                                                        <td>Kapali İhale</td>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <td> <textarea class="card-text" id="note" name="note" rows="4"
                                                                cols="30"
                                                                style="color: #5a5a5a;">İlan uyarı notu yayınlanacak.</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Taban Fiyat</th>
                                                        <td>
                                                            <h3><b>X X X</b></h3>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Teklifiniz</th>
                                                        <td>
                                                            <h3 class="c-red">TL61.000</h3>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="mt-3">
                                                    <a href="#" class="btn btn-blue"><i class="icon-money"></i></a>
                                                    <a href="#" class="btn btn-blue"><i
                                                            class="icon-info-circle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Teklif Arsivi #2-3 act -->
                            <div class="tab-pane fade" id="v-pills-archive" role="tabpanel"
                                aria-labelledby="v-pills-archive-tab">
                            </div>
                            <!-- Mesajlarim #2-4 msg -->
                            <div class="tab-pane fade" id="v-pills-msg" role="tabpanel"
                                aria-labelledby="v-pills-msg-tab">
                                <div class="container">
                                    <h3 class=" text-center">Mesajlar</h3>
                                    <div class="messaging">
                                        <div class="inbox_msg">
                                            <div class="inbox_people">
                                                <div class="headind_srch">
                                                    <div class="recent_heading">
                                                        <h4>Son</h4>
                                                    </div>
                                                    <div class="srch_bar">
                                                        <div class="stylish-input-group">
                                                            <input type="text" class="search-bar" placeholder="Ara">
                                                            <span class="input-group-addon">
                                                                <button type="button"> <i class="fa fa-search"
                                                                        aria-hidden="true"></i> </button>
                                                            </span> </div>
                                                    </div>
                                                </div>
                                                <div class="inbox_chat">
                                                    <div class="chat_list active_chat">
                                                        <div class="chat_people">
                                                            <div class="chat_img"> <img
                                                                    src="https://ptetutorials.com/images/user-profile.png"
                                                                    alt="sunil"> </div>
                                                            <div class="chat_ib">
                                                                <h5>John Doe <span class="chat_date">15 Şubat</span>
                                                                </h5>
                                                                <p>Test, which is a new approach to have all solutions
                                                                    astrology under one roof.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chat_list">
                                                        <div class="chat_people">
                                                            <div class="chat_img"> <img
                                                                    src="https://ptetutorials.com/images/user-profile.png"
                                                                    alt="sunil"> </div>
                                                            <div class="chat_ib">
                                                                <h5>John Doe <span class="chat_date">13 Şubat</span>
                                                                </h5>
                                                                <p>Test, which is a new approach to have all solutions
                                                                    astrology under one roof.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chat_list">
                                                        <div class="chat_people">
                                                            <div class="chat_img"> <img
                                                                    src="https://ptetutorials.com/images/user-profile.png"
                                                                    alt="sunil"> </div>
                                                            <div class="chat_ib">
                                                                <h5>John Doe <span class="chat_date">13 Şubat</span>
                                                                </h5>
                                                                <p>Test, which is a new approach to have all solutions
                                                                    astrology under one roof.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chat_list">
                                                        <div class="chat_people">
                                                            <div class="chat_img"> <img
                                                                    src="https://ptetutorials.com/images/user-profile.png"
                                                                    alt="sunil"> </div>
                                                            <div class="chat_ib">
                                                                <h5>John Doe <span class="chat_date">13 Şubat</span>
                                                                </h5>
                                                                <p>Test, which is a new approach to have all solutions
                                                                    astrology under one roof.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chat_list">
                                                        <div class="chat_people">
                                                            <div class="chat_img"> <img
                                                                    src="https://ptetutorials.com/images/user-profile.png"
                                                                    alt="sunil"> </div>
                                                            <div class="chat_ib">
                                                                <h5>John Doe <span class="chat_date">13 Şubat</span>
                                                                </h5>
                                                                <p>Test, which is a new approach to have all solutions
                                                                    astrology under one roof.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chat_list">
                                                        <div class="chat_people">
                                                            <div class="chat_img"> <img
                                                                    src="https://ptetutorials.com/images/user-profile.png"
                                                                    alt="sunil"> </div>
                                                            <div class="chat_ib">
                                                                <h5>John Doe <span class="chat_date">13 Şubat</span>
                                                                </h5>
                                                                <p>Test, which is a new approach to have all solutions
                                                                    astrology under one roof.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chat_list">
                                                        <div class="chat_people">
                                                            <div class="chat_img"> <img
                                                                    src="https://ptetutorials.com/images/user-profile.png"
                                                                    alt="sunil"> </div>
                                                            <div class="chat_ib">
                                                                <h5>John Doe <span class="chat_date">13 Şubat</span>
                                                                </h5>
                                                                <p>Test, which is a new approach to have all solutions
                                                                    astrology under one roof.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mesgs">
                                                <div class="msg_history">
                                                    <div class="incoming_msg">
                                                        <div class="incoming_msg_img"> <img
                                                                src="https://ptetutorials.com/images/user-profile.png"
                                                                alt="sunil"> </div>
                                                        <div class="received_msg">
                                                            <div class="received_withd_msg">
                                                                <p>12 Şubat</p>
                                                                <span class="time_date"> 11:01 | Şubat 9</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="outgoing_msg">
                                                        <div class="sent_msg">
                                                            <p>Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat
                                                                numune kitabı oluşturmak üzere bir yazı galerisini
                                                                alarak karıştırdığı 1500'lerden beri endüstri standardı
                                                                sahte metinler olarak kullanılmıştır.</p>
                                                            <span class="time_date"> 11:01 | Şubat 9</span>
                                                        </div>
                                                    </div>
                                                    <div class="incoming_msg">
                                                        <div class="incoming_msg_img"> <img
                                                                src="https://ptetutorials.com/images/user-profile.png"
                                                                alt="sunil"> </div>
                                                        <div class="received_msg">
                                                            <div class="received_withd_msg">
                                                                <p>Beşyüz yıl boyunca varlığını sürdürmekle kalmamış,
                                                                    aynı zamanda pek değişmeden elektronik dizgiye de
                                                                    sıçramıştır.</p>
                                                                <span class="time_date"> 11:10 | Dün</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="outgoing_msg">
                                                        <div class="sent_msg">
                                                            <p>1960'larda Lorem Ipsum pasajları da içeren Letraset
                                                                yapraklarının yayınlanması ile ve yakın zamanda Aldus
                                                                PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü
                                                                yayıncılık yazılımları ile popüler olmuştur.</p>
                                                            <span class="time_date"> 12:01 | Bugün</span>
                                                        </div>
                                                    </div>
                                                    <div class="incoming_msg">
                                                        <div class="incoming_msg_img"> <img
                                                                src="https://ptetutorials.com/images/user-profile.png"
                                                                alt="sunil"> </div>
                                                        <div class="received_msg">
                                                            <div class="received_withd_msg">
                                                                <p>1960'larda Lorem Ipsum pasajları da içeren Letraset
                                                                    yapraklarının yayınlanması ile ve yakın zamanda
                                                                    Aldus
                                                                    PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü
                                                                    yayıncılık yazılımları ile popüler olmuştur.</p>
                                                                <span class="time_date"> 12:01 | Bugün</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="type_msg">
                                                    <div class="input_msg_write">
                                                        <input type="text" class="write_msg"
                                                            placeholder="Mesaj Yaz. . ." />
                                                        <button class="msg_send_btn" type="button"><i
                                                                class="fa fa-paper-plane-o"
                                                                aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- İlanlarım in #3 -->
                            <!-- İlan Ekle #3-1 -->
                            <div class="tab-pane fade" id="v-pills-new" role="tabpanel"
                                aria-labelledby="v-pills-new-tab">
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label for="">Arac Plakasi*</label>
                                        <input type="text" class="form-control" placeholder="35 XXX 35">
                                        <small>Not: <b>Hatali plaka yazan ilanlar yayinlanmayacaktir. </b> </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="">Aracin suan ki durumu*</label>
                                        <div class="col">
                                            <select class="custom-select d-block w-100" id="status" required="">
                                                <option value="">Seçiniz</option>
                                                <option>Kazali (En ufak bir onarim görmermiş)</option>
                                                <option>Kazali (Hafif onarımlar yapılmış "makyajlanmış")</option>
                                                <option>İkinci El (Pert kayıtlı)</option>
                                                <option>İkinci El (Pert kayıtsız)</option>
                                            </select>
                                        </div>
                                        <div class="mt-2 text-center">
                                            <a class="btn btn-primary" href="#exampleModal" data-toggle="modal"
                                                role="button">İleri</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- İhaledeki İlanlarım #3-2 -->
                            <div class="tab-pane fade" id="v-pills-bid" role="tabpanel"
                                aria-labelledby="v-pills-bid-tab">
                                <table class="border bordered mt-3">
                                    <tr>
                                        <th>Plaka</th>
                                        <th>Arac Detaylari</th>
                                        <th>Sehir</th>
                                        <th>Profil</th>
                                        <th>Eklenme Tarihi</th>
                                        <th>Ihale Kapanis</th>
                                        <th>Durum</th>
                                        <th>Aciklama</th>
                                        <th>Detay</th>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Sehir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td class="admin-refuse">Admin Ilani Onaylamadi</td>
                                        <td>Yonetici Onaylamadi</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Sehir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td class="live">Yayinda</td>
                                        <td></td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Sehir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td class="cancel">Iptal Edildi</td>
                                        <td>Satici gelen teklifi onaylamadi</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Sehir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td class="waiting-approval">Onay Bekliyor</td>
                                        <td>Ihale kapandi satici onayi bekleniyor</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Sehir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td class="sell">Satildi</td>
                                        <td>Noter Satisi yapildi</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- Doğrudan Satışlarım #3-3 -->
                            <div class="tab-pane fade" id="v-pills-sell" role="tabpanel"
                                aria-labelledby="v-pills-sell-tab">
                                <table class="border bordered mt-3">
                                    <tr>
                                        <th>Plaka</th>
                                        <th>Arac Detaylari</th>
                                        <th>Sehir</th>
                                        <th>Profil</th>
                                        <th>Eklenme Tarihi</th>
                                        <th>Ihale Kapanis</th>
                                        <th>Durum</th>
                                        <th>Detay</th>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Sehir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td class="live">Yayinda</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Sehir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td class="cancel">Suresi bitti</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Sehir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td class="waiting-approval">Onay Bekliyor</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Yorumlar in #4  -->
                            <div class="tab-pane fade" id="v-pills-comments" role="tabpanel"
                                aria-labelledby="v-pills-comments-tab">
                                <table class="border bordered mt-3">
                                    <tr>
                                        <th>Plaka</th>
                                        <th>Arac Detaylari</th>
                                        <th>Sehir</th>
                                        <th>Profil</th>
                                        <th>Yorum Eklenme Tarihi</th>
                                        <th>Ihale Kapanis</th>
                                        <th>Yorum</th>
                                        <th>Detay</th>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Istanbul</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td>guzel bir alisveristi</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Izmir</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td>zahmetsizce hasarli arac satin alabilecegim bir site</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>35 ABN 34</td>
                                        <td>2011 Renault</td>
                                        <td>Ankara</td>
                                        <td>Cekme Belgeli/Pert Kayitli</td>
                                        <td>10.12.2020 15:43</td>
                                        <td>17.12.2020 16:30</td>
                                        <td>tesekkurler</td>
                                        <td><a href="#" class="btn btn-primary"><i class="icon-search"></i></a></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Ayarlar in #5-->
                            <!-- Profili Düzenle #5-1 -->
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                aria-labelledby="v-pills-settings-tab">
                                <h2 for=""> Kullanıcı Profil Düzenlemesi</h2>
                                <a href="packages.php" class="btn btn-primary btn-block mt-1 mb-1" target="blank"
                                    role="button">Paketlerimizi
                                    incelemek icin tikla</a>
                                <select class="custom-select d-block w-100" id="" required="">
                                    <option value="">Paket Değiştir</option>
                                    <option>Gold Standart</option>
                                    <option>Gold Plus</option>
                                    <option>Gold Extra</option>
                                </select>
                                <form>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label for="">Adınız</label>
                                            <input type="text" class="form-control" placeholder="Ad" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Soyadınız</label>
                                            <input type="text" class="form-control" placeholder="Soyad" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Üye olma sebebi*</label>
                                            <div class="col">
                                                <select class="custom-select d-block w-100" id="why" required="">
                                                    <option value="">Seçiniz</option>
                                                    <option>Onarıp kullanmak amacıyla</option>
                                                    <option>Araç alıp satıyorum</option>
                                                    <option>Aracımı satmak istiyorum</option>
                                                    <option>Sadece merak ettim</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col">
                                            <label for="firstName">Cinsiyet*</label>
                                            <select class="custom-select d-block w-100" id="" required="">
                                                <option value="">Seçiniz</option>
                                                <option>Kadın</option>
                                                <option>Erkek</option>
                                                <option>Belirtmek istemiyorum</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="">E-mail*</label>
                                            <input type="email" class="form-control" placeholder="iletisim@info.com">
                                        </div>
                                        <div class="col">
                                            <label for="">GSM No Onay SMS*</label>
                                            <input type="tel" class="form-control" placeholder="(---) --- -- --">
                                        </div>
                                        <div class="col">
                                            <label for="">Sabit Tel</label>
                                            <input type="tel" class="form-control" placeholder="(---) -- --">
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-6">
                                            <label for="firstName">Sehir seciniz*</label>
                                            <select class="custom-select d-block w-100" id="" required="">
                                                <option value="">Seçiniz</option>
                                                <option>Istanbul</option>
                                                <option>Ankara</option>
                                                <option>izmir</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="d-block">Adres*</label>
                                            <textarea id="" rows="4" cols="40"
                                                placeholder="Adresinizi yaziniz"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col">
                                            <a class="btn btn-primary" href="#" role="button">Düzenle</a>
                                            <a class="btn btn-primary" href="#exampleModal3" data-toggle="modal">Şifre Değiştir</a>
                                        </div>
                                    </div>
                                </form>
                                <h2 class="mt-3" for=""> Firma Profil Düzenlemesi</h2>
                                <a href="packages.php" class="btn btn-primary btn-block mt-1 mb-1" target="blank"
                                    role="button">Paketlerimizi
                                    incelemek icin tikla</a>
                                <select class="custom-select d-block w-100" id="" required="">
                                    <option value="">Paket Değiştir</option>
                                    <option>Gold Standart</option>
                                    <option>Gold Plus</option>
                                    <option>Gold Extra</option>
                                </select>
                                <form>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label for="">Firma Unvani</label>
                                            <input type="text" class="form-control" placeholder="" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Adınız</label>
                                            <input type="text" class="form-control" placeholder="" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Soyadınız*</label>
                                            <input type="text" class="form-control" placeholder="" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Üye olma sebebi*</label>
                                            <div class="col">
                                                <select class="custom-select d-block w-100" id="why" required="">
                                                    <option value="">Seçiniz</option>
                                                    <option>Onarıp kullanmak amacıyla</option>
                                                    <option>Araç alıp satıyorum</option>
                                                    <option>Aracımı satmak istiyorum</option>
                                                    <option>Sadece merak ettim</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col">
                                            <label for="firstName">Cinsiyet*</label>
                                            <select class="custom-select d-block w-100" id="" required="">
                                                <option value="">Seçiniz</option>
                                                <option>Kadın</option>
                                                <option>Erkek</option>
                                                <option>Belirtmek istemiyorum</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="">E-mail*</label>
                                            <input type="email" class="form-control" placeholder="iletisim@info.com">
                                        </div>
                                        <div class="col">
                                            <label for="">GSM No Onay SMS*</label>
                                            <input type="tel" class="form-control" placeholder="(---) --- -- --">
                                        </div>
                                        <div class="col">
                                            <label for="">Sabit Tel</label>
                                            <input type="tel" class="form-control" placeholder="(---) -- --">
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col">
                                            <label for="firstName">Sehir seciniz*</label>
                                            <select class="custom-select d-block w-100" id="" required="">
                                                <option value="">Seçiniz</option>
                                                <option>Istanbul</option>
                                                <option>Ankara</option>
                                                <option>izmir</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col">
                                            <label for="">Vergi Dairesi*</label>
                                            <input type="text" class="form-control" placeholder="Kayıtlı olduğunuz"
                                                readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Vergi Dairesi No*</label>
                                            <input type="text" class="form-control" placeholder="Kayıtlı olduğunuz"
                                                readonly>
                                        </div>
                                        <div class="col">
                                            <label for="">Adres*</label>
                                            <textarea id="" rows="4" cols="40"
                                                placeholder="Adresinizi yaziniz"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col">
                                            <a class="btn btn-primary" href="#" role="button">Düzenle</a>
                                            <a class="btn btn-primary" href="#exampleModal3" data-toggle="modal">Şifre
                                                Değiştir</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Cayma Bedelleri #5-2 -->
                            <div class="tab-pane fade" id="v-pills-price" role="tabpanel"
                                aria-labelledby="v-pills-price-tab">
                                <h2>Aktif Cayma Bedelleri</h2>
                                <table class="border bordered mt-3 withdrawal">
                                    <tr>
                                        <th>Gönderildiği Tarih</th>
                                        <td>17.12.2020</td>
                                    </tr>
                                    <tr>
                                        <th>Tutar</th>
                                        <td>TL10.000</td>
                                    </tr>
                                    <tr>
                                        <th>İade Edilen Hesap</th>
                                        <td>GÜRCAN CANKIZ</td>
                                    </tr>
                                    <tr>
                                        <th>İade Edilecek IBAN No</th>
                                        <td>TR320010009999901234567890</td>
                                    </tr>
                                    <tr>
                                        <th>Durum</th>
                                        <td><a href="#exampleModal7" data-toggle="modal" class="btn btn-trans"><i
                                                    class="icon-send-o"> Talebi
                                                    Gonder</i></a></td>
                                    </tr>
                                    <tr>
                                        <th>İşlem</th>
                                        <td><a href="#" class="btn btn-trans"><i class="icon-delete"> Sil</i></a></td>
                                    </tr>
                                </table>
                                <h2 class="mt-3">İade Talep Ettilerim</h2>
                                <!-- burası için .withdrawal-waiting -->
                                <p class="c-red">İade Talep Ettiğiniz Cayme Bedeli yoktur.</p>

                                <h2 class="mt-3">İade Aldıklarım</h2>
                                <!-- burası için .withdrawal-close -->
                                <p class="c-red">İade Ettiğiniz Cayme Bedeli yoktur.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <footer class="site-footer" style="margin-top:1%;">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <h2 class="footer-heading mb-4">İletişim</h2>
          <p>Adres - Çınar Mahallesi 5003/1 Sokak No:9 Ege Plaza Daire:30 Bornova / İzmir</p>
          <p>Sabit Hat - 0 (232) 503 80 13</p>
          <p>Fax ve Sms - 0 (850) 303 98 69</p>
          <p>E-mail - info@pertdunyasi.com</p>
        </div>
        <div class="col-lg-9 ml-auto">
          <div class="row">
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Şirketimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">Hakkımızda</a></li>
                <li><a href="#">Iletisim</a></li>
                <li><a href="#">S.S.S</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Hizmetlerimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">Doğrudan Satış</a></li>
                <li><a href="#">Aracını Sat</a></li>
                <li><a href="#">Araç Değer Tespiti</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Bayiliklerimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">İzmir</a></li>
                <li><a href="#">İstanbul</a></li>
                <li><a href="#">Ankara</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Yararli Linkler</h2>
              <ul class="list-unstyled">
                <li><a href="#">Kullanim Kosul ve Sartlari</a></li>
                <li><a href="#">Gizlilik</a></li>
                <li><a href="#">Site Haritası</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5 text-center">
        <div class="col-md-12">
          <div class="border-top pt-5">
            <p>
              Telif hakkı &copy;
              <script>
                document.write(new Date().getFullYear());
              </script> Tüm Hakları Saklıdır <br>
              Yazılım & Tasarim <a href="https://eabilisim.net.tr/" target="_blank">EA Bilişim Teknolojileri</a>
            </p>
            <img src="images/logo2.png">
          </div>
        </div>
      </div>
    </div>
  </footer>

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
</body>

</html>