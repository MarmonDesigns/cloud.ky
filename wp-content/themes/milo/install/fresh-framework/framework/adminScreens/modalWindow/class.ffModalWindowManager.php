<?php 

abstract class ffModalWindowManager extends ffModalWindowBasicObject {
	const CLASS_HIDE_MENU = 'hide-menu';
	const CLASS_HIDE_ROUTER = 'hide-router';
	const CLASS_HIDE_MODAL_WINDOW = 'ff-hide-modal-window';

	private $_showMenu = true;

	/**
	 * 
	 * @var array[ffModalWindow]
	 */
	private $_modalWindows = array();

	private $_additionalClasses = array();

	private $_id = null;

	private $_modalWindowClass = null;
	
	private $_differentNavigationMenu = null;

	private $_differentRouterMenu = null;
	
	public function addCssClass( $className ) {
		$this->_additionalClasses[] = $className;
	}

	protected function _getClassesImploded() {
		if( empty( $this->_additionalClasses ) ) {
			return '';
		} else {
			return implode(' ', $this->_additionalClasses);
		}
	}

	protected function _setId( $id ) {
		$this->_id = $id;
	}

	protected function _setModalWindowClass( $class ) {
		$this->_modalWindowClass = $class;
	}

	protected function _initialize() {

	}

	public function getModalWindows() {
		return $this->_modalWindows;
	}

	public function addModalWindow( ffModalWindow $modalWindow ) {
		$this->_modalWindows[ $modalWindow->getSlug() ] = $modalWindow;
	}
	
	protected function _addDifferentNavigationMenu( $name, $slug ) {
		$oneMenu = new stdClass();
		$oneMenu->name = $name;
		$oneMenu->slug = $slug;
		$this->_differentNavigationMenu[] = $oneMenu;
	}
	
	protected function _printNavigationMenu() {
		
		if( !empty( $this->_differentNavigationMenu ) ) {
			echo '<div class="media-frame-menu">';
				echo '<div class="media-menu">';
					foreach( $this->_differentNavigationMenu as $oneMenu) {
						echo '<a href="#'.$oneMenu->slug.'">'.$oneMenu->name.'</a>';
					}
				echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="media-frame-menu">';
		    	echo '<div class="media-menu">';
		    		foreach( $this->_modalWindows as $oneWindow ) {
		    			echo '<a href="#'.$oneWindow->getSlug().'">'.$oneWindow->getName().'</a>';
		    		}
		    	echo '</div>';
		    echo '</div>';
		}
	}

	protected function _printTitle() {
		$firstWindow = reset( $this->_modalWindows );
		echo '<div class="media-frame-title">';
		echo '<h1>'.$firstWindow->getName().'</h1>';
		echo '</div>';
	}
	
	protected function _printToolbar() {
		foreach( $this->_modalWindows as $oneWindow ) {
			foreach( $oneWindow->getViews() as $oneView ) {
				$oneView->printToolbar();
			}
		}
	}
	
	protected function _addDifferentRouterMenu( $name, $slug ) {
		$newMenu = new stdClass();
		$newMenu->name = $name;
		$newMenu->slug = $slug;
		
		$this->_differentRouterMenu[] = $newMenu;
	}

	protected function _printRouter() {
		if( empty( $this->_differentRouterMenu ) ) {
			$style = '';
			foreach( $this->_modalWindows as $oneWindow ) {
				echo '<div class="media-frame-router ff-router-'.$oneWindow->getSlug().'" '. $style.'>';
					echo '<div class="media-router">';
					$active = 'active';
					foreach( $oneWindow->getViews() as $oneView ) {
						echo '<a href="#'.$oneWindow->getSlug().'-'.$oneView->getSlug().'" class="media-menu-item '.$active.'">'.$oneView->getName().'</a>';
						$active = '';
					}
	
					echo '</div>';
				echo '</div>';
	
				$style='style="display:none;"';
			}
		} else {
			$style = '';
			foreach( $this->_modalWindows as $oneWindow ) {
				echo '<div class="media-frame-router ff-router-'.$oneWindow->getSlug().'" '. $style.'>';
					echo '<div class="media-router">';
					$active = 'active';
					foreach( $this->_differentRouterMenu as $oneMenu) {
						echo '<a href="#'.$oneWindow->getSlug().'-'.$oneMenu->slug.'" class="media-menu-item '.$active.' '.$oneMenu->slug.'">'.$oneMenu->name.'</a>';
						$active = '';
					}
				
					echo '</div>';
				echo '</div>';
			
				$style='style="display:none;"';
			}
		}

	}

	protected function _printFrames() {
		$styleFrameSection = '';
		foreach( $this->_modalWindows as $oneWindow ) {


			$style = '';
			echo '<div class="ff-frame-content-section ff-frame-content-section-'.$oneWindow->getSlug().'" '.$styleFrameSection.'>';
			foreach( $oneWindow->getViews() as $oneView ) {

				echo '<div class="media-frame-content ff-frame-'.$oneWindow->getSlug().'-'.$oneView->getSlug().'" '.$style.'>';
					if( $oneView->getWrappedInnerContent() ) {
						echo '<div class="media-frame-content-inner">';
					}

						$oneView->render();

					if( $oneView->getWrappedInnerContent() ) {
						echo '</div>';
					}

					// AJAX INFO
					echo '<div class="ff-ajax-info" style="display:none;">';
						echo '<div class="ff-manager-class">';
							echo get_class( $this );
						echo '</div>';
						echo '<div class="ff-window-class">';
							echo get_class( $oneWindow );
						echo '</div>';
						echo '<div class="ff-view-class">';
							echo get_class( $oneView );
						echo '</div>';
					echo '</div>';

				echo '</div>';
				$style = 'style="display:none;"';
			}

			echo '</div>';

			$styleFrameSection = 'style="display:none;"';
		}
	}

	public function printWindow() {
		if( empty( $this->_modalWindows) ) return;

		echo '<style>.ff-media-modal {display:none;}</style>';
		echo '<div id="'.$this->_id.'" class="ff-media-modal '.$this->_modalWindowClass.'">';
   			echo '<div class="media-modal">';
      			echo '<a class="media-modal-close" href="#" title="Close"><span class="media-modal-icon"></span></a>';
      			echo '<div class="media-modal-content">';
      				echo '<div class="media-frame wp-core-ui '.$this->_getClassesImploded().'" id="">';
      					$this->_printNavigationMenu();
      					$this->_printTitle();
      					$this->_printRouter();
      					$this->_printFrames();
      					$this->_printToolbar();
      					//$this->_
					echo '</div>';
      			echo '</div>';
      		echo '</div>';
      		echo '<div class="media-modal-backdrop"></div>';
      	echo '</div>';
	}
}
