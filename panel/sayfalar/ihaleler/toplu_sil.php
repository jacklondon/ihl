<?php 
	$admin_id = $_SESSION['kid'];
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
	$yetkiler=$admin_yetki_oku["yetki"];
	$yetki_parcala=explode("|",$yetkiler);
	
	$silinecek = $_POST['secim'];
	$sayisi=count($silinecek);
	for($i=0;$i< $sayisi;$i++){ ?>
		<input type="hidden" id="secilen_id<?=$i ?>" value="<?=$silinecek[$i] ?>">
	<?php } 


	if($_POST['secili_sil']){
		if (in_array(2, $yetki_parcala)) { 
		echo "<script>alert('İlan silme yetkiniz yok.')</script>";
			foreach ($silinecek as $sil) {
				mysql_query("DELETE FROM ilanlar WHERE id = '".$sil."'");
			}
			header('Location: ?modul=ihaleler&sayfa=tum_ihaleler');
		}else{
			echo "<script>alert('İlan silme yetkiniz yok.')</script>";
			echo '<script>window.location.href = "?modul=ihaleler&sayfa=tum_ihaleler";</script>';
		}
		
	}
	else if($_POST['uye_secili_sil'])
	{
		if (in_array(2, $yetki_parcala)) { 
			foreach ($silinecek as $sil) {
				mysql_query("DELETE FROM ilanlar WHERE id = '".$sil."'");
			}
			header('Location: ?modul=ihaleler&sayfa=uyelerden_gelenler');
		}else{
			echo "<script>alert('İlan silme yetkiniz yok.')</script>";
			echo '<script>window.location.href = "?modul=ihaleler&sayfa=uyelerden_gelenler";</script>';
		}
	}
	else if($_POST['uye_dogrudan_secili_sil']){
		if (in_array(2, $yetki_parcala)) { 
			foreach ($silinecek as $sil) {
				mysql_query("DELETE FROM dogrudan_satisli_ilanlar WHERE id = '".$sil."'");
			}
			header('Location: ?modul=ihaleler&sayfa=uyelerden_gelenler');
		}else{
			echo "<script>alert('İlan silme yetkiniz yok.')</script>";
			echo '<script>window.location.href = "?modul=ihaleler&sayfa=uyelerden_gelenler";</script>';
		}
	}
	else if($_POST['secili_uzat']){ 
	
		if (in_array(1, $yetki_parcala)) { ?>
			
			<div class="row-fluid">
				<label for="IDofInput">Tarih</label>
				<input type="date" name="secili_tarih" id="secili_tarih" class="span6">
				<label for="IDofInput">Saat</label>
				<input type="time" name="secili_saat"  id="secili_saat" class="span6">
			</div>
			<div class="row-fluid">
			   <input type="button" onclick="sureyi_kaydet(); " name="sureyi" class="btn-primary" value="Kaydet">
			</div>
			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
			<script>
				function sureyi_kaydet(){
					var a =new Array();
					var h;
					for(h=0;h<<?=$sayisi ?>;h++){
						a.push({ a:document.getElementById("secilen_id"+h).value });
					}
					//var array = JSON.stringify(a);
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_zaman_duzenle",
							json_array:JSON.stringify(a),
							secili_tarih:document.getElementById("secili_tarih").value,
							secili_saat:document.getElementById("secili_saat").value,
							
						},
						success: function(response) {
							console.log(response);
							if(response.status==200){
								alert(response.message);
								location.href="?modul=ihaleler&sayfa=tum_ihaleler";
								
							}else{
								alert(response.message);
							}
						}
					});
			}
		   </script>
		<?php }else{ 
			echo "<script>alert('İlan düzenleme yetkiniz yoktur.')</script>";
			echo '<script>window.location.href = "?modul=ihaleler&sayfa=tum_ihaleler";</script>';
		} 
 	} 
 
 ?>


