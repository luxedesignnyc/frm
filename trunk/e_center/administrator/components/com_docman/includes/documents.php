<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: documents.php 765 2009-01-05 20:55:57Z mathias $
 * @package DOCman_1.4
 * @copyright (C) 2003-2009 Joomlatools
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

include_once dirname(__FILE__) . '/documents.html.php';

require_once ($_DOCMAN->getPath('classes' , 'file'));
require_once($_DOCMAN->getPath('classes', 'mambots'));
include_once($_DOCMAN->getPath('classes', 'params'));
JHTML::script('action_javascripts.js', 'administrator/components/com_docman/includes/js/');
JHTML::script('ajax.js', 'includes/js/libraries/');
JHTML::script('select.js', 'includes/js/libraries/');
JHTML::script('table.js', 'includes/js/libraries/');
JHTML::script('checkbox.js', 'includes/js/libraries/');

mosArrayToInts( $cid );

switch ($task) {
    case "publish" :
        publishDocument($cid, 1);
        break;
    case "unpublish":
        publishDocument($cid, 0);
        break;
    case "approve":
        approveDocument($cid, 1);
        publishDocument($cid, 1);
        break;
    case "unapprove":
        approveDocument($cid, 0);
        publishDocument($cid, 0);
        break;
    case "new":
        editDocument(-1);
        break;
    case "edit":
        editDocument($cid[0]);
        break;

	//BEGIN: TUYEN created functions here
	case "editAfterUpload":
        editDocumentAfterUpload();
        break;
		
	case "approveFiles":
        approveFiles();
        break;
	
	case "getUsers":
        getUsers();
        break;
		
	case "saveDistributedDocument":
        saveDistributedDocument();
        break;		
		
	//END: TUYEN created functions here
	
    case "move_form":
        moveDocumentForm($cid);
        break;
    case "move_process":
        moveDocumentProcess($cid);
        break;
    case "copy_form":
        copyDocumentForm($cid);
        break;
    case "copy_process":
        copyDocumentProcess($cid);
        break;
    case "remove":
        removeDocument($cid);
        break;
    case "apply":
    case "save":
        saveDocument();
        break;
    case "cancel":
        cancelDocument();
        break;
    case "download" :
        $bid = mosGetParam($_REQUEST, 'bid', 0);
        downloadDocument($bid);
        break;
    case "show":
    default :
        showDocuments($pend, $sort, 0);
}

//BEGIN: TUYEN wrote this function with using AJAX
function getUsers() {//user AJAX
	global $mainframe, $database;
	$strUserIds = JRequest::getVar( 'userIds', array(0), 'get', 'string' );
	
	//BEGIN: TUYEN get DB from 'jos_users' table
	$query = " SELECT id,name,username, email, block".
             " FROM #__users".
             " WHERE id IN (" . $strUserIds . ")".
             " ORDER BY block ASC, name ASC";
	$database->setQuery ($query);
	$userList = $database->loadObjectList();
	echo "<select name='user' id='idUser'><option value=''>&nbsp;</option>";
	if (!empty($userList)) {		
		foreach ($userList as $row) {
			echo "<option title='". $row->name ."' value='". $row->id . "'>". $row->name . " - " . $row->email . "</option>";

		}//End Foreach		
	}//End If
	echo "</select>";	
	//BEGIN: TUYEN get DB from 'jos_users' table
	
	echo $return.'&nbsp;';//prevent blank case
	$mainframe->close();
}

