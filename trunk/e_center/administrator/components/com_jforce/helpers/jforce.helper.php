<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			jforce.helper.php											*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForceHelper {

	function getDaysDate($date, $style = true) {
		// Written on 2009-07-14 by TDRD
		$html = NULL;
		
		//number of seconds in a day
		$day = 86400;	
		$today_str = date('Y-m-d');
		$date_str = date('Y-m-d',strtotime($date));

		// if date is the same, then it's today
		if ($date_str == $today_str){
			$html = JText::_('Today');
			
		// same month	
		}elseif (substr($date_str,0,7) == substr($today_str,0,7)){
			$today_d = (int)substr($today_str,8,2);
			$date_d = (int)substr($date_str,8,2);
			$days_diff = $date_d - $today_d;
			if ($date_d == ($today_d + 1)){
				$html = JText::_('Tomorrow');	
			}elseif($date_d == $today_d - 1){
				$html = JText::_('Yesterday');
			}elseif($date_d >= ($today_d + 2)){
				if(!$style):
					$html = JText::_('Due in')." ". $days_diff ." ".JText::_('Days');
				else:
					$html = "<span class='upcoming'>".JText::_('Due in')." ". $days_diff ." ".JText::_('Days')."</span>";
				endif;	
			}elseif($date_d <= ($today_d - 2)){
				if(!$style):
					$html = abs($days_diff)." ".JText::_('Days Ago')."</span>";
				else:
					$html = "<span class='late'>".abs($days_diff)." ".JText::_('Days Late')."</span>";
				endif;
			}
			
		// not same month	
		}else{
			$today_y = substr($today_str,0,4);
			$today_m = substr($today_str,5,2);
			$date_y = substr($date_str,0,4);
			$date_m = substr($date_str,5,2);
			$year_diff = $today_y - $date_y;
			if ($year_diff >= 0){
				$month_diff = $today_m - $date_m + 12*$year_diff;
				
				if ($month_diff == 1){
					$html = JText::_('1 Month Ago');				
				}else{
					$html = $month_diff.' '.JText::_('Months Ago');
				}
			}
		}
    	return $html;
	}
	/*
	function getDaysDate($date, $style = true) {
		$day = 86400;
		$today = time();
		$date = date('Y-m-d',strtotime($date));
		$date = strtotime($date);
		
		$days = floor(($today-$date)/$day);
		
		switch($days) {
			case 0:
			case -1:
			$html = JText::_('Today');
			break;
			
			case 1:
			$html = JText::_('Yesterday');
			break;
			
			default:
				if($days > 30 ):
					$months = floor($days/30);
					if($months==1):
						$html = $months.' '.JText::_('Month Ago');
					else:
						$html = $months.' '.JText::_('Months Ago');
					endif;
				elseif($days < -1):
					if(!$style):
						$html = JText::_('Due in')." ". abs($days) ." ".JText::_('Days');
					else:
						$html = "<span class='upcoming'>".JText::_('Due in')." ". abs($days) ." ".JText::_('Days')."</span>";
					endif;
				else:
					if(!$style):
						$html = $days." ".JText::_('Days Ago')."</span>";
					else:
						$html = "<span class='late'>".$days." ".JText::_('Days Late')."</span>";
					endif;
				endif;
			break;
		}
    return $html;
	}
	*/
	
	function getObjectStatus($object, $type)
	{
		$user 		= JFactory::getUser();
		$database 	= JFactory::getDBO();
		
		$query = "SELECT COUNT(*) FROM #__jf_objectviews ".
				 " WHERE object='$object' ".
				 " AND type='$type' ".
				 " AND uid='$user->id' ";
		$database->setQuery($query);

		$result = $database->loadResult();
		
		if(!$result):
			$read = false;
		else:
			$read = true;
		endif;
		
		return $read;
	}
	
	function setObjectStatus($object, $type)
	{
		$user 		= JFactory::getUser();
		$database 	= JFactory::getDBO();
		
		$item = JTable::getInstance('ObjectStatus', 'JTable');
		
		$item->uid = $user->get('id');
		$item->object = $object;
		$item->type = $type;

		$item->store();
	}

	function getInvoiceInterval($publish, $interval) {
		// Interval must be declared in days
		
		$interval = $interval*3600*24;
		
		$time = strtotime($publish) + $interval;
		
		$time = date("Y-m-d", $time);
		
		return $time;
	
	}
	
	function standardizeFields($original, $field = null,$late = false)
	{
		$object = array();
		if ($original) :
		foreach ( $original as $key => $value ) : 
                
				$type = $key;
				
				if($value):
				foreach($value as $v) :
				
					switch($type) :
					
						case 'project': 
							$title = $v->name;
							$text = $v->description;
							$completed = null;
							$duedate = $v->startson;
						break;
						case 'milestone':
							$title = $v->summary;
							$text = $v->notes;
							$completed = $v->completed;
							$duedate = $v->duedate;
						break;
						
						case 'checklist':
							$title = $v->summary;
							$text = $v->description;
							$completed = $v->completed;
							$duedate = null;
						break;
						
						case 'task':
							$title = $v->summary;
							$text = null;
							$completed = $v->completed;	
							$duedate = $v->duedate;
						break;
						
						case 'comment':
							$title = $v->message;
							$text = null;
							$completed = null;
							$duedate = null;
						break;
						
						case 'discussion':
							$title = $v->summary;
							$text = $v->message;
							$completed = null;
							$duedate = null;
						break;
						
						case 'ticket':
							$title = $v->summary;
							$text = $v->description;
							$completed = null;
							$duedate = null;
						break;
						
						case 'event':
							$title = $v->subject;
							$text = $v->description;
							$completed = null;
							$duedate = 	JHTML::_('date',  $v->startdate,'%b %d, %Y');		
							$v->duedate = $duedate;
						break;
						
						case 'quote':
							$title = $v->name;
							$text = $v->description;
							$completed = $v->accepted;
							$duedate = JHTML::_('date',  $v->validtill,'%b %d, %Y');;
							$v->duedate = $duedate;
						break;

						case 'invoice':
							$title = $v->name;
							$text = $v->description;
							$completed = $v->paid;
							$duedate = JHTML::_('date',  $v->validtill,'%b %d, %Y');;
							$v->duedate = $duedate;
						break;

						case 'document':
							$title = $v->name;
							$text = $v->description;
							$completed = null;
							$duedate = null;
						break;
						
					endswitch;
					
					$text = JForceHelper::snippet($text, 50);
					
					$restoreButton = isset($v->restoreButton) ? $v->restoreButton : '';
					
					
					/* Repetitive Revisit statements */
					if(!$late):
						if($field):
							$object[$v->$field][] = array(
								"id" => $v->id,
								"type" => $type,
								"author" => $v->author,
								"link" => $v->link,
								"created" => $v->created,
								"title" => $title,
								"text" => $text,
								"completed" => $completed,
								"duedate" => $duedate,
								"restoreButton" => $restoreButton
								);
						else:
							$object[$type][] = array(
								"id" => $v->id,
								"type" => $type,
								"author" => $v->author,
								"link" => $v->link,
								"created" => $v->created,
								"title" => $title,
								"text" => $text,
								"completed" => $completed,
								"duedate" => $duedate
								);
						endif;
					else:
						if($duedate!='' || $duedate>time()):
							if($field):
								$object[$v->$field][] = array(
									"id" => $v->id,
									"type" => $type,
									"author" => $v->author,
									"link" => $v->link,
									"created" => $v->created,
									"title" => $title,
									"text" => $text,
									"completed" => $completed,
									"duedate" => $duedate,
									"restoreButton" => $restoreButton
									);
							else:
								$object[$type][] = array(
									"id" => $v->id,
									"type" => $type,
									"author" => $v->author,
									"link" => $v->link,
									"created" => $v->created,
									"title" => $title,
									"text" => $text,
									"completed" => $completed,
									"duedate" => $duedate
									);
							endif;
						endif;
					endif;
					
				endforeach;
				endif;
				
        	endforeach;
		endif;
			
		return $object;
	}
	
	function sortArray($original,$field, $start = null)
        {
           $sortArr = array();
			
		   $new = JForceHelper::standardizeFields($original, $field);
		   $items = array();
		   
			$seconds = 86400;
			$today = time();
			
			if($new):
				foreach ($new as $k=>$n) {
					foreach($n as $o):
						$date = date('Y-m-d',strtotime($k));
						$date = strtotime($date);
						$days = floor(($today-$date)/$seconds);		
			
						$day = date("Y-m-d", strtotime($k));
								
						if($start):
							if($days < $start):
								$items[$day][] = $o;
							endif;
						else:
							$items[$day][] = $o;
						endif;
					endforeach;					
				}
			endif;			
			
			krsort($items);
            return $items;
        }    
		

		function snippet($text,$length=100,$tail="...") {
			$text = strip_tags($text);
			$text = trim($text);
			$txtl = strlen($text);
			if($txtl > $length) {
				for($i=1;$text[$length-$i]!=" ";$i++) {
					if($i == $length) {
						return substr($text,0,$length) . $tail;
					}
				}
				$text = substr($text,0,$length-$i+1) . $tail;
			}
			
			return $text;
		}
		
		function prepareTags($tags,$pid) {
			$tags = explode(',',$tags);
			for($i=0;$i<count($tags);$i++):
				$tag = $tags[$i];
				$link = JRoute::_('index.php?option=com_jforce&view=search&layout=results&pid='.$pid.'&keyword='.$tag);				
				$returnTags[] = '<a href='.$link.'>'.$tag.'</a>';
			endfor;

			$finalTags = implode(', ',$returnTags);
			
			return $finalTags;
		
		}
		
		function prepareAssignees($assignees) {
			for($i=0;$i<count($assignees);$i++):
				$a = $assignees[$i];
				$link = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$a->person_id);				
				$returnTags[] = '<a href='.$link.'>'.$a->name.'</a>';
			endfor;

			$finalTags = implode(', ',$returnTags);
			
			return $finalTags;
		}
		
		function getFilesize($filesize)
		{
			if($filesize < 1000):
				$size = $filesize."b";
			elseif($filesize >= 1000 and $filesize < 1000000):
				$size = round($filesize / 1000,2) ."kb";
			else:
				$size = round($filesize / 1000000, 2) ."mb";
			endif;
			
			return $size;
		}
		
		function getPagination($model) {
			
			$limit		 	= JRequest::getVar('limit', 0);
			$limitstart		= JRequest::getVar('limitstart', 0);
	
			$total = $model->getTotal();
			
			if (!$limit) :
				$limit = 10;
				JRequest::setVar('limit', $limit, 'get');
			endif;
	
			jimport('joomla.html.pagination');
			$pagination = new JPagination($total, $limitstart, $limit);
		
			return $pagination;
		}
        
		function notAuth() {
			global $mainframe;
			$url = JRoute::_('index.php?option=com_jforce');
			$msg = JText::_('You are not authorized to view this resource.');
			$mainframe->redirect($url, $msg);
		}
		
		function lockOut() {
			global $mainframe;
			$url = 'index.php';
			$msg = JText::_('You are not authorized to view this resource.');
			$mainframe->redirect($url, $msg);
		}
		
		function loginRedirect() {
			global $mainframe;
			$uri = &JFactory::getURI();
			$return = base64_encode($uri->toString());
			$url = JRoute::_('index.php?option=com_user&view=login&return='.$return);
			$msg = JText::_('Please login.');
			$mainframe->redirect($url, $msg);	
		}
		
		function generateKey() {
			$key = md5(md5(uniqid().time()));
			return $key;
		}
		
		function loadComments($type, $object) {
			
			$document = &JFactory::getDocument();
			$js = "window.addEvent('domready', function() {
						$('addAttachment').addEvent('click', function(e) {
							new Event(e).stop();

							addAttachment();											  
						});
					});";
			
			$document->addScriptDeclaration($js);
			
			$commentModel = &JModel::getInstance('Comment', 'JforceModel');
			$commentModel->setId(null);
			$commentModel->setType($type);
			$commentModel->setObjectid($object->id);
			
			$pagination = JForceHelper::getPagination($commentModel);
			$comments = $commentModel->listComments();
			$title = JText::_('Reply to '.ucwords($type));
			$showMain = $pagination->get('pages.current')==1 ? true : false;
			
			$config['name'] = 'comment';
			$commentView = new JView($config);
			$commentView->assignRef('comments', $comments);
			$commentView->assignRef('id', $object->id);
			$commentView->assignRef('pid', $object->pid);
			$commentView->assignRef('type', $type);
			$commentView->assignRef('pagination', $pagination);
			$commentView->assignRef('showMain', $showMain);
			$commentView->assignRef('title', $title);
			
			return $commentView;
		}

	function loadEvents($type, $object) {
			
			$view = JRequest::getVar('view');
			$layout = JRequest::getVar('layout');
		
			$eventModel = &JModel::getInstance('Event', 'JForceModel');
			$eventModel->setVar('id', '');
			$function = "set".$type;
			$eventModel->$function($object->id);
			$events = $eventModel->listEvents();
			
			// Build Select Lists
			$lists = &$eventModel->buildLists();
			$quickLinks = JForceMenuHelper::getQuickLinks();			
			
			$url = JRoute::_('index.php?option=com_jforce&c=event&view=event&layout=new&'.$type.'='.$object->id);
			$newEventLink = '<a href="'.$url.'" class="button">'.JText::_('Add Event').'</a>';
			
			$return = JRoute::_('index.php?option=com_jforce&c=sales&view='.$view.'&layout='.$layout.'&id='.$object->id);
			
			$config['name'] = 'event';
			$eventView = new JView($config);
			$eventView->assignRef('events', $events);
			$eventView->assignRef('newEventLink', $newEventLink);
			$eventView->assignRef('quickLinks',$quickLinks);
			$eventView->assignRef('lists',$lists);
			$eventView->assignRef('return',$return);
			
			return $eventView;
		}
	function loadNotes($type, $object) {
			
			$noteModel = &JModel::getInstance('Note', 'JForceModel');
			$function = "set".$type;
			$noteModel->setVar('id', '');
			$noteModel->$function($object->id);
			$notes = $noteModel->listNotes();
			
			$url = JRoute::_('index.php?option=com_jforce&c=sales&view=note&layout=new&'.$type.'='.$object->id);
			$newNoteLink = '<a href="'.$url.'" class="button">'.JText::_('Add Note').'</a>';
			
			$config['name'] = 'note';
			$noteView = new JView($config);
			$noteView->assignRef('notes', $notes);
			$noteView->assignRef('newNoteLink', $newNoteLink);
			
			return $noteView;
		}
		
	function loadCustomFields($type, $id, $edit = false, $publicOnly = false, $customLayout = NULL) {
		$customFieldModel = &JModel::getInstance('Customfield', 'JForceModel');
		$customFieldModel->setId(NULL);
		
		if ($publicOnly) :
			$customFieldModel->setPublicOnly();
		endif;

		$customFields = $customFieldModel->loadCustomFields($type, $id, $edit);
		
		$config['name'] = 'customfield';
		$customfieldView = new JView($config);
		$layout = JForceHelper::getCustomFieldLayout($customfieldView, $type, $edit, $customLayout);
		$customfieldView->setLayout($layout);
		$customfieldView->assignRef('customFields', $customFields);
		return $customfieldView;
	}

	function getCustomFieldLayout($customfieldView, $type, $edit, $customLayout) {
		$layout = $edit ? 'form' : 'default';
		
		if (!$customLayout) :
			$customLayout = $edit ? $type.'form' : $type;
		endif;
		
		if (JForceHelper::checkCustomFieldView($customfieldView, $customLayout)) :
			$layout = $customLayout;
		endif;
		
		return $layout;
	}

	function checkCustomFieldView($customfieldView, $customLayout) {
		jimport('joomla.filesystem.file');
		$exists = false;
		for($i=0; $i<count($customfieldView->_path['template']); $i++) :
			$customfile = $customfieldView->_path['template'][$i].$customLayout.'.php';
			if (JFile::exists($customfile)) :
				$exists = true;
			endif;
		endfor;
		return $exists;
	}
	
	function validateObject($object, $fields) {
		global $mainframe;
		$missing = array();
		
		for($i=0; $i<count($fields); $i++) :
			$f = $fields[$i];
			if (!$object->$f) :
				$pass = false;
				$missing[] = $f;
			endif;
		endfor;
		
		if (!empty($missing)) :
			$return = $_SERVER['HTTP_REFERER'];
			$msg = JText::_('Please fill out all required fields:');
			$mainframe->enqueueMessage($msg, 'error');
			foreach ($missing as $m) :
				$mainframe->enqueueMessage(JText::_($m), 'error');
			endforeach;
			$mainframe->redirect($return);
		endif;
		
	}
	function convertRequired($name, $fields) {
		$newFields = array();
		
		for ($i=0; $i<count($fields); $i++) :
			$newFields[] = $name.'['.$fields[$i].']';
		endfor;
		
		return $newFields;
	}
	function initValidation($fields) {
		
		$fields = "'".implode("','",$fields)."'";
		
		$document = &JFactory::getDocument();
		$js = "window.addEvent('domready', function() {
					var requiredFields = new Array(".$fields.");
					
					$$('input, select, textarea').each(function(el) {
						var name = el.getProperty('name');
						
						if (in_array(name, requiredFields)) {
							el.addClass('required');
							
						}
						
					});
				
				});";
		$document->addScriptDeclaration($js);
	}
	
	function getFilter() {
		$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$array = str_split($alphabet);

		$c 		= JRequest::getVar('c','');
		$view 	= JRequest::getVar('view');
		$pid 	= JRequest::getVar('pid');
		
		$url = $c ? 'index.php?option=com_jforce&c='.$c.'&view='.$view : 'index.php?option=com_jforce&view='.$view;
		if ($pid) :
			$url .= '&pid='.$pid;
		endif;

		$links[] = '<a class="alphaFilter" href="'.JRoute::_($url).'">All</a>';
		$links[] = '<a class="alphaFilter" href="'.JRoute::_($url.'&alpha=numeric').'">0-9</a>';
		foreach ($array as $a) :
			$links[] = '<a class="alphaFilter" href="'.JRoute::_($url.'&alpha='.$a).'">'.$a.'</a>';
		endforeach;
		
		return $links;
		
	}


	function prepareSearchContent( $text, $length=200, $searchword ) {
      // strips tags won't remove the actual jscript
      $text = preg_replace( "'<script[^>]*>.*?</script>'si", "", $text );
      $text = preg_replace( '/{.+?}/', '', $text);
  
      //$text = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2', $text );
  
      // replace line breaking tags with whitespace
      $text = preg_replace( "'<(br[^/>]*?/|hr[^/>]*?/|/(div|h[1-6]|li|p|td))>'si", ' ', $text );
  
      $text = JForceHelper::smartSubstr( strip_tags( $text ), $length, $searchword );
  
      return $text;
  }
  
	function smartSubstr($text, $length=200, $searchword) {
    	$wordpos = strpos(strtolower($text), strtolower($searchword));
		$halfside = intval($wordpos - $length/2 - strlen($searchword));
		if ($wordpos && $halfside > 0) {
		  return '...' . substr($text, $halfside, $length) . '...';
		} else {
		  return substr( $text, 0, $length);
		}
  }
  
function objectToArray($object) {
	
		$array = array();
		if (!empty($object)) :
			foreach ($object as $o) :
					$array[] = $o;
			endforeach;
		endif;
		
		return $array;	
	}
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               