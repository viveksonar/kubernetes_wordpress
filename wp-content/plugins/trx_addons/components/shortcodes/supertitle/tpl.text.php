<?php
$args = get_query_var('trx_addons_args_sc_supertitle_args');
if (!empty($args['text'])) {
	?><<?php echo esc_attr($args['tag']); ?> class="sc_supertitle_text<?php
		if (!empty($args['inline'])) echo ' sc_supertitle_display_inline';
		if (!empty($args['color']) && empty($args['link'])) echo ' ' . trx_addons_add_inline_css_class('color: ' . esc_attr($args['color']) . ' !important;');
	?>"><?php
		if (!empty($args['link'])) {
			?><a href="<?php echo esc_url($args['link']); ?>"<?php
				if (!empty($args['color'])) echo ' class="' . trx_addons_add_inline_css_class('color: ' . esc_attr($args['color']) . ' !important;') . '"';
				if (!empty($args['new_window']) || !empty($args['link_extra']['is_external'])) echo ' target="_blank"';
				if (!empty($args['nofollow']) || !empty($args['link_extra']['nofollow'])) echo ' rel="nofollow"';
			?>><?php
		}

		trx_addons_show_layout($args['text']);

		if (!empty($args['link'])) {
			?></a><?php
		}
	?></<?php echo esc_attr($args['tag']); ?>><?php
}