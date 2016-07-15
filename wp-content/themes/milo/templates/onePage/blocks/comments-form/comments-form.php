<?php


///////////////////////////////////////////////////////////////////////////////////////////////////
// Add wrappers to comment input fields
///////////////////////////////////////////////////////////////////////////////////////////////////
    $query = ffTemporaryQueryHolder::getQuery('comments-form');

    if( $query->queryExists('comments-form') ) {
        $query = $query->get('comments-form');
    }



    $commentFormPrinter = ffContainer()->getThemeFrameworkFactory()->getCommentsFormPrinter();

if( $commentFormPrinter->commentsOpen() ) {

    $commentFormPrinter->addFieldAuthorLine('<p>');
    $commentFormPrinter->addFieldAuthorLine('<label for="name">' . ff_wp_kses( $query->get('name') ) . ' <span class="required">*</span></label>');
    $commentFormPrinter->addFieldAuthorLine('<input class="ff-field-author" id="name" name="author" type="text" placeholder="'. esc_attr( $query->get('name') ) .'">');
    $commentFormPrinter->addFieldAuthorLine('</p>');

    $commentFormPrinter->addFieldEmailLine('<p>');
    $commentFormPrinter->addFieldEmailLine('<label for="email">' . ff_wp_kses( $query->get('email') ) . ' <span class="required">*</span></label>');
    $commentFormPrinter->addFieldEmailLine('<input class="ff-field-email" id="email" name="email" type="text" placeholder="' . esc_attr( $query->get('email') ) . '">');
    $commentFormPrinter->addFieldEmailLine('</p>');

    $commentFormPrinter->addFieldWebsiteLine('<p>');
    $commentFormPrinter->addFieldWebsiteLine('<label for="url">' . ff_wp_kses( $query->get('website') ) . ' </label>');
    $commentFormPrinter->addFieldWebsiteLine('<input class="ff-field-url" id="url" name="url" type="text" placeholder="' . esc_attr( $query->get('website') ) . '">');
    $commentFormPrinter->addFieldWebsiteLine('</p>');

    $commentFormPrinter->addFieldCommentLine('<p>');
    $commentFormPrinter->addFieldCommentLine('<label for="comment">' . ff_wp_kses( $query->get('comment-form') ) . ' </label>');
    $commentFormPrinter->addFieldCommentLine('<textarea class="ff-field-comment" id="comment" name="comment" rows="8" cols="25" placeholder="' . esc_attr( $query->get('comment-form') ) . '"></textarea>');
    $commentFormPrinter->addFieldCommentLine('</p>');

    $commentFormPrinter->setClassSubmitButton('btn btn-default');

    $commentFormPrinter->addFieldLoggedInLine('<p class="col-1 logged-in-as">');
    $commentFormPrinter->addFieldLoggedInLine($query->get('logged-in'));
    $commentFormPrinter->addFieldLoggedInLine('</p>');


    $commentFormPrinter->setTextHeading($query->get('heading'));
    $commentFormPrinter->setTextSubmit($query->get('submit-button'));



    $commentFormPrinter->addReplaceRule('comment-reply-title', 'comment-reply-title commentform-title');


    $commentFormPrinter->printForm();

}