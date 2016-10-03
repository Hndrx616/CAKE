<?php
//*******************************************************************
//Template Name: cake_reportController.php
//Author: Stephen Hilliard (c) 2016
//Developer: Stephen Hilliard (c) 2016
//license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// @project: cake_reportController
//*******************************************************************/

require_once(CAKE_BASE_CLASSES_DIR.'cake_adminController.php');

class cake_reportController extends cake_adminController {
	
	/**
	 * Constructor
	 * @param array $params
	 * @return
	 */
	function __construct($params) {	
		$this->setControllerType('report');
		$this->setRequiredCapability('view_reports');
		parent::__construct($params);
		
		// set a siteId is none is set on the request params
		$siteId = $this->getCurrentSiteId();
		
		if ( ! $siteId ) {
			//$siteId = $this->getDefaultSiteId();
		}
		
		$this->setParam( 'siteId', $siteId );
	}
	
	
	/**Pre Action: Current user is fully authenticated and loaded by this point*/
	function pre() {
		
		$sites = $this->getSitesAllowedForCurrentUser();
		$this->set('sites', $sites);
		
		$this->set( 'currentSiteId', $this->getParam('siteId') );
		
		// pass full set of params to view
		$this->data['params'] = $this->params;
		
		// setup the time period object in $this->period				
		$this->setPeriod();
		// check to see if the period is a default period. TODO move this ot view where needed.
		$this->set('is_default_period', $this->period->isDefaultPeriod() );
		$this->setView('base.report');
		$this->setViewMethod('delegate');
		
		$this->dom_id = str_replace('.', '-', $this->getParam('do'));
		$this->data['dom_id'] = $this->dom_id;
		$this->data['do'] = $this->getParam('do');
		$nav = cake_coreAPI::getGroupNavigation('Reports');
		// setup tabs
		$siteId = $this->get('siteId');
		if ($siteId) {
			$gm = cake_coreAPI::supportClassFactory('base', 'goalManager', $siteId);
			
			$tabs = array();
			$site_usage = array(
					'tab_label'		=> 'Site Usage',
					'metrics'		=> 'visits,pagesPerVisit,visitDuration,bounceRate,uniqueVisitors',
					'sort'			=> 'visits-',
					'trendchartmetric'	=>	'visits'
			);
			
			$tabs['site_usage'] = $site_usage;
			
			// ecommerce tab
			if ( cake_coreAPI::getSiteSetting( $this->getParam('siteId'), 'enableEcommerceReporting') ) {
			
				$ecommerce = array(
						'tab_label'		=> 'e-commerce',
						'metrics'		=> 'visits,transactions,transactionRevenue,revenuePerVisit,revenuePerTransaction,ecommerceConversionRate',
						'sort'			=> 'transactionRevenue-',
						'trendchartmetric'	=>	'transactions'
				);
			
				$tabs['ecommerce'] = $ecommerce;
			}		
			$goal_groups = $gm->getActiveGoalGroups();
			
			if ( $goal_groups ) {
				foreach ($goal_groups as $group) {
					$goal_metrics = 'visits';
					$active_goals = $gm->getActiveGoalsByGroup($group);
						
					if ( $active_goals ) {
					
						foreach ($active_goals as $goal) {
							$goal_metrics .= sprintf(',goal%sCompletions', $goal);
						}
					}
					
					$goal_metrics .= ',goalValueAll';
					$goal_group = array(
							'tab_label'		=>	$gm->getGoalGroupLabel($group),
							'metrics'		=>	$goal_metrics,
							'sort'			=> 'goalValueAll-',
							'trendchartmetric'	=>	'visits'
					);
					$name = 'goal_group_'.$group;
					$tabs[$name] = $goal_group;
				}
			}
					
			$this->set('tabs', $tabs);
			$this->set('tabs_json', json_encode($tabs));
		
			
		
			if ( ! cake_coreAPI::getSiteSetting( $this->getParam( 'siteId' ), 'enableEcommerceReporting' ) ) {
			
				unset($nav['Ecommerce']);
			}
		}				
		
		//$this->body->set('sub_nav', cake_coreAPI::getNavigation($this->get('nav_tab'), 'sub_nav'));
		
		
		$this->set('top_level_report_nav', $nav);		
		
		
	}
	
	function post() {
		
		return;
	}
	
	function setTitle($title, $suffix = '') {
		
		$this->set('title', $title);
		$this->set('titleSuffix', $suffix);
	}
	
	/**
	 * Chooses a siteId from a list of AllowedSites needed jsut in case a siteId is not passed on the request.
	 * @return string
	 */
	protected function getDefaultSiteId() {
		
		$db = cake_coreAPI::dbSingleton();
		$db->select('site_id');
		$db->from('cake_site');
		$db->limit(1);
		$ret = $db->getOneRow();
		
		return $ret['site_id'];
	}
	
	protected function hideReportingNavigation() {
		
		$this->set('hideReportingNavigation', true);
	}
	
	protected function hideSitesFilter() {
		
		$this->set('hideSitesFilter', true);
	}
}

?>