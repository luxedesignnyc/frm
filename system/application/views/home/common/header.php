<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="<?php echo base_url(); ?>templates/home/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>templates/home/images/favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="alexaVerifyID" content="J_mnEtPUDglQ039W2oyKZBA5lws" />
<meta name="google-site-verification" content="2I2JANiiw42OZIbSWLtSDOMruRC-XYvKdxn3w8xPWfQ" />
<meta name="keywords" content="<?php echo Setting::settingKeyword; ?>" />
<meta name="description" content="<?php if(isset($descrSiteGlobal)){echo $descrSiteGlobal;}else{echo Setting::settingDescr;} ?>" />
<title><?php if(isset($titleSiteGlobal)){echo $this->lang->line('title_detail_header').$titleSiteGlobal;}else{echo Setting::settingTitle;} ?></title>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/general.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/tooltips.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/swfobject.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/templates.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/tooltips.css" />
<!--[if ie]>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/ie.css" />
<![endif]-->
<!--[if ie 6]>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/ie6.css" />
<![endif]-->
<!--[if ie 8]>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/ie8.css" />
<![endif]-->
</head>

<body>
<div style="border: 1px solid rgb(204, 204, 204); left: -1000px; top: 395px; visibility: hidden;" id="dhtmltooltip">
<table border="0" cellpadding="1" cellspacing="0" width="300">
<tbody>

</tbody>
</table>
</div>
  <img style="top: 381px; visibility: hidden;" id="dhtmlpointer" src="">

  <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/templates.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/tooltips.css" />
  <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/style1.css">
<div id="main_container">
<div class="top_bar">
<div class="top_search">
<div class="search_text">
<a href="<?php echo base_url(); ?>notify/4">
<blink>
<b>
<font color="#ff0000">
Thông báo
</font>
</b>
</blink>
</a>
&nbsp;&nbsp;
<a href="<?php echo base_url(); ?>search/product/name/">
Search
</a>
&nbsp;
</div>
<a class="search_selected" id="TabSearch_1" href="#SearchProduct" onclick="sel=SelectSearch(1)">
</a>
<a class="menu" id="TabSearch_2" href="#SearchAds" onclick="sel=SelectSearch(2)">
</a>
<a class="menu" id="TabSearch_3" href="#SearchJob" onclick="sel=SelectSearch(3)">
</a>
<a class="menu" id="TabSearch_4" href="#SearchEmploy" onclick="sel=SelectSearch(4)">
</a>
<a class="menu" id="TabSearch_5" href="#SearchShop" onclick="sel=SelectSearch(5)">
</a>
<script>
sel=SelectSearch(1);
</script>
  <input class="search_input" name="KeywordSearch" id="KeywordSearch" value="" maxlength="80" type="text">
  <input class="search_bt" onclick="Search(sel,'<?php echo base_url(); ?>')" src="<?php echo base_url(); ?>templates/home/images/search.gif" type="image">
</div>
<div class="kienthuc">
&nbsp;&nbsp;&nbsp;&nbsp;
<font color="#ffff00">
<b>
Tin VIP
</b>
</font>
:
<marquee onmouseover="this.stop();" onmouseout="this.start();" behavior="scroll" scrollamount="1" scrolldelay="1">
				<?php foreach($adsTaskbarGlobal as $adsTaskbarGlobalArray){ ?>
				<a class="menu_taskbar" href="<?php echo base_url() ?>ads/category/<?php echo $adsTaskbarGlobalArray->ads_category; ?>/detail/<?php echo $adsTaskbarGlobalArray->ads_id; ?>" title="<?php echo $adsTaskbarGlobalArray->ads_descr; ?>">&bull; <?php echo $adsTaskbarGlobalArray->ads_title; ?></a>
				<?php } ?>
            </marquee>

</div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>images/style.css">
<table style="border-collapse: collapse;" width="100%" border="0" cellpadding="0">
<tbody>
<tr>
<td>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td width="134" align="center">
<a href="<?php echo base_url() ?>">
  <img src="<?php echo base_url() ?>images/rvqn_top_home.gif" onmouseover="this.src='<?php echo base_url() ?>images/rvqn_top_home2.gif'" onmouseout="this.src='<?php echo base_url() ?>images/rvqn_top_home.gif'" title="TRANG CHỦ" border="0">
</a>
</td>
<td id="menu_parent_mbrv" onclick="location.href='<?php echo base_url() ?>ads'" style="cursor: pointer;" width="172" align="center">
<a href="<?php echo base_url() ?>ads">
  <img src="<?php echo base_url() ?>images/rvqn_top_mbrv.gif" onmouseover="this.src='<?php echo base_url() ?>images/rvqn_top_mbrv2.gif'" onmouseout="this.src='<?php echo base_url() ?>images/rvqn_top_mbrv.gif'" title="MUA BÁN RAO VẶT" border="0">
