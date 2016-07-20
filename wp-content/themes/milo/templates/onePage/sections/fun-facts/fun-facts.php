<?php


        $notSelectedPartColor = $query->get('not-selected-part-color');

        $selectedPartColor = '';

        if( $query->get('use-this-color-instead-accent') ) {
            $selectedPartColor = $query->get('selected-part-color');
        } else {
            $selectedPartColor = ff_theme_accent_color_hex();
        }
?>


        <?php
            if( $query->get('show-heading') ){
                ff_load_section_printer('heading-wrapped', $query);
            }
        ?>

    <div class="row">
        <?php
            foreach ($query->get('facts') as $fact) {
                $bootstrapClass = ff_load_section_printer('bootstrap-columns', $fact->get('bootstrap-columns'));
        ?>
            <div class="<?php echo esc_attr( $bootstrapClass ); ?>">

                <div class="pie-chart" data-percent="<?php $fact->printText('percentage'); ?>" data-size="225" data-line-width="4" data-track-color="<?php echo esc_attr( $notSelectedPartColor ); ?>" data-bar-color="<?php echo esc_attr( $selectedPartColor ); ?>">

                    <div class="pie-chart-details">
                        <h1>
                            <span class="value"></span>%
                            <small><?php $fact->printText('title'); ?></small>
                        </h1>

                    </div><!-- pie-chart-details -->

                </div><!-- pie-chart -->

            </div><!-- col -->
        <?php
        }
        ?>
    </div><!-- row -->
