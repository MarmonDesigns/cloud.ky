
<div class="row">
	<div class="col-sm-12">

		<div class="headline style-2">

			<i class="miu-icon-other_conversation_review_comment_bubble_talk_outline_stroke"></i>
			<h2><?php $query->printText('title'); ?></h2>

		</div><!-- headline -->

		<div class="testimonial-slider<?php if( 'dots' == $query->get('type') ) echo "-2"; ?>">
			<ul>
				<?php
				foreach ($query->get('testimonials') as $testimonial){
					$photo = $testimonial->getImage('photo');
					$imageUrlResized = fImg::resize($photo->url, 64, 64, true);
				?>
				<li>
					<div class="testimonial">

						<blockquote>
							<p><?php $testimonial->printText('text'); ?></p>
						</blockquote>

						<h5><?php $testimonial->printText('author'); ?></h5>

					</div><!-- testimonial -->
				</li>
				<?php
				}
				?>
			</ul>

            <div class="thumb-pager">
                <?php

                $numberOfSlides = $query->get('testimonials')->getNumberOfElements();

                foreach ($query->get('testimonials') as $key => $testimonial){
                    $photo = $testimonial->getImage('photo');
                    $imageUrlResized = fImg::resize($photo->url, 64, 64, true);


                    echo '<a data-slide-index="'.esc_attr( $key ).'" href="">';

                        if( $query->get('type') != 'dots' && $numberOfSlides > 1) {
                            $slideCssClass = '';
                            if( $query->get('type') == 'img-circle' ) {
                                $slideCssClass = 'class="img-circle"';
                            }



                            echo '<img src="'.esc_url( $imageUrlResized ).'" alt="" '.  $slideCssClass.'>';


                        }


                    echo '</a>';


                    ?>

                    
                <?php
                }
                ?>
            </div><!-- thumb-pager -->
            <?php if( ( '' == $query->get('type') ) || ( 'img-circle' == $query->get('type') ) ) { ?>

			<?php } ?>

		</div><!-- testimonial-slider -->

	</div><!-- col -->
</div><!-- row -->
