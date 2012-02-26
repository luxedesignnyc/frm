<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			style.helper.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
class JforceStyleHelper {
	
	function getStyle() {
		global $mainframe;
		jimport('joomla.filesystem.file');
		
		$doc =& JFactory::getDocument();
		$doc->addStyleSheet(JURI::root().'components/com_jforce/css/style.css');
		
		$template = $mainframe->getTemplate();
		
		$templatePath 	= JPATH_SITE.DS.'templates'.DS.$template;
		$templateURL	= JURI::root().'templates/'.$template;
		
		$customStylePath	= $templatePath.DS.'html'.DS.'com_jforce'.DS.'css'.DS.'style.css';
		$customStyle 		= $templateURL.'/html/com_jforce/css/style.css';
		
		if(JFile::exists($customStylePath)) {
			$doc->addStyleSheet($customStyle);
		}

		//hbd
		$customPrintStylePath	= $templatePath.DS.'html'.DS.'com_jforce'.DS.'css'.DS.'print.css';
		$customPrintStyle 		= $templateURL.'/html/com_jforce/css/print.css';
		
		if(JFile::exists($customPrintStylePath)) {
			$doc->addStyleSheet($customPrintStyle,'text/css','print');
		}		
		
		## ATTEMPT TO LOAD TEMPLATE STYLESHEET IF COMPONENT.PHP IS NOT FOUND ##
		$tmpl = JRequest::getVar('tmpl');
		if ($tmpl == 'component') :
			$componentPath 			= $templatePath.DS.'component.php';
			$templateStylePath 		= $templatePath.DS.'css'.DS.'template.css';
			$templateStyleURL		= $templateURL.'/css/template.css';
			if (!JFile::exists($componentPath) && JFile::exists($templateStylePath)) :
				$doc->addStyleSheet($templateStyleURL);
			endif;
		endif;
		
	}
}