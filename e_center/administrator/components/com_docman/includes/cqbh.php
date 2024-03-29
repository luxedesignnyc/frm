<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: categories.php 765 2009-01-05 20:55:57Z mathias $
 * @package DOCman_1.4
 * @copyright (C) 2003-2009 Joomlatools
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

include_once dirname(__FILE__) . '/cqbh.html.php';
mosArrayToInts( $cid );

switch ($task) {
    case "edit" :
    	editCQBH($option, $cid[0]);
        break;
    case "new":
         editCQBH($option, 0);
        break;
    case "cancel":
        cancelCategory();
        break;
    case "save":
    case "apply":
        saveCategory();
        break;
    case "remove":
        removeCategories($option, $cid);
        break;
    case "publish":
        publishCategories("com_docman", $id, $cid, 1);
        break;
    case "unpublish":
        publishCategories("com_docman", $id, $cid, 0);
        break;
    case "orderup":
        orderCategory($cid[0], -1);
        break;
    case "orderdown":
        orderCategory($cid[0], 1);
        break;
    case "accesspublic":
        accessCategory($cid[0], 0);
        break;
    case "accessregistered":
        accessCategory($cid[0], 1);
        break;
    case "accessspecial":
        accessCategory($cid[0], 2);
        break;
    case "show":
    default :
        show_cqbh();
}

function show_cqbh()
{
    global $database, $my, $option, $menutype, $mainframe, $mosConfig_list_limit;

    $section = "com_docman";

    $sectionid = $mainframe->getUserStateFromRequest("sectionid{$section}{$section}", 'sectionid', 0);
    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$section}limitstart", 'limitstart', 0);
    $levellimit = $mainframe->getUserStateFromRequest("view{$option}limit$menutype", 'levellimit', 10);

    $query = "SELECT  c.id, c.parent_id as parent , c.name, c.alias, c.title, c.alias, c.checked_out as checked_out_contact_category ,c.ordering, c.public, c.access,g.name as groupname  "
     . "\n FROM #__docman_cqbh c "
     . "\n LEFT JOIN #__groups AS g ON g.id = c.access"
     . "\n ORDER BY ordering" ;
    $database->setQuery($query);

    $rows = $database->loadObjectList();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    // establish the hierarchy of the categories
    $children = array();
    // first pass - collect children
    foreach ($rows as $v) {
        $pt = $v->parent;
        $list = @$children[$pt] ? $children[$pt] : array();
        array_push($list, $v);
        $children[$pt] = $list;
    }
    // second pass - get an indent list of the items
    $list = DOCMAN_Utils::mosTreeRecurse(0, '', array(), $children, max(0, $levellimit-1));
    $list = is_array($list) ? $list : array();

    $total = count($list);

    require_once($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    $levellist = mosHTML::integerSelectList(1, 20, 1, 'levellimit', 'size="1" onchange="document.adminForm.submit();"', $levellimit);
    // slice out elements based on limits
    $list = array_slice($list, $pageNav->limitstart, $pageNav->limit);

    $count = count($list);
    // number of Active Items
    for ($i = 0; $i < $count; $i++) {
        $query = "SELECT COUNT( d.id )"
         . "\n FROM #__docman AS d"
         . "\n WHERE d.catid = " . $list[$i]->id;
        // . "\n AND d.state <> '-2'";
        $database->setQuery($query);
        $active = $database->loadResult();
        $list[$i]->documents = $active;
    }
    // get list of sections for dropdown filter
    $javascript = 'onchange="document.adminForm.submit();"';
    $lists['sectionid'] = mosAdminMenus::SelectSection('sectionid', $sectionid, $javascript);

    HTML_DMCQBH::show($list, $my->id, $pageNav, $lists, 'other');
}

