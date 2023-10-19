<?php
/*
* Phoenix Media Rename main class
*
*/

require_once('class-plugins.php');

#region constants

define("actionRename", "rename");
define("actionRenameRetitle", "rename_retitle");
define("actionRetitle", "retitle");
define("actionRetitleFromPostTitle", "retitle_from_post_title");
define("actionRenameFromPostTitle", "rename_from_post_title");
define("actionRenameRetitleFromPostTitle", "rename_retitle_from_post_title");
define("success", "pmr_renamed");
define("pmrTableName", "pmr_status");

abstract class Operation
{
	const search = 0;
	const replace = 1;
}

#endregion

class Phoenix_Media_Rename {

	private $is_media_rename_page;
	private $nonce_printed;

	/**
	 * Initializes the plugin
	 */
	function __construct() {
		$post = isset($_REQUEST['post']) ? get_post($_REQUEST['post']) : NULL;
		$is_media_edit_page = $post && $post->post_type == 'attachment' && $GLOBALS['pagenow'] == 'post.php';
		$is_media_listing_page = $GLOBALS['pagenow'] == 'upload.php';
		$this->is_media_rename_page = $is_media_edit_page || $is_media_listing_page;
		self::frontend_support();
	}

	/**
	 * Adds the "Filename" column at the media posts listing page
	 *
	 * @param array $columns
	 * @return array
	 */
	function add_filename_column($columns) {
		$columns['filename'] = 'Filename';
		return $columns;
	}

	/**
	 * Adds the "Filename" column content at the media posts listing page
	 *
	 * @param string $column_name
	 * @param integer $post_id
	 * @return void
	 */
	function add_filename_column_content($column_name, $post_id) {
		if ($column_name == 'filename') {

			//set bulk rename process as stopped
			$this->reset_bulk_rename();

			$file_parts = pmr_lib::get_file_parts($post_id);
			echo $this->get_filename_field($post_id, $file_parts['filename'], $file_parts['extension']);
		}
	}

	/**
	 * Add the "Filename" field to the Media form
	 *
	 * @param array $form_fields
	 * @param WP_Post $post
	 * @return array form fields
	 */
	function add_filename_field($form_fields, $post) {
		if (isset($GLOBALS['post']) && $GLOBALS['post']->post_type=='attachment') {
			$file_parts = pmr_lib::get_file_parts($GLOBALS['post']->ID);
			$form_fields['mr_filename']=array(
				'label' => __('Filename', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN')),
				'input' => 'html',
				'html' => $this->get_filename_field($GLOBALS['post']->ID, $file_parts['filename'], $file_parts['extension'])
			);
		}
		return $form_fields;
	}

	/**
	 * Reset the bulk rename process
	 *
	 * @return void
	 */
	function reset_bulk_rename(){
		//set index for group rename
		$this->write_db_value('current_image_index', 0);
		//reset the bulk rename flag
		$this->write_db_value('bulk_rename_in_progress', false);
		//reset the bulk rename from post flag
		$this->write_db_value('bulk_rename_from_post_in_progress', false);
		//reset the bulk rename filename header
		$this->write_db_value('bulk_filename_header', '');
}

	/**
	 * Makes sure that the success message will be shown on bulk rename
	 *
	 * @return void
	 */
	function handle_bulk_pnx_rename_form_submit() {
		if (
			array_search(constant("actionRename"), $_REQUEST, true) !== FALSE
			|| array_search(constant("actionRenameRetitle"), $_REQUEST, true) !== FALSE
			|| array_search(constant("actionRetitle"), $_REQUEST, true) !== FALSE
			|| array_search(constant("actionRetitleFromPostTitle"), $_REQUEST, true) !== FALSE
			) {

			//set bulk rename process as stopped
			$this->reset_bulk_rename();

			wp_redirect(add_query_arg(array(constant("success") => 1), wp_get_referer()));
			exit;
		}
	}

	/**
	 * Shows bulk rename success notice
	 *
	 * @return void
	 */
	function show_bulk_pnx_rename_success_notice() {
		if(isset($_REQUEST[constant("success")])) {
			echo '<div class="updated"><p>'. __('Medias successfully renamed!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN')) .'</p></div>';
		}
	}

