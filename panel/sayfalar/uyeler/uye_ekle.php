 <style>
    #data{
        margin-top: 2%;
    }
	.yedek_input{
		margin-bottom:5%;
		width:90%;
	}
	.yedek_sil_input{
		margin-top:20%;
		margin-bottom:45%;
	}
</style>




<?php 
  $sehir_cek = mysql_query("SELECT * FROM sehir ORDER BY plaka ASC"); 
?>

<form method="post" name="data" id="data" enctype="multipart/form-data">
	<input type="hidden" name="action" value="panel_kayit"  />
	<strong class="mesaj"></strong>
    <div class="row-fluid">	
        <div class="span6">
            <label for="IDofInput">Firma Adı</label>
            <input id="firma_adi" type="text" style="text-transform: capitalize;" name="firma_adi" class="span12"   pattern="\b\w+\b(?:.*?\b\w+\b){1}" oninvalid="this.setCustomValidity('Lütfen en az 2 kelime olacak şekilde giriniz.')" oninput="this.setCustomValidity('')">
            <label for="IDofInput">Yetkili Adı Soyadı</label>
            <input id="yetkili_adi_soyadi" type="text" style="text-transform: capitalize;" name="yetkili_adi_soyadi" class="span12"   pattern="\b\w+\b(?:.*?\b\w+\b){1}" oninvalid="this.setCustomValidity('Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.')" oninput="this.setCustomValidity('')">
            <label for="IDofInput">TC Kimlik Numarası</label>
            <input id="tc_kimlik" type="text" onkeypress="return isNumberKey(event)" name="tc_kimlik" maxlength="11" class="span12" >
            <label id="tc_kontrol" ></label>
			<label for="IDofInput">Doğum Tarihi</label>
            <input id="dogum_tarihi" type="date" name="dogum_tarihi" class="span12" >
			<label for="IDofInput">Şifre</label>
            <input id="sifre" type="password" name="sifre" class="span12" >
            <label for="IDofInput">Eposta</label>
            <input id="email" type="text" id="email" name="email" onkeyup="javascript:kontrol()" class="span12" >
			<label id="email_kontrol" ></label>
            <label for="IDofInput">Onaylı Cep No</label>
            <input id="onayli_cep_no" data-mask="0(000)000-0000" type="tel" class="span12" name="onayli_cep_no" placeholder="örn. 0(123)-456-7890">
			<label id="tel_kontrol" ></label>
			<label for="IDofInput" style="display:none" id="vergi_yazi"> Vergi Dairesi</label>
			<input type="text" id="vergi_dairesi" name="vergi_dairesi"class="span12" style="display:none" >
			<label for="IDofInput" style="display:none" id="vergi_no_yazi"> Vergi Dairesi No</label>
			<input  type="text" id="vergi_dairesi_no" name="vergi_dairesi_no" class="span12" style="display:none" >
        </div>
        <div class="span6">
			<div class="row-fluid">
				<div class="span12">
					<label id="IDofInput" class="form-text text-muted">Size ulaşamadığımızda ulaşabileceğimiz kişiler</label>
					<input style="float:right;margin-bottom:5%;" type="button"  onclick="yedek_ekle();" class=" btn btn-success" value="Ekle" />
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6" id="yedek_ad_div">
					<input name="yedek_kisi[]"  type="text" class="form-control yedek_input" placeholder="Adı" value="">
				</div>

				<div class="span6" id="yedek_tel_div">
					<input name="yedek_kisi_tel[]"  data-mask="0(000)000-0000" type="tel" class="form-control yedek_input" placeholder="Telefonu" value="">
				</div>

			</div>
	
            <label for="IDofInput">İl</label>
            <select name="sehir" id="sehir" class="span12" >
                
                <?php
                while($sehir_oku = mysql_fetch_array($sehir_cek)){                   
                ?>                        
                <option value="<?=$sehir_oku["sehirID"]?>"><?=$sehir_oku["sehiradi"];?></option>  
                <?php } ?>                      
            </select>
            <label for="IDofInput">İlçe</label>
            <select name="ilce" id="ilce" title="Lütfen ilk olarak il seçin" class="span12" disabled>
                <option value="">İlçe seçin</option>
            </select>
            <label for="IDofInput">Cinsiyet</label>
            <select name="cinsiyet" id="cinsiyet" class="span12" >
                <option value="">Seçiniz</option>
                <option value="Erkek">Erkek</option>
                <option value="Kadın">Kadın</option>
            </select>
            <label for="IDofInput">Üye Olma Sebebi</label>
            <select name="sebep" id="sebep" class="span12" >
                <option value="">Seçiniz</option>
                <option value="Onarıp kullanmak amacıyla araç arıyorum">Onarıp kullanmak amacıyla araç arıyorum</option>
                <option value="Araç alıp satıyorum">Araç alıp satıyorum</option>
                <option value="Aracımı satmak istiyorum">Aracımı satmak istiyorum</option>
                <option value="Sadece merak ettim">Sadece merak ettim</option>
            </select>
            <label for="IDofInput">Kullanıcı Türü</label>
            <select name="uye_turu" id="uye_turu" class="span12" onchange="vergi_ac();" >
                <option value="">Seçiniz</option>
                <option value="1">Bireysel</option>
                <option value="2">Kurumsal</option>
            </select>
        </div>
    </div>
    <button type="button" onclick="guncelle();" class="btn btn-primary" >Kaydet</button>
