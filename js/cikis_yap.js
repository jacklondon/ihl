	function cikis_yap(token){
			
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				data: {
					action: "cikis_yap",
					token: token,
				},success: function(response) {
					//console.log(response);
				
				}
			});
		}
	function bildirim_sms(){
		
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			data: {
				action: "ihale_bildirim_sms",
			},success: function(response) {
				//console.log(response);
			
			}
		});
	}
	/*function cikis_yap2(token){
			
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				data: {
					action: "cikis_yap_2",
					token: token,
				},success: function(response) {
					//console.log(response);
				
				}
			});
		}

	
	function cikis_baslat(tkn){
		jQuery(document).ready(function() {		
			var validNavigation = false;
			document.onkeydown = fkey;
			document.onkeypress = fkey
			document.onkeyup = fkey;
			function fkey(e){
				e = e || window.event;
				if( validNavigation ) return; 
				if (e.keyCode != "") {
					validNavigation = true;
				}else {
				   
				}
			}


			$(document).on("keyup", this, function (event) {
				if (event.keyCode == 13) {
					console.log(event.keyCode);
				validNavigation = true;
				}
			});
			$(document).on("keydown", this, function (event) {
				if (event.keyCode == 13) {
					console.log(event.keyCode);
				validNavigation = true;
				}
			});
			
			$("a").bind("click", function() {
				validNavigation = true;
			
			});


			$("form").bind("submit", function() {
				validNavigation = true;
			});

			$("input[type=submit]").bind("click", function() {
				validNavigation = true;
			}); 
			$("input[type=button]").bind("click", function() {
				validNavigation = true;
			}); 
			$("button[type=button]").bind("click", function() {
				validNavigation = true;
			}); 
			$("button[type=submit]").bind("click", function() {
				validNavigation = true;
			}); 
		  
			$(window).bind('beforeunload', function(){	              
				if (!validNavigation) {  							
					cikis_yap2(tkn);
				}
			});
			$(window).bind('unload', function(){	              
				if (!validNavigation) {  							
					cikis_yap2(tkn);
				} 
			});
        });
	}*/
	function son_islem(tokenn){
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			data: {
				action: "son_islem",
				token: tokenn,
			},success: function(response) {
				//console.log(response);
			}
		});
	}
	function son_islem_guncelle(tknn){
		jQuery(document).ready(function() {	
			$("a").bind("click", function() {
				son_islem(tknn); 
			});
			$("form").bind("submit", function() {
				son_islem(tknn);
			});
			$("input[type=submit]").bind("click", function() {
				son_islem(tknn);
			}); 
			$("input[type=button]").bind("click", function() {
				son_islem(tknn);
			}); 
			$("button[type=button]").bind("click", function() {
				son_islem(tknn);
			}); 
			$("button[type=submit]").bind("click", function() {
				son_islem(tknn);
			});
		 });
	}