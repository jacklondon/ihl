
//Kazandıkları
$(document).ready(function(){
     $(document).on('click', '.view_kazandiklari', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/uyeler/kazandiklari.php', {'id':employee_id}, function(response){
                  $('#uyenin_kazandiklari').html(response);
                  $('#kazandiklari').modal('show');                 
               })
          }
     });
});
//Teklifleri
$(document).ready(function(){
     $(document).on('click', '.view_teklifleri', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/uyeler/teklifleri.php', {'id':employee_id}, function(response){
                  $('#uyenin_teklifleri').html(response);
                  $('#teklifleri').modal('show')
               })
          }
     });
});
//Mesajları
$(document).ready(function(){
     $(document).on('click', '.view_mesajlari', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/uyeler/mesajlari.php', {'id':employee_id}, function(response){
                  $('#uyenin_mesajlari').html(response);
                  $('#mesajlari').modal('show')
               })
          }
     });
});
//Favorileri
$(document).ready(function(){
     $(document).on('click', '.view_favorileri', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/uyeler/favorileri.php', {'id':employee_id}, function(response){
                  $('#uyenin_favorileri').html(response);
                  $('#favorileri').modal('show')
               })
          }
     });
});
//Notları
$(document).ready(function(){
     $(document).on('click', '.view_notlari', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/uyeler/notlari.php', {'id':employee_id}, function(response){
                  $('#uyenin_notlari').html(response);
                  $('#notlari').modal('show')
               })
          }
     });
});



//Aktif Cayma Bedelleri
$(document).ready(function(){
     $(document).on('click', '.view_aktifleri', function(){
          var employee_id = $(this).attr("id");
          
          if(employee_id != '')
          {  
               $.post('sayfalar/uyeler/aktif_caymalari.php', {'id':employee_id}, function(response){
                  $('#caymanin_aktifleri').html(response);
                  $('#aktifleri').modal('show');
               })
          }else{
               alert("Hata");
          }
     });
});
//Aktif Cayma Bedelleri Güncelleme
function aktifGuncelle(){
          var aktif_id = $("#aktif_id").val();
          var gelen_id = $("#gelen_id").val();
          var hesap_sahibi = $('#hesap_sahibi').val();
          var depozito_durumu = $('#depozito_durumu').val();
          var aktif_tutar = $('#aktif_tutar').val();
          var aktif_iade_tutar = $('#aktif_iade_tutar').val();
          var aktif_iban = $('#aktif_iban').val();
          var aktif_aciklama = $('#aktif_aciklama').val();
          var aktif_iade_tutar = $('#aktif_iade_tutar').val();
          var iade_edilecek_tarih = $('#iade_edilecek_tarih').val();
          var $baseUrl = "https://ihale.pertdunyasi.com/panel/sayfalar/uyeler/";
          var adsayi = hesap_sahibi.match(/(\w+)/g).length;

          if(aktif_id)
          {  
               if(adsayi < 2){
                    alert("Ad Soyad en az 2 kelime olmak zorundadır");
               }else if(depozito_durumu==""){
				   alert("Depozito durumu seçmelisiniz.");
			   }else{
                    if(aktif_iban.length < 24 || aktif_iban.length > 24){
                         alert("Iban 24 karakter olmalıdır");
                    }else{
                         jQuery.ajax({
                              url: $baseUrl+'aktif_caymalari_duzenle.php',
                              type: "POST",
                              dataType: "JSON",
                              data: {
								   action:"aktif_guncelle",
                                   aktif_id: aktif_id,
                                   gelen_id: gelen_id,
                                   hesap_sahibi: hesap_sahibi,
                                   depozito_durumu: depozito_durumu,
                                   aktif_tutar: aktif_tutar,
                                   aktif_iban: aktif_iban,
                                   aktif_aciklama: aktif_aciklama,
                                   aktif_iade_tutar: aktif_iade_tutar,
                                   iade_edilecek_tarih: iade_edilecek_tarih,
                                   aktif_iade_tutar:aktif_iade_tutar
                              },
                              success: function(data) {
                                 $('.success').removeClass('d-none').html(data);
                                 alert("İşlem başarılı"); 
                                 location.reload();
                              },
                              error: function(data) {
                                 $('.error').removeClass('d-none').html(data);
                                 alert('HATA! Lütfen tekrar deneyiniz.')
                              }
                         });
                    }
               
               }
          }
     } 

