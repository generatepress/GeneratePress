<?php
/**
 * Migrates old options on update.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Process option updates if necessary.
 */
class GeneratePress_Theme_Update {
	/**
	 * Class instance.
	 *
	 * @access private
	 * @var $instance Class instance.
	 */
	private static $instance;

	/**
	 * Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 *  Constructor
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'admin_init', __CLASS__ . '::init', 5 );
		} else {
			add_action( 'wp', __CLASS__ . '::init', 5 );
		}
	}

	/**
	 * Implement theme update logic. Only run updates on existing sites.
	 *
	 * @since 2.5.0
	 */
	public static function init() {
		if ( is_customize_preview() ) {
			return;
		}

		$saved_version = get_option( 'generate_db_version', false );

		if ( false === $saved_version ) {
			// Typically this would mean this is a new install, but we haven't always had the version saved, so we need to check for existing settings.

			$existing_settings = get_option( 'generate_settings', array() );

			// Can't count this as a user-set option since a previous migration script set it.
			if ( isset( $existing_settings['combine_css'] ) ) {
				unset( $existing_settings['combine_css'] );
			}

			if ( ! empty( $existing_settings ) ) {
				// We have settings, which means this is an old install with no version number.
				$saved_version = '1.0';
			} else {
				// No settings and no saved version, must be a new install.

				if ( 'admin_init' === current_action() ) {
					// If we're in the admin, add our version to the database.
					update_option( 'generate_db_version', GENERATE_VERSION );
				}

				return;
			}
		}

		if ( version_compare( $saved_version, GENERATE_VERSION, '=' ) ) {
			return;
		}

		if ( version_compare( $saved_version, '1.3.0', '<' ) ) {
			self::v_1_3_0();
		}

		if ( version_compare( $saved_version, '1.3.29', '<' ) ) {
			self::v_1_3_29();
		}

		if ( version_compare( $saved_version, '2.0', '<' ) ) {
			self::v_2_0();
		}

		if ( version_compare( $saved_version, '2.1.3', '<' ) ) {
			self::v_2_1_3();
		}

		if ( version_compare( $saved_version, '2.3', '<' ) ) {
			self::v_2_3_0();
		}

		if ( version_compare( $saved_version, '2.5', '<' ) ) {
			self::v_2_5_0();
		}

		// Last thing to do is update our version.
		update_option( 'generate_db_version', GENERATE_VERSION );
	}

	/**
	 * Remove variants from font family values.
	 *
	 * @since 1.3.0
	 */
	public function v_1_3_0() {
		// Don't run this if Typography add-on is activated.
		if ( function_exists( 'generate_fonts_customize_register' ) ) {
			return;
		}

		$settings = get_option( 'generate_settings', array() );

		if ( ! isset( $settings['font_body'] ) ) {
			return;
		}

		$value = $settings['font_body'];
		$needs_update = false;

		// If our value has : in it.
		if ( ! empty( $value ) && strpos( $value, ':' ) !== false ) {
			// Remove the : and anything past it.
			$value = current( explode( ':', $value ) );

			$settings['font_body'] = $value;
			$needs_update = true;
		}

		if ( $needs_update ) {
			update_option( 'generate_settings', $settings );
		}
	}

	/**
	 * Move logo to custom_logo option as required by WP.org.
	 *
	 * @since 1.3.29
	 */
	public static function v_1_3_29() {
		if ( ! function_exists( 'the_custom_logo' ) ) {
			return;
		}

		if ( get_theme_mod( 'custom_logo' ) ) {
			return;
		}

		$settings = get_option( 'generate_settings', array() );

		if ( ! isset( $settings['logo'] ) ) {
			return;
		}

		$old_value = $settings['logo'];

		if ( empty( $old_value ) ) {
			return;
		}

		$logo = attachment_url_to_postid( $old_value );

		if ( is_int( $logo ) ) {
			set_theme_mod( 'custom_logo', $logo );
		}

		if ( get_theme_mod( 'custom_logo' ) ) {
			$settings['logo'] = '';
			update_option( 'generate_settings', $settings );
		}
	}

	/**
	 * Pre-2.0 defaults.
	 *
	 * @since 2.0
	 */
	public static function v_2_0() {
		$settings = get_option( 'generate_settings', array() );
		$needs_update = false;

		if ( ! isset( $settings['font_awesome_essentials'] ) ) {
			$settings['font_awesome_essentials'] = false;
			$needs_update = true;
		}

		if ( ! isset( $settings['dynamic_css_cache'] ) ) {
			$settings['dynamic_css_cache'] = false;
			$needs_update = true;
		}

		$font_settings = wp_parse_args(
			get_option( 'generate_settings', array() ),
			array(
				'font_body' => 'Open Sans',
			)
		);

		$category = get_theme_mod( 'font_body_category', 'sans-serif' );
		$variants = get_theme_mod( 'font_body_variants', '300,300italic,regular,italic,600,600italic,700,700italic,800,800italic' );

		if ( 'Open Sans' === $font_settings['font_body'] ) {
			$settings['font_body'] = 'Open Sans';
			set_theme_mod( 'font_body_category', $category );
			set_theme_mod( 'font_body_variants', $variants );
			$needs_update = true;
		}

		if ( $needs_update ) {
			update_option( 'generate_settings', $settings );
		}
	}

	/**
	 * Set blog index content open to full content.
	 *
	 * @since 2.1.3
	 */
	public static function v_2_1_3() {
		$settings = wp_parse_args(
			get_option( 'generate_settings', array() ),
			array(
				'post_content' => 'full',
			)
		);

		$needs_update = false;

		if ( 'full' === $settings['post_content'] ) {
			$settings['post_content'] = 'full';
			$needs_update = true;
		}

		if ( $needs_update ) {
			update_option( 'generate_settings', $settings );
		}
	}

	/**
	 * Turn off the combine CSS option for existing sites.
	 *
	 * @since 2.3.0
	 */
	public static function v_2_3_0() {
		$settings = get_option( 'generate_settings', array() );
		$needs_update = false;

		if ( ! isset( $settings['combine_css'] ) ) {
			$settings['combine_css'] = false;
			$needs_update = true;
		}

		if ( $needs_update ) {
			update_option( 'generate_settings', $settings );
		}
	}

	/**
	 * Update sites using old defaults.
	 *
	 * @since 2.5.0
	 */
	public static function v_2_5_0() {
		$settings = get_option( 'generate_settings', array() );
		$needs_update = false;

		$old_defaults = array(
			'icons' => 'font',
			'structure' => 'floats',
		);

		foreach ( $old_defaults as $key => $value ) {
			if ( ! isset( $settings[ $key ] ) ) {
				$settings[ $key ] = $value;
				$needs_update = true;
			}
		}

		if ( $needs_update ) {
			update_option( 'generate_settings', $settings );
			delete_option( 'generate_dynamic_css_output' );
			delete_option( 'generate_dynamic_css_cached_version' );
		}
	}
}

GeneratePress_Theme_Update::get_instance();
