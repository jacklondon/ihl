
<?php 
	$sayac=1;
	$popup_cek = mysql_query("SELECT * FROM uye_giris_popup order by id asc");
	$popup_oku = mysql_fetch_array($popup_cek);
	if($popup_oku["durum"]=="1"){
		$checked="checked";
	}else{
		$checked="";
	}
	$secilme_checked="";
?>

<script src="assets/ckeditor4/ckeditor.js"></script>
	<h3>Üyelerin Sisteme Girişte Göreceği Popup</h3>
	<form name="uyelerin_gorecegi_popup" method="post" enctype="multipart/form-data">
		<?php include('islemler/ayarlar/popup.php'); ?>
		<textarea name="uyelerin_giriste_gorecegi_popup" id="uyelerin_giriste_gorecegi_popup"></textarea>
		<br/>
		<span>Onay Kutusu: </span><input type="checkbox" <?=$checked ?> name="pop_durum" id="pop_durum" value="1" /><br/>
		
		<span>Kimlere Gösterilsin: </span><br/>
		
		<?php 
			
			$popup_cek2=mysql_query("select uye_giris_popup.*,uye_grubu.* from uye_giris_popup inner join uye_grubu on uye_giris_popup.paket_id=uye_grubu.id order by uye_giris_popup.id asc");
			while($popup_oku2=mysql_fetch_object($popup_cek2)){
				if($popup_oku2->secilme_durumu=="1"){
					$secilme_checked="checked";
				}else{
					$secilme_checked="";
				}
			?>
				 <input type="checkbox" <?=$secilme_checked ?> name="gruplar[]" value="1" /><span><?=$popup_oku2->grup_adi ?> </span><br/>
				
		<?php } ?> 
		
		<div class="form-actions">
			<input type="submit" name="giriste_gorulecek_pupup" class="btn blue" value="Kaydet" />
		</div>
	</form>
	<style>
		.ck-editor__editable_inline {
			min-height: 200px !important;
		}
	</style>
<script>
    CKEDITOR.replace( 'uyelerin_giriste_gorecegi_popup', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	} );
</script>



  <div class="row-fluid">
    <div class="span6" style="background-color: #eaeaea;">
        <p name=""><?= $popup_oku["icerik"] ?></p>
    </div>
    <div class="span6">
 
    </div>
</div>
   
   

<?php



 
/* $popup_cek = mysql_query("SELECT * FROM uye_giris_popup");

?>
<?php while($popup_oku = mysql_fetch_array($popup_cek)){ ?>
<div class="row-fluid" style="margin-top: 5%;">

    <div class="span1">
    <a href="?modul=ayarlar&sayfa=data_sil&id=<?= $popup_oku['id'] ?>&q=popup_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')"><i class="fas fa-trash">Sil</i></a>
    </div>    
    <div class="span11">
    <textarea class="span12" readonly> <?= $popup_oku["icerik"]; ?></textarea>
    </div>
   
</div>
<?php } */ ?>

