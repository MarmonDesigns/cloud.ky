<?php

class ffOptionsPrinterElement_TableStart extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		$classParam = $this->_getClassesString();
		
		echo '<table class="'.$classParam.' form-table ff-options"><tbody>';
	}
}


class ffOptionsPrinterElement_TableEnd extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		echo '</tbody></table>';
	}
}


class ffOptionsPrinterElement_TableHeader extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		$classParam = $this->_getClassesString();
		$class = '';
		if( $classParam != null ) {
			$class = ' class="'.$classParam.'" ';
		}
		echo '<th '.$class.' scope="row">'.$element->getTitle().'</th>';
	}
}

class ffOptionsPrinterElement_TableDataStart extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		$classParam = $this->_getClassesString();
		$class = '';
		if( $classParam != null ) {
			$class = ' class="'.$classParam.'" ';
		}
		
		echo '<tr '.$class .'>';
		if( strlen($element->getTitle()) > 0 )
			echo '<th scope="row">'.$element->getTitle().'</th>';
		echo '<td><fieldset>';
	}
}

class ffOptionsPrinterElement_TableDataEnd extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
        echo '</fieldset></td></tr>';
        return;
		echo '</fieldset></td>';
		echo '</tr>';
	}
}

class ffOptionsPrinterElement_NewLine extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		echo "<br/>\n\n";
	}
}

class ffOptionsPrinterElement_Html extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		echo $element->getTitle();
	}
}

class ffOptionsPrinterElement_Button extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		echo '<input type="submit" value="'.$element->getTitle().'" class="button button-secondary" id="'.$element->getId().'" name="submit"><span class="'.$element->getId().'_spinner spinner"></span>';
	}
}

class ffOptionsPrinterElement_Button_Primary extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		echo '<input type="submit" value="'.$element->getTitle().'" class="button button-primary  ff-form-submit" id="'.$element->getId().'" name="submit"><span class="'.$element->getId().'_spinner spinner"></span>';
	}
}

class ffOptionsPrinterElement_Heading extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		$type = $element->getParam('heading_type', 'h3');
		
		echo '<'.$type.'>';
			echo $element->getTitle();
		echo '</'.$type.'>';
		//echo '<'
		//echo '<div class="'.$element->getId().'"><input type="submit" value="'.$element->getTitle().'" class="button button-secondary button-small" id="'.$element->getId().'" name="submit"><span class="spinner"></span></div>';
	}
}


class ffOptionsPrinterElement_Paragraph extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		echo '<p>';
		echo $element->getTitle();
		echo '</p>';
	}
}

class ffOptionsPrinterElement_Description extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		$type = $element->getParam('tag', 'p');
		echo '<'.$type.' class="description">';
		echo $element->getTitle();
		echo '</'.$type.'>';
	}
}

class ffOptionsPrinterElement_SectionStart extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		$type = $element->getParam('type', 'div');
		$classParam = $this->_getClassesString();
		$classParam .= ' ff-one-section ';
		
		$enabled_group = $element->getParam('enabled-group','');
		$enabled_value = $element->getParam('enabled-value','');
		
		$enabledValueClass = $enabled_group.'-'.$enabled_value;
		
		$classParam .= ' '.$enabled_group;
		$classParam .= ' '.$enabledValueClass;
		
		if( !empty( $enabled_group ) ) {
			$classParam.= ' ff-disabled';
		}
		
		echo '<'.$type.' class="'.$classParam.'">';
	}
}

class ffOptionsPrinterElement_SectionEnd extends ffOptionsPrinterElementsBasic {
	protected function _printElement( ffOneElement $element ) {
		$type = $element->getParam('type', 'div');

		echo '</'.$type.'>';
	}
}



class ffOptionsPrinterElement_ToggleBoxStart extends ffOptionsPrinterElementsBasic {
    protected function _printElement( ffOneElement $element ) {
		echo '<ul style="display: block;" class="ff-repeatable  ff-odd ff-repeatable-boxed ">';
            echo '<li class="ff-repeatable-template-holder"></li>';
            echo '<li class="ff-repeatable-item ff-repeatable-item-closed" style="opacity: 1;">';
                echo '<div class="ff-repeatable-header ff-repeatable-handle">';
                    echo '<table class="ff-repeatable-header-table">';
                        echo '<tbody>';
                        echo '<tr>';
                            echo '<td class="ff-repeatable-item-number"></td>';
                            echo '<td class="ff-repeatable-title">'.$element->getTitle().'</td>';
                            echo '<td class="ff-repeatable-description"></td>';
                        echo '</tr>';
                        echo '</tbody>';
                    echo '</table>';
                    echo '<div class="ff-repeatable-handle "></div>';
                echo '</div>';
                echo '<div class="ff-repeatable-content" style="display: none;">';
	}
}

class ffOptionsPrinterElement_ToggleBoxEnd extends ffOptionsPrinterElementsBasic {
    protected function _printElement( ffOneElement $element ) {
                echo '</div>';
            echo '</li>';
        echo '</ul>';
	}
}

