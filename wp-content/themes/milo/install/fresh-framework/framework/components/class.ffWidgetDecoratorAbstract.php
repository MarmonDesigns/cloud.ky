<?php
/**
 * From this class have to be inherited all widgets. It handle creating of
 * options (which are stored in extern class, because we need them in backend
 * and in frontend too). Also handling printing the widget (also in extern
 * class since we could use the parts across the framework)
 * 
 * @since 0.1
 * @author FRESHFACE
 */
abstract class ffWidgetDecoratorAbstract extends WP_Widget {

/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	protected $_widgetAdminTitle =       '';
	protected $_widgetAdminDescription = '';
	protected $_widgetWrapperClasses =   '';
	protected $_widgetFormSize =         '';
	protected $_widgetName = '';
    protected $_widgetAdditionalClasses = '';
	
	const WIDGET_FORM_SIZE_WIDE = 'wide';
	const WIDGET_FORM_SIZE_THIN = 'thin';
	
	/**
	 * 
	 * @var ffContainer
	 */
	protected $_container = null;
	
	/**
	 * 
	 * @var ffComponent_Factory
	 */
	protected $_componentFactory = null;
	
	
	/**
	 * 
	 * @var unknown
	 */
	protected $_componentPrinter = null;
	
	/**
	 * 
	 * @var ffOptions_Factory
	 */
	protected $_optionsFactory = null;
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	
	
	public function __construct() {
		
		$options = array('classname' => get_class($this) .' ' . $this->_widgetAdditionalClasses, 'description' =>  $this->_widgetAdminDescription  );
		$controls = array('width' => $this->_getFormSize(), 'height' => 200);
		
		parent::__construct( get_class($this) ,  $this->_widgetAdminTitle , $options, $controls);
		
		$this->_setComponentfactory( ffContainer::getInstance()->getComponentFactory() );
		$this->_setContainer( ffContainer::getInstance() );
		$this->_setOptionsFactory( ffContainer::getInstance()->getOptionsFactory() );

//        ffContainer()->getFrameworkScriptLoader()->requireFrsLib()->requireFrsLibOptions();
	}
	
	public function form( $instance ) {

		// create proprietary options for this widget
		$options = $this->_getComponentfactory()->createOptionsHolder( $this->_widgetName );
		
		// get a widget printer factory
		$printer = $this->_getOptionsFactory()->createOptionsPrinterBoxed( $instance, $options->getOptions() );
		
		// set Name Param prefix, like widget-name[widget-id]
		$printer->setNameprefix( $this->_getFieldNamePrefix());
		$printer->setIdprefix( $this->_getFieldIdPrefix() );
		
		echo '<div class="ff-widget-options-wrapper">';
		// same as print;
		$printer->walk();

		echo '</div>';
	}
	
	public function update( $newInstance, $oldInstance) {
		return $newInstance;
	}
	
	public function widget($args, $instance) {
		$widgetPrinter = $this->_getComponentfactory()->createComponentPrinter( $this->_widgetName );
		$query = $this->_createOptionsQuery($instance);
		$args  = $this->_influenceArgs($args);
		$this->_printWidget($args, $query, $widgetPrinter);
	}
	
	private function _createOptionsQuery( $instance ) {
		$optionsHolder = $options = $this->_getComponentfactory()->createOptionsHolder( $this->_widgetName );
		$query = $this->_getOptionsFactory()->createQuery( $instance, $optionsHolder );
		return $query;
	}

/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	
	private function _influenceArgs( $args ) {
		//$_widgetName
		$newWidgetClassName = $this->_widgetName . ' ' . $this->_widgetWrapperClasses;
		
		$args['before_widget'] = str_replace( $this->_widgetName, $newWidgetClassName, $args['before_widget']);
		
		return $args;
	}
	
	protected function _getFormSize(){
		$size = 250;
		if( $this->_widgetFormSize == ffWidgetDecoratorAbstract::WIDGET_FORM_SIZE_WIDE ){
			$size = 430;
		}
		return $size;
	}
	
	protected function _printWidget( $args, ffOptionsQuery $query, $widgetPrinter ) {
		$widgetPrinter->printComponent( $args, $query );
	}
	
	protected function _getFieldIdPrefix() {
		return 'widget-' . $this->id_base . '-' . $this->number . '-';
	}
	
	protected function _getFieldNamePrefix() {
		return 'widget-' . $this->id_base . '[' . $this->number . ']';
	}
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/

	/**
	 * @return ffComponent_Factory
	 */
	protected function _getComponentfactory() {
		return $this->_componentFactory;
	}
	
	/**
	 * @param ffComponent_Factory $_componentFactory
	 */
	protected function _setComponentfactory(ffComponent_Factory $componentFactory) {
		$this->_componentFactory = $componentFactory;
		return $this;
	}

	/**
	 * @return ffContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}
	
	/**
	 * @param ffContainer $container
	 */
	protected function _setContainer(ffContainer $container) {
		$this->_container = $container;
		return $this;
	}

	/**
	 * @return ffOptions_Factory
	 */
	protected function _getOptionsFactory() {
		return $this->_optionsFactory;
	}
	
	/**
	 * @param ffOptions_Factory $optionsFactory
	 */
	protected function _setOptionsFactory(ffOptions_Factory $optionsFactory) {
		$this->_optionsFactory = $optionsFactory;
		return $this;
	}
	
}