<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$id = sanitize_text_field( $_GET['id'] );
$content = get_post_meta( $id, 'content', true );

$users = get_users( array(
	'capability' => 'edit_posts',
	'fields' => array( 'ID', 'display_name' ),
	'has_published_posts' => true
) );
?>
<div id="tab-content" class="col s12 white">
	<div class="row">
		<div class="col s12">
			<h5><?php _e( 'Post types:', 'flatpm_l10n' ); ?></h5>

			<?php
			$args = array(
				'public' => true
			);

			$post_types = array_diff( array_values( get_post_types( $args, 'names', 'and' ) ), array( 'flat_pm_block', 'attachment' ) );
			?>

			<div class="col s12" style="display:flex;column-gap:40px;flex-wrap:wrap">
				<?php
				foreach( $post_types as $type ){
					$type = get_post_type_object( $type );

					echo '
					<p>
						<label>
							<input type="checkbox"
								id="post_types_' . esc_attr( $type->name ) . '"
								name="content[post_types][' . esc_attr( $type->name ) . ']"
								' . ( ( isset( $content['post_types'][ $type->name ] ) && $content['post_types'][ $type->name ] === 'true' ) ? 'checked' : '' ) . '
							>
							<span>' . esc_html( $type->labels->name ) . '</span>
						</label>
					</p>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="divider"></div>

	<div class="row">
		<div class="col s12">
			<h5><?php _e( 'Posts:', 'flatpm_l10n' ); ?></h5>

			<div class="row">
				<div class="col s12 m6">
					<p>
						<?php _e( 'In which posts to show:', 'flatpm_l10n' ); ?>
						<button type="button" class="delete-all btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right" data-position="top" data-tooltip="<?php esc_attr_e( 'Remove all', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
							<i class="material-icons" style="color:#d87a87!important">close</i>
						</button>
						<button type="button" data-target="search-publish-modal" class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right modal-trigger" data-position="top" data-tooltip="<?php esc_attr_e( 'Add', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
							<i class="material-icons">edit</i>
						</button>
					</p>

					<ul class="extended_list collection" data-type="publish_enabled"><?php
						if( isset( $content['publish_enabled'] ) ){
							foreach( $content['publish_enabled'] as $type => $posts ){
								if( is_array( $posts ) ){
									foreach( $posts as $post ){
										$post = get_post( $post );

										if( $post ){
											echo '<li class="collection-item">
												<input type="hidden"
													name="content[publish_enabled][' . esc_attr( $type ) . '][' . esc_attr( $post->ID ) . ']"
													value="' . esc_attr( $post->ID ) . '"
												>

												<span class="title">' . esc_html( $post->post_title ) . '</span>
												<span class="post_type">' . esc_html( $post->post_type ) . '</span>

												<button type="button" class="btn btn-small btn-floating right white z-depth-0 waves-effect delete-item">
													<i class="material-icons" style="color:#d87a87!important">block</i>
												</button>
											</li>';
										}
									}
								}
							}
						}
					?></ul>

					<div class="empty-list">
						<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
					</div>
				</div>

				<div class="col s12 m6">
					<p>
						<?php _e( 'In which posts to not show:', 'flatpm_l10n' ); ?>
						<button type="button" class="delete-all btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right" data-position="top" data-tooltip="<?php esc_attr_e( 'Remove all', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
							<i class="material-icons" style="color:#d87a87!important">close</i>
						</button>
						<button type="button" data-target="search-publish-modal" class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right modal-trigger" data-position="top" data-tooltip="<?php esc_attr_e( 'Add', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
							<i class="material-icons">edit</i>
						</button>
					</p>

					<ul class="extended_list collection" data-type="publish_disabled"><?php
						if( isset( $content['publish_disabled'] ) ){
							foreach( $content['publish_disabled'] as $type => $posts ){
								if( is_array( $posts ) ){
									foreach( $posts as $post ){
										$post = get_post( $post );

										if( $post ){
											echo '<li class="collection-item">
												<input type="hidden"
													name="content[publish_disabled][' . esc_attr( $type ) . '][' . esc_attr( $post->ID ) . ']"
													value="' . esc_attr( $post->ID ) . '"
												>

												<span class="title">' . esc_html( $post->post_title ) . '</span>
												<span class="post_type">' . esc_html( $post->post_type ) . '</span>

												<button type="button" class="btn btn-small btn-floating right white z-depth-0 waves-effect delete-item">
													<i class="material-icons" style="color:#d87a87!important">block</i>
												</button>
											</li>';
										}
									}
								}
							}
						}
					?></ul>

					<div class="empty-list">
						<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="divider"></div>

	<div class="row">
		<div class="col s12">
			<h5><?php _e( 'Taxonomies:', 'flatpm_l10n' ); ?></h5>

			<div class="row">
				<div class="col s12 m6">
					<p>
						<?php _e( 'In which taxonomies to show:', 'flatpm_l10n' ); ?>
						<button type="button" class="delete-all btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right" data-position="top" data-tooltip="<?php esc_attr_e( 'Remove all', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
							<i class="material-icons" style="color:#d87a87!important">close</i>
						</button>
						<button type="button" data-target="search-taxonomy-modal" class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right modal-trigger" data-position="top" data-tooltip="<?php esc_attr_e( 'Add', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
							<i class="material-icons">edit</i>
						</button>
					</p>

					<ul class="extended_list collection" data-type="taxonomy_enabled"><?php
						if( isset( $content['taxonomy_enabled'] ) ){
							foreach( $content['taxonomy_enabled'] as $type => $terms ){
								if( is_array( $terms ) ){
									foreach( $terms as $term ){
										$term = get_term( $term );

										if( $term ){
											echo '<li class="collection-item">
												<input type="hidden"
													name="content[taxonomy_enabled][' . esc_attr( $type ) . '][' . esc_attr( $term->term_id ) . ']"
													value="' . esc_attr( $term->term_id ) . '"
												>

												<span class="title">' . esc_html( $term->name ) . '</span>
												<span class="post_type">' . esc_html( $term->taxonomy ) . '</span>

												<button type="button" class="btn btn-small btn-floating right white z-depth-0 waves-effect delete-item">
													<i class="material-icons" style="color:#d87a87!important">block</i>
												</button>
											</li>';
										}
									}
								}
							}
						}
					?></ul>

					<div class="empty-list">
						<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
					</div>
				</div>

				<div class="col s12 m6">
					<p>
						<?php _e( 'In which taxonomies not to show:', 'flatpm_l10n' ); ?>
						<button type="button" class="delete-all btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right" data-position="top" data-tooltip="<?php esc_attr_e( 'Remove all', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
							<i class="material-icons" style="color:#d87a87!important">close</i>
						</button>
						<button type="button" data-target="search-taxonomy-modal" class="btn btn-small btn-floating tooltipped white z-depth-0 waves-effect right modal-trigger" data-position="top" data-tooltip="<?php esc_attr_e( 'Add', 'flatpm_l10n' ); ?>" style="margin-top:-6px">
							<i class="material-icons">edit</i>
						</button>
					</p>

					<ul class="extended_list collection" data-type="taxonomy_disabled"><?php
						if( isset( $content['taxonomy_disabled'] ) ){
							foreach( $content['taxonomy_disabled'] as $type => $terms ){
								if( is_array( $terms ) ){
									foreach( $terms as $term ){
										$term = get_term( $term );

										if( $term ){
											echo '<li class="collection-item">
												<input type="hidden"
													name="content[taxonomy_disabled][' . esc_attr( $type ) . '][' . esc_attr( $term->term_id ) . ']"
													value="' . esc_attr( $term->term_id ) . '"
												>

												<span class="title">' . esc_html( $term->name ) . '</span>
												<span class="post_type">' . esc_html( $term->taxonomy ) . '</span>

												<button type="button" class="btn btn-small btn-floating right white z-depth-0 waves-effect delete-item">
													<i class="material-icons" style="color:#d87a87!important">block</i>
												</button>
											</li>';
										}
									}
								}
							}
						}
					?></ul>

					<div class="empty-list">
						<img width="250" height="146" src="<?php echo esc_attr( FLATPM_URL ); ?>assets/admin/img/empty_state.svg">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="divider"></div>

	<div class="row">
		<div class="col s12">
			<h5><?php _e( 'Content restriction:', 'flatpm_l10n' ); ?></h5>
		</div>

		<div class="input-field col s12 m6">
			<input id="content_restriction_content_less" type="number" class="validate"
				min="0" step="1"
				name="content[restriction][content_less]"
				value="<?php echo esc_attr( $content['restriction']['content_less'] ); ?>"
			>
			<label for="content_restriction_content_less"><?php _e( 'Hide if the content is less than N characters:', 'flatpm_l10n' ); ?></label>
		</div>

		<div class="input-field col s12 m6">
			<input id="content_restriction_title_less" type="number" class="validate"
				min="0" step="1"
				name="content[restriction][title_less]"
				value="<?php echo esc_attr( $content['restriction']['title_less'] ); ?>"
			>
			<label for="content_restriction_title_less"><?php _e( 'Hide if there are less than N subheadings:', 'flatpm_l10n' ); ?></label>
		</div>

		<div class="input-field col s12 m6">
			<input id="content_restriction_content_more" type="number" class="validate"
				min="0" step="1"
				name="content[restriction][content_more]"
				value="<?php echo esc_attr( $content['restriction']['content_more'] ); ?>"
			>
			<label for="content_restriction_content_more"><?php _e( 'Hide if the content is more than N characters:', 'flatpm_l10n' ); ?></label>
		</div>

		<div class="input-field col s12 m6">
			<input id="content_restriction_title_more" type="number" class="validate"
				min="0" step="1"
				name="content[restriction][title_more]"
				value="<?php echo esc_attr( $content['restriction']['title_more'] ); ?>"
			>
			<label for="content_restriction_title_more"><?php _e( 'Hide if there are more than N subheadings:', 'flatpm_l10n' ); ?></label>
		</div>
	</div>

	<div class="divider"></div>

	<div class="row" style="margin-bottom:0">
		<div class="col s12">
			<h5><?php _e( 'Author targeting:', 'flatpm_l10n' ); ?></h5>
		</div>

		<div class="input-field col s12 m6">
			<select multiple name="content[author][allow]" id="content_author_allow">
				<option value="" disabled><?php _e( 'Select Authors', 'flatpm_l10n' ); ?></option>
				<?php
				foreach( $users as $user ){
					$selected = (
						isset( $content['author'] ) &&
						isset( $content['author']['allow'] ) &&
						in_array( $user->ID, $content['author']['allow'] )
					) ? 'selected' : '';

					echo '<option value="' . esc_attr( $user->ID ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $user->display_name ) . '</option>';
				}
				?>
			</select>
			<label><?php _e( 'Show if author:', 'flatpm_l10n' ); ?></label>
		</div>

		<div class="input-field col s12 m6">
			<select multiple name="content[author][disallow]" id="content_author_disallow">
				<option value="" disabled><?php _e( 'Select Authors', 'flatpm_l10n' ); ?></option>
				<?php
				foreach( $users as $user ){
					$selected = (
						isset( $content['author'] ) &&
						isset( $content['author']['disallow'] ) &&
						in_array( $user->ID, $content['author']['disallow'] )
					) ? 'selected' : '';

					echo '<option value="' . esc_attr( $user->ID ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $user->display_name ) . '</option>';
				}
				?>
			</select>
			<label><?php _e( 'Hide if author:', 'flatpm_l10n' ); ?></label>
		</div>
	</div>

	<div class="divider"></div>

	<div class="row">
		<div class="col s12">
			<h5><?php _e( 'Template types:', 'flatpm_l10n' ); ?></h5>

			<div class="col s12 m6">
				<p>
					<label>
						<input type="checkbox" name="content[templates][home]"
							<?php if( $content['templates']['home'] === 'true' ) echo 'checked'; ?>
						>
						<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_home(), is_front_page()"><?php _e( 'homepage', 'flatpm_l10n' ); ?></ins></span>
					</label>
				</p>
			</div>
			<div class="col s12 m6">
				<p>
					<label>
						<input type="checkbox" name="content[templates][singular]"
							<?php if( $content['templates']['singular'] === 'true' ) echo 'checked'; ?>
						>
						<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_singular()"><?php _e( 'singular', 'flatpm_l10n' ); ?></ins></span>
					</label>
				</p>
			</div>
			<div class="col s12 m6">
				<p>
					<label>
						<input type="checkbox" name="content[templates][archives]"
							<?php if( $content['templates']['archives'] === 'true' ) echo 'checked'; ?>
						>
						<span><?php _e( 'Show in', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_archive()"><?php _e( 'archives', 'flatpm_l10n' ); ?></ins></span>
					</label>
				</p>
			</div>
			<div class="col s12 m6">
				<p>
					<label>
						<input type="checkbox" name="content[templates][categories]"
							<?php if( $content['templates']['categories'] === 'true' ) echo 'checked'; ?>
						>
						<span><?php _e( 'Show in', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_category(), is_tax()"><?php _e( 'categories', 'flatpm_l10n' ); ?></ins></span>
					</label>
				</p>
			</div>
			<div class="col s12 m6">
				<p>
					<label>
						<input type="checkbox" name="content[templates][search]"
							<?php if( $content['templates']['search'] === 'true' ) echo 'checked'; ?>
						>
						<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_search()"><?php _e( 'search page', 'flatpm_l10n' ); ?></ins></span>
					</label>
				</p>
			</div>
			<div class="col s12 m6">
				<p>
					<label>
						<input type="checkbox" name="content[templates][404]"
							<?php if( $content['templates']['404'] === 'true' ) echo 'checked'; ?>
						>
						<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_404()"><?php _e( 'page 404 errors', 'flatpm_l10n' ); ?></ins></span>
					</label>
				</p>
			</div>
			<div class="col s12 m6">
				<p>
					<label>
						<input type="checkbox" name="content[templates][paged]"
							<?php if( $content['templates']['paged'] === 'true' ) echo 'checked'; ?>
						>
						<span><?php _e( 'Show on', 'flatpm_l10n' ); ?> <ins class="tooltipped" data-position="top" data-tooltip="is_paged()"><?php _e( 'pagination page', 'flatpm_l10n' ); ?></ins></span>
					</label>
				</p>
			</div>
		</div>
	</div>
</div>