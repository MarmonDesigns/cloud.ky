
<div class="row">

    <?php
        $cnt = 0;
        foreach ($query->get('numbered-services') as $service){
        $cnt++;

            $bootstrapClass = ff_load_section_printer('bootstrap-columns', $service->get('bootstrap-columns'));
            $animationClass = ff_load_section_printer('animation', $service );
        ?>
    <div class="<?php echo esc_attr( $bootstrapClass ); ?>">

        <div class="services-boxes style-4 wow <?php echo esc_attr( $animationClass ); ?>">

            <h1><?php echo absint( $cnt ) ; ?>.</h1>

            <h3>
                <?php
                    if( $service->get('url') ){
                        echo '<a href="';
                        $service->printText('url');
                        echo '"';

                        if( '_blank' == $service->get('target') ){
                            echo ' target="_blank"';
                        }

                        echo '>';
                    }
                    $service->printText('title');
                    if( $service->get('url') ){
                        echo '</a>';
                    }
                ?>
                <small><?php $service->printText('subtitle'); ?></small>
            </h3>

            <br class="clearfix">

            <div class="services-boxes-content">

                <p><?php $service->printText('description'); ?></p>

            </div><!-- services-boxes-content -->

        </div><!-- services-boxes -->

    </div><!-- col -->
    <?php
    }
    ?>
</div><!-- row -->
