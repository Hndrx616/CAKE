<?php
//*******************************************************************
//Template Name: mw_plugin.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: mw_plugin
//*******************************************************************/

if ( ! defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once( dirname( __FILE__ )  . '/' . 'cake_env.php' );
require_once( CAKE_BASE_CLASSES_DIR . 'cake_mw.php' );

/** CAKE MW EXTENSION SPECIFIC CONFIGURATION VARIABLES To alter these, set them in your localsettings.php 
file AFTER you include/require the extension.
*/
 
// $wgCakeSiteId is used to overide the default site_id that CAKE
$wgCakeSiteId = false;

// $wgCakeEnableSpecialPage enables/disables CAKE's special page.
$wgCakeEnableSpecialPage = true;

// $wgCakeThirdPartyCookies enables third party cookie mode for 
$wgCakeThirdPartyCookies = false;

// $wgCakeCookieDomain contain the domain that CAKE's javascript tracker 
$wgCakeCookieDomain = false;

/**Register Extension and Hooks*/
$wgExtensionCredits['specialpage'][] = array(
		'name' 			=> 'Catalyst Analytic Keyword Engine for MediaWiki', 
  		'author' 		=> 'Stephen Hilliard', 
  		'url' 			=> 'http://www.mythoughtbomb.com',
  		'description' 	=> 'Catalyst Analytic Keyword Engine for MedaWiki'
);

// used to sniff out admin requests	
$wgHooks['UnknownAction'][] = 'cake_actions';
// used to set proper params for logging Article Page Views	
$wgHooks['ArticlePageDataAfter'][] = 'cake_logArticle';
// used to set proper params for logging Special Page Views	
$wgHooks['SpecialPageExecuteAfterPage'][] = 'cake_logSpecialPage';
// used to set proper params for logging Category Page Views	
$wgHooks['CategoryPageView'][] = 'cake_logCategoryPage';
// used to add CAKE's javascript tracking tag to all pages 	
$wgHooks['BeforePageDisplay'][] = 'cake_footer';
// used to fire Action events when articles are created
$wgHooks['ArticleInsertComplete'][] = 'cake_newArticleAction';
// used to fire Action events when articles are edited
$wgHooks['ArticleSaveComplete'][] = 'cake_editArticleAction';
// used to fire Action events when new articles are deleted
$wgHooks['ArticleDeleteComplete'][] = 'cake_deleteArticleAction';
// used to fire Action events when new user accounts are created
$wgHooks['AddNewAccount'][] = 'cake_addUserAction';
// used to fire Action events when new uploads occur
$wgHooks['UploadComplete'][] = 'cake_addUploadAction';
// used to fire Action events when users login
$wgHooks['UserLoginComplete'][] = 'cake_userLoginAction';
// used to fire Action events when talk pages are edited
$wgHooks['ArticleEditUpdateNewTalk'][] ='cake_editTalkPageAction';
// used to register CAKE's special page
$wgHooks['SpecialPage_initList'][] = 'cake_registerSpecialPage';

// add 'cake_view' right to admin groups in order to view special page
$wgGroupPermissions['user']['cake_view'] = true;

/**Hook Function for Registering CAKE's Special Page*/
function cake_registerSpecialPage( &$aSpecialPages ) {
	
	global $wgCakeEnableSpecialPage;
	
	// Enable Special Page
	if ( $wgCakeEnableSpecialPage === true ) {
		//Load Special Page
		$wgAutoloadClasses['SpecialCake'] = __FILE__;
		// Adds CAKE's admin interface to special page list
		$aSpecialPages['Cake'] = 'SpecialCake';
	}
	// must return true for hook to continue processing.
	return true;
}

/**
 * Hook for CAKE special actions
 * @TODO figure out how to register this method to be triggered only when 'action=cake' instead of for all unknown mediawiki actions.
 * @param object $specialPage
 * @url http://www.mediawiki.org/wiki/Manual:MediaWiki_hooks/UnknownAction
 * @return false
 */
function cake_actions($action) {
	
	global $wgOut, $wgUser, $wgRequest;
	
	$action = $wgRequest->getText( 'action' );
	if ( $action === 'cake' ) {
		$wgOut->disable();
		$cake = cake_singleton();
		$cake->handleSpecialActionRequest();
		return false;
	} else {
		return true;
	}
}

/**Needed to avoid CAKE loading for every mediawiki request*/
function cake_singleton() {

	static $cake;
		
	if ( empty( $cake ) ) {
			
		global 	$wgUser, 
				$wgServer, 
				$wgScriptPath, 
				$wgScript, 
				$wgMainCacheType, 
				$wgMemCachedServers,
				$wgCakeSiteId,
				$wgCakeMemCachedServers;
		
		/* CAKE CONFIGURATION OVERRIDES */
		$cake_config = array();
		// check for memcache. these need to be passed into CAKE to avoid race condition.
		if ( $wgMainCacheType === CACHE_MEMCACHED ) {
			$cake_config['cacheType'] = 'memcached';
			$cake_config['memcachedServers'] = $wgMemCachedServers;
		}
		$cake = new cake_mw( $cake_config );
		$cake->setSetting( 'base', 'report_wrapper', 'wrapper_mediawiki.tpl' );
		$cake->setSetting( 'base', 'main_url', $wgScriptPath.'/index.php?title=Special:Cake' );
		$cake->setSetting( 'base', 'main_absolute_url', $wgServer.$cake->getSetting( 'base', 'main_url' ) );
		$cake->setSetting( 'base', 'action_url', $wgServer.$wgScriptPath.'/index.php?action=cake&cake_specialAction' );
		$cake->setSetting( 'base', 'api_url', $wgServer.$wgScriptPath.'/index.php?action=cake&cake_apiAction' );
		$cake->setSetting( 'base', 'link_template', '%s&%s' );
		$cake->setSetting( 'base', 'is_embedded', true );
		$cake->setSetting( 'base', 'query_string_filters', 'returnto' );
		$cake->setSetting( 'base', 'delay_first_hit', false );
		
		if ( ! $wgCakeSiteId ) {
			$wgCakeSiteId = md5($wgServer.$wgScriptPath);
		}
		
		$cake->setSiteId( $wgCakeSiteId );
		
		// filter authentication
		$dispatch = cake_coreAPI::getEventDispatch();
		// alternative auth method, sets auth status, role, and allowed sites list.
		$dispatch->attachFilter('auth_status', 'cake_mwAuthUser',0);
		//print_r( $current_user );
		
	}
		
	return $cake;
}

/**Populates CAKE's current user object with info about the current mediawiki user.*/
function cake_mwAuthUser($auth_status) {
	
	global 	$wgUser, $wgCakeSiteId;
	
	if ( $wgUser->isLoggedIn() ) { 
	
		$cu = cake_coreAPI::getCurrentUser();
		$cu->setAuthStatus(true);	

		$cu->setUserData( 'user_id', $wgUser->getName() );
		$cu->setUserData( 'email_address', $wgUser->getEmail() );
		$cu->setUserData( 'real_name', $wgUser->getRealName() );
		$cu->setRole( cake_translate_role( $wgUser->getGroups() ) );
		
		// set list of allowed sites. In this case it's only this wiki.
		
		$domains = array($wgCakeSiteId);		
		// load assigned sites list by domain
    	$cu->loadAssignedSitesByDomain($domains);
		$cu->setInitialized();
    	
    	return true;
    	
	} else {
		// not logged in
		return false;
	} 		

}

/**
 * Transalates MW Roles into CAKE Roles
 * @todo make this configurable with a global property
 */
function cake_translate_role($level = array()) {
	
	if ( ! empty( $level ) ) {

		if ( in_array( "*", $level ) ) {
			$cake_role = 'everyone';
		} elseif ( in_array( "user", $level ) ) {
			$cake_role = 'viewer';
		} elseif ( in_array( "autoconfirmed", $level ) ) {
			$cake_role = 'viewer';
		} elseif ( in_array( "emailconfirmed", $level ) ) {
			$cake_role = 'viewer';
		} elseif ( in_array( "bot", $level ) ) {
			$cake_role = 'viewer';
		} elseif ( in_array( "sysop", $level ) ) {
			$cake_role = 'admin';
		} elseif ( in_array( "bureaucrat", $level ) ) {
			$cake_role = 'admin';
		} elseif ( in_array( "developer", $level ) ) {
			$cake_role = 'admin';
		}
		
	} else {
		$cake_role = '';
	}
	
	return $cake_role;
}

/**Helper function for tracking page views of various types*/
function cake_trackPageView( $params = array() ) {
	
	global $wgUser, $wgOut, $wgCakeSiteId;
	
	$cake = cake_singleton();
	
	if ( $cake->getSetting( 'base', 'install_complete' ) ) {
	
		//$event = $cake->makeEvent();
		//$event->setEventType( 'base.page_request' );
		$cake->setSiteId( $wgCakeSiteId );
		$cake->setProperty( 'user_name', $wgUser->mName );
		$cake->setProperty( 'user_email', $wgUser->mEmail );
		$cake->setProperty( 'language', cake_getLanguage() );
		if ( ! $cake->pageview_event->get( 'page_type') ) {
			$cake->setPageType( '(not set)' );
		}
		
		//foreach ( $params as $k => $v ) {
		//	$event->set( $k, $v );
		//}
		
		// if the page title is not set for some reasons, set it
		// using $wgOut.
		if ( ! $cake->pageview_event->get( 'page_title') ) {
			$cake->setPageTitle( 'page_title', $wgOut->getPageTitle() );
		}
		
		/*
		$tag = sprintf(
						'<!-- CAKE Page View Tracking Params -->
						var cake_params = %s;', 
						 json_encode( $event->getProperties() )
				);
				
				$wgOut->addInlineScript( $tag );
		*/
	}
		
	return true;
}

/**
 * Logs Special Page Views
 * @param object $specialPage
 * @return boolean
 */
function cake_logSpecialPage(&$specialPage) {
	
	$title_obj = $specialPage->getTitle();
	$title = $title_obj->getText();
	$cake = cake_singleton();
	$cake->setPageTitle( $title );
	$cake->setPageType( 'Special Page' );
	return true;
}

/**
 * Logs Category Page Views
 * @param object $categoryPage
 * @return boolean
 */
function cake_logCategoryPage( &$categoryPage ) {
	
	$title_obj = $categoryPage->getTitle();
	$title = $title_obj->getText();
	$cake = cake_singleton();
	$cake->setPageTitle( $title );
	$cake->setPageType( 'Category' );
	return true;
}

/**
 * Logs Article Page Views
 * @param object $article
 * @return boolean
 */
function cake_logArticle( &$article ) {
	
	$title_obj = $article->getTitle();
	$title = $title_obj->getText();
	$cake = cake_singleton();
	$cake->setPageTitle( $title );
	$cake->setPageType( 'Article' );
	return true;
}

/**
 * Helper Function for tracking Action Events
 * @param	$action_name
 * @param	$label
 * @return boolean	true
 */
function cake_trackAction( $action_name, $label ) {

	$cake = cake_singleton();
   
    if ( $cake->getSetting( 'base', 'install_complete' ) ) {
		$cake->trackAction( 'mediawiki', $action_name, $label );
		cake_coreAPI::debug( "logging action event " . $action_name );
	}
	
	return true;
}

/**
 * Logs New Articles
 * @param object $categoryPage
 * @return boolean
 */
function cake_newArticleAction(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision) {
	
	$label = $article->getTitle()->getText();
	return cake_trackAction( 'Article Created', $label );
}

function cake_editArticleAction($article, &$user, $text, $summary, 
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, 
		&$status, $baseRevId, &$redirect = '') {
	
	if ( $flags & EDIT_UPDATE ) {
		
		$label = $article->getTitle()->getText();
		return cake_trackAction( 'Article Edit', $label );
		
	} else {
		
		return true;
	}
}

function cake_deleteArticleAction( &$article, &$user, $reason, $id ) {
	
	$label = $article->getTitle()->getText();
	return cake_trackAction( 'Article Deleted', $label );
}

function cake_addUserAction( $user, $byEmail ) {
	
	$label = '';
	return cake_trackAction( 'User Account Added', $label );
}

function cake_addUploadAction( &$image ) {
	
	$label = $image->getLocalFile()->getMimeType();
	return cake_trackAction( 'File Upload', $label );
}

function cake_userLoginAction( &$user, &$inject_html ) {
	
	$label = '';
	return cake_trackAction( 'Login', $label );
}

function editTalkPageAction( $article ) {

	$label = $article->getTitle()->getText();
	return cake_trackAction( 'Talk Page Edit', $label );
}

/**
 * Adds javascript tracker to pages
 * @param object $article
 * @return boolean
 */
function cake_footer(&$wgOut, $sk) {
	
	global $wgRequest, $wgCakeThirdPartyCookies, $wgCakeCookieDomain;
	
	if ($wgRequest->getVal('action') != 'edit' && $wgRequest->getVal('title') != 'Special:Cake') {
		
		$cake = cake_singleton();
		if ($cake->getSetting('base', 'install_complete')) {
			
			$cmds  = "";
			if ( $wgCakeThirdPartyCookies ) {
				$cmds .= "cake_cmds.push( ['setOption', 'thirdParty', true] );";
			}
			
			if ( $wgCakeCookieDomain ) {
				$cmds .= "cake_cmds.push( ['setCookieDomain', '$wgCakeCookieDomain'] );";
			}
			
			$page_properties = $cake->getAllEventProperties($cake->pageview_event);
			if ( $page_properties ) {
				$page_properties_json = json_encode( $page_properties );
				$cmds .= "cake_cmds.push( ['setPageProperties', $page_properties_json] );";
			}
			
			//$wgOut->addInlineScript( $cmds );
			
			$options = array( 'cmds' => $cmds );
			
			$tags = $cake->placeHelperPageTags(false, $options);		
			$wgOut->addHTML($tags);
			
		}
	}
	
	return true;
}

/**Gets mediawiki Language variable*/
function cake_getLanguage() {
    	
	global $wgLang, $wgContLang;
	$code = '';
	
	$code = $wgLang->getCode();
	if ( ! $code ) {
		$code = $wgContLang->getCode();
	}
	
	return $code;
}  

/**
 * CAKE Special Page Class
 * Enables CAKE to be accessed through a Mediawiki special page. 
 */
class SpecialCake extends SpecialPage {

    function __construct() {
            parent::SpecialPage('Cake', 'cake_view');
            self::loadMessages();
    }

    function execute() {
    
    	global $wgRequest, $wgOut, $wgUser, $wgSitename, $wgScriptPath, $wgScript, $wgServer, 
    		   $wgDBtype, $wgDBname, $wgDBserver, $wgDBuser, $wgDBpassword;

        //must be called after setHeaders for some reason or elsethe wgUser object is not yet populated.        
        $this->setHeaders();
        
        if ($this->userCanExecute($wgUser)) {
         

	        $cake = cake_singleton();
	        $params = array();
	        
	        // if no action is found...
	        $do = cake_coreAPI::getRequestParam('do');
	        if (empty($do)) {
	        	// check to see that cake in installed.
	            if (!$cake->getSetting('base', 'install_complete')) {
					
					define('CAKE_INSTALLING', true);
					               	
	            	$site_url = $wgServer.$wgScriptPath;
	
	            	$params = array(
	            			'site_id' 		=> md5($site_url), 
							'name' 			=> $wgSitename,
							'domain' 		=> $site_url, 
							'description' 	=> '',
							'do' 			=> 'base.installStartEmbedded');
					
					$params['db_type'] = $wgDBtype;
					$params['db_name'] = $wgDBname;
					$params['db_host'] = $wgDBserver;
					$params['db_user'] = $wgDBuser;
					$params['db_password'] = $wgDBpassword;
					$params['public_url'] = $wgServer.$wgScriptPath.'/extensions/cake/';
					$page = $cake->handleRequest($params);
				
				// send to daashboard
	           } else {
	            	//$params['do'] = 'base.reportDashboard';
	            	
		           	$page = $cake->handleRequest($params);
	            }
	        // do action found on url
	        } else {
	       		$page = $cake->handleRequestFromURL(); 
	        }
	        
			return $wgOut->addHTML($page);					
		} else {
			$this->displayRestrictionError();
		}
    }

    function loadMessages() {
    	static $messagesLoaded = false;
        global $wgMessageCache;
            
		if ( $messagesLoaded ) return;
		
		$messagesLoaded = true;
		
		// this should be the only msg defined by mediawiki
		$allMessages = array(
			 'en' => array( 
				 'cake' => 'Catalyst Analytic Keyword Engine'
				 )
			);


		// load msgs in to mediawiki cache
		foreach ( $allMessages as $lang => $langMessages ) {
			   $wgMessageCache->addMessages( $langMessages, $lang );
		}
		
		return true;
    }    
}

?>