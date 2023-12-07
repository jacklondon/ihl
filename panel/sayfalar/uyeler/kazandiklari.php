<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id)
{
    $output .= '';
    $query = mysql_query("SELECT * FROM `user` WHERE id=$gelen_id LIMIT 1");
    $query2 = mysql_query("SELECT * FROM `user` WHERE id=$gelen_id LIMIT 1");
    $kazan = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE uye_id ='".$gelen_id."'");
    while($qyaz = mysql_fetch_array($query2)){
    $output .= '<h3>'.$qyaz["ad"].'</h3>';}
    $output .= '
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Kod / Plaka</th>
            <th>Model Yılı/Marka/Model/Tip/Şehir</th>
            <th>Kazandığı Tutar</th>
            <th>Hizmet Bedeli</th>
            <th>İhale Kapanış</th>
            <th>Statü ve Açıklaması</th>
         </tr>
        </thead>'; 
         while($win = mysql_fetch_array($kazan)){
            $kazanilan_id = $win['id'];
            $arac_id = $win['ilan_id'];
            $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$win['ilan_id']."' LIMIT 1");
            
            if($win['durum'] == 0){
               $statu = "Onay Bekleniyor";
            }elseif($win['durum'] == 1){
               $statu = "Ödeme Bekliyor";
            }elseif($win['durum'] == 2){
               $statu = "Son İşlemde";
            }elseif($win['durum'] == 3){
               $statu = "Satın Alındı";
            }elseif($win['durum'] == 4){
               $statu = "İptal Oldu";
            }
			$aciklama="/".$win['aciklama'];
            while($ilan_oku = mysql_fetch_array($ilan_cek)){
               $marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = '".$ilan_oku['marka']."'");
               $marka_oku = mysql_fetch_assoc($marka_cek);
               $marka = $marka_oku['marka_adi'];
               $kod = $ilan_oku['arac_kodu'];
               $ihalenin_tarihi = $ilan_oku['ihale_tarihi']." ".$ilan_oku['ihale_saati'];
               $son_tarih =  date("d-m-Y H:i:s", strtotime($ihalenin_tarihi));
               $sigortasi = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$ilan_oku['sigorta']."'");
               $yaz_sigorta = mysql_fetch_assoc($sigortasi);
               $bedeli = $win['pd_hizmet'];
         $output .= '
        <tbody> ';
		if($win['durum'] == 4){	
			$style = 'opacity: 0.4';
		}else{ 
			$style = 'opacity: 1';
		}
         $output .= '
            <tr style = "'.$style.'">
               <td><a href="?modul=ilanlar&sayfa=ilan_ekle&id='.$arac_id.'" target="_blank">'.$kod.' /'.$ilan_oku["plaka"].'</a></td>
               <td><a href="../arac_detay.php?id='.$arac_id.'&q=ihale" target="_blank">'.$ilan_oku["model_yili"].' / '.$marka.' / '.$ilan_oku['model'].' / '.$ilan_oku['tip'].' / '.$ilan_oku['sehir'].'</a></td>
               <td>'.money($win["kazanilan_teklif"]).'₺ </td>
               <td>'.money($bedeli).'₺ </td>
               <td>'.$son_tarih.'</td>
               <td>'.$statu.$aciklama.'</td>
               
            </tr>  ';  } } 
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
