<?php

class ffMenu extends ffBasicObject {
	const TYPE_TOP_LEVEL = 'ff_type_top_level';
	const TYPE_SUB_LEVEL = 'ff_type_sub_level';
	const TYPE_UNI_LEVEL = 'ff_type_uni_level';
	const TYPE_HID_LEVEL = 'ff_type_hid_level';
	
	public $parentSlug = null;
	public $pageTitle = null;
	public $menuTitle = null;
	public $capability = null;
	public $menuSlug = null;
	public $callback = null;
	public $iconUrl = null;
	public $position = null;
	public $type = null;
}