(function($){
    frslib.provide('frslib.options');
    frslib.provide('frslib.options.walkers');

    frslib.options.walkers.printerBoxed = function() {
        var _ = {};
        var walker = frslib.options.walkers.walker();

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
        _.output = '';

        _.walker = walker;
        walker.ignoreData = true;

        _.setStructureString = walker.setStructureString;
        _.setDataString = walker.setDataString;
        _.setDataJSON = walker.setDataJSON;
        _.setIgnoreHideDefault = walker.setIgnoreHideDefault;

        _.getCurrentRouteCount = function() {
            return Object.keys(_.walker.idRoute).length;
        }

        _.setPrefix = walker.setPrefix;

        _.walk = function() {
            _.output = '';
            walker.walk();

            return _.output;
        }


/**********************************************************************************************************************/
/* ROUTE AND QUERYING
/**********************************************************************************************************************/
        _.getChildSections = function( route ) {

            var $result = $(_.output);

            var $parentUl = $result.find('li[data-current-section-route="'+route+'"]').parents('.ff-repeatable-js:first');


            var sections = new Array();

            $parentUl.children('li').each(function() {
                var newSection = {};
                newSection.name = $(this).attr('data-section-name');
                newSection.id = $(this).attr('data-section-id');
                newSection.route = $(this).attr('data-current-section-route');

                sections.push(newSection);
            });

            return sections;

        }

        _.getChildSectionsParentUl = function( route ) {


            var $result = $(_.output);

            var $parentUl = $result.find('li[data-current-section-route="'+route+'"]').parents('.ff-repeatable-js:first');

            return $parentUl;
        }

        _.getSection = function( route, id ) {


            var $result = $(_.output);

            var $li = $result.find('li[data-section-id="'+id+'"]').filter('li[data-current-section-route="'+route+'"]');

            return $li;
        }

/**********************************************************************************************************************/
/* ITEM HELPERS
/**********************************************************************************************************************/
        _.escapeValue = function( value ) {
            value = value.split('&').join('&amp;');
            value = value.split('<').join('&lt;');
            value = value.split('>').join('&gt;')
            value = value.split('"').join('&quot;')
            value = value.split("'").join('&apos;');

            return value;
        }

        _.getItemParam = function ( item, param, defaultValue ) {
            if( item == null ) {
                return null;
            }
            if( item.params == undefined || item.params == null ) {
               if( defaultValue != undefined) {
                    return defaultValue;
                } else {
                    return null;
                }
            }
            if( item.params[param] != undefined &&  item.params[param] != null ) {
                return item.params[param][0];
            } else {
                if( defaultValue != undefined) {
                    return defaultValue;
                } else {
                    return null;
                }
            }
        }
        _.getItemParamArray = function( item, param ) {
            if( item.params == undefined || item.params == null ) {
                return null;
            }
            if( item.params[param] != undefined && item.params[param] != null ) {
                return item.params[param];
            } else {
                return null;
            }
        }
/**********************************************************************************************************************/
/* OPTIONS & ELEMENTS FUNCTIONS
/**********************************************************************************************************************/
        _.getItemClassesString = function( item ) {
            var paramClasses = _.getItemParamArray(item, 'class');

            var classes = '';

            for( var id in paramClasses ) {
                classes += ' ' + paramClasses[ id ];
            }

            return paramClasses;
        }

        _.getItemCols = function( item ) {
            var cols = _.getItemParam('cols');

            if( cols != null ) {
                return ' cols="'+cols+'"';
            } else {
                return ' cols="30"';
            }
        }

        _.getItemRows = function( item ) {
            var cols = _.getItemParam('rows');

            if( cols != null ) {
                return ' rows="'+rows+'"';
            } else {
                return ' rows="5"';
            }
        }

        _.getItemCheckedCheckBox = function( item ) {
            if( parseInt( item.value ) == 1 ) {
                return ' checked="checked" ';
            } else {
                return '';
            }
        }

/**********************************************************************************************************************/
/* ELEMENTS
/**********************************************************************************************************************/
        walker.setCallbackOneElement(function(item, id){
            switch( item.type ) {
                case 'type_table_start':
                    _.printElementTableStart( item, id );
                    break;

                case 'type_table_end':
                    _.printElementTableEnd(item, id );
                    break;

                case 'type_table_data_start':
                    _.printElementTableDataStart( item, id);
                    break;

                case 'type_table_data_end':
                    _.printElementTableDataEnd( item, id );
                    break;

                case 'type_new_line':
                    _.printElementNewLine( item, id );
                    break;

                case 'type_html':
                    _.printElementHtml( item, id );
                    break;

                case 'type_heading':
                    _.printElementHeading( item, id );
                    break;

                case 'type_paragraph':
                    _.printElementParagraph( item, id );
                    break;

                case 'type_description':
                    _.printElementDescription( item, id );
                    break;

                case 'type_toggle_box_start':
                    _.printElementToggleBoxStart( item, id );
                    break;

                case 'type_toggle_box_end':
                    _.printElementToggleBoxEnd( item, id );
                    break;
            }
        });

        /*----------------------------------------------------------*/
        /* TABLE START
        /*----------------------------------------------------------*/
        _.printElementTableStart =  function( item, id ){
            var classParam = _.getItemClassesString( item );

            _.output += '<table class="' + classParam +' form-table ff-options"><tbody>';

        };


        /*----------------------------------------------------------*/
        /* TABLE END
        /*----------------------------------------------------------*/
        _.printElementTableEnd =  function( item, id ){
            _.output += '</tbody></table>';
        };


        /*----------------------------------------------------------*/
        /* TABLE DATA START
        /*----------------------------------------------------------*/
        _.printElementTableDataStart = function( item, id ) {
            _.output += '<tr>';
            _.output += '<th scope="row">' + item.title + '</th>';
            _.output += '<td><fieldset>';

        }

        /*----------------------------------------------------------*/
        /* TABLE DATA END
        /*----------------------------------------------------------*/
        _.printElementTableDataEnd = function( item, id ) {
            _.output += '</fieldset></td></tr>';
        }

        /*----------------------------------------------------------*/
        /* NEW LINE
        /*----------------------------------------------------------*/
        _.printElementNewLine = function( item, id ) {
            _.output += '<br>';
        }


        /*----------------------------------------------------------*/
        /* HEADING
        /*----------------------------------------------------------*/
        _.printElementHeading = function( item, id ) {
            var type = _.getItemParam('heading_type');
            if( type == null ) {
                type = 'h3';
            }

            _.output += '<' + type + '>';
            _.output += item.title;
            _.output += '</' + type + '>';
        }

        /*----------------------------------------------------------*/
        /* PARAGRAPH
        /*----------------------------------------------------------*/
        _.printElementParagraph = function( item, id ) {
            _.output += '<p>';
            _.output += item.title;
            _.output += '</p>';
        }


        /*----------------------------------------------------------*/
        /* DESCRIPTION
        /*----------------------------------------------------------*/
        _.printElementDescription= function( item, id ) {
            var type = _.getItemParam( item, 'tag', 'p');
            _.output += '<' + type + ' class="description">';
            _.output += item.title;
            _.output += '</' + type + '>';
        }

        /*----------------------------------------------------------*/
        /* TOGGLE BOX START
        /*----------------------------------------------------------*/
        _.printElementToggleBoxStart = function( item, id ) {
            _.output += '<ul style="display: block;" class="ff-repeatable  ff-odd ff-repeatable-boxed ">';
                _.output += '<li class="ff-repeatable-template-holder"></li>';
                _.output += '<li class="ff-repeatable-item ff-repeatable-item-closed" style="opacity: 1;">';
                    _.output += '<div class="ff-repeatable-header ff-repeatable-handle">';
                        _.output += '<table class="ff-repeatable-header-table">';
                            _.output += '<tbody>';
                            _.output += '<tr>';
                                _.output += '<td class="ff-repeatable-item-number"></td>';
                                _.output += '<td class="ff-repeatable-title">' + item.title + '</td>';
                                _.output += '<td class="ff-repeatable-description"></td>';
                            _.output += '</tr>';
                            _.output += '</tbody>';
                        _.output += '</table>';
                        _.output += '<div class="ff-repeatable-handle "></div>';
                    _.output += '</div>';
                    _.output += '<div class="ff-repeatable-content" style="display: none;">';
        }

        /*----------------------------------------------------------*/
        /* TOGGLE BOX END
        /*----------------------------------------------------------*/
        _.printElementToggleBoxEnd = function( item, id ) {
                    _.output += '</div>';
                _.output += '</li>';
            _.output += '</ul>';
        }


        /*----------------------------------------------------------*/
        /* HTML
        /*----------------------------------------------------------*/
        _.printElementHtml = function( item, id ) {
            var sanitized = item.title;

            var ret = sanitized.replace(/&gt;/g, '>');
            ret = ret.replace(/&lt;/g, '<');
            ret = ret.replace(/&quot;/g, '"');
            ret = ret.replace(/&apos;/g, "'");
            ret = ret.replace(/&amp;/g, '&');

            _.output += ret;
        }

/**********************************************************************************************************************/
/* OPTION
/**********************************************************************************************************************/
        /*----------------------------------------------------------*/
        /* GET PLACEHOLDER
        /*----------------------------------------------------------*/
        _.getPlaceholder = function( item ) {
            var placeholder = _.getItemParam( item, 'placeholder');

            if( placeholder != null ) {
                return ' placeholder="' + placeholder + '" ';
            } else {
                return '';
            }
        }


        _.missingOptions = {};

        walker.setCallbackOneOption(function(item, id, nameRoute ){
            switch( item.type ) {
                case 'text' :
                    _.printOptionText(item, id, nameRoute );
                    break;

                case 'number' :
                    _.printOptionNumber(item, id, nameRoute );
                    break;


                case 'textarea' :
                    _.printOptionTextarea(item, id, nameRoute );
                    break;

                case 'checkbox' :
                    _.printOptionCheckbox( item, id, nameRoute );
                    break;

                case 'image' :
                    _.printOptionImage( item, id, nameRoute);
                    break;

                case 'icon' :
                    _.printOptionIcon( item, id, nameRoute );
                    break;

                case 'select' :
                    _.printOptionSelect( item, id, nameRoute );
                    break;


                case 'select2' :
                    _.printOptionSelect2( item, id, nameRoute );
                    break;
                case 'navigation_menu_selector' :
                    _.printOptionNavigationMenuSelector( item, id, nameRoute );
                    break;

                case 'color_picker_wp' :
                    item.params = {};
                    item.params['class'] ='ff-default-wp-color-picker';
                    _.printOptionText(item, id, nameRoute );
                    break;

                default :

                    _.output += '<span style="color:red">' + item.type + ' MISSING - javascript options printer </span><br>';
                    _.missingOptions[ item.type ] = 1;

                    console.log(_.missingOptions );
                    break;

            }
        });

        /*----------------------------------------------------------*/
        /* OPTION TEXT
        /*----------------------------------------------------------*/
        _.printOptionText = function( item, id, nameRoute ) {
            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';
            input += '<input type="text" ';
            input += ' name="' + nameRoute + '" ';
            input += ' class="' + _.getItemClassesString( item ) + '" ';
            input += ' value="' + item.value + '" ';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';


            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }
                if(_.getItemParam( item, 'fullwidth') ) {
                    _.output += '<label class="ff-input-wideflex__label">';
                        _.output += '<div class="ff-input-wideflex__label-text">';
                            _.output += label;
                        _.output += '</div>';
                        _.output += '<div class="ff-input-wideflex__input-wrapper">';
                            _.output += input;
                        _.output += '</div>';
                        _.output += labelAfter;
                    _.output += '</label>';
                } else {
                    _.output += '<label>';
                        _.output += label;
                        _.output += ' ';
                        _.output += input;
                        _.output += ' ';
                        _.output += labelAfter;
                    _.output += '</label>';
                }

            }
        }


        /*----------------------------------------------------------*/
        /* OPTION NUMBER
        /*----------------------------------------------------------*/
        _.printOptionNumber = function( item, id, nameRoute ) {
            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';
            input += '<input type="number" ';
            input += ' name="' + nameRoute + '" ';
            input += ' class="' + _.getItemClassesString( item ) + '" ';
            input += ' value="' + item.value + '" ';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';


            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }
                if(_.getItemParam( item, 'fullwidth') ) {
                    _.output += '<label class="ff-input-wideflex__label">';
                        _.output += '<div class="ff-input-wideflex__label-text">';
                            _.output += label;
                        _.output += '</div>';
                        _.output += '<div class="ff-input-wideflex__input-wrapper">';
                            _.output += input;
                        _.output += '</div>';
                        _.output += labelAfter;
                    _.output += '</label>';
                } else {
                    _.output += '<label>';
                        _.output += label;
                        _.output += ' ';
                        _.output += input;
                        _.output += ' ';
                        _.output += labelAfter;
                    _.output += '</label>';
                }

            }
        }



        /*----------------------------------------------------------*/
        /* OPTION TEXTAREA
        /*----------------------------------------------------------*/
        _.printOptionTextarea = function( item, id, nameRoute ) {

            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';
            input += '<textarea ';
            input += ' name="' + nameRoute + '" ';
            input += _.getItemCols( item );
            input += _.getItemRows( item );
            input += ' class="' + _.getItemClassesString( item ) + ' ff-options__textarea"';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';

            input += item.value;

            input += '</textarea>';

            input += '<span class="description">' + item.description + '</span>';

            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }

                    _.output += '<label class="ff-options__textarea__label">';
                        _.output += label;
                        _.output += ' ';
                        _.output += input;
                        _.output += ' ';
                        _.output += labelAfter;
                    _.output += '</label>';
            }
        }


        /*----------------------------------------------------------*/
        /* OPTION CHECKBOX
        /*----------------------------------------------------------*/
        _.printOptionCheckbox = function( item, id, nameRoute ) {

            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';
            //input += '<div class="ff-checkbox-wrapper">';
            input += '<input type="hidden" class="ff-checkbox-shadow" value="0" name="' + nameRoute + '" >';

            input += '<input type="checkbox" ';
            input += ' name="' + nameRoute + '" ';
            input += ' value="1" ';
            input += _.getItemCheckedCheckBox( item );
            input += ' class="' + _.getItemClassesString( item ) + '"';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';
            //input += '<div>';


            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }

                    _.output += '<label>';
                        _.output += input;
                        _.output += ' ';
                        _.output += label;
                    _.output += '</label>';
            }
        }

        /*----------------------------------------------------------*/
        /* OPTION SELECT
        /*----------------------------------------------------------*/
        _.printOptionSelect = function( item, id, nameRoute ) {
            var selectValues = item.selectValues;
            var selectedValue = item.value;
            var isGroup = _.getItemParam( item, 'is_group', false);


            var enables = _.getItemParam( item, 'enables', '');
            if( enables != '' ) {
                enables = ' data-enables="' + enables + '" ';
            }

            var input = '';

            if(_.getItemParam( item, 'print_label', true) == true ) {
                input += '<label>';
            }

            input += item.title;
            input += '<select our-value="'+selectedValue+'" class="' + _.getItemClassesString( item ) + '" name="' + nameRoute + '" ' + enables + '>';

                if( !isGroup ) {

                    for( var i in selectValues ) {
                        var oneValue = selectValues[i];
                        var selected = '';

                        if( oneValue.value == selectedValue ) {
                            selected = ' selected="selected" ';
                        }

                        input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

                    }

                } else {

                    alert(' OPTIONS IN GROUPS ARE NOT READY!!!')

                }

            input += '</select>';

            if(_.getItemParam( item, 'print_label', true) == true ) {
                input += '</label>';
            }

            _.output += input;
        }


        /*----------------------------------------------------------*/
        /* SELECT2
        /*----------------------------------------------------------*/
        _.printOptionSelect2 = function( item, id, nameRoute ) {


            var selectValues = item.selectValues;
            var selectedValue = item.value;

            var selectedValueExploded = selectedValue.split('--||--');
            var multiple = _.getItemParam( item, 'type', '');

            var input = '';

            input += '<div class="ff-select2-wrapper">';

                // real value wrapper
                input += '<div class="ff-select2-value-wrapper">';
                input += '<input type="text" class="ff-select2-value" name="'+ nameRoute + '" value="'+ selectedValue +'">';
                input += '</div>';

                input += '<div class="ff-select2-real-wrapper">';
                    input += '<select ' + multiple + ' size="1" data-selected-value="' + selectedValue + '" class="ff-select2" name="' + nameRoute +'" >';

                        for( var i in selectValues ) {
                            var oneValue = selectValues[i];
                            var selected = '';


                            if($.isArray( selectedValueExploded ) ) {
                                //console.log( $.inArray( oneValue.value,  selectedValueExploded ) );
                                //    console.log( oneValue.value.toString(), selectedValueExploded );
                                if($.inArray( oneValue.value.toString(),  selectedValueExploded  ) != -1 ) {
                                    selected = ' selected="selected" ';
                                }
                            } else {

                                if( oneValue.value == selectedValue ) {
                                    selected = ' selected="selected" ';
                                }
                            }



                            input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

                        }

                    input += '</select>';
                input += '</div>';



                input += '<div class="ff-select2-shadow-wrapper">';
                    input += '<select ' + multiple + ' size="1" data-selected-value="' + selectedValue + '" class="ff-select2" name="' + nameRoute +'" >';

                            for( var i in selectValues ) {
                                var oneValue = selectValues[i];
                                var selected = '';

                                if( oneValue.value == selectedValue ) {
                                    selected = ' selected="selected" ';
                                }

                                input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

                            }

                    input += '</select>';
                input += '</div>';


            input += '</div>';

            _.output += input;


        }

        _.printOptionNavigationMenuSelector = function( item, id, nameRoute ) {
            var selectValues = JSON.parse($('.ff-navigation-menu-selector-content').html());
            var selectedValue = item.value;
            var isGroup = _.getItemParam( item, 'is_group', false);


            var enables = _.getItemParam( item, 'enables', '');
            if( enables != '' ) {
                enables = ' data-enables="' + enables + '" ';
            }

            var input = '';

            if(_.getItemParam( item, 'print_label', true) == true ) {
                input += '<label>';
            }

            input += item.title;
            input += '<select class="ff-navigation-menu-selector ' + _.getItemClassesString( item ) + '" name="' + nameRoute + '" ' + enables + '>';

                if( !isGroup ) {

                    for( var i in selectValues ) {
                        var oneValue = selectValues[i];
                        var selected = '';

                        if( oneValue.value == selectedValue ) {
                            selected = ' selected="selected" ';
                        }

                        input += '<option value="' + oneValue.value + '" ' + selected + '>' + oneValue.name + '</option>';

                    }

                } else {

                    alert(' OPTIONS IN GROUPS ARE NOT READY!!!')

                }

            input += '</select>';

            if(_.getItemParam( item, 'print_label', true) == true ) {
                input += '</label>';
            }

            _.output += input;
        }

        /*----------------------------------------------------------*/
        /* OPTION IMAGE
        /*----------------------------------------------------------*/
        _.printOptionImage = function( item, id, nameRoute ) {


            var value = item.value;

            if( value == '' ) {
                var defaultValueJSON = {};
                defaultValueJSON.url = '';
                defaultValueJSON.id = '';
                defaultValueJSON.width = 0;
                defaultValueJSON.height = 0;
                value = defaultValueJSON;
            } else {
                value = JSON.parse( value );
            }


            var label = item.title;

            if( label == null ) {
                label = 'Select Image';
            }

            var dataForcedWidth = _.getItemParam( item, 'data-forced-width', '');
            if( dataForcedWidth != '' ) {
                dataForcedWidth = ' data-forced-width="' + dataForcedWidth + '" ';
            }

            var dataForcedHeight = _.getItemParam( item, 'data-forced-height', '');
            if( dataForcedHeight != '' ) {
                dataForcedHeight = ' data-forced-height="' + dataForcedHeight + '" ';
            }

            input = '';

            input +=  '<span class="ff-open-library-button-wrapper ff-open-image-library-button-wrapper">';
            input +=  '<a class="ff-open-library-button ff-open-image-library-button" ' + dataForcedWidth + ' ' + dataForcedHeight + '>';
            input +=  '<span class="ff-open-library-button-preview">';
            input +=  '<span class="ff-open-library-button-preview-image" style="background-image:url(\'' + _.escapeValue( value.url ) + '\');">';
            input +=  '</span>';
            input +=  '</span><span class="ff-open-library-button-title">' + label + '</span>';
            input +=  '<input type="hidden" name="' + nameRoute + '" id="" class="ff-image" value="' + _.escapeValue( item.value ) +'">';
            input +=  '<span class="ff-open-library-button-preview-image-large-wrapper">';
            input +=  '<img class="ff-open-library-button-preview-image-large" src="'  + _.escapeValue( value.url ) + '" width="'+ value.width + '" height="'+ value.height + '">';
            input +=  '</span>';
            input +=  '</a>';
            input +=  '<a class="ff-open-library-remove" title="Clear"></a>';
            input +=  '</span>';


            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');
            var description = item.description;


            if( description == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }

                    _.output += '<label>';
                        _.output += description;
                        _.output += ' ';
                        _.output += input;
                        _.output += ' ';
                        _.output += labelAfter;
                    _.output += '</label>';
            }

        }

        _.printOptionIcon = function( item, id, nameRoute ) {
            var label = item.title;

            if( label == null ) {
                label = 'Select Icon';
            }

            var data_autofilter = _.getItemParam( item, 'data-autofilter', '');
            if( data_autofilter != '' ) {
                data_autofilter = ' data-autofilter="'+data_autofilter+'" ';
            }

            var input = '';
            input += '<span class="ff-open-icon-library-button-wrapper">';
			input += '<a class="ff-open-library-button ff-open-library-icon-button">';
				input += '<span class="ff-open-library-button-preview">';

				input += '<i class="' + item.value + '"></i>';

				input += '</span>';
				input += '<span class="ff-open-library-button-title">' + label + '</span>';
				input += '<input type="hidden" name="' + nameRoute +'" id="" class="ff-icon" value="' + _.escapeValue( item.value )+ '" ' + data_autofilter +'>';

                input += '</a>';
            input += '</span>';

            _.output += input;
        }

        /*----------------------------------------------------------*/
        /* OPTION RADIO
        /*----------------------------------------------------------*/
        _.printOptionRadio = function( item, id, nameRoute ) {


            _.output += '<span style="color:red; font-size:20px;"> OPTION RADIO MISSING </span>';

            var label = item.title;
            var labelAfter = _.getItemParam(item, 'PARAM_TITILE_AFTER');

            var input = '';

            input += '<input type="hidden" value="0" name="' + nameRoute + '" >';

            input += '<input type="checkbox" ';
            input += ' name="' + nameRoute + '" ';
            input += ' value="1" ';
            input += _.getItemCheckedCheckBox( item );
            input += ' class="' + _.getItemClassesString( item ) + '"';
            input += ' ' + _.getPlaceholder( item ) + ' ';
            input += '>';

            if( label == null && labelAfter == null ) {
                _.output += input;
            } else {
                if( labelAfter == null ) {
                    labelAfter = '';
                }

                    _.output += '<label>';
                        _.output += input;
                        _.output += ' ';
                        _.output += label;
                    _.output += '</label>';
            }
        }




