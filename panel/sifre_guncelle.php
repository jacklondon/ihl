<!DOCTYPE html>
<!--[if IE 8]> <html lang="tr" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="tr" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="tr"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8" />
  <title>SistemAl E-Ticaret</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/metro.css" rel="stylesheet" />
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/style_responsive.css" rel="stylesheet" />
  <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
  <link rel="shortcut icon" href="favicon.ico" />
</head>
<?php 
	include("ayar.php");
	if ( $_SESSION['kid'] != "" )
	{
		header("Location: sistem.php");
	}

    if(re("action")=="sifre_talebi")
    {

        $kullanici_adi=re("kullanici_adi");

        $select=mysql_query("Select * from kullanicilar where kullanici_adi='".$kullanici_adi."'");
        $kullanici_cek=mysql_fetch_assoc($select);

        $yeni_sifre = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,6);

        $sifre="Pert Dünyası Ekibi --   Yeni Şifreniz:". $yeni_sifre;
        $sifre_guncelle = mysql_query("update kullanicilar set sifre = '".md5($yeni_sifre)."' where id = '".$kullanici_cek["id"]."'");


        coklu_sms_gonder_admin($kullanici_cek["id"],$sifre,6);
    }
	
?>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="logo" style="margin-top:0px;">
    <img src="https://ihale.pertdunyasi.com/images/sistemal.png" alt="" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical" method="POST">
      <h3 class="form-title">Sms İle Şifre Alma</h3>
      <div id="goster" class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span><?php echo $mesaj; ?></span>
      </div>
      <input type="hidden" name="action" value="sifre_talebi">
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Kullanıcı Adı</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Kullanıcı Adınız" name="kullanici_adi"/>
          </div>
        </div>
      </div>
        <button type="submit"  class="btn btn-block" value="Şifre Gönder">Şifre Gönder</button>
   
    </form>
    <!-- END REGISTRATION FORM -->
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    2014 &copy; SistemAl E-Ticaret 1.0
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.3.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  
  <script src="assets/uniform/jquery.uniform.min.js"></script> 
  <script src="assets/js/jquery.blockui.js"></script>
  <script type="text/javascript" src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="assets/js/app.js"></script>
  

</body>

<!-- END BODY -->
</html>