</form>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script> -->

 <script src="js/jquery.mask.js"></script>
<script src="js/il_ilce.js?v=14"></script>
<script>
  //$('input[type="tel"]').mask('0(000)000-0000');
</script>
<script>
function maskle(){
	//$('input[type="tel"]').mask('0(000)000-0000');
}


function vergi_ac()
{
	var uyelik=$('#uye_turu').val();

	if(uyelik==2)
	{
		$("#vergi_dairesi").attr('required',true);
		$("#vergi_dairesi_no").attr('required',true);	
		$( "#vergi_yazi" ).show();
		$( "#vergi_no_yazi" ).show();
		$( "#vergi_dairesi" ).show();
		$( "#vergi_dairesi_no" ).show();	
	
	}
	else
	{
		$( "#vergi_yazi" ).hide();
		$( "#vergi_no_yazi" ).hide();
		$( "#vergi_dairesi" ).hide();
		$( "#vergi_dairesi_no" ).hide();
	}
}


</script>





<!-- <script>
function phoneMask() { 
    var num = $(this).val().replace(/\D/g,''); 
    $(this).val(num.substring(0,1)+'(' + num.substring(1,4) + ')'+num.substring(4,7)+'-'+num.substring(7,11)); 
}
$('[type="tel"]').keyup(phoneMask);
</script> -->


<!-- <script language="javascript">
function kontrol()
{
var reg=new RegExp("\[ÜĞŞÇÖğıüşöçİ]");
if(reg.test(document.getElementById('email').value,reg))
{
alert('Email alanında türkçe karakter bulunmamalıdır.');
document.getElementById('email').value="";
}
}
</script> -->


<script>
    function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>

