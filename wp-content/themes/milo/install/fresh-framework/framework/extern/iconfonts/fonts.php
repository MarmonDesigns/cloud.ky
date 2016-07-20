<?php

//	<div class="option"><?php echo $fonticon; ? ></div>

$all_fonts = array();

$d = dir( dirname(__FILE__) );
while (false !== ($entry = $d->read())) {
	if( !is_dir($d->path . '/' . $entry ) ){
		continue;
	}
	if( '.' == substr($entry, 0,1) ){
		continue;
	}
	$all_fonts[ "$entry" ] = dirname(__FILE__).'/'.$entry.'/'.$entry.'.css';
}
$d->close();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//     Not dangerous, but also not clean :(
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// $uploaded_font_directory = dirname(__FILE__);
// for($i=0;$i<10;$i++){
// 	$uploaded_font_directory = dirname($uploaded_font_directory);
// 	if( FALSE === strpos($uploaded_font_directory, 'wp-content') ){
// 		break;
// 	}
// }
// $uploaded_font_directory = $uploaded_font_directory . '/wp-content/fonts';

// if( is_dir($uploaded_font_directory) ){
// 	$d = dir( $uploaded_font_directory );
// 	while (false !== ($entry = $d->read())) {
// 		if( !is_dir($d->path . '/' . $entry ) ){
// 			continue;
// 		}
// 		if( '.' == substr($entry, 0,1) ){
// 			continue;
// 		}
// 		$all_fonts[ "$entry" ] = $uploaded_font_directory.'/'.$entry.'/'.$entry.'.css';
// 	}
// 	$d->close();
// }

//     END: Not dangerous, but also not clean :(
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

ksort( $all_fonts );

foreach ($all_fonts as $font => $font_file_path) {
	$font_file = file( $font_file_path );

	$font_title = str_replace('ff-font-', '', $font);
	//<div class="placeholder"><div class="ff-modal-group-title fixedheader"><input type="checkbox">awesome</div></div></div>
	echo '<div class="placeholder placeholder-font-'.$font_title.'" data-font-class="placeholder-font-'.$font_title.'">';
	echo '<div class="ff-modal-group-title fixedheader_container">';
	echo '<div class="fixedheader_wrapper">';
	echo '<div class="fixedheader">';
	echo '<label>';
	//echo '<input type="checkbox">';
	echo $font_title;

	/*
	echo '<span class="edit">';
	echo '<a href="';
	echo '#link-to-edit-font-tags-and-stuff';
	echo '">edit font settings</a>';
	echo '</span>';
	*/

	echo '<span class="icon-group-count">';
		echo '<span class="icon-group-count-filtered">???</span>';
		echo '<span class="icon-group-count-slash">/</span>';
		echo '<span class="icon-group-count-total">???</span>';
	echo '</span>';

	echo '</label>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '<ul class="ui-sortable ui-sortable-disabled clearfix">';
	foreach ($font_file as $line) {
		$line = str_replace("content:'", "content: '", $line);
		if( FALSE === strpos($line, ':before') ){
			continue;
		}

		if( FALSE === strpos($line, "content: '\\") ){
			continue;
		}

		echo '
		<li class="attachment save-ready">
		';

		$tags = explode('/*', $line);
		if( empty($tags[1]) ){
			$tags = explode(':before', $line);
			$tags = $tags[0];
			$tags = str_replace($font, '', $tags);
		}else{
			$tags = $tags[1];
			$tags = str_replace("*/", '', $tags);
		}
		$tags = str_replace('.ff-', '', $tags);
		$tags = str_replace('.icon-', '', $tags);
		$tags = str_replace('-', ' ', $tags);
		$tags = str_replace('.', ' ', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = str_replace('  ', ' ', $tags);
		$tags = trim($tags) . ' ' . str_replace('ff-font-', '', $font);

		$content = explode("content: '\\", $line);
		if( empty($content[1]) ){
			$content = "????";
		}else{
			$content = explode("'", $content[1]);
			$content = $content[0];
		}

		echo "<div class='font' data-family='".$font."' data-tags='".$tags."' data-content='".$content."'>";
		$ico = explode(':before', $line);
		$ico = $ico[0];
		$ico = trim(str_replace('.', ' ', $ico));
		echo "<i class='".$ico."'></i>";
		echo '</div>';
		echo "<div class='info'>";
		echo $ico . ' ' . $tags;
		//echo $line."<br />";
		echo "</div>";
		echo '</li>';
	}
	echo '</ul>';
}
