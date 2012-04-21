<?php $this->load->view('shop/common/header'); ?>
<?php $this->load->view('shop/common/left'); ?>
<?php if(isset($siteGlobal)){ ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/check_email.js"></script>
<!--BEGIN: Center-->
<td width="602" valign="top" align="center">
    <?php $this->load->view('shop/common/top'); ?>
    <table width="594" class="table_module" style="margin-top:5px;" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td height="28" class="title_module"><?php echo $this->lang->line('title_detail_contact'); ?></td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <table width="585" class="form_main" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="20" class="form_top"></td>
                    </tr>
                    <?php if($successContactShopDetail == false){ ?>
                    <form name="frmContact" method="post">
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" cellpadding="3" cellspacing="2">
                                <tr>
                                    <td colspan="2" height="5"></td>
                                </tr>
                                <tr>
                                    <td width="105" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('fullname_detail_contact'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="name_contact" id="name_contact" value="<?php if(isset($name_contact)){echo $name_contact;} ?>" maxlength="80" class="input_form" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmContact','name_contact');" onfocus="ChangeStyle('name_contact',1)" onblur="ChangeStyle('name_contact',2)" />
                                        <?php echo form_error('name_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="105" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_detail_contact'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="email_contact" id="email_contact" value="<?php if(isset($email_contact)){echo $email_contact;} ?>" maxlength="50" class="input_form" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_contact',1)" onblur="ChangeStyle('email_contact',2)" />
                                        <?php echo form_error('email_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="105" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_detail_contact'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="address_contact" id="address_contact" value="<?php if(isset($address_contact)){echo $address_contact;} ?>" maxlength="80" class="input_form" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmContact','address_contact');" onfocus="ChangeStyle('address_contact',1)" onblur="ChangeStyle('address_contact',2)" />
                                        <?php echo form_error('address_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="105" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_detail_contact'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="phone_contact" id="phone_contact" value="<?php if(isset($phone_contact)){echo $phone_contact;} ?>" maxlength="50" class="input_form" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('phone_contact',1)" onblur="ChangeStyle('phone_contact',2)" />
                                        <?php echo form_error('phone_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="105" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_contact_detail_contact'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="title_contact" id="title_contact" value="<?php if(isset($title_contact)){echo $title_contact;} ?>" maxlength="80" class="input_form" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_contact',1);" onblur="ChangeStyle('title_contact',2);" />
                                        <?php echo form_error('title_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="105" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('content_detail_contact'); ?>:</td>
                                    <td align="left">
                                        <table border="0" align="left" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <textarea name="content_contact" id="content_contact" cols="47" rows="8" class="textarea_form" onfocus="ChangeStyle('content_contact',1);" onblur="ChangeStyle('content_contact',2);"><?php if(isset($content_contact)){echo $content_contact;} ?></textarea>
                                                    <?php echo form_error('content_contact'); ?>
                                                </td>
                                                <td style="padding-left:5px;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php if(isset($imageCaptchaContactShopDetail)){ ?>
                                <tr>
                                    <td width="105" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                                    <td align="left">
                                        <img src="<?php echo base_url().$imageCaptchaContactShopDetail; ?>" width="151" height="30" /><br />
                                        <input type="text" name="captcha_contact" id="captcha_contact" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_contact',1);" onblur="ChangeStyle('captcha_contact',2);" />
                                        <?php echo form_error('captcha_contact'); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td height="30"></td>
                                    <td height="30" valign="bottom" align="center">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td><input type="button" onclick="CheckInput_Contact();" name="submit_contact" value="<?php echo $this->lang->line('button_send_detail_contact'); ?>" class="button_form" /></td>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_contact" value="<?php echo $this->lang->line('button_reset_detail_contact'); ?>" class="button_form" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post">
                            <meta http-equiv=refresh content="5; url=<?php echo base_url().$siteGlobal->sho_link; ?>">
                            <?php echo $this->lang->line('success_detail_contact'); ?>
						</td>
					</tr>
                    <?php } ?>
                    <tr>
                        <td height="25" class="form_bottom"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="10" class="bottom_module"></td>
        </tr>
    </table>
</td>
<!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/right'); ?>
<?php $this->load->view('shop/common/footer'); ?>