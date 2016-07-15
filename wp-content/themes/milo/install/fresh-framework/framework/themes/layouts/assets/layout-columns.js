(function($){
    $(document).ready(function(){


    $('.ff-layout-active').click(function(){
        var postId = $(this).find('.ff-layout-active-info').find('.post-id').html();
        var status = true;

        if( $(this).find('.ff-layout-active-button').find('.switch').hasClass('switch--off') ) {
            status = false;
        }

        var changeTo = !status;
        var data = {};
        data[ 'post-id' ] = postId;
        data[ 'active-change-to' ] = changeTo;

        var __this = $(this);

        frslib.ajax.frameworkRequest('ff-layout-ajax', {}, data, function( response ) {
            if( changeTo == true ) {
                __this.find('.ff-layout-active-button').find('.switch').removeClass('switch--off').addClass('switch--on');
                // __this.find('.ff-layout-active-button').find('.switch').html( 'ON' );
            } else {
                __this.find('.ff-layout-active-button').find('.switch').removeClass('switch--on').addClass('switch--off');
                // __this.find('.ff-layout-active-button').find('.switch').html( 'OFF' );
            }


        });
    });
        });
})(jQuery);