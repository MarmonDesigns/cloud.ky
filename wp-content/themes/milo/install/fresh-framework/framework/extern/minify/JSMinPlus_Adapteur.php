<?php

class JsMinPlus_Adapteur extends ffBasicObject {
	public function minify( $js ) {
		return JSMinPlus::minify($js);
	}
}