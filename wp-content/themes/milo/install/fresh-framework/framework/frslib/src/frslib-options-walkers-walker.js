(function($){
    frslib.provide('frslib.options');
    frslib.provide('frslib.options.walkers');



/**********************************************************************************************************************/
/* WALKER
/**********************************************************************************************************************/
    frslib.options.walkers.walker = function() {

        var _ = {};

/**********************************************************************************************************************/
/* CALLBACK VARIABLE CONTAINER
/**********************************************************************************************************************/
        _.setCallbackBeforeRepeatableVariableContainer = function( callback ) {
            _.callbackBeforeRepeatableVariableContainer = callback;
        }

        _.setCallbackAfterRepeatableVariableContainer = function( callback ) {
            _.callbackAfterRepeatableVariableContainer = callback;
        }

        _.callbackBeforeRepeatableVariableContainer = function(){};
        _.callbackAfterRepeatableVariableContainer = function(){};


/**********************************************************************************************************************/
/* CALLBACK VARIATION CONTAINER
/**********************************************************************************************************************/
        _.setCallbackBeforeRepeatableVariationContainer = function( callback ) {
            _.callbackBeforeRepeatableVariationContainer = callback;
        }

        _.setCallbackAfterRepeatableVariationContainer = function( callback ) {
            _.callbackAfterRepeatableVariationContainer = callback;
        }

        _.callbackBeforeRepeatableVariationContainer = function(){};
        _.callbackAfterRepeatableVariationContainer = function(){};

/**********************************************************************************************************************/
/* CALLBACK VARIATION CONTAINER
/**********************************************************************************************************************/

        _.setCallbackBeforeNormalSectionContainer = function( callback ) {
            _.callbackBeforeNormalSectionContainer = callback;
        }

        _.setCallbackAfterNormalSectionContainer = function( callback ) {
            _.callbackAfterNormalSectionContainer = callback;
        }

        _.callbackBeforeNormalSectionContainer = function(){};
        _.callbackAfterNormalSectionContainer = function(){};

/**********************************************************************************************************************/
/* CALLBACK OPTION AND ELEMENT
/**********************************************************************************************************************/

        _.setCallbackOneOption = function( callback ) {
            _.callbackOneOption = callback;
        }

        _.setCallbackOneElement = function( callback ) {
            _.callbackOneElement = callback;
        }

        _.callbackOneOption = function(){};
        _.callbackOneElement = function(){};

/**********************************************************************************************************************/
/* OTHER THINGS
/**********************************************************************************************************************/

        _.structure = null;
        _.data = null;
        _.prefix = null;
        // ignore user data input (so it will walk through all the repeatable shit except the hide default );
        _.ignoreData = false;
        _.ignoreHideDefault = false;

        _.setIgnoreHideDefault = function( hideDefault ) {
            _.ignoreHideDefault = hideDefault;
        }

        _.setPrefix = function ( prefix ) {
            _.prefix = prefix;
        }

        _.setStructureString = function( structureString ) {
            var structureJSON = JSON.parse( structureString );
            _.setStructureJSON( structureJSON );
        }

        _.setStructureJSON = function( structureJSON ) {
            _.structure = structureJSON;
        }

        _.setDataString = function( dataString ) {
            var dataJSON = JSON.parse( dataString );
            _.setDataJSON( dataJSON );
        }

        _.setDataJSON = function( dataJSON ) {
            if( dataJSON == null || dataJSON == false) {
                _.ignoreData = true;
            } else {
                _.ignoreData = false;
                _.data = dataJSON;
            }
        }

/**********************************************************************************************************************/
/* WALK
/**********************************************************************************************************************/
        _.walk = function() {
            if(_.prefix == null ) {
                _.prefix = 'default';
            }
            //console.log(_.structure);
            //console.log(_.data);
            var startSection = _.structure.data;

            if( startSection.type == 'section' ) {
                _.addRoute( startSection.id );
            }
            _.walkItem( startSection );

            if( startSection.type == 'section' ) {
                _.removeRoute( startSection.id );
            }
        }
/**********************************************************************************************************************/
/* ROUTES
/**********************************************************************************************************************/
        _.idRoute = {};
        _.idRouteCount = 0;

        _.sectionRoute = {};
        _.sectionRouteCount = 0;


        _.addRouteSection = function( sectionName ) {
            _.sectionRoute[_.sectionRouteCount ] = sectionName;
            _.sectionRouteCount ++;
        }

        _.removeRouteSection = function( sectionName ) {
            _.sectionRouteCount--;
            delete _.sectionRoute[_.sectionRouteCount ];
        }

        _.getCurrentSectionRoute = function() {
            var toReturn = new Array();
            for( var id in _.sectionRoute ) {
                toReturn[id] = _.sectionRoute[id];
            }
            return toReturn.join(' ');
        }

        _.addRoute = function( id ) {
            _.idRoute[_.idRouteCount ] = id;
            _.idRouteCount++;
        }

        _.removeRoute = function( id ) {
            _.idRouteCount--;
            delete _.idRoute[_.idRouteCount ];
        }


        _.getCurrentRouteValue = function () {
            var currentRouteDataHolder = _.data;
            for( var key in _.idRoute) {
                var name = _.idRoute[ key ];

                if( currentRouteDataHolder == undefined ) {
                    return null;
                }

                currentRouteDataHolder = currentRouteDataHolder[name];
            }

            return currentRouteDataHolder;
        }

        _.getReferenceItem = function( ID ) {
            return _.structure.reference[ID];
        }
/**********************************************************************************************************************/
/* WALKERS
/**********************************************************************************************************************/
        _.walkItem = function( item ) {
                if( item == null || item == undefined ) {
                    return false;
                }

                if( item.overall_type == 'option' ) {
                    _.walkOption( item );
                } else if( item.overall_type == 'element' ) {
                    _.walkElement( item );
                } else if( item.overall_type == 'section' ) {
                    _.walkContainer( item );
                } else if( item.overall_type == 'reference' ) {
                    var newItem = _.getReferenceItem( item.id );

                    _.walkItem( newItem );
                }

        }

        _.walkOption = function ( item ) {

            item.userValue =  _.getCurrentRouteValue();



            if( item.userValue == null ) {
                item.value = item.defaultValue;
            } else {
                item.value = item.userValue;
            }

            if( item.type != 'image' ) {
                if( item.value != undefined && item.value.replace != undefined ) {
                    item.value = item.value.replace(/"/g, '&quot;');
                }
            }

            var nameRoute = '';

            for( var index in _.idRoute ) {
                if( _.idRoute[ index ]. split( '-|-').length == 2 ) {
                    //[-_-1-TEMPLATE-_--|-heading]
                    var currentValue = '-_-'+index+'-TEMPLATE-_--|-' + _.idRoute[ index ]. split( '-|-')[1];
                } else {
                    var currentValue = _.idRoute[index];
                }
                nameRoute += '[' + currentValue + ']';
            }
            nameRoute = _.prefix + nameRoute;


            //setTimeout(_.callbackOneOption, 0, item, _.idRoute, nameRoute );
            _.callbackOneOption( item, _.idRoute, nameRoute );

        }

        _.walkElement = function( item ) {
            _.callbackOneElement( item, _.idRoute );
        }

        _.walkContainer = function( item ) {
            if( item == null || item == undefined ) {
                return false;
            }

            _.addRouteSection( item.id );
            if( item.type == 'repeatable_variable' ) {
                _.walkContainerRepeatableVariable( item );
            } else if( item.type == 'repeatable_variation' ){
                _.walkContainerRepeatableVariation( item );
            } else if( item.type == 'section' ) {
                _.walkContainerSection( item );
            }
            _.removeRouteSection( item.id );
        }

        _.walkContainerSection = function( item ) {
            _.callbackBeforeNormalSectionContainer();
            for( var childId in item.childs ) {

                var child = item.childs[ childId ];

                if( child.type != 'repeatable_variable' && child.type != 'repeatable_variation') {
                    _.addRoute( child.id );
                        _.walkItem( child );
                    _.removeRoute( child.id);
                } else {
                     _.walkItem( child );
                }
            }
            _.callbackAfterNormalSectionContainer();
        }

        _.walkContainerRepeatableVariation = function( item ) {

            for( var childId in item.childs ) {

                var child = item.childs[ childId ];

                if( child.type != 'repeatable_variable' && child.type != 'repeatable_variation') {
                    _.addRoute( child.id );
                        _.walkItem( child );
                    _.removeRoute( child.id);
                } else {
                     _.walkItem( child );
                }
            }

        }

        _.findChildById = function( itemContainingChilds, id ) {
            var childToReturn = null;

            for( var childId in itemContainingChilds.childs ) {

                if( itemContainingChilds.childs[ childId][ 'id' ] == id ) {
                    childToReturn = itemContainingChilds.childs[ childId ];
                    break;
                }

            }

            return childToReturn;
        }

        _.walkContainerRepeatableVariable = function( item ) {

            _.addRoute( item.id );


            _.callbackBeforeRepeatableVariableContainer( item, _.idRoute );

            var repeatableItems = _.getCurrentRouteValue();

            var ignoreData = false;

            if( repeatableItems == null || _.ignoreData == true) {
                ignoreData = true;
            }

            if( ignoreData == false ) {
                for( var oneItemNameWithNumber in repeatableItems ) {
                    // name = 0-|-navigation (for example)
                    var splitedNames = oneItemNameWithNumber.split('-|-');
                    var sectionID = splitedNames[0];
                    var sectionName = splitedNames[1];

                    _.addRoute( oneItemNameWithNumber );
                    _.addRoute( sectionName );

                        var newChild = _.findChildById( item, sectionName );

                        _.callbackBeforeRepeatableVariationContainer( newChild, _.idRoute, sectionID );
                        _.walkContainer( newChild );
                        _.callbackAfterRepeatableVariationContainer( newChild, _.idRoute, sectionID );

                    _.removeRoute( sectionName );
                    _.removeRoute( oneItemNameWithNumber );


                }
            } else {
                for( var childNumber in item.childs ) {
                    var child = item.childs[ childNumber];

                    if(_.ignoreHideDefault == false &&
                            child.params != null && child.params != undefined &&
                        child.params['hide-default'] != undefined &&
                        child.params['hide-default'][0] == true ) {
                        continue;
                    }

                    var childId =  child.id;

                    var childIdWithNumber = childNumber + '-|-' + childId;

                    _.addRoute( childIdWithNumber );
                    _.addRoute( childId );


                        _.callbackBeforeRepeatableVariationContainer( child, _.idRoute, childNumber );
                        _.walkContainer( child );
                        _.callbackAfterRepeatableVariationContainer( child, _.idRoute, childNumber );


                    _.removeRoute( childId );
                    _.removeRoute( childIdWithNumber );
                }


            }

            _.callbackAfterRepeatableVariableContainer( item, _.idRoute );

            _.removeRoute( item.id);
        }

        return _;
    }
})(jQuery);