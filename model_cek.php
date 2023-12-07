<?php 
	include 'ayar.php';
	$modelin_marka = re('modelin_marka');
	$modelin_marka_cek = mysql_query("select * from model where marka_id = '".$modelin_marka."'");
	$dmodel_array=array();
	$as=0;
	while($modelin_marka_oku = mysql_fetch_array($modelin_marka_cek)){       
		$modell_say=mysql_query("select * from dogrudan_satisli_ilanlar where durum=1 and model='".$modelin_marka_oku["model_adi"]."'");
		
		$modell_sayisi=mysql_num_rows($modell_say);
		$dmodel_array[$as]="";
		if($modell_sayisi>0){
			$dmodel_array[$as]="true";
		}

		if($dmodel_array[$as]=="true"){
			$html .= '
			<div class="filter_check_box modelmarka_'.$modelin_marka.'" style="width:calc(100% / 2);" >
				<input type="checkbox" name="model[]" value="'.$modelin_marka_oku["model_adi"].'" >'.$modelin_marka_oku["model_adi"]." ".$modell_sayisi.'
			</div> ';
		}
		$as++;
		
	}   
	echo $html;
	/* 
		include 'ayar.php';
		$modelin_marka = re('modelin_marka');
		$modelin_marka_cek = mysql_query("select * from model where marka_adi = '".$modelin_marka."'");

		$dmodel_array=array();
		$as=0;
		while($modelin_marka_oku = mysql_fetch_array($modelin_marka_cek)){       
			$modell_say=mysql_query("select * from dogrudan_satisli_ilanlar where durum=1 and model='".$modelin_marka_oku["model_adi"]."'");
			
			$modell_sayisi=mysql_num_rows($modell_say);
			$dmodel_array[$as]="";
			if($modell_sayisi>0){
				$dmodel_array[$as]="true";
			}

			if($dmodel_array[$as]=="true"){
				$html .= '
				<div class="filter_check_box" style="width:calc(100% / 2);" id="model_'.$modelin_marka.'">
					<input type="checkbox" name="model[]" value="'.$modelin_marka_oku["model_adi"].'" >'.$modelin_marka_oku["model_adi"]." ".$modell_sayisi.'
				</div> ';
			}
			$as++;
			
		}   
		echo $html;
	*/

?>



