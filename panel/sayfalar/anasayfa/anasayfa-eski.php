<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						<?php 
						/*
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
							<div class="color-mode">
								<p>THEME RENKLERİ</p>
								<ul class="inline">
									<li class="color-black current color-default" data-style="default"></li>
									<li class="color-blue" data-style="blue"></li>
									<li class="color-brown" data-style="brown"></li>
									<li class="color-purple" data-style="purple"></li>
									<li class="color-white color-light" data-style="light"></li>
								</ul>
								<label class="hidden-phone">
								<input type="checkbox" class="header" checked value="" />
								<span class="color-mode-label">Sayfaya yayma</span>
								</label>							
							</div>
						</div>
						*/
						?>
						<!-- END BEGIN STYLE CUSTOMIZER -->   	
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Giriş				
							<small>Özet İstatistikler</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="index.php">Giriş</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#">İstatistikler</a></li>
							<li class="pull-right no-text-shadow" style="display:none;">
								<div id="dashboard-report-range" class="dashboard-date-range tooltips no-tooltip-on-touch-device responsive" data-tablet="" data-desktop="tooltips" data-placement="top" data-original-title="Change dashboard date range">
									<i class="icon-calendar"></i>
									<span></span>
									<i class="icon-angle-down"></i>
								</div>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->

<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					<div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue">
								<div class="visual">
									<i class="icon-comments"></i>
								</div>
								<div class="details">
									<div class="number">
										<?php echo $mesaj_say; ?>
									</div>
									<div class="desc">									
										Yeni Mesajlar
									</div>
								</div>
								<a class="more" href="?modul=istatistikler&sayfa=mesajlar">
								Detaylar <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="icon-shopping-cart"></i>
								</div>
								<div class="details">
									<div class="number">
										<?php echo mysql_num_rows(mysql_query("select * from s_sepet where durum='2' and sip_durum='1' ORDER BY sip_tarihi ASC, id ASC ")); ?>
									</div>
									<div class="desc">Yeni Satış</div>
								</div>
								<a class="more" href="?modul=siparisler&sayfa=tum_siparisler">
								Detaylar <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="icon-globe"></i>
								</div>
								<div class="details">
									<div class="number"><?php echo $tahsil_sayi; ?></div>
									<div class="desc">Toplam Satış</div>
								</div>
								<a class="more" href="#">
								Detaylar<i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="details">
									<div class="number"><?php echo para($tahsil_tutar); ?> TL</div>
									<div class="desc">Tahsilat</div>
								</div>
								<a class="more" href="#">
								Detaylar <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
					</div>
					<!-- END DASHBOARD STATS -->
					<div class="clearfix"></div>
					<div class="row-fluid">
						<div class="span6">
							<!-- BEGIN PORTLET-->
							<div class="portlet solid bordered light-grey">
								<div class="portlet-title">
									<h4><i class="icon-bar-chart"></i>Site İstatistik</h4>
									<div class="tools">
										<div class="btn-group pull-right" data-toggle="buttons-radio">
											<a href="javascript:;" class="btn mini">Kullanıcı</a>
											<a href="javascript:;" class="btn mini active">Feedbacks</a>
										</div>
									</div>
								</div>
								<div class="portlet-body">
									<div id="site_statistics_loading">
										<img src="assets/img/loading.gif" alt="loading" />
									</div>
									<div id="site_statistics_content" class="hide">
										<div id="site_statistics" class="chart"></div>
									</div>
								</div>
							</div>
							<!-- END PORTLET-->
						</div>
						<div class="span6">
							<!-- BEGIN PORTLET-->
							<div class="portlet solid light-grey bordered">
								<div class="portlet-title">
									<h4><i class="icon-bullhorn"></i>Günlük Çizelge</h4>
									<div class="tools">
										<div class="btn-group pull-right" data-toggle="buttons-radio">
											<a href="javascript:;" class="btn blue mini active">Kullanıcı</a>
											<a href="javascript:;" class="btn blue mini">Satış</a>
										</div>
									</div>
								</div>
								<div class="portlet-body">
									<div id="site_activities_loading">
										<img src="assets/img/loading.gif" alt="loading" />
									</div>
									<div id="site_activities_content" class="hide">
										<div id="site_activities" style="height:100px;"></div>
									</div>
								</div>
							</div>
							<!-- END PORTLET-->
							<!-- BEGIN PORTLET-->
							<div class="portlet solid bordered light-grey">
								<div class="portlet-title">
									<h4><i class="icon-signal"></i>Server Durum</h4>
									<div class="tools">
										<div class="btn-group pull-right" data-toggle="buttons-radio">
											<a href="javascript:;" class="btn red mini active">
											<span class="hidden-phone">Database</span>
											<span class="visible-phone">DB</span></a>
											<a href="javascript:;" class="btn red mini">Web</a>
										</div>
									</div>
								</div>
								<div class="portlet-body">
									<div id="load_statistics_loading">
										<img src="assets/img/loading.gif" alt="loading" />
									</div>
									<div id="load_statistics_content" class="hide">
										<div id="load_statistics" style="height:108px;"></div>
									</div>
								</div>
							</div>
							<!-- END PORTLET-->
						</div>
					</div>
					<div class="clearfix"></div>
					
					
				</div>