<script>
	function guncelle(){
		let myForm = document.getElementById('data');
		var form_data = new FormData(myForm);
		form_data.append("panel", "1");
	

		if($('#uye_turu').val()==2)
		{
			if($('#vergi_dairesi').val()==""  && $('#vergi_dairesi_no').val()==""){
				alert("Lütfen Vergi Dairesi ve Vergi No Giriniz");
			}else{			
				jQuery.ajax({
					url: "https://ihale.pertdunyasi.com/register_add.php",
					type: 'POST',
					data: form_data,
					dataType: "JSON",
					success: function(response) {
						console.log(response);
						if (response.status != 200) {
							$(".mesaj").html(response.message);
							$(".mesaj").css("color", "red");
						}else{
							alert("Başarıyla Eklendi");
							location.reload();
						}
					},
					cache: false,
					contentType: false,
					processData: false
				});
			}
		}else{
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/register_add.php",
				type: 'POST',
				data: form_data,
				dataType: "JSON",
				success: function(response) {
					console.log(response);
					if (response.status != 200) {
						$(".mesaj").html(response.message);
						$(".mesaj").css("color", "red");
					}else{
						alert("Başarıyla Eklendi");
						location.reload();
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
	  }
	}
	/* $('#yeni_uyeyi').on('click', function () {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/register_add.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_kayit",
				firma_adi:document.getElementById('firma_adi').value,
				ad:document.getElementById('ad').value,
				tc_kimlik:document.getElementById('tc_kimlik').value,
				dogum_tarihi:document.getElementById('dogum_tarihi').value,
				sebep:document.getElementById('sebep').value,
				cinsiyet:document.getElementById('cinsiyet').value,
				email:document.getElementById('email').value,
				tel:document.getElementById('tel').value,
				sehir:document.getElementById('sehir').value,
				sifre:document.getElementById('sifre').value,
				ilce:document.getElementById('ilce').value,
				yedek_kisi:document.getElementById('yedek_kisi').value,
				yedek_kisi_tel:document.getElementById('yedek_kisi_tel').value,
				uye_turu:document.getElementById('uye_turu').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status != 200) {
					$("#mesaj").html("");
					$("#mesaj").html(response.message);
					$("#mesaj").css("color", "red");
				}else{
					$("#mesaj").html("");
					alert("Kayıt ekleme başarılı");
					 window.location="?modul=uyeler&sayfa=uyeler";
				}
			}
		});
	  
	});*/
	
	$('#email').on('change', function () {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/register_add.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "email_kontrol",
				email:document.getElementById('email').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$("#email_kontrol").html(response.message);
					$("#email_kontrol").css("color", "green");
				}else{
					$("#email_kontrol").html(response.message);
					$("#email_kontrol").css("color", "red");
				}
			}
		});  
	});
	$('#onayli_cep_no').on('change', function () {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/register_add.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "tel_kontrol",
				tel:document.getElementById('onayli_cep_no').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$("#tel_kontrol").html(response.message);
					$("#tel_kontrol").css("color", "green");

				}else{
					$("#tel_kontrol").html(response.message);
					$("#tel_kontrol").css("color", "red");

				}
			}
		});
	});
	$('#tc_kimlik').on('change', function () {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/register_add.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "tc_kontrol",
				tc_kimlik:document.getElementById('tc_kimlik').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$("#tc_kontrol").html(response.message);
					$("#tc_kontrol").css("color", "green");
				}else{
					$("#tc_kontrol").html(response.message);
					$("#tc_kontrol").css("color", "red");
				}
			}
		});
	});
	function yedek_ekle(){    
		var nesne=document.createElement("input");    
		nesne.setAttribute("type","text");
		nesne.setAttribute("name","yedek_kisi[]");  
		nesne.setAttribute("placeholder", "Adı");
		nesne.setAttribute("class"," form-control yedek_input "); 
		var yedek_ad_div=document.getElementById("yedek_ad_div");
		yedek_ad_div.appendChild(nesne);

		var nesne_2=document.createElement("input");    
		nesne_2.setAttribute("name","yedek_kisi_tel[]");     
		nesne_2.setAttribute("data-mask","0(000)000-0000");    
		nesne_2.setAttribute("type","tel");  
		nesne_2.setAttribute("class","form-control yedek_input");
		nesne_2.setAttribute("placeholder", "Telefonu");
		nesne_2.setAttribute("value","");  
		nesne_2.setAttribute("autocomplete","off");  
		nesne_2.setAttribute("maxlength","14");   
		

		var yedek_tel_div=document.getElementById("yedek_tel_div");
		yedek_tel_div.appendChild(nesne_2); 
		
		var nesne_3=document.createElement("script");    
		nesne_3.setAttribute("src","js/jquery.mask.js");    
		var yedek_tl_div=document.getElementById("yedek_tel_div");
		yedek_tl_div.appendChild(nesne_3); 
				

	
	}
</script>

