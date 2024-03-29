<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: DOCMAN_compat15.class.php 775 2009-01-19 13:32:56Z mathias $
 * @package DOCman_1.4
 * @copyright (C) 2003-2009 Joomlatools
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

class DOCMAN_Compat {
    function mosLoadAdminModules( $position='left', $style=0 ) {
        global $mainframe;

        $modules    =& JModuleHelper::getModules($position);
        $pane       =& JPane::getInstance('sliders');
        echo $pane->startPane("content-pane");

        foreach ($modules as $module) {
            $title = $module->title ;
            echo $pane->startPanel( $title, "$position-panel" );
            echo JModuleHelper::renderModule($module);
            echo $pane->endPanel();
        }

        echo $pane->endPane();
    }

    function mosReadDirectory($path, $filter='.', $recurse=false, $fullpath=false) {
        $arr = array();
        if (!@is_dir( $path )) {
            return $arr;
        }
        $handle = opendir( $path );

        while ($file = readdir($handle)) {
            $dir = mosPathName( $path.'/'.$file, false );
            $isDir = is_dir( $dir );
            if (($file != ".") && ($file != "..")) {
                if (preg_match( "/$filter/", $file )) {
                    if ($fullpath) {
                        $arr[] = trim( mosPathName( $path.'/'.$file, false ) );
                    } else {
                        $arr[] = trim( $file );
                    }
                }
                if ($recurse && $isDir) {
                    $arr2 = mosReadDirectory( $dir, $filter, $recurse, $fullpath );
                    $arr = array_merge( $arr, $arr2 );
                }
            }
        }
        closedir($handle);
        asort($arr);
        return $arr;
    }


    function editorArea($areaname, $content, $name, $width, $height, $rows, $cols) {
        $editor =& JFactory::getEditor();

        // JEditor::display( $name,  $html,  $width,  $height,  $col,  $row, [ $buttons = true])
        echo $editor->display($name, $content, $width, $height, $rows, $cols) ;
    }

    // Add the Calendar includes to the document <head> section
    function calendarJS() {
        JHTML::_('behavior.calendar');
    }

    function calendar($name, $value) {
    	JHTML::_('behavior.calendar'); //load the calendar behavior

		$format	= '%d-%m-%Y';
	//	$format	= '%d-%m-%Y';
		$class	= 'inputbox';
		$id   	= $name;

		echo JHTML::_('calendar', $value, $name, $id, $format, array('class' => $class));
    }

    /**
     * Removes illegal tags and attributes from html input
     */
    function inputFilter($html){
        /*
        jimport('joomla.filter.input');
        $filter = & JFilterInput::getInstance(array(), array(), 1, 1);
        return $filter->clean( $html );
        */

        // Replaced code to fix issue with img tags
        jimport('phpinputfilter.inputfilter');
        $filter = new InputFilter(array(), array(), 1, 1);
        return $filter->process( $html );
    }
}
