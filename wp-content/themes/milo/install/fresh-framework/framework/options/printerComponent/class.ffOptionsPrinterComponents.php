<?php
/******************************************************************************/
/* TYPE TEXT
/******************************************************************************/
class ffOptionsPrinterComponent_Text extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$label = trim( $oneOption->getTitle() );
		$labelAfter = $this->_getLabelAfter( $oneOption );
		$input = '<input type="text" '
				. ' name="'.$nameRoute.'"'
						. ' value="'.$oneOption->getValue().'"'
								. $this->_placeholder( $oneOption )
								. $this->_class( $oneOption )
								. ' >';

		if( empty( $label ) && empty( $labelAfter ) ) {
			echo $input;
		} else {
			if( $oneOption->getParam('fullwidth') ) {
				echo '<label class="ff-input-wideflex__label"><div class="ff-input-wideflex__label-text">' . $label . '</div><div class="ff-input-wideflex__input-wrapper">' . $input . '</div>' . $labelAfter . '</label>';
			} else {
				echo '<label>' . $label . ' ' . $input . ' ' . $labelAfter . '</label> ';
			}
		}
 
	}
}

/******************************************************************************/
/* TYPE COLOR PICKER WP
/******************************************************************************/
class ffOptionsPrinterComponent_ColorPickerWP extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
        $oneOption->addParam('class', 'ff-default-wp-color-picker');

		$label = trim( $oneOption->getTitle() );
		$labelAfter = $this->_getLabelAfter( $oneOption );
		$input = '<input type="text" '
				. ' name="'.$nameRoute.'"'
						. ' value="'.$oneOption->getValue().'"'
								. $this->_placeholder( $oneOption )
								. $this->_class( $oneOption )
								. ' >';

		if( empty( $label ) && empty( $labelAfter ) ) {
			echo $input;
		} else {
			if( $oneOption->getParam('fullwidth') ) {
				echo '<label class="ff-input-wideflex__label"><div class="ff-input-wideflex__label-text">' . $label . '</div><div class="ff-input-wideflex__input-wrapper">' . $input . '</div>' . $labelAfter . '</label>';
			} else {
				echo '<label>' . $label . ' ' . $input . ' ' . $labelAfter . '</label> ';
			}
		}

	}
}

/******************************************************************************/
/* TYPE NUMBER
/******************************************************************************/
class ffOptionsPrinterComponent_Number extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$label = trim( $oneOption->getTitle() );
		$labelAfter = $this->_getLabelAfter( $oneOption );
		$input = '<input type="number" '
					. ' name="'.$nameRoute.'"'
					. ' value="'.$oneOption->getValue().'"'
					. $this->_placeholder( $oneOption )
					. $this->_class( $oneOption )
					. ' >';

		echo ( empty( $label ) and empty( $labelAfter ) )
				? $input
				: '<label>' . $label . ' ' . $input . ' ' . $labelAfter . '</label> '
				;
	}
}

/******************************************************************************/
/* TYPE TEXTAREA
/******************************************************************************/
class ffOptionsPrinterComponent_Textarea extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		
		$label = trim( $oneOption->getTitle() );
		$labelAfter = $this->_getLabelAfter( $oneOption );
		

		
		$input = '<textarea class="ff-options__textarea" '
					. ' name="'.$nameRoute.'"'
					. $this->_placeholder( $oneOption )
					. $this->_class( $oneOption )
					. $this->_rows( $oneOption )
					. $this->_cols( $oneOption )
					. '>'.$oneOption->getValue().'</textarea>';
		$input .= '<span class="description">'.$oneOption->getDescription().'</span>';
		
		echo ( empty( $label ) && empty( $labelAfter ) )
				? $input
				: '<lab el class="ff-options__textarea__label">' . $label . ' ' . $input . ' ' . $labelAfter . '</label> '
				;
	}
}


/******************************************************************************/
/* TYPE CHECKBOX
/******************************************************************************/
class ffOptionsPrinterComponent_Checkbox extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$label = trim( $oneOption->getTitle() );
		$labelAfter = $this->_getLabelAfter( $oneOption );
		$inputHidden = '<input type="hidden" class="ff-checkbox-shadow" '
					. ' value="0" '
					. ' name="'.$nameRoute.'" '
				. ' >';
		$input = '<input type="checkbox" '
					. ' name="'.$nameRoute.'"'
					. ' value="1"'
					. $this->_checkedCheckBox( $oneOption )
					. $this->_class( $oneOption )
					. ' >';
//        echo '<div class="ff-checkbox-wrapper">';
		echo ( empty( $label ) and empty( $labelAfter ) )
				? $inputHidden. $input
				: $inputHidden. '<label>' . $input . ' ' . $label . '</label>'
				;
//        echo '</div>';
	}
}


/******************************************************************************/
/* TYPE RADIO
 /******************************************************************************/
