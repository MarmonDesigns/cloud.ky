(function($){
    $(document).ready(function() {

        var fnTogglePreviewButton = function() {

            var currentPageTemplate = $('#page_template').val();

            if( currentPageTemplate == 'page-onepage.php' ) {
                $('#post-preview').hide();
            } else {
                $('#post-preview').show();
            }

        }

        $('#page_template').change( fnTogglePreviewButton );
        fnTogglePreviewButton();

    });
})(jQuery);