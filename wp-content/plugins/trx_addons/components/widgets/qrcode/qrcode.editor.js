/**
 * Widget Instagram
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.47
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {
	"use strict";

	jQuery( window ).on( 'elementor:init', function() {
		elementor.hooks.addAction( 'panel/open_editor/widget/trx_widget_qrcode', function( panel, model, view ) {
			var $element = view.$el.find( '.elementor-selector' ),
				$panel = panel.$el.find( '#elementor-controls' );
			if ( $panel.find('.qrcode_image').length ==0 ) {
				$panel.append('<div class="qrcode_image" style="display:none;"><img src="">');
			}

			trx_addons_elm_update_qrcode($panel);
			model.setSetting('image', $panel.find('.fld_image input').val());

			$panel.change (function (e) {
				trx_addons_elm_update_qrcode($panel);
				model.setSetting('image', $panel.find('.fld_image input').val());
			});
			jQuery('.fld_color').on('mouseup', function (e) {
				trx_addons_elm_update_qrcode($panel);
				model.setSetting('image', $panel.find('.fld_image input').val());
			});

			if (jQuery('.disabled input').length > 0) {
				jQuery('.disabled input').attr('disabled', true);
			}
		} );

	});

	function trx_addons_elm_update_qrcode(widget) {

		trx_addons_elm_show_qrcode(widget, {
				ufname:		widget.find('.fld_ufname input').val(),
				ulname:		widget.find('.fld_ulname input').val(),
				ucompany:	widget.find('.fld_ucompany input').val(),
				usite:		widget.find('.fld_usite input').val(),
				uemail:		widget.find('.fld_uemail input').val(),
				uphone:		widget.find('.fld_uphone input').val(),
				uaddr:		widget.find('.fld_uaddr input').val(),
				ucity:		widget.find('.fld_ucity input').val(),
				upostcode:	widget.find('.fld_upostcode input').val(),
				ucountry:	widget.find('.fld_ucountry input').val(),
				uid:		widget.find('.fld_uid input').val(),
				urev:		widget.find('.fld_urev input').val()
			},
			{
				qrcode: widget.find('.qrcode_image').eq(0),
				show_personal: widget.find('.fld_show_personal input').attr('checked')=='checked',
				color: widget.find('.fld_color input.wp-color-picker').val(),
				width: widget.find('.fld_width input').val()
			}
		);
		widget.find('.fld_image input').val(widget.find('.qrcode_image canvas').get(0).toDataURL('image/png'));
	}

	function trx_addons_elm_show_qrcode(widget, vc, opt) {
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
	}
})();