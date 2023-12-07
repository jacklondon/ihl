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
  <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet" type="text/css" />
</head>
<?php 
	include("ayar.php");
	if ( $_SESSION['kid'] != "" )
	{
		header("Location: sistem.php");
	}
	
?>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="logo" style="margin-top:0px;">
    <img src="images/pert_logo2.png" alt="" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical" method="POST">
      <h3 class="form-title">Hesabınızla giriş yapın</h3>
      <div id="goster" class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span><?php echo $mesaj; ?></span>
      </div>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Kullanıcı Adı</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Kullanıcı Adınız" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" id="kullanici_adi" name="kullanici_adi"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Parola</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Parolanız" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>" id="sifre" name="sifre"/>
          </div>
        </div>
      </div>
      <img class="guvenlik_resmi" src="img.php"> <div class="yenile_buton">Yenile</div>
			<input type="text" class="m-wrap placeholder-no-fix" placeholder="kodu girin" id="guvenlik_kodu" name="guvenlik_kodu">
      <div class="form-actions">
        <label class="checkbox">
        <input <?php if(isset($_COOKIE["member_login"])) { echo "checked"; } ?> type="checkbox" name="remember" id="remember" value="1" /> Beni Hatırla
        </label>
        <input type="button" onclick="admin_giris();" class="btn yellow pull-right" name="giris" value="Giris">
         <i class="m-icon-swapright m-icon-white"></i>
                  
      </div>
      <div class="forget-password">
        <h4>Parolanızı unuttunuz mu ?</h4>
        <p>
          Parolanızı hatırlamıyorsanız, <a href="sifre_guncelle.php" class="" id="forget-password">buraya tıklayarak</a>
          şifrenizi sıfırlayabilirsiniz.
        </p>
      </div>
      <div class="create-account">
        <p>
          Hala bir hesabınız yok ise ?&nbsp; 
          <a href="javascript:;" id="register-btn" class="">Buraya tıklayarak oluşturabilirsiniz.</a>
        </p>
      </div>
    </form>
    <!-- END LOGIN FORM -->        
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="form-vertical forget-form" action="index.php">
      <h3 class="">Unutulan Parolalar ?</h3>
      <p>Parolanızı sıfırlamak için kayıtlı e-mail adresinizi yazınız.</p>
      <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-envelope"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />
          </div>
        </div>
      </div>
      <div class="form-actions">
        <button type="button" id="back-btn" class="btn">
        <i class="m-icon-swapleft"></i> Geri Dön!
        </button>
        <button type="submit" class="btn yellow pull-right">
        Gönder <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="form-vertical register-form" action="index.php">
      <h3 class="">Yeni Hesap</h3>
      <p>Yeni hesap açamazsınız:</p>
     
      <div class="form-actions">
        <button id="register-back-btn" type="button" class="btn">
        <i class="m-icon-swapleft"></i>  Geri Dön!
        </button>
                  
      </div>
    </form>
    <!-- END REGISTRATION FORM -->
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <!-- <div class="copyright">
    2014 &copy; SistemAl E-Ticaret 1.0
  </div> -->
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.3.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  
  <script src="assets/uniform/jquery.uniform.min.js"></script> 
  <script src="assets/js/jquery.blockui.js"></script>
  <script type="text/javascript" src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="assets/js/app.js?v=<?=time(); ?>"></script>

	<script>

	
	function bakbakalim()
	{
		var deger='<?php echo $hata_ver; ?>';
		if ( deger == 1 ) 
		{ 
			document.getElementById('goster').className='alert alert-error';
		} else { document.getElementById('goster').className='alert alert-error hide';}
	}
	
	bakbakalim();
  
  </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
	$(function(){
		$(".yenile_buton").click(function(){
			$(".guvenlik_resmi").attr("src","img.php?d="+Math.random());
		});
	});
	
	function admin_giris(){
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType:"json",
			data: {
				action: "admin_giris",
				kullanici_adi:$("#kullanici_adi").val(),
				sifre:$("#sifre").val(),
				guvenlik_kodu:$("#guvenlik_kodu").val(),
				remember:$("#remember").val(),
			},
			success: function(data) {
				console.log(data);
				if(data.status==200){
					window.location.href = "sistem.php";
				}else{
					alert(data.message);
				}
			
				
			}
		});
	}
	/*function admin_giris(){
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType:"json",
			data: {
				action: "admin_giris",
				kullanici_adi:$("#kullanici_adi").val(),
				sifre:$("#sifre").val(),
				guvenlik_kodu:$("#guvenlik_kodu").val(),
			},
			success: function(data) {
				console.log(data);
				if(data.status==200){
					if(data.onay_durum==0){
						console.log(data.onay_kodu);
						console.log(data.admin_id);
						var onay_kodu=data.onay_kodu;
						var durum=true;
						while(durum==true){
							let person = prompt("GSM Onay Kodu:");
							if (person == onay_kodu ) {
								jQuery.ajax({
									url: "https://ihale.pertdunyasi.com/check.php",
									type: "POST",
									dataType: "JSON",
									data: {
										action: "admin_onayla",
										admin_id:data.admin_id,
										onay_kod:person,
									},
									success: function(response) {
										if(response.status==200){
											durum=false;
											window.location.href = "sistem.php";
											
										}
									}
								});
								break;
							} else if(person=="" || person==null){
								break;
							}else {
								console.log(onay_kodu);
							}
						}
						if(durum==false){
							window.location.href = "sistem.php";
						}
					}else if(data.status==200){
						window.location.href = "sistem.php";
					}else{
						alert(data.message);
					}
				}else{
					alert(data.message);
				}
				
			}
		});
	}*/
</script>
  <!-- END JAVASCRIPTS -->
</body>
<style>
			.yenile_buton{
				padding:14px 25px;
				margin-top:10px;
				background:#333;
				color:#fff;
				font-weight:bold;
				cursor:pointer;
        width:60%;
				margin:10px;
				float:left;
				text-align:center
			}

		
			.guvenlik_resmi{

			
        width:90%
			}
		
		</style>
<!-- END BODY -->
</html>