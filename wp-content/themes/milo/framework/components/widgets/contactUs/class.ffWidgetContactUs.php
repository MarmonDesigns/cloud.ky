<?php

class ffWidgetContactUs extends ffWidgetDecoratorAbstract {
	protected $_widgetAdminTitle =       'Contact Us - Custom Widget';
	protected $_widgetAdminDescription = 'Displays your contact info';
	protected $_widgetWrapperClasses =   '';
	protected $_widgetName = 'ContactUsWidget';
    protected $_widgetAdditionalClasses = 'widget_contact';
	protected $_widgetFormSize = ffWidgetDecoratorAbstract::WIDGET_FORM_SIZE_WIDE;
}