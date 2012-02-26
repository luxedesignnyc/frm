<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			configuration.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class JforceControllerConfiguration extends JController { 

	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'configuration'; 
		
			JRequest::setVar('view', $default );
		}
		
		parent::display();	
	}
	
	function save() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post = JRequest::get('post');
		
		if (isset($post['action']) && $post['action'] == 'role') :
			$this->saveRole($post);
			return;
		endif;
		
		if($post['model']):
			$model =& $this->getModel($post['model']);	
		else:
			$model =& $this->getModel('configuration');
		endif;
		
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
	
	function projectRoles() {
		JRequest::setVar('view', 'role');
		JRequest::setVar('type', 'project');
		parent::display();
	}
	
	function systemRoles() {
		JRequest::setVar('view', 'role');
		JRequest::setVar('type', 'system');
		parent::display();
	}
	
	function saveRole($post) {
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
		$modelName = $post['type'] == 'system' ? 'systemrole' : 'projectrole';
		$model = $this->getModel($modelName);
		$bind = $post['pr'];
		$bind['id'] = $post['id'];
		$bind['name'] = $post['name'];
		
		$model->save($bind);
		
		$type = $post['type'] == 'projectrole' ? 'project' : 'system';
		$url = JRoute::_('index.php?option=com_jforce&view=role&type='.$type);
		$msg = JText::_('Role Successfully Saved');
		$this->setRedirect($url, $msg);
		
	}
	
	function installPlugin() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
		
		$post = JRequest::get('post');
		$files = JRequest::get('files');
		
		$plugin = &JModel::getInstance('Plugin', 'JForceModel');
		$plugin->upload($files, $post);
		
		$return = $_SERVER['HTTP_REFERER'];
		$this->setRedirect($return);
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
	
	function buildVariableList() {
		$type = JRequest::getVar('type');
		$model =& JModel::getInstance(ucwords($type),'JForceModel');

		for($i=0;$i<count($model->_emailvars);$i++):
			$variable = $model->_emailvars[$i];
			echo $variable;
			echo "<br />";
		endfor;
	}

	function buildTriggers() {	
		$model =& JModel::getInstance('template','JForceModel');
		$cat = JRequest::getVar('cat');	
		$triggers = $model->buildTriggers($cat);
		echo $triggers;
	}
	
	function exportTables() {
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		$config = new JConfig();

		$db = &JFactory::getDBO();
		$tablePath = JPATH_COMPONENT_ADMINISTRATOR.DS.'tables';
		$files = JFolder::files($tablePath);
		
		$jfTables = array();
		for ($i=0; $i<count($files); $i++) :
			$f = $files[$i];
			$name = JFile::stripExt($f);
			$table = JTable::getInstance($name, 'JTable');
			if ($table) {
				$jfTables[] = $table->_tbl;
			}
		endfor;
		
		$output = $this->generateBackupSQL($jfTables);
		ob_start();
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="backup.sql"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . strlen($output));
		ob_clean();
		flush();
		echo $output;
		exit();
		
	}
	
	function generateBackupSQL($tables) {
		$db = &JFactory::getDBO();
		$tableFields = $db->getTableFields($tables);
		$output = null;
		foreach($tableFields as $table => $fields) :
			$rows = $this->getAllData($table);
			if (count($rows)) :
				$last = count($rows)-1;
				$field_names = array_keys($fields);
				$field_names = "(`".implode("`, `",$field_names)."`)";
				$begin_insert = "INSERT INTO $table $field_names VALUES\r\n";
				$output .= $begin_insert;
				for ($i=0; $i<count($rows); $i++) :
					$row = $rows[$i];
					
					$data = "('".implode("', '",$row)."')";
					$output .= $data;
					if (($i%50 == 0 && $i>0) || $i == $last) :
						$output .= ";\r\n";
						if ($i != $last) :
							$output .= $begin_insert;
						endif;
					else :
						$output .= ",\r\n";
					endif;
				endfor;
				$output .= "\r\n\r\n";
			endif;		
		endforeach;
		return $output;
	}

	function getAllData($table) {
		$db = &JFactory::getDBO();
		$query = "SELECT * FROM $table";
		$db->setQuery($query);
		return $db->loadRowList();
	}

	function importSQL() {
		$db = &JFactory::getDBO();
		jimport('joomla.filesystem.file');
		$contents = JFile::read($file);
		$db->setQuery($contents);
		#if (!($db->queryBatch())) :
		#	echo $db->stderr();
		#endif;
		print_r($db);
	}

}
