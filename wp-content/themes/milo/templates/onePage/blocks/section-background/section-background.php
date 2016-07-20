<?php

if( $query->get('show') ){

	$backgrounds = $query->get('backgrounds');

	foreach( $backgrounds as $oneBGLayer ) {

		$variation = $oneBGLayer->getVariationType();
		$opacity = $oneBGLayer->get('opacity');
		if( !empty($opacity) and ('0' !== $opacity ) ){
			$opacity = 'opacity:' . number_format( $opacity, 2 ) . ';';
		}else{
			$opacity = '';
		}

		switch ( $variation ) {
			case 'background-color':
				$color = $oneBGLayer->get('color');
				echo '<div class="section-background-block background-color"';
				echo ' style="background-color:'.esc_attr( $color ).';'.  $opacity.'"';
				echo '></div>';
				break;

			case 'background-image':
				$img = $oneBGLayer->getImage('image')->url;
				echo '<div class="section-background-block background-image';
				if($oneBGLayer->get('fixed')){
					echo ' background-fixed';
				}
				echo '"';
				echo ' style="background-image:url(\''.esc_url( $img ).'\');'.  $opacity.'"';
				echo '></div>';
				break;

			case 'background-pattern':
				$img = $oneBGLayer->getImage('image')->url;
				echo '<div class="section-background-block background-pattern';
				if($oneBGLayer->get('fixed')){
					echo ' background-fixed';
				}
				echo '"';
				echo ' style="background-image:url(\''.esc_url( $img ).'\');'.  $opacity.'"';
				echo '></div>';
				break;

			case 'background-youtube-video':
				$url = $oneBGLayer->get('url');

				// something like static varible - sorry:
				global $__ff_background_youtube_video;
				if( empty( $__ff_background_youtube_video ) ){
					$__ff_background_youtube_video = 0;
				}
				$__ff_background_youtube_video ++;

				echo '<div class="section-background-block background-youtube-video"';
				echo ' style="'.  $opacity.'"';
				echo '>';
				echo '<div class="player" data-property="{';
					echo 'videoURL:\''.esc_attr( $url ).'\'';
					echo ',containment:\'.background-youtube-video\'';
					echo ',autoplay:1';
					echo ',loop:true';
					if( $oneBGLayer->get('show-controls') ){
						echo ',showControls:false';
					}
					echo ',showYTLogo:false';
					echo ',mute:true';
					echo ',startAt:0';
					echo ',opacity:1';
				echo '}">';
				echo '<div class="background-youtube-video-id-'.absint( $__ff_background_youtube_video ).'">';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				break;

			case 'background-url-video':

				echo '<div class="section-background-block background-url-video"';
				echo ' style="'.  $opacity.'"';
				echo '>';

				echo '<video
					id="video_background"
					preload="auto"
					autoplay="true"
					loop="loop"
					muted="muted"
					volume="0"
					>';

				if($oneBGLayer->get('webm') ) {
					echo '<source src="';
					echo esc_url( $oneBGLayer->get('webm') );
					echo '" type="video/webm">';
				}

				if($oneBGLayer->get('mp4') ) {
					echo '<source src="';
					echo esc_url( $oneBGLayer->get('mp4') );
					echo '>" type="video/mp4">';
				}

				if($oneBGLayer->get('ogg') ) {
					echo '<source src="';
					echo esc_url( $oneBGLayer->get('ogg') );
					echo '>" type="video/ogg">';
				}

				echo '</video>';

				echo '</div>';
				break;

			default:
				echo "\n\n\n\n\n\n\n\n\n\n\n\n<!-- UNDEFINED BACKGROUND TYPE: ".  $variation."-->\n\n\n\n\n\n\n\n\n\n\n\n";
				break;
		}
	}
}

