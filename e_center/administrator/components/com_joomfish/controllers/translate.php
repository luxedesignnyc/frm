<?php
/**
 * Joom!Fish - Multi Lingual extention and translation manager for Joomla!
 * Copyright (C) 2003-2009 Think Network GmbH, Munich
 *
 * All rights reserved.  The Joom!Fish project is a set of extentions for
 * the content management system Joomla!. It enables Joomla!
 * to manage multi lingual sites especially in all dynamic information
 * which are stored in the database.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,USA.
 *
 * The "GNU General Public License" (GPL) is available at
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * -----------------------------------------------------------------------------
 * $Id: translate.php 1251 2009-01-06 18:33:02Z apostolov $
 * @package joomfish
 * @subpackage translate
 *
*/

defined( 'JPATH_BASE' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

JLoader::import( 'helpers.controllerHelper',JOOMFISH_ADMINPATH);

/**
 * The JoomFish Tasker manages the general tasks within the Joom!Fish admin interface
 *
 */
class TranslateController extends JController   {

	/** @var string		current used task */
	var $task=null;

	/** @var string		action within the task */
	var $act=null;

	/** @var array		int or array with the choosen list id */
	var $cid=null;

	/** @var string		file code */
	var $fileCode = null;

	/**
	 * @var object	reference to the Joom!Fish manager
	 * @access private
	 */
	var $_joomfishManager=null;

	/**
	 * PHP 4 constructor for the tasker
	 *
	 * @return joomfishTasker
	 */
	function __construct( ){
		parent::__construct();
		$this->registerDefaultTask( 'showTranslate' );

		$this->act =  JRequest::getVar( 'act', '' );
		$this->task =  JRequest::getVar( 'task', '' );
		$this->cid =  JRequest::getVar( 'cid', array(0) );
		if (!is_array( $this->cid )) {
			$this->cid = array(0);
		}
		$this->fileCode =  JRequest::getVar( 'fileCode', '' );
		$this->_joomfishManager =& JoomFishManager::getInstance();

		$this->registerTask( 'overview', 'showTranslate' );
		$this->registerTask( 'edit', 'editTranslation' );
		$this->registerTask( 'apply', 'saveTranslation' );
		$this->registerTask( 'save', 'saveTranslation' );
		$this->registerTask( 'publish', 'publishTranslation' );
		// NB the method will check on task
		$this->registerTask( 'unpublish', 'publishTranslation' );
		$this->registerTask( 'remove', 'removeTranslation' );
		$this->registerTask( 'preview', 'previewTranslation' );
		
		$this->registerTask( 'orphans', 'showOrphanOverview' );
		$this->registerTask( 'orphandetail', 'showOrphanDetail' );
		$this->registerTask( 'removeorphan', 'removeOrphan' );

		// Populate data used by controller
		global $mainframe;
		$this->_catid = $mainframe->getUserStateFromRequest('selected_catid', 'catid', '');
		$this->_select_language_id = $mainframe->getUserStateFromRequest('selected_lang','select_language_id', '-1');		
		$this->_language_id =  JRequest::getVar( 'language_id', $this->_select_language_id );
		$this->_select_language_id = ($this->_select_language_id == -1 && $this->_language_id != -1) ? $this->_language_id : $this->_select_language_id;
		
		// Populate common data used by view
		// get the view
		$this->view = & $this->getView("translate");
		$model =& $this->getModel('translate');
		$this->view->setModel($model, true);

		// Assign data for view 
		$this->view->assignRef('catid'   , $this->_catid);
		$this->view->assignRef('select_language_id',  $this->_select_language_id);
		$this->view->assignRef('task', $this->task);
		$this->view->assignRef('act', $this->act);
	}

	/**
	 * presenting the translation dialog
	 *
	 */
	function showTranslate() {

		// If direct translation then close the modal window
		if (intval(JRequest::getVar("direct",0))){
			$this->modalClose();
			return;
		}
		
		JoomfishControllerHelper::_setupContentElementCache();
		if( !JoomfishControllerHelper::_testSystemBotState() ) {;
		echo "<div style='font-size:16px;font-weight:bold;color:red'>".JText::_('MAMBOT_ERROR')."</div>";
		}


		$this->showTranslationOverview( $this->_select_language_id, $this->_catid );
	}

	/** Presentation of the content's that must be translated
	 */
	// DONE
	function showTranslationOverview( $language_id, $catid) {
		$db =& JFactory::getDBO();
		global $mainframe;

		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest( "view{com_joomfish}limitstart", 'limitstart', 0 );
		$search = $mainframe->getUserStateFromRequest( "search{com_joomfish}", 'search', '' );
		$search = $db->getEscaped( trim( strtolower( $search ) ) );

		// Build up the rows for the table
		$rows=null;
		$total=0;
		$filterHTML=array();
		if( $language_id != -1 && isset($catid) && $catid!="" ) {
			$contentElement = $this->_joomfishManager->getContentElement( $catid );
			if (!$contentElement){
				$catid = "content";
				$contentElement = $this->_joomfishManager->getContentElement( $catid );
			}
			JLoader::import( 'models.TranslationFilter',JOOMFISH_ADMINPATH);
			$tranFilters = getTranslationFilters($catid,$contentElement);

			$total = $contentElement->countReferences($language_id, $tranFilters);
			
			if ($total<$limitstart){
				$limitstart = 0;
			}
			
			$db->setQuery( $contentElement->createContentSQL( $language_id, null, $limitstart, $limit,$tranFilters ) );
			$rows = $db->loadObjectList();
			if ($db->getErrorNum()) {
				echo $db->stderr();
				// should not stop the page here otherwise there is no way for the user to recover
				$rows = array();
			}

			// Manipulation of result based on further information
			for( $i=0; $i<count($rows); $i++ ) {
				JLoader::import( 'models.ContentObject',JOOMFISH_ADMINPATH);
				$contentObject = new ContentObject( $language_id, $contentElement );
				$contentObject->readFromRow( $rows[$i] );
				$rows[$i] = $contentObject;
			}

			foreach ($tranFilters as $tranFilter){
				$afilterHTML=$tranFilter->_createFilterHTML();
				if (isset($afilterHTML)) $filterHTML[$tranFilter->filterType] = $afilterHTML;
			}

		}

		// Create the pagination object
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);

		// get list of active languages
		$langOptions[] = JHTML::_('select.option',  '-1', JText::_('Select Language') );
		//$langOptions[] = JHTML::_('select.option',  'NULL', JText::_('Select no Translation'));

		$langActive = $this->_joomfishManager->getLanguages( false );		// all languages even non active once

		if ( count($langActive)>0 ) {
			foreach( $langActive as $language )
			{
				$langOptions[] = JHTML::_('select.option',  $language->id, $language->name );
			}
		}
		$langlist = JHTML::_('select.genericlist', $langOptions, 'select_language_id', 'class="inputbox" size="1" onchange="if(document.getElementById(\'catid\').value.length>0) document.adminForm.submit();"', 'value', 'text', $language_id );

		// get list of element names
		$elementNames[] = JHTML::_('select.option',  '', JText::_('Please select') );
		//$elementNames[] = JHTML::_('select.option',  '-1', '- All Content elements' );
		// force reload to make sure we get them all
		$elements = $this->_joomfishManager->getContentElements(true);
		foreach( $elements as $key => $element )
		{
			$elementNames[] = JHTML::_('select.option',  $key, $element->Name );
		}
		$clist = JHTML::_('select.genericlist', $elementNames, 'catid', 'class="inputbox" size="1" onchange="if(document.getElementById(\'select_language_id\').value>=0) document.adminForm.submit();"', 'value', 'text', $catid );

		// get the view
		$this->view = & $this->getView("translate","html");

		// Set the layout
		$this->view->setLayout('default');

		// Assign data for view - should really do this as I go along
		$this->view->assignRef('rows'   , $rows);
		$this->view->assignRef('search'   , $search);
		$this->view->assignRef('pageNav'   , $pageNav);
		$this->view->assignRef('langlist'   , $langlist);
		$this->view->assignRef('clist'   , $clist);
		$this->view->assignRef('language_id', $language_id);
		$this->view->assignRef('filterlist', $filterHTML);
		
		$this->view->display();
		//TranslateViewTranslate::showTranslationOverview( $rows, $search, $pageNav, $langlist, $clist, $catid ,$language_id,$filterHTML );
	}

	/** Details of one content for translation
	 */
	// DONE
	function editTranslation(  ) {
		$cid =  JRequest::getVar( 'cid', array(0) );
		$translation_id = 0;
		if( strpos($cid[0], '|') >= 0 ) {
			list($translation_id, $contentid, $language_id) = explode('|', $cid[0]);
			$select_language_id = ($this->_select_language_id == -1 && $language_id != -1) ? $language_id : $this->_select_language_id;
		}
		$catid=$this->_catid;

		global  $mainframe;
		$user =& JFactory::getUser();
		$db =& JFactory::getDBO();

		$actContentObject=null;


		if( isset($catid) && $catid!="" ) {
			$contentElement = $this->_joomfishManager->getContentElement( $catid );
			JLoader::import( 'models.ContentObject',JOOMFISH_ADMINPATH);
			$actContentObject = new ContentObject( $language_id, $contentElement );
			$actContentObject->loadFromContentID( $contentid );
		}

		// fail if checked out not by 'me'
		if ($actContentObject->checked_out && $actContentObject->checked_out <> $user->id) {
			global $mainframe;
			$mainframe->redirect( "index2.php?option=option=com_joomfish&task=translate",
			"The content item $actContentObject->title is currently being edited by another administrator" );
		}

		// get list of active languages
		$langOptions[] = JHTML::_('select.option',  'NULL', JText::_('Select no translation') );

		$langActive = $this->_joomfishManager->getActiveLanguages();

		if ( count($langActive)>0 ) {
			foreach( $langActive as $language )
			{
				$langOptions[] = JHTML::_('select.option',  $language->id, $language->name );
			}
		}
		$confirm="";
		if ($actContentObject->language_id!=0){
			$confirm="onchange=\"confirmChangeLanguage('".$actContentObject->language."','".$actContentObject->language_id."')\"";
		}

		$langlist = JHTML::_('select.genericlist', $langOptions, 'language_id', 'class="inputbox" size="1" '.$confirm, 'value', 'text', $actContentObject->language_id );

		// get existing filters so I can remember them!
		JLoader::import( 'models.TranslationFilter',JOOMFISH_ADMINPATH);
		$tranFilters = getTranslationFilters($catid,$contentElement);
		
		// get the view
		$this->view = & $this->getView("translate");

		// Set the layout
		$this->view->setLayout('edit');

		// Assign data for view - should really do this as I go along
		$this->view->assignRef('actContentObject'   , $actContentObject);
		$this->view->assignRef('langlist'   , $langlist);
		$this->view->assignRef('tranFilters'   , $tranFilters);
		$filterlist= array();
		$this->view->assignRef('filterlist',$filterlist);

		$this->view->display();
		//HTML_joomfish::showTranslation( $actContentObject, $langlist, $catid, $select_language_id , $tranFilters );

	}

	/** Saves the information of one translation
	 */
	// DONE
	function saveTranslation( ) {
		$catid=$this->_catid;
		$select_language_id = $this->_select_language_id;
		$language_id =  $this->_language_id;
		
		$id =  JRequest::getVar( 'reference_id', null );
		$jfc_id  =  JRequest::getVar( 'jfc_id ', null );

		$actContentObject=null;
		if( isset($catid) && $catid!="" ) {
			$contentElement = $this->_joomfishManager->getContentElement( $catid );
			JLoader::import( 'models.ContentObject',JOOMFISH_ADMINPATH);
			$actContentObject = new ContentObject( $language_id, $contentElement );

			// get's the config settings on how to store original files
			$storeOriginalText = ($this->_joomfishManager->getCfg('storageOfOriginal') == 'md5') ? false : true;
			$actContentObject->bind( $_POST, '', '', true,  $storeOriginalText);
			$actContentObject->store();
			$this->view->message = JText::_('Translation saved');

			// Clear Translation Cache
			$db =& JFactory::getDBO();
			$lang = new TableJFLanguage($db);
			$lang->load( $language_id );
			$cache = & $this->_joomfishManager->getCache($lang->code);
			$cache->clean();
		}
		else {
			$this->view->message = JText::_('Cannot save - invalid catid');
		}

		if ($this->task=="translate.apply"){
			$cid =  $actContentObject->id."|".$id."|".$language_id;
			JRequest::setVar( 'cid', array($cid) );		
			$this->editTranslation();
		}
		else {
			// redirect to overview
			$this->showTranslate();
		}
	}

	/**
	 * method to remove a translation
	 */
	// DONE
	function removeTranslation() {
		$this->cid =  JRequest::getVar( 'cid', array(0) );
		if (!is_array( $this->cid )) {
			$this->cid = array(0);
		}

		
		$model =& $this->view->getModel();
		$model->_removeTranslation( $this->_catid, $this->cid );
		// redirect to overview
		$this->showTranslate();
	}

	/**
	 * Reload all translations and publish/unpublish them
	 */
	// DONE
	function publishTranslation(  ) {
		$catid = $this->_catid;
		$publish = $this->_task=="publish" ? 1 : 0;
		$cid =  JRequest::getVar( 'cid', array(0) );
		$model =& $this->view->getModel();
		if( strpos($cid[0], '|') >= 0 ) {
			list($translation_id, $contentid, $language_id) = explode('|', $cid[0]);
		}
		foreach( $cid as $cid_row ) {
			list($translation_id, $contentid, $language_id) = explode('|', $cid_row);

			$contentElement = $this->_joomfishManager->getContentElement( $catid );
			JLoader::import( 'models.ContentObject',JOOMFISH_ADMINPATH);
			$actContentObject = new ContentObject( $language_id, $contentElement );
			$actContentObject->loadFromContentID( $contentid );
			if( $actContentObject->state>=0 ) {
				$actContentObject->setPublished($publish);
				$actContentObject->store();
				$model->setState('message', $publish ? JText::_('Translation published') : JText::_('Translation unpublished') );
			}
		}

		// redirect to overview
		$this->showTranslate();
	}
	
	/**
	 * Previews content translation
	 *
	 */
	function previewTranslation(){
		// get the view
		$this->view = & $this->getView("translate");

		// Set the layout
		$this->view->setLayout('preview');

		// Assign data for view - should really do this as I go along
		//$this->view->assignRef('rows'   , $rows);
		$this->view->display();
		
	}
	
	/**
	 * show original value in an IFrame - for form safety
	 *
	 */
	function originalValue(){		
		$cid =  trim(JRequest::getVar( 'cid', "" ));		
		$language_id =  JRequest::getInt( 'lang', 0 );
		if ($cid=="" ){
			echo JText::_("Invalid paramaters");
			return;
		}
		$translation_id = 0;
		$contentid = intval($cid);
		$catid=$this->_catid;

		global  $mainframe;
		$user =& JFactory::getUser();
		$db =& JFactory::getDBO();

		$actContentObject=null;

		if( isset($catid) && $catid!="" ) {
			$contentElement = $this->_joomfishManager->getContentElement( $catid );
			JLoader::import( 'models.ContentObject',JOOMFISH_ADMINPATH);
			$actContentObject = new ContentObject( $language_id, $contentElement );
			$actContentObject->loadFromContentID( $contentid );
		}

		$fieldname = JRequest::getString('field','');
				
		// get the view
		$this->view = & $this->getView('translate');

		// Set the layout
		$this->view->setLayout('originalvalue');

		// Assign data for view - should really do this as I go along
		$this->view->assignRef('actContentObject'   , $actContentObject);
		$this->view->assignRef('field'   , $fieldname);
		$this->view->display();

	}
	
	/** Presentation of translations that have been orphaned
	 */
	function showOrphanOverview( ) {
		$language_id = $this->_language_id;
		$catid = $this->_catid;
		 
		global  $mainframe;
		$db =& JFactory::getDBO();


		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest( "view{com_joomfish}limitstart", 'limitstart', 0 );
		$search = $mainframe->getUserStateFromRequest( "search{com_joomfish}", 'search', '' );
		$search = $db->getEscaped( trim( strtolower( $search ) ) );

		$tranFilters=array();
		$filterHTML=array();

		// Build up the rows for the table
		$rows=null;
		$total=0;
		if( isset($catid) && $catid!="" ) {
			$contentElement = $this->_joomfishManager->getContentElement( $catid );

			$db->setQuery( $contentElement->createOrphanSQL( $language_id, null, $limitstart, $limit,$tranFilters ) );
			$rows = $db->loadObjectList();
			if ($db->getErrorNum()) {
				echo $db->stderr();
				return false;
			}

			$total = count($rows);

			for( $i=0; $i<count($rows); $i++ ) {
				//$contentObject = new ContentObject( $language_id, $contentElement );
				//$contentObject->readFromRow( $row );
				//$rows[$i] = $contentObject ;
				$rows[$i]->state=null;
				$rows[$i]->title = $rows[$i]->original_text;
				if (is_null($rows[$i]->title)){
					$rows[$i]->title=JText::_("original missing");
				}
				$rows[$i]->checked_out=false;
			}
		}

		require_once( JPATH_SITE . "/administrator/includes/pageNavigation.php");
		$pageNav = new mosPageNav( $total, $limitstart, $limit );

		// get list of active languages
		$langlist = "";

		$langOptions[] = JHTML::_('select.option',  '-1', JText::_('Select language') );
		//$langOptions[] = JHTML::_('select.option',  '-2', JText::_('SELECT_NOTRANSLATION') );

		$langActive = $this->_joomfishManager->getLanguages( false );		// all languages even non active once

		if ( count($langActive)>0 ) {
			foreach( $langActive as $language )
			{
				$langOptions[] = JHTML::_('select.option',  $language->id, $language->name );
			}
		}
		$langlist = JHTML::_('select.genericlist', $langOptions, 'select_language_id', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $language_id );

		// get list of element names
		$elementNames[] = JHTML::_('select.option',  '', JText::_('PLEASE SELECT') );
		//$elementNames[] = JHTML::_('select.option',  '-1', '- All Content elements' );
		$elements = $this->_joomfishManager->getContentElements(true);
		foreach( $elements as $key => $element )
		{
			$elementNames[] = JHTML::_('select.option',  $key, $element->Name );
		}
		$clist = JHTML::_('select.genericlist', $elementNames, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $catid );
		
		// get the view
		$this->view = & $this->getView("translate");

		// Set the layout
		$this->view->setLayout('orphans');

		// Assign data for view - should really do this as I go along
		$this->view->assignRef('rows'   , $rows);
		$this->view->assignRef('search'   , $search);
		$this->view->assignRef('pageNav'   , $pageNav);
		$this->view->assignRef('langlist'   , $langlist);
		$this->view->assignRef('clist'   , $clist);
		$this->view->assignRef('language_id', $language_id);
		$this->view->assignRef('filterlist', $filterHTML);
		$this->view->display();
		//HTML_joomfish::showOrphanOverview( $rows, $search, $pageNav, $langlist, $clist, $catid ,$language_id,$filterHTML );
	}

	/**
	 * method to show orphan translation details
	 *
	 * @param unknown_type $jfc_id
	 * @param unknown_type $contentid
	 * @param unknown_type $tablename
	 * @param unknown_type $lang
	 */
	function showOrphanDetail(  ){
		$jfc_id  =  JRequest::getVar( 'jfc_id ', null );
		$cid =  JRequest::getVar( 'cid', array(0) );
		if( strpos($cid[0], '|') >= 0 ) {
			list($translation_id, $contentid, $language_id) = explode('|', $cid[0]);
		}
		$contentElement = $this->_joomfishManager->getContentElement( $this->_catid );
		$tablename = $contentElement->getTableName();

		$db =& JFactory::getDBO();

		// read details of orphan translation
		//$sql = "SELECT * FROM #__jf_content WHERE id=$mbfc_id AND reference_id=$contentid AND reference_table='".$tablename."'";
		$sql = "SELECT * FROM #__jf_content WHERE reference_id=$contentid AND language_id='".$language_id."' AND reference_table='".$tablename."'";	
		$db->setQuery($sql);
		$rows = null;
		$rows=$db->loadObjectList();

		// get the view
		$this->view = & $this->getView("translate");

		// Set the layout
		$this->view->setLayout('orphandetail');
		// Assign data for view - should really do this as I go along
		$this->view->assignRef('rows'   , $rows);
		$this->view->assignRef('tablename'   , $tablename);
		$this->view->display();
		//HTML_joomfish::showOrphan($rows, $tablename);
	}

	/**
	 * method to remove orphan translation
	 */
	function removeOrphan() {
		$this->cid =  JRequest::getVar( 'cid', array(0) );
		if (!is_array( $this->cid )) {
			$this->cid = array(0);
		}

		$this->_removeTranslation( $this->_catid, $this->cid );

		$this->view->message = JText::_('Orphan Translation(s) deleted');
		// redirect to overview
		$this->showOrphanOverview();
	}

	function modalClose(){

		@ob_end_clean();
		?>
		<script language="javascript" type="text/javascript">
			window.parent.SqueezeBox.close();
			<?php
				if ($this->task=="translate.save"){
					echo "alert('".JText::_('Translation saved')."');";				
				}
			?>
		</script>
		<?php
		exit();
		
	}
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             