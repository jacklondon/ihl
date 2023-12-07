<?php
	// MİNİ BLOG İŞLEMLER SAYFASI

	include('islemler/icerik/miniblogClass.php');

	$mb = new miniBlog();
	
	if (isset($_GET['id'])) {
		if ($_GET['id'] == '0') {
			$action = 'ADD';
		}
		else {
			if (isset($_GET['sil'])) {
				$mb->delPost($_GET['sil']);
				header('Location: sistem.php?modul=icerik&sayfa=miniblog');
			} else {
				$action = 'EDIT';
				$post = $mb->getPost($_GET['id']);
				if ($post === false)
					header('Location: sistem.php?modul=icerik&sayfa=miniblog');
			}
		}
	} else {
		$action = 'LIST';
		$posts = $mb->getAll();
	}

	

	if (isset($_POST['action'])) {
		switch ($_POST['action']) {
			case 'addPost':
				$mb->addPost($_POST);
			break;
			case 'editPost':
				$mb->editPost($_POST);
				header('Location: sistem.php?modul=icerik&sayfa=miniblog');
			break;
			
			default:
				# code...
				break;
		}
	}