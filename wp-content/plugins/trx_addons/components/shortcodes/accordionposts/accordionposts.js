/**
 * Shortcode Accordion
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */
/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

// Init handlers
jQuery(document).ready(function() {

	var $sc_accordionposts = jQuery('.sc_accordionposts:not(.inited)');
	if ($sc_accordionposts.length > 0) {
		$sc_accordionposts.addClass('inited')
			.on('click', '.sc_accordionposts_item_header, .sc_accordionposts_item_icon, .sc_accordionposts_item_subtitle, .section_icon', function(e) {
				var $wrapper = jQuery(this).closest('.sc_accordionposts'),
					$parent = jQuery(this).closest('.sc_accordionposts_item');
				trx_addons_close_progress_bar();
				// Close others
				if (!$parent.hasClass('active')) {
					jQuery('.sc_accordionposts_item', $wrapper).removeClass('active')
										.find('.sc_accordionposts_item_header').stop().slideDown();
					jQuery('.sc_accordionposts_item_inner, .sc_accordionposts_item_subtitle', $wrapper).stop().slideUp({
						duration: 600,
						easing : 'swing'
					});
					trx_addons_open_item( $parent );
				} else {
					trx_addons_open_item( $parent );
				}
				return false;
			});
	}

	function trx_addons_open_item( $item ) {
		jQuery('.sc_accordionposts_item_header, .sc_accordionposts_item_inner, .sc_accordionposts_item_subtitle', $item).stop().slideToggle({
			duration: 600,
			easing : 'swing'
		}).promise().done(function () {
			$item.toggleClass('active');
			trx_addons_init_progress_bar();
			jQuery(window).trigger('resize');
		});
	}
	function trx_addons_close_progress_bar() {
		$prb = jQuery('.elementor-progress-bar');
		if ( $prb.length > 0 ) {
			$prb.css( 'width', 0 );
		}
	}
	function trx_addons_init_progress_bar() {
		$prb = jQuery('.elementor-progress-bar');
		if ( $prb.length > 0 ) {
		$prb.each(function () {
				var $current = jQuery(this),
					max = $current.data( 'max' );
				setTimeout(	function() {
						$current.css('width', max + '%');
					}, 600 );
				});
		}
	}

});