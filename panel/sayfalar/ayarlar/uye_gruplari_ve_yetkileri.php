<?php 
session_start();
$hepsini_cek = mysql_query("SELECT * FROM uye_grubu");

?>
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: center;
  padding: 8px;
}
i{
    color:black;
    padding: 8px;
}
</style>
<div class="well">
    <i class="fas fa-question-circle"> Bu ekrandan üye gruplarını görüntüleyebilirsiniz.</i>
    <div class="row-fluid" style="margin-top: 2%;">
        <div class="span6">
            <form class="navbar-search pull-left">
                <input type="text" class="search-query" name="arama" placeholder="Grup Ara">
            </form>
        </div>
        
<!--   <div class="span3">
            <button type="submit" class="btn" style="background-color: rgb(88,103,221); ">
                <a href="?modul=ayarlar&sayfa=teklif_sinirlamalari" style="color:white; text-decoration:none; cursor:pointer;"> Teklif Sınırlamaları</a>
            </button>
        </div> -->
        <div class="span3">
            <button type="submit" class="btn" style="background-color: rgb(88,103,221); ">
                <a href="?modul=ayarlar&sayfa=uye_grubu_ekle" style="color:white; text-decoration:none; cursor:pointer;"> Üye Grubu Ekle</a>
            </button>
        </div>
    </div>
    <div class="row-fluid">
        <table class="table" cellspacing="4" cellpadding="2" style="margin-top:3%;">
            <tbody>
                <tr>
                    <td>#</td>
                    <td>Üye Grupları</td>
                    <td>Teklif Sınırlamaları</td>
                    <td>Sil</td>
                </tr>
                <?php 
                    $sayac=1;
                    while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
                    $uye_grubu_id = $hepsini_oku["id"];
					if($uye_grubu_id != 22 && $uye_grubu_id != 1 && $uye_grubu_id != 2 && $uye_grubu_id != 21){
						$td_sil=' <a name="sil" href="?modul=ayarlar&sayfa=data_sil&id='.$uye_grubu_id.'&q=uye_grubu_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" style=" "><i style="color:black;" class="fas fa-trash"></i></a> ';
					}else{
						$td_sil='';
					}
                ?>
                <tr>
                    <td><?=$sayac++;?></td>
                    <td><?=$hepsini_oku["grup_adi"];?></td>
                    <td><a href="?modul=ayarlar&sayfa=teklif_sinirlamalari&id=<?= $uye_grubu_id ?>"><i class="fas fa-bars"></i></a></td>
                    <td><?=$td_sil ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>