<?php
    global $bpxl_goblog_options;

    // If Redux Framewoek is installed and activated
    if ( class_exists( 'ReduxFramework' ) ) {
        $bpxl_footer_text = $bpxl_goblog_options['bpxl_footer_text'];
        $bpxl_scroll_btn = $bpxl_goblog_options['bpxl_scroll_btn'];
    } else {
        $bpxl_footer_text = '&copy; Copyright 2017. Theme by <a href="http://themeforest.net/user/BloomPixel/portfolio?ref=bloompixel">BloomPixel</a>.';
        $bpxl_scroll_btn = '1';
    }
?>
		</div><!--#page-->
	</div><!--.main-wrapper-->
	<footer id="site-footer" class="footer site-footer clearfix" itemscope itemtype="http://schema.org/WPFooter">
		<div class="container">
			<div class="footer-widgets">
				<div class="footer-widget footer-widget-1">
					<?php dynamic_sidebar('footer-1'); ?>
				</div>
				<div class="footer-widget footer-widget-2">
					<?php dynamic_sidebar('footer-2'); ?>
				</div>
				<div class="footer-widget footer-widget-3">
					<?php dynamic_sidebar('footer-3'); ?>
				</div>
				<div class="footer-widget footer-widget-4 last">
					<?php dynamic_sidebar('footer-4'); ?>
				</div>
			</div><!-- .footer-widgets -->
		</div><!-- .container -->
	</footer>
	<div class="copyright">
		<div class="copyright-inner">
			<?php if ( $bpxl_footer_text != '' ) { ?><div class="copyright-text"><?php echo wp_kses_post( $bpxl_footer_text ); ?></div><?php } ?>
		</div>
	</div><!-- .copyright -->
    <div class="site-overlay"></div>
    </div><!-- .menu-pusher -->
</div><!-- .main-container -->
<?php if ( $bpxl_scroll_btn == '1' ) { ?>
	<div class="back-to-top"><i class="fa fa-arrow-up"></i></div>
<?php } ?>
</div>
<?php wp_footer(); ?>
</body>
</html>