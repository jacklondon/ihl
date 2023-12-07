<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}
</style>

<div class="alert" >
<i class="fas fa-exclamation-triangle"></i> <strong>* İşaretli alanları eksiksiz doldurun</strong>
</div>
<div class="row-fluid">
    <div class="span3">
    <a href="?modul=ayarlar&sayfa=markalar">  <button type="button" style="background-color: rgb(88,103,221); color:white;" class="btn span12">Markalara Dön</button></a>
    </div>
</div>
<?php 
$gelen_id=re("id");
$gelen_marka = mysql_query("SELECT * FROM marka WHERE markaID = $gelen_id");
?>
<?php if($gelen_id){ ?>
<form method="POST" name="form" id="form">
<?php include('islemler/ayarlar/marka_ekle.php'); ?>
<div class="row-fluid" style="margin-top:2%;">
    <div class="span6">
    <?php while($remarka = mysql_fetch_array($gelen_marka)){ ?>
        <label for="IDofInput">Marka Adı*</label>
        <input type="text" value="<?= $remarka['marka_adi'] ?>" class="span12" name="marka_adi">        
        <input type="submit" name="markayi" value="Kaydet" style="background-color: rgb(88,103,221); color:white;" class="btn span3">
        <?php } ?>
    </div>
</div>
</form>
<?php }else{ ?>
<form method="POST" name="form" id="form">
<?php include('islemler/ayarlar/marka_ekle.php'); ?>
<div class="row-fluid" style="margin-top:2%;">
    <div class="span6">
        <label for="IDofInput">Marka Adı*</label>
        <input type="text" class="span12" name="marka_adi">        
        <input type="submit" name="markayi" value="Kaydet" style="background-color: rgb(88,103,221); color:white;" class="btn span3">
    </div>
</div>
</form>
<?php } ?>
<div class="row-fluid" style="margin-top:2%;">
    <div class="alert" >
        <i class="fas fa-exclamation-triangle"></i> <strong> Model isimlerini baş harfi büyük diğerleri küçük 
            olacak şekilde ekleyebilirsiniz.
        </strong>
    </div>
    
    <div class="row-fluid">
        <div class="span3">
            <form class="navbar-search pull-left">
                <input type="text" class="search-query span9" placeholder="Ara.." name="search">
            </form>
        </div>
        <div class="span6"></div>
        <div class="span3">
            <a href="?modul=ayarlar&sayfa=model_ekle"><button type="submit" class="span btn" style="background-color: rgb(88,103,221); color:white;">Model Ekle</button></a>
        </div>
    </div>
    <?php 
        $model_getir = mysql_query("SELECT * FROM model,marka WHERE model.marka_id = marka.markaID order by marka.marka_adi asc");
        $sayac = 1;
    ?>

    
    <table width="100%" border="0" cellspacing="4" class="table" cellpadding="2" style="margin-top:3%;">
        <tbody>
            <tr>
                <td>#</td>
                <td>Model Adı</td>
                <td>Marka Adı</td>
                <td>Düzenle</td>
                <td>Sil</td>
            </tr>
            <?php 
                while($model_yaz = mysql_fetch_array($model_getir)){
                $model_id = $model_yaz['modelID'];
                
            ?>
            <tr>                
                <td><?= $sayac++ ?></td>
                <td><?= $model_yaz['model_adi'] ?></td>
                <td><?= $model_yaz['marka_adi'] ?></td>
                <td><a href="?modul=ayarlar&sayfa=model_duzenle&id=<?= $model_id ?>" style="text-decoration:none; color:black;" name="komisyon_duzenle"><i class="fas fa-align-justify"></i></a></td>
                <td><a href="?modul=ayarlar&sayfa=data_sil&id=<?= $model_id ?>&q=model_sil" onclick="return confirm('Silmek istediğinize emin misiniz ?')"><i style="color:black;" class="fas fa-trash"></i></a></td>      
            </tr>
            <?php  } ?>
        </tbody>
    </table>
</div>