class ffOptionsPrinterComponent_Radio extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$valueS = $oneOption->getSelectValues();
		$value  = $oneOption->getValue();

        echo '<div class="ff-radio-group">';
		foreach( $valueS as $key => $oneValue ) {
				echo '<label>';
				echo '<input type="radio" '
						. ( ( $oneValue['value'] == $value ) ? 'checked="checked"' : '' )
						. ' value="' . $oneValue['value'] . '"'
						. $this->_class( $oneOption )
						. ' name="' . $nameRoute . '">';
				echo $oneValue['name'];
				echo '</label>';
				echo "\n";

				if( $oneOption->getParam('break-line-at-end') == true )
					echo '<br>';
		}
        echo '</div>';
	}
}

/******************************************************************************/
/* TYPE CODE
/******************************************************************************/
class ffOptionsPrinterComponent_Code extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$mode     = $oneOption->getParam('mode', 'css');
		$minLines = $oneOption->getParam('minLines', '13');
		$maxLines = $oneOption->getParam('maxLines', '50');

		echo '<div class="ff-code-holder">';
		echo '<pre id="'.$idRoute.$oneOption->getId().'" data-ff-option-type="code" data-ff-option-mode="'.$mode.'" data-ff-option-min-lines="'.$minLines.'" data-ff-option-max-lines="'.$maxLines.'">';
		echo $oneOption->getValue();
		echo '</pre>';

		echo '<textarea id="'.$idRoute.$oneOption->getId().'-textarea" class="ff-code-editor-textarea" name="'.$nameRoute.'" >';
		echo $oneOption->getValue();
		echo '</textarea>';
		echo '</div>';
	}
}

/******************************************************************************/
/* TYPE FONT
/******************************************************************************/
class ffOptionsPrinterComponent_Font extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		$inputValue = $oneOption->getValue();
		$isGroup =  $oneOption->getParam('is_group', false);

		echo '<label>';
		echo '<select data-value="'.$inputValue.'" name="'.$nameRoute.'" value="'.$inputValue.'" class="ff-component-font ff-component-font-uninitialized">';

		echo '<optgroup label="Web Safe Fonts" class="web-safe-fonts">';
		foreach( array(
			"Arial"               => "Arial, Helvetica, sans-serif",
			"Arial Black"         => "'Arial Black', Gadget, sans-serif",
			"Comic Sans MS"       => "'Comic Sans MS', cursive, sans-serif",
			"Courier New"         => "'Courier New', Courier, monospace",
			"Georgia"             => "Georgia, serif",
			"Helvetica"           => "Helvetica, sans-serif",
			"Impact"              => "Impact, Charcoal, sans-serif",
			"Lucida Console"      => "'Lucida Console', Monaco, monospace",
			"Lucida Sans Unicode" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"Palatino Linotype"   => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Times New Roman"     => "'Times New Roman', Times, serif",
			"Tahoma"              => "Tahoma, Geneva, sans-serif",
			"Trebuchet MS"        => "'Trebuchet MS', Helvetica, sans-serif",
			"Verdana"             => "Verdana, Geneva, sans-serif",
		) as $title => $value ) {
			echo '<option value="'.$value.'">'.$title.'</option>';
		}
		echo '</optgroup>';
		echo '<optgroup label="Google Fonts" class="google-fonts">';
		echo '</optgroup>';
		echo '</select>';

		echo '<h1 class="font-example">Grumpy wizards make toxic brew for the evil Queen and Jack.</h1>';
		echo '<p class="font-example">';
		echo 'Grumpy wizards make toxic brew for the evil Queen and Jack.<br/>
