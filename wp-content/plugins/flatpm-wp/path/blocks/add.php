<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flat_pm_pagespeed = get_option( 'flat_pm_pagespeed' );

$folder_id = ( isset( $_GET[ 'folder' ] ) ) ? sanitize_text_field( $_GET[ 'folder' ] ) : '';
?>
<main class="row">
	<div class="container col s12">
		<h1><?php _e( 'Add new block', 'flatpm_l10n' ); ?></h1>

		<?php echo flat_pm_get_pro_text(); ?>
	</div>
</main>

<div class="flat_pm_wrap row wp-exclude-emoji">
	<div class="sidebar sidebar--left">
		<?php require FLATPM_FOLDERS_LIST; ?>
	</div>

	<form class="main col s12 block_update" style="padding-top:0">
		<input type="hidden" name="method" value="block_update">
		<input type="hidden" name="abgroup" value="">
		<?php if( ! empty( $folder_id ) ){ ?>
			<input type="hidden" name="folder_id" value="<?php echo esc_attr( $folder_id ); ?>">
		<?php } ?>
		<input type="hidden" id="same_code" data-html="<?php esc_attr_e( '<span>The note!<br><span>In order not to use the same code in two columns, enable duplication for Adblock in the plugin options</span></span>', 'flatpm_l10n' ); ?>">

		<?php wp_nonce_field( 'flat_pm_nonce' ); ?>

		<div class="row white" style="border-radius:10px 10px 0 0">
			<div class="input-field col s12 m6 right">
				<div class="main-control right">
					<input type="checkbox" name="turned" id="turned" checked>
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Enabled block', 'flatpm_l10n' ); ?>"
						for="turned"
					>
						<i class="material-icons" style="color:#81C06D!important">turned_in</i>
					</label>
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Disabled block', 'flatpm_l10n' ); ?>"
						for="turned"
					>
						<i class="material-icons" style="color:#d87a87!important">turned_in_not</i>
					</label>

					<input type="checkbox" name="fast" id="fast">
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Enabled fast mode', 'flatpm_l10n' ); ?>"
						for="fast"
					>
						<i class="material-icons" style="color:#81C06D!important">flash_on</i>
					</label>
					<label style="border-radius:50%" class="btn tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Disabled fast mode', 'flatpm_l10n' ); ?>"
						for="fast"
					>
						<i class="material-icons" style="color:#d87a87!important">flash_off</i>
					</label>

					<?php if( $flat_pm_pagespeed['lazyload'] === 'true' ){ ?>
						<input type="checkbox" name="lazy" id="lazy" checked>
						<label style="border-radius:50%" class="btn tooltipped"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Enabled lazyload', 'flatpm_l10n' ); ?>"
							for="lazy"
						>
							<i class="material-icons" style="color:#81C06D!important">free_breakfast</i>
						</label>
						<label style="border-radius:50%" class="btn tooltipped"
							data-position="top"
							data-tooltip="<?php esc_attr_e( 'Disabled lazyload', 'flatpm_l10n' ); ?>"
							for="lazy"
						>
							<i class="material-icons" style="color:#d87a87!important">free_breakfast</i>
						</label>
					<?php } ?>

					<button type="submit" style="border-radius:50%" class="btn waves-effect tooltipped"
						data-position="top"
						data-tooltip="<?php esc_attr_e( 'Save', 'flatpm_l10n' ); ?>"
					>
						<i class="material-icons">save</i>
					</button>
				</div>
			</div>

			<div class="input-field col s12 m6">
				<input type="text" id="block-name" class="validate no-border" name="name" placeholder="<?php esc_attr_e( 'Block name', 'flatpm_l10n' ); ?>" required>
				<span class="helper-text" data-error="<?php esc_attr_e( 'Please fill out this field', 'flatpm_l10n' ); ?>" data-success=""></span>
			</div>
		</div>

		<div class="row white">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab">
						<a class="waves-effect active" href="#tab-html"><?php _e( 'Subblocks', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-view"><?php _e( 'Output options', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-content"><?php _e( 'Content targeting', 'flatpm_l10n' ); ?></a>
					</li>
					<li class="tab">
						<a class="waves-effect" href="#tab-user"><?php _e( 'User targeting', 'flatpm_l10n' ); ?></a>
					</li>
				</ul>
			</div>
		</div>

		<div class="row" style="border-radius:0 0 10px 10px">
			<?php include_once 'add_tab/html.php'; ?>
			<?php include_once 'add_tab/view.php'; ?>
			<?php include_once 'add_tab/content.php'; ?>
			<?php include_once 'add_tab/user.php'; ?>
		</div>

		<br>

		<div class="row" style="border-radius:0 0 10px 10px">
			<button type="submit" class="btn btn-large waves-effect waves-light" type="submit">
				<b><?php _e( 'Create new block', 'flatpm_l10n' ); ?></b>
			</button>
		</div>
	</form>


	<div id="search-publish-modal" class="modal">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Choose publications', 'flatpm_l10n' ); ?></h4>
			<p><?php _e( 'You can search as a single entry by entering the id, url or title, or as a list.<br>Each query on a new line:', 'flatpm_l10n' ); ?></p>

			<div class="col s12">
				<div class="row" style="margin-bottom:10px">
					<div class="row" style="margin-bottom:0">
						<div class="col s12 m5">
							<textarea class="default" name="search-publish-query" id="search-publish-query" placeholder="<?php esc_attr_e( 'What are we looking for?', 'flatpm_l10n' ); ?>" style="min-height:220.5px"></textarea>
						</div>

						<div class="col s12 m7">
							<ul class="extended_list collection" style="margin:0"></ul>
						</div>
					</div>
				</div>
			</div>

			<small><?php _e( 'minimum query length for url - 8 characters', 'flatpm_l10n' ); ?>,</small>
			<small><?php _e( 'minimum query length for title - 4 characters', 'flatpm_l10n' ); ?></small>

			<div class="col s12 add_all">
				<button class="row btn btn-small z-depth-0 waves-effect right" type="button"><?php _e( 'Add all', 'flatpm_l10n' ); ?></button>
			</div>
		</div>
	</div>


	<div id="search-taxonomy-modal" class="modal">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Choose taxonomies', 'flatpm_l10n' ); ?></h4>
			<p><?php _e( 'You can search for one taxonomy by entering id, slug or title, or as a list.<br>Each query on a new line:', 'flatpm_l10n' ); ?></p>

			<div class="col s12">
				<div class="row" style="margin-bottom:10px">
					<div class="row" style="margin-bottom:0">
						<div class="col s12 m5">
							<textarea class="default" name="search-taxonomy-query" id="search-taxonomy-query" placeholder="Что будем искать?" style="min-height:220.5px"></textarea>
						</div>

						<div class="col s12 m7">
							<ul class="extended_list collection" style="margin:0"></ul>
						</div>
					</div>
				</div>
			</div>

			<small><?php _e( 'minimum query length for url - 8 characters', 'flatpm_l10n' ); ?>,</small>
			<small><?php _e( 'minimum query length for title - 4 characters', 'flatpm_l10n' ); ?></small>

			<div class="col s12 add_all">
				<button class="row btn btn-small z-depth-0 waves-effect right" type="button"><?php _e( 'Add all', 'flatpm_l10n' ); ?></button>
			</div>
		</div>
	</div>

	<div id="confirm-enable-fast-mode" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Confirm enabling "Fast Mode"', 'flatpm_l10n' ) ?></h4>
			<p><?php _e( 'In this mode, all types of block output will be turned off, except for "Based on selectors (Once)"', 'flatpm_l10n' ) ?></p>

			<button class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button class="modal-close waves-effect btn-flat confirm-enable-fast-mode"><?php _e( 'I confirm', 'flatpm_l10n' ); ?></button>
		</div>
	</div>



	<form id="confirm-insert-image" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Image insertion assistant', 'flatpm_l10n' ) ?></h4>

			<div class="input-field col s12">
				<input type="text" id="confirm-insert-image-url" class="validate" required>
				<label for="confirm-insert-image-url"><?php _e( 'Image url:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12">
				<input type="text" id="confirm-insert-image-alt">
				<label for="confirm-insert-image-alt"><?php _e( 'Image alt:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6">
				<input type="number" id="confirm-insert-image-width">
				<label for="confirm-insert-image-width"><?php _e( 'Image width:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6">
				<input type="number" id="confirm-insert-image-height">
				<label for="confirm-insert-image-height"><?php _e( 'Image height:', 'flatpm_l10n' ) ?></label>
			</div>

			<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button type="submit" class="waves-effect btn-flat confirm-insert-image"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>
		</div>
	</form>



	<form id="confirm-insert-link" class="modal" style="width:600px;overflow:visible" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Link insertion assistant', 'flatpm_l10n' ) ?></h4>

			<div class="input-field col s12">
				<input type="text" id="confirm-insert-link-url" class="validate" required>
				<label for="confirm-insert-link-url"><?php _e( 'Link url:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12">
				<input type="text" id="confirm-insert-link-text">
				<label for="confirm-insert-link-text"><?php _e( 'Link text:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6">
				<select id="confirm-insert-link-target">
					<option value="">_self</option>
					<option value="_blank">_blank</option>
					<option value="_parent">_parent</option>
					<option value="_top">_top</option>
				</select>
				<label for="confirm-insert-link-target"><?php _e( 'Link target:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6">
				<select id="confirm-insert-link-rel" multiple>
					<option value="nofollow">nofollow</option>
					<option value="noreferrer">noreferrer</option>
					<option value="noopener">noopener</option>
				</select>
				<label for="confirm-insert-link-rel"><?php _e( 'Link rel:', 'flatpm_l10n' ) ?></label>
			</div>

			<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button type="submit" class="waves-effect btn-flat confirm-insert-image"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>
		</div>
	</form>



	<form id="confirm-insert-sticky" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Sticky insertion assistant', 'flatpm_l10n' ) ?></h4>

			<div class="input-field col s12 m6" style="margin-bottom:0">
				<input type="number" id="confirm-insert-sticky-height" value="500">
				<label for="confirm-insert-sticky-height"><?php _e( 'Sticky height:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12 m6" style="margin-bottom:0">
				<input type="number" id="confirm-insert-sticky-offset" value="20">
				<label for="confirm-insert-sticky-offset"><?php _e( 'Offset from top:', 'flatpm_l10n' ) ?></label>
			</div>
			<div class="input-field col s12" style="margin-top:0">
				<textarea class="default" type="text" id="confirm-insert-sticky-code" class="validate" placeholder="<?php esc_attr_e( 'Your code:', 'flatpm_l10n' ) ?>" required></textarea>
			</div>

			<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button type="submit" class="waves-effect btn-flat confirm-insert-image"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>
		</div>
	</form>



	<form id="confirm-insert-sidebar" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Sidebar block insertion assistant', 'flatpm_l10n' ) ?></h4>

			<div class="items">
				<div class="item" data-id="0">
					<div class="input-field col s12" style="display:flex;gap:10px;margin-bottom:0">
						<input type="number" id="confirm-insert-sidebar-offset-block_0" value="20" style="max-width:calc(100% - 62px)">
						<label for="confirm-insert-sidebar-offset-block_0"><?php _e( 'Offset from top:', 'flatpm_l10n' ) ?></label>

						<button type="button" class="btn-flat waves-effect confirm-delete-item" style="height:46px;line-height:46px;margin:0 0 7px">
							<i class="material-icons" style="color:#d87a87!important;">delete_forever</i>
						</button>
					</div>
					<div class="input-field col s12" style="margin-top:0">
						<textarea class="default" type="text" id="confirm-insert-sidebar-code-block_0" class="validate" placeholder="<?php esc_attr_e( 'Your code:', 'flatpm_l10n' ) ?>" required></textarea>
					</div>
				</div>
			</div>

			<center>
				<button type="button" class="btn-small waves-effect confirm-add-more">
					<?php _e( 'Add more', 'flatpm_l10n' ) ?>
				</button>
			</center>

			<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button type="submit" class="waves-effect btn-flat confirm-insert-image"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>
		</div>
	</form>



	<form id="confirm-insert-slider" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Slider insertion assistant', 'flatpm_l10n' ) ?></h4>

			<div class="items">
				<div class="item" data-id="0">
					<div class="input-field col s12" style="display:flex;gap:10px;margin-bottom:0">
						<input type="number" id="confirm-insert-slider-timer-block_0" value="30" style="max-width:calc(100% - 62px)">
						<label for="confirm-insert-slider-timer-block_0"><?php _e( 'Time to show slide:', 'flatpm_l10n' ) ?></label>

						<button type="button" class="btn-flat waves-effect confirm-delete-item" style="height:46px;line-height:46px;margin:0 0 7px">
							<i class="material-icons" style="color:#d87a87!important;">delete_forever</i>
						</button>
					</div>
					<div class="input-field col s12" style="margin-top:0">
						<textarea class="default" type="text" id="confirm-insert-slider-code-block_0" class="validate" placeholder="<?php esc_attr_e( 'Your code:', 'flatpm_l10n' ) ?>" required></textarea>
					</div>
				</div>
			</div>

			<center>
				<button type="button" class="btn-small waves-effect confirm-add-more">
					<?php _e( 'Add more', 'flatpm_l10n' ) ?>
				</button>
			</center>

			<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button type="submit" class="waves-effect btn-flat confirm-insert-image"><?php _e( 'Insert', 'flatpm_l10n' ); ?></button>
		</div>
	</form>



	<form id="confirm-master-rtb-step-1" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Code Insertion Assistant.', 'flatpm_l10n' ) ?></h4>
			<p>
				<?php _e( 'FlatPM has determined that you want to insert a Yandex.Metrika, FloorAd, Fullscreen or TopAd.', 'flatpm_l10n' ) ?><br>
				<?php _e( 'Do you want us to help you?', 'flatpm_l10n' ) ?>
			</p>

			<button type="button" class="modal-close waves-effect btn"><?php _e( 'Cancel', 'flatpm_l10n' ); ?></button>
			<button type="submit" class="waves-effect btn-flat confirm-master-rtb-step-1"><?php _e( 'Yes help me!', 'flatpm_l10n' ); ?></button>
		</div>
	</form>



	<form id="confirm-master-rtb-step-2" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4>
				<?php _e( 'Cool!', 'flatpm_l10n' ) ?><br>
				<?php _e( 'Thank you for your trust😉', 'flatpm_l10n' ) ?>
			</h4>
			<p><?php _e( 'First, we\'ll set up the "Output options"', 'flatpm_l10n' ) ?></p>

			<button type="submit" class="waves-effect btn confirm-master-rtb-step-2"><?php _e( 'Next step', 'flatpm_l10n' ); ?></button>
		</div>
	</form>



	<form id="confirm-master-rtb-step-3" class="modal" style="width:600px" tabindex="0">
		<div class="modal-content">
			<button type="button" class="modal-close btn btn-floating white z-depth-0 waves-effect right">
				<i class="material-icons right" style="color:#000!important">close</i>
			</button>

			<h4><?php _e( 'Second and final step.', 'flatpm_l10n' ) ?></h4>
			<p><?php _e( 'Last, we\'ll set up "Content targeting"', 'flatpm_l10n' ) ?></p>
			<p><?php _e( 'Everything is ready and set up correctly, enjoy 😊', 'flatpm_l10n' ) ?></p>
		</div>
	</form>



	<div class="sidebar sidebar--right">
		<?php require FLATPM_NEWS; ?>
	</div>
</div>