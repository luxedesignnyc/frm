function submitbutton(pressbutton) {
	var form = document.adminForm;
	switch(pressbutton) {
	
		case 'default':
			form.view.value = form.c.value;
			form.layout.value = 'default';
		break;
		
		case 'new':
			if(form.view.value=='') {
				form.view.value = form.c.value;
			}
			form.boxchecked.value=0;
			form.layout.value = 'form';
		break;
		
		case 'edit':
			if(form.view.value=='') {
				form.view.value = form.c.value;
			}
			form.layout.value = 'form';
		break;
		
		default:
			form.task.value = pressbutton;
		break;
		
	}
	
	submitform(pressbutton);
}

function toggleValueRow() {

	var type = $('fieldtype').value;

	var row = $('valueRow');
	var required = $('requiredRow');

	if (type == 'textbox' || type == 'textarea') {
		row.setStyle('display', 'none');
	} else {
		row.setStyle('display', 'table-row');
	}

	if (type == 'checkbox') {
		required.setStyle('display', 'none');	
	} else {
		required.setStyle('display','table-row');
	}

}

function createValueField(type) {
	if(!type){
		var type = 'values';
	}
	var valueField = new Element('input', {
			'type'		:	'text',
			'name'		:	type+'[]', 
			'size'		:	'35',
			'class'		:	'inputbox separate'
		});
	
	$(type+'Holder').appendChild(valueField);
}
function validateWeighting() {
	
	var msg = '';
	var numeric = true;
	var leadTotal = 0;
	var ticketTotal = 0;
	
	$$('#leadTable input[type=text]').each(function(el) {
		var string = el.value;
		var number = Number(el.value);
		
		if (string != number || number < 0) {
			numeric = false;	
		}
		
		leadTotal += number;
		
	});

	if (leadTotal != 100) {
		msg += 'Lead percentages must add up to 100%\n';
	}
	
	$$('#ticketTable input[type=text]').each(function(el) {
		var string = el.value;
		var number = Number(el.value);
		
		if (string != number || number < 0) {
			numeric = false;	
		}
		
		ticketTotal += number;
		
	});

	if (ticketTotal != 100) {
		msg += 'Ticket percentages must add up to 100%\n';
	}
	
	
	if (!numeric) {
		msg += 'All values must be numeric and positive\n';	
	}
	
	if (msg != '') {
		alert(msg);
		return false;
	}
	
	return true;
	
}

function listVariables(type) {
	var url = 'index.php?format=raw&option=com_jforce&c=configuration&task=buildVariableList';
	var postData = 'type='+type;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			$('variablesHolder').setHTML(response);
		}
	}).request(postData);
	
}

function buildTriggers() {
	var url = 'index.php?format=raw&option=com_jforce&c=configuration&task=buildTriggers';
	var postData = 'cat='+$('cat').value;
	new Ajax(url, {
		method: 'post',
		onSuccess: function(response) {
			$('triggers').setHTML(response);
		}
	}).request(postData);	
}

function getProjectWeights(project) {
	var url = 'index.php?format=raw&option=com_jforce&c=configuration&view=weighting&layout=project&pid='+project;
	var updateDiv = $('projectWeights');
	new Ajax(url, {
		method: 'get',
		update: updateDiv
	}).request();
	
}

function addContainer(buttonId) {
	var split = buttonId.split("_");
	var type = split[0];
	var holder = $(type+'Holder');

	var existing = $$('.'+type+'Container');

	var newContainer = existing[0].clone();
	
	newContainer.setStyle('opacity', '0');
	
	var deleteButton = newContainer.getElement('img');
	deleteButton.setStyle('display', 'inline');
	
	deleteButton.removeEvents('click');
	deleteButton.addEvent('click', function(e) {
		e = new Event(e).stop();
		deleteContainer(this);	
	});
	
	var inputs = newContainer.getElementsByTagName('*');
	for(var i=0; i<inputs.length; i++) {
		var el = $(inputs[i]);
		
		if (el.tagName != 'OPTION') {
			if (el.getProperty('value')) {
				el.removeProperty('value');
			}
			if (el.getProperty('id')) {
				el.setProperty('id', '');
			}
			if (el.className) {
				if (el.hasClass('milestone_name')) {
					el.removeEvents('change');
					el.addEvent('change', function(){
						populateMilestoneSelects();
					});
				}
			}
			if (el.className) {
				if (el.hasClass('addTask')) {
					el.removeEvents('click');
					el.addEvent('click', function(e){
						e = new Event(e).stop();
						addTask(this);
					});
				}
			}
			if (el.className && el.hasClass('deleteTask')) {
				el.removeEvents('click');
				el.addEvent('click', function(e) {
					e = new Event(e).stop();
					deleteTask(this);
				});
			}
		}
	}

	

	holder.appendChild(newContainer);
	
	if (type == 'checklist') {
		updateTaskNames();
	}
	
	new Fx.Style(newContainer, 'opacity', {duration: 300} ).start(1);
	
}

