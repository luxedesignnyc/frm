<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			view.html.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view'); 

class JforceViewWeighting extends JView {
	
function display($tpl = null) {
       
		// Add front-side Models
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
		$pid = JRequest::getVar('pid');
		$model = &JModel::getInstance('Weight', 'JForceModel');
		
		$lists = $model->buildProjectLists($pid);
		
		$this->assignRef('lists', $lists);
		$this->assignRef('pid', $pid);
       
        parent::display($tpl);
	}	
	
}