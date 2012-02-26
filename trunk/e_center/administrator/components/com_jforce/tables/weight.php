<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			servicecf.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableWeight extends JTable
{ 

	var $id					= null;
	
	var $project			= null;
	
	var $lead				= null;
	
	var $global_ticket		= null;
	
	var $ticket				= null;
			
	var $person				= null;
			
	var $weight				= null;
			
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_weights', 'id', $_db );
	}	
}