//İade Cayma Bedelleri
$(document).ready(function(){
     $(document).on('click', '.view_iadeleri', function(){
          var employee_id = $(this).attr("id");
          
          if(employee_id != '')
          {  
               $.post('sayfalar/uyeler/iade_caymalari.php', {'id':employee_id}, function(response){
                  $('#caymanin_iadeleri').html(response);
                  $('#iadeleri').modal('show');
               })
          }else{
               alert("Hata");
          }
     });
});
//Aktif Cayma Bedelleri Güncelleme
	function iadeGuncelle(){
		var iade_id = $("#iade_id").val();
		var gelen_id = $("#gelen_id").val();
		var hesap_sahibi = $('#hesap_sahibi').val();
		var depozito_durumu = $('#depozito_durumu').val();
		var aktif_tutar = $('#aktif_tutar').val();
		var aktif_iade_tutar = $('#aktif_iade_tutar').val();
		var aktif_iban = $('#aktif_iban').val();
		var aktif_aciklama = $('#aktif_aciklama').val();
		var aktif_iade_tutar = $('#aktif_iade_tutar').val();
		var iade_edilecek_tarih = $('#iade_edilecek_tarih').val();
		var $baseUrl = "https://ihale.pertdunyasi.com/panel/sayfalar/uyeler/";
		var adKontrol = hesap_sahibi.match(/(\w+)/g).length;

		if(aktif_id)
		{  
		   if(adKontrol < 2){
				alert("HATA");
		   }else if(depozito_durumu == ""){
				alert("Depozito durumu seçmelisiniz");
		   }else{
				if(aktif_iban.length < 24 || aktif_iban.length > 24){
					 alert("Iban 24 karakter olmalıdır");
				}else{
					jQuery.ajax({
						url: $baseUrl+'iade_caymalari_duzenle.php',
						type: "POST",
						dataType: "JSON",
						data: {
							action:"iade_guncelle",
							iade_id: iade_id,
							gelen_id: gelen_id,
							hesap_sahibi: hesap_sahibi,
							depozito_durumu: depozito_durumu,
							aktif_tutar: aktif_tutar,
							aktif_iban: aktif_iban,
							aktif_aciklama: aktif_aciklama,
							aktif_iade_tutar: aktif_iade_tutar,
							iade_edilecek_tarih: iade_edilecek_tarih,
							aktif_iade_tutar:aktif_iade_tutar
						},
						success: function(data) {
							$('.success').removeClass('d-none').html(data);
							alert("İşlem başarılı"); 
							location.reload();
						},
						error: function(data) {
							$('.error').removeClass('d-none').html(data);
							alert('HATA! Lütfen tekrar deneyiniz.')
						}
					});
				}
			}	
		}
	} 
