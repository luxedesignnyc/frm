<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                    <!--BEGIN: Main-->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10" colspan="2"></td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/category')" class="icon_main" id="icon_main_1" onmouseover="ChangeStyleIcon('icon_main_1',1)" onmouseout="ChangeStyleIcon('icon_main_1',2)">
                                    <a class="menu" href="#">
                                		<img src="<?php echo base_url(); ?>templates/admin/images/icon_category_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('category_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/user')" class="icon_main" id="icon_main_2" onmouseover="ChangeStyleIcon('icon_main_2',1)" onmouseout="ChangeStyleIcon('icon_main_2',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_user_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('user_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/user/vip')" class="icon_main" id="icon_main_3" onmouseover="ChangeStyleIcon('icon_main_3',1)" onmouseout="ChangeStyleIcon('icon_main_3',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_vip_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('vip_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/user/saler')" class="icon_main" id="icon_main_4" onmouseover="ChangeStyleIcon('icon_main_4',1)" onmouseout="ChangeStyleIcon('icon_main_4',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_saler_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('saler_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/shop')" class="icon_main" id="icon_main_5" onmouseover="ChangeStyleIcon('icon_main_5',1)" onmouseout="ChangeStyleIcon('icon_main_5',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_shop_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('shop_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/showcart')" class="icon_main" id="icon_main_6" onmouseover="ChangeStyleIcon('icon_main_6',1)" onmouseout="ChangeStyleIcon('icon_main_6',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_customer_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('customer_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/product')" class="icon_main" id="icon_main_7" onmouseover="ChangeStyleIcon('icon_main_7',1)" onmouseout="ChangeStyleIcon('icon_main_7',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_product_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('product_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/ads')" class="icon_main" id="icon_main_8" onmouseover="ChangeStyleIcon('icon_main_8',1)" onmouseout="ChangeStyleIcon('icon_main_8',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_ads_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('ads_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/job')" class="icon_main" id="icon_main_9" onmouseover="ChangeStyleIcon('icon_main_9',1)" onmouseout="ChangeStyleIcon('icon_main_9',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_job_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('job_main'); ?></div>
                                    </a>
                                </div>
                                <div onclick="ActionLink('<?php echo base_url(); ?>administ/employ')" class="icon_main" id="icon_main_10" onmouseover="ChangeStyleIcon('icon_main_10',1)" onmouseout="ChangeStyleIcon('icon_main_10',2)">
                                    <a class="menu" href="#">
                                        <img src="<?php echo base_url(); ?>templates/admin/images/icon_employ_main.png" border="0" />
                                        <div class="text_icon_main"><?php echo $this->lang->line('employ_main'); ?></div>
                                    </a>
                                </div>
                            </td>
                            <td width="395" valign="top">
                                <table width="100%" class="infomain" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="25" class="title_infomain" colspan="3"><?php echo $this->lang->line('title_info'); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_user_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('user_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $userDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('active_action'); ?>: <font color="#FF0000"><?php echo $activeUserDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_vip_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('vip_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $vipDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endVipDefaults; ?></font>)</span>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('active_action'); ?>: <font color="#FF0000"><?php echo $activeVipDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_shop_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('shop_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $shopDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endShopDefaults; ?></font>)</span>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('active_action'); ?>: <font color="#FF0000"><?php echo $activeShopDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_product_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('product_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $productDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endProductDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_ads_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('ads_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $adsDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endAdsDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_job_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('job_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $jobDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endJobDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_employ_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('employ_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $employDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endEmployDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_advertise_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('advertise_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $advertiseDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('end_action'); ?>: <font color="#FF0000"><?php echo $endAdvertiseDefaults; ?></font>)</span>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('active_action'); ?>: <font color="#FF0000"><?php echo $activeAdvertiseDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_contact_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('contact_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $contactDefaults; ?>
                                            <span class="expand_infomain">(<?php echo $this->lang->line('not_view_action'); ?>: <font color="#FF0000"><?php echo $notViewContactDefaults; ?></font>)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_badpro_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('product_bad_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $productBadDefaults; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="img_infomain"><img src="<?php echo base_url(); ?>templates/admin/images/icon_badads_infomain.gif" border="0" /></td>
                                        <td width="100" class="list_infomain"><?php echo $this->lang->line('ads_bad_info'); ?>:</td>
                                        <td class="content_infomain">
                                            <?php echo $adsBadDefaults; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!--END Main-->
                </td>
                <td width="10" class="right_main" valign="top"></td>
                <td width="2"></td>
            </tr>
            <tr>
                <td width="2" height="11"></td>
                <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                <td height="11" class="middle_bottom_main"></td>
                <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                <td width="2" height="11"></td>
            </tr>
        </table>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>