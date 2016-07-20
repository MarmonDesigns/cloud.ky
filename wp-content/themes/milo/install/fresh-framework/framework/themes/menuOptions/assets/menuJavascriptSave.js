(function($){

    $(document).ready(function(){

        if( !wpNavMenu ) {
            return false;
        }

        var backupeventOnClickMenuSave = wpNavMenu.eventOnClickMenuSave;

        wpNavMenu.eventOnClickMenuSave = function() {
            backupeventOnClickMenuSave();

            var ourInputName = 'ff-navigation-menu-serialized';
            var $form = $('#update-nav-menu');
            var serializedForm = ( $form.serialize() );

            $form.find('input, checkbox, radio, textarea').attr('name', '');
            $form.append('<input type="hidden" class="'+ourInputName+'" name="'+ourInputName+'">');
            $('.'+ourInputName).val( serializedForm );

            $form.submit();

        }
    });

})(jQuery);