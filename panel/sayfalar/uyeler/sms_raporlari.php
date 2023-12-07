<?

$select=mysql_query("Select * from sms_kaydet order by id desc");
while($sms_durum_cek=mysql_fetch_array($select))
{


    
    $sms_kategori=mysql_query("Select * from sms_kategorileri where id='".$sms_durum_cek["sms_kategori_id"]."'");
    $kategori=mysql_fetch_assoc($sms_kategori);

    $sayacim++;
   
    $temiz_no=str_replace(' ', '', $sms_durum_cek["bulkid"]);   
    // if($sms_durum_cek["id"] == 332){
        // $gelen_deger=SMSHttpGET(trim($temiz_no));
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
        // $mesaj_kodu=mesaj_kodlari($gelen_deger[1]);
        // $operatorum=operator_sms($gelen_deger[2]);
        // $mesaj_sayisi=($gelen_deger[3]);
        // $gonderildigi_tarih=($gelen_deger[4]);
        // $gonderildigi_saat=($gelen_deger[5]);
        // $hata_kodu=(hata_kodlari($gelen_deger[6]));
    $tr.='<tr>
            <td>'.$sayacim.' </td>
            <td> '.ucfirst($kisi_cek["ad"]).'</td>
            <td> '.$sms_durum_cek["numara"].'</td>
            <td style="max-width: 450px;"> '.str_replace('%20', ' ', $sms_durum_cek["sms_icerigi"]).'</td>
            <td> '.$kategori["kategori_adi"].'</td>
            <td><a href="?modul=uyeler&sayfa=sms_raporu&q='.$sms_durum_cek["id"].'" class="btn green"> Sms Raporu</a></td>
        <tr>';
    // }
}


?>
<h3 style="text-align:center"> Gönderilen Mesaj Durumları </h3>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Gönderilen Kullanıcı</th>
                <th>Gönderildiği Numara</th>
                <th>Gönderildiği Mesaj</th>
                <th>Sms Kategori</th>
                <th>Sms Raporu</th>
            </tr>
        </thead>
        <tbody>
            <tr>
           <?= $tr ?>
</tr>
        </tbody>
    </table>
</div>

