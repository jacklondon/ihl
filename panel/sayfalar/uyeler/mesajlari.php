<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id)
{
    $output .= '';
    $query = mysql_query("SELECT * FROM `user` WHERE id=$gelen_id LIMIT 1");
    $query2 = mysql_query("SELECT * FROM `user` WHERE id=$gelen_id LIMIT 1");
    $mesaj = mysql_query("SELECT * FROM mesajlar WHERE gonderen_id ='".$gelen_id."'");
    while($qyaz = mysql_fetch_array($query2)){
    $output .= '<h3>'.$qyaz["ad"].'</h3>';}
    $output .= '
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Kod / Plaka</th>
            <th>Model Yılı/Marka/Model/Tip/Şehir</th>
            <th>İhale Kapanış</th>
            <th>Mesaj</th>
            <th>Mesaj Gönderme Zamanı</th>
         </tr>
        </thead>'; 
        while($de = mysql_fetch_array($query)){
         while($message = mysql_fetch_array($mesaj)){
            $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$message['ilan_id']."' ORDER BY ihale_tarihi DESC ");
            while($ilan_oku = mysql_fetch_array($ilan_cek)){
               $arac_id = $ilan_oku['id'];
               $marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = '".$ilan_oku['marka']."'");
               $marka_oku = mysql_fetch_assoc($marka_cek);
               $marka = $marka_oku['marka_adi'];
               $ihalenin_tarihi = $ilan_oku['ihale_tarihi']." ".$ilan_oku['ihale_saati'];
               $son_tarih =  date("d-m-Y H:i:s", strtotime($ihalenin_tarihi));
         $output .= '
         <tbody> ';
         if($ilan_oku['ihale_tarihi'] > date('Y-m-d')){

            $style = 'opacity: 1';
            $output .= '
            <tr style = "'.$style.'">
               <td><a href="?modul=ilanlar&sayfa=ilan_ekle&id='.$arac_id.'" target="_blank">'.$ilan_oku["arac_kodu"].' /'.$ilan_oku["plaka"].'</a></td>
               <td><a href="../arac_detay.php?id='.$arac_id.'&q=ihale" target="_blank">'.$ilan_oku["model_yili"].' / '.$marka.' / '.$ilan_oku['model'].' / '.$ilan_oku['tip'].' / '.$ilan_oku['sehir'].'</a></td>
               <td>'.$son_tarih.'</td>
               <td>'.$message["mesaj"].'</td>
               
               <td>'.date("d-m-Y H:i:s", strtotime($message['gonderme_zamani'])).'</td>
            </tr>  '; 
         }
         else
         {
             $style = 'opacity: 0.4';
             $output2 .= '
             <tr style = "'.$style.'">
                <td><a href="?modul=ilanlar&sayfa=ilan_ekle&id='.$arac_id.'" target="_blank">'.$ilan_oku["arac_kodu"].' /'.$ilan_oku["plaka"].'</a></td>
                <td><a href="../arac_detay.php?id='.$arac_id.'&q=ihale" target="_blank">'.$ilan_oku["model_yili"].' / '.$marka.' / '.$ilan_oku['model'].' / '.$ilan_oku['tip'].' / '.$ilan_oku['sehir'].'</a></td>
                <td>'.$son_tarih.'</td>
                <td>'.$message["mesaj"].'</td>
                
                <td>'.date("d-m-Y H:i:s", strtotime($message['gonderme_zamani'])).'</td>
             </tr>  '; 
         }

       
          } } }
          $output.=$output2;
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
