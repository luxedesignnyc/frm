<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			general.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<form action='index.php' method='post' name='adminForm'>
<div id='cpanel'>
	<div class='jfAdminTitle'><?php echo JText::_('General Configuration'); ?></div>
</div>
		
<?php
echo $this->tabs->startPane('pane');
echo $this->tabs->startPanel('General', 'general');
?>
<fieldset class="adminform">
    	<legend><?php echo JText::_('Settings'); ?></legend>
				<table class="admintable">
				<tbody>
		           <tr> 
                        <td class='key'>
                            <label for='currency'><?php echo JText::_('Show Help Text'); ?></label>
                        </td>
                        <td>
                            <?php echo $this->lists['showhelp'];?>
                        </td>
                   </tr>
				   <tr> 
                        <td class='key'>
                            <label for='repository_path'><?php echo JText::_('Document Path'); ?></label>
                        </td>
                        <td>
                            <input type='text' name='repository_path' size='35' class='inputbox' value='<?php echo $this->repository_path;?>' />
                        </td>
                   </tr>
                  <!-- <tr> 
                        <td class='key'>
                            <label for='currency'><?php echo JText::_('Enable Tax'); ?></label>
                        </td>
                        <td>
                            <?php echo $this->lists['taxenabled'];?>
                        </td>
                   </tr> -->
                   <tr> 
                        <td class='key'>
                            <label for='currency'><?php echo JText::_('Currency'); ?></label>
                        </td>
                        <td>
                            <?php echo $this->lists['currency'];?>
                        </td>
                   </tr>
                   <tr>
                        <td class='key' valign="top">
                            <?php echo JText::_('Tax Rates'); ?>
                        </td>
                        <td id="taxHolder"><a href="#" id="addTaxValue"><?php echo JText::_('Add Tax');?></a><br />
                            <?php for ($i=0; $i<count($this->tax); $i++) : ?>
                                <input type='text' name='tax[]' size='35' class='inputbox separate' value='<?php echo $this->tax[$i];?>' />
                            <?php endfor; ?>
                        </td>
					</tr>
            </tbody>
            </table>                                                            
</fieldset>
<fieldset class="adminform">
    	<legend><?php echo JText::_('Owner Company'); ?></legend>
				<table class="admintable">
				<tbody>
		           <tr> 
    	            <td class='key'>
    			        <label for='name'><?php echo JText::_('Name'); ?></label>
        		    </td>
                	<td>
            			<input type='text' name='company[name]' class='inputbox' value='<?php echo $this->company->name; ?>' class='required' />
            		</td>
                   </tr>
                <tr>
                    <td class='key'>
                    <label for='address'><?php echo JText::_('Address'); ?></label>
                    </td>
                    <td>
                    <input type='text' name='company[address]' class='inputbox' value='<?php echo $this->company->address; ?>' class='required' />
                    </td>
                </tr>
                <tr>
                    <td class='key'>
                    <label for='phone'><?php echo JText::_('Phone'); ?></label>
                    </td>
                    <td>
                    <input type='text' name='company[phone]' class='inputbox' value='<?php echo $this->company->phone; ?>' class='required' />
                    </td>
                </tr>
                <tr>
                    <td class='key'>
                    <label for='fax'><?php echo JText::_('Fax'); ?></label>
                    </td>
                    <td>
                    <input type='text' name='company[fax]' class='inputbox' value='<?php echo $this->company->fax; ?>' class='required' />
                    </td>
                </tr>
                <tr>
                    <td class='key'>
                    <label for='homepage'><?php echo JText::_('Homepage'); ?></label>
                    </td>
                    <td>
                    <input type='text' name='company[homepage]' class='inputbox' value='<?php echo $this->company->homepage; ?>' class='required' />
                    </td>
                  </tr>
            </tbody>
            </table>                                                            
</fieldset>
	<fieldset class="adminform">
    	<legend><?php echo JText::_('General Categories'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="discussioncategoriesHolder"><a href="#" id="addDiscussionValue"><?php echo JText::_('Add Category');?></a><br />
                    <?php for ($i=0; $i<count($this->discussion); $i++) : ?>
						<input type='text' name='generalcategories[]' size='35' class='inputbox separate' value='<?php echo $this->discussion[$i];?>' />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
	</fieldset>	
<?php 
echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Tickets', 'tickets')
?>
    <fieldset class="adminform">
    	<legend><?php echo JText::_('Ticket Categories'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="supportcategoriesHolder"><a href="#" id="addSupportValue"><?php echo JText::_('Add Category');?></a><br />
                    <?php for ($i=0; $i<count($this->support); $i++) : ?>
						<input type='text' name='supportcategories[]' size='35' class='inputbox separate' value='<?php echo $this->support[$i];?>' />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
	</fieldset>
<?php 
echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Campaigns', 'campaigns')
?>
    <fieldset class="adminform">
    	<legend><?php echo JText::_('Campaign Categories'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="campaigncategoriesHolder"><a href="#" id="addCampaignValue"><?php echo JText::_('Add Category');?></a><br />
                    <?php for ($i=0; $i<count($this->campaign); $i++) : ?>
						<input type='text' name='campaigncategories[]' size='35' class='inputbox separate' value='<?php echo $this->campaign[$i];?>' />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
	</fieldset>	
<?php

echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Events', 'events');

?>
	<fieldset class="adminform">
    	<legend><?php echo JText::_('Event Priority Options'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="event_priorityHolder"><a href="#" id="addEventPriorityValue"><?php echo JText::_('Add Type');?></a><br />
                    <?php for ($i=0; $i<count($this->event_priority); $i++) : ?>
						<input type='text' name='event_priority[]' size='35' class='inputbox separate' value='<?php echo $this->event_priority[$i];?>' />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
	</fieldset>	
	<fieldset class="adminform">
    	<legend><?php echo JText::_('Event Status Options'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="event_statusHolder"><a href="#" id="addEventStatusValue"><?php echo JText::_('Add Type');?></a><br />
                    <?php for ($i=0; $i<count($this->event_status); $i++) : ?>
						<input type='text' name='event_status[]' size='35' class='inputbox separate' value='<?php echo $this->event_status[$i];?>' />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
	</fieldset>	
    <fieldset class="adminform">
    	<legend><?php echo JText::_('Event Types'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="event_typeHolder"><a href="#" id="addEventTypeValue"><?php echo JText::_('Add Type');?></a><br />
                    <?php for ($i=0; $i<count($this->event); $i++) : ?>
						<input type='text' name='event_type[]' size='35' class='inputbox separate' value='<?php echo $this->event[$i];?>' />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
	</fieldset>	
<?php
echo $this->tabs->endPanel();
echo $this->tabs->endPane();
?>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='ret' value='index.php?option=com_jforce' />
<input type="hidden" name="c" value="configuration" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="" />
<input type="hidden" name="layout" value="" />
<input type='hidden' name='company[id]' value='<?php echo $this->company->id;?>' />

<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	