/**
 * jQuery Unveil
 * A very lightweight jQuery plugin to lazy load images
 * http://luis-almeida.github.com/unveil
 *
 * Licensed under the MIT license.
 * Copyright 2013 Luís Almeida
 * https://github.com/luis-almeida
 */

// Partialy changed


		// $(".unveil").unveil(1000).load(function() {
		//     var self = $(this);
		//     if(self.attr('src') == self.data('src')){
		//         self.addClass('unveiled');
		//     }
		// });

;(function($) {

	$.fn.unveil = function(threshold, callback) {

		var $w = $(window),
			th = threshold || 0,
			retina ,
			attrib ,
			images = this,
			loaded;

		// http://stackoverflow.com/questions/19689715/what-is-the-best-way-to-detect-retina-support-on-a-device-using-javascript
		function isRetinaDisplay() {
			if (window.matchMedia) {
				var mq = window.matchMedia("only screen and (min--moz-device-pixel-ratio: 1.3), only screen and (-o-min-device-pixel-ratio: 2.6/2), only screen and (-webkit-min-device-pixel-ratio: 1.3), only screen  and (min-device-pixel-ratio: 1.3), only screen and (min-resolution: 1.3dppx)");
				if (mq && mq.matches || (window.devicePixelRatio > 1)) {
					return true;
				} else {
					return false;
				}
			}
			return false;
		}

		retina = isRetinaDisplay();

		this.one("unveil", function() {
			attrib = retina? "data-src-retina" : "data-src";
			if( $(this).hasClass('unveiled') ){
				return;
			}
			var source = $(this).attr( attrib );
			if( source ) {
				;
			} else{
				source = this.getAttribute("data-src");
				attrib = 'data-src';
			}
			if (source) {
				$('img.unveil['+attrib+'="'+source+'"]').attr("src", source);
				$('.unveil:not(img)['+attrib+'="'+source+'"]').css("background-image", "url('" + source + "')" );
				// $(':not(img)['+attrib+'="'+source+'"]').css("background-image", "attr("+attrib+" url)" );
				$('.unveil['+attrib+'="'+source+'"]').addClass('unveiled');
				if (typeof callback === "function") callback.call(this);
			}
		});

		function unveil() {
			var inview = images.filter(function() {
				var $e = $(this);
				// if ($e.is(":hidden")) return;

				var wt = $w.scrollTop(),
				wb = wt + $w.height(),
				et = $e.offset().top,
				eb = et + $e.height();

				return eb >= wt - th && et <= wb + th;
			});

			loaded = inview.trigger("unveil");
			images = images.not(loaded);
		}

		$w.on("scroll.unveil resize.unveil lookup.unveil", unveil);

		unveil();

		return this;

	};

})(jQuery);