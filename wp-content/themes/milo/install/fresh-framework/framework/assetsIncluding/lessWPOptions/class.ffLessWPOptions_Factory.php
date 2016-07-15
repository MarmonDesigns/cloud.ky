<?php

class ffLessWPOptions_Factory extends ffFactoryAbstract {

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffOptions_Factory
	 */
	private $_Options_Factory = null;

	/**
	 * @var ffDataStorage_Factory
	 */
	private $_DataStorage_Factory = null;

	/**
	 * class constructor
	 * @param ffClassLoader     $classLoader
	 * @param ffWPLayer         $WPLayer
	 * @param ffOptions_Factory $Options_Factory
	 */
	function __construct( ffClassLoader $classLoader, ffWPLayer $WPLayer, ffOptions_Factory $Options_Factory ) {
		$this->_setWPlayer($WPLayer);
		$this->_setOptions_Factory($Options_Factory);
	}


	/* Original from : http://www.w3schools.com/cssref/css_colornames.asp */
	private $possibleStringCollors = array( 'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black',
		'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral',
		'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen',
		'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen',
		'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue',
		'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green',
		'greenyellow', 'honeydew', 'hotpink', 'indianred ', 'indigo ', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen',
		'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgray', 'lightgreen', 'lightpink',
		'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen',
		'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen',
		'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose',
		'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod',
		'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple',
		'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue',
		'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet',
		'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen',
	);

	/**
	 * return input type by value in bootstrap variable file
	 * @param  string $value devined value
	 * @return string        one of ffOneOption type constants
	 */
	public function getTypeByValue( $value ){

		$value = trim( $value );

		// Special case - color with name:
		if( in_array( strtolower($value) , $this->possibleStringCollors ) ){
			return ffOneOption::TYPE_COLOR;
		}

		$types_pattern = array(
			ffOneOption::TYPE_COLOR => array(
				// rgb ( 1, 2, 3 )
				'/^rgb\s*\(\s*[0-9]{1,3}\s*\,\s*[0-9]{1,3}\s*\,\s*[0-9]{1,3}\s*\)$/mUi' ,

				// rgba ( 1, 2, 3, .5 )
				'/^rgba\s*\((\s*[0-9]{1,3}\s*\,){3}\s*[01]?\.[0-9]{1,}\s*\)$/mUi' ,

				// #123 or #AbC
				'/^\#[0-9a-f]{3}$/mUi' ,

				// #123456 or #AbCdEf
				'/^\#[0-9a-f]{6}$/mUi' ,

				// lighten( #000 , 60% )
				// lighten(,)
				'/^lighten\s*\([^\)]*,[^\)]*\)$/mUi' ,

				// darken( #000 , 60% )
				// darken(,)
				'/^darken\s*\([^\)]*,[^\)]*\)$/mUi' ,
			) ,
		);

		foreach ($types_pattern as $ffOneOption_TYPE => $patterns) {
			foreach ($patterns as $single_pattern) {
				if( 1 === preg_match( $single_pattern, $value ) ){
					return $ffOneOption_TYPE;
				}
			}
		}

		//return ffOneOption::TYPE_TEXT;
		return '';
	}

