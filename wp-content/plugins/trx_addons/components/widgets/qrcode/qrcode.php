<?php
/**
 * Widget: QR code vcard
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */

// Load widget
if (!function_exists('trx_addons_widget_qrcode_load')) {
	add_action( 'widgets_init', 'trx_addons_widget_qrcode_load' );
	function trx_addons_widget_qrcode_load() {
		register_widget('trx_addons_widget_qrcode');
	}
}

// Merge widget specific styles into single stylesheet
if ( !function_exists( 'trx_addons_widget_qrcode_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'trx_addons_widget_qrcode_merge_styles');
	function trx_addons_widget_qrcode_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_WIDGETS . 'qrcode/_qrcode.scss';
		return $list;
	}
}


// Load required styles and scripts for the admin
if ( !function_exists( 'trx_addons_widget_qrcode_load_scripts_admin' ) ) {
	add_action("admin_enqueue_scripts", 'trx_addons_widget_qrcode_load_scripts_admin');
	function trx_addons_widget_qrcode_load_scripts_admin() {
		wp_enqueue_style( 'trx_addons-widget_qrcode_css', trx_addons_get_file_url( TRX_ADDONS_PLUGIN_WIDGETS . 'qrcode/qrcode.admin.css' ) );
		wp_enqueue_script( 'jquery_qrcode', trx_addons_get_file_url( TRX_ADDONS_PLUGIN_WIDGETS . 'qrcode/jquery.qrcode-0.6.0.min.js' ), array( 'jquery' ), null, true );
		wp_enqueue_script( 'trx_addons-widget_qrcode', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'qrcode/qrcode.admin.js'), array('jquery', 'jquery_qrcode'), null, true );
	}
}

// Load required styles and scripts for Elementor Editor mode
if ( !function_exists( 'trx_addons_qrcode_editor_load_scripts' ) ) {
	add_action("trx_addons_action_pagebuilder_admin_scripts", 'trx_addons_qrcode_editor_load_scripts');
	function trx_addons_qrcode_editor_load_scripts() {
		wp_enqueue_script( 'jquery_qrcode', trx_addons_get_file_url( TRX_ADDONS_PLUGIN_WIDGETS . 'qrcode/jquery.qrcode-0.6.0.min.js' ), array( 'jquery' ), null, true );
		wp_enqueue_script( 'trx_addons-qrcode-editor', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_WIDGETS . 'qrcode/qrcode.editor.js'), array('jquery', 'jquery_qrcode'), null, true );
	}
}


/**
 * QRCode VCard Widget class.
 */
class trx_addons_widget_qrcode extends TRX_Addons_Widget {

