<div id="footer">
    <div class="container">
        <div class="row">
            <?php
                for( $i=1; $i <= 4; $i++ ) {
                    $size = $query->get('footer-sidebar-'  .$i);

                    if ($size == 'dont-show' ) {
                        continue;
                    }


                    $class = 'col-sm-'.absint($size);

                    echo '<div class="'.  $class.'">';
                        if( is_active_sidebar('sidebar-footer-'.  $i) ) {
                            dynamic_sidebar('sidebar-footer-'.  $i);
                        }

                    echo '</div>';
                }
            ?>
        </div><!-- row -->
    </div><!-- container -->
</div><!-- footer -->