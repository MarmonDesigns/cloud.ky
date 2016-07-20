
    <div class="row">
        <div class="col-sm-12">

            <div class="info-slider">
                <ul>
                    <?php
                    foreach ($query->get('items') as $item){
                        $image = $item->getImage('picture');
                        $imageUrlResized = fImg::resize($image->url, 560, 325, true);
                    ?>
                    <li>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="headline style-1">
                                    <h4><?php $item->printText('over-title'); ?></h4>
                                    <h2><?php $item->printText('title'); ?></h2>
                                </div><!-- headline -->

                                <p><?php $item->printText('description'); ?></p>

                            </div><!-- col -->
                            <div class="col-sm-6">

                                <img src="<?php echo esc_url( $imageUrlResized ); ?>" alt="">

                            </div><!-- col -->
                        </div><!-- row -->
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </div><!-- info-slider -->

        </div><!-- col -->
    </div><!-- row -->
