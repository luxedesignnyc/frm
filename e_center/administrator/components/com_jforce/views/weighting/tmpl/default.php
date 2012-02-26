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

<form action='index.php' method='post' name='adminForm'>

<?php
echo $this->tabs->startPane('pane');
echo $this->tabs->startPanel('Leads', 'leadsTab');
?>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable' id="leadTable">
			<tr>
				<td class='key'>
					<?php echo JText::_('Auto Assign Leads'); ?></td><td>
					<?php echo $this->lists['leadauto']; ?>
				</td>
			</tr>      
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Assignment Type'); ?></td><td>
					<?php echo $this->lists['leadassigntype']; ?>
				</td>
			</tr>
            <?php for ($i=0; $i<count($this->lists['leadweights']);$i++) : 
				$w = $this->lists['leadweights'][$i];
			?>
            	<tr>
                	<td class='key'><?php echo $w['label'];?></td><td><?php echo $w['input'];?>&nbsp;%</td>
            	</tr>
            <?php endfor; ?>
		</table>
<?php
echo $this->tabs->endPanel();

echo $this->tabs->startPanel('Tickets', 'global_ticketsTab');
?>
	<table width='100%' cellpadding='5' cellspacing='0' class='admintable' id="ticketTable">
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
<?php
echo $this->tabs->endPanel();

echo $this->tabs->startPanel('Project Tickets', 'ticketsTab');
?>

	<table width='100%' cellpadding='5' cellspacing='0' class='admintable' id="ticketTable">
			<tr>
				<td class='key'>
					<?php echo JText::_('Project'); ?></td><td>
					<?php echo $this->lists['projects']; ?>
				</td>
			</tr>  
	</table>
	<div id="projectWeights"></div>
<?php
echo $this->tabs->endPanel();

echo $this->tabs->endPane();

?>

	
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='ret' value='index.php?option=com_jforce' />
<input type='hidden' name='task' value='' />
<input type='hidden' name='model' value='weight' />
<input type='hidden' name='c' value='configuration' />
<input type='hidden' name='view' value='weighting' />
<input type='hidden' name='layout' value='default' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive');
