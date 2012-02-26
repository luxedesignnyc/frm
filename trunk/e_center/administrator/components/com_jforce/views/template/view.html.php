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

class JforceViewTemplate extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		// Add front-side Models
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');

        $model = JModel::getInstance('Template','JForceModel');

		if ($layout == 'template') {
			$this->_displayTemplate($tpl, $model);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl, $model);
			return;
		}
		
		$templates = $model->listTemplates();
		
		$this->assignRef('templates', $templates);

        
        parent::display($tpl);		
	}	
		
	
	function _displayTemplate($tpl, $model) {
        global $mainframe, $option;

        $template = &$model->getTemplate();
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Templates'), 'index.php?option=com_jforce&view=template');	
		$pathway->addItem(JText::_('Template'));	

        $this->assignRef('template', $template);
        $this->assignRef('option', $option);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl, $model) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
		
		$js = "window.addEvent('domready',function() {
					$('cat').addEvent('change',function() {
						listVariables($('cat').value);
						buildTriggers();
					});
				
				})";
		
		$document->addScriptDeclaration($js);
		
		// Load the JEditor object
		$editor =& JFactory::getEditor();
		
		$checked = JRequest::getVar('boxchecked',0);

		if($checked):
			$cid = JRequest::getVar('cid', 0);
			$id = $cid[0];
			$model->setVar('id',$id);
		endif;
		
		$template = &$model->getTemplate();
		
		//hbd
		if(!empty($template->id)) {
			$js = "window.addEvent('domeready',function() {
					listVariables($('cat').value);
					});";
			$document->addScriptDeclaration($js);
		}
		
		$lists = &$model->buildLists();
		
		$categories = &$model->buildCategories($template->category);
				
		// Build the page title string
		$title = $template->id ? JText::_('Edit Template') : JText::_('New Template');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('lists',$lists);
		$this->assignRef('categories',$categories);
		$this->assignRef('template',	$template);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		
		parent::display($tpl);			
	}		
	
}