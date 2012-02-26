<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			lists.helper.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access 
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForceListsHelper {
	
	function getMilestoneList($default = null) {
		$milestoneModel = &JModel::getInstance('Milestone', 'JforceModel');
		$milestones = $milestoneModel->listMilestones();
		
		$incomplete = array_merge($milestones['late'], $milestones['active']);
		$complete = $milestones['completed'];

		$milestone_options[] = JHTML::_('select.option', '', '---');

		if ($incomplete) :
			$milestone_options[] = JHTML::_('select.optgroup', JText::_('Active'));
		endif;

		for($i=0; $i<count($incomplete);$i++) :
			$m = $incomplete[$i];
			$milestone_options[] = JHTML::_('select.option', $m->id, $m->summary);
		endfor;
		
		if ($complete) :
			$milestone_options[] = JHTML::_('select.optgroup', JText::_('Completed'));
		endif;
		
		for($i=0; $i<count($complete);$i++) :
			$m = $complete[$i];
			$milestone_options[] = JHTML::_('select.option', $m->id, $m->summary);
		endfor;
		
		return JHTML::_('select.genericlist', $milestone_options, 'milestone', 'class="inputbox" style="max-max-width:240px"', 'value', 'text', $default);	
	}
	
	function getCategoryList($default = null, $type = 'generalcategories', $name = NULL) {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$categories = $configModel->getConfig($type, true);

		$category_options[] = JHTML::_('select.option', '', '---');

		for($i=0; $i<count($categories); $i++) :
			$category = $categories[$i];
			$category_options[] = JHTML::_('select.option', $category, $category);
		endfor;
		$name = $name ? $name : 'category';
		return JHTML::_('select.genericlist', $category_options, $name, 'class="inputbox" style="max-width:240px"', 'value', 'text', $default);	
	}
	
	function getPriorityList($default = null, $name = NULL) {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$priorities = $configModel->getConfig('priority', true);

		$priority_options[] = JHTML::_('select.option', '', '---');

		for($i=0; $i<count($priorities); $i++) :
			$priority = $priorities[$i];
			$priority_options[] = JHTML::_('select.option', $priority, $priority);
		endfor;
	
		$name = $name ? $name : 'priority';
	
		return JHTML::_('select.genericlist', $priority_options, $name, 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getEventPriorityList($default = null) {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$priorities = $configModel->getConfig('event_priority', true);

		$priority_options[] = JHTML::_('select.option', '', '---');

		for($i=0; $i<count($priorities); $i++) :
			$priority = $priorities[$i];
			$priority_options[] = JHTML::_('select.option', $priority, $priority);
		endfor;
	
		return JHTML::_('select.genericlist', $priority_options, 'priority', 'class="inputbox"', 'value', 'text', $default);	
	}
	
function getEventTypeList($default = null) {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$types = $configModel->getConfig('event_type', true);

		$type_options[] = JHTML::_('select.option', '', '---');

		for($i=0; $i<count($types); $i++) :
			$type = $types[$i];
			$type_options[] = JHTML::_('select.option', $type, $type);
		endfor;
	
		return JHTML::_('select.genericlist', $type_options, 'type', 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getChecklistList($default = null) {
		$checklistModel = &JModel::getInstance('Checklist','JForceModel');
		$checklistModel->setVar('id', '');
		$checklists = $checklistModel->listChecklists();
		$checklist_options[] = JHTML::_('select.option', '', '---');
		
		for($i=0;$i<count($checklists);$i++):
			$checklist = $checklists[$i];
			$checklist_options[] = JHTML::_('select.option',$checklist->id,$checklist->summary);
		endfor;
		
		return JHTML::_('select.genericlist',$checklist_options,'checklist','class="inputbox" style="max-width: 240px"', 'value','text',$default);	
	}
	
	function getProjectList($default = null) {
		$projectModel = &JModel::getInstance('Project','JForceModel');
		$projects = $projectModel->listProjects();

		$project_options[] = JHTML::_('select.option', '', '---');
		
		for($i=0;$i<count($projects);$i++):
			$project = $projects[$i];
			$project_options[] = JHTML::_('select.option',$project->id,$project->name);
		endfor;
		
		return JHTML::_('select.genericlist',$project_options,'pid','class="inputbox" style="max-width: 240px"', 'value','text',$default);	
	}
	
	function getProjectPermissionList($field, $value, $name,$empty = false, $default = null) {
		$db = &JFactory::getDBO();
		$projectModel = &JModel::getInstance('Project','JForceModel');
		
		$where = $projectModel->_buildWhere();
		$order = $projectModel->_buildOrder();
		
		$where .= ' AND cf.'.$field.' >= '.$value;
		
		$query = 'SELECT b.id,b.name '.
				' FROM #__jf_projects AS b' .
				' INNER JOIN #__jf_projectroles_cf AS cf ON cf.pid = b.id'.
				$where.
				$order;
				
		$db->setQuery($query);
		$projects = $db->loadObjectList();
		
		if (!$projects && !$empty) :
			return false;
		endif;
		
		$project_options[] = JHTML::_('select.option', '', '---');
		
		for($i=0;$i<count($projects);$i++):
			$project = $projects[$i];
			$project_options[] = JHTML::_('select.option',$project->id,$project->name);
		endfor;
		
		return JHTML::_('select.genericlist',$project_options,$name,'class="inputbox" style="max-width: 240px"', 'value','text',$default);	
	}
	
	
	function getAccessRoleList($default = null) {
		$accessRoleModel = &JModel::getInstance('Accessrole', 'JforceModel');
		$accessRoleModel->setId(null);
		$roles = $accessRoleModel->listAccessroles();
		
		$ids = array();
		$role_options = array();
		for($i=0; $i<count($roles);$i++) :
			$r = $roles[$i];
			$role_options[] = JHTML::_('select.option', $r->id, $r->name);
			$ids[] = $r->id;
		endfor;
		
		if (!in_array($default,$ids)) :
			$default = '';
		endif;
		
		$role_options[] = JHTML::_('select.option', '', 'Custom');
		
		return JHTML::_('select.genericlist', $role_options, 'systemrole', 'class="inputbox"', 'value', 'text', $default, 'accessrole');	
	}
	
	
	
	function getProjectRoleList($default = '') {
		
		$projectRoleModel = &JModel::getInstance('Projectrole', 'JforceModel');
		$projectRoleModel->setId(null);
		$roles = $projectRoleModel->listProjectroles();
		$role_options = array();
		
		$possible = false;
		for($i=0; $i<count($roles);$i++) :
			$r = $roles[$i];
			$role_options[] = JHTML::_('select.option', $r->id, $r->name);
			if ($r->id == $default) :
				$possible = true;
			endif;
		endfor;
		
		$role_options[] = JHTML::_('select.option', '', 'Custom');
		
		$default = $possible ? $default : ''; 
		
		return JHTML::_('select.genericlist', $role_options, 'projectrole', 'class="inputbox"', 'value', 'text', $default, 'projectrole');	
	}
	
	function getStatusList($default = null) {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$status = $configModel->getConfig('status', true);
	
		for($i=0; $i<count($status); $i++) :
			$s = $status[$i];
			$status_options[] = JHTML::_('select.option', $s, $s);
		endfor;
	
		return JHTML::_('select.genericlist', $status_options, 'status', 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getLeadStatusList($default = null) {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$status = $configModel->getConfig('lead_status', true);
	
		for($i=0; $i<count($status); $i++) :
			$s = $status[$i];
			$status_options[] = JHTML::_('select.option', $s, $s);
		endfor;
	
		return JHTML::_('select.genericlist', $status_options, 'status', 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getEventStatusList($default = null) {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$status = $configModel->getConfig('event_status', true);
	
		for($i=0; $i<count($status); $i++) :
			$s = $status[$i];
			$status_options[] = JHTML::_('select.option', $s, $s);
		endfor;
	
		return JHTML::_('select.genericlist', $status_options, 'status', 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getJoomlaUsers() {
		
		$query = "SELECT p.uid FROM #__jf_persons AS p";
		$this->_db->setQuery($query);
		$current = $this->_db->loadResultArray();
		
		$where = ' WHERE u.id <> '.implode(' AND u.id <>',$current);
		
		$query = "SELECT u.id, u.name, u.username ".
				 "FROM #__users AS u ".
				 "LEFT JOIN #__jf_persons AS p ON p.uid = u.id ".
				 $where;

		$this->_db->setQuery($query);
		$users = $this->_db->loadObjectList();
		$joomlaUsers[] = JHTML::_('select.option','', JText::_('New User'));
		for($i=0; $i<count($users); $i++) :
			$u = $users[$i];
			$name = $u->name.' ['.$u->username.']';
			$joomlaUsers[] = JHTML::_('select.option', $u->id, $name);
		endfor;
	
		return JHTML::_('select.genericlist', $joomlaUsers, 'uid', 'class="inputbox"', 'value', 'text', '', 'uidList');	
	}
	
	function getClientList($default = null, $name = null) {
		$companyModel =& JModel::getInstance('Company', 'JForceModel');
		$companyModel->setId(null);
		$company = $companyModel->listCompanies();
		
		$company_options[] = JHTML::_('select.option','','---');
		for($i=0; $i<count($company); $i++) :
			$c = $company[$i];
			$company_options[] = JHTML::_('select.option', $c->id, $c->name);
		endfor;
	
		$name = $name ? $name : 'company';
	
		return JHTML::_('select.genericlist', $company_options, $name, 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getLeadList($default = null) {
		$leadModel =& JModel::getInstance('Lead', 'JForceModel');
		$leadModel->setId(null);
		$leads = $leadModel->listLeads();
		
		$lead_options[] = JHTML::_('select.option','','---');
		for($i=0; $i<count($leads); $i++) :
			$l = $leads[$i];
			$lead_options[] = JHTML::_('select.option', $l->id, $l->firstname.' '.$l->lastname);
		endfor;
	
		return JHTML::_('select.genericlist', $lead_options, 'lead', 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getLeaderList($default = null) {
		$personModel =& JModel::getInstance('Person', 'JForceModel');
		$personModel->setId(null);
		$leader = $personModel->listPersons();
		
		$leader_options[] = JHTML::_('select.option','','---');
		for($i=0; $i<count($leader); $i++) :
			$l = $leader[$i];
			$leader_options[] = JHTML::_('select.option', $l->id, $l->name);
		endfor;
	
		return JHTML::_('select.genericlist', $leader_options, 'leader', 'class="inputbox"', 'value', 'text', $default);	
	}

	function getOwnerList($company, $default = null) {
		$personModel =& JModel::getInstance('Person', 'JForceModel');
		$personModel->setId(null);
		$personModel->setCompany($company);
		
		$owner = $personModel->listPersons();
		
		$owner_options[] = JHTML::_('select.option','','---');
		
		if ($company) :
			for($i=0; $i<count($owner); $i++) :
				$o = $owner[$i];
				$owner_options[] = JHTML::_('select.option', $o->uid, $o->name);
			endfor;
		endif;
	
		return JHTML::_('select.genericlist', $owner_options, 'owner', 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getProjectPeople($project = null, $default = null) {
		$personModel =& JModel::getInstance('Person','JForceModel');
		$personModel->setPid($project);
		$persons = $personModel->listPersons();
		
		$person_options[] = JHTML::_('select.option','','---');
		
		for($i=0;$i<count($persons);$i++):
			$person = $persons[$i];		
			$companies[$person->company][] = $person;
		endfor;
		
		foreach($companies as $company => $people):
		
			$person_options[] = JHTML::_('select.optgroup',$company);
			
			for($j=0;$j<count($people);$j++):
				$person = $people[$j];
				$person_options[] = JHTML::_('select.option',$person->uid,$person->name);
			endfor;
			
		endforeach;
		
		return JHTML::_('select.genericlist',$person_options, 'uid', 'class="inputbox"','value','text', $default);
	}
	
	function getGatewayList($default) {
		$gatewayModel = &JModel::getInstance('Gateway', 'JForceModel');
		
		if (!$default) :
			$default = $gatewayModel->loadDefault();
			$default = $default->id;
		endif;
		
		$gateways = $gatewayModel->listGateways();
		
		$gateway_options[] = JHTML::_('select.option', '', '---');
		
		for($i=0; $i<count($gateways); $i++) :
			$gateway_options[] = JHTML::_('select.option', $gateways[$i]->id, $gateways[$i]->name);
		endfor;
		
		return JHTML::_('select.genericlist',$gateway_options, 'payment_method', 'class="inputbox"','value','text', $default);
		
	}
	
	function getVisibilityList($default, $id, $dropdown = false, $name = NULL, $yesno = true) {
		
		$default = !$id ? 1 : $default;
		
		$name = $name ? $name : 'visibility';
		
		if ($dropdown) :
			if($yesno) :
				$options[] = JHTML::_('select.option',0,JText::_('No'));
				$options[] = JHTML::_('select.option',1,JText::_('Yes'));
			else :
				$options[] = JHTML::_('select.option',0,JText::_('Private'));
				$options[] = JHTML::_('select.option',1,JText::_('Public'));
			endif;
			$html = JHTML::_('select.genericlist', $options, $name, 'class="inputbox"', 'value', 'text', $default); 
		else :
			$html = JHTML::_('select.booleanlist', $name, '', $default, JText::_('Public'), JText::_('Private')); 
		endif;
		
		return $html;
	}
	
	function getResolvedList($default) {
			
		return JHTML::_('select.booleanlist', 'resolved', '', $default, JText::_('Yes'), JText::_('No'));
	}
	
	function getAcceptedList($default) {
		$options[] = JHTML::_('select.option',0,'Pending');
		$options[] = JHTML::_('select.option',-1,JText::_('Denied'));
		$options[] = JHTML::_('select.option',1,JText::_('Accepted'));
		return JHTML::_('select.genericlist', $options, 'accepted', 'class="inputbox"', 'value', 'text', $default);	
	}
	function getPaidList($default) {
		
		$options[] = JHTML::_('select.option',0,JText::_('Unpaid'));
		$options[] = JHTML::_('select.option',1,JText::_('Paid'));
		$options[] = JHTML::_('select.option',-1,JText::_('Refunded'));
		return JHTML::_('select.genericlist', $options, 'paid', 'class="inputbox"', 'value', 'text', $default);
		
	}
	
	function getPublishedList($default) {
		
		return JHTML::_('select.booleanlist', 'published', '', $default, JText::_('Yes'), JText::_('No'));
		
	}
	
	function getDefaultList($default) {
		
		return JHTML::_('select.booleanlist', 'default', '', $default, JText::_('Yes'), JText::_('No'));
		
	}
	
	function getCampaignList($default = null) {
		
		$campaignModel =& JModel::getInstance('Campaign','JForceModel');
		$campaigns = $campaignModel->listCampaigns();
		
		$campaignOptions = array();
		$campaignOptions[] = JHTML::_('select.option', '', '---');
		for($i=0;$i<count($campaigns);$i++):
			$campaign = $campaigns[$i];
			$campaignOptions[] = JHTML::_('select.option',$campaign->id,$campaign->name);
		endfor;
		
		

		return JHTML::_('select.genericlist',$campaignOptions,'campaign', 'class="inputbox" style="max-max-width:240px"','value','text',$default);
	}
	
	function getPotentialList($default = null) {
		
		$potentialModel =& JModel::getInstance('Potential','JForceModel');
		$potentials = $potentialModel->listPotentials();
		
		$potentialOptions = array();
		$potentialOptions[] = JHTML::_('select.option', '', '---');
		for($i=0;$i<count($potentials);$i++):
			$potential = $potentials[$i];
			$potentialOptions[] = JHTML::_('select.option',$potential->id,$potential->name);
		endfor;
		
		

		return JHTML::_('select.genericlist',$potentialOptions,'potential', 'class="inputbox" style="max-width:240px"','value','text',$default);
	}

	function getSalesStages($default = null) {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$stages = $configModel->getConfig('sales_stages',true);

		$stageOptions[] = JHTML::_('select.option', '', '---');

		for($i=0; $i<count($stages); $i++) :
			$stage = $stages[$i];
			$stageOptions[] = JHTML::_('select.option', $stage, $stage);
		endfor;
	
		return JHTML::_('select.genericlist', $stageOptions, 'salesstage', 'class="inputbox" style="max-width:240px"', 'value', 'text', $default);	
	}

	function getFieldObjectList($default) {
		
		$types = array('lead','person', 'company','ticket', 'milestone', 'checklist', 'discussion','document', 'quote','invoice','potential','campaign', 'event','note');
		
		foreach ($types as $v) :
			$type_options[] = JHTML::_('select.option', $v, ucwords($v));
		endforeach;
		
		return JHTML::_('select.genericlist', $type_options, 'type', 'class="inputbox"', 'value', 'text', $default);
		
	}
	
	function getFieldTypeList($default) {
		$fieldtypes = array('textbox', 'textarea', 'select', 'radio', 'checkbox');
		
		foreach ($fieldtypes as $f) :
			$fieldtype_options[] = JHTML::_('select.option', $f, ucwords($f));
		endforeach;
	
		return JHTML::_('select.genericlist', $fieldtype_options, 'fieldtype', 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getCurrencyList($default) {
		$currencies = array(
							'Dollar'	=>	'#36;', 
							'GBP' 		=>	'#163;',
							'Euro' 		=>	'#128;', 
							'Yen'		=>	'#165;', 
							'Franc'		=>	'#8355;',
							'Lira'		=>	'#8356;',
							'Peseta'	=>	'#8359;',
							'Rupee'		=>	'#8360;',
							'Peso'		=>	'#8369;',
							'Won'		=>	'#8361;'
						);
		
		foreach ($currencies as $k=>$v) :
			$currency_options[] = JHTML::_('select.option', $v, '&'.$v.' ('.$k.')');
		endforeach;
	
		return JHTML::_('select.genericlist', $currency_options, 'currency', 'class="inputbox"', 'value', 'text', $default);	
	}

	function getTimeList($name,$default) {
		if ($default) :
			$stamp = strtotime($default);
		else :
			$stamp = mktime(8,0,0,date("m"),date("d"),date("Y"));	
		endif;
		$date = date("Y-m-d",$stamp);
		$hour = date("g",$stamp);
		$minute = date("i",$stamp);
		$meridiem = date("A",$stamp);
		
		$dateSelect = JHTML::_('calendar', $date, $name.'[date]', $name.'date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19', 'readonly'=>'readonly'));
		
		$hourList = JHTML::_('select.integerlist',1,12,1,$name.'[h]', 'class="inputbox"',$hour);
		$minuteList = JHTML::_('select.integerlist',00,59,1,$name.'[m]', 'class="inputbox"',$minute, '%02d');
		
		$meridiemOptions[] = JHTML::_('select.option', 'AM', 'AM');
		$meridiemOptions[] = JHTML::_('select.option', 'PM', 'PM');
		
		$meridiemList = JHTML::_('select.genericlist', $meridiemOptions, $name.'[mer]', 'class="inputbox"', 'value', 'text', $meridiem);	
		
		$html = $dateSelect.'<br /><br />'.$hourList.'&nbsp;:&nbsp;'.$minuteList.'&nbsp;&nbsp;'.$meridiemList;
		
		return $html;
	}

	function getShowHelpList($default) {
		return JHTML::_('select.booleanlist', 'showhelp', '', $default, JText::_('Yes'), JText::_('No'));
	}
	
	function getTaxEnabledList($default) {
		return JHTML::_('select.booleanlist', 'tax_enabled', '', $default, JText::_('Yes'), JText::_('No'));
	}

	function getRequiredList($default) {
		return JHTML::_('select.booleanlist', 'required', '', $default, JText::_('Yes'), JText::_('No'));
	}
	
	function getPublicList($default) {
		return JHTML::_('select.booleanlist', 'public', '', $default, JText::_('Yes'), JText::_('No'));	
	}
	
	function getLeadAutoAssignList($default) {
		return JHTML::_('select.booleanlist', 'config[lead_auto_assign]', '', $default, JText::_('Yes'), JText::_('No'));	
	}
	
	function getTicketAutoAssignList($default, $name = NULL) {
		$name = $name ? $name : 'config[global_ticket_auto_assign]';
		
		return JHTML::_('select.booleanlist', $name, '', $default, JText::_('Yes'), JText::_('No'));	
	}
	
	function getLeadAssignTypeList($default) {
		$options[] = JHTML::_('select.option','0',JText::_('Random'));
		$options[] = JHTML::_('select.option','1',JText::_('Weighted'));
		
		return JHTML::_('select.genericlist', $options, 'config[lead_assign_type]', 'class="inputbox"', 'value', 'text', $default);
	}
	
	function getTicketAssignTypeList($default, $name = NULL) {
		$options[] = JHTML::_('select.option','0',JText::_('Random'));
		$options[] = JHTML::_('select.option','1',JText::_('Weighted'));
		
		$name = $name ? $name : 'config[global_ticket_assign_type]';
		
		return JHTML::_('select.genericlist', $options, $name, 'class="inputbox"', 'value', 'text', $default);
	}
	
	function getCustomFieldTypeList($default) {
		$fieldtypes = array('lead','person', 'company','ticket', 'milestone', 'checklist', 'discussion','document', 'quote','invoice','potential','campaign','event', 'note');
		
		$fieldtype_options[] = JHTML::_('select.option','',JText::_('All Types'));
		foreach ($fieldtypes as $f) :
			$fieldtype_options[] = JHTML::_('select.option', $f, ucwords($f));
		endforeach;
		
		$javascript = 'onchange="document.adminForm.submit();"';	
		return JHTML::_('select.genericlist', $fieldtype_options, 'fieldtypefilter', $javascript. 'class="inputbox"', 'value', 'text', $default);	
	}
	
	function getBlankList($default,$name,$class = NULL) {
		
		$options[] = JHTML::_('select.option','','---');
		
		if ($default) :
			$options[] = JHTML::_('select.option',$default,$default);
		endif;
		
		$class = $class ? $class : 'inputbox';
		
		return JHTML::_('select.genericlist', $options, $name, 'class="'.$class.'"', 'value', 'text', $default);	
	}
	
	function getRepositoryList($default = NULL, $name = NULL) {
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		$config = &JModel::getInstance('Configuration', 'JForceModel');
		$path 	= $config->getConfig('repository_path');
		$path 	= $path ? $path : 'images';
		
		$path = JPATH_SITE.DS.$path;
		$files = JFolder::files($path, '', true, true);

		$options[] = JHTML::_('select.option','','---');
		for ($i=0; $i<count($files); $i++) :
			$f = $files[$i];
			$options[] = JHTML::_('select.option', $f, JFile::getName($f));
		endfor;
		
		$name = $name ? $name : 'file';
		
		return JHTML::_('select.genericlist', $options, $name, 'class="inputbox"', 'value', 'text', $default);	
		
	}
	
	function getProjectTemplateList() {
		$model = &JModel::getInstance('ProjectTemplate', 'JForceModel');
		$templates = $model->listProjectTemplates();
		
		$options[] = JHTML::_('select.option','','---');
		for ($i=0; $i<count($templates); $i++) :
			$t = $templates[$i];
			$options[] = JHTML::_('select.option', $t->id, $t->name);
		endfor;
		
		return JHTML::_('select.genericlist', $options, 'projecttemplate', 'class="inputbox"', 'value', 'text');	
	}
	

}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                