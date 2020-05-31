<?php
/**
 * Shortcode: Print Buttons
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

	
// Merge contact form specific styles into single stylesheet
if ( !function_exists( 'trx_addons_sc_printbuttons_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_sc_printbuttons_merge_styles');
	function trx_addons_sc_printbuttons_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/_printbuttons.scss';
		return $list;
	}
}


// Merge shortcode's specific styles to the single stylesheet (responsive)
if ( !function_exists( 'trx_addons_sc_printbuttons_merge_styles_responsive' ) ) {
	add_filter("trx_addons_filter_merge_styles_responsive", 'trx_addons_sc_printbuttons_merge_styles_responsive');
	function trx_addons_sc_printbuttons_merge_styles_responsive($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/_printbuttons.responsive.scss';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'trx_addons_sc_printbuttons_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'trx_addons_sc_printbuttons_merge_scripts');
	function trx_addons_sc_printbuttons_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/print.min.js';
		$list[] = TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/printbuttons.js';
		return $list;
	}
}

// Load required styles and scripts for the frontend
if ( !function_exists( 'trx_addons_sc_printbuttons_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'trx_addons_sc_printbuttons_load_scripts_front');
	function trx_addons_sc_printbuttons_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode')))
			wp_enqueue_script( 'printjs', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/print.min.js'), array('jquery'), null, true );
			wp_enqueue_script( 'trx_addons-sc_printbuttons', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/printbuttons.js'), array('jquery'), null, true );
	}
}


// trx_sc_printbuttons
//-------------------------------------------------------------
/*
[trx_sc_printbuttons id="unique_id" columns="2" values="encoded_json_data"]
*/
if ( !function_exists( 'trx_addons_sc_printbuttons' ) ) {
	function trx_addons_sc_printbuttons($atts, $content=null) {
		$atts = trx_addons_sc_prepare_atts('trx_sc_printbuttons', $atts, array(
			// Individual params
			"type" => "default",
			"icon_type" => "icons",
			"align" => "center",
			"out_content" => "",
			"size" => "medium",
			"color" => "",
			"columns" => "",
			"printbuttons" => "",
			"title" => "",
			"subtitle" => "",
			"printbuttons_animation" => "0",
			"link" => '#',
			"link_style" => 'default',
			"link_image" => '',
			"link_text" => esc_html__('Learn more', 'trx_addons'),
			"title_align" => "left",
			"title_style" => "default",
			"title_tag" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		if (function_exists('vc_param_group_parse_atts') && !is_array($atts['printbuttons']))
			$atts['printbuttons'] = (array) vc_param_group_parse_atts( $atts['printbuttons'] );

		$output = '';
		if (is_array($atts['printbuttons']) && count($atts['printbuttons']) > 0) {
			if (empty($atts['columns'])) $atts['columns'] = count($atts['printbuttons']);
			$atts['columns'] = max(1, min(count($atts['printbuttons']), $atts['columns']));

			ob_start();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/tpl.'.trx_addons_esc($atts['type']).'.php',
											TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/tpl.default.php'
											),
											'trx_addons_args_sc_printbuttons',
											$atts
										);
			$output = ob_get_contents();
			ob_end_clean();
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_printbuttons', $atts, $content);
	}
}


// Add [trx_sc_printbuttons] in the VC shortcodes list
if (!function_exists('trx_addons_sc_printbuttons_add_in_vc')) {
	function trx_addons_sc_printbuttons_add_in_vc() {
		
		add_shortcode("trx_sc_printbuttons", "trx_addons_sc_printbuttons");
		
		if (!trx_addons_exists_vc()) return;
		
		vc_lean_map("trx_sc_printbuttons", 'trx_addons_sc_printbuttons_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_Printbuttons extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_printbuttons_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_printbuttons_add_in_vc_params')) {
	function trx_addons_sc_printbuttons_add_in_vc_params() {
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_printbuttons",
				"name" => esc_html__("Print Buttons", 'trx_addons'),
				"description" => wp_kses_data( __("Insert print buttons with title and icons", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_printbuttons',
				"class" => "trx_sc_printbuttons",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array_merge(
					array(
						array(
							"param_name" => "type",
							"heading" => esc_html__("Layout", 'trx_addons'),
							"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
							"admin_label" => true,
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "default",
							"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'printbuttons'), 'trx_sc_printbuttons')),
							"type" => "dropdown"
						),
						array(
							"param_name" => "out_content",
							"heading" => esc_html__("Out Content", 'trx_addons'),
							"description" => wp_kses_data( __("Push buttons out contant", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "0",
							"value" => array(esc_html__("Push", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "align",
							"heading" => esc_html__("Align", 'trx_addons'),
							"description" => wp_kses_data( __("Select alignment of this item", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "center",
					        'save_always' => true,
							"value" => array_flip(trx_addons_get_list_sc_aligns()),
							"type" => "dropdown"
						),
						array(
							"param_name" => "size",
							"heading" => esc_html__("Icon size", 'trx_addons'),
							"description" => wp_kses_data( __("Select icon's size", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"value" => array_flip(trx_addons_get_list_sc_icon_sizes()),
					        'save_always' => true,
							"std" => "medium",
							"type" => "dropdown"
						),
						array(
							'param_name' => 'color',
							'heading' => esc_html__( 'Color', 'trx_addons' ),
							'description' => esc_html__( 'Select custom color for each icon', 'trx_addons' ),
							'edit_field_class' => 'vc_col-sm-4',
							'type' => 'colorpicker',
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", 'trx_addons'),
							"description" => wp_kses_data( __("Specify number of columns for printbuttons. If empty - auto detect by items number", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"type" => "textfield"
						),
						array(
							"param_name" => "printbuttons_animation",
							"heading" => esc_html__("Animation", 'trx_addons'),
							"description" => wp_kses_data( __("Check if you want animate printbuttons. Attention! Animation enabled only if in your theme exists .SVG icon with same name as selected icon", 'trx_addons') ),
							'edit_field_class' => 'vc_col-sm-4',
							"std" => "0",
							"value" => array(esc_html__("Animate printbuttons", 'trx_addons') => "1" ),
							"type" => "checkbox"
						),
						array(
							'type' => 'param_group',
							'param_name' => 'printbuttons',
							'heading' => esc_html__( 'Print Buttons', 'trx_addons' ),
							"description" => wp_kses_data( __("Select print buttons, specify title and/or icon for each item", 'trx_addons') ),
							'value' => urlencode( json_encode( apply_filters('trx_addons_sc_param_group_value', array(
								array(
									'title' => esc_html__( 'One', 'trx_addons' ),
									'description' => '',
									'color' => '',
									'role' => '',
									'image' => '',
									'link' => '',
									'icon' => '',
									'icon_fontawesome' => 'empty',
									'icon_openiconic' => 'empty',
									'icon_typprintbuttons' => 'empty',
									'icon_entypo' => 'empty',
									'icon_linecons' => 'empty'
								),
							), 'trx_sc_printbuttons') ) ),
							'params' => apply_filters('trx_addons_sc_param_group_params', array_merge(array(
									array(
										'param_name' => 'title',
										'heading' => esc_html__( 'Title', 'trx_addons' ),
										'description' => esc_html__( 'Enter title for this item', 'trx_addons' ),
										'admin_label' => true,
										'edit_field_class' => 'vc_col-sm-6',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'link',
										'heading' => esc_html__( 'File link', 'trx_addons' ),
										'description' => esc_html__( 'URL to link this block', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-6',
										'type' => 'textfield',
									),
									array(
										'param_name' => 'role',
										'heading' => esc_html__( 'Role', 'trx_addons' ),
										'description' => esc_html__( 'Button role', 'trx_addons' ),
										"admin_label" => true,
										'edit_field_class' => 'vc_col-sm-6',
										"std" => "download",
										"value" => array_flip(
											array(
												'download' =>  __( 'Download', 'trx_addons' ),
												'print_pdf' =>  __( 'Print PDF', 'trx_addons' ),
												'print_img' =>  __( 'Print image', 'trx_addons' ),
												'simple_link' =>  __( 'Simple Link', 'trx_addons' ),
											)
										),
										"type" => "dropdown"
									),
									array(
										'param_name' => 'color',
										'heading' => esc_html__( 'Color', 'trx_addons' ),
										'description' => esc_html__( 'Select custom color for this item', 'trx_addons' ),
										'edit_field_class' => 'vc_col-sm-6',
										'type' => 'colorpicker',
									),
									array(
										"param_name" => "image",
										"heading" => esc_html__("Image", 'trx_addons'),
										"description" => wp_kses_data( __("Select or upload image or specify URL from other site", 'trx_addons') ),
										'edit_field_class' => 'vc_col-sm-6',
										"type" => "attach_image"
									),
								), trx_addons_vc_add_icon_param('')
							), 'trx_sc_printbuttons')
						)
					),
					trx_addons_vc_add_title_param(false, false),
					trx_addons_vc_add_id_param()
				)
			), 'trx_sc_printbuttons' );
	}
}




// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_printbuttons_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_printbuttons_add_in_elementor' );
	function trx_addons_sc_printbuttons_add_in_elementor() {
		
		if (!class_exists('TRX_Addons_Elementor_Widget')) return;	

		class TRX_Addons_Elementor_Widget_Printbuttons extends TRX_Addons_Elementor_Widget {

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_sc_printbuttons';
			}

			/**
			 * Retrieve widget title.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget title.
			 */
			public function get_title() {
				return __( 'Print Buttons', 'trx_addons' );
			}

			/**
			 * Retrieve widget icon.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget icon.
			 */
			public function get_icon() {
				return 'eicon-info-box';
			}

			/**
			 * Retrieve the list of categories the widget belongs to.
			 *
			 * Used to determine where to display the widget in the editor.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return array Widget categories.
			 */
			public function get_categories() {
				return ['trx_addons-elements'];
			}

			/**
			 * Register widget controls.
			 *
			 * Adds different input fields to allow the user to change and customize the widget settings.
			 *
			 * @since 1.6.41
			 * @access protected
			 */
			protected function _register_controls() {
				$this->start_controls_section(
					'section_sc_printbuttons',
					[
						'label' => __( 'Print Buttons', 'trx_addons' ),
					]
				);

				$this->add_control(
					'type',
					[
						'label' => __( 'Layout', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'printbuttons'), 'trx_sc_printbuttons'),
						'default' => 'default',
					]
				);

				$this->add_control(
					'out_content',
					[
						'label' => __( 'Out Content', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Push buttons out contant", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'Push', 'trx_addons' ),
						'return_value' => '1'
					]
				);

				$this->add_control(
					'align',
					[
						'label' => __( 'Align', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_aligns(),
						'default' => 'center',
					]
				);

				$this->add_control(
					'size',
					[
						'label' => __( 'Icon size', 'trx_addons' ),
						'label_block' => false,
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => trx_addons_get_list_sc_icon_sizes(),
						'default' => 'medium',
					]
				);

				$this->add_control(
					'color',
					[
						'label' => __( 'Color', 'trx_addons' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'default' => '',
						'scheme' => [
							'type' => \Elementor\Scheme_Color::get_type(),
							'value' => \Elementor\Scheme_Color::COLOR_1
						],
					]
				);
				
				$this->add_control(
					'columns',
					[
						'label' => __( 'Columns', 'trx_addons' ),
						'description' => wp_kses_data( __("Specify number of columns for printbuttons. If empty or 0 - auto detect by items number", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 0
						],
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 12
							]
						]
					]
				);

				$this->add_control(
					'animation',
					[
						'label' => __( 'Print Buttons animation', 'trx_addons' ),
						'label_block' => false,
						'description' => wp_kses_data( __("Check if you want animate printbuttons. Attention! Animation enabled only if in your theme exists .SVG icon with same name as selected icon", 'trx_addons') ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Off', 'trx_addons' ),
						'label_on' => __( 'On', 'trx_addons' ),
						'return_value' => '1'
					]
				);
				
				$this->add_control(
					'printbuttons',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::REPEATER,
						'default' => apply_filters('trx_addons_sc_param_group_value', [
							[
								'title' => __( 'First icon', 'trx_addons' ),
								'link' => ['url' => ''],
								'description' => $this->get_default_description(),
								'color' => '',
								'role' => 'print',
								'image' => ['url' => ''],
								'icon' => 'icon-star-empty'
							],
							[
								'title' => __( 'Second icon', 'trx_addons' ),
								'link' => ['url' => ''],
								'description' => $this->get_default_description(),
								'color' => '',
								'role' => 'download',
								'image' => ['url' => ''],
								'icon' => 'icon-heart-empty'
							]
						], 'trx_sc_printbuttons'),
						'fields' => apply_filters('trx_addons_sc_param_group_params', array_merge(
							$this->get_icon_param(),
							[
								[
									'name' => 'title',
									'label' => __( 'Title', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::TEXT,
									'placeholder' => __( "Item's title", 'trx_addons' ),
									'default' => ''
								],
								[
									'name' => 'link',
									'label' => __( 'File link', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::URL,
									'placeholder' => 'http://your-link.com', 'trx_addons',
								],
								[
									'name' => 'role',
									'label' => __( 'Button role', 'trx_addons' ),
									'label_block' => false,
									'type' => \Elementor\Controls_Manager::SELECT,
									'options' => [
										'download' =>  __( 'Download', 'trx_addons' ),
										'print_pdf' =>  __( 'Print PDF', 'trx_addons' ),
										'print_img' =>  __( 'Print image', 'trx_addons' ),
										'simple_link' =>  __( 'Simple Link', 'trx_addons' ),
									],
									'default' => 'download',
								],
								[
									'name' => 'color',
									'label' => __( 'Color', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::COLOR,
									'default' => '',
									'scheme' => [
										'type' => \Elementor\Scheme_Color::get_type(),
										'value' => \Elementor\Scheme_Color::COLOR_1,
									],
								],
								[
									'name' => 'image',
									'label' => __( 'Image', 'trx_addons' ),
									'type' => \Elementor\Controls_Manager::MEDIA,
									'default' => [
										'url' => '',
									],
								]
							]),
							'trx_sc_printbuttons'),
						'title_field' => '{{{ title }}}',
					]
				);

				$this->end_controls_section();

				$this->add_title_param();
			}

		}
		
		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Printbuttons() );
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_sc_printbuttons_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_sc_printbuttons_black_list' );
	function trx_addons_sc_printbuttons_black_list($list) {
		$list[] = 'TRX_Addons_SOW_Widget_Printbuttons';
		return $list;
	}
}




// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_Printbuttons extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_printbuttons',
				esc_html__('ThemeREX Print Buttons', 'trx_addons'),
				array(
					'classname' => 'widget_printbuttons',
					'description' => __('Display set of printbuttons', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}


		// Return array with all widget's fields
		function get_widget_form() {
			return apply_filters('trx_addons_sow_map', array_merge(
				array(
					'type' => array(
						'label' => __('Layout', 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('sc', 'printbuttons'), $this->get_sc_name(), 'sow'),
						'type' => 'select'
					),
					"out_content" => array(
						"label" => esc_html__("Out Content", 'trx_addons'),
						"description" => wp_kses_data( __("Push buttons out contant", 'trx_addons') ),
						"default" => false,
						"type" => "checkbox"
					),
					"align" => array(
						"label" => esc_html__("Align", 'trx_addons'),
						"description" => wp_kses_data( __("Select alignment of this item", 'trx_addons') ),
						"default" => "center",
						"options" => trx_addons_get_list_sc_aligns(),
						"type" => "select"
					),
					"size" => array(
						"label" => esc_html__("Size", 'trx_addons'),
						"description" => wp_kses_data( __("Select icon's size", 'trx_addons') ),
						"default" => "medium",
						"options" => trx_addons_get_list_sc_icon_sizes(),
						"type" => "select"
					),
					"color" => array(
						"label" => esc_html__("Color", 'trx_addons'),
						"description" => wp_kses_data( __("Select custom color for each icon", 'trx_addons') ),
						"type" => "color"
					),
					"columns" => array(
						"label" => esc_html__("Columns", 'trx_addons'),
						"description" => wp_kses_data( __("Specify number of columns for printbuttons. If empty - auto detect by items number", 'trx_addons') ),
						"type" => "number"
					),
					"printbuttons_animation" => array(
						"label" => esc_html__("Animation", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want animate printbuttons. Attention! Animation enabled only if in your theme exists .SVG icon with same name as selected icon", 'trx_addons') ),
						"default" => false,
						"type" => "checkbox"
					),
					'printbuttons' => array(
						'label' => __('Print Buttons', 'trx_addons'),
						'item_name'  => __( 'Icon', 'trx_addons' ),
						'item_label' => array(
							'selector'     => "[name*='title']",
							'update_event' => 'change',
							'value_method' => 'val'
						),
						'type' => 'repeater',
						'fields' => apply_filters('trx_addons_sc_param_group_fields', array_merge(array(
								'title' => array(
									'label' => __('Title', 'trx_addons'),
									'description' => esc_html__( 'Enter title of the item', 'trx_addons' ),
									'type' => 'text'
								),
								'link' => array(
									'label' => __('File link', 'trx_addons'),
									'description' => esc_html__( 'URL to link this item', 'trx_addons' ),
									'type' => 'link'
								),
								'role' => array(
									'label' => __('Role', 'trx_addons'),
									"description" => wp_kses_data( __("Select button role", 'trx_addons') ),
									'default' => 'download',
									'options' => array(
										'download' =>  __( 'Download', 'trx_addons' ),
										'print_pdf' =>  __( 'Print PDF', 'trx_addons' ),
										'print_img' =>  __( 'Print image', 'trx_addons' ),
										'simple_link' =>  __( 'Simple Link', 'trx_addons' ),
									),
									'type' => 'select'
								),
								'color' => array(
									'label' => __('Color', 'trx_addons'),
									"description" => wp_kses_data( __("Select custom color for this item", 'trx_addons') ),
									'type' => 'color'
								),
								'image' => array(
									'label' => __('Image', 'trx_addons'),
									"description" => wp_kses_data( __("Select or upload imageto show it above title (instead icon)", 'trx_addons') ),
									'type' => 'media'
								)
							),
							trx_addons_sow_add_icon_param('')
						), $this->get_sc_name())
					)
				),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_printbuttons', __FILE__, 'TRX_Addons_SOW_Widget_Printbuttons');
}
?>