//Talep Edilen Cayma Bedelleri
$(document).ready(function(){
	$(document).on('click', '.view_talepleri', function(){
		var employee_id = $(this).attr("id");
          
		if(employee_id != '')
		{  
			$.post('sayfalar/uyeler/cayma_bedeli_iade_talepleri.php', {'id':employee_id}, function(response){
				$('#caymanin_talepleri').html(response);
				$('#talepleri').modal('show');
			})
		}else{
			alert("Hata");
		}
	});
});
//Yeni Cayma Bedeli Ekle
$(document).ready(function(){
	$(document).on('click', '.view_yeni_cayma', function(){
		var employee_id = $(this).attr("id");
		if(employee_id != '')
		{  
			$.post('sayfalar/uyeler/yeni_cayma.php', {'id':employee_id}, function(response){
				$('#cayma_yeni').html(response);
				$('#yeni_cayma').modal('show');
			})
		}else{
			alert("Hata");
		}
	});
});
//Cayma Bedeli Duzenle
$(document).ready(function(){
	$(document).on('click', '.view_duzenle_cayma', function(){
		var employee_id = $(this).attr("id");
		if(employee_id != '')
		{  
			$.post('sayfalar/uyeler/cayma_duzenle.php', {'id':employee_id}, function(response){
				$('#cayma_duzenle').html(response);
				$('#duzenle_cayma').modal('show');
			})
		}else{
			alert("Hata");
		}
	});
});
//Yeni Borç Ekle
$(document).ready(function(){
	$(document).on('click', '.view_yeni_borc', function(){
		var employee_id = $(this).attr("id");
		if(employee_id != '')
		{  
			$.post('sayfalar/uyeler/yeni_borc.php', {'id':employee_id}, function(response){
				$('#borc_ekle').html(response);
				$('#ekle_borc').modal('show');
			})
		}else{
			alert("Hata");
		}
	});
});



//Satılan Araç Ekle
$(document).ready(function(){
     $(document).on('click', '.view_yeni_satilan_ekle', function(){
          var employee_id = 1;
          if(employee_id != '')
          {  
               $.post('sayfalar/muhasebe/yeni_veri_ekle.php', {'id':employee_id}, function(response){
                  $('#satilan_yeni_veri_ekle').html(response);
                  $('#yeni_veri_ekle').modal('show')
               })
          }
     });
});

//Satılan Araç Düzenle
$(document).ready(function(){
     $(document).on('click', '.view_satilan_duzenle', function(){
          var employee_id =  $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/muhasebe/veri_duzenle.php', {'id':employee_id}, function(response){
                  $('#satilan_yeni_veri_duzenle').html(response);
                  $('#yeni_veri_duzenle').modal('show')
               })
          }
     });
});





