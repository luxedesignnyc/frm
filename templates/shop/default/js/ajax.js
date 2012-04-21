/*BEGIN: Get Product Shop*/
function getProduct(type, div, box, token, shop, style, baseUrl)
{
	$("#" + div).html('<img src="' + baseUrl + 'templates/shop/' + style + '/images/loading.gif" class="loading_image" />');
	$.ajax({
			   type: "POST",
			   url: baseUrl + "shop/ajax",
			   data: "type=" + type + "&link=" + shop + "&token=" + token,
			   dataType: "json",
			   success: function(data){
				   						if(data[1] > 0)
										{
											str = '';
											for(i = 0; i < data[1]; i++)
											{
												str += '<div class="showbox_1" id="' + box + i + '" onmouseover="ChangeStyleBox(\'' + box + i + '\',1)" onmouseout="ChangeStyleBox(\'' + box + i + '\',2)">';
												str += '<a class="menu_1" href="' + baseUrl + shop + '/product/detail/' + data[0][i].pro_id + '" title="' + data[0][i].pro_descr + '">';
												str += '<img src="' + baseUrl + 'media/images/product/' + data[0][i].pro_dir + '/' + showThumbnail(data[0][i].pro_id, data[0][i].pro_image, 2) + '" class="image_showbox_1" />';
												str += '<div class="name_showbox_1">';
												str += '<span id="DivName_' + box + i + '"></span>';
												str += '</div></a><div class="cost_showbox">';
												str += '<span id="DivCost_' + box + i + '"></span>&nbsp;' + data[0][i].pro_currency;
												str += '</div></div>';
												str += '<script>subStr("' + data[0][i].pro_name + '", 30, "DivName_' + box + i + '");</script>';
												str += '<script>FormatCost("' + data[0][i].pro_cost + '", "DivCost_' + box + i + '");</script>';
												$("#" + div).html(str);
											}
										}
										else
										{
											if(type == 3)
											{
												document.getElementById('TableSaleoff').style.display = "none";
											}
											else
											{
												alert("No Data!");
											}
										}
			   						  },
			   error: function(){}
		 	});
}
/*END Get Product Shop*/