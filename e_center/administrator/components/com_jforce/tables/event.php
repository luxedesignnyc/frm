<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			task.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableEvent extends JTable
{ 

	var $id						= null;
	
	var $subject				= null;
	
	var $description			= null;
	
	var $location				= null;
	
	var $status					= null;
			
	var $priority				= null;
	
	var $type					= null;
	
	var $tags					= null;
	
	var $startdate				= null;
			
	var $enddate				= null;
				
	var $recurring				= null;
			
	var $completed				= null;

	var $created				= null;
			
	var $modified				= null;
			
	var $author					= null;
	
	var $published				= null;
	
	var $lead					= null;
	
	var $potential				= null;
	
	var $campaign				= null;
	
	var $person					= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_events', 'id', $_db );
	}	
}