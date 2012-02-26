<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			project.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access

defined('_JEXEC') or die('Restricted access');

class JTableProjectTemplate extends JTable
{ 

	var $id					= null;
	
	var $name				= null;
			
	var $description		= null;
			
	var $milestones			= null;
	
	var $checklists			= null;
						
	var $discussions		= null;
			
	var $documents			= null;
			
	var $quotes				= null;
	
	var $invoices			= null;
			
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_projecttemplates', 'id', $_db );
	}	
}