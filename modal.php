<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/il_ilce.js?v=62"></script>
<?php $sehir_cek = mysql_query("SELECT * FROM sehir"); 
  $sehir_cek2 = mysql_query("SELECT * FROM sehir");   
?>
<style>
.modal-backdrop {
    z-index: 9999;
}

.modal {
    z-index: 99999;
}
@media only screen and (max-width: 600px) 
{
    .input_box_outer
    {
        margin-top:10px;
    }
}
</style>
<!-- Modal Sign-Up -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="kayit_ol_modal_kapat" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding:10px;">
                <div class="container" style="padding:10px;">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active c-second" id="user-tab" data-toggle="tab" href="#user" role="tab"
                                aria-controls="user" aria-selected="true">Bireysel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link c-second" id="company-tab" data-toggle="tab" href="#company" role="tab"
                                aria-controls="company" aria-selected="false">Kurumsal</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">
                            <strong class="u_mesaj"></strong>
                            <form method="POST" name="form" >
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="">Ad Soyad*</label>
                                        <input type="text" style="text-transform: capitalize;" required class="form-control" name="ad" id="u_ad"
                                            placeholder="Ad" pattern="\b\w+\b(?:.*?\b\w+\b){1}"
                                            oninvalid="this.setCustomValidity('Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.')"
                                            oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="">Üye olma sebebi*</label>
                                        <select id="u_sebep" name="sebep" class="form-control custom-select d-block w-100" required>
                                            <option value="">Seçiniz</option>
                                            <option value="Onarıp kullanmak amacıyla">Onarıp kullanmak amacıyla
                                            </option>
                                            <option value="Araç alıp satıyorum">Araç alıp satıyorum</option>
                                            <option value="Aracımı satmak istiyorum">Aracımı satmak istiyorum
                                            </option>
                                            <option value="Sadece merak ettim">Sadece merak ettim</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="firstName">Cinsiyet*</label>
                                        <select id="u_cinsiyet" name="cinsiyet" class="form-control custom-select d-block w-100"required>
                                            <option value="">Seçiniz</option>
                                            <option value="Kadin">Kadın</option>
                                            <option value="Erkek">Erkek</option>
                                            <option value="belirtmemis">Belirtmek istemiyorum</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="row mt-5">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="">E-mail*</label>
                                        <input type="text" id="u_email" required class="form-control" name="mail" placeholder="iletisim@info.com">
										 <!-- <input type="email" id="u_email" required class="form-control" name="mail"
                                            onkeyup="javascript:modal_kontrol('u_email')" 
                                            placeholder="iletisim@info.com"> -->
                                        <label class="kontrol_yaz"> </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="">GSM No Onay SMS*</label>
                                        <input type="tel" required class="form-control" id="u_tel" name="gsm" placeholder="(---) --- -- --">
                                        <label class="tel_kontrol_yaz"> </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="">Doğum Tarihi</label>
                                        <input type="date" id="u_dogum_tarihi" class="form-control" name="u_dogum_tarihi">                                      
                                    </div>
                                    <!-- <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="">Sabit Tel</label>
                                        <input type="tel" id="u_sabit_tel"
                                            class="form-control" name="sabit_tel"
                                            placeholder="(---) -- --">
                                        <label class="sabit_tel_kontrol_yaz"> </label>
                                    </div> -->
                                </div>
                                <div class="row mt-5">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="firstName">Sehir seciniz*</label>
                                        <select name="sehir" class="form-control custom-select d-block w-100" id="sehir" required>
                                            <option value="">Seçiniz</option>
                                            <?php
                                            while($sehir_oku = mysql_fetch_array($sehir_cek)){                   
                                            ?>
                                            <option value="<?= $sehir_oku['sehirID'] ?>"><?=$sehir_oku["sehiradi"];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                    <label for="IDofInput">İlçe</label>
                                    <select name="ilce" id="ilce" class="form-control custom-select d-block w-100" disabled>
                                        <option value="">İlçe seçin</option>
                                    </select>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="">Şifre*</label>
                                        <input type="password" required class="form-control" id="u_sifre" name="sifre" placeholder="">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="">Şifre Tekrar*</label>
                                        <input type="password" required class="form-control" id="u_sifre_tekrar" name="sifre_tekrar" placeholder="">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for=""> 
                                            <input type="checkbox" id="u_kullanim_sartlari" class="checkbox_check" name="kullanim_sartlari" value="1">
											<?php 
												$kullanim_cek=mysql_query("select * from pdf order by id desc limit 1");
												$kullanim_oku=mysql_fetch_object($kullanim_cek);
											?>
                                            <a href="<?=$kullanim_oku->kullanim_sartlari ?>" target="blank"> Kullanım Şartları</a>
                                            okudum, anladım ve kabul ediyorum.</label><br>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input style="color: #fff;background-color: #f7941e;border-color: #f7941e;" type="button" id="uye_kayitol" class="btn btn-block" name="gonder" value="Kaydol">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="company" role="tabpanel" aria-labelledby="company-tab">
                            <strong class="k_mesaj"></strong>
                            <form method="POST">
                                <div class="row mt-3">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Degree">Firma Unvani*</label>
                                        <input type="text" id="unvan" name="unvan" required class="form-control"
                                            placeholder="Unvaniniz" style="text-transform: capitalize;" pattern="\b\w+\b(?:.*?\b\w+\b){1}"
                                            oninvalid="this.setCustomValidity('Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.')"
                                            oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Name">Yetkili Ad Soyad*</label>
                                        <input type="text" style="text-transform: capitalize;" id="kurumsal_ad" name="kurumsal_ad" required
                                            class="form-control" placeholder="Ad" pattern="\b\w+\b(?:.*?\b\w+\b){1}"
                                            oninvalid="this.setCustomValidity('Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.')"
                                            oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Reason">Üye olma sebebi*</label>
                                        <select name="kurumsal_sebep" class="form-control custom-select d-block w-100" id="why"
                                            required>
                                            <option value="">Seçiniz</option>
                                            <option value="Onarıp kullanmak amacıyla">Onarıp kullanmak amacıyla
                                            </option>
                                            <option value="Araç alıp satıyorum">Araç alıp satıyorum</option>
                                            <option value="Aracımı satmak istiyorum">Aracımı satmak istiyorum
                                            </option>
                                            <option value="Sadece merak ettim">Sadece merak ettim</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Email">E-mail*</label>
                                        <input type="text" id="k_email" name="kurumsal_mail"
											required class="form-control"
                                            placeholder="iletisim@info.com">
										<!-- <input type="email" id="k_email" name="kurumsal_mail"
                                            onkeyup="javascript:modal_kontrol('k_email')" required class="form-control"
                                            placeholder="iletisim@info.com"> -->
                                        <label class="k_kontrol_yaz"> </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="City">Sehir seciniz*</label>
                                        <select name="kurumsal_sehir" class="form-control custom-select d-block w-100"
                                            id="kurumsal_city" required>
                                            <option value="">Seçiniz</option>
                                            <?php                           
                                            while($sehir_oku2 = mysql_fetch_array($sehir_cek2)){                   
                                            ?>
                                            <option value="<?= $sehir_oku2['sehirID'] ?>"><?=$sehir_oku2["sehiradi"];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                    <label for="IDofInput">İlçe</label>
                                    <select name="kurumsal_ilce" id="kurumsal_ilce" class="form-control custom-select d-block w-100" disabled>
                                        <option value="">İlçe seçin</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Phone">Doğum Tarihi</label>
                                        <input id="k_dogum_tarihi" name="k_dogum_tarihi" type="date" class="form-control">
                                        
                                    </div>
                                    <!-- <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Phone">Sabit Tel(Varsa)</label>
                                        <input id="k_sabit_tel" name="kurumsal_sabit_telefon" 
                                            type="tel" class="form-control"
                                            placeholder="(---) -- --">
                                        <label class="k_sabit_tel_kontrol_yaz"> </label>
                                    </div> -->
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Password">Şifre*</label>
                                        <input name="sifre" id="k_sifre" required type="password" class="form-control"
                                            placeholder="">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Password">Şifre Tekrar*</label>
                                        <input name="sifre_tekrar" id="k_sifre_tekrar" required type="password"
                                            class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row mt-5">
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 input_box_outer">
                                        <label for="Phone">GSM No Onay SMS*</label>
                                        <input type="tel" id="k_tel" name="kurumsal_tel" required
                                             class="form-control"
                                            placeholder="(---) --- -- --">
                                        <label class="k_tel_kontrol_yaz"> </label>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="Terms of"> 
                                        <input class="checkbox_check" type="checkbox" required id="k_kullanim_sartlari" name="k_kullanim_sartlari" value="1" >
                                        <a href="kullanim-sartlari.pdf" target="blank"> Kullanım Şartları</a> okudum, anladım ve kabul ediyorum.</label><br>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 input_box_outer">
                                        <input style="color: #fff;background-color: #f7941e;border-color: #f7941e;" type="button" class="btn btn-block" id="k_kayitol"
                                            name="kurumsal_gonder" value="Kayit Ol" >
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / END Modal Sign-Up -->

<!-- Modal Login -->
<div class="modal fade" style="margin-top:2%;" id="exampleModal2" tabindex="-1" role="dialog"aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"  aria-label="Close" id="kapat_btn">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="login_controller.php" method="POST">
                        <div class="row">
                            <div class="col">
                                <label for="">GSM No*</label>
                                <input type="tel" name="gsm"
                                    value="<?php re("gsm")?>"  class="form-control form-control-sm"
                                    placeholder="(---) --- -- --">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <label for="">Şifre*</label>
                                <input type="password" name="sifre" class="form-control form-control-sm" placeholder="">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col">
                                <a href="#exampleModal3" data-toggle="modal" id="fpass" onclick="modal_kapat();"  ><i><b>Şifremi unuttum?</b></i></a>                                
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <input style="color: #fff;background-color: #f7941e;border-color: #f7941e;" type="submit" name="giris" class="btn btn-block" value="Giris Yap">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / END Modal Login -->

<!-- Onay Modal Begın -->

<div class="modal fade show" style="margin-top:2%;" id="onay_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="temizle();" aria-label="Close" id="kapat_btn_onay">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="login_controller.php" method="POST">
                        <input name="action" value="onay_kodu" type="hidden"> 
						<input name="gsm" value="" type="hidden"> 
                        <div class="row">
                            <div class="col">
                                <label for="">Sms Onay Kodu*</label>
                                <input type="text" name="gsm_onaykodu"  class="form-control form-control-sm" required>
                            </div>
                        </div>                     
                        <div class="row mt-5">
                            <div class="col">
                                <input style="color: #fff;background-color: #f7941e;border-color: #f7941e;" type="submit" name="onay_kodu" class="btn btn-block" value="Doğrula">
                            </div>
                        </div>
						 <div class="row mt-5">
                            <div class="col">
                                <input style="color: #fff;background-color: #f7941e;border-color: #f7941e;" type="button" onclick="yeniOnayKodu()" name="yeni_onay_kodu" class="btn btn-block" value="Yeni Onay Kodu Gönder">
                            </div>
                        </div>
					
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Onay Modal End -->

<!-- Modal Forgot Password -->
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
                        <div class="row" style="text-align:center">
                            <div class="col" style="text-align:center">
                                <label for="">Email Adresi*</label>
                                <input type="email" id="sifremi_unuttum_mail" class="form-control form-control-sm" >
                            </div>
                            </div>
                            <div class="row">
                          
                        </div>
                            <div class="row">
                            <div class="col">
                                <label for="">GSM NO*</label>
                                <input type="tel" id="sifremi_unuttum_tel" class="form-control form-control-sm" >
                            </div>
                             </div>
                           
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <a style="color: #fff;background-color: #f7941e;border-color: #f7941e;" class="btn btn-block" onclick="sifreSifirla()" role="button">Yenile</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <div class="row">
                            <div class="col">
                                <label for="">Email Adresi*</label>
                                <input type="tel" id="sifremi_unuttum_mail" class="form-control form-control-sm" placeholder="(---) --- -- --">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">GSM No*</label>
                                <input type="tel" id="sifremi_unuttum_tel" class="form-control form-control-sm" placeholder="(---) --- -- --">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <label for="">Şifre*</label>
                                <input type="password" class="form-control form-control-sm" placeholder="">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <a class="btn btn-primary btn-block" onclick="sifreSifirla()" role="button">Yenile</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- / END Modal Forgot Password -->
<script>
    function sifreSifirla(){
        var hatirlatilacak_mail = document.getElementById('sifremi_unuttum_mail').value;
        var gsm=$('#sifremi_unuttum_tel').val();
        if (hatirlatilacak_mail !=="" && gsm!=="") {
			$.ajax({
			  url:"sifre_sifirla.php",
			  type:"POST",
			  dataType:"JSON",
			  data:{
				  action:"mail_sifre",
				  hatirlatilacak_mail:hatirlatilacak_mail,
				  gsm:gsm
				},
			  success:function(response){
				if(response.status==200)
				{
					alert("Yeni Şifreniz Mail Adresinize ve Telefonunuza İletildi.");
				  window.location.href = 'index.php';
				}
				else if(response.status==201)
				{
					alert("Bir Hata Oluştu.Lütfen Tekrar Deneyiniz");
				  window.location.href = 'index.php';
				}
				else
				{
					alert("Sistemimizde Kayıtlı Böyle Bir Kullanıcı Bulunmamaktadır.");
				  window.location.href = 'index.php';
				}
			   
			  }  
			});
		}
/*if(gsm!="")
      {
        $.ajax({
          url:"sifre_sifirla.php",
          type:"POST",
          cache:false,
          data:{
            action:"sms_sifre",
            hatiralatilacak_gsm:gsm},
          success:function(data){
            alert("Yeni şifreniz Sms ile iletildi.");
            window.location.href = 'index.php';
          }  
        });
      }  */    
      else{
        alert("Lütfen Mail Adresinizi ve Telefon Numaranızı Yazınız.");
      }
    }
	
	function yeniOnayKodu(){

		var gsm=localStorage.getItem("gsm");
		if(gsm=="" || gsm==null || gsm==undefined){
			alert("Telefon numarası bulunamadı")
		}else{
					console.log(gsm);
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/action.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "yeni_onay_kodu",
					gsm: gsm
				},
				success: function(response) {
					console.log(response);
					if (response.status == 200) {
						alert(response.message)
					} else {
						alert(response.message)
					}
				}
			});			
		}
	}
