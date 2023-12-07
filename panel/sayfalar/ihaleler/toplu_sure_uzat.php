 <?php 
include('../../../ayar.php');
$guncellenecek = $_POST['secim'];

if(count($guncellenecek)>0)
{	
	$admin_id = $_SESSION['kid'];
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
	$yetkiler=$admin_yetki_oku["yetki"];
	$yetki_parcala=explode("|",$yetkiler);
	if (in_array(1, $yetki_parcala)) {
		
	$output="";
	$sayisi=count($guncellenecek);
	for($i=0;$i< $sayisi;$i++){ 
		$output .= '<input type="hidden" id="secilen_id_'.$i.'" value="'.$guncellenecek[$i].'">';
	} 
		$output .= '
			<div class="row-fluid">
					<label for="IDofInput">Tarih</label>
					<input type="date" name="secili_tarih" id="secili_tarih" class="span6" max="9999-12-31">
					<label for="IDofInput">Saat</label>
					<input type="time" name="secili_saat"  id="secili_saat" class="span6">
				</div>
				<div class="row-fluid" style="margin-top:3%;">
					<div class="span6" style="display:none" id="sure_uyari_span">
						<input type="checkbox" value="1" id="sure_uyari_durum" name="sure_uyari_durum" ><text style="margin-left:1%;"> Uyarıya rağmen işlemi yap</text>
					</div>
					<div class="span6">
						
					</div>
				</div>
				<div class="row-fluid">
				   <input type="button" onclick="sureyi_kaydet2(); " name="sureyi" class="btn-primary" value="Kaydet">
				</div>
				<script>
					function sureyi_kaydet2(){
						var a =new Array();
						var h;
						for(h=0;h<'.$sayisi.';h++){
							a.push(document.getElementById("secilen_id_"+h).value);
						}
						if(document.getElementById("sure_uyari_durum").checked==true){
							var uyari_durum=document.getElementById("sure_uyari_durum").value;
						}else{
							var uyari_durum="";
						}
						jQuery.ajax({
							url: "https://ihale.pertdunyasi.com/check.php",
							type: "POST",
							dataType: "JSON",
							data: {
								action: "panel_zaman_duzenle",
								json_array:a,
								secili_tarih:document.getElementById("secili_tarih").value,
								secili_saat:document.getElementById("secili_saat").value,
								uyari_durum:uyari_durum
							},
							success: function(response) {
								console.log(response);
								if(response.status==200){
									alert(response.message);
									window.location.reload();
								}else{
									alert(response.message);
									if(response.ihale_durum==1){
										document.getElementById("sure_uyari_span").style.display = "block";
									}else{
										alert(response.message);
									}
									
								}
							}
						});
				}
			   </script>
			';
			echo $output;
	}else{
		echo "<script>alert('İlan düzenleme yetkiniz yoktur.')</script>";
		echo '<script>window.location.reload();</scriptwindow.location.reload>';
		// echo '<script>window.location.href = "?modul=ihaleler&sayfa=tum_ihaleler";</scriptwindow.location.reload>';
	}
   
}

?>
