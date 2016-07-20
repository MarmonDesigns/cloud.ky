(function($){
	
	frslib.provide('frslib._classes');

	// class modalWindowColorLibraryColor
	frslib._classes.modalWindowColorLibraryColor =function(){

		var _this_ = {};
		_._className = 'modalWindowColorLibraryColor';

		// Propeties
		_this_.selectors = {
			$currentSelectedColor : ''
		};
		
		_this_.colors = {
			hex : '',
			rgb : { r:0, g:0, b:0},
			opacity: 1,
			rgba : ''
		};
		
		_this_.description = {
			id : '',
			name : '',
			tags : '',
			type : '',
			group : '',
		};
 
		_this_.init = function(){

		};
		
		_this_.getOnlyData = function() {
			var data = {};
			data.description = _this_.description;
			data.colors = _this_.colors;
			return data;
		};

		// Methods
		_this_.setColor = function( color ) {
			var rgbaArray = frslib.colors.convert.toArray( color );			
			_this_.colors.hex = frslib.colors.convert.rgbToHex( rgbaArray.r, rgbaArray.g, rgbaArray.b );
			_this_.colors.rgb.r = rgbaArray.r;
			_this_.colors.rgb.g = rgbaArray.g;
			_this_.colors.rgb.b = rgbaArray.b;
			
			_this_.colors.rgba = 'rgba('+rgbaArray.r+','+rgbaArray.g+','+rgbaArray.b+','+rgbaArray.a+')';
			
			_this_.colors.opacity = rgbaArray.a;
		};
		
		_this_.setOpacity = function( opacity ) {
			var rgb = _this_.colors.rgb;
			_this_.colors.rgba = 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+opacity+')';
			_this_.colors.opacity = opacity;
		}
		
		_this_.getColorWeb = function( color ) {
			if( _this_.colors.opacity == 1 ) {
				return _this_.colors.hex;
			} else {
				return _this_.colors.rgba;
			}
		};
		
		_this_.setId = function ( id ) {
			this.description.id = id;
		};
		
		_this_.setName = function( name ) {
			_this_.description.name = name;
		};
		
		_this_.setTags = function( tags ) {
			_this_.description.tags = tags;
		};
		
		_this_.setType = function( type ) {
			_this_.description.type = type;
		};
		
		
		_this_.setId = function( id ) {
			_this_.description.id = id;
		};
		
		_this_.setCurrentSelector = function( $selector ) {
			_this_.selectors.$currentSelectedColor = $selector;
		};
		
		_this_.gatherDataFromSelector = function() {
			$item = _this_.selectors.$currentSelectedColor;
			if( $item ){ } else{ return; }
			$itemInfo = $item.find('.ff-item-info');
			
			_this_.setName( $itemInfo.find('.ff-item-name').val() );
			_this_.setTags( $itemInfo.find('.ff-item-tags').val() );
			_this_.setType( $itemInfo.find('.ff-item-type').val() );
			_this_.setColor( $itemInfo.find('.ff-item-color').val() );
			_this_.description.group =  $itemInfo.find('.ff-item-group').val();
			
			if( _this_.description.type == 'system' ) {
				_this_.setId( _this_.description.name );
			} else {
				_this_.setId( $itemInfo.find('.ff-item-id').val() );
			}
		};
		
		_this_.writeDataToSelector = function() {
			$item = _this_.selectors.$currentSelectedColor;
			$item.find('.ff-modal-library-items-group-item-color').css('background-color', _this_.colors.rgba);
			
			$itemInfo = $item.find('.ff-item-info');
			
			$itemInfo.find('.ff-item-name').val( _this_.description.name );
			$itemInfo.find('.ff-item-tags').val( _this_.description.tags );
			$itemInfo.find('.ff-item-type').val( _this_.description.type );
			$itemInfo.find('.ff-item-color').val( _this_.getColorWeb() );
			$itemInfo.find('.ff-item-group').val( _this_.description.group );
			
			//$item.css('background-color', _this_.getColorWeb() );
		};

		return _this_;
	};
	
	//var test = new frslib._classes.modalWindowColorLibraryColor();
	//test.alert();
})(jQuery);







