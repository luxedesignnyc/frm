/*BEGIN: Waiting Load Page*/
function WaitingLoadPage()
{
	document.getElementById('DivGlobalSite').style.display = '';
}
/*END Waiting Load Page*/
/*BEGIN: OpenTab*/
function OpenTab(status)
{
	switch (status)
	{
		case 1:
			document.getElementById('DivContentDetail').style.display = "";
			document.getElementById('DivVoteDetail').style.display = "none";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 2:
			document.getElementById('DivContentDetail').style.display = "none";
			document.getElementById('DivVoteDetail').style.display = "";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 3:
			document.getElementById('DivContentDetail').style.display = "none";
			document.getElementById('DivVoteDetail').style.display = "none";
			document.getElementById('DivReplyDetail').style.display = "";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 4:
			if(document.getElementById('DivSendLinkDetail').style.display == "")
			{
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendLinkDetail').style.display = "";
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			break;
		case 5:
			if(document.getElementById('DivSendFailDetail').style.display == "")
			{
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendFailDetail').style.display = "";
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			break;
		default:
			document.getElementById('DivContentDetail').style.display = "";
			document.getElementById('DivVoteDetail').style.display = "none";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
	}
}

function OpenTabAds(status)
{
	switch (status)
	{
		case 1:
			document.getElementById('DivContentDetail').style.display = "";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 2:
			document.getElementById('DivContentDetail').style.display = "none";
			document.getElementById('DivReplyDetail').style.display = "";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
			break;
		case 3:
			if(document.getElementById('DivSendLinkDetail').style.display == "")
			{
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendLinkDetail').style.display = "";
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			break;
		case 4:
			if(document.getElementById('DivSendFailDetail').style.display == "")
			{
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendFailDetail').style.display = "";
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			break;
		default:
			document.getElementById('DivContentDetail').style.display = "";
			document.getElementById('DivReplyDetail').style.display = "none";
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
	}
}

function OpenTabJob(status)
{
	switch (status)
	{
		case 1:
			if(document.getElementById('DivSendLinkDetail').style.display == "")
			{
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendLinkDetail').style.display = "";
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			break;
		case 2:
			if(document.getElementById('DivSendFailDetail').style.display == "")
			{
				document.getElementById('DivSendFailDetail').style.display = "none";
			}
			else
			{
				document.getElementById('DivSendFailDetail').style.display = "";
				document.getElementById('DivSendLinkDetail').style.display = "none";
			}
			break;
		default:
			document.getElementById('DivSendLinkDetail').style.display = "none";
			document.getElementById('DivSendFailDetail').style.display = "none";
	}
}
/*END OpenTab*/
/*BEGIN: Change Style*/
function ChangeStyle(div,action)
{
	switch (action)
	{
		case 1:
			document.getElementById(div).style.border = "1px #2F97FF solid";
			break;
		case 2:
			document.getElementById(div).style.border = "1px #CCC solid";
			break;
		default:
			document.getElementById(div).style.border = "1px #2F97FF solid";	
	}
}
/*END Change Style*/
/*BEGIN: Kiem Tra TextBox Co Rong*/
function TrimInput(sString)
{
	while(sString.substring(0,1) == ' ')
	{
		sString = sString.substring(1, sString.length);
	}
	while(sString.substring(sString.length-1, sString.length) == ' ')
	{
		sString = sString.substring(0,sString.length-1);
	}
	return sString;
}

function CheckBlank(str)
{
	if(TrimInput(str) == '')
		return true;//Neu chua nhap
	else
		return false;//Neu da nhap
}	
/*END Kiem Tra TextBox Co Rong*/
/*BEGIN: Is Number*/
function IsNumber(number)
{
	var str="0123456789";
	for(var i=0;i<number.length;i++)
	{
		if(str.indexOf(number.charAt(i)) == -1)
		{
			return false;
		}
	}
	return true;//Dung la so
}
/*END Is Number*/
/*BEGIN: Check Phone*/
function CheckPhone(number)
{
	if(number.length < 5 || number.length > 16)
	{
		return false;
	}
	else
	{
		var str="0123456789.()";
		for(var i=0;i<number.length;i++)
		{
			if(str.indexOf(number.charAt(i)) == -1)
			{
				return false;
			}
		}
	}
	return true;//Dung so dien thoai
}
/*END Check Phone*/
/*BEGIN: Check Character*/
function CheckCharacter(char)
{
	var str="0123456789abcdefghikjlmnopqrstuvwxyszABCDEFGHIKJLMNOPQRSTUVWXYSZ-_";
	for(var i=0;i<char.length;i++)
	{
		if(str.indexOf(char.charAt(i)) == -1)
		{
			return false;
		}
	}
	return true;//Dung la ky tu cho phep
}
/*END Check Character*/
/*BEGIN: Check Link*/
function CheckLink(char)
{
	var str="0123456789abcdefghikjlmnopqrstuvwxysz-_";
	for(var i=0;i<char.length;i++)
	{
		if(str.indexOf(char.charAt(i)) == -1)
		{
			return false;
		}
	}
	return true;//Dung la ky tu cho phep
}
/*END Check Link*/
/*BEGIN: Check Website*/
function CheckWebsite(char)
{
	var str="0123456789abcdefghikjlmnopqrstuvwxysz/.:-_";
	for(var i=0;i<char.length;i++)
	{
		if(str.indexOf(char.charAt(i)) == -1)
		{
			return false;
		}
	}
	return true;//Dung la ky tu cho phep
}
/*END Check Website*/
/*BEGIN: Kiem Tra Ngay - Neu Hop Le Tra Ve true*/
function CheckDate(isday,ismonth,isyear)
{
   	var vdate = new Date();
   	var vday = vdate.getDate();
   	var vmonth = vdate.getMonth();
   	var vyear = vdate.getFullYear();
	vmonth = vmonth + 1;
	isday = isday*1;
	ismonth = ismonth*1;
	isyear = isyear*1;
	if(isyear > vyear)
	{
		return true;//Hop le
	}
	if(isyear == vyear)
	{
		if(ismonth > vmonth)
		{
			return true;//Hop le
		}
		if(ismonth == vmonth)
		{
			if(isday > vday)
			{
				return true;//Hop le
			}
			else
			{
				return false;//Khong hop le
			}
		}
		else
		{
			return false;//Khong hop le
		}
	}
	else
	{
		return false;//Khong hop le
	}
}
/*END Kiem Tra Ngay*/
/*BEGIN: So Sanh Ngay*/
function CompareDate(isday,ismonth,isyear,vday,vmonth,vyear)
{
	isday = isday*1;
	ismonth = ismonth*1;
	isyear = isyear*1;
	vday = vday*1;
	vmonth = vmonth*1;
	vyear = vyear*1;
	if(isyear < vyear)
	{
		return true;//Neu nam sau > nam dau
	}
	if(isyear == vyear)
	{
		if(ismonth < vmonth)
		{
			return true;//Neu thang sau > thang dau
		}
		if(ismonth == vmonth)
		{
			if(isday <= vday)
			{
				return true;//Neu ngay sau lon hon ngay dau
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
/*END So Sanh Ngay*/
/*BEGIN: Check Input*/
function CheckInput_SendLink()
{
	if(CheckBlank(document.getElementById('sender_sendlink').value))
	{
		alert("Bạn chưa nhập email người gởi!");
		document.getElementById('sender_sendlink').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('sender_sendlink').value))
	{
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('sender_sendlink').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('receiver_sendlink').value))
	{
		alert("Bạn chưa nhập email người nhận!");
		document.getElementById('receiver_sendlink').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('receiver_sendlink').value))
	{
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('receiver_sendlink').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('title_sendlink').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_sendlink').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('content_sendlink').value))
	{
		alert("Bạn chưa nhập lời nhắn!");
		document.getElementById('content_sendlink').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_sendlink').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_sendlink').focus();
		return false;
	}
	document.frmSendLink.submit();
}

function CheckInput_SendFail(status)
{
	if(status == '1')
	{
		if(CheckBlank(document.getElementById('sender_sendfail').value))
		{
			alert("Bạn chưa nhập email người gởi!");
			document.getElementById('sender_sendfail').focus();
			return false;
		}
		if(!CheckEmail(document.getElementById('sender_sendfail').value))
		{
			alert("Email bạn nhập không hợp lệ!");
			document.getElementById('sender_sendfail').focus();
			return false;
		}
		
		if(CheckBlank(document.getElementById('title_sendfail').value))
		{
			alert("Bạn chưa nhập tiêu đề!");
			document.getElementById('title_sendfail').focus();
			return false;
		}
		
		if(CheckBlank(document.getElementById('content_sendfail').value))
		{
			alert("Bạn chưa nhập nội dung!");
			document.getElementById('content_sendfail').focus();
			return false;
		}
		
		if(CheckBlank(document.getElementById('captcha_sendfail').value))
		{
			alert("Bạn chưa nhập mã xác nhận!");
			document.getElementById('captcha_sendfail').focus();
			return false;
		}
		document.frmSendFail.submit();
	}
	else
	{
		alert(status);
		return false;
	}
}

function CheckInput_Reply(status)
{
	if(status == '1')
	{
		if(CheckBlank(document.getElementById('title_reply').value))
		{
			alert("Bạn chưa nhập tiêu đề!");
			document.getElementById('title_reply').focus();
			return false;
		}
		
		if(CheckBlank(document.getElementById('content_reply').value))
		{
			alert("Bạn chưa nhập nội dung!");
			document.getElementById('content_reply').focus();
			return false;
		}
		
		if(CheckBlank(document.getElementById('captcha_reply').value))
		{
			alert("Bạn chưa nhập mã xác nhận!");
			document.getElementById('captcha_reply').focus();
			return false;
		}
		document.frmReply.submit();
	}
	else
	{
		alert(status);
		return false;
	}
}

function CheckInput_PostPro()
{
	 if(CheckBlank(document.getElementById('name_pro').value))
	 {
		alert("Bạn chưa nhập tên sản phẩm!");
		document.getElementById('name_pro').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('descr_pro').value))
	 {
		alert("Bạn chưa nhập mô tả!");
		document.getElementById('descr_pro').focus();
		return false;
	 }
	 
	 if(document.getElementById('nonecost_pro').checked == false)
	 {
		 if(CheckBlank(document.getElementById('cost_pro').value))
		 {
			alert("Bạn chưa nhập giá sản phẩm!");
			document.getElementById('cost_pro').focus();
			return false;
		 }
		 if(!IsNumber(document.getElementById('cost_pro').value))
		 {
			alert("Giá bán bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
			document.getElementById('cost_pro').focus();
			return false;
		 }
		 if(document.getElementById('cost_pro').value == "0")
		 {
			alert("Giá bán không được bằng 0!\nBạn có thể chọn Không có giá.");
			document.getElementById('cost_pro').focus();
			return false;
		 }
	 }
	 
	 if(!CheckDate(document.getElementById('day_pro').value,document.getElementById('month_pro').value,document.getElementById('year_pro').value))
	 {
		 alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("Bạn chưa nhập chi tiết sản phẩm!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('fullname_pro').value))
	 {
		alert("Bạn chưa nhập người đăng sản phẩm!");
		document.getElementById('fullname_pro').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_pro').value))
	 {
		alert("Bạn chưa nhập địa chỉ liên hệ!");
		document.getElementById('address_pro').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_pro').value))
	 {
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('phone_pro').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_pro').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_pro').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_pro').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_pro').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_pro').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_pro').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('email_pro').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_pro').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_pro').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_pro').value))
	 {
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_pro').focus();
		return false;
	 }
	 document.frmPostPro.submit();
}

function CheckInput_PostAds()
{
	 if(CheckBlank(document.getElementById('title_ads').value))
	 {
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_ads').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('descr_ads').value))
	 {
		alert("Bạn chưa nhập mô tả!");
		document.getElementById('descr_ads').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('day_ads').value,document.getElementById('month_ads').value,document.getElementById('year_ads').value))
	 {
		 alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("Bạn chưa nhập chi tiết rao vặt!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('fullname_ads').value))
	 {
		alert("Bạn chưa nhập người đăng rao vặt!");
		document.getElementById('fullname_ads').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_ads').value))
	 {
		alert("Bạn chưa nhập địa chỉ liên hệ!");
		document.getElementById('address_ads').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_ads').value))
	 {
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('address_ads').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_ads').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_ads').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_ads').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_ads').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_ads').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_ads').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('email_ads').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_ads').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_ads').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_ads').value))
	 {
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_ads').focus();
		return false;
	 }
	 document.frmPostAds.submit();
}

function CheckInput_PostJob()
{
	 if(CheckBlank(document.getElementById('title_job').value))
	 {
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('position_job').value))
	 {
		alert("Bạn chưa nhập vị trí tuyển dụng!");
		document.getElementById('position_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('level_job').value))
	 {
		alert("Bạn chưa nhập trình độ!");
		document.getElementById('level_job').focus();
		return false;
	 }
	 
	 if(document.getElementById('age1_job').value > document.getElementById('age2_job').value)
	 {
		 alert("Bạn chọn tuổi không hợp lệ!\nVí dụ: Tuổi từ 18 đến 25.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('require_job').value))
	 {
		alert("Bạn chưa nhập yêu cầu công việc!");
		document.getElementById('require_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('salary_job').value))
	 {
		alert("Bạn chưa nhập mức lương khởi điểm!");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('salary_job').value))
	 {
		alert("Mức lương khởi điểm bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 if(document.getElementById('salary_job').value == "0")
	 {
		alert("Mức lương khởi điểm không được bằng 0!");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('try_job').value))
	 {
		alert("Bạn chưa nhập thời gian thử việc!");
		document.getElementById('try_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('try_job').value))
	 {
		alert("Thời gian thử việc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		document.getElementById('try_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('interest_job').value))
	 {
		alert("Bạn chưa nhập quyền lợi!");
		document.getElementById('interest_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('quantity_job').value))
	 {
		alert("Bạn chưa nhập số lượng tuyển dụng!");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('quantity_job').value))
	 {
		alert("Số lượng tuyển dụng bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 if(document.getElementById('quantity_job').value == "0")
	 {
		alert("Số lượng tuyển dụng không được bằng 0!");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('record_job').value))
	 {
		alert("Bạn chưa nhập hồ sơ xin việc!");
		document.getElementById('record_job').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('day_job').value,document.getElementById('month_job').value,document.getElementById('year_job').value))
	 {
		 alert("Thời gian nộp hồ sơ không hợp lệ!\nThời gian nộp hồ sơ phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("Bạn chưa nhập chi tiết tin tuyển dụng!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('name_job').value))
	 {
		alert("Bạn chưa nhập tên nhà tuyển dụng!");
		document.getElementById('name_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_job').value))
	 {
		alert("Bạn chưa nhập địa chỉ nhà tuyển dụng!");
		document.getElementById('address_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_job').value))
	 {
		alert("Bạn chưa nhập số điện thoại nhà tuyển dụng!");
		document.getElementById('phone_job').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_job').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_job').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_job').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_job').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_job').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_job').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('email_job').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_job').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_job').focus();
		return false;
	 }
	 
	 if(!CheckWebsite(document.getElementById('website_job').value))
	 {
		alert("Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -");
		document.getElementById('website_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('namecontact_job').value))
	 {
		alert("Bạn chưa nhập tên người đại diện!");
		document.getElementById('namecontact_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('addresscontact_job').value))
	 {
		alert("Bạn chưa nhập địa chỉ liên hệ!");
		document.getElementById('addresscontact_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phonecontact_job').value))
	 {
		alert("Bạn chưa nhập số điện thoại liên hệ!");
		document.getElementById('phonecontact_job').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phonecontact_job').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phonecontact_job').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobilecontact_job').value))
	 {
		 if(!CheckPhone(document.getElementById('mobilecontact_job').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobilecontact_job').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('emailcontact_job').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('emailcontact_job').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('emailcontact_job').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('emailcontact_job').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('endday_job').value,document.getElementById('endmonth_job').value,document.getElementById('endyear_job').value))
	 {
		 alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_job').value))
	 {
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_job').focus();
		return false;
	 }
	 document.frmPostJob.submit();
}

function CheckInput_PostEmploy()
{
	 if(CheckBlank(document.getElementById('title_employ').value))
	 {
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('position_employ').value))
	 {
		alert("Bạn chưa nhập vị trí làm việc!");
		document.getElementById('position_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('salary_employ').value))
	 {
		alert("Bạn chưa nhập mức lương mong muốn!");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('salary_employ').value))
	 {
		alert("Mức lương mong muốn bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 if(document.getElementById('salary_employ').value == "0")
	 {
		alert("Mức lương mong muốn không được bằng 0!");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("Bạn chưa nhập chi tiết tin tìm việc!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('name_employ').value))
	 {
		alert("Bạn chưa nhập họ tên!");
		document.getElementById('name_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('level_employ').value))
	 {
		alert("Bạn chưa nhập trình độ!");
		document.getElementById('level_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_employ').value))
	 {
		alert("Bạn chưa nhập địa chỉ!");
		document.getElementById('address_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_employ').value))
	 {
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('phone_employ').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_employ').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_employ').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_employ').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_employ').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_employ').focus();

			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_employ').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('email_employ').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_employ').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_employ').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('endday_employ').value,document.getElementById('endmonth_employ').value,document.getElementById('endyear_employ').value))
	 {
		 alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_employ').value))
	 {
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_employ').focus();
		return false;
	 }
	 document.frmPostEmploy.submit();
}

function CheckInput_Register()
{
	if(CheckBlank(document.getElementById('username_regis').value))
	{
		alert("Bạn chưa nhập tài khoản!");
		document.getElementById('username_regis').focus();
		return false;
	}
	if(!CheckCharacter(document.getElementById('username_regis').value))
	{
		alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z\nChấp nhận các ký tự - _");
		document.getElementById('username_regis').focus();
		return false;
	}
	var username = document.getElementById('username_regis').value;
	if(username.length < 6)
	{
		alert("Tài khoản phải có ít nhất 6 ký tự!");
		document.getElementById('username_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('password_regis').value))
	{
		alert("Bạn chưa nhập mật khẩu!");
		document.getElementById('password_regis').focus();
		return false;
	}
	var password = document.getElementById('password_regis').value;
	if(password.length < 6)
	{
		alert("Mật khẩu phải có ít nhất 6 ký tự!");
		document.getElementById('password_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('email_regis').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_regis').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_regis').value))
	{
		alert("Email bạn nhập không hợp lê!");
		document.getElementById('email_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('fullname_regis').value))
	{
		alert("Bạn chưa nhập họ tên!");
		document.getElementById('fullname_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('address_regis').value))
	{
		alert("Bạn chưa nhập địa chỉ!");
		document.getElementById('address_regis').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('phone_regis').value))
	 {
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('phone_regis').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_regis').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_regis').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_regis').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_regis').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_regis').focus();

			return false;
		 }
	 }
	
	if(CheckBlank(document.getElementById('captcha_regis').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_regis').focus();
		return false;
	}
	document.frmRegister.submit();
}

function CheckInput_Contact()
{
	if(CheckBlank(document.getElementById('name_contact').value))
	{
		alert("Bạn chưa nhập họ tên!");
		document.getElementById('name_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('email_contact').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_contact').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_contact').value))
	{
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('address_contact').value))
	{
		alert("Bạn chưa nhập địa chỉ!");
		document.getElementById('address_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('phone_contact').value))
	{
		alert("Bạn chưa nhập điện thoại!");
		document.getElementById('phone_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('title_contact').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('content_contact').value))
	{
		alert("Bạn chưa nhập nội dung!");
		document.getElementById('content_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_contact').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_contact').focus();
		return false;
	}
	document.frmContact.submit();
}

function CheckInput_Login()
{
	if(CheckBlank(document.getElementById('UsernameLogin').value))
	{
		alert("Bạn chưa nhập tài khoản!");
		document.getElementById('UsernameLogin').focus();
		return false;
	}
	if(!CheckCharacter(document.getElementById('UsernameLogin').value))
	{
		alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z\nChấp nhận các ký tự - _");
		document.getElementById('UsernameLogin').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('PasswordLogin').value))
	{
		alert("Bạn chưa nhập mật khẩu!");
		document.getElementById('PasswordLogin').focus();
		return false;
	}
	document.frmLogin.submit();
}

function CheckInput_Forgot()
{
	if(CheckBlank(document.getElementById('username_forgot').value))
	{
		alert("Bạn chưa nhập tài khoản!");
		document.getElementById('username_forgot').focus();
		return false;
	}
	if(!CheckCharacter(document.getElementById('username_forgot').value))
	{
		alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z\nChấp nhận các ký tự - _");
		document.getElementById('username_forgot').focus();
		return false;
	}
	var username = document.getElementById('username_forgot').value;
	if(username.length < 6)
	{
		alert("Tài khoản phải có ít nhất 6 ký tự!");
		document.getElementById('username_forgot').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('email_forgot').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_forgot').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_forgot').value))
	{
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_forgot').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_forgot').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_forgot').focus();
		return false;
	}
	document.frmForgotPassword.submit();
}

function CheckInput_SearchPro(baseUrl)
{
	if(!CheckBlank(document.getElementById('cost_search1').value) || !CheckBlank(document.getElementById('cost_search2').value))
	{
		if(CheckBlank(document.getElementById('cost_search1').value))
		{
			alert("Bạn chưa nhập giá bắt đầu của sản phẩm!");
			document.getElementById('cost_search1').focus();
			return false;
		}
		if(!IsNumber(document.getElementById('cost_search1').value))
	   	{
		  alert("Giá bắt đầu bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		  document.getElementById('cost_search1').focus();
		  return false;
	   	}
	   	if(document.getElementById('cost_search1').value == "0")
	   	{
		  alert("Giá bán không được bằng 0!");
		  document.getElementById('cost_search1').focus();
		  return false;
	   	}
		
		if(CheckBlank(document.getElementById('cost_search2').value))
		{
			alert("Bạn chưa nhập giá kết thúc của sản phẩm!");
			document.getElementById('cost_search2').focus();
			return false;
		}
		if(!IsNumber(document.getElementById('cost_search2').value))
	   	{
		  alert("Giá kết thúc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		  document.getElementById('cost_search2').focus();
		  return false;
	   	}
	   	if(document.getElementById('cost_search2').value == "0")
	   	{
		  alert("Giá bán không được bằng 0!");
		  document.getElementById('cost_search2').focus();
		  return false;
	   	}
		
		var cost1 = document.getElementById('cost_search1').value*1;
		var cost2 = document.getElementById('cost_search2').value*1;
		if(cost1 > cost2)
		{
			alert("Giá kết thúc phải lớn hơn hoặc bằng giá bắt đầu!\nNếu bạn muốn tìm chính xác giá, bạn vui lòng nhập giá bắt đầu bằng với giá kết thúc.");
			document.getElementById('cost_search2').focus();
		  	return false;
		}
	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			alert("Bạn chưa chọn ngày bắt đầu!");
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			alert("Bạn chưa chọn ngày kết thúc!");
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.");
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('name_search').value) && CheckBlank(document.getElementById('cost_search1').value) && document.getElementById('saleoff_search').checked == false && document.getElementById('province_search').value == "0" && document.getElementById('category_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
		return false;
	}
	ActionSearch(baseUrl, 1);
}

function CheckInput_SearchAds(baseUrl)
{
	if(!CheckBlank(document.getElementById('view_search1').value) || !CheckBlank(document.getElementById('view_search2').value))
	{
		if(CheckBlank(document.getElementById('view_search1').value))
		{
			alert("Bạn chưa nhập lượt xem bắt đầu!");
			document.getElementById('view_search1').focus();
			return false;
		}
		if(!IsNumber(document.getElementById('view_search1').value))
	   	{
		  alert("Lượt xem bắt đầu bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		  document.getElementById('view_search1').focus();
		  return false;
	   	}
		
		if(CheckBlank(document.getElementById('view_search2').value))
		{
			alert("Bạn chưa nhập lượt xem kết thúc!");
			document.getElementById('view_search2').focus();
			return false;
		}
		if(!IsNumber(document.getElementById('view_search2').value))
	   	{
		  alert("Lượt xem kết thúc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		  document.getElementById('view_search2').focus();
		  return false;
	   	}
		
		var view1 = document.getElementById('view_search1').value*1;
		var view2 = document.getElementById('view_search2').value*1;
		if(view1 > view2)
		{
			alert("Lượt xem kết thúc phải lớn hơn hoặc bằng lượt xem bắt đầu!\nNếu bạn muốn tìm chính xác lượt xem, bạn vui lòng nhập lượt xem bắt đầu bằng với lượt xem kết thúc.");
			document.getElementById('view_search2').focus();
		  	return false;
		}
	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			alert("Bạn chưa chọn ngày bắt đầu!");
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			alert("Bạn chưa chọn ngày kết thúc!");
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.");
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('title_search').value) && CheckBlank(document.getElementById('view_search1').value) && document.getElementById('province_search').value == "0" && document.getElementById('category_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
		return false;
	}
	ActionSearch(baseUrl, 2);
}

function CheckInput_SearchJob(baseUrl)
{
	if(!CheckBlank(document.getElementById('salary_search').value))
	{
		if(!IsNumber(document.getElementById('salary_search').value))
		{
		  alert("Mức lương bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		  document.getElementById('salary_search').focus();
		  return false;
		}
		if(document.getElementById('salary_search').value == "0")
		{
		  alert("Mức lương không được bằng 0!");
		  document.getElementById('salary_search').focus();
		  return false;
		}
	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			alert("Bạn chưa chọn ngày bắt đầu!");
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			alert("Bạn chưa chọn ngày kết thúc!");
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.");
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('title_search').value) && CheckBlank(document.getElementById('salary_search').value) && document.getElementById('province_search').value == "0" && document.getElementById('field_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
		return false;
	}
	ActionSearch(baseUrl, 3);
}

function CheckInput_SearchEmploy(baseUrl)
{
	if(!CheckBlank(document.getElementById('salary_search').value))
	{
		if(!IsNumber(document.getElementById('salary_search').value))
		{
		  alert("Mức lương bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		  document.getElementById('salary_search').focus();
		  return false;
		}
		if(document.getElementById('salary_search').value == "0")
		{
		  alert("Mức lương không được bằng 0!");
		  document.getElementById('salary_search').focus();
		  return false;
		}
	}
	
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			alert("Bạn chưa chọn ngày bắt đầu!");
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			alert("Bạn chưa chọn ngày kết thúc!");
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.");
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('title_search').value) && CheckBlank(document.getElementById('salary_search').value) && document.getElementById('province_search').value == "0" && document.getElementById('field_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
		return false;
	}
	ActionSearch(baseUrl, 4);
}

function CheckInput_SearchShop(baseUrl)
{
	if((document.getElementById('beginday_search1').value != 0 && document.getElementById('beginmonth_search1').value != 0 && document.getElementById('beginyear_search1').value != 0) || (document.getElementById('beginday_search2').value != 0 && document.getElementById('beginmonth_search2').value != 0 && document.getElementById('beginyear_search2').value != 0))
	{
		if(document.getElementById('beginday_search1').value == 0 || document.getElementById('beginmonth_search1').value == 0 || document.getElementById('beginyear_search1').value == 0)
		{
			alert("Bạn chưa chọn ngày bắt đầu!");
			return false;
		}
		
		if(document.getElementById('beginday_search2').value == 0 || document.getElementById('beginmonth_search2').value == 0 || document.getElementById('beginyear_search2').value == 0)
		{
			alert("Bạn chưa chọn ngày kết thúc!");
			return false;
		}
		
	   	if(CheckDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value) || CheckDate(document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày đăng ký không hợp lệ!\nNgày đăng ký phải nhỏ hơn hoặc bằng ngày hiện tại.");
			return false;
	   	}
		
	   	if(!CompareDate(document.getElementById('beginday_search1').value,document.getElementById('beginmonth_search1').value,document.getElementById('beginyear_search1').value,document.getElementById('beginday_search2').value,document.getElementById('beginmonth_search2').value,document.getElementById('beginyear_search2').value))
	   	{
			alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng ký, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
			return false;
	   	}
	}
	
	if((CheckBlank(document.getElementById('name_search').value) && CheckBlank(document.getElementById('address_search').value) && document.getElementById('saleoff_search').checked == false && document.getElementById('province_search').value == "0" && document.getElementById('category_search').value == "0") && (document.getElementById('beginday_search1').value == "0" || document.getElementById('beginmonth_search1').value == "0" || document.getElementById('beginyear_search1').value == "0"))
	{
		alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
		return false;
	}
	ActionSearch(baseUrl, 5);
}

function CheckInput_EditAccount()
{
	if(CheckBlank(document.getElementById('email_account').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_account').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_account').value))
	{
		alert("Email bạn nhập không hợp lê!");
		document.getElementById('email_account').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('fullname_account').value))
	{
		alert("Bạn chưa nhập họ tên!");
		document.getElementById('fullname_account').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('address_account').value))
	{
		alert("Bạn chưa nhập địa chỉ!");
		document.getElementById('address_account').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('phone_account').value))
	{
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('phone_account').focus();
		return false;
	}
	if(!CheckPhone(document.getElementById('phone_account').value))
	{
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_account').focus();
		return false;
	}
	 if(!CheckBlank(document.getElementById('mobile_account').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_account').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_account').focus();
			return false;
		 }
	 }
	
	if(CheckBlank(document.getElementById('captcha_account').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_account').focus();
		return false;
	}
	document.frmEditAccount.submit();
}

function CheckInput_ChangePassword()
{
	if(CheckBlank(document.getElementById('oldpassword_changepass').value))
	{
		alert("Bạn chưa nhập mật khẩu củ!");
		document.getElementById('oldpassword_changepass').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('password_changepass').value))
	{
		alert("Bạn chưa nhập mật khẩu mới!");
		document.getElementById('password_changepass').focus();
		return false;
	}
	var password = document.getElementById('password_changepass').value;
	if(password.length < 6)
	{
		alert("Mật khẩu mới phải có ít nhất 6 ký tự!");
		document.getElementById('password_changepass').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_changepass').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_changepass').focus();
		return false;
	}
	document.frmChangePassword.submit();
}

function CheckInput_ContactAccount()
{
	if(CheckBlank(document.getElementById('title_contact').value))
	{
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_contact').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('txtContent').value))
	{
		alert("Bạn chưa nhập nội dung!");
		document.getElementById('txtContent').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_contact').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_contact').focus();
		return false;
	}
	document.frmContactAccount.submit();
}

function CheckInput_EditPro()
{
	 if(CheckBlank(document.getElementById('name_pro').value))
	 {
		alert("Bạn chưa nhập tên sản phẩm!");
		document.getElementById('name_pro').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('descr_pro').value))
	 {
		alert("Bạn chưa nhập mô tả!");
		document.getElementById('descr_pro').focus();
		return false;
	 }
	 
	 if(document.getElementById('nonecost_pro').checked == false)
	 {
		 if(CheckBlank(document.getElementById('cost_pro').value))
		 {
			alert("Bạn chưa nhập giá sản phẩm!");
			document.getElementById('cost_pro').focus();
			return false;
		 }
		 if(!IsNumber(document.getElementById('cost_pro').value))
		 {
			alert("Giá bán bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
			document.getElementById('cost_pro').focus();
			return false;
		 }
		 if(document.getElementById('cost_pro').value == "0")
		 {
			alert("Giá bán không được bằng 0!\nBạn có thể chọn Không có giá.");
			document.getElementById('cost_pro').focus();
			return false;
		 }
	 }
	 
	 if(!CheckDate(document.getElementById('day_pro').value,document.getElementById('month_pro').value,document.getElementById('year_pro').value))
	 {
		 alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("Bạn chưa nhập chi tiết sản phẩm!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('fullname_pro').value))
	 {
		alert("Bạn chưa nhập người đăng sản phẩm!");
		document.getElementById('fullname_pro').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_pro').value))
	 {
		alert("Bạn chưa nhập địa chỉ liên hệ!");
		document.getElementById('address_pro').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_pro').value))
	 {
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('phone_pro').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_pro').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_pro').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_pro').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_pro').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_pro').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_pro').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('email_pro').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_pro').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_pro').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_pro').value))
	 {
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_pro').focus();
		return false;
	 }
	 document.frmEditPro.submit();
}

function CheckInput_EditAds()
{
	 if(CheckBlank(document.getElementById('title_ads').value))
	 {
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_ads').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('descr_ads').value))
	 {
		alert("Bạn chưa nhập mô tả!");
		document.getElementById('descr_ads').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('day_ads').value,document.getElementById('month_ads').value,document.getElementById('year_ads').value))
	 {
		 alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("Bạn chưa nhập chi tiết rao vặt!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('fullname_ads').value))
	 {
		alert("Bạn chưa nhập người đăng rao vặt!");
		document.getElementById('fullname_ads').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_ads').value))
	 {
		alert("Bạn chưa nhập địa chỉ liên hệ!");
		document.getElementById('address_ads').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_ads').value))
	 {
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('address_ads').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_ads').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_ads').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_ads').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_ads').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_ads').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_ads').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('email_ads').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_ads').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_ads').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_ads').value))
	 {
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_ads').focus();
		return false;
	 }
	 document.frmEditAds.submit();
}

function CheckInput_EditJob()
{
	 if(CheckBlank(document.getElementById('title_job').value))
	 {
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('position_job').value))
	 {
		alert("Bạn chưa nhập vị trí tuyển dụng!");
		document.getElementById('position_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('level_job').value))
	 {
		alert("Bạn chưa nhập trình độ!");
		document.getElementById('level_job').focus();
		return false;
	 }
	 
	 if(document.getElementById('age1_job').value > document.getElementById('age2_job').value)
	 {
		 alert("Bạn chọn tuổi không hợp lệ!\nVí dụ: Tuổi từ 18 đến 25.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('require_job').value))
	 {
		alert("Bạn chưa nhập yêu cầu công việc!");
		document.getElementById('require_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('salary_job').value))
	 {
		alert("Bạn chưa nhập mức lương khởi điểm!");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('salary_job').value))
	 {
		alert("Mức lương khởi điểm bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 if(document.getElementById('salary_job').value == "0")
	 {
		alert("Mức lương khởi điểm không được bằng 0!");
		document.getElementById('salary_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('try_job').value))
	 {
		alert("Bạn chưa nhập thời gian thử việc!");
		document.getElementById('try_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('try_job').value))
	 {
		alert("Thời gian thử việc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		document.getElementById('try_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('interest_job').value))
	 {
		alert("Bạn chưa nhập quyền lợi!");
		document.getElementById('interest_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('quantity_job').value))
	 {
		alert("Bạn chưa nhập số lượng tuyển dụng!");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('quantity_job').value))
	 {
		alert("Số lượng tuyển dụng bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 if(document.getElementById('quantity_job').value == "0")
	 {
		alert("Số lượng tuyển dụng không được bằng 0!");
		document.getElementById('quantity_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('record_job').value))
	 {
		alert("Bạn chưa nhập hồ sơ xin việc!");
		document.getElementById('record_job').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('day_job').value,document.getElementById('month_job').value,document.getElementById('year_job').value))
	 {
		 alert("Thời gian nộp hồ sơ không hợp lệ!\nThời gian nộp hồ sơ phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("Bạn chưa nhập chi tiết tin tuyển dụng!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('name_job').value))
	 {
		alert("Bạn chưa nhập tên nhà tuyển dụng!");
		document.getElementById('name_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_job').value))
	 {
		alert("Bạn chưa nhập địa chỉ nhà tuyển dụng!");
		document.getElementById('address_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_job').value))
	 {
		alert("Bạn chưa nhập số điện thoại nhà tuyển dụng!");
		document.getElementById('phone_job').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_job').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_job').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_job').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_job').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_job').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_job').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('email_job').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_job').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_job').focus();
		return false;
	 }
	 
	 if(!CheckWebsite(document.getElementById('website_job').value))
	 {
		alert("Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -");
		document.getElementById('website_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('namecontact_job').value))
	 {
		alert("Bạn chưa nhập tên người đại diện!");
		document.getElementById('namecontact_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('addresscontact_job').value))
	 {
		alert("Bạn chưa nhập địa chỉ liên hệ!");
		document.getElementById('addresscontact_job').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phonecontact_job').value))
	 {
		alert("Bạn chưa nhập số điện thoại liên hệ!");
		document.getElementById('phonecontact_job').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phonecontact_job').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phonecontact_job').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobilecontact_job').value))
	 {
		 if(!CheckPhone(document.getElementById('mobilecontact_job').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobilecontact_job').focus();
			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('emailcontact_job').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('emailcontact_job').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('emailcontact_job').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('emailcontact_job').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('endday_job').value,document.getElementById('endmonth_job').value,document.getElementById('endyear_job').value))
	 {
		 alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_job').value))
	 {
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_job').focus();
		return false;
	 }
	 document.frmEditJob.submit();
}

function CheckInput_EditEmploy()
{
	 if(CheckBlank(document.getElementById('title_employ').value))
	 {
		alert("Bạn chưa nhập tiêu đề!");
		document.getElementById('title_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('position_employ').value))
	 {
		alert("Bạn chưa nhập vị trí làm việc!");
		document.getElementById('position_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('salary_employ').value))
	 {
		alert("Bạn chưa nhập mức lương mong muốn!");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 if(!IsNumber(document.getElementById('salary_employ').value))
	 {
		alert("Mức lương mong muốn bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 if(document.getElementById('salary_employ').value == "0")
	 {
		alert("Mức lương mong muốn không được bằng 0!");
		document.getElementById('salary_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('txtContent').value))
	 {
		alert("Bạn chưa nhập chi tiết tin tìm việc!");
		document.getElementById('txtContent').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('name_employ').value))
	 {
		alert("Bạn chưa nhập họ tên!");
		document.getElementById('name_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('level_employ').value))
	 {
		alert("Bạn chưa nhập trình độ!");
		document.getElementById('level_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('address_employ').value))
	 {
		alert("Bạn chưa nhập địa chỉ!");
		document.getElementById('address_employ').focus();
		return false;
	 }
	 
	 if(CheckBlank(document.getElementById('phone_employ').value))
	 {
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('phone_employ').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_employ').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_employ').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_employ').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_employ').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_employ').focus();

			return false;
		 }
	 }
	 
	 if(CheckBlank(document.getElementById('email_employ').value))
	 {
		alert("Bạn chưa nhập email!");
		document.getElementById('email_employ').focus();
		return false;
	 }
	 if(!CheckEmail(document.getElementById('email_employ').value))
	 {
		alert("Email bạn nhập không hợp lệ!");
		document.getElementById('email_employ').focus();
		return false;
	 }
	 
	 if(!CheckDate(document.getElementById('endday_employ').value,document.getElementById('endmonth_employ').value,document.getElementById('endyear_employ').value))
	 {
		 alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
		 return false;
	 }
	 
	 if(CheckBlank(document.getElementById('captcha_employ').value))
	 {
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_employ').focus();
		return false;
	 }
	 document.frmEditEmploy.submit();
}

function CheckInput_EditShop()
{
	if(CheckBlank(document.getElementById('link_shop').value))
	{
		alert("Bạn chưa nhập link tới cửa hàng!");
		document.getElementById('link_shop').focus();
		return false;
	}
	if(!CheckLink(document.getElementById('link_shop').value))
	{
		alert("Link tới cửa hàng bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, _-");
		document.getElementById('link_shop').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('name_shop').value))
	{
		alert("Bạn chưa nhập tên cửa hàng!");
		document.getElementById('name_shop').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('descr_shop').value))
	{
		alert("Bạn chưa nhập mô tả cửa hàng!");
		document.getElementById('descr_shop').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('address_shop').value))
	{
		alert("Bạn chưa nhập địa chỉ của cửa hàng!");
		document.getElementById('address_shop').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('phone_shop').value))
	 {
		alert("Bạn chưa nhập số điện thoại!");
		document.getElementById('phone_shop').focus();
		return false;
	 }
	 if(!CheckPhone(document.getElementById('phone_shop').value))
	 {
		alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
		document.getElementById('phone_shop').focus();
		return false;
	 }
	 if(!CheckBlank(document.getElementById('mobile_shop').value))
	 {
		 if(!CheckPhone(document.getElementById('mobile_shop').value))
		 {
			alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
			document.getElementById('mobile_shop').focus();
			return false;
		 }
	 }
	 
	if(CheckBlank(document.getElementById('email_shop').value))
	{
		alert("Bạn chưa nhập email!");
		document.getElementById('email_shop').focus();
		return false;
	}
	if(!CheckEmail(document.getElementById('email_shop').value))
	{
		alert("Email bạn nhập không hợp lê!");
		document.getElementById('email_shop').focus();
		return false;
	}
	
	if(!CheckWebsite(document.getElementById('website_shop').value))
	{
		alert("Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -");
		document.getElementById('website_shop').focus();
		return false;
	}
	
	if(CheckBlank(document.getElementById('captcha_shop').value))
	{
		alert("Bạn chưa nhập mã xác nhận!");
		document.getElementById('captcha_shop').focus();
		return false;
	}
	document.frmEditShop.submit();
}
/*END Check Input*/
/*BEGIN: Khoa Ky Tu Khong Cho Phep*/
var rBlock={
  'SpecialChar':/['\'\"\\#~`<>;']/g,
  'AllSpecialChar':/['@\'\"\\~<>;`&\/%$^*{}\[\]!|():,?+=#']/g,
  'NotNumbers':/[^\d]/g
}
function BlockChar(div,type)
{
	div.value = div.value.replace(rBlock[type],'');
	div.value = div.value.replace(/ +/g,' ');
}
/*END Khoa Ky Tu Khong Cho Phep*/
/*BEGIN: Chu Hoa Dau Tu*/
function CapitalizeNames(FormName,FieldName) 
{
  var ValueString = new String();
  eval('ValueString=document.'+FormName+'.'+FieldName+'.value');
  ValueString = ValueString.replace(/ +/g,' ');
  var names = ValueString.split(' ');
  for(var i = 0; i < names.length; i++) 
  {
	  if(names[i].length > 1)
	  {
		  names[i] = names[i].toLowerCase();
		  letters = names[i].split('');
		  letters[0] = letters[0].toUpperCase();
		  names[i] = letters.join('');
  	  }
  	  else
	  { 
	  	names[i] = names[i].toUpperCase();
	  }
  }
  ValueString = names.join(' ');
  eval('document.'+FormName+'.'+FieldName+'.value=ValueString');
  return true;
}
/*END Chu Hoa Dau Tu*/
/*BEGIN: Post*/
function AddComma(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = "";
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1))
	{	
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function FormatCurrency(div,idGeted,number)
{
	/*Convert tu 1000->1.000*/
	/*var mynumber=1000;number = number.replace(/\./g,"");*/
	document.getElementById(div).style.display = "";
	document.getElementById(div).innerHTML = AddComma(number);
	document.getElementById(div).innerHTML = document.getElementById(div).innerHTML + '&nbsp;' + document.getElementById(idGeted).options[document.getElementById(idGeted).selectedIndex].innerHTML;
}

function FormatCost(cost,div)
{
	document.getElementById(div).innerHTML = AddComma(cost);
}
/*BEGIN: Sub*/
function subStr(str, leng, div)
{
	var currentLeng = str.length;
	var result = '';
	var i = 0;
	while(i < leng)
	{
		result += str.charAt(i);
		if(i == currentLeng)
		{
			document.getElementById(div).innerHTML = str;
			return;
		}
		i += 1;
	}
	document.getElementById(div).innerHTML = result + ' ...';
}
/*END Sub*/
function ChangeStyleTextBox(div,div_show,status)
{
	if (status == true)
	{
		document.getElementById(div).style.backgroundColor = "#DDDDDD";
		document.getElementById(div).value = "0";
	}
	else
	{
		document.getElementById(div).style.backgroundColor = "#FFFFFF";
		document.getElementById(div).value = "";
	}
	document.getElementById(div_show).style.display = "none";
}

function ChangeCheckBox(checkbox)
{
	document.getElementById(checkbox).checked = false;
}
/*END Post*/
/*BEGIN: Dang Ky*/
function ChangeLawRegister(status,index)
{
	if(status == true)
	{
		if(index == 1)
		{
			document.getElementById('DivNormalRegister').style.display = "none";
			document.getElementById('DivVipRegister').style.display = "";
			document.getElementById('DivShopRegister').style.display = "none";
			$(function()
			{
				$('#Panel_2').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
			});
		}
		if(index == 2)
		{
			document.getElementById('DivNormalRegister').style.display = "none";
			document.getElementById('DivVipRegister').style.display = "none";
			document.getElementById('DivShopRegister').style.display = "";
			$(function()
			{
				$('#Panel_3').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
			});
		}
	}
	else
	{
		document.getElementById('DivNormalRegister').style.display = "";
		document.getElementById('DivVipRegister').style.display = "none";
		document.getElementById('DivShopRegister').style.display = "none";
		$(function()
		{
			$('#Panel_1').jScrollPane({showArrows:true, scrollbarWidth: 15, arrowSize: 16});
		});
	}
}
/*END Dang Ky*/
/*BEGIN: Kiem tra xem co chon vao o checkbox nao khong, Va hai tuy chon tat ca va huy bo*/
function DoCheck(status,FormName,from_)
{
	var alen=eval('document.'+FormName+'.elements.length');
	alen=(alen>1)?eval('document.'+FormName+'.checkone.length'):0;
	if (alen>0)
	{
		for(var i=0;i<alen;i++)
			eval('document.'+FormName+'.checkone[i].checked=status');
	}
	else
	{
		eval('document.'+FormName+'.checkone.checked=status');
	}
	if(from_>0)
		eval('document.'+FormName+'.checkall.checked=status');
}

function DoCheckOne(FormName)
{
	var alen=eval('document.'+FormName+'.elements.length');
	var isChecked=true;
	alen=(alen>1)?eval('document.'+FormName+'.checkone.length'):0;
	if (alen>0)
	{
		for(var i=0;i<alen;i++)
				if(eval('document.'+FormName+'.checkone[i].checked==false'))
						isChecked=false;
	}
	else
	{
		if(eval('document.'+FormName+'.checkone.checked==false'))
			isChecked=false;
	}				
	eval('document.'+FormName+'.checkall.checked=isChecked');
}
/*END Kiem tra xem co chon vao o checkbox nao khong, Va hai tuy chon tat ca va huy bo*/
/*BEGIN: ShowCart*/
function SumCost(CostVNDShowCart,Quantity,SumCostVNDShowCart,SumCostUSDShowCart,convert)
{
	var vnd = document.getElementById(CostVNDShowCart).value * document.getElementById(Quantity).value;
	var usd = vnd/convert;
	vnd = Math.round(vnd);
	usd = Math.round(usd);
	vnd = AddComma(vnd);
	usd = AddComma(usd);
	document.getElementById(SumCostVNDShowCart).innerHTML = vnd;
	document.getElementById(SumCostUSDShowCart).innerHTML = usd + "&nbsp;USD";
}

function TotalCost(CostVNDShowCart,Quantity,TotalVNDShowCart,TotalUSDShowCart,number,convert)
{
	var vnd = 0;
	var usd = 0;
	if(number > 0)
	{
		for(var i=1;i<=number;i++)
		{
			vnd = vnd + document.getElementById(CostVNDShowCart+i).value * document.getElementById(Quantity+i).value;
		}
	}
	usd = vnd/convert;
	vnd = Math.round(vnd);
	usd = Math.round(usd);
	vnd = AddComma(vnd);
	usd = AddComma(usd);
	document.getElementById(TotalVNDShowCart).innerHTML = vnd + "&nbsp;VND";
	document.getElementById(TotalUSDShowCart).innerHTML = "(" + usd + "&nbsp;USD)";
}

function ActionDeleteShowcart()
{
	var alen=document.frmShowCart.elements.length;
	var isChecked=false;
	alen=(alen>1)?document.frmShowCart.checkone.length:0;
	if(alen>0)
	{
		for(var i=0;i<alen;i++)
				if(document.frmShowCart.checkone[i].checked==true)
				{
					isChecked=true;
					break;
				}
	}
	else
	{
		if(document.frmShowCart.checkone.checked==true)
			isChecked=true;
	}	
	if(isChecked == true)
	{
		document.frmShowCart.submit();
	}
}

function ActionEqual(status)
{
	if(status == '1')
	{
		document.getElementById('checkall').checked = false;
		DoCheck(document.frmShowCart.checkall.checked,'frmShowCart',0);
		document.frmShowCart.submit();
	}
	else
	{
		alert(status);
	}
}

function ResetQuantity(Quantity,number)
{
	for(var i=1;i<=number;i++)
	{
		document.getElementById(Quantity+i).value = "1"; 
	}
}
/*END ShowCart*/
/*BEGIN: Change Style*/
function ChangeStyleBox(div,action)
{
	switch (action)
	{
		case 1:
			document.getElementById(div).style.border = "1px #2F97FF solid";
			break;
		case 2:
			document.getElementById(div).style.border = "1px #D4EDFF solid";
			break;
		default:
			document.getElementById(div).style.border = "1px #2F97FF solid";
	}
}
/*END Change Style*/
/*BEGIN: ChangeStyleRow*/
function ChangeStyleRow(div,row,status)
{
	switch (status)
	{
		case 1://Change
			document.getElementById(div).style.background = "#ECF5FF";
			break;
		case 2://Default
			if(row % 2 == 0)
			{
				document.getElementById(div).style.background = "#f1f9ff";
			}
			else
			{
				document.getElementById(div).style.background = "none";
			}
			break;
		default://Change
			document.getElementById(div).style.background = "#ECF5FF";
	}
}
/*END ChangeStyleRow*/
/*BEGIN: ActionSort*/
function ActionSort(isAddress)
{
	window.location.href = isAddress;
}
/*END ActionSort*/
/*BEGIN: ActionLink*/
function ActionLink(isAddress)
{
	window.location.href = isAddress;
}
/*END ActionLink*/
/*BEGIN: Favorite*/
function Favorite(formName, status)
{
	if(status == '1')
	{
		eval('document.' + formName + '.submit();');
	}
	else
	{
		alert(status);
	}
}
/*END Favorite*/
/*BEGIN: Showcart*/
function Showcart(formName, status)
{
	if(status == '1')
	{
		eval('document.' + formName + '.submit();');
	}
	else
	{
		alert(status);
	}
}
/*END Showcart*/
/*BEGIN: SubmitVote*/
function SubmitVote()
{
	document.frmVote.submit();
}
/*END SubmitVote*/
/*BEGIN: OpenTabTopJob*/
function OpenTabTopJob(total, page, type)
{
	if(type == 'job')
	{
		var div = 'DivTop24hJob';
	}
	else
	{
		var div = 'DivTop24hEmploy';
	}
	switch(page)
	{
		case 1:
			for(i = 1; i <= total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "";
			}
			for(i = total+1; i <= 3*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "none";
			}
			break;
		case 2:
			for(i = 1; i <= total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "none";
			}
			for(i = total+1; i <= 2*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "";
			}
			for(i = 2*total+1; i <= 3*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "none";
			}
			break;
		default:
			for(i = 1; i <= 2*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "none";
			}
			for(i = 2*total+1; i <= 3*total; i++)
			{
				document.getElementById(div + '_' + i).style.display = "";
			}
	}
}
/*END OpenTabTopJob*/
/*BEGIN: OpenTabField*/
function OpenTabField()
{
	if(document.getElementById('DivField_1').style.display == "none")
	{
		document.getElementById('DivField_1').style.display = "";
		document.getElementById('DivField_2').style.display = "";
		document.getElementById('DivField_3').style.display = "";
		document.getElementById('DivField_4').style.display = "";
	}
	else
	{
		document.getElementById('DivField_1').style.display = "none";
		document.getElementById('DivField_2').style.display = "none";
		document.getElementById('DivField_3').style.display = "none";
		document.getElementById('DivField_4').style.display = "none";
	}
}
/*END OpenTabField*/
/*BEGIN: ActionSubmit*/
function ActionSubmit(formName)
{
	eval('document.' + formName + '.submit();');
}
/*END ActionSubmit*/
/*BEGIN: Mktime*/
function mktime()
{
    var no=0, i = 0, ma=0, mb=0, d = new Date(), dn = new Date(), argv = arguments, argc = argv.length;
    var dateManip = {
        0: function(tt){ return d.setHours(tt); },
        1: function(tt){ return d.setMinutes(tt); },
        2: function(tt){ var set = d.setSeconds(tt); mb = d.getDate() - dn.getDate(); return set;},
        3: function(tt){ var set = d.setMonth(parseInt(tt, 10)-1); ma = d.getFullYear() - dn.getFullYear(); return set;},
        4: function(tt){ return d.setDate(tt+mb);},
        5: function(tt){
            if (tt >= 0 && tt <= 69) {
                tt += 2000;
            }
            else if (tt >= 70 && tt <= 100) {
                tt += 1900;
            }
            return d.setFullYear(tt+ma);
        }
        // 7th argument (for DST) is deprecated
    };
	
    for( i = 0; i < argc; i++ ){
        no = parseInt(argv[i]*1, 10);
        if (isNaN(no)) {
            return false;
        } else {
            // arg is number, let's manipulate date object
            if(!dateManip[i](no)){
                // failed
                return false;
            }
        }
    }
	
    for (i = argc; i < 6; i++) {
        switch(i) {
            case 0:
                no = dn.getHours();
                break;
            case 1:
                no = dn.getMinutes();
                break;
            case 2:
                no = dn.getSeconds();
                break;
            case 3:
                no = dn.getMonth()+1;
                break;
            case 4:
                no = dn.getDate();
                break;
            case 5:
                no = dn.getFullYear();
                break;
        }
        dateManip[i](no);
    }
    return Math.floor(d.getTime()/1000);
}
/*END Mktime*/
/*BEGIN: Action Search*/
function ActionSearch(baseurl,type)
{
	var isAddress = '';
	switch (type)
	{
		case 1://Search product
			isAddress = baseurl;
			isName = document.getElementById('name_search').value;
			isSCost = document.getElementById('cost_search1').value;
			isECost = document.getElementById('cost_search2').value;
			isCurrency = document.getElementById('currency_search').value;
			isSaleoff = document.getElementById('saleoff_search').value;
			isPlace = document.getElementById('province_search').value;
			isCategory = document.getElementById('category_search').value;
			isSDay = document.getElementById('beginday_search1').value;
			isSMonth = document.getElementById('beginmonth_search1').value;
			isSYear = document.getElementById('beginyear_search1').value;
			isEDay = document.getElementById('beginday_search2').value;
			isEMonth = document.getElementById('beginmonth_search2').value;
			isEYear = document.getElementById('beginyear_search2').value;
			isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
			isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
			if(!CheckBlank(isName))
			{
				isAddress += 'name/' + isName + '/';
			}
			if(!CheckBlank(isSCost) && !CheckBlank(isECost))
			{
				isAddress += 'sCost/' + isSCost + '/';
				isAddress += 'eCost/' + isECost + '/';
				isAddress += 'currency/' + isCurrency + '/';
			}
			if(document.getElementById('saleoff_search').checked == true)
			{
				isAddress += 'saleoff/1/';
			}
			if(isPlace != '0')
			{
				isAddress += 'place/' + isPlace + '/';
			}
			if(isCategory != '0')
			{
				isAddress += 'category/' + isCategory + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		case 2://Search ads
			isAddress = baseurl;
			isTitle = document.getElementById('title_search').value;
			isSView = document.getElementById('view_search1').value;
			isEView = document.getElementById('view_search2').value;
			isPlace = document.getElementById('province_search').value;
			isCategory = document.getElementById('category_search').value;
			isSDay = document.getElementById('beginday_search1').value;
			isSMonth = document.getElementById('beginmonth_search1').value;
			isSYear = document.getElementById('beginyear_search1').value;
			isEDay = document.getElementById('beginday_search2').value;
			isEMonth = document.getElementById('beginmonth_search2').value;
			isEYear = document.getElementById('beginyear_search2').value;
			isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
			isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
			if(!CheckBlank(isTitle))
			{
				isAddress += 'title/' + isTitle + '/';
			}
			if(!CheckBlank(isSView) && !CheckBlank(isEView))
			{
				isAddress += 'sView/' + isSView + '/';
				isAddress += 'eView/' + isEView + '/';
			}
			if(isPlace != '0')
			{
				isAddress += 'place/' + isPlace + '/';
			}
			if(isCategory != '0')
			{
				isAddress += 'category/' + isCategory + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		case 3://Search job
			isAddress = baseurl;
			isTitle = document.getElementById('title_search').value;
			isSalary = document.getElementById('salary_search').value;
			isCurrency = document.getElementById('currency_search').value;
			isPlace = document.getElementById('province_search').value;
			isField = document.getElementById('field_search').value;
			isSDay = document.getElementById('beginday_search1').value;
			isSMonth = document.getElementById('beginmonth_search1').value;
			isSYear = document.getElementById('beginyear_search1').value;
			isEDay = document.getElementById('beginday_search2').value;
			isEMonth = document.getElementById('beginmonth_search2').value;
			isEYear = document.getElementById('beginyear_search2').value;
			isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
			isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
			if(!CheckBlank(isTitle))
			{
				isAddress += 'title/' + isTitle + '/';
			}
			if(!CheckBlank(isSalary))
			{
				isAddress += 'salary/' + isSalary + '/';
				isAddress += 'currency/' + isCurrency + '/';
			}
			if(isPlace != '0')
			{
				isAddress += 'place/' + isPlace + '/';
			}
			if(isField != '0')
			{
				isAddress += 'field/' + isField + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		case 4://Search employ
			isAddress = baseurl;
			isTitle = document.getElementById('title_search').value;
			isSalary = document.getElementById('salary_search').value;
			isCurrency = document.getElementById('currency_search').value;
			isPlace = document.getElementById('province_search').value;
			isField = document.getElementById('field_search').value;
			isSDay = document.getElementById('beginday_search1').value;
			isSMonth = document.getElementById('beginmonth_search1').value;
			isSYear = document.getElementById('beginyear_search1').value;
			isEDay = document.getElementById('beginday_search2').value;
			isEMonth = document.getElementById('beginmonth_search2').value;
			isEYear = document.getElementById('beginyear_search2').value;
			isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
			isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
			if(!CheckBlank(isTitle))
			{
				isAddress += 'title/' + isTitle + '/';
			}
			if(!CheckBlank(isSalary))
			{
				isAddress += 'salary/' + isSalary + '/';
				isAddress += 'currency/' + isCurrency + '/';
			}
			if(isPlace != '0')
			{
				isAddress += 'place/' + isPlace + '/';
			}
			if(isField != '0')
			{
				isAddress += 'field/' + isField + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		case 5://Search shop
			isAddress = baseurl;
			isName = document.getElementById('name_search').value;
			isAddress_Shop = document.getElementById('address_search').value;
			isSaleoff = document.getElementById('saleoff_search').value;
			isProvince = document.getElementById('province_search').value;
			isCategory = document.getElementById('category_search').value;
			isSDay = document.getElementById('beginday_search1').value;
			isSMonth = document.getElementById('beginmonth_search1').value;
			isSYear = document.getElementById('beginyear_search1').value;
			isEDay = document.getElementById('beginday_search2').value;
			isEMonth = document.getElementById('beginmonth_search2').value;
			isEYear = document.getElementById('beginyear_search2').value;
			isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
			isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
			if(!CheckBlank(isName))
			{
				isAddress += 'name/' + isName + '/';
			}
			if(document.getElementById('saleoff_search').checked == true)
			{
				isAddress += 'saleoff/1/';
			}
			if(!CheckBlank(isAddress_Shop))
			{
				isAddress += 'address/' + isAddress_Shop + '/';
			}
			if(isProvince != '0')
			{
				isAddress += 'province/' + isProvince + '/';
			}
			if(isCategory != '0')
			{
				isAddress += 'category/' + isCategory + '/';
			}
			if(isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008))
			{
				isAddress += 'sPostdate/' + isSDate + '/';
				isAddress += 'ePostdate/' + isEDate + '/';
			}
			window.location.href = isAddress;
			break;
		default://Search account
			var isKeyword = "";
			var isSearch = "";
			isKeyword = document.getElementById('keyword_account').value;
			isSearch = document.getElementById('search_account').value;
			if(!CheckBlank(isKeyword))
			{
				isAddress = baseurl + 'search/' + isSearch + '/keyword/' + isKeyword;
				window.location.href = isAddress;
			}
	}
}

function SelectSearch(sel)
{
	for(i=1;i<6;i++)
	{
		document.getElementById("TabSearch_" + i).className = "menu";
	}
	document.getElementById("TabSearch_" + sel).className = "search_selected";
	return sel;
}

function Search(type, baseUrl)
{
	var isAddress = baseUrl + 'search/';
	switch(type)
	{
		case 2:
			isAddress += 'ads/title/';
			break;
		case 3:
			isAddress += 'job/title/';
			break;
		case 4:
			isAddress += 'employ/title/';
			break;
		case 5:
			isAddress += 'shop/name/';
			break;
		default:
			isAddress += 'product/name/';
	}
	var isKeyword = document.getElementById('KeywordSearch').value;
	if(!CheckBlank(isKeyword))
	{
		window.location.href = isAddress + isKeyword;
	}
}
/*END Action Search*/
/*BEGIN: Guide*/
function Guide($div)
{
	$totalGuide = 9;
	for($i = 1; $i < $div; $i++)
	{
		document.getElementById('DivTitleGuide_' + $i).style.display = 'none';
		document.getElementById('DivContentGuide_' + $i).style.display = 'none';
		document.getElementById('DivListGuide_' + $i).className = 'menu_1';
	}
	for($j = $div+1; $j <= $totalGuide; $j++)
	{
		document.getElementById('DivTitleGuide_' + $j).style.display = 'none';
		document.getElementById('DivContentGuide_' + $j).style.display = 'none';
		document.getElementById('DivListGuide_' + $j).className = 'menu_1';
	}
	document.getElementById('DivIntroGuide').style.display = 'none';
	document.getElementById('DivGuide').style.display = 'block';
	document.getElementById('DivTitleGuide_' + $div).style.display = 'block';
	document.getElementById('DivContentGuide_' + $div).style.display = 'block';
	document.getElementById('DivListGuide_' + $div).className = 'menu_2';
}
/*END Guide*/
/*BEGIN: Taskbar*/
function TabTaskbarNotify(status)
{
	switch(status)
	{
		case 1:
			if(document.getElementById('DivTaskbarNotify').style.display == 'block')
			{
				document.getElementById('DivTaskbarNotify').style.display = 'none';
			}
			else
			{
				document.getElementById('DivTaskbarNotify').style.display = 'block';
			}
			break;
		default:
			document.getElementById('DivTaskbarNotify').style.display = 'none';
	}
}
/*END Taskbar*/
/*BEGIN: Show Thumbnail*/
function validImage(id)
{
    id = id*1;
    if(id > 1506)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function showThumbnail(id, image, thumb)
{
    var imageArray = image.split(',');
    if(validImage(id))
    {
        return 'thumbnail_' + thumb + '_' + imageArray[0];
    }
    else
    {
        return imageArray[0];
    }
}
/*END Show Thumbnail*/