//Yeni Cayma Ekle
	var $baseUrl = "https://ihale.pertdunyasi.com/panel/sayfalar/uyeler/";
	function aracGetir(){
		var arac_kod_plaka = $("#arac_kod_plaka").val();
		jQuery.ajax({
			url: $baseUrl+"yeni_cayma_ekle.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action:"arac_getir",
				arac_kod_plaka: arac_kod_plaka,
			},
			success: function(data) {
				console.log(data);
				if(data.status==200){
					var arac_detay=data.arac_detay
					$("#arac_bilgisi").html(arac_detay);
				}else{
					$("#arac_bilgisi").html("");
				}
				
			},
			error: function(data) {
			
				alert("Hata");  
			}
		});
	}
	function caymaFiltre(durum,listeleme,excel_action){
		var ay = $('#ay_'+durum).val();
		var yil = $('#yil_'+durum).val();  
		if(yil!=""){  
			jQuery.ajax({
				url: $baseUrl+'yeni_cayma_ekle.php',
				type: "POST",
				dataType: "JSON",
				data: {
					action:"cayma_filtre",
					ay: ay,
					yil: yil,
					durum: durum,
					listeleme: listeleme,
					excel_action: excel_action,
				},
				success: function(response) {
					console.log(response);
					
					$("#excel_"+durum).html(response.excel_href);
					$("#tarih_"+durum).html(response.tarih_text);
					$("#toplam_"+durum).html(response.toplam);
					$("#caymalar_"+durum).html(response.data);
					$('#cayma_durumlari_'+durum).html(response.data);

					//$('#ekle_borc').modal('toggle');
					//alert("İşlem başarılı");  
					//localStorage.setItem("trigger","cayma_bedeli_tab");
					//window.location.href = "?modul=uyeler&sayfa=uye_duzenle&id="+uye_id;
				},
				error: function(response) {
					
					alert("Hata");  
				}
			});
		}else{
			alert("Yıl seçimi yapmalısınız");
		}
	}
	function yeniBorcEkle(){     
		var uye_id = $('#uye_id').val();
		var arac_kod_plaka = $('#arac_kod_plaka').val();
		var tutar = $('#tutar').val();
		var arac_bilgisi= $('#arac_bilgisi').html();
		var aciklama = $('#aciklama').val();
		var bloke_tarihi = $('#bloke_tarihi').val();
		
		if(uye_id!=""){  
			jQuery.ajax({
				url: $baseUrl+'yeni_cayma_ekle.php',
				type: "POST",
				dataType: "JSON",
				data: {
					action:"borc_ekle",
					uye_id: uye_id,
					arac_kod_plaka: arac_kod_plaka,
					tutar: tutar,
					arac_bilgisi: arac_bilgisi,
					aciklama: aciklama,
					bloke_tarihi: bloke_tarihi,
				},
				success: function(data) {
					console.log(data);
					$('#ekle_borc').modal('toggle');
					alert("İşlem başarılı");  
					localStorage.setItem("trigger","cayma_bedeli_tab");
					window.location.href = "?modul=uyeler&sayfa=uye_duzenle&id="+uye_id;
				},
				error: function(data) {
					$('.error').removeClass('d-none').html(data);
					alert("Hata");  
				}
			});
		}else{
			alert("Ad Soyad en az 2 kelime olmak zorundadır");
		}
	} 
	function cayma_sil(id){
		if(confirm ("Silmek istediğinize emin misiniz?")){
			jQuery.ajax({
				url: $baseUrl+"yeni_cayma_ekle.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action:"cayma_sil",
					cayma_id: id
				},
				success: function(data) {
					console.log(data);
					alert("İşlem başarılı"); 
					localStorage.setItem("trigger","cayma_bedeli_tab");			
					window.location.reload();		
					//window.location.href = "?modul=uyeler&sayfa=uye_duzenle&id="+uye_id;
					$('#cayma_'+id).remove();
					//var form=data.form;
					//$("#cayma_form").html(form);
					
				},
				error: function(data) {
				
					alert("Hata");  
				}
			});
		}else{
			alert("İşlem iptal edildi");
		}
	}
	function inputGoster(){
		var durum = $("#durum").val();		
		var cayma_id = $("#cayma_id").val();
		jQuery.ajax({
			url: $baseUrl+"yeni_cayma_ekle.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action:"form_guncelle",
				durum: durum,
				cayma_id: cayma_id,
			},
			success: function(data) {
				console.log(data);

				var form=data.form;
				$("#cayma_form").html(form);
				
			},
			error: function(data) {
			
				alert("Hata");  
			}
		});
	}
	function yeniEkle(){     
		var uye_id = $('#uye_id').val();
		var hesap_sahibi = $('#hesap_sahibi').val();
		var tutar = $('#tutar').val();
		var iban = $('#iban').val();
		var aciklama = $('#aciklama').val();
		var paranin_geldigi_tarih = $('#paranin_geldigi_tarih').val();
		var wordCount = hesap_sahibi.match(/(\w+)/g).length;
	
		if(uye_id!=""){  
			if(wordCount < 2){
				alert("Ad Soyad en az 2 kelime olmak zorundadır");
			}else{
				jQuery.ajax({
					url: $baseUrl+'yeni_cayma_ekle.php',
					type: "POST",
					dataType: "JSON",
					data: {
						action:"yeni_ekle",
						uye_id: uye_id,
						hesap_sahibi: hesap_sahibi,
						tutar: tutar,
						iban: iban,
						aciklama: aciklama,
						paranin_geldigi_tarih: paranin_geldigi_tarih,
					},
					success: function(data) {
						console.log(data);
						$('.success').removeClass('d-none').html(data);
						$('#yeni_cayma').modal('toggle');
						localStorage.setItem("trigger","cayma_bedeli_tab");
						alert("İşlem başarılı");  
						window.location.href = "?modul=uyeler&sayfa=uye_duzenle&id="+uye_id;
					},
					error: function(data) {
						$('.error').removeClass('d-none').html(data);
						alert("Hata");  
					}
				});
				/*
				if(iban.length < 24 || iban.length > 24){
					alert("Iban 24 karakter olmalıdır");
				}else{
					jQuery.ajax({
						url: $baseUrl+'yeni_cayma_ekle.php',
						type: "POST",
						dataType: "JSON",
						data: {
							action:"yeni_ekle",
							uye_id: uye_id,
							hesap_sahibi: hesap_sahibi,
							tutar: tutar,
							iban: iban,
							aciklama: aciklama,
							paranin_geldigi_tarih: paranin_geldigi_tarih,
						},
						success: function(data) {
							console.log(data);
							$('.success').removeClass('d-none').html(data);
							$('#yeni_cayma').modal('toggle');
							localStorage.setItem("trigger","cayma_bedeli_tab");
							alert("İşlem başarılı");  
							window.location.href = "?modul=uyeler&sayfa=uye_duzenle&id="+uye_id;
						},
						error: function(data) {
						   $('.error').removeClass('d-none').html(data);
							alert("Hata");  
						}
					});
				}
				*/
			}
		}else{
			alert("Ad Soyad en az 2 kelime olmak zorundadır");
		}
	} 
	function caymaDuzenle(){     
		var cayma_id = $('#cayma_id').val();
		var uye_id = $('#uye_id').val();
		var hesap_sahibi = $('#hesap_sahibi').val();
		var durum = $('#durum').val();
		var tutar = $('#tutar').val();
		var iban = $('#iban').val();
		var aciklama = $('#aciklama').val();
		var paranin_geldigi_tarih = $('#paranin_geldigi_tarih').val();
		var bloke_tarihi = $('#bloke_tarihi').val();
		var mahsup_tarihi = $('#mahsup_tarihi').val();
		var tahsil_tarihi = $('#tahsil_tarihi').val();
		var iade_tarihi = $('#iade_tarihi').val();
		var arac_kod_plaka = $('#arac_kod_plaka').val();
		var arac_detay = $('#arac_bilgisi').html();
		// var aciklama = $('#aciklama').html();
		if(hesap_sahibi!=undefined){
			var wordCount = hesap_sahibi.match(/(\w+)/g).length;
		}else{
			var wordCount=0;
		}
	
		if(uye_id!=""){  
			if(hesap_sahibi!=undefined && wordCount < 2){
				alert("Ad Soyad en az 2 kelime olmak zorundadır");
			}else{
				if(iban!=undefined && (iban.length < 24 || iban.length > 24)){
					alert("Iban 24 karakter olmalıdır");
				}else{
					jQuery.ajax({
						url: $baseUrl+'yeni_cayma_ekle.php',
						type: "POST",
						dataType: "JSON",
						data: {
							action:"cayma_duzenle",
							uye_id: uye_id,
							cayma_id: cayma_id,
							hesap_sahibi: hesap_sahibi,
							tutar: tutar,
							durum: durum,
							iban: iban,
							aciklama: aciklama,
							paranin_geldigi_tarih: paranin_geldigi_tarih,
							bloke_tarihi: bloke_tarihi,
							mahsup_tarihi: mahsup_tarihi,
							tahsil_tarihi: tahsil_tarihi,
							iade_tarihi: iade_tarihi,
							arac_kod_plaka: arac_kod_plaka,
							arac_detay: arac_detay,
						},
						success: function(data) {
							console.log(data);
							$('.success').removeClass('d-none').html(data);
							$('#duzenle_cayma').modal('toggle');
							localStorage.setItem("trigger","cayma_bedeli_tab");
							alert(data.message);  
							if(data.status == 200){
								window.location.href = "?modul=uyeler&sayfa=uye_duzenle&id="+uye_id;
							}
						},
						error: function(data) {
						   $('.error').removeClass('d-none').html(data);
							alert("Hata");  
						}
					});
				}
			}
		}else{
			alert("Ad Soyad en az 2 kelime olmak zorundadır");
		}
	} 
	

