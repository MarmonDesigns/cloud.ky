<div class="row footer-top">
    <div class="col-sm-12">

        <div class="widget widget-social">

            <div class="social-media">

                <?php
                    $socialLinks = $query->get('social-links');
                    $linksTranslated = ffContainer::getInstance()->getThemeFrameworkFactory()->getSocialFeedCreator()
                        ->getFeedFromLinks($socialLinks);

                    if (!empty($linksTranslated)) {
                        foreach ($linksTranslated as $oneLink) {
                            ?>

                            <a class="<?php echo esc_attr( $oneLink->type ); ?>"
                               href="<?php echo esc_url( $oneLink->link ); ?>">
                                <i class="fa fa-<?php echo esc_attr( $oneLink->type ); ?>"></i>
                            </a>
                        <?php
                        }
                    }
                ?>
            </div><!-- social-media -->

        </div><!-- widget-social -->

    </div><!-- col -->
</div><!-- row -->
