<?php
/**
 * Template to represent shortcode as a widget in the Elementor preview area
 *
 * Written as a Backbone JavaScript template and using to generate the live preview in the Elementor's Editor
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.41
 */

extract(get_query_var('trx_addons_args_widget_contacts'));

extract(trx_addons_prepare_widgets_args('widget_contacts_'.mt_rand(), 'widget_contacts'));

// Before widget (defined by themes)
trx_addons_show_layout($before_widget);

// Widget title if one was input (before and after defined by themes)
?><#
		settings.use_labels = settings.style === 'contacts-labels';
		if (settings.title != '') {
		#><?php trx_addons_show_layout($before_title); ?><#
			print(settings.title);
			#><?php trx_addons_show_layout($after_title); ?><#
			}

			// Widget body
			#><div class="contacts_wrap<#
				if (settings.use_labels > 0) {
					print(' contacts_wrap_labels');
				} else {
					print(' contacts_wrap_icons');
				}
			#>"><#
			if (settings.logo.url != '') {
			var mult = <?php echo trx_addons_get_retina_multiplier(); ?>;
			if (settings.logo_retina.url != '' && mult > 1)
		settings.logo.url = settings.logo_retina.url;
		#><div class="contacts_logo"><img src="{{ settings.logo.url }}" alt="<?php esc_attr_e("Contact's logo", 'trx_addons'); ?>"></div><#
				}
				if (settings.description != '') {
				#><div class="contacts_description">{{{ settings.description }}}</div><#
					}
					var show_info = settings.address != '' || settings.phone != '' || settings.email != '';
					if (!show_info) settings.googlemap_position = 'top';
					if (show_info || settings.googlemap > 0) {
				if (show_info && settings.googlemap > 0) {
				#><div class="contacts_place contacts_map_{{ settings.googlemap_position }}"><#
							}
							if (settings.googlemap > 0 && settings.address != '') {
						var id = settings._element_id ? settings._element_id + '_sc' : 'sc_contacts_map_'+(''+Math.random()).replace('.', '');
						var icon = "<?php echo addslashes(trx_addons_remove_protocol(trx_addons_get_option('api_google_marker'))); ?>";
						#><div class="contacts_map">
							<div id="{{ id }}_wrap" class="sc_googlemap_wrap">
								<div id="{{ id }}_map" class="sc_googlemap sc_googlemap_default" data-zoom="14">
									<div id="{{ id }}_marker"
										 class="sc_googlemap_marker"
										 data-address="<# print(_.escape(trx_addons_remove_macros(settings.address))); #>"
										 data-latlng=""></div>
								</div>
							</div><!-- /.sc_googlemap_wrap -->
						</div><#
								}
								if (show_info) {
								#><div class="contacts_info<#
				if (settings.use_labels > 0) {
					print(' show_labels');
				}
			#>"><#
										if (settings.name != '' || settings.bdate != '' || settings.address != '') {
										if (settings.columns > 0) {
									#><div class="contacts_left"><#
												}
												}
												if (settings.name != '') {
												#><div class="contacts_item"><span class="contacts_label"><?php esc_html_e( 'Name:', 'trx_addons' ) ?></span><span class="contacts_name"><# print(trx_addons_prepare_macros(settings.name)); #></span></div><#
													}
													if (settings.bdate != '') {
													#><div class="contacts_item"><span class="contacts_label"><?php esc_html_e( 'Date of birth:', 'trx_addons' ) ?></span><span class="contacts_bdate"><# print(trx_addons_prepare_macros(settings.bdate)); #></span></div><#
														}
														if (settings.address != '') {
														#><div class="contacts_item"><span class="contacts_label"><?php esc_html_e( 'Address:', 'trx_addons' ) ?></span><span class="contacts_address"><# print(trx_addons_prepare_macros(settings.address)); #></span></div><#
															}
															if (settings.name != '' || settings.bdate != '' || settings.address != '') {
															if (settings.columns > 0) {
														#></div><#
											}
											}
											if (settings.phone != '' || settings.email != '' || settings.site != '') {
											if (settings.columns > 0) {
										#><div class="contacts_right"><#
													}
													if (settings.email != '') {
													#><div class="contacts_item"><span class="contacts_label"><?php esc_html_e( 'Email:', 'trx_addons' ) ?></span><span class="contacts_email"><a href="mailto:{{ settings.email }}">{{ settings.email }}</a></span></div><#
														}
														if (settings.phone != '') {
														#><div class="contacts_item"><span class="contacts_label"><?php esc_html_e( 'Phone:', 'trx_addons' ) ?></span><a href="tel:{{ settings.phone }}" class="contacts_phone">{{ settings.phone }}</a></div><#
															}
															if (settings.site.url != '') {
															#><div class="contacts_item"><span class="contacts_label"><?php esc_html_e( 'Website:', 'trx_addons' ) ?></span><a href="{{ settings.site.url }}" class="contacts_site">{{ settings.site.url }}</a></div><#
																}
																if (settings.columns > 0) {
															#></div><#
												}
												}
												#></div><#
									}
									if (show_info && settings.googlemap > 0) {
								#></div><#
						}
						}

						// Social icons
						if ( settings.socials > 0) {
					#><div class="contacts_socials socials_wrap"><?php trx_addons_show_layout(trx_addons_get_socials_links()); ?></div><#
							}

							#></div><!-- /.contacts_wrap --><?php

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>