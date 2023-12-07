<!--<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>-->
<!--<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>-->
<script src="assets/ckeditor4/ckeditor.js"></script>
<div class="row-fluid" style="margin-top: 2%;">
	<div class="span12">
		<button class="btn btn blue btn-block form-control span6" id="soru_gizle" onclick="Yeni_soru()">Yeni Ekle</button>
		<form method="POST" style="display: none; margin-top:2%;" id="yeni_ekle" enctype="multipart/form-data">
			<?php include('islemler/ayarlar/sik_sorulan_soru_ekle.php'); ?>
			<label for="IDofInput" class="span12">Soru Adı</label>
			<input type="text" name="soru" class="span12">
			<label for="IDofInput">Cevap</label>
			<textarea name="cevap" id="cevap" class="span12"  rows="5"></textarea>
			<div class="row-fluid" style="margin-top: 10px;">
				<div class="span6">
					<input type="submit" class="btn blue btn-block" name="sik_sorulan_soruyu" value="Ekle">
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	CKEDITOR.replace( 'cevap', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	} );
	
	function Yeni_soru() {
		var x = document.getElementById("yeni_ekle");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
		var y = document.getElementById("soru_gizle");
		y.style.display= "none";
	}
</script>

<style>
	.ck-editor__editable_inline {
		min-height: 200px !important;
	}
</style>
    <?php 
      $soru_cek = mysql_query("SELECT * FROM sss");
    ?>
	<form action="" method="POST" name="form" id="form">
		<div class="accordion" id="accordion3" style="margin-top: 2%;">
			<?php
				$sira = 1;
				while($soru_oku = mysql_fetch_array($soru_cek)){
					$soru_id = $soru_oku["id"];
			?>
			<div class="row-fluid">
				<div class="span11">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#b<?=$soru_oku["id"]?>">
								<i class="fas fa-angle-down"> <?=$soru_oku["soru"]?></i>
							</a>
						</div>
						<div id="b<?=$soru_oku["id"]?>" class="accordion-body collapse">
							<div class="accordion-inner"><?=$soru_oku["cevap"]?>
							</div>
						</div>
					</div>
				</div>
				<div class="span1">
					<a href="?modul=ayarlar&sayfa=data_sil&id=<?= $soru_id ?>&q=sss_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn mini"><i class="fas fa-trash"></i></a>
					<a href="?modul=ayarlar&sayfa=sss_duzenle&id=<?= $soru_id ?>" class="btn mini"><i class="fas fa-edit"></i></a>
				</div>
			</div>
			<?php } ?>
		</div>
	</form>


