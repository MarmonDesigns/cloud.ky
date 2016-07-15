<?php

class ffMetaBoxManager extends ffBasicObject {
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffMetaBoxFactory
	 */
	private $_metaBoxFactory = null;
	
	private $_metaBoxesClassNames = array();
	
	/**
	 * 
	 * @var array[ffMetaBox]
	 */
	private $_metaBoxesClasses = array();
	
	private $_metaBoxesForRemove = array();
	
	public function __construct( ffWPLayer $WPLayer, ffMetaBoxFactory $metaBoxFactory) {
		$this->_setWplayer($WPLayer);
		
		$this->_getWplayer()->add_action('add_meta_boxes', array( $this, 'actAddMetaBoxes' ) );
		$this->_getWplayer()->add_action('save_post', array( $this, 'actSavePost') );
	
		$this->_getWplayer()->add_action('admin_menu', array( $this, 'actRemoveMetaBoxes') );
		
		$this->_setMetaBoxFactory($metaBoxFactory);
		
		
		//add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );
	}
	
	public function actRemoveMetaBoxes() {
		// TODO
	}
	
	public function removeMetabox( $id, $postType, $type ) {
		$metaboxForRemove = array(
			'id' => $id,
			'post-type' => $postType,
			'type' => $type
		);
		
		
		
		$this->_metaBoxesForRemove[] = $metaboxForRemove;
	}
	
	public function hookAjax() {
		
		$this->_getWPLayer()->getHookManager()->addAjaxRequestOwner('ffMetaBoxManager', array( $this, 'actMetaBoxAjax') );
	}
	
	public function actMetaBoxAjax( ffAjaxRequest $request ) {

		$metaboxClass = $request->specification['metaboxClass'];
		
		$this->_createMetaBoxClasses();
		
		if( isset( $this->_metaBoxesClasses[ $metaboxClass ] ) ) {
			$metaBoxClass = $this->_metaBoxesClasses[ $metaboxClass ];
			$metaBoxClass->ajaxRequest( $request );
		}
	}
	
	public function actModalWindowAjax( ffAjaxRequest $request ) {
			
		// ffModalWindowManagerTest
		$managerClass = $request->specification['managerClass'];
		// ModalWindowManagerTest
		$managerClassWithoutFF = substr( $managerClass, 2 );//str_replace('ff', '', $managerClass);
		// getModalWindowManagerTest
		$managerClassMethodName = 'get'.$managerClassWithoutFF;
	
		$factory = $this->_getModalWindowFactory();
	
		if( method_exists( $factory, $managerClassMethodName) ) {
			// create a modal window
			$modalWindowManager = call_user_func( array( $factory, $managerClassMethodName) );
				
			$requestModalClass = $request->specification['modalClass'];
			foreach( $modalWindowManager->getModalWindows() as $oneModalWindow ) {
				if( $oneModalWindow instanceof $requestModalClass ) {
					$requestViewClass = $request->specification['viewClass'];
						
					foreach( $oneModalWindow->getViews() as $oneView ) {
						if( $oneView instanceof  $requestViewClass ) {
							$oneView->proceedAjax( $request );
						}
					}
						
				}
			}
		}
	
	
		//var_dump($this->_getModalWindowFactory());
	}
	
	
	public function actSavePost( $postId ) {
	
		if( isset( $_POST[ ffMetaBoxView::USED_META_BOX_COLLECTOR_NAME ] ) ) {
			$metaBoxClassesUsed = $_POST[ ffMetaBoxView::USED_META_BOX_COLLECTOR_NAME ];
			
			$this->_metaBoxesClassNames = $metaBoxClassesUsed;
			$this->_createMetaBoxClasses();
			
			foreach( $this->_metaBoxesClasses as $oneClass ) {
				$oneClass->save( $postId );
			}
		}
	}
	
	public function actAddMetaBoxes() {
		if( empty( $this->_metaBoxesClassNames ) ) {
			return false;
		}
		
		$this->_createMetaBoxClasses();

		foreach( $this->_metaBoxesClasses as $className => $oneClass ) {
			$postTypes = $oneClass->getPostType();

			foreach( $postTypes as $oneType ) {
				$this->_getWplayer()
					->add_meta_box(
										$oneClass->getId(),
										$oneClass->getTitle(),
										array( $oneClass, 'render'),
										$oneType,
										$oneClass->getContext(), 
										$oneClass->getPriority()
									);
			}
		}
	}
	
	private function _createMetaBoxClasses() {
		foreach( $this->_metaBoxesClassNames as $oneClassName ) {
			$this->_metaBoxesClasses[ $oneClassName ] = $this->_getMetaBoxFactory()->createMetaBox($oneClassName);
		}
	}
	
	public function addMetaBoxClassName( $metaBoxClassName ) {
		$this->_metaBoxesClassNames[] = $metaBoxClassName;
	}
	
	/**
	 *
	 * @return ffWPLayer
	 */
	protected function _getWplayer() {
		return $this->_WPLayer;
	}
	
	/**
	 *
	 * @param ffWPLayer $_WPLayer        	
	 */
	protected function _setWplayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	/**
	 *
	 * @return ffMetaBoxFactory
	 */
	protected function _getMetaBoxFactory() {
		return $this->_metaBoxFactory;
	}
	
	/**
	 *
	 * @param ffMetaBoxFactory $metaBoxFactory        	
	 */
	protected function _setMetaBoxFactory(ffMetaBoxFactory $metaBoxFactory) {
		$this->_metaBoxFactory = $metaBoxFactory;
		return $this;
	}
	
	

}