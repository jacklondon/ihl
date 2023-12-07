<!--<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>-->
<script src="assets/ckeditor4/ckeditor.js"></script>
<div class="row-fluid" style="margin-top: 2%;">
	<div class="span12">
		<button class="btn btn blue btn-block form-control span6" id="soru_gizle" onclick="Yeni_soru()">Yeni Ekle</button>
		<form method="POST" style="display: none; margin-top:2%;" id="yeni_ekle" enctype="multipart/form-data">
			<?php include('islemler/ayarlar/duyuru_ekle.php'); ?>
			<label for="IDofInput" class="span12">Başlık</label>
			<input type="text" name="baslik" class="span12">
			<label for="IDofInput" class="span12" style="margin-left: 0;">Kısa İçerik</label>
			<textarea name="kisa_icerik" class="span12"  rows="2"></textarea>
			<label for="IDofInpıt">Resim</label>
			<input type="file" name="file">
			<label for="IDofInput">İçerik</label>
			<textarea name="icerik" id="icerik" class="span12"  rows="5"></textarea>
			<div class="row-fluid" style="margin-top: 10px;">
				<div class="span6">
					<input type="submit" class="btn blue btn-block" name="duyuru" value="Ekle">
				</div>
			</div>
		</form>
	</div>
</div>

<script>
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
	/* ClassicEditor
    .create( document.querySelector( '#icerik' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );*/
	CKEDITOR.replace( 'icerik', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	} );
</script>
<style>
	.ck-editor__editable_inline {
		min-height: 200px !important;
	}
</style>
	<?php 
		$duyuru_cek = mysql_query("SELECT * FROM duyurular order by eklenme_zamani desc");
    ?>
	<form action="" method="POST" name="form" id="form">
		<div class="accordion" id="accordion3" style="margin-top: 2%;">
		<?php
			$sira = 1;
			while($duyuru_oku = mysql_fetch_array($duyuru_cek)){
				$duyuru_id = $duyuru_oku["id"]; ?>
				<div class="row-fluid">  
					<div class="span11">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#b<?=$duyuru_oku["id"]?>">
									<i class="fas fa-angle-down"> <?=$duyuru_oku["baslik"]?></i>
								</a>
							</div>
							<div id="b<?=$duyuru_oku["id"]?>" class="accordion-body collapse">
								<div class="accordion-inner">
									<img src="../duyurular/<?=$duyuru_oku['resim'] ?>" alt="">
									<?=$duyuru_oku["icerik"]?>
								</div>
							</div>
						</div>
					</div>
					<div class="span1">
						<a href="?modul=ayarlar&sayfa=edit_duyuru&id=<?= $duyuru_id ?>" class="btn mini"><i class="fas fa-edit"></i></a>
						<a href="?modul=ayarlar&sayfa=data_sil&id=<?= $duyuru_id ?>&q=duyuru_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')" class="btn mini"><i class="fas fa-trash"></i></a>
					</div>
				</div> 
			<?php } ?>
		</div>
	</form>


