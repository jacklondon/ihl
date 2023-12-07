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
include 'modal.php';
include 'alert.php';
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

  <!-- MAIN CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/custom.css">

</head>

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

  <?php include 'header.php'; ?>

    <div class="ftco-blocks-cover-1">
      <div class="ftco-cover-1 innerpage overlay" style="background-image: url('images/hero_2.jpg')">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
              <span class="d-block mb-3 text-white" data-aos="fade-up">11.02.2021 <span
                  class="mx-2 text-primary">&bullet;</span> Admin Tarafindan</span>
              <h1 class="mb-4" data-aos="fade-up" data-aos-delay="100">Neden Kullanırız?</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-8 blog-content">
            <p class="lead">
              Yinelenen bir sayfa i&ccedil;eriğinin okuyucunun dikkatini dağıttığı bilinen bir ger&ccedil;ektir.
              Lorem Ipsum kullanmanın amacı, s&uuml;rekli 'buraya metin gelecek, buraya metin gelecek' yazmaya kıyasla
              daha dengeli bir harf dağılımı sağlayarak okunurluğu artırmasıdır. Şu anda bir&ccedil;ok
              masa&uuml;st&uuml; yayıncılık paketi ve web sayfa d&uuml;zenleyicisi, varsayılan mıgır metinler olarak
              Lorem Ipsum kullanmaktadır. Ayrıca arama motorlarında 'lorem ipsum' anahtar s&ouml;zc&uuml;kleri ile
              arama yapıldığında hen&uuml;z tasarım aşamasında olan &ccedil;ok sayıda site listelenir. Yıllar
              i&ccedil;inde, bazen kazara, bazen bilin&ccedil;li olarak (&ouml;rneğin mizah katılarak), &ccedil;eşitli
              s&uuml;r&uuml;mleri geliştirilmiştir.
            </p>

            <div class="pt-5">
              <p>Kategoriler: <a href="#">Kategori 1</a>, <a href="#">Kategori 2</a>
                Etiketler: <a href="#">#etiket1</a>, <a href="#">#etiket2</a></p>
            </div>

            <div class="pt-5">
              <h3 class="mb-5">3 Yorum</h3>
              <ul class="comment-list">
                <li class="comment">
                  <div class="vcard bio">
                    <img src="images/person_2.jpg" alt="Free Website Template by Free-Template.co">
                  </div>
                  <div class="comment-body">
                    <h3>Jane Doe</h3>
                    <div class="meta">09.01.2021 12:34</div>
                    <p>Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah
                      katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı
                      kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir.</p>
                    <p><a href="#" class="reply">Cevapla</a></p>
                  </div>
                </li>

                <li class="comment">
                  <div class="vcard bio">
                    <img src="images/person_3.jpg" alt="Free Website Template by Free-Template.co">
                  </div>
                  <div class="comment-body">
                    <h3>Jane Doe</h3>
                    <div class="meta">09.01.2021 14:34</div>
                    <p>İnternet'teki tüm Lorem Ipsum üreteçleri önceden belirlenmiş metin bloklarını yineler. Bu da, bu
                      üreteci İnternet üzerindeki gerçek Lorem Ipsum üreteci yapar. Bu üreteç, 200'den fazla Latince
                      sözcük ve onlara ait cümle yapılarını içeren bir sözlük kullanır.</p>
                    <p><a href="#" class="reply">Cevapla</a></p>
                  </div>

                  <ul class="children">
                    <li class="comment">
                      <div class="vcard bio">
                        <img src="images/person_5.jpg" alt="Free Website Template by Free-Template.co">
                      </div>
                      <div class="comment-body">
                        <h3>Jean Doe</h3>
                        <div class="meta">09.01.2021 16:34</div>
                        <p>Bu nedenle, üretilen Lorem Ipsum metinleri yinelemelerden, mizahtan ve karakteristik olmayan
                          sözcüklerden uzaktır.</p>
                        <p><a href="#" class="reply">Cevapla</a></p>
                      </div>
                    </li>
                  </ul>
                </li>

                <li class="comment">
                  <div class="vcard bio">
                    <img src="images/person_1.jpg" alt="Free Website Template by Free-Template.co">
                  </div>
                  <div class="comment-body">
                    <h3>Jean Doe</h3>
                    <div class="meta">11.01.2021 11:32</div>
                    <p>Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu
                      yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır.</p>
                    <p><a href="#" class="reply">Cevapla</a></p>
                  </div>
                </li>
              </ul>
              <!-- END comment-list -->

              <div class="comment-form-wrap pt-5">
                <h3 class="mb-5">Bir yorum yaz</h3>
                <form action="#" class="">
                  <div class="form-group">
                    <label for="">Adınız *</label>
                    <input type="text" class="form-control" id="">
                  </div>
                  <div class="form-group">
                    <label for="">Soyadınız *</label>
                    <input type="text" class="form-control" id="">
                  </div>
                  <div class="form-group">
                    <label for="">Email *</label>
                    <input type="" class="form-control" id="">
                  </div>

                  <div class="form-group">
                    <label for="">Mesaj</label>
                    <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <input type="submit" value="Gönder" class="btn btn-primary btn-md text-white">
                  </div>
                </form>
              </div>
            </div>

          </div>
          <div class="col-md-4 sidebar">
            <div class="sidebar-box">
              <form action="#" class="search-form">
                <div class="form-group">
                  <span class="icon fa fa-search"></span>
                  <input type="text" class="form-control" placeholder="Bir kelime yaz">
                </div>
              </form>
            </div>
            <div class="sidebar-box">
              <div class="categories">
                <h3>Kategoriler</h3>
                <li><a href="#">Kategori 1 <span>(3)</span></a></li>
                <li><a href="#">Kategori 2<span>(5)</span></a></li>
                <li><a href="#">Kategori 3<span>(2)</span></a></li>
                <li><a href="#">Kategori 4<span>(1)</span></a></li>
                <li><a href="#">Kategori 5<span>(15)</span></a></li>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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
</body>

</html>