<?php
/**
 * Walking through the options and then printing them. Possible to set prefix
 * for printing ID and NAME of the options -> important for widgets mainly.
 * 
 * @author FRESHFACE
 * @since 0.1
 */
class ffOptionsPrinter extends ffOptionsWalker {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffOptionsPrinterComponent_Factory
	 */
	private $_printerComponentFactory = null;
	
	/**
	 * 
	 * @var Prefix for name -> name="PREFIX[x][y]"
	 */
	private $_namePrefix = null;
	
	/**
	 * 
	 * @var prefix for ID -> id="PREFIXaaaaaa"
	 */
	private $_idPrefix = null;
	
	
	/**
	 * 
	 * @var ffOptionsPrinterDataBoxGenerator
	 */
	private $_optionsPrinterDataBoxGenerator = null;
	
	private $_printingCallbacks = array();
	
	private $_printingCssClasses = array();
	
	private $_ulNestedLevel = 0;
	
	const ACT_BEFORE_REPEATABLE_NODE = 'before_repeatable_node';
	const ACT_AFTER_REPEATABLE_NODE = 'after_repeatable_node';
	
	const ACT_BEFORE_REPEATABLE_TEMPLATE = 'before_repeatable_template';
	const ACT_AFTER_REPEATABLE_TEMPLATE = 'after_repeatable_template';

	
	const ACT_BEFORE_REPEATABLE_VARIABLE_TEMPLATE = 'before_repeatable_variable_template';
	const ACT_AFTER_REPEATABLE_VARIABLE_TEMPLATE = 'after_repeatable_variable_template';
	
	const ACT_AFTER_REPEATABLE_VARIABLE_NODE = 'before_repeatable_variable_node';
	const ACT_BEFORE_REPEATABLE_VARIABLE_NODE = 'after_repeatable_variable_node';
	
	const ACT_BEFORE_CONTAINER = 'before_container';
	const ACT_AFTER_CONTAINER = 'after_container';
	
	const POSITION_FIRST = 'first';
	const POSITION_LAST = 'last';
	
	const CSS_FF_REPEATABLE = 'ff_repeatable';
	const CSS_FF_REPEATABLE_ITEM = 'ff_repeatable_item';
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	/**
	 * Printer factory is important, since we want to print options
	 * 
	 * @param string $optionsArrayData
	 * @param string $optionsStructure
	 * @param ffOptionsPrinterComponent_Factory $printerComponentFactory
	 */
	public function __construct( $optionsArrayData = null, $optionsStructure = null, ffOptionsPrinterComponent_Factory $printerComponentFactory, ffOptionsPrinterDataBoxGenerator $optionsPrinterDataBoxGenerator ) {
		$this->_setPrintercomponentfactory($printerComponentFactory);
		$this->_setOptionsPrinterDataBoxGenerator($optionsPrinterDataBoxGenerator);
		$this->_addCallbacks();
		parent::__construct( $optionsArrayData, $optionsStructure);
		
	}
	
	/**
	 * Print options ( called walk from inherited classes )
	 */
	public function walk() {
        ob_start();
		$this->_walk();
        $content = ob_get_contents();
        ob_end_clean();
        $contentReplaced = preg_replace('/>\s\s+</ms', '><', $content);


        echo $contentReplaced;

	}
	
/******************************************************************************/
/* ELEMENT JUNCTION
/******************************************************************************/	
	protected function _oneElement( ffOneElement $item) {
		
		$routeForNameParam = $this->_getRouteForNameParam();
		$routeForIdParam = $this->_getRouteForIdParam();
		
		
		switch ( $item->getType() ) {
			case ffOneElement::TYPE_TABLE_START :
					$this->_getPrintercomponentfactory()->createPrinterElementTableStart()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_TABLE_START);
				break;
				
			case ffOneElement::TYPE_TABLE_END :
					$this->_getPrintercomponentfactory()->createPrinterElementTableEnd()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_TABLE_END);
				break;
				
