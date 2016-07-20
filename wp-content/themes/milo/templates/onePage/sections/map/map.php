<?php
    $scriptEnqueuer = ffContainer()->getScriptEnqueuer();
    $scriptEnqueuer->addScript('ff-google-maps-extern','http://maps.google.com/maps/api/js?sensor=false', null, null, true);
    $scriptEnqueuer->addScriptTheme('ff-google-maps','/assets/js/googlemaps/jquery.gmap.min.js', null, null, true);

    $address = $query->get('address');
    $description = $query->get('description');

    $addressEscaped = htmlspecialchars( $address );
    $descriptionEscaped = htmlspecialchars( $description );

    $zoom = $query->get('zoom');
?>

<div class="map" data-zoom="<?php echo esc_attr( $zoom );
?>" data-address="<?php echo esc_attr( $addressEscaped );
?>" data-description="<?php echo esc_attr( $descriptionEscaped );
?>"></div>