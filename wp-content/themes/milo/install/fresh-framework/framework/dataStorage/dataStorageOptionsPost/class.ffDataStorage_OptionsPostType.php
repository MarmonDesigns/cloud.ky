<?php

class ffDataStorage_OptionsPostType extends ffBasicObject {

################################################################################
# PRIVATE OBJECTS
################################################################################
	/**
	 * 
	 * @var ffPostLayer
	 */
	private $postLayer = null;
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	
	/**
	 * 
	 * @var ffPostGetter
	 */
	private $_postGetter = null;
	
	/**
	 * 
	 * @var array[ffPostCollectionItem]
	 */
	private $_loadedNamespaces = array();
	
	/**
	 * array[ NAMESPACE ] = post ID;
	 */
	private $_slugToIdMap = array();
	
	/**
	 * 
	 * array[ NAMESPACEwithID ] = namespace ( without id )
	 */
	private $_namespaceIdToNamespaceMap = array();
	
	/**
	 * 
	 * @var array[] = $changedSlug
	 * we need to save these slugs at the final hook
	 */
	private $_changedSlugs = array();
	
	/**
	 * 
	 * @var array[] = $changedSlug
	 */
	private $_namespacesToDelete = array();

################################################################################
# CONSTRUCTOR
################################################################################	
	public function __construct( ffPostLayer $postLayer, ffWPLayer $WPLayer) {
		$this->_setWPLayer($WPLayer);
		$this->_setPostLayer($postLayer);
		$this->_getWPLayer()->getHookManager()->addActionShutdown( array( $this, 'actionShutdown' ) );
	}

################################################################################
# ACTIONS
################################################################################
	/**
	 * Save changed options
	 * @return boolean
	 */
	public function actionShutdown() {
 
		if( empty( $this->_changedSlugs ) ) {
			return false;
		}
		
		$slugNames = array_keys( $this->_changedSlugs );
		
		foreach( $slugNames as $oneSlugName ) {
			$id = $this->_getIdOfSlug( $oneSlugName );
			
			$postArray = $this->_preparePostArray( $oneSlugName, $id );
			
			//var_dump( $postArray );
			// We changed some options but the post does not exists right now
			if( null == $id ) {
				$this->_getPostLayer()->getPostUpdater()->insertPost( $postArray );
			// We changed some options and the post exists	
			} else {
				$this->_getPostLayer()->getPostUpdater()->updatePost( $postArray );
			}
		}
	}
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	

	
	public function getOption( $namespace, $name, $defaultValue = null ) {
		$namespaceWithId = $this->_getNamespaceId($namespace);
		$this->_initNamespace($namespaceWithId);
	
		if( isset( $this->_loadedNamespaces[$namespaceWithId][ $name ] ) ) {
			return  $this->_loadedNamespaces[$namespaceWithId][ $name ];
		} else {
			return $defaultValue;
		}
	}
	
	public function setOptionCoded( $namespace, $name, $value ) {
		
		$value = serialize( $value );
		$value = base64_encode( $value );
		
		return $this->setOption($namespace, $name, $value);
		
	}
	
	public function getOptionCoded( $namespace, $name, $defaultValue = null ) {
		$value = $this->getOption($namespace, $name, $defaultValue);
		$value = base64_decode( $value );
		$value = unserialize( $value );
		
		return $value;
	}
	
	public function setOption( $namespace, $name, $value ) {
		$namespaceWithId = $this->_getNamespaceId( $namespace );

		$this->_initNamespace($namespaceWithId);
		$this->_loadedNamespaces[ $namespaceWithId ][ $name ] = $value;
	
		$this->_changedSlugs[ $namespaceWithId ] = true;
	}
	
	public function deleteOption( $namespace, $name ) {
		$namespaceWithId = $this->_getNamespaceId( $namespace );
		$this->_initNamespace($namespaceWithId);
		
		unset( $this->_loadedNamespaces[ $namespaceWithId][ $name ] );
		$this->_changedSlugs[ $namespaceWithId ] = true;
	}
	
	public function deleteNamespace( $namespace ) {
		// TODO real deleting
		$namespaceWithId = $this->_getNamespaceId( $namespace );
		$this->_initNamespace($namespaceWithId);
		
		$this->_loadedNamespaces[ $namespaceWithId ] = array();
	}
	
	public function getAllOptionsForNamespace( $namespace ) {
		$namespaceWithId = $this->_getNamespaceId( $namespace );
		$this->_initNamespace($namespaceWithId);
		
		return array_keys( $this->_loadedNamespaces[ $namespaceWithId] );
	}
	
	public function getAllOptionsForNamespaceWithValues( $namespace ) {
		$namespaceWithId = $this->_getNamespaceId( $namespace );
		$this->_initNamespace($namespaceWithId);
		
		return $this->_loadedNamespaces[ $namespaceWithId];
	}
	
	
################################################################################
# PRIVATE FUNCTIONS
################################################################################
	private function _getIdOfSlug( $slugName ) {
		if( isset( $this->_slugToIdMap[ $slugName ] ) ) {
			return $this->_slugToIdMap[ $slugName ];
		} else {
			return null;
		}
	}
	
	private function _preparePostArray( $slugName, $postId = null ) {
		$postArray = array();
		if( null != $postId ) {
			$postArray['ID'] = $postId;
		}
		
		$postArray['post_name'] = $slugName;
		
		$postContentSerialised = serialize( $this->_loadedNamespaces[ $slugName ] );
		
		$postArray['post_content'] = $postContentSerialised;
		$postArray['post_type'] = 'ff-options';
		$postArray['post_status'] = 'publish';
		$postArray['ping_status'] = 'closed';
		$postArray['comment_status'] = 'closed';
		$postArray['post_title'] = $this->_namespaceIdToNamespaceMap[ $slugName ];
		
		return $postArray;
	}
	

	
	private function _getNamespaceId( $namespace ) {
		$namespaceWithId = $namespace . '-1';
		$this->_namespaceIdToNamespaceMap[ $namespaceWithId ] = $namespace;
		return $namespaceWithId;
	}
	
	private function _initNamespace( $namespace ) {
		
		if( !isset( $this->_loadedNamespaces[ $namespace ] ) ) {
			$optionsPost = $this->_loadedPosts[ $namespace ] = $this->_getPostLayer()->getPostGetter()->getPostBySlug( $namespace, ffDataStorage_OptionsPostTypeRegistrator::OPTIONS_POST_TYPE_SLUG  );
			
			if( $optionsPost instanceof ffPostCollectionItem ) {
				$postContent = $optionsPost->getContent();
				$postContentUnserialised = unserialize( $postContent );
				
				if( empty($postContentUnserialised) ) {
					$postContentUnserialised = array();
				}
				
				$postId = $optionsPost->getID();
				
				
				$this->_loadedNamespaces[ $namespace ] = $postContentUnserialised;
				$this->_slugToIdMap[ $namespace ] = $postId;
			} else {
				$this->_loadedNamespaces[ $namespace ] = array();
			}
		}
		
		//return $this->_loadedNamespaces[ $namespace ];
	}
	 
################################################################################
# GETTERS AND SETTERS
################################################################################	
	
	/**
	 *
	 * @return ffPostLayer
	 */
	protected function _getPostLayer() {
		return $this->_postLayer;
	}
	
	/**
	 *
	 * @param ffPostLayer $postLayer        	
	 */
	protected function _setPostLayer(ffPostLayer $postLayer) {
		$this->_postLayer = $postLayer;
		return $this;
	}
	
	/**
	 *
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 *
	 * @param ffWPLayer $WPLayer        	
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	
	
	
}