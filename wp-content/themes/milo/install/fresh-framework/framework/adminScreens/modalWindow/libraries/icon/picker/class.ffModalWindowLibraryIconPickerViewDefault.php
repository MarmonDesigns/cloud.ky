<?php

class ffModalWindowLibraryIconPickerViewDefault extends ffModalWindowView {

	/**
	 *
	 * @var ffModalWindowLibraryIconPickerIconPreparator
	 */
	private $iconLibraryPreparator = null;

	// Toolbar
	protected $_toolbarCancelText = "Cancel";
	protected $_toolbarOKText = "Select Icon";
	protected $_toolbarHasSizeSlider = true;

	protected function _initialize() {
		$this->_setViewName('Default');
		$this->_setWrappedInnerContent( false );
	}

	protected  function _requireAssets() {
		$this->_getScriptEnqueuer()->getFrameworkScriptLoader()
										->requireSelect2()
										->requireFrsLib()
										->requireFrsLibOptions()
										->requireFrsLibModal();

		foreach ($this->_getIconLibraryPreparator()->getIconFontCSSList() as $slug => $path) {
			$this->_getStyleEnqueuer()->addStyleFramework( 'ff-font'.$slug, $path );
		}
	}



	private function _printIconGroup( $groupName, $groupValue ) {
		?>

		<div class="ff-modal-library-items-group">
			<div class="ff-modal-library-items-group-title">
				<label>
					<?php echo str_replace('-', ' ',$groupName); ?>
					<span class="ff-modal-library-items-group-counter">
						<span class="ff-modal-library-items-group-counter-filtered">???</span>
						<span class="ff-modal-library-items-group-counter-slash">/</span>
						<span class="ff-modal-library-items-group-counter-total">???</span>
					</span>
				</label>
			</div><!-- END MODAL LIBRARY GROUP TITLE -->

			<div class="ff-modal-library-items-group-items">

				<?php

					foreach( $groupValue as $itemName => $oneItem ) {
						echo '<i';
						echo ' data-tags="'.$oneItem['tags'].'"';
						echo ' data-content="'.$oneItem['content'].'"';
						echo ' data-font="'.$oneItem['font'].'"';
						echo ' class="'.$oneItem['class'].'"';
						echo '></i>';
						// echo '<!-- END MODAL LIBRARY GROUP ITEM -->';
						echo "\n\n";
					}
				?>

			</div><!-- END MODAL LIBRARY GROUP ITEMS -->
		</div><!-- END MODAL LIBRARY GROUP -->
		<?php
	}

	protected function _render() {
		// $iconLib = ffContainer::getInstance()->getLibManager()->createUserIconLibrary();
	?>
			<div class="attachments-browser">
				<div class="media-toolbar">
					<div class="media-toolbar-secondary">
						<select class="attachment-filters">
							<option value="all">All</option>
  							<?php
  							/*
  							<optgroup label="User">
								<option value="uploaded">blue brand (19)</option>
								<option value="uploaded">green variant (19)</option>
							</optgroup>
  							<optgroup label="Themes">
								<option value="uploaded">Sentinel (43)</option>
							</optgroup>
  							<optgroup label="Plugins">
								<option value="uploaded">Fresh Shortcodes (124)</option>
								<option value="uploaded">Fresh Social (124)</option>
								<option value="uploaded">Bootstrap (53)</option>
							</optgroup>
							*/
							?>
						</select>
						<span class="spinner" style="display: none;"></span>
					</div>
					<div class="media-toolbar-primary"><input type="search" placeholder="Search" class="search"></div>
				</div>

				<div class="ff-modal-library-items-container">

					<div class="ff-modal-library-items-groups-titles-container">
						<div class="ff-modal-library-items-groups-titles-wrapper">
							<div class="ff-modal-library-items-groups-titles">
								<div class="ff-modal-library-items-group-title" style="background:red;" data-font-class="placeholder-font-awesome" data-top="-171">
								</div><!-- END MODAL LIBRARY GROUP TITLE -->
							</div>
						</div>
					</div><!-- END MODAL LIBRARY GROUPS TITLES -->

					<div class="ff-modal-library-items-wrapper">
						<div class="ff-modal-library-items">



<?php

						//$variableName = '@brand-primary';
						// $userIcons = $this->_getIconLibraryPreparator()->getPreparedUserIcons();
						// $this->_printUserIcons( $userIcons );


						$systemIcons = $this->_getIconLibraryPreparator()->getPreparedSystemIcons( );

						foreach( $systemIcons as $groupName => $groupValue ) {
							$this->_printIconGroup( $groupName, $groupValue );
						}
?>
						</div><!-- END MODAL LIBRARY ITEMS -->
					</div>
				</div>


				<?php $this->_printSidebar(); ?>
			</div>
		<?php
	}

