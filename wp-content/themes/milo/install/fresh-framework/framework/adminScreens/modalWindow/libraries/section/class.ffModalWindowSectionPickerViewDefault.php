<?php
 
class ffModalWindowSectionPickerViewDefault extends ffModalWindowView {

	/**
	 *
	 * @var ffModalWindowLibraryIconPickerIconPreparator
	 */
	private $iconLibraryPreparator = null;

	// Toolbar
	protected $_toolbarCancelText = "Cancel";
	protected $_toolbarOKText = "Add Section";
	protected $_toolbarHasSizeSlider = true;

	protected function _initialize() {
		$this->_setViewName('Default');
		$this->_setWrappedInnerContent( false );
	}

	protected  function _requireAssets() {
		
		$this->_getScriptEnqueuer()->getFrameworkScriptLoader()
		->requireSelect2()
		->requireFrsLib()
		->requireFrsLibOptions()
		->requireFrsLibModal();
		
		$this->_getStyleEnqueuer()->addStyleFramework('ff-section-picker', '/framework/adminScreens/modalWindow/libraries/section/sectionPicker.css');
		$this->_getScriptEnqueuer()->getFrameworkScriptLoader()->addAdminColorsToStyle('ff-section-picker');
		$this->_getStyleEnqueuer()->addLessImportFile('ff-section-picker', 'ff-bootstrap-mixins-less', ffContainer::getInstance()->getLessWPOptionsManager()->getFrameworkBootstrapMixinsLessUrl() );
		$this->_getStyleEnqueuer()->addLessImportFile('ff-section-picker', 'ff-fresh-mixins-less', ffContainer::getInstance()->getLessWPOptionsManager()->getFrameworkFreshMixinsLessUrl() );
		$this->_getScriptEnqueuer()->addScriptFramework('ff-imagesloaded-js', '/framework/extern/imagesloaded/imagesloaded.min.js', array('jquery'));
		$this->_getScriptEnqueuer()->addScriptFramework('ff-packery-js', '/framework/extern/packery/packery.pkgd.min.js', array('jquery'));
		
	
	}

	protected function _render() {
		/*
		 * type name
		 * type value
		 * 
		 * image
		 * name
		 * value
		 * 
		 * title
		 * description
		 * 
		 */
		// $iconLib = ffContainer::getInstance()->getLibManager()->createUserIconLibrary();
	?>
			<div class="attachments-browser">

				<div class="ff-section-picker">

					<div class="ff-section-picker__categories">
						<div class="ff-section-picker__category"></div>
					</div>

					<div class="ff-section-picker__list">
						<div class="ff-section-picker__list-item ff-section-picker__list-item--active">
							<img class="ff-section-picker__list-item__image" src="" alt="">
							<div class="ff-section-picker__list-item__name"></div>
						</div>
					</div>

				</div>

				<?php //$this->_printSidebar(); ?>
			</div>

		<?php
	}

	private function _printSidebar() {
	?>



	<?php
	}

	public function proceedAjax( ffAjaxRequest $request ) {
		 


		switch( $request->specification['action'] ) {
			case 'delete' :

				break;

			case 'new':

				break;

			case 'edit':

				break;

			case 'duplicate':
				$userIcons = $this->_getIconLibraryPreparator()->getPreparedUserIcons();
				//var_dump( $userIcons );
				$firstIcon = $userIcons[''][0];

				$groupNew = array();
				$groupNew['new-icons'][] = $firstIcon;
				ob_start();
				$this->_printUserIcons( $groupNew );
				$icons = ob_get_contents();
				ob_end_clean();

				$toPrint = array();
				$toPrint['html'] = $icons;
				$toPrint['group_name'] = 'new-icons';
				echo json_encode( $toPrint );

				break;
		}
	}


	private function _printForm( $data = array() ) {

	}

	/**
	 *
	 * @return ffModalWindowLibraryIconPickerIconPreparator
	 */
	protected function _getIconLibraryPreparator() {
		return $this->_iconLibraryPreparator;
	}

	/**
	 *
	 * @param ffModalWindowLibraryIconPickerIconPreparator $iconLibraryPreparator
	 */
	public function setIconLibraryPreparator(ffModalWindowLibraryIconPickerIconPreparator $iconLibraryPreparator) {
		$this->_iconLibraryPreparator = $iconLibraryPreparator;
		return $this;
	}

}