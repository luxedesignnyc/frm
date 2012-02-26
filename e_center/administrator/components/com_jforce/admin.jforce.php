<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			admin.jforce.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Set the table directory
JTable::addIncludePath( JPATH_COMPONENT_ADMINISTRATOR.DS.'com_jforce'.DS.'tables');

//Add helpers
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jforce.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'lists.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'plugin.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'menu.helper.php');

JHTML::_('behavior.mootools');

$doc =& JFactory::getDocument();
$doc->addStylesheet('components/com_jforce/css/style.css');
$doc->addScript('components/com_jforce/js/admin.jforce.js');

$controllerName = JRequest::getCmd( 'c', 'configuration' );

	require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );
	
	$controllerName = 'JforceController'.ucfirst($controllerName);

	// Create the controller
	$controller = new $controllerName();
	JModel::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
	JForceMenuHelper::getAdminSubMenu();
	// Perform the Request task
	$controller->execute( JRequest::getCmd('task') );

	// Redirect if set by the controller
	$controller->redirect();