function saveDistributedDocument () {
	global $mainframe, $database;
	
	$user = JFactory::getUser();
	
	$strVersionId = JRequest::getVar( 'versionId', array(0), 'get', 'string' );
	$strRequest = JRequest::getVar( 'request', array(0), 'get', 'string' );	
	$strSubject = JRequest::getVar( 'subject', array(0), 'get', 'string' );	
	$arrayUserId = explode(",", (string)JRequest::getVar( 'userIds', array(0), 'get', 'string' ));
	try {
		for ($i=0; $i< count ($arrayUserId); $i++) {
			$query = " INSERT INTO #__messages (user_id_from, user_id_to, folder_id, date_time, state, priority, subject, message, file_id)" .
					 " VALUES ('". $user->get('id')."','".$arrayUserId[$i]."','0', NOW(),'0','0','".$strSubject."','".$strRequest."','".$strVersionId."')";
			$database->setQuery( $query );
			$database->query();
		}
	} catch (Exception $e) {
			echo $return.'&nbsp;'.$e->getMessage();//prevent blank case
			$mainframe->close();
	}
		
	echo $return.'&nbsp;'. JText::_("SUCCESSFULLY SENT");//prevent blank case
	$mainframe->close();
}
//END: TUYEN wrote this function with using AJAX

function showDocuments($pend, $sort, $view_type)
{
    global $_DOCMAN;
    require_once($_DOCMAN->getPath('classes', 'utils'));

    global $database, $mainframe, $option, $section;
    global $mosConfig_list_limit, $section, $menutype;

    $catid = $mainframe->getUserStateFromRequest("catidarc{option}{$section}", 'catid', 0);
    $cqbhid = $mainframe->getUserStateFromRequest("catidarc{option}{$section}", 'cqbhid', 0);
    $lvbid = $mainframe->getUserStateFromRequest("catidarc{option}{$section}", 'lvbid', 0);
    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$option}{$section}limitstart", 'limitstart', 0);
    $levellimit = $mainframe->getUserStateFromRequest("view{$option}{$section}limit", 'levellimit', 10);

    $search = $mainframe->getUserStateFromRequest("searcharc{$option}{$section}", 'search', '');
	
    $search = $database->getEscaped(trim(strtolower($search)));

    $where = array();

    if ($catid > 0) {
        $where[] = "a.catid=$catid";
    }
    if ($cqbhid > 0) {
        $where[] = "a.cqbhid=$cqbhid";
    }
    if ($lvbid > 0) {
        $where[] = "a.lvbid=$catid";
    }
    if ($search) {
        $where[] = "LOWER(a.dmname) LIKE '%$search%'";
    }
    if ($pend == 'yes') {
        $where[] = "a.approved LIKE '0'";
    }
    // get the total number of records
    $query = "SELECT count(*) "
     . "\n FROM #__docman AS a"
     . (count($where) ? "\n WHERE " . implode(' AND ', $where) : "");
    $database->setQuery($query);
    $total = $database->loadResult();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    // $where[] = "a.catid=cc.id";
    if ($sort == 'filename') {
        $sorttemp = "a.dmfilename";
    } else if ($sort == 'name') {
        $sorttemp = "a.dmname";
    } else if ($sort == 'date') {
        $sorttemp = "a.dmdate_published";
    } else {
        $sorttemp = "a.catid,a.dmname";
    }

    $query = "SELECT a.*, cc.name AS category, u.name AS editor"
     . "\n FROM #__docman AS a"
     . "\n LEFT JOIN #__users AS u ON u.id = a.checked_out"
     . "\n LEFT JOIN #__docman_cqbh AS cc ON cc.id = a.cqbhid"
     . (count($where) ? "\n WHERE " . implode(' AND ', $where) : "")
     . "\n ORDER BY " . $sorttemp . " ASC" ;
    //echo $query;
    $database->setQuery($query);
    $rows = $database->loadObjectList();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }

    require_once($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    // slice out elements based on limits
    $rows = array_slice($rows, $pageNav->limitstart, $pageNav->limit);
    // add category name
    $list = DOCMAN_utils::CQBHcategoryArray();
    for ($i = 0, $n = count($rows);$i < $n;$i++) {
        $row = &$rows[$i];
        $row->treename = array_key_exists($row->catid , $list) ?
        $list[$row->catid]->treename : '(orphan)';
    }
    // get list of categories
    $options = array();
    $options[] = dmHTML::makeOption('0', _DML_SELECT_CAT);
    $options[] = dmHTML::makeOption('-1', _DML_ALL_CATS);
    $lists['catid'] = dmHTML::categoryList($catid, "document.adminForm.submit();", $options);
    $lists['cqbhid'] = dmHTML::CQBHcategoryList($cqbhid, "document.adminForm.submit();", $options);
    $lists['lvbid'] = dmHTML::LVBcategoryList($lvbid, "document.adminForm.submit();", $options);
    // get unpublished documents
    $database->setQuery("SELECT count(*) FROM #__docman WHERE approved=0");
    $number_pending = $database->loadResult();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    // get pending documents
    $database->setQuery("SELECT count(*) FROM #__docman WHERE published=0");
    $number_unpublished = $database->loadResult();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }

    HTML_DMDocuments::showDocuments($rows, $lists, $search, $pageNav, $number_pending, $number_unpublished, $view_type);
}

