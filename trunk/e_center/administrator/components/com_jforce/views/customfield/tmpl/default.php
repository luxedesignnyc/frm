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
<table cellpadding='4' cellspacing='0' border='0' width='100%' class='adminlist'>
        <tr>
        	<td align='right'><?php echo JText::_('Filter'); ?>: <?php echo $this->filter; ?></td>
        </tr>
</table>
<table cellpadding='4' cellspacing='0' border='0' width='100%' class='adminlist'>
    <thead>
        <tr>
            <th width='20'><input type='checkbox' name='toggle' value='' onclick='checkAll(<?php echo count($this->customfields); ?>);' /></th>
            <th align='center' width="25"><?php echo JText::_('ID'); ?></th>
            <th><?php echo JText::_('Field'); ?></th>
            <th><?php echo JText::_('Field Type'); ?></th>
            <th><?php echo JText::_('Type'); ?></th>
            <th width="100"><?php echo JText::_('Order'); ?><?php echo JHTML::_('grid.order',  $this->customfields ); ?></th>
            <th width="50"><?php echo JText::_('Required'); ?></th>
            <th width="50"><?php echo JText::_('Public'); ?></th>
            <th width="50"><?php echo JText::_('Published'); ?></th>
        </tr>
	</thead>
		<tbody>
		<?php
		$k = 0;
		for($i=0; $i < count( $this->customfields ); $i++) {
		$n = count($this->customfields);
		$customfield = $this->customfields[$i];
		?>
		<tr class='<?php echo 'row'.$k; ?>'>
		<td><input type='checkbox' id='cb<?php echo $i; ?>' name='cid[]' value='<?php echo $customfield->id; ?>' onclick='isChecked(this.checked);' /></td>
		<td align='center'><?php echo $customfield->id; ?></td>
<td><a href='#edit' onclick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $customfield->field; ?></td>
<td><?php echo $customfield->fieldtype; ?></td>
<td><?php echo $customfield->type; ?></td>
<td class="order">
	<span><?php echo $this->pagination->orderUpIcon( $i, ($customfield->type == @$this->customfields[$i-1]->type), 'orderup', 'Move Up', true); ?></span>
	<span><?php echo $this->pagination->orderDownIcon( $i, $n, ($customfield->type == @$this->customfields[$i+1]->type), 'orderdown', 'Move Down', true ); ?></span>
	<input type="text" name="order[]" size="5" value="<?php echo $customfield->ordering; ?>" class="text_area" style="text-align: center" />
</td>
<td align="center"><?php echo $customfield->required; ?></td>
<td align="center"><?php echo $customfield->public; ?></td>
<td align="center"><?php echo $customfield->published; ?></td>
		<?php $k = 1 - $k; ?>
		</tr>
		<?php }	?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan='10'><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
		</table>
		<input type='hidden' name='task' value='' />
		<input type='hidden' name='option' value='com_jforce' />
        <input type='hidden' name='c' value='customfield' />
		<input type='hidden' name='boxchecked' value='0' />
        <input type='hidden' name='ret' value='index.php?option=com_jforce' />
        <input type="hidden" name="view" value="customfield" />
        <input type="hidden" name="layout" value="default" />
        <input type="hidden" name="model" value="customfield" />
        <?php echo JHTML::_('form.token'); ?>
		</form> 