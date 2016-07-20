<?php

    $imageQuery = $query->get('image');
    $imageAnimationClass = ff_load_section_printer('animation', $imageQuery );
    $imagePosition = $imageQuery->get('position');

    $imageHtml = '';
    $imageHtml .= '<div class="col-sm-6">';
        $imageHtml .= '<p class="text-center wow '.esc_attr( $imageAnimationClass ).'">';

            $imageHtml .= '<img src="'.esc_url( $imageQuery->getImage('image')->url ).'" alt="">';

        $imageHtml .= '</p>';
    $imageHtml .= '</div>';

?>


<div class="row">

    <?php if( $imagePosition == 'left' ) { echo  $imageHtml; } ?>

    <div class="col-sm-6">

        <div class="headline style-1">

            <?php ff_load_section_printer('heading-content', $query ); ?>

        </div><!-- headline -->
        <?php
            foreach( $query->get('content') as $oneParagraph ) {
                echo '<p>';
                    $oneParagraph->printText( 'text' );
                echo '</p>';
            }

        ?>

        <?php
            ff_load_section_printer('button', $query);
        ?>


    </div><!-- col -->

    <?php if( $imagePosition == 'right' ) { echo  $imageHtml; } ?>

</div><!-- row -->
