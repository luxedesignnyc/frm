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
        global $mainframe;
        
		$document = &JFactory::getDocument();
		$js = "
		
		window.addEvent('domready', function() {
			$('pid').addEvent('change', function() {
				getProjectWeights(this.value);
			});
		});
		
		function submitbutton(button) {
			if (button == 'save') {
				//if (validateWeighting()) {
					submitform(button);	
				//} else {
				//	return false;
				//}
			} else {
				submitform(button);	
			}
		}";
		$document->addScriptDeclaration($js);

		jimport('joomla.html.pane');
		$tabs = JPane::getInstance('tabs');
		
		// Add front-side Models
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
		
		$model = &JModel::getInstance('Weight', 'JForceModel');
		
		$lists = $model->buildLists();
		
		$this->assignRef('tabs', $tabs);
		$this->assignRef('lists', $lists);
       
        parent::display($tpl);		
	}	
	
		
}