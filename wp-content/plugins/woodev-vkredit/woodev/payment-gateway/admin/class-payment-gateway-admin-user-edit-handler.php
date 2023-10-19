<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Woodev_Payment_Gateway_Admin_User_Edit_Handler' ) ) :

class Woodev_Payment_Gateway_Admin_User_Edit_Handler {
	
	private $plugin;
	
	private static $user_profile_tokenization_js_rendered = false;
	
	public function __construct( $plugin ) {

		$this->plugin      = $plugin;
		
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		
			add_action( 'show_user_profile', array( $this, 'add_user_profile_fields' ) );
			add_action( 'edit_user_profile', array( $this, 'add_user_profile_fields' ) );
			
			add_action( 'personal_options_update',  array( $this, 'save_user_profile_fields' ) );
			add_action( 'edit_user_profile_update', array( $this, 'save_user_profile_fields' ) );
		}
	}
	
	public function add_user_profile_fields( $user ) {
	
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$customer_id_user_meta_names = array();
		
		foreach ( $this->get_plugin()->get_gateways() as $gateway ) {

			if ( ! $gateway->is_enabled() ) {
				continue;
			}

			ob_start();

			if ( $this->get_plugin()->supports( Woodev_Payment_Gateway_Plugin::FEATURE_CUSTOMER_ID ) ) {
				$customer_id_user_meta_name = $gateway->get_customer_id_user_meta_name();
				
				if ( $customer_id_user_meta_name && ! in_array( $customer_id_user_meta_name, $customer_id_user_meta_names ) ) {
					$this->maybe_add_user_profile_customer_id_fields( $gateway, $user );
					$customer_id_user_meta_names[] = $customer_id_user_meta_name;
				}
			}

			if ( $gateway->supports_tokenization() ) {
				$this->maybe_add_user_profile_tokenization_fields( $gateway, $user );
			}
			
			$this->add_custom_user_profile_fields( $gateway, $user );

			$fields = ob_get_clean();

			if ( $fields ) {
				echo '<h3>' . sprintf( '%s Данные клиента', $gateway->get_method_title() ) . '</h3>';
				echo $fields;
			}
		}
	}
	
	public function save_user_profile_fields( $user_id ) {
		
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$customer_id_user_meta_names = array();
		
		foreach ( $this->get_plugin()->get_gateways() as $gateway ) {

			if ( $this->get_plugin()->supports( Woodev_Payment_Gateway_Plugin::FEATURE_CUSTOMER_ID ) ) {
				$customer_id_user_meta_name = $gateway->get_customer_id_user_meta_name();
				
				if ( $customer_id_user_meta_name && ! in_array( $customer_id_user_meta_name, $customer_id_user_meta_names ) ) {
					$this->save_user_profile_customer_id_fields( $gateway, $user_id );
					$customer_id_user_meta_names[] = $customer_id_user_meta_name;
				}
			}

			if ( $gateway->supports_tokenization() ) {
				$this->save_user_profile_tokenization_fields( $gateway, $user_id );
			}
			
			$this->save_custom_user_profile_fields( $gateway, $user_id );

		}
	}
	
	protected function add_custom_user_profile_fields( $gateway, $user ) {}
	
	protected function save_custom_user_profile_fields( $gateway, $user_id ) {}
	
	protected function maybe_add_user_profile_customer_id_fields( $gateway, $user ) {

		$environments = $gateway->get_environments();

		?>
		<table class="form-table">
		<?php

		foreach ( $environments as $environment_id => $environment_name ) :

			?>
				<tr>
					<th><label for="<?php printf( '_wc_%s_customer_id_%s', $gateway->get_id(), $environment_id ); ?>"><?php echo count( $environments ) > 1 ? sprintf( 'ID клиента (%s)', $environment_name ) : 'ID клиента'; ?></label></th>
					<td>
						<input type="text" name="<?php printf( '_wc_%s_customer_id_%s', $gateway->get_id(), $environment_id ); ?>" value="<?php echo esc_attr( $gateway->get_customer_id( $user->ID, array( 'environment_id' => $environment_id, 'autocreate' => false ) ) ); ?>" class="regular-text" /><br/>
						<span class="description"><?php echo count( $environments ) > 1 ? sprintf( 'Шлюз ID покупателя для пользователя в среде %s. Редактируйте это только при необходимости.', $environment_name ) : 'Шлюз ID покупателя для пльзователя. Редактируйте это только при необходимости.'; ?></span>
					</td>
				</tr>
			<?php

		endforeach;

		?>
		</table>
		<?php
	}
	
	protected function save_user_profile_customer_id_fields( $gateway, $user_id ) {

		$environments = $gateway->get_environments();
		
		foreach ( array_keys( $environments ) as $environment_id ) {
		
			if ( isset( $_POST[ '_wc_' . $gateway->get_id() . '_customer_id_' . $environment_id ] ) ) {
				$gateway->update_customer_id( $user_id, trim( $_POST[ '_wc_' . $gateway->get_id() . '_customer_id_' . $environment_id ] ), $environment_id );
			}

		}
	}
	
	protected function maybe_add_user_profile_tokenization_fields( $gateway, $user ) {
	
		if ( $gateway->tokenization_enabled() && ! $gateway->get_api()->supports_get_tokenized_payment_methods() ) {

			$environments = $gateway->get_environments();

			foreach ( $environments as $environment_id => $environment_name ) :
			
				$payment_tokens = $gateway->get_payment_tokens( $user->ID, array( 'environment_id' => $environment_id ) );

				?>

				<table class="form-table">
					<tr>
						<th style="padding-bottom:0px;"><?php echo ( count( $environments ) > 1 ? sprintf( '%s Токены оплаты', $environment_name ) : 'Токены оплаты' ); ?></th>
						<td style="padding-bottom:0px;">
							<?php
							if ( empty( $payment_tokens ) ):
								echo "<p>Этот покупатель не сохранял токены оплаты</p>";
							else:
								?>
								<ul style="margin:0;">
									<?php
									foreach ( $payment_tokens as $token ) :

										?>
											<li>
												<?php echo $token->get_token(); ?> (<?php printf( '%s заканчивается на %s истекает %s', $token->get_type_full(), $token->get_last_four(), $token->get_exp_month() . '/' . $token->get_exp_year() ); echo ( $token->is_default() ? ' <strong>Карта по умолчанию</strong>' : '' ); ?>)
												<a href="#" class="js-woodev-payment-token-delete" data-payment_token="<?php echo $token->get_token(); ?>">Удалить</a>
											</li>
										<?php

									endforeach; ?>
								</ul>
								<input type="hidden" class="js-woodev-payment-tokens-deleted" name="wc_<?php echo $gateway->get_id(); ?>_payment_tokens_deleted_<?php echo $environment_id; ?>" value="" />
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th style="padding-top:0px;">Добавить платёжный токен</th>
						<td style="padding-top:0px;">
							<input type="text" name="wc_<?php echo $gateway->get_id(); ?>_payment_token_<?php echo $environment_id; ?>" placeholder="Токен" style="width:145px;" />
							<?php if ( $gateway->supports( Woodev_Payment_Gateway::FEATURE_CARD_TYPES ) ) : ?>
								<select name="wc_<?php echo $gateway->get_id(); ?>_payment_token_type_<?php echo $environment_id; ?>">
									<option value="">Тип карты</option>
									<?php
									foreach ( $gateway->get_card_types() as $card_type ) :
										$card_type = strtolower( $card_type );
										?>
										<option value="<?php echo esc_attr( $card_type ); ?>"><?php echo esc_html( Woodev_Payment_Gateway_Helper::payment_type_to_name( $card_type ) ); ?></option>
										<?php
									endforeach;
									?>
								</select>
							<?php endif; ?>
							<input type="text" name="wc_<?php echo $gateway->get_id(); ?>_payment_token_last_four_<?php echo $environment_id; ?>" placeholder="<?php printf( 'Последние 4 цифры', substr( date( 'Y' ) + 1, -2 ) ); ?>" style="width:75px;" />
							<input type="text" name="wc_<?php echo $gateway->get_id(); ?>_payment_token_exp_date_<?php echo $environment_id; ?>" placeholder="<?php printf( 'Дата окончания', date( 'Y' ) + 1 ); ?>" style="width:155px;" />
							<br/>
							<span class="description"><?php echo apply_filters( 'wc_payment_gateway_' . $gateway->get_id() . '_user_profile_add_token_description', '', $gateway, $user ); ?></span>
						</td>
					</tr>
				</table>
				<?php
			endforeach;

			$this->maybe_add_user_profile_tokenization_fields_js();
		}

	}
	
	protected function maybe_add_user_profile_tokenization_fields_js() {

		if ( ! self::$user_profile_tokenization_js_rendered ) : ?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					$( '.js-woodev-payment-token-delete' ).click( function() {

						if ( ! confirm( 'Вы уверены, что хотите это сделать? Изменение не будет завершено, пока вы не нажмете «Обновить»' ) ) {
							return false;
						}

						var $deleted_tokens = $( this ).closest( 'table' ).find( '.js-woodev-payment-tokens-deleted' );
						$deleted_tokens.val( $( this ).data( 'payment_token' ) + ',' + $deleted_tokens.val() );
						$( this ).closest( 'li' ).remove();

						return false;
					} );
				} );
			</script>
			<?php
			self::$user_profile_tokenization_js_rendered = true;
		endif;
	}
	
	protected function save_user_profile_tokenization_fields( $gateway, $user_id ) {

		foreach ( array_keys( $gateway->get_environments() ) as $environment_id ) {
		
			$payment_tokens_deleted_name = 'wc_' . $gateway->get_id() . '_payment_tokens_deleted_' . $environment_id;
			$delete_payment_tokens = Woodev_Helper::get_post( $payment_tokens_deleted_name ) ? explode( ',', trim( Woodev_Helper::get_post( $payment_tokens_deleted_name ), ',' ) ) : array();
			
			foreach ( $delete_payment_tokens as $token ) {
				$gateway->remove_payment_token( $user_id, $token, $environment_id );
			}
			
			$payment_token_name = 'wc_' . $gateway->get_id() . '_payment_token_' . $environment_id;

			if ( Woodev_Helper::get_post( $payment_token_name ) ) {

				$exp_date = explode( '/', Woodev_Helper::get_post( 'wc_' . $gateway->get_id() . '_payment_token_exp_date_' . $environment_id ) );
				
				$gateway->add_payment_token(
					$user_id,
					$gateway->build_payment_token(
						Woodev_Helper::get_post( $payment_token_name ),
						array(
							'type'      => $gateway->is_credit_card_gateway() ? 'credit_card' : 'check',
							'card_type' => Woodev_Helper::get_post( 'wc_' . $gateway->get_id() . '_payment_token_type_' . $environment_id ),
							'last_four' => Woodev_Helper::get_post( 'wc_' . $gateway->get_id() . '_payment_token_last_four_' . $environment_id ),
							'exp_month' => count( $exp_date ) > 1 ? sprintf( '%02s', $exp_date[0] ) : null,
							'exp_year'  => count( $exp_date ) > 1 ? $exp_date[1] : null,
						)
					)
				);
			}
		}

	}
	
	protected function get_plugin() {
		return $this->plugin;
	}

}

endif;