//BEGIN: TUYEN created this function
function editDocumentAfterUpload() {
	editDocument (JRequest::getVar('document_id', 0, 'get', 'string'));
}

function approveFiles() {
	global $database;
	//Approve File
	$intFileID = (int) JRequest::getVar('fileId', 0, 'get', 'string');
	$query = " SELECT track, status FROM #__docman_files WHERE id = '" . $intFileID . "'";
	$database->setQuery($query);				
	$dbItem = $database->loadObject();
	
	$user		= & JFactory::getUser();
	$strTrack = "";
	$intStatus = 0;
	
	//Get Current Date
	$current = getDate();
	$d = $current['mday'];
	$mon = $current['mon'];
	$y = $current['year'];
	$h = $current['hours'];
	$min = $current['minutes'];
	$s = $current['seconds'];
	$__today = "$d-$mon-$y $h:$min:$s";

	
	if (!empty($dbItem)) {
		$strTrack= addslashes($dbItem->track);
		if ((int)$dbItem->status == 0) {
			$intStatus = 1;
			$strTrack = addslashes("Approved by <font color = 'green'>" . $user->get ("email") . "</font> on " . $__today . "<br/>") . $strTrack ;
		} else {
			$intStatus = 0; 
			$strTrack = addslashes("Don't be approved by <font color = 'red'>" . $user->get ("email") . "</font> on " . $__today . "<br/>") . $strTrack;
		}
	}
	
		
	$query = " UPDATE #__docman_files".
			 " SET status='". $intStatus ."', track='". $strTrack ."'".
			 " WHERE id='". $intFileID . "'";
	$database->setQuery($query);
	
	if (!$database->query()) {
		echo "<script> alert('" . $database->getErrorMsg() . "'); </script>\n";
		exit();
	}
	//echo $query;
	mosRedirect ("index2.php?option=com_docman&section=documents&task=editAfterUpload&document_id=".JRequest::getVar('document_id', 0, 'get', 'string'));
	//editDocument (JRequest::getVar('document_id', 0, 'get', 'string'));
}

//END: TUYEN created this function