</script>

<!-- Modal Bid Offer Kapalı İhale -->
<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <div class="text-center border-bottom mt-3">
                        <h3><a href="#" class="c-second">2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC</a></h3>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <h6>8 Gun 23:12:56</h6>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <label for="">Taban Fiyat</label>
                        <h3>TL 138.000</h3>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <h6>Kapalı İhale</h6>
                    </div>
                    <!-- Kullanici onceden bu arabaya teklif yapmis ise -->
                    <div class="text-center border-bottom mt-3">
                        <h6 class="c-red">TL 101.000 onceki teklifiniz.</h6>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <input class="mb-1" type="text" placeholder="yeni teklifiniz giriniz" required>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <blockquote><i>Not - Bu teklifiniz 50 iş günü geçerli olacaktır</i></blockquote>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <h6 class="text-muted">Hizmet Bedeli TL 150</h6>
                    </div>
                    <div class="text-center mt-3">
                        <input type="checkbox" name="" value="">
                        <a href="#exampleModal5" data-toggle="modal" class="text-muted">Koşulları okudum ve kabul
                            ediyorum.</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#exampleModal6" data-toggle="modal" class="btn btn-secondary mt-3 mr-1 float-left"><i
                        class="icon-mail_outline"> Mesaj Yaz</i></a>
                <a href="#" class="btn btn-primary mt-3 mr-1 float-right"><i class="icon-send-o"> Teklifi Gonder</i></a>
            </div>
        </div>
    </div>
