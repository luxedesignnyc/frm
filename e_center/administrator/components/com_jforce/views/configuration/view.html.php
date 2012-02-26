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

class JforceViewConfiguration extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();
	
		switch($layout):
		
			case 'general':
				$this->_displayGeneral($tpl);
				return;
			break;
			
			case 'templates':
				$this->_displayTemplates($tpl);
				return;
			break;
			
			case 'accounting':
				$this->_displayAccounting($tpl);
				return;
			break;
			
			case 'categories':
				$this->_displayCategories($tpl);
				return;
			break;
			
			case 'access':
				$this->_displayAccess($tpl);
				return;
			break;
			
			case 'form':
				$this->_displayForm($tpl);
				return;
			break;
		
		endswitch;


        $model = &$this->getModel();
		$buttons = $model->listButtons();
		
		$this->assignRef('buttons', $buttons);

        
        parent::display($tpl);		
	}	
	
	function _displayGeneral($tpl) {
	
		jimport('joomla.html.pane');
		$tabs = JPane::getInstance('tabs');
		
		$document	=& JFactory::getDocument();
		
		$js = "window.addEvent('domready', function() {
			
			$('addTaxValue').addEvent('click', function() {
				createValueField('tax');										 
			});
			
			$('addSupportValue').addEvent('click', function() {
				createValueField('supportcategories');										 
			});

			$('addDiscussionValue').addEvent('click', function() {
				createValueField('discussioncategories');										 
			});
			
			$('addCampaignValue').addEvent('click', function() {
				createValueField('campaigncategories');										 
			});
			
			$('addEventTypeValue').addEvent('click', function() {
				createValueField('event_type');										 
			});
			
			$('addEventStatusValue').addEvent('click', function() {
				createValueField('event_status');										 
			});
			
			$('addEventPriorityValue').addEvent('click', function() {
				createValueField('event_priority');										 
			});
					
		});";
		
		$document->addScriptDeclaration($js);
	
		$model =&$this->getModel();
		
		$company = $model->getCompany();
		$lists = $model->buildGeneralLists();
		
		$tax = $model->getConfig('tax',true);
		
		$support = $model->getConfig('supportcategories', true);
		
		$discussion = $model->getConfig('generalcategories', true);
		
		$campaign = $model->getConfig('campaigncategories', true);
		
		$event = $model->getConfig('event_type', true);
		$event_priority = $model->getConfig('event_priority', true);
		$event_status = $model->getConfig('event_status', true);
		$repository_path = $model->getConfig('repository_path');
	
		$this->assignRef('support',$support);
		$this->assignRef('discussion',$discussion);
		$this->assignRef('campaign',$campaign);
		$this->assignRef('company',$company);
		$this->assignRef('lists',$lists);
		$this->assignRef('tax',$tax);
		$this->assignRef('tabs',$tabs);
		$this->assignRef('event',$event);
		$this->assignRef('event_status',$event_status);
		$this->assignRef('event_priority',$event_priority);
		$this->assignRef('repository_path',$repository_path);
		
		parent::display($tpl);
	}
	
	function _displayCategories($tpl) {
	
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();
		
		jimport('joomla.html.pane');
		$tabs = JPane::getInstance('tabs');
		
		$js = "window.addEvent('domready', function() {
			
			$('addSupportValue').addEvent('click', function() {
				createValueField('supportcategories');										 
			});

			$('addDiscussionValue').addEvent('click', function() {
				createValueField('discussioncategories');										 
			});
			
			$('addCampaignValue').addEvent('click', function() {
				createValueField('campaigncategories');										 
			});
					
		});";
		
		$document->addScriptDeclaration($js);


		$model =&$this->getModel();
		
		$support = $model->getConfig('supportcategories', true);
		
		$discussion = $model->getConfig('generalcategories', true);
		
		$campaign = $model->getConfig('campaigncategories', true);
		
		$event = $model->getConfig('event_type', true);
	
		$this->assignRef('support',$support);
		$this->assignRef('tabs',$tabs);
		$this->assignRef('discussion',$discussion);
		$this->assignRef('campaign',$campaign);
		$this->assignRef('event',$event);
		
		parent::display($tpl);
	}

function _displayTemplates($tpl) {
		// Load the JEditor object
		$editor =& JFactory::getEditor();
	
		$model =&$this->getModel();
		
		$email = $model->getEmailFields();
		
		$quotetemplate = $model->getConfig('quotetemplate');
		$invoicetemplate = $model->getConfig('invoicetemplate');
			
		$this->assignRef('quotetemplate', $quotetemplate);
		$this->assignRef('invoicetemplate', $invoicetemplate);
		$this->assignRef('email',$email);
		$this->assignRef('editor',$editor);
		
		parent::display($tpl);
	}
	
	function _displayAccounting($tpl) {
		// Load the JEditor object
		$editor =& JFactory::getEditor();
	
		$model =&$this->getModel();
		
		$currency = $model->getCurrencies();
		
		$printtemplate = $model->getConfig('printtemplate');
	
		$this->assignRef('currency', $currency);
		$this->assignRef('printtemplate', $printtemplate);
		$this->assignRef('editor',$editor);
		
		parent::display($tpl);
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();
		
		$js = "";
		
		$document->addScriptDeclaration($js);
			
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		
        $customfield = &$model->getCustomfield();
		$lists = $model->buildLists();
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('customfield',	$customfield);
		$this->assignRef('lists',	$lists);	
		
		parent::display($tpl);			
	}
	
}