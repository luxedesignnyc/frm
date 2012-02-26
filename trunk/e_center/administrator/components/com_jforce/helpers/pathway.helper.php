<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			pathway.helper.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForcePathwayHelper {

	function getPathway() {
		
		global $mainframe;
	
		$c = JRequest::getVar('c');
		$view = JRequest::getVar('view');
		$layout = JRequest::getVar('layout','default');

		$pid = JRequest::getVar('pid',0);
		$id = JRequest::getVar('id',0);
		
		$title = $id ? JText::_('Edit '.ucwords($view)) : JText::_('New '.ucwords($view)); 
		
		if($pid):
			$projectModel =& JModel::getInstance('Project','JForceModel');
			$project = $projectModel->getProject();
		endif;
		
		$pathway =& $mainframe->getPathway();
		
		if ($pid) :
			$pathway->addItem(JText::_('All Projects'), JRoute::_('index.php?option=com_jforce&c=project&view=project'));	
			$pathway->addItem(JText::_($project->name), JRoute::_('index.php?option=com_jforce&c=project&view=project&layout=project&pid='.$pid));
		endif;
		
		$plural = JForcePathwayHelper::pluralize($view);
		
		$layout_view_link = 'index.php?option=com_jforce&c='.$c.'&view='.$view;
		$layout_view_link = $pid ? $layout_view_link.'&pid='.$pid : $layout_view_link;
		
		if($layout=='default' && $view!='project'): 
			$pathway->addItem(JText::_(ucwords($plural)));
		elseif($layout==$view && $view!='project'): 
			$pathway->addItem(JText::_(ucwords($plural)), JRoute::_($layout_view_link));			
		elseif($view!='project'):
			$pathway->addItem(JText::_(ucwords($plural)), JRoute::_($layout_view_link));
			$pathway->addItem($title);
		endif;
		
	}
	
	function pluralize($word) {
		
		if ($word == 'company') :
			$plural = 'companies';
		else:
			$plural = $word.'s';
		endif;
		
		return $plural;
	}

}