<?php 
	$admin_id=$_SESSION['kid'];
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
   
	$yetkiler=$admin_yetki_oku["yetki"];
   
	$yetki_parcala=explode("|",$yetkiler);

	if (count($yetki_parcala) !=13  ) { 
		echo '<script>alert("Bu Sayfaya Giriş Yetkiniz Yoktur")</script>';
		echo "<script>window.location.href = 'index.php'</script>";
	}

$admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE durum <> 0");
?>
<style>
  i{
    color:#000000;
  }
  tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
<style>
    a.disabled {
  pointer-events: none;
  cursor: default;
}
  </style> 
<div style="margin-top:3%">
<input type="search" name="ara" id="ara" placeholder="Ara" >
<a href="sistem.php?modul=admin&sayfa=admin_ekle" type="submit" class="btn blue">Yeni Ekle</a>
</div>
<table width="100%"  cellspacing="1" cellpadding="1" style="margin-top: 3%; text-align:center;">
  <tbody>
    <tr>
      <td><u>Ad Soyad</u></th>

      <td><u>Düzenle</u></th>
		     
      <td><u>Yetkiler</u></th>
	   <td><u>Şifremi Unuttum</u></th>
      <td><u>Sil</u></th>
    </tr>
    <?php while($admin_oku = mysql_fetch_array($admin_cek)){ 
      $admin_id = $admin_oku["id"];
      if($admin_id == 1 || $admin_id == 14){
        $sil_btn= "";
      }else{
        $sil_btn='<a href="?modul=ayarlar&sayfa=data_sil&id='.$admin_id.'&q=admin_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" class="<?= $class ?>"><i class="fas fa-trash"></i></a>';
      }
    ?>      
    <tr>
		<td><?= $admin_oku["kullanici_adi"]; ?></td>
		<td><a href="?modul=admin&sayfa=admin_ekle&id=<?=$admin_id?>" class="<?= $class ?>"><i class="fas fa-pencil-alt"></i></a></td>
		<td><a href="?modul=admin&sayfa=admin_ekle&id=<?=$admin_id?>" class="<?= $class ?>"><i class="fas fa-align-justify"></i></a></td>
		<td><a href="?modul=admin&sayfa=admin_sifre_sifirla&id=<?=$admin_id?>&q=sifre_sms" class="<?= $class ?>"><i class="fas fa-plus"></i></a></td>
		<td><?= $sil_btn ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>


