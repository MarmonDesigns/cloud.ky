<?php

class ffOptionsPrinterLogic extends ffOptionsPrinter {
	
	public function __construct( $optionsArrayData = null, $optionsStructure = null, ffOptionsPrinterComponent_Factory $printerComponentFactory, ffOptionsPrinterDataBoxGenerator $optionsPrinterDataBoxGenerator ) {
		
		parent::__construct($optionsArrayData,$optionsStructure, $printerComponentFactory, $optionsPrinterDataBoxGenerator);
		$this->_addCallbacks();
	}
	
	private function _addCallbacks() {
		//$this->_addCalback( ffOptionsPrinter::ACT_BEFORE_REPEATABLE_NODE, ffOptionsPrinter::POSITION_LAST, array($this, '_printRepeatableItemHeader') );
		//$this->_addCalback( ffOptionsPrinter::ACT_BEFORE_REPEATABLE_VARIABLE_NODE, ffOptionsPrinter::POSITION_LAST, array($this, '_printRepeatableItemHeader') );
		
		
		//$this->_addCalback( ffOptionsPrinter::ACT_AFTER_REPEATABLE_NODE, ffOptionsPrinter::POSITION_FIRST, array($this, '_printRepeatableItemHeaderEnd') );
		//$this->_addCalback( ffOptionsPrinter::ACT_AFTER_REPEATABLE_VARIABLE_NODE, ffOptionsPrinter::POSITION_FIRST, array($this, '_printRepeatableItemHeaderEnd') );
		
		$this->_addCssClass( ffOptionsPrinter::CSS_FF_REPEATABLE, 'ff-repeatable-logic');
		$this->_addCssClass( ffOptionsPrinter::CSS_FF_REPEATABLE_ITEM, 'ff-repeatable-logic-item');
	}

	//_beforeRepeatableNodeCallback
	//_beforeRepeatableVariableNodeCallback
	protected function _printRepeatableItemHeader( $item ) {
		return;
		$sectionName = $item->getParam('section-name');
		
		echo '<div class="ff-repeatable-header ff-repeatable-drag ff-repeatable-handle">';
            echo '<h3 class="ff-repeatable-title">'.$sectionName.'</h3>';
            echo '<div class="ff-repeatable-handle"></div>';
            echo '<div class="ff-repeatable-controls-offset">';
              echo '<div class="ff-repeatable-remove" title="Remove"></div>';
            echo '</div>';
		echo '</div>';
		echo '<div class="ff-repeatable-content">';
		/*
		echo '<div class="ff-repeatable-header ff-repeatable-drag">';
		echo '<h3 class="ff-repeatable-title">Background Image</h3>';
		echo '<div class="ff-repeatable-add">Add</div>';
		echo '<div class="ff-repeatable-remove">Remove</div>';
		echo '<div class="ff-repeatable-duplicate">Duplicate</div>';
		echo '<div class="ff-repeatable-handle">Open/Close</div>';
		echo '</div>';
		echo '<div class="ff-repeatable-content" style="">';
		//content here
		//</div>*/
	}
	
	protected function _printRepeatableItemHeaderEnd() {
		echo '<input type="submit" name="submit" id="ff_delete_cache" class="button button-secondary ff-repeatable-logic-button-and" value="and">
											<button class="button button-secondary ff-repeatable-logic-button-remove"> </button>';
		return;
		echo '</div>';
        echo '<div class="ff-repeatable-controls-top">';
        	echo '<div class="ff-repeatable-duplicate-above" title="Duplicate above"></div>';
        	echo '<div class="ff-repeatable-add-above" title="Add above"></div>';
        echo '</div>';
        echo '<div class="ff-repeatable-controls-bottom">';
        	echo '<div class="ff-repeatable-duplicate-below" title="Duplicate below"></div>';
        	echo '<div class="ff-repeatable-add-below" title="Add below"></div>';
        echo '</div>';
	}
}