</div>
<!-- / END Modal Bid Offer Kapalı İhale -->

<!-- Modal Bid Offer Açık İhale -->
<div class="modal fade" id="exampleModal8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <div class="text-center border-bottom mt-3">
                        <h3><a href="#" class="c-second">1975 Dodge Hatchback </a></h3>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <h6>1 Gun 11:12:56</h6>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <label for="">En Yüksek Teklif</label>
                        <h3>TL 72.000</h3>
                        <div class="align-items-md-stretch mb-3">
                            <div class="btn btn-primary mb-1">+ TL250</div>
                            <div class="btn btn-primary mb-1">+ TL500</div>
                            <div class="btn btn-primary mb-1">+ TL750</div>
                            <div class="btn btn-primary mb-1">+ TL1000</div>
                        </div>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <h6>Açık Arttırma</h6>
                    </div>
                    <!-- Kullanici onceden bu arabaya teklif yapmis ise -->
                    <div class="text-center border-bottom mt-3">
                        <h6 class="c-green">En yüksek teklif sizindir.</h6>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <input class="mb-1" type="text" id="" name="" placeholder="yeni teklifiniz giriniz" required>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <blockquote><i>Not - Kazandığınız araçtan cayamazsınız teklif iletilsin mi?</i></blockquote>
                    </div>
                    <div class="text-center border-bottom mt-3">
                        <h6 class="text-muted">Hizmet Bedeli TL 1182</h6>
                    </div>
                    <div class="text-center mt-3">
                        <input type="checkbox" id="" name="" value="">
                        <a href="#exampleModal5" data-toggle="modal" class="text-muted">Koşulları okudum ve kabul
                            ediyorum.</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#exampleModal6" data-toggle="modal" class="btn btn-secondary mt-3 mr-1 float-left"><i
                        class="icon-mail_outline"> Mesaj Yaz</i></a>
                <a href="#" class="btn btn-primary mt-3 mr-1 float-right"><i class="icon-send-o"> Teklifi Gonder</i></a>
            </div>
        </div>
    </div>
