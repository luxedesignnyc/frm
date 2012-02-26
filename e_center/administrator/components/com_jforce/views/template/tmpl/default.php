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
<div class="jfAdminTitle"><?php echo JText::_('Templates'); ?></div>
<?php /* 
<?php
echo $this->tabs->startPane('pane');
echo $this->tabs->startPanel('Quotes', 'quotesTab');
?>
<script language='javascript' type='text/javascript'>
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	form.task.value=pressbutton;
	form.submit();
}
//-->
</script>
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
	<fieldset class="adminform">
    	<legend><?php echo JText::_('Details'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
			<tr>
				<td class='key'>
					<?php echo JText::_('Subject'); ?></td><td>
					<input type='text' name='subject' size='35' class='inputbox required' value='<?php echo $this->template->subject;?>' />
				</td>
			</tr>                        
            <tr>
				<td class='key'>
					<?php echo JText::_('Body'); ?></td><td>
                    	<table width="100%" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td valign='top' width="50%">
									<?php echo $this->editor->display( 'body',  $this->template->body , '100%', '200', '150', '20' ) ; ?>
                                </td>
                                <td valign='top' width="200px">
	                                <fieldset class="adminform">
    	                                <legend><?php echo JText::_('Variable List'); ?></legend>
		                                <div id='variablesHolder'><?php echo $variableOptions['quote']; ?></div>
                                	</fieldset>
                                </td>
                                <td>&nbsp;</td>
                           </tr>
                      </table>
				</td>
			</tr>
		</table>
</fieldset>
<input type="hidden" name="category" value="quote" />
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='template' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->template->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>

<?php
echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Invoices', 'invoicesTab');
?>

<script language='javascript' type='text/javascript'>
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	form.task.value=pressbutton;
	form.submit();
}
//-->
</script>
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
	<fieldset class="adminform">
    	<legend><?php echo JText::_('Details'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
			<tr>
				<td class='key'>
					<?php echo JText::_('Subject'); ?></td><td>
					<input type='text' name='subject' size='35' class='inputbox required' value='<?php echo $this->template->subject;?>' />
				</td>
			</tr>                        
            <tr>
				<td class='key'>
					<?php echo JText::_('Body'); ?></td><td>
                    	<table width="100%" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td valign='top' width="50%">
									<?php echo $this->editor->display( 'body',  $this->template->body , '100%', '200', '150', '20' ) ; ?>
                                </td>
                                <td valign='top' width="200px">
	                                <fieldset class="adminform">
    	                                <legend><?php echo JText::_('Variable List'); ?></legend>
		                                <div id='variablesHolder'><?php echo $variableOptions['invoice']; ?></div>
                                	</fieldset>
                                </td>
                                <td>&nbsp;</td>
                           </tr>
                      </table>
				</td>
			</tr>
		</table>
</fieldset>
<input type="hidden" name="category" value="invoice" />
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='template' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->template->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>

<?php
echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Email', 'emailTab');
?>
*/
?>
<form action='index.php' method='post' name='adminForm'>
<table cellpadding='4' cellspacing='0' border='0' width='100%' class='adminlist'>
    <thead>
        <tr>
            <th width='20'><input type='checkbox' name='toggle' value='' onclick='checkAll(<?php echo count($this->templates); ?>);' /></th>
            <th align='center'><?php echo JText::_('ID'); ?></th>
            <th><?php echo JText::_('Template Name'); ?></th>
            <th><?php echo JText::_('Category'); ?></th>
            <th><?php echo JText::_('Tags'); ?></th>
        </tr>
	</thead>
		<tbody>
		<?php
		$k = 0;
		for($i=0; $i < count( $this->templates ); $i++) {
		$template = $this->templates[$i];
		?>
		<tr class='<?php echo 'row'.$k; ?>'>
		<td><input type='checkbox' id='cb<?php echo $i; ?>' name='cid[]' value='<?php echo $template->id; ?>' onclick='isChecked(this.checked);' /></td>
		<td align='center'><?php echo $template->id; ?></td>
<td><a href='#edit' onclick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $template->name; ?></td>
<td><?php echo $template->category; ?></td>
<td><?php echo $template->tags; ?></td>
		<?php $k = 1 - $k; ?>
		</tr>
		<?php }	?>
		</tbody>
	<!--	<tfoot>
			<tr>
				<td colspan='10'><?php /*echo $pagination->getListFooter();*/?></td>
			</tr>
		</tfoot> -->
		</table>
		<input type='hidden' name='task' value='' />
		<input type='hidden' name='option' value='com_jforce' />
        <input type='hidden' name='c' value='configuration' />
		<input type='hidden' name='boxchecked' value='0' />
        <input type="hidden" name="view" value="template" />
		<input type="hidden" name="layout" value="form" />
        <input type="hidden" name="model" value="template" />
        <input type="hidden" name="ret" value="index.php?option=com_jforce" />
        <?php echo JHTML::_('form.token'); ?>
		</form> 
        
<?php /*
echo $this->tabs->endPanel();
echo $this->tabs->endPane();
*/
?>