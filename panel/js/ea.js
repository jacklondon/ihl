var settaym = '';
function menu_getir(sira)
{
	for(var i=1; i<=document.getElementById('alt_menu_toplam').value; i++)
	{
		if(i != sira)
		{
			menu_goturelim(i);
		}
	}
	clearTimeout(settaym);
	$('#alt_m_'+sira).fadeIn(200);
}

function hepsini_gotur()
{
	for(var i=1; i<=document.getElementById('alt_menu_toplam').value; i++)
	{
		menu_goturelim(i);
	}
}

function menu_gotur(sira)
{
	for(var i=1; i<=document.getElementById('alt_menu_toplam').value; i++)
	{
		if(i != sira)
		{
			menu_goturelim(i);
		}
	}
	//settaym = setTimeout('menu_goturelim('+sira+')',500);
	//$('#alt_m_'+sira).fadeOut(200);
}

function menu_goturelim(sira)
{
	$('#alt_m_'+sira).fadeOut(150);
}

var kapatilabilir_wit = 0;
function profil_ac()
{
	document.getElementById("kullanici_p_dis").style.backgroundColor="white";
	document.getElementById("kullanici_p_dis").style.color="#27A9E3";
	document.getElementById("kullanici_r_c_dis").src="images/genel/r_cerceve2.png";
	document.getElementById('acilacak_alan').style.width=document.getElementById("kullanici_p_dis").offsetWidth+'px';
	$('#acilacak_alan').fadeIn(200);
	$('#kapatmalik_alan_ust').fadeIn(200);
	kapatilabilir_wit = 1000 - document.getElementById("kullanici_p_dis").offsetWidth;
	document.getElementById('kapatmalik_alan').style.width = kapatilabilir_wit+'px';
	document.getElementById('kapatmalik_alan').style.height = document.getElementById("acilacak_alan").offsetHeight+'px';
}

function profil_kapat()
{
	document.getElementById("kullanici_p_dis").style.backgroundColor="#27A9E3";
	document.getElementById("kullanici_p_dis").style.color="white";
	document.getElementById("kullanici_r_c_dis").src="images/genel/r_cerceve.png";
	$('#acilacak_alan').fadeOut(100);
	$('#kapatmalik_alan_ust').fadeOut(100);
}




/*
function submit(islem)
{
	$('#submit_st').html('<input type="hidden" name="islem" value="'+islem+'" />');
	document.forms["form"].submit();
}
*/



var depo_ac = false;
function depo_islem()
{
	if(depo_ac == false)
	{
		$('#depo_acilan').fadeIn(100);
		depo_ac = true;
	}
	else
	{
		$('#depo_acilan').fadeOut(100);
		depo_ac = false;
	}
}

function resim_secildi()
{
	if(document.getElementById('resim_depo').value != "")
	{
		$('#up_konum').html('<input type="hidden" name="islem_r" value="depo_resim" />');
		document.forms["form"].submit();
	}
}


function depo_resim_tik(resim)
{
	if(resim != "")
	{
		window.prompt("Resim Linkini aşağıdan kopyalayabilirsiniz", 'images/resimler/'+resim);
	}
}


function kategori_ekle(kat_id,adi)
{
	if(document.getElementById('eklenecek_kategoriler').value == "")
	{
		document.getElementById('eklenecek_kategoriler').value = document.getElementById('eklenecek_kategoriler').value+kat_id;
	}
	else
	{
		document.getElementById('eklenecek_kategoriler').value = document.getElementById('eklenecek_kategoriler').value+','+kat_id;
	}
	
	$('#ek_kategoriler').append('<div class="ek_kategorisi" id="eklenmis_kat_'+kat_id+'">'+adi+'<span style="margin-left:8px; margin-top:-2px; cursor:pointer; font-weight:bold; cursor:pointer;" onclick="kategoriyi_cikart('+kat_id+');">x</span></div>');
	$('#kat_liste_'+kat_id).fadeOut(150);
	
	if(document.getElementById('acilmismi_bu').value == " ")
	{
		$('#acilmismi_bu').fadeOut(150);
	}
}

var eklenecekleri = "";
var say_bunu = 0;
function kategoriyi_cikart(kat_id)
{
	$('#eklenmis_kat_'+kat_id).remove();
	$('#kat_liste_'+kat_id).fadeIn(150);
	
	var kategorileri = document.getElementById('eklenecek_kategoriler').value.split(',');
	var length = kategorileri.length;   
	
	say_bunu = 0;
	eklenecekleri = '';
	for(sayi in kategorileri) 
	{
		if(kat_id != kategorileri[sayi])
		{
			say_bunu++
			if(say_bunu == 1)
			{
				eklenecekleri += eklenecekleri+kategorileri[sayi];
			}
			else
			{
				eklenecekleri = eklenecekleri+','+kategorileri[sayi];
			}
		}
	}
	document.getElementById('eklenecek_kategoriler').value = eklenecekleri;
}








