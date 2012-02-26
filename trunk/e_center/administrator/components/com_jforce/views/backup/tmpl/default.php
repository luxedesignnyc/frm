<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			default.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<form name="uploadForm" method="post" enctype="multipart/form-data">
<fieldset>
	<legend><?php echo JText::_('Import Backup');?></legend>
    <input type="file" name="file" class="inputbox" id="file" />&nbsp;&nbsp;
    <input type="submit" name="upload" class="button" value="<?php echo JText::_('Upload');?>" />
</fieldset>
<input type="hidden" name="option" value="com_jforce" />
<input type="hidden" name="task" value="importSQL" />
<?php echo JHTML::_('form.token'); ?>
</form>


<fieldset>
	<legend><?php echo JText::_('Backup Tables');?></legend>
   	<a class="button small" href="index.php?option=com_jforce&task=exportTables&view=raw">Download Backup</a>
</fieldset>

<form action='index.php' method='post' name='adminForm'>
<input type='hidden' name='task' value='' />
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='c' value='configuration' />
<input type='hidden' name='boxchecked' value='0' />
<input type="hidden" name="view" value="backup" />
<input type="hidden" name="layout" value="" />
<input type='hidden' name='ret' value='index.php?option=com_jforce' />
</form> 