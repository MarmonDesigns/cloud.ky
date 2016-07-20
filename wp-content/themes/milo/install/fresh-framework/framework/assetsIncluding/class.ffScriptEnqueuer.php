<?php

class ffScriptEnqueuer extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	
	/**
	 * 
	 * @var ffWPLayer
	 */
	protected $_WPLayer = null;
	
	/**
	 * 
	 * @var ffScript_Factory
	 */
	protected $_scriptFactory = null;


	/**
	 *
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	/**
	 * 
	 * @var array[ffScript]
	 */
	protected $_scripts = array();
	
	protected $_scriptsNonMinificable = array();
	
	protected $_actionEnqueueScriptsHeaderTriggered = false;
	
	/**
	 * 
	 * @var ffFrameworkScriptLoader
	 */
	protected $_frameworkScriptLoader = null;
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffScript_Factory $scriptFactory, ffFileSystem $fileSystem ) {
		$this->_setWplayer($WPLayer);
		$this->_setScriptfactory($scriptFactory);
		$this->_getWplayer()->getHookManager()->addActionEnqueuScripts( array( $this, 'actionEnqueueScripts' ) );
		$this->_setfileSystem( $fileSystem );
		//$this->_getWplayer()->add_action_enque_scripts( array( $this, 'actionEnqueueScripts' ) );
	}
	
	public function addScriptFramework( $handle = null, $source = null, $dependencies = null, $version = null, $inFooter = null, $type = null, $additionalInfo = true ) {
        $source = $this->_getWplayer()->untrailingslashit( $source );
		$source = $this->_getWplayer()->getFrameworkUrl() . $source;
		$this->addScript( $handle, $source, $dependencies, $version, $inFooter, $type, $additionalInfo );
		
		return $this;
	}
	
	public function addScriptTheme( $handle = null, $source = null, $dependencies = null, $version = null, $inFooter = null, $type = null, $additionalInfo = true ) {
		$source = $this->_getfileSystem()->locateFileInChildTheme($source, true);
		$this->addScript(  $handle , $source , $dependencies , $version , $inFooter , $type , $additionalInfo  );
		
		return $this;
	}
	
/*	public function addStyleTheme( $handle = null, $source = null, $dependencies = null, $version = null, $media = null, $type = null, $additionalInfo = null ) {
		$source = $this->_getfileSystem()->locateFileInChildTheme($source, true);
		$this->addStyle($handle, $source, $dependencies, $version, $media, $type, $additionalInfo );
	}*/
	
	public function addScript( $handle = null, $source = null, $dependencies = null, $version = null, $inFooter = null, $type = null, $additionalInfo = true ) {
		$script = $this->_getScriptfactory()
						->createScript( $handle, $source, $dependencies, $version, $inFooter, $type, $additionalInfo);
		
		$this->_addScript( $script );
		
		return $this;
		
	}
	
	public function addData( $handle, $key, $value ) {
        if( isset( $this->_scripts[ $handle ] ) ) {
            $this->_scripts[ $handle ]->addData( $key, $value);
        }
		return $this->_getWPLayer()->get_wp_scripts()->add_data($handle, $key, $value);
	}
	
	public function addScriptNonMinificable( $handle = null, $source = null, $dependencies = null, $version = null, $inFooter = null, $type = null ) {
		$additionalInfo = false;
		$script = $this->_getScriptfactory()
						->createScript( $handle, $source, $dependencies, $version, $inFooter, $type, $additionalInfo);
		
		$this->_addScript( $script );
		
		return $this;
	}
	
	public function addScriptObject( ffScript $script ) {
		$this->_addScript($script);
		
		return $this;
	}
	
	public function actionEnqueueScripts() {
		$this->_actionEnqueueScriptsHeaderTriggered = true;
		$this->_enqueueNonMinificableScripts();
		
		if( !empty($this->_scripts) ) {
			foreach( $this->_scripts as $oneScript ) {

				$this->_getWplayer()
					->wp_enqueue_script(
							$oneScript->handle,
							$oneScript->source, 
							$oneScript->dependencies, 
							null, 
							$oneScript->inFooter
					);

                if( $oneScript->data !== null ) {
                    foreach( $oneScript->data as $key => $value ) {
                        $this->_getWPLayer()->get_wp_scripts()->add_data($oneScript->handle, $key, $value);
                    }
                }
			}
		}
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _actionScriptsHeaderHasBeenTriggered() {
		
		if( $this->_getWplayer()->action_been_executed( 'wp_print_scripts') ) {
			return true;
		} else {
			return false;
		}
		
		if( $this->_actionEnqueueScriptsHeaderTriggered ) {
			return true;
		}
		
		
		if( $this->_getWplayer()->action_been_executed( $this->_getWplayer()->action_enqueue_scripts_name() ) ) {
			return true;
		}
		
		return false;
	}
	
	private function _addScript( ffScript $script ) {
		
		if( $this->_actionScriptsHeaderHasBeenTriggered() ) {
			$this->_getWplayer()
				->wp_enqueue_script(
					$script->handle,
					$script->source,
					$script->dependencies,
					$script->version,
					true
			);
		}
		$this->_scripts[ $script->handle ] = $script;
	
	}
	
	protected function _enqueueNonMinificableScripts() {
		if( !empty($this->_scriptsNonMinificable) ) {
			foreach( $this->_scriptsNonMinificable as $oneScript ) {
				$this->_getWplayer()
				->wp_enqueue_script(
						$oneScript->handle,
						$oneScript->source,
						$oneScript->dependencies,
						null,
						$oneScript->inFooter
				);
			}
		}
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/	
	
	public function setFrameworkScriptLoader( ffFrameworkScriptLoader $frameworkScriptLoader ) {
		$this->_frameworkScriptLoader = $frameworkScriptLoader;
	}
	
	public function getFrameworkScriptLoader() {
		return $this->_frameworkScriptLoader;
	}
	
	/**
	 * @return ffWPLayer
	 */
	protected function _getWplayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $_WPLayer
	 */
	protected function _setWplayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	/**
	 * @return ffScript_Factory
	 */
	protected function _getScriptfactory() {
		return $this->_scriptFactory;
	}
	
	/**
	 * @param ffScript_Factory $_scriptFactory
	 */
	protected function _setScriptfactory(ffScript_Factory $scriptFactory) {
		$this->_scriptFactory = $scriptFactory;
		return $this;
	}	
	
	
	/**
	 * @return ffFileSystem
	 */
	protected function _getfileSystem() {
		return $this->_fileSystem;
	}
	
	/**
	 * @param ffFileSystem $_fileSystem
	 */
	protected function _setfileSystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}
}