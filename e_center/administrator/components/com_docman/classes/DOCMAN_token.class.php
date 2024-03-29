<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: DOCMAN_token.class.php 781 2009-02-08 16:02:59Z mathias $
 * @package DOCman_1.4
 * @copyright (C) 2003-2009 Joomlatools
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

if (defined('_DOCMAN_token')) {
    return true;
} else {
    define('_DOCMAN_token', 1);
}

/**
 * Utility class to work with form tokens
 *
 * @example:
 * In a form:
 * <code>
 * <?php echo DOCMAN_token::render();?>
 * </code>
 * Where the form is submitted:
 * <code>
 * <?php DOCMAN_token::check() or die('Invalid Token'); ?>
 * </code>
 *
 * @static
 */
class DOCMAN_Token
{
    /**
     * Generate new token and store it in the session
     *
     * @see render()
     * @return	string	Token
     */
    function get($forceNew = false)
    {
        if(defined('_DM_J15'))
        {
        	return JUtility::getToken($forceNew);
        }
        
        static $token;
        if($forceNew or !isset($token))
        {
            @session_start();
            $token = md5(uniqid(rand(), TRUE));
            $_SESSION['docman.token'] = $token;
        }
        return $token;
    }

    /**
     * Render the hidden input field with the token
     *
     * @return	string	Html
     */
    function render()
    {
    	if(defined('_DM_J15'))
        {
        	return JHTML::_( 'form.token' );
        }
        
        return '<input type="hidden" name="'.DOCMAN_Token::get().'" value="1" />';
        
    }

    /**
     * Check if a valid token was submitted
     *
     * @todo	When all forms are updated to fully use $_POST, so should this
     *
     * @return	boolean	True on success
     */
    function check($method = 'post')
    {
    	if(defined('_DM_J15'))
        {
    		return JRequest::checkToken($method);
        }
        
        @session_start();
        if(!isset($_SESSION['docman.token']))
        {
        	return false;
        }
        $token = $_SESSION['docman.token'];
        if(isset($_REQUEST[$token]) && $_REQUEST[$token])
        {
            return true;
        }
        return false;
    	
    }


}