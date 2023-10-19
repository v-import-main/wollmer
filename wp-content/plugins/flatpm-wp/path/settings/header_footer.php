<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_header_footer = get_option( 'flat_pm_header_footer' );
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Header and footer inserting code', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<form class="main col s12 header_footer_update" style="padding-top:0">
		<input type="hidden" name="method" value="header_footer_update">

		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row">
			<div class="col s12 white">
				<div class="col s12 l6">
					<h5><?php _e( 'Code in', 'flatpm_l10n' ); ?> &lt;head&gt;</h5>

					<br>

					<div class="switch">
						<label>
							Off
							<input type="checkbox" name="flat_pm_header_footer[header_enabled]" <?php if( $flat_pm_header_footer['header_enabled'] === 'true' ) echo 'checked'; ?>>
							<span class="lever"></span>
							On
						</label>
					</div>

					<br>


					<textarea class="default" name="flat_pm_header_footer[header_code]" placeholder="<?php _e( 'Paste code here', 'flatpm_l10n' ); ?>" style="height:228px"><?php echo stripslashes( $flat_pm_header_footer['header_code'] ); ?></textarea>

					<br>

					<label>
						<input type="checkbox" name="flat_pm_header_footer[header_deffered]" <?php if( $flat_pm_header_footer['header_deffered'] === 'true' ) echo 'checked'; ?>>
						<span><?php _e( 'Defer the output of this code', 'flatpm_l10n' ); ?></span>
					</label>
				</div>
				<div class="col s12 l6">
					<h5><?php _e( 'Code before', 'flatpm_l10n' ); ?> &lt;/body&gt;</h5>

					<br>

					<div class="switch">
						<label>
							Off
							<input type="checkbox" name="flat_pm_header_footer[footer_enabled]" <?php if( $flat_pm_header_footer['footer_enabled'] === 'true' ) echo 'checked'; ?>>
							<span class="lever"></span>
							On
						</label>
					</div>

					<br>

					<textarea class="default" name="flat_pm_header_footer[footer_code]" placeholder="<?php _e( 'Paste code here', 'flatpm_l10n' ); ?>" style="height:228px"><?php echo stripslashes( $flat_pm_header_footer['footer_code'] ); ?></textarea>

					<br>

					<label>
						<input type="checkbox" name="flat_pm_header_footer[footer_deffered]" <?php if( $flat_pm_header_footer['footer_deffered'] === 'true' ) echo 'checked'; ?>>
						<span><?php _e( 'Defer the output of this code', 'flatpm_l10n' ); ?></span>
					</label>
				</div>

				<div class="row"></div>

				<div class="col s12">
					<?php _e( 'Do not use the deferred output option if the code contains the noscript tag or meta tags confirming the site ownership, for example:', 'flatpm_l10n' ); ?>
					<ol>
						<li>&lt;meta name=&quot;google-site-verification&quot;&gt;</li>
						<li>&lt;meta name=&quot;yandex-verification&quot;&gt;</li>
						<li>&lt;noscript&gt;&lt;/noscript&gt;</li>
					</ol>
					<?php _e( 'With this option enabled, they will not work.', 'flatpm_l10n' ); ?>
				</div>

				<div class="row"></div>
			</div>
		</div>

		<br>

		<div class="row">
			<button type="submit" class="btn btn-large waves-effect waves-light">
				<b><?php _e( 'Save settings', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>