<?php
defined( 'WPINC' ) or die;

if ( ! function_exists( 'generate_construct_footer' ) ) {
	/**
	 * Build our footer.
	 *
	 * @since 1.3.42
	 */
	add_action( 'generate_footer', 'generate_construct_footer' );
	function generate_construct_footer() {
		?>
		<footer class="site-info" itemtype="http://schema.org/WPFooter" itemscope="itemscope">
			<div class="inside-site-info <?php if ( 'full-width' !== generate_get_setting( 'footer_inner_width' ) ) : ?>grid-container grid-parent<?php endif; ?>">
				<?php do_action( 'generate_before_copyright' ); ?>
				<div class="copyright-bar">
					<?php do_action( 'generate_credits' ); ?>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'generate_footer_bar' ) ) {
	add_action( 'generate_before_copyright', 'generate_footer_bar', 15 );
	/**
	 * Build our footer bar
	 * @since 1.3.42
	 */
	function generate_footer_bar() {

		if ( ! is_active_sidebar( 'footer-bar' ) ) {
			return;
		}

		?>
		<div class="footer-bar">
			<?php dynamic_sidebar( 'footer-bar' ); ?>
		</div>
		<?php

	}
}

if ( ! function_exists( 'generate_add_footer_info' ) ) {
	add_action( 'generate_credits', 'generate_add_footer_info' );
	/**
	 * Add the copyright to the footer
	 *
	 * @since 0.1
	 */
	function generate_add_footer_info() {
		$copyright = sprintf( '<span class="copyright">&copy; %1$s</span> &bull; <a href="%2$s" target="_blank" itemprop="url">%3$s</a>',
			date( 'Y' ),
			esc_url( 'https://generatepress.com' ),
			__( 'GeneratePress','generatepress' )
		);

		echo apply_filters( 'generate_copyright', $copyright );
	}
}

