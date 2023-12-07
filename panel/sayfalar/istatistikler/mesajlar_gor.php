<form method="POST">
	<?php 
		
		if(re('mesaj') == "")
		{
			alert("Mesaj Bulunamadı..");
			echo '<meta http-equiv="refresh" content="0;URL=?modul=istatistikler&sayfa=mesajlar&sira='.re('sira').'">';
		}
		else
		{
			$mesaj_cek = mysql_query("select * from mesajlar where id='".re('mesaj')."' and durum!='0' ");
			$mesaj_oku = mysql_fetch_assoc($mesaj_cek);
			
			if($mesaj_oku['id'] == "")
			{
				alert("Mesaj Bulunamadı..");
				echo '<meta http-equiv="refresh" content="0;URL=?modul=istatistikler&sayfa=mesajlar&sira='.re('sira').'">';
			}
			else
			{
				if($mesaj_oku['o_tarihi'] == "")
				{
					mysql_query("update mesajlar set o_tarihi='".mktime()."' where id='".re('mesaj')."' ");
				}
				mysql_query("update mesajlar set s_o_tarihi='".mktime()."' where id='".re('mesaj')."' ");
				
				$adi_soyadi = $mesaj_oku['adi_soyadi'];
				$tel = $mesaj_oku['tel'];
				$email = $mesaj_oku['email'];
				
				if($mesaj_oku['kullanici_id'] != 0)
				{
					$kullaniciyi_cek = mysql_query("select * from kullanicilar where id='".$mesaj_oku['kullanici_id']."' ");
					$kullaniciyi_oku = mysql_fetch_assoc($kullaniciyi_cek);
					
					if($kullaniciyi_oku['id'] != "")
					{
						$adi_soyadi = '<a href="?modul=kullanicilar&sayfa=yeni_kullanici_ekle&sira=1&kullanici='.$kullaniciyi_oku['id'].'">'.$kullaniciyi_oku['adi'].' '.$kullaniciyi_oku['soyadi'].'</a>';
						$tel = $kullaniciyi_oku['tel'];
						$email = $kullaniciyi_oku['email'];
					}
				}
			}
		}
		
		if(re('mesaji') == "Gönder")
		{
			mysql_query("insert into mesajlar (ip,kullanici_id,konu,mesaj,e_tarihi,durum,giden_gelen) values ('".$_SERVER['REMOTE_ADDR']."','".$kullaniciyi_oku['id']."','".re('yeni_konu')."','".re('yeni_mesaj')."','".mktime()."','1','1') ");
			alert("Mesaj Başarıyla Gönderilmiştir..");
			echo '<meta http-equiv="refresh" content="0;URL=?modul=istatistikler&sayfa=mesajlar_gor&sira='.re('sira').'&mesaj='.re('mesaj').'">';
		}
	?>
	<div class="span6">
		<h3><?php echo $mesaj_oku['konu']; ?></h3>
		<blockquote>
			<?php echo $mesaj_oku['mesaj']; ?>
		</blockquote>
		
		<?php 
			if($kullaniciyi_oku['id'] != "")
			{
		?>
		<div class="span6">
			<div class="a_mesaj_dis">
				<div style="font-weight:bold; margin-bottom:4px;">
					Cevapla
				</div>
				<div class="a_mesaj_ic_1">
					<div class="a_mesaj_ic_1_1">
						Konu
					</div>
					<div class="a_mesaj_ic_1_2">
						<input type="text" name="yeni_konu" id="yeni_konu" style="width:400px;" value="RE: <?php echo $mesaj_oku['konu']; ?>" />
					</div>
				</div>
				<div class="a_mesaj_ic_1">
					<div class="a_mesaj_ic_1_1">
						Mesaj
					</div>
					<div class="a_mesaj_ic_1_2">
						<textarea name="yeni_mesaj" id="yeni_mesaj" style="width:400px;" ></textarea>
					</div>
				</div>
				<div class="a_mesaj_ic_1">
					<div class="a_mesaj_ic_1_2">
						<input type="submit" name="mesaji" id="mesaji" value="Gönder" />
					</div>
				</div>
			</div>
		</div>
		<?php 
			}
		?>
		
	</div>
	<div class="span6">
		<h3>İletişim Bilgileri</h3>
		<div class="well">
			<address>
				<strong>Adı Soyadı</strong><br />
				<?php echo $adi_soyadi; ?>
			</address>
			<address>
				<strong>IP</strong><br />
				<?php echo $mesaj_oku['ip']; ?>
			</address>
			<address>
				<strong>Telefon</strong><br />
				<?php echo $tel; ?>
			</address>
			<address>
				<strong>Email</strong><br />
				<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
			</address>
		</div>
	</div>
</form>