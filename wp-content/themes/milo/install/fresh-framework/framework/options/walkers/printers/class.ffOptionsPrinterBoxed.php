<?php

class ffOptionsPrinterBoxed extends ffOptionsPrinter {
	
	public function __construct( $optionsArrayData = null, $optionsStructure = null, ffOptionsPrinterComponent_Factory $printerComponentFactory, ffOptionsPrinterDataBoxGenerator $optionsPrinterDataBoxGenerator ) {
		
		parent::__construct($optionsArrayData,$optionsStructure, $printerComponentFactory, $optionsPrinterDataBoxGenerator);
		$this->_addCallbacks();
	}
	
	private function _addCallbacks() {
		$this->_addCalback( ffOptionsPrinter::ACT_BEFORE_REPEATABLE_NODE, ffOptionsPrinter::POSITION_LAST, array($this, '_printRepeatableItemHeader') );
		$this->_addCalback( ffOptionsPrinter::ACT_BEFORE_REPEATABLE_VARIABLE_NODE, ffOptionsPrinter::POSITION_LAST, array($this, '_printRepeatableItemHeader') );
		
		
		$this->_addCalback( ffOptionsPrinter::ACT_AFTER_REPEATABLE_NODE, ffOptionsPrinter::POSITION_FIRST, array($this, '_printRepeatableItemHeaderEnd') );
		$this->_addCalback( ffOptionsPrinter::ACT_AFTER_REPEATABLE_VARIABLE_NODE, ffOptionsPrinter::POSITION_FIRST, array($this, '_printRepeatableItemHeaderEnd') );
		
		$this->_addCssClass( ffOptionsPrinter::CSS_FF_REPEATABLE, 'ff-repeatable-boxed');
	}

	//_beforeRepeatableNodeCallback
	//_beforeRepeatableVariableNodeCallback
	protected function _printRepeatableItemHeader( $item ) {
		$sectionName = $item->getParam('section-name');
		
		echo '<div class="ff-repeatable-header ff-repeatable-drag ff-repeatable-handle">';
			echo '<table class="ff-repeatable-header-table"><tbody><tr>';
			echo '<td class="ff-repeatable-item-number"></td>';
				echo '<td class="ff-repeatable-title">'.$sectionName.'</td>';
				echo '<td class="ff-repeatable-description"> </td>';
            echo '</tr></tbody></table>';
            echo '<div class="ff-repeatable-handle"></div>';
            
            //var_dump( $item->getParam('advanced-picker-section-image') );
            
            ?>
            <div class="ff-repeatable-settings"></div>
            <?php 
            
            	if( $item->getParam('advanced-picker-section-image') != null ) {
					$url = $item->getParam('advanced-picker-section-image');
					$resizedUrl = $url;// fImg::resize($url, 600);
					
					echo '<div class="ff-repeatable-preview">';
            		echo '<img src="'.$resizedUrl.'" alt="">';
            		echo '</div>';
				}
            
            ?>

            <div class="ff-popup-container">
                <div class="ff-popup-wrapper">
                    <div class="ff-popup-backdrop"></div>
                    <ul class="ff-repeatable-settings-popup ff-popup">
                        <?php
                        /*
                        <li class="ff-popup-button-wrapper">
                            <div class="ff-popup-button ff-repeatable-duplicate-above">Duplicate above</div>
                        </li>
                        <li class="ff-popup-button-wrapper">
                            <div class="ff-popup-button ff-repeatable-duplicate-below">Duplicate below</div>
                        </li>
                        */
                        ?>
                        <li class="ff-popup-button-wrapper">
                            <div class="ff-popup-button ff-repeatable-remove">Remove</div>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
		echo '</div>';
		echo '<div class="ff-repeatable-content">';

	}
	
	protected function _printRepeatableItemHeaderEnd() {
		echo '</div>';
		
		
		echo '<div class="ff-repeatable-controls-top ff-repeatable-variation-selector">';
		echo '<div class="ff-repeatable-add-above" title="Add Item"></div>';
		?>
		            <div class="ff-popup-container">
		                <div class="ff-popup-wrapper">
		                    <div class="ff-popup-backdrop"></div>
		                    <ul class="ff-popup ff-repeatable-add-variation-selector-popup">
		                        <li class="ff-popup-button-wrapper">
		                            <div class="ff-popup-button">Placeholder</div>
		                        </li>
		                    </ul>
		                </div>
		            </div>
		            <?php
		echo '</div>';


        echo '<div class="ff-repeatable-controls-bottom ff-repeatable-variation-selector">';
        	echo '<div class="ff-repeatable-add-below" title="Add Item"></div>';
		?>
		            <div class="ff-popup-container">
		                <div class="ff-popup-wrapper">
		                    <div class="ff-popup-backdrop"></div>
		                    <ul class="ff-popup ff-repeatable-add-variation-selector-popup">
		                        <li class="ff-popup-button-wrapper">
		                            <div class="ff-popup-button">Placeholder</div>
		                        </li>
		                    </ul>
		                </div>
		            </div>
		            <?php
        echo '</div>';

        
	}
}