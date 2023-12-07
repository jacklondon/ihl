<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id)
{
    $output .= '';
    $query = mysql_query("SELECT * FROM `user` WHERE id=$gelen_id LIMIT 1");
    $query2 = mysql_query("SELECT * FROM `user` WHERE id=$gelen_id LIMIT 1");
    $teklif = mysql_query("SELECT * FROM teklifler WHERE uye_id ='".$gelen_id."' and durum=1 order by teklif_zamani desc");
    $uye_teklif_sayi = mysql_num_rows($teklif);
    $qyaz = mysql_fetch_assoc($query2);

    $output .= '<h3>'.$qyaz["ad"].' --- Teklif Sayısı = '.$uye_teklif_sayi.' </h3>';
    $output .= '
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Kod / Plaka</th>
            <th>Model Yılı/Marka/Model/Tip/Şehir</th>
            <th>Teklifi</th>
            <th>Hizmet Bedeli</th>
            <th>İhale Kapanış</th>
            <th>Teklif Zamanı</th>
         </tr>
        </thead>'; 
        while($de = mysql_fetch_array($query)){
         while($offer = mysql_fetch_array($teklif)){
            
            $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$offer['ilan_id']."' ");
            while($ilan_oku = mysql_fetch_array($ilan_cek)){
               $arac_id = $ilan_oku['id'];
               $marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = '".$ilan_oku['marka']."'");
               $marka_oku = mysql_fetch_assoc($marka_cek);
               $marka = $marka_oku['marka_adi'];
               $komisyon_cek = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id = '".$arac_id."'");
               $komisyon_oku = mysql_fetch_assoc($komisyon_cek);
               $komisyon = $komisyon_oku['toplam'];
			   if($ilan_oku['pd_hizmet']=="" || $ilan_oku['pd_hizmet']=0){
					$hizmet_bedeli=$offer["hizmet_bedeli"];
				}else{
					$hizmet_bedeli=$ilan_oku['pd_hizmet'];
				}
               $kod = $ilan_oku['arac_kodu'];
               $ihalenin_tarihi = $ilan_oku['ihale_tarihi']." ".$ilan_oku['ihale_saati'];
               $son_tarih =  date("d-m-Y H:i:s", strtotime($ihalenin_tarihi));
         $output .= '
         <tbody> ';
         if($ilan_oku['ihale_tarihi'] > date('Y-m-d'))
         {

            $style = 'opacity: 1';
            $output .= '
            <tr style = "'.$style.'">
               <td><a href="?modul=ilanlar&sayfa=ilan_ekle&id='.$arac_id.'" target="_blank">'.$kod.' /'.$ilan_oku["plaka"].'</a></td>
               <td><a href="../arac_detay.php?id='.$arac_id.'&q=ihale" target="_blank">'.$ilan_oku["model_yili"].' / '.$marka.' / '.$ilan_oku['model'].' / '.$ilan_oku['tip'].' / '.$ilan_oku['sehir'].'</a></td>
               <td style="font-size:18px;font-weight:bold;" >'.money($offer["teklif"]).'</td>
               <td >'.money($hizmet_bedeli).' ₺</td>
               <td>'.$son_tarih.'</td>
               <td>'.date("d-m-Y H:i:s", strtotime($offer['teklif_zamani'])).'</td>
            </tr>  '; 
         }
         else
         {
            $style = 'opacity: 0.4';
            $output2 .= '
            <tr style = "'.$style.'">
               <td><a href="?modul=ilanlar&sayfa=ilan_ekle&id='.$arac_id.'" target="_blank">'.$kod.' /'.$ilan_oku["plaka"].'</a></td>
               <td><a href="../arac_detay.php?id='.$arac_id.'&q=ihale" target="_blank">'.$ilan_oku["model_yili"].' / '.$marka.' / '.$ilan_oku['model'].' / '.$ilan_oku['tip'].' / '.$ilan_oku['sehir'].'</a></td>
               <td style="font-size:18px;font-weight:bold;" >'.money($offer["teklif"]).'</td>
               <td >'.money($hizmet_bedeli).' ₺</td>
               <td>'.$son_tarih.'</td>
               <td>'.date("d-m-Y H:i:s", strtotime($offer['teklif_zamani'])).'</td>
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