Latin Extended: D&#232;s No&#235;l o&#249; un z&#233;phyr ha&#239; me v&#234;t de gla&#231;ons w&#252;rmiens je d&#238;ne d&#8217;exquis r&#244;tis de b&#339;uf au kir &#224; l&#8217;a&#255; d&#8217;&#226;ge m&#251;r & c&#230;tera.<br/>
Cyrillic Extended: &#1042; &#1095;&#1072;&#1097;&#1072;&#1093; &#1102;&#1075;&#1072; &#1078;&#1080;&#1083; &#1073;&#1099; &#1094;&#1080;&#1090;&#1088;&#1091;&#1089;? &#1044;&#1072;, &#1085;&#1086; &#1092;&#1072;&#1083;&#1100;&#1096;&#1080;&#1074;&#1099;&#1081; &#1101;&#1082;&#1079;&#1077;&#1084;&#1087;&#1083;&#1103;&#1088;!<br/>
Greek Extended: &#932;&#940;&#967;&#953;&#963;&#964;&#951; &#945;&#955;&#974;&#960;&#951;&#958; &#946;&#945;&#966;&#942;&#962; &#968;&#951;&#956;&#941;&#957;&#951; &#947;&#951;, &#948;&#961;&#945;&#963;&#954;&#949;&#955;&#943;&#950;&#949;&#953; &#965;&#960;&#941;&#961; &#957;&#969;&#952;&#961;&#959;&#973; &#954;&#965;&#957;&#972;&#962;<br/>
Vietnamese: T&#244;i c&#243; th&#7875; &#259;n th&#7911;y tinh m&#224; kh&#244;ng h&#7841;i g&#236;.T&#244;i c&#243; th&#7875; &#259;n th&#7911;y tinh m&#224; kh&#244;ng h&#7841;i g&#236;.<br/>
East Europe Latin: P&#345;&#237;&#353;ern&#283; &#382;lu&#357;ou&#269;k&#253; k&#367;&#328; &#250;p&#283;l &#271;&#225;belsk&#233; &#243;dy.<br/>';
		echo '</p>';
		echo '</label>';

		// TODO

		// Sorry, but there may be some ajax calling in the future
		// + Or when this is inserted into repeatables
		// + This will be replaced by modal window soon

		?><script>
			jQuery(document).ready(function( $ ){
				var $uninitialized = $('.ff-component-font-uninitialized');
				var $font_select = $('.ff-component-font');

				if( 0 == $uninitialized.size() ){
					return;
				}

				$font_select.change(function(){
					if( $(this).val() ){}else{ return; }
					if( -1 != $(this).val().indexOf(',') ){
						$(this).parents('label').find('.font-example').css('font-family',$(this).val());
						return;
					}

					var font_name = $(this).val().replace(/\'/g,'');

					var css_id = font_name.replace(/ /g,'_');

					if( 0 == $( '#' + css_id ).size()){
						var css_link = '//fonts.googleapis.com/css?family='+font_name+':300italic,400italic,600italic,300,400,600&subset=latin,latin-ext';
						var css_html = '<link rel="stylesheet" id="'+css_id+'" href="'+css_link+'" type="text/css" media="all" />';
						$('head').append(css_html);
					}
					$(this).parents('label').find('.font-example').css('font-family',$(this).val());
				});

				var jqxhr = $.getJSON( "<?php echo ffContainer::getInstance()->getWPLayer()->getAssetsSourceHolder()->getGoogleFontsAjax(); ?>", function( data ) {
					data.items.forEach(function( entry ) {
						var title = entry.family;
						var value = "'" +title+ "'";
						$font_select.each(function(){
							$(this).find('.google-fonts').append('<option value="'+value+'">'+title+'</option>');
							if( value == $(this).attr('data-value') ){
								$(this).val(value);
								$(this).change();
							}
						});
					});
				});

				$font_select.each(function(){
					$(this).val( $(this).attr('data-value') );
					$(this).change();
				});


				$('.ff-component-font-uninitialized').removeClass('ff-component-font-uninitialized');

			});
		</script><?php
	}
}
/******************************************************************************/
/* TYPE REVOLUTION SLIDEr
/******************************************************************************/
class ffOptionsPrinterComponent_RevolutionSlider extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$selectValues = $oneOption->getSelectValues();
		$selectedValue = $oneOption->getValue();
		$isGroup =  $oneOption->getParam('is_group', false);
		if( $oneOption->getParam('print_label', true) == true ) {
			echo '<label>';
		}

		$enables = $oneOption->getParam('enables');
		$enablesCode = '';

		if( $enables != null ) {
			$enablesCode = ' data-enables="'.$enables.'" ';
		}

		echo $oneOption->getTitle().' <select class="ff-revolution-slider-selector '.$this->_getClassesString().'" name="'.$nameRoute.'" '.$enablesCode.' our-value="'.$selectedValue.'" value="'.$selectedValue.'">';

			if( !$isGroup ) {
				if( !empty( $selectValues ) ) {
					foreach( $selectValues as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
				}
			} else {

				if( !empty( $selectValues ) ) {
					foreach( $selectValues as $groupName => $values ) {
						echo '<optgroup label="'.$groupName.'">';
						foreach( $values as $oneValue ) {
							$selected = '';
							if( $oneValue['value'] == $selectedValue ) {
								$selected = ' selected="selected" ';
							}
							echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			}
		echo '</select>';
		if( $oneOption->getParam('print_label', true) == true ) {
			echo '</label>';
		}

	}
}

/******************************************************************************/
/* TYPE SELECT
/******************************************************************************/
class ffOptionsPrinterComponent_Select extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		$selectValues = $oneOption->getSelectValues();
		$selectedValue = $oneOption->getValue();
		$isGroup =  $oneOption->getParam('is_group', false);
		if( $oneOption->getParam('print_label', true) == true ) {
			echo '<label>';
		}

		$enables = $oneOption->getParam('enables');
		$enablesCode = '';
		
		if( $enables != null ) {
			$enablesCode = ' data-enables="'.$enables.'" ';
		}
		
		echo $oneOption->getTitle().' <select class="'.$this->_getClassesString().'" name="'.$nameRoute.'" '.$enablesCode.'>';
		
			if( !$isGroup ) {
				if( !empty( $selectValues ) ) {
					foreach( $selectValues as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
				}
			} else {
				
				if( !empty( $selectValues ) ) {
					foreach( $selectValues as $groupName => $values ) {
						echo '<optgroup label="'.$groupName.'">';
						foreach( $values as $oneValue ) {
							$selected = '';
							if( $oneValue['value'] == $selectedValue ) {
								$selected = ' selected="selected" ';
							}
							echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			}
		echo '</select>';
		if( $oneOption->getParam('print_label', true) == true ) {
			echo '</label>';
		}
		
	}
}

/******************************************************************************/
/* TYPE SELECT
 /******************************************************************************/
class ffOptionsPrinterComponent_NavigationMenuSelector extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		
		$WPLayer = ffContainer::getInstance()->getWPLayer();
		$registeredNavigationMenus = $WPLayer->get_all_navigation_menus();
		
		$oneOption->clearSelectValues();
		
		if( !empty( $registeredNavigationMenus ) ) {
			
			foreach( $registeredNavigationMenus as $oneMenu ) {
				$oneOption->addSelectValue( $oneMenu->name, $oneMenu->term_id);
			}
			
		} else {
			$oneOption->addSelectValue('NO MENU DETECTED', 'no-menu-detected');
		}
		
		
		$selectValues = $oneOption->getSelectValues();
		$selectedValue = $oneOption->getValue();
		$isGroup =  $oneOption->getParam('is_group', false);
		if( $oneOption->getParam('print_label', true) == true ) {
			echo '<label>';
		}

		$enables = $oneOption->getParam('enables');
		$enablesCode = '';

		if( $enables != null ) {
			$enablesCode = ' data-enables="'.$enables.'" ';
		}

		echo $oneOption->getTitle().' <select class="'.$this->_getClassesString().'" name="'.$nameRoute.'" '.$enablesCode.'>';

		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $oneValue['value'] == $selectedValue ) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {

			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
		if( $oneOption->getParam('print_label', true) == true ) {
			echo '</label>';
		}

	}
}

/******************************************************************************/
/* TYPE SELECT_CONTENT_TYPE
/******************************************************************************/
class ffOptionsPrinterComponent_Select_ContentType extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		$selectValues = $oneOption->getSelectValues();
		$value = ( $oneOption->getValue());
		
		$selectedValue = $oneOption->getValue();
		$isGroup =  true;//$oneOption->getParam('is_group', false);
		
		//var_Dump( $isGroup );
		echo ''.$oneOption->getTitle().'<select class="'.$this->_getClassesString().' ff-select-content-type" data-value="'.$value.'" name="'.$nameRoute.'" >';

		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					
					$selected = '';
					if( $oneValue['value'] == $selectedValue ) {
						$selected = ' selected="selected" ';
						
						
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
							
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
	}
}

/*foreach( get_users() as $oneUser ) {
	echo '<option value="'.$oneUser->data->ID.'">'.$oneUser->data->user_nicename.'</option>';
}*/
/******************************************************************************/
/* TYPE TAXONOMY
 /******************************************************************************/
class ffOptionsPrinterComponent_Taxonomy extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		
		$taxType = $oneOption->getParam('tax_type', 'category');
		
		$taxGetter = ffContainer::getInstance()->getTaxLayer()->getTaxGetter();//ffContainer::getInstance()->getTaxLayer()->getTaxGetter()->filterByTaxonomy('category')->getList());
		$tax = $taxGetter->filterByTaxonomy( $taxType )->getList();
	
 		
		
		$selectValues = $oneOption->getSelectValues();
		$selectValuesNew = array();
		
		if( $tax instanceof WP_Error ) {
			$selectValuesNew = array();
		} else {
			
			foreach( $tax as $oneTax ) {
				$selectValuesNew[] = array('name' => $oneTax->name, 'value'=> $oneTax->term_id);
			}
		}
		
		if( empty( $selectValues ) ) {
			$selectValues = array();
		}
		
	
		
		
		$selectValues = array_merge( $selectValues, $selectValuesNew );
		//$selectValues = array_merge( $selectValues, $selectValuesNew );
	
		$selectedValue = $oneOption->getValue();

		$selectedValueExploded = explode('--||--', $selectedValue );

		$multiple = $oneOption->getParam('type', '');

		$isGroup =  $oneOption->getParam('is_group', false);
		$width = $oneOption->getParam('width', 0);
		$style = '';
			
		echo '<div class="ff-select2-wrapper">';
			
		echo '<div class="ff-select2-value-wrapper">';
		echo '<input type="text" class="ff-select2-value" name="'.$nameRoute.'" value="'.$selectedValue.'">';
		echo '</div>';
			
		echo '<div class="ff-select2-real-wrapper">';
		echo '<select '.$multiple.' size="1" data-selected-value="'.$selectedValue.'" class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $this->_isValueSelected( $oneValue['value'], $selectedValueExploded)) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $this->_isValueSelected( $oneValue['value'], $selectedValue)) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="ff-select2-shadow-wrapper">';
		echo '<select '.$multiple.' data-selected-value="'.$selectedValue.'" class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $oneValue['value'] == $selectedValue ) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
		echo '</div>';
		echo '</div>';
	}
}

/******************************************************************************/
/* TYPE USERS
 /******************************************************************************/
class ffOptionsPrinterComponent_Users extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		
	
		
		/*if( $contentSpecific == 'author-archive' ) {
			foreach( ffContainer::getInstance()->getWPLayer()->get_users() as $oneUser ) {
				echo '<option value="'.$oneUser->data->ID.'">'.$oneUser->data->user_nicename.'</option>';
			}
		}
		else if( $contentSpecific == 'user-logged' ) {
			foreach( ffContainer::getInstance()->getWPLayer()->get_users() as $oneUser ) {
				echo '<option value="'.$oneUser->data->ID.'">'.$oneUser->data->user_nicename.'</option>';
			}
			echo '<option value="not-logged">Not Logged</option>';
		} else if( $contentSpecific =='user-role') {
			global $wp_roles;
			foreach( $wp_roles->roles as $value => $oneRole ) {
				echo '<option value="'.$value.'">'.$oneRole['name'].'</option>';
			}
			echo '<option value="no-role">No Role</option>';
		}*/
		
		$selectValues = array();

		$taxType = $oneOption->getParam('user_type', 'author-archive');
  
		if( $taxType == 'author-archive' ) {
			foreach( ffContainer::getInstance()->getWPLayer()->get_users() as $oneUser ) {
				$selectValues[] = array('name' => $oneUser->data->user_nicename, 'value'=> $oneUser->data->ID);
			}
		}



	

		$selectedValue = $oneOption->getValue();

		$selectedValueExploded = explode('--||--', $selectedValue );

		$multiple = $oneOption->getParam('type', '');

		$isGroup =  $oneOption->getParam('is_group', false);
		$width = $oneOption->getParam('width', 0);
		$style = '';
			
		echo '<div class="ff-select2-wrapper">';
			
		echo '<div class="ff-select2-value-wrapper">';
		echo '<input type="text" class="ff-select2-value" name="'.$nameRoute.'" value="'.$selectedValue.'">';
		echo '</div>';
			
		echo '<div class="ff-select2-real-wrapper">';
		echo '<select '.$multiple.' size="1" data-selected-value="'.$selectedValue.'" class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $this->_isValueSelected( $oneValue['value'], $selectedValueExploded)) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $this->_isValueSelected( $oneValue['value'], $selectedValue)) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="ff-select2-shadow-wrapper">';
		echo '<select '.$multiple.' data-selected-value="'.$selectedValue.'" class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $oneValue['value'] == $selectedValue ) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
		echo '</div>';
		echo '</div>';
	}
}

/******************************************************************************/
/* TYPE SELECT2
/******************************************************************************/
class ffOptionsPrinterComponent_Select2 extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {	
		$selectValues = $oneOption->getSelectValues();
		$selectedValue = $oneOption->getValue();
		
		$selectedValueExploded = explode('--||--', $selectedValue );
		
		$multiple = $oneOption->getParam('type', '');
		
		$isGroup =  $oneOption->getParam('is_group', false);
		$width = $oneOption->getParam('width', 0);
		$style = '';
			
			echo '<div class="ff-select2-wrapper">';
			
			echo '<div class="ff-select2-value-wrapper">';
				echo '<input type="text" class="ff-select2-value" name="'.$nameRoute.'" value="'.$selectedValue.'">';
			echo '</div>';
			
			echo '<div class="ff-select2-real-wrapper">';
			echo '<select '.$multiple.' size="1" data-selected-value="'.$selectedValue.'" class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
			if( !$isGroup ) {
				if( !empty( $selectValues ) ) {
					foreach( $selectValues as $oneValue ) {
						$selected = '';
						if( $this->_isValueSelected( $oneValue['value'], $selectedValueExploded)) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
				}
			} else {
				if( !empty( $selectValues ) ) {
					foreach( $selectValues as $groupName => $values ) {
						echo '<optgroup label="'.$groupName.'">';
						foreach( $values as $oneValue ) {
							$selected = '';
							if( $this->_isValueSelected( $oneValue['value'], $selectedValue)) {
								$selected = ' selected="selected" ';
							}
							echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
						}
						echo '</optgroup>';
					}
				}
			}
		echo '</select>';
		echo '</div>';
		
		echo '<div class="ff-select2-shadow-wrapper">';
		echo '<select '.$multiple.' data-selected-value="'.$selectedValue.'" class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $oneValue['value'] == $selectedValue ) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
		echo '</div>';
		echo '</div>';
	}
}


/******************************************************************************/
/* TYPE SELECT2
 /******************************************************************************/
class ffOptionsPrinterComponent_Select2_Hidden extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		echo '<label>'.$oneOption->getTitle().'<input type="hidden" class="ff-select2 ff-select2-hidden" name="'.$nameRoute.'" '.$style.'>';
		echo '</label>';
	}
}

