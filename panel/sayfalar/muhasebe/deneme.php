<?php 
session_start();
$admin_id = $_SESSION['kid'];
$uye_cek = mysql_query("SELECT * FROM user WHERE temsilci_id = '".$admin_id."'");
$sira = 1;
$year = date('Y');

// ÜYELERİMİN ALDIKLARI ESKİSİ
?>
<style>
   .dikey{
   writing-mode: tb-rl;
   transform: rotate(-180deg);
   }
   .sari{
   background-color: rgb(255,255,0);
   }
   .laci{
   background-color: rgb(51,51,153);
   color: #ffffff;
   }
   .acik_mavi{
   background-color: rgb(219,229,241);
   }
</style>
<h3>Üyelerimin Aldıkları</h3>
<div style="overflow-x:auto; overflow-y:auto;">
   <table class="table table-bordered">
      <tr>
         <td colspan="17"></td>
      </tr>
      <form method="POST">
         <td>Şu Tarihler Arası</td>
         <td><input type="date" name="tarih1" id="tarih1" class="input-mini"></td>
         <td>ile</td>
         <td><input type="date" name="tarih2" id="tarih2" class="input-mini"></td>
         <td>arası</td>
         <td><input type="submit" name="tarihleri" class="input-mini btn blue" value="Filtrele"></td>
         <td></td>
         <td>Ay/Yıl Seç</td>
         <td><select name="ay" id="ay" class="input-mini"> 
             <option value="01">Ocak</option>
             <option value="02">Şubat</option>
             <option value="03">Mart</option>
             <option value="04">Nisan</option>
             <option value="05">Mayıs</option>
             <option value="06">Haziran</option>
             <option value="07">Temmuz</option>
             <option value="08">Ağustos</option>
             <option value="09">Eylül</option>
             <option value="10">Ekim</option>
             <option value="11">Kasım</option>
             <option value="12">Aralık</option>
         </select></td>
         <td><select name="yil" id="yil" class="input-mini"> 
            <?php for($i=2010; $i <=$year; $i++){ ?>
             <option value="<?= $i ?>"><?= $i ?></option>
             <?php } ?>
         </select></td>
         
         <td><input type="submit" name="secili_tarihi" class="input-mini btn blue" value="Filtrele"></td>
         <td></td>
         </form>
      <tr>
         <td colspan="17"></td>
      </tr> 
       <tr>
         <td colspan="17"></td>
      </tr>
   </table>
   <table class="table table-bordered ex1">
      <tr class="sari" style="overflow:hidden;overflow-y: scroll;">
         <td>
            <p class="dikey">Sıra</p>
         </td>
         <td>KOD</td>
         <td>ÖDEME TARİHİ</td>
         <td>PARAYI GÖNDEREN</td>
         <td>ARAÇ PLAKASI</td>
         <td>MARKA MODEL</td>
         <td>SİGORTA</td>
         <td>ARACI ALAN ÜYE</td>
         <td>SATIŞ KİMİN ADINA YAPILDI</td>
         <td>SATIŞ TARİHİ</td>
         <td>Maliyeti</td>
         <td>SATILAN FİYAT</td>
         <td>Pd Hizmet Bedeli</td>
         <td>EXTRA KAZANÇ</td>
         <td>AÇIKLAYICI NOTLAR</td>
         <td>TOPLAM KAR / ZARAR</td>
      </tr>
      <?php 
   
   while($uye_oku = mysql_fetch_array($uye_cek)){
   $prim_cek = mysql_query("SELECT * FROM uye_notlari WHERE uye_id = '".$uye_oku['id']."' AND ekleyen = '".$admin_id."' LIMIT 1");
   $prim_oku = mysql_fetch_assoc($prim_cek);
   $uye_id = $prim_oku['uye_id'];

   if(re('tarihleri')=="Filtrele"){
      $satilan_cek = mysql_query("SELECT * FROM satilan_araclar WHERE uye_id = '".$uye_id."' AND tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' ");
      
     while($satilan_oku = mysql_fetch_array($satilan_cek)){ ?>
         <tr>
            <td class="laci"><?= $sira++ ?></td>
            <td><?= $satilan_oku['kod'] ?></td>
            <td><?= $satilan_oku['odeme_tarihi'] ?></td>
            <td><?= $satilan_oku['parayi_gonderen'] ?></td>
            <td><?= $satilan_oku['plaka'] ?></td>
            <td><?= $satilan_oku['marka_model'] ?></td>
            <td><?= $satilan_oku['sigorta'] ?></td>
            <td><?= $satilan_oku['araci_alan'] ?></td>
            <td><?= $satilan_oku['satis_adi'] ?></td>
            <td><?= $satilan_oku['tarih'] ?></td>
            <td><?= $satilan_oku['maliyet'] ?> ₺</td>
            <td><?= $satilan_oku['satilan_fiyat'] ?> ₺</td>
            <td><?= $satilan_oku['pd_hizmet'] ?> ₺</td>
            <td><?= $satilan_oku['ektra_kazanc'] ?> ₺</td>
            <td><?= $satilan_oku['aciklayici_not'] ?> </td>
            <td style="color:<?php if($satilan_oku['ciro'] > 0){echo '#03601b'; }elseif($satilan_oku['ciro'] < 0){ echo 'red'; } ?>"><?= $satilan_oku['ciro'] ?> ₺</td>
         </tr>
    <?php  } 

   }
   elseif(re('secili_tarihi')=="Filtrele"){
      $gelen_ay = re('ay');
      $gelen_yil = re('yil');
      $satilan_cek = mysql_query("SELECT * FROM satilan_araclar WHERE uye_id = '".$uye_id."' AND MONTH(tarih) = '$gelen_ay' AND YEAR(tarih)= '$gelen_yil' ");
      
      while($satilan_oku = mysql_fetch_array($satilan_cek)){ ?>
         <tr>
            <td class="laci"><?= $sira++ ?></td>
            <td><?= $satilan_oku['kod'] ?></td>
            <td><?= $satilan_oku['odeme_tarihi'] ?></td>
            <td><?= $satilan_oku['parayi_gonderen'] ?></td>
            <td><?= $satilan_oku['plaka'] ?></td>
            <td><?= $satilan_oku['marka_model'] ?></td>
            <td><?= $satilan_oku['sigorta'] ?></td>
            <td><?= $satilan_oku['araci_alan'] ?></td>
            <td><?= $satilan_oku['satis_adi'] ?></td>
            <td><?= $satilan_oku['tarih'] ?></td>
            <td><?= $satilan_oku['maliyet'] ?> ₺</td>
            <td><?= $satilan_oku['satilan_fiyat'] ?> ₺</td>
            <td><?= $satilan_oku['pd_hizmet'] ?> ₺</td>
            <td><?= $satilan_oku['ektra_kazanc'] ?> ₺</td>
            <td><?= $satilan_oku['aciklayici_not'] ?> </td>
            <td style="color:<?php if($satilan_oku['ciro'] > 0){echo '#03601b'; }elseif($satilan_oku['ciro'] < 0){ echo 'red'; } ?>"><?= $satilan_oku['ciro'] ?> ₺</td>
         </tr>
    <?php  } 
   }
   else{
      $satilan_cek = mysql_query("SELECT * FROM satilan_araclar WHERE uye_id = '".$uye_id."' ORDER BY tarih DESC");
      
      while($satilan_oku = mysql_fetch_array($satilan_cek)){ ?>
         <tr>
            <td class="laci"><?= $sira++ ?></td>
            <td><?= $satilan_oku['kod'] ?></td>
            <td><?= $satilan_oku['odeme_tarihi'] ?></td>
            <td><?= $satilan_oku['parayi_gonderen'] ?></td>
            <td><?= $satilan_oku['plaka'] ?></td>
            <td><?= $satilan_oku['marka_model'] ?></td>
            <td><?= $satilan_oku['sigorta'] ?></td>
            <td><?= $satilan_oku['araci_alan'] ?></td>
            <td><?= $satilan_oku['satis_adi'] ?></td>
            <td><?= $satilan_oku['tarih'] ?></td>
            <td><?= $satilan_oku['maliyet'] ?> ₺</td>
            <td><?= $satilan_oku['satilan_fiyat'] ?> ₺</td>
            <td><?= $satilan_oku['pd_hizmet'] ?> ₺</td>
            <td><?= $satilan_oku['ektra_kazanc'] ?> ₺</td>
            <td><?= $satilan_oku['aciklayici_not'] ?> </td>
            <td style="color:<?php if($satilan_oku['ciro'] > 0){echo '#03601b'; }elseif($satilan_oku['ciro'] < 0){ echo 'red'; } ?>"><?= $satilan_oku['ciro'] ?> ₺</td>
         </tr>
    <?php      } 
   }

   
   ?>
   
  <?php } ?>
     
   </table>
</div>