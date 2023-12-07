<form name="form" id="form" method="POST" enctype="multipart/form-data">
    <div class="row-fluid" style="margin-top: 3%;">
        <a href="?modul=ayarlar&sayfa=komisyon_oranlari" type="submit" class="btn" style="background-color: rgb(88,103,221); color:white; text-decoration:none;">Komisyon Oranları</a>
    </div>
    <?php include('islemler/ayarlar/komisyon_oranlari_ekle.php'); ?>
    <div class="row-fluid">
        <div class="span8">
            <label for="Miktar">Miktar(e kadar)*</label>
            <input type="text" name="miktar" id="miktar" class="span12" required>
            <label for="Net">Net*</label>
            <input type="text" name="net" id="net" class="span12" required>
            <label for="OnBinde">10.000(On binde)*</label>
            <input type="text" name="onbinde" class="span12" required>
            <label for="LuxNet">Lüx Net*</label>
            <input type="text" name="lux_net" id="lux_net" class="span12" required>
            <label for="Lux10000">Lüx 10.000(On binde)*</label>
            <input type="text" name="lux_onbinde" class="span12" required>
            <input type="submit" class="btn" name="komisyon_oranini" value="Kaydet" style="background-color: rgb(88,103,221); color:white;">
        </div>
    </div>
</form>