/*
*    @desc Edit a document entry
*	 $uid : is Id of Document //Tuyen commented here
*/
function editDocument($uid )
{
    global $mosConfig_absolute_path;

	require_once ($mosConfig_absolute_path ."/administrator/components/com_docman/classes/DOCMAN_utils.class.php");
    require_once ($mosConfig_absolute_path ."/administrator/components/com_docman/classes/DOCMAN_params.class.php");

    global $database, $my, $mosConfig_absolute_path, $mosConfig_live_site;
    global $_DOCMAN, $_DMUSER;

    // disable the main menu to force user to use buttons
    $_REQUEST['hidemainmenu']=1;

	 $uploaded_file = mosGetParam(DOCMAN_Utils::stripslashes($_REQUEST), "uploaded_file", "");

    $doc = new mosDMDocument($database);
    if ($uid) {
        $doc->load($uid);
        if ($doc->checked_out) {
            if ($doc->checked_out <> $my->id) {
                mosRedirect("index2.php?option=$option", _DML_THE_MODULE . " $row->title " . _DML_IS_BEING);
            }
        } else { // check out document...
            $doc->checkout($my->id);
        }
    } else {
        $doc->init_record();
    }

    // Begin building interface information...
    $lists = array();

    $lists['document_url']        = ''; //make sure
    $lists['original_dmfilename'] = $doc->dmfilename;
    if (strcasecmp(substr($doc->dmfilename , 0, _DM_DOCUMENT_LINK_LNG) , _DM_DOCUMENT_LINK) == 0) {
        $lists['document_url'] = substr($doc->dmfilename , _DM_DOCUMENT_LINK_LNG);
        $doc->dmfilename = _DM_DOCUMENT_LINK ;
    }

    // category select list
    $options = array(mosHTML::makeOption('0', _DML_SELECT_CAT));
    // Co quan ban hanh
   $lists['catid'] = dmHTML::categoryList($doc->catid, "loopSelected('catid', 'lvbid')", $options);
   $lists['cqbhid'] = dmHTML::CQBHcategoryList($doc->cqbhid, "", $options);
    // check if we have at least one category defined
    $database->setQuery("SELECT id " . "\n FROM #__docman_cqbh ", 0, 1);

    if (!$checkcats = $database->loadObjectList()) {
        mosRedirect("index2.php?option=com_docman&section=cqbh", _DML_PLEASE_SEL_CAT);
    }
 	// Loai van ban
    $lists['lvbid'] = dmHTML::LVBcategoryList($doc->lvbid , "", $options);
    
   // $lists['catid'] = dmHTML::categoryList($doc->catid, "", $options);
    // check if we have at least one category defined
    
	//BEGIN: TUYEN - Get infomation about files of Document.
	$__query = " SELECT * FROM #__docman_files WHERE doc_id = '" . (int) $uid . "' ORDER BY license_name DESC";
	$database->setQuery($__query);
	$__filesList = $database->loadObjectList();
	$__i = 0;
	$__filesArray = null;
	foreach($__filesList as $__item) {
		$__filesArray[$__i] = $__item;
		$__query = " SELECT email FROM #__users WHERE id = '" . (int) $__item->created_by_id . "'";
		$database->setQuery($__query);				
		$__filesArray[$__i]->creatorEmail = $database->loadObject()->email;
		$__i++;
	}	
	$lists['__files'] = $__filesArray;
	
	$lists['__doc_id'] = (int) $uid;
	//END: TUYEN - Get infomation about files of Document.
	
    // select lists
    $lists['approved'] = mosHTML::yesnoRadioList('approved', 'class="inputbox"', $doc->approved);
    $lists['published'] = mosHTML::yesnoRadioList('published', 'class="inputbox"', $doc->published);

    // licenses list
    $database->setQuery("SELECT id, name " . "\n FROM #__docman_licenses " . "\n ORDER BY name ASC");
    $licensesTemp = $database->loadObjectList();
    $licenses[] = mosHTML::makeOption('0', _DML_NO_LICENSE);

    foreach($licensesTemp as $licensesTemp) {
        $licenses[] = mosHTML::makeOption($licensesTemp->id, $licensesTemp->name);
    }

    $lists['licenses'] = mosHTML::selectList($licenses, 'dmlicense_id',
        'class="inputbox" size="1"', 'value', 'text', $doc->dmlicense_id);

    // licenses display list
    $licenses_display[] = mosHTML::makeOption('0', _DML_NO);
    $licenses_display[] = mosHTML::makeOption('1', _DML_YES);;
    $lists['licenses_display'] = mosHTML::selectList($licenses_display,
        'dmlicense_display', 'class="inputbox" size="1"', 'value', 'text', $doc->dmlicense_display);

    if ($uploaded_file == '')
    {
        // Create docs List
        $dm_path      = $_DOCMAN->getCfg('dmpath');
        $fname_reject = $_DOCMAN->getCfg('fname_reject');

        $docFiles = DOCMAN_Compat::mosReadDirectory($dm_path);

        $docs = array(mosHTML::makeOption('', _DML_SELECT_FILE));
        $docs[] = mosHTML::makeOption(_DM_DOCUMENT_LINK , _DML_LINKED);

        if ( count($docFiles) > 0 )
        {
            foreach ( $docFiles as $file )
            {

                if ( substr($file,0,1) == '.' ) continue; //ignore files starting with .
                if ( @is_dir($dm_path . '/' . $file) ) continue; //ignore directories
                if ( $fname_reject && preg_match("/^(".$fname_reject.")$/i", $file) ) continue; //ignore certain filenames
                if ( preg_match("/^("._DM_FNAME_REJECT.")$/i", $file) ) continue; //ignore certain filenames

               	//$query = "SELECT * FROM #__docman WHERE dmfilename='" . $database->getEscaped($file) . "'";
              	//$database->setQuery($query);
             	//if (!($result = $database->query())) {
                /*	echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); '</script>\n";*/
             	//}

                //if ($database->getNumRows($result) == 0 || $doc->dmfilename == $file) {
                    $docs[] = mosHTML::makeOption($file);
                //}
            } //end foreach $docsFiles
        }

        if ( count($docs) < 1 ) {
            mosRedirect("index2.php?option=$option&task=upload", _DML_YOU_MUST_UPLOAD);
        }

        $lists['dmfilename'] = mosHTML::selectList($docs, 'dmfilename',
            'class="inputbox" size="1"', 'value', 'text', $doc->dmfilename);
    } else { // uploaded_file isn't blank

    	$filename = split("\.", $uploaded_file);
     	$row->dmname = $filename[0];

        $docs = array(mosHTML::makeOption($uploaded_file));
        $lists['dmfilename'] = mosHTML::selectList($docs, 'dmfilename',
            'class="inputbox" size="1"', 'value', 'text', $doc->dmfilename);
    } // endif uploaded_file

    // permissions lists
    $lists['viewer']     = dmHTML::viewerList($doc, 'dmowner');
    $lists['maintainer'] = dmHTML::maintainerList($doc, 'dmmantainedby');

    // updater user information
    $last = array();
    if ($doc->dmlastupdateby > '0' && $doc->dmlastupdateby != $my->id) {
        $database->setQuery("SELECT id, name FROM #__users WHERE id=" . (int) $doc->dmlastupdateby);
        $last = $database->loadObjectList();
    } else $last[0]->name = $my->name ? $my->name : $my->username; // "Super Administrator"

    // creator user information
    $created = array();
    if ($doc->dmsubmitedby > '0' && $doc->dmsubmitedby != $my->id) {
        $database->setQuery("SELECT id, name FROM #__users WHERE id=". (int) $doc->dmsubmitedby);
        $created = $database->loadObjectList();
    } else $created[0]->name = $my->name ? $my->name : $my->username; // "Super Administrator"

    // Imagelist
    $lists['image'] = dmHTML::imageList('dmthumbnail', $doc->dmthumbnail);

    // Params definitions
    $params_path = $mosConfig_absolute_path . '/administrator/components/com_docman/docman.params.xml';
	if(file_exists($params_path)) {
		$params =& new dmParameters( $doc->attribs, $params_path , 'params' );
	}

	/* ------------------------------ *
     *   MAMBOT - Setup All Mambots   *
     * ------------------------------ */
    $prebot = new DOCMAN_mambot('onBeforeEditDocument');
    $prebot->setParm('document' , $doc);
    $prebot->setParm('filename' , $filename);
    $prebot->setParm('user'     , $_DMUSER);

     if (!$uid) {
        $prebot->copyParm('process' , 'new document');
    } else {
        $prebot->copyParm('process' , 'edit document');
    }

    $prebot->trigger();

    if ($prebot->getError()) {
    	mosRedirect("index2.php?option=com_docman&section=documents", $prebot->getErrorMsg());
    }
	
	//BEGIN: TUYEN get DB from 'jos_docman_groups' table
	$query = " SELECT * FROM #__docman_groups".
			 " WHERE groups_access = 1"; 
	$database->setQuery ($query);
	$lists['user_group'] = $database->loadObjectList();
	//BEGIN: TUYEN get DB from 'jos_docman_groups' table	

    HTML_DMDocuments::editDocument($doc, $lists, $last, $created, $params);
}

