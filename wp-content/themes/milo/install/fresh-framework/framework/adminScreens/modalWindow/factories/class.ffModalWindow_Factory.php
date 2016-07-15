<?php

class ffModalWindowFactory extends ffFactoryAbstract {
	private $_dependentClassesLoaded = false;

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffStyleEnqueuer
	 */
	private $_styleEnqueuer = null;

	/**
	 * @var ffScriptEnqueuer
	 */
	private $_scriptEnqueuer = null;

	
	private $_printed = array();

	public function __construct($classLoader) {
		parent::__construct($classLoader);

		$c = ffContainer::getInstance();

		$this->_setWPLayer( $c->getWPLayer() );
		$this->_setScriptEnqueuer( $c->getScriptEnqueuer() );
		$this->_setStyleEnqueuer( $c->getStyleEnqueuer() );
	}

	public function getModalWindowManagerConditions() {
		$this->_loadDependentClasses();

		$classLoader = $this->_getClassloader();

		$classLoader->loadClass('ffModalWindowManagerConditions');
		$classLoader->loadClass('ffModalWindowConditions');
		$classLoader->loadClass('ffModalWindowConditionsViewDefault');
	

		$modalWindowConditionsViewDefault = new ffModalWindowConditionsViewDefault( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );

		$modalWindowConditions = new ffModalWindowConditions( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );

		$modalWindowManagerConditions = new ffModalWindowManagerConditions( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );

		$modalWindowConditions->addViewObject( $modalWindowConditionsViewDefault );
		$modalWindowManagerConditions->addModalWindow( $modalWindowConditions);

		return $modalWindowManagerConditions;
	}

