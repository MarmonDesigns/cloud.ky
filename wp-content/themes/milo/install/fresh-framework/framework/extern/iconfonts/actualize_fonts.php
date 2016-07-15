<?php





// If you want to actualize from "https://raw.github.com/fontello/", just comment "exit"
// and run this.


exit;







define('ICON_PREFIX', 'ff-font');
define('PRE_REPO_URI', 'https://raw.github.com/fontello/');

echo '<h1>Font Icons parser</h1>';
echo '<h2>Opening REPOS</h2>';

$font_dirs = array(
	'awesome-uni.font',
	'brandico.font',
	'elusive.font',
	'entypo',
	'fontelico.font',
	'iconic-uni.font',
	'linecons.font',
	'maki.font',
	'meteocons.font',
	'mfglabs.font',
	'modernpics.font',
	'typicons.font',
	'weathercons.font',
	'websymbols-uni.font',
	'zocial.font',
);

echo '<h2>Opening config.yml in dir</h2>';

$root_fonts_css = array();

foreach ($font_dirs as $font_dir) {
	$config = file_get_contents( PRE_REPO_URI . $font_dir . '/master/config.yml');
	if( empty( $config ) ){
		echo PRE_REPO_URI . $font_dir . '/master/config.yml';
		die();
	}
	$config = explode("\n", $config);
	$config_new = array();

	$meta_head = '';
	$fontname = $font_dir;
	$fontname = str_replace( '-uni.font-master', '', $fontname );
	$fontname = str_replace( '.font-master', '', $fontname );
	$fontname = str_replace( '.font', '', $fontname );
	$fontname = str_replace( '-uni', '', $fontname );

	$glyphs_ready = false;

	foreach ($config as $index => $line) {
		$line = trim($line);
		if( '#' == substr($line, 0,1)){
			$line = '';
		}
		if( empty($line) ){
			continue;
		}

		if( 'glyphs:' == $line ){
			$glyphs_ready = true;
			continue;
		}

		if( ! $glyphs_ready ){
			$meta_head .= $line . "\n";
			continue;
		}
		$config_new[] = $line;
	}

	echo '<h3>'.$fontname.'</h3>';
	echo '<p>Loaded metas, loaded pre-css ...</p>';
	echo '<p>Clearing ...</p>';

	$config_new = implode("\n", $config_new);
	$config_new = str_replace("-\n", "- ",$config_new);
	$config_new = explode("- ", $config_new);

	$pre_css = array();

	foreach ($config_new as $index => $rule) {
		$rule = trim( $rule );
		if(empty($rule)){
			continue;
		}

		$pre_css_item = array();
		$pre_css_item_tmp = explode("\n", trim( $rule ) );
		foreach($pre_css_item_tmp as $tr){
			$tr = explode(":", $tr);
			$pre_css_item[ trim($tr[0]) ] = trim($tr[1]);
		}
		$pre_css[] = $pre_css_item;
	}

	echo '<p>Creating CSS ...</p>';

	if( ! is_dir( dirname(__FILE__) . '/' . ICON_PREFIX . '-'.$fontname ) ){
		if( @mkdir( dirname(__FILE__) . '/' . ICON_PREFIX . '-'.$fontname ) ){
			echo "<p>Created directory: <code>".dirname(__FILE__) . '/' . ICON_PREFIX . '-'.$fontname."</code></p>";
		}else{
			echo "<p>Unable to create directory: <code>".dirname(__FILE__) . '/' . ICON_PREFIX . '-'.$fontname."</code></p>";
			exit;
		}
	}

	$new_css_file_name = dirname(__FILE__).'/' . ICON_PREFIX . '-'.$fontname.'/' . ICON_PREFIX . '-'.$fontname.'.css';
	$new_css_file = fopen( $new_css_file_name, "wt");
	$root_fonts_css[] = './' . ICON_PREFIX . '-'.$fontname.'/' . ICON_PREFIX . '-'.$fontname.'.css';

	if( empty( $new_css_file ) ){
		echo "catto open file";
		exit;
	}

	fputs( $new_css_file, "/**************************************\n" );
	fputs( $new_css_file, $meta_head."\n" );
	fputs( $new_css_file, "**************************************/\n" );
	fputs( $new_css_file, "

@font-face {
	font-family: '".ICON_PREFIX."-$fontname';
	src: url('./".ICON_PREFIX."-$fontname.eot?v=4.0.3');
	src: url('./".ICON_PREFIX."-$fontname.eot?#iefix&v=4.0.3') format('embedded-opentype'), url('./".ICON_PREFIX."-$fontname.woff?v=4.0.3') format('woff'), url('./".ICON_PREFIX."-$fontname.ttf?v=4.0.3') format('truetype'), url('./".ICON_PREFIX."-$fontname.svg?v=4.0.3') format('svg');
	font-weight: normal;
	font-style: normal;
}

.".ICON_PREFIX."-$fontname {
	display: inline-block;
	font-family: '".ICON_PREFIX."-$fontname';
	font-style: normal;
	font-weight: normal;
	line-height: 1;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}

");


	echo "<hr />";
	echo "<h4>Coping files</h4>";
	$_fontname_tmp = $fontname;
	if( 'awesome' == $_fontname_tmp ){
		$_fontname_tmp = 'fontawesome';
	}
	foreach ( array('eot', 'svg', 'ttf', 'woff') as $ext) {
		$src = PRE_REPO_URI . $font_dir . '/master/font/'.$_fontname_tmp.'.'.$ext;
		$dst = dirname(__FILE__).'/' . ICON_PREFIX . '-'.$fontname.'/'.ICON_PREFIX.'-'.$fontname.'.'.$ext;
		echo "SRC: $src<br />DST: $dst<br />";
		copy( $src, $dst );
	}

	echo "<hr />";

	$css = array();
	foreach ($pre_css as $rule) {
		//echo "<hr><pre>"; print_r($rule); echo "</pre>";
		if( empty( $rule['css'] ) ) continue;
		if( empty( $rule['code'] ) ) continue;

		$rule_css = str_replace('"', '', $rule['css']);
		$rule_code = str_replace("0x", "\\", $rule['code']);
		$rule_search = '';
		if( ! empty( $rule['search'] ) ){
			$rule_search = " /* " . str_replace(array(",","[","]"), " ", $rule['search']) . " */ ";
		}
		$rule_search = str_replace('  ', ' ', $rule_search);
		$rule_search = str_replace('  ', ' ', $rule_search);
		$rule_search = str_replace('  ', ' ', $rule_search);

		$css_line = ".".ICON_PREFIX."-".$fontname.".icon-".$rule_css.":before { content: '".$rule_code."'; }".$rule_search;

		fputs( $new_css_file, $css_line."\n" );
		echo $css_line;
		echo "<br />\n";
	}
}

$_file_for_all_css = fopen( dirname(__FILE__).'/fonts.css', "wt");
foreach ($root_fonts_css as $css_file) {
	//@import url('fontello-fa/font-awesome.css');
	fputs( $_file_for_all_css, "@import url('$css_file');\n" );
}
