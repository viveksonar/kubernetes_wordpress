<?php
/**
 * Skins support: Main skin file for the skin 'Default'
 *
 * Setup skin-dependent fonts and colors, load scripts and styles,
 * and other operations that affect the appearance and behavior of the theme
 * when the skin is activated
 *
 * @package WordPress
 * @subpackage BASEKIT
 * @since BASEKIT 1.0.46
 */


// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'shift_cv_skin_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'shift_cv_skin_theme_setup3', 3 );
	function shift_cv_skin_theme_setup3() {
		shift_cv_storage_set(
			'schemes', array(

				// Color scheme: 'default'
				'default' => array(
					'title'    => esc_html__( 'Default', 'shift-cv' ),
					'internal' => true,
					'colors'   => array(

						// Whole block border and background
						'bg_color'         => '#ffffff', //
						'bd_color'         => '#f3f3f5', //

						// Text and links colors
						'text'             => '#86888f', //
						'text_light'       => '#9a9ea7', //
						'text_dark'        => '#1d1d1d', //
						'text_link'        => '#2c51f8', //
						'text_hover'       => '#fa6827', //
						'text_link2'       => '#ffb400', //
						'text_hover2'      => '#8be77c',
						'text_link3'       => '#ffffff', ///
						'text_hover3'      => '#eec432',

						// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
						'alter_bg_color'   => '#ffffff', //
						'alter_bg_hover'   => '#e3e4e6', //
						'alter_bd_color'   => '#f3f3f5', //
						'alter_bd_hover'   => '#e3e4e6', ///
						'alter_text'       => '#333333',
						'alter_light'      => '#9a9ea7', //
						'alter_dark'       => '#1d1d1d',
						'alter_link'       => '#fa6827', //
						'alter_hover'      => '#2c51f8', //
						'alter_link2'      => '#ffc455', //
						'alter_hover2'     => '#80d572',
						'alter_link3'      => '#eec432',
						'alter_hover3'     => '#ddb837',

						// Extra blocks (submenu, tabs, color blocks, etc.)
						'extra_bg_color'   => '#1f2021', //
						'extra_bg_hover'   => '#28272e',
						'extra_bd_color'   => '#3c3d40', //
						'extra_bd_hover'   => '#3d3d3d',
						'extra_text'       => '#bfbfbf',
						'extra_light'      => '#9a9ea7', //
						'extra_dark'       => '#ffffff',
						'extra_link'       => '#2c51f8', //
						'extra_hover'      => '#fa6827',
						'extra_link2'      => '#fa6827', //
						'extra_hover2'     => '#8be77c',
						'extra_link3'      => '#ddb837',
						'extra_hover3'     => '#1f2021', ///

						// Input fields (form's fields and textarea)
						'input_bg_color'   => '#f3f3f5', //
						'input_bg_hover'   => '#f3f3f5', ///
						'input_bd_color'   => '#f3f3f5',
						'input_bd_hover'   => '#fa6827', //
						'input_text'       => '#888888',
						'input_light'      => '#a7a7a7',
						'input_dark'       => '#1d1d1d',

						// Inverse blocks (text and links on the 'text_link' background)
						'inverse_bd_color' => '#f3f3f5', //
						'inverse_bd_hover' => '#5aa4a9',
						'inverse_text'     => '#ffffff', //
						'inverse_light'    => '#ffffff', ///
						'inverse_dark'     => '#000000',
						'inverse_link'     => '#ffffff',
						'inverse_hover'    => '#1d1d1d',
					),
				),

				// Color scheme: 'dark'
				'dark'    => array(
					'title'    => esc_html__( 'Dark', 'shift-cv' ),
					'internal' => true,
					'colors'   => array(

						// Whole block border and background
						'bg_color'         => '#1f2021', //
						'bd_color'         => '#3c3d40', ///

						// Text and links colors
						'text'             => '#67696e', //
						'text_light'       => '#a3a5ad', //
						'text_dark'        => '#ffffff', //
						'text_link'        => '#ffb400', //
						'text_hover'       => '#fa6827', //
						'text_link2'       => '#ffb400', //
						'text_hover2'      => '#8be77c',
						'text_link3'       => '#3c3d40', ///
						'text_hover3'      => '#eec432',

						// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
						'alter_bg_color'   => '#1f2021', //
						'alter_bg_hover'   => '#161617', //
						'alter_bd_color'   => '#1f2021', //
						'alter_bd_hover'   => '#3c3d40', ///
						'alter_text'       => '#67696e', //
						'alter_light'      => '#a3a5ad', //
						'alter_dark'       => '#ffffff', //
						'alter_link'       => '#ffb400', //
						'alter_hover'      => '#2c51f8', //
						'alter_link2'      => '#ffc455', //
						'alter_hover2'     => '#80d572',
						'alter_link3'      => '#eec432',
						'alter_hover3'     => '#ddb837',

						// Extra blocks (submenu, tabs, color blocks, etc.)
						'extra_bg_color'   => '#ffffff', //
						'extra_bg_hover'   => '#f3f5f7', //
						'extra_bd_color'   => '#e5e5e5', //
						'extra_bd_hover'   => '#f3f5f7',
						'extra_text'       => '#1f2021', //
						'extra_light'      => '#a3a5ad', //
						'extra_dark'       => '#ffffff',
						'extra_link'       => '#fa6827', //
						'extra_hover'      => '#fa6827',
						'extra_link2'      => '#ff4b4b', //
						'extra_hover2'     => '#8be77c',
						'extra_link3'      => '#ddb837',
						'extra_hover3'     => '#3c3d40',

						// Input fields (form's fields and textarea)
						'input_bg_color'   => '#161617', ///
						'input_bg_hover'   => '#3c3d40', ///
						'input_bd_color'   => '#161617', ///
						'input_bd_hover'   => '#fa6827', //
						'input_text'       => '#ffffff', //
						'input_light'      => '#6f6f6f',
						'input_dark'       => '#a3a5ad', //

						// Inverse blocks (text and links on the 'text_link' background)
						'inverse_bd_color' => '#161617', //
						'inverse_bd_hover' => '#cb5b47',
						'inverse_text'     => '#ffffff', //
						'inverse_light'    => '#3c3d40', ///
						'inverse_dark'     => '#1f2021', //
						'inverse_link'     => '#ffffff', //
						'inverse_hover'    => '#ffffff', //
					),
				),

			)
		);
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'shift_cv_skin_tgmpa_required_plugins' ) ) {
	add_filter( 'shift_cv_filter_tgmpa_required_plugins', 'shift_cv_skin_tgmpa_required_plugins' );
	function shift_cv_skin_tgmpa_required_plugins( $list = array() ) {
		// ToDo: Check if plugin is in the 'required_plugins' and add his parameters to the TGMPA-list
		//       Replace 'skin-specific-plugin-slug' to the real slug of the plugin
		if ( shift_cv_storage_isset( 'required_plugins', 'skin-specific-plugin-slug' ) ) {
			$list[] = array(
				'name'     => shift_cv_storage_get_array( 'required_plugins', 'skin-specific-plugin-slug' ),
				'slug'     => 'skin-specific-plugin-slug',
				'required' => false,
			);
		}
		return $list;
	}
}

