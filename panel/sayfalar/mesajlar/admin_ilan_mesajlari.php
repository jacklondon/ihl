
<?php 
session_start();
$admin_id=$_SESSION['kid'];

include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id)
{
    $output .= '';   
    $ilan_mesajlar = mysql_query("SELECT * FROM mesajlar WHERE ilan_id ='".$gelen_id."' and alan_id =0 and durum=0 order by gonderme_zamani desc");
    $ilan_gonderilen_mesajlar = mysql_query("SELECT * FROM mesajlar WHERE ilan_id ='".$gelen_id."' and gonderen_id=0 order by gonderme_zamani desc");

    $output .= '
		<div style="float:right;margin-bottom:10px;">
		
		
        </div>
		<table class="table table-bordered">
        <thead>
            <tr>
				<th>Mesaj Zamanı</th>
				<th>Mesaj </th>
				<th>Gönderen Üye</th>
				<th>Cevap</th>
				<th>Gönder</th>
				
			</tr>
        </thead>'; 

         while($mesajlar = mysql_fetch_array($ilan_mesajlar)){
			 if(mysql_num_rows($ilan_mesajlar) > 0){
			  $okunma_durumu="";
             $arac_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$mesajlar['ilan_id']."' LIMIT 1");
             $uye_cek = mysql_query("SELECT * FROM user WHERE id = '".$mesajlar['gonderen_id']."' LIMIT 1");
			if($mesajlar["durum"]=="0"){
				$okunma_durumu="Okunmadı";
			}else{
				$okunma_durumu="Okundu";
			}
            
         $output .= '
         <tbody> ';
		
         while($uye_oku = mysql_fetch_array($uye_cek)){
             $uye_ad = $uye_oku['ad'];
             $uye_telefon = $uye_oku['telefon'];

         $output .= '
            <tr id="" style = "'.$style.'">   
                <td id="eski_mesaj_tarih'.$mesajlar['id'].'">'.$mesajlar['gonderme_zamani'].'</td>         
                <td id="eski_mesaj'.$mesajlar['id'].'">'.$mesajlar['mesaj'].'</td>         
				<td>'.$uye_ad.'</td>
				<td><input type="text" name="admin_cevap'.$mesajlar['id'].'" id="admin_cevap'.$mesajlar['id'].'" ></td>
				<td><button type="button" class="btn blue" onclick="cevapla('.$mesajlar['ilan_id'].','.$mesajlar['gonderen_id'].','.$mesajlar['id'].');" name="cevap_gonder'.$mesajlar['id'].'" id="cevap_gonder'.$mesajlar['id'].'" > Gönder </button></td>
                
		 </tr>  ';  }  } }
         $output .='
         </tbody>
		 
      </table>
	  
	  <text>Gönderilen Mesajlar</text>
	 <table class="table table-bordered">
        <thead>
            <tr>
				<th>Mesaj Zamanı</th>
				<th>Gönderilen Mesaj </th>
				<th>Gönderilen Üye</th>
				<th>Okunma Durum</th>
			</tr>
        </thead>
         '; 
	  while($gonderilen_mesajlar = mysql_fetch_array($ilan_gonderilen_mesajlar)){

			 if(mysql_num_rows($ilan_gonderilen_mesajlar) > 0){
             $arac_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$gonderilen_mesajlar['ilan_id']."' LIMIT 1");
             $uye_cek = mysql_query("SELECT * FROM user WHERE id = '".$gonderilen_mesajlar['alan_id']."' LIMIT 1");
			
            
         $output .= '
         <tbody> ';

         while($uye_oku = mysql_fetch_array($uye_cek)){
			 $okunma_durumu="";
             $uye_ad = $uye_oku['ad'];
             $uye_telefon = $uye_oku['telefon'];
			if($gonderilen_mesajlar["durum"]=="0"){
				$okunma_durumu="Okunmadı";
			}else{
				$okunma_durumu="Okundu";
			}
         $output .= '
            <tr id="" style = "'.$style.'">   
                <td>'.$gonderilen_mesajlar['gonderme_zamani'].'</td>         
                <td>'.$gonderilen_mesajlar['mesaj'].'</td>         
				<td>'.$uye_ad.'</td>
				<td>'.$okunma_durumu.'</td>
          
		 </tr>  ';  }  } }
         $output .='
         </tbody>
		 
      </table> ';
	
	$output .='
			<script>
					function cevapla(ilan_id,gonderen_id,mesaj_id){
						jQuery.ajax({
							url: "https://ihale.pertdunyasi.com/check.php",
							type: "POST",
							dataType: "JSON",
							data: {
								action: "panel_admin_mesaj_cevapla",
								ilan_id: ilan_id,
								gonderen_id: gonderen_id,
								mesaj_id: mesaj_id,
								admin_mesaj: $("#admin_cevap"+parseInt(mesaj_id)).val(),
								admin_id :'.$admin_id.',
								eski_mesaj :$("#eski_mesaj"+parseInt(mesaj_id)).html(),
								eski_mesaj_tarih :$("#eski_mesaj_tarih"+parseInt(mesaj_id)).html(),
							},
							success: function(response) {
								console.log(response);
								alert("Mesaj başarıyla gönderildi");
								$("#admin_cevap"+parseInt(mesaj_id)).val("");

							}
						});
					}
					var options = [];
					var clicked = false;
					$(".checkall").on("click", function() {
						$(".checkhour").prop("checked", !clicked);
						clicked = !clicked;
						if(clicked){
							var totalCheckboxes = $(".checkhour").length;
							for(var i=0;i<totalCheckboxes;i++){
								var name = $(".checkhour")[i].value;
								if(jQuery.inArray($(".checkhour")[i].value, options) == -1){
									options.push(name);
								}
								
							}
							this.innerHTML="Seçimleri Kaldır";

						}else{		
							var totalCheckboxes = $(".checkhour").length;
							for(var i=0;i<totalCheckboxes;i++){
								var name = $(".checkhour")[i].value;
								if(jQuery.inArray($(".checkhour")[i].value, options) != -1){
									options.splice(options.indexOf(name), 1);
								}
							}
							this.innerHTML="Tümünü Seç";
						} 
						

					});
					
					$(function() {
					  durum_guncelle();
					});
					
					function durum_guncelle(){
						$("input:checkbox").on("change", function() {
							var name = $(this).attr("value");
							if ($(this).is(":checked")) {
								options.push(name);
							} else {
								options.splice(options.indexOf(name), 1);
							}
							console.log(options)
						});
					}
					function kaydet(){
						jQuery.ajax({
							url: "https://ihale.pertdunyasi.com/check.php",
							type: "POST",
							dataType: "JSON",
							data: {
								action: "panel_admin_mesaj_okundu",
								dizi:options,
							},
							success: function(response) {
								alert("İşlem Başarılı");
								location.reload();
							}
						});
					}
											
			</script>
							';
    echo $output;
}

?>
