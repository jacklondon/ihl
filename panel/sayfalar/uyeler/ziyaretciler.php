<?php 
$tarih=date("Y-m-d H:i:s",strtotime("-5 minutes"));
$tarih2=date("Y-m-d H:i:s");
$ziyaretci_cek = mysql_query("SELECT * FROM ziyaretciler where tarih between '".$tarih."' and '".$tarih2."'");
$sira = 1;

?>

<h2 style="text-align: center;background-color:orange; color:#0a47ff; font-weight:750;">Ziyaretçiler</h2>
   <table class="table table-bordered table-striped" style="margin-top:3%;">
      <thead>
         <tr>
            <th>Sıra</th>
            <th>IP Adresi</th>
            <th>Tarih</th>
         </tr>
      </thead>
      <tbody>
      <?php while($ziyaretci_oku = mysql_fetch_array($ziyaretci_cek)){ 
		if($ziyaretci_oku["son_islem_isletim_sistemi"]=="iPhone" || $ziyaretci_oku["son_islem_isletim_sistemi"]=="iPod"  || $ziyaretci_oku["son_islem_isletim_sistemi"]=="iPad" || $ziyaretci_oku["son_islem_isletim_sistemi"]=="Mac OS X" || $ziyaretci_oku["son_islem_isletim_sistemi"]=="Mac OS 9"){
			$icon='/ <i class="fab fa-apple"></i>';
		}else if($ziyaretci_oku["son_islem_isletim_sistemi"]=="Android"){
			$icon='/ <i class="fab fa-android"></i>';
		}else {
			$icon='';
		}
	  ?>
         <tr>
            <td><?= $sira++ ?></td>
            <td><?= $ziyaretci_oku['ip'] ?></td>
            <td><?= date("d-m-y H:i:s",strtotime($ziyaretci_oku['tarih'])).$icon ?></td>
         </tr>
         <?php } ?>
      </tbody>
   </table>

