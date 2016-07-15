<?php

class ffCommentsFormPrinter extends ffBasicObject {

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    private $_data = array();

    private $_replaceRules = array();

    public function __construct( ffWPLayer $WPLayer ) {
        $this->_setWPLayer( $WPLayer );
        $this->_setData('fresh-framework-validation', true);
    }

    public function disableFreshFrameworkValidation() {
        $this->_setData('fresh-framework-validation', false);
    }

    public function commentsOpen() {
        return $this->_getWPLayer()->comments_open();
    }

    public function addFieldAuthorLine( $line ) {
        $this->_addLineToData( 'field-author', $line );
    }

    public function addFieldEmailLine( $line ) {
        $this->_addLineToData( 'field-email', $line );
    }

    public function addFieldWebsiteLine( $line ) {
        $this->_addLineToData( 'field-website', $line );
    }

    public function addFieldCommentLine( $line ) {
        $this->_addLineToData( 'field-comment', $line );
    }

    public function addFieldLoggedInLine( $line ) {
        $this->_addLineToData( 'field-logged-in', $line );
    }


    public function setClassFormElement( $class ) {
        $this->_setData('class-form-element', $class );
    }

    public function setClassSubmitButton( $class ) {
        $this->_setData('class-submit-button', $class );
    }

    public function setClassSubmitParagraph( $class ) {
        $this->_setData('class-submit-paragraph', $class );
    }

    public function addReplaceRule( $find, $replace, $isRegexp = false ) {
        $replaceRule = array();
        $replaceRule['find'] = $find;
        $replaceRule['replace'] = $replace;
        $replaceRule['is_regexp'] = $isRegexp;

        $this->_replaceRules[] = $replaceRule;
    }



    public function setFieldAuthor( $content ) {
        $this->_setData('field-author', $content );
    }

    public function setFieldEmail( $content ) {
        $this->_setData('field-email', $content );
    }

    public function setFieldWebsite( $content ) {
        $this->_setData('field-website', $content );
    }

    public function setFieldComment( $content ) {
        $this->_setData('field-comment', $content );
    }

    public function setFieldLoggedIn( $content ) {
        $this->_setData('field-logged-in', $content );
    }

    public function setTextSubmit( $content ) {
        $this->_setData('text-submit', $content );
    }

    public function setTextHeading( $content ) {
        $this->_setData('text-heading', $content );
    }

    /**
     * 1.) acquire data from our sources
     * 2.) print the comment form into output buffers
     * 3.) create internal filters based on our data (for replacing form class, <p> submit button and other things
     * 4.) apply all filters to the comment form
     * 5.) print comment form
     */
    public function printForm() {

        $fields = array();

        $fields['author'] = $this->_getData('field-author');
        $fields['email'] = $this->_getData('field-email');
        $fields['url'] = $this->_getData('field-website');

        $commentForm = $this->_getData('field-comment');
        $textSubmitButton = $this->_getData('text-submit');
        $textHeading = $this->_getData('text-heading');
        $fieldLoggedIn = $this->_replaceLoggedIn($this->_getData('field-logged-in'));

        $classSubmitButton = $this->_getData('class-submit-button');


        ob_start();
            $this->_getWPLayer()->comment_form(
                                    array(
                                        'comment_notes_after' => '',
                                        'fields' => $fields,
                                        'comment_field' => $commentForm,
                                        'label_submit' => $textSubmitButton,
                                        'comment_notes_before' => '',
                                        'logged_in_as' => $fieldLoggedIn,
                                        'comment_notes_after' => '',
                                        'title_reply' => ''.$textHeading.'',
                                        'class_submit' => $classSubmitButton,
                                    )
            );
        $content = ob_get_contents();
        ob_end_clean();

        $this->_addInternalReplaceRules();
        $contentAfterReplaceRules = $this->_applyReplaceRules( $content );

        echo $contentAfterReplaceRules;
    }

    private function _addInternalReplaceRules() {
        if( $this->_getData('class-form-element') != null ) {
            $this->addReplaceRule('class="comment-form"', 'class="comment-form '.$this->_getData('class-form-element').'"');
        }

        if( $this->_getData('class-submit-paragraph') != null ) {
            $this->addReplaceRule('class="form-submit"', 'class="form-submit '.$this->_getData('class-submit-paragraph').'"');
        }

        if( $this->_getData('fresh-framework-validation') == true ) {
            $this->addReplaceRule('class="comment-respond"', 'class="comment-respond ff-validate-comment-form"');
        }
    }


    private function _replaceLoggedIn( $loggedInText ) {
            $user = $this->_getWPLayer()->wp_get_current_user();
            $user_identity = $user->exists() ? $user->display_name : '';
            $this->_getWPLayer()->get_current_post()->ID;
            $post_id = $userEditLink = $this->_getWPLayer()->get_edit_user_link();
            $logoutUrl = $this->_getWPLayer()->wp_logout_url( apply_filters('the_permalink', $this->_getWPLayer()->get_permalink( $post_id ) ) );

            $loggedInAs = sprintf( $loggedInText, get_edit_user_link(), $user_identity, $logoutUrl );

            return $loggedInAs;
    }

    private function _applyReplaceRules( $content ) {
        if( empty($this->_replaceRules) ) {
            return $content;
        }

        foreach( $this->_replaceRules as $oneReplaceRule ) {
            // find, replace, is_regexp
            if( $oneReplaceRule['is_regexp'] ) {
                $content = preg_replace( $oneReplaceRule['find'], $oneReplaceRule['replace'], $content );
            } else {
                $content = str_replace( $oneReplaceRule['find'], $oneReplaceRule['replace'], $content );
            }
        }

        return $content;
    }

    private function _addLineToData( $name, $line ) {
        $currentValue = $this->_getData( $name );

        if( $currentValue == null ) {
            $currentValue = '';
        }

        $currentValue .= $line;

        $this->_setData( $name, $currentValue );
    }

    private function _setData( $name, $value ) {
        $this->_data[ $name ] = $value;
    }

    private function _getData( $name ) {
        if( isset( $this->_data[ $name ] ) ) {
            return $this->_data[ $name ];
        } else {
            return null;
        }
    }

    /**
     * @return ffWPLayer
     */
    private function _getWPLayer()
    {
        return $this->_WPLayer;
    }

    /**
     * @param ffWPLayer $WPLayer
     */
    private function _setWPLayer($WPLayer)
    {
        $this->_WPLayer = $WPLayer;
    }

}