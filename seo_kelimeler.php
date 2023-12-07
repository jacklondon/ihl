<?php 
	$seo_kelime_head_cek = mysql_query("select * from seo_kelimeler where id = 1");
	$seo_kelime_head_oku = mysql_fetch_assoc($seo_kelime_head_cek);
?>
<title>Pert &mdash; Dünyası</title>
<meta http-equiv="content-language" content="tr">
<meta name="author" content="<?= $seo_kelime_head_oku['author'] ?>">
<meta name="Abstract" content="<?= $seo_kelime_head_oku['abstract'] ?>">
<meta name="description" content="<?= $seo_kelime_head_oku['description'] ?>">
<meta name="keywords" content="<?= $seo_kelime_head_oku['keywords'] ?>" >
<meta name="Copyright" content="Ea Bilişim Tüm Hakları Saklıdır.">
<meta name="robots" content="index,follow">

<link rel="canonical" href="https://ihale.pertdunyasi.com" />
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />