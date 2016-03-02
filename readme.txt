=== WP Responsive Testimonial Slider ===
Contributors: omikant, wptutorialspoint
Donate Link: http://wptutorialspoint.com/
Tags: Testimonial Slider, Testimonials, Testimonials jQuery, Rotating Testimonial Plugin 
Requires at least: 3.0.1
Tested up to: 4.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


== Description ==

WP Responsive Testimonial Slider Plugin is for Add Testimonials with this Shortcode '[testimonials]'.For More info please check this Link http://www.wptutorialspoint.com/ .


= Shortcode Options =
As of version 1.0, Please use '[testimonials]' or `<?php echo do_shortcode('[testimonials]'); ?>` shortcodes.For More info please check this Link http://www.wptutorialspoint.com/ .

= Credits =

This plugin was written by WP Tutorials Point WordPress Team.

== Installation ==

= The easy way: =

1. Go to the Plugins Menu in WordPress
1. Search for "WP Responsive Testimonial Slider"
1. Click 'Install'
1. Activate the plugin

= Manual Installation =

1. Download the plugin file from this page and unzip the contents
1. Upload the `wp-responsive-testimonial-slider` folder to the `/wp-content/plugins/` directory
1. Activate the `wp-responsive-testimonial-slider` plugin through the 'Plugins' menu in WordPress

= Once Activated =

1. Place the `[testimonials]` shortcode in a Page or Post
1. Create new items in the `testimonials` post type, uploading a Featured Image for each.
	1. *Optional:* You can hyperlink each image by entering the desired url `Image Link URL` admin metabox when adding a new slider image.


== Frequently Asked Questions ==

= The Slider Shortcode =

Place the `[testimonials]` shortcode in a Page or Post

= Can I insert the carousel into a WordPress template instead of a page? =

Absolutely - you just need to use the [do_shortcode](http://codex.wordpress.org/Function_Reference/do_shortcode) WordPress function. For example:
`<?php echo do_shortcode('[testimonials]'); ?>`


== Screenshots ==

1. Admin list interface showing Slider images and titles.
2. Example output.(see documentation).

== Changelog ==

= 1.0 =
* Added shortcode attribute functionality for tweaking of slider options.