</a>
</td>
<td width="165" align="center">
<a href="<?php echo base_url() ?>product/saleoff">

  <img src="<?php echo base_url() ?>images/rvqn_top_saleoff.gif" onmouseover="this.src='<?php echo base_url() ?>images/rvqn_top_saleoff2.gif'" onmouseout="this.src='<?php echo base_url() ?>images/rvqn_top_saleoff.gif'" title="TIN KHUYẾN MÃI" border="0">
</a>
  </td>
<td width="187" align="center">
<a href="<?php echo base_url() ?>shop">

<img src="<?php echo base_url() ?>images/top_menu_eshop.gif" onmouseover="this.src='<?php echo base_url() ?>images/top_menu_eshop2.gif'" onmouseout="this.src='<?php echo base_url() ?>images/top_menu_eshop.gif'" title="GIAN HÀNG ĐIỆN TỬ" border="0">
  </a>
</td>
<td width="120" align="center">
<a href="<?php echo base_url() ?>contact">
  <img src="<?php echo base_url() ?>images/top_menu_contact.gif" onmouseover="this.src='<?php echo base_url() ?>images/top_menu_contact2.gif'" onmouseout="this.src='<?php echo base_url() ?>images/top_menu_contact.gif'" title="LIÊN HỆ" border="0">
</a>
</td>
<td class="WhiteText" width="217" align="center" background="<?php echo base_url() ?>images/top_menu_bg.gif" height="28">
Hotline: 0988949988 / 0985416655
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

<div id="header">
<div id="main_content">
<div class="oferte_content">
<table id="table1" border="0" cellpadding="0" cellspacing="0" width="1000" height="165">
<tbody>
<tr>
<td align="center" valign="top">
<table id="table2" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center" width="250" height="160">
<a href="<?php echo base_url(); ?>">
  <img src="<?php echo base_url(); ?>templates/home/images/chosoc.png" title="mua3s.vn" border="0" width="272" height="140">
</a>
</td>
<td valign="top">
<table id="table3" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td>
<table id="table4" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td colspan="2">
&nbsp;
</td>
</tr>
<tr>
<td align="center" valign="top" width="33%">
<table id="table7" border="0" width="100%">
<tbody>
<tr>
<td align="center">
Hỗ trợ trực tuyến 24/7
</td>
</tr>
<!--tr >
< td align="center" >
Hotline: 0988949988
< /td >
< /tr-->
<tr>
<td align="center">
<table id="table8" align="center" border="0" width="100%">
<tbody>
<tr>
<td align="right" width="123">
<a href="gtalk:call?jid=thuexedulich24h@gmail.com" title="Hỗ trợ Google Talk">
  <img src="<?php echo base_url(); ?>templates/home/images/gtalk-icon.gif" alt="Hỗ trợ Google Talk" border="0" width="25" height="25">
</a>
</td>
<td align="center" width="30">
<a href="msnim:add?contact=thuexedulich24h@hotmail.com" title="Hỗ trợ MSN">
  <img src="<?php echo base_url(); ?>templates/home/images/msn-icon.gif" alt="Hỗ trợ MSN" border="0" width="25" height="25">
</a>
</td>
<td align="center" width="30">
<a href="ymsgr:sendIM?trungbktt1" title="Hỗ trợ Mesenger Yahoo">
  <img src="<?php echo base_url(); ?>templates/home/images/yahoo-icon.gif" alt="Hỗ trợ Mesenger Yahoo" border="0" width="25" height="25">
</a>
</td>
<td align="left" width="123">
<a href="skype:trungtd268" title="Hỗ trợ Skype">
  <img src="<?php echo base_url(); ?>templates/home/images/skype-icon.gif" alt="Hỗ trợ Skype" border="0" width="25" height="25">
</a>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td align="center">

  <img src="<?php echo base_url(); ?>templates/home/images/security_icon.gif" alt="Hỗ trợ Google Talk" border="0" width="128" height="32">