if ( ! function_exists( 'generate_construct_footer_widgets' ) ) {
	add_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
	/**
	 * Build our footer widgets.
	 *
	 * @since 1.3.42
	 */
	function generate_construct_footer_widgets() {
		// Get how many widgets to show
		$widgets = generate_get_footer_widgets();

		if ( !empty( $widgets ) && 0 !== $widgets ) :

			// Set up the widget width
			$widget_width = '';
			if ( $widgets == 1 ) $widget_width = '100';
			if ( $widgets == 2 ) $widget_width = '50';
			if ( $widgets == 3 ) $widget_width = '33';
			if ( $widgets == 4 ) $widget_width = '25';
			if ( $widgets == 5 ) $widget_width = '20';
			?>
			<div id="footer-widgets" class="site footer-widgets">
				<div <?php generate_inside_footer_class(); ?>>
					<div class="inside-footer-widgets">
						<?php if ( $widgets >= 1 ) : ?>
							<div class="footer-widget-1 grid-parent grid-<?php echo absint( apply_filters( 'generate_footer_widget_1_width', $widget_width ) ); ?> tablet-grid-<?php echo absint( apply_filters( 'generate_footer_widget_1_tablet_width', '50' ) ); ?> mobile-grid-100">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-1')): ?>
									<aside class="widget inner-padding widget_text">
										<h4 class="widget-title"><?php _e('Footer Widget 1','generatepress');?></h4>
										<div class="textwidget">
											<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into this widget area.','generatepress' ), esc_url( admin_url( 'widgets.php' ) ) ); ?></p>
											<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generatepress' ), esc_url( admin_url( 'customize.php' ) ) ); ?></p>
										</div>
									</aside>
								<?php endif; ?>
							</div>
						<?php endif;

						if ( $widgets >= 2 ) : ?>
						<div class="footer-widget-2 grid-parent grid-<?php echo absint( apply_filters( 'generate_footer_widget_2_width', $widget_width ) ); ?> tablet-grid-<?php echo absint( apply_filters( 'generate_footer_widget_2_tablet_width', '50' ) ); ?> mobile-grid-100">
							<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-2')): ?>
								<aside class="widget inner-padding widget_text">
									<h4 class="widget-title"><?php _e('Footer Widget 2','generatepress');?></h4>
									<div class="textwidget">
										<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into this widget area.','generatepress' ), esc_url( admin_url( 'widgets.php' ) ) ); ?></p>
										<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generatepress' ), esc_url( admin_url( 'customize.php' ) ) ); ?></p>
									</div>
								</aside>
							<?php endif; ?>
						</div>
						<?php endif;

						if ( $widgets >= 3 ) : ?>
						<div class="footer-widget-3 grid-parent grid-<?php echo absint( apply_filters( 'generate_footer_widget_3_width', $widget_width ) ); ?> tablet-grid-<?php echo absint( apply_filters( 'generate_footer_widget_3_tablet_width', '50' ) ); ?> mobile-grid-100">
							<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-3')): ?>
								<aside class="widget inner-padding widget_text">
									<h4 class="widget-title"><?php _e('Footer Widget 3','generatepress');?></h4>
									<div class="textwidget">
										<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into this widget area.','generatepress' ), esc_url( admin_url( 'widgets.php' ) ) ); ?></p>
										<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generatepress' ), esc_url( admin_url( 'customize.php' ) ) ); ?></p>
									</div>
								</aside>
							<?php endif; ?>
						</div>
						<?php endif;

						if ( $widgets >= 4 ) : ?>
						<div class="footer-widget-4 grid-parent grid-<?php echo absint( apply_filters( 'generate_footer_widget_4_width', $widget_width ) ); ?> tablet-grid-<?php echo absint( apply_filters( 'generate_footer_widget_4_tablet_width', '50' ) ); ?> mobile-grid-100">
							<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-4')): ?>
								<aside class="widget inner-padding widget_text">
									<h4 class="widget-title"><?php _e('Footer Widget 4','generatepress');?></h4>
									<div class="textwidget">
										<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into this widget area.','generatepress' ), esc_url( admin_url( 'widgets.php' ) ) ); ?></p>
										<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generatepress' ), esc_url( admin_url( 'customize.php' ) ) ); ?></p>
									</div>
								</aside>
							<?php endif; ?>
						</div>
						<?php endif;

						if ( $widgets >= 5 ) : ?>
						<div class="footer-widget-5 grid-parent grid-<?php echo absint( apply_filters( 'generate_footer_widget_5_width', $widget_width ) ); ?> tablet-grid-<?php echo absint( apply_filters( 'generate_footer_widget_5_tablet_width', '50' ) ); ?> mobile-grid-100">
							<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-5')): ?>
								<aside class="widget inner-padding widget_text">
									<h4 class="widget-title"><?php _e('Footer Widget 5','generatepress');?></h4>
									<div class="textwidget">
										<p><?php printf( __( 'Replace this widget content by going to <a href="%1$s"><strong>Appearance / Widgets</strong></a> and dragging widgets into this widget area.','generatepress' ), esc_url( admin_url( 'widgets.php' ) ) ); ?></p>
										<p><?php printf( __( 'To remove or choose the number of footer widgets, go to <a href="%1$s"><strong>Appearance / Customize / Layout / Footer Widgets</strong></a>.','generatepress' ), esc_url( admin_url( 'customize.php' ) ) ); ?></p>
									</div>
								</aside>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php
		endif;
		do_action( 'generate_after_footer_widgets' );
	}
}

if ( ! function_exists( 'generate_back_to_top' ) ) {
	add_action( 'wp_footer', 'generate_back_to_top' );
	/**
	 * Build the back to top button
	 *
	 * @since 1.3.24
	 */
	function generate_back_to_top() {
		$generate_settings = wp_parse_args(
			get_option( 'generate_settings', array() ),
			generate_get_defaults()
		);

		if ( 'enable' !== $generate_settings[ 'back_to_top' ] ) {
			return;
		}

		echo apply_filters( 'generate_back_to_top_output', sprintf(
			'<a title="%1$s" rel="nofollow" href="#" class="generate-back-to-top" style="opacity:0;visibility:hidden;" data-scroll-speed="%2$s" data-start-scroll="%3$s">
				<i class="fa %4$s" aria-hidden="true"></i>
				<span class="screen-reader-text">%5$s</span>
			</a>',
			esc_attr__( 'Scroll back to top','generatepress' ),
			absint( apply_filters( 'generate_back_to_top_scroll_speed', 400 ) ),
			absint( apply_filters( 'generate_back_to_top_start_scroll', 300 ) ),
			esc_attr( apply_filters( 'generate_back_to_top_icon','fa-angle-up' ) ),
			__( 'Scroll back to top','generatepress' )
		));
	}
}