/******************************************************************************/
/* TYPE SELECT2_POSTS
/******************************************************************************/
class ffOptionsPrinterComponent_Select2_Posts extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		$selectValues = $oneOption->getSelectValues();
		$selectedValue = $oneOption->getValue();

		$isGroup =  $oneOption->getParam('is_group', false);
		$width = $oneOption->getParam('width', 300);
		$style = 'style="width:'.$width.'px;"';

		echo ''.$oneOption->getTitle().'<select class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $oneValue['value'] == $selectedValue ) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
	}
}

class ffOptionsPrinterComponent_AceEditor extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
	
	}
}

/******************************************************************************/
/* TYPE DATEPICKER
 /******************************************************************************/
class ffOptionsPrinterComponent_Datepicker extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$label = trim( $oneOption->getTitle() );
		$labelAfter = $this->_getLabelAfter( $oneOption );

		$input = '<input type="text" '
				. ' name="'.$nameRoute.'"'
						. ' value="'.$oneOption->getValue().'"'
								. $this->_placeholder( $oneOption )
								. $this->_class( $oneOption, 'ff-datepicker' )
								. ' >';

		echo ( empty( $label ) and empty( $labelAfter ) )
		? $input
		: '<label class="datepicker_label">' . $label . ' ' . $input . ' ' . $labelAfter . '</label> '
				;
	}
}

/******************************************************************************/
/* TYPE Image
 /******************************************************************************/
class ffOptionsPrinterComponent_Image extends ffOptionsPrinterComponentsBasic {
	protected $valueEscapingDisabled = true;

	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$value = $oneOption->getValue();

		if( empty( $value ) ){
			$valueDecoded = (object) array( 'url'=>'', 'id'=>'', 'width'=>0, 'height'=>0 );
		}else{
			$valueDecoded = json_decode( $value );
		}

		$label = trim( $oneOption->getTitle() );
		
		if( empty( $label ) ){
			$label = 'Select Image';
		}

		$data_forced_width  = $oneOption->getParam('data-forced-width',  '');
		if( ! empty( $data_forced_width  ) ){ $data_forced_width  = ' data-forced-width="'  . $data_forced_width  . '"'; }
		$data_forced_height = $oneOption->getParam('data-forced-height', '');
		if( ! empty( $data_forced_height ) ){ $data_forced_height = ' data-forced-height="' . $data_forced_height . '"'; }

		ob_start();
		echo '<span class="ff-open-library-button-wrapper ff-open-image-library-button-wrapper">';
			echo '<a class="ff-open-library-button ff-open-image-library-button"'.$data_forced_width.$data_forced_height.'>';
				echo '<span class="ff-open-library-button-preview">';
				echo '<span class="ff-open-library-button-preview-image" style="background-image:url(\''.$this->_escapedValue( $valueDecoded->url ).'\');">';
				echo '</span>';
				echo '</span><span class="ff-open-library-button-title">'.$label.'</span>';
				echo '<input type="hidden" name="'.$nameRoute.'" id="'.$idRoute.'" class="ff-image" value="'.$this->_escapedValue( $value ).'">';
				echo '<span class="ff-open-library-button-preview-image-large-wrapper">';
				echo '<img class="ff-open-library-button-preview-image-large" src="'.$this->_escapedValue( $valueDecoded->url ).'" width="'.$valueDecoded->width.'" height="'.$valueDecoded->height.'">';
				echo '</span>';
			echo '</a>';
			echo '<a class="ff-open-library-remove" title="Clear"></a>';
		echo '</span>';
		$imageSource = ob_get_contents();
		ob_end_clean();
		
		$description = trim( $oneOption->getDescription() );
		$labelAfter = $this->_getLabelAfter( $oneOption );
		
		
		echo ( empty( $description ) and empty( $labelAfter ) )
				? $imageSource
				: '<label>' . $description . ' ' . $imageSource . ' ' . $labelAfter . '</label> '
						;

// 		$label = trim( $oneOption->getTitle() );
// 		$labelAfter = $this->_getLabelAfter( $oneOption );



// 		$input = '<textarea '
// 				. ' name="'.$nameRoute.'"'
// 						. $this->_placeholder( $oneOption )
// 						. $this->_class( $oneOption )
// 						. $this->_rows( $oneOption )
// 						. $this->_cols( $oneOption )
// 						. '>'.$oneOption->getValue().'</textarea>';
// 		$input .= '<span class="description">'.$oneOption->getDescription().'</span>';

// 		echo ( empty( $label ) and empty( $labelAfter ) )
// 		? $input
// 		: '<label>' . $label . ' ' . $input . ' ' . $labelAfter . '</label> '
// 				;
		
	}
}

/******************************************************************************/
/* TYPE Icon
 /******************************************************************************/
