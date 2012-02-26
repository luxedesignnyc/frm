<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			project.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<table width='100%' cellpadding='5' cellspacing='0' class='admintable' id="ticketTable2">
	<tr>
		<td class='key'>
			<?php echo JText::_('Auto Assign Tickets'); ?></td><td>
			<?php echo $this->lists['ticketauto']; ?>
		</td>
	</tr>      
    <tr>
		<td class='key' valign="top">
			<?php echo JText::_('Assignment Type'); ?></td><td>
			<?php echo $this->lists['ticketassigntype']; ?>
		</td>
	</tr>
	<?php for ($i=0; $i<count($this->lists['ticketweights']);$i++) : 
				$w = $this->lists['ticketweights'][$i];
			?>
            	<tr>
                	<td class='key'><?php echo $w['label'];?></td><td><?php echo $w['input'];?>&nbsp;%</td>
            	</tr>
            <?php endfor; ?>
</table>

