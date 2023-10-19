<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_css = get_option( 'flat_pm_css' );
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Style editor', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row">
	<form class="main col s12 css_editor_update" style="padding-top:0">
		<input type="hidden" name="method" value="css_editor_update">
		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row">
			<div class="col s12 white" style="border-radius:10px">
				<div class="col s12 l6">
					<br>

					<textarea class="default" name="flat_pm_css" placeholder="<?php _e( 'Paste your custom css here', 'flatpm_l10n' ); ?>" style="min-height:500px"><?php echo stripslashes( $flat_pm_css ); ?></textarea>

					<ul class="collapsible" style="margin-bottom:0">
						<li>
							<div class="collapsible-header"><i class="material-icons right" style="margin-right:1rem">code</i> <?php _e( 'Usage examples:', 'flatpm_l10n' ); ?></div>
							<div class="collapsible-body" style="border-bottom:0;padding-bottom:0">
								<code style="width:100%">
<pre style="max-height:238px;overflow:auto;margin:5px 0;white-space:pre-wrap;width:100%">
<span style="color:#DECB6B">.fpm-slider .fpm-timeline</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for the timeline in the slider', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-slider</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for the slider', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-show</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for show class', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-hide</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for hide class', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-hoverroll</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for hoverroll block', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-preroll</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for preroll block', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-cross</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'cross stitch styles', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-timer</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'timer styles', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-stop</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for stop class in sticky sidebar', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-fixed</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for fixed class in sticky sidebar', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-overlay</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'popup background overlay styles', 'flatpm_l10n' ); ?> */</span>
}

[<span style="color:#FF5370">data-fpm-type</span>=<span style="color:#C3E88D">"outgoing"</span>]{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for outgoing blocks, including popup', 'flatpm_l10n' ); ?> */</span>
}

[<span style="color:#FF5370">data-fpm-status</span>]{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for blocks in different states, can take the value: "processing" and "complite"', 'flatpm_l10n' ); ?> */</span>
}

<span style="color:#DECB6B">.fpm-async</span>{
    <span style="color:#a2b5bf">/* <?php _e( 'styles for blocks of the async class, these are blocks that have restrictions on GEO, ISP, role or ip', 'flatpm_l10n' ); ?> */</span>
}
</pre>
								</code>
							</div>
						</li>
					</ul>

					<style>
					.cm-s-material.CodeMirror{min-height:500px!important}
					.wp-core-ui .CodeMirror-lint-marker-error,
					.wp-core-ui .CodeMirror-lint-marker-warning,
					.CodeMirror-lint-mark-warning{display:none}
					.collapsible-body{padding-bottom:0;padding-left:0;padding-right:0}
					</style>
				</div>
				<div class="col s12 l6">
					<p><?php _e( 'This style editor supports special variables. These variables are needed in order to prevent the adblock blocking the display of popups and overlay blocks.', 'flatpm_l10n' ); ?></p>
					<p><?php _e( 'Supported variables:', 'flatpm_l10n' ); ?></p>

					<div class="variables-list">
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-timeline</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-slider</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-show</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-hide</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-hoverroll</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-preroll</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-cross</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-timer</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-stop</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-fixed</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-overlay</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-type</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-status</span></button>
						<button type="button" class="btn btn-small waves-effect waves-light copied" data-position="top" data-tooltip="Скопировано"><span>fpm-async</span></button>
					</div>

					<br>

					<p><?php _e( 'More information can be found in the <a href="https://mehanoid.pro/flat-pm/faq-po-plaginu-flat-pm/" target="_blank">documentation</a>.', 'flatpm_l10n' ); ?></p>
				</div>

				<div class="row"></div>
			</div>
		</div>

		<br>

		<div class="row">
			<button type="submit" class="btn btn-large waves-effect waves-light" type="submit">
				<b><?php _e( 'Save settings', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>

	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>