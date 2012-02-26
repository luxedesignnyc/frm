<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: DOCMAN_button.class.php 765 2009-01-05 20:55:57Z mathias $
 * @package DOCman_1.4
 * @copyright (C) 2003-2009 Joomlatools
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');


if (defined('_DOCMAN_button')) {
    return true;
} else {
    define('_DOCMAN_button', 1);
}

if( defined('_DM_J15') ) {
    // do nothing
} else {
    require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'DOCMAN_jobject.class.php');
}

require_once($_DOCMAN->getPath('classes', 'params'));

/**
 * @abstract
 */
class DOCMAN_Button extends JObject {
    /**
     * @abstract string
     */
	var $name;

    /**
     * @abstract string
     */
    var $text;

    /**
     * @abstract string
     */
    var $link;

    /**
     * @abstract DMmosParameters Object
     */
    var $params;

    /**
     * @constructor
     */
    function __construct($name, $text, $link = '#', $params = null) {
    	$this->name = $name;
        $this->text = $text;
        $this->link = $link;
        if(!is_object($params)) {
        	$this->params = new DMmosParameters('');
        } else {
        	$this->params = & $params;
        }
    }
}