<?php

class ffModalWindowLibraryColorPickerViewDefault extends ffModalWindowView {

	/**
	 * @var ffModalWindowLibraryColorPickerColorPreparator
	 */
	private $colorLibraryPreparator = null;

	// Toolbar
	protected $_toolbarCancelText = "Cancel";
	protected $_toolbarOKText = "Select Color";
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

		//$this->_getScriptEnqueuer()->addScriptFramework('ff-modal-color-picker', '/framework/adminScreens/modalWindow/libraries/color/picker/assets/ModalWindowLibraryColorPicker.js', array('jquery'));

		$this->_getScriptEnqueuer()->addScriptFramework('ff-nouislider-js', '/framework/extern/nouislider/jquery.nouislider.min.js', array('jquery'));
		$this->_getStyleEnqueuer()->addStyleFramework('ff-nouislider-css', '/framework/extern/nouislider/jquery.nouislider.min.css');
	}

	private function _getClearedSearchTags( $tags ){
		$tags = str_replace(array("'",'"'), array('',''), $tags);
		// $tags = str_replace('@', ' ', $tags);
		// $tags = str_replace('#', ' ', $tags);
		// $tags = str_replace('-', ' ', $tags);
		$tags = str_replace('.', ' ', $tags);
		$tags = str_replace("\n", ',', $tags);
		$tags = str_replace("\r", ' ', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = str_replace(', ', ',', $tags);
		$tags = str_replace(' ,', ',', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = str_replace(',,', ',', $tags);
		$tags = str_replace(',,', ',', $tags);
		$tags = trim($tags);
		$tags = strtolower($tags);

		$tags_tmp = explode( ',', $tags );
		$tags = array();
		foreach ($tags_tmp as $value) {
			$value = trim($value);
			$tags[ $value ] = $value;
		}
		$tags = implode(', ', $tags);
		if( ',' == substr($tags, 0,1) ){
			$tags = substr($tags, 1);
		}
		return $tags;
	}

	private function _printSingleColor( $hex, $title, $htmlColor, $type, $tags, $id, $group){
		$for_search = $tags . ', ' . $type . ', ' . $title .', ' . $hex . ', ' . $id;
		$for_search = $this->_getClearedSearchTags( $for_search );
 
		echo '<div class="ff-modal-library-items-group-item" data-tags="'.$for_search.'">';
			echo '<div class="ff-modal-library-items-group-item-color-wrapper">';
				echo '<div class="ff-modal-library-items-group-item-color" style="background-color:' . $htmlColor. '">';

					echo '<div class="ff-modal-library-items-group-item-color-controls">';
						if( $type != 'system' ) {
							echo '<div class="ff-modal-library-items-group-item-color-controls-edit"></div>';
						}
						echo '<div class="ff-modal-library-items-group-item-color-controls-select"></div>';
					echo '</div>';

					echo '<div class="ff-item-info">';
						echo '<input type="hidden" class="ff-item-name" value="' . $title. '">';
						echo '<input type="hidden" class="ff-item-color" value="' . $htmlColor. '">';
						echo '<input type="hidden" class="ff-item-type" value="' . $type. '">';
						// echo '<input type="hidden" class="ff-item-tags" value="' . $tags. '">';
						echo '<input type="hidden" class="ff-item-tags" value="' . $for_search. '">';
						echo '<input type="hidden" class="ff-item-group" value="' . $group. '">';
						echo '<input type="hidden" class="ff-item-id" value="' . $id. '">';
					echo '</div>';

				echo '</div>';
			echo '</div>';

			echo '<div class="ff-modal-library-items-group-item-color-title">' . $title. '</div>';

		echo '</div><!-- END MODAL LIBRARY GROUP ITEM -->';
	}

	private function _printSingleTitle( $groupName, $isUser, $groupSlug = '' ){
		
		echo '<div class="ff-modal-library-items-group-title" data-group-name="'.$groupSlug.'" data-group-name-nice="'.$groupName.'">';
			echo '<label>';
				echo '<span class="ff-group-label">';
				echo $groupName;
				echo '</span>';

	            if ( $isUser ){

				echo '<a class="ff-modal-library-items-group-settings" title="Group Actions"></a>';

				echo '<a class="ff-modal-library-items-group-settings-color-add" title="Add Color"></a>';

				}

				echo '<span class="ff-modal-library-items-group-counter">';
					echo '<span class="ff-modal-library-items-group-counter-filtered">???</span>';
					echo '<span class="ff-modal-library-items-group-counter-slash">/</span>';
					echo '<span class="ff-modal-library-items-group-counter-total">???</span>';
				echo '</span>';
			echo '</label>';
		echo '</div><!-- END MODAL LIBRARY GROUP TITLE -->';
	}

	private function _printUserColors( $data, $groups ) {

		
		
		if( empty( $groups) ) {
			return;
		}

		foreach( $groups as $groupSlug  => $groupName ) {

			echo '<div class="ff-modal-library-items-group"'
				. ' data-group-type="user"'
				. ' data-group-name-nice="'.$groupName.'"'
				. ' data-group-name="'.$groupSlug.'">';

			$this->_printSingleTitle( $groupName, true /* enable delete group */, $groupSlug );

			echo '<div class="ff-modal-library-items-group-items">';

			if( isset( $data[ $groupSlug ] ) ) {

				foreach(  $data[ $groupSlug ] as $oneItem ) {
					$this->_printSingleColor(
						$oneItem->getColor()->getHex(),
						$oneItem->getTitle(),
						$oneItem->getColor()->getHTMLColor(),
						'user',
						$oneItem->getTags(),
						$oneItem->getId(),
						$oneItem->getGroup()
					);
				}
			}

			echo '</div><!-- END MODAL LIBRARY GROUP ITEMS -->';
			echo '</div><!-- END MODAL LIBRARY GROUP -->';
		}
	}

	private function _printSystemColors( $systemColors ) {
		if( empty( $systemColors ) ) {
			return false;
		}
		foreach( $systemColors as $groupName => $groupValue ) {
			$groupNameNice = str_replace('-', ' ',$groupName);

			echo '<div class="ff-modal-library-items-group"'
				. ' data-group-type="system"'
				. ' data-group-name-nice="'.$groupNameNice.'"'
				. ' data-group-name="'.$groupName.'">';

			$this->_printSingleTitle( $groupNameNice, false /* disable delete group */ );

			echo '<div class="ff-modal-library-items-group-items">';

			foreach( $groupValue as $itemName => $oneItem ) {

				$this->_printSingleColor(
					$oneItem, // hex
					$itemName, //title
					$oneItem,
					'system',
					'Bootstrap',
					$itemName,
					$groupName
				);
			}

			echo '</div><!-- END MODAL LIBRARY GROUP ITEMS -->';
			echo '</div><!-- END MODAL LIBRARY GROUP -->';
		}
	}

	private function _printData() {
        return;
		echo '<div class="ff-colorlib-data">';
			echo '<div class="ff-new-group">';
				ob_start();
				$userColors = $this->_printUserColors( array(), array('template' => 'template' ) );
				$content = ob_get_contents();
				ob_end_clean();

				echo base64_encode( $content );
			echo '</div>';
			
			echo '<div class="ff-new-color">';
				ob_start();
				$this->_printSingleColor( '#000000',  'New Color', '#000000', 'user', '', '', '' );
				$content = ob_get_contents();
				ob_end_clean();
				
				echo base64_encode( $content );
		
			echo '</div>';
			
			echo '<div class="ff-ignored-colors">';
				if( $this->_getColorLibraryPreparator()->getBannedColors() == null ) {
					echo json_encode($this->_getColorLibraryPreparator()->getBannedColors());
				}
			echo '</div>';

		echo '</div>';
	}

	protected function _render() {
        return;

		// echo '<div class="ff-colorlib-banned-variables">';
		// 	echo json_encode( $this->_getColorLibraryPreparator()->getBannedColors() );
		// echo '</div>';

		
		
		$this->_printData();

	?>

			<div class="attachments-browser">
				<div class="media-toolbar">
					<div class="media-toolbar-secondary">
	<?php 
		//TODO
		/*
						<select class="attachment-filters">
							<option value="all">All (324)</option>
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
						</select><span class="spinner" style="display: none;"></span><a href="" class="ff-modal-library-items-group-view-masonry-toggle" title="Grid View"></a><a href="" class="ff-modal-library-items-group-view-list-toggle" title="List View"></a>
					</div>
					<div class="media-toolbar-primary"><input type="search" placeholder="Search" class="search"></div>
				</div>

				<div class="ff-modal-library-items-container" data-size="5">

					<div class="ff-modal-library-items-groups-titles-container">
						<div class="ff-modal-library-items-groups-titles-wrapper">
							<div class="ff-modal-library-items-groups-titles">
								<div class="ff-modal-library-items-group-title">
								</div><!-- END MODAL LIBRARY GROUP TITLE -->
							</div>
						</div>
					</div><!-- END MODAL LIBRARY GROUPS TITLES -->

					<div class="ff-modal-library-items-wrapper">
						<div class="ff-modal-library-items">

<?php

						// print User Colors

						$userColors = $this->_getColorLibraryPreparator()->getPreparedUserColors();
						$groups = $this->_getColorLibraryPreparator()->getUserColorsGroups();

						$this->_printUserColors( $userColors, $groups );

						// Print System Colors

						$systemColors = $this->_getColorLibraryPreparator()->getPreparedSystemColors( );
						$this->_printSystemColors( $systemColors );

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
				<h3>Color Details</h3>
				<div class="attachment-info">
					<div class="thumbnail">
						<div class="ff-modal-library-item-color" style="background: lightgreen;"></div>
					</div>
					<div class="details">
						<div class="filename"></div>
						<!--<div class="uploaded">May 9, 2014</div>-->

						<a class="edit-attachment" href="#" >Edit Color</a>
						<a class="duplicate-attachment" href="#" >Duplicate Color</a>

						<a class="delete-attachment" href="#">Delete Permanently</a>
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">HEX</div>
					<div class="ff-modal-library-item-details-settings-td ff-modal-library-item-tedails-settings-hex">
						<p></p>
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">RGBA</div>
					<div class="ff-modal-library-item-details-settings-td ff-modal-library-item-tedails-settings-rgba">
						<p></p>
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">Tags</div>
					<div class="ff-modal-library-item-details-settings-td ff-modal-library-item-tedails-settings-tags">
						<p><a href=""></a></p>
					</div>
				</div>
				<div class="separator"></div>
				<div class="ff-modal-library-item-details-settings-row" style="display:none;">
					<div class="ff-modal-library-item-details-settings-th">LESS function</div>
					<div class="ff-modal-library-item-details-settings-td">
						<div class="ff-modal-library-color-math-function">
							<ul class="ff-repeatable ff-repeatable-modal-library-color-math-function">
								<li class="ff-repeatable-item ff-repeatable-item-modal-library-color-math-function">
									<select class="ff-modal-library-color-math-function-select">
										<option value="darken" selected="">darken</option>
										<option value="lighten">lighten</option>
										<option value="spin">spin</option>
										<option value="fadein">fadein</option>
										<option value="fadein">fadeout</option>
										<option value="fadein">greyscale</option>
										<option value="fadein">saturate</option>
										<option value="fadein">desaturate</option>
									</select>
									<input type="text" value="20" class="ff-modal-library-color-math-function-value">
									<p class="ff-modal-library-color-math-function-unit">%</p>
									<a href="" class="ff-modal-library-color-math-function-remove"></a>
								</li>
							</ul>
							<input type="button" class="button button-small" value="+ Add">
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	public function proceedAjax( ffAjaxRequest $request ) {


		switch( $request->specification['action'] ) {
			case 'delete-color-value':
				$colorToDeleteName = $request->data['colorName'];
				
				ffContainer::getInstance()->getAssetsIncludingFactory()->getLessUserSelectedColorsDataStorage()->deleteUserColor( $colorToDeleteName );
				
				break;

			case 'create-new-group' :
				$groupName = $request->data['groupName'];

				$groups = $this->_getColorLibraryPreparator()->getUserColorsGroups();
				// $groupSlug = strtolower($this->_getWPLayer()->sanitize_only_letters_and_numbers( $groupName ));
				$groupSlug = $request->data['groupSlug'];

				if( empty ( $groups ) ) {
					$groups = array();
				}
				$groups = array_merge( array( $groupSlug => $groupName), $groups );
				//$groups[ $groupSlug ] = $groupName;

				$this->_getColorLibraryPreparator()->setUserColorGroups($groups);


				break;
				
			case 'create-color' :
				$userColorLibrary = ffContainer::getInstance()->getLibManager()->createUserColorLibrary();
				
				$newColor = $userColorLibrary->getNewColor();
				
				$data = $request->data;
				
				$newColor->setTitle( $data['description']['name']);
				$newColor->setTags( $data['description']['tags']);
				$newColor->setGroup( $data['description']['group']);
				
				$newColor->getColor()->setHex( $data['colors']['hex'], $data['colors']['opacity']);
				
				echo $newColor->getId();
				$userColorLibrary->setColor( $newColor );
				break;
				
			case 'edit-color':
				$userColorLibrary = ffContainer::getInstance()->getLibManager()->createUserColorLibrary();

				
				$data = $request->data;
				$id = $data['description']['id'];
				//var_dump( $id );
				$editedColor = $userColorLibrary->getColor( $id );
				
				$editedColor->setTitle( $data['description']['name']);
				$editedColor->setTags( $data['description']['tags']);
				$editedColor->setGroup( $data['description']['group']);
				
				$editedColor->getColor()->setHex( $data['colors']['hex'], $data['colors']['opacity']);
				
				$userColorLibrary->setColor( $editedColor );
				
				break;

			case 'delete-group' :
 
				
					$groupToDelete = $request->data['groupToDelete'];
					$this->_getColorLibraryPreparator()->deleteUserColorGroup( $groupToDelete['slug'] );
 
				break;
				
				
			case 'rename-group':
					$data = $request->data;
					//var_dump( $data );
					
					$colorGroups = $this->_getColorLibraryPreparator()->getUserColorsGroups();
					
					$colorGroups[ $data['oldGroupSlug'] ] = $data['newGroupName'];
					
					$this->_getColorLibraryPreparator()->setUserColorGroups( $colorGroups );
				break;
				
			case 'move-colors-delete-group':
					$data = $request->data;
					$newGroupSlug = $data['newGroup'];
					$deleteGroupSlug = $data['groupToDelete']['slug'];
					// newGroup,   groupToDelete-slug
					
					$userColorLibrary = ffContainer::getInstance()->getLibManager()->createUserColorLibrary();
					
					$colors = $userColorLibrary->getColors();
					
					$affectedColors = array();
					
					foreach( $colors as $oneColor ) {
						if( $oneColor->getGroup() == $deleteGroupSlug ) {
							$oneColor->setGroup( $newGroupSlug );
							$affectedColors[] = $oneColor;
						}
					}
					
					foreach( $affectedColors as $oneAffectedColor ) {
						$userColorLibrary->setColor( $oneAffectedColor );
					}
					
					$this->_getColorLibraryPreparator()->deleteUserColorGroup( $deleteGroupSlug );

				break;
				
				
			case 'delete-color' :
					$data = $request->data;
					$idToDelete = $data['idToDelete'];
					
					$userColorLibrary = ffContainer::getInstance()->getLibManager()->createUserColorLibrary();
					
					$userColorLibrary->deleteColorById( $idToDelete );
				break;
				
				
			case 'save-color' :
					$data = $request->data;
					
					$colorLibrary = ffContainer::getInstance()->getAssetsIncludingFactory()->getColorLibrary();
					
					$colorLibrary->setUserColor( $data['lessVariableName'], $data['newValue']);

				break;
/*
			case 'delete' :

				break;

			case 'new':

				break;

			case 'edit':
				$color = $request->data['color'];

				$colorLibrary = ffContainer::getInstance()->getLibManager()->createUserColorLibrary();

				$existingColor = $colorLibrary->getColor( $color['description']['id'] );

				$existingColor->setTitle( $color['description']['name']);
				$existingColor->setTags( $color['description']['tags']);
				$existingColor->getColor()->setHex($color['colors']['hex'], $color['colors']['opacity']);

				$colorLibrary->setColor( $existingColor );
				break;

			case 'duplicate':
				$userColors = $this->_getColorLibraryPreparator()->getPreparedUserColors();
				//var_dump( $userColors );
				$firstColor = $userColors[''][0];

				$groupNew = array();
				$groupNew['new-colors'][] = $firstColor;
				ob_start();
				$this->_printUserColors( $groupNew );
				$colors = ob_get_contents();
				ob_end_clean();

				$toPrint = array();
				$toPrint['html'] = $colors;
				$toPrint['group_name'] = 'new-colors';
				echo json_encode( $toPrint );


				break;
				//var_dump( $request->data );
				$colorInfo = $request->data['colorInfo'];
				$userColorLibrary = ffContainer::getInstance()->getLibManager()->createUserColorLibrary();

				$newUserColor = $userColorLibrary->getNewColor();

				$newUserColor->setTitle($colorInfo['title'] . '-DUPLICATE' );
				$newUserColor->setTags( $colorInfo['tags'] );

				$newUserColor->getColor()->setHex( $colorInfo['hex'], $colorInfo['opacity']);
				$userColorLibrary->setColor( $newUserColor );

				break; // */
		}
	}


	private function _printForm( $data = array() ) {

	}

	/**
	 *
	 * @return ffModalWindowLibraryColorPickerColorPreparator
	 */
	protected function _getColorLibraryPreparator() {
		return $this->_colorLibraryPreparator;
	}

	/**
	 *
	 * @param ffModalWindowLibraryColorPickerColorPreparator $colorLibraryPreparator
	 */
	public function setColorLibraryPreparator(ffModalWindowLibraryColorPickerColorPreparator $colorLibraryPreparator) {
		$this->_colorLibraryPreparator = $colorLibraryPreparator;
		return $this;
	}

}