//Tarih Guncelle
$(document).ready(function(){
	$(document).on('click', '.view_guncelle', function(){
		var employee_id = $(this).attr("id");
		if(employee_id != '')
		{  
			$.post('sayfalar/uyeler/tarih_guncelle.php', {'id':employee_id}, function(response){
				$('#ihale_guncelle').html(response);
				$('#tarih_guncelle').modal('show')
			})
		}
	});
});


//İlan Favorileri
$(document).ready(function(){
     $(document).on('click', '.view_ilan_favorileri', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/ihaleler/ilan_favorileri.php', {'id':employee_id}, function(response){
                  $('#fav_ilan').html(response);
                  $('#ilan_fav').modal('show')
               })
          }
     });
});
//İlan Mesajları
$(document).ready(function(){
     $(document).on('click', '.view_ilan_mesajlari', function(){
          var employee_id = $(this).attr("id");
		  parcala=employee_id.split("_");
          if(employee_id != '')
          {  
               $.post('sayfalar/ihaleler/ilan_mesajlari.php', {'id':parcala[1]}, function(response){
                  $('#mesaj_ilan').html(response);
                  $('#ilan_mesaj').modal('show')
               })
          }
     });
});
$(document).ready(function(){
     $(document).on('click', '.view_ilan_teklifleri', function(){
          var employee_id = $(this).attr("id");
		  parcala=employee_id.split("_");
          if(employee_id != '')
          {  
               $.post('sayfalar/ihaleler/ilan_teklifleri.php', {'id':parcala[1]}, function(response){
                  $('#teklif_ilan').html(response);
                  $('#ilan_teklif').modal('show')
               })
          }
     });
});

