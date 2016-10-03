<?php
//*******************************************************************
//Template Name: wp_plugin.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: wp_plugin
//*******************************************************************/

require_once('cake_env.php');

// Filter and Action hook assignments
add_action('template_redirect', 'cake_main');
add_action('wp_head', 'cake_insertPageTags',100);
add_filter('the_permalink_rss', 'cake_post_link');
add_action('init', 'cake_handleSpecialActionRequest');
add_filter('bloginfo_url', 'add_feed_sid');
add_action('admin_menu', 'cake_dashboard_menu');
add_action('comment_post', 'cake_logComment',10,2);
add_action('transition_comment_status', 'cake_logCommentEdit',10,3);
add_action('admin_menu', 'cake_options_menu');
add_action('user_register', 'cake_userRegistrationActionTracker');
add_action('wp_login', 'cake_userLoginActionTracker');
add_action('profile_update', 'cake_userProfileUpdateActionTracker', 10,2);
add_action('password_reset', 'cake_userPasswordResetActionTracker');
add_action('trackback_post', 'cake_trackbackActionTracker');
add_action('add_attachment', 'cake_newAttachmentActionTracker');
add_action('edit_attachment', 'cake_editAttachmentActionTracker');
add_action('transition_post_status', 'cake_postActionTracker', 10, 3);
add_action('wpmu_new_blog', 'cake_newBlogActionTracker', 10, 5);
add_action('wpmu_new_blog', 'cake_createTrackedSiteForNewBlog', 10, 6);
// Installation hook
register_activation_hook(__FILE__, 'cake_install');

/////////////////////////////////////////////////////////////////////////////////

/**New Blog Action Tracker*/
function cake_newBlogActionTracker($blog_id, $user_id, $domain, $path, $site_id) {

	$cake = cake_getInstance();
	$cake->trackAction('wordpress', 'Blog Created', $domain);
}

function cake_createTrackedSiteForNewBlog($blog_id, $user_id, $domain, $path, $site_id, $meta) {
	
	$cake = cake_getInstance();
	$sm = cake_coreAPI::supportClassFactory( 'base', 'siteManager' );
	$sm->createNewSite( $domain, $domain, '', ''); 
}

/**Edit Post Action Tracker*/
function cake_editPostActionTracker($post_id, $post) {
	
	// we don't want to track autosaves...
	if(wp_is_post_autosave($post)) {
		return;
	}
	
	$cake = cake_getInstance();
	$label = $post->post_title;
	$cake->trackAction('wordpress', $post->post_type.' edited', $label);
}

/**Post Action Tracker*/
function cake_postActionTracker($new_status, $old_status, $post) {
	
	// we don't want to track autosaves...
	if(wp_is_post_autosave($post)) {
		return;
	}
	
	if ($new_status === 'draft' && $old_status === 'draft') {
		return;
	} elseif ($new_status === 'publish' && $old_status != 'publish') {
		$action_name = $post->post_type.' publish';
	} elseif ($new_status === $old_status) {
		$action_name = $post->post_type.' edit';
	}
	
	if ($action_name) {	
		$cake = cake_getInstance();
		cake_coreAPI::debug(sprintf("new: %s, old: %s, post: %s", $new_status, $old_status, print_r($post, true)));
		$label = $post->post_title;
		$cake->trackAction('wordpress', $action_name, $label);
	}
}

/**New Attachment Action Tracker*/
function cake_editAttachmentActionTracker($post_id) {

	$cake = cake_getInstance();
	$post = get_post($post_id);
	$label = $post->post_title;
	$cake->trackAction('wordpress', 'Attachment Edit', $label);
}

/**New Attachment Action Tracker*/
function cake_newAttachmentActionTracker($post_id) {

	$cake = cake_getInstance();
	$post = get_post($post_id);
	$label = $post->post_title;
	$cake->trackAction('wordpress', 'Attachment Created', $label);
}

/** User Registration Action Tracker*/
function cake_userRegistrationActionTracker($user_id) {
	
	$cake = cake_getInstance();
	$user = get_userdata($user_id);
	if (!empty($user->first_name) && !empty($user->last_name)) {
		$label = $user->first_name.' '.$user->last_name;	
	} else {
		$label = $user->display_name;
	}
	
	$cake->trackAction('wordpress', 'User Registration', $label);
}

