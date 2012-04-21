<?php if(isset($siteGlobal)){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="<?php echo base_url(); ?>templates/home/images/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>templates/home/images/favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="thitruong,thi truong,job,employ,product,ads,advertise,publich,free,register,24,24gio,24h,san pham,rao vat,tuyen dung,tim viec,cua hang,shop,comment,nokia,samsung,novo,motorola,lg,suzuky" />
<meta name="keywords" content="<?php echo Setting::settingKeyword; ?>" />
<meta name="description" content="<?php echo $siteGlobal->sho_descr; ?>" />
<title><?php echo $this->lang->line('title_detail_global'); ?><?php echo $siteGlobal->sho_name; ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/css/templates.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/css/tooltips.css" />

<script language="javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/general.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/tooltips.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/swfobject.js" type="text/javascript"></script>
<!--[if ie]>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/css/ie.css" />
<![endif]-->
<!--[if ie 6]>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/css/ie6.css" />
<![endif]-->
<!--[if ie 8]>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/css/ie8.css" />
<![endif]-->
</head>
<body>
<table width="1004" border="0" cellpadding="0" cellspacing="0" align="center">
	<!--BEGIN: Header-->
	<?php if(strtolower(substr($siteGlobal->sho_banner, -4)) == '.swf'){ ?>
	<tr>
    	<td colspan="3"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" class="banner_flash" id="FlashID_Banner"><param name="movie" value="<?php echo base_url(); ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $siteGlobal->sho_banner; ?>" /><param name="quality" value="high" /><param name="wmode" value="opaque" /><param name="swfversion" value="6.0.65.0" /><param name="expressinstall" value="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/expressInstall.swf" /><!--[if !IE]>--><object type="application/x-shockwave-flash" data="<?php echo base_url(); ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $siteGlobal->sho_banner; ?>" class="banner_flash"><!--<![endif]--><param name="quality" value="high" /><param name="wmode" value="opaque" /><param name="swfversion" value="6.0.65.0" /><param name="expressinstall" value="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/expressInstall.swf" /><div><h4>Content on this page requires a newer version of Adobe Flash Player.</h4><p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p></div><!--[if !IE]>--></object><!--<![endif]--></object><script type="text/javascript"><!-- swfobject.registerObject("FlashID_Banner"); //--></script></td>
    </tr>
	<?php }else{ ?>
	<tr>
    	<td colspan="3"><img src="<?php echo base_url(); ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $siteGlobal->sho_banner; ?>" border="0" width="1004" height="130" /></td>
    </tr>
    <?php } ?>
    <tr id="DivGlobalSiteTop" style="display:none;">
    	<td colspan="2" class="top_menu">
        	<table border="0" height="30" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="seper_none"><a class="menu_top" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('home_page_menu_detail_global'); ?></a></td>
                    <td class="seper_left"><a class="<?php if(isset($menuSelected) && $menuSelected == 'home'){echo 'menu_top_selected';}else{echo 'menu_top';} ?>" href="<?php echo base_url().$siteGlobal->sho_link; ?>"><?php echo $this->lang->line('index_page_menu_detail_global'); ?></a></td>
                    <td class="seper_left"><a class="<?php if(isset($menuSelected) && $menuSelected == 'product'){echo 'menu_top_selected';}else{echo 'menu_top';} ?>" href="<?php echo base_url().$siteGlobal->sho_link; ?>/product"><?php echo $this->lang->line('product_menu_detail_global'); ?></a></td>
                    <td class="seper_left"><a class="<?php if(isset($menuSelected) && $menuSelected == 'ads'){echo 'menu_top_selected';}else{echo 'menu_top';} ?>" href="<?php echo base_url().$siteGlobal->sho_link; ?>/ads"><?php echo $this->lang->line('ads_menu_detail_global'); ?></a></td>
                    <td class="seper_left"><a class="<?php if(isset($menuSelected) && $menuSelected == 'search'){echo 'menu_top_selected';}else{echo 'menu_top';} ?>" <?php if(isset($menuSelected) && ($menuSelected == 'home' || $menuSelected == 'product')){ ?>onclick="OpenSearch(1)" href="#Search"<?php }else{ ?>href="<?php echo base_url().$siteGlobal->sho_link; ?>/search"<?php } ?>><?php echo $this->lang->line('search_menu_detail_global'); ?></a></td>
                    <td class="seper_left"><a class="<?php if(isset($menuSelected) && $menuSelected == 'contact'){echo 'menu_top_selected';}else{echo 'menu_top';} ?>" href="<?php echo base_url().$siteGlobal->sho_link; ?>/contact"><?php echo $this->lang->line('contact_menu_detail_global'); ?></a></td>
                </tr>
            </table>
        </td>
        <td height="30" class="top_menu" style="text-align:right; padding-right:5px;"><?php if(trim($siteGlobal->sho_email != '')){ ?><a href="mailto:<?php echo $siteGlobal->sho_email; ?>" title="<?php echo $siteGlobal->sho_email; ?>"><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/mail_top.gif" border="0" /></a><?php } ?><?php if(trim($siteGlobal->sho_yahoo) != ''){ ?><a href="ymsgr:SendIM?<?php echo $siteGlobal->sho_yahoo; ?>" title="<?php echo $siteGlobal->sho_yahoo; ?>"><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/yahoo_top.gif" border="0" /></a><?php } ?><?php if(trim($siteGlobal->sho_skype) != ''){ ?><a href="skype:<?php echo $siteGlobal->sho_skype; ?>?Chat" title="<?php echo $siteGlobal->sho_skype; ?>"><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/skype_top.gif" border="0" /></a><?php } ?></td>
    </tr>
    <tr>
    	<td colspan="3" height="5"></td>
    </tr>
    <!--END Header-->
    <!--BEGIN: Main-->
    <tr id="DivGlobalSiteMain" style="display:none;">
 <?php } ?>