</div>
<!-- / END Modal Bid Offer Açık İhale -->

<!-- Modal Terms and Conditions of Use -->
<div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <p>Bu İnternet Sitesi i&ccedil;eriğinde yer alan t&uuml;m eserler (yazı, resim,
                        g&ouml;r&uuml;nt&uuml;,
                        fotoğraf, video, m&uuml;zik vb.) K&uuml;lt&uuml;r ve Turizm
                        Bakanlığı&rsquo;na&nbsp;<strong>(Bakanlık)</strong>&nbsp;ait olup, 5846 sayılı Fikir ve Sanat
                        Eserleri
                        Kanunu ve 5237 sayılı T&uuml;rk Ceca Kanunu kapsamında korunmaktadır. Bu hakları ihlal eden
                        kişiler, 5846
                        sayılı Fikir ve Sanat eserleri Kanunu ve 5237 sayılı T&uuml;rk Ceza Kanununda yer alan hukuki ve
                        cezai
                        yaptırımlara tabi olurlar. Bakanlık ilgili yasal işlem başlatma hakkına sahiptir.<br />&nbsp;
                    </p>
                    <p>Bu İnternet Sitesinin her hangi bir sayfasına girilmesi halinde &nbsp;aşağıda belirtilen şartlar
                        kabul
                        edilmiş sayılır. Bu &nbsp;şartların kabul edilmemesi durumunda İnternet Sitesine girilmemelidir.
                    </p>
                    <p>&nbsp;</p>
                    <p><strong>A. Siteye erişim ve Sitenin kullanımı, Bakanlığının belirlediği aşağıdaki esas ve
                            şartlara
                            tabidir.</strong></p>
                    <p>&nbsp;</p>
                    <p>1. Bu İnternet Sitesinde yer alan t&uuml;m eserler Bakanlıktan izin alınmaksızın değiştirilemez,
                        &ccedil;oğaltılamaz, yayımlanamaz, dağıtılamaz, umuma iletilemez, başka bir lisana
                        &ccedil;evrilemez.</p>
                    <p>2. Siteyi kullanan kişinin, Sitenin ilk defa kullanım anından itibaren ge&ccedil;erlilik kazanan
                        "Kullanım Koşulları" kabul edilmiş sayılır. Bakanlık, "Kullanım Koşullarını", değişiklikleri
                        &ccedil;evrim
                        i&ccedil;i yayınlamak koşulu ile her an değiştirme hakkını saklı tutar. &Ccedil;evirim
                        i&ccedil;i
                        yayınlanan değişikliklerden zamanında haberdar olmak i&ccedil;in "Kullanım Koşullarını"
                        d&uuml;zenli
                        olarak takip etmek, Site kullanıcısının sorumluluğundadır. Yapılan değişikliklerden sonra Siteyi
                        kullanmaya devam eden kişi, "Kullanım Koşulları"ndaki değişiklikleri kabul etmiş sayılır.</p>
                    <p><br />3. Bakanlık&nbsp; Sitenin 24 saat erişilebilir olması i&ccedil;in &ccedil;alışmaktadır.
                        Ancak
                        değişik sebeplerle Sitenin erişilebilir olmamasından sorumlu değildir.</p>
                    <p><br />4. Bu Siteye erişim, her hangi bir duyuru yapılmaksızın ge&ccedil;ici veya s&uuml;rekli
                        olarak
                        durdurulabilir.<br />&nbsp;</p>
                    <p>5. Bakanlık, Site kullanıcılarına sunduğu bilgilerin doğru olması i&ccedil;in her t&uuml;rl&uuml;
                        gayreti
                        g&ouml;stermekle beraber, bilgilerin doğruluğu konusunda, a&ccedil;ıktan veya ima yolu ile
                        hi&ccedil; bir
                        garanti vermez. Bakanlık yanlış veya eksik bilgiden sorumlu değildir.</p>
                    <p>&nbsp;<br />6. Site, &uuml;&ccedil;&uuml;nc&uuml; kişiler tarafından sunulan bilgiler de
                        i&ccedil;erebilir. &Uuml;&ccedil;&uuml;nc&uuml; kişiler, bu Sitede yayınlanan materyallerin
                        ulusal ve
                        uluslararası mevzuatla uyumlu olmasını sağlamak ile y&uuml;k&uuml;ml&uuml;d&uuml;rler. Bakanlık,
                        bu
                        materyalin doğruluğunu garanti edemez ve materyaldeki hata, ihmal veya eksiklik, yanlış beyan,
                        materyalde
                        vaad edilen hizmetlerin yerine getirilmesinde meydana gelecek bir aksama veya getirilmesinin
                        aksaması
                        iddiası karşısında ve Sitede duyurulan hizmetleri sunan firma, şirket veya bireyin iflası veya
                        firma veya
                        şirketin tasfiyesi durumlarında doğabilecek maddi/manevi kayıp veya zarar nedeniyle sorumluluk
                        kabul
                        etmeyeceğini a&ccedil;ık&ccedil;a beyan eder. Sunulan bilgilerin doğruluğu ve g&uuml;ncelliği,
                        s&ouml;z
                        konusu kuruluşların kendilerine onaylatılmalıdır.</p>
                    <p>&nbsp;<br />7. Bakanlık, Sitenin kullanılması, kullanılamaması, b&uuml;nyesinde sunulan bilgiler
                        veya
                        Siteye bağlı olarak yapılan eylemler veya alınan kararlar nedeniyle kullanımında meydana gelen
                        aksaklıktan, Sitenin i&ccedil;erdiği materyalden, Sitenin kullanımından sonra alınan bir karar
                        veya
                        yapılan bir eylemden doğan, kontrat, haksız fiil veya başka t&uuml;rl&uuml; (sınırlama olmadan,
                        iş
                        kaybından doğan zararlar veya k&acirc;r kaybı dahil) zararlardan sorumlu değildir.</p>
                    <p><br />8. Bakanlık, İnternet Sitesinde yer alan linklerle ulaşılacak sitelerde sunulan bilgiler
                        nedeniyle
                        hi&ccedil; bir sorumluluk kabul etmez. S&ouml;z konusu linkler (bağlantılar), a&ccedil;ıktan
                        veya ima yolu
                        ile her hangi bir garanti verilmeksizin, kullanıcıya kullanım kolaylığı sağlamak amacıyla
                        verilmiştir.</p>
                    <p>&nbsp;</p>
                    <p><strong>B. Bu Siteden yazılı ve/veya g&ouml;rsel nitelikte bilgi indirme ve baskı alma ve
                            internet
                            sitelerinde kullanma &nbsp;ancak aşağıdaki koşullar dahilinde yapılabilir:</strong></p>
                    <p><strong>1. Kişisel kullanım;</strong></p>
                    <p><br />1.1. İnternet Sitesinde yer alan eserlerin kullanımı kişisel kullanım ve/veya bilgi edinme
                        amacı
                        ile sınırlıdır. Ancak bu kapsamda ger&ccedil;ekleştirilen &ccedil;oğaltma fiilleri hak sahibinin
                        meşru
                        menfaatlerine haklı bir sebep olmadan zarar veremez ya da&nbsp; eserden normal yararlanmaya
                        aykırı olamaz,
                        ticari ama&ccedil;la kullanılamaz.</p>
                    <p>1.2. Sitedeki yazılı veya g&ouml;rsel materyal hi&ccedil; bir şekilde değiştirilemez, telif hakkı
                        ibareleri silinerek kullanılamaz.</p>
                    <p>1.3. Sitede yer alan eserlerin b&uuml;t&uuml;n&uuml; veya bir kısmı değiştirilerek veya başka bir
                        suretle
                        diğer bir internet sitesinde izinsiz olarak kullanılamaz.</p>
                    <p>1.4. Bu İnternet Sitesindeki veriler ticari olmayan, bilgi alma ama&ccedil;lı ve kişisel kullanım
                        i&ccedil;in indirebilir veya yazdırılabilir.</p>
                    <p><br />1.5. Bu İnternet Sitesindeki verileri her hangi bir ticari ama&ccedil; olmadan
                        &uuml;&ccedil;&uuml;nc&uuml; şahıslara onların kişisel bilgilendirilmeleri i&ccedil;in,
                        i&ccedil;eriğin
                        Bakanlık tarafından sağlandığını ve bu kayıt ve şartların onlara da uygulandığını ve bunlara
                        uymak zorunda
                        olduklarını belirtmek şartıyla &nbsp;g&ouml;nderilebilir.</p>
                    <p><br /><strong>2. Kişisel olmayan kullanım;</strong></p>
                    <p><br />Bu Siteden yazılı ve/veya g&ouml;rsel nitelikte bilgi indirme ve baskı alma gibi
                        &ccedil;oğaltma
                        yahut internet sitelerinde kullanma:</p>
                    <p>Kullanılacak bilgiye ilişkin izinler, bilginin altında ismi yer alan ilgili Merkez veya Taşra
                        birimlerinden, ilgili birim ibaresi olmayan materyallerin kullanım izni ise K&uuml;lt&uuml;r ve
                        Turizm
                        Bakanlığı Strateji Geliştirme Başkanlığından yazılı olarak talep edilmelidir.</p>
                    <p>&nbsp;</p>
                    <p><strong>C. Sorumluluk Reddi</strong></p>
                    <p><br /><strong>&nbsp;</strong></p>
                    <p>1. Bakanlık, bu Sitede yer alan bilgilerin tam ve doğru olduğunu veya sayfaya kesintisiz giriş
                        sağlanacağını garanti etmemektedir. İşbu Sitede yer alan beyanlar hukuken taahh&uuml;t
                        niteliğinde
                        sayılmamaktadır ve bağlayıcı değildir. Bu bilgilerle &uuml;&ccedil;&uuml;nc&uuml; şahısların
                        haklarının
                        ihlal edilmemesi; m&uuml;lkiyet, satılabilirlik, belirli bir ama&ccedil; i&ccedil;in uygunluk
                        ve/veya
                        bilgisayar vir&uuml;s&uuml; bulunmamasına ilişkin garantiler dahil, ancak bunlarla sınırlı
                        kalmamak
                        kaydıyla, zımnen, a&ccedil;ık&ccedil;a ya da yasal olarak hi&ccedil; bir garanti vermemektedir.
                    </p>
                    <p>2. Bu internet Sitesinde yer alan bilgi, rapor,&nbsp; grafik ve benzeri her t&uuml;rl&uuml;
                        elektronik
                        dok&uuml;man Bakanlık&nbsp; tarafından her hangi bir maddi menfaat temin edilmeksizin genel
                        anlamda
                        kamuoyunu bilgilendirmek amacıyla hazırlanmıştır. Internet Sitesinde yer alan bu elektronik
                        dok&uuml;manların doğruluğu; yazım hatası, yazılım hatası, aktarım hatası, sistemlerin bozulması
                        veya
                        saldırıya uğraması gibi nedenlerden kaynaklanan hatalara karşı garanti edilmemekte olup, bu
                        bilgiler belli
                        bir getirinin sağlanmasına y&ouml;nelik olarak verilmemektedir.</p>
                    <p>3. Bu nedenle bu İnternet Sitesinde yer alan elektronik dok&uuml;manlardaki hatalardan,
                        eksikliklerden ya
                        da bu dok&uuml;manlara dayanılarak yapılan işlemlerden doğacak, doğrudan veya dolaylı, her
                        t&uuml;rl&uuml;
                        maddi/manevi zararlar ve masraflardan&nbsp; Bakanlık sorumlu tutulamaz.</p>
                    <p>4. Bu İnternet Sitesinin kullanımı sırasında her hangi bir arıza, hata, eksiklik, kesinti, kusur
                        veya
                        nakilde gecikme, bilgisayar vir&uuml;s&uuml; veya hat veya sistem arızası sonucu doğrudan ya da
                        dolaylı
                        ortaya &ccedil;ıkan zarar, ziyan ve masraflar da dahil, ancak bunlarla sınırlı olmamak
                        &uuml;zere
                        hi&ccedil; bir zarardan, Bakanlık ve/veya &ccedil;alışanı, bu t&uuml;r bir zarar olasılığından
                        haberdar
                        edilmiş olsalar dahi, sorumlu olmazlar.</p>
                    <p>5. Bu bilgiler doğrultusunda, Bakanlık, bu Sitenin i&ccedil;eriğinde yer alan bilgilerden ve
                        g&ouml;rsel
                        malzemeden kaynaklanabilecek hatalardan, maddi veya manevi zararlardan hi&ccedil; bir şekil ve
                        surette
                        sorumlu değildir.</p>
                    <p>6. Sitede yer alan t&uuml;m bilgiler &ouml;nceden haber verilmeksizin değiştirilebilir. Bakanlık
                        dilediği
                        zaman, Sitenin her hangi bir b&ouml;l&uuml;m&uuml;n&uuml; iptal edebilir, değiştirebilir, haber
                        vermeksizin Sitedeki bazı &ouml;zellikleri veya bilgileri veya Sitenin bazı
                        b&ouml;l&uuml;mlerine erişimi
                        sınırlandırabilir.</p>
                    <p>7. Bakanlık, İnternet Sitesinin vir&uuml;s &ouml;nlemlerini almış olmakla birlikte, bu konuda bir
                        garanti
                        vermemektedir. Her hangi bir bilgi, belge, uygulama vb. indirmeden &ouml;nce vir&uuml;slerden
                        korunma
                        konusunda gerekli &ouml;nlemlerin alınması tavsiye edilir.</p>
                    <p>8. Kullanım şartlarıyla ilgili ortaya &ccedil;ıkabilecek ihtilaflarda, m&uuml;nhasıran T&uuml;rk
                        Hukuku
                        kapsamında Ankara Mahkemeleri ve İcra Daireleri yetkilidir.</p>
                    <p><br /><strong>D. Cookies</strong></p>
                    <p><br />&ldquo;Cookie&rdquo; bilgisayarınıza g&ouml;nderilebilen bir yazılımdır.
                        &ldquo;Cookie&rdquo;ler
                        İnternet Sitelerimizin ve servislerimizin nasıl kullanıldığına dair bilgileri toplamaya ve
                        y&ouml;netmeye
                        yarar. Eğer bilgisayarınıza bir &ldquo;cookie&rdquo; g&ouml;nderirsek, sizin bilginiz ve
                        onayınız olmadan,
                        sizinle ilgili bir veri toplamayacaktır. O zamana kadar &ldquo;cookie&rdquo; sadece genel
                        kullanım
                        modellerini izleyecek ve sizi birey olarak tanımlamada kullanılmayacaktır.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / END Modal Terms and Conditions of Use -->