	/**
	 * 
	 * @return ffModalWindowManagerSectionPicker
	 */
	public function getModalWindowSectionPicker() {
		$this->_loadDependentClasses();
		
		$classLoader = $this->_getClassloader();
		
		$classLoader->loadClass('ffModalWindowManagerSectionPicker');
		$classLoader->loadClass('ffModalWindowSectionPicker');
		$classLoader->loadClass('ffModalWindowSectionPickerViewDefault');
		
		

		$modalWindowSectionPickerViewDefault = new ffModalWindowSectionPickerViewDefault( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$modalWindowSectionPicker = new ffModalWindowSectionPicker( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		
		$modalWindowManagerSectionPicker = new ffModalWindowManagerSectionPicker( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		
		$modalWindowSectionPicker->addViewObject( $modalWindowSectionPickerViewDefault );
		$modalWindowManagerSectionPicker->addModalWindow( $modalWindowSectionPicker);

		return $modalWindowManagerSectionPicker;
	}

	// Color Modal


	public function getModalWindowManagerLibraryColorEditor() {
		$this->_loadDependentClasses();

		$classLoader = $this->_getClassloader();

		$classLoader->loadClass('ffModalWindowManagerLibraryColorEditor');
		$classLoader->loadClass('ffModalWindowLibraryColorEditor');
		$classLoader->loadClass('ffModalWindowLibraryColorEditorViewDefault');

		$viewDefault = new ffModalWindowLibraryColorEditorViewDefault( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$window = new ffModalWindowLibraryColorEditor( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$manager = new ffModalWindowManagerLibraryColorEditor( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );

		$window->addViewObject( $viewDefault );
		$manager->addModalWindow( $window );

		return $manager;
	}

	public function getModalWindowManagerLibraryColorPicker() {

		$this->_loadDependentClasses();

		$classLoader = $this->_getClassloader();
		$classLoader->loadClass('ffModalWindowManagerLibraryColorPicker');
		$classLoader->loadClass('ffModalWindowLibraryColorPicker');
		$classLoader->loadClass('ffModalWindowLibraryColorPickerViewDefault');
		$classLoader->loadClass('ffModalWindowLibraryColorPickerColorPreparator');

		//ffLessUserSelectedColorsDataStorage $lessUserSelectedColors, ffUserColorLibrary $userColorLibrary, ffLessSystemColorLibrary $systemColorLibrary, ffLessSystemColorLibraryBackend $systemColorLibraryBackend

		$libManager = ffContainer::getInstance()->getLibManager();
		$assets = ffContainer::getInstance()->getAssetsIncludingFactory();
		$preparator = new ffModalWindowLibraryColorPickerColorPreparator(
				$assets->getLessUserSelectedColorsDataStorage(),
				$libManager->createUserColorLibrary(),
				$assets->getLessSystemColorLibrary(),
				$assets->getLessSystemColorLibraryBackend(),
				ffContainer::getInstance()->getWPLayer()
		);

		$viewDefault = new ffModalWindowLibraryColorPickerViewDefault( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$viewDefault->setColorLibraryPreparator($preparator);
		$window = new ffModalWindowLibraryColorPicker( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$manager = new ffModalWindowManagerLibraryColorPicker( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );

		$window->addViewObject( $viewDefault );
		$manager->addModalWindow( $window );

		return $manager;
	}
	
	public function getModalWindowManagerLibraryAddGroup() {
		$this->_loadDependentClasses();
		
		$classLoader = $this->_getClassloader();
		$classLoader->loadClass('ffModalWindowManagerLibraryAddGroup');
		$classLoader->loadClass('ffModalWindowLibraryAddGroup');
		$classLoader->loadClass('ffModalWindowLibraryAddGroupViewDefault');
	
		
		$viewDefault = new ffModalWindowLibraryAddGroupViewDefault( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$window = new ffModalWindowLibraryAddGroup( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$manager = new ffModalWindowManagerLibraryAddGroup( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		
		$window->addViewObject( $viewDefault );
		$manager->addModalWindow( $window );
		
		return $manager;
	}
	
	public function getModalWindowManagerLibraryDeleteGroup() {
		$this->_loadDependentClasses();
		
		$classLoader = $this->_getClassloader();
		$classLoader->loadClass('ffModalWindowManagerLibraryDeleteGroup');
		$classLoader->loadClass('ffModalWindowLibraryDeleteGroup');
		$classLoader->loadClass('ffModalWindowLibraryDeleteGroupViewDefault');
		
		
		$viewDefault = new ffModalWindowLibraryDeleteGroupViewDefault( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$window = new ffModalWindowLibraryDeleteGroup( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$manager = new ffModalWindowManagerLibraryDeleteGroup( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		
		$window->addViewObject( $viewDefault );
		$manager->addModalWindow( $window );
		
		return $manager;
	}

	public function printModalWindowManagerLibraryColor() {
        return;

		$managerPicker = $this->getModalWindowManagerLibraryColorPicker();

		$managerPicker->printWindow();
		$managerEditor = $this->getModalWindowManagerLibraryColorEditor();
		$managerEditor->printWindow();

		$managerAddGroup = $this->getModalWindowManagerLibraryAddGroup();
		$managerAddGroup->printWindow();
		
		$managerDeleteGroup = $this->getModalWindowManagerLibraryDeleteGroup();
		$managerDeleteGroup->printWindow();
		
		return;
	}


	// Icon Modal


	// public function getModalWindowManagerLibraryIconEditor() {
	// 	$this->_loadDependentClasses();

	// 	$classLoader = $this->_getClassloader();

	// 	$classLoader->loadClass('ffModalWindowLibraryIconEditor');
	// 	$classLoader->loadClass('ffModalWindowLibraryIconEditorViewDefault');

	// 	$viewDefault = new ffModalWindowLibraryIconEditorViewDefault( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
	// 	$window = new ffModalWindowLibraryIconEditor( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
	// 	$manager = new ffModalWindowManagerLibraryIconEditor( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );

	// 	$window->addViewObject( $viewDefault );
	// 	$manager->addModalWindow( $window );

	// 	return $manager;
	// }

	public function getModalWindowManagerLibraryIconPicker() {

		$this->_loadDependentClasses();

		$classLoader = $this->_getClassloader();
		$classLoader->loadClass('ffModalWindowManagerLibraryIconPicker');
		$classLoader->loadClass('ffModalWindowLibraryIconPicker');
		$classLoader->loadClass('ffModalWindowLibraryIconPickerViewDefault');
		$classLoader->loadClass('ffModalWindowLibraryIconPickerIconPreparator');

		//ffLessUserSelectedIconsDataStorage $lessUserSelectedIcons, ffUserIconLibrary $userIconLibrary, ffLessSystemIconLibrary $systemIconLibrary, ffLessSystemIconLibraryBackend $systemIconLibraryBackend

		$libManager = ffContainer::getInstance()->getLibManager();
		$assets = ffContainer::getInstance()->getAssetsIncludingFactory();
		$preparator = new ffModalWindowLibraryIconPickerIconPreparator(
				ffContainer::getInstance()->getWPLayer(),
				ffContainer::getInstance()->getFileSystem()
		);

		$viewDefault = new ffModalWindowLibraryIconPickerViewDefault( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$viewDefault->setIconLibraryPreparator($preparator);
		$window = new ffModalWindowLibraryIconPicker( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );
		$manager = new ffModalWindowManagerLibraryIconPicker( $this->_getWPLayer(), $this->_getScriptEnqueuer(), $this->_getStyleEnqueuer() );

		$window->addViewObject( $viewDefault );
		$manager->addModalWindow( $window );

		return $manager;
	}
	
	public function printModalWindowSectionPicker() {
		if( !isset( $this->_printed[ 'sectionPicker'] ) ) {
			$sectionPicker = $this->getModalWindowSectionPicker();
			$sectionPicker->printWindow();
			$this->_printed['sectionPicker'] = true;
		}
	}

	public function printModalWindowManagerLibraryIcon() {

		$managerPicker = $this->getModalWindowManagerLibraryIconPicker();
		$managerPicker->printWindow();

		// $managerEditor = $this->getModalWindowManagerLibraryIconEditor();
		// $managerEditor->printWindow();

		return;
	}



	private function _loadDependentClasses() {
		if( $this->_dependentClassesLoaded == false ) {
			$this->_dependentClassesLoaded = true;

			$cl = $this->_getClassloader();
			$cl->loadClass('ffModalWindowBasicObject');
			$cl->loadClass('ffModalWindowManager');
			$cl->loadClass('ffModalWindow');
			$cl->loadClass('ffModalWindowView');
;
			//$this->_getScriptEnqueuer()->addScriptFramework('modalWindow', '/framework/adminScreens/modalWindow/modalWindow.js');
			$this->_getWPLayer()->wp_enqueue_media();

		}
	}

	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return ffStyleEnqueuer
	 */
	protected function _getStyleEnqueuer() {
		return $this->_styleEnqueuer;
	}

	/**
	 * @param ffStyleEnqueuer $styleEnqeueur
	 */
	protected function _setStyleEnqueuer(ffStyleEnqueuer $styleEnqueuer) {
		$this->_styleEnqueuer= $styleEnqueuer;
		return $this;
	}

	/**
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {

		return $this->_scriptEnqueuer;
	}

	/**
	 * @param ffScriptEnqueuer $scriptEnqeueur
	 */
	protected function _setScriptEnqueuer(ffScriptEnqueuer $scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}

}