//BEGIN: TUYEN write functions here
var count = -1;
var catObjRemove = new Array();
function loopSelected(parentId, childId)	{
	var textIdSection = "";
	var selectedArray = new Array();
	var secObj = document.getElementById(parentId);
	var catObj = document.getElementById(childId);
	var i;
	for (i=0; i<secObj.options.length; i++) {
		if (secObj.options[i].selected) {
		  textIdSection = secObj.options[i].value;
		  //selectedArray[count] = selObj.options[i].value;
		  break;
		}
	}
	
	var length = catObj.options.length;	  
	for (i=0; i<count; i++) {
		catObj.options[length + i] = catObjRemove[i];
	}
	count = -1;

	if (textIdSection == "0") {
			return;
	}
	//alert (count);
	
	
	for (i=0; i<catObj.options.length; i++) {
		if (catObj.options[i].id != textIdSection) {
		  //catObj.options[i].style.display = 'none';				  
		  count++;
		  catObjRemove[count] = catObj.options[i];
		  catObj.remove(i);
		  i=-1;
		} else {
			//catObj.options[i].style.display = 'block';				  
			//var newOpt1 = new Option("newText", "newValue");
			//catObj.options[0] = newOpt1;
			//catObj.options[i].selected = true;
		}
	}	  
	
	//txtSelectedValuesObj.value = "TUYEN";
}
//END: TUYEN write functions here