function removeDocument($cid)
{
    DOCMAN_token::check() or die('Invalid Token');
    global $database;

    $doc = new mosDMDocument($database);
    if ($doc->remove($cid)) {
        mosRedirect("index2.php?option=com_docman&section=documents");
    } else {
    	echo "<script> alert('Problem removing documents'); window.history.go(-1);</script>\n";
        exit();
    }
}

function cancelDocument()
{
    global $database;

    $doc = new mosDMDocument($database);
    if ($doc->cancel()) {
        mosRedirect("index2.php?option=com_docman&section=documents");
    }
}

function publishDocument($cid, $publish = 1)
{
    DOCMAN_token::check() or die('Invalid Token');
    global $database;

    $doc = new mosDMDocument($database);
    if ($doc->publish($cid, $publish)) {
        mosRedirect("index2.php?option=com_docman&section=documents");
    }
}

/*
*    @desc Approves a document
*/

function approveDocument($cid, $approved = 1)
{
    DOCMAN_token::check() or die('Invalid Token');
    global $database;

    $redirect = mosGetParam($_REQUEST, 'redirect', "index2.php?option=com_docman&section=documents" );

    $doc = new mosDMDocument($database);
    if ($doc->approve($cid, $approved)) {
        mosRedirect($redirect);
    }
}

