<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			menu.helper.php												*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForceMenuHelper {
	
function getTabMenu($object, $subscribe = true, $remind = true) {
	
	$user =& JFactory::getUser();
	$view = JRequest::getVar('view');
	$c = JRequest::getVar('c','project');
	$ucView = ucwords($view);
	$pid = JRequest::getVar('pid', 0);
	
	$menu = array();
	$i = 0;

	$role = $pid ? $user->projectaccess[$pid] : $user->systemrole;
	$permission = $role->$view;
	
	# EDIT MENU ITEM #
	if($permission >=4 && $view!='ticket'):
		
		if($c=='project' && $view!='project'):
			$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=edit&pid='.$object->pid.'&id='.$object->id);
		elseif($c=='project' && $view == 'project'):
			$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=edit&pid='.$object->id);   
		else:
			$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=edit&id='.$object->id);
		endif;
		$menu[$i]['Options'] = "";		
		$menu[$i]['Text'] = JText::_('Edit ' . $ucView);
		$i++;
	
	# TRASH MENU ITEM #
	$menu[$i]['Link'] = '';
	$trashModel =& JModel::getInstance('Trash', 'JForceModel');
	$menu[$i]['Text'] = $trashModel->getTrashLink($object, $view);
	$i++;
	
	endif;
	
	
	if($permission >= 1 && $view=='ticket'):
		if($c=='project' && $view!='project'):
			$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=edit&pid='.$object->pid.'&id='.$object->id);
		elseif($c=='project' && $view == 'project'):
			$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=edit&pid='.$object->id);   
		else:
			$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=edit&id='.$object->id);
		endif;
		$menu[$i]['Options'] = "";		
		$menu[$i]['Text'] = JText::_('Edit ' . $ucView);
		$i++;
	endif;
	
	if($subscribe):
		# SUBSCRIBE MENU ITEM #
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$status = $subscriptionModel->checkSubscriptionStatus($user->id, $object->id, $view);
		$subscribeText = $status ? JText::_('Unsubscribe') : JText::_('Subscribe');
	
		$menu[$i]['Link'] = '#';
		$menu[$i]['Options'] = "id='subscribeLink'";	
		$menu[$i]['Text'] = $subscribeText;
		$i++;
	endif;
	
	if($permission >=3):
		# REMIND MENU ITEM #
		$menu[$i]['Link'] = '#';
		$menu[$i]['Options'] = "id='remindLink'";	
		$menu[$i]['Text'] = JText::_('Remind');					
		$i++;
	endif;
	
	if($view=='checklist' && $role->checklist >=3):
		$menu[$i]['Link'] = JRoute::_("index.php?option=com_jforce&c=project&view=task&layout=new&pid=".$object->pid."&cid=".$object->id);
		$menu[$i]['Options'] = "id='addTask'";
		$menu[$i]['Text'] = JText::_('New Task');
		$i++;
	endif;

	if($view=='company'):
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=new&company='.$object->id);
		$menu[$i]['Options'] = "";	
		$menu[$i]['Text'] = JText::_('New User'); 
		$i++;
	endif;
	
	if($view=='document'):
	    $menu[$i]['Link'] = $object->file->downloadUrl;
		$menu[$i]['Options'] = "";			
		$menu[$i]['Text'] = JText::_('Download');
        $i++;
		
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&view=document&layout=version&pid='.$object->pid.'&document='.$object->id);
		$menu[$i]['Options'] = "";			
		$menu[$i]['Text'] = JText::_('New Version'); 
		$i++;
	endif;
	
	if($view=='invoice' || $view=='quote'):

		$menu[$i]['Link'] = "javascript:copyObject(\"".$object->id."\",\"".$view."\");";
		$menu[$i]['Options'] = "";			
		$menu[$i]['Text'] = JText::_('Copy '.$ucView);
		$i++;
		
		# Temporarily Removed: Needs to be revisited
		#$menu[$i]['Link'] = '#';
		#$menu[$i]['Options'] = "";			
		#$menu[$i]['Text'] = JText::_('Email'); 
		#$i++;
		
		$link = 'index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=print&id='.$object->id.'&tmpl=component';
		if ($pid) $link .= '&pid='.$pid;
		
		$menu[$i]['Link'] = JRoute::_($link);
		$menu[$i]['Options'] = "onclick=\"window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;\"";
		$menu[$i]['Text'] = JText::_('Print');
		$i++;
	endif;
	
	if($view=='milestone' && $role->milestone >=3):
		$menu[$i]['Link'] = $object->rescheduleLink;
		$menu[$i]['Options'] = "id='rescheduleLink'";
		$menu[$i]['Text'] = JText::_('Reschedule');
		$i++;

		$menu[$i]['Link'] = '#';
		$menu[$i]['Options'] = "id='toggleLink'";
		$menu[$i]['Text'] = $object->completed ? JText::_('Reopen') : JText::_('Complete'); 
		$i++;
	endif;
	
	if($user->systemrole->project >=4):
		if($view=='project'):
			$menu[$i]['Link'] = "javascript:copyObject(\"".$object->id."\",\"".$view."\");";
			$menu[$i]['Options'] = '';
			$menu[$i]['Text'] = JText::_('Copy Project'); 
			$i++;
			
		endif;
	endif;
	
	if($view=='potential' || $view=='person' || $view=='campaign' || $view=='lead'): 
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c=event&view=event&layout=new&'.$view.'='.$object->id);
		$menu[$i]['Options'] = '';
		$menu[$i]['Text'] = JText::_('Add Event');
		$i++;
	endif;
	
	return $menu;
	
}

	function getQuickLinks() {
	$user =& JFactory::getUser();
	$view = JRequest::getVar('view');
	$c = JRequest::getVar('c','project');
	$ucView = ucwords($view);
	$pid = JRequest::getVar('pid', 0);
	
	$menu = array();
	$i = 0;

	$role = $pid ? $user->projectaccess[$pid] : $user->systemrole;
	if(($view=='quote' || $view=='invoice' || $view=='ticket') && $pid=='0'):
		$field = 'global_'.$view;
		$permission = $role->$field;
	elseif($view=='message'):
		$permission = $role->can_access_messages;
		$permission = $permission==1 ? 4 : 0;
	else:
		$permission = $role->$view;
	endif;
	
	if($permission >= 3):
		if($pid):
			$link = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=new&pid='.$pid);
		else:
			$link = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=new');
		endif;
	
			$menu[$i]['Link'] = $link;
			$menu[$i]['Options'] = '';
			$menu[$i]['Text'] = JText::_('New');		
			$i++;
	endif;

	if($permission>=4):
		# TRASH MENU ITEM #
		$menu[$i]['Link'] = 'javascript:void(0)';
		$menu[$i]['Options'] = 'onclick="submitbutton(\'trash\')"';
		$menu[$i]['Text'] = JText::_('Delete');
		$i++;
	endif;

	return $menu;
	
	}

	function getTopMenu($model) {
		
	}

	function getAdminSubMenu() {
		$uri = &JFactory::getURI();
		$current = 'index.php?'.$uri->getQuery();
		
		$configurationModel = &JModel::getInstance('Configuration', 'JForceModel');
		$buttons = $configurationModel->listButtons();
		
		for ($i=0; $i<count($buttons); $i++) :
			$b = $buttons[$i];
			$active = $current == $b['link'] ? true : false;
			JSubMenuHelper::addEntry(JText::_( $b['name'] ), $b['link'], $active);
		endfor;
		
	}

}