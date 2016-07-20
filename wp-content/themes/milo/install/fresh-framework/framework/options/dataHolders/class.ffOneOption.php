<?php
class ffOneOption extends ffBasicObject implements ffIOneDataNode {
	const TYPE_TEXT = 'text';
    const TYPE_TEXT_FULLWIDTH = 'text_fullwidth';

	// REDEFINE !!!
	const TYPE_COLOR = 'text';


	const TYPE_TEXTAREA = 'textarea';
	const TYPE_NUMBER = 'number';
	const TYPE_RADIO = 'radio';
	const TYPE_FONT = 'font';
	const TYPE_SELECT = 'select';
	const TYPE_SELECT_CONTENT_TYPE = 'select_content_type';
	const TYPE_SELECT2 = 'select2';
	const TYPE_SELECT2_HIDDEN = 'select2_hidden';
	const TYPE_SELECT2_POSTS = 'select2_posts';
	const TYPE_CHECKBOX = 'checkbox';
	const TYPE_CODE = 'code';
	const TYPE_CONDITIONAL_LOGIC = 'conditional_logic';
	const TYPE_IMAGE = 'image';
	const TYPE_VIDEO = 'text';
	const TYPE_ICON = 'icon';
	const TYPE_COLOR_LIBRARY = 'color_library';
	const TYPE_TAXONOMY = 'taxonomy';
	const TYPE_USERS = 'users';
	const TYPE_DATEPICKER = 'datepicker';
	const TYPE_POST_SELECTOR = 'post_selector';
	const TYPE_NAVIGATION_MENU_SELECTOR  = 'navigation_menu_selector';
	const TYPE_REVOLUTION_SLIDER = 'revolution_slider';
    const TYPE_COLOR_PICKER_WP = 'color_picker_wp';

	const PARAM_TITLE_AFTER = 'PARAM_TITILE_AFTER';

	private $_type = null;
	private $_id = null;
	private $_title = null;
	private $_defaultValue = null;
	private $_description = null;

	private $_selectValues = null;
	private $_params = null;
	private $_value = null;

/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/	
	public function __construct( $type = null, $id = null, $title = null, $defaultValue = null, $description = null ) {
		$this->_type = $type;
		$this->_id = $id;
		$this->_title = $title;
		$this->_defaultValue = $defaultValue;
		$this->_description = $description;
	}
	
	public function clearSelectValues() {
		$this->_selectValues = null;
	}
	
	public function addSelectValue( $name, $value, $group = null ) {
		$newValue = array( 'name' => $name, 'value' => $value );
		
		if( $group == null ) {
			$this->_selectValues[] = $newValue;
		} else {
			$this->addParam('is_group', true, true);
			$this->_selectValues[ $group ][] = $newValue;
		}
		
		return $this;
	}
	
	public function addSelectNumberRange( $start, $end, $adder = 1 ) {
		
		for( $i = $start; $i <= $end; $i += $adder ) {
			
			$this->addSelectValue( $i, $i );
			
		}

        return $this;
		
	}
	
	public function addSelectValues( $values ) {
		$this->_selectValues = $values;
	}

    public function getParams() {
        return $this->_params;
    }
	
	public function addParam( $name, $value, $onlyOnce = false ) {
		if( $onlyOnce ) {
			$this->_params[ $name ] = array( $value );
		} else {
			$this->_params[ $name ][] = $value;
		}
		return $this;
	}
	
	public function getDefaultValue() { return $this->_defaultValue; }

	public function getValue() {return $this->_value;}
	
	public function setValue( $value ) { $this->_value = $value; }

	public function getTitle() { return $this->_title; }
	public function getType() { return $this->_type; }

	public function getDescription() { return $this->_description; }

	public function getSelectValues() { return $this->_selectValues; }

	public function getParam( $name, $defaultValue = null ) {
		if( isset( $this->_params[$name ] ) ) {
			if( count( $this->_params[ $name ]) == 1 ) {
				return reset( $this->_params[ $name ] );
			} else {
				return $this->_params[ $name ];
			}
		}
		
		return $defaultValue;
	}
/******************************************************************************/
/* IOneDataNode IMPLEMENTATION
/******************************************************************************/	
	public function getId() { return $this->_id; }
	
	public function isContainer() {
		return false;
	}
	
	
}