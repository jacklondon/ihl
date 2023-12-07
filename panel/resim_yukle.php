<?php
include("resize.php");
?>
<!DOCTYPE  html>
<html>
	<head>
		<meta charset="windows-1254">
		<title>Admin/Upload</title>
		
		<!-- CSS -->
		<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../css/social-icons.css" type="text/css" media="screen" />

		<!-- JS -->
		<script src="../js/jquery-1.5.1.min.js"></script>
		<script src="../js/custom.js"></script>
		<script type="text/javascript" src="../js/jquery.backgroundPosition.js"></script>
		
		<!--[if IE]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!-- ENDS JS -->
		
		<!--[if IE 8]>
		<link rel="stylesheet" href="../css/ie8-hacks.css" type="text/css" media="screen" />
		<![endif]-->
		
		
		<!-- poshytip -->
		<link rel="stylesheet" href="../js/poshytip-1.0/src/tip-twitter/tip-twitter.css" type="text/css" />
		<link rel="stylesheet" href="../js/poshytip-1.0/src/tip-yellowsimple/tip-yellowsimple.css" type="text/css" />
		<script type="text/javascript" src="../js/poshytip-1.0/src/jquery.poshytip.min.js"></script>
		<!-- ENDS poshytip -->
		
		<!-- superfish -->
		<link rel="stylesheet" media="screen" href="../css/superfish.css" /> 
		<script type="text/javascript" src="../js/superfish-1.4.8/js/hoverIntent.js"></script>
		<script type="text/javascript" src="../js/superfish-1.4.8/js/superfish.js"></script>
		<script type="text/javascript" src="../js/superfish-1.4.8/js/supersubs.js"></script>
		<!-- ENDS superfish -->
		
		<!-- Tweet -->
		<link rel="stylesheet" href="../css/jquery.tweet.css" media="all"  type="text/css"/> 
		<script src="../js/tweet/jquery.tweet.js" type="text/javascript"></script> 
		<!-- ENDS Tweet -->

		<!-- prettyPhoto -->
		<script type="text/javascript" src="../js/prettyPhoto/js/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" href="../js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" />
		<!-- ENDS prettyPhoto -->
		
		<!-- Slides -->
		<script src="../js/slides.min.jquery.js" type="text/javascript"></script> 
		
		<!-- tabs -->
		<link rel="stylesheet" href="../css/tabs.css" type="text/css" media="screen" />
		<script type="text/javascript" src="../js/tabs.js"></script>
  		<!-- ENDS tabs -->
  		
		<!-- GOOGLE FONTS -->
		<link href='http://fonts.googleapis.com/css?family=Arvo:400,700|PT+Sans' rel='stylesheet' type='text/css'>
		
		
	</head>
	<body>
		<!-- WRAPPER -->
		<div id="bottom-bg">
		<div id="wrapper">
		
			<div id="top-header">
				<a href="index.php"><img src="../img/logo.png" alt="ZEN" id="logo" /></a>
			</div>
			
			<nav>
				<ul id="nav" class="sf-menu">
					<li><a href="index.php">Blog Düzenle <span class="subheader">Yazılarınızı Düzenleyin veya Silin</span></a></li>
					<li class="current-menu-item"><a href="">Yükle<span class="subheader">Dosya Yükleyin</span></a>
						<ul>
							<li><a href="makale_upload.php">Makale</a></li>
							<li><a href="resim_upload.php">Resim</a></li>
							<li><a href="#">Metin</a></li>
						</ul>
					</li>
				<li><a href="logout.php">Çıkış</a></li>	
				</ul>
			</nav>
			<div id="sidebar-opener">Sidebar</div>
			<!-- content -->
			<div id="content">
			
				<!-- posts -->
				<div id="posts">
					<!-- entry-standard -->
					<article class="format-standard">
				
						<h4 class="entry-title">
							<span class="title"><a href="single.html">Resim Yükleme</a></span>
							<span class="entry-comments"><a href="single.html#comments" title="Go to the comments" class="poshytip">23</a></span>
						</h4>
						
						
						<div class="entry-excerpt">

						<form method="post" action="" enctype="multipart/form-data">
						<input type="file" value="Resim Seç" name="dosyam"/>
						<input type="submit" value="Resim Ekle" name="resim_ekle" /> 
						</form>
<?php
if(@$_POST['resim_ekle'])
	{
		$dosyaismi=$_FILES['dosyam']['name'];
		$geciciyer=$_FILES['dosyam']['tmp_name'];
		if(@$dosyaismi=="" || $_FILES['dosyam']['error']>0)
			{
			echo "Yükleme yapabilmek İçin bir dosya seçin";
			}
		else
			{
			$x=substr(md5(rand(9999,99999)),0,5).substr($dosyaismi,-4);
			$gercekisim="image_".$x;
			move_uploaded_file($geciciyer,"../images/urunler/".$gercekisim);
			echo "dosya yuklenmiştir<br>";
			$thumbisim="../images/urunler/".$gercekisim;
			$image = new SimpleImage();
			$image->load("$thumbisim");
			$image->resize(700,380);
			$image->save("$thumbisim");
			}		
	}
	
?>
						</div>
					</article>
					<!-- ENDS entry-standard -->
				</div>
				<!-- ENDS posts -->

				<div id="footer-bottom"><h6>Zen HTML template</h6><span>by <a href="http://www.luiszuno.com" >luiszuno.com</a></span></div>
			
			</div>
			<!-- ENDS content -->
			
			
			<div id="to-top">Back to top</div>

		</div>
		</div>
		<!-- ENDS WRAPPER -->
		
	</body>
</html>
