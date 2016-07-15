<?php

$query = $query->get('button');


$title = trim( $query->get('title') );
if( empty($title) and ! $query->get('use-icon') ){
	return;
}

echo "\n";
echo '<a href="';
$query->printText('url');
echo '"';

if( '_blank' == $query->get('target') ){
	echo ' target="_blank"';
}

echo ' class="btn btn-default"';

echo '>';

$query->printText('title');

if( $query->get('use-icon') ){
	echo '<i class="'.esc_attr( $query->getIcon('icon') ).'"></i> ';
}

echo '</a>';
echo "\n";