</td>
</tr>
</tbody>
</table>
</td>
<td width="67%">
<p class="header_banner_left" align="center">
<?php $this->load->view('home/advertise/header'); ?>
</p>
</td>
</tr>
<tr>
<td width="33%">
&nbsp;
</td>
<td width="67%">
&nbsp;
</td>
</tr>
<tr>
<td colspan="2">
<div align="center">
<table id="table6" border="0" cellpadding="0" cellspacing="3" width="100%">
<tbody>
<tr>
<td align="center">
&nbsp;
</td>
<td align="center">
&nbsp;
</td>
<td align="center">
&nbsp;
</td>
<td align="center">
&nbsp;
</td>
<td align="center">
&nbsp;
</td>
<td align="center">
&nbsp;
</td>
<td align="center">
&nbsp;
</td>
<td align="center">
&nbsp;
</td>
<td align="center">
&nbsp;
</td>
</tr>
<tr>
<td align="left">
&nbsp;
</td>
<td align="left">
&nbsp;
</td>
<?php if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home') || trim(strtolower($this->uri->segment(1))) == 'logout'){ ?>
<td class="menutren" align="left" width="95">
  <img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_01.gif" title="Đăng nhập" align="middle" border="0" width="32" height="21">
<a href="<?php echo base_url(); ?>login">
Đăng nhập
</a>
</td>
<td class="menutren" align="left" width="85">
  <img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_06.gif" title="Đăng ký" align="middle" border="0" width="32" height="21">
<a href="<?php echo base_url(); ?>register">
Đăng ký
</a>
</td>
<?php }else{ ?>
<td class="menutren" align="left" width="95">
  <img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_01.gif" title="Tài khoản" align="middle" border="0" width="32" height="21">
<a href="<?php echo base_url(); ?>account">
Tài khoản
</a>
</td>
<td class="menutren" align="left" width="85">
  <img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_06.gif" title="Thoát" align="middle" border="0" width="32" height="21">
<a href="<?php echo base_url(); ?>logout">
Thoát
</a>
</td>
<?php } ?>
<td class="menutren" align="left" width="120">
  <img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_16.gif" title="Đăng sản phẩm" align="middle" border="0" width="32" height="21">
<a href="<?php echo base_url(); ?>product/post" title="Đăng sản phẩm">
Đăng sản phẩm
</a>
</td>
<td class="menutren" align="left" width="120">
  <img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_03.gif" title="Đăng tin rao vặt" align="middle" border="0" width="32" height="21">
<a href="<?php echo base_url(); ?>ads/post" title="Đăng tin rao vặt">
Đăng tin rao vặt
</a>
</td>
<td class="menutren" align="left" width="145">
  <img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_01.gif" title="Đăng tin tuyển dụng" align="middle" border="0" width="32" height="21">
<a href="<?php echo base_url(); ?>job/post" title="Đăng tin tuyển dụng">
Đăng tin tuyển dụng
</a>
</td>
<td class="menutren" align="left" width="125">
  <img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_15.gif" title="Đăng tin tìm việc" align="middle" border="0" width="32" height="21">
<a href="<?php echo base_url(); ?>employ/post" title="Đăng tin tìm việc">
Đăng tin tìm việc
</a>
</td>
</tr>
<tr>
<td colspan="9" align="center">
&nbsp;
</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<div id="main_content">
<div id="menu_tab">
<div class="left_menu_corner">
</div>
<ul class="menu">
<li>
<a href="<?php echo base_url(); ?>" class="nav1">
Sản phẩm
</a>
</li>
<li class="divider">
</li>
<li>
<a href="<?php echo base_url(); ?>ads" class="nav4">
Rao vặt
</a>
</li>
<li class="divider">
</li>
<li>
<a href="<?php echo base_url(); ?>shop" class="nav2">
Cửa hàng
</a>
</li>
<li class="divider">
</li>
<li>
<a href="<?php echo base_url(); ?>job" class="nav3">
Việc làm
</a>
</li>
<li class="divider">
</li>
<li>
<a href="<?php echo base_url(); ?>guide" class="nav7">
Hướng dẫn
</a>
</li>
<li class="divider">
</li>
<li>
<a href="<?php echo base_url(); ?>contact" class="nav6">
Liên hệ
</a>
</li>
<li class="divider">
</li>
<li>
<a class="nav5" href="<?php echo base_url(); ?>showcart"><?php echo $this->lang->line('showcart_header'); ?><span class="showcart_header">(<?php if($this->session->userdata('sessionProductShowcart')){echo count(explode(',', trim($this->session->userdata('sessionProductShowcart'), ',')));}else{echo '0';} ?>)</span></a>
</li>
<li class="currencies">

</li>
</ul>
<div class="right_menu_corner">
</div>
</div>
<!-- end of menu tab -->

<!--END HEADER-->
    <tr id="DivGlobalSite" style="display:none;">
		<td colspan="2">
			<table width="1004" border="0" cellpadding="0" cellspacing="0">
				<tr>