<!-- Modal Send Message -->
<div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <textarea id="" name="" rows="4" cols="30" placeholder="Mesajinizi buraya yaziniz."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-secondary mt-3 mr-1"><i class="icon-mail_outline"> Gonder</i></a>
            </div>
        </div>
    </div>
</div>
<!-- / END Send Message -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script>
$('input[type="tel"]').mask('0(000)000-0000');
</script>
<!-- <script>
function phoneMask() {
    var num = $(this).val().replace(/\D/g, '');
    $(this).val(num.substring(0, 1) + '(' + num.substring(1, 4) + ')' + num.substring(4, 7) + '-' + num.substring(7,
        11));
}
$('[type="tel"]').keyup(phoneMask);
</script> -->
<script>
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
                //$("#uye_kayitol").attr("disabled", false);
                //$("#uye_kayitol").css("display", "block");
            } else {
                $(".kontrol_yaz").html(response.message);
                $(".kontrol_yaz").css("color", "red");
                //$("#uye_kayitol").attr("disabled", true);
                //$("#uye_kayitol").css("display", "none");
            }
        }
    });

});
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
                //$("#uye_kayitol").attr("disabled", false);
                //$("#uye_kayitol").css("display", "block");
            } else {
                $(".tel_kontrol_yaz").html(response.message);
                $(".tel_kontrol_yaz").css("color", "red");
                //$("#uye_kayitol").attr("disabled", true);
                //$("#uye_kayitol").css("display", "none");
            }
        }
    });

});
// $('#u_sabit_tel').on('change', function() {
//     jQuery.ajax({
//         url: "https://ihale.pertdunyasi.com/register_add.php",
//         type: "POST",
//         dataType: "JSON",
//         data: {
//             action: "sabit_tel_kontrol",
//             sabit_tel: document.getElementById('u_sabit_tel').value,
//         },
//         success: function(response) {
//             console.log(response);
//             if (response.status == 200) {
//                 $(".sabit_tel_kontrol_yaz").html(response.message);
//                 $(".sabit_tel_kontrol_yaz").css("color", "green");
//                 //$("#uye_kayitol").attr("disabled", false);
//                 //$("#uye_kayitol").css("display", "block");
//             } else {
//                 $(".sabit_tel_kontrol_yaz").html(response.message);
//                 $(".sabit_tel_kontrol_yaz").css("color", "red");
//                 //$("#uye_kayitol").attr("disabled", true);
//                 //$("#uye_kayitol").css("display", "none");
//             }
//         }
//     });

