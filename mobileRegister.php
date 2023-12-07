<?php 
    session_start();
    $token = $_SESSION['u_token'];
    $k_token = $_SESSION['k_token'];
    if($token != "" && $k_token == "")
    {
        $uye_token = $token;
    }
    elseif($token == "" && $k_token != "")
    {
        $uye_token = $k_token;
    }
    
    include 'ayar.php';
  
    $duyuru_cek = mysql_query("SELECT * FROM duyurular WHERE durum = 1");

    $sehir_cek = mysql_query("SELECT * FROM sehir"); 
    while($sehir_oku = mysql_fetch_object($sehir_cek)){
        $sehirler .= '<option value="'.$sehir_oku->sehirID.'">'.$sehir_oku->sehiradi.'</option>';
    }

    $kullanim_cek=mysql_query("select * from pdf order by id desc limit 1");
    $kullanim_oku=mysql_fetch_object($kullanim_cek);
?>
<!doctype html>
<html lang="en">
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
        <link rel="stylesheet" href="css/style.css?v=<?=time() ?>">
        <link rel="stylesheet" href="css/metin.css?v=<?=time() ?>">
        <link rel="stylesheet" href="css/custom.css">
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
        <div class="customSplashScreenOuter" style="background-image:url('images/sliders/f7470798a2c7389d43b6c8c52cc2c055.png');">

            <div class="customMobileLoginPageInner">
                <img class="customMobileLoginPageLogo" src="images/logo2.png" />
                <div class="mobileRegisterTabsOuter">
                    <div class="mobileRegisterTabBox mobileRegisterTabSelect" id="registerTab1" onclick="registerTabSelect(1)">
                        Bireysel
                    </div>
                    <div class="mobileRegisterTabBox" id="registerTab2" onclick="registerTabSelect(2)">
                        Kurumsal
                    </div>
                </div>
                <div id="registerTabContents1" style="display:block;">
                <strong class="u_mesaj" style="padding: 5px;color:white;"></strong>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Ad Soyad*</p>
                        <input type="text" style="text-transform: capitalize;" placeholder="Adınızı ve Soyadınızı Giriniz." name="ad" id="u_ad"
                                        placeholder="Ad" pattern="\b\w+\b(?:.*?\b\w+\b){1}"
                                        oninvalid="this.setCustomValidity('Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.')"
                                        oninput="this.setCustomValidity('')" />
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Üye Olma Sebebi*</p>
                        <select id="u_sebep" name="sebep" >
                            <option value="">Seçiniz</option>
                            <option value="Onarıp kullanmak amacıyla">Onarıp kullanmak amacıyla</option>
                            <option value="Araç alıp satıyorum">Araç alıp satıyorum</option>
                            <option value="Aracımı satmak istiyorum">Aracımı satmak istiyorum</option>
                            <option value="Sadece merak ettim">Sadece merak ettim</option>
                        </select>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Cinsiyet*</p>
                        <select id="u_cinsiyet" name="cinsiyet">
                            <option value="">Seçiniz</option>
                            <option value="Kadin">Kadın</option>
                            <option value="Erkek">Erkek</option>
                            <option value="belirtmemis">Belirtmek istemiyorum</option>
                        </select>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>E-Posta Adresi*</p>
                        <input type="text" id="u_email" name="mail" placeholder="E-Posta Adresinizi Giriniz." />
                        <label class="kontrol_yaz"> </label>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>GSM No Onay SMS*</p>
                        <input type="tel" id="u_tel" name="gsm" placeholder="(---) --- -- --" maxlength="14" />
                        <label class="tel_kontrol_yaz" style="color:red;"></label>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Doğum Tarihi*</p>
                        <input type="date" id="u_dogum_tarihi" name="u_dogum_tarihi"/>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Şehir Seçiniz*</p>
                        <select name="sehir" id="sehir">
                            <option value="">Seçiniz</option>
                            <?= $sehirler ?>
                        </select>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>İlçe Seçiniz*</p>
                        <select name="ilce" id="ilce">
                            <option value="">Seçiniz</option>
                        </select>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Şifre*</p>
                        <input type="password" id="u_sifre" name="sifre" placeholder="Şifrenizi Giriniz." />
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Şifre Tekrar*</p>
                        <input type="password" id="u_sifre_tekrar" name="sifre_tekrar" placeholder="Şifrenizi Tekrar Giriniz." />
                    </div>
                    <div class="mobileRegisterCheckOuter">
                        <input type="checkbox" id="u_kullanim_sartlari" class="checkbox_check" name="kulanim_sartlari" value="1" />
                        <p>
                            <a href="<?=$kullanim_oku->kullanim_sartlari ?>" target="blank"> Kullanım Şartları</a>'nı okudum, anladım ve kabul ediyorum.
                        </p>
                    </div>
                    <button class="customMobileLoginBtn" id="uye_kayitol">
                        Kaydol
                    </button>
                </div>
                <div id="registerTabContents2" style="display:none;">
                    <strong class="k_mesaj" style="padding: 5px;color:white;"></strong>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Firma Ünvanı*</p>
                        <input type="text" id="unvan" name="unvan" placeholder="Unvaniniz" style="text-transform: capitalize;" pattern="\b\w+\b(?:.*?\b\w+\b){1}"
                        oninvalid="this.setCustomValidity('Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.')" oninput="this.setCustomValidity('')" />
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Yetkili Ad Soyad*</p>
                        <input type="text" style="text-transform: capitalize;" id="kurumsal_ad" name="kurumsal_ad" placeholder="Ad" pattern="\b\w+\b(?:.*?\b\w+\b){1}" 
                            oninvalid="this.setCustomValidity('Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.')" oninput="this.setCustomValidity('')"/>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Üye Olma Sebebi*</p>
                        <select name="kurumsal_sebep" id="why">
                            <option value="">Seçiniz</option>
                            <option value="Onarıp kullanmak amacıyla">Onarıp kullanmak amacıyla</option>
                            <option value="Araç alıp satıyorum">Araç alıp satıyorum</option>
                            <option value="Aracımı satmak istiyorum">Aracımı satmak istiyorum</option>
                            <option value="Sadece merak ettim">Sadece merak ettim</option>
                        </select>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>E-Posta Adresi*</p>
                        <input type="text" id="k_email" name="kurumsal_mail" placeholder="iletisim@info.com" />
                        <label class="k_kontrol_yaz"> </label>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Şehir Seçiniz*</p>
                        <select name="kurumsal_sehir" id="kurumsal_city">
                            <option value="">Seçiniz</option>
                            <?= $sehirler ?>
                        </select>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>İlçe Seçiniz*</p>
                        <select name="kurumsal_ilce" id="kurumsal_ilce">
                            <option value="">Seçiniz</option>
                        </select>
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Doğum Tarihi*</p>
                        <input type="date" id="k_dogum_tarihi" name="k_dogum_tarihi" />
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Şifre*</p>
                        <input type="password" name="sifre" id="k_sifre" placeholder="Şifrenizi Giriniz." />
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>Şifre Tekrar*</p>
                        <input type="password" name="sifre_tekrar" id="k_sifre_tekrar" placeholder="Şifrenizi Tekrar Giriniz." />
                    </div>
                    <div class="customMobileLoginPageInputOuter">
                        <p>GSM No Onay SMS*</p>
                        <input type="tel" placeholder="(---) --- -- --" id="k_tel" name="kurumsal_tel" maxlength="14" />
                        <label class="k_tel_kontrol_yaz" style="color:red;"> </label>
                    </div>
                    <div class="mobileRegisterCheckOuter">
                        <input type="checkbox"  class="checkbox_check" id="k_kullanim_sartlari" name="k_kullanim_sartlari" value="1"/>
                        <p>
                            <a href="<?=$kullanim_oku->kullanim_sartlari ?>" target="blank"> Kullanım Şartları</a>'nı okudum, anladım ve kabul ediyorum.
                        </p>
                    </div>
                    <button class="customMobileLoginBtn" id="k_kayitol" name="kurumsal_gonder" value="Kayit Ol">
                        Kaydol
                    </button>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="js/il_ilce.js?v=62"></script>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
        <script>
        $('input[type="tel"]').mask('0(000)000-0000');
        </script>
        <script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
	    <script>
	        setInterval(function(){
                cikis_yap("<?=$uye_token?>");
            }, 300001);
	        // son_islem_guncelle("<?=$uye_token?>");
			setInterval(function(){ bildirim_sms(); }, 1000);

            function registerTabSelect(item)
            {
                if(item == 1)
                {
                    document.getElementById("registerTab1").classList.add("mobileRegisterTabSelect");
                    document.getElementById("registerTab2").classList.remove("mobileRegisterTabSelect");
                    document.getElementById("registerTabContents1").style.display = "block";
                    document.getElementById("registerTabContents2").style.display = "none";
                }
                else
                {
                    document.getElementById("registerTab1").classList.remove("mobileRegisterTabSelect");
                    document.getElementById("registerTab2").classList.add("mobileRegisterTabSelect");
                    document.getElementById("registerTabContents2").style.display = "block";
                    document.getElementById("registerTabContents1").style.display = "none";
                }
            }
	    </script>
        <script>
            $('#u_tel').on('change', function() {
                jQuery.ajax({
                    url: "https://ihale.pertdunyasi.com/register_add.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        action: "tel_kontrol",
                        tel: document.getElementById('u_tel').value,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            $(".tel_kontrol_yaz").html(response.message);
                            $(".tel_kontrol_yaz").css("color", "green");
                        } else {
                            $(".tel_kontrol_yaz").html(response.message);
                            $(".tel_kontrol_yaz").css("color", "red");
                        }
                    }
                });
            });
            $('#u_email').on('change', function() {
                jQuery.ajax({
                    url: "https://ihale.pertdunyasi.com/register_add.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        action: "email_kontrol",
                        email: document.getElementById('u_email').value,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            $(".kontrol_yaz").html(response.message);
                            $(".kontrol_yaz").css("color", "green");
                        } else {
                            $(".kontrol_yaz").html(response.message);
                            $(".kontrol_yaz").css("color", "red");
                        }
                    }
                });
            });
            $('#k_email').on('change', function() {
                jQuery.ajax({
                    url: "https://ihale.pertdunyasi.com/register_add.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        action: "email_kontrol",
                        email: document.getElementById('k_email').value,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            $(".k_kontrol_yaz").html(response.message);
                            $(".k_kontrol_yaz").css("color", "green");
                        } else {
                            $(".k_kontrol_yaz").html(response.message);
                            $(".k_kontrol_yaz").css("color", "red");
                        }
                    }
                });
            });
            $('#k_tel').on('change', function() {
                jQuery.ajax({
                    url: "https://ihale.pertdunyasi.com/register_add.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        action: "tel_kontrol",
                        tel: document.getElementById('k_tel').value,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            $(".k_tel_kontrol_yaz").html(response.message);
                            $(".k_tel_kontrol_yaz").css("color", "green");
                        } else {
                            $(".k_tel_kontrol_yaz").html(response.message);
                            $(".k_tel_kontrol_yaz").css("color", "red");
                        }
                    }
                });
            });
            $('#uye_kayitol').on('click', function() {
                if ($('input.checkbox_check').is(':checked')) {
                    jQuery.ajax({
                    url: "https://ihale.pertdunyasi.com/register_add.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        action: "Kaydol",
                        u_ad: document.getElementById('u_ad').value,
                        u_sebep: document.getElementById('u_sebep').value,
                        u_cinsiyet: document.getElementById('u_cinsiyet').value,
                        u_email: document.getElementById('u_email').value,
                        u_dogum_tarihi: document.getElementById('u_dogum_tarihi').value,
                        u_tel: document.getElementById('u_tel').value,
                        ilce: document.getElementById('ilce').value,
                        sehir: document.getElementById('sehir').value,
                        u_sifre: document.getElementById('u_sifre').value,
                        u_sifre_tekrar: document.getElementById('u_sifre_tekrar').value,
                        u_kullanim_sartlari: document.getElementById('u_kullanim_sartlari').value,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status != 200) {
                            $(".u_mesaj").html(response.message);
                            $(".u_mesaj").css("background", "red");
                        } else {
                            $.ajax({
                                url:"sifre_sifirla.php",
                                type:"POST",
                                cache:false,
                                dataType: "JSON",
                                data:{
                                    action:"yeni_kullanici",
                                    telefon: document.getElementById('u_tel').value
                                },
                                success:function(data){
                                    alert(data.message);
                                    if(data.modal == 1){                                
                                        localStorage.setItem('Onay',0);
                                        localStorage.setItem('gsm',document.getElementById('u_tel').value);
                                        localStorage.setItem('confirm_user_token',data.user_token);   
                                        window.location.href = 'mobileRegisterCode.php'; 
                                    }else{
                                        if(data.user_token != ""){
                                            window.location.href = 'uye_panel/success.php';
                                        }else if(data.kurumsal_token != ""){
                                            window.location.href = 'kurumsal_panel/success.php';
                                        }
                                    }		
                                }  
                            });
                        }
                    }
                });
                }else{
                    alert('Devam etmek için Kullanım Şartlarını onaylamanız gerekmektedir.');
                }   
            });
            $('#k_kayitol').on('click', function() {
                if ($('input.checkbox_check').is(':checked')) {
                    jQuery.ajax({
                        url: "https://ihale.pertdunyasi.com/register_add_kurumsal.php",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            action: "Kayit Ol",
                            unvan: document.getElementById('unvan').value,
                            kurumsal_ad: document.getElementById('kurumsal_ad').value,
                            sebep: document.getElementById('why').value,
                            k_email: document.getElementById('k_email').value,
                            kurumsal_city: document.getElementById('kurumsal_city').value,
                            kurumsal_ilce: document.getElementById('kurumsal_ilce').value,
                            k_tel: document.getElementById('k_tel').value,
                            k_dogum_tarihi: document.getElementById('k_dogum_tarihi').value,
                            k_sifre: document.getElementById('k_sifre').value,
                            k_sifre_tekrar: document.getElementById('k_sifre_tekrar').value,
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status != 200) {              
                                $(".k_mesaj").html(response.message);
                                $(".k_mesaj").css("color", "red");
                            } else {
                                jQuery.ajax({
                                    url:"sifre_sifirla.php",
                                    type:"POST",
                                    dataType: "JSON",
                                    cache:false,
                                    data:{
                                        action:"yeni_kullanici",
                                        telefon: document.getElementById('k_tel').value
                                        },
                                    success: function(data){
                                        alert(data.message);
                                        if(data.modal == 1){                               
                                            localStorage.setItem('Onay',0);
                                            localStorage.setItem('gsm',document.getElementById('k_tel').value);
                                            localStorage.setItem('confirm_user_token',data.user_token);    
                                            window.location.href = 'mobileRegisterCode.php'; 
                                        }else{
                                            if(data.user_token != ""){
                                                window.location.href = 'uye_panel/success.php';
                                            }else if(data.kurumsal_token != ""){
                                                window.location.href = 'kurumsal_panel/success.php';
                                            }
                                        }	
                                    }  
                                });
                            }
                        }
                    });
                }else{
                    alert('Devam etmek için Kullanım Şartlarını onaylamanız gerekmektedir.');
                }
            });
        </script>
    </body>
</html>