/** User Login Action Tracker*/
function cake_userLoginActionTracker($user_id) {

	$cake = cake_getInstance();
	$label = $user_id;
	$cake->trackAction('wordpress', 'User Login', $label);
}

/**Profile Update Action Tracker*/
function cake_userProfileUpdateActionTracker($user_id, $old_user_data = '') {

	$cake = cake_getInstance();
	$user = get_userdata($user_id);
	if (!empty($user->first_name) && !empty($user->last_name)) {
		$label = $user->first_name.' '.$user->last_name;	
	} else {
		$label = $user->display_name;
	}
	
	$cake->trackAction('wordpress', 'User Profile Update', $label);
}

/**Password Reset Action Tracker*/
function cake_userPasswordResetActionTracker($user) {
	
	$cake = cake_getInstance();
	$label = $user->display_name;
	$cake->trackAction('wordpress', 'User Password Reset', $label);
}

/**Trackback Action Tracker*/
function cake_trackbackActionTracker($comment_id) {
	
	$cake = cake_getInstance();
	$label = $comment_id;
	$cake->trackAction('wordpress', 'Trackback', $label);
}




/**
 * Singleton Method
 * Returns an instance of CAKE
 * @return $cake object
 */
function &cake_getInstance() {
	
	static $cake;
	
	if( empty( $cake ) ) {
		
		require_once(CAKE_BASE_CLASSES_DIR.'cake_wp.php');
		
		// create cake instance w/ config
		$cake = new cake_wp();
		$cake->setSiteId( md5( get_settings( 'siteurl' ) ) );
		$cake->setSetting( 'base', 'report_wrapper', 'wrapper_wordpress.tpl' );
		$cake->setSetting( 'base', 'link_template', '%s&%s' );
		$cake->setSetting( 'base', 'main_url', '../wp-admin/index.php?page=cake' );
		$cake->setSetting( 'base', 'main_absolute_url', get_bloginfo('url').'/wp-admin/index.php?page=cake' );
		$cake->setSetting( 'base', 'action_url', get_bloginfo('url').'/index.php?cake_specialAction' );
		$cake->setSetting( 'base', 'api_url', get_bloginfo('url').'/index.php?cake_apiAction' );
		$cake->setSetting( 'base', 'is_embedded', true );
		// needed as old installs might have this turned on by default...
		$cake->setSetting( 'base', 'delay_first_hit', false );
		
		// Access WP current user object to check permissions
		//$current_user = cake_getCurrentWpUser();
      	//print_r($current_user);
		// Set CAKE's current user info and mark as authenticated so that
		// downstream controllers don't have to authenticate
		
		//$cu->isInitialized = true;
		
		// register allowedSitesList filter
		$dispatch = cake_coreAPI::getEventDispatch();
		// alternative auth method, sets auth status, role, and allowed sites list.
		$dispatch->attachFilter('auth_status', 'cake_wpAuthUser',0);
		//print_r( $current_user );
	}
	
	return $cake;
}

/**
 * CAKE authentication filter method
 * This filter function authenticates the user and populates the the current user in CAKE with the proper role, and allowed sites list.
 * This method kicks in after all over CAKE's built in auth methods have failed in the cake_auth class.
 * @param 	$auth_status	boolean
 * @return	$auth_status	boolean
 */
function cake_wpAuthUser($auth_status) {

	$current_user = wp_get_current_user();
	
    if ( $current_user instanceof WP_User ) { 
    	// logged in, authenticated
    	$cu = cake_coreAPI::getCurrentUser();
    	
    	$cu->setAuthStatus(true);
    	
    	if (isset($current_user->user_login)) {
			$cu->setUserData('user_id', $current_user->user_login);
			cake_coreAPI::debug("Wordpress User_id: ".$current_user->user_login);
		}
		
		if (isset($current_user->user_email)) {	
			$cu->setUserData('email_address', $current_user->user_email);
		}
		
		if (isset($current_user->first_name)) {
			$cu->setUserData('real_name', $current_user->first_name.' '.$current_user->last_name);
			$cu->setRole(cake_translate_role($current_user->roles));
		}
		
		cake_coreAPI::debug("Wordpress User Role: ".print_r($current_user->roles, true));
		cake_coreAPI::debug("Wordpress Translated CAKE User Role: ".$cu->getRole());
		
		// fetch the list of allowed blogs from WP
		$domains = array();
		$allowedBlogs = get_blogs_of_user($current_user->ID);
	
		foreach ( $allowedBlogs as $blog) {
			$domains[] = $blog->siteurl;		
		}
		
		// check to see if we are installing before trying to load sites
		// other wise you run into a race condition as config file
		// might not be created.
		if (! defined('CAKE_INSTALLING') ) {
			// load assigned sites list by domain
    		$cu->loadAssignedSitesByDomain($domains);
    	}
    	
		$cu->setInitialized();
    
    	return true;
    
    } else {
    	// not logged in to WP and therefor not authenticated
    	return false;
    }	
}

