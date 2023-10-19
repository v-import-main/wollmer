<?php
/*
* support functions
*
*/

class pmr_lib{

	/**
	 * Generate the complete filename and sanitize it (if required)
	 *
	 * @param pmr_options $options Phoenix Media Rename options
	 * @param string $new_filename new name for the media file
	 * @param bool $file_edited true: file has been edited
	 * @param string $file_filename_ends_with file suffix added by WordPress (-scaled)
	 * @param string $file_extension file extension (file type)
	 * @param string $file_subfolder name of the subfolder containing the file
	 * @param string $post_parent_category name of the main category of the post parent
	 * @return string
	 */
	public static function clear_filename($options, $post_parent_category, $file_info){// $file_edited, $file_filename_ends_with, $file_extension, $file_subfolder){
		$result = $file_info->new_filename;

		//sanitizing file name (using sanitize_title because sanitize_file_name doesn't remove accents)
		if ($options->option_remove_accents){
			$result = remove_accents($result);
		} else{
			//accent removal disabled by user
		}

		//add post parent's category name to header
		if ($options->option_category_filename_header){
			$filename_header = $post_parent_category;
		} else{
			//no post parent's category name
		}

		//add user selected header to filename
		if ($options->option_filename_header){
			$filename_header .= " " . $options->option_filename_header;
		} else{
			//no header entered by user
		}

		//add header to filename only if it is not already present
		if (($options->option_category_filename_header || $options->option_filename_header != "")
			&& (stripos($result, $filename_header) !== 0)
			&& (stripos($result, sanitize_file_name($filename_header)) !== 0)){
			$result = $filename_header . ' ' . $result;
		} else{
			//no header or header already present
		}

		//add user selected trailer to filename
		if ($options->option_filename_trailer){
			$filename_trailer = $options->option_filename_trailer;
		} else{
			//no trailer entered by user
		}

		//add post parent's category name to trailer
		if ($options->option_category_filename_trailer){
			$filename_trailer .= " " . $post_parent_category;
		} else{
			//no post parent's category name
		}

		//add trailer to filename only if it is not already present
		if (($options->option_category_filename_trailer || $options->option_filename_trailer != "")
		&& ! (pmr_lib::ends_with($result, $filename_trailer))
		&& ! (pmr_lib::ends_with($result, sanitize_file_name($filename_trailer)))){
			$result = $result . ' ' . $filename_trailer;
		} else{
			//no trailer entered by user
		}

		if ($options->option_sanitize_filename){
			$result = sanitize_file_name($result);
		} else{
			//sanitization disabled by user
		}

		//serialize filename if option is enabled
		if ($options->option_serialize_if_filename_present){
			$result = self::serialize_if_file_exists($result, $file_info->file_extension, $file_info->file_subfolder);
		} else{
			//don't serialize filename: can result in "filename already exists" error
		}

		//force lowercase if requested
		if ($options->option_convert_to_lowercase){
			$result = strtolower($result);
		}

		try{
			if (pmr_plugins::is_plugin_active(constant("pluginArchivarixExternalImagesImporter"))) {
				//plugin is active, remove last . added by archivarix
				$result = rtrim($result, '.');
			}
		}catch(exception $e){
		}

		return $result;
	}

	/**
	 * Validate filename
	 *
	 * @param WP_Post $post WordPress post object
	 * @param integer $attachment_id ID of the post to update
	 * @param pmr_options $options Phoenix Media Rename options
	 * @param pmr_file_info $file_info filename elements
	 * @return string error message
	 */
	public static function validate_filename($post, $attachment_id, $options, $file_info){
		//check if old file still exists
		if (! file_exists($file_info->file_abs_path)) return __('Can\'t find original file in the folder. Tried to rename ' . $file_info->file_abs_path, constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));

		//check if post containing media file exists
		if (!$post) return __('Post with ID ' . $attachment_id . ' does not exist!');