/**********************************************************************************************************************/
/* VARIATION
/**********************************************************************************************************************/
        walker.setCallbackBeforeRepeatableVariationContainer(function( item, id, index ){

            if( item == null ) {
                return;
            }
            //console.log('--- variation - START ' + item.id );

            var sectionName = _.getItemParam( item, 'section-name');

            var hideDefault = _.getItemParam(item, 'hide-default');

            var currentSectionRoute = _.walker.getCurrentSectionRoute();

            _.output += '<li class="ff-repeatable-item ff-repeatable-item-js ff-repeatable-item-'+index+' ff-repeatable-item-closed" data-section-id="'+item.id+'" data-section-name="'+sectionName+'" data-node-id="'+index+'" data-current-section-route="'+currentSectionRoute+'">';


            if(_.getItemParam( item, 'advanced-picker-menu-title') != null ) {
                _.output += '<div class="ff-repeatable-section-info" style="display:none">';
                    _.output +=  '<span class="ff-advanced-section-name">'+ _.getItemParam( item, 'section-name')+'</span>';
                    _.output +=  '<span class="ff-advanced-section-id">' + item.id + '</span>';
                    _.output +=  '<span class="ff-advanced-section-image">'+ _.getItemParam( item, 'advanced-picker-section-image') + '</span>';
                    _.output +=  '<span class="ff-advanced-menu-title">'+ _.getItemParam( item, 'advanced-picker-menu-title') + '</span>';
                    _.output +=  '<span class="ff-advanced-menu-id">'+ _.getItemParam( item, 'advanced-picker-menu-id') + '</span>';
                _.output +=  '</div>';
            }

            // HEADER
            _.output +=  '<div class="ff-repeatable-header ff-repeatable-drag ff-repeatable-handle ui-sortable">';

            _.output += '<table class="ff-repeatable-header-table"><tbody><tr>';
                _.output += '<td class="ff-repeatable-item-number"></td>';
                _.output += '<td class="ff-repeatable-title">' + sectionName + '</td>';
                _.output += '<td class="ff-repeatable-description"> </td>';
                _.output += '</tr></tbody></table>';
                _.output += '<div class="ff-repeatable-handle"></div>';
                _.output += '<div class="ff-repeatable-settings"></div>';

                    if(_.getItemParam( item, 'advanced-picker-section-image') != null ) {
                        var url = _.getItemParam( item, 'advanced-picker-section-image');
                        _.output += '<div class="ff-repeatable-preview">';
                            _.output += '<img src="' + url + '" alt="">';
                        _.output += '</div>';
                    }

                _.output += '<div class="ff-popup-container">';
                _.output += '<div class="ff-popup-wrapper">';
                    _.output += '<div class="ff-popup-backdrop"></div>';
                    _.output += '<ul class="ff-repeatable-settings-popup ff-popup">';

                        //_.output += '<li class="ff-popup-button-wrapper">';
                        //    _.output += '<div class="ff-popup-button ff-repeatable-js-duplicate-above">Duplicate Above</div>';
                        //_.output += '</li>';
                        //
                        //_.output += '<li class="ff-popup-button-wrapper">';
                        //    _.output += '<div class="ff-popup-button ff-repeatable-js-duplicate-below">Duplicate Below</div>';
                        //_.output += '</li>';

                        _.output += '<li class="ff-popup-button-wrapper">';
                            _.output += '<div class="ff-popup-button ff-repeatable-remove">Remove</div>';
                        _.output += '</li>';
                    _.output += '</ul>';
                _.output += '</div>';
            _.output += '</div>';
            _.output += '</div>';
            _.output += '<div class="ff-repeatable-content">';
        });

        walker.setCallbackAfterRepeatableVariationContainer(function( item, id ){
            _.output += '</div>';

            _.output += '<div class="ff-repeatable-controls-top ff-repeatable-variation-selector">';
            _.output += '<div class="ff-repeatable-add-above ff-repeatable-add-above-js" title="Add Item"></div>';

                _.output += '<div class="ff-popup-container">';
                            _.output += '<div class="ff-popup-wrapper">';
                                _.output += '<div class="ff-popup-backdrop"></div>';
                                _.output += '<ul class="ff-popup ff-repeatable-add-variation-selector-popup">';
                                    _.output += '<li class="ff-popup-button-wrapper">';
                                        _.output += '<div class="ff-popup-button">Placeholder</div>';
                                    _.output += '</li>';
                                _.output += '</ul>';
                            _.output += '</div>';
                        _.output += '</div>';
            _.output += '</div>';



            _.output += '<div class="ff-repeatable-controls-bottom ff-repeatable-variation-selector">';
            _.output += '<div class="ff-repeatable-add-below ff-repeatable-add-below-js" title="Add Item"></div>';
                    _.output += '<div class="ff-popup-container">';
                        _.output += '<div class="ff-popup-wrapper">';
                            _.output += '<div class="ff-popup-backdrop"></div>';
                            _.output += '<ul class="ff-popup ff-repeatable-add-variation-selector-popup">';
                                _.output += '<li class="ff-popup-button-wrapper">';
                                    _.output += '<div class="ff-popup-button">Placeholder</div>';
                                _.output += '</li>';
                            _.output += '</ul>';
                        _.output += '</div>';
                    _.output += '</div>';
            _.output += '</div>';

            _.output += '</li>';
        });

/**********************************************************************************************************************/
/* VARIABLE
/**********************************************************************************************************************/
        walker.setCallbackBeforeRepeatableVariableContainer(function(item, id ){
            var currentLevel = _.getCurrentRouteCount();
            var currentSectionRoute = _.walker.getCurrentSectionRoute();
            var classes = '';

            if(_.getItemParam( item, 'section-picker') == 'advanced' ) {
                classes += 'ff-section-picker-advanced';
            }

            _.output += '<ul class="ff-repeatable ff-repeatable-js ff-repeatable-boxed '+classes+'" data-current-level="'+currentLevel+'" data-current-section-route="'+currentSectionRoute+'">';
        });

        walker.setCallbackAfterRepeatableVariableContainer(function(item, id ){
            _.output += '</ul>';
        });



        return _;
    }
})(jQuery);