// Enqueue skin-specific styles and scripts
if ( ! function_exists( 'shift_cv_skin_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'shift_cv_skin_frontend_scripts', 1100 );
	function shift_cv_skin_frontend_scripts() {
		if ( shift_cv_is_on( shift_cv_get_theme_option( 'debug_mode' ) ) ) {
			$shift_cv_url = shift_cv_get_file_url( SHIFT_CV_SKIN_DIR . 'skin.js' );
			if ( '' != $shift_cv_url ) {
				wp_enqueue_script( 'shift-cv-skin-' . esc_attr( SHIFT_CV_SKIN_NAME ), $shift_cv_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'shift_cv_skin_merge_styles' ) ) {
	add_filter( 'shift_cv_filter_merge_styles', 'shift_cv_skin_merge_styles' );
	function shift_cv_skin_merge_styles( $list ) {
		if ( shift_cv_get_file_dir( SHIFT_CV_SKIN_DIR . '_skin.scss' ) != '' ) {
			$list[] = SHIFT_CV_SKIN_DIR . '_skin.scss';
		}
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'shift_cv_skin_merge_styles_responsive' ) ) {
	add_filter( 'shift_cv_filter_merge_styles_responsive', 'shift_cv_skin_merge_styles_responsive' );
	function shift_cv_skin_merge_styles_responsive( $list ) {
		if ( shift_cv_get_file_dir( SHIFT_CV_SKIN_DIR . '_skin-responsive.scss' ) != '' ) {
			$list[] = SHIFT_CV_SKIN_DIR . '_skin-responsive.scss';
		}
		return $list;
	}
}

// Merge custom scripts
if ( ! function_exists( 'shift_cv_skin_merge_scripts' ) ) {
	add_filter( 'shift_cv_filter_merge_scripts', 'shift_cv_skin_merge_scripts' );
	function shift_cv_skin_merge_scripts( $list ) {
		if ( shift_cv_get_file_dir( SHIFT_CV_SKIN_DIR . 'skin.js' ) != '' ) {
			$list[] = SHIFT_CV_SKIN_DIR . 'skin.js';
		}
		return $list;
	}
}

//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'shift_cv_skin_importer_set_options' ) ) {
	add_filter('trx_addons_filter_importer_options', 'shift_cv_skin_importer_set_options', 10);
	function shift_cv_skin_importer_set_options($options = array()) {
		if (is_array($options)) {
			// Corporate demo
			$options['files']['real-estate'] = $options['files']['default'];
			$options['files']['real-estate']['title'] = esc_html__('Real Estate Shift CV Demo', 'shift-cv');
			$options['files']['real-estate']['domain_demo'] = esc_url( shift_cv_get_protocol() . '://real-estate.shift-cv.themerex.net' );   // Demo-site domain
		}
		return $options;
	}
}


// Add slin-specific colors and fonts to the custom CSS
require_once SHIFT_CV_THEME_DIR . SHIFT_CV_SKIN_DIR . 'skin-styles.php';

