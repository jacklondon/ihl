<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id)
{
    $output .= '';   
    $ilan_favoriler = mysql_query("SELECT * FROM favoriler WHERE ilan_id ='".$gelen_id."'");
    $output .= '
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Favorilere Zamanı</th>            
            <th>Üye Grubu / Cayma Bedeli</th>
            <th>Ekleyen Üye</th>
            <th>Üye Telefon</th>
            
         </tr>
        </thead>'; 
         while($favoriler = mysql_fetch_array($ilan_favoriler)){
             $arac_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$favoriler['ilan_id']."' LIMIT 1");
             $uye_cek = mysql_query("SELECT * FROM user WHERE id = '".$favoriler['uye_id']."' LIMIT 1");             
            
         $output .= '
         <tbody> ';
         while($uye_oku = mysql_fetch_array($uye_cek)){
             $uyenin_grubu_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$uye_oku['paket']."'");
             $uyenin_grubu = mysql_fetch_assoc($uyenin_grubu_cek);
             $uyenin_grubu_adi = $uyenin_grubu['grup_adi'];
			 
             /*$uyenin_aktif_caymasi = mysql_query("SELECT SUM(net) FROM cayma_bedelleri WHERE uye_id = '".$uye_oku['id']."' AND durum=1");
             $uye_aktif_bedel = mysql_fetch_assoc($uyenin_aktif_caymasi);
             $aktif_bedel = $uye_aktif_bedel['SUM(net)'];
             $uye_borc_cayma = mysql_query("SELECT SUM(net) FROM cayma_bedelleri WHERE uye_id = '".$uye_oku['id']."' AND durum=2"); 
             $uye_borc_bedel = mysql_fetch_assoc($uye_borc_cayma);
             $borc_bedel = $uye_borc_bedel['SUM(net)'];
             $toplam_cayma = $aktif_bedel + $borc_bedel;*/
			 $aktif_cayma_toplam=mysql_query("
				SELECT 
					SUM(tutar) as toplam_aktif_cayma
				FROM
					cayma_bedelleri
				WHERE
					uye_id='".$uye_oku['id']."' AND
					durum=1
			");
			$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
			$iade_talepleri_toplam=mysql_query("
				SELECT 
					SUM(tutar) as toplam_iade_talepleri
				FROM
					cayma_bedelleri
				WHERE
					uye_id='".$uye_oku['id']."' AND
					durum=2
			");
			$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
			$borclar_toplam=mysql_query("
				SELECT 
					SUM(tutar) as toplam_borclar
				FROM
					cayma_bedelleri
				WHERE
					uye_id='".$uye_oku['id']."' AND
					durum=6
			");
			$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
			$toplam_cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
            if($uye_oku["user_token"] == ""){
                $uye_ad = $uye_oku["unvan"];
            }else{
                $uye_ad = $uye_oku['ad'];
            }
             
             $uye_telefon = $uye_oku['telefon'];
         $output .= '
            <tr style = "'.$style.'">   
            
                <td>'.date("d-m-Y H:i:s", strtotime($favoriler['favlama_zamani'])) .'</td>         
               <td>'.$uyenin_grubu_adi.' / '.$toplam_cayma.' ₺</td>
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
