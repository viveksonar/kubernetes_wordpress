<?php
/**
 * The style "default" of the Icons
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_printbuttons');

$icon_present = '';
$svg_present = false;

?><div id="<?php echo esc_attr($args['id']); ?>"
	class="sc_printbuttons sc_printbuttons_<?php
		echo esc_attr($args['type']);
		echo ' sc_printbuttons_size_' . esc_attr($args['size']);
		if (!empty($args['out_content'])) echo ' sc_printbuttons_out_content';
		if (!empty($args['align'])) echo ' sc_align_'.esc_attr($args['align']);
		if (!empty($args['class'])) echo ' '.esc_attr($args['class']);
	?>"<?php
	if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
?>><?php

	trx_addons_sc_show_titles('sc_printbuttons', $args);

	if ($args['columns'] > 1) {
		?><div class="sc_printbuttons_columns_wrap sc_item_columns <?php echo esc_attr(trx_addons_get_columns_wrap_class()); ?> columns_padding_bottom"><?php
	}
	
	foreach ($args['printbuttons'] as $item) {
		$item['color'] = !empty($item['color']) ? $item['color'] : $args['color'];
		$role = !empty($item['role']) ? $item['role'] : 'download_pdf';

		if ($args['columns'] > 1) {
			?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
		}
		if (empty($args['out_content'])) {
			?><div class="printbuttons_buttons_wrap"><?php
		}
		?><a href="<?php echo ( empty($item['link']) ? '#' : $item['link']); ?>"
			class="sc_printbuttons_item <?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_printbuttons_item_link', 'sc_printbuttons', $args));
			//Print PDF
			if ('print_pdf' === $role) { echo ' print_pdf'; }
			//Print IMG
			if ('print_img' === $role) { echo ' print_img'; }
		?>"<?php
			if (!empty($item['new_window']) || !empty($item['link_extra']['is_external'])) echo ' target="_blank"';
			if (!empty($item['color'])) echo ' style="background-color: '.esc_attr($item['color']).'"';
			//Download
			if ('download' === $role) { echo ' download'; }

		?>><?php

			if (!empty($item['title']) && !empty($args['out_content'])) {
				$item['title'] = explode('|', $item['title']);
				foreach ($item['title'] as $str) {
					?><span class="sc_printbuttons_title"<?php
					if (!empty($item['color'])) echo ' style="background-color: '.esc_attr($item['color']).'"';
					?>><?php echo esc_html($str); ?></span><?php
				}
			}

			if (!empty($item['image'])) {
				$item['image'] = trx_addons_get_attachment_url($item['image'], apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('medium'), 'printbuttons-default'));
				if (!empty($item['image'])) {
					$attr = trx_addons_getimagesize($item['image']);
					?><span class="sc_printbuttons_image"><img src="<?php echo esc_url($item['image']); ?>" alt="<?php esc_attr_e('Icon', 'trx_addons'); ?>"<?php echo (!empty($attr[3]) ? ' '.trim($attr[3]) : ''); ?>></span><?php
				}
			} else {
				if (empty($item['icon_type'])) $item['icon_type'] = '';
				$icon = !empty($item['icon_type']) && !empty($item['icon_' . $item['icon_type']]) && $item['icon_' . $item['icon_type']] != 'empty'
					? $item['icon_' . $item['icon_type']]
					: (!empty($item['icon']) && strtolower($item['icon'])!='none' ? $item['icon'] : '');
				if (!empty($icon)) {
					$svg = $img = '';
					if (trx_addons_is_url($icon)) {
						if (strpos($icon, '.svg') !== false) {
							$svg = $icon;
							$item['icon_type'] = 'svg';
							$svg_present = $args['printbuttons_animation'] > 0;
						} else {
							$img = $icon;
							$item['icon_type'] = 'images';
						}
						$icon = basename($icon);
					} else if ($args['printbuttons_animation'] > 0 && ($svg = trx_addons_get_file_dir('css/icons.svg/'.trx_addons_clear_icon_name($icon).'.svg')) != '') {
						$item['icon_type'] = 'svg';
						$svg_present = true;
					} else if (!empty($item['icon_type']) && strpos($icon_present, $item['icon_type'])===false) {
						$icon_present .= (!empty($icon_present) ? ',' : '') . $item['icon_type'];
					}
					?><span id="<?php echo esc_attr($args['id'].'_'.trim($icon)); ?>" class="sc_printbuttons_icon sc_icon_type_<?php
						echo esc_attr($args['icon_type']);
						echo empty($svg) && empty($img) ? ' '.esc_attr($icon) : '';
						if ($svg_present) echo ' sc_icon_animation';
						?>"<?php

						if (!empty($item['color'])) echo ' style="background-color: '.esc_attr($item['color']).'"';

						?>><?php
					if (!empty($svg)) {
						trx_addons_show_layout(trx_addons_get_svg_from_file($svg));
					} else if (!empty($img)) {
						$attr = trx_addons_getimagesize($img);
						?><img class="sc_icon_as_image" src="<?php echo esc_url($img); ?>" alt="<?php esc_attr_e('Icon', 'trx_addons'); ?>"<?php echo (!empty($attr[3]) ? ' '.trim($attr[3]) : ''); ?>><?php
					} else {
						if (!empty($item['icon_type']) && $item['icon_type'] == 'sow')
							echo siteorigin_widget_get_icon($icon);
						else {
							?><span class="sc_icon_type_<?php echo esc_attr($args['icon_type']); ?> <?php echo esc_attr($icon); ?>"></span><?php
						}
					}
					?></span><?php
				}
			}

			if (!empty($item['title']) && empty($args['out_content'])) {
				$item['title'] = explode('|', $item['title']);
				foreach ($item['title'] as $str) {
					?><span class="sc_printbuttons_title"><?php echo esc_html($str); ?></span><?php
				}
			}

		?></a><?php
		if (empty($args['out_content'])) {
			?></div><?php
		}
		if ($args['columns'] > 1) {
			?></div><?php
		}
	} // End foreach

	if ($args['columns'] > 1) {
		?></div><?php
	}

	trx_addons_sc_show_links('sc_printbuttons', $args);

?></div><!-- /.sc_printbuttons --><?php

trx_addons_load_icons($icon_present);
if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $svg_present) {
	wp_enqueue_script( 'vivus', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_SHORTCODES . 'printbuttons/vivus.js'), array('jquery'), null, true );
}
?>