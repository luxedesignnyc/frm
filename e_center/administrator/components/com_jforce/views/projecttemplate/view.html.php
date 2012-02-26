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

class JforceViewProjectTemplate extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		// Add front-side Models
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');

        $model = JModel::getInstance('ProjectTemplate','JForceModel');


		if($layout == 'form') {
			$this->_displayForm($tpl, $model);
			return;
		}
		
		// Load the JEditor object
		$editor =& JFactory::getEditor();
				
		$templates = $model->listProjectTemplates();
		
		$this->assignRef('templates', $templates);

        parent::display($tpl);		
	}	
	
	function _displayForm($tpl, $model) {
		global $option, $mainframe;

		jimport('joomla.html.pane');

		// Initialize variables
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();	
		$tabs 		=& JPane::getInstance('tabs');
		
		$js = "window.addEvent('domready', function() {
			
				$$('.addButton').addEvent('click', function(e) {
					e = new Event(e).stop();
					addContainer(this.id);	
				});
			
				$$('.deleteButton').addEvent('click', function(e) {
					e = new Event(e).stop();
					deleteContainer(this);	
				});
				
				$$('.addTask').addEvent('click', function(e) {
					e = new Event(e).stop();
					addTask(this);	
				});
				
				$$('.deleteTask').addEvent('click', function(e) {
					e = new Event(e).stop();
					deleteTask(this);	
				});
			
				populateMilestoneSelects();
				initMilestones();
			
			});";
		
		$document->addScriptDeclaration($js);
		
		// Load the JEditor object
		$editor =& JFactory::getEditor();
		
		$checked = JRequest::getVar('boxchecked',0);

		if($checked):
			$cid = JRequest::getVar('cid', 0);
			$id = $cid[0];
			$model->setVar('id',$id);
		endif;
		
		$template = &$model->getProjectTemplate();
	
		$model->parseTemplate();
		$model->buildItemLists();
		
		$milestones 	= $model->get('milestones');
		$checklists 	= $model->get('checklists');	
		$discussions	= $model->get('discussions');
		$documents 		= $model->get('documents');
		#$quotes 		= $model->get('quotes');
		#$invoices 		= $model->get('invoices');
		
		
		// Build the page title string
		$title = $template->id ? JText::_('Edit Template') : JText::_('New Template');			
		
		$this->assignRef('lists', 	$lists);
		$this->assignRef('title',   $title);
		$this->assignRef('template',	$template);
		$this->assignRef('editor',	$editor);
		$this->assignRef('tabs',	$tabs);
		$this->assignRef('milestones',	$milestones);
		$this->assignRef('checklists',	$checklists);
		$this->assignRef('discussions',	$discussions);
		$this->assignRef('documents',	$documents);
		#$this->assignRef('tickets',	$tickets);
		#$this->assignRef('quotes',	$quotes);
		#$this->assignRef('invoices',	$invoices);
		
		parent::display($tpl);			
	}		
	
}