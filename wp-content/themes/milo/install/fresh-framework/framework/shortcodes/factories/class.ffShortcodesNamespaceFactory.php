<?php

class ffShortcodesNamespaceFactory extends ffFactoryAbstract {
	
	public function getShortcodeManager() {
		$this->_getClassloader()->loadClass('ffShortcodeManager');
        $fwc = ffContainer();
        $shortcodeCollection = $fwc->createNewCollection();
        $shortcodeCollection->addSupportedClass('ffShortcodeObjectBasic');

		return new ffShortcodeManager( $fwc->getWPLayer(), $this->getShortcodeFactory(), $this->getShortcodeContentParser(), $shortcodeCollection );
	}

    public function getShortcodeFactory() {
        $this->_getClassloader()->loadClass('ffShortcodeObjectBasic');
        $this->_getClassloader()->loadClass('ffShortcodeFactory');
        $scFactory = new ffShortcodeFactory( $this->_getClassloader() );
        $scFactory->setWPLayer( ffContainer()->getWPLayer() );

        return $scFactory;
    }

    public function getShortcodeContentParser() {
        $this->_getClassloader()->loadClass('ffShortcodeContentParser');

        $shortcodeContentParser = new ffShortcodeContentParser();

        return $shortcodeContentParser;
    }

}