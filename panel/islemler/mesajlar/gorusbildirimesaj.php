<?php
	// İşlemler
	function getMessages() {
		$query = "SELECT * FROM gorus_bildiri_form ORDER BY id DESC";
		$result = mysql_query($query);
		$data = array();
		while ($msg = mysql_fetch_assoc($result)) {
			$data[] = $msg;
		}
		return $data;
	}

	$mesajlar = getMessages();