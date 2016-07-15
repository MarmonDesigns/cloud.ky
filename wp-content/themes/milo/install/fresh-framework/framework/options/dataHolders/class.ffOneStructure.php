<?php

class ffOneStructure extends ffBasicObject {
	/******************************************************************************/
	/* VARIABLES AND CONSTANTS
	 /******************************************************************************/
	private $_data = array();	// stores sections and options

	private $_currentSectionBuffer = array(); 	// pointer to the most current
	// section, so we can add
	// more things ( opt and sect)
	// there

	private $_name = null;
	
	/**
	 * 
	 * @var ffOneOption_Factory
	 */
	private $_oneOptionFactory = null;

    private $_uniqueHash = null;

	/**
	 * 
	 * @var ffOneSection_Factory
	 */
	private $_oneSectionFactory = null;
	
	/******************************************************************************/
	/* CONSTRUCT AND PUBLIC FUNCTIONS
	 /******************************************************************************/
	public function __construct( $name = null, ffOneOption_Factory $oneOptionFactory, ffOneSection_Factory $oneSectionFactory ) {
		$this->_name = $name;
		$this->_setOneoptionfactory($oneOptionFactory);
		$this->_setOnesectionfactory($oneSectionFactory);
	}
	/**
	 *
	 * @param string $id
	 * @param string $type
	 * @return ffOneSection
	 */
	public function startSection( $id, $type = null ) {
		$newSection = $this->_getOnesectionfactory()->createOneSection($id, $type);

		if( empty( $this->_currentSectionBuffer ) ) {
			$this->_data[] = $newSection;
		} else {
			$this->_getCurrentSection()->addSection( $newSection );
		}

		$this->_addSectionToBuffer($newSection);

		return $newSection;
	}
	
	public function insertStructure( ffOneStructure $structure ) {
		$data = $structure->getData();
		if( is_array( $data ) ) {
			foreach( $data as $newSection ) {
				if( empty( $this->_currentSectionBuffer ) ) {
					$this->_data[] = $newSection;
				} else {
					$this->_getCurrentSection()->addSection( $newSection );
					$this->_removeSectionFromBuffer();
				}
			}
		}
	}

	/**
	 * End section
	 */
	public function endSection() {
		$this->_removeSectionFromBuffer();
	}
	
	

	/**
	 *
	 * @param string $type
	 * @param string $id
	 * @param string $title
	 * @param string $defaultValue
	 * @param string $description
	 * @return ffOneOption
	 */
	public function addOption( $type, $id, $title = '', $defaultValue = '', $description = '' ) {
        $this->_addToHash( $title );
		$newOption = $this->_getOneoptionfactory()->createOneOption( $type, $id, $title, $defaultValue, $description );
		$this->_getCurrentSection()->addOption($newOption);

		return $newOption;
	}
	
	public function addElement( $type, $id = '', $title = '', $description = '' ) {
		$newElement = $this->_getOneoptionfactory()->createOneElement($type, $id, $title, $description);
		$this->_getCurrentSection()->addElement( $newElement );
		
		return $newElement;
	}

    public function getUniqueHash() {
        return md5( $this->_uniqueHash );
    }

	/******************************************************************************/
	/* PRIVATE FUNCTIONS
	 /******************************************************************************/
	/**
	 *
	 * @return ffOneSection
	 */
	private function _getCurrentSection() {
		if( empty( $this->_currentSectionBuffer ) ) {
			return null;
		} else {
			return end( $this->_currentSectionBuffer );
		}
	}

    private function _addToHash( $string ) {
        if( $this->_uniqueHash == null ) {
            $this->_uniqueHash = '';
        }

        $this->_uniqueHash .= $string;
    }

	private function _addSectionToBuffer( $newSection ) {
		$this->_currentSectionBuffer[] = $newSection;
	}

	private function _removeSectionFromBuffer() {
		array_pop( $this->_currentSectionBuffer );
	}
	/******************************************************************************/
	/* SETTERS AND GETTERS
	 /******************************************************************************/
	public function getData() {
		return $this->_data;
	}

	public function getType() {
		return ffOneSection::TYPE_NORMAL;
	}

	public function isContainer() {
		return true;
	}

	/**
	 * @return ffOneOption_Factory
	 */
	protected function _getOneoptionfactory() {
		return $this->_oneOptionFactory;
	}
	
	/**
	 * @param ffOneOption_Factory $_oneOptionFactory
	 */
	protected function _setOneoptionfactory(ffOneOption_Factory $oneOptionFactory) {
		$this->_oneOptionFactory = $oneOptionFactory;
		return $this;
	}
	
	/**
	 * @return ffOneSection_Factory
	 */
	protected function _getOnesectionfactory() {
		return $this->_oneSectionFactory;
	}
	
	/**
	 * @param ffOneSection_Factory $_oneSectionFactory
	 */
	protected function _setOnesectionfactory(ffOneSection_Factory $oneSectionFactory) {
		$this->_oneSectionFactory = $oneSectionFactory;
		return $this;
	}
	


}