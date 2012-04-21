/*BEGIN: Get Product Home*/
function getProduct(type, obj, div, token, baseUrl)
{
	$("#" + div).html('<img src="' + baseUrl + 'templates/home/images/loading.gif" class="loading_image" />');
	$.ajax({
			   type: "POST",
			   url: baseUrl + "ajax",
			   data: "type=" + type + "&object=" + obj + "&token=" + token,
			   dataType: "json",
			   success: function(data){
				   						if(data[1] > 0)
										{
											str = '';
											for(i = 0; i < data[1]; i++)
											{
												str += '<div class="showbox_1" id="DivProductBox_' + i + '" onmouseover="ChangeStyleBox(\'DivProductBox_' + i + '\',1)" onmouseout="ChangeStyleBox(\'DivProductBox_' + i + '\',2)">';
												str += '<a href="' + baseUrl + 'product/category/' + data[0][i].pro_category + '/detail/' + data[0][i].pro_id + '" title="' + data[0][i].pro_descr + '">';
												str += '<img src="' + baseUrl + 'media/images/product/' + data[0][i].pro_dir + '/' + showThumbnail(data[0][i].pro_id, data[0][i].pro_image, 2) + '" class="image_showbox_1" />';
												str += '<div class="name_showbox_1">';
												str += '<span id="DivName_' + i + '"></span>';
												str += '</div></a><div class="cost_showbox">';
												str += '<span id="DivCost_' + i + '"></span>&nbsp;' + data[0][i].pro_currency;
												str += '</div></div>';
												str += '<script>subStr("' + data[0][i].pro_name + '", 30, "DivName_' + i + '");</script>';
												str += '<script>FormatCost("' + data[0][i].pro_cost + '", "DivCost_' + i + '");</script>';
												$("#" + div).html(str);
											}
										}
										else
										{
											alert("No Data!");
										}
			   						  },
			   error: function(){}
		 	});
}
/*END Get Product Home*/
/*BEGIN: Get Reliable Product Home*/
function getReliable(obj, div, token, baseUrl)
{
	$("#" + div).html('<img src="' + baseUrl + 'templates/home/images/loading.gif" class="loading_image" />');
	$.ajax({
			   type: "POST",
			   url: baseUrl + "ajax",
			   data: "object=" + obj + "&token=" + token,
			   dataType: "json",
			   success: function(data){
				   						if(data[1] > 0)
										{
											str = '';
											for(i = 0; i < data[1]; i++)
											{
												str += '<div class="showbox_1" id="DivReliableProductBox_' + i + '" onmouseover="ChangeStyleBox(\'DivReliableProductBox_' + i + '\',1)" onmouseout="ChangeStyleBox(\'DivReliableProductBox_' + i + '\',2)">';
												str += '<a href="' + baseUrl + 'product/category/' + data[0][i].pro_category + '/detail/' + data[0][i].pro_id + '" title="' + data[0][i].pro_descr + '">';
												str += '<img src="' + baseUrl + 'media/images/product/' + data[0][i].pro_dir + '/' + showThumbnail(data[0][i].pro_id, data[0][i].pro_image, 2) + '" class="image_showbox_1" />';
												str += '<div class="name_showbox_1">';
												str += '<span id="DivReliableName_' + i + '"></span>';
												str += '</div></a><div class="cost_showbox">';
												str += '<span id="DivReliableCost_' + i + '"></span>&nbsp;' + data[0][i].pro_currency;
												str += '</div></div>';
												str += '<script>subStr("' + data[0][i].pro_name + '", 30, "DivReliableName_' + i + '");</script>';
												str += '<script>FormatCost("' + data[0][i].pro_cost + '", "DivReliableCost_' + i + '");</script>';
												$("#" + div).html(str);
											}
										}
										else
										{
											alert("No Data!");
										}
			   						  },
			   error: function(){}
		 	});
}
/*END Get Reliable Product Home*/
/*BEGIN: Get Interest Shop Home*/
function getInterestShop(obj, div, token, baseUrl)
{
	$("#" + div).html('<img src="' + baseUrl + 'templates/home/images/loading.gif" class="loading_image_shop" />');
	$.ajax({
			   type: "POST",
			   url: baseUrl + "ajax",
			   data: "object=" + obj + "&token=" + token,
			   dataType: "json",
			   success: function(data){
				   						if(data[1] > 0)
										{
											str = '';
											for(i = 0; i < data[1]; i++)
											{
												str += '<div class="showbox_2" id="DivInterestShopBox_' + i + '" onmouseover="ChangeStyleBox(\'DivInterestShopBox_' + i + '\',1)" onmouseout="ChangeStyleBox(\'DivInterestShopBox_' + i + '\',2)">';
												str += '<table height="91" align="center" border="0" cellpadding="0" cellspacing="0"><tr><td>';
												str += '<a href="' + baseUrl + data[0][i].sho_link + '" title="' + data[0][i].sho_descr + '" target="_blank">';
												str += '<img src="' + baseUrl + 'media/shop/logos/' + data[0][i].sho_dir_logo + '/' + data[0][i].sho_logo + '" class="image_showbox_2" />';
												str += '</a>';
												str += '</td></tr></table></div>';
												$("#" + div).html(str);
											}
										}
										else
										{
											alert("No Data!");
										}
			   						  },
			   error: function(){}
		 	});
}
/*END Get Interest Shop Home*/
/*BEGIN: Ads Home*/
function getAds(type, obj, div, token, baseUrl)
{
    if(type == '1')
	{
        document.getElementById('DivMenuTabAds_1').className = 'menu_3';
        document.getElementById('DivMenuTabAds_2').className = 'menu_3';
        document.getElementById('DivMenuTabAds_3').className = 'menu_3_selected';
	}
	else
	{
        if(type == '2')
		{
	        document.getElementById('DivMenuTabAds_1').className = 'menu_3';
	        document.getElementById('DivMenuTabAds_2').className = 'menu_3_selected';
	        document.getElementById('DivMenuTabAds_3').className = 'menu_3';
		}
		else
		{
            document.getElementById('DivMenuTabAds_1').className = 'menu_3_selected';
            document.getElementById('DivMenuTabAds_2').className = 'menu_3';
	        document.getElementById('DivMenuTabAds_3').className = 'menu_3';
		}
	}
	$("#" + div).html('<img src="' + baseUrl + 'templates/home/images/loading.gif" class="loading_image_ads" />');
	$.ajax({
			   type: "POST",
			   url: baseUrl + "ajax",
			   data: "type=" + type + "&object=" + obj + "&token=" + token,
			   dataType: "json",
			   success: function(data){
				   						if(data[1] > 0)
										{
                                            str = '';
											for(i = 0; i < data[1]; i++)
											{
												str += '<table border="0" width="100%" height="18" cellpadding="0" cellspacing="0"><tr><td width="5" valign="top" style="padding-top:4px;"><img src="' + baseUrl + 'templates/home/images/list_ten.gif" border="0" /></td>';
												str += '<td class="list_2" align="left" valign="top"><a class="menu_1" href="' + baseUrl + 'ads/category/' + data[0][i].ads_category + '/detail/' + data[0][i].ads_id + '" title="' + data[0][i].ads_descr + '">';
												str += '<span id="DivTitleAds_' + i + '"></span>';
												str += '</a>&nbsp;<span class="province_view">(';
												str += data[0][i].pre_name;
												str += ')</span></td></tr></table>';
												str += '<script>subStr("' + data[0][i].ads_title + '", 35, "DivTitleAds_' + i + '");</script>';
												$("#" + div).html(str);
											}
										}
										else
										{
											alert("No Data!");
										}
			   						  },
			   error: function(){}
		 	});
}
/*END Ads Home*/
/*BEGIN: Job Home*/
function getJob(obj, div, token, baseUrl)
{
	$("#" + div).html('<img src="' + baseUrl + 'templates/home/images/loading.gif" class="loading_image_job" />');
	$.ajax({
			   type: "POST",
			   url: baseUrl + "ajax",
			   data: "object=" + obj + "&token=" + token,
			   dataType: "json",
			   success: function(data){
				   						if(data[1] > 0)
										{
											str = '';
											for(i = 0; i < data[1]; i++)
											{
												str += '<table border="0" width="100%" height="18" cellpadding="0" cellspacing="0"><tr><td width="5" valign="top" style="padding-top:4px;"><img src="' + baseUrl + 'templates/home/images/list_ten.gif" border="0" /></td>';
												str += '<td class="list_2" align="left" valign="top"><a class="menu_1" href="' + baseUrl + 'job/field/' + data[0][i].job_field + '/detail/' + data[0][i].job_id + '" title="' + data[0][i].job_jober + '">';
												str += '<span id="DivTitleJob_' + i + '"></span>';
												str += '</a></td></tr></table>';
												str += '<script>subStr("' + data[0][i].job_title + '", 27, "DivTitleJob_' + i + '");</script>';
												$("#" + div).html(str);
											}
										}
										else
										{
											alert("No Data!");
										}
			   						  },
			   error: function(){}
		 	});
}
/*END Job Home*/
/*BEGIN: Set Enddate*/
function setEndDate(id, endDate, type, baseUrl, token)
{
    $.ajax({
			   type: "POST",
			   url: baseUrl + "account/ajax",
			   data: "id=" + id + "&enddate=" + endDate + "&type=" + type + "&token=" + token,
			   success: function(){},
			   error: function(){}
		 	});
}
/*END Set Enddate*/