	function __construct() {
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget_qrcode', 'description' => esc_html__('Generate QRCode for your VCard', 'trx_addons'));
		parent::__construct( 'trx_addons_widget_qrcode', esc_html__('ThemeREX QRCode VCard', 'trx_addons'), $widget_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget($args, $instance) {
		$args['title'] =  apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '');

		trx_addons_get_template_part(TRX_ADDONS_PLUGIN_WIDGETS . 'qrcode/tpl.default.php',
			'trx_addons_args_widget_qrcode',
			apply_filters('trx_addons_filter_widget_args',
				array_merge($args, $instance),
				$instance, 'trx_addons_widget_qrcode')
		);
	}

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Strip tags for title and comments count to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = strip_tags($new_instance['subtitle']);

		$instance['ulname'] = strip_tags($new_instance['ulname']);
		$instance['ufname'] = strip_tags($new_instance['ufname']);
		$instance['utitle'] = strip_tags($new_instance['utitle']);
		$instance['ucompany'] = strip_tags($new_instance['ucompany']);
		$instance['uphone'] = strip_tags($new_instance['uphone']);
		//$instance['ufax'] = strip_tags($new_instance['ufax']);
		$instance['uaddr'] = strip_tags($new_instance['uaddr']);
		$instance['ucity'] = strip_tags($new_instance['ucity']);
		$instance['upostcode'] = strip_tags($new_instance['upostcode']);
		$instance['ucountry'] = strip_tags($new_instance['ucountry']);
		$instance['uemail'] = strip_tags($new_instance['uemail']);
		$instance['usite'] = strip_tags($new_instance['usite']);
		//$instance['unote'] = strip_tags($new_instance['unote']);
		//$instance['ucats'] = strip_tags($new_instance['ucats']);
		$instance['uid'] = strip_tags($new_instance['uid']);
		$instance['urev'] = date('Y-m-d');
		$instance['show_personal'] = isset($new_instance['show_personal']) ? 1 : 0;
		$instance['auto_draw'] = isset($new_instance['auto_draw']) ? 1 : 0;
		$instance['width'] = (int) $new_instance['width'];
		$instance['color'] = strip_tags($new_instance['color']);
		$instance['image'] = strip_tags($new_instance['image']);
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {

		/* Set up some default widget settings. */
		$address = explode(',', $instance['uaddr']);
		$defaults = array(
			'title' => '', 
			'subtitle' => '', 
			'description' => esc_attr__('QR Code Generator (for your vcard)', 'trx_addons'),
			'ulname' => $instance['ulname'],
			'ufname' => $instance['ufname'],
			'ucompany' => $instance['ucompany'],
			'uaddr' => (isset($address[0]) ? $address[0] : '').(isset($address[1]) ? ','.$address[1] : ''), 
			'ucity' => isset($address[2]) ? $address[2] : '', 
			'upostcode' => isset($address[count($address)-2]) ? $address[count($address)-2] : '', 
			'ucountry' => isset($address[count($address)-1]) ? $address[count($address)-1] : '', 
			'uemail' => $instance['uemail'],
			'usite' => $instance['usite'],
			'uphone' => $instance['uphone'],
			//'ufax' => '', 
			//'unote' => '', 
			//'ucats' => '', 
			'uid' => md5(microtime()), 
			'urev' => date('Y-m-d'),
			'image' => '', 
			'show_personal' => 0,
			'auto_draw' => 0,
			'size' => 160,
			'color' => '#000000'
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<div class="widget_qrcode">
        	<div class="qrcode_tabs">
                <ul class="tabs">
                    <li class="first"><a href="#tab_settings"><?php esc_attr_e('Settings', 'trx_addons'); ?></a></li>
                    <li><a href="#tab_fields" onmousedown="trx_addons_init_qrcode()"><?php esc_attr_e('Personal Data', 'trx_addons'); ?></a></li>
                </ul>
                <div id="tab_settings" class="tab_content tab_settings">
                    <p>
                        <input class="fld_show_personal" onfocus="trx_addons_init_qrcode()" id="<?php echo $this->get_field_id('show_personal'); ?>" name="<?php echo $this->get_field_name('show_personal'); ?>" value="1" type="checkbox" <?php echo $instance['show_personal']==1 ? 'checked="checked"' : ''; ?>>
                        <label for="<?php echo $this->get_field_id('show_personal'); ?>"> <?php esc_attr_e('Show personal data', 'trx_addons'); ?></label>
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_attr_e('Title:', 'trx_addons'); ?></label>
                        <input class="fld_title" onfocus="trx_addons_init_qrcode()" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
                    </p>
            
                    <p>
                        <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php esc_attr_e('Subtitle:', 'trx_addons'); ?></label>
                        <input class="fld_subtitle" onfocus="trx_addons_init_qrcode()" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" value="<?php echo $instance['subtitle']; ?>">
                    </p>
                    <p>
                        <label for="<?php echo $this->get_field_id('color'); ?>"><?php esc_attr_e('Color', 'trx_addons'); ?></label>
                        <input type="text" id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" value="<?php echo $instance['color']; ?>" class="wp-color-picker">
                        <input class="fld_width" onfocus="trx_addons_init_qrcode()" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="160" type="hidden" >
                    </p>
                </div>
                <div id="tab_fields" class="tab_content tab_personal">
                    <p>
                        <label for="<?php echo $this->get_field_id('ulname'); ?>"><?php esc_attr_e('Last name:', 'trx_addons'); ?></label>
                        <input class="fld_ulname" id="<?php echo $this->get_field_id('ulname'); ?>" name="<?php echo $this->get_field_name('ulname'); ?>" value="<?php echo $instance['ulname']; ?>">
                    </p>
                    
                    <p>
                        <label for="<?php echo $this->get_field_id('ufname'); ?>"><?php esc_attr_e('First name:', 'trx_addons'); ?></label>
                        <input class="fld_ufname" id="<?php echo $this->get_field_id('ufname'); ?>" name="<?php echo $this->get_field_name('ufname'); ?>" value="<?php echo $instance['ufname']; ?>">
                    </p>
                    
                    <p>
                        <label for="<?php echo $this->get_field_id('ucompany'); ?>"><?php esc_attr_e('Company:', 'trx_addons'); ?></label>
                        <input class="fld_ucompany" id="<?php echo $this->get_field_id('ucompany'); ?>" name="<?php echo $this->get_field_name('ucompany'); ?>" value="<?php echo $instance['ucompany']; ?>">
                    </p>
                    
                    <p>
                        <label for="<?php echo $this->get_field_id('uphone'); ?>"><?php esc_attr_e('Phone:', 'trx_addons'); ?></label>
                        <input class="fld_uphone" id="<?php echo $this->get_field_id('uphone'); ?>" name="<?php echo $this->get_field_name('uphone'); ?>" value="<?php echo $instance['uphone']; ?>">
                    </p>
           
                    <p>
                        <label for="<?php echo $this->get_field_id('uaddr'); ?>"><?php esc_attr_e('Address:', 'trx_addons'); ?></label>
                        <input class="fld_uaddr" id="<?php echo $this->get_field_id('uaddr'); ?>" name="<?php echo $this->get_field_name('uaddr'); ?>" value="<?php echo $instance['uaddr']; ?>">
                    </p>
                    
                    <p>
                        <label for="<?php echo $this->get_field_id('ucity'); ?>"><?php esc_attr_e('City:', 'trx_addons'); ?></label>
                        <input class="fld_ucity" id="<?php echo $this->get_field_id('ucity'); ?>" name="<?php echo $this->get_field_name('ucity'); ?>" value="<?php echo $instance['ucity']; ?>" >
                    </p>
                    
                    <p>
                        <label for="<?php echo $this->get_field_id('upostcode'); ?>"><?php esc_attr_e('Post code:', 'trx_addons'); ?></label>
                        <input class="fld_upostcode" id="<?php echo $this->get_field_id('upostcode'); ?>" name="<?php echo $this->get_field_name('upostcode'); ?>" value="<?php echo $instance['upostcode']; ?>">
                    </p>
                    
                    <p>
                        <label for="<?php echo $this->get_field_id('ucountry'); ?>"><?php esc_attr_e('Country:', 'trx_addons'); ?></label>
                        <input class="fld_ucountry" id="<?php echo $this->get_field_id('ucountry'); ?>" name="<?php echo $this->get_field_name('ucountry'); ?>" value="<?php echo $instance['ucountry']; ?>">
                    </p>
            
                    <p>
                        <label for="<?php echo $this->get_field_id('uemail'); ?>"><?php esc_attr_e('E-mail:', 'trx_addons'); ?></label>
                        <input class="fld_uemail" id="<?php echo $this->get_field_id('uemail'); ?>" name="<?php echo $this->get_field_name('uemail'); ?>" value="<?php echo $instance['uemail']; ?>">
                    </p>
            
                    <p>
                        <label for="<?php echo $this->get_field_id('usite'); ?>"><?php esc_attr_e('Web Site URL:', 'trx_addons'); ?></label>
                        <input class="fld_usite" id="<?php echo $this->get_field_id('usite'); ?>" name="<?php echo $this->get_field_name('usite'); ?>" value="<?php echo $instance['usite']; ?>">
                    </p>

				</div>
            </div>            
            <input class="fld_uid" id="<?php echo $this->get_field_id('uid'); ?>" name="<?php echo $this->get_field_name('uid'); ?>" value="<?php echo $instance['uid']; ?>" type="hidden">
            <input class="fld_urev" id="<?php echo $this->get_field_id('urev'); ?>" name="<?php echo $this->get_field_name('urev'); ?>" value="<?php echo $instance['urev']; ?>" type="hidden">
    
            <p>
                <input class="fld_button_draw" id="<?php echo $this->get_field_id('button_draw'); ?>" name="<?php echo $this->get_field_name('button_draw'); ?>" value="Update" type="button">
                <input class="fld_auto_draw" id="<?php echo $this->get_field_id('auto_draw'); ?>" name="<?php echo $this->get_field_name('auto_draw'); ?>" value="1" type="checkbox" <?php echo $instance['auto_draw']==1 ? 'checked="checked"' : ''; ?>>
                <label for="<?php echo $this->get_field_id('auto_draw'); ?>"> <?php esc_attr_e('Auto', 'trx_addons'); ?></label>
            </p>
            <input class="fld_image" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" value="" type="hidden">
            <div id="<?php echo $this->get_field_id('qrcode_image'); ?>" class="qrcode_image"><img src="<?php echo $instance['image']; ?>"></div>
            <div id="<?php echo $this->get_field_id('qrcode_data'); ?>" class="qrcode_data">
<?php if ($instance['show_personal']==1) { ?>
                <ul>
                    <li class="user_name odd first"><?php echo $instance['ufname']; ?> <?php echo $instance['ulname']; ?></li>
                    <?php 
						echo  ($instance['ucompany'] ? '<li class="user_company even">' . $instance['ucompany'] . '</li>' : '')
							. ($instance['uphone'] ? '<li class="user_phone odd">' . $instance['uphone'] . '</li>' : '')
							. ($instance['uemail'] ? '<li class="user_email even"><a href="mailto:' . $instance['uemail'] . '">' . $instance['uemail'] . '</a></li>' : '')
							. ($instance['usite'] ? '<li class="user_site odd"><a href="' . $instance['usite'] . '" target="_blank">' . $instance['usite'] . '</a></li>' : '');
					?>
                </ul>
<?php } ?>
            </div>
		</div>
	<?php
	}
}

// trx_widget_qrcode
//-------------------------------------------------------------
/*
[trx_widget_qrcode id="unique_id" title="Widget title" title_popular="title for the tab 'most popular'" title_commented="title for the tab 'most commented'" title_liked="title for the tab 'most liked'" number="4"]
*/
if ( !function_exists( 'trx_addons_sc_widget_qrcode' ) ) {
	function trx_addons_sc_widget_qrcode($atts, $content=null){
		$atts = trx_addons_sc_prepare_atts('trx_widget_qrcode', $atts, array(
				// Individual params
				"show_personal" => "",
				"title" => "",
				"subtitle" => "",
				"color" => "#000000",
				"width" => "160",
				"ulname" => "",
				"ufname" => "",
				"ucompany" => "",
				"uphone" => "",
				"uaddr" => "",
				"ucity" => "",
				"upostcode" => "",
				"ucountry" => "",
				"uemail" => "",
				"usite" => "",
				"uid" => "",
				"urev" => "",
				"image" => "",
				// Common params
				"id" => "",
				"class" => "",
				"css" => ""
			)
		);
		if ($atts['urev']=='') $atts['uid'] = date('Y-m-d');


		extract($atts);
		$type = 'trx_addons_widget_qrcode';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="widget_area sc_widget_qrcode'
				. (!empty($class) ? ' ' . esc_attr($class) : '')
				. '"'
				. ($css ? ' style="'.esc_attr($css).'"' : '')
				. '>';
			ob_start();
			the_widget( $type, $atts, trx_addons_prepare_widgets_args($id ? $id.'_widget' : 'widget_qrcode', 'widget_qrcode') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('trx_addons_sc_output', $output, 'trx_widget_qrcode', $atts, $content);
	}
}

// Elementor Widget
//------------------------------------------------------
if (!function_exists('trx_addons_sc_widget_qrcode_add_in_elementor')) {
	add_action( 'elementor/widgets/widgets_registered', 'trx_addons_sc_widget_qrcode_add_in_elementor' );
	function trx_addons_sc_widget_qrcode_add_in_elementor() {

		if (!class_exists('TRX_Addons_Elementor_Widget')) return;

		class TRX_Addons_Elementor_Widget_Qrcode extends TRX_Addons_Elementor_Widget {

			/**
			 * Widget base constructor.
			 *
			 * Initializing the widget base class.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @param array      $data Widget data. Default is an empty array.
			 * @param array|null $args Optional. Widget default arguments. Default is null.
			 */
			public function __construct( $data = [], $args = null ) {
				parent::__construct( $data, $args );
				$this->add_plain_params([
					'width' => 'size'
				]);
			}

			/**
			 * Retrieve widget name.
			 *
			 * @since 1.6.41
			 * @access public
			 *
			 * @return string Widget name.
			 */
			public function get_name() {
				return 'trx_widget_qrcode';
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
				return __( 'Widget: QRCode VCard', 'trx_addons' );
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
				return 'eicon-shortcode';
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
				return ['trx_addons-widgets'];
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
					'section_sc_qrcode',
					[
						'label' => __( 'Widget: QRCode VCard', 'trx_addons' ),
					]
				);
				$this->add_control(
					'title',
					[
						'label' => __( 'Title', 'trx_addons' ),
						'label_block' => true,
						'classes' => 'fld_title',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Widget title", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'subtitle',
					[
						'label' => __( 'Subtitle', 'trx_addons' ),
						'label_block' => true,
						'classes' => 'fld_subtitle',
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'placeholder' => __( "Widget subtitle", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'color',
					[
						'label' => __( 'Color', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_color',
						'type' => \Elementor\Controls_Manager::COLOR,
						'placeholder' => __( "Widget Color", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'width',
					[
						'label' => __( 'Number posts to show', 'trx_addons' ),
						'classes' => 'fld_width',
						'type' => \Elementor\Controls_Manager::SLIDER,
						'default' => [
							'size' => 160,
						],
						'range' => [
							'px' => [
								'min' => 100,
								'max' => 300
							]
						]
					]
				);
				$this->add_control(
					'show_personal',
					[
						'label' => __( "Show personal data", 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_show_personal',
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_off' => __( 'Hide', 'trx_addons' ),
						'label_on' => __( 'Show', 'trx_addons' ),
						'default' => 1,
						'return_value' => '1'
					]
				);
				$this->add_control(
					'ulname',
					[
						'label' => __( 'Last name', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_ulname',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Widget last name", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'ufname',
					[
						'label' => __( 'First name', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_ufname',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Widget first name", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'ucompany',
					[
						'label' => __( 'Company', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_ucompany',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Company", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'uphone',
					[
						'label' => __( 'Phone', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_uphone',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => '000-000-000',
						'default' => ''
					]
				);
				$this->add_control(
					'uaddr',
					[
						'label' => __( 'Address', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_uaddr',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Address", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'ucity',
					[
						'label' => __( 'City', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_ucity',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "City", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'upostcode',
					[
						'label' => __( 'Post code', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_upostcode',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Post code", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'ucountry',
					[
						'label' => __( 'Country', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_ucountry',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => __( "Country", 'trx_addons' ),
						'default' => ''
					]
				);
				$this->add_control(
					'uemail',
					[
						'label' => __( 'E-mail', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_uemail',
						'type' => \Elementor\Controls_Manager::TEXT,
						'placeholder' => 'test@mail.com',
						'default' => ''
					]
				);
				$this->add_control(
					'usite',
					[
						'label' => __( 'Web Site URL', 'trx_addons' ),
						'label_block' => false,
						'classes' => 'fld_usite',
						'type' => \Elementor\Controls_Manager::URL,
						'placeholder' => 'https://example.com',
						'default' => [ 'url' => 'http://your-link.com' ]
					]
				);
				//Hidden
				$this->add_control(
					'image',
					[
						'label' => __( 'QRCode value', 'trx_addons' ),
						'classes' => 'fld_image disabled',
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => ''
					]
				);

				$this->end_controls_section();
			}
		}

		// Register widget
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TRX_Addons_Elementor_Widget_Qrcode() );
	}
}


// Disable our widgets (shortcodes) to use in Elementor
// because we create special Elementor's widgets instead
if (!function_exists('trx_addons_widget_qrcode_black_list')) {
	add_action( 'elementor/widgets/black_list', 'trx_addons_widget_qrcode_black_list' );
	function trx_addons_widget_qrcode_black_list($list) {
		$list[] = 'trx_addons_widget_qrcode';
		return $list;
	}
}


?>