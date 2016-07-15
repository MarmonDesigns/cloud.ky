/******************************************************************************/
/** Global fresh library object, used across all our plugins and others. Here we
/** assign sub-libraries, important for other our stuff. It also cooperates with
/** jquery
/******************************************************************************/
"use strict";

// Safari bugfix
Number.isNaN = Number.isNaN || function(value) {
    return typeof value === "number" && value !== value;
}
// Safari bugfix end

var frslib = frslib || {};
////////////////////////////////////////////////////////////////////////////////
// FROM GOOGle CLOSURE
////////////////////////////////////////////////////////////////////////////////
frslib.global = this;
frslib.isDef = function(val) {
	  return val !== undefined;
	};
frslib.exportPath_ = function(name, opt_object, opt_objectToExportTo) {
	  var parts = name.split('.');
	  var cur = opt_objectToExportTo || frslib.global;

	  // Internet Explorer exhibits strange behavior when throwing errors from
	  // methods externed in this manner.  See the testExportSymbolExceptions in
	  // base_test.html for an example.
	  if (!(parts[0] in cur) && cur.execScript) {
	    cur.execScript('var ' + parts[0]);
	  }

	  // Certain browsers cannot parse code in the form for((a in b); c;);
	  // This pattern is produced by the JSCompiler when it collapses the
	  // statement above into the conditional loop below. To prevent this from
	  // happening, use a for-loop and reserve the init logic as below.

	  // Parentheses added to eliminate strict JS warning in Firefox.
	  for (var part; parts.length && (part = parts.shift());) {
	    if (!parts.length && frslib.isDef(opt_object)) {
	      // last part and we have an object; use it
	      cur[part] = opt_object;
	    } else if (cur[part]) {
	      cur = cur[part];
	    } else {
	      cur = cur[part] = {};
	    }
	  }
};

frslib.provide = function( name ) {
	return frslib.exportPath_(name);
};
////////////////////////////////////////////////////////////////////////////////
// HTML FORMS
////////////////////////////////////////////////////////////////////////////////
frslib.provide('frslib.htmlforms');
(function($){
	frslib.htmlforms.writeValueToCode = function( $selector ) {
		$selector.find('input').each(function(){
			var val = $(this).val();
			$(this).attr('value', val);
			
			if( $(this).attr('type') == 'checkbox' ) {
				var checked = $(this).is(':checked');
				
				if( checked ) {
					$(this).attr('checked', 'checked');
				}
				else {
					$(this).prop('checked', false);
					$(this).removeAttr('checked');
				}
			}
		});
	}
})(jQuery);
////////////////////////////////////////////////////////////////////////////////
// CALLBACKS
////////////////////////////////////////////////////////////////////////////////
frslib.provide('frslib.callbacks');

(function($){
	//console.log(frslib['htmlforms']['writeValueToCode']);
	frslib.callbacks.functions = new Array();
	frslib.callbacks.addCallback = function( eventName, callback ) {
		frslib.provide('frslib.callbacks.functions.'+eventName);
		frslib.callbacks.functions[eventName] = new Array();
		frslib.callbacks.functions[eventName].push(callback);
	}
	
	frslib.callbacks.doCallback = function( eventName ) {
		if( !(eventName in frslib.callbacks.functions) ) {
			return false;
		}
		
		var newArguments = new Array();

		for( var argumentsKey in arguments ) {

			if( !Number.isNaN(argumentsKey) && argumentsKey > 0 ){
				newArguments[ argumentsKey-1 ] = arguments[ argumentsKey ];
			}
		}
		
		var output = {};
		
		for( var key in frslib.callbacks.functions[eventName] ) {
			output[key] = frslib.callbacks.functions[eventName][key].apply( this,newArguments);
		}
		
		return output;
	}
	
	frslib.callbacks.callAllFunctionsFromArray = function( arrayOfFunctions ) {
		var newArguments = Array();
		
		for( var argumentsKey in arguments ) {
			if( !Number.isNaN(argumentsKey) && argumentsKey > 0 ){
				newArguments[ argumentsKey-1 ] = arguments[ argumentsKey ];
			}
		}
		
		var oneFunction;
		if( arrayOfFunctions ){
			for( oneFunction in arrayOfFunctions ) {
				if( arrayOfFunctions[ oneFunction ] ){
					arrayOfFunctions[ oneFunction ].apply( this, newArguments );
				}
			}
		}
	}
})(jQuery);

