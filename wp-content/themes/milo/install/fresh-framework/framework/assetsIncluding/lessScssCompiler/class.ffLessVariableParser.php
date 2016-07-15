<?php


class ffLessVariableParser extends ffBasicObject {
################################################################################
# CONSTANTS
################################################################################
	const TYPE_COLOR = 'type_color';

    protected $_currentVariables = array();
################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 *
	 * @var lessc_freshframework
	 */
	private $_lessCompiler = null;
################################################################################
# PRIVATE VARIABLES
################################################################################
	private $_content = null;


	/* Original from : http://www.w3schools.com/cssref/css_colornames.asp */
	private $_possibleStringCollors = array( 'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black',
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

	private $_colorsWithHex = array(
			'aliceblue'=>'#f0f8ff','antiquewhite'=>'#faebd7',
			'aqua'=>'#00ffff',
			'aquamarine'=>'#7fffd4',
			'azure'=>'#f0ffff',
			'beige'=>'#f5f5dc',
			'bisque'=>'#ffe4c4',
			'black'=>'#000000',
			'blanchedalmond'=>'#ffebcd',
			'blue'=>'#0000ff',
			'blueviolet'=>'#8a2be2',
			'brown'=>'#a52a2a',
			'burlywood'=>'#deb887',
			'cadetblue'=>'#5f9ea0',
			'chartreuse'=>'#7fff00',
			'chocolate'=>'#d2691e',
			'coral'=>'#ff7f50',
			'cornflowerblue'=>'#6495ed',
			'cornsilk'=>'#fff8dc',
			'crimson'=>'#dc143c',
			'cyan'=>'#00ffff',
			'darkblue'=>'#00008b',
			'darkcyan'=>'#008b8b',
			'darkgoldenrod'=>'#b8860b',
			'darkgray'=>'#a9a9a9',
			'darkgrey'=>'#a9a9a9',
			'darkgreen'=>'#006400',
			'darkkhaki'=>'#bdb76b',
			'darkmagenta'=>'#8b008b',
			'darkolivegreen'=>'#556b2f',
			'darkorange'=>'#ff8c00',
			'darkorchid'=>'#9932cc',
			'darkred'=>'#8b0000',
			'darksalmon'=>'#e9967a',
			'darkseagreen'=>'#8fbc8f',
			'darkslateblue'=>'#483d8b',
			'darkslategray'=>'#2f4f4f',
			'darkslategrey'=>'#2f4f4f',
			'darkturquoise'=>'#00ced1',
			'darkviolet'=>'#9400d3',
			'deeppink'=>'#ff1493',
			'deepskyblue'=>'#00bfff',
			'dimgray'=>'#696969',
			'dimgrey'=>'#696969',
			'dodgerblue'=>'#1e90ff',
			'firebrick'=>'#b22222',
			'floralwhite'=>'#fffaf0',
			'forestgreen'=>'#228b22',
			'fuchsia'=>'#ff00ff',
			'gainsboro'=>'#dcdcdc',
			'ghostwhite'=>'#f8f8ff',
			'gold'=>'#ffd700',
			'goldenrod'=>'#daa520',
			'gray'=>'#808080',
			'grey'=>'#808080',
			'green'=>'#008000',
			'greenyellow'=>'#adff2f',
			'honeydew'=>'#f0fff0',
			'hotpink'=>'#ff69b4',
			'indianred'=>'#cd5c5c',
			'indigo'=>'#4b0082',
			'ivory'=>'#fffff0',
			'khaki'=>'#f0e68c',
			'lavender'=>'#e6e6fa',
			'lavenderblush'=>'#fff0f5',
			'lawngreen'=>'#7cfc00',
			'lemonchiffon'=>'#fffacd',
			'lightblue'=>'#add8e6',
			'lightcoral'=>'#f08080',
			'lightcyan'=>'#e0ffff',
			'lightgoldenrodyellow'=>'#fafad2',
			'lightgray'=>'#d3d3d3',
			'lightgrey'=>'#d3d3d3',
			'lightgreen'=>'#90ee90',
			'lightpink'=>'#ffb6c1',
			'lightsalmon'=>'#ffa07a',
			'lightseagreen'=>'#20b2aa',
			'lightskyblue'=>'#87cefa',
			'lightslategray'=>'#778899',
			'lightslategrey'=>'#778899',
			'lightsteelblue'=>'#b0c4de',
			'lightyellow'=>'#ffffe0',
			'lime'=>'#00ff00',
			'limegreen'=>'#32cd32',
			'linen'=>'#faf0e6',
			'magenta'=>'#ff00ff',
			'maroon'=>'#800000',
			'mediumaquamarine'=>'#66cdaa',
			'mediumblue'=>'#0000cd',
			'mediumorchid'=>'#ba55d3',
			'mediumpurple'=>'#9370d8',
			'mediumseagreen'=>'#3cb371',
			'mediumslateblue'=>'#7b68ee',
			'mediumspringgreen'=>'#00fa9a',
			'mediumturquoise'=>'#48d1cc',
			'mediumvioletred'=>'#c71585',
			'midnightblue'=>'#191970',
			'mintcream'=>'#f5fffa',
			'mistyrose'=>'#ffe4e1',
			'moccasin'=>'#ffe4b5',
			'navajowhite'=>'#ffdead',
			'navy'=>'#000080','oldlace'=>'#fdf5e6','olive'=>'#808000','olivedrab'=>'#6b8e23','orange'=>'#ffa500','orangered'=>'#ff4500',
			'orchid'=>'#da70d6','palegoldenrod'=>'#eee8aa','palegreen'=>'#98fb98','paleturquoise'=>'#afeeee','palevioletred'=>'#d87093','papayawhip'=>'#ffefd5','peachpuff'=>'#ffdab9',
			'peru'=>'#cd853f','pink'=>'#ffc0cb','plum'=>'#dda0dd','powderblue'=>'#b0e0e6','purple'=>'#800080','red'=>'#ff0000','rosybrown'=>'#bc8f8f','royalblue'=>'#4169e1',
			'saddlebrown'=>'#8b4513','salmon'=>'#fa8072','sandybrown'=>'#f4a460','seagreen'=>'#2e8b57','seashell'=>'#fff5ee','sienna'=>'#a0522d','silver'=>'#c0c0c0',
			'skyblue'=>'#87ceeb','slateblue'=>'#6a5acd','slategray'=>'#708090','slategrey'=>'#708090','snow'=>'#fffafa','springgreen'=>'#00ff7f',
			'steelblue'=>'#4682b4','tan'=>'#d2b48c','teal'=>'#008080','thistle'=>'#d8bfd8','tomato'=>'#ff6347','turquoise'=>'#40e0d0',
			'violet'=>'#ee82ee','wheat'=>'#f5deb3','white'=>'#ffffff','whitesmoke'=>'#f5f5f5','yellow'=>'#ffff00','yellowgreen'=>'#9acd32'
	);
################################################################################
# CONSTRUCTOR
################################################################################
	public function __construct( lessc_freshframework $lessCompiler ) {
		$this->_setLesscompiler( $lessCompiler );
	}
################################################################################
# ACTIONS
################################################################################

################################################################################
# PUBLIC FUNCTIONS
################################################################################
	/**
	 * return input type by value in bootstrap variable file
	 * @param  string $value devined value
	 * @return string        one of ffOneOption type constants
	*/
	public function getTypeByValue( $value ){

		$value = trim( $value );

		// Special case - color with name:
		if( in_array( strtolower($value) , $this->_possibleStringCollors ) ){
			return ffLessVariableParser::TYPE_COLOR;
		}



		$types_pattern = array(
				ffLessVariableParser::TYPE_COLOR => array(
						// rgb ( 1, 2, 3 )
						'/^rgb\s*\(\s*[0-9]{1,3}\s*\,\s*[0-9]{1,3}\s*\,\s*[0-9]{1,3}\s*\)$/mUi' ,

						// rgba ( 1, 2, 3, .5 )

						'/^rgba\s*\((\s*[0-9]{1,3}\s*\,){3}\s*([01]\.)?[0-9]{1,}\s*\)$/mUi' ,

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
		return '';
	}

    private function _changeColorStringsForHex() {
        if( empty( $this->_currentVariables ) || !is_array( $this->_currentVariables ) ) {
            return null;
        }
		foreach( $this->_currentVariables as $name => $value ) {
			if( isset( $this->_colorsWithHex[ $value ] ) ) {
				$this->_currentVariables[$name] = $this->_colorsWithHex[ $value ];
			}
		}
	}

	/**
	 * Get all less color variables from the text string
	 * @param string $text
	 * @return array();
	 */
 	public function getLessVariablesFromString( $text ) {
 		$combined = $this->getLessVariablesFromStringWithReferences($text);

 		$this->_currentVariables = $combined;
 		$this->_removeReferencesFromVariables();
 		$this->_removeOtherVariablesThanColors();
 		$this->_compileLessCombinedColors();
 		$this->_changeColorStringsForHex();

 		$currentVariables = $this->_currentVariables;
 		$this->_currentVariables = null;

 		return $currentVariables;
 	}

 	public function getAllLessVariablesFromString( $text ) {
 		$combined = $this->getLessVariablesFromStringWithReferences($text);

 		$this->_currentVariables = $combined;
 		$this->_removeReferencesFromVariables();
 		//$this->_removeOtherVariablesThanColors();
 		//$this->_compileLessCombinedColors();
 		//$this->_changeColorStringsForHex();

 		$currentVariables = $this->_currentVariables;
 		$this->_currentVariables = null;

 		return $currentVariables;
 	}


 	/**
 	 * Get banned variables
 	 * @param unknown $text
 	 * @return Ambigous <multitype:, unknown>
 	 */
 	public function getReferenceChainFromString( $text ) {
 		$lessVariables = $this->getLessVariablesFromStringWithReferences($text);

 		$variablesChainArray = array();
 		foreach( $lessVariables as $oneVarName => $oneVarValue ) {
 			$result = $this->_getVariableReferences($lessVariables, $oneVarName );

 			if( !empty( $result )) {
 				$variablesChainArray[] = $result . $oneVarName;//$oneVarName.','. substr($result,0,-1);
 			}
 		}

 		$bannedVariables = array();
 		foreach( $variablesChainArray as $oneChain ) {
 			$exploded = explode(',', $oneChain);

 			for( $i = 0; $i< count( $exploded); $i++ ) {
 				$first = array_shift( $exploded );

 				foreach( $exploded as $variableName ) {
 					if( !isset( $bannedVariables[ $first ] ) || !in_array($variableName, $bannedVariables[ $first ] )) {
 						$bannedVariables[ $first ][] = $variableName;
 					}
 				}
 			}
 		}

 		return $bannedVariables;
 	}

 	public function getDirectReferencesFromString( $text ) {
 		$variables = $this->getLessVariablesFromStringWithReferences( $text );
 		$toReturn = array();
 		foreach( $variables as $name => $value ) {
 			$variable = $this->_getVariableFromString( $value );
 			if( !empty( $variable ) ) {
 				$toReturn[ $name ] = $variable;
 			}
 		}

 		return $toReturn;
 	}

 	/**
 	 * Get variables, which values can point to variables (example @a : @b; )
 	 * @param unknown $text
 	 * @return multitype:
 	 */
 	public function getLessVariablesFromStringWithReferences( $text ) {
 		$parsedVariables = array();
 		preg_match_all("/(\s*\@[^\:^\;]*\s*)\:\s*([^;]*)\s*;/mU", $text, $parsedVariables);
 		$trimmedNames = array_map('trim', $parsedVariables[1] );
 		$trimmedValues = array_map('trim', $parsedVariables[2] );

        if( !empty( $trimmedNames ) && !empty( $trimmedValues ) ) {
 		$combined = array_combine( $trimmedNames, $trimmedValues);
        } else {
            $combined = array();
        }

 		return $combined;
 	}
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _compileLessCombinedColors() {
        if( empty( $this->_currentVariables ) ) {
            return;
        }
		foreach( $this->_currentVariables as $variableName => $variableValue ) {

			$colorFunctionMarkers = array('lighten', 'darken', 'spin' );

			$hasFunctionInside = false;

			foreach( $colorFunctionMarkers as $oneMarker ) {
				if( $hasFunctionInside ) {
					continue;
				}

				if( strpos( $variableValue, $oneMarker) !== false ) {
					$hasFunctionInside = true;

				}
			}

			if( $hasFunctionInside ) {
				$stringToCompile = 'body{color:'.$variableValue.';}';
				$compiledString = $this->_getLesscompiler()->compile( $stringToCompile );

				$compiledCleanString =  preg_replace('/\s+/', ' ', trim($compiledString));
				$compiledCleanString = str_replace(' ', '', $compiledCleanString);
				$compiledCleanString = str_replace('body{color:', '', $compiledCleanString);
				$compiledCleanString = str_replace(';}', '', $compiledCleanString);

				$this->_currentVariables[ $variableName ] = $compiledCleanString;
			}
		}
	}


 	private function _getVariableReferences( $lessVariables, $oneVariable, $string = '', $isFirst = true ) {
 		if( !isset( $lessVariables[ $oneVariable ] ) ){
 			return;
 		}
 		$oneVariableValue = $lessVariables[ $oneVariable ];

 		$variableReference = $this->_getVariableFromString( $oneVariableValue );

 		if( !empty( $variableReference ) ) {
 			$string = $variableReference . ',' . $string;
 			$string = $this->_getVariableReferences($lessVariables, $variableReference, $string, false);
 		}
 		return $string;
 	}


	private function _getVariableFromString( $text ) {
		$result = array();
		preg_match('/(\@[^\s^\,^\)]*)/m',$text, $result);

		if( empty( $result ) ) {
			return null;
		} else {
			return $result[0];
		}
	}


	private function _changeColorStringsForH0ex() {
        if( empty( $this->_currentVariables ) ) {
            return;
        }
		foreach( $this->_currentVariables as $name => $value ) {
			if( isset( $this->_colorsWithHex[ $value ] ) ) {
				$this->_currentVariables[$name] = $this->_colorsWithHex[ $value ];
			}
		}
	}

 	private function _removeReferencesFromVariables() {
        if( empty( $this->_currentVariables ) ) {
            return;
        }
 		foreach( $this->_currentVariables as $name => $value ) {

 			// matched has variable ?
 			$matched = $this->_getVariableFromString( $value );

 			if( empty( $matched ) ) {
 				continue;
 			}

 			$variableReferenceName = $matched;

 		 	$originalVariableValue = $this->_getVariableValue( $variableReferenceName );
 			if( $originalVariableValue == null ) {
 				unset( $this->_currentVariables[ $name ] );
 			} else {
 				$this->_currentVariables[ $name ] = str_replace( $variableReferenceName, $originalVariableValue, $value);
 			}
 		}
 	}

 	private function _removeOtherVariablesThanColors() {
 		 if( empty( $this->_currentVariables ) ) {
            return;
        }
 		foreach( $this->_currentVariables as $name => $value ) {
 			if( $this->getTypeByValue( $value ) !== ffLessVariableParser::TYPE_COLOR ) {
 				unset( $this->_currentVariables[ $name ] );
 			}
 		}
 	}

 	private function _getVariableValue( $variableName ) {
		if( !isset( $this->_currentVariables[ $variableName ] ) ) {
 			return null;
 		}

 		$value = $this->_currentVariables[ $variableName ];

 		$variableReference = $this->_getVariableFromString($value);

 		if( !empty( $variableReference ) ) {
 			$value =str_replace($variableReference, $this->_getVariableValue( $variableReference), $value );
 		}

 		return $value;
 	}

################################################################################
# GETTERS AND SETTERS
################################################################################
 	/**
 	 *
 	 * @return lessc_freshframework
 	 */
 	protected function _getLesscompiler() {
 		return $this->_lessCompiler;
 	}

 	/**
 	 *
 	 * @param lessc_freshframework $_lessCompiler
 	 */
 	protected function _setLesscompiler(lessc_freshframework $lessCompiler) {
 		$this->_lessCompiler = $lessCompiler;
 		return $this;
 	}
}