<?php 
// $evrak_cek = mysql_query("SELECT * FROM yuklenen_evraklar group by gonderme_zamani ORDER BY id DESC");
$evrak_cek = mysql_query("SELECT * FROM yuklenen_evraklar ORDER BY id DESC");
$sira = 1;
?>
<table class="table table-bordered table-striped" style="margin-top: 3%;">
    <thead>
        <tr>
            <th scope="col">Sıra</th>
            <th scope="col">Üye Adı</th>
            <th scope="col">Evrak Adı</th>
            <th scope="col">Not</th>
            <th scope="col">Yükleme Zamanı</th>
            <!-- <th scope="col">Tümünü İndir</th> -->
        </tr>
    </thead>
    <tbody>
        <?php 
		while($evrak_oku = mysql_fetch_array($evrak_cek)){
			$td="";
			$yukleme_zamani=$evrak_oku["gonderme_zamani"];
			$user_id=$evrak_oku["user_id"];
			$not=$evrak_oku["not"];
			$evrak_grup=mysql_query("select * from yuklenen_evrak_dosya where evrak_id='".$evrak_oku["id"]."'");
			while($evrak_grup_oku=mysql_fetch_array($evrak_grup)){
				$td.='<a download href="../assets/'.$evrak_grup_oku['icerik'].'">-'.$evrak_grup_oku['icerik'].'</a><br/>';
			}
            $userID = $evrak_oku['user_id'];
            $uye_cek = mysql_query("SELECT * FROM user WHERE id = '".$userID."' LIMIT 1");
            $uye_oku = mysql_fetch_assoc($uye_cek);
            if($uye_oku["user_token"] != ""){
                $ad = $uye_oku['ad'];
            }else{
                $ad = $uye_oku['unvan'];
            }
            $tumunu_indir = '<a href="?modul=uyeler&sayfa=tumunu_indir&id='.$evrak_oku["id"].'" class="btn blue">Tümünü İndir</a>';
        
        ?>
        <tr>
            <td><?= $sira++ ?></td>
            <td><?= $ad ?></td>
            <td>
                <?= $td ?>
                <?= $tumunu_indir ?>
            </td>
            <td><?= $not ?></td>
            <td><?= date("d-m-Y H:i:s",strtotime($evrak_oku['gonderme_zamani'])) ?></td>
            <!-- <td><a class="btn blue" href="?modul=uyeler&sayfa=tumunu_indir&id=<?= $evrak_oku["user_id"] ?>">Tümünü İndir</a></td> -->
           
        </tr>
        <?php } ?>
    </tbody>

</table>