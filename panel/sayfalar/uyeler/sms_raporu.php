<?
$gelen_id = re('q');
$select=mysql_query("Select * from sms_kaydet where id = '".$gelen_id."'");
while($sms_durum_cek=mysql_fetch_array($select))
{

 
    $sms_kategori=mysql_query("Select * from sms_kategorileri where id='".$sms_durum_cek["sms_kategori_id"]."'");
    $kategori=mysql_fetch_assoc($sms_kategori);

    $sayacim++;
   
    $temiz_no=str_replace(' ', '', $sms_durum_cek["bulkid"]);   
    $gelen_deger=SMSHttpGET(trim($temiz_no));

    $yeni_array=array();
   
    
    

    $array  = array_map('intval', str_split($sms_durum_cek["numara"]));
    $k=0;
    for($i=0;$i<12;$i++)
    { 
        
        if($i==1)
        {           
            array_push($yeni_array,"(");         
        }
        if($i==4)
        {          
            array_push($yeni_array,")");            
        }
        if($i==7)
        {           
            array_push($yeni_array,"-");            
        }
        else {
            array_push($yeni_array,$array[$k]);
            $k++;
        }
    }


    $dene= (implode(" ",$yeni_array));
    $dene_2=str_replace(' ', '', $dene);   
    $select2=mysql_query("Select * from user where telefon='".$dene_2."' ");
    
     

    
   $kisi_cek=mysql_fetch_assoc($select2);
   $mesaj_kodu=mesaj_kodlari($gelen_deger[1]);
   $operatorum=operator_sms($gelen_deger[2]);
   $mesaj_sayisi=($gelen_deger[3]);
   $gonderildigi_tarih=($gelen_deger[4]);
   $gonderildigi_saat=($gelen_deger[5]);
   $hata_kodu=(hata_kodlari($gelen_deger[6]));

   

   $tr.='
<tr>
        <td>'.$sayacim.' </td>
        <td> '.ucfirst($kisi_cek["ad"]).'</td>
        <td> '.$mesaj_kodu.'</td>
        <td> '.$operatorum.'</td>
        <td> '.$gonderildigi_tarih.'</td>
        <td> '.$gonderildigi_saat.'</td>
        <td> '.$kategori["kategori_adi"].'</td>
        <td> '.$hata_kodu.'</td>
       
<tr>
   ';

}


?>
<h3 style="text-align:center"> Gönderilen Mesaj Durumları </h3>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
                <th>#</th>
                <th>Kullanıcı</th>
                <th>Mesaj Durumu</th>
                <th>Gönderilen Operatör</th>
                <th>Gönderildiği Tarih</th>
                <th>Gönderildiği Saat</th>
                <th>Sms Kategori</th>
                <th>Durum</th>
        </thead>
        <tbody>
            <tr>
           <?= $tr ?>
</tr>
        </tbody>
    </table>
</div>