class ffOptionsPrinterComponent_Icon extends ffOptionsPrinterComponentsBasic {
	protected $valueEscapingDisabled = true;

	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$value = $oneOption->getValue();

		$label = trim( $oneOption->getTitle() );
		if( empty( $label ) ){
			$label = 'Select Icon';
		}

		$data_autofilter  = $oneOption->getParam('data-autofilter',  '');
		if( ! empty( $data_autofilter  ) ){ $data_autofilter  = ' data-autofilter="'  . $data_autofilter  . '"'; }

		echo '<span class="ff-open-icon-library-button-wrapper">';
			echo '<a class="ff-open-library-button ff-open-library-icon-button">';
				echo '<span class="ff-open-library-button-preview">';

				echo '<i class="'.$value.'"></i>';

				echo '</span>';
				echo '<span class="ff-open-library-button-title">'.$label.'</span>';
				echo '<input type="hidden" name="'.$nameRoute.'" id="'.$idRoute.'" class="ff-icon" value="'.$this->_escapedValue( $value ).'" '.$data_autofilter.'>';
				// echo '<span class="ff-open-library-button-preview-icon-large-wrapper">';
				// 	echo '<span class="ff-open-library-button-preview-icon-large">';
				// 		echo '<i class="'.$value.'"></i>';
				// 	echo '</span>';
				// echo '</span>';
			echo '</a>';
			// echo '<a class="ff-open-library-remove" title="Clear"></a>';
		echo '</span>';
	}
}

/******************************************************************************/
/* TYPE Color Library
/******************************************************************************/
class ffOptionsPrinterComponent_ColorLibrary extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
	
		// mandatory color library preparation
		ffContainer::getInstance()->getAssetsIncludingFactory()->getLessSystemColorLibraryManager()->prepareColorLibraries();
		
		
		$lessVariableName =  $oneOption->getParam('less-variable-name');
		
		if( empty( $lessVariableName ) ) {
			throw new ffException('!!! SELECT COLOR VARIABLE NAME FOR THE COLOR LIBRARY OPTION !!!');
		
			return;
		}
		
		$value = $oneOption->getValue();
		
		
		
		//$value = '{"id":"@test-vsech-promennych","type":"system"}';
		//$value = '{"id":"2","type":"user"}';
		
		$colorLib = ffContainer::getInstance()->getAssetsIncludingFactory()->getColorLibrary();
		
		// STDclass->pickedColorName, ->colorValue
		$data = $colorLib->getColorOptionData( $lessVariableName );
		//$defaultValue = $colorLib->getColorOptionData($colorName)
		
		//var_dump( $data );
		
		echo '<label><span class="ff-open-library-button-wrapper ff-open-color-library-button-wrapper">';
		echo '<a class="ff-open-library-button ff-open-library-color-button">';
			echo '<span class="ff-open-library-button-preview">';
			echo '<span class="ff-open-library-button-preview-color" style="background:'.$data->colorValue.';"></span>';
			echo '</span><span class="ff-open-library-button-title">Select Color</span>';
			echo '<input type="hidden"  class="ff-color-input" name="'.$nameRoute.'" id="'.$idRoute.'" value="'.( $data->pickedColorName ).'">';
			echo '<span class="ff-less-variable-name" style="display:none;">'.$oneOption->getParam('less-variable-name').'</span>';
			echo '<span class="ff-less-variable-value" style="display:none;">'.$data->defaultValue.'</span>';
			
		echo '</a>';
		echo '<a class="ff-open-library-remove" title="Clear"></a>';
		echo '</span></label>';
		return;
		
		/*
		 * 				
		 * 
		 * 
		 * <a class="ff-open-library-button ff-open-library-color-button">
					<span class="ff-open-library-button-preview">
						<span class="ff-open-library-button-preview-color" style="background:#0088cc;"></span>
					</span><span class="ff-open-library-button-title">Select Color</span>
				</a>
		 */
		
		
		$value = $oneOption->getValue();

		if( empty( $value ) ){
			$valueDecoded = (object) array( 'url'=>'', 'id'=>'' );
		}else{
			$valueDecoded = json_decode( $value );
		}

		$label = trim( $oneOption->getTitle() );
		if( empty( $label ) ){
			$label = 'Select Image';
		}

		echo '<span class="ff-open-library-button-wrapper ff-open-image-library-button-wrapper">';
		echo '<a class="ff-open-library-button ff-open-image-library-button">';
		echo '<span class="ff-open-library-button-preview">';
		echo '<span class="ff-open-library-button-preview-image" style="background-image:url(\''.$this->_escapedValue( $valueDecoded->url ).'\');"></span>';
		echo '</span><span class="ff-open-library-button-title">'.$label.'</span>';
		echo '<input type="hidden" name="'.$nameRoute.'" id="'.$idRoute.'" class="ff-image" value="'.$this->_escapedValue( $value ).'">';
		echo '</a>';
		echo '<a class="ff-open-library-remove" title="Clear"></a>';
		echo '</span>';

	}
}

