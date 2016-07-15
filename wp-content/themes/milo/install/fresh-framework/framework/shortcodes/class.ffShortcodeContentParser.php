<?php

class ffShortcodeContentParser extends ffBasicObject {
    const SUFFIX = '_depth_';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    /**
     * @var ffCollection
     */
    private $_recursiveShortcodesCollection = null;

    private $_content = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct() {

    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

    public function filterShortcodes() {
        foreach( $this->_getRecursiveShortcodesCollection() as $oneItem ) {
            $this->_searchAndAdjustContentForOneShortcodeObject( $oneItem );
        }
        return $this->_getContent();
    }


    public function setRecursiveShortcodesCollection( $collection ) {
        $this->_setRecursiveShortcodesCollection( $collection );
    }

    public function setContent( $content ) {
        $this->_setContent( $content );
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _searchAndAdjustContentForOneShortcodeObject( ffShortcodeObjectBasic $shortcodeObject ) {
        $content = $this->_getContent();
        foreach( $shortcodeObject->getShortcodeNames() as $oneName ) {
            $regex = $this->_getRegexpStringForShortcode( $oneName );

            $offset = 0;
            $depth = 0;
            $matches = array();

            // go through all shortcodes of one name, it match [shortcode] and also [/shortcode]
            while( preg_match( $regex, $content, $matches, PREG_OFFSET_CAPTURE, $offset ) ) {
                $matchedString = $matches[0][0];
                $position = $matches[0][1];

                // its opening of new level
                if( strpos( $matchedString, '/' ) === false ) {
                    $depth++;
                }

                // we detected nested shortcode
                if( $depth > 1 ) {

                    // create sufix with the level
                    $suffix = ffShortcodeContentParser::SUFFIX.($depth-1);

                    // replace the old shortcode with the new one
                    $newShortcodeName = str_replace($oneName, $oneName.$suffix, $matchedString );

                    $newShortcodeNameClean = str_replace(array('[',']', '/', ' '), '', $newShortcodeName );

                    $shortcodeObject->addName( $newShortcodeNameClean );


                    $newContent = substr( $content,0, $position);
                    $newContent .= $newShortcodeName;
                    $newContent .= substr( $content, $position + strlen( $matchedString ) );

                    $content = $newContent;

                    $offset = $position + strlen( $newShortcodeName );
                } else {
                    $offset = $position + strlen( $matchedString );
                }


                // its closing current level
                if( strpos( $matchedString, '/' ) !== false ) {
                    $depth--;
                }

            }
        }
        $this->_setContent( $content );
    }

    private function _getRegexpStringForShortcode( $shortcodeName ) {
        $regExp = '/';              // start of regexp

        $regExp .='\[+';            // start of shortcode ( 1 - N x the "[" ) -> [ or [[ or [[[

        $regExp .= '\/?';           // possible closing tag

        $regExp .= $shortcodeName;  // shortcode name

        $regExp .= '[ \]]';         // possible closing tags and space

        $regExp .= '/i';            // end of regexp ( i = case insensitive )

        return $regExp;
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffCollection
     */
    private function _getRecursiveShortcodesCollection()
    {
        return $this->_recursiveShortcodesCollection;
    }

    /**
     * @param ffCollection $recursiveShortcodesCollection
     */
    private function _setRecursiveShortcodesCollection($recursiveShortcodesCollection)
    {
        $this->_recursiveShortcodesCollection = $recursiveShortcodesCollection;
    }

    /**
     * @return null
     */
    private function _getContent()
    {
        return $this->_content;
    }

    /**
     * @param null $content
     */
    private function _setContent($content)
    {
        $this->_content = $content;
    }


}


//
//function enable_recursive_shortcodes($content) {
//
//    $recursive_tags = array( 'column', 'div', 'span', 'table' ); // define recursive shortcodes, these must have closing tags
//    $suffix = '__recursive'; // suffix is added to the tag of recursive shortcodes
//
//    $content = str_replace( $suffix, '', $content ); // remove old suffix on shortcodes to start process over
//
//    foreach( $recursive_tags as $recursive_tag ) {
//
//        $open_tag = '[' . $recursive_tag . ' ';
//        $close_tag = '[/'. $recursive_tag . ']';
//
//        $open_tags = 0;
//
//        $open_pos = stripos( $content, $open_tag ); // find first opening tag
//
//        $offset = $open_pos + strlen( $open_tag ); // set offset for first closing tag
//
//        while( $open_pos !== false ) {
//
//            $close_pos = stripos( $content, $close_tag, $offset ); // find first closing tag
//
//            if(++$open_tags > 1) { // if we are inside an open tag
//
//                // modify open tag from original shortcode name
//                $content = substr( $content, 0, $open_pos ) .
//                            '[' .$recursive_tag . $suffix . ' ' .
//                              substr( $content, $offset );
//                // modify closing tag from original shortcode name
//                $content = substr( $content, 0, $close_pos + strlen($suffix) ) .
//                            '[/'.$recursive_tag.'__recursive]' .
//                            substr( $content, $close_pos + strlen( $close_tag ) + strlen($suffix) );
//                $open_tags--;
//            }
//
//            $open_pos = stripos( $content, $open_tag, $offset ); // find next opening tag
//
//            if( $close_pos < $open_pos ) $open_tags--; // if closing tag comes before next opening tag, lower open tag count
//
//            $offset = $open_pos + strlen($open_tag); // set new offset for next open tag search
//
//        }
//
//    }
//
//    return $content;
//
//}