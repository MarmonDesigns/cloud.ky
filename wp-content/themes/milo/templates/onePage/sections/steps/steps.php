<?php
    $steps = $query->get('steps');

    $numberOfSteps = $steps->getNumberOfElements();

?>

<div class="row">
    <div class="col-sm-12">

        <div class="process-steps process-<?php echo esc_attr( $numberOfSteps ); ?>-steps clearfix">

            <?php
            foreach ($query->get('steps') as $step) {
            ?>
            <div class="step">

                <i class="<?php echo esc_attr( $step->getIcon('icon') ); ?>"></i>

                <div class="step-details">
                    <h5><?php $step->printText('description')?></h5>
                </div><!-- step-details -->

            </div><!-- step -->
            <?php
            }
            ?>
        </div><!-- porcess-steps -->

    </div><!-- col -->
</div><!-- row -->