// Üye Adına Teklif Ver
$(document).ready(function(){
     $(document).on('click', '.view_uyeye_teklif_ver', function(){
          var employee_id = $(this).attr("id");
		  parcala=employee_id.split("_");
          if(employee_id != '')
          {  
               $.post('sayfalar/uyeler/uyeye_teklif_ver.php', {'id':parcala[1]}, function(response){
                  $('#uyenin_teklifi').html(response);
                  $('#uyeye_teklif').modal('show')
               })
          }
     });
});



// İLAN Notları
$(document).ready(function(){
     $(document).on('click', '.view_ilan_notlari', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/ihaleler/notlari.php', {'id':employee_id}, function(response){
                  $('#ilanin_notlarini').html(response);
                  $('#ilan_notlari').modal('show')
               })
          }
     });
});
//İlan Süre Uzatma
$(document).ready(function(){
	$(document).on('click', '.view_secili_ilan_sure_uzat', function(){
		// var employee_id = $(this).attr("id");
		var array=[];
		$("input.chec:checked").each(function(){
			array.push($(this).val());
		});
		if(array != ''){  
			$.post('sayfalar/ihaleler/toplu_sure_uzat.php', {'secim':array}, function(response){
				$('#ilan_sure_uzat').html(response);
				$('#sure_uzat_ilan').modal('show')
			})
		}else{
			alert("İlan seçmelisiniz");
		}
     });
});

//Admin Mesajlar
$(document).ready(function(){
     $(document).on('click', '.view_ilan_admin_mesajlari', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {  
               $.post('sayfalar/mesajlar/admin_ilan_mesajlari.php', {'id':employee_id}, function(response){
                  $('#mesaj_ilan_admin').html(response);
                  $('#admin_ilan_mesaj').modal('show')
               })
          }
     });
});

