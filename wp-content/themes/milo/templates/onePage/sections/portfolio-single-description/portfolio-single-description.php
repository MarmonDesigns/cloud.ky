
<div class="row">
    <?php

        foreach( $query->get('boxes') as $oneBox ) {
            $bootstrapClass = ff_load_section_printer('bootstrap-columns', $oneBox->get('bootstrap-columns'));
            $type = $oneBox->getVariationType();


            echo '<div class="'.esc_attr( $bootstrapClass ).'">';

                if( $type == 'detail-box' ) {

                    echo '<ul class="project-details">';

                    foreach( $oneBox->get('details') as $oneDetail ) {
                        echo '<li>';

                            echo '<strong>' . ff_wp_kses( $oneDetail->get('title') ) .'</strong> ';
                            echo '<small>' . ff_wp_kses( $oneDetail->get('content') ) . '</small>';

                        echo '</li>';
                    }

                    echo '</ul>';


                } else if ( $type == 'text-box' ) {

                    if( $oneBox->get('show-title') ) {
                        echo '<h3><strong>' . ff_wp_kses( $oneBox->get('title') ) . '</strong></h3>';
                        echo '<br>';
                    }

                    echo '<p>';
                        echo ff_wp_kses( $oneBox->get('description-text') );
                    echo '</p>';

                }

            echo '</div>';
        }
    ?>
</div>

