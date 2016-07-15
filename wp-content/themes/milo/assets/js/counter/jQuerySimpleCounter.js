/*
 *	SimpleCounter
 *	http://www.jqueryscript.net/time-clock/Lightweight-jQuery-Animated-Counter-Plugin.html
 */
!function(t){t.fn.jQuerySimpleCounter=function(n){var e=t.extend({start:0,end:100,easing:"swing",duration:400,complete:""},n),i=t(this);t({count:e.start}).animate({count:e.end},{duration:e.duration,easing:e.easing,step:function(){var t=Math.ceil(this.count);i.text(t)},complete:e.complete})}}(jQuery);