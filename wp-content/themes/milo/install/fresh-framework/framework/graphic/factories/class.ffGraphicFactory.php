<?php

class ffGraphicFactory extends ffFactoryAbstract {
	public function getImageInformator( $imageUrl ) {
		$this->_getClassloader()->loadClass('ffImageInformator');
		
		$container = ffContainer::getInstance();
		
		$imageInformator = new ffImageInformator( $container->getFileSystem() );
		$imageInformator->setImageUrl( $imageUrl );
		
		
		return $imageInformator;
		
	}

    public function getImageHttpManager() {
        $this->_getClassloader()->loadClass('ffImageHttpManager');

        $container = ffContainer();

        $imageHttpManager = new ffImageHttpManager(
            $container->getWPLayer(),
            $container->getHttpAction(),
            $container->getGraphicFactory()->getImageServingObject(),
            $container->getFileSystem()
        );

        return $imageHttpManager;
    }

    public function getImageServingObject() {
        $this->_getClassloader()->loadClass('ffImageServingObject');

        $imageServingObject = new ffImageServingObject();

        return $imageServingObject;
    }
}