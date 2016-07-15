// ff-section-evoker

(function($){

	frslib.provide('frslib._classes');

	// class modalWindowColorLibraryColor
	frslib._classes.modalWindowColorSectionPickerConstructor =function(){

		var _ = {};
		_._className = 'modalWindowColorSectionPicker';
		_._sections = new Array();
		_._$modal = $('#ff-modal-section-picker');
		_._callback = null;
        _._status = 'closed';

        $(document).keyup(function(e) {
            if (e.keyCode == 27 && _._status == 'opened') {
                _.close();
            }
        });

		_.openMasonry = function(sectionId) {
			var $modal = _._$modal;

			var this_sectionList = '.ff-section-picker__list-' + sectionId + ' .ff-section-picker__list-inner';
			var $this_sectionList = $(this_sectionList);

			var $container = $this_sectionList.imagesLoaded( function() {
				$container.packery({
					itemSelector: this_sectionList + ' .ff-section-picker__list-item'
				});
			});

		}

		_.closeMasonry = function() {
			var $modal = _._$modal;

		}



		_.open = function( callback ){
            _._status = 'opened';
			_._callback = callback;
			$('#ff-modal-section-picker')
				.css('z-index', 9999)
				.css('opacity', '0')
				.css('display', 'block')
				.animate({opacity:1},500);

			var menuTitles = new Array();

			var $menuHtml = $('<div></div>');
			var $categoriesHtml = $('<div></div>');;

			for( var key in _._sections ) {
				var oneSection = _._sections[key ];

				if( $menuHtml == null || ( oneSection.menuId.length > 0 &&  $menuHtml.find('.ff-section-category-' + oneSection.menuId ).size() == 0 ) ) {
					var text = ('<div class="ff-section-picker__category  '+ 'ff-section-category-' + oneSection.menuId + '" data-menu-id="'+oneSection.menuId+'" ">'+ oneSection.menuTitle +'</div>');
					var categories = ('<div class="ff-section-picker__list ff-section-picker__list-'+oneSection.menuId+'"><div class="ff-section-picker__list__grid-sizer"></div><div class="ff-section-picker__list-inner"></div></div>');

					if( $menuHtml == null ) {
						$menuHtml = $(text + 'a');


					} else {
						$menuHtml.append(text);
					}

					if( $categoriesHtml == null ) {
						$categoriesHtml = $(categories);
					} else {
						$categoriesHtml.append( categories );
					}
				}
			}

			_._$modal.find('.ff-section-picker__categories').html( $menuHtml.html() );



			for( var key in _._sections ) {

				var oneSection = _._sections[key ];

				if( oneSection.menuId.length > 0  ) {
					var oneItem = '';
					var activeClass = '';
					if( key == 0 ) {
						//activeClass = ' ff-section-picker__list-item--active ';
					}
					oneItem += '<div class="ff-section-picker__list-item'+activeClass+'" data-section-id="'+oneSection.sectionId+'">';
					oneItem += '<img class="ff-section-picker__list-item__image" src="'+oneSection.sectionImage+'" alt="">';
					oneItem += '<div class="ff-section-picker__list-item__name">'+oneSection.sectionName+'</div>';
					oneItem += '</div>';

					$categoriesHtml.find('.ff-section-picker__list-'+oneSection.menuId+' .ff-section-picker__list-inner').append(oneItem);
				}
			}


			_._$modal.find('.ff-section-picker__list').remove();

			_._$modal.find('.ff-section-picker__categories').after( $categoriesHtml.html() );

			var firstMenuId = _._$modal.find('.ff-section-picker__categories').find('.ff-section-picker__category:first').attr('data-menu-id');

			_._$modal.find('.ff-section-picker__list').css('display', 'none');
			_._$modal.find('.ff-section-picker__list-'+firstMenuId).css('display', 'block');

			_._$modal.find('.ff-section-picker__category:first').addClass('ff-section-picker__category--active');

			//ff-section-picker__category--active
			//console.log( firstMenuId );

			// ff-section-picker__list ff-section-picker__list-
			_.openMasonry();

			// Fix packery
			window.setTimeout(function(){
				$('#ff-modal-section-picker .ff-section-picker__category:first').click();
			}, 100);

		};

		_.clean = function() {
			_._sections = new Array();
			_._callback = null;
		};

		_.close = function(){
            _._status = 'closed';
			$('#ff-modal-section-picker')
				.css('z-index', 9999)
				.animate({opacity:0},500, function(){
					$(this).css('display', 'none');
				});
			_.clean();

			_.closeMasonry();
		};


		_.addOneSection = function( sectionData ) {
			_._sections.push(sectionData);
		}

		_.changeSection = function( sectionId, $menuClicked ) {
			_._$modal.find('.ff-section-picker__category').removeClass('ff-section-picker__category--active');
			$menuClicked.addClass('ff-section-picker__category--active');

			_._$modal.find('.ff-section-picker__list').css('display','none');
			_._$modal.find('.ff-section-picker__list-'+sectionId).css('display', 'block');
			// ff-section-picker__category
			if (! _._$modal.find('.ff-section-picker__list-'+sectionId).hasClass('ff-section-picker__list--packery-initialized--yes')){
				_.openMasonry(sectionId);
			}
			_._$modal.find('.ff-section-picker__list-'+sectionId).addClass('ff-section-picker__list--packery-initialized--yes')


		}


		$(document).on('click', '.ff-section-picker__list-item', function(){
			var sectionId = $(this).attr('data-section-id');

			_._callback( sectionId );
			_.close();

		});

		$(document).on('click', '.ff-section-picker__category', function(){
			_.changeSection( $(this).attr('data-menu-id'), $(this) );
		});

		$('#ff-modal-section-picker .ff-submit-library-button').css('display', 'none');

		$(document).on('click', '#ff-modal-section-picker .ff-cancel-library-button', function(){
			_.close()
		});

		$(document).on('click', '#ff-modal-section-picker .media-modal-close', function(){
			_.close()
		});


		$('.media-modal-backdrop').click(function(){
			_.close();
		});

		return _;
	};


	frslib._classes.modalWindowColorSectionPicker = frslib._classes.modalWindowColorSectionPickerConstructor();

	//var test = new frslib._classes.modalWindowColorLibraryColor();
	//test.alert();
})(jQuery);







(function($){

	$(document).ready(function(){
		$('.ff-section-evoker').click(function(){
			frslib._classes.modalWindowColorSectionPicker.open();
		});
	});


})(jQuery);