<? 
function SMSgonderHttpGET(){

  $url= "https://api.netgsm.com.tr/sms/send/get/?usercode=//8503030800&password=1397ea1479&gsmno=05462081009,05312978587,05392909068,05536520390&message=EaBilisimTestMesajıdır&msgheader=EA%20Bilisim";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $http_response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  if($http_code != 200){
    echo "$http_code $http_response\n";
    return false;
  }
  $balanceInfo = $http_response;
 //echo "MesajID : $balanceInfo";
  return $balanceInfo;
}

SMSgonderHttpGET();
?>