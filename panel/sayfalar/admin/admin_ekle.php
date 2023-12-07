<?php 
session_start();
	$admin_id=$_SESSION['kid'];
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
   
	$yetkiler=$admin_yetki_oku["yetki"];
   
	$yetki_parcala=explode("|",$yetkiler);

	if (count($yetki_parcala) != 13  ) { 
		echo '<script>alert("Bu Sayfaya Giriş Yetkiniz Yoktur")</script>';
		echo "<script>window.location.href = 'index.php'</script>";
	}
$gelen_id=re("id");
$admini_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = $gelen_id");


$performans_orani_cek=mysql_query("select performans_kazanci_orani from kullanicilar where id=1");
$performans_orani_oku=mysql_fetch_array($performans_orani_cek);
$performans_orani=$performans_orani_oku["performans_kazanci_orani"] / 100;
?>
<style>
.row {
    background: #f6f6f6;
    overflow: hidden;
    padding: 10px;
}
.col {
    float: left;
    width: 50%
}
.yetki{
    background-color : blue;
}
.a{
    opacity: 1 !important;
    z-index: 9999;
    margin-left:1px !important;
    margin-top:2px !important

}
.checker span{

    background-color:tranparent;
    border:0px tranparent;
    background:tranparent


}

</style>
<?php if(!empty($gelen_id)){ ?>
<form method="POST" id="form" name="form">
<?php 
while($admini_getir = mysql_fetch_array($admini_cek)){
?>
<?php include('islemler/kullanicilar/kullanici_ekle.php'); ?>
    <div class="row-fluid" style="margin-top: 2%;">
        <div class="span6">
            <label for="IDofInput">Adı</label> 
            <input type="text" class="span12" value="<?= $admini_getir['adi'] ?>"  id="adi" name="adi" /> 
            <label for="IDofInput">Soyadı</label> 
            <input type="text" class="span12" value="<?= $admini_getir['soyadi'] ?>" id="soyadi" name="soyadi"/> 
            <label for="IDofInput">Kullanıcı Adı</label> 
            <input  onkeypress="temizle(event);" onpaste="return false;" type="text" class="span12" value="<?= $admini_getir['kullanici_adi'] ?>" name="kullanici_adi" required /> 
            <label for="IDofInput">Email Adresi</label> 
            <input type="email" class="span12" value="<?= $admini_getir['email'] ?>" name="email" required/> 
            <label for="IDofInput">Şifre</label> 
            <input type="password" class="span12" value="" name="sifre" />  
            <label for="IDofInput">Şifre Tekrar</label> 
            <input type="password" class="span12" value="" name="sifre_tekrar" /> 
            <label for="IDofInput">Gsm</label> 
            <input onkeypress="temizle();"  type="tel" value="<?= $admini_getir['tel'] ?>" class="span12" id="gms_no" name="gsm" maxlength="11" required onkeypress="return isNumberKey(event)" /> 
            <!--<input type="text" class="span12" value="<?= $admini_getir['tel'] ?>" name="gsm" maxlength="11" required onkeypress="return isNumberKey(event)" /> -->
            
        </div>
        <div class="span6">
             <!--<label for="IDofInput">YETKİLER</label> 
           <select name="uye_grubu" value="<?= $admini_getir['yetki'] ?>" id="yetki_grubu" tabindex="1" >
                <option value="0">Tam Yetki</option>
                <option value="1" >Sınırlı Yetki</option>
            </select><br>-->
            <?php 
             $admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$gelen_id."' ");
             $admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
             $yetkiler=$admin_yetki_oku["yetki"];
             $yetki_parcala=explode("|",$yetkiler);
           
                 
            ?>
			<div class="row">    
			<?php
				if($gelen_id==1){
					if($admin_id==1){?>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="1" <?php if (in_array(1, $yetki_parcala)){ echo "checked";} ?>> İlan Düzenleme
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="2" <?php if (in_array(2, $yetki_parcala)){ echo "checked";} ?>> İlan Silme
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="3" <?php if (in_array(3, $yetki_parcala)){ echo "checked";} ?>> Statü Tanımlama
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="4" <?php if (in_array(4, $yetki_parcala)){ echo "checked";} ?>> Üye Düzenleme
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="5" <?php if (in_array(5, $yetki_parcala)){ echo "checked";} ?>> Üye Yetki Sekmesi
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="6" <?php if (in_array(6, $yetki_parcala)){ echo "checked";} ?>> Üye Cayma Bedeli Sekmesi
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="7" <?php if (in_array(7, $yetki_parcala)){ echo "checked";} ?>> Üye Silme
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="8" <?php if (in_array(8, $yetki_parcala)){ echo "checked";} ?>> Not Düzenleme
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="9" <?php if (in_array(9, $yetki_parcala)){ echo "checked";} ?>> Not Silme
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="10" <?php if (in_array(10, $yetki_parcala)){ echo "checked";} ?>> Satılan Araçlar Listesi
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="11" <?php if (in_array(11, $yetki_parcala)){ echo "checked";} ?>> Performanslar
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="12" <?php if (in_array(12, $yetki_parcala)){ echo "checked";} ?>> Üye Bakiyelerini Görme Yetkisi
							</label>
							<label class="checkbox">
							<input name="yetki[]" type="checkbox" value="13" <?php if (in_array(13, $yetki_parcala)){ echo "checked";} ?>> Müşteri Temsilcisi Atama
							</label>
					<?php }
				}else{ ?>               
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="1" <?php if (in_array(1, $yetki_parcala)){ echo "checked";} ?>> İlan Düzenleme
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="2" <?php if (in_array(2, $yetki_parcala)){ echo "checked";} ?>> İlan Silme
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="3" <?php if (in_array(3, $yetki_parcala)){ echo "checked";} ?>> Statü Tanımlama
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="4" <?php if (in_array(4, $yetki_parcala)){ echo "checked";} ?>> Üye Düzenleme
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="5" <?php if (in_array(5, $yetki_parcala)){ echo "checked";} ?>> Üye Yetki Sekmesi
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="6" <?php if (in_array(6, $yetki_parcala)){ echo "checked";} ?>> Üye Cayma Bedeli Sekmesi
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="7" <?php if (in_array(7, $yetki_parcala)){ echo "checked";} ?>> Üye Silme
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="8" <?php if (in_array(8, $yetki_parcala)){ echo "checked";} ?>> Not Düzenleme
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="9" <?php if (in_array(9, $yetki_parcala)){ echo "checked";} ?>> Not Silme
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="10" <?php if (in_array(10, $yetki_parcala)){ echo "checked";} ?>> Satılan Araçlar Listesi
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="11" <?php if (in_array(11, $yetki_parcala)){ echo "checked";} ?>> Performanslar
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="12" <?php if (in_array(12, $yetki_parcala)){ echo "checked";} ?>> Üye Bakiyelerini Görme Yetkisi
						</label>
						<label class="checkbox">
						<input name="yetki[]" type="checkbox" value="13" <?php if (in_array(13, $yetki_parcala)){ echo "checked";} ?>> Müşteri Temsilcisi Atama
						</label>

				<?php } ?>
			</div>
            <div class="row">
                <div class="span6">
                    <label for="IDofInput">Günlük PRM Ekleme Limiti</label>
                    <input type="number" class="span12" name="prm_limiti" value="<?= $admini_getir['prm_limiti'] ?>" class="span12">
                </div>
                
            </div>
			<div class="row">
                <div class="span6">
                    <label for="IDofInput">Departman</label>
					<?php
						$liste_selected="";
						if($admini_getir["departman"]=="Müşteri Temsilcisi"){
							$liste_selected="";
						}else if($admini_getir["departman"]=="Veri Giriş Sorumlusu"){
							$liste_selected="";
						}else if($admini_getir["departman"]=="Sistem Destek Uzmanı"){
							$liste_selected="";
						}else if($admini_getir["departman"]=="Saha Sorumlusu"){
							$liste_selected="";
						}else if($admini_getir["departman"]=="Muhasebe"){
							$liste_selected="";
						}else{
							$liste_selected="true";
						}
					?>
					<select onchange="departman_controle();" name="departman" id="departman" class="span12">
						<option <?php if($admini_getir["departman"]=="Müşteri Temsilcisi"){ echo "selected"; } ?> value="Müşteri Temsilcisi">Müşteri Temsilcisi</option>
						<option <?php if($admini_getir["departman"]=="Veri Giriş Sorumlusu"){ echo "selected"; } ?> value="Veri Giriş Sorumlusu">Veri Giriş Sorumlusu</option>
						<option <?php if($admini_getir["departman"]=="Sistem Destek Uzmanı"){ echo "selected"; } ?> value="Sistem Destek Uzmanı">Sistem Destek Uzmanı</option>
						<option <?php if($admini_getir["departman"]=="Saha Sorumlusu"){ echo "selected"; } ?> value="Saha Sorumlusu">Saha Sorumlusu</option>
						<option <?php if($admini_getir["departman"]=="Muhasebe"){ echo "selected"; } ?> value="Muhasebe">Muhasebe</option>
						<option <?php if($liste_selected=="true"){ echo "selected"; } ?> value="Diğer">Diğer</option>
					</select>
					<input type="text" style="<?php if($liste_selected=="true"){ echo "display:block"; }else{ echo "display:none"; }  ?>" class="span12" id="diger_departman" name="diger_departman" value="<?=$admini_getir["departman"] ?>" >
                </div>
                
            </div>
			<div class="row">
                <div class="span6">
                    <label for="IDofInput">Prim Oranı</label>
					<?php
						if($admin_id==1 || $admin_id == 14){ ?>
							<input type="number" step="0.01" class="span12" value="<?= $admini_getir['prim_orani'] ?>" name="prim_orani" class="span12">
					<?php }else{ ?>
							<span class="span12" class="span12"><?= $admini_getir['prim_orani'] ?></span>
					<?php } ?>
                </div>
               
            </div>
			<?php if($gelen_id == 1){ ?>
			<div class="row">
				<div class="span6">
					<label for="IDofInput">Performas Kazancı Oranı</label>
					<?php if($admin_id==1 || $admin_id == 14){ ?>
						<input type="number" step="0.001" class="span12" value="<?= $admini_getir['performans_kazanci_orani'] ?>" name="performans_kazanci_orani" class="span12">
					<?php } else { ?>
						<span class="span12" class="span12"><?= $admini_getir['performans_kazanci_orani'] ?></span>
					<?php } ?>
				</div>
				<div class="span6"></div>
			</div>
            <?php } ?>
			<div class="row">    
                <div style="display:flex;" class="span6">
                    <label for="IDofInput">Listelenme Durumu</label>
					<?php
						$listelenme_durumu="";
						if($admini_getir['listelenme_durumu']==1){
							$listelenme_durumu="checked";
						}
					?>
                    <input type="checkbox" <?=$listelenme_durumu ?> class="span12" name="listelenme_durumu" id="listelenme_durumu" onchange="listelenme_controle();" value="1" class="span12">
                </div>
				<input type="number" style="<?php if($listelenme_durumu == "checked" ){ echo "display:block"; }else{ echo "display:none"; } ?>" class="span7" id="listelenme_sirasi" name="listelenme_sirasi" value="<?=$admini_getir['listelenme_sirasi'] ?>">
                
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" name="yoneticiyi" class="btn blue" value="Kaydet" />
        </div>
    </div>
<?php } ?>
</form>
<?php }else{ ?>

<form method="POST" id="form" name="form">
<?php include('islemler/kullanicilar/kullanici_ekle.php'); ?>
    <div class="row-fluid" style="margin-top: 2%;">
        <div class="span6">
            <label for="IDofInput">Adı</label> 
            <input required type="text" class="span12" id="adi" name="adi"/> 
            <label for="IDofInput">Soyadı</label> 
            <input required type="text" class="span12" id="soyadi"  name="soyadi"/> 
            <label for="IDofInput">Kullanıcı Adı</label> 
            <input onkeypress="temizle(event);"  onpaste="return false;" type="text" class="span12" id="kullanici_adi" name="kullanici_adi" required /> 
            <label for="IDofInput">Email Adresi</label> 
            <input onkeypress="temizle();"  type="email" class="span12" name="email" required/> 
            <label for="IDofInput">Şifre</label> 
            <input onkeypress="temizle();" type="password" class="span12" name="sifre" required/> 
            <label for="IDofInput">Şifre Tekrar</label> 
            <input onkeypress="temizle();" type="password" class="span12" name="sifre_tekrar" required/> 
            <label for="IDofInput">Gsm</label> 
            <input onkeypress="temizle();"  type="tel" class="span12" id="gms_no" name="gsm" maxlength="11" required onkeypress="return isNumberKey(event)" /> 

        </div>
        <div class="span6">
           <!-- <label for="IDofInput">YETKİLER</label> 
             <select name="uye_grubu" id="yetki_grubu" onchange="check()" tabindex="1">
                <option id="tam_yetki"  value="0">Tam Yetki</option>
                <option id="sinirli_yetki" value="1" >Sınırlı Yetki</option>
            </select><br>--> 
            <label for="IDofInput">Prim Oranı</label>
            <?php
                if($admin_id == 1 || $admin_id == 14){ ?>
                    <input type="number" step="0.01" class="span12"  name="prim_orani" class="span12">
            <?php }else{ ?>
                    <span class="span12" class="span12"></span>
            <?php } ?>
            
            <div class="row">
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="ilan_duzenle" value="1" style="opacity:1 !important;" > İlan Düzenleme
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="ilan_sil" value="2" > İlan Silme
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox"  class="a"id="ilan_statu" value="3" > Statü Tanımlama
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="uye_duzenle" value="4" > Üye Düzenleme
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox"  class="a"id="uye_yetki" value="5" > Üye Yetki Sekmesi
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="uye_cayma" value="6" > Üye Cayma Bedeli Sekmesi
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="uye_sil" value="7" > Üye Silme
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="not_duzenle" value="8" > Not Düzenleme
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox"  class="a" id="not_sil" value="9" > Not Silme
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="satilan_arac" value="10" > Satılan Araçlar Listesi
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="muhasebe" value="11" > Performanslar
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a" id="uye_bakiye" value="12" > Üye Bakiyelerini Görme Yetkisi
                </label>
                <label class="checkbox">
                <input name="yetki[]" type="checkbox" class="a"  id="musteri_temsilcisi_atama" value="13" > Müşteri Temsilcisi Atama
                </label>
            </div>
            <div class="row">
                <div class="span6">
                    <label for="IDofInput">Günlük PRM Ekleme Limiti</label>
                    <input type="number" class="span12" name="prm_limiti" class="span12">
                </div>
                <div class="span6"></div>
            </div>
			<div class="row">
                <div class="span6">
                    <label for="IDofInput">Departman</label>
					<select onchange="departman_controle();" name="departman" id="departman" class="span12">
						<option value="Müşteri Temsilci">Müşteri Temsilcisi</option>
						<option value="Veri Giriş Sorumlusu">Veri Giriş Sorumlusu</option>
						<option value="Sistem Destek Uzmanı">Sistem Destek Uzmanı</option>
						<option value="Saha Sorumlusu">Saha Sorumlusu</option>
						<option value="Muhasebe">Muhasebe</option>
						<option value="Diğer">Diğer</option>
					</select>
					<input type="text" style="display:none" class="span12" id="diger_departman" name="diger_departman">
                </div>
                <div class="span6"></div>
            </div>
			<?php
				if($admin_yetki_oku["id"]==1){
			?>
			<!-- <div class="row">
                <div class="span6">
                    <label for="IDofInput">Prim Oranı</label>
                    <input type="number" step="0.01" class="span12" name="prim_orani" class="span12">
                </div>
                <div class="span6"></div>
            </div> -->
				<?php } ?>
			<div class="row">    
                <div style="display:flex" class="span6">
                    <label for="IDofInput">Listelenme Durumu</label>
                    <input type="checkbox" onchange="listelenme_controle();" class="span12" id="listelenme_durumu" name="listelenme_durumu" value="1" >
                </div>
				<input type="number" style="display:none" class="span7" id="listelenme_sirasi" name="listelenme_sirasi">
                <div class="span6"></div>
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" name="yoneticiyi" class="btn blue" value="Kaydet" />
        </div>
    </div>
</form>
<?php } ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
	$('input[type="tel"]').mask('0(000)000-0000');

