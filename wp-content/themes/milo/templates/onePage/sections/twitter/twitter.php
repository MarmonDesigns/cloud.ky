<?php

    $twitterFeeder = ffContainer::getInstance()->getLibManager()->createTwitterFeeder();
    ffContainer::getInstance()->getClassLoader()->loadClass('ffOptionsHolder_Twitter');

    $tweetsCollection = ($twitterFeeder->getTwitterFeed( $query->get('fw_twitter')  ));

?>


            <div class="row">
                <div class="col-sm-11">

                    <div class="widget widget_twitter">
                            <div id="tweet">
                                <ul>
                                    <?php
                                        foreach( $tweetsCollection as $oneTweet ) {
                                            echo '<li><p class="tweet">';

                                                echo  $oneTweet->textWithLinks;

                                            echo '</p></li>';
                                        }
                                    ?>
                                </ul>
                            </div>

                    </div><!-- end .widget-twitter-->

                </div><!-- col -->
                <div class="col-sm-1">

                    <div id="twitter-slider-controls">
                        <span id="twitter-slider-prev"><a class="bx-prev" href=""></a></span>
                        <span id="twitter-slider-next"><a class="bx-next" href=""></a></span>
                    </div>

                </div><!-- col -->
            </div><!-- row -->
