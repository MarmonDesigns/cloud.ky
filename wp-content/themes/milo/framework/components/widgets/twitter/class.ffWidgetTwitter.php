<?php

class ffWidgetTwitter extends ffWidgetDecoratorAbstract {
	protected $_widgetAdminTitle =       "Twitter - Custom Widget";
	protected $_widgetAdminDescription = "Displays your latest tweets";
	protected $_widgetWrapperClasses =   "";
	protected $_widgetName = 'TwitterWidget';
	//protected $_widgetFormSize =         //frameworkWidget::WIDGET_FORM_SIZE_WIDE;

	/**
	 * Overloaded method to set custom dependencies ( Tester feeder )
	 * @see ffWidgetDecoratorAbstract::_printWidget()
	 * @param $widgetPrinter ffWidgetTester_Printer
	 */
// 	protected function _printWidget($args, ffOptionsQuery $query, $widgetPrinter) {
// 		$widgetPrinter->printComponent($args, $query, $widgetPrinter );
// 	}
}