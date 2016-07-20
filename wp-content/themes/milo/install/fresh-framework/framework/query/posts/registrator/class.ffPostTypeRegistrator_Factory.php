<?php

class ffPostTypeRegistrator_Factory extends ffFactoryAbstract {

	public function createPostTypeRegistrator( $slug_id, $name, $singular_name, $is_hidden ){
		$this->_getClassLoader()->loadClass( 'ffPostTypeRegistrator' );
		return new ffPostTypeRegistrator( $slug_id );
	}

	public function createNormalPostTypeRegistrator( $ff_inner_slug, $name, $singular_name = null ){
		$newPostType = $this->createPostTypeRegistrator( $ff_inner_slug, $name, $singular_name, false);

		$newPostType->setArgs(     $this->createPostTypeRegistratorArgs() );
		$newPostType->setSupports( $this->createPostTypeRegistratorSupports() );
		$newPostType->setLabels(   $this->createPostTypeRegistratorLabels( $name, $singular_name ) );
		$newPostType->setMessages( $this->createPostTypeRegistratorMessages( $name, $singular_name, 'normal' ) );

        return $newPostType;
	}

	public function createHiddenPostTypeRegistrator( $slug_id, $name, $singular_name = NULL ){
		$newPostType = $this->createPostTypeRegistrator( $slug_id, $name, $singular_name, TRUE );

		$args = $this->createPostTypeRegistratorArgs() ;
		$args->set('exclude_from_search' , TRUE  );
		$args->set('show_in_nav_menus' ,   FALSE );
		$args->set('show_in_menu' ,        FALSE );
		$args->set('show_in_admin_bar' ,   FALSE );
		$args->set('has_archive' ,         FALSE );
		$args->set('public' ,              FALSE );

		$newPostType->setArgs( $args );

		$supports = $this->createPostTypeRegistratorSupports();
		$supports->set('editor',    FALSE ); // default TRUE
		$supports->set('author',    FALSE ); // default TRUE
		$supports->set('thumbnail', FALSE ); // default TRUE
		$supports->set('excerpt',   FALSE ); // default TRUE
		$supports->set('revisions', TRUE  ); // default FALSE

		$newPostType->setSupports( $supports );

		$newPostType->setLabels(   $this->createPostTypeRegistratorLabels( $name, $singular_name ) );
		$newPostType->setMessages( $this->createPostTypeRegistratorMessages( $name, $singular_name, 'hidden' ) );

		return $newPostType;
	}

	public function createPostTypeRegistratorArgs(){
		$this->_getClassLoader()->loadClass( 'ffPostTypeRegistratorArgs' );
		return new ffPostTypeRegistratorArgs();
	}

	public function createPostTypeRegistratorSupports(){
		$this->_getClassLoader()->loadClass( 'ffPostTypeRegistratorSupports' );		
		return new ffPostTypeRegistratorSupports();
	}

	public function createPostTypeRegistratorLabels( $name, $singular_name ){
		$this->_getClassLoader()->loadClass( 'ffPostTypeRegistratorLabels' );
		return new ffPostTypeRegistratorLabels( $name, $singular_name );
	}

	public function createPostTypeRegistratorMessages( $name, $singular_name, $type ){
		$this->_getClassLoader()->loadClass( 'ffPostTypeRegistratorMessages' );
		return new ffPostTypeRegistratorMessages( $name, $singular_name, $type );
	}

}