/*
*    @desc Saves a document
*/

function saveDocument()
{
    DOCMAN_token::check() or die('Invalid Token');

    global $database, $task, $_DMUSER;


	//fetch current id
    $cid = (int) mosGetParam($_POST , 'id' , 0);

    //fetch params
    $params = mosGetParam( $_POST, 'params', '' );
	if (is_array( $params )) {
		$txt = array();
		foreach ($params as $k=>$v) {
			$txt[] = "$k=$v";
		}
		$_POST['attribs'] = implode( "\n", $txt );
	}

    $doc = new mosDMDocument($database); // Create record
    $doc->load($cid); // Load from id
    $doc->bind(DOCMAN_Utils::stripslashes($_POST) );

     /* ------------------------------ *
     *   MAMBOT - Setup All Mambots   *
     * ------------------------------ */
    $logbot = new DOCMAN_mambot('onLog');
    $postbot = new DOCMAN_mambot('onAfterEditDocument');
    $logbot->setParm('document' , $doc);
    $logbot->setParm('file'     , DOCMAN_Utils::stripslashes($_POST['dmfilename']));
    $logbot->setParm('user'     , $_DMUSER);

     if (!$cid) {
        $logbot->copyParm('process' , 'new document');
    } else {
        $logbot->copyParm('process' , 'edit document');
    }
    $logbot->copyParm('new' , !$cid);
    $postbot->setParmArray($logbot->getParm());

     $postbot->trigger();
    if ($postbot->getError()) {
      	$logbot->copyParm('msg' , $postbot->getErrorMsg());
       	$logbot->copyParm('status' , 'LOG_ERROR');
        $logbot->trigger();
        mosRedirect("index2.php?option=com_docman&section=documents", $postbot->getErrorMsg());
   	}

    if ($doc->save()) { // Update from browser
    	$logbot->copyParm('msg' , 'Document saved');
        $logbot->copyParm('status' , 'LOG_OK');
        $logbot->trigger();

        if( $task == 'save' ) {
            $url = 'index2.php?option=com_docman&section=documents';
        } else { // $task = 'apply'
            $url = 'index2.php?option=com_docman&section=documents&task=edit&cid[0]='.$doc->id;
        }

        mosRedirect( $url, _DML_SAVED_CHANGES);
    }

    $logbot->copyParm('msg' , $doc->getError());
    $logbot->copyParm('status' , 'LOG_ERROR');
    $logbot->trigger();

    mosRedirect( 'index2.php?option=com_docman&section=documents', $doc->getError());
}

