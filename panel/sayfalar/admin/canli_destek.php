<?

if(re("action")=="canli_destek")
{
    $date_time=date("Y-m-d H:i:s");
	if(re('soru')==""){
		$msg='<div class="alert alert-danger" role="alert">
			Soru alanı boş olamaz 
		  </div>';
	}else if(re('cevap')==""){
		$msg='<div class="alert alert-danger" role="alert">
			Cevap alanı boş olamaz 
		  </div>';
	}else{
		$yukle =mysql_query("INSERT INTO `canli_destek` (`soru`, `cevap`, `e_tarihi`, `durum`) VALUES 
		('".re('soru')."', '".re('cevap')."', '".$date_time."', '1');");

		if($yukle)
		{
			$msg='<div class="alert alert-primary" role="alert">
		   Başarıyla Yüklendi.
		  </div>';
		}
		else {
			$msg='<div class="alert alert-danger" role="alert">
			Hata Oluştu.Tekrar Deneyiniz.
		  </div>';
		}
	}
    

}

$select=mysql_query("Select * from canli_destek ");
while($sorulari_cek=mysql_fetch_array($select))
{$sayac_mesaj++;
   $td.='
            <tr>
            <td>'.$sayac_mesaj.'</td>
            <td>'.$sorulari_cek["soru"].'</td>
            <td>'.$sorulari_cek["cevap"].'</td>
            <td><a href="?modul=admin&sayfa=cevap_yaz&id='.$sorulari_cek["id"].'" class="btn">Cevap Yaz/Düzenle </a></td>
            </tr>
   ';
}

if(re("action")=="bot_durum")
{
   $bot_durum=re("bot_durum");

   $update=mysql_query("Update chat_bot set chat_bot_durum='".$bot_durum."' where id='1'");
}

$bot_durum_cek=mysql_query("Select * from chat_bot where id='1'");
$durum_cek=mysql_fetch_assoc($bot_durum_cek);

$checked="";
if($durum_cek["chat_bot_durum"]==1)
{
   $checked='checked';
}


$chat_gelen_mesaj=mysql_query("Select * from canli_destek_mesaj where durum='1' and sender_id='0' group by ip");
while($mesajlar=mysql_fetch_array($chat_gelen_mesaj))
{
   $sayac_chat++;
   $chat.='
            <tr>
            <td>'.$sayac_chat.'</td>
            <td>'.$mesajlar["gelen_mesaj"].'</td>         
            <td>'.$mesajlar["giden_mesaj"].'</td>         
            <td><a href="?modul=admin&sayfa=mesajlas&ip='.$mesajlar["ip"].'" class="btn">Konuşmaya Başla</a></td>
            </tr>
   ';
}

?>


<p style="color:black;font-size:15px">
<? echo($msg);?></p>
<form method="POST" id="form" name="form">
    <input type="hidden" name="action" value="canli_destek">
   <div class="row-fluid" style="margin-top: 2%;">
   <div class="span6">
      <label for="IDofInput">Soru</label>
      <input type="text" class="span12" name="soru" class="span12" value="">
   </div>
   <div class="span6">
      <label for="IDofInput">Cevap</label>
      <input type="text" class="span12" name="cevap" class="span12" value="">
   </div>
   <div class="row-fluid">
       <div class="span12">
      <div class="form-actions">
         <input type="submit" name="silmseyi" class="btn blue btn-block" value="Kaydet" />
      </div>
    </div>
   </div>
</form>
<label class="checkbox-inline">
   
  <input type="checkbox" id="bot" <?= $checked ?>  data-toggle="toggle" onchange="aktif_pasif()"> Bot Aktif
</label>
<h4 style="text-align:center"><b>Siz Aktif Değilken Bot'un Cevap Verecebileceği Sorular </b></h4>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Sorular</th>
                <th>Cevaplar</th>
                <th>Cevap Yaz/Düzenle</th>
            </tr>
             </thead>
            <tbody>
           <?= $td ?>
        </tbody>
    </table>
</div>

<h4 style="text-align:center"><b>Aktifken Gelen Mesajlar </b></h4>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Mesaj İçeriği</th>
                <th>Son Cevap</th>
                <th>Konuşmaya Başla</th>
            </tr>
             </thead>
            <tbody>
           <?= $chat ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>

   function aktif_pasif()
   {
      var $durum="";

      if($('#bot').is(':checked')==true)
      {  
         $durum=1;
      }
      else
      {
         $durum=0;
      }
      jQuery.ajax({
         url: "https://ihale.pertdunyasi.com/panel/sistem.php?modul=admin&sayfa=canli_destek",
         type: "POST",
         dataType: "JSON",
         data: {
            action: "bot_durum", 
            bot_durum:$durum
         },
         success: function(response) { 
          

         },
      }); 

   }

   </script>