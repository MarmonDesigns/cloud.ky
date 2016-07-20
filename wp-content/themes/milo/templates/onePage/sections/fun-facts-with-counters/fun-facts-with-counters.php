
<div class="row">
    <?php
        foreach ($query->get('facts') as $fact) {
            $bootstrapClass = ff_load_section_printer('bootstrap-columns', $fact->get('bootstrap-columns'));
            $iconClass = $fact->getIcon('icon');
            ?>
            <div class="<?php echo esc_attr( $bootstrapClass ); ?>">

                <div class="counter">

                    <i class="<?php echo esc_attr( $iconClass ); ?>"></i>

                    <div class="counter-value" data-value="<?php $fact->printText('quantity'); ?>"></div>

                    <div class="counter-details">
                        <p><?php $fact->printText('title'); ?></p>
                    </div>
                    <!-- counter-details -->

                </div>
                <!-- counter -->

            </div><!-- col -->
        <?php
        }
    ?>
</div><!-- row -->