			case ffOneElement::TYPE_TABLE_DATA_START :
					$this->_getPrintercomponentfactory()->createPrinterElementTableDataStart()->printElement($item, $routeForNameParam, $routeForIdParam);
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_TABLE_DATA_START);
				break;
				
			case ffOneElement::TYPE_TABLE_DATA_END :
					$this->_getPrintercomponentfactory()->createPrinterElementTableDataEnd()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_TABLE_DATA_END);
					break;

			case ffOneElement::TYPE_NEW_LINE :
					$this->_getPrintercomponentfactory()->createPrinterElementNewLine()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_NEW_LINE);
					break;

			case ffOneElement::TYPE_BUTTON :
					$this->_getPrintercomponentfactory()->createPrinterElementButton()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_BUTTON);
					break;

			case ffOneElement::TYPE_BUTTON_PRIMARY :
					$this->_getPrintercomponentfactory()->createPrinterElementButtonPrimary()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_BUTTON_PRIMARY);
					break;

			case ffOneElement::TYPE_HTML : 
					$this->_getPrintercomponentfactory()->createPrinterElementHtml()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_HTML);
					break;

			case ffOneElement::TYPE_HEADING :
					$this->_getPrintercomponentfactory()->createPrinterElementHeading()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_HEADING);
					break;

			case ffOneElement::TYPE_PARAGRAPH:
					$this->_getPrintercomponentfactory()->createPrinterElementParagraph()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_PARAGRAPH);
					break;			

			case ffOneElement::TYPE_DESCRIPTION:
					$this->_getPrintercomponentfactory()->createPrinterElementDescription()->printElement( $item, $routeForNameParam, $routeForIdParam );
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_DESCRIPTION);
					break;
					
			case ffOneElement::TYPE_SECTION_START:
				$this->_getPrintercomponentfactory()->createPrinterElementSectionStart()->printElement( $item, $routeForNameParam, $routeForIdParam );
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_SECTION_START);
				break;
				
			case ffOneElement::TYPE_SECTION_END:
				$this->_getPrintercomponentfactory()->createPrinterElementSectionEnd()->printElement( $item, $routeForNameParam, $routeForIdParam );
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_SECTION_END);
				break;

            case ffOneElement::TYPE_TOGGLE_BOX_START:
				$this->_getPrintercomponentfactory()->createPrinterElementToggleBoxStart()->printElement( $item, $routeForNameParam, $routeForIdParam );
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_TOGGLE_BOX_START);
				break;

            case ffOneElement::TYPE_TOGGLE_BOX_END:
				$this->_getPrintercomponentfactory()->createPrinterElementToggleBoxEnd()->printElement( $item, $routeForNameParam, $routeForIdParam );
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedElement(ffOneElement::TYPE_TOGGLE_BOX_END);
				break;



		}
	}
	
	
	protected function _oneOption( $item ) {

		
		$routeForNameParam = $this->_getRouteForNameParam();
		$routeForIdParam = $this->_getRouteForIdParam();
	
		switch( $item->getType() ) {
			
				/***** TYPE TEXT *****/
			case ffOneOption::TYPE_TEXT :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionText()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_TEXT);
				break;
	
				/***** TYPE TEXTAREA *****/
			case ffOneOption::TYPE_TEXTAREA :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionTextarea()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_TEXTAREA);
				break;
	
				/***** TYPE NUMBER *****/
			case ffOneOption::TYPE_NUMBER :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionNumber()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_NUMBER);
				break;

				/***** TYPE FONT *****/
			case ffOneOption::TYPE_FONT :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionFont()
				->printOption($item, $routeForNameParam, $routeForIdParam);

				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_SELECT);
				break;

				/***** TYPE REVOLUTION SLIDER *****/
			case ffOneOption::TYPE_REVOLUTION_SLIDER :
				$this->_getPrintercomponentfactory()
				->createPrinterRevolutionSlider()
				->printOption($item, $routeForNameParam, $routeForIdParam);

				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_REVOLUTION_SLIDER);
				break;

				/***** TYPE SELECT *****/
			case ffOneOption::TYPE_SELECT :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionSelect()
				->printOption($item, $routeForNameParam, $routeForIdParam);

				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_SELECT);
				break;
				
				/***** TYPE NAVIGATION MENU SELECTOR *****/
			case ffOneOption::TYPE_NAVIGATION_MENU_SELECTOR: 
				$this->_getPrintercomponentfactory()
				->createPrinterOptionNavigationMenuSelector()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_NAVIGATION_MENU_SELECTOR);
				break;
				

			/***** TYPE SELECT *****/
			case ffOneOption::TYPE_SELECT_CONTENT_TYPE :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionSelectContentType()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_SELECT_CONTENT_TYPE);
				break;				
	
				/***** TYPE SELECT2 *****/
			case ffOneOption::TYPE_SELECT2 :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionSelect2()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_SELECT2);
				break;

            case ffOneOption::TYPE_COLOR_PICKER_WP :
                $this->_getPrintercomponentfactory()
				->createPrinterOptinsColorPickerWP()
				->printOption($item, $routeForNameParam, $routeForIdParam);

				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_COLOR_PICKER_WP);
				break;

				
				/***** TYPE SELECT2 HIDDEN *****/
			case ffOneOption::TYPE_SELECT2_HIDDEN :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionSelect2Hidden()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_SELECT2_HIDDEN);
				break;				
				
				/***** TYPE SELECT2 *****/
			case ffOneOption::TYPE_SELECT2_POSTS :
				$this->_getPrintercomponentfactory()
					->createPrinterOptionSelect2Posts()
					->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_SELECT2_POSTS);
				break;				
	
				/***** TYPE CHECKBOX *****/
			case ffOneOption::TYPE_CHECKBOX :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionCheckbox()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_CHECKBOX);
				break;
				
			/***** TYPE RADAIO *****/
			case ffOneOption::TYPE_RADIO :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionRadio()
				->printOption($item, $routeForNameParam, $routeForIdParam);
			
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_CHECKBOX);
				break;
	
				/***** TYPE CODE *****/
			case ffOneOption::TYPE_CODE :
				
				$this->_getPrintercomponentfactory()
				->createPrinterOptionCode()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_CODE);
			
				break;
				
				/***** TYPE CONDITIONAL LOGI *****/
			case ffOneOption::TYPE_CONDITIONAL_LOGIC :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionConditionalLogic()
				->printOption($item, $routeForNameParam, $routeForIdParam);
			
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_CONDITIONAL_LOGIC);
				break;

			/***** TYPE IMAGE *****/
			case ffOneOption::TYPE_IMAGE :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionImage()
				->printOption($item, $routeForNameParam, $routeForIdParam);

				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_IMAGE);
				break;

			/***** TYPE ICON *****/
			case ffOneOption::TYPE_ICON :
				$this->_getPrintercomponentfactory()
				->createPrinterOptionIcon()
				->printOption($item, $routeForNameParam, $routeForIdParam);

				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_ICON);
				break;

			/***** TYPE COLOR LIBRARY *****/
			case ffOneOption::TYPE_COLOR_LIBRARY :
				
				$this->_getPrintercomponentfactory()
				->createPrinterColorLibrary()
				->printOption($item, $routeForNameParam, $routeForIdParam);
					
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_COLOR_LIBRARY);
				break;
				
			/***** TYPE TAXONOMY *****/
			case ffOneOption::TYPE_TAXONOMY :
			
				$this->_getPrintercomponentfactory()
				->createPrinterTaxonomy()
				->printOption($item, $routeForNameParam, $routeForIdParam);
				
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_TAXONOMY);		
				break;
				
			/***** TYPE USERS *****/
			case ffOneOption::TYPE_USERS :
				
				$this->_getPrintercomponentfactory()
				->createPrinterUsers()
				->printOption($item, $routeForNameParam, $routeForIdParam);
					
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_USERS);			
				
				break;
				
				
				/***** TYPE USERS *****/
				case ffOneOption::TYPE_DATEPICKER :
						
					$this->_getPrintercomponentfactory()
					->createPrinterDatepicker()
					->printOption($item, $routeForNameParam, $routeForIdParam);
						
					$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_DATEPICKER);
						
					break;
			/***** TYPE USERS *****/
			case ffOneOption::TYPE_POST_SELECTOR :
			
				$this->_getPrintercomponentfactory()
				->createPrinterPostSelector()
				->printOption($item, $routeForNameParam, $routeForIdParam);
					
				$this->_getOptionsPrinterDataBoxGenerator()->addPrintedComponent(ffOneOption::TYPE_POST_SELECTOR);
			
				break;				
		}
	}
	
	protected function _getRouteForIdParam() {
		$currentRoute = implode('-', $this->_getRoute() ).'-';
		return $this->_getIdprefix() . $currentRoute;
	}
	
	protected function _getRouteForNameParam() {
		$currentRouteToArray = '[' . implode('][', $this->_getCurrentForPrint()) .']';
		return $this->_getNameprefix() . $currentRouteToArray;
	}	
	
	protected function _addCalback( $action, $position, $callback ) {
		if( $position == ffOptionsPrinter::POSITION_LAST ) {
			$this->_printingCallbacks[ $action ][] = $callback;
		} else {
			if( !empty( $this->_printingCallbacks[ $action ] ) ) {
				$currentData = $this->_printingCallbacks[ $action ];
				array_unshift( $currentData, $callback );
				$this->_printingCallbacks[ $action ] = $currentData;
			} else {
				$this->_printingCallbacks[ $action ][] = $callback;
			}
		}
	}
	
	protected function _removeCallback( $action ) {
		$this->_printingCallbacks[ $action ] = array();
	}
	
	private function _doAllActions( $actionName, $firstArgument = null, $secondArgument = null ) {
		if( !isset( $this->_printingCallbacks[ $actionName ] ) ) {
			return;
		}
		
		foreach( $this->_printingCallbacks[ $actionName ] as $oneCallback ) {
			call_user_func( $oneCallback, $firstArgument, $secondArgument );
		}
	}
	
	protected function _addCssClass( $selector, $class ) {
		$this->_printingCssClasses[ $selector ][] = $class;
	}
	
	protected function _getCssClass( $selector ) {
		if( empty( $this->_printingCssClasses[ $selector ] ) ) {
			return '';
		}
		
		$cssClassesImploded = implode(' ', $this->_printingCssClasses[ $selector ] );
		return $cssClassesImploded; 
	}
	
	
	private function _addCallbacks() {
		$this->_addCalback(ffOptionsPrinter::ACT_BEFORE_REPEATABLE_NODE, ffOptionsPrinter::POSITION_LAST, array( $this, '_beforeRepeatableNodeCallback'));
		$this->_addCalback(ffOptionsPrinter::ACT_AFTER_REPEATABLE_NODE, ffOptionsPrinter::POSITION_LAST, array( $this, '_afterRepeatableNodeCallback'));
		
		$this->_addCalback(ffOptionsPrinter::ACT_BEFORE_REPEATABLE_TEMPLATE, ffOptionsPrinter::POSITION_LAST, array( $this, '_beforeRepeatableTemplateCallback'));
		$this->_addCalback(ffOptionsPrinter::ACT_AFTER_REPEATABLE_TEMPLATE, ffOptionsPrinter::POSITION_LAST, array( $this, '_afterRepeatableTemplateCallback'));
		
		
		$this->_addCalback(ffOptionsPrinter::ACT_BEFORE_REPEATABLE_VARIABLE_TEMPLATE, ffOptionsPrinter::POSITION_LAST, array( $this, '_beforeRepeatableVariableTemplateCallback'));
		
		//$this->_addCalback(ffOptionsPrinter::ACT_BEFORE_REPEATABLE_VARIABLE_TEMPLATE, ffOptionsPrinter::POSITION_LAST, array( $this, '_printAdvancedSectionPickerInfo'));
		
		$this->_addCalback(ffOptionsPrinter::ACT_AFTER_REPEATABLE_VARIABLE_TEMPLATE, ffOptionsPrinter::POSITION_LAST, array( $this, '_afterRepeatableVariableTemplateCallback'));
		
		$this->_addCalback(ffOptionsPrinter::ACT_BEFORE_REPEATABLE_VARIABLE_NODE, ffOptionsPrinter::POSITION_LAST, array( $this, '_beforeRepeatableVariableNodeCallback'));
		$this->_addCalback(ffOptionsPrinter::ACT_AFTER_REPEATABLE_VARIABLE_NODE, ffOptionsPrinter::POSITION_LAST, array( $this, '_afterRepeatableVariableNodeCallback'));
		
		$this->_addCalback(ffOptionsPrinter::ACT_BEFORE_CONTAINER, ffOptionsPrinter::POSITION_LAST, array( $this, '_beforeContainerCallback'));
		$this->_addCalback(ffOptionsPrinter::ACT_AFTER_CONTAINER, ffOptionsPrinter::POSITION_LAST, array( $this, '_afterContainerCallback'));
		
	}
	
	private function _beforeRepeatableNodeCallback( $item, $index ) {

		echo '<li class="ff-repeatable-item-'.$index.' ff-repeatable-item '.$this->_getCssClass( ffOptionsPrinter::CSS_FF_REPEATABLE_ITEM ).'" data-node-id="'.$index.'">'."\n";
	}
	

	
	private function _afterRepeatableNodeCallback( $item, $index ) {
		echo '</li>'."\n";
	}
	
	
	private function _beforeRepeatableTemplateCallback( $item, $currentLevel ) {
	
		echo '<li class="ff-repeatable-template" data-current-level="'.$currentLevel.'">'."\n";
	}
	
	private function _afterRepeatableTemplateCallback( $item, $currentLevel ) {
		echo '</li>'."\n";
	}
	
	
	private function _beforeRepeatableVariableTemplateCallback( $item, $currentLevel ) {
		$sectionName = $item->getParam('section-name');
		echo '<li class="ff-repeatable-template-holder" style="display:none;">';
		$this->_printAdvancedSectionPickerInfo($item, $currentLevel);
		echo '<ul class="ff-repeatable-template '.$this->_getUlLevelClass().'" data-section-name="'.$sectionName.'" data-section-id="'.$item->getId().'" data-current-level="'.$currentLevel.'">'."\n";
	}
	
	private function _printAdvancedSectionPickerInfo( $item, $index ) {
		echo '<div class="ff-repeatable-section-info" class="display:none">';
			echo '<span class="ff-advanced-section-name">'.$item->getParam('section-name').'</span>';
			echo '<span class="ff-advanced-section-id">'.$item->getId().'</span>';
			echo '<span class="ff-advanced-section-image">'.$item->getParam('advanced-picker-section-image').'</span>';

			echo '<span class="ff-advanced-menu-title">'.$item->getParam('advanced-picker-menu-title').'</span>';
			echo '<span class="ff-advanced-menu-id">'.$item->getParam('advanced-picker-menu-id').'</span>';
		echo '</div>';
	
	}
	
	
	private function _afterRepeatableVariableTemplateCallback( $item, $currentLevel ) {
		
		echo '</ul></li>'."\n";
	}
	private function _beforeRepeatableVariableNodeCallback( $item, $index ) {
		//var_dump( $item->getParam('hide-default'));
		
		(  $item->getParam('hide-default') == true ) ? $classHideDefault = 'ff-repeatable-item-hide-default' : $classHideDefault = '';

		echo '<li class="ff-repeatable-item-'.$index.' '. $classHideDefault .' ff-repeatable-item ff-repeatable-item-closed '.$this->_getCssClass( ffOptionsPrinter::CSS_FF_REPEATABLE_ITEM ).'" data-section-id="'.$item->getId().'" data-section-name="'.$item->getParam('section-name').'" data-node-id="'.$index.'">'."\n";
	}
	private function _afterRepeatableVariableNodeCallback( $item, $index ) {
		echo '</li>'."\n";
	}
	
	protected function _beforeContainerCallback( $item ) {
		//$item = new ffOneSection();
		
		if( $item->getType() == ffOneSection::TYPE_REPEATABLE || $item->getType() == ffOneSection::TYPE_REPEATABLE_VARIABLE ) {
			
			$currentLevel = $this->_getCurrentRouteCount();
			
			$this->_ulLevelAdd();
			$class = $this->_getUlLevelClass();
			
			$externClasses = $item->getParam('class');
	
			//var_dump( $item->getParam('classxxx') );
			
			
			
			$classes = $item->getParam('class', array());
			if( is_array( $classes ) ) {
				$classes = implode(' ', $classes);
			}
			
			if( $item->getParam('section-picker') == 'advanced') {
				$classes .= ' ff-section-picker-advanced ';
			}
			
		
			
			echo '<ul style="display:none;" class="ff-repeatable '.$classes.' '.$class.' '.$this->_getCssClass( ffOptionsPrinter::CSS_FF_REPEATABLE ).'" data-current-level="'.$currentLevel.'">'."\n";			
		}
	}
	

	
	protected function _afterContainerCallback( $item ) {
		if( $item->getType() == ffOneSection::TYPE_REPEATABLE || $item->getType() == ffOneSection::TYPE_REPEATABLE_VARIABLE ) {
			echo '</ul>'."\n";
			$this->_ulLevelRemove();
		}
	}
	
	
	private function _ulLevelAdd() {
		$this->_ulNestedLevel++;
	}
	
	private function _ulLevelRemove() {
		$this->_ulNestedLevel--;
	}
	
	private function _getUlLevelClass() {
		( $this->_ulNestedLevel % 2 == 0 ) ? $class = 'ff-odd' : $class = 'ff-even';
		return $class;
	}
