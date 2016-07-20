<?php

class ffModalWindowLibraryColorEditorViewDefault extends ffModalWindowView {

	// Toolbar
	protected $_toolbarCancelText = "Cancel";
	protected $_toolbarOKText = "Save";
	protected $_toolbarHasSizeSlider = false;

	protected function _initialize() {
		$this->_setViewName('Default');
		$this->_setWrappedInnerContent( false );
	}

	protected  function _requireAssets() {
		$this->_getScriptEnqueuer()->getFrameworkScriptLoader()
										->requireSelect2()
										->requireFrsLib()
										->requireFrsLibOptions()
										->requireFrsLibModal()
										->requireMinicolors();
		
		$this->_getScriptEnqueuer()->addScriptFramework('ff-modal-color-editor', '/framework/adminScreens/modalWindow/libraries/color/editor/assets/ModalWindowLibraryColorEditor.js');
										
	}
	
 

	protected function _render() {

		
		?>

			<div class="attachments-browser">
				<div class="ff-modal-library-color-editor-ui">
					<table>
						<tbody>
							<tr>
								<td>
									<input type="text" class="minicolors" data-opacity="0" value="#ff6161">
								</td>
								<td>
									<table>
										<tbody>
											<tr>
												<td>
													<table>
														<tbody>
															<tr>
																<td>
																	<div class="ff-colorlib-color-preview-wrapper">
																		<div style="background-color:#ff2a00;" class="ff-colorlib-color-preview-after"></div>
																		<a style="background-color:rgba(255,0,0,0.5);" class="ff-colorlib-color-preview-before" href=""></a>
																	</div>
																	<br>
																</td>
																<td>
																	<label for="ff-colorlib-color-hexcode"><span class="ff-modal-library-color-editor-label-left ff-colorlib-color-hexcode-label-left">#</span><input type="text" class="ff-colorlib-color-hexcode" id="ff-colorlib-color-hexcode"></label><br>
																	<label for="ff-colorlib-color-opacity"><span class="ff-modal-library-color-editor-label-left ff-colorlib-color-opacity-label-left">Opacity:</span><input type="text" class="ff-colorlib-color-opacity" id="ff-colorlib-color-opacity"> <span class="ff-modal-library-color-editor-label-right ff-colorlib-color-opacity-label-right">%</span></label>
																	<br>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td>
													<table>
														<tbody>
															<tr>
																<td>
																	<label for="ff-colorlib-color-hsb-h"><span class="ff-modal-library-color-editor-label-left">H:</span><input type="text" class="ff-colorlib-color-hsb-h" id="ff-colorlib-color-hsb-h"> <span class="ff-modal-library-color-editor-label-right">&#176;</span></label><br>
																	<label for="ff-colorlib-color-hsb-s"><span class="ff-modal-library-color-editor-label-left">S:</span><input type="text" class="ff-colorlib-color-hsb-s" id="ff-colorlib-color-hsb-s"> <span class="ff-modal-library-color-editor-label-right">%</span></label><br>
																	<label for="ff-colorlib-color-hsb-b"><span class="ff-modal-library-color-editor-label-left">B:</span><input type="text" class="ff-colorlib-color-hsb-b" id="ff-colorlib-color-hsb-b"> <span class="ff-modal-library-color-editor-label-right">%</span></label><br>
																</td>
																<td>
																	<label for="ff-colorlib-color-rgb-r"><span class="ff-modal-library-color-editor-label-left">R:</span><input type="text" class="ff-colorlib-color-rgb-r" id="ff-colorlib-color-rgb-r"></label><br>
																	<label for="ff-colorlib-color-rgb-g"><span class="ff-modal-library-color-editor-label-left">G:</span><input type="text" class="ff-colorlib-color-rgb-g" id="ff-colorlib-color-rgb-g"></label><br>
																	<label for="ff-colorlib-color-rgb-b"><span class="ff-modal-library-color-editor-label-left">B:</span><input type="text" class="ff-colorlib-color-rgb-b" id="ff-colorlib-color-rgb-b"></label><br>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>				
			</div>
				
			<?php $this->_printSidebar(); ?>
 
		<?php 
	}
	
	private function _printSidebar() {
	?>
	
		<div class="media-sidebar">
			<div class="attachment-details save-ready">
				<h3>COLOR DETAILS
					<span class="settings-save-status">
						<span class="spinner"></span>
						<span class="saved">Saved.</span>
					</span>
				</h3>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">Title</div>
					<div class="ff-modal-library-item-details-settings-td">
						<input type="text" value="MyColor3" class="ff-modal-library-item-details-settings-title">
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">Tags</div>
					<div class="ff-modal-library-item-details-settings-td">
						<textarea class="ff-modal-library-item-details-settings-tags">colors, user, hello world, bootstrap, red, blue, green</textarea>
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">Group</div>
					<div class="ff-modal-library-item-details-settings-td">
						<select name="" id="" class="ff-modal-library-item-details-settings-groups">
							<option value="" selected="selected">My Colors</option>
							<option value="">Bootstrap</option>
							<option value="">Pantone</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	 


	public function proceedAjax( ffAjaxRequest $request ) {
 
	}


	private function _printForm( $data = array() ) {
 
	}
}