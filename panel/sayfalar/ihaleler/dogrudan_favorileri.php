<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id)
{
    $output .= '';   
    $ilan_favoriler = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id ='".$gelen_id."'");
    $output .= '
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Favorilere Zamanı</th>            
            <th>Ekleyen Üye</th>
            <th>Üye Telefon</th>
            
         </tr>
        </thead>'; 
         while($favoriler = mysql_fetch_array($ilan_favoriler)){
             $arac_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE id = '".$favoriler['ilan_id']."' LIMIT 1");
             $uye_cek = mysql_query("SELECT * FROM user WHERE id = '".$favoriler['uye_id']."' LIMIT 1");
            
         $output .= '
         <tbody> ';
         while($uye_oku = mysql_fetch_array($uye_cek)){
             $uye_ad = $uye_oku['ad'];
             $uye_telefon = $uye_oku['telefon'];
         $output .= '
            <tr>   
           
                <td>'.date("d-m-Y H:i:s", strtotime($favoriler['favlama_zamani'])).'</td>         
               <td>'.$uye_ad.'</td>
               <td>'.$uye_telefon.'</td>
               
            </tr>  ';  }} 
         $output .='
         </tbody>
      </table>
         '; 
    $output .= '
         </table>
    ';
    echo $output;
}

?>