function kategori_degisti()
{
	$.post('islemler/urunler/urun_kat_islemi.php',{veri: "1|"+document.getElementById("kategori").value},function(veriler){
		
		
		if(veriler == "")
		{
			$('#alt_kategori').html('');
		}
		else
		{
			
			$('#alt_kategori').html(veriler);
		}
	});
}


function marka_degisti()
{
	$.post('islemler/urunler/urun_kat_islemi.php',{veri: "2|"+document.getElementById("marka").value},function(veriler){
		if(veriler == "")
		{
			$('#model').html('');
		}
		else
		{
			
			$('#model').html(veriler);
		}
	});
}

var eklentisi = '';
function post_edildi()
{
	eklentisi = '';
	if(document.getElementById("kategori").value != 0)
	{
		eklentisi += '&kategori='+document.getElementById("kategori").value;
	}
	if(document.getElementById("alt_kategori").value != 0)
	{
		eklentisi += '&alt_kategori='+document.getElementById("alt_kategori").value;
	}
	if(document.getElementById("alt_kategori2").value != 0)
	{
		eklentisi += '&alt_kategori2='+document.getElementById("alt_kategori2").value;
	}
	if(document.getElementById("alt_kategori3").value != 0)
	{
		eklentisi += '&alt_kategori3='+document.getElementById("alt_kategori3").value;
	}
	if(document.getElementById("alt_kategori4").value != 0)
	{
		eklentisi += '&alt_kategori4='+document.getElementById("alt_kategori4").value;
	}
	if(document.getElementById("marka").value != 0)
	{
		eklentisi += '&marka='+document.getElementById("marka").value;
	}
	window.location="?modul=urunler&sayfa=urunler"+eklentisi;
	//document.forms["form"].submit();
}


function post_edildi2()
{
	eklentisi = '';
	if(document.getElementById("kategori").value != 0)
	{
		eklentisi += '&kategori='+document.getElementById("kategori").value;
	}
	if(document.getElementById("alt_kategori").value != 0)
	{
		eklentisi += '&alt_kategori='+document.getElementById("alt_kategori").value;
	}
	if(document.getElementById("alt_kategori2").value != 0)
	{
		eklentisi += '&alt_kategori2='+document.getElementById("alt_kategori2").value;
	}
	if(document.getElementById("alt_kategori3").value != 0)
	{
		eklentisi += '&alt_kategori3='+document.getElementById("alt_kategori3").value;
	}
	if(document.getElementById("alt_kategori4").value != 0)
	{
		eklentisi += '&alt_kategori4='+document.getElementById("alt_kategori4").value;
	}
	if(document.getElementById("marka").value != 0)
	{
		eklentisi += '&marka='+document.getElementById("marka").value;
	}
	window.location="?modul=urunler&sayfa=toplu_guncelleme"+eklentisi;
	//document.forms["form"].submit();
}



function kat_icine_gir(kat_id)
{
	$("#k_kat_"+kat_id).toggle();
}






function k_kategori_ekle(kat_id,adi,tur)
{
	if(document.getElementById('eklenecek_k_kategoriler').value == "")
	{
		document.getElementById('eklenecek_k_kategoriler').value = document.getElementById('eklenecek_k_kategoriler').value+kat_id;
	}
	else
	{
		document.getElementById('eklenecek_k_kategoriler').value = document.getElementById('eklenecek_k_kategoriler').value+','+kat_id;
	}
	
	$('#ek_k_kategoriler').append('<div class="ek_kategorisi" id="k_eklenmis_kat_'+kat_id+'">'+adi+'<span style="margin-left:8px; margin-top:-2px; cursor:pointer; font-weight:bold; cursor:pointer;" onclick="k_kategoriyi_cikart('+kat_id+','+tur+');">x</span></div>');
	
	$('#k'+tur+'_kat_'+kat_id).fadeOut(150);
	
	if(document.getElementById('k_acilmismi_bu').value == " ")
	{
		$('#k_acilmismi_bu').fadeOut(150);
	}
}


var eklenecekleri = "";
var say_bunu = 0;
function k_kategoriyi_cikart(kat_id,tur)
{
	$('#k_eklenmis_kat_'+kat_id).remove();
	$('#k'+tur+'_kat_'+kat_id).fadeIn(150);
	
	var kategorileri = document.getElementById('eklenecek_k_kategoriler').value.split(',');
	var length = kategorileri.length;   
	
	say_bunu = 0;
	eklenecekleri = '';
	for(sayi in kategorileri) 
	{
		if(kat_id != kategorileri[sayi])
		{
			say_bunu++
			if(say_bunu == 1)
			{
				eklenecekleri += eklenecekleri+kategorileri[sayi];
			}
			else
			{
				eklenecekleri = eklenecekleri+','+kategorileri[sayi];
			}
		}
	}
	document.getElementById('eklenecek_k_kategoriler').value = eklenecekleri;
}





$(function() {
	if($('.fiyat_yaz').size()>0)
		$('.fiyat_yaz').html($('.fiyat_yaz').html().replace("%s",""));
});

 function openToastrSuccess(msg){
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "3000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	};
	toastr["success"](msg);

}
function openToastrDanger(msg){
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5500",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	};
	toastr["error"](msg);

}



