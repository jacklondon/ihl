<style>
	.radio_k_class{float:left; margin-right:10px;}
</style>
<?php
	$sql=mysql_query("
		SELECT
			*
		FROM
			statu_smsleri
		WHERE 
			status=1
	");

	

 ?>
<form method="POST"  id="form" name="form" >
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Statu SMS</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
					<?php while($fetch=mysql_fetch_array($sql)){ ?>
						<div class="control-group">
							<label class="control-label"><?=$fetch["statu_adi"] ?></label>
							<div class="controls"> 
								<textarea style="width:60%;height:50px;" name="sms_icerigi<?=$fetch["id"] ?>" > <?=$fetch["sms_icerigi"] ?> </textarea>	
								<button style="border: none;background: none;" type="submit" name="statu_guncelle" value="statu_guncelle<?=$fetch["id"] ?>" ><i style="font-size: 30px; margin-left: 30px;" class="fas fa-save"></i></button>
							</div>
						</div>				   			
					<?php } ?>
					<!-- <div class="form-actions">
						<input type="submit" name="pdf_guncelle" class="btn blue" value="Güncelle" />
					</div>-->
				</div>
				<!-- END FORM-->           
			 </div>
		  </div>
		  <!-- END SAMPLE FORM PORTLET-->
	   </div>
	</div>
		
</form>

<?php 
	if(re("statu_guncelle")=="statu_guncelle1"){
		$update=mysql_query("
			UPDATE
				statu_smsleri
			SET
				sms_icerigi='".re("sms_icerigi1")."'
			WHERE 
				id=1
		");
		if($update){
			header("Location: sistem.php?modul=ayarlar&sayfa=statu_sms");
		}	
	}
?>
<?php 
	if(re("statu_guncelle")=="statu_guncelle2"){
		$update=mysql_query("
			UPDATE
				statu_smsleri
			SET
				sms_icerigi='".re("sms_icerigi2")."'
			WHERE 
				id=2
		");
		if($update){
			header("Location: sistem.php?modul=ayarlar&sayfa=statu_sms");
		}	
	}
?>

<?php 
	if(re("statu_guncelle")=="statu_guncelle3"){
		$update=mysql_query("
			UPDATE
				statu_smsleri
			SET
				sms_icerigi='".re("sms_icerigi3")."'
			WHERE 
				id=3
		");
		if($update){
			header("Location: sistem.php?modul=ayarlar&sayfa=statu_sms");
		}	
	}
?>

<?php 
	if(re("statu_guncelle")=="statu_guncelle4"){
		$update=mysql_query("
			UPDATE
				statu_smsleri
			SET
				sms_icerigi='".re("sms_icerigi4")."'
			WHERE 
				id=4
		");
		if($update){
			header("Location: sistem.php?modul=ayarlar&sayfa=statu_sms");
		}	
	}
?>
<?php 
	if(re("statu_guncelle")=="statu_guncelle5"){
		$update=mysql_query("
			UPDATE
				statu_smsleri
			SET
				sms_icerigi='".re("sms_icerigi5")."'
			WHERE 
				id=5
		");
		if($update){
			header("Location: sistem.php?modul=ayarlar&sayfa=statu_sms");
		}	
	}
?>





