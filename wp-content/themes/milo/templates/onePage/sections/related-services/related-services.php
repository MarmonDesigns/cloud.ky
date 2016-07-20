
<div class="row">
    <?php
        foreach ($query->get('services') as $service){

            $serviceClass = ff_load_section_printer( 'bootstrap-columns', $service->get('bootstrap-columns') );
    ?>
    <div class="<?php echo esc_attr( $serviceClass ); ?>">

        <div class="services-boxes style-2 wow fadeInDown">

            <div class="services-boxes-content">

                <h3>
                    <a href="<?php $service->printText('link') ?>"><?php $service->printText('title'); ?></a>
                    <?php if ($service->get('subtitle') == ''){ ?>
                        <small><?php $service->printText('subtitle'); ?></small>
                    <?php } ?>
                </h3>

                <?php if ($service->get('description') == ''){ ?>
                    <p><?php $service->printText('description'); ?></p>
                <?php } ?>

            </div><!-- services-boxes-content -->

        </div><!-- services-boxes -->

    </div><!-- col -->
    <?php
        }
    ?>
</div><!-- row -->
