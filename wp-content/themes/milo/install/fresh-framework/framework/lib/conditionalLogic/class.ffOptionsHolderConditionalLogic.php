<?php

class ffOptionsHolderConditionalLogic extends ffOptionsHolder {
	const SECTION_NAME = 'fw-conditional-logic';
	public function getOptions() {
		$struct = $this->_getOnestructurefactory()
		->createOneStructure( ffOptionsHolderConditionalLogic::SECTION_NAME );
	
		$struct->startSection('logic-use-or-not');
		
		$struct->addOption(ffOneOption::TYPE_CHECKBOX, 'logic_use_or_not', 'Apply only if:', 0, '')->addParam('class', 'ff-conditional-logic-checkbox');

		$struct->addElement( ffOneElement::TYPE_NEW_LINE );
		
		$struct->endSection();
		
		
		
		// LOGIC OR
		$struct->startSection('logic-or', ffOneSection::TYPE_REPEATABLE_VARIABLE)->addParam('class', 'ff-conditional-logic-options');
		$struct->startSection('logic-or', ffOneSection::TYPE_REPEATABLE_VARIATION);
		// LOGIC AND
		$struct->startSection('logic-and', ffOneSection::TYPE_REPEATABLE_VARIABLE);
		$struct->startSection('logic-and', ffOneSection::TYPE_REPEATABLE_VARIATION);
		// ONE TABLE
		$struct->addElement( ffOneElement::TYPE_TABLE_START)->addParam('class', 'ff-repeatable-logic-table');
		$struct->addElement(ffOneElement::TYPE_HTML,'','<tr>');
		$struct->addElement(ffOneElement::TYPE_HTML,'','<td class="ff-repeatable-content-type">');
		
		// ONE TD
		$struct->addOption(ffOneOption::TYPE_SELECT_CONTENT_TYPE, 'content_type', '', 'post-extra-|-post-format', '')->addParam('value', 'post-extra-|-post-format');
		// END TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','</td>');
		
		// START TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','<td class="ff-repeatable-content-operator">');
		
		$struct->addOption(ffOneOption::TYPE_SELECT, 'equal', '', 'equal', '')
		->addSelectValue('is equal to', 'equal')
		->addSelectValue('is not equal to', 'not_equal')
		->addParam('print_label', false);
		// END TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','</td>');
			
		// START TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','<td class="ff-repeatable-content-value">');
		
		$struct->addOption(ffOneOption::TYPE_SELECT2, 'content_id', '', '', '')->addParam('type', 'multiple');
		
		// END TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','</td>');
			
		// START TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','<td class="ff-repeatable-content-add">');
		
		$struct->addElement( ffOneElement::TYPE_HTML,'','<input type="submit" name="submit" id="ff_delete_cache" class="button button-secondary ff-repeatable-add-below ff-repeatable-logic-button-and" value="and">');
			
		// END TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','</td>');
			
		// START TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','<td class="ff-repeatable-content-remove">');
		
		$struct->addElement( ffOneElement::TYPE_HTML,'','<button class="button button-secondary ff-repeatable-logic-button-remove ff-repeatable-remove"> </button>');
		
		// END TD
		$struct->addElement(ffOneElement::TYPE_HTML,'','</td>');
		
		
		$struct->addElement(ffOneElement::TYPE_HTML,'','</tr>');
		$struct->addElement( ffOneElement::TYPE_TABLE_END);
		
		$struct->endSection();
		$struct->endSection();
		
		
		
		
		$struct->addElement( ffOneElement::TYPE_HTML,'','<input type="submit" name="submit" id="ff_delete_cache" class="button button-secondary ff-repeatable-add-below ff-repeatable-logic-button-or" value="or">');
			
		$struct->endSection();
		$struct->endSection();
			
		return $struct;
	}
}