/******************************************************************************/
/* CONTAINER STUFF
/******************************************************************************/	
	protected function _beforeRepeatableNode( $item, $index ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_BEFORE_REPEATABLE_NODE, $item, $index);
	}
	protected function _afterRepeatableNode( $item, $index ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_AFTER_REPEATABLE_NODE, $item, $index);
	}
	
	protected function _beforeRepeatableTemplate( $item, $currentLevel ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_BEFORE_REPEATABLE_TEMPLATE, $item, $currentLevel);
	}
	protected function _afterRepeatableTemplate( $item, $currentLevel ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_AFTER_REPEATABLE_TEMPLATE, $item, $currentLevel);
	}
	
	protected function _beforeRepeatableVariableTemplate( $item, $currentLevel ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_BEFORE_REPEATABLE_VARIABLE_TEMPLATE, $item, $currentLevel);
	}
	protected function _afterRepeatableVariableTemplate( $item, $currentLevel ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_AFTER_REPEATABLE_VARIABLE_TEMPLATE, $item, $currentLevel);
	}
	
	protected function _beforeRepeatableVariableNode( $item, $index ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_BEFORE_REPEATABLE_VARIABLE_NODE, $item, $index);
	}
	protected function _afterRepeatableVariableNode( $item, $index ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_AFTER_REPEATABLE_VARIABLE_NODE, $item, $index);
	}
	
	protected function _beforeContainer( $item ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_BEFORE_CONTAINER, $item);
	}
	protected function _afterContainer( $item ) {
		$this->_doAllActions( ffOptionsPrinter::ACT_AFTER_CONTAINER, $item);
	}
