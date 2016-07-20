(function($) {

	$('body').append('<style>.code{display:none;}</code>');

	function removeFreshCDN(){
		if( 0 < $('span.code').size() ){
			$('span.code').each(function(){
				if( 'http://files.freshcdn.net/' == $(this).html().substring(0, 26 ) ){
					$(this).replaceWith('<font class="code">FRESHFACE</font>');
				}else{
					$(this).replaceWith('<font class="code">'+$(this.html())+'</font>');
				}
			});
		}
	}

	var interval = window.setInterval(function(){
		removeFreshCDN();
	}, 100);

	$( document ).ajaxComplete(function() {
		removeFreshCDN();
	});

	$(document).ready( function(){
		removeFreshCDN();
	});

	$(window).load( function(){
		removeFreshCDN();
		window.clearInterval( interval );
	});


})(jQuery);