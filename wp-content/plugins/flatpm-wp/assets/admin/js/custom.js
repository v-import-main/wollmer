jQuery( function($){
	var family = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',
		body = $('body'),
		list_color = [ '#fff', '#d87a87', '#f0f2f5', '#81C06D', '#2188ab', '#5face5', '#82be4e', '#a585d5' ],
		stat_color = [ '#3A416F', '#e91e63', '#a585d5', '#2188ab', '#5face5', '#82be4e', '#81C06D', '#d87a87' ],
		fragment = document.createDocumentFragment(),
		xpathExclude = [
			'!>',
			'!',
			'!^',
			'!~',
			'!+',
			':after(',
			':after-sibling(',
			':before(',
			':before-sibling(',
			':contains(',
			':icontains(',
			':starts-with(',
			':istarts-with(',
			':ends-with(',
			':iends-with(',
			':first(',
			':has(',
			':has-sibling(',
		],
		search_timeout;

	function is_selector_valid( selector ){
		var bool = false,
			xpath = '';

		xpathExclude.forEach( function(el){
			if( selector.includes( el ) ){
				bool = true;
				xpath = css2xpath( selector );

				return;
			}
		} );

		if( bool ){
			try{ document.evaluate( xpath, document, null, XPathResult.ANY_TYPE, null ) }
			catch{ return false }
			return true;
		}else{
			try{ fragment.querySelector( selector ) }
			catch{ return false }
			return true;
		}
	}

	window.data_not_saved = false;

	document.onkeydown = function(e){
		var form_submit_button = $('.flat_pm_wrap form:not([id^="tab-"]) [type="submit"].btn-large, .flat_pm_wrap form[id^="tab-"].active [type="submit"].btn-large');

		if( form_submit_button.length > 0 ){
			if(
				( e.keyCode == 83 && e.altKey ) ||
				( e.keyCode == 83 && e.ctrlKey )
			){
				e.preventDefault();

				form_submit_button.trigger( 'click' );

				return false;
			}
		}
	}

	if( $('.coloris').length > 0 ){
		Coloris( {
			el: '.coloris',
			alpha: true,
			swatches: [ '#264653', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51', '#d62828', '#023e8a', '#0077b6', '#0096c7', '#00b4d8', '#48cae4' ]
		} );
	}

	$('.list .item canvas').each( function(){
		var i = 0,
			that = $(this),
			labels = that.data('labels'),
			values = that.data('values') || [[]],
			datasets = values.map( function( el ) {
				var data = {
					label: el.label,
					tension: 0,
					borderWidth: 0,
					pointRadius: 5,
					pointBackgroundColor: list_color[i],
					pointBorderColor: 'transparent',
					borderColor: list_color[i],
					borderWidth: 4,
					backgroundColor: 'transparent',
					fill: true,
					data: el.values,
				};

				i++;

				return data;
			} );



		new Chart( this.getContext('2d'), {
			type: 'line',
			maintainAspectRatio: false,
			data: {
				labels: labels,
				datasets: datasets,
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					}
				},
				interaction: {
					intersect: false,
					mode: 'index',
				},
				scales: {
					y: {
						grid: {
							drawBorder: false,
							display: true,
							drawOnChartArea: true,
							drawTicks: false,
							borderDash: [6, 6],
							color: 'rgba(255, 255, 255, .2)'
						},
						ticks: {
							display: true,
							color: 'rgba(255, 255, 255, .8)',
							padding: 15,
							font: {
								size: 10,
								weight: 300,
								family: family,
								style: 'normal',
								lineHeight: 2
							},
						}
					},
					x: {
						grid: {
							drawBorder: false,
							display: false,
							drawOnChartArea: false,
							drawTicks: false,
							borderDash: [6, 6]
						},
						ticks: {
							display: true,
							color: 'rgba(255, 255, 255, .8)',
							padding: 5,
							font: {
								size: 10,
								weight: 300,
								family: family,
								style: 'normal',
								lineHeight: 2
							},
						}
					},
				},
			},
		} );
	} );

	$('.statistics-chart canvas').each( function(){
		var i = 0,
			that = $(this),
			labels = that.data('labels'),
			values = that.data('values') || [[]],
			datasets = values.map( function( el ) {
				var data = {
					label: el.label,
					tension: 0,
					pointRadius: 5,
					pointBackgroundColor: stat_color[i],
					pointBorderColor: "transparent",
					borderColor: stat_color[i],
					borderWidth: 4,
					backgroundColor: "transparent",
					fill: true,
					data: el.values,
					maxBarThickness: 6
				};

				i++;

				return data;
			} );



		new Chart( this.getContext('2d'), {
			type: 'line',
			data: {
				labels: labels,
				datasets: datasets,
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: false,
					}
				},
				interaction: {
					intersect: false,
					mode: 'index',
				},
				scales: {
					y: {
						grid: {
							drawBorder: false,
							display: true,
							drawOnChartArea: true,
							drawTicks: false,
							borderDash: [5, 5],
							color: '#c1c4ce5c'
						},
						ticks: {
							display: true,
							padding: 10,
							color: '#9ca2b7',
							font: {
								size: 14,
								weight: 300,
								family: family,
								style: 'normal',
								lineHeight: 2
							},
						}
					},
					x: {
						grid: {
							drawBorder: false,
							display: true,
							drawOnChartArea: true,
							drawTicks: true,
							borderDash: [5, 5],
							color: '#c1c4ce5c'
						},
						ticks: {
							display: true,
							color: '#9ca2b7',
							padding: 10,
							font: {
								size: 14,
								weight: 300,
								family: family,
								style: 'normal',
								lineHeight: 2
							},
						}
					},
				},
			},
		} );
	} );





	$( ".table-schedule tbody" ).each( function(){
		var that = $(this),
			sheetData = that.data( 'sheetdata' ),
			parent = that.closest( 'li' ),
			input_class = '[name="user[schedule][value]"]',
			input = parent.find( input_class );

		if( sheetData ){
			sheetData = sheetData.map( function( el ){
				return ( '0'.repeat(24) + ( parseInt( el, 16 ) ).toString(2) ).substr(-24).split('').map( function(x){
					return parseInt( x, 10 );
				} );
			} );
		}else{
			sheetData = [
				[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
				[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
			];
		}

		that.TimeSheet( {
			data: {
				dimensions: [ 7,24 ],
				colHead: [
					{ name:"00" },{ name:"01" },{ name:"02" },{ name:"03" },{ name:"04" },{ name:"05" },{ name:"06" },{ name:"07" },
					{ name:"08" },{ name:"09" },{ name:"10" },{ name:"11" },{ name:"12" },{ name:"13" },{ name:"14" },{ name:"15" },
					{ name:"16" },{ name:"17" },{ name:"18" },{ name:"19" },{ name:"20" },{ name:"21" },{ name:"22" },{ name:"23" }
				],
				rowHead: [
					{ name: fpm_l10n.datepicker.weekdaysShort[1] },
					{ name: fpm_l10n.datepicker.weekdaysShort[2] },
					{ name: fpm_l10n.datepicker.weekdaysShort[3] },
					{ name: fpm_l10n.datepicker.weekdaysShort[4] },
					{ name: fpm_l10n.datepicker.weekdaysShort[5] },
					{ name: fpm_l10n.datepicker.weekdaysShort[6] },
					{ name: fpm_l10n.datepicker.weekdaysShort[0] }
				],
				sheetHead: { name: '' },
				sheetData: sheetData
			},
			input: input_class
		} );
	} );




	function update_checked_item_count(){
		$('[data-select-count]').attr( 'data-select-count', $('[name="checked-item"]:checked').length );
	}




	function update_tab_fpm_disabled( that ){
		var that = $(that),
			parent = that.closest( '.row' );

		parent.find( '[name*="[n]"], [name*="[m]"], [name*="[exclude]"], [name*="[start]"], [name*="[max]"]' ).addClass( 'fpm_disabled' );

		if( [ 'percent_once', 'percent_iterable', 'center', 'symbol_once', 'symbol_iterable', 'px_once', 'px_iterable' ].includes( that.val() ) ){
			parent.find( '[name*="[exclude]"], [name*="[m]"]' ).removeClass( 'fpm_disabled' );
		}
		if( [ 'percent_once', 'percent_iterable', 'symbol_once', 'symbol_iterable', 'px_once', 'px_iterable' ].includes( that.val() ) ){
			parent.find( '[name*="[n]"]' ).removeClass( 'fpm_disabled' );
		}
		if( [ 'percent_iterable', 'symbol_iterable', 'px_iterable' ].includes( that.val() ) ){
			parent.find( '[name*="[start]"], [name*="[max]"]' ).removeClass( 'fpm_disabled' );
		}
	}

	$('#tab-view [name="view[pixels][type]"]:checked, #tab-view [name="view[symbols][type]"]:checked').each( function(){
		update_tab_fpm_disabled( this );
	} );




	window['call_reorder_blocks'] = function(){
		var list = $('.list .item'),
			items = [];

		list.each( function(){
			var that = $(this),
				order = 1 + that.index(),
				id = that.attr( 'data-block-id' );

			items.push( {
				id: id,
				order: order
			} );
		} );

		flat_pm_ajax_handler( { meta: {
			method: 'update_order',
			items: items,
			_wpnonce: $('#_wpnonce').val(),
			_wp_http_referer: $('#_wp_http_referer').val()
		} } );
	}




	function download_export( content, filename ){
		var data = 'data:text/json;charset=utf-8,' + encodeURIComponent( JSON.stringify( content ) ),
			a = document.createElement('a');

		a.setAttribute( 'href', data );
		a.setAttribute( 'download', filename + '.json' );
		document.body.appendChild( a );
		a.click();
		a.remove();
	}




	function update_selector_input(){
		var that = $(this),
			parent = that.closest( '.row' ),
			input = parent.find( 'input[name*="[selector]"]' ),
			xpath = parent.find( 'input[name*="[xpath]"]' ),
			n = parent.find( 'input[name*="[n]"]' ),
			insert_type = that.closest( '.collapsible-body' ).find( 'input[name*="[insert_type]"]' );

		if( that.val() == '' ) return;

		input.val( that.val() );

		xpath.val( css2xpath( that.val() ) );

		if( [ 'html', 'head', 'body', '.fpm_start', '.fpm_end' ].includes( that.val() ) ){
			n.prop( 'disabled', true );
			n.val( '1' );
		}else{
			n.prop( 'disabled', false );
		}

		insert_type.prop( 'disabled', true );

		if( [ 'html', 'head', 'body' ].includes( that.val() ) ){
			insert_type.eq( 2 ).prop( 'disabled', false );
			insert_type.eq( 3 ).prop( 'disabled', false );
		}else
		if( [ '.fpm_start', '.fpm_end' ].includes( that.val() ) ){
			insert_type.eq( 0 ).prop( 'disabled', false );
			insert_type.eq( 1 ).prop( 'disabled', false );
		}else{
			insert_type.prop( 'disabled', false );
		}

		if( that.closest( '.collapsible-body' ).find( 'input[name*="[insert_type]"]:not(:disabled):checked' ).length == 0 ){
			that.closest( '.collapsible-body' ).find( 'input[name*="[insert_type]"]:not(:disabled):eq(0)' ).prop( 'checked', true );
		}

		M.updateTextFields();
	}




	function update_selector_select(){
		var that = $(this),
			parent = that.closest( '.row' ),
			select = parent.find( 'select' ),
			xpath = parent.find( 'input[name*="[xpath]"]' ),
			n = parent.find( 'input[name*="[n]"]' ),
			options = Array.prototype.map.call( select.find( 'option' ), function(el){ return el.value } ),
			insert_type = that.closest( '.collapsible-body' ).find( 'input[name*="[insert_type]"]' );

		if( options.includes( that.val() ) ){
			select.val( that.val() ).formSelect();
		}else{
			select.val( '' ).formSelect();
		}

		xpath.val( css2xpath( that.val() ) );

		if( [ 'html', 'head', 'body', '.fpm_start', '.fpm_end' ].includes( that.val() ) ){
			n.prop( 'disabled', true );
			n.val( '1' );
		}else{
			n.prop( 'disabled', false );
		}

		insert_type.prop( 'disabled', true );

		if( [ 'html', 'head', 'body' ].includes( that.val() ) ){
			insert_type.eq( 2 ).prop( 'disabled', false );
			insert_type.eq( 3 ).prop( 'disabled', false );
		}else
		if( [ '.fpm_start', '.fpm_end' ].includes( that.val() ) ){
			insert_type.eq( 0 ).prop( 'disabled', false );
			insert_type.eq( 1 ).prop( 'disabled', false );
		}else{
			insert_type.prop( 'disabled', false );
		}

		if( that.closest( '.collapsible-body' ).find( 'input[name*="[insert_type]"]:not(:disabled):checked' ).length == 0 ){
			that.closest( '.collapsible-body' ).find( 'input[name*="[insert_type]"]:not(:disabled):eq(0)' ).prop( 'checked', true );
		}

		M.updateTextFields();
	}

	$('[name="view[once][selector]"], [name="view[iterable][selector]"]').each( update_selector_select );




	function update_ad_preloader_attr(){
		var value = $(this).val(),
			datas = $( '[data-preloader-type]' );

		datas.each( function(){
			$(this).attr( 'data-preloader-text', value );
		} );
	}

	$('[name="flat_pm_stylization[ad_preloader][text]"]').each( update_ad_preloader_attr );




	function update_ad_preloader_vars(){
		var that = $(this),
			value = that.val(),
			parent = that.parent().parent().parent().css( {
				'--data-preloader-background': $('[name="flat_pm_stylization[ad_preloader][background]"]').val(),
				'--data-preloader-color': $('[name="flat_pm_stylization[ad_preloader][color]"]').val(),
			} );
	}

	$('[name="flat_pm_stylization[ad_preloader][background]"], [name="flat_pm_stylization[ad_preloader][color]"]').each( update_ad_preloader_vars );




	function buildInputObject( arr, val ){
		if( arr.length < 1 )
			return val;

		var objkey = arr[0];

		if( objkey.slice( -1 ) == "]" ){
			objkey = objkey.slice(0,-1);
		}

		var result = {};

		if( arr.length == 1 ){
			result[objkey] = val;
		}else{
			arr.shift();
			result[objkey] = buildInputObject( arr, val );
		}

		return result;
	}

	window['flat_pm_ajax_handler'] = function( data, param, url ){
		data = data || {};
		param = param || {}

		url = url || ajax_url_flat_pm || '/wp-admin/admin-ajax.php';

		$.ajax( {
			type: 'POST',
			url: url,
			dataType: 'json',
			data: {
				action: param.action || 'flat_pm_admin',
				data_me: data
			},
			success: function( res ){
				switch( res.method ) {
					case 'settings_update':
					case 'header_footer_update':
					case 'blacklist_ip_update':
					case 'css_editor_update':
						window.data_not_saved = false;

						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						break;

					case 'block_update':
						window.data_not_saved = false;

						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						if( res.data.action && res.data.action === 'insert' ){
							document.location.href = base_url_flat_pm + '/wp-admin/admin.php?page=fpm_blocks&id=' + res.data.id;
						}

						break;

					case 'folder_update':
						window.data_not_saved = false;

						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						if( res.data.action && res.data.action === 'insert' ){

							if( res.data.html !== '' ){
								var html = $( res.data.html );

								if( !disabled_tooltip_flat_pm )
									html.find( '.tooltipped' ).tooltip();

								if( $('[data-folder-id="999999999"]').length === 0 ){
									$('.folders .folder:last-of-type').after( html );
								}else{
									$('.folders .folder:last-of-type').before( html );
								}

								$('[id="select-folder"]').append( '<option value="' + res.data.id + '">' + res.data.name + '</option>' ).formSelect();
							}

						}else{
							var folder = $('.folders .folder[data-folder-id="' + res.data.id + '"]' );

							folder.find( '.name' ).text( res.data.name );
							folder.find( '.filtered' ).remove();

							if( res.data.turned === 'true' ){
								folder.find( '.icon' ).prepend( '<span class="filtered">filter</span>' );
							}
						}

						break;

					case 'block_geo_role_ip':
						$('.your_country').text( res.data.country );
						$('.your_city').text( res.data.city );
						$('.your_isp').text( res.data.isp );

						break;

					case 'update_order':
					case 'block_activate':
					case 'update_unfold':
						break;

					case 'block_delete':
						if( res.data.ids && Array.isArray( res.data.ids ) ){
							if( $('.main.block_update').length > 0 ){
								document.location.href = base_url_flat_pm + '/wp-admin/admin.php?page=fpm_blocks';
							}else{
								res.data.ids.forEach( function(el){
									$('.item[data-block-id="' + el + '"]').remove();
								} );

								window.call_reorder_blocks();
							}
						}

						break;

					case 'search_taxonomy':
					case 'search_publish':

						param.extended_list.removeClass( 'ajax-spin-holder' );

						if( res.data.status && res.data.status == 'error' ){
							M.toast( {
								html: res.data.message,
								classes: res.data.status
							} );

							break;
						}

						$.each( res.data, function(){
							var is_done = window['search-modal-list'].find( 'input[value="' + this.id + '"]' ).length > 0;
								li = `
							<li class="collection-item` + ( ( is_done ) ? ' done' : '' ) + `">
								<input type="hidden" name="content[${window['search-modal-list'].data( 'type' )}][${this.type}][${this.id}]" value="${this.id}">

								<span class="title">${this.title}</span>
								<span class="post_type">${this.label}</span>

								<button type="button" class="add-item btn btn-small btn-floating right white z-depth-0 waves-effect">
									<i class="material-icons" style="color:#81C06D!important">` + ( ( is_done ) ? 'done' : 'add' ) + `</i>
								</button>
							</li>`;

							param.extended_list.append( li );
						} );

						var add_all = param.extended_list.closest( '.modal-content' ).find( '.add_all' );

						if( res.data.length > 3 ){
							add_all.addClass( 'active' );
						}else{
							add_all.removeClass( 'active' );
						}

						break;

					case 'update_license':
						window.data_not_saved = false;
						param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						setTimeout( function(){
							document.location.reload();
						}, 1000 )

						break;

					case 'migration_process':
						param.that.removeClass( param.name );

						if( res.data.status == 'success' ){
							$( 'li[data-id="' + res.data.id + '"]' ).attr( 'data-process', 'yes' );

							if( res.data.done ){
								param.that.find( 'b' ).text( res.data.message );
								$('.migration_process .progress .determinate').css( { width: '100%' } );
							}else{
								param.that.click();
							}
						}

						break;

					case 'move_to_folder':
						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						if( res.data.ids ){
							res.data.ids.forEach( function(el){
								var that = $('.list .item[data-block-id="' + el + '"]'),
									folders_name = that.find( '.folders_name span' );

								if( res.data.folder ){
									var new_name = $('.folder[data-folder-id="' + res.data.folder + '"] .name').text();

									that.attr( 'data-folder', '[' + res.data.folder + ']' );
									that.data( 'folder', [ res.data.folder ] );

									if( folders_name.length === 0 ){
										that.find( '.controls--title' ).before( '<span class="folders_name"><i class="material-icons">folder</i> <span></span></span>' );

										folders_name = that.find( '.folders_name span' );
									}

									folders_name.text( new_name );
								}else{
									folders_name.parent().remove();
								}
							} );

							fpm_sort_blocks();
						}

						break;

					case 'block_copy':
						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						if( res.data.output ){
							res.data.output.forEach( function(el){
								var that = $('.list .item[data-block-id="' + el.old + '"]'),
									clone = $( that.clone().prop( 'outerHTML' ).replaceAll( el.old, el.new ) );

								if( !disabled_tooltip_flat_pm )
									clone.find( '.tooltipped' ).tooltip();

								clone.find( '.controls--title' ).text( el.name );

								$('.list').append( clone );
							} );

							fpm_sort_blocks();

							window.call_reorder_blocks();
						}

						break;

					case 'folder_rename':
						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						if( res.data.id ){
							$('.folder[data-folder-id="' + res.data.id + '"] .name').text( res.data.name );
							$('.item[data-folder*="' + res.data.id + '"] .folders_name span').text( res.data.name );
							$('#select-folder option[value="' + res.data.id + '"]').text( res.data.name );

							$('[id="select-folder"]').formSelect();

							var urlParams = new URLSearchParams( window.location.search );

							if( $('[value="folder_update"]').length > 0 && urlParams.get( 'folder' ) == res.data.id ){
								$('#block-name').val( res.data.name );
							}
						}

						break;

					case 'folder_delete':
						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						if( res.data.ids ){
							var active = $('.folders .folder.active');

							res.data.ids.forEach( function(el){
								if( active.attr( 'data-folder-id' ) == el ){
									active.removeClass( 'active' );

									$('[data-folder-id="all"]').addClass( 'active' );

									fpm_sort_blocks();
								}

								$('.folder[data-folder-id="' + el + '"]').remove();

								$('[id="select-folder"] option[value="' + el + '"]').remove();

								$('[id="select-folder"]').formSelect();
							} );

							var urlParams = new URLSearchParams( window.location.search );

							if( $('[value="folder_update"]').length > 0 && res.data.ids.includes( urlParams.get( 'folder' ) ) ){
								document.location.href = base_url_flat_pm + '/wp-admin/admin.php?page=fpm_blocks';
							}
						}

						break;

					case 'copy_to_folder':
						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						if( res.data.output ){
							res.data.output.forEach( function(el){
								var that = $('.list .item[data-block-id="' + el.old + '"]'),
									clone = $( that.clone().prop( 'outerHTML' )
										.replaceAll( el.old, el.new )
										.replaceAll( '[' + el.oldfolder + ']', '[' + res.data.folder + ']' )
									),
									folders_name = clone.find( '.folders_name span' );

								if( !disabled_tooltip_flat_pm )
									clone.find( '.tooltipped' ).tooltip();

								clone.find( '.controls--title' ).text( el.name );

								if( folders_name.length === 0 ){
									that.find( '.controls--title' ).before( '<span class="folders_name"><i class="material-icons">folder</i> <span></span></span>' );

									folders_name = that.find( '.folders_name span' );
								}

								folders_name.text( $('.folder[data-folder-id="' + res.data.folder + '"] .name').text() );

								$('.list').append( clone );
							} );

							fpm_sort_blocks();

							window.call_reorder_blocks();
						}

						break;

					case 'clear_all_html':
						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						break;

					case 'import':
						window.data_not_saved = false;

						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						break;

					case 'export':
						window.data_not_saved = false;

						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						var date = new Date(),
							dd = String( date.getDate() ).padStart( 2, '0' ),
							mm = String( date.getMonth() + 1 ).padStart( 2, '0' ),
							yyyy = date.getFullYear();

						if( res.data.data ){
							download_export( res.data.data, window.location.hostname + '_' + mm + '-' + dd + '-' + yyyy );
						}

						break;

					default:
						param.that && param.that.removeClass( param.name );

						M.toast( {
							html: res.data.message,
							classes: res.data.status
						} );

						break;
				}
			},
			error: function( error ){
				param.that.removeClass( param.name );
				console.log( 'ajax error:' ), console.error( 'php script returned error, response:', error );

				M.toast( {
					html: '<i class="material-icons">close</i> ' + fpm_l10n.other.php_error,
					classes: 'error'
				} );
			}
		} );
	}

	function fpm_setCookie( name, value, options ){
		options = options || {};

		options = {
			path: '/',
			...options
		};

		if( options.expires instanceof Date ){
			options.expires = options.expires.toUTCString();
		}

		var updatedCookie = encodeURIComponent( name ) + "=" + encodeURIComponent( value );

		for( var optionKey in options ){
			updatedCookie += "; " + optionKey;

			var optionValue = options[ optionKey ];

			if( optionValue !== true ){
				updatedCookie += "=" + optionValue;
			}
		}

		document.cookie = updatedCookie;
	}

	function fpm_change_form(e){
		window.data_not_saved = true;
	}

	function fpm_submit_form(e){
		e.preventDefault();

		var form = $(this),
			name = 'ajax-spin-holder',
			that = form.find( '[type="submit"]' ),
			inputs = form.find( '[name]:not([type="radio"]), [type="radio"]:checked' ),
			errors = false,
			data = {};

		if( that.hasClass( name ) ){
			return;
		}

		data.meta = {};

		inputs.each( function(){
			var input = $(this),
				val = ( input.is( ':checkbox' ) ) ? input.prop( 'checked' ) : input.val();

			$.extend( true, data.meta, buildInputObject( input.attr('name').split( "[" ), val ) );

			if( input.is('.invalid') ) errors = true;
		} );

		if( errors ){
			return;
		}

		that.addClass( name );

		e.preventDefault();

		flat_pm_ajax_handler( data, { that: that, name: name } );
	}

	function migration_process(e){
		e.preventDefault();

		var form = $(this),
			name = 'ajax-spin-holder',
			that = form.find( '[type="submit"]' ),
			inputs = form.find( '[name]:not([type="radio"]), [type="radio"]:checked' ),
			li_all = form.find( 'li[data-process]' ),
			li_yes = form.find( 'li[data-process="yes"]' ),
			li_no = form.find( 'li[data-process="no"]' ),
			errors = false,
			data = {};

		if(
			that.hasClass( name ) ||
			li_all.length <= 0 ||
			li_all.length - li_yes.length <= 0
		){
			return;
		}

		data.meta = {
			li_all: li_all.length,
			li_yes: li_yes.length,
			li_no: li_no.length,
			li_current: {
				type: li_no.eq(0).attr( 'data-type' ),
				id: li_no.eq(0).attr( 'data-id' ),
				xpath: li_no.eq(0).attr( 'data-xpath' ),
				order: li_no.eq(0).attr( 'data-order' ),
			}
		};

		inputs.each( function(){
			var input = $(this),
				val = ( input.is( ':checkbox' ) ) ? input.prop( 'checked' ) : input.val();

			$.extend( true, data.meta, buildInputObject( input.attr('name').split( "[" ), val ) );

			if( input.is('.invalid') ) errors = true;
		} );

		if( errors ){
			return;
		}

		that.addClass( name );

		e.preventDefault();

		$('.migration_process .progress .determinate').css( { width: ( 100 / li_all.length * li_yes.length ).toFixed(2) + '%' } );

		flat_pm_ajax_handler( data, { that: that, name: name } );
	}




	function import_process(e){
		e.preventDefault();

		var form = $(this),
			name = 'ajax-spin-holder',
			that = form.find( '[type="submit"]' ),
			inputs = form.find( '[name]:not([type="radio"]), [type="radio"]:checked' ),
			json = form.find( '[name="import[json]"]' ),
			errors = false,
			data = {};

		if( that.hasClass( name ) ){
			return;
		}

		data.meta = {};

		inputs.each( function(){
			var input = $(this),
				val = ( input.is( ':checkbox' ) ) ? input.prop( 'checked' ) : input.val();

			$.extend( true, data.meta, buildInputObject( input.attr('name').split( "[" ), val ) );

			if( input.is('.invalid') ) errors = true;
		} );

		if( json.val() === '' ){
			M.toast( {
				html: '<i class="material-icons">close</i> ' + fpm_l10n.other.empty_export,
				classes: 'error'
			} );

			errors = true;
		}

		console.log(data);

		if( errors ){
			return;
		}

		that.addClass( name );

		e.preventDefault();

		flat_pm_ajax_handler( data, { that: that, name: name, bar: $('#tab-import .progress .determinate') } );
	}




	if( $('.your_country').length > 0 || $('.your_city').length > 0 ){
		flat_pm_ajax_handler( { meta: { method: 'block_geo_role_ip' } }, { action: 'flat_pm_ajax' } );
	}



	function min_max_resolutions_update( that ){
		var container = that.closest( '.sub_block' ),
			minwidth = container.find( '[name*="[minwidth]"]' ).val() || 0,
			maxwidth = container.find( '[name*="[maxwidth]"]' ).val() || 99999999;

		container.find( '.mobile' ).toggleClass( 'active', ( minwidth <= 320 && maxwidth >= 425 ) );
		container.find( '.tablet' ).toggleClass( 'active', ( minwidth <= 426 && maxwidth >= 768 ) );
		container.find( '.laptop' ).toggleClass( 'active', ( minwidth <= 769 && maxwidth >= 1024 ) );
		container.find( '.desktop' ).toggleClass( 'active', ( maxwidth >= 1025 ) );
	}

	$('[name*="[minwidth]').each( function(){
		min_max_resolutions_update( $(this) );
	} );



	function update_fst_mode(){
		var that = $('input#fast'),
			list = $('[name^="view["][name$="][enabled]"]:not([name*="[once]"])');

		if( that.prop( 'checked' ) ){
			list.prop( 'checked', false );
			list.prop( 'disabled', true );
		}else{
			list.prop( 'disabled', false );
		}

		$('#tab-view .switch label input[type=checkbox]').each( function(){
			update_badge( this );
		} );
	}

	if( $('input#fast').length > 0 ){
		update_fst_mode();
	}



	function fpm_check_select_notempty(){
		var that = $(this),
			val = that.val(),
			parent = that.parent();

		if( ( Array.isArray( val ) && val.length == 0 ) || val == 'all' ){
			parent.removeClass( 'notempty' );
		}else{
			parent.addClass( 'notempty' );
		}
	}



	function fpm_sort_blocks(){
		try{
			var devices = $('#select-device').val(),
				filters = $('#select-filter').val(),
				types   = $('#select-types').val(),
				status  = $('#select-status').val(),
				folder  = $('.folders .folder.active').attr( 'data-folder-id' ),
				items   = $('.list .item'),
				code    = $('#search_code').val().toLowerCase(),
				some = false;

			items.addClass( 'hidden' );

			items.each( function(){
				var that = $(this);

				if(
					( folder === 'all' || that.data( 'folder' ).includes( 1 * folder ) ) &&
					( status === 'all' || that.data( 'status' ).includes( status ) ) &&
					( types.length === 0 || types.some( function( el ){ return that.data( 'types' ).includes( el ); } ) ) &&
					( devices.length === 0 || devices.some( function( el ){ return that.data( 'devices' ).includes( el ); } ) ) &&
					( filters.length === 0 || filters.some( function( el ){ return that.data( 'filters' ).includes( el ); } ) ) &&
					( code === '' || that.data( 'code' ).toLowerCase().includes( code ) )
				){
					that.removeClass( 'hidden' );

					some = true;
				}else{
					that.addClass( 'hidden' );
				}
			} );

			if( some ){
				$('.empty-list').addClass( 'hidden' );
			}else{
				$('.empty-list').removeClass( 'hidden' );
			}

			fpm_setCookie( 'fpm_filters', JSON.stringify( { device: devices, filter: filters, types: types, status: status } ) );
		}catch(e){
			console.log(e);
		}
	}



	function update_badge(e){
		var that = $( ( e.target ) ? e.target : e ),
			item = that.closest('li'),
			badge = item.find('.badge'),
			header = item.find('.collapsible-header');

		if( that.prop( 'checked' ) ){
			badge.addClass('active');
		}else{
			badge.removeClass('active');
		}

		if( that.prop( 'disabled' ) ){
			badge.addClass('disabled');
			header.addClass('disabled');
		}else{
			badge.removeClass('disabled');
			header.removeClass('disabled');
		}
	}

	$('#tab-user .switch label input[type=checkbox], #tab-view .switch label input[type=checkbox]').each( function(){
		update_badge( this );
	} );




	if( $('[value="create_block"], [value="update_folder"], [value="create_block"]').length != 0 ){
		var title = $('title'),
			tmp_title = title.text().split( '‹' ),
			old_title,
			block_name = $('#block-name').val() || fpm_l10n.other.untitled;

		tmp_title[0] = block_name + ' ‹ ' + $('main .container h1').text();

		old_title = tmp_title.join( ' ‹ ' );
		title.text( old_title );

		body.on( 'input', '#block-name', function(){
			var that = $(this),
				value = that.val();

			if( value.length > 0 ){
				$('title').text( value );
			}else{
				$('title').text( old_title );
			}
		} );
	}




	$('li[data-selector]').each( function(){
		var that = $(this),
			selector = that.attr( 'data-selector' );

		that.attr( 'data-xpath', css2xpath( selector ) );
	} );





	$('.flat_pm_wrap .collapsible').collapsible();
	$('.flat_pm_wrap .collapsible.expandable').collapsible( {
		accordion: false
	} );

	$('.flat_pm_wrap .sidenav').sidenav( {
		edge: 'right'
	} );

	var $tabs = $('.flat_pm_wrap .tabs').tabs();

	if( !disabled_tooltip_flat_pm )
		$('.tooltipped').tooltip();

	$('.materialboxed:not(.aligncenter)').materialbox();
	$('article.content [class*="wp-image"]:not(.aligncenter)').materialbox();

	$('.flat_pm_wrap .modal').modal();

	$('.flat_pm_wrap .parallax').parallax();

	$('nav.navbar .dropdown-trigger').dropdown( {
		alignment: 'right',
		constrainWidth: !1,
		coverTrigger: !1,
		closeOnClick: !1
	} );

	$('.input-field select').formSelect();


	if( $('.create-new').length > 0 ){
		fpm_sort_blocks();

		body.on( 'click', '.folder .icon', function(){
			$('.folder').removeClass( 'active' );

			$('input#checked-item_all').prop( 'checked', false );
			$('[name="checked-item"]').prop( 'checked', false );

			update_checked_item_count();

			$(this).closest( '.folder' ).addClass( 'active' );

			fpm_sort_blocks();
		} );

		$('#select-device, #select-filter, #select-types, #select-status').each( fpm_check_select_notempty );
	}else{
		body.on( 'click', '.folder .icon', function(){
			document.location.href = $(this).closest( '.folder' ).attr( 'data-href' );
		} );
	}


	var $timepicker = $('.timepicker').timepicker( {
		twelveHour: false,
		i18n: fpm_l10n.timepicker
	} );

	var $datepicker = $('.datepicker').datepicker( {
		firstDay: 1,
		format: 'dd-mm-yyyy',
		autoClose: true,
		yearRange: 5,
		i18n: fpm_l10n.datepicker
	} );

	body

	.on( 'change', 'input#checked-item_all', function(){
		$('.list .item:not(.hidden) [name="checked-item"]').prop( 'checked', $(this).prop( 'checked' ) );

		update_checked_item_count();
	} )

	.on( 'change', '[name="checked-item"]', update_checked_item_count )

	.on( 'change', 'select#period', function(){
		var that = $(this),
			from = M.Datepicker.getInstance( $datepicker[0] ),
			to = M.Datepicker.getInstance( $datepicker[1] ),
			d = new Date();

		if( that.val() === 'week' ){
			from.setDate( new Date( d.setDate( d.getDate() - 7 ) ) );
			from.setInputValue();

			to.setDate( new Date() );
			to.setInputValue();
		}

		if( that.val() === '1month' ){
			from.setDate( new Date( d.setMonth( d.getMonth() - 1 ) ) );
			from.setInputValue();

			to.setDate( new Date() );
			to.setInputValue();
		}

		if( that.val() === '3month' ){
			from.setDate( new Date( d.setMonth( d.getMonth() - 3 ) ) );
			from.setInputValue();

			to.setDate( new Date() );
			to.setInputValue();
		}

		$('input#date-from, input#date-to').prop( 'disabled', that.val() !== 'other' );
	} )

	.on( 'change', '#tab-user .switch label input[type=checkbox], #tab-view .switch label input[type=checkbox]', update_badge )

	.on( 'click', '#tab-content .delete-item', function(){
		window.data_not_saved = true;

		$(this).closest('.collection-item').remove();
	} )

	.on( 'click', '#tab-content .delete-all', function(){
		window.data_not_saved = true;

		var that = $(this),
			parent = that.closest('.col'),
			list_items = parent.find('.collection-item');

		list_items.remove();
	} )

	.on( 'click', '#tab-content [data-target="search-publish-modal"], #tab-content [data-target="search-taxonomy-modal"]', function(){
		window.data_not_saved = true;

		var that = $(this),
			parent = that.closest('.col');

		window['search-modal-list'] = parent.find('.extended_list');
	} )

	.on( 'click', '.flat_pm_wrap [data-target="confirm-delete-block"]', function(){
		window['confirm-delete-block-id'] = [ $(this).closest('.item, .main.block_update').attr( 'data-block-id' ) ];
	} )

	.on( 'click', '.flat_pm_wrap [data-target="confirm-delete-folder"]', function(){
		window['confirm-delete-folder-id'] = [ $(this).closest('.folder').attr( 'data-folder-id' ) ];
	} )

	.on( 'click', '.flat_pm_wrap [data-target="confirm-rename-folder"]', function(){
		window['confirm-rename-folder-id'] = $(this).closest('.folder').attr( 'data-folder-id' );
	} )

	.on( 'click', '.extended_list .collection-item:not(.done) .add-item', function(){
		window.data_not_saved = true;

		var that = $(this),
			parent = that.closest('li'),
			clone = parent.clone( true );

		if( window['search-modal-list'] ){
			clone
				.find( '.add-item' )
					.removeClass( 'add-item' )
					.addClass( 'delete-item' )
				.find( 'i' )
					.text( 'block' )
					.attr( 'style', 'color:#d87a87!important' )
				.end().find( '.waves-ripple' )
					.remove();

			window['search-modal-list'].append( clone );

			parent.addClass( 'done' );
			that.find( 'i' ).text( 'done' );
		}
	} )

	.on( 'change', `#tab-view [name="view[pixels][type]"], #tab-view [name="view[symbols][type]"]`, function(){
		update_tab_fpm_disabled( this );
	} )

	.on( 'change', '[id="view[once][element]"], [id="view[iterable][element]"], #view_preroll_selector, #view_hoverroll_selector', update_selector_input )

	.on( 'change', '[name="view[once][selector]"], [name="view[iterable][selector]"]', update_selector_select )

	.on( 'click', '.add_subblock', function(){
		var sub_blocks = $( '.sub_block' ),
			last = sub_blocks.last(),
			next_id = [],
			clone;

		sub_blocks.each( function(){
			next_id.push( parseInt( $(this).find( 'input[name*="[id]"]' ).val() ) );
		} );

		next_id = Math.max( ...next_id ) + 1;

		clone = $( last.clone().prop( 'outerHTML' ).replaceAll(
			'[block][block_' + last.find( 'input[name*="[id]"]' ).val() + ']',
			'[block][block_' + next_id + ']'
		) );

		clone.find( 'input[name*="[id]"]' ).val( next_id );
		clone.find( 'input[name*="[turned]"]' ).prop( 'checked', true );
		clone.find( 'input[id*="[expand]"]' ).prop( 'checked', false );
		clone.find( 'textarea.default, input[type="text"], input[type="number"]' ).removeAttr( 'value' ).val( '' );
		clone.find( '[name*="[minwidth]"]' ).val( last.find( '[name*="[minwidth]"]' ).val() );
		clone.find( '[name*="[maxwidth]"]' ).val( last.find( '[name*="[maxwidth]"]' ).val() );
		clone.find( '.main-control' ).removeAttr( 'data-state' );
		clone.find( '.CodeMirror' ).remove();

		if( !disabled_tooltip_flat_pm )
			clone.find('.tooltipped').tooltip();

		$('#tab-html .list').append( clone );

		tinyMCEPreInit = {
			baseURL: base_url_flat_pm + '/wp-includes/js/tinymce',
			suffix: '.min',
			mceInit: {},
			qtInit: {
				[ 'html[block][block_' + next_id + '][html][code]' ]: {
						id: 'html[block][block_' + next_id + '][html][code]',
						buttons: 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close'
					},
				[ 'html[block][block_' + next_id + '][adb][code]' ]: {
						id: 'html[block][block_' + next_id + '][adb][code]',
						buttons: 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close'
					}
			},
			ref: {
				plugins: '',
				theme: 'modern',
				language: ''
			},
			load_ext: function( url,lang ){
				var sl = tinymce.ScriptLoader;

				sl.markDone( url + '/langs/' + lang + '.js' );
				sl.markDone( url + '/langs/' + lang + '_dlg.js' );
			}
		};

		var init, id, $wrap;

		if( typeof tinymce !== 'undefined' ){

			if( tinymce.Env.ie && tinymce.Env.ie < 11 ){
				tinymce.$( '.wp-editor-wrap ' ).removeClass( 'tmce-active' ).addClass( 'html-active' );
				return;
			}

			for( id in tinyMCEPreInit.mceInit ){
				init = tinyMCEPreInit.mceInit[id];

				$wrap = tinymce.$( '#wp-' + id + '-wrap' );

				if( ( $wrap.hasClass( 'tmce-active' ) || ! tinyMCEPreInit.qtInit.hasOwnProperty( id ) ) && ! init.wp_skip_init ){
					tinymce.init( init );
					if( !window.wpActiveEditor ){
						window.wpActiveEditor = id;
					}
				}
			}
		}

		if( typeof quicktags !== 'undefined' ){
			for( id in tinyMCEPreInit.qtInit ){
				quicktags( tinyMCEPreInit.qtInit[id] );

				if( !window.wpActiveEditor ){
					window.wpActiveEditor = id;
				}
			}
		}

		clone.find( 'textarea.default' ).each( function(){
			var textArea = this,
				editor = wp.codeEditor.initialize( textArea, {
					mode: 'xml',
					htmlMode: true,
					lineNumbers: true,
					lineWrapping: true,
					theme: 'material'
				} );

			editor.codemirror.on( 'change', function(){
				editor.codemirror.save();
				$( textArea ).trigger( 'flatpm_change' );
			} );

			$(textArea).on( 'change', function(){
				editor.codemirror.setValue( this.value );
				$( textArea ).trigger( 'flatpm_change' );
			} );
		} );
	} )

	.on( 'click', '.sub_block .delete_sub_block', function(){
		if( $('.sub_block').length <= 1 )
			return;

		$(this).closest('.sub_block').remove();
	} )

	.on( 'change', 'input#unfold', function(){
		flat_pm_ajax_handler( { meta: {
			method: 'update_unfold',
			flat_pm_unfold: $(this).prop( 'checked' ),
			_wpnonce: $('#_wpnonce').val(),
			_wp_http_referer: $('#_wp_http_referer').val()
		} } );
	} )

	.on( 'input', '[name="search-publish-query"]', function(){
		var that = $(this),
			post_types = [],
			post_types_inputs = $('[name*="content[post_types]"]:checked'),
			row = that.closest( '.row' ),
			extended_list = row.find( '.extended_list' );

		post_types_inputs.each( function(){
			var that = $(this);

			post_types.push( that.attr( 'name' ).split( '][' )[1].slice(0, -1) );
		} );

		clearTimeout( search_timeout );

		if( that.val() == '' ){
			extended_list.removeClass( 'ajax-spin-holder' );

			return;
		}

		extended_list.html( '' ).addClass( 'ajax-spin-holder' );

		search_timeout = setTimeout( function(){

			flat_pm_ajax_handler( {
				meta: {
					method: 'search_publish',
					post_types: post_types,
					query: that.val(),
					_wpnonce: $('#_wpnonce').val(),
					_wp_http_referer: $('#_wp_http_referer').val()
				}
			}, { extended_list: extended_list } );

		}, 1000 );
	} )

	.on( 'input', '[name="search-taxonomy-query"]', function(){
		var that = $(this),
			row = that.closest( '.row' ),
			extended_list = row.find( '.extended_list' );

		clearTimeout( search_timeout );

		if( that.val() == '' ){
			extended_list.removeClass( 'ajax-spin-holder' );

			return;
		}

		extended_list.html( '' ).addClass( 'ajax-spin-holder' );

		search_timeout = setTimeout( function(){

			flat_pm_ajax_handler( {
				meta: {
					method: 'search_taxonomy',
					query: that.val(),
					_wpnonce: $('#_wpnonce').val(),
					_wp_http_referer: $('#_wp_http_referer').val()
				}
			}, { extended_list: extended_list } );

		}, 1000 );
	} )

	.on( 'click', '#search-publish-modal .modal-close, #search-taxonomy-modal .modal-close', function(){
		var that = $(this),
			modal = that.closest( '.modal' );

		modal.find( 'textarea.default' ).val( '' );
		modal.find( '.extended_list' ).html( '' ).removeClass( 'ajax-spin-holder' );
	} )

	.on( 'click', '#search-publish-modal + .modal-overlay, #search-taxonomy-modal + .modal-overlay', function(){
		var that = $(this),
			modal = that.prev( '.modal' );

		modal.find( 'textarea.default' ).val( '' );
		modal.find( '.extended_list' ).html( '' ).removeClass( 'ajax-spin-holder' );
	} )

	.on( 'input', '#tab-html [name*="[minwidth]"], #tab-html [name*="[maxwidth]"]', function(){
		min_max_resolutions_update( $(this) );
	} )

	.on( 'click', '#tab-html .desktop, #tab-html .laptop, #tab-html .tablet, #tab-html .mobile', function(){
		var that = $(this),
			control = that.closest( '.main-control' ),
			state = control.attr( 'data-state' ) || 'first-click',
			minwidth = control.find( '[name*="[minwidth]"]' ),
			maxwidth = control.find( '[name*="[maxwidth]"]' );

		if( state == 'first-click' ){
			control.attr( 'data-state', 'second-click' );
			control.find( '.desktop, .laptop, .tablet, .mobile' ).removeClass( 'active' );
			that.addClass( 'active' );

			if( that.is( '.mobile' ) ){ minwidth.val( '' ); maxwidth.val( 425 ); }
			if( that.is( '.tablet' ) ){ minwidth.val( 426 ); maxwidth.val( 768 ); }
			if( that.is( '.laptop' ) ){ minwidth.val( 769 ); maxwidth.val( 1024 ); }
			if( that.is( '.desktop' ) ){ minwidth.val( 1025 ); maxwidth.val( '' ); }
		}

		if( state == 'second-click' ){
			control.attr( 'data-state', 'first-click' );

			var prev = control.find( 'button.active' ),
				indexs = [ prev.index(), that.index() ];

			if( indexs[0] < indexs[1] ){
				prev.nextUntil( that ).add( prev ).add( that ).addClass( 'active' );
			}

			if( indexs[0] > indexs[1] ){
				prev.prevUntil( that ).add( prev ).add( that ).addClass( 'active' );
			}

			indexs.sort( function(a, b){ return a - b; } );

			if( indexs[0] == 0 && indexs[1] == 1 ){ minwidth.val( '' ); maxwidth.val( 768 ); }
			if( indexs[0] == 1 && indexs[1] == 2 ){ minwidth.val( 426 ); maxwidth.val( 1024 ); }
			if( indexs[0] == 2 && indexs[1] == 3 ){ minwidth.val( 769 ); maxwidth.val( '' ); }
			if( indexs[0] == 0 && indexs[1] == 2 ){ minwidth.val( '' ); maxwidth.val( 1024 ); }
			if( indexs[0] == 1 && indexs[1] == 3 ){ minwidth.val( 426 ); maxwidth.val( '' ); }
			if( indexs[0] == 0 && indexs[1] == 3 ){ minwidth.val( '' ); maxwidth.val( '' ); }
		}
	} )

	.on( 'change', '#tab-html .main-control [name*="turned"]', function(){
		$('[name="turned"]').prop( 'checked', $('#tab-html .main-control [name*="turned"]:checked').length > 0 );
	} )

	.on( 'change', '[name="turned"]', function(){
		var that = $(this),
			sub = $('#tab-html .main-control [name*="turned"]');

		if( that.prop( 'checked' ) == true && sub.length == 1 ){
			sub.prop( 'checked', true );
		}
	} )

	.on( 'click', '.modal .confirm-delete-block', function(){
		flat_pm_ajax_handler( {
			meta: {
				method: 'block_delete',
				ids: window['confirm-delete-block-id'],
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'click', '.modal .confirm-move-to-folder', function(){
		flat_pm_ajax_handler( {
			meta: {
				method: 'move_to_folder',
				ids: window['confirm-move-to-folder-id'],
				folder: $(this).closest('.modal').find('select').val(),
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'click', '.list .item label.turn_off, .list .item label.turn_on', function(){
		var that = $(this),
			action = that.hasClass( 'turn_off' ) ? 'true' : 'false';

		flat_pm_ajax_handler( {
			meta: {
				method: 'block_activate',
				action: action,
				ids: [ that.closest( '.item' ).attr( 'data-block-id' ) ],
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'input', '[name="user[schedule][value]"]', function(){
		var that = $(this),
			value = that.val(),
			output;

		output = JSON.parse( value ).map( function( el ){
			return parseInt( el.join(''), 2 ).toString(16).toUpperCase();
		} );

		that.val( JSON.stringify( output ) );
	} )

	.on( 'click', '.action.input-field.col .btn', function(e){
		e.preventDefault();

		var that = $(this),
			items = $('.list .item input[id^="checked-item"]:checked').closest( '.item' ),
			action = that.closest( '.action' ).find( 'select' ).val(),
			ids = [];

		items.each( function(){
			ids.push( $(this).attr( 'data-block-id' ) );
		} );

		if( action == 'statistics-on' ){
			items.find( '[name="statistics"]' ).prop( 'checked', true );
		}

		if( action == 'statistics-off' ){
			items.find( '[name="statistics"]' ).prop( 'checked', false );
		}

		if( action == 'move-to-folder' ){
			window['confirm-move-to-folder-id'] = ids;

			var instance = M.Modal.getInstance( document.querySelector('#confirm-move-to-folder') );

			instance.open();
		}

		if( action == 'activate' ){
			items.find( '[name="turned"]' ).prop( 'checked', true );

			flat_pm_ajax_handler( {
				meta: {
					method: 'block_activate',
					action: true,
					ids: ids,
					_wpnonce: $('#_wpnonce').val(),
					_wp_http_referer: $('#_wp_http_referer').val()
				}
			} );
		}

		if( action == 'deactivate' ){
			items.find( '[name="turned"]' ).prop( 'checked', false );

			flat_pm_ajax_handler( {
				meta: {
					method: 'block_activate',
					action: false,
					ids: ids,
					_wpnonce: $('#_wpnonce').val(),
					_wp_http_referer: $('#_wp_http_referer').val()
				}
			} );
		}

		if( action == 'copy' ){
			flat_pm_ajax_handler( {
				meta: {
					method: 'block_copy',
					ids: ids,
					_wpnonce: $('#_wpnonce').val(),
					_wp_http_referer: $('#_wp_http_referer').val()
				}
			} );
		}

		if( action == 'delete' ){
			items.remove();

			flat_pm_ajax_handler( {
				meta: {
					method: 'block_delete',
					ids: ids,
					_wpnonce: $('#_wpnonce').val(),
					_wp_http_referer: $('#_wp_http_referer').val()
				}
			} );
		}

		if( action == 'copy_to_folder' ){
			window['confirm-copy-to-folder'] = ids;

			var instance = M.Modal.getInstance( document.querySelector('#confirm-copy-to-folder') );

			instance.open();
		}
	} )

	.on( 'click', '.confirm-copy-to-folder', function(){
		flat_pm_ajax_handler( {
			meta: {
				method: 'copy_to_folder',
				ids: window['confirm-copy-to-folder'],
				folder: $(this).closest('.modal').find('select').val(),
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'click', '[id^="search-"][id$="-modal"] .add_all button', function(e){
		e.preventDefault();

		var that = $(this),
			buttons = that.closest( '.modal-content' ).find( '.add-item' );

		buttons.each( function(){
			$(this).trigger( 'click' );
		} );
	} )

	.on( 'input', '#search_code', fpm_sort_blocks )

	.on( 'change', '#select-device, #select-filter, #select-types, #select-status', fpm_sort_blocks )

	.on( 'change', '#select-device, #select-filter, #select-types, #select-status', fpm_check_select_notempty )

	.on( 'click', '.main-control .copy', function(){
		var that = $(this),
			id = that.closest( '.item' ).attr( 'data-block-id' );

		flat_pm_ajax_handler( {
			meta: {
				method: 'block_copy',
				action: false,
				ids: [id],
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'change', '.list .item .abgroup', function(){
		var that = $(this),
			id = that.closest( '.item' ).attr( 'data-block-id' ),
			abgroup = that.val();

		flat_pm_ajax_handler( {
			meta: {
				method: 'block_abgroup',
				id: id,
				abgroup: abgroup,
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'click', '.modal .confirm-rename-folder', function(){
		var that = $(this),
			name = that.closest( '.modal' ).find( '[name="name"]' ).val();

		flat_pm_ajax_handler( {
			meta: {
				method: 'folder_rename',
				id: window['confirm-rename-folder-id'],
				name: name,
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'click', '.modal .confirm-delete-folder', function(){
		flat_pm_ajax_handler( {
			meta: {
				method: 'folder_delete',
				ids: window['confirm-delete-folder-id'],
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'click', '.modal .confirm-create-folder', function(){
		var that = $(this),
			name = that.closest( '.modal' ).find( '[name="name"]' ).val();

		flat_pm_ajax_handler( {
			meta: {
				method: 'folder_update',
				name: name,
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'input', '[name="flat_pm_stylization[ad_preloader][text]"]', update_ad_preloader_attr )

	.on( 'input', '[name="flat_pm_stylization[ad_preloader][background]"], [name="flat_pm_stylization[ad_preloader][color]"]', update_ad_preloader_vars )

	.on( 'change', 'input#fast', function(){
		update_fst_mode();
	} )

	.on( 'click', '.main-control [name*="fast"] + label + label', function(e){
		e.preventDefault();

		var instance = M.Modal.getInstance( document.querySelector('#confirm-enable-fast-mode') );

		instance.open();
	} )

	.on( 'click', '.confirm-enable-fast-mode', function(){
		M.Tabs.getInstance( $tabs[0] ).select( 'tab-view' );

		$('#fast').prop( 'checked', true ).trigger( 'change' );
	} )

	.on( 'input change flatpm_change', '[name*="[html][code]"], [name*="[adb][code]"]', function(){
		var that = $(this),
			parent = that.closest( '.sub_block' ),
			html = parent.find( '[name*="[html][code]"]' ).val(),
			adb = parent.find( '[name*="[adb][code]"]' ).val();

		if( html === adb && html !== '' ){
			M.toast( {
				html: $('#same_code').attr( 'data-html' ),
				classes: 'notice'
			} );
		}
	} )

	.on( 'input change flatpm_change', '[name*="[html][code]"], [name*="[adb][code]"]', function(){
		if( ! window.master_rtb_once ){

			var that = $(this).val();

			if(
				that.includes( 'yaContextCb' ) &&
				( that.includes( 'topAd' ) || that.includes( 'floorAd' ) || that.includes( 'fullscreen' ) ) ||
				that.includes( 'metrika' )
			){
				window.master_rtb_once = true;

				var instance = M.Modal.getInstance( document.querySelector('#confirm-master-rtb-step-1') );

				instance.open();
			}
		}
	} )

	.on( 'change', 'input[id*="[more]"]', function(){
		var that = $(this);

		that.closest('.sub_block').find('input[id*="[more]"]').prop( 'checked', that.prop( 'checked' ) );
	} )

	.on( 'input', '#view_pixels_exclude, #view_symbols_exclude, #view_once_selector, #view_iterable_selector, #view_outgoing_action_selector, #view_preroll_selector, #view_hoverroll_selector, #view_vignette_exclude', function(){
		var that = $(this),
			value = that.val();

		if( value.length === 0 ){
			that.removeClass( 'invalid valid' );

			return;
		}

		if( is_selector_valid( value ) ){
			that.removeClass( 'invalid' ).addClass( 'valid' );
		}else{
			that.addClass( 'invalid' );

			M.toast( {
				html: $('#invalid-selector').attr( 'data-html' ),
				classes: 'error'
			} );
		}
	} )

	.on( 'click', '.create-new', function(e){
		e.preventDefault();

		var that = $(this),
			url = that.attr( 'href' ),
			folder = $('.folder.active');

		if( folder.length > 0 && folder.attr( 'data-folder-id' ) !== 'all' ){
			window.location.href = url + '&folder=' + parseInt( folder.attr( 'data-folder-id' ) );
		}else{
			window.location.href = url;
		}
	} )

	.on( 'click', '.clear_all_html', function(e){
		e.preventDefault();

		var instance = M.Modal.getInstance( document.querySelector('#confirm-clear-all-html') );

		instance.open();
	} )

	.on( 'click', '.confirm-clear-all-html', function(){
		flat_pm_ajax_handler( {
			meta: {
				method: 'clear_all_html',
				_wpnonce: $('#_wpnonce').val(),
				_wp_http_referer: $('#_wp_http_referer').val()
			}
		} );
	} )

	.on( 'click', '.quicktags-referer-toolbar button', function(e){
		e.preventDefault();

		var that = $(this),
			textarea = that.closest( '.col' ).find( 'textarea' ),
			value = textarea.val();

		if( textarea.val() === '' ){
			textarea.val( value + that.data( 'value' ) );
		}else{
			textarea.val( value + '\n' + that.data( 'value' ) );
		}
	} )

	.on( 'click', '.wp-core-ui .quicktags-toolbar input[id*="[code]_fpm_"]', function(e){
		e.preventDefault();
		e.stopPropagation();

		var that = $(this),
			type = that.attr( 'id' ).split( '_fpm_' )[1],
			modal = $( '#confirm-insert-' + type ),
			closest = that.closest( '[id*="-editor-container"]' );

		if( closest.length === 0 ){
			return;
		}

		window.popup_scope = closest;

		if( modal !== null ){
			M.Modal.getInstance( modal[0] ).open();
		}
	} )

	.on( 'click', '.confirm-add-more', function(e){
		e.preventDefault();

		var that = $(this),
			closest = that.closest( '.modal-content' ),
			container = closest.find( '.items' ),
			items = closest.find( '.item' ),
			first = items.first(),
			next_id = [],
			clone;

		items.each( function(){
			next_id.push( parseInt( $(this).attr( 'data-id' ) ) );
		} );

		next_id = Math.max( ...next_id ) + 1;

		clone = $( first.clone().prop( 'outerHTML' ).replaceAll(
			'block_' + first.attr( 'data-id' ),
			'block_' + next_id
		) );

		clone.find( 'textarea' ).val( '' );
		clone.attr( 'data-id', next_id );

		container.append( clone );
	} )

	.on( 'click', '.confirm-delete-item', function(e){
		e.preventDefault();

		var that = $(this),
			closest = that.closest( '.modal-content' ),
			items = closest.find( '.item' );

		if( items.length <= 1 ){
			return;
		}

		that.closest( '.item' ).remove();
	} )

	.on( 'input change', '#tab-view input:not([name^="view"][name$="[enabled]"]), #tab-view select, #tab-view textarea', function(){
		if( $('[name^="view"][name$="[enabled]"]:checked').length === 0 ){
			var that = $(this),
				closest = that.closest( 'li' ),
				lever = closest.find('[name^="view"][name$="[enabled]"]');

			lever.prop( 'checked', true );

			update_badge( lever[0] );
		}
	} )

	.on( 'click', '.copied', function(){
		var that = $(this);

		el = document.createElement('textarea');
		el.value = that.find('span').text();
		el.setAttribute( 'readonly', '' );
		el.style.position = 'absolute';
		el.style.left = '-9999px';
		document.body.appendChild( el );
		el.select();
		el.setSelectionRange( 0, 99999 );
		document.execCommand( 'copy' );
		document.body.removeChild( el );

		that.tooltip( { margin: -6 } );
		that.tooltip( 'open' );
	} )

	.on( 'mouseleave', '.copied', function(){
		var that = $(this);

		if( that.tooltip() ){
			that.tooltip( 'destroy' );
		}
	} )

	.on( 'change', '[name="export[blocks][enabled]"], [name="export[folders][enabled]"]', function(){
		var that = $(this),
			list = that.closest( 'p' ).next();

		list.toggleClass( 'active', function(){
			return that.prop( 'checked' );
		} );
	} )

	.on( 'click', '.expand-list .select_all', function(e){
		$(this).closest( '.expand-list' ).find( '[type="checkbox"]' ).prop( 'checked', true );
	} )

	.on( 'click', '.expand-list .cancel_all', function(e){
		$(this).closest( '.expand-list' ).find( '[type="checkbox"]' ).prop( 'checked', false );
	} )

	.on( 'change', '#tab-import [type="file"]', function(){
		var file = this.files[0];

		if( file ){
			var reader = new FileReader();

			reader.readAsText( file, 'UTF-8' );

			reader.onload = function(e){
				$('#tab-import [name="import[json]"]').val( e.target.result );
			}

			reader.onerror = function(e){
				M.toast( {
					html: '<i class="material-icons">close</i> ' + fpm_l10n.other.broken_file,
					classes: 'error'
				} );
			}
		}
	} )

	.on( 'click', '.clear_filters', function(){
		$('#select-device, #select-filter, #select-types').val( [] ).formSelect();

		$('#select-status').val( 'all' ).formSelect();

		$('#search_code').val( '' );

		fpm_sort_blocks();
	} )

	var forms_to_submit = [
		'.block_update',
		'.folder_update',
		'.update_license',
		'.settings_update',
		'.header_footer_update',
		'.blacklist_ip_update',
		'.css_editor_update',
		'#tab-export'
	];

	$( '#confirm-insert-image' ).submit( function(e){
		e.preventDefault();

		var url = $('#confirm-insert-image-url'),
			alt = $('#confirm-insert-image-alt').val(),
			width = $('#confirm-insert-image-width').val(),
			height = $('#confirm-insert-image-height').val(),
			textarea = window.popup_scope.find('textarea');

		if( url.hasClass( 'invalid' ) ){
			return;
		}

		if( alt != '' ){
			alt = ` alt="${alt}"`;
		}

		if( width != '' ){
			width = ` width="${width}"`;
		}

		if( height != '' ){
			height = ` height="${height}"`;
		}

		if( textarea ){
			if( textarea.val() != '' ){
				textarea.val( textarea.val() + '\n' );
			}

			textarea.val( textarea.val() + `<img src="${url.val()}"${alt}${width}${height}>` );

			textarea.trigger( 'change' );
		}
	} );

	$( '#confirm-insert-link' ).submit( function(e){
		e.preventDefault();

		var url = $('#confirm-insert-link-url'),
			text = $('#confirm-insert-link-text').val(),
			target = $('#confirm-insert-link-target').val(),
			rel = $('#confirm-insert-link-rel').val(),
			textarea = window.popup_scope.find('textarea');

		if( url.hasClass( 'invalid' ) ){
			return;
		}

		if( target != '' ){
			target = ` target="${target}"`;
		}

		if( rel.length > 0 ){
			rel = ` rel="${rel.join( ' ' )}"`;
		}

		if( textarea ){
			if( textarea.val() != '' ){
				textarea.val( textarea.val() + '\n' );
			}

			textarea.val( textarea.val() + `<a href="${url.val()}"${target}${rel}>${text}</a>` );

			textarea.trigger( 'change' );
		}
	} );

	$( '#confirm-insert-sticky' ).submit( function(e){
		e.preventDefault();

		var height = $('#confirm-insert-sticky-height').val() || 500,
			offset = $('#confirm-insert-sticky-offset').val() || 0,
			code = $('#confirm-insert-sticky-code').val(),
			textarea = window.popup_scope.find('textarea');

		if( textarea ){
			if( textarea.val() != '' ){
				textarea.val( textarea.val() + '\n' );
			}

			textarea.val( textarea.val() + `<div class="flatPM_sticky" data-height="${height}" data-top="${offset}">\n${code}\n</div>` );

			textarea.trigger( 'change' );
		}
	} );

	$( '#confirm-insert-sidebar' ).submit( function(e){
		e.preventDefault();

		var modal = $('#confirm-insert-sidebar'),
			items = modal.find( '.item' ),
			textarea = window.popup_scope.find('textarea'),
			output = '';

		items.each( function(){
			var that = $(this),
				offset = that.find( '[id*="confirm-insert-sidebar-offset"]' ).val(),
				code = that.find( '[id*="confirm-insert-sidebar-code"]' ).val();

			output += `<div class="flatPM_sidebar" data-top="${offset}">\n${code}\n</div>\n`;
		} );

		if( textarea ){
			if( textarea.val() != '' ){
				textarea.val( textarea.val() + '\n' );
			}

			textarea.val( textarea.val() + output );

			textarea.trigger( 'change' );
		}
	} );

	$( '#confirm-insert-slider' ).submit( function(e){
		e.preventDefault();

		var modal = $('#confirm-insert-slider'),
			items = modal.find( '.item' ),
			textarea = window.popup_scope.find('textarea'),
			output = '';

		items.each( function(){
			var that = $(this),
				timer = that.find( '[id*="confirm-insert-slider-timer"]' ).val() || 30,
				code = that.find( '[id*="confirm-insert-slider-code"]' ).val();

			output += `<div class="flatPM_slider" data-timer="${timer}">\n${code}\n</div>\n`;
		} );

		if( textarea ){
			if( textarea.val() != '' ){
				textarea.val( textarea.val() + '\n' );
			}

			textarea.val( textarea.val() + output );

			textarea.trigger( 'change' );
		}
	} );

	$( '#confirm-master-rtb-step-1' ).submit( function(e){
		e.preventDefault();

		var old = M.Modal.getInstance( document.querySelector('#confirm-master-rtb-step-1') );
		old.close();

		M.Tabs.getInstance( $tabs[0] ).select( 'tab-view' );

		$('#tab-view > ul.collapsible > li:eq(2) > .collapsible-header').trigger( 'click' );
		$('#tab-view > ul.collapsible > li:eq(2) [name*="[selector]"]').val( 'body' ).trigger( 'change' );
		$('#tab-view > ul.collapsible > li:eq(2) [name*="[document]"]').prop( 'checked', true );

		$('#tab-content [name*="[post_types]"]').prop( 'checked', true );
		$('#tab-content [name*="[templates]"]').prop( 'checked', true );

		var instance = M.Modal.getInstance( document.querySelector('#confirm-master-rtb-step-2') );
		instance.open();
	} );

	$( '#confirm-master-rtb-step-2' ).submit( function(e){
		e.preventDefault();

		var old = M.Modal.getInstance( document.querySelector('#confirm-master-rtb-step-2') );
		old.close();

		M.Tabs.getInstance( $tabs[0] ).select( 'tab-content' );

		var instance = M.Modal.getInstance( document.querySelector('#confirm-master-rtb-step-3') );
		instance.open();
	} );

	$( forms_to_submit.join() ).submit( fpm_submit_form );

	$( '.migration_process' ).submit( migration_process );

	$('#tab-import').submit( import_process );

	$( forms_to_submit.join() ).on( 'input change flatpm_change', 'input[name], select[name], textarea[name]', fpm_change_form );

	window.onbeforeunload = function() {
		if( window.data_not_saved ){
			return fpm_l10n.other.change_not_saved;
		}
	}

	if( typeof QTags !== 'undefined' ){
		QTags.addButton( 'fpm_image', fpm_l10n.other.image, '', '', 'w' );
		QTags.addButton( 'fpm_link', fpm_l10n.other.link, '', '', 'w' );
		QTags.addButton( 'fpm_sticky', fpm_l10n.other.sticky, '', '', 'w' );
		QTags.addButton( 'fpm_sidebar', fpm_l10n.other.sidebar, '', '', 'w' );
		QTags.addButton( 'fpm_slider', fpm_l10n.other.slider, '', '', 'w' );
	}

	M.updateTextFields();
} );