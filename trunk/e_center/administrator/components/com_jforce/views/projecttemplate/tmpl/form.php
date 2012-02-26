<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			form.php														*
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
echo $this->tabs->startPanel('General', 'generalTab');
?>
	<div class='jfAdminTitle'><?php echo $this->title; ?></div>
	<fieldset class="adminform">
    	<legend><?php echo JText::_('Details'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
			<tr>
				<td class='key'>
					<?php echo JText::_('Name'); ?></td><td>
					<input type='text' name="name" size='35' class='inputbox' value="<?php echo $this->template->name;?>" />
				</td>
			</tr>                      
            <tr>
				<td class='key' valign="top"><?php echo JText::_('Description'); ?></td>
				<td><?php echo $this->editor->display( 'description',  $this->template->description , '100%', '200', '150', '20' ) ; ?></td>                
			</tr>
		</table>
	</fieldset>
<?php
echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Milestones', 'milestoneTab');
?>
<div class='jfAdminTitle'>
	<span class="areaTitle"><?php echo JText::_('Milestones'); ?></span>
	<span class="addButtonHolder"><a href="#" id="milestone_add" class="addButton"><?php echo JText::_('Add Milestone');?></a></span>
</div>
<div id="milestoneHolder">
<?php for ($i=0; $i<count($this->milestones); $i++) : 
	$milestone = $this->milestones[$i];
?>

<div class="milestoneContainer">
	<fieldset class="adminform">
    	<legend><img src="images/publish_x.png" align="top" class="deleteButton" id="milestone_deleteButton_<?php echo $i;?>"/><?php echo JText::_('Milestone Details'); ?></legend>

		<table cellpadding="0" cellspacing="0" class='admintable'>
	    	<tr>
	        	<td class='key'><?php echo JText::_('Summary'); ?></td>			
			    <td><input type='text' name='milestone[summary][]' size='50' class='inputbox milestone_name' value='<?php echo $milestone->summary;?>' /></td>
				<td class="key"><?php echo JText::_('Start Date'); ?></td>	
		        <td><input type='text' name='milestone[startdate][]' size='5' class='inputbox' value='<?php echo $milestone->startdate;?>' />&nbsp;
				<?php echo JText::_('days from project start'); ?>
				</td>
			</tr>
			<tr>
				<td class="key"><?php echo JText::_('Priority'); ?></td>	
		        <td><?php echo $milestone->priorityList;?></td>
				
				<td class="key"><?php echo JText::_('Due Date'); ?></td>			
		        <td><input type='text' name='milestone[duedate][]' size='5' class='inputbox' value='<?php echo $milestone->duedate;?>' />&nbsp;
				<?php echo JText::_('days from project start'); ?>
				</td>
	        </tr>
			<tr>
				<td class='key'><?php echo JText::_('Tags'); ?></td>			
			    <td><input type='text' name='milestone[tags][]' size='50' class='inputbox' value='<?php echo $milestone->tags;?>' /></td>
				<td class="key">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="key" valign="top"><?php echo JText::_('Notes'); ?></td>
				<td><textarea name='milestone[notes][]' cols='45' rows='5'><?php echo $milestone->notes;?></textarea></td>
				<td class="key">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
</fieldset>
</div>


<?php endfor; ?>
</div>

<?php
echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Checklists', 'checklistTab');
?>
<div class='jfAdminTitle'>
	<span class="areaTitle"><?php echo JText::_('Checklists'); ?></span>
	<span class="addButtonHolder"><a href="#" id="checklist_add" class="addButton"><?php echo JText::_('Add Checklists');?></a></span>
</div>
<div id="checklistHolder">
<?php for ($i=0; $i<count($this->checklists); $i++) : 
	$checklist = $this->checklists[$i];
?>

<div class="checklistContainer">
	<fieldset class="adminform">
    	<legend><img src="images/publish_x.png" align="top" class="deleteButton" id="checklist_deleteButton_<?php echo $i;?>"/><?php echo JText::_('Checklist Details'); ?></legend>

		<table cellpadding="0" cellspacing="0" class='admintable'>
	    	<tr>
	        	<td class='key'><?php echo JText::_('Summary'); ?></td>			
			    <td><input type='text' name='checklist[summary][]' size='50' class='inputbox' value='<?php echo $checklist->summary;?>' /></td>
				<td class="key" valign="top"><?php echo JText::_('Milestone'); ?></td>			
		        <td><?php echo $checklist->milestoneList; ?></td>
			</tr>
			<tr>
				<td class="key" valign="top"><?php echo JText::_('Visibility'); ?></td>	
		        <td><?php echo $checklist->visibilityList;?></td>
				<td class='key'><?php echo JText::_('Tags'); ?></td>			
			    <td><input type='text' name='checklist[tags][]' size='35' class='inputbox' value='<?php echo $checklist->tags;?>' /></td>
	        </tr>
			<tr>
				<td class="key" valign="top"><?php echo JText::_('Description'); ?></td>
				<td><textarea name='checklist[description][]' cols='45' rows='5'><?php echo $checklist->description;?></textarea></td>
				<td class="key" valign="top">
					<?php echo JText::_('Tasks'); ?>
					<br />
					<a href="#" class="addTask"><?php echo JText::_('Add Task');?></a>
				</td>
				<td valign="top" class="taskHolder">
					<?php for ($k=0; $k<count($checklist->tasks); $k++) : 
						$task = $checklist->tasks[$k];
					?>
						<div class="newTask">
							<input type="text" name="tasks[<?php echo $i; ?>][summary][]" class="inputbox" value="<?php echo $task->summary;?>" />&nbsp;&nbsp;
							<?php echo $task->priorityList; ?>&nbsp;
							<img src="images/publish_x.png" align="top" class="deleteTask" />
						</div>
					<?php endfor; ?>
				</td>
			</tr>
		</table>
</fieldset>

</div>
<?php endfor; ?>
</div>
<?php
echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Discussions', 'discussionTab');
?>
<div class='jfAdminTitle'>
	<span class="areaTitle"><?php echo JText::_('Discussions'); ?></span>
	<span class="addButtonHolder"><a href="#" id="discussion_add" class="addButton"><?php echo JText::_('Add Discussion');?></a></span>
</div>
<div id="discussionHolder">
<?php for ($i=0; $i<count($this->discussions); $i++) : 
	$discussion = $this->discussions[$i];
?>

<div class="discussionContainer">
	<fieldset class="adminform">
    	<legend><img src="images/publish_x.png" align="top" class="deleteButton" id="discussion_deleteButton_<?php echo $i;?>"/><?php echo JText::_('Discussion Details'); ?></legend>

		<table cellpadding="0" cellspacing="0" class='admintable'>
	    	<tr>
	        	<td class='key'><?php echo JText::_('Summary'); ?></td>			
			    <td><input type='text' name='discussion[summary][]' size='50' class='inputbox' value='<?php echo $discussion->summary;?>' /></td>
				<td class="key"><?php echo JText::_('Category'); ?></td>	
		        <td><?php echo $discussion->categoryList; ?></td>
				</td>
			</tr>
			<tr>
				<td class="key" valign="top"><?php echo JText::_('Visibility'); ?></td>	
		        <td><?php echo $discussion->visibilityList;?></td>
				
				<td class="key" valign="top"><?php echo JText::_('Milestone'); ?></td>			
		        <td><?php echo $discussion->milestoneList; ?></td>
	        </tr>
			<tr>
				<td class='key'><?php echo JText::_('Tags'); ?></td>			
			    <td><input type='text' name='discussion[tags][]' size='50' class='inputbox' value='<?php echo $discussion->tags;?>' /></td>
				<td class="key">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="key" valign="top"><?php echo JText::_('Message'); ?></td>
				<td><textarea name='discussion[message][]' cols='45' rows='5'><?php echo $discussion->message;?></textarea></td>
				<td class="key">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
</fieldset>
</div>


<?php endfor; ?>
</div>

<?php
echo $this->tabs->endPanel();
echo $this->tabs->startPanel('Documents', 'documentTab');
?>
<div class='jfAdminTitle'>
	<span class="areaTitle"><?php echo JText::_('Documents'); ?></span>
	<span class="addButtonHolder"><a href="#" id="document_add" class="addButton"><?php echo JText::_('Add Documents');?></a></span>
</div>
<div id="documentHolder">
<?php for ($i=0; $i<count($this->documents); $i++) : 
	$document = $this->documents[$i];
?>

<div class="documentContainer">
	<fieldset class="adminform">
    	<legend><img src="images/publish_x.png" align="top" class="deleteButton" id="document_deleteButton_<?php echo $i;?>"/><?php echo JText::_('Document Details'); ?></legend>

		<table cellpadding="0" cellspacing="0" class='admintable'>
	    	<tr>
	        	<td class='key'><?php echo JText::_('Name'); ?></td>			
			    <td><input type='text' name='document[name][]' size='50' class='inputbox' value='<?php echo $document->name;?>' /></td>
				<td class="key"><?php echo JText::_('Category'); ?></td>	
		        <td><?php echo $document->categoryList; ?></td>
			</tr>
			<tr>
				<td class="key" valign="top"><?php echo JText::_('Visibility'); ?></td>	
		        <td><?php echo $document->visibilityList;?></td>
				
				<td class="key" valign="top"><?php echo JText::_('Milestone'); ?></td>			
		        <td><?php echo $document->milestoneList; ?></td>
	        </tr>
			<tr>
				<td class='key'><?php echo JText::_('Tags'); ?></td>			
			    <td><input type='text' name='document[tags][]' size='50' class='inputbox' value='<?php echo $document->tags;?>' /></td>
				<td class="key"><?php echo JText::_('File'); ?></td>
				<td><?php echo $document->fileList; ?></td>
			</tr>
			<tr>
				<td class="key" valign="top"><?php echo JText::_('Description'); ?></td>
				<td><textarea name='document[description][]' cols='45' rows='5'><?php echo $document->description;?></textarea></td>
				<td class="key">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
</fieldset>
</div>


<?php endfor; ?>
</div>
<?php
echo $this->tabs->endPanel();
echo $this->tabs->endPane();
?>

<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='projecttemplate' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->template->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive');
