<?php
/*
Plugin Name: Frontend Uploader
Description: Allow your visitors to upload content and moderate it.
Author: Rinat Khaziev, Daniel Bachhuber
Version: 0.6
Author URI: http://digitallyconscious.com

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

// Define consts and bootstrap and dependencies
define( 'FU_VERSION', '0.6.1-working' );
define( 'FU_ROOT' , dirname( __FILE__ ) );
define( 'FU_FILE_PATH' , FU_ROOT . '/' . basename( __FILE__ ) );
define( 'FU_URL' , plugins_url( '/', __FILE__ ) );

require_once FU_ROOT . '/lib/php/class-frontend-uploader-wp-media-list-table.php';
require_once FU_ROOT . '/lib/php/class-frontend-uploader-wp-posts-list-table.php';
require_once FU_ROOT . '/lib/php/class-html-helper.php';
require_once FU_ROOT . '/lib/php/settings-api/class.settings-api.php';
require_once FU_ROOT . '/lib/php/functions.php';
require_once FU_ROOT . '/lib/php/frontend-uploader-settings.php';

class Frontend_Uploader {

	public $allowed_mime_types;
	public $html;
	public $settings;
	public $settings_slug = 'frontend_uploader_settings';
	public $is_debug = false;
	public $form_fields = array();
	protected $manage_permissions = array();

	/**
	 * Here we go
	 *
	 * Instantiating the plugin, adding actions, filters, and shortcodes
	 */
	function __construct() {
		// Init
		add_action( 'init', array( $this, 'action_init' ) );

		// HTML helper to render HTML elements
		$this->html = new Html_Helper;

		// Either use default settings if no setting set, or try to merge defaults with existing settings
		// Needed if new options were added in upgraded version of the plugin
		$this->settings = array_merge( $this->settings_defaults(), (array) get_option( $this->settings_slug, $this->settings_defaults() ) );
		register_activation_hook( __FILE__, array( $this, 'activate_plugin' ) );

		/**
		 * Should consist of fields to be proccessed automatically on content submission
		 *
		 * @todo this is just a pass one
		 *
		 * Example field:
		 *  array(
		 *  'name' => '{form name}',
		 *  'element' => HTML element,
		 *  'role' => {title|description|content|file|meta|internal} )
		 * @var array
		 */
		$this->form_fields = array();
	}

	/**
	 *  Load languages and a bit of paranoia
	 */
	function action_init() {

		load_plugin_textdomain( 'frontend-uploader', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		// Hooking to wp_ajax

		add_action( 'wp_ajax_approve_ugc', array( $this, 'approve_photo' ) );
		add_action( 'wp_ajax_approve_ugc_post', array( $this, 'approve_post' ) );
		add_action( 'wp_ajax_delete_ugc', array( $this, 'delete_post' ) );

		add_action( 'wp_ajax_upload_ugc', array( $this, 'upload_content' ) );
		add_action( 'wp_ajax_nopriv_upload_ugc', array( $this, 'upload_content' ) );

		// Adding media submenu
		add_action( 'admin_menu', array( $this, 'add_menu_items' ) );

		// Currently supported shortcodes
		add_shortcode( 'fu-upload-form', array( $this, 'upload_form' ) );
		add_shortcode( 'input', array( $this, 'shortcode_content_parser' ) );
		add_shortcode( 'textarea', array( $this, 'shortcode_content_parser' ) );
		add_shortcode( 'select', array( $this, 'shortcode_content_parser' ) );

		// Static assets
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Unautop the shortcode
		add_filter( 'the_content', 'shortcode_unautop', 100 );
		// Hiding not approved attachments from Media Gallery
		// @since core 3.5-beta-1
		add_filter( 'posts_where', array( $this, 'filter_posts_where' ) );


		$this->allowed_mime_types = $this->_get_mime_types();
		// Configuration filter to change manage permissions
		$this->manage_permissions = apply_filters( 'fu_manage_permissions', 'edit_posts' );
		// Debug mode filter
		$this->is_debug = (bool) apply_filters( 'fu_is_debug', defined( 'WP_DEBUG' ) && WP_DEBUG );

		add_filter( 'upload_mimes', array( $this,  '_get_mime_types' ), 999 );
	}

	function _get_mime_types() {
		// Use wp_get_mime_types if available, fallback to get_allowed_mime_types()
		$mime_types = function_exists( 'wp_get_mime_types' ) ? wp_get_mime_types() : get_allowed_mime_types() ;
		$fu_mime_types = fu_get_mime_types();
		// Workaround for IE
		$mime_types['jpg|jpe|jpeg|pjpg'] = 'image/pjpeg';
		$mime_types['png|xpng'] = 'image/x-png';
		// Iterate through default extensions
		foreach ( $fu_mime_types as $extension => $details ) {
			// Skip if it's not in the settings
			if ( !in_array( $extension, $this->settings['enabled_files'] ) )
				continue;

			// Iterate through mime-types for this extension
			foreach ( $details['mimes'] as $ext_mime ) {
				$mime_types[ $extension . '|' . $extension . sanitize_title_with_dashes( $ext_mime ) ] = $ext_mime;
			}
		}
		// Configuration filter: fu_allowed_mime_types should return array of allowed mime types (see readme)
		$mime_types = apply_filters( 'fu_allowed_mime_types', $mime_types );

		foreach ( $mime_types as $ext_key => $mime ) {
			// Check for php just in case
			if ( false !== strpos( $mime, 'php' ) )
				unset( $mime_types[$ext_key] );
		}
		return $mime_types;
	}

	/**
	 * Ensure we're not producing any notices by supplying the defaults to get_option
	 *
	 * @return array $defaults
	 */
	function settings_defaults() {
		$defaults = array();
		$settings = Frontend_Uploader_Settings::get_settings_fields();
		foreach ( $settings[$this->settings_slug] as $setting ) {
			$defaults[ $setting['name'] ] = $setting['default'];
		}
		return $defaults;
	}

	function activate_plugin() {
		global $wp_version;
		if ( version_compare( $wp_version, '3.3', '<' ) ) {
			wp_die( __( 'Frontend Uploader requires WordPress 3.3 or newer. Please upgrade.', 'frontend-uploader' ) );
		}

		$defaults = $this->settings_defaults();
		$existing_settings = (array) get_option( $this->settings_slug, $this->settings_defaults() );
		update_option( $this->settings_slug, array_merge( $defaults, (array) $existing_settings ) );
	}

	/**
	 * Since WP 3.5-beta-1 WP Media interface shows private attachments as well
	 * We don't want that, so we force WHERE statement to post_status = 'inherit'
	 *
	 * @since  0.3
	 *
	 * @param string  $where WHERE statement
	 * @return string WHERE statement
	 */
	function filter_posts_where( $where ) {
		if ( !is_admin() || !function_exists( 'get_current_screen' ) )
			return $where;

		$screen = get_current_screen();
		if ( ! defined( 'DOING_AJAX' ) && $screen->base == 'upload' && ( !isset( $_GET['page'] ) || $_GET['page'] != 'manage_frontend_uploader' ) ) {
			$where = str_replace( "post_status = 'private'", "post_status = 'inherit'", $where );
		}
		return $where;
	}

	/**
	 * Determine if we should autoapprove the submission or not
	 *
	 * @return boolean [description]
	 */
	function _is_public() {
		return  ( current_user_can( 'read' ) && 'on' == $this->settings['auto_approve_user_files'] ) ||  ( 'on' == $this->settings['auto_approve_any_files'] );
	}

	/**
	 * Handle uploading of the files
	 *
	 * @since  0.4
	 *
	 * @uses media_handle_sideload Don't even know why
	 *
	 * @param int     $post_id Parent post id
	 * @return array Combined result of media ids and errors if any
	 */
	function _upload_files( $post_id ) {
		$media_ids = $errors = array();
		// Bail if there are no files
		if ( empty( $_FILES ) )
			return false;

		// File field name could be user defined, so we just get the first file
		$files = current( $_FILES );

		for ( $i = 0; $i < count( $files['name'] ); $i++ ) {
			$fields = array( 'name', 'type', 'tmp_name', 'error', 'size' );
			foreach ( $fields as $field ) {
				$k[$field] = $files[$field][$i];
			}

			$k['name'] = sanitize_file_name( $k['name'] );

			// Skip to the next file if upload went wrong
			if ( $k['tmp_name'] == "" ) {
				continue;
			}

			// Add an error message if MIME-type is not allowed
			if ( ! in_array( $k['type'], (array) $this->allowed_mime_types ) ) {
				$errors['fu-disallowed-mime-type'][] = array( 'name' => $k['name'], 'mime' => $k['type'] );
				continue;
			}

			// Setup some default values
			// However, you can make additional changes on 'fu_after_upload' action
			$caption = '';

			// Try to set post caption if the field is set on request
			// Fallback to post_content if the field is not set
			// @todo remove this in v0.6 when automatic handling of shortcode attributes is implemented
			if ( isset( $_POST['caption'] ) )
				$caption = sanitize_text_field( $_POST['caption'] );
			elseif ( isset( $_POST['post_content'] ) )
				$caption = sanitize_text_field( $_POST['post_content'] );
			// @todo remove or refactor
			$filename = !empty( $this->settings['default_file_name'] ) ? $this->settings['default_file_name'] : pathinfo( $k['name'], PATHINFO_FILENAME );
			$post_overrides = array(
				'post_status' => $this->_is_public() ? 'publish' : 'private',
				'post_title' => isset( $_POST['post_title'] ) && ! empty( $_POST['post_title'] ) ? sanitize_text_field( $_POST['post_title'] ) : $filename,
				'post_content' => empty( $caption ) ? __( 'Unnamed', 'frontend-uploader' ) : $caption,
				'post_excerpt' => empty( $caption ) ? __( 'Unnamed', 'frontend-uploader' ) :  $caption,
			);

			// Trying to upload the file
			$upload_id = media_handle_sideload( $k, (int) $post_id, $post_overrides['post_title'], $post_overrides );
			if ( !is_wp_error( $upload_id ) )
				$media_ids[] = $upload_id;
			else
				$errors['fu-error-media'][] = $k['name'];
		}

		$success = empty( $errors ) && !empty( $media_ids ) ? true : false;
		// Allow additional setup
		// Pass array of attachment ids
		do_action( 'fu_after_upload', $media_ids, $success );
		return array( 'success' => $success, 'media_ids' => $media_ids, 'errors' => $errors );
	}

	function get_value_for_role( $role = 'meta', $name = '', $fallback = '' ) {

	}

	/**
	 * Handle post uploads
	 *
	 * @since 0.4
	 */
	function _upload_post() {
		$errors = array();
		$success = true;

		// Construct post array;
		$post_array = array(
			'post_type' =>  isset( $_POST['post_type'] ) && in_array( $_POST['post_type'], $this->settings['enabled_post_types'] ) ? $_POST['post_type'] : 'post',
			'post_title'    => isset( $_POST['caption'] ) ? sanitize_text_field( $_POST['caption'] )  : sanitize_text_field( $_POST['post_title'] ),
			'post_content'  => wp_filter_post_kses( $_POST['post_content'] ),
			'post_status'   => $this->_is_public() ? 'publish' : 'private',
		);

		// Determine if we have a whitelisted category
		$allowed_categories = array_filter( explode( ",", str_replace( " ", "",  $this->settings['allowed_categories'] ) ) );

		if (  isset( $_POST['post_category'] ) && in_array( $_POST['post_category'], $allowed_categories ) ) {
			$post_array = array_merge( $post_array, array( 'post_category' => array( (int) $_POST['post_category'] ) ) );
		}

		$author = isset( $_POST['post_author'] ) ? sanitize_text_field( $_POST['post_author'] ) : '';
		$users = get_users( array(
				'search' => $author,
				'fields' => 'ID'
			) );

		if ( isset( $users[0] ) ) {
			$post_array['post_author'] = (int) $users[0];
		}

		$post_id = wp_insert_post( $post_array, true );
		// Something went wrong
		if ( is_wp_error( $post_id ) ) {
			$errors[] = 'fu-error-post';
			$success = false;
		} else {
			do_action( 'fu_after_create_post', $post_id );
			// If the author name is not in registered users
			// Save the author name if it was filled and post was created successfully
			if ( $author )
				add_post_meta( $post_id, 'author_name', $author );
		}

		return array( 'success' => $success, 'post_id' => $post_id, 'errors' => $errors );
	}

	/**
	 * Handle post, post+media, or just media files
	 *
	 * @since  0.4
	 */
	function upload_content() {
		$fields = array();



		// Bail if something fishy is going on
		if ( !wp_verify_nonce( $_POST['fu_nonce'], FU_FILE_PATH ) ) {
			wp_safe_redirect( add_query_arg( array( 'response' => 'fu-error', 'errors' =>  'nonce-failure' ), wp_get_referer() ) );
			exit;
		}

		$layout = isset( $_POST['form_layout'] ) && !empty( $_POST['form_layout'] ) ? $_POST['form_layout'] : 'image';
		switch ( $layout ) {

		// Upload the post
		case 'post':
			$result = $this->_upload_post();
			break;
		// Upload the post first, and then upload media and attach to the post
		case 'post_image':
		case 'post_media';
			$response = $this->_upload_post();
			if ( ! is_wp_error( $response['post_id'] ) ) {
				$result = $this->_upload_files( $response['post_id'] );
				$result = array_merge( $result, $response );
			}
			break;
		// Upload media 
		case 'image':
		case 'media':

			if ( isset( $_POST['post_ID'] ) && 0 !== $pid = (int) $_POST['post_ID'] ) {
				$result = $this->_upload_files( $pid );
			}

			break;
		}
		// Notify the admin via email 
		$this->_notify_admin( $result );

		// Handle error and success messages, and redirect
		$this->_handle_result( $result );
		exit;
	}

	/**
	 * Notify site administrator by email
	 */
	function _notify_admin( $result = array() ) {
		// Notify site admins of new upload
		if ( ! ( 'on' == $this->settings['notify_admin'] && $result['success'] ) )
			return;
		// @todo It'd be nice to add the list of upload files
		$to = !empty( $this->settings['notification_email'] ) && filter_var( $this->settings['notification_email'], FILTER_VALIDATE_EMAIL ) ? $this->settings['notification_email'] : get_option( 'admin_email' );
		$subj = __( 'New content was uploaded on your site', 'frontend-uploader' );
		wp_mail( $to, $subj, $this->settings['admin_notification_text'] );

	}

	/**
	 * Process response from upload logic
	 *
	 * @since  0.4
	 */
	function _handle_result( $result = array() ) {
		// Redirect to referrer if repsonse is malformed
		if ( empty( $result ) || !is_array( $result ) ) {
			wp_safe_redirect( wp_get_referer() );
			return;
		}

		$errors_formatted = array();
		// Either redirect to success page if it's set and valid
		// Or to referrer
		$url = isset( $_POST['success_page'] ) && filter_var( $_POST['success_page'], FILTER_VALIDATE_URL ) ? $_POST['success_page'] : wp_get_referer();

		// $query_args will hold everything that's needed for displaying notices to user
		$query_args = array();

		// Account for successful uploads
		if ( isset( $result['success'] ) && $result['success'] ) {
			// If it's a post
			if ( isset( $result['post_id'] ) )
				$query_args['response'] = 'fu-post-sent';
			// If it's media uploads
			if ( isset( $result['media_ids'] ) && !isset( $result['post_id'] ) )
				$query_args['response'] = 'fu-sent';
		}


		// Some errors happened
		// Format a string to be passed as GET value
		if ( !empty( $result['errors'] ) ) {
			$query_args['response'] = 'fu-error';
			$_errors = array();

			// Iterate through key=>value pairs of errors
			foreach ( $result['errors'] as $key => $error ) {

				// Do not display mime-types in production
				if ( !$this->is_debug && isset( $error[0]['mime'] ) )
					unset( $error[0]['mime'] );
				if ( isset( $error[0] ) )
					$_errors[$key] = join( ',,,', (array) $error[0] );
			}

			foreach ( $_errors as $key => $value ) {
				$errors_formatted[] = "{$key}:{$value}";
			}

			$query_args['errors'] = join( ';', $errors_formatted );
		}

		wp_safe_redirect( add_query_arg( array( $query_args ) , $url ) );
	}

	/**
	 * Render various admin template files
	 *
	 * @param string  $view file slug
	 * @since 0.4
	 */
	function render( $view = '' ) {
		if ( empty( $view ) )
			return;

		$file = FU_ROOT . "/lib/views/{$view}.tpl.php";
		if ( file_exists( $file ) )
			require $file;
	}

	/**
	 * Display media list table
	 *
	 * @return [type] [description]
	 */
	function admin_list() {
		$this->render( 'manage-ugc-media' );
	}

	/**
	 * Display posts/custom post types table
	 *
	 * @return [type] [description]
	 */
	function admin_posts_list() {
		$this->render( 'manage-ugc-posts' );
	}

	/**
	 * Add submenu items
	 */
	function add_menu_items() {
		add_media_page( __( 'Manage UGC', 'frontend-uploader' ), __( 'Manage UGC', 'frontend-uploader' ), $this->manage_permissions, 'manage_frontend_uploader', array( $this, 'admin_list' ) );
		foreach ( (array) $this->settings['enabled_post_types'] as $cpt ) {
			if ( $cpt == 'post' ) {
				add_posts_page( __( 'Manage UGC Posts', 'frontend-uploader' ), __( 'Manage UGC', 'frontend-uploader' ), $this->manage_permissions, 'manage_frontend_uploader_posts', array( $this, 'admin_posts_list' ) );
				continue;
			}

			add_submenu_page( "edit.php?post_type={$cpt}", __( 'Manage UGC Posts', 'frontend-uploader' ), __( 'Manage UGC', 'frontend-uploader' ), $this->manage_permissions, "manage_frontend_uploader_{$cpt}s", array( $this, 'admin_posts_list' ) );
		}
	}

	/**
	 * Approve a media file
	 *
	 * @todo refactor in 0.6
	 * @return [type] [description]
	 */
	function approve_photo() {
		// Check permissions, attachment ID, and nonce
		if ( ! $this->_check_perms_and_nonce() || 0 !== (int) $_GET['id'] )
			wp_safe_redirect( get_admin_url( null, 'upload.php?page=manage_frontend_uploader&error=id_or_perm' ) );

		$post = get_post( $_GET['id'] );

		if ( is_object( $post ) && $post->post_status == 'private' ) {
			$post->post_status = 'inherit';
			wp_update_post( $post );
			$this->update_35_gallery_shortcode( $post->post_parent, $post->ID );
			wp_safe_redirect( get_admin_url( null, 'upload.php?page=manage_frontend_uploader&approved=1' ) );
		}

		wp_safe_redirect( get_admin_url( null, 'upload.php?page=manage_frontend_uploader' ) );
		exit;
	}

	/**
	 *
	 *
	 * @todo refactor in 0.6
	 * @return [type] [description]
	 */
	function approve_post() {
		// check for permissions and id
		$url = get_admin_url( null, 'edit.php?page=manage_frontend_uploader_posts&error=id_or_perm' );
		if ( !current_user_can( $this->manage_permissions ) || intval( $_GET['id'] ) == 0  )
			wp_safe_redirect( $url );

		$post = get_post( $_GET['id'] );

		if ( !is_wp_error( $post ) ) {
			$post->post_status = 'publish';
			wp_update_post( $post );

			// Check if there's any UGC attachments
			$attachments = get_children( 'post_type=attachment&post_parent=' . $post->ID );
			foreach ( (array) $attachments as $image_id => $attachment ) {
				$attachment->post_status = "inherit";
				wp_update_post( $attachment );
			}

			// Override query args
			$qa = array(
				'page' => "manage_frontend_uploader_{$post->post_type}s",
				'approved' => 1,
				'post_type' => $post->post_type != 'post' ? $post->post_type : '',
			);

			$url = add_query_arg( $qa, get_admin_url( null, "edit.php" ) );
		}

		wp_safe_redirect( $url );
		exit;
	}

	/**
	 * Delete post and redirect to referrer
	 * @return [type] [description]
	 */
	function delete_post() {
		if ( $this->_check_perms_and_nonce() && 0 !== (int) $_GET['id'] ) {
						if ( wp_delete_post( (int) $_GET['id'], true ) )
							$args['deleted'] = 1;
		}

		wp_safe_redirect( add_query_arg( $args, wp_get_referer() ) );
		exit;
	}

	/**
	 * Handles security checks
	 * @return bool
	 */
	function _check_perms_and_nonce() {
		return current_user_can( $this->manage_permissions ) && wp_verify_nonce( $_REQUEST['fu_nonce'], FU_FILE_PATH );
	}

	/**
	 * Shortcode callback for inner content of [fu-upload-form] shortcode
	 *
	 * @param array   $atts    shortcode attributes
	 * @param unknown $content not used
	 * @param string  $tag
	 */
	function shortcode_content_parser( $atts, $content = null, $tag ) {
		$atts = shortcode_atts( array(
				'id' => '',
				'name' => '',
				'description' => '',
				'value' => '',
				'type' => '',
				'class' => '',
				'multiple' => false,
				'values' => '',
				'wysiwyg_enabled' => false,
				'role' => 'meta'
			), $atts );

		extract( $atts );

		// Add the field to fields map
		$this->form_fields[] = array(
			'name' => sanitize_text_field( $name ),
			'role' => in_array( $role, array( 'meta', 'title', 'description', 'author', 'internal', 'content' ) ) ? $role : 'meta',
		);

		// Render the element if render callback is available
		$callback = array( $this, "_render_{$tag}" );
		if ( is_callable( $callback ) )
			return call_user_func( $callback, $atts );
	}

	/**
	 * Input element callback
	 *
	 * @param array   shortcode attributes
	 * @return string formatted html element
	 */
	function _render_input( $atts ) {
		extract( $atts );
		$atts = array( 'id' => $id, 'class' => $class, 'multiple' => $multiple );
		// Workaround for HTML5 multiple attribute
		if ( $multiple == 'false' )
			unset( $atts['multiple'] );

		// Allow multiple file upload by default.
		// To do so, we need to add array notation to name field: []
		if ( !strpos( $name, '[]' ) && $type == 'file' )
			$name = 'files' . '[]';

		$input = $this->html->input( $type, $name, $value, $atts );

		// No need for wrappers or labels for hidden input
		if ( $type == 'hidden' )
			return $input;

		$element = $this->html->element( 'label', $description . $input , array( 'for' => $id ), false );

		return $this->html->element( 'div', $element, array( 'class' => 'ugc-input-wrapper' ), false );
	}

	/**
	 * Textarea element callback
	 *
	 * @param array   shortcode attributes
	 * @return string formatted html elemen
	 */
	function _render_textarea( $atts ) {
		extract( $atts );
		// Render WYSIWYG textarea
		if ( ( isset( $this->settings['wysiwyg_enabled'] ) && 'on' == $this->settings['wysiwyg_enabled'] ) || $wysiwyg_enabled == true ) {
			ob_start();
			wp_editor( '', $id, array(
					'textarea_name' => $name,
					'media_buttons' => false,
					'teeny' => true,
					'quicktags' => false
				) );
			$tiny = ob_get_clean();
			$label =  $this->html->element( 'label', $description , array( 'for' => $id ), false );
			return $this->html->element( 'div', $label . $tiny, array( 'class' => 'ugc-input-wrapper' ), false ) ;
		}
		// Render plain textarea
		$element = $this->html->element( 'textarea', '', array( 'name' => $name, 'id' => $id, 'class' => $class ) );
		$label = $this->html->element( 'label', $description, array( 'for' => $id ), false );

		return $this->html->element( 'div', $label . $element, array( 'class' => 'ugc-input-wrapper' ), false );
	}

	/**
	 * Checkboxes element callback
	 *
	 * @param array   shortcode attributes
	 * @return [type]       [description]
	 */
	function _render_checkboxes( $atts ) {
		extract( $atts );
		return;
	}

	/**
	 * Radio buttons callback
	 *
	 * @param array   shortcode attributes
	 * @return [type]       [description]
	 */
	function _render_radio( $atts ) {
		extract( $atts );
		return;
	}

	/**
	 * Select element callback
	 *
	 * @param array   shortcode attributes
	 * @return [type]       [description]
	 */
	function _render_select( $atts ) {
		extract( $atts );
		$atts = array( 'values' => $values );
		$values = explode( ',', $values );
		$options = '';
		//Build options for the list
		foreach ( $values as $option ) {
			$options .= $this->html->element( 'option', $option, array( 'value' => $option ), false );
		}
		//Render select field
		$element = $this->html->element( 'label', $description . $this->html->element( 'select', $options, array(
					'name' => $name,
					'id' => $id,
					'class' => $class
				), false ), array( 'for' => $id ), false );
		return $this->html->element( 'div', $element, array( 'class' => 'ugc-input-wrapper' ), false );
	}

	/**
	 * Display the upload post form
	 *
	 * @todo Major refactoring for this before releasing 0.6
	 *
	 * @param array   $atts    shortcode attributes
	 * @param string  $content content that is encloded in [fu-upload-form][/fu-upload-form]
	 */
	function upload_form( $atts, $content = null ) {

		// Reset postdata in case it got polluted somewhere
		wp_reset_postdata();

		extract( shortcode_atts( array(
					'description' => '',
					'title' => __( 'Submit a new post', 'frontend-uploader' ),
					'type' => '',
					'class' => 'validate',
					'success_page' => '',
					'form_layout' => 'image',
					'post_id' => get_the_ID(),
					'post_type' => 'post',
					'category' => '',
				), $atts ) );

		$post_id = (int) $post_id;

		$form_layout = in_array( $form_layout, array( 'post', 'image', 'media', 'post_image', 'post_media' ) ) ? $form_layout : 'media';

		switch ( $form_layout ) {
		case 'image':
		case 'media':
			$title = __( 'Submit a media file', 'frontend-uploader' );
			break;
		case 'post':
		case 'post_media':
			break;
		default:
		}
		ob_start();
?>
	<form action="<?php echo admin_url( 'admin-ajax.php' ) ?>" method="post" id="ugc-media-form" class="<?php echo esc_attr( $class )?>" enctype="multipart/form-data">
	  <div class="ugc-inner-wrapper">
		  <h2><?php echo esc_html( $title ) ?></h2>
<?php
		if ( !empty( $_GET ) )
			$this->_display_response_notices( $_GET );

		$textarea_desc = __( 'Description', 'frontend-uploader' );
		$file_desc = __( 'Your Media Files', 'frontend-uploader' );
		$submit_button = __( 'Submit', 'frontend-uploader' );
		
		if( !( isset( $this->settings['suppress_default_fields'] ) && 'on' == $this->settings['suppress_default_fields'] ) ) {
		
			// Display title field
			echo $this->shortcode_content_parser( array(
				'type' => 'text',
				'role' => 'title',
				'name' => 'post_title',
				'id' => 'ug_post_title',
				'class' => 'required',
				'description' =>  __( 'Title', 'frontend-uploader' ),
				), null, 'input' );

	   /**
		* Render default fields
		* 
		*/
			switch ( $form_layout ) {
			case 'post_image':
			case 'post_media':
			case 'image':
			case 'media':

				// post_content
				echo $this->shortcode_content_parser( array(
					'role' => 'content',
					'name' => 'post_content',
					'id' => 'ug_content',
					'class' => 'required',
					'description' =>  __( 'Post content or file description', 'frontend-uploader' ),
					), null, 'textarea' );

				echo $this->shortcode_content_parser( array(
					'type' => 'file',
					'role' => 'file',
					'name' => 'files',
					'id' => 'ug_photo',
					'multiple' => '',
					'description' =>  $file_desc,
					), null, 'input' );

				break;
			case 'post':
				// post_content
				echo $this->shortcode_content_parser( array(
					'role' => 'content',
					'name' => 'post_content',
					'id' => 'ug_content',
					'class' => 'required',
					'description' =>  __( 'Post content', 'frontend-uploader' ),
					), null, 'textarea' );
				break;
			}
		}

		// Show author field
		if ( isset( $this->settings['show_author'] ) && $this->settings['show_author'] == 'on' ) {
			echo $this->shortcode_content_parser( array(
				'type' => 'text',
				'role' => 'author',
				'name' => 'post_author',
				'id' => 'ug_post_author',
				'class' => '',
				'description' =>  __( 'Author', 'frontend-uploader' ),
				), null, 'input' );
		}

		// Parse nested shortcodes
		if ( $content )
			echo do_shortcode( $content );

		if ( !( isset( $this->settings['suppress_default_fields'] ) && 'on' == $this->settings['suppress_default_fields'] ) ) {
			echo $this->shortcode_content_parser( array(
				'type' => 'submit',
				'role' => 'internal',
				'id' => 'ug_submit_button',
				'class' => 'btn',
				'value' =>  $submit_button,
			), null, 'input' );
		}

		// wp_ajax_ hook
		echo $this->shortcode_content_parser( array(
			'type' => 'hidden',
			'role' => 'internal',
			'name' => 'action',
			'value' => 'upload_ugc'
		), null, 'input' );

		echo $this->shortcode_content_parser( array(
			'type' => 'hidden',
			'role' => 'internal',
			'name' => 'post_ID',
			'value' => $post_id
		), null, 'input' );

		if ( isset( $category ) && 0 !== (int) $category ) {
			echo $this->shortcode_content_parser( array(
				'type' => 'hidden',
				'role' => 'internal',
				'name' => 'post_category',
				'value' => (int) $category
			), null, 'input' );
		}

		// Redirect to specified url if valid
		if ( !empty( $success_page ) && filter_var( $success_page, FILTER_VALIDATE_URL ) ) {
			echo $this->shortcode_content_parser( array(
				'type' => 'hidden',
				'role' => 'internal',
				'name' => 'success_page',
				'value' =>  $success_page
			), null, 'input' );			
		}

		// One of supported form layouts 
		echo $this->shortcode_content_parser( array(
			'type' => 'hidden',
			'role' => 'internal',
			'name' => 'form_layout',
			'value' =>  $form_layout
		), null, 'input' );

		// @todo 0.6
		// Mapping of form fields and their corresponding roles
		// Should help to get rid of hardcoded logic of content upload
		// Thus giving users more flexibility without requiring PHP knowledge
		/*
		 <input type="hidden" name="form_fields" value="<?php echo esc_attr( json_encode( $this->form_fields ) ) ?>" /> 
		*/
		// Set post type for the content submission
		if ( in_array( $form_layout, array( "post_media", "post_image", "post" ) ) ) {
			echo $this->shortcode_content_parser( array(
				'type' => 'hidden',
				'role' => 'internal',
				'name' => 'post_type',
				'value' =>  $post_type
			), null, 'input' );
		}

		// Allow a little customization
		do_action( 'fu_additional_html' );
		?>
		<?php wp_nonce_field( FU_FILE_PATH, 'fu_nonce' ); ?>
		<div class="clear"></div>
	  </div>
	  </form>
<?php
		return ob_get_clean();
	}

	/**
	 * Returns html chunk of single notice
	 *
	 * @since 0.4
	 *
	 * @param string  $message Text of the message
	 * @param string  $class   Class of container
	 * @return string          [description]
	 */
	function _notice_html( $message, $class ) {
		if ( empty( $message ) || empty( $class ) )
			return;
		return sprintf( '<p class="ugc-notice %1$s">%2$s</p>', $class, $message );
	}

	/**
	 * Handle response notices
	 *
	 * @since 0.4
	 *
	 * @param array   $res [description]
	 * @return [type]      [description]
	 */
	function _display_response_notices( $res = array() ) {
		if ( empty( $res ) )
			return;

		$output = '';
		$map = array(
			'fu-sent' => array(
				'text' => __( 'Your file was successfully uploaded!', 'frontend-uploader' ),
				'class' => 'success',
			),
			'fu-post-sent' => array(
				'text' => __( 'Your post was successfully uploaded!', 'frontend-uploader' ),
				'class' => 'success',
			),
			'fu-error' => array(
				'text' => __( 'There was an error with your submission', 'frontend-uploader' ),
				'class' => 'failure',
			),
		);

		if ( isset( $res['response'] ) && isset( $map[ $res['response'] ] ) )
			$output .= $this->_notice_html( $map[ $res['response'] ]['text'] , $map[ $res['response'] ]['class'] );

		if ( !empty( $res['errors' ] ) )
			$output .= $this->_display_errors( $res['errors' ] );

		echo $output;
	}
	/**
	 * Handle errors
	 *
	 * @since 0.4
	 * @param string  $errors [description]
	 * @return string HTML
	 */
	function _display_errors( $errors ) {
		$errors_arr = explode( ';', $errors );
		$output = '';
		$map = array(
			'nonce-failure' => array(
				'text' => __( 'Security check failed!', 'frontend-uploader' ),
			),
			'fu-disallowed-mime-type' => array(
				'text' => __( 'This kind of file is not allowed. Please, try again selecting other file.', 'frontend-uploader' ),
				'format' => $this->is_debug ? '%1$s: <br/> File name: %2$s <br/> MIME-TYPE: %3$s' : '%1$s: <br/> %2$s',
			),
			'fu-invalid-post' => array(
				'text' =>__( 'The content you are trying to post is invalid.', 'frontend-uploader' ),
			),
			'fu-error-media' => array(
				'text' =>__( "Couldn't upload the file", 'frontend-uploader' ),
			),
			'fu-error-post' => array(
				'text' =>__( "Couldn't create the post", 'frontend-uploader' ),
			),
		);

		foreach ( $errors_arr as $error ) {
			$error_type = explode( ':', $error );
			$error_details = explode( '|', $error_type[1] );
			// Iterate over different errors
			foreach ( $error_details as $single_error ) {

				// And see if there's any additional details
				$details = isset( $single_error ) ? explode( ',,,', $single_error ) : explode( ',,,', $single_error );
				// Add a description to our details array
				array_unshift( $details, $map[ $error_type[0] ]['text']  );
				// If we have a format, let's format an error
				// If not, just display the message
				if ( isset( $map[ $error_type[0] ]['format'] ) )
					$message = vsprintf( $map[ $error_type[0] ]['format'], $details );
				else
					$message = $map[ $error_type[0] ]['text'];
			}
			$output .= $this->_notice_html( $message, 'failure' );
		}

		return $output;
	}

	/**
	 * Enqueue our assets
	 */
	function enqueue_scripts() {
		wp_enqueue_style( 'frontend-uploader', FU_URL . 'lib/css/frontend-uploader.css' );
		wp_enqueue_script( 'jquery-validate', FU_URL .' lib/js/validate/jquery.validate.js ', array( 'jquery' ) );
		wp_enqueue_script( 'frontend-uploader-js', FU_URL . 'lib/js/frontend-uploader.js', array( 'jquery', 'jquery-validate' ) );
		// Include localization strings for default messages of validation plugin
		// Filter is needed for wordpress.com
		$wplang = apply_filters( 'fu_wplang', defined( 'WPLANG' ) ? WPLANG : '' );
		if ( $wplang ) {
			$lang = explode( '_', $wplang );
			$relative_path = "lib/js/validate/localization/messages_{$lang[0]}.js";
			$url = FU_URL . $relative_path;
			if ( file_exists(  FU_ROOT . "/{$relative_path}" ) )
				wp_enqueue_script( 'jquery-validate-messages', $url, array( 'jquery' ) );
		}

	}

	/**
	 * Enqueue scripts for admin
	 */
	function admin_enqueue_scripts() {
		wp_enqueue_script( 'wp-ajax-response' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'media' );
	}

	/**
	 * 3.5 brings new Media UI
	 * Unfortunately, we have to specify ids of approved attachments explicitly,
	 * Otherwise, editors have to pick photos after they have already approved them in "Manage UGC"
	 *
	 * This method will search a parent post with a regular expression, and update gallery shortcode with freshly approved attachment ID
	 *
	 * @return post id/wp_error
	 */
	function update_35_gallery_shortcode( $post_id, $attachment_id ) {
		global $wp_version;
		// Bail of wp is older than 3.5
		if ( version_compare( $wp_version, '3.5', '<' ) )
			return;

		$parent = get_post( $post_id );

		/**
		 * Parse the post content:
		 * Before the shortcode,
		 * Before ids,
		 * Ids,
		 * After ids
		 */
		preg_match( '#(?<way_before>.*)(?<before>\[gallery(.*))ids=(\'|")(?<ids>[0-9,]*)(\'|")(?<after>.*)#ims', $parent->post_content, $matches ) ;

		// No gallery shortcode, no problem
		if ( !isset( $matches['ids'] ) )
			return;

		$content = '';
		$if_prepend = apply_filters( 'fu_update_gallery_shortcode_prepend', false );
		// Replace ids element with actual string of ids, adding the new att id
		$matches['ids'] = $if_prepend ? "ids=\"{$attachment_id},{$matches['ids']}\"" : "ids=\"{$matches['ids']},{$attachment_id}\"";
		$deconstructed = array( 'way_before', 'before', 'ids', 'after' );
		// Iterate through match elements and reconstruct the post
		foreach ( $deconstructed as $match_key ) {
			if ( isset( $matches[$match_key] ) ) {
				$content .= $matches[$match_key];
			}
		}

		// Update the post
		$post_to_update = array(
			'ID' => (int) $post_id,
			'post_content' => $content,
		);
		return wp_update_post( $post_to_update );
	}
}

global $frontend_uploader;
$frontend_uploader = new Frontend_Uploader;