function downloadDocument($bid)
{
    global $database, $_DOCMAN;
    // load document
    $doc = new mosDMDocument($database);
    $doc->load($bid);
    // download file
    $file = new DOCMAN_File($doc->dmfilename, $_DOCMAN->getCfg('dmpath'));
    $file->download();
    die; // Important!
}

function moveDocumentForm($cid)
{
    global $database;

    if (!is_array($cid) || count($cid) < 1) {
        echo "<script> alert('"._DML_SELECT_ITEM_MOVE."'); window.history.go(-1);</script>\n";
        exit;
    }
    // query to list items from documents
    $cids = implode(',', $cid);
    $query = "SELECT dmname FROM #__docman WHERE id IN ( " . $cids . " ) ORDER BY id, dmname";
    $database->setQuery($query);
    $items = $database->loadObjectList();
    // category select list
    $options = array(mosHTML::makeOption('1', _DML_SELECT_CAT));
    $lists['categories'] = dmHTML::categoryList("", "", $options);

    HTML_DMDocuments::moveDocumentForm($cid, $lists, $items);
}

function moveDocumentProcess($cid)
{
    DOCMAN_token::check() or die('Invalid Token');
    global $database, $my;
    // get the id of the category to move the document to
    $categoryMove = mosGetParam($_POST, 'catid', '');
    // preform move
    $doc = new mosDMDocument($database);
    $doc->move($cid, $categoryMove);
    // output status message
    $cids = implode(',', $cid);
    $total = count($cid);

    $cat = new mosDMCategory ($database);
    $cat->load($categoryMove);

    $msg = $total . ' '._DML_DOCUMENTS_MOVED_TO.' '. $cat->name;
    mosRedirect('index2.php?option=com_docman&section=documents',  $msg);
}

function copyDocumentForm($cid)
{
    global $database;

    if (!is_array($cid) || count($cid) < 1) {
        echo "<script> alert('"._DML_SELECT_ITEM_COPY."'); window.history.go(-1);</script>\n";
        exit;
    }
    // query to list items from documents
    $cids = implode(',', $cid);
    $query = "SELECT dmname FROM #__docman WHERE id IN ( " . $cids . " ) ORDER BY id, dmname";
    $database->setQuery($query);
    $items = $database->loadObjectList();
    // category select list
    $options = array(mosHTML::makeOption('1', _DML_SELECT_CAT));
    $lists['categories'] = dmHTML::categoryList("", "", $options);

    HTML_DMDocuments::copyDocumentForm($cid, $lists, $items);
}

function copyDocumentProcess($cid)
{
    DOCMAN_token::check() or die('Invalid Token');

    global $database, $my;
    // get the id of the category to copy the document to
    $categoryCopy = mosGetParam($_POST, 'catid', '');
    // preform move
    $doc = new mosDMDocument($database);
    $doc->copy($cid, $categoryCopy);
    // output status message
    $cids = implode(',', $cid);
    $total = count($cid);

    $cat = new mosDMCategory ($database);
    $cat->load($categoryCopy);

    $msg = $total . ' '._DML_DOCUMENTS_COPIED_TO.' '. $cat->name;
    mosRedirect('index2.php?option=com_docman&section=documents',  $msg);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        