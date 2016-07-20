

    <div class="row">
        <?php
            foreach ($query->get('tables') as $table)
            {
                $bootstrapClass = ff_load_section_printer('bootstrap-columns', $table->get('bootstrap-columns') );
                $animationClass = ff_load_section_printer('animation', $table );
            ?>
        <div class="<?php echo esc_attr( $bootstrapClass ); ?>">

            <div class="price-plan wow <?php echo esc_attr( $animationClass ); ?>">

                <div class="price-plan-heading">

                    <i class="miu-icon-business_coins_money_stack_salary_outline_stroke"></i>
                    <h3><?php $table->printText('title'); ?></h3>
                    <h1><sup><?php
                        $table->printText('currency');
                    ?></sup><?php
                        $table->printText('price');
                    ?><small><?php
                        $table->printText('time-period');
                    ?></small></h1>

                </div><!-- price-table-heading -->

                <ul>
                    <?php
                    foreach ($table->get('rows') as $row)
                    {
                        ?>
                        <li><?php $row->printText('item');?></li>
                    <?php
                    }
                    ?>
                </ul>

                <?php ff_load_section_printer( 'button', $table); ?>

            </div><!-- price-table -->

        </div><!-- col -->
        <?php
        }
        ?>
    </div><!-- row -->