// });
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
                //$("#k_kayitol").attr("disabled", false);
                //$("#k_kayitol").css("display", "block");
            } else {
                $(".k_kontrol_yaz").html(response.message);
                $(".k_kontrol_yaz").css("color", "red");
                //$("#k_kayitol").attr("disabled", true);
                //$("#k_kayitol").css("display", "none");
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
                //$("#k_kayitol").attr("disabled", false);
                //$("#k_kayitol").css("display", "block");
            } else {
                $(".k_tel_kontrol_yaz").html(response.message);
                $(".k_tel_kontrol_yaz").css("color", "red");
                //$("#k_kayitol").attr("disabled", true);
                //$("#k_kayitol").css("display", "none");
            }
        }
    });

});
// $('#k_sabit_tel').on('change', function() {
//     jQuery.ajax({
//         url: "https://ihale.pertdunyasi.com/register_add.php",
//         type: "POST",
//         dataType: "JSON",
//         data: {
//             action: "sabit_tel_kontrol",
//             sabit_tel: document.getElementById('k_sabit_tel').value,
//         },
//         success: function(response) {
//             console.log(response);
//             if (response.status == 200) {
//                 $(".k_sabit_tel_kontrol_yaz").html(response.message);
//                 $(".k_sabit_tel_kontrol_yaz").css("color", "green");
//                 //$("#k_kayitol").attr("disabled", false);
//                 //$("#k_kayitol").css("display", "block");
//             } else {
//                 $(".k_sabit_tel_kontrol_yaz").html(response.message);
//                 $(".k_sabit_tel_kontrol_yaz").css("color", "red");
//                 //$("#k_kayitol").attr("disabled", true);
//                 //$("#k_kayitol").css("display", "none");
//             }
//         }
//     });