function deleteContainer(button) {
	button = $(button);
	var holder = button.getParent();
	var toDelete = holder.getParent();
	
	var toDeleteParent = toDelete.getParent();
	
	var container = toDeleteParent.getParent().getProperty('id');
	
	var count = $$('#'+container+' .deleteButton').length;

	// Clear first container //
	if (count == 1) {
		
		var inputs = toDelete.getElementsByTagName('*');
		for(var i=0; i<inputs.length; i++) {
			var el = $(inputs[i]);
			if (el.getProperty('value')) {
				el.setProperty('value', '');
			}
		}
		
	} else {
		// Delete container > first //
		if (toDelete) {
			var fx = toDelete.effects({duration: 300});
			fx.start ({
				opacity: 1
			}).chain(function() {
				fx.start.delay(0, fx, {
					opacity: 0
				});
			}).chain(function() {
				fx.start ({
					opacity: 0,
					width: 0,
					height: 0
				});
			}).chain(function() {
				toDeleteParent.removeChild(toDelete);
				if(container == 'checklistHolder') {
					updateTaskNames();
				}
			});
		}
	}
	
	
	
}
function updateTaskNames(){
	
	var taskHolders = $$('td.taskHolder');

	for(var i=0; i<taskHolders.length; i++) {
		holder = $(taskHolders[i]);
		var inputs = holder.getElementsByTagName('input');
		for (var k=0; k<inputs.length; k++) {
			var input = $(inputs[k]);
			input.name = 'tasks['+i+'][summary][]';
		}
		
		var selects = holder.getElementsByTagName('select');
		for (var k=0; k<selects.length; k++) {
			var select = $(selects[k]);
			select.name = 'tasks['+i+'][priority][]';
		}
	}

	

}

function in_array(needle, haystack) {
	var pass = false;
	
	for (var i=0; i<haystack.length; i++) {
		if(haystack[i] == needle) {
			pass = true;	
		}
	}
	
	return pass;

}

function initMilestones() {
	$$('input.milestone_name').addEvent('change', function() {
		populateMilestoneSelects();
	});
}

function populateMilestoneSelects() {
	var milestones = new Array();
	$$('input.milestone_name').each(function(el) {
		var value = el.getProperty('value');
		if (value) {
			milestones.push(value.toString());
		}
	});
	
	var selects = $$('select.milestone_select');
	
	for (var i=0; i<selects.length; i++) {
		var select = $(selects[i]);
		updateOptions(select, milestones);
	}
	
}

function updateOptions(select, milestoneList) {
	
	var optionList 	= select.options;
	var values 		= new Array();
	var toRemove 	= new Array();
	var selected 	= false;
	
	for (var i = 0; i<optionList.length; i++) {
		var option = $(optionList[i]);
		var value = option.getAttribute('value');
		if (value != "") {
			if (!in_array(value, milestoneList)) {
				if (option.selected == true) {
					selected = true;
				}
				toRemove.push(option);
			} else {
				values.push(value.toString());	
			}
		}
	}
	
	for(var i=0; i<toRemove.length; i++) {
		var option = toRemove[i];
		select.removeChild(option);
	}
	
	for (var i=0; i<milestoneList.length; i++) {
		var milestone = milestoneList[i];
		
		if (!in_array(milestone, values)) {
			var newOption = createOption(milestone, selected);
			select.appendChild(newOption);
		}
	}
	
}

function createOption(milestone, selected) {
	
	var option = new Element('option', {
			'value'		:	milestone,
			'selected'	:	selected
		});
		
	option.innerHTML = milestone;
	return option;
}

function addTask(button) {
	button = $(button);
	var holder = button.getParent().getNext();
	
	var taskHolder = holder.getElement('.newTask');
	
	if (taskHolder.getStyle('display') == 'none') {
		taskHolder.setStyle('display', 'block');
	}
	else {
	
		var newTask = taskHolder.clone();
		var deleteButton = newTask.getElement('img');
		deleteButton.removeEvents('click');
		deleteButton.addEvent('click', function(e){
			e = new Event(e).stop();
			deleteTask(this);
		});
		
		var inputs = newTask.getElementsByTagName('*');
		
		for (var k = 0; k < inputs.length; k++) {
			var input = $(inputs[k]);
			if (input.tagName != 'OPTION') {
				if (input.getProperty('value')) {
					input.setProperty('value', '');
				}
				if(input.getProperty('id')) {
					input.setProperty('id', '');
				}
			}
		}
		
		holder.appendChild(newTask);
	}
}

function deleteTask(button) {

	var holder = button.getParent();
	var container = holder.getParent();
	
	var tasks = container.getElementsByTagName('input');

	if (tasks.length == 1) {
		var input1 = holder.getElement('input');
		var input2 = holder.getElement('select');
		input1.setProperty('value', '');
		input2.setProperty('value', '');
		holder.setStyle('display', 'none');
	} else {
		container.removeChild(holder);
	}
	
}
