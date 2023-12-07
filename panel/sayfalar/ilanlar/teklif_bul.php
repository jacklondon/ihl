<?php 
include('../../../ayar.php');
if (re('teklif')){
    $teklif = re('teklif');  
    $teklif_cek = mysql_query("SELECT * FROM teklifler WHERE id = $teklif");
   
	$teklif_oku = mysql_fetch_assoc($teklif_cek);
	$son_teklif = $teklif_oku['teklif'];
	$ilan_id = $teklif_oku['ilan_id'];
	
	$ilan_cek=mysql_query("select * from ilanlar where id='".$ilan_id."'");
	$ilan_oku=mysql_fetch_object($ilan_cek);
	
	if($ilan_oku->pd_hizmet==0 || $ilan_oku->pd_hizmet == "" ){
		$hizmet_bedeli = $teklif_oku['hizmet_bedeli'];
	
	}else{
		$hizmet_bedeli = $ilan_oku->pd_hizmet;
	}

	$response=["hizmet_bedeli"=>$hizmet_bedeli,"teklif"=>$son_teklif];
	
    echo json_encode($response)	;
}
?>
