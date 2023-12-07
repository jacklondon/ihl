<?php 
$uyeleri_cek = mysql_query("SELECT * FROM user");
$now = date('Y-m-d H:i:s');
$tarih = date("Y-m-d H:i:s", strtotime('-7 days',strtotime($now)));
$basvuru_cek = mysql_query("SELECT * FROM gold_uyelik_talepleri WHERE basvuru_tarihi > '".$tarih."' ORDER BY id DESC");
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/uyeler_modal.js"></script>
<style>
   a{
      cursor: pointer;
   }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="form-control" style="margin-top: 2%;">
   <div class="row-fluid">
      <div class="span6">
         <form class="navbar-search pull-left">
            <input type="text" class="search-query" placeholder="Ara">
         </form>
      </div>
      <div class="span6">
         
      </div>
   </div>
</div>
<form method="POST" name="form" id="form">
   <table width="100%" class="table table-bordered" style="margin-top: 2%;">
      <thead>
         <tr>
            <th>Üye Adı</th>
            <th>Telefon</th>
            <th>Başvurduğu Tür</th>
            <th>Başvuru Tarihi</th>
            <th>Durum</th>
            <th>Menü</th>
         </tr>
      </thead>
      <tbody>
      <?php while($basvuru_oku = mysql_fetch_array($basvuru_cek)){ 
         $grup_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$basvuru_oku['tur']."'");
         $grup_oku = mysql_fetch_assoc($grup_cek);
         $grup_adi = $grup_oku['grup_adi'];
         $gelen_id = $basvuru_oku["id"];
         $uye_id = $basvuru_oku['uye_id'];
         $uye_cek = mysql_query("select * from user where id = '".$basvuru_oku["uye_id"]."'");
         $uye_oku = mysql_fetch_object($uye_cek);
         if($uye_oku->user_token == ""){
            $uye_adi = $uye_oku->unvan;
         }else{
            $uye_adi = $uye_oku->ad;
         }
         if($basvuru_oku['durum'] == "0"){
             $durum = "Onay Bekliyor";
         }elseif($basvuru_oku['durum'] == 1){
            $durum = "Onaylandı";
         }elseif($basvuru_oku['durum'] == 2){
            $durum = "Reddedildi";
         }
         ?>
         <tr>
            <td><?= $uye_adi ?></td>
            <td><a href="?modul=uyeler&sayfa=sms_gonder&id=<?=$basvuru_oku["id"]?>" target="_blank"> <?= $basvuru_oku["telefon"] ?> </a></td>            
            <td><?= $grup_adi ?></td>           
            <td><?= date("d-m-Y H:i:s", strtotime($basvuru_oku["basvuru_tarihi"])) ?></td>  
            <td><?= $durum ?></td>            
            <td class="dropdown">
               <a class="dropwn-toggle" data-toggle="dropdown"><i class="fas fa-align-justify fa-2x"></i></a>
               <ul class="dropdown-menu"style="position: absolute; transform: translate3d(90px, 10px, 0px); top: -65px; left: -240px; will-change: transform;">
                  <li><a href="?modul=uyeler&sayfa=basvuru_islemleri&id=<?= $gelen_id ?>&q=onayla&uye=<?= $uye_id ?>">Onayla</a></li>
                  <!-- <li><a href="?modul=uyeler&sayfa=basvuru_islemleri&id=<?= $gelen_id ?>&q=reddet&uye=<?= $uye_id ?>">Reddet</a></li> -->
                  <li><a href="?modul=uyeler&sayfa=basvuru_islemleri&id=<?= $gelen_id ?>&q=sil&uye=<?= $uye_id ?>">Başvuruyu Sil</a></li>
               </ul>
            </td>
         </tr>
         <?php } ?>
      </tbody>
   </table>
    </form>


