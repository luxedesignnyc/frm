<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			customfield.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class JforceControllerCustomfield extends JController { 

	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'customfield'; 
		
			JRequest::setVar('view', $default );
		}
		
		parent::display();	
	}
	
	function save() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post = JRequest::get('post');
		$model =& $this->getModel('customfield');
		$model->save($post);

		$msg = JText::_('Item successfully saved.');
		
		$referer = JRequest::getVar('ret', JURI::base());


		$this->setRedirect($referer, $msg);		
	}
	
	function cancel()
	{

		// If the task was cancel, we go back to the item
		$referer = JRequest::getString('ret', JURI::base());

		$this->setRedirect($referer);
	}
	
	function orderup() {
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$model =& $this->getModel('customfield');
		$model->order(-1);
		
		$filter = JRequest::getVar('fieldtypefilter');
		$url = 'index.php?option=com_jforce&view=customfield';
		if ($filter) $url .= '&fieldtypefilter='.$filter;
		$this->setRedirect($url);
	}
	
	function orderdown() {
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$model =& $this->getModel('customfield');
		$model->order(1);
		
		$filter = JRequest::getVar('fieldtypefilter');
		$url = 'index.php?option=com_jforce&view=customfield';
		if ($filter) $url .= '&fieldtypefilter='.$filter;
		$this->setRedirect($url);
	}
	
	function saveorder() {
		JRequest::checkToken() or jexit('Invalid Token');
		
		$model=&$this->getModel('customfield');
		$model->saveOrder();
		
		$msg = JText::_('Order saved successfully'); 
		
		$this->setRedirect('index.php?option=com_jforce&view=customfield',$msg);
	}
	
	function delete() {
		JRequest::checkToken() or jexit( 'Invalid Token' );
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
		$post = JRequest::get('post');
		$model =& $this->getModel($post['model']);
		$model->delete($post);
		
		$ret = $_SERVER['HTTP_REFERER'];
		$msg = JText::_('Item Successfully Deleted');
		$this->setRedirect($ret, $msg);
	}
	
	function trash() {
		JRequest::checkToken() or jexit('Invalid Token');
		$post = JRequest::get('post');
		$model =& $this->getModel('customfield');
		$model->trash($post);

		$msg = JText::_('Item(s) successfully trashed.');
		
		$referer = JRequest::getVar('ret', JURI::base());


		$this->setRedirect($referer, $msg);				
	}

}