		//check if type of post containing media file is "attachment"
		if ($post && $post->post_type != 'attachment') return __('Post with ID ' . $attachment_id . ' is not an attachment!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));

		//check if new filename has been compiled
		if (!$file_info->new_filename) return __('The field is empty!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));

		//check if new filename contains bad characters
		if ($options->option_remove_accents){
			if ($file_info->new_filename != remove_accents($file_info->new_filename)) return __('Bad characters or invalid filename!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));
		}else{
			//accent removal disabled by user
		}

		if ($options->option_sanitize_filename){
			if ($file_info->new_filename != sanitize_file_name($file_info->new_filename)) return __('Bad characters or invalid filename!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));
		}else{
			//filename sanitizazion disabled by user
		}

		//check if destination folder already contains a file with the target filename
		if (file_exists($file_info->new_file_abs_path)) return __('A file with that name already exists in the containing folder!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));

		//check if destination folder is writable
		if (!is_writable(realpath($file_info->file_abs_dir))) return __('The media containing directory is not writable!', constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'));

		return '';
	}

	/**
	 * Get filename parts
	 *
	 * @param integer $post_id id of the post of the media file (post_type: attachment)
	 * @return array
	 */
	public static function get_file_parts($post_id) {
		$filename = self::get_filename($post_id);

		return self::file_parts($filename, $post_id);
	}

	/**
	 * Extract filename and extension
	 *
	 * @param string $filename name of the file
	 * @param integer $post_id ID of the post of the media file (post_type: attachment)
	 * @return array
	 */
	public static function file_parts($filename, $post_id){
		//read post meta to check if image has been edited
		$post_meta = get_post_meta($post_id, '_wp_attachment_metadata', 1);
		$file_path = wp_upload_dir();

		if (isset($post_meta['original_image'])){
			$edited = true;
			$original_filename = $post_meta['original_image'];

			//separate filename
			preg_match('~([^/]+)\.([^\.]+)$~', self::esl_basename($original_filename), $original_file_parts);

			//check if filename has been correctly separeted
			if ((is_array($original_file_parts)) && (sizeof($original_file_parts) > 0)){
				$original_filename = $original_file_parts[1];
			} else {
				$original_filename = "";
			}
		} else {
			$edited = false;
			$original_filename = "";
		}

		//separate filename and extension
		preg_match('~([^/]+)\.([^\.]+)$~', self::esl_basename($filename), $file_parts);

		$filepath = str_replace(self::esl_basename($filename), '', $filename);
		$subfolder = str_replace($file_path['basedir'], '', $filepath);

		//remove first slash from subfolder (it breaks image metadata)
		if (strlen($subfolder) > 0){
			if (substr($subfolder, 0, 1) == '/') {
				$subfolder = substr($subfolder, 1, strlen($subfolder) -1);
			}
		}

		if ((! is_array($file_parts)) || (sizeof($file_parts) < 2)){
			//file name or extension is missing
			echo "file name or extension is missing";
			$result = array(
				'filepath'			=> $filepath,
				'subfolder'			=> $subfolder,
				'filename'			=> "",
				'extension'			=> "",
				'endswith'			=> "",
				'edited'			=> $edited,
				'originalfilename'	=> $original_filename,
				'baseurl'			=> $file_path['baseurl']
			);
		} else {
			$filename = $file_parts[1];

			//check if filename ends with "-scaled"
			if (($edited) && (self::ends_with($file_parts[1], '-scaled'))) {
				$endsWith = '-scaled';
				$filename = preg_replace('/-scaled$/', '', $filename);
			} else {
				$endsWith = '';
			}

			$result = array(
				'filepath'			=> $filepath,
				'subfolder'			=> $subfolder,
				'filename'			=> $filename,
				'extension'			=> $file_parts[2],
				'endswith'			=> $endsWith,
				'edited'			=> $edited,
				'originalfilename'	=> $original_filename,
				'baseurl'			=> $file_path['baseurl']
			);
		}

		return $result;
	}

	/**
	 * Get attachment filename
	 *
	 * @param integer $post_id
	 * @return void
	 */
	public static function get_filename($post_id) {
		$filename = get_attached_file($post_id);

		return $filename;
	}

	/**
	 * Search a substring at the start of a string
	 *
	 * @param string $haystack string to search in
	 * @param string $needle string to be found
	 * @return string the match if found (i.e. $haystack = '0001523', $needle = '0', returns '000'), -1 otherwise
	 */
	public static function starts_with($haystack, $needle) {
		$re = '/^[' . $needle . ']+/i';

		if (preg_match($re, $haystack, $matches, PREG_OFFSET_CAPTURE)){
			return $matches[0][0];
		} else {
			return -1;
		}
	}

	/**
	 * Check if strings ends with a sequence of characters
	 *
	 * @param string $haystack string to search in
	 * @param string $needle string to be found
	 * @return bool true if $haystack ens with $needle
	 */
	public static function ends_with($haystack, $needle) {
		$length = strlen($needle);

		if(!$length) {
			//$needle is empty
			$result = true;
		} else {
			if (strcasecmp(substr($haystack, -$length), $needle) == 0){
				//$haystack ends with $needle
				$result = true;
			} else {
				$result = false;
			}
		}

		return $result;
	}

	/**
	 * Replace the media url and fix serialization if necessary
	 *
	 * @param array $subj metadata to update
	 * @param string $searches strings to search
	 * @param string $replaces new values for strings
	 * @return array
	 */
	public static function replace_media_urls($subj, &$searches, &$replaces) {
		$subj = is_object($subj) ? clone $subj : $subj;

		if (!is_scalar($subj) && is_countable($subj) && count($subj)) {
			//iterates elements and replace old filename with new one
			//code suggested by alx359
			foreach($subj as $key => $f) {
				$item = &$subj[$key];
				$item = self::replace_media_urls($item, $searches, $replaces);
		 }

		} else {
			$subj = is_string($subj) ? str_replace($searches, $replaces, $subj) : $subj;
		}
		
		return $subj;
	}

	/**
	 * Unserializes a variable until reaching a non-serialized value
	 *
	 * @param string $var
	 * @return void
	 */
	public static function unserialize_deep($var) {
		while (is_serialized($var)) {
			$var = @unserialize($var);
		}

		return $var;
	}

	/**
	 * Check if table exists
	 *
	 * @param string $tablename
	 * @return boolean
	 */
	public static function table_exist($tablename){
		global $wpdb;

		if($wpdb->get_var("SHOW TABLES LIKE '$tablename'") == $tablename){
			//table is not present
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Prints the javascript used by Phoenix Media Rename options page
	 */
	public static function print_options_js(){
		if(get_current_screen() -> id == 'settings_page_pmr-setting-admin') {
			wp_enqueue_script(constant('PHOENIX_MEDIA_RENAME_TEXT_DOMAIN'), plugins_url('js/options.min.js', __FILE__), array('jquery'), '1.0.0');
		}
	}

	
	/**
	 * Create a unique filename
	 *
	 * @param string $filename: filename
	 * @param string $extension: filename extension
	 * @param string $file_subfolder: folder containing the file
	 * @return void
	 */
	private static function serialize_if_file_exists($filename, $extension, $file_subfolder){
		clearstatcache();

		//check normal and lowercase filename to ensure compatibility with case insensitive file systems
		while (
			(file_exists(wp_upload_dir()['basedir'] . '/' . $file_subfolder . $filename . '.' . $extension))
			||
			(file_exists(strtolower(wp_upload_dir()['basedir'] . '/' . $file_subfolder . $filename . '.' . $extension)))
			) {
			//filename exists: create a new filename
			$filename = self::increment_filename($filename);
		}

		return $filename;
	}

	/**
	 * Wraps php basename function
	 *
	 * @param string $full_name
	 * @return string
	 */
	private static function esl_basename($full_name) {
		return rawurldecode(basename($full_name));
	}

	/**
	 * Add a progessive number to the filename
	 *
	 * @param string $filename
	 * @return void
	 */
	private static function increment_filename($filename){
		//if filename ends with '-scaled', remove the string
		if (pmr_lib::ends_with($filename, '-scaled')){
			$filename = substr($filename, 0, strlen($filename) - strlen('-scaled'));
			$add_suffix = true;
		} else {
			$add_suffix = false;
		}

		//check if filename ends with a number
		$pattern = '(\d+$)';

		preg_match($pattern, $filename, $matches);

		if ($matches){
			//filename ends with a number: increase the value
			$number = $matches[0];
			$number++;

			$filename = preg_replace($pattern, $number, $filename);
		} else {
			//filename doesn't end with a number: add it
			$filename .= '-1';
		}

		//restore '-scaled' suffix if it was present
		if ($add_suffix){
			$filename .= '-scaled';
		}

		return $filename;
	}

}