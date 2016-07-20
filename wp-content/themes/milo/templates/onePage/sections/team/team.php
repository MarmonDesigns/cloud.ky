
<div class="row">
    <?php
    $persons = $query->get('persons');
    foreach ($query->get('persons') as $person)
    {
        $image = $person->getImage('image');
        $imageUrlResized = fImg::resize($image->url, 360, 425, true);
        $position = $person->get('position');

        $boostrapClass = ff_load_section_printer('bootstrap-columns', $person->get('bootstrap-columns') );
        ?>
    <div class="<?php echo esc_attr( $boostrapClass ); ?>">

        <div class="about-me wow fadeInLeft">

            <div class="about-me-thumbnail">

                <img src="<?php echo esc_url( $imageUrlResized ); ?>" alt="">

                <div class="social-media">
                    <?php
                    $socialLinks = $person->get('social');
                    $linksTranslated = ffContainer::getInstance()->getThemeFrameworkFactory()->getSocialFeedCreator()->getFeedFromLinks($socialLinks);

                    if( !empty( $linksTranslated ) ) {
                        foreach( $linksTranslated as $oneLink ) {
                            ?>
                            <a class="facebook" href="<?php echo esc_url( $oneLink->link ); ?>">
                                <i class="fa fa-<?php echo esc_attr( $oneLink->type ); ?>"></i>
                            </a>
                        <?php
                        }
                    }
                    ?>

                </div><!-- social-media -->

            </div><!-- about-me-thumbnail -->

            <div class="about-me-details">

                <h4><?php $person->printText('name'); ?></h4>
                <h5><?php $person->printText('position'); ?></h5>

            </div><!-- about-me-details -->

        </div><!-- about-me -->

    </div><!-- col -->
   <?php
   }
   ?>
</div><!-- row -->
