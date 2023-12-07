<?php 
include 'ayar.php';
    $modelin_marka = re('modelin_marka');
    $modelin_marka_cek = mysql_query("select * from model where marka_id = '".$modelin_marka."'");
	$html ="";
	$model_array=array();
	$a=0;
    while($modelin_marka_oku = mysql_fetch_array($modelin_marka_cek)){ 
		$model_say=mysql_query("select * from ilanlar where durum=1 and model='".$modelin_marka_oku["model_adi"]."'");
		$model_sayisi=mysql_num_rows($model_say);
		$model_array[$a]="";
		if($model_sayisi > 0){
			$model_array[$a]="true";
		}

		if($model_array[$a]=="true"){
			$html .=
			'<div class="filter_check_box modelmarka_'.$modelin_marka_oku["marka_id"].'" style="width:calc(100% / 2);" >
				<input type="checkbox" name="model[]" id="model_'.$modelin_marka_oku["model_adi"].'" value="'.$modelin_marka_oku["model_adi"].'" >'.$modelin_marka_oku["model_adi"]." ".$model_sayisi.'
			</div> ';
		}
		$a++;
		       
    }
    echo $html;
	
	
?>


<?php 
/*
include 'ayar.php';
    $modelin_marka = re('modelin_marka');
    $modelin_marka_cek = mysql_query("select * from model where marka_id = '".$modelin_marka."'");
	$html ="";
    while($modelin_marka_oku = mysql_fetch_array($modelin_marka_cek)){ 
		$model_say=mysql_query("select * from ilanlar where durum=1 and model='".$modelin_marka_oku["model_adi"]."'");
		$model_sayisi=mysql_num_rows($model_say);
	
			
			//var_dump("select * from ilanlar where durum=1 and model='".$modelin_marka_oku["model_adi"]."'");
			 $html .=
			'<div class="filter_check_box modelmarka_'.$modelin_marka_oku["marka_id"].'" style="width:calc(100% / 2);" >
				<input type="checkbox" name="model[]" value="'.$modelin_marka_oku["model_adi"].'" >'.$modelin_marka_oku["model_adi"]." ".$model_sayisi.'
			</div> ';
		
       
    }
    echo $html;
	
	
*/

/* 

--YEDEKKK

                         <div class="filter_outer">
                              <div class="filter_title_outer">
                                 Modele Göre
                              </div>
								<div class="filter_check_outer" id="modeller">                                       
										   
									<?php 
										$tu = 0;
										$tu2 = 0;
										$seciliModelSayisi = count($_POST['model']);
										$model_array=array();
										if($seciliModelSayisi==0){ ?>
											
										<?php }else{ 
											while($tu2<$seciliModelSayisi){
											$model_cek=mysql_query("select * from model where marka_id=(select marka_id from model where model_adi='".$_POST["model"][$tu2]."')");
											$model_say=mysql_query("select * from ilanlar where model='".$_POST["model"][$tu2]."' and durum=1");
											$model_sayisi=mysql_num_rows($model_sayisi);
											while($model_oku=mysql_fetch_array($model_cek)){
												$model_array[$tu]="";
												for($i=0;$i<count($_POST["model"]);$i++){
													if($model_oku["model_adi"]==$_POST["model"][$i]){
														$model_array[$tu]="checked";
													}
												}
												
												
												if($model_array[$tu] == "checked"){ ?>
												<div class="filter_check_box modelmarka_<?=$model_oku["marka_id"]?>" style="width:calc(100% / 2);" >
													<input type="checkbox" checked id="model_<?=$_POST['model'][$tu2] ?>" name="model[]" value="<?=$_POST['model'][$tu2] ?>" /><?= $_POST['model'][$tu2]." ".$model_sayisi ?>	
												</div>
											<?php }else{ ?>
												<div class="filter_check_box modelmarka_<?=$model_oku["marka_id"]?>" style="width:calc(100% / 2);" >
													<input type="checkbox" id="model_<?=$model_oku["model_adi"] ?>" name="model[]" value="<?= strtolower($model_oku["model_adi"]) ?>" /><?= $model_oku["model_adi"]." ".$model_sayisi  ?>	
												</div>
											<?php } $tu++;  }  ?>

							
										<?php $tu2++; }
										}
										 ?>
								</div>

								<!--<div class="filter_check_outer" id="modeller">                                       
                                          
									
								</div>-->

                        </div> 
*/


?>