/******************************************************************************/
/* TYPE POST_SELECTOR
/******************************************************************************/
class ffOptionsPrinterComponent_PostSelector extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {

		$postType = $oneOption->getParam('post_type', 'page');

		
		$postGetter = ffContainer::getInstance()->getPostLayer()->getPostGetter();
		$posts = $postGetter->setNumberOfPosts(-1)->getPostsByType( $postType );
		
		//$taxGetter = ffContainer::getInstance()->getTaxLayer()->getTaxGetter();//ffContainer::getInstance()->getTaxLayer()->getTaxGetter()->filterByTaxonomy('category')->getList());
		//$tax = $taxGetter->filterByTaxonomy( $taxType )->getList();

			

		$selectValues = $oneOption->getSelectValues();
		$selectValuesNew = array();

	
		
		if( $posts instanceof WP_Error ) {
			$selectValuesNew = array();
		} else {
				
			foreach( $posts as $onePost ) {
				$selectValuesNew[] = array('name' => $onePost->getTitle(), 'value'=> $onePost->getId() );
			}
		}

		if( empty( $selectValues ) ) {
			$selectValues = array();
		}




		$selectValues = array_merge( $selectValues, $selectValuesNew );
		//$selectValues = array_merge( $selectValues, $selectValuesNew );

		$selectedValue = $oneOption->getValue();

		$selectedValueExploded = explode('--||--', $selectedValue );

		$multiple = $oneOption->getParam('type', '');

		$isGroup =  $oneOption->getParam('is_group', false);
		$width = $oneOption->getParam('width', 0);
		$style = '';
			
		echo '<div class="ff-select2-wrapper">';
			
		echo '<div class="ff-select2-value-wrapper">';
		echo '<input type="text" class="ff-select2-value" name="'.$nameRoute.'" value="'.$selectedValue.'">';
		echo '</div>';
			
		echo '<div class="ff-select2-real-wrapper">';
		echo '<select '.$multiple.' size="1" data-selected-value="'.$selectedValue.'" class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $this->_isValueSelected( $oneValue['value'], $selectedValueExploded)) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $this->_isValueSelected( $oneValue['value'], $selectedValue)) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
		echo '</div>';

		echo '<div class="ff-select2-shadow-wrapper">';
		echo '<select '.$multiple.' data-selected-value="'.$selectedValue.'" class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $oneValue['value'] == $selectedValue ) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';
		echo '</div>';
		echo '</div>';
	}
}



/******************************************************************************/
/* TYPE_CONDITIONAL_LOGIC
/******************************************************************************/
class ffOptionsPrinterComponent_ConditionalLogic extends ffOptionsPrinterComponentsBasic {
	protected function _printOption( ffOneOption $oneOption, $nameRoute, $idRoute ) {
		//die();

		$fwc = ffContainer::getInstance();
		$conditionalLogic  = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolderConditionalLogic');

		//vaR_dump( $conditionalLogic );

	//	$value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOption('customcode_logic');
	//	parse_str($oneOption->getValue(), $params);
		//var_dump( $params );

		$printer = $fwc->getOptionsFactory()->createOptionsPrinterLogic( $oneOption->getValue(), $conditionalLogic->getOptions() );
		$printer->setNameprefix( 'option-value' );

		echo '<div class="ff-option-conditional-logic-wrapper">';
		echo '<input type="text" class="ff-hidden-input" name="'.$nameRoute.'">';
		echo '<div class="ff-option-conditional-logic">';
		$printer->walk();
		echo '</div>';

		echo '</div>';

		/*
		$value = $oneOption->getValue();
		
		echo '<div class="ff-option-conditional-logic">';
			echo 'CONDITIONAL LOGIC';
			
			echo '<textarea type="text" class="ff-logic"></textarea>';
		echo '</div>';
		
		/*$selectValues = $oneOption->getSelectValues();
		$selectedValue = $oneOption->getValue();

		$isGroup =  $oneOption->getParam('is_group', false);
		$width = $oneOption->getParam('width', 300);
		$style = 'style="width:'.$width.'px;"';

		echo ''.$oneOption->getTitle().'<select class="ff-select2" name="'.$nameRoute.'" '.$style.'>';
		if( !$isGroup ) {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $oneValue ) {
					$selected = '';
					if( $oneValue['value'] == $selectedValue ) {
						$selected = ' selected="selected" ';
					}
					echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
				}
			}
		} else {
			if( !empty( $selectValues ) ) {
				foreach( $selectValues as $groupName => $values ) {
					echo '<optgroup label="'.$groupName.'">';
					foreach( $values as $oneValue ) {
						$selected = '';
						if( $oneValue['value'] == $selectedValue ) {
							$selected = ' selected="selected" ';
						}
						echo '<option value="'.$oneValue['value'].'" '.$selected.'>'.$oneValue['name'].'</option>';
					}
					echo '</optgroup>';
				}
			}
		}
		echo '</select>';*/
	}
}