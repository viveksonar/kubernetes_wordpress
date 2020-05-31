/**
 * Widget Instagram
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.47
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */


"use strict";

jQuery(document).ready(function(){
	trx_addons_init_qrcode();
});

function trx_addons_init_qrcode() {
	var widget = null;
	jQuery('#widgets-right .widget_qrcode input.wp-color-picker').each(function() {
		var obj = jQuery(this);
		if (!obj.hasClass('colored') && obj.attr('id').indexOf('__i__') < 0) {
			widget = obj.parents('.widget_qrcode');
			obj.addClass('colored');
			widget.find('div.qrcode_tabs').tabs();
			widget.find('.fld_button_draw').click(function() {
				trx_addons_update_qrcode(widget);
			});
			widget.parents('form').find('.widget-control-save').click(function() {
				trx_addons_update_qrcode(widget);
			});
			widget.find('.tab_personal input,.fld_auto_draw,.wp-color-picker').change(function () {
				if (widget.find('.fld_auto_draw').attr('checked')=='checked') {
					widget.find('.fld_button_draw').hide();
					trx_addons_update_qrcode(widget);
				} else
					widget.find('.fld_button_draw').show();
			});
			jQuery('.wp-color-picker').wpColorPicker({
				change:function(event, ui) {
					setTimeout(
						function () {
							if (widget.find('.fld_auto_draw').attr('checked')=='checked') {
								trx_addons_update_qrcode(widget);
							}
						},
						100
					)

				}
			});
		}
	});
	if (widget && widget.find('.fld_auto_draw').attr('checked')=='checked')
		widget.find('.fld_button_draw').hide();
}

function trx_addons_update_qrcode(widget) {

	trx_addons_show_qrcode(widget, {
			ufname:		widget.find('.fld_ufname').val(),
			ulname:		widget.find('.fld_ulname').val(),
			ucompany:	widget.find('.fld_ucompany').val(),
			usite:		widget.find('.fld_usite').val(),
			uemail:		widget.find('.fld_uemail').val(),
			uphone:		widget.find('.fld_uphone').val(),
			uaddr:		widget.find('.fld_uaddr').val(),
			ucity:		widget.find('.fld_ucity').val(),
			upostcode:	widget.find('.fld_upostcode').val(),
			ucountry:	widget.find('.fld_ucountry').val(),
			uid:		widget.find('.fld_uid').val(),
			urev:		widget.find('.fld_urev').val()
		},
		{
			qrcode: widget.find('.qrcode_image').eq(0),
			personal: widget.find('.qrcode_data'),
			show_personal: widget.find('.fld_show_personal').attr('checked')=='checked',
			color: widget.find('.wp-color-picker').val(),
			width: widget.find('.fld_width').val()
		}
	);
	widget.find('.fld_image').val(widget.find('.qrcode_image canvas').get(0).toDataURL('image/png'));
}
function trx_addons_show_qrcode(widget, vc, opt) {
	var vcard = 'BEGIN:VCARD\n'
		+ 'VERSION:3.0\n'
		+ 'FN:' + vc.ufname + ' ' + vc.ulname + '\n'
		+ 'N:' + vc.ulname + ';' + vc.ufname + '\n'
		+ (vc.ucompany ? 'ORG:' + vc.ucompany + '\n' : '')
		+ (vc.uphone ? 'TEL;TYPE=cell, pref:' + vc.uphone + '\n' : '')
		+ (vc.ufax ? 'TEL;TYPE=fax, pref:' + vc.ufax + '\n' : '')
		+ (vc.uaddr || vc.ucity || vc.ucountry ? 'ADR;TYPE=dom, home, postal, parcel:;;' + vc.uaddr + ';' + vc.ucity + ';;' + vc.upostcode + ';' + vc.ucountry + '\n' : '')
		+ (vc.usite ? 'URL:' + vc.usite + '\n' : '')
		+ (vc.uemail ? 'EMAIL;TYPE=INTERNET:' + vc.uemail + '\n' : '')
		+ (vc.ucats ? 'CATEGORIES:' + vc.ucats + '\n' : '')
		+ (vc.unote ? 'NOTE:' + vc.unote + '\n' : '')
		+ (vc.urev ? 'NOTE:' + vc.urev + '\n' : '')
		+ (vc.uid ? 'UID:' + vc.uid + '\n' : '')
		+ 'END:VCARD';
	opt.qrcode
		.empty()
		.qrcode({
			'text': vcard,
			'color': opt.color ? opt.color : '#000000',
			'size': opt.width ? opt.width : 160,
			'height': opt.width ? opt.width : 220
		});
	if (opt.show_personal == 0)
		opt.personal.empty().hide();
	else
		opt.personal.html(
			'<ul>'
			+ '<li class="user_name odd first">' + vc.ufname + ' ' + vc.ulname + '</li>'
			+ (vc.ucompany ? '<li class="user_company even">' + vc.ucompany + '</li>' : '')
			+ (vc.uphone ? '<li class="user_phone odd">' + vc.uphone + '</li>' : '')
			+ (vc.uemail ? '<li class="user_email even"><a href="mailto:' + vc.uemail + '">' + vc.uemail + '</a></li>' : '')
			+ (vc.usite ? '<li class="user_site odd"><a href="' + vc.usite + '" target="_blank">' + vc.usite + '</a></li>' : '')
			+ '</ul>'
		).show();
}
