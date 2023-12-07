<div style="float:left; width:100%; margin-top:20px;">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-reorder"></i>Ziyaretçi</h4>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
				<div class="progress progress-striped active">
					<div style="width:<?php echo $toplam_ziyaretci / 10; ?>%;" class="bar"></div>
				</div>
				<div style="font-size:14px;">
					Toplam Ziyaret Eden Kişi Sayısı : 
					<b><?php echo $toplam_ziyaretci; ?></b>
				</div>
			</div>
		</div>
	</div>
</div>

<div style="float:left; width:100%;">
	<div class="span12">
		<div class="portlet box green">
			<div class="portlet-title">
				<h4><i class="icon-reorder"></i>Tıklama</h4>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
				<div class="progress progress-striped progress-success active">
					<div style="width:<?php echo $toplam_tik / 10; ?>%;" class="bar"></div>
				</div>
				<div style="font-size:14px;">
					Toplam Tıklama Sayısı : 
					<b><?php echo $toplam_tik; ?></b>
				</div>
			</div>
		</div>
	</div>
</div>

<div style="float:left; width:100%;">
	<div class="span12">
		<div class="portlet box yellow">
			<div class="portlet-title">
				<h4><i class="icon-reorder"></i>Mesaj</h4>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
				<div class="progress progress-striped progress-warning active">
					<div style="width:<?php echo $toplam_mesaj_sayisi / 10; ?>%;" class="bar"></div>
				</div>
				<div style="font-size:14px;">
					Toplam Gelen Mesaj Sayısı : 
					<b><?php echo $toplam_mesaj_sayisi; ?></b>
				</div>
			</div>
		</div>
	</div>
</div>


<div style="float:left; width:100%;">
	<div class="span12">
		<div class="portlet box red">
			<div class="portlet-title">
				<h4><i class="icon-reorder"></i>Kullanıcı</h4>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
				<div class="progress progress-striped progress-danger active">
					<div style="width:<?php echo $toplam_kullanici_sayisi / 10; ?>%;" class="bar"></div>
				</div>
				<div style="font-size:14px;">
					Toplam Kullanıcı Sayısı : 
					<b><?php echo $toplam_kullanici_sayisi; ?></b>
				</div>
			</div>
		</div>
	</div>
</div>


<div style="float:left; width:100%;">
	<div class="span12">
		<div class="portlet box grey">
			<div class="portlet-title">
				<h4><i class="icon-reorder"></i>Sipariş</h4>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
				<div class="progress progress-striped active">
					<div style="width:<?php echo $toplam_siparis / 10; ?>%;" class="bar"></div>
				</div>
				<div style="font-size:14px;">
					Toplam Sipariş Sayısı : 
					<b><?php echo $toplam_siparis; ?></b>
				</div>
			</div>
		</div>
	</div>
</div>