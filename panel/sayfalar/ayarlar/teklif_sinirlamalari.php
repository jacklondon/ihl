<?php 
$gelen_id=re("id");
$teklif_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = $gelen_id");
?>
<?php if(!empty($gelen_id)){?>
<form action="" method="POST" name="form" id="form">
<div class="well">
    <i class="fas fa-exclamation-triangle"> Bu ekrandan seçtiğiniz üye grubu için teklif sınırı belirtebilirsiniz.<br>
        * işaretli alanları eksiksiz doldurun.
    </i>
    <div class="row-fluid" style="margin-top: 2%;">
        <a class="btn" name="teklif_sinirlamalari" style="color:white; text-decoration:none; cursor:pointer; background-color: rgb(88,103,221);" href="?modul=ayarlar&sayfa=uye_gruplari_ve_yetkileri">Teklif Sınırlamaları</a>
    </div>  
	<?php 
        while($teklif_oku = mysql_fetch_array($teklif_cek)){
    ?>
	<div class="row-fluid" style="margin-top: 2%;">
  
        <label for="CaymaBedeli">Paket Adı*</label>
        <input type="text"  name="grup_adi" value="<?= $teklif_oku["grup_adi"] ?>" class="span8">
		<!--<label for="uyelikUcreti">Üyelik Ücreti*</label>
        <input type="checkbox"  name="uyelik_ucreti" value="1" <?php if($teklif_oku["uyelik_ucreti"]=="1"){ echo "checked"; } ?> class="span8">
		<label for="teminatIadesi">Teminat İadesi*</label>
        <input type="checkbox"  name="teminat_iadesi" value="1" <?php if($teklif_oku["teminat_iadesi"]=="1"){ echo "checked"; } ?> class="span8">-->
		
    </div>
	
    <div class="row-fluid" style="margin-top: 2%;">
  
        <label for="CaymaBedeli">Cayma Bedeli*</label>
        <input type="text"  name="cayma_bedeli" value="" class="span8">
    </div>
    <!--<div class="row-fluid" style="margin-top: 2%;">
        <label for="TeklifUstLimiti">Teklif Üst Limiti*</label>
        <input type="number" name="teklif_ust_limit" value="<?= $teklif_oku["teklif_ust_limit"] ?>" class="span8">
    </div>-->
    <div class="row-fluid" style="margin-top: 2%;">
        <label for="StandartHesaplamalıIlan">Standart Hesaplamalı İlan Üst Limiti*</label>
        <input type="number" name="standart_hesaplamali_ilan" value="" class="span8">
    </div>
    <div class="row-fluid" style="margin-top: 2%;">
        <label for="LuksStandartlıIlan">Ticari Standartlı İlan Üst Limiti*</label>
        <input type="number" name="luks_teklif_ust_limit" value="" class="span8">
    </div>
    <div class="row-fluid" style="margin-top: 2%;">
        <input type="submit" class="btn" name="teklif_sinirlamalarini" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
    </div>
    <?php }?>
</div>
</form>


 <!--<form action="" method="POST" name="form" id="form">
<div class="well">
    <i class="fas fa-exclamation-triangle"> Bu ekrandan seçtiğiniz üye grubu için teklif sınırı belirtebilirsiniz.<br>
        * işaretli alanları eksiksiz doldurun.
    </i>
    <div class="row-fluid" style="margin-top: 2%;">
        <a class="btn" name="teklif_sinirlamalari" style="color:white; text-decoration:none; cursor:pointer; background-color: rgb(88,103,221);" href="?modul=ayarlar&sayfa=uye_gruplari_ve_yetkileri">Teklif Sınırlamaları</a>
    </div>
    <div class="row-fluid" style="margin-top: 2%;">
        <label for="CaymaBedeli">Cayma Bedeli*</label>
        <input type="text"  name="cayma_bedeli"  class="span8">
    </div>
    <div class="row-fluid" style="margin-top: 2%;">
        <label for="TeklifUstLimiti">Teklif Üst Limiti*</label>
        <input type="number" name="teklif_ust_limit"  class="span8">
    </div>
    <div class="row-fluid" style="margin-top: 2%;">
        <label for="StandartHesaplamalıIlan">Standart Hesaplamalı İlan Üst Limiti*</label>
        <input type="number" name="standart_hesaplamali_ilan"  class="span8">
    </div>
    <div class="row-fluid" style="margin-top: 2%;">
        <label for="LuksStandartlıIlan">Ticari Standartlı İlan Üst Limiti*</label>
        <input type="number" name="luks_teklif_ust_limit" class="span8">
    </div>
    <div class="row-fluid" style="margin-top: 2%;">
        <input type="submit" class="btn" name="teklif_sinirlamalarini" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
    </div>
</div>
</form>
-->
   <form method="POST" action="" name="form2" id="form2">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cayma Bedeli</th>
                    <th>Standart Hesaplamalı İlan Üst Limiti</th>
                    <th>Ticari Hesaplamalı İlan Üst Limiti</th>
                    <th>Sil</th>
                </tr>
            </thead>
                 <?php 
                 $sinir_cek = mysql_query("SELECT * FROM uye_grubu_detaylari WHERE grup_id='".$gelen_id."' order by cayma_bedeli asc");
                    $sayac=1;
                    while($sinir_oku = mysql_fetch_array($sinir_cek)){
                ?>
            <tbody>
                <tr>
                    <td><?= $sayac++; ?></td>
                    <td><?= money($sinir_oku["cayma_bedeli"]) ?> ₺</td>
                    <td><?= money($sinir_oku["standart_ust_limit"]) ?> ₺</td>
                    <td><?= money($sinir_oku["luks_ust_limit"]) ?> ₺</td>
                    <td><a name="sil" href="?modul=ayarlar&sayfa=data_sil&grup_id=<?=$gelen_id ?>&id=<?= $sinir_oku["id"] ?>&q=sinirlama_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')"><i style="color:black;" class="fas fa-trash"></i></a></td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>    
    </form>

<?php }?>

<?php 

if(re('teklif_sinirlamalarini')=="Kaydet"){
    mysql_query("
		UPDATE
			uye_grubu
		SET        
			grup_adi = '".re('grup_adi')."',
		WHERE 
			id = $gelen_id"
	);
    
	if( re('luks_teklif_ust_limit')!="" && re('cayma_bedeli')!="" && re('standart_hesaplamali_ilan')!="" ){
		$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$gelen_id."'");
		$durum="false";
		while($grup_oku=mysql_fetch_array($grup_cek)){

			if(re("cayma_bedeli")==$grup_oku["cayma_bedeli"]){ 
				$durum="true";
			}
			
		}
		if($durum=="true"){
			echo "<script>alert('Belirtilen cayma bedeline ait teklif limitleri daha önce belirlenmiş.Eklemek istiyorsanız önce mevdut kaydı silip tekrar ekleme işlemini yapmalısınız.')</script>";
		}else{
		$ekle=mysql_query("
							insert into
								uye_grubu_detaylari 
							(grup_id,cayma_bedeli,standart_ust_limit,luks_ust_limit) 
								values
							('".$gelen_id."','".re("cayma_bedeli")."','".re("standart_hesaplamali_ilan")."','".re("luks_teklif_ust_limit")."')
						");
		/*$uyeler_cek = mysql_query("SELECT * FROM user WHERE paket = '".$gelen_id."'");
		while($uyeler_oku = mysql_fetch_array($uyeler_cek)){
			mysql_query("UPDATE teklif_limiti SET teklif_limiti = '".re('teklif_ust_limit')."',
			standart_limit = '".re('standart_hesaplamali_ilan')."', luks_limit = '".re('luks_teklif_ust_limit')."'
			WHERE uye_id = '".$uyeler_oku['id']."'");
		}*/
		header("Location:?modul=ayarlar&sayfa=teklif_sinirlamalari&id=$gelen_id");   
		}
	}
	
}

?>
