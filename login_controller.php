<?php 
	session_start();
	include 'ayar.php';

	// $uye_token = $_SESSION['u_token'];
	// $kurumsal_token = $_SESSION['k_token'];
?>




<?php

	if(re('giris') == "Giris Yap"){
		$sifre = md5(re('sifre'));
		$telefon = re('gsm');
		$kullanici_kontrol = mysql_query("SELECT * FROM user WHERE telefon='".$telefon."' and sifre='".$sifre."'");
			if(mysql_num_rows($kullanici_kontrol) == 1){    
				$kullanici_oku=mysql_fetch_array($kullanici_kontrol); 

				$bugun = date("Y-m-d");
				$uye_durum_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$kullanici_oku['id']."'");
				$uye_durum_oku = mysql_fetch_assoc($uye_durum_cek);
				$uye_demo_tarihi = $uye_durum_oku['demo_olacagi_tarih'];
				if($uye_demo_tarihi == $bugun){
					$demo_yetki_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = 1");
					$demo_yetki_oku = mysql_fetch_assoc($demo_yetki_cek);
					$ust_limiti = $demo_yetki_oku['teklif_ust_limit'];
					$ust_standart = $demo_yetki_oku['standart_ust_limit'];
					$ust_luks = $demo_yetki_oku['luks_ust_limit'];
					mysql_query("UPDATE user SET paket = 1 WHERE id = '".$kullanici_oku['id']."'");
					mysql_query("UPDATE teklif_limiti SET teklif_limiti = '".$ust_limiti."', standart_limit = '0',
					luks_limit = '0' WHERE uye_id = '".$kullanici_oku['id']."'");
				}
				$kullanici_onay=mysql_query("Select * from onayli_kullanicilar where user_id='".$kullanici_oku["id"]."'");
				$onay_cek=mysql_fetch_assoc($kullanici_onay);
				if($onay_cek["durum"]!=1)
				{
					echo "<script> localStorage.setItem('Onay',0);</script>";
					echo "<script> localStorage.setItem('gsm',".$telefon.");</script>";
					echo "<script>window.location.href = 'index.php';</script>";     
				}
				else
				{         
					echo "<script> localStorage.setItem('Onay',1);</script>";
					$_SESSION['u_token'] = $kullanici_oku["user_token"];
					$_SESSION['k_token'] = $kullanici_oku["kurumsal_user_token"];
					if(!empty($_SESSION['u_token'])){
						$cek = mysql_query("SELECT * FROM user WHERE user_token = '".$_SESSION['u_token']."' LIMIT 1");
						$oku = mysql_fetch_assoc($cek);
						$yetki_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$oku['id']."'");
						$yetki_oku = mysql_fetch_assoc($yetki_cek);
						if($yetki_oku['uyelik_iptal']=="on"){
							if($yetki_oku['uyelik_iptal_nedeni']==""){
								echo '<script type="text/javascript">alert("Üyeliğiniz fesih edilmiştir. Tekrar üyelik almanız mümkün değildir");</script>';
								session_destroy();        
								echo "<script>window.location.href = 'index.php';</script>";
							}else{
								$uyelik_iptal_nedeni = $yetki_oku['uyelik_iptal_nedeni'];
								echo '<script type="text/javascript">alert("'.$uyelik_iptal_nedeni.'");</script>';
								session_destroy();        
								echo "<script>window.location.href = 'index.php';</script>";
							}
						}else{
							if($yetki_oku['kalici_mesaj']=="on"){
								$kalici_sistem_mesaji = $yetki_oku['kalici_sistem_mesaji'];
								if($kalici_sistem_mesaji !=""){
									echo '<script type="text/javascript">alert("'.$kalici_sistem_mesaji.'");</script>';
									session_destroy();        
									echo "<script>window.location.href = 'index.php';</script>";
								}else{
									echo "<script>alert('Değerli üyemiz bazı bilgileriniz eksiktir. Bize ulaşmanız durumunda eksik bilgileri birlikte doldurur isek sisteme giriş yapabileceksiniz.');</script>";
									session_destroy();        
									echo "<script>window.location.href = 'index.php';</script>";
								}
							}else{
								$son_islem_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$_SESSION['u_token']."'");
								$son_islem_oku = mysql_fetch_assoc($son_islem_cek);
								$son_islem_zamani = $son_islem_oku['son_islem_zamani'];
								$u_paket=$son_islem_oku["paket"];
								$now = date("Y-m-d H:i:s");
								$yesterday = date("Y-m-d H:i:s", strtotime('-24 hours',strtotime($now)));
								header('location:uye_panel/success.php');
							}
						}
					}elseif(!empty($_SESSION['k_token'])){
						$k_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$_SESSION['k_token']."' LIMIT 1");
						$k_oku = mysql_fetch_assoc($k_cek);
						$k_yetki_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$k_oku['id']."'");
						$k_yetki_oku = mysql_fetch_assoc($k_yetki_cek);



						if($k_yetki_oku['uyelik_iptal']=="on"){
							if($k_yetki_oku['uyelik_iptal_nedeni']==""){
								echo '<script type="text/javascript">alert("Üyeliğiniz fesih edilmiştir. Tekrar üyelik almanız mümkün değildir");</script>';
								session_destroy();        
								echo "<script>window.location.href = 'index.php';</script>";
							}else{
								$k_uyelik_iptal_nedeni = $k_yetki_oku['uyelik_iptal_nedeni'];
								echo '<script type="text/javascript">alert("'.$k_uyelik_iptal_nedeni.'");</script>';
								session_destroy();        
								echo "<script>window.location.href = 'index.php';</script>";
							}
						}else{
							if($k_yetki_oku['kalici_mesaj']=="on"){
								$k_kalici_mesaj = $k_yetki_oku['kalici_sistem_mesaji'];
								if($k_kalici_mesaj !=""){
									echo '<script type="text/javascript">alert("'.$k_kalici_mesaj.'");</script>';
									session_destroy();        
									echo "<script>window.location.href = 'index.php';</script>";
								}else{
									echo "<script>alert('Değerli üyemiz bazı bilgileriniz eksiktir. Bize ulaşmanız durumunda eksik bilgileri birlikte doldurur isek sisteme giriş yapabileceksiniz.');</script>";
									session_destroy();        
									echo "<script>window.location.href = 'index.php';</script>";
								}
							}else{
								header('location:kurumsal_panel/success.php');
							}
						}
					}
				}
			}else{
				echo '<script>alert("Telefon numaranız veya şifreniz hatalı lütfen tekrar deneyin!")</script>';
				echo '<script>
					window.location.href = "index.php";
				</script>';
      
			}
		}
		if(re("action")=="onay_kodu")
		{
			$gsm=re("gsm");
			$kullanici_cek=mysql_query("select * from user where telefon='".$gsm."'");
			$kullanici_oku=mysql_fetch_assoc($kullanici_cek);
			$kullanici_id=$kullanici_oku["id"];
			
			$gsm_onaykodu=re("gsm_onaykodu");
			$sql=mysql_query("select * from onayli_kullanicilar where user_id='".$kullanici_id."'");
			$fetch=mysql_fetch_assoc($sql);
			if($fetch["kod"]==$gsm_onaykodu){
				$_SESSION['u_token'] = $kullanici_oku["user_token"];
				$_SESSION['k_token'] = $kullanici_oku["kurumsal_user_token"];
				if($_SESSION['u_token']!=""){
					$yonlendirme="uye_panel/success.php";
				}else{
					$yonlendirme="kurumsal_panel/success.php";
				}
				$update=mysql_query("Update onayli_kullanicilar set durum='1' where user_id='".$kullanici_id."' and kod='".$gsm_onaykodu."'");
				if($update)
				{
					echo "<script> localStorage.setItem('Onay',1);</script>";
					echo "<script> localStorage.setItem('gsm','');</script>";

					echo '<script>alert("GSM No Onaylandı")</script>';
					echo '<script>window.location.href = "'.$yonlendirme.'";</script>';
				} else {
					echo '<script>alert("Onay Kodunuz Yanlış")</script>';
					echo '<script>window.location.href = "index.php";</script>';
				}
			}else{
				echo '<script>alert("Onay Kodunuz Yanlış")</script>';
				echo '<script>window.location.href = "index.php";</script>';
			}
			
			

		}
?>
