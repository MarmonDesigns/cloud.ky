<?php

abstract class ffModalWindowLibraryViewDefault extends ffModalWindowView {

################################################################################
# CONSTANTS
################################################################################

################################################################################
# PRIVATE OBJECTS
################################################################################
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	

################################################################################
# CONSTRUCTOR
################################################################################	

################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	

################################################################################
# PRIVATE FUNCTIONS
################################################################################
	protected function _printBeforeList() {
		echo '<div class="attachments-browser">';
			echo '<div class="media-toolbar">';
				echo '<div class="media-toolbar-secondary">';
					echo '<select class="attachment-filters">';
						echo '<option value="all">Images</option>';
						echo '<option value="uploaded">Uploaded to this post</option>';
					echo '</select>';
					echo '<span class="spinner" style="display: none;"></span>';
				echo '</div>';
				echo '<div class="media-toolbar-primary"><input type="search" placeholder="Search" class="search"></div>';
			echo '</div>';
			echo '<ul class="attachments ui-sortable ui-sortable-disabled">';
	}
	
	protected function _printAfterList() {
			echo '</ul>';
			$this->_printSidebar();
		echo '</div>';
	}
	
	protected function _printSidebar() {
		
	}
################################################################################
# GETTERS AND SETTERS
################################################################################	
	
}