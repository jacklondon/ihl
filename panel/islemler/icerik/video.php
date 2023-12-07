<?php
	$resim_oku=mysql_query("select * from m_video where durum='1'");
	while($resim_cek=mysql_fetch_array($resim_oku))
	{
		
		$video_bol=explode('watch?v=',$resim_cek['link']);
		$resim_bas.='
		<tr style="width:100%;">
			<td>'.$resim_cek['id'].'</td>
			<td>
				<iframe width="400" height="200" src="https://www.youtube.com/embed/'.$video_bol[1].'" frameborder="0" allowfullscreen></iframe>
			</td>
			<td>
			</td>
			<td>
				<a href="?modul=icerik&sayfa=video&sil='.$resim_cek['id'].'">
					sil
				</a>
			</td>
		</tr>';
		
	}
		$resim_bas.='<tr>
						<td>
							#
						</td>
						<td>
							Video Arka Fon
						</td>
						<td>
							<input type="color" name="video_arka" id="video_arka" value="'.$ozellik_oku['video_arka_fon'].'" />
						</td>
						<td>
							
						</td>
					</tr>';

	if(re('sil')!="")
	{
		mysql_query("UPDATE m_video SET durum='0' WHERE id='".re('sil')."' ");
		alert('Görsel Silindi');
		header('Location: ?modul=icerik&sayfa=video');
	}
	
	if(re('kaydet')=='kaydet')
	{
		if(re('link')!='')
		{
			$video_linki=re('link');
			mysql_query("INSERT INTO m_video(link, durum) VALUES ('".$video_linki."','1')");
			header('Location: ?modul=icerik&sayfa=video');
		}
		if(re('video_arka')!=$ozellik_oku['video_arka_fon'])
		{
			mysql_query("update site_tasarim set video_arka_fon='".re('video_arka')."'");
			header('Location: ?modul=icerik&sayfa=video');
		}
	}
?>