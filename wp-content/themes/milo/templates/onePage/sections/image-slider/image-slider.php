
    <div class="row">
        <div class="col-sm-12">

            <div class="images-slider-2">
                <ul>
                    <?php
                        $images = $query->get('images');

                        $width = $query->get('image-dimensions width');
                        $height = $query->get('image-dimensions height');
                        foreach ($query->get('images') as $image)
                        {
                        $image = $image->getImage('image');
                        $imageUrlResized = fImg::resize($image->url, $width, $height, true);
                            ?>
                                <li><img src="<?php echo esc_url( $imageUrlResized ); ?>" alt=""></li>
                            <?php
                        }
                    ?>
                </ul>
            </div><!-- images-slider -->

        </div><!-- col -->
    </div><!-- row -->