function editCQBH($section = '', $uid = 0)
{
    global $database, $my;
    global $mosConfig_absolute_path, $mosConfig_live_site;

    // disable the main menu to force user to use buttons
    $_REQUEST['hidemainmenu']=1;

    $type = mosGetParam($_REQUEST, 'type', '');
    $redirect = mosGetParam($_POST, 'section', '');;

    $row = new mosDMCQBH($database);
    // load the row from the db table
    $row->load($uid);
    // fail if checked out not by 'me'
    if ($row->checked_out && $row->checked_out <> $my->id) {
        mosRedirect('index2.php?option=com_docman&task=cqbh', 'The category ' . $row->title . ' is currently being edited by another administrator');
    }

    if ($uid) {
        // existing record
        $row->checkout($my->id);
        // code for Link Menu
    } else {
        // new record
        $row->section = $section;
        $row->public = 1;
    }
    // make order list
    $order = array();
    $database->setQuery("SELECT COUNT(*) FROM #__docman_cqbh  WHERE parent_id='$row->id'");
    $max = intval($database->loadResult()) + 1;

    for ($i = 1; $i < $max; $i++) {
        $order[] = mosHTML::makeOption($i);
    }
    // build the html select list for ordering
    $query = "SELECT ordering AS value, title AS text"
     . "\n FROM #__docman_cqbh"
     . "\n WHERE parent_id='$row->id'"
     . "\n ORDER BY ordering" ;
    $lists['ordering'] = mosAdminMenus::SpecificOrdering($row, $uid, $query);
    // build the select list for the image positions
    //$active = ($row->image_position ? $row->image_position : 'left');
   // $lists['image_position'] = mosAdminMenus::Positions('image_position', $active, null, 0, 0);
    // Imagelist
   // $lists['image'] = dmHTML::imageList('image', $row->image);
    // build the html select list for the group access
    $lists['access'] = mosAdminMenus::Access($row);
    // build the html radio buttons for published
    $lists['public'] = mosHTML::yesnoRadioList('public', 'class="inputbox"', $row->public);
    // build the html select list for paraent item
    $options = array();
    $options[] = mosHTML::makeOption('0', _DML_TOP);
    $lists['parent'] = dmHTML::CQBHcategoryParentList($row->id, "", $options,'');

    HTML_DMCQBH::edit($row, $section, $lists, $redirect);
}

function saveCategory()
{
    DOCMAN_token::check() or die('Invalid Token');

    global $database, $task, $my;

   //$row = new mosDMCQBH($database);
/*
    if (!$row->bind(DOCMAN_Utils::stripslashes($_POST))) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    if (!$row->check()) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    if (!$row->store()) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    $row->checkin();
    $row->updateOrder(" parent_id =". (int) $row->parent_id);
*/
    /* http://forum.joomlatools.eu/viewtopic.php?f=14&t=316
    $oldtitle =  strip_tags( mosGetParam($_POST, 'oldtitle', null) );
    if ($oldtitle) {
        if ($oldtitle != $row->title) {
            $database->setQuery("UPDATE #__categories " . "\n SET name='$row->title' " . "\n WHERE name='$oldtitle' " . "\n    AND section='com_docman'");
            $database->query();
        }
    }
    */
    $id =  strip_tags( mosGetParam($_REQUEST, 'id', null) );
	$name =  strip_tags( mosGetParam($_REQUEST, 'name', null) );
	$title =  strip_tags( mosGetParam($_REQUEST, 'title', null) );
	$parent_id =  strip_tags( mosGetParam($_REQUEST, 'parent_id', null) );
	$ordering =  strip_tags( mosGetParam($_REQUEST, 'ordering', null) );
	$access =  strip_tags( mosGetParam($_REQUEST, 'access', null) );
	$public =  strip_tags( mosGetParam($_REQUEST, 'public', null) );
	$description =  strip_tags( mosGetParam($_REQUEST, 'description', null) );
	
	if ($id <>0){
	$sql = " UPDATE #__docman_cqbh C"  
		     . "\n SET name ='$name', "
			. "\n  title ='$title', "
			. "\n parent_id  ='$parent_id', "
			. "\n ordering ='$ordering', "
			. "\n access ='$access', "
			. "\n public ='$public', "
			. "\n description ='$description' "
		    . "\n WHERE id =  $id  ";
	}else{
	$sql = " INSERT INTO #__docman_cqbh(id, parent_id, name, title, alias, public, ordering, access, checked_out, description )"  
		    	 . "\n VALUES('','$parent_id','$name','$title','','$public','$ordering','$access','','$description') ";
			
	}
			
      $database->setQuery($sql);
      $database->query();
  
    if( $task == 'save' ) {
        $url = 'index2.php?option=com_docman&section=cqbh';
    } else { // $task = 'apply'
        $url = 'index2.php?option=com_docman&section=cqbh&task=edit&cid[0]='.$id;
    }

    mosRedirect( $url, _DML_SAVED_CHANGES);

}

