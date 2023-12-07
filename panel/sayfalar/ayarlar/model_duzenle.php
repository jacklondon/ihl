<?php 
session_start();
$gelen_id=re("id");
$modeli_cek = mysql_query("SELECT * FROM model WHERE modelID = $gelen_id"); 
?>

<?php 
if(!empty($gelen_id)){ 
?>
<form method="POST" name="form" id="form">
<?php include 'islemler/ayarlar/model_guncelle.php'; ?>
<div class="row-fluid" style="margin-top: 2%;">
<div class="span6">
    <label for="model">Model Adı</label>
    <?php while($modeli_oku = mysql_fetch_array($modeli_cek)){ ?>
    <input type="text" name="model_adi" value="<?= $modeli_oku['model_adi'] ?>" class="span12" required>
      <?php } ?>
    </div>
    <div class="span6">
    <?php $secili_marka_cek = mysql_query("SELECT * FROM marka,model WHERE model.marka_id = marka.markaID AND model.modelID = $gelen_id"); ?>
    <label for="marka">Marka</label>
    <select name="marka" id="marka" class="span12" required>        
        <?php while($secili_marka_oku = mysql_fetch_array($secili_marka_cek)){ ?>
        <option value="<?= $secili_marka_oku['markaID'] ?>"><?= $secili_marka_oku['marka_adi'] ?></option>
        <?php } ?>
        <?php $marka_getir = mysql_query("SELECT * FROM marka");
            while($marka_yaz = mysql_fetch_array($marka_getir)){
        ?>
        <option value="<?= $marka_yaz['markaID'] ?>"><?= $marka_yaz['marka_adi'] ?></option>
        <?php } ?>
    </select>
    </div>
</div>
<div class="row-fluid">
    <input type="submit" class="btn-primary span4" name="modeli" value="Kaydet">   
</div>
</form>

<?php } ?>