
<?php 

function pre_up($str){
    $str = str_replace('i', 'İ', $str);
    $str = str_replace('ı', 'I', $str);
    return $str;
}
session_start();
$admin_id=$_SESSION['kid'];

$gelen_id = re("id");

$ilani_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE id = $gelen_id");
$ilani_oku=mysql_fetch_object($ilani_cek);

$marka_cek=mysql_query("select * from marka where markaID='".$ilani_oku->marka."' ");
$marka_oku=mysql_fetch_object($marka_cek);

$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
$yetkiler=$admin_yetki_oku["yetki"];
$yetki_parcala=explode("|",$yetkiler);

if (!in_array(1, $yetki_parcala)) { 
    $aktiflik = "disabled";
    $gorunme = "none";
  } 
	$ilan_resimleri_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE ilan_id = '".re("id")."'");
?>
	<style>
		.blue-text {
  color: blue;
}

.underline {
  text-decoration: underline;
}

.drop-field {
  position: relative;
  text-align: center;
  vertical-align: middle;
}

.drop-field,
.drop-area {
margin-top:10px;
  height: 200px;
  width: 100%;
}

.drop-field .browse {
  z-index: 0;
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  margin: 0 auto;
}

.drop-field .drop-area {
  display: block;
  border: 3px dashed #ce680d;
  position: relative;
}

.drop-field,
.drop-area,
.drop-field .browse {
  transition: all 0.3s;
}

.drop-field.loaded .drop-area {
  border: 1px solid blue;
}

.drop-field .browse {
  opacity: 0;
  transform: translateY(100%);
}

.drop-field.loaded .browse {
  opacity: 1;
  transform: translateY(0);
}

.drop-field.hover .drop-area {
  border: 1px solid black;
}

.drop-field .drop-area input[type="file"] {
  height: 100%;
  width: 100%;
  position: absolute;
  display: block;
  z-index: 3;
  top: 0;
  left: 0;
  opacity: 0.000001;
}

.drop-field .file-list {
  position: absolute;
  z-index: 0;
  top: 0;
  left: 0;
  text-align: center;
}

.drop-field .remove {
  position: absolute;
  left: 20px;
  top: 20px;
  z-index: 4;
  transition: all 0.3s;
  opacity: 0;
  transform: translateY(-100%);
  cursor: pointer;
}

.drop-field .remove:hover {
  color: blue;
}

.drop-field.loaded .remove {
  opacity: 1;
  transform: translateY(0);
}