/******************************************************************************/
/* CONTAINER STUFF
/******************************************************************************/	



	
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/

	/**
	 * @return ffOptionsPrinterComponent_Factory
	 */
	protected function _getPrintercomponentfactory() {
		return $this->_printerComponentFactory;
	}
	
	/**
	 * @param ffOptionsPrinterComponent_Factory $_printerComponentFactory
	 */
	protected function _setPrintercomponentfactory(ffOptionsPrinterComponent_Factory $printerComponentFactory) {
		$this->_printerComponentFactory = $printerComponentFactory;
		return $this;
	}

	/**
	 * @return unknown_type
	 */
	protected function _getNameprefix() {
		return $this->_namePrefix;
	}
	
	/**
	 * @param unknown_type $_namePrefix
	 */
	public function setNameprefix($_namePrefix) {
		$this->_namePrefix = $_namePrefix;
		return $this;
	}
	
	/**
	 * @return unknown_type
	 */
	protected function _getIdprefix() {
		return $this->_idPrefix;
	}
	
	/**
	 * @param unknown_type $_idPrefix
	 */
	public function setIdprefix($_idPrefix) {
		$this->_idPrefix = $_idPrefix;
		return $this;
	}

	/**
	 * @return ffOptionsPrinterDataBoxGenerator
	 */
	protected function _getOptionsPrinterDataBoxGenerator() {
		return $this->_optionsPrinterDataBoxGenerator;
	}
	
	/**
	 * @param ffOptionsPrinterDataBoxGenerator $optionsPrinterDataBoxGenerator
	 */
	protected function _setOptionsPrinterDataBoxGenerator(ffOptionsPrinterDataBoxGenerator $optionsPrinterDataBoxGenerator) {
		$this->_optionsPrinterDataBoxGenerator = $optionsPrinterDataBoxGenerator;
		return $this;
	}
	
	


	
}