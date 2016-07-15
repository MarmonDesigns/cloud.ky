<?php

class ffComponent_ContactUsWidget_Printer extends ffBasicObject {
	public function printComponent( $args, ffOptionsQuery $query) {
//        echo'bbb';
//        return;
//		var_dump( $args );

        echo  $args['before_widget'];

            echo  $args['before_title'];
                echo ff_wp_kses( $query->get('contact-us title') );
            echo  $args['after_title'];


            echo '<ul>';

                foreach( $query->get('contact-us description-boxes') as $oneBox ) {
                    echo '<li>';

                        foreach( $oneBox->get('lines') as $oneLine ) {
                            $type = $oneLine->getVariationType();

                            if( $type == 'one-line' ) {
                                echo ff_wp_kses( $oneLine->get('text') ) . '<br>';
                            } else if ( $type == 'one-heading' ) {
                                echo '<span>' . ff_wp_kses( $oneLine->get('text') ) . '</span>';
                            } else if ( $type == 'one-email' ) {
                                echo '<a href="mailto:'.esc_attr($oneLine->get('text')).'">'.ff_wp_kses($oneLine->get('text')).'</a><br>';
                            }
                        }

                    echo '</li>';
                }

            echo '</ul>';

        echo  $args['after_widget'];
	}
}