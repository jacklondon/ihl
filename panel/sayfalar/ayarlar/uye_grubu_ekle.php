<div role="alert" class="alert " style="background-color: white;">
    <div class="alert-icon alert-icon-top">
    <i class="fas fa-exclamation-triangle"></i>Bu ekrandan üye grubu ekliyebilirsiniz<br>* İşaretli alanları eksizsiz doldurun.
    </div>
</div>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
<?php include('islemler/ayarlar/uye_grubu_ekle.php'); ?>
<div class="row-fluid">
    <div class="span6">
        <label for="UyeGrubu">Üye Grubu*</label>
        <input type="text" name="uye_grubu" class="span12">
		<!-- <label for="UyeGrubu">Üyelik Ücreti*</label>
        <input type="checkbox" name="uyelik_ucreti" value="1" class="span12">
		 <label for="UyeGrubu">Teminat İadesi*</label>
        <input type="checkbox" name="teminat_iadesi" value="1" class="span12">-->
    </div>
    <div class="span6"></div>
</div>
<div class="row-fluid" style="margin-top: 2%;">
        <input type="submit" class="btn" name="uye_grubunu" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
</div>
</form>
