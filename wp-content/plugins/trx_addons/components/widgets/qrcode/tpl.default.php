<?php
/**
 * The style "default" of the Widget "QRcode"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.49
 */

$args = get_query_var('trx_addons_args_widget_qrcode');
extract($args);
// Before widget (defined by themes)
trx_addons_show_layout($before_widget);

// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);

?><div class="widget_inner<?php echo ($show_personal ? ' with_personal_data' : ''); ?>">
	<div class="qrcode"><img src="<?php echo wp_kses_data($image); ?>" alt="<?php echo esc_html($title); ?>"></div>
	<p class="subtitle"><?php echo wp_kses_data($subtitle); ?></p>
		<?php if ($show_personal): ?>
					<div class="personal_data">
						<p class="user_name"><?php echo esc_html($ufname . ' ' . $ulname); ?></p>
						<?php if (!empty($ucompany)) {
							?><p class="user_company"><?php echo esc_html($ucompany); ?></p><?php
						} ?>
						<?php if (!empty($uphone)) {
							?><p class="user_phone"><a href="<?php echo esc_attr(trx_addons_get_phone_link($uphone)); ?>"><?php echo wp_kses_data($uphone); ?></a></p><?php
						} ?>
						<?php if (!empty($uemail)) {
							?><p class="user_email"><a href="mailto:<?php echo antispambot($uemail); ?>"><?php echo antispambot($uemail); ?></a></p><?php
						} ?>
						<?php if (!empty($usite)) {
							if (is_array($usite)) {
								$is_external = empty($usite['is_external']) ? '' : $usite['is_external'];
								$nofollow = empty($usite['is_external']) ? '' : $usite['is_external'];
								$usite = empty($usite['url']) ? '' : $usite['url'];
							}
							?><p class="user_site"><a href="<?php echo esc_url($usite); ?>"
													  <?php if (!empty($new_window) || !empty($is_external)) echo ' target="_blank"';?><?php
													  		if (!empty($nofollow)) echo ' rel="nofollow"';?>><?php
														echo esc_url($usite); ?></a>
							</p><?php
						} ?>
					</div>
		<?php endif; ?>
</div><!-- /.widget_inner -->
<?php
// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>