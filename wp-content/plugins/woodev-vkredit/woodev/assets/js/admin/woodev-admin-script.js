'use strict';

var WoodevAdmin = window.WoodevAdmin || ( function( document, window, $ ) {

	var app = {
		
		init: function() {
			$( document ).ready( app.ready );
		},
		
		ready: function() {
			
			jconfirm.defaults = {
				closeIcon: true,
				backgroundDismiss: true,
				escapeKey: true,
				animationBounce: 1,
				useBootstrap: false,
				theme: 'modern',
				boxWidth: '450px',
				animateFromElement: false
			};
			
			app.events();
		},
		
		events: function() {
			app.clickEvents();
		},
		
		clickEvents: function() {

			$( document.body ).on(
				'click change keyup',
				'.woodev-licence-need .woocommerce-save-button, :input.woodev-modal',
				function( event ) {

					event.preventDefault();
					event.stopImmediatePropagation();
					
					app.licenseModal();
				}
			);
		},
		
		licenseModal: function() {

			$.confirm( {
				title  : false,
				icon   : 'fa fa-exclamation-triangle',
				type   : 'red',
				content: function() {
					var $self = this;
					
					$self.showLoading( true );
					
					$.post( woodev_admin_strings.admin_url, {
						action: 'woodev_verify_license',
						nonce: woodev_admin_strings.admin_nonce
					}, function( data ) {
						if( data.data ) {
							$self.setContent( data.data );
						} else {
							$self.setContent( woodev_admin_strings.load_error_text );
						}
						
						$self.hideLoading( true );
					} );
					
				},
				buttons: {
					confirm: {
						text    : woodev_admin_strings.enter_license,
						btnClass: 'btn-confirm',
						keys    : [ 'enter' ],
						action: function(){
							window.open( woodev_admin_strings.license_page_url );
						}
					},
					cancel : {
						text: woodev_admin_strings.close
					}
				}
			} );
		}
	};
	
	return app;

}( document, window, jQuery ) );

WoodevAdmin.init();