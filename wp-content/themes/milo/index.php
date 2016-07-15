<?php
/**
 * Hi there!
 *
 * This index.php contains only printing of the layouts. As you can read in the documentation, our site is builded
 * by layouts mainly. So here are printed all the layouts from WP Admin -> Layouts, which are set as a content,
 * which pass through the conditional logic.
 *
 * Typically here could be printed:
 * - blog section at a blog pages
 * - single post section, at single posts
 * - portfolio category section, at portfolio categories
 *
 * All what is printed, depends only at you
 */

get_header();

ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutPrinter()->printLayoutContent();

get_footer();
