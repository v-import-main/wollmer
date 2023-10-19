<tr valign="top" id="promo_codes">
	<th scope="row" class="titledesc">Промокоды</th>
	<td class="forminp">
		<style type="text/css">
			.promo_codes td {
				vertical-align: middle;
				padding: 4px 7px;
			}
			.promo_codes tr.new {
				background-color:#fbf0f2;
			}
			.promo_codes tr.empty-promo td {
				padding: 9px 7px;
				background-color:#fbf0f2;
			}
			.promo_codes th {
				padding: 9px 7px;
			}
			.promo_codes td input {
				margin-right: 4px;
			}
			.promo_codes .check-column {
				vertical-align: middle;
				text-align: left;
				padding: 0 7px;
			}
		</style>
		<table class="promo_codes widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" /></th>
					<th>Название</th>
					<th>Код</th>
					<th>Включено</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th colspan="4">
						<a href="#" class="button plus insert">Добавить код</a>
						<a href="#" class="button minus remove">Удалить выделеные</a>
					</th>
				</tr>
			</tfoot>
			<tbody id="codes">
				<?php
					
					$promo_codes = $this->get_option( 'promo_codes', array() );
					
					if ( $promo_codes ) {
						foreach ( $promo_codes as $key => $promo ) {
							if ( ! is_numeric( $key ) )
								continue;
							?>
							<tr>
								<td class="check-column"><input type="checkbox" /></td>
								<td><input type="text" size="35" name="promo_name[<?php echo $key; ?>]" value="<?php echo esc_attr( $promo['name'] ); ?>" /></td>
								<td><input type="text" name="promo_code[<?php echo $key; ?>]" value="<?php echo esc_attr( $promo['code'] ); ?>" /></td>
								<td><input type="checkbox" name="promo_enabled[<?php echo $key; ?>]" <?php checked( $promo['enabled'], true ); ?> /></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="empty-promo">
							<td colspan="4"><center>Вы ещё не добавли ни одного промокода. Будет использоваться значение по-умолчанию.</center></td>
						</tr>
						<?php
					}
				?>
			</tbody>
			<script type="text/javascript">

				jQuery(window).load(function(){

					jQuery('.promo_codes .insert').click( function() {
						var $tbody = jQuery('.promo_codes').find('tbody');
						var size = $tbody.find('tr').size();
						var code = '<tr class="new">\
								<td class="check-column"><input type="checkbox" /></td>\
								<td><input type="text" size="35" name="promo_name[' + size + ']" /></td>\
								<td><input type="text" name="promo_code[' + size + ']" /></td>\
								<td><input type="checkbox" name="promo_enabled[' + size + ']" checked="checked" /></td>\
							</tr>';

						$tbody.append( code );
						
						$tbody.find( '.empty-promo' ).remove();

						return false;
					} );

					jQuery('.promo_codes .remove').click(function() {
						var $tbody = jQuery('.promo_codes').find('tbody');

						$tbody.find('.check-column input:checked').each(function() {
							//jQuery(this).closest('tr').hide().find('input').val('');
							jQuery( this ).closest('tr').remove();
						});
						
						if( $tbody.find( 'tr' ).length == 0 ) {
							$tbody.append( [
								'<tr class="empty-promo">',
								'<td colspan="4">',
								'<center>Вы удалили все промокоды. Если вы сохраните изменения, то будет использоваться значение по-умолчанию.</center>',
								'</td>',
								'</tr>'
							].join( '' ) );
						}

						return false;
					});

				});

			</script>
		</table>
	</td>
</tr>