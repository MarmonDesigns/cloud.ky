<?php

interface ffIAdminScreenView {
	public function render();
	
	public function requireAssets();
	
	public function actionSave( ffRequest $request );
}