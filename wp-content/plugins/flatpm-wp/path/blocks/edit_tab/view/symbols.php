<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$id = sanitize_text_field( $_GET['id'] );
$view = get_post_meta( $id, 'view', true );

$symbols = $view['symbols'];
?>
<div class="collapsible-header">
	<b><?php _e( 'Based on symbols:', 'flatpm_l10n' ); ?></b>
	<span class="badge"></span>
</div>

<div class="collapsible-body">
	<div class="switch">
		<label>
			Off
			<input class="hidden" type="checkbox" name="view[symbols][enabled]" <?php if( $symbols['enabled'] === 'true') echo 'checked'; ?>>
			<span class="lever"></span>
			On
		</label>
	</div>

	<br>

	<div class="row">
		<div class="col s12">
			<p><?php _e( 'Insert type:', 'flatpm_l10n' ); ?></p>
		</div>

		<div class="col s12">
			<div style="display:flex;column-gap:40px;flex-wrap:wrap">
				<div style="display:flex;gap:15px;flex-wrap:wrap;flex-direction:column">
					<label>
						<input class="with-gap" name="view[symbols][type]" type="radio" value="percent_once" <?php checked( $symbols['type'], 'percent_once' ); ?>>
						<span><?php _e( 'Through percentage (%) characters', 'flatpm_l10n' ); ?></span>
					</label>
					<label>
						<input class="with-gap" name="view[symbols][type]" type="radio" value="percent_iterable" <?php checked( $symbols['type'], 'percent_iterable' ); ?>>
						<span><?php _e( 'Each percentage (%) of characters', 'flatpm_l10n' ); ?></span>
					</label>
					<label>
						<input class="with-gap" name="view[symbols][type]" type="radio" value="center" <?php checked( $symbols['type'], 'center' ); ?>>
						<span><?php _e( 'In the center of the article', 'flatpm_l10n' ); ?></span>
					</label>
				</div>

				<div style="display:flex;gap:15px;flex-wrap:wrap;flex-direction:column">
					<label>
						<input class="with-gap" name="view[symbols][type]" type="radio" value="symbol_once" <?php checked( $symbols['type'], 'symbol_once' ); ?>>
						<span><?php _e( 'Through N characters', 'flatpm_l10n' ); ?></span>
					</label>
					<label>
						<input class="with-gap" name="view[symbols][type]" type="radio" value="symbol_iterable" <?php checked( $symbols['type'], 'symbol_iterable' ); ?>>
						<span><?php _e( 'Every N characters', 'flatpm_l10n' ); ?></span>
					</label>
				</div>
			</div>
		</div>

		<div class="col s12">
			<p><?php _e( 'Settings:', 'flatpm_l10n' ); ?></p>
		</div>

		<div class="input-field col s12 l4 xl3">
			<input id="view_symbols_percent_n" type="number" class="validate fpm_disabled" min="0"
				step="1"
				name="view[symbols][n]"
				value="<?php echo esc_attr( $symbols['n'] ); ?>"
			>
			<label for="view_symbols_percent_n">
				<i class="material-icons tooltipped"
					data-position="bottom"
					data-tooltip="<?php esc_attr_e( 'The interval is defined in the number of characters (percentage or N)', 'flatpm_l10n' ); ?>"
				>info_outline</i>
				<?php _e( 'Percent or N', 'flatpm_l10n' ); ?>
			</label>
		</div>

		<div class="input-field col s12 l4 xl3">
			<input id="view_symbols_start" type="number" class="validate fpm_disabled" min="0"
				step="1"
				name="view[symbols][start]"
				value="<?php echo esc_attr( $symbols['start'] ); ?>"
			>
			<label for="view_symbols_start">
				<i class="material-icons tooltipped"
					data-position="bottom"
					data-tooltip="<?php esc_attr_e( 'From which iteration to start', 'flatpm_l10n' ); ?>"
				>info_outline</i>
				<?php _e( 'Start from', 'flatpm_l10n' ); ?>
			</label>
		</div>

		<div class="input-field col s12 l4 xl3 show-on-large" style="opacity:0;pointer-events:none;display:none">
			<input type="text">
		</div>

		<div class="input-field col s12 l4 xl3 show-on-xl" style="opacity:0;pointer-events:none;display:none">
			<input type="text">
		</div>

		<div class="input-field col s12 l4 xl3">
			<input id="view_symbols_max" type="number" class="validate fpm_disabled" min="0"
				step="1"
				name="view[symbols][max]"
				value="<?php echo esc_attr( $symbols['max'] ); ?>"
			>
			<label for="view_symbols_max">
				<i class="material-icons tooltipped"
					data-position="bottom"
					data-tooltip="<?php esc_attr_e( 'How many iterations there will be', 'flatpm_l10n' ); ?>"
				>info_outline</i>
				<?php _e( 'Iterations count', 'flatpm_l10n' ); ?>
			</label>
		</div>

		<div class="input-field col s12 l4 xl3">
			<input id="view_symbols_m" type="number" class="validate fpm_disabled" min="0"
				step="1"
				name="view[symbols][m]"
				value="<?php echo esc_attr( $symbols['m'] ); ?>"
			>
			<label for="view_symbols_m">
				<i class="material-icons tooltipped"
					data-position="bottom"
					data-tooltip="<?php esc_attr_e( 'If there are fewer characters between blocks than M, then the block will not be displayed', 'flatpm_l10n' ); ?>"
				>info_outline</i>
				<?php _e( 'Min. interval M', 'flatpm_l10n' ); ?>
			</label>
		</div>

		<div class="input-field col s12 l4 xl3 show-on-large" style="opacity:0;pointer-events:none;display:none">
			<input type="text">
		</div>

		<div class="input-field col s12 l4 xl3 show-on-xl" style="opacity:0;pointer-events:none;display:none">
			<input type="text">
		</div>

		<div class="input-field col s12 l8 xl6">
			<input id="view_symbols_exclude" type="text" class="fpm_disabled"
				name="view[symbols][exclude]"
				value="<?php echo esc_attr( $symbols['exclude'] ); ?>"
			>
			<label for="view_symbols_exclude">
				<i class="material-icons tooltipped"
					data-position="bottom"
					data-tooltip="<?php esc_attr_e( 'Selectors to be ignored on inserts. This is useful if you don\'t want ads to appear in blockquotes, lists or tables, default is:', 'flatpm_l10n' ); ?> <code>table *, blockquote *, ul *, ol *, a *, p *</code>"
				>info_outline</i>
				<?php _e( 'Exceptions', 'flatpm_l10n' ); ?>
			</label>
			<span class="helper-text" data-error="<?php esc_attr_e( 'Wrong selector', 'flatpm_l10n' ); ?>" data-success=""></span>
		</div>
	</div>
</div>