.drop-field ul li {
	margin-left: 50px;
	font-size: 15px;
  padding: 0;
  text-align: center;
  list-style: none;
}
</style>
	<?php 
		$ilan_resimleri_cek = mysql_query("SELECT * FROM dogrudan_satisli_resimler WHERE ilan_id = '".$gelen_id."'");
	?>
	<form method="POST" id="form" name="form" enctype="multipart/form-data">
		<input type="hidden" name="action" value="dogrudan_ilan_resim_ekle" />
		<div class="row-fluid" style="margin-top:1%;margin-right: 2% !important; margin-left: 2% !important; width:96% !important;">
			<b style="float:right;" ><?php echo "#".$ilani_oku->arac_kodu." / ".$ilani_oku->model_yili." / ".$ilani_oku->marka." / ".$ilani_oku->model." / ".$ilani_oku->uzanti ?></b>
		</div>
		<div class="row-fluid" style="margin-right: 2% !important; margin-left: 2% !important; width:96% !important;">
			<input type="button" class="btn" <?= $aktiflik ?> onclick="dogrudan_butun_resim_sil(<?=$gelen_id ?>)" value="Bütün Resimleri Sil" style="background-color: rgb(251,57,122); color:white;">
			<a href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?= $gelen_id ?>"><button type="button" class="btn-primary">Araç Bilgilerine Geri Dön</button></a>
			<div class="form-group">
				<br/>
				<text>Dosyaları seçmek için aaşağıdaki alana tıklayabilir veya dosyaları alanın içine sürükleyebilirsiniz.</text>
				<input onchange="dogrudan_resim_yukle(<?= $gelen_id ?>)" id="file_input" name="resim[]" type="file" multiple>
			</div>
			<div class="row-fluid" style="margin-left:1px;">
				<ul id="kayitli_resimler" class="thumbnails">
					<?php while($resim_oku = mysql_fetch_array($ilan_resimleri_cek)){
						$resim = "../images/".$resim_oku['resim']; ?>  
						<li id="<?= $resim_oku['id'] ?>" style="margin-left:5px;margin-top:10px;" class="span4">
							<a href="#" class="thumbnail">
								<img src="<?= $resim ?>" style="height:100px;">
							</a><br/>
							<a style="display: <?= $gorunme ?>;" href="#" onclick="dogrudan_resim_sil(<?=$resim_oku['id'] ?>)" class="btn red">Sil</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</form>
    
<?php 
	if(re('hepsini_sil')=="Bütün Resimleri Sil"){
		mysql_query("DELETE FROM ilan_resimler WHERE ilan_id = '".re('id')."'");
		header('Location: ?modul=ilanlar&sayfa=ilan_resim_ekle&id='.re('id').'');
	}
?>



<script src="https://code.jquery.com/jquery-3.6.0.js" > </script>

<script>
	var globalFunctions = {};
	globalFunctions.ddInput = function(elem) {
		if ($(elem).length == 0 || typeof FileReader === "undefined") return;
		var $fileupload = $('input[type="file"]');
		var noitems = '<li class="no-items"></li>';
		var hasitems = '<div class="browse hasitems">Dosya Seçimi </div>';
		var file_list = '<ul class="file-list"></ul>';
		var rmv = '<div class="remove"><i style="font-size:30px" class="icon-close icons">x</i></div>'
		$fileupload.each(function() {
			var self = this;
			var $dropfield = $('<div class="drop-field"><div class="drop-area"></div></div>');
			$(self).after($dropfield).appendTo($dropfield.find('.drop-area'));
			var $file_list = $(file_list).appendTo($dropfield);
			$dropfield.append(hasitems);
			$dropfield.append(rmv);
			$(noitems).appendTo($file_list);
			var isDropped = false;
			$(self).on("change", function(evt) {
				if ($(self).val() == "") {
					$file_list.find('li').remove();
					$file_list.append(noitems);
				} else {
					if(!isDropped) {
						$dropfield.removeClass('hover');
						$dropfield.addClass('loaded');
						var files = $(self).prop("files");
						traverseFiles(files);
					}
				}
			});
			
			$dropfield.on("dragleave", function(evt) {
				$dropfield.removeClass('hover');
				evt.stopPropagation();
			});

			$dropfield.on('click', function(evt) {
				$(self).val('');
				$file_list.find('li').remove();
				$file_list.append(noitems);
				$dropfield.removeClass('hover').removeClass('loaded');
			});

			$dropfield.on("dragenter", function(evt) {
				$dropfield.addClass('hover');
				evt.stopPropagation();
			});

			$dropfield.on("drop", function(evt) {
				isDropped = true;
				$dropfield.removeClass('hover');
				$dropfield.addClass('loaded');
				var files = evt.originalEvent.dataTransfer.files;
				traverseFiles(files);
				isDropped = false;
			});


			function appendFile(file) {

				$file_list.append('<li>' + file.name + '</li>');
			}

			function traverseFiles(files) {
				if ($dropfield.hasClass('loaded')) {
					$file_list.find('li').remove();
				}
				if (typeof files !== "undefined") {
					for (var i = 0, l = files.length; i < l; i++) {
						appendFile(files[i]);
					}
				} else {
					alert("Tarayıcının dosya yükleme özelliği yok.");
				}
			}

		});
	};

	$(document).ready(function() {
		globalFunctions.ddInput('input[type="file"]');
	});
	function dogrudan_resim_yukle(id){
		   
		var formData = new FormData(document.getElementById('form'));
		formData.append('id', id);  
		formData.append("action", "dogrudan_ilan_resim_ekle");
		var filesLength=document.getElementById('file_input').files.length;
		for(var i=0;i<filesLength;i++){
			formData.append("resim[]", document.getElementById('file_input').files[i]);
		}
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(response) {
				var gorunme=<?php echo json_encode($gorunme); ?>;
				alert("Yükleme Başarılı");
				var dosya_sayisi=response.yukleme_sayisi;
				
			var li_html=$("#kayitli_resimler").html();
				li_html=$("#kayitli_resimler").html();
				var li_html2="";
				for(var j=0;j<filesLength;j++){
					li_html+="<li id='"+response.resim_id[j]["resim_id"]+"' style='margin-left:5px;margin-top:10px;' class='span4'><a href='#' class='thumbnail'><img src=../images/"+ response.resim[j]["ad"] +" value='' style='height:100px;'></a><br/><a style='display: "+gorunme +"' href='?modul=ayarlar&sayfa=data_sil&id="+response.resim_id[j]["resim_id"]+"&q=resim&g="+id+"' class='btn red'>Sil</a></li>";
				}
				$("#kayitli_resimler").html(li_html+li_html2);
				var file_list = '<ul class="file-list"></ul>';
				var dropfield = $('<div class="drop-field"><div class="drop-area"></div></div>');
				var noitems = '<li class="no-items"></li>';
				$('input[type="file"]').val('');
				$(".file-list").remove();
				$(".drop-field").removeClass("loaded");


			},
			cache: false,
			contentType: false,
			processData: false
		});
		 
	}
	function dogrudan_resim_sil(id){ 

			$.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				method: 'POST',
				data: {
					action: "dogrudan_resim_sil",
					id: id
			   },
				success: function(data) {
					alert("İşlem Başarılı");
					$("#"+id).remove();
				},
				error: function(data) {
					
				}
			});

	}
	function dogrudan_butun_resim_sil(id){
		var a=confirm("Tüm resimleri silmek istediğinize emin misiniz");
		if(a){
			$.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				method: 'POST',
				data: {
					action: "dogrudan_resimleri_sil",
					id: id
			   },
				success: function(data) {
					alert("İşlem Başarılı");
					$("#kayitli_resimler").remove();
				},
				error: function(data) {
					
				}
			});	
		}
		
	}
</script>