	private function _printSidebar() {
	?>
		<div class="media-sidebar">
			<div class="attachment-details save-ready">
				<h3>Icon Details</h3>
				<div class="attachment-info">
					<div class="thumbnail icon-info">
						<i class="ff-font-awesome icon-star-half-alt"></i>
					</div>
<!--
					<div class="details">
						<div class="filename"></div>
						<a class="edit-attachment" href="#" >Edit Icon</a>
						<a class="duplicate-attachment" href="#" >Duplicate Icon</a>
						<a class="delete-attachment" href="#">Delete Permanently</a>
					</div>
 -->
				</div>

				<div class="ff-modal-library-item-details-settings-row description-name">
					<div class="ff-modal-library-item-details-settings-th">Name</div>
					<div class="ff-modal-library-item-details-settings-td"><p></p></div>
				</div>
				<div class="ff-modal-library-item-details-settings-row description-font">
					<div class="ff-modal-library-item-details-settings-th">Family</div>
					<div class="ff-modal-library-item-details-settings-td"><p></p></div>
				</div>
				<div class="ff-modal-library-item-details-settings-row description-tags">
					<div class="ff-modal-library-item-details-settings-th">Tags</div>
					<div class="ff-modal-library-item-details-settings-td"><p></p></div>
				</div>
				<div class="ff-modal-library-item-details-settings-row description-class">
					<div class="ff-modal-library-item-details-settings-th">Class</div>
					<div class="ff-modal-library-item-details-settings-td"><p></p></div>
				</div>
				<div class="ff-modal-library-item-details-settings-row description-glyph-escaped">
					<div class="ff-modal-library-item-details-settings-th">HTML</div>
					<div class="ff-modal-library-item-details-settings-td"><p></p></div>
				</div>
				<div class="ff-modal-library-item-details-settings-row description-css">
					<div class="ff-modal-library-item-details-settings-th">CSS</div>
					<div class="ff-modal-library-item-details-settings-td"><p></p></div>
				</div>
				<div class="ff-modal-library-item-details-settings-row description-glyph-character">
					<div class="ff-modal-library-item-details-settings-th">Glyph</div>
					<div class="ff-modal-library-item-details-settings-td"><p></p></div>
				</div>

<!--
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">Tags</div>
					<div class="ff-modal-library-item-details-settings-td ff-modal-library-item-tedails-settings-tags">
						<p><a href=""></a></p>
					</div>
				</div>
 -->
			</div>
		</div>
	<?php
	}

	public function proceedAjax( ffAjaxRequest $request ) {
		var_dump( $request );


		switch( $request->specification['action'] ) {
			case 'delete' :

				break;

			case 'new':

				break;

			case 'edit':

				break;

			case 'duplicate':
				$userIcons = $this->_getIconLibraryPreparator()->getPreparedUserIcons();
				//var_dump( $userIcons );
				$firstIcon = $userIcons[''][0];

				$groupNew = array();
				$groupNew['new-icons'][] = $firstIcon;
				ob_start();
				$this->_printUserIcons( $groupNew );
				$icons = ob_get_contents();
				ob_end_clean();

				$toPrint = array();
				$toPrint['html'] = $icons;
				$toPrint['group_name'] = 'new-icons';
				echo json_encode( $toPrint );


				break;
		}
	}


	private function _printForm( $data = array() ) {

	}

	/**
	 *
	 * @return ffModalWindowLibraryIconPickerIconPreparator
	 */
	protected function _getIconLibraryPreparator() {
		return $this->_iconLibraryPreparator;
	}

	/**
	 *
	 * @param ffModalWindowLibraryIconPickerIconPreparator $iconLibraryPreparator
	 */
	public function setIconLibraryPreparator(ffModalWindowLibraryIconPickerIconPreparator $iconLibraryPreparator) {
		$this->_iconLibraryPreparator = $iconLibraryPreparator;
		return $this;
	}

}