<?php 
	$admin_id = $_SESSION['kid'];
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
	$yetkiler=$admin_yetki_oku["yetki"];
	$yetki_parcala=explode("|",$yetkiler);
	
	$silinecek = $_POST['secim'];
	if($_POST['secili_sil']){
		if (in_array(2, $yetki_parcala)) { 
			foreach ($silinecek as $sil) {
				mysql_query("DELETE FROM dogrudan_satisli_ilanlar WHERE id = '".$sil."'");
				
			}
			header('Location: ?modul=ihaleler&sayfa=dogrudan_satis');
		}else{
			echo "<script>alert('İlan silme yetkiniz yok.')<script>";
			echo '<script>window.location.href = "?modul=ihaleler&sayfa=tum_ihaleler";</script>';
		}
		/*foreach ($silinecek as $sil) {
			mysql_query("DELETE FROM dogrudan_satisli_ilanlar WHERE id = '".$sil."'");
		}
		header('Location: ?modul=ihaleler&sayfa=dogrudan_satis');*/
	}
?>