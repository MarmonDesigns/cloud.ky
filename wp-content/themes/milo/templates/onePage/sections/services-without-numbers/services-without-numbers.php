    <div class="row">
    <?php
        foreach ($query->get('numbered-services') as $service){


        $bootstrapClasses =  ff_load_section_printer(
            'bootstrap-columns',
            $service->get('bootstrap-columns')
        );
    ?>
        <div class="<?php echo esc_attr( $bootstrapClasses ); ?>">

            <div class="services-boxes style-2 wow fadeInDown">

                <div class="services-boxes-content">

                    <h3>
                        <a href="<?php echo esc_url( $service->get('link') ); ?>"><?php $service->printText('title'); ?></a>
                        <small><?php $service->printText('subtitle'); ?></small>
                    </h3>

                    <p><?php $service->printText('description'); ?></p>

                </div><!-- services-boxes-content -->

            </div><!-- services-boxes -->

        </div><!-- col -->
    <?php
        }
    ?>
    </div><!-- row -->
