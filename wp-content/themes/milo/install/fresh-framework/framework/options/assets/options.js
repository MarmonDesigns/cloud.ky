jQuery(document).ready(function($){
	return;
/******************************************************************************/
/** REPEATABLE 
/******************************************************************************/
	var repeatable_plus_button = '.ff-repeatable-add';
	var repeatable_parent = '.ff-repeatable';
	var repeatable_template = '.ff-repeatable-template';

	var repeatable_button_remove = '.ff-repeatable-remove';
	var repeatable_button_clone = '.ff-repeatable-duplicate';
	var repeatable_button_close = '.ff-repeatable-handle';
	var repeatable_button_drag = '.ff-repeatable-drag';
	$(repeatable_template).css('display', 'none');
	
	
/******************************************************************************/
/** HOVERS
/******************************************************************************/	
	// li.ff-repeatable-add-hover
	// li.ff-repeatable-remove-hover
	// li.ff-repeatable-duplicate-hover
	// li.ff-repeatable-drag-hover
	// li.ff-repeatable-handle-hover	
	
	
	
		$(repeatable_button_remove).live('mouseenter', function() { 
			$(this).parents('.ff-repeatable-item:first').addClass('ff-repeatable-remove-hover');
		}).live('mouseleave', function () {
			$(this).parents('.ff-repeatable-item:first').removeClass('ff-repeatable-remove-hover');	
		});
		
		
		$(repeatable_plus_button).live('mouseenter', function() { 
			$(this).parents('.ff-repeatable-item:first').addClass('ff-repeatable-add-hover');
		}).live('mouseleave', function () {
			$(this).parents('.ff-repeatable-item:first').removeClass('ff-repeatable-add-hover');	
		});
		
		
		$(repeatable_button_clone).live('mouseenter', function() { 
			$(this).parents('.ff-repeatable-item:first').addClass('ff-repeatable-duplicate-hover');
		}).live('mouseleave', function () {
			$(this).parents('.ff-repeatable-item:first').removeClass('ff-repeatable-duplicate-hover');	
		});		
		
		$(repeatable_button_close).live('mouseenter', function() { 
			$(this).parents('.ff-repeatable-item:first').addClass('ff-repeatable-handle-hover');
		}).live('mouseleave', function () {
			$(this).parents('.ff-repeatable-item:first').removeClass('ff-repeatable-handle-hover');	
		});		
		
		
/******************************************************************************/
/** HOVERS END
/******************************************************************************/	
	
	// ADDING NEW SECTION
	$( repeatable_plus_button ).live('click', function(){
		// FOR REPEATABLE VARIABLE SECTION
		if( $(this).parents('.ff-repeatable-item:first').attr('data-section-id') != undefined) {
			var template_name = $(this).parents('.ff-repeatable-item:first').attr('data-section-id');
			var $parent = $(this).parents( repeatable_parent ).eq(0);
			var $template = $parent.find('.ff-repeatable-template[data-section-id="'+template_name+'"]');
			
		// FOR REPEATABLE CLASSIC SECTION
		} else {
			var $parent = $(this).parents( repeatable_parent ).eq(0);
			var $template = $parent.find( repeatable_template );
		}
		
		var $newItem = $($template.html());
		$newItem.hide();
		$(this).parents('.ff-repeatable-item:first').after( $newItem );
		$newItem.animate({ height: 'toggle' }, 200);
		$( '.ff-repeatable').sortable({handle:repeatable_button_drag});
		
		return false;
	});
	
	$('.ff-repeatable-controls').live('click', function(){
		return false;
	});
	
	
	$(repeatable_button_remove).live('click', function(){
		var $parent = $(this).parents('.ff-repeatable-item:first');
		$parent.animate({ height: 'toggle', opacity: 'toggle' }, 500, function(){
			$parent.remove();
		});
		//$(this).parents('.ff-repeatable-item:first').remove();
	});
	
	$(repeatable_button_clone).live('click', function() {
		var $parent = $(this).parents('.ff-repeatable-item:first');
		$parent.find('input').each(function(){
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
		
		var $newItem = $parent.clone();
		
		$newItem.removeClass('ff-repeatable-item-opened').addClass('ff-repeatable-item-closed').find('.ff-repeatable-content').css('display','none');
		
		$newItem.find('.ff-select2-wrapper').each(function(i,o){
			
			var shadow_html = $(o).find('.ff-select2-shadow-wrapper').html();
			
			console.log( shadow_html );
			$(o).find('.ff-select2-real-wrapper').html( shadow_html );
			
			$(o).find(".ff-select2-real-wrapper .ff-select2").select2({
				 containerCssClass : "ff-select2",
		         dropdownCssClass: "ff-select2",
			});
			
		});
		//$parent.after( $newItem);
		
		$parent.after( $newItem );
		$newItem.hide();
		$newItem.animate({ height: 'show', opacity: 'show' }, 200);
	});
	
	
	$(repeatable_button_close).live('click', function( e ){
		
		var speed = 200;
		//alert( 'click');
		
		var $parent = $(this).parents('.ff-repeatable-item:first');
		
		//alert(  $parent.hasClass('ff-repeatable-item-opened') );
		// must only close this and all siblings
		if( $parent.hasClass('ff-repeatable-item-opened') ) {
			
			$parent.find('.ff-repeatable-content:first').slideUp(speed, function() {
				$parent.removeClass('ff-repeatable-item-opened');
				$parent.addClass('ff-repeatable-item-closed');
			});
			
			 
			
			//$parent.find('.ff-repeatable-content').slideUp(1000);
			//$parent.find('.ff-repeatable-content').hide();
			//$parent.siblings( '.ff-repeatable-item').find('.ff-repeatable-content').toggle(false);
			//$parent.removeClass('ff-repeatable-item-opened');
			//$parent.addClass('ff-repeatable-item-closed');
			
			
			//$parent.siblings( '.ff-repeatable-item').find('.ff-repeatable-content').slideUp(1000);
			//$parent.siblings( '.ff-repeatable-item').removeClass('ff-repeatable-item-opened').addClass('ff-repeatable-item-closed');
			
		}  else {
			$parent.find('.ff-repeatable-content:first').slideDown(speed, function() {
				$parent.removeClass('ff-repeatable-item-closed');
				$parent.addClass('ff-repeatable-item-opened');
			});
			
			var $siblings = $parent.siblings( '.ff-repeatable-item');
			
			$siblings.find('.ff-repeatable-content').slideUp(speed, function() {
				$siblings.removeClass('ff-repeatable-item-opened');
				$siblings.addClass('ff-repeatable-item-closed');
			});
			
			//$parent.find('.ff-repeatable-content').slideDown(1000);
			//$parent.removeClass('ff-repeatable-item-closed');
			
			//$parent.addClass('ff-repeatable-item-opened');
			
			//$parent.siblings( '.ff-repeatable-item').find('.ff-repeatable-content').slideUp(1000);
			//$parent.siblings( '.ff-repeatable-item').removeClass('ff-repeatable-item-closed').addClass('ff-repeatable-item-opened');
			
			//$parent.find('.ff-repeatable-content').show();
			
			//$parent.siblings( '.ff-repeatable-item').find('.ff-repeatable-content').toggle(false);
		}
		return false;
		/*var $parent = $(this).parents('.ff-repeatable-item:first');
		
		if( $parent.hasClass( 'ff-repeatable-open' ) ) {
			$parent.removeClass('ff-repeatable-open');
			$parent.siblings( '.ff-repeatable-item').find('.ff-repeatable-content').toggle(false);
			$parent.find('.ff-repeatable-content').stop().slideToggle(1000);
			
			
		} else {
			$parent.addClass('ff-repeatable-open');
			$parent.find('.ff-repeatable-content').stop().slideToggle(1000);
		}
		
		//$parent.find('.ff-repeatable-content').stop().slideToggle(1000); */
	});
	
	$( '.ff-repeatable').sortable({handle:repeatable_button_drag});
	
	
	
	
	$('#ff-submit').click(function(){
		$(this).parents('form:first').find('.ff-repeatable-template').remove();
		//$(this).parents('form:first').find('.ff-repeatable-item')
		//console.log($(this).parents('form:first').serialize());
		//return false;
		//return false;
		
		var $form = $('.ff-repeatable').parents('form:first');
		
		
		var number_of_sections = $form.find('.ff-repeatable').size();
		
		$('.ff-repeatable').find('input').each(function(){
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
		
		
		for( var i = 0; i < number_of_sections; i++) {
			var $repeat = $form.find('.ff-repeatable:eq('+i+')');
			
			var currentLevel = $repeat.attr('data-current-level');
			
			var toReplace = '-_-'+currentLevel+'-TEMPLATE-_-';
			
			var indexCounter = 0;
			
			$repeat.children('.ff-repeatable-item').each(function(){
				var replaced = $(this).clone().outerHtml().replace( new RegExp( toReplace,'g'), indexCounter);
				$(this).outerHtml( replaced );
				indexCounter++;
			});
		}
		
		if( $('.ffsend').is(':checked')) {
			
		} else {
			return false;
		}
	});
});

(function($) {
	  'use strict';
	  
	  
	  var hasNativeOuterHTML = !!('outerHTML' in $('<div></div>').get(0));
	  
	  // Prefer the native `outerHTML` property when possible
	  var getterFn = function() {
	    var target = this.get(0);

	    // If the browser supports the `outerHTML` property on elements AND if `target` is an element node
	    if (hasNativeOuterHTML && target.nodeType === 1) {
	      return target.outerHTML;
	    }
	    else {
	      return $('<div></div>').append(this.eq(0).clone()).html();
	    }
	  };
	  
	  var setterFn = function(value) {
	    // Do not attempt to replace anything using the native `outerHTML` property setter
	    // even if it exists: it is riddled with bugs!
	    return $('<div id="jquery-outerHtml-transformer"></div>').append(value).contents().replaceAll(this);
	  };

	  // Detect jQuery 1.8.x bug (for which the value here is `false`)
	  var doesNotLeaveTempParentOnDetachedDomElement = true;

	  $.fn.outerHtml = function(value) {
	    if (arguments.length) {
	      if (doesNotLeaveTempParentOnDetachedDomElement) {
	        return setterFn.call(this, value);
	      }
	      else {
	        // Fix for jQuery 1.8.x bug: https://github.com/JamesMGreene/jquery.outerHtml/issues/1
	        var parentsOfThis = (function() {
	          var parents = new Array(this.length);
	          this.each(function(i) {
	            parents[i] = this.parentNode || null;
	          });
	          return parents;
	        }).call(this);
	        
	        return setterFn.call(this, value).map(function(i) {
	          if (!parentsOfThis[i]) {
	            if (this.parentNode) {
	              return this.parentNode.removeChild(this);
	            }
	          }
	          else if (parentsOfThis[i] !== this.parentNode) {
	            // Appending to the end: this doesn't seem right but it should cover the detached DOM scenarios
	            return parentsOfThis[i].appendChild(this);
	          }
	          return this;
	        });
	      }
	    }
	    else {
	      return getterFn.call(this);
	    }
	  };
	  
	  // Detect jQuery 1.8.x bug (for which the value here is `false`)
	  doesNotLeaveTempParentOnDetachedDomElement = (function() {
	    var parent = $('<s>bad</s>').outerHtml('<div>good</div>').get(0).parentNode;
	    return (parent.nodeName === '#document-fragment' && parent.nodeType === 11);
	  })();

	}(jQuery));