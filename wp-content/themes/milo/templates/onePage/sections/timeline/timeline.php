

    <div class="row">
        <div class="col-sm-12">

            <div class="timeline">
                <?php
                foreach ($query->get('timeline-items') as $timelineItem)
                {
                    ?>
                    <div class="timeline-item wow fadeInDown">

                        <h4><?php $timelineItem->printText('date'); ?></h4>
                        <h2><a href="<?php $timelineItem->printText('link'); ?>"><?php $timelineItem->printText('title'); ?></a></h2>

                        <h4>
                            <?php
                            foreach ($timelineItem->get('date-items') as $dateItem)
                            {
                                $dateItem->printText('title');
                            ?>
                            <br>
                            <?php
                            }
                            ?>

                        </h4>

                    </div><!-- timeline-item -->
                <?php
                }
                ?>
            </div><!-- timeline -->
        </div><!-- col -->
    </div><!-- row -->