/**
* Deletes one or more categories from the categories table
*
* @param string $ The name of the category section
* @param array $ An array of unique category id numbers
*/
function removeCategories($section, $cid)
{
    DOCMAN_token::check() or die('Invalid Token');

    global $database;

    if (count($cid) < 1) {
        echo "<script> alert('"._DML_SELECTCATTODELETE."'); window.history.go(-1);</script>\n";
        exit;
    }

    $cids = implode(',', $cid);
    // Check to see if the category holds child documents and/or subcategories
    $query = "SELECT c.id, c.name, c.parent_id, COUNT(s.catid) AS numcat, COUNT(u.id) as numkids"
     . "\n FROM #__docman_cqbh  AS c"
     . "\n LEFT JOIN #__docman     AS s ON s.catid=c.id"
     . "\n LEFT JOIN #__docman_cqbh  AS u ON u.parent_id =c.id"
     . "\n WHERE c.id IN ($cids)"
     . "\n GROUP BY c.id" ;
    $database->setQuery($query);

    if (!($rows = $database->loadObjectList())) {
        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
    }

    $err = array();
    $cid = array();

    foreach ($rows as $row) {
        if ($row->numcat == 0 && $row->numkids == 0) {
            $cid[] = $row->id;
        } else {
            $err[] = $row->name;
        }
    }

    if (count($cid)) {
        $cids = implode(',', $cid);
        $database->setQuery("DELETE FROM #__docman_cqbh  WHERE id IN ($cids)");
        if (!$database->query()) {
            echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        }
    }

    if (count($err)) {
        if (count($err) > 1) {
            $cids = implode(', ', $err);
            $msg = _DML_CATS.": $cids -";
        } else {
            $msg = _DML_CAT." " . $err[0] ;
        }
        $msg .= ' '._DML_CATS_CANT_BE_REMOVED;
        mosRedirect('index2.php?option=com_docman&section=cqbh&mosmsg=' . $msg);
    }

    $msg = (count($err) > 1 ? _DML_CATS : _DML_CAT . " ") . _DML_DELETED;
    mosRedirect('index2.php?option=com_docman&section=cqbh&mosmsg=' . $msg);
}

/**
* Publishes or Unpublishes one or more categories
*
* @param string $ The name of the category section
* @param integer $ A unique category id (passed from an edit form)
* @param array $ An array of unique category id numbers
* @param integer $ 0 if unpublishing, 1 if publishing
* @param string $ The name of the current user
*/

function publishCategories($section, $categoryid = null, $cid = null, $publish = 1)
{
    DOCMAN_token::check() or die('Invalid Token');

    global $database, $my;

    if (!is_array($cid)) {
        $cid = array();
    }
    if ($categoryid) {
        $cid[] = $categoryid;
    }

    if (count($cid) < 1) {
        $action = $publish ? _PUBLISH : _DML_UNPUBLISH;
        echo "<script> alert('" . _DML_SELECTCATTO . " $action'); window.history.go(-1);</script>\n";
        exit;
    }

    $cids = implode(',', $cid);

    $query = "UPDATE #__docman_cqbh  SET public=$publish"
     . "\n WHERE id IN ($cids) AND (checked_out=0 OR (checked_out=$my->id))" ;
    $database->setQuery($query);
    if (!$database->query()) {
        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    /*if (count($cid) == 1) {
        $row = new mosCategory($database);
        $row->checkin($cid[0]);
    }*/

    mosRedirect('index2.php?option=com_docman&section=cqbh');
}

/**
* Cancels an edit operation
*
* @param string $ The name of the category section
* @param integer $ A unique category id
*/
function cancelCategory()
{
    global $database;

    $row = new mosDMCQBH($database);
    $row->bind(DOCMAN_Utils::stripslashes($_POST));
    $row->checkin();
    mosRedirect('index2.php?option=com_docman&section=cqbh');
}

/**
* Moves the order of a record
*
* @param integer $ The increment to reorder by
*/
function orderCategory($uid, $inc)
{
    global $database;

    $row = new mosDMCQBH($database);
    $row->load($uid);
    $row->move($inc, "section='$row->section'");
    mosRedirect('index2.php?option=com_docman&section=cqbh');
}

/**
* changes the access level of a record
*
* @param integer $ The increment to reorder by
*/
function accessCategory($uid, $access)
{
    DOCMAN_token::check() or die('Invalid Token');

    global $database;

    $row = new mosDMCategory($database);
    $row->load($uid);
    $row->access = $access;

    if (!$row->check()) {
        return $row->getError();
    }
    if (!$row->store()) {
        return $row->getError();
    }

    mosRedirect('index2.php?option=com_docman&section=categories');
}
