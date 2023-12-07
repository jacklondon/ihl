<?php 
include('../../../ayar.php');
// include "not_gonder.php";
$gelen_id = re('id');
if($gelen_id)
{
	
    $output = '';
	
	$aktif_admin=mysql_query("select * from kullanicilar where id='".$_SESSION["kid"]."'");
	$aktif_admin_oku=mysql_fetch_object($aktif_admin);
	$aktif_admin_id=$aktif_admin_oku->id;
	$aktif_admin_yetkiler=$aktif_admin_oku->yetki;
	$parcala=explode("|",$aktif_admin_yetkiler);
	
	if(count($parcala)==13){
		$sınırsız_yetki=true;
	}else{
		$sınırsız_yetki=false;
	}
	
	
    $query = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` WHERE id=$gelen_id LIMIT 1");
    $query2 = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` WHERE id=$gelen_id LIMIT 1");
    $evraklar = mysql_query("SELECT * FROM dogrudan_satis_notlari WHERE dogrudan_id ='".$gelen_id."' group by tarih order by id desc");
    while($qyaz = mysql_fetch_array($query2)){
    $output .= '<h3>'.$qyaz["ad"].'</h3>';}
	$output .= '<h6>'.mysql_num_rows($evraklar).' adet not bulundu</h6>';
	 $output .= '
		<form method="POST" action="" enctype="multipart/form-data">
            <div class="row-fluid>
				<label for="IDofInput">Notunuz</label>
				<textarea class="span12" name="eklenecek_not" id="eklenecek_not" rows="4"></textarea>
				<input type="hidden" value="'.$gelen_id.'" name="gelen_id" id="gelen_id">
            </div>
            <div class="row-fluid">
				<input type="file" name="files[]" multiple id="dogrudan_not_files" >
            </div>
            <div class="row-fluid">
				<div class="span2">
					<input type="button" onclick="dogrudan_not_ekle('.$gelen_id.')" class="btn blue" name="notu" value="Kaydet" >
				</div>
				<div class="span2"><label>Gizlilik</label></div>
				<div class="span8">
					<select id="gizlilik" name="gizlilik">
						<option value="0">Sadece Ben </option>             
						<option value="1">Tam Yetkili Adminler Görebilir </option> 
						<option value="2" selected>Herkes Görebilir </option> 
					</select>
				</div>
            </div>
		</form>
            ';
    $output .= '
        <table class="table table-bordered">
        <thead>
            <tr>
				<th>Ekleme Tarihi</th>
				<th>Ekleyen</th>
				<th>Gizlilik</th>
				<th>Not</th>
				<th>Ek</th>
			</tr>
        </thead>'; 
        while($de = mysql_fetch_array($query)){
         while($evrak = mysql_fetch_array($evraklar)){
			$yukleme_tarihi=$evrak['tarih'];
            $admin_cek = mysql_query("select * from kullanicilar where id = '".$evrak['ekleyen']."'");
            $admin_oku = mysql_fetch_assoc($admin_cek);
            $admin_adi = $admin_oku['adi'];
            $td="";
            $td.="<td>";
            $gorme_durum="";
            $evrak_yaz="";
            if($evrak["dosya"]==1)
            {
			   if($evrak["gizlilik"]==2){
				    $evrak_yaz.=$evrak['ilan_notu'];
					$td.='<p style="color:black" >Dosya Yok</p>';
				}else if($evrak["gizlilik"]==1 && $sınırsız_yetki==true ){
					$evrak_yaz.=$evrak['ilan_notu'];
					$td.='<p style="color:black" >Dosya Yok</p>';
				}else if($evrak["gizlilik"]==0 ){
					if($evrak['ekleyen']==$aktif_admin_id){
						$evrak_yaz.=$evrak['uye_notu'];
						$td.='<p style="color:black" >Dosya Yok</p>';
					}else{
						$evrak_yaz.="Sadece Ekleyen Admin Görebilir";
						$td.="Sadece Ekleyen Admin Görebilir";
					}
				}else{
					$evrak_yaz.="Yetkiniz Yetersiz";
				    $td.="Yetkiniz Yetersiz";
				}
            }
            else {
			   if($evrak["gizlilik"]==2){
				   
				    $evrak_yaz.=$evrak['ilan_notu'];
					$evrak_grup=mysql_query("select * from dogrudan_satis_notlari where tarih='".$yukleme_tarihi."' and dogrudan_id='".$gelen_id."'");
					while($evrak_grup_oku=mysql_fetch_array($evrak_grup)){
						$td.='<a href="../assets/'.$evrak_grup_oku['dosya'].'" target="_blank">-'.$evrak_grup_oku['dosya'].'</a><br/>';
					}
				}else if($evrak["gizlilik"]==1 && $sınırsız_yetki==true ){
					$evrak_yaz.=$evrak['ilan_notu'];
					$evrak_grup=mysql_query("select * from dogrudan_satis_notlari where tarih='".$yukleme_tarihi."' and dogrudan_id='".$gelen_id."'");
					while($evrak_grup_oku=mysql_fetch_array($evrak_grup)){
						$td.='<a href="../assets/'.$evrak_grup_oku['dosya'].'" target="_blank">-'.$evrak_grup_oku['dosya'].'</a><br/>';
					}
				}else if($evrak["gizlilik"]==0 ){
					if($evrak['ekleyen']==$aktif_admin_id){
						$evrak_yaz.=$evrak['ilan_notu'];
						$evrak_grup=mysql_query("select * from dogrudan_satis_notlari where tarih='".$yukleme_tarihi."' and dogrudan_id='".$gelen_id."'");
						while($evrak_grup_oku=mysql_fetch_array($evrak_grup)){
							$td.='<a href="../assets/'.$evrak_grup_oku['dosya'].'" target="_blank">-'.$evrak_grup_oku['dosya'].'</a><br/>';
						}
					}else{
						$evrak_yaz.="Sadece Ekleyen Admin Görebilir";
						$td.="Sadece Ekleyen Admin Görebilir";
					}
					
				}else{
					$evrak_yaz.="Yetkiniz Yetersiz";
				    $td.="Yetkiniz Yetersiz";
				}
            }

            if($evrak["gizlilik"]==0)
            {
                $gorme_durum="Sadece Ben";
            }
            else if($evrak["gizlilik"]==1)
            {
               $gorme_durum=" Tam Yetkili Adminler";
            }
            else if($evrak["gizlilik"]==2)
            {
               $gorme_durum="Herkes Görebilir";
            }
			$td.='</td>';
         $output .= '
         <tbody> ';
         $output .= '
            <tr>
               <td>'.date("d-m-Y H:i:s", strtotime($evrak['tarih'])) .'</td>
               <td>'.$admin_adi.'</td>
               <td>'.$gorme_durum.'</td>
               <td>'.$evrak_yaz.'</td>
               '.$td.'
            </tr>  '; 
         } } 
            
         $output .='
         
         </tbody>
      </table>
         '; 
    $output .= '
         </table>
    ';
	$output.="
		<script>
		function dogrudan_not_ekle(id){
			var formData = new FormData(document.getElementById('form'));
			var gizlilik = $('#gizlilik').val();
			var eklenecek_not = $('#eklenecek_not').val();
			formData.append('action', 'dogrudan_notu_kaydet');
			formData.append('gelen_id', id);
			formData.append('gizlilik', gizlilik);
			formData.append('eklenecek_not', eklenecek_not);
			var filesLength=document.getElementById('dogrudan_not_files').files.length;
			for(var i=0;i<filesLength;i++){
				formData.append('file[]', document.getElementById('dogrudan_not_files').files[i]);
			}
			$.ajax({
				url: 'https://ihale.pertdunyasi.com/action.php',
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if(response.status==200){
						console.log(response.toplam_not);
						openToastrSuccess(response.message);
						$('#dogrudan_notlari_close').trigger('click');
						var text='<a id=\''+id+'\' class=\'view_dogru_notlari\'><i class=\'fas fa-align-justify\'>'+response.toplam_not+'</i></a>';
						$('#td_view_dogru_notlari_'+id).html(text);
					}else{
						openToastrDanger(response.message);
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
		</script>
	";
   
    echo $output;

}
?>


<script>
// Not Ekleme
   function notuKaydet(){     
     var eklenecek_not = $('#eklenecek_not').val();
     var file = $('#files').val();
     var gelen_id = $('#gelen_id').val();
     var gizlilik = $('#gizlilik').val();
     var $baseUrl = "https://ihale.pertdunyasi.com/panel/sayfalar/uyeler/";

     if(gelen_id)
     {  
          jQuery.ajax({
               url: $baseUrl+'not_gonder.php',
               type: "POST",
               dataType: "JSON",
               data: {
                  eklenecek_not: eklenecek_not,
                  file: file,
                  gelen_id: gelen_id,
                  gizlilik: gizlilik,
               },
               success: function(data) {
				   console.log(data);
                  $('.success').removeClass('d-none').html(data);                  
                  //location.reload();
               },
               error: function(data) {
                  $('.error').removeClass('d-none').html(data);
                  alert('HATA! Lütfen tekrar deneyiniz.')
               }
            });
     }
} 

</script>  

