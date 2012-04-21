<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_account_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" align="left" >
                <table width="780" border="0" style="margin-left:13px;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="35"></td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/edit">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('account_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                   <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/changepassword">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_changepassword_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('change_password_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                    <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/notify">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_notify_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('notify_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                    <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/contact">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_mail_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('contact_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/contact/send">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_sendcontact_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('send_contact_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                   <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/ads">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_ads_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('ads_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                    <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/job">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_job_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('job_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                    <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/employ">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_employ_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('employ_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%" align="center" valign="top">
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/showcart">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_showcart_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('showcart_account_defaults'); ?></div>
                                        </a>
                                    </td>
                                   <td width="25%" align="center" valign="top">
                                        <?php if((int)$this->session->userdata('sessionGroup') != 1){ ?>
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/product">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_product_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('product_account_defaults'); ?></div>
                                        </a>
                                        <?php } ?>
                                    </td>
                                    <td width="25%" align="center" valign="top">
                                        <?php if((int)$this->session->userdata('sessionGroup') != 1){ ?>
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/customer">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_customer_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('customer_account_defaults'); ?></div>
                                        </a>
                                        <?php } ?>
                                    </td>
                                    <td width="25%" align="center" valign="top">
                                        <?php if((int)$this->session->userdata('sessionGroup') == 3){ ?>
                                        <a class="menu_1" href="<?php echo base_url(); ?>account/shop">
                                            <img src="<?php echo base_url(); ?>templates/home/images/item_shop_account.gif" border="0">
                                            <div class="title_menu_account"><?php echo $this->lang->line('shop_account_defaults'); ?></div>
                                        </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_ac.png" height="16" ></td>
        </tr>
    </table>	
</td>					
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>