////////////////////////////////////////////////////////////////////////////////
//COLORS
////////////////////////////////////////////////////////////////////////////////
frslib.provide('frslib.colors');
frslib.provide('frslib.colors.convert');
frslib.provide('frslib.colors.type');

(function($){
	frslib.colors.convert.hexToRgb = function(hex) {
	    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	    return result ? {
	        r: parseInt(result[1], 16),
	        g: parseInt(result[2], 16),
	        b: parseInt(result[3], 16)
	    } : null;
	};
	
	frslib.colors.convert.hslToRgb = function(h, s, l){

	    var r, g, b, m, c, x

	    if (!isFinite(h)) h = 0
	    if (!isFinite(s)) s = 0
	    if (!isFinite(l)) l = 0

	    h /= 60
	    if (h < 0) h = 6 - (-h % 6)
	    h %= 6

	    s = Math.max(0, Math.min(1, s / 100))
	    l = Math.max(0, Math.min(1, l / 100))

	    c = (1 - Math.abs((2 * l) - 1)) * s
	    x = c * (1 - Math.abs((h % 2) - 1))

	    if (h < 1) {
	        r = c
	        g = x
	        b = 0
	    } else if (h < 2) {
	        r = x
	        g = c
	        b = 0
	    } else if (h < 3) {
	        r = 0
	        g = c
	        b = x
	    } else if (h < 4) {
	        r = 0
	        g = x
	        b = c
	    } else if (h < 5) {
	        r = x
	        g = 0
	        b = c
	    } else {
	        r = c
	        g = 0
	        b = x
	    }

	    m = l - c / 2
	    r = Math.round((r + m) * 255)
	    g = Math.round((g + m) * 255)
	    b = Math.round((b + m) * 255)

	    return { r: r, g: g, b: b }

      };
	
	frslib.colors.convert.rgbToHsl = function (r, g, b){
	    r /= 255, g /= 255, b /= 255;
	    var max = Math.max(r, g, b), min = Math.min(r, g, b);
	    var h, s, l = (max + min) / 2;

	    if(max == min){
	        h = s = 0; // achromatic
	    }else{
	        var d = max - min;
	        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
	        switch(max){
	            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
	            case g: h = (b - r) / d + 2; break;
	            case b: h = (r - g) / d + 4; break;
	        }
	        h /= 6;
	    }

	    return  { h:Math.floor(h * 360), s:Math.floor(s * 100), b:Math.floor(l * 100) };
	};
	
	frslib.colors.convert.invalid ='color-is-invalid';
	
	frslib.colors.convert.toArray = function(color) {
		 
	    var cache
	      , p = parseInt // Use p as a byte saving reference to parseInt
	      , color = color.replace(/\s\s*/g,'') // Remove all spaces
	    ;//var
	    
	    var rgbaType = 0;
	    
	    // Checks for 6 digit hex and converts string to integer
	    if (cache = /^#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})/.exec(color)) 
	        cache = [p(cache[1], 16), p(cache[2], 16), p(cache[3], 16)];
	        
	    // Checks for 3 digit hex and converts string to integer
	    else if (cache = /^#([\da-fA-F])([\da-fA-F])([\da-fA-F])/.exec(color))
	        cache = [p(cache[1], 16) * 17, p(cache[2], 16) * 17, p(cache[3], 16) * 17];
	        
	    // Checks for rgba and converts string to
	    // integer/float using unary + operator to save bytes
	    else if (cache = /^rgba\(([\d]+),([\d]+),([\d]+),([\d]+|[\d]*.[\d]+)\)/.exec(color)) {
	        cache = [+cache[1], +cache[2], +cache[3], +cache[4]];
	        rgbaType = 1;
	    }
	        
	    // Checks for rgb and converts string to
	    // integer/float using unary + operator to save bytes
	    else if (cache = /^rgb\(([\d]+),([\d]+),([\d]+)\)/.exec(color))
	        cache = [+cache[1], +cache[2], +cache[3]];
	        
	    // Otherwise throw an exception to make debugging easier
	    else {
	    	return frslib.colors.convert.invalid;
	    } //throw Error(color + ' is not supported by $.parseColor');
	    
	    // Performs RGBA conversion by default
	    isNaN(cache[3]) && (cache[3] = 1);
	    
	    // Adds or removes 4th value based on rgba support
	    // Support is flipped twice to prevent erros if
	    // it's not defined
	    var parsedColor =  cache.slice(0,3 + rgbaType);
	    
	    var toReturn = {};
	    toReturn.r = parsedColor[0];
	    toReturn.g = parsedColor[1];
	    toReturn.b = parsedColor[2];
	    
	    if( rgbaType == 1 ) {
	    	toReturn.a = parsedColor[3];
	    } else {
	    	toReturn.a = 1;
	    }
	    
	    return toReturn;
	    
	}
	
	
	frslib.colors.type.rgba = 'rgba';
	frslib.colors.type.rgb = 'rgb';
	frslib.colors.type.hex = 'hex';
	
	
	frslib.colors.type.identify = function( colorValue ) {
		if( colorValue.toLowerCase().indexOf('rgba') != -1 ) {
			return frslib.colors.type.rgba;
		} else if( colorValue.toLowerCase().indexOf('rgb') != -1 ) {
			return frslib.colors.type.rgb;
		} else if( colorValue.indexOf('#') != -1 ) {
			return frslib.colors.type.hex;
		}
	};

	frslib.colors.convert.rgbToHex = function (r,g,b) {
		 var rgb =b  | (g << 8) | ( r << 16);
	      return '#' + (0x1000000 + rgb).toString(16).slice(1)
	};
	
	
 
 
})(jQuery);
////////////////////////////////////////////////////////////////////////////////
//AJAX
////////////////////////////////////////////////////////////////////////////////
frslib.provide('frslib.ajax');

(function($){
	frslib.ajax.frameworkRequest = function( owner, specification, data, callback ) {
		$.post(
				ajaxurl,
				{
					'action':'ff_ajax',
					'owner': owner,
					'specification':specification,
					'data':data
				},
				callback
		);
	};
	
	frslib.ajax.adminScreenRequest = function( specification, data, callback ) {
		
		// ff-view-identification admin-screen-name admin-view-name
		var adminScreenName = $('.ff-view-identification').find('.admin-screen-name').html();
		var adminViewName =$('.ff-view-identification').find('.admin-view-name').html(); 
		
		var data = {
				'adminScreenName' : adminScreenName,
				'adminViewName' : adminViewName,
				'specification' : specification,
				'action' : 'ff_ajax_admin',
				'data' : data
		}
		
		$.post(
				ajaxurl,
				data,
				callback
		);
	}
	
	

})(jQuery);
////////////////////////////////////////////////////////////////////////////////
//CONTACT FORM VALIDATION
////////////////////////////////////////////////////////////////////////////////

frslib.provide('frslib.validator');

(function($){
	frslib.validator.email = function( value ) {
        var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
        return filter.test( value );
	}
})(jQuery);


frslib.provide('frslib.text');

(function($){
	
	$.fn.findButNotInside = function(selector) {
	    var origElement = $(this);
	    return origElement.find(selector).filter(function() {
	        var nearestMatch = $(this).parent().closest(selector);
	        return nearestMatch.length == 0 || origElement.find(nearestMatch).length == 0;
	    });
	};
	
})(jQuery);

(function($){
	frslib.text.onlyAlphaNumeric = function( toReplace ) {
		return toReplace.replace(/[^a-z0-9 ]/gi,'');
	};
})(jQuery);
/*!
 * jquery.base64.js 0.0.3 - https://github.com/yckart/jquery.base64.js
 * Makes Base64 en & -decoding simpler as it is.
 *
 * Based upon: https://gist.github.com/Yaffle/1284012
 *
 * Copyright (c) 2012 Yannick Albert (http://yckart.com)
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 * 2013/02/10
 **/
;(function($) {

    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
        a256 = '',
        r64 = [256],
        r256 = [256],
        i = 0;

    var UTF8 = {

        /**
         * Encode multi-byte Unicode string into utf-8 multiple single-byte characters
         * (BMP / basic multilingual plane only)
         *
         * Chars in range U+0080 - U+07FF are encoded in 2 chars, U+0800 - U+FFFF in 3 chars
         *
         * @param {String} strUni Unicode string to be encoded as UTF-8
         * @returns {String} encoded string
         */
        encode: function(strUni) {
            // use regular expressions & String.replace callback function for better efficiency
            // than procedural approaches
            var strUtf = strUni.replace(/[\u0080-\u07ff]/g, // U+0080 - U+07FF => 2 bytes 110yyyyy, 10zzzzzz
            function(c) {
                var cc = c.charCodeAt(0);
                return String.fromCharCode(0xc0 | cc >> 6, 0x80 | cc & 0x3f);
            })
            .replace(/[\u0800-\uffff]/g, // U+0800 - U+FFFF => 3 bytes 1110xxxx, 10yyyyyy, 10zzzzzz
            function(c) {
                var cc = c.charCodeAt(0);
                return String.fromCharCode(0xe0 | cc >> 12, 0x80 | cc >> 6 & 0x3F, 0x80 | cc & 0x3f);
            });
            return strUtf;
        },

        /**
         * Decode utf-8 encoded string back into multi-byte Unicode characters
         *
         * @param {String} strUtf UTF-8 string to be decoded back to Unicode
         * @returns {String} decoded string
         */
        decode: function(strUtf) {
            // note: decode 3-byte chars first as decoded 2-byte strings could appear to be 3-byte char!
            var strUni = strUtf.replace(/[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g, // 3-byte chars
            function(c) { // (note parentheses for precence)
                var cc = ((c.charCodeAt(0) & 0x0f) << 12) | ((c.charCodeAt(1) & 0x3f) << 6) | (c.charCodeAt(2) & 0x3f);
                return String.fromCharCode(cc);
            })
            .replace(/[\u00c0-\u00df][\u0080-\u00bf]/g, // 2-byte chars
            function(c) { // (note parentheses for precence)
                var cc = (c.charCodeAt(0) & 0x1f) << 6 | c.charCodeAt(1) & 0x3f;
                return String.fromCharCode(cc);
            });
            return strUni;
        }
    };

    while(i < 256) {
        var c = String.fromCharCode(i);
        a256 += c;
        r256[i] = i;
        r64[i] = b64.indexOf(c);
        ++i;
    }

    function code(s, discard, alpha, beta, w1, w2) {
        s = String(s);
        var buffer = 0,
            i = 0,
            length = s.length,
            result = '',
            bitsInBuffer = 0;

        while(i < length) {
            var c = s.charCodeAt(i);
            c = c < 256 ? alpha[c] : -1;

            buffer = (buffer << w1) + c;
            bitsInBuffer += w1;

            while(bitsInBuffer >= w2) {
                bitsInBuffer -= w2;
                var tmp = buffer >> bitsInBuffer;
                result += beta.charAt(tmp);
                buffer ^= tmp << bitsInBuffer;
            }
            ++i;
        }
        if(!discard && bitsInBuffer > 0) result += beta.charAt(buffer << (w2 - bitsInBuffer));
        return result;
    }

    var Plugin = $.base64 = function(dir, input, encode) {
            return input ? Plugin[dir](input, encode) : dir ? null : this;
        };

    Plugin.btoa = Plugin.encode = function(plain, utf8encode) {
        plain = Plugin.raw === false || Plugin.utf8encode || utf8encode ? UTF8.encode(plain) : plain;
        plain = code(plain, false, r256, b64, 8, 6);
        return plain + '===='.slice((plain.length % 4) || 4);
    };

    Plugin.atob = Plugin.decode = function(coded, utf8decode) {
        coded = coded.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        coded = String(coded).split('=');
        var i = coded.length;
        do {--i;
            coded[i] = code(coded[i], true, r64, a256, 6, 8);
        } while (i > 0);
        coded = coded.join('');
        return Plugin.raw === false || Plugin.utf8decode || utf8decode ? UTF8.decode(coded) : coded;
    };
}(jQuery));


 jQuery.fn.serializeObject = function() {
 var json = {};
  jQuery.map(jQuery(this).serializeArray(), function(n, i) {
    var _ = n.name.indexOf('[');
    if (_ > -1) {
      var o = json;
      var _name = n.name.replace(/\]/gi, '').split('[');
      for (var i=0, len=_name.length; i<len; i++) {
        if (i == len-1) {
          if (o[_name[i]]) {
            if (typeof o[_name[i]] == 'string') {
              o[_name[i]] = [o[_name[i]]];
            }
            o[_name[i]].push(n.value);
          }
          else o[_name[i]] = n.value || '';
        }
        else o = o[_name[i]] = o[_name[i]] || {};
      }
    }
    else {
      if (json[n.name] !== undefined) {
        if (!json[n.name].push) {
          json[n.name] = [json[n.name]];
        }
        json[n.name].push(n.value || '');
      }
      else json[n.name] = n.value || '';
    }
  });
  return json;
};

/*
 * jQuery.bind-first library v0.2.3
 * Copyright (c) 2013 Vladimir Zhuravlev
 *
 * Released under MIT License
 * @license
 *
 * Date: Thu Feb  6 10:13:59 ICT 2014
 **/

(function($) {
	var splitVersion = $.fn.jquery.split(".");
	var major = parseInt(splitVersion[0]);
	var minor = parseInt(splitVersion[1]);

	var JQ_LT_17 = (major < 1) || (major == 1 && minor < 7);

	function eventsData($el) {
		return JQ_LT_17 ? $el.data('events') : $._data($el[0]).events;
	}

	function moveHandlerToTop($el, eventName, isDelegated) {
		var data = eventsData($el);
		var events = data[eventName];

		if (!JQ_LT_17) {
			var handler = isDelegated ? events.splice(events.delegateCount - 1, 1)[0] : events.pop();
			events.splice(isDelegated ? 0 : (events.delegateCount || 0), 0, handler);

			return;
		}

		if (isDelegated) {
			data.live.unshift(data.live.pop());
		} else {
			events.unshift(events.pop());
		}
	}

	function moveEventHandlers($elems, eventsString, isDelegate) {
		var events = eventsString.split(/\s+/);
		$elems.each(function() {
			for (var i = 0; i < events.length; ++i) {
				var pureEventName = $.trim(events[i]).match(/[^\.]+/i)[0];
				moveHandlerToTop($(this), pureEventName, isDelegate);
			}
		});
	}

	function makeMethod(methodName) {
		$.fn[methodName + 'First'] = function() {
			var args = $.makeArray(arguments);
			var eventsString = args.shift();

			if (eventsString) {
				$.fn[methodName].apply(this, arguments);
				moveEventHandlers(this, eventsString);
			}

			return this;
		}
	}

	// bind
	makeMethod('bind');

	// one
	makeMethod('one');

	// delegate
	$.fn.delegateFirst = function() {
		var args = $.makeArray(arguments);
		var eventsString = args[1];

		if (eventsString) {
			args.splice(0, 2);
			$.fn.delegate.apply(this, arguments);
			moveEventHandlers(this, eventsString, true);
		}

		return this;
	};

	// live
	$.fn.liveFirst = function() {
		var args = $.makeArray(arguments);

		// live = delegate to the document
		args.unshift(this.selector);
		$.fn.delegateFirst.apply($(document), args);

		return this;
	};

	// on (jquery >= 1.7)
	if (!JQ_LT_17) {
		$.fn.onFirst = function(types, selector) {
			var $el = $(this);
			var isDelegated = typeof selector === 'string';

			$.fn.on.apply($el, arguments);

			// events map
			if (typeof types === 'object') {
				for (type in types)
					if (types.hasOwnProperty(type)) {
						moveEventHandlers($el, type, isDelegated);
					}
			} else if (typeof types === 'string') {
				moveEventHandlers($el, types, isDelegated);
			}

			return $el;
		};
	}

})(jQuery);