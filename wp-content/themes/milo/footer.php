<?php
/**
 * Hi there!
 *
 * As opposite of other themes (where you usually find here footer code and other), in this theme, you'll
 * find only code for printing layouts of placement "Footer" and "After Content". These layouts could be
 * created in WP Admin -> Layouts.
 *
 * Typically here will be printed (but it depends at you of course)
 * - Footer with social icons
 * - footer with widgets
 * - bottom footer with message
 */
?>
<?php
    ffContainer()->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutPrinter()
        ->printLayoutAfterContent()
        ->printLayoutFooter();
?>
    </div><!-- PAGE-WRAPPER -->

    <?php
        if( ffThemeOptions::getQuery('layout scroll-to-top') ) {
    ?>
        <!-- GO TOP -->
        <a id="go-top"><i class="miu-icon-circle_arrow-up_glyph"></i></a>
    <?php
        }
    ?>

<?php wp_footer(); ?>
</body>
</html>