</script>
<script>
	function temizle(e){
		var regex = new RegExp("^[a-zA-Z0-9 ]+$");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}

		e.preventDefault();
		return false;
	}
	function temizle2(id) {  
		var a=$("#"+id).val();
		var b=a.replace(/[^a-z0-9]/gi,'');
		$("#"+id).val(b);
		$("#"+id).html(b);
	}

</script>	
<script>
    function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}


</script>
 <script>
$(document).ready(function() {
    //check();
});

    function check() {

    var yetki_grubu = document.getElementById('yetki_grubu').value;

    if(yetki_grubu == 0){
        $( "#ilan_duzenle" ).prop( "checked", true );
        $("#ilan_duzenle").prop("checked", true);
        $("#ilan_sil").prop("checked", true);
        $("#ilan_statu").prop("checked", true);
        $("#uye_duzenle").prop("checked", true);
        $("#uye_yetki").prop("checked", true);
        $("#uye_cayma").prop("checked", true);
        $("#uye_sil").prop("checked", true);
        $("#not_duzenle").prop("checked", true);
        $("#not_sil").prop("checked", true);
        $("#satilan_arac").prop("checked", true);
        $("#muhasebe").prop("checked", true);
        $("#uye_bakiye").prop("checked", true);
        $("#nakit").prop("checked", true);
        $("#musteri_temsilcisi_atama").prop("checked", true); 
    }
    if(yetki_grubu==1){      

        $("#ilan_duzenle").prop("checked", false);
        $("#musteri_temsilcisi_atama").prop("checked", false);
        $("#ilan_sil").prop("checked", false);
        $("#ilan_statu").prop("checked", false);
        $("#nakit").prop("checked", false);
        $("#not_sil").prop("checked", false);
        $("#satilan_arac").prop("checked", false);
        $("#muhasebe").prop("checked", false);
       
    }
    
}

function departman_controle(){
	var departman=$("#departman").val();
	if(departman=="Diğer"){
		$("#diger_departman").css("display","block");
	}else{
		$("#diger_departman").css("display","none")
	}
}
function listelenme_controle(){
	var listelenme=$('#listelenme_durumu').is(':checked');
	if(listelenme==true){
		$("#listelenme_sirasi").css("display","block");
	}else{
		$("#listelenme_sirasi").css("display","none")
	}
}
</script> 

