<?php
    $leftBox = $query->get('box-left');
    $rightBox = $query->get('box-right');

    $leftAnimation = ff_load_section_printer('animation', $leftBox );
    $rightAnimation = ff_load_section_printer('animation', $rightBox );

    $leftIcon = $leftBox->getIcon('icon');
    $rightIcon = $rightBox->getIcon('icon');
?>

<div class="row">
    <div class="col-sm-6">

        <div class="services-boxes style-3 icon-right wow <?php echo esc_attr( $leftAnimation ); ?>">

            <i class="<?php echo esc_attr( $leftIcon ); ?>"></i>

            <div class="services-boxes-content">

                <h3><a href="<?php echo esc_url( $leftBox->get('url') ); ?>"><?php $leftBox->printText('title');?></a></h3>

                <p><?php $leftBox->printText('description');?></p>

            </div><!-- services-boxes-content -->

        </div><!-- services-boxes -->

    </div><!-- col -->
    <div class="col-sm-6">

        <div class="services-boxes style-3 icon-left wow <?php echo esc_attr( $rightAnimation ); ?>">

            <i class="<?php echo esc_attr( $rightIcon ); ?>"></i>

            <div class="services-boxes-content">

                <h3><a href="<?php echo esc_attr( $rightBox->get('url') ); ?>"><?php $rightBox->printText('title');?></a></h3>

                <p><?php $rightBox->printText('description');?></p>

            </div><!-- services-boxes-content -->

        </div><!-- services-boxes -->

    </div><!-- col -->
</div><!-- row -->