	/**
	 * Print the JS code only on media.php and media-upload.php pages
	 *
	 * @return void
	 */
	function print_js() {
		if ($this->is_media_rename_page) {
			wp_enqueue_script(constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'), plugins_url('js/scripts.min.js', dirname(__FILE__)), array('jquery'), '3.1.0');
			?>

			<script type="text/javascript">
				MRSettings = {
					'labels': {
						'<?php echo constant("actionRename") ?>': '<?php echo __('Rename', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN')) ?>',
						'<?php echo constant("actionRenameRetitle") ?>': '<?php echo __('Rename & Retitle', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN')) ?>',
						'<?php echo constant("actionRetitle") ?>': '<?php echo __('Retitle', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN')) ?>',
						'<?php echo constant("actionRetitleFromPostTitle") ?>': '<?php echo __('Retitle from Post', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN')) ?>',
						'<?php echo constant("actionRenameFromPostTitle") ?>': '<?php echo __('Rename from Post', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN')) ?>',
						'<?php echo constant("actionRenameRetitleFromPostTitle") ?>': '<?php echo __('Rename & Retitle from Post', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN')) ?>'
					}
				};
			</script>

			<?php
		}
	}

	/**
	 * Print the CSS styles only on media.php and media-upload.php pages
	 *
	 * @return void
	 */
	function print_css() {
		if ($this->is_media_rename_page) {
			wp_enqueue_style('phoenix-media-rename', plugins_url('css/style.css', dirname(__FILE__)));
		}
	}

	/**
	 * Prints the "Filename" textfield
	 *
	 * @param integer $post_id
	 * @param string $filename
	 * @param string $extension
	 * @return void
	 */
	function get_filename_field($post_id, $filename, $extension) {
		if (!isset($this->nonce_printed)) $this->nonce_printed=0;
		ob_start(); ?>

			<div class="phoenix-media-rename">
				<input type="text" class="text phoenix-media-rename-filename" autocomplete="post_title" value="<?php echo $filename ?>" title="<?php echo $filename ?>" data-post-id="<?php echo $post_id ?>" />
				<span class="file_ext">.<?php echo $extension ?></span>
				<span class="loader"></span>
				<span class="success"></span>
				<span class="error"></span>
				<?php if (!$this->nonce_printed) {
					wp_nonce_field('phoenix_media_rename', '_mr_wp_nonce');
					$this->nonce_printed++;
				} ?>
			</div>

		<?php return ob_get_clean();
	}

	/**
	 * Read a value from Phoenix Media Rename table
	 *
	 * @param string $field
	 * @return string
	 */
	function read_db_value($field){
		global $wpdb;

		//check if there are values in table
		$result = $wpdb->get_var("SELECT " . $field . " FROM " . $wpdb->prefix . constant('pmrTableName'));

		return $result;
	}

	/**
	 * Insert a value in Phoenix Media Rename table
	 *
	 * @param string $field
	 * @param any $value
	 * @return void
	 */
	function write_db_value($field, $value){
		global $wpdb;

		//check if there are values in table
		$records = $wpdb->get_var("SELECT IFNULL(COUNT(*), 0) FROM " . $wpdb->prefix . constant('pmrTableName'));

		if ($records > 1){
			//error in table content, truncate table to reset data
			$wpdb->query(
				$wpdb->prepare(
					"TRUNCATE TABLE " . $wpdb->prefix . constant('pmrTableName')
				)
			);
		}elseif ($records == 0){
			//table is empty, insert new row
			$wpdb->insert(
				$wpdb->prefix . constant('pmrTableName'), 
				array(
					$field => $value, 
				)
			);
		} else {
			//table contains a record, update data
			$wpdb->update(
				$wpdb->prefix . constant('pmrTableName'), 
				array(
					$field => $value, 
				),
				array(
					'ID' => 1, 
				)
			);
		}
	}

	/**
	 * Handles AJAX rename queries
	 *
	 * @return void
	 */
	function ajax_pnx_rename() {
		if (check_ajax_referer('phoenix_media_rename', '_wpnonce', 0)) {
			//check if retitle and rename are required
			$retitle = $this->retitle_required();
			$rename = $this->rename_required();
			$name_from_post = $this->name_from_post();
			$title_from_post = $this->title_from_post();

			$new_filename = $_REQUEST['new_filename'];
			$bulk_rename_in_progress = $this->read_db_value('bulk_rename_in_progress');
			$attachment_id = $_REQUEST['post_id'];
			$force_serializiation = false;

			if (! current_user_can('edit_post', $attachment_id)){
				//the user can't modify the file: log the error and exit function to prevent code excecution
				echo __("user doesn't have permission to edit the post", constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));

				wp_die();
			} else{
				//the user can modify the file: execute the code

				if ($name_from_post || $title_from_post){
					//if filename has to be generated from parent post the do_rename function will get the filename
					// $new_filename = '';
					$post = get_post($attachment_id);

					if (! $this->check_post_parent($post)){
						//media is not attached to a post, or post has no title
						return;
					}else{
						$new_filename = $this->get_filename_from_post_parent($post, true, $post_parent);

						$force_serializiation = true;
					};

				}elseif ($bulk_rename_in_progress){
					//bulk rename in progress: build filename
					//increment image name index
					$current_image_index = $this->read_db_value('current_image_index');
					$bulk_filename_header = $this->read_db_value('bulk_filename_header');

					$this->write_db_value('current_image_index', ++$current_image_index);

					//create filename
					$new_filename = $this->build_filename($bulk_filename_header, $current_image_index);
				}else{
					//bulk rename not in progress: check if filename contains {}
					//search pattern {number}
					$re = '/[{][0-9]{1,10}[}]/m';

					preg_match($re, $new_filename, $matches);

					//if new filename contains {number}, serialize following file names
					if ($matches){
						//notify the start of bulk rename process
						$this->write_db_value('bulk_rename_in_progress', true);

						//extract file header
						$bulk_filename_header = preg_replace($re, '', $new_filename);

						//if this is the first iteration, extract the number from filename
						$re = '/[0-9]{1,10}/m';

						preg_match($re, $matches[0], $matches);

						$current_image_index = $matches[0];

						//check if image index start with '0'
						$zeroes = pmr_lib::starts_with($current_image_index, '0');

						if ($zeroes != -1){
							//image index start with one or more '0'
							//add zeroes to header
							$bulk_filename_header .= $zeroes;

							//remove zeroes from image index
							$current_image_index = intval($current_image_index);
						}

						$this->write_db_value('bulk_filename_header', $bulk_filename_header);

						$this->write_db_value('current_image_index', $current_image_index);

						//create filename
						$new_filename = $this->build_filename($bulk_filename_header, $current_image_index);
					}	
				}

				echo $this->do_rename($attachment_id, $new_filename, $retitle, $title_from_post, $name_from_post, true, false, $force_serializiation, $rename);
				}

			wp_die();
		}

		wp_die();
	}

	/**
	 * Check if rename is needed
	 *
	 * @return boolean
	 */
	private function title_from_post(){
		//if action is "actionRenameFromPostTitle" or "actionRenameRetitleFromPostTitle" retrieve title for post related to media file to generate attachment title
		if ($_REQUEST['type'] == constant("actionRenameRetitleFromPostTitle")
			|| $_REQUEST['type'] == constant("actionRetitleFromPostTitle")
			) {
			$result = true;
		}else{
			$result = false;
		}

		return $result;
	}

	/**
	 * Check if rename is needed
	 *
	 * @return boolean
	 */
	private function name_from_post(){

		//if action is "actionRenameFromPostTitle" or "actionRenameRetitleFromPostTitle" retrieve title for post related to media file to generate filename
		if (($_REQUEST['type'] == constant("actionRenameFromPostTitle"))
			|| ($_REQUEST['type'] == constant("actionRenameRetitleFromPostTitle"))
			){
			$result = true;
		}else{
			$result = false;
		}

		return $result;
	}

	/**
	 * Check if rename is needed
	 *
	 * @return boolean
	 */
	private function rename_required(){
		//set default
		$result = true;

		if (
			$_REQUEST['type'] == constant("actionRetitle")
			|| $_REQUEST['type'] == constant("actionRetitleFromPostTitle")
			) {
			//disable renaming if needed
			$result = false;
		}

		return $result;
	}

	/**
	 * Check if retitle is needed
	 *
	 * @return boolean
	 */
	private function retitle_required(){
		//set default
		$result = false;

		//check if retitle is needed
		if (
			$_REQUEST['type'] == constant("actionRenameRetitleFromPostTitle")
			|| $_REQUEST['type'] == constant("actionRetitleFromPostTitle")
			|| $_REQUEST['type'] == constant("actionRenameRetitle")
			|| $_REQUEST['type'] == constant("actionRetitle")
			) {
			//enable retitling if needed
			$result = true;
		}

		return $result;
	}

	/**
	 * build a filename from filename parts
	 *
	 * @param string $header
	 * @param string $trailer
	 * @return void
	 */
	function build_filename($header, $trailer){
		return $header . $trailer;
	}

	/**
	 * Generate filename from title of parent post
	 *
	 * @param object $post post of the media file to rename
	 * @param bool $name_from_post true: generate filename from post title; false: don't generate filename from post title
	 * @param object $post_parent parent of the media post
	 * @return void
	 */
	static function get_filename_from_post_parent($post, $name_from_post, &$post_parent){
		//retrive post_parent
		$post_parent = get_post($post->post_parent);

		if ($name_from_post){
			//generate filename from post_parent title
			$new_filename = $post_parent->post_title;
		} else {
			$new_filename = '';
		}

		return $new_filename;
	}

	static function get_category_from_post_parent($post){
		//retrive post_parent
		$post_parent = get_post($post->post_parent);

		$post_categories = wp_get_post_categories($post_parent->ID, array('fields' => 'names'));

		if (count($post_categories) > 0) {
			$category_name = $post_categories[0];
		}

		return $category_name;
	}

	/**
	 * Check if media is attached to a post and if the post have a title
	 *
	 * @param WP_Post $post
	 * @return boolean
	 */
	static function check_post_parent($post){
		$post_parent = $post->post_parent;

		if (! $post_parent){
			//no post found
			echo __('The media is not attached to a post!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));
			return false;
		}

		$new_filename = self::get_filename_from_post_parent($post, true, $post_parent);

		if (! $new_filename){
			//no title set
			echo __('The post has no title!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));
			return false;
		}

		//everything is ok
		return true;
	}

	/**
	 * update post title
	 * 
	 * @param object $post_changes
	 * @param string $post_title
	 * @return object
	 */
	static function do_retitle($post_changes, $post_title)
	{
		$post_changes['post_title'] = $post_title;

		return $post_changes;
	}

	/**
	 * Handles the actual rename process
	 *
	 * @param integer $attachment_id id of the post of the media file (post_type: attachment)
	 * @param string $new_filename name to give to the file
	 * @param boolean $retitle true: change the title of the post of the media file
	 * @param boolean $title_from_post true: get the title the post of the media file from the title of the post the media file is attached to
	 * @param boolean $name_from_post true: get the filename from the title of the post the media file is attached to
	 * @param boolean $check_post_parent true: check if the post of the media file has a parent
	 * @param boolean $force_lowercase true: change the filename to lowercase
	 * @param boolean $force_serializiation true: add a progressive number to the filename
	 * @param boolean $rename true: rename the file
	 * @return string
	 */
	static function do_rename($attachment_id, $new_filename, $retitle = 0, $title_from_post = 0, $name_from_post = 0, $check_post_parent = true, $force_lowercase = false, $force_serializiation = false, $rename = true) {
		//Variables
		$options = new pmr_options();
		$post = get_post($attachment_id);

		//Change the attachment post
		$post_changes['ID'] = $post->ID;

		if ($force_serializiation){
			$options->option_serialize_if_filename_present = true;
		}

		if (($title_from_post) || ($name_from_post)){
			//force serialization if renaming from post title
			$options->option_serialize_if_filename_present = true;

			if ($check_post_parent){
				if (! self::check_post_parent($post)){
					//the media is not attached to a post or the post has no title
					//this check is needed to avoid issues with third party code that calls directly pmr->do_rename
					return;
				}else{
					$post_parent = get_post($post->post_parent);
					$new_filename = self::get_filename_from_post_parent($post, true, $post_parent);
				}
			} else {
				$post_parent = get_post($post->post_parent);
				$new_filename = self::get_filename_from_post_parent($post, true, $post_parent);
			}
		}

		if ($options->option_category_filename_header){
			//use post parent's category as filenamne header
			$post_parent_category = self::get_category_from_post_parent($post);
		} else {
			$post_parent_category = "";
		}

		if ((! $rename) && ($retitle)){
			//renaming is disabled and retitle is enabled
			//change post title
			$post_changes = self::do_retitle($post_changes, $new_filename);

			//update post in databse
			wp_update_post($post_changes);

			//avoid the file renaming process
			return 1;
			} else {
			//renaming is enabled

			$file_info = new pmr_file_info($attachment_id, $new_filename, $options, $post_parent_category);

			if (pmr_plugins::is_plugin_active(constant("pluginAmazonS3AndCloudfront"))) {
				//plugin is active
				add_filter('as3cf_get_attached_file_copy_back_to_local', '__return_true');
			}

			//attachment miniatures
			$searches = self::get_attachment_urls($attachment_id, Operation::search, $file_info, $file_info->new_filename);

			//Validations
			$validation_message = pmr_lib::validate_filename($post, $attachment_id, $options, $file_info);

			if ($validation_message != ''){
				//validation error: stop renaming process and notify user
				return $validation_message;
			} else {
				//validation passed, complete renaming process

				//change post data
				$post_changes['guid'] = preg_replace('~[^/]+$~', $file_info->new_filename . '.' . $file_info->file_extension, $post->guid);

				//Change post title
				//if action is "actionRenameFromPostTitle" retrieve title for post related to media file
				if ($retitle){
					$post_changes = self::do_retitle($post_changes, self::filename_to_title($file_info->new_filename_unsanitized));
				}elseif ($title_from_post){
					$post_changes['post_title'] = self::filename_to_title($post_parent->post_title);
				}else{
					$post_changes = self::do_retitle($post_changes, $post->post_title);
				}

				$post_changes['post_name'] = wp_unique_post_slug($file_info->new_filename, $post->ID, $post->post_status, $post->post_type, $post->post_parent);
				wp_update_post($post_changes);

				//rename file
				$error_message = self::rename_files($options, $post->ID, $file_info);

				if ( $error_message != ''){
					//filename failed: block the post update process
					return $error_message;
				}

				//delete thumbnails (they will be recreated)
				self::delete_files($attachment_id, $options);

				//update metadata for media file
				update_post_meta($attachment_id, '_wp_attached_file', $file_info->new_file_rel_path);

				$metas = self::update_metadata(wp_get_attachment_metadata($attachment_id), wp_generate_attachment_metadata($attachment_id, $file_info->new_file_abs_path), $attachment_id, $file_info);

				wp_update_attachment_metadata($attachment_id, $metas);

				// Replace the old with the new media link in the content of all posts and metas
				$replaces = self::get_attachment_urls($attachment_id, Operation::replace, $file_info, $file_info->new_filename);

				$post_types = get_post_types();

				//remove attachment from post type to be updated
				unset($post_types['attachment']);
				//remove revision from post type to be updated, revisions will be updated after posts to avoid loops
				unset($post_types['revision']);

				//updates posts content
				self::update_posts($post_types, $searches, $replaces);

				if ($options->option_update_revisions) {
					//update revisions, if option to update revisions is active
					$post_types['revision'] = array('post_type' => $post_types);
					self::update_posts($post_types, $searches, $replaces);
				}

				$options->update_options();

				do_action('pmr_renaming_successful', $file_info->file_old_filename, $file_info->new_filename);

				if (pmr_plugins::is_plugin_active(constant("pluginWPML"))) {
					//plugin is active
					//Updating WPML tables
					pmr_plugins::update_wpml($attachment_id);
				}

				if (pmr_plugins::is_plugin_active(constant("pluginSmartSlider3"))) {
					//plugin is active
					//Updating SmartSlider 3 tables
					pmr_plugins::update_smartslider($file_info->file_old_filename, $file_info->new_filename, $file_info->file_extension);
				}

				if (pmr_plugins::is_plugin_active(constant("pluginRedirection"))) {
					//plugin is active
					//Adding Redirection from old ORL to the new one
					pmr_plugins::add_redirection($file_info->file_old_filename, $file_info->new_filename, $file_info->file_extension, $file_info->file_subfolder, $options->option_create_redirection, constant("pluginRedirection"));
				}

				if (pmr_plugins::is_plugin_active(constant("pluginRankMath"))) {
					//plugin is active
					//Adding Redirection from old ORL to the new one
					pmr_plugins::add_redirection($file_info->file_old_filename, $file_info->new_filename, $file_info->file_extension, $file_info->file_subfolder, $options->option_create_redirection, constant("pluginRankMath"));
				}

				return 1;
			}
		}
	}

	/**
	 * Renames the files
	 *
	 * @param object $options Phoenix Media Rename options
	 * @param integer $post_id id of the post to update (post_type attachment)
	 * @param pmr_file_info $file_parts filename elements
	 * @return string error message
	 */
	private static function rename_files($options, $post_id, $file_info){
		$result = '';

		// Change attachment post metas & rename files
		if ($options->option_debug_mode){
			// //execute rename showing errors (if present)
			$result = self::rename_file_debug($file_info->file_abs_path, $file_info->new_file_abs_path, $file_info->new_filename, $post_id);

			if (($result == '') && ($file_info->original_filename)){
				//if original_image exists, rename also the original file
				$result = self::rename_file_debug($file_info->file_path . $file_info->original_filename . $file_info->filename_ends_with . '.' . $file_info->file_extension, $file_info->file_path . $file_info->new_filename . $file_info->filename_ends_with . '.' . $file_info->file_extension, $file_info->new_filename, $post_id);
			}
		} else {
			//execute rename hiding errors (if present)
			$result = self::rename_file($file_info->file_abs_path, $file_info->new_file_abs_path, $file_info->new_filename, $post_id);
			if (($result == '') && ($file_info->original_filename)){
				//if original_image exists, rename also the original file
				$result = self::rename_file($file_info->file_path . $file_info->original_filename . $file_info->filename_ends_with . '.' . $file_info->file_extension, $file_info->file_path . $file_info->new_filename . $file_info->filename_ends_with . '.' . $file_info->file_extension, $file_info->new_filename, $post_id);
			}
		}

		return $result;
	}

	/**
	 * Rename a file hiding errors (if present)
	 *
	 * @param string $file_abs_path full path of the file
	 * @param string $new_file_abs_path full path of the new file
	 * @param string $new_filename new name
	 * @param integer $post_id id of the post to update (post_type attachment)
	 * @return string error message
	 */
	static private function rename_file($file_abs_path, $new_file_abs_path, $new_filename, $post_id){
		$result = '';

		//copy old file to new one
		if (!@copy($file_abs_path, $new_file_abs_path)) {
			$result = __('File renaming error! Tried to copy ' . $file_abs_path . ' to ' . $new_file_abs_path);
		};

		update_attached_file($post_id , $new_filename);

		//delete old media file, thumbnails will be deleted later
		if (!@unlink($file_abs_path)) {
			$result = __('File renaming error! Tried to delete ' . $file_abs_path);
		};

		return $result;
	}

	/**
	 * Rename a file using debug output
	 *
	 * @param string $file_abs_path full path of the file
	 * @param string $new_file_abs_path full path of the new file
	 * @param string $new_filename new name
	 * @param integer $post_id id of the post to update (post_type attachment)
	 * @return string error message
	 */
	static private function rename_file_debug($file_abs_path, $new_file_abs_path, $new_filename, $post_id){
		$result = '';

		//read error reporting settings
		$error_level = error_reporting();
		$display_errors = ini_get('display_errors');

		//enable errors display
		error_reporting(E_ALL); 
		ini_set('display_errors', 1);

		try{
			//copy old file to new one
			if (!copy($file_abs_path, $new_file_abs_path)) {
				$result = __('File renaming error! Tried to copy ' . $file_abs_path . ' to ' . $new_file_abs_path);
			};

			update_attached_file($post_id, $new_filename);

			//delete old media file, thumbnails will be deleted later
			if (!unlink($file_abs_path)) {
				$result = __('File renaming error! Tried to delete ' . $file_abs_path);
			};
		}catch(exception $e){
			//reset error reporting settings
			error_reporting($error_level);
			ini_set('display_errors', $display_errors);

			//avoid to update posts due to renaming failure
			$result = __('File renaming error!');
		}

		//reset error reporting settings
		error_reporting($error_level);
		ini_set('display_errors', $display_errors);

		return $result;
	}

	/**
	 * Updates posts content to reflect new filename
	 *
	 * @param [type] $post_types array of post type to process
	 * @return void
	 */
	private static function update_posts($post_types, $searches, $replaces){
		$i=0;

		while ($posts = get_posts(array('post_type' => $post_types, 'post_status' => 'any', 'numberposts' => 100, 'offset' => $i * 100))) {
			foreach ($posts as $post) {
				// Updating post content if necessary
				$new_post = array('ID' => $post->ID);
				if ($post->post_content != ""){
					$new_post['post_content'] = str_replace('\\', '\\\\', $post->post_content);
					$new_post['post_content'] = str_replace($searches, $replaces, $new_post['post_content']);
				}
				try{
					if (array_key_exists('post_content', $new_post)){
						if ($new_post['post_content'] != $post->post_content) wp_update_post($new_post);
					}
				}catch(exception $e){
				}

				// Updating post metas if needed
				$metas = get_post_meta($post->ID);
				foreach ($metas as $key => $meta) {
					if (str_contains($key, '_elementor_')){
						pmr_plugins::update_elementor_data($post->ID, $key, $searches, $replaces);
					} else {
							//update wp_postmeta
							$meta[0] = pmr_lib::unserialize_deep($meta[0]);
							$new_meta = pmr_lib::replace_media_urls($meta[0], $searches, $replaces);
							if ($new_meta != $meta[0]) update_post_meta($post->ID, $key, $new_meta, $meta[0]);
					}
				}
			}

			$i++;
		}
	}

	/**
	 * Updates metadata array
	 *
	 * @param array $old_meta old metadata values
	 * @param array $new_meta new metadata values
	 * @param string $new_filename new name
	 * @param string $old_filename old name
	 * @param integer $attachment_id id of the post to update
	 * @param string $file_path path of the file
	 * @param array $file_parts filename elements
	 * 
	 * @return array
	 */
	static function update_metadata($old_meta, $new_meta, $attachment_id, $file_info){//, $new_filename, $old_filename, $file_path, $file_parts){
		$result = $old_meta;

		//update ShortPixel thumbnails data
		$result = pmr_plugins::update_shortpixel_metadata($result, $file_info->file_old_filename, $file_info->new_filename, $attachment_id, $file_info->file_path);

		//replace original filename (needed to ensure correct wp-cli management of thumbnails renegeration)
		if (array_key_exists('original_image', $result)){
			$result['original_image'] = $file_info->new_filename . '.' . $file_info->file_extension;
			}

		//add the code to rename original file (if exists)

		foreach ($new_meta as $key => $value) {
			switch ($key){
				case 'file':
					//change the file name in meta
					$result[$key] = $value;
					break;
				case 'sizes':
					//change the file name in miniatures
					$result[$key] = $value;
					break;
				default:
					if (is_array($result)){
						//$result is an array
						if (! array_key_exists($key, $result)){
							//add missing keys (if needed)
							// array_push($result[$key], $value);
							$result[$key] = $value;
						}
					} else {
						//$result is not an array
						$result[$key] = $value;
					}

			}
		}

		return $result;
	}

	/**
	 * Delete thumbnail files from upload folder
	 *
	 * @param integer $attachment_id id of the post of the media file (post_type: attachment)
	 * @param array $$option_debug_mode true: enable debug messages, false: disable debug messages
	 * @return void
	 */
	static function delete_files($attachment_id, $option_debug_mode){
		$uploads_path = wp_upload_dir();
		//use 'basedir' because $size_data['path'] contains relative path for each file (needed when year/month subfolder structure is changed)
		$uploads_path = $uploads_path['basedir'];

		foreach (get_intermediate_image_sizes() as $size) {
			$size_data = image_get_intermediate_size($attachment_id, $size);
			if (is_bool($size_data)){
				//image intermediate sizes not found
			} else {
				if (! array_key_exists('file', $size_data)){
					//array key is missing
					if ($option_debug_mode){
						echo 'array key is missing';
					}
				} else{
					if ($size_data['file'] == ''){
						//filename is missing
						if ($option_debug_mode){
							echo 'filename is missing';
						}
					} else {
						//delete the file
						@unlink (realpath($uploads_path . DIRECTORY_SEPARATOR . $size_data['path']));
					}
				}
			}
		}
	}

#region support functions

	/**
	 * add support for calling Phoenix Media Rename from frontend
	 *
	 * @return boolean
	 */
	static function frontend_support(){
		if (! function_exists('wp_crop_image')) {
			include(ABSPATH . 'wp-admin/includes/image.php');
		}
	}

	/**
	 * Adds more problematic characters to the "sanitize_file_name_chars" filter
	 *
	 * @param string $special_chars
	 * @return void
	 */
	static function add_special_chars($special_chars) {
		//can't add . to character list: due to bad implementation in WordPress core this would cause images to lose file extension
		return array_merge($special_chars, array('%', '^', ',', '–'));
	}

	/**
	 * Returns the attachment URL and sizes URLs, in case of an image
	 *
	 * @param integer $attachment_id id of the attachement to change
	 * @param boolean $remove_suffix true: remove the -scaled suffix
	 * @param Operation $operation kind of operation (Search/Replace)
	 * @param pmr_file_info $file_parts filename elements
	 * @param string $new_filename the new filename
	 * @return array
	 */
	static function get_attachment_urls($attachment_id, $operation, $file_parts, $new_filename) {
		$urls = array(wp_get_attachment_url($attachment_id));

		if (wp_attachment_is_image($attachment_id)) {

			if ($file_parts->original_filename){
				//if original_image exists, rename also the original file
				if (($operation == Operation::search)) {
					//if operation is replace, replace original filename with the new one
					$urls[] = $file_parts->base_url . '/' . $file_parts->original_filename . '.' . $file_parts->file_extension;
				} else {
					$urls[] = self::generate_full_filename($file_parts, $new_filename);
				}
			}

			foreach (get_intermediate_image_sizes() as $size) {
				$image = wp_get_attachment_image_src($attachment_id, $size);
				$urls[] = $image[0];
			}
		}

		return array_unique($urls);
	}

	/**
	 * Generate full filename (path + filename) for a file
	 *
	 * @param pmr_file_info $file_parts filename elements
	 * @param string $new_filename the new filename (without extension)
	 * @return string the new full filename
	 */
	static private function generate_full_filename($file_parts, $new_filename){
		$result = $file_parts->base_url . '/' . $new_filename . '.' . $file_parts->file_extension;

		return $result;
	}

	/**
	 * Convert filename to post title
	 *
	 * @param string $filename
	 * @return string post title
	 */
	static function filename_to_title($filename) {
		return $filename;
	}

#endregion
}

/**
 * Polyfill for compatibility with old PHP versions (less than 7)
 */
if (!function_exists('is_countable')) {
	function is_countable($var) {
		return (is_array($var) || $var instanceof Countable);
	}
}

/**
 * Polyfill for compatibility with old PHP versions (less than 8)
 */
if (!function_exists('str_contains')) {
	function str_contains (string $haystack, string $needle) {
		return empty($needle) || strpos($haystack, $needle) !== false;
	}
}

#region class file_info
class pmr_file_info{
	public $base_url;
	public $file_path;
	public $file_subfolder;
	public $file_old_filename;
	public $filename_ends_with;
	public $file_extension;
	public $file_edited;
	public $filename;
	public $original_filename;
	public $new_filename;
	public $new_filename_unsanitized;
	public $file_abs_path;
	public $file_abs_dir;
	public $file_rel_path;
	public $new_file_rel_path;
	public $new_file_abs_path;

	/**
	 * Class constructor
	 *
	 * @param integer $attachment_id ID of the post of the media file (post_type: attachment)
	 * @param string $new_filename new file name
	 * @param pmr_options $options Phoenix Media Rename options
	 * @param string $post_parent_category name of the main category of the post parent
	 */
	public function __construct($attachment_id, $new_filename, $options, $post_parent_category){
		$file_parts = pmr_lib::get_file_parts($attachment_id);
		$this->new_filename_unsanitized = $new_filename;
		$this->base_url = $file_parts['baseurl'];
		$this->file_path = $file_parts['filepath'];
		$this->file_subfolder = $file_parts['subfolder'];
		$this->file_old_filename = $file_parts['filename'];
		$this->filename_ends_with = $file_parts['endswith'];
		$this->file_extension = $file_parts['extension'];
		$this->file_edited = $file_parts['edited'];
		$this->filename = $file_parts['filename'];
		$this->original_filename = $file_parts['originalfilename'];
		$this->new_filename = $new_filename;
		$this->new_filename = pmr_lib::clear_filename($options, $post_parent_category, $this);

		$this->file_abs_path = $this->file_path . $this->file_old_filename . '.' .$this->file_extension;
		$this->file_abs_dir = $this->file_path;
		$this->file_rel_path = $this->file_subfolder . $this->file_old_filename . '.' .$this->file_extension;

		$this->new_file_rel_path = preg_replace('~[^/]+$~', $this->new_filename . '.' . $this->file_extension, $this->file_rel_path);
		$this->new_file_abs_path = preg_replace('~[^/]+$~', $this->new_filename . '.' . $this->file_extension, $this->file_abs_path);
		}
}
