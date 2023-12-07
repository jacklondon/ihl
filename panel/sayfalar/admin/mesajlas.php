<?  

$ip=re("ip");

$select=mysql_query("Select * from canli_destek_mesaj where ip='".$ip."'");


while($veri_cek=mysql_fetch_assoc($select))
{
    $sayac_chat++;
     $chat.='
       
        <label for="IDofInput">Mesaj</label>
        <input type="text" class="span12" name="soru" class="span12" value="'.$veri_cek["gelen_mesaj"].'">
   
   ';
}


if(re("action")=="canli_destek_cevap")
{
    $ip=re("ip");

    $select=mysql_query("Select * from canli_destek_mesaj where ip='".$ip."' order by id desc limit 1");
    $son_cek=mysql_fetch_assoc($select);

    $update=mysql_query("Update canli_destek_mesaj set giden_mesaj='".re('cevap')."' where id='".$son_cek["id"]."'");
    
}

?>

<form method="POST" id="form" name="form">
    <input type="hidden" name="action" value="canli_destek_cevap">
    <input type="hidden" name="ip" value="<?= $ip ?>">
   <div class="row-fluid" style="margin-top: 2%;">
   <div class="span12">
    <?= $chat ?> 
    </div>        
    </div>
    <div class="row-fluid" style="margin-top: 2%;">
    <div class="span12">
        <label for="IDofInput">Cevap</label>
        <input type="text" class="span12" name="cevap" class="span12" value="">
     </div>
    </div> 
    <div class="row-fluid" style="margin-top: 2%;">
    <div class="span12">
        <button type="submit" class="btn btn-block" class="span12" value="">Cevap Ver</button>
     </div>
    </div> 
</form>