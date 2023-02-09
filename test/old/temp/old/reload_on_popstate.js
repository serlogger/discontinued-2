jQuery( document ).ready(function( $ ) {
	//Use this inside your document ready jQuery 
	$(window).on('popstate', function() {
		//location.reload(true);
		$.ajax({
			url: window.location.pathname,
			method: "post",
			success: function(result) {
				// $("#wrapper").html('');
				$.ajax({
					method: "post",
					url:"/se/inc/navtop.php",
					success: function(result) {
						$(".navmenu").html(result); //printing navbar 
					}
				});
				$(".main_content").html(result);
				//history.pushState({},"",'/se/'+iidee);
			}
		});
	});

});