<?php

class ffCustomTaxonomy_Factory extends ffFactoryAbstract {

	public function createCustomTaxonomy( $slug_id ){
		return new ffCustomTaxonomy( $slug_id );
	}

	public function createNormalCustomTaxonomy( $ff_inner_slug, $name, $singular_name = null ){
		$newTaxonomy = $this->createCustomTaxonomy( $ff_inner_slug );

		$newTaxonomy->setArgs(     $this->createCustomTaxonomyArgs() );
		$newTaxonomy->setLabels(   $this->createCustomTaxonomyLabels( $name, $singular_name ) );

        return $newTaxonomy;
	}

	public function createCustomTaxonomyArgs(){
		return new ffCustomTaxonomyArgs();
	}

	public function createCustomTaxonomyLabels( $name, $singular_name ){
		return new ffCustomTaxonomyLabels( $name, $singular_name );
	}

	// public function createCustomTaxonomyMessages( $name, $singular_name, $type ){
	// 	return new ffCustomTaxonomyMessages( $name, $singular_name, $type );
	// }

}