	/**
	 * Creates WP Options Structure from file parameter
	 * @param  string $file_name file name
	 * @param  string $optionsName name of options
	 * @return ffOneStructure    structure generated from file
	 */
	public function createWPOptionsStructureFromFile( $file_name, $optionsName ){
		$s = $this->_getOptions_Factory()->createStructure( $optionsName );

		$s->startSection($optionsName, ffOneSection::TYPE_NORMAL );

			// $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', '&nbsp;');
			// $s->addElement( ffOneElement::TYPE_BUTTON, 'Save', 'Save' );

			$file = ffContainer::getInstance()->getFileSystem()->file( $file_name );

			$input_description = '';

			$print_end_table = false;
			$print_end_table_data = false;
			$in_table = false;
			$in_td = false;

			foreach ($file as $line) {

				$line = trim( $line );

				if( '@' == substr($line, 0, 1) ) {
					if( ! $in_td ){
						if( ! $in_table ){
							$s->addElement( ffOneElement::TYPE_TABLE_START );
							$in_table = true;
						}
						$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ' &nbsp; ');
						$in_td = true;
					}

					// Variable
					if( FALSE === strpos($line, ':') ) continue;
					$line = explode(':', $line);
					$variable = trim( $line[0] );
					$variable = substr($variable, 1);
					$value = trim( $line[1] );
					if( FALSE !== strpos($value, ';') ){
						$exp = explode(';', $value);
						$value = $exp[0];
						$type = ( !empty($exp[1]) ) ? trim( str_replace('//', '', $exp[1])) : '';
					}
					$value = htmlentities($value);

					// Color detection

					if( 'TYPE_COLOR' == $type ){
					//if(ffOneOption::TYPE_COLOR == $this->getTypeByValue( $value )){
						$s->addOption(ffOneOption::TYPE_COLOR_LIBRARY, $variable, $input_description, $value)
							//->addParam('placeholder', $value)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' COLOR @'.$variable )
							->addParam('less-variable-name', '@'.$variable)
							;
					}else{
						$s->addOption(ffOneOption::TYPE_TEXT, $variable, $input_description, $value)
							//->addParam('placeholder', $value)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ' @'.$variable )
							;
					}

					// Color detection END

					$s->addElement( ffOneElement::TYPE_NEW_LINE );

					$input_description = '';

				}else if( '//==' == substr($line, 0, 4) ){
					// Header
					$line = substr($line, 4);
					$line = htmlentities($line);
					if( $print_end_table ){
						$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
						$s->addElement( ffOneElement::TYPE_TABLE_END );
						$print_end_table_data = false;
						$in_table = false;
						$in_td = false;
					}else{
						$print_end_table = true;
					}
					$s->addElement( ffOneElement::TYPE_HEADING, 'TYPE_HEADING', $line );
				}else if( '//--' == substr($line, 0, 4) ){
					// Header
					$line = substr($line, 4);
					$line = htmlentities($line);
					// $s->addElement( ffOneElement::TYPE_HEADING, 'TYPE_HEADING', $line );
					if( $print_end_table_data ){
						$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
						$in_td = false;
					}else{
						$print_end_table_data = true;
					}
					if( ! $in_table ){
						$s->addElement( ffOneElement::TYPE_TABLE_START );
						$in_table = true;
					}
					$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', $line);
					$in_td = true;
				}else if( '//##' == substr($line, 0, 4) ){
					// Paragraph
					$line = substr($line, 4);
					$line = htmlentities($line);
					$s->addElement( ffOneElement::TYPE_PARAGRAPH, 'TYPE_DESCRIPTION', $line );
				}else if( '//**' == substr($line, 0, 4) ){
					// Input description
					$line = substr($line, 4);
					$line = htmlentities($line);
					$line = preg_replace('/`([^`]*)`/', "<span>$1</span>", $line);
					$input_description = $line;
				}
			}

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		$s->addElement( ffOneElement::TYPE_TABLE_END );
		$s->endSection();
		return $s;
	}

	/**
	 * @return ffOneStructure structure generated from bootstrap variables.less file
	 */
	public function createBootstrapWPOptionsStructure(){
		$variables_less_file = $this->_getWPlayer()->getFrameworkDir().'/framework/extern/bootstrap/less/variables.less';
		return $this->createWPOptionsStructureFromFile( $variables_less_file, 'bootstrap' );
	}

	/**
	 * @return ffOptions_Factory instance of ffOptions_Factory
	 */
	protected function _getOptions_Factory() {
		return $this->_Options_Factory;
	}

	/**
	 * @param ffOptions_Factory $_Options_Factory
	 * @return ffLessWPOptions_Factory caller instance of ffLessWPOptions_Factory
	 */
	protected function _setOptions_Factory(ffOptions_Factory $Options_Factory) {
		$this->_Options_Factory = $Options_Factory;
		return $this;
	}

	/**
	 * @return ffWPLayer instance of ffWPLayer
	 */
	protected function _getWPlayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $_WPLayer
	 * @return ffLessWPOptions_Factory caller instance of ffLessWPOptions_Factory
	 */
	protected function _setWPlayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

}