function cake_getCurrentWpUser() {

	// Access WP current user object to check permissions
	global $current_user;
    get_currentuserinfo();
    return $current_user;

}

// translates wordpress roles to cake roles
function cake_translate_role($roles) {
	
	if (!empty($roles)) {
	
		if (in_array('administrator', $roles)) {
			$cake_role = 'admin';
		} elseif (in_array('editor', $roles)) {
			$cake_role = 'viewer';
		} elseif (in_array('author', $roles)) {
			$cake_role = 'viewer';
		} elseif (in_array('contributor', $roles)) {
			$cake_role = 'viewer';
		} elseif (in_array('subscriber', $roles)) {
			$cake_role = 'everyone';
		} else {
			$cake_role = 'everyone';
		}
		
	} else {
		$cake_role = 'everyone';
	}
	
	return $cake_role;
}


function cake_handleSpecialActionRequest() {

	$cake = cake_getInstance();
	cake_coreAPI::debug("hello from WP special action handler");
	return $cake->handleSpecialActionRequest();
	
}

function cake_logComment($id, $comment_data = '') {

	if ( $comment_data === 'approved' || $comment_data === 1 ) {

		$cake = cake_getInstance();
		$label = '';
		$cake->trackAction('wordpress', 'comment', $label);
	}
}

function cake_logCommentEdit($new_status, $old_status, $comment) {
	
	if ($new_status === 'approved') {
		if (isset($comment->comment_author)) {
			$label = $comment->comment_author; 
		} else {
			$label = '';
		}
		
		$cake = cake_getInstance();
		$cake->trackAction('wordpress', 'comment', $label);
	}
}

/** Prints helper page tags to the <head> of pages.*/
function cake_insertPageTags() {
	
	// Don't log if the page request is a preview - Wordpress 2.x or greater
	if (function_exists('is_preview')) {
		if (is_preview()) {
			return;
		}
	}
	
	$cake = cake_getInstance();
	
	$page_properties = $cake->getAllEventProperties($cake->pageview_event);
	$cmds = '';
	if ( $page_properties ) {
		$page_properties_json = json_encode( $page_properties );
		$cmds .= "cake_cmds.push( ['setPageProperties', $page_properties_json] );";
	}
	
	//$wgOut->addInlineScript( $cmds );
	
	$options = array( 'cmds' => $cmds );
	
	
	$cake->placeHelperPageTags(true, $options);	
}	

/**This is the main logging controller that is called on each request.*/
function cake_main() {
	
	//global $user_level;
	
	$cake = cake_getInstance();
	cake_coreAPI::debug('wp main request method');
	
	//Check to see if this is a Feed Reeder
	if( $cake->getSetting('base', 'log_feedreaders') && is_feed() ) {
		$event = $cake->makeEvent();
		$event->setEventType('base.feed_request');
		$event->set('feed_format', $_GET['feed']);
		// Process the request by calling cake
		return $cake->trackEvent($event);
	}
	
	// Set the type and title of the page
	$page_type = cake_get_page_type();
	$cake->setPageType( $page_type );
	// Get Title of Page
	$cake->setPageTitle( cake_get_title( $page_type ) );
}

/**
 * Determines the title of the page being requested
 * @param string $page_type
 * @return string $title
 */
function cake_get_title($page_type) {

	if ($page_type == "Home"):
		$title = get_bloginfo('name');
	elseif ($page_type == "Search Results"):
		$title = "Search Results for \"".$_GET['s']."\"";	
	elseif ($page_type == "Page" || "Post"):
		$title = wp_title($sep = '', $display = 0);
	elseif ($page_type == "Author"):
		$title = wp_title($sep = '', $display = 0);
	elseif ($page_type == "Category"):
		$title = wp_title($sep = '', $display = 0);
	elseif ($page_type == "Month"):
		$title = wp_title($sep = '', $display = 0);
	elseif ($page_type == "Day"):
		$title = wp_title($sep = '', $display = 0);
	elseif ($page_type == "Year"):
		$title = wp_title($sep = '', $display = 0);
	elseif ($page_type == "Time"):
		$title = wp_title($sep = '', $display = 0);
	elseif ($page_type == "Feed"):
		$title = wp_title($sep = '', $display = 0);
	endif;	
	
	return $title;
}

