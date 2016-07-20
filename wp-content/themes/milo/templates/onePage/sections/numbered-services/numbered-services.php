<div class="row">
<?php
    $cnt = 0;
    foreach ($query->get('numbered-services') as $service){
        $cnt++;

        $bootstrapClasses =  ff_load_section_printer(
            'bootstrap-columns',
            $service->get('bootstrap-columns')
        );

    ?>
        <div class="<?php echo esc_attr( $bootstrapClasses ); ?>">
            <div class="services-boxes style-1 wow fadeInDown">

                <div class="services-boxes-content">

                    <h5><?php echo '0'.absint($cnt); ?></h5>
                    <h2><a href="<?php echo esc_url( $service->get('link') ); ?>"><?php $service->printText('title'); ?></a></h2>

                    <p><?php $service->printText('description'); ?></p>

                    <a href="<?php echo esc_url( $service->get('link') ); ?>"><?php $service->printText('link-text'); ?> <i class="fa fa-arrow-right"></i></a>

                </div><!-- services-boxes-content -->

            </div><!-- services-boxes -->
        </div>
        <?php
        }
        ?>
</div>