// });


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
            // u_sabit_tel: document.getElementById('u_sabit_tel').value,
            sehir: document.getElementById('sehir').value,
            u_sifre: document.getElementById('u_sifre').value,
            u_sifre_tekrar: document.getElementById('u_sifre_tekrar').value,
            u_kullanim_sartlari: document.getElementById('u_kullanim_sartlari').value,
        },
        success: function(response) {
            console.log(response);
            if (response.status != 200) {
                $(".u_mesaj").html(response.message);
                $(".u_mesaj").css("color", "red");
                
                //$("#uye_kayitol").attr("disabled", false);
                //$("#uye_kayitol").css("display", "block");
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
                                $( "#onay_modal" ).addClass( "show" );    
                                $( "#onay_modal" ).css( "display","block" ); 
                                localStorage.setItem('Onay',0);
                                localStorage.setItem('gsm',document.getElementById('u_tel').value);
                                localStorage.setItem('user_token',data.user_token);    
                                $("input[name='gsm']").val(localStorage.getItem('gsm'));
                                kayit_ol_modal_kapat();		
                            }else{
                                kayit_ol_modal_kapat();		
                                if(data.user_token != ""){
                                    window.location.href = 'uye_panel/success.php';
                                }else if(data.kurumsal_token != ""){
                                    window.location.href = 'kurumsal_panel/success.php';
                                }
                            }		
							//window.location = "index.php";
                        }  
                        });
               // alert("Başarıyla kayıt oldunuz.Lütfen giriş yapınız.");
                //window.location = "index.php";
                //header('Location: index.php');
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
            // k_sabit_tel: document.getElementById('k_sabit_tel').value,
            k_sifre: document.getElementById('k_sifre').value,
            k_sifre_tekrar: document.getElementById('k_sifre_tekrar').value,
        },
        success: function(response) {
            console.log(response);
            if (response.status != 200) {              
                $(".k_mesaj").html(response.message);
                $(".k_mesaj").css("color", "red");
                //$("#k_kayitol").attr("disabled", false);
                //$("#k_kayitol").css("display", "block");
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

                            console.log(data);
                            alert(data.message);
                            /*
                            if(data.modal == 1){                                
                                $( "#onay_modal" ).addClass( "show" );    
                                $( "#onay_modal" ).css( "display","block" ); 
                                localStorage.setItem('Onay',0);
                                localStorage.setItem('gsm',document.getElementById('k_tel').value);
                                localStorage.setItem('user_token',data.user_token);    
                                $("input[name='gsm']").val(localStorage.getItem('gsm'));
                            }		
                            kayit_ol_modal_kapat();		
                            */


                            if(data.modal == 1){                                
                                $( "#onay_modal" ).addClass( "show" );    
                                $( "#onay_modal" ).css( "display","block" ); 
                                localStorage.setItem('Onay',0);
                                localStorage.setItem('gsm',document.getElementById('k_tel').value);
                                localStorage.setItem('user_token',data.user_token);    
                                $("input[name='gsm']").val(localStorage.getItem('gsm'));
                                kayit_ol_modal_kapat();		
                            }else{
                                kayit_ol_modal_kapat();		
                                if(data.user_token != ""){
                                    window.location.href = 'uye_panel/success.php';
                                }else if(data.kurumsal_token != ""){
                                    window.location.href = 'kurumsal_panel/success.php';
                                }
                            }	






                            /*
                            alert(data.message);
                            localStorage.setItem('gsm',document.getElementById('k_tel').value);                        
                            window.location = "index.php";
                            */

                                 //alert("Onay Kodu Telefon Numaranıza Gönderildi.");
                        }  
                        });
               /* alert("Başarıyla kayıt oldunuz.Lütfen giriş yapınız.");
                window.location = "index.php";
                //header('Location: index.php');*/
            }
        }
    });

    }else{
        alert('Devam etmek için Kullanım Şartlarını onaylamanız gerekmektedir.');
    }
   

});
</script>
<script language="javascript">
function modal_kontrol(id) {
    var reg = new RegExp("\[ÜĞŞÇÖğıüşöç]");
    if (reg.test(document.getElementById(id).value, reg)) {
        alert('Email alanında türkçe karakter bulunmamalıdır.');
        document.getElementById(id).value = "";
    }
}

$( document ).ready(function() {
     
     if(localStorage.getItem("Onay")==0)
     {   
		$( "#onay_modal" ).addClass( "show" );    
		$( "#onay_modal" ).css( "display","block" );    
		$("input[name='gsm']").val(localStorage.getItem('gsm'));
     }
   
 });

$('#kapat_btn_onay').on("click",function(){
    $( "#onay_modal" ).removeClass( "show" );    
    $( "#onay_modal" ).css( "display","none" );     

});

function modal_kapat()
{
    $( "#kapat_btn" ).click();   

}
function kayit_ol_modal_kapat()
{
    $( "#kayit_ol_modal_kapat" ).click();   
  
}
function temizle(){
	localStorage.removeItem("gsm");
	localStorage.removeItem("Onay");
}
</script>