/**
 * Determines the type of page being requested
 * @return string $type
 */
function cake_get_page_type() {	
	
	if (is_home()):
		$type = "Home";
	elseif (is_attachment()):
		$type = "Attachment";
	elseif (is_page()):
		$type = "Page";
	// general page catch, should be after more specific post types	
	elseif (is_single()):
		$type = "Post";
	elseif (is_feed()):
		$type = "Feed";
	elseif (is_author()):
		$type = "Author";
	elseif (is_category()):
		$type = "Category";
	elseif (is_search()):
		$type = "Search Results";
	elseif (is_month()):
		$type = "Month";
	elseif (is_day()):
		$type = "Day";
	elseif (is_year()):
		$type = "Year";
	elseif (is_time()):
		$type = "Time";
	elseif (is_tag()):
		$type = "Tag";
	elseif (is_tax()):
		$type = "Taxonomy";
	// general archive catch, should be after specific archive types	
	elseif (is_archive()):
		$type = "Archive";
	else:
		$type = '(not set)';
	endif;
	
	return $type;
}

/**
 * Wordpress filter function adds a GUID to the feed URL.
 * @param array $binfo
 * @return string $newbinfo
 */
function add_feed_sid($binfo) {
	
	$cake = cake_getInstance();
	
	$test = strpos($binfo, "feed=");
	
	if ($test == true):
		$newbinfo = $cake->add_feed_tracking($binfo);
	
	else: 
		
		$newbinfo = $binfo;
		
	endif;
	
	return $newbinfo;

}

/**
 * Adds tracking source param to links in feeds
 * @param string $link
 * @return string
 */
function cake_post_link($link) {

	$cake = cake_getInstance();

	return $cake->add_link_tracking($link);
		
}

/**Schema and setting installation*/
function cake_install() {

	define('CAKE_INSTALLING', true);
	
	$params = array();
	//$params['do_not_fetch_config_from_db'] = true;

	$cake = cake_getInstance($params);
	$cake->setSetting('base', 'cache_objects', false);	
	$public_url =  get_bloginfo('wpurl').'/wp-content/plugins/cake/';
	
	$install_params = array('site_id' => md5(get_settings('siteurl')), 
							'name' => get_bloginfo('name'),
							'domain' => get_settings('siteurl'), 
							'description' => get_bloginfo('description'),
							'action' => 'base.installEmbedded',
							'db_type' => 'mysql',
							'db_name' => DB_NAME,
							'db_host' => DB_HOST,
							'db_user' => DB_USER,
							'db_password' => DB_PASSWORD,
							'public_url' =>  $public_url
							);
	
	$cake->handleRequest($install_params);
}

/** Adds Analytics sub tab to admin dashboard screens.*/
function cake_dashboard_menu() {

	if (function_exists('add_submenu_page')):
		add_submenu_page('index.php', 'CAKE Dashboard', 'Analytics', 1, dirname(__FILE__), 'cake_pageController');
    endif;
    
    return;

}

/**Main page handler.*/
function cake_pageController() {

	$cake = cake_getInstance();	
	echo $cake->handleRequest();

}

/**Adds Options page to admin interface*/
function cake_options_menu() {
	
	if (function_exists('add_options_page')):
		add_options_page('Options', 'CAKE', 8, basename(__FILE__), 'cake_options_page');
	endif;
    
    return;
}

/**Generates Options Management Page*/
function cake_options_page() {
	
	$cake = cake_getInstance();
	
	$params = array();
	$params['view'] = 'base.options';
	$params['subview'] = 'base.optionsGeneral';
	echo $cake->handleRequest($params);
	
	return;
}

/**
 * Parses string to get the major and minor version of the instance of wordpress that is running
 * @param string $version
 * @return array
 */
function cake_parse_version($version) {
	
	$version_array = explode(".", $version);
   
   return $version_array;
	
}

?>