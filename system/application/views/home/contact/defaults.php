<?php $this->load->view('home/common/header'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: LEFT-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_left.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_left.jpg" style="padding-left:4px;" valign="top" >
                <?php if($successContact == false){ ?>
                <div class="note_post">
                    <img src="<?php echo base_url(); ?>templates/home/images/note_post.gif" border="0" width="20" height="20" />&nbsp;
                    <b><font color="#FD5942"><?php echo $this->lang->line('note_help'); ?>:</font></b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="#FF0000"><b>*</b></font>&nbsp;&nbsp;<?php echo $this->lang->line('must_input_help'); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" />&nbsp;&nbsp;<?php echo $this->lang->line('input_help'); ?>
                </div>
                <?php } ?>
                <table width="500" class="form_main" border="0" style="margin-left:45px;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="20" class="form_top"></td>
                    </tr>
                    <?php if($successContact == false){ ?>
                    <form name="frmContact" method="post">
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" cellpadding="3" cellspacing="2">
                                <tr>
                                    <td colspan="2" height="15"></td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('fullname_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="name_contact" id="name_contact" value="<?php if(isset($name_contact)){echo $name_contact;} ?>" maxlength="80" class="input_form" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmContact','name_contact');" onfocus="ChangeStyle('name_contact',1)" onblur="ChangeStyle('name_contact',2)" />
                                        <?php echo form_error('name_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="email_contact" id="email_contact" value="<?php if(isset($email_contact)){echo $email_contact;} ?>" maxlength="50" class="input_form" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_contact',1)" onblur="ChangeStyle('email_contact',2)" />
                                        <?php echo form_error('email_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="address_contact" id="address_contact" value="<?php if(isset($address_contact)){echo $address_contact;} ?>" maxlength="80" class="input_form" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmContact','address_contact');" onfocus="ChangeStyle('address_contact',1)" onblur="ChangeStyle('address_contact',2)" />
                                        <?php echo form_error('address_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="phone_contact" id="phone_contact" value="<?php if(isset($phone_contact)){echo $phone_contact;} ?>" maxlength="50" class="input_form" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('phone_contact',1)" onblur="ChangeStyle('phone_contact',2)" />
                                        <?php echo form_error('phone_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_contact_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="title_contact" id="title_contact" value="<?php if(isset($title_contact)){echo $title_contact;} ?>" maxlength="80" class="input_form" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_contact',1);" onblur="ChangeStyle('title_contact',2);" />
                                        <?php echo form_error('title_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('position_defaults'); ?>:</td>
                                    <td align="left">
                                        <select name="position_contact" id="position_contact" class="selectposition_contact">
                                            <option value="<?php echo $this->lang->line('business_defaults'); ?>" <?php if(isset($position_contact) && $position_contact == $this->lang->line('business_defaults')){echo 'selected="selected"';}elseif(!isset($position_contact)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('business_defaults'); ?></option>
                                            <option value="<?php echo $this->lang->line('tech_defaults'); ?>" <?php if(isset($position_contact) && $position_contact == $this->lang->line('tech_defaults')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('tech_defaults'); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('content_defaults'); ?>:</td>
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
                                <?php if(isset($imageCaptchaContact)){ ?>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                                    <td align="left">
                                        <img src="<?php echo base_url().$imageCaptchaContact; ?>" width="151" height="30" /><br />
                                        <input type="text" name="captcha_contact" id="captcha_contact" value="" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_contact',1);" onblur="ChangeStyle('captcha_contact',2);" />
                                        <?php echo form_error('captcha_contact'); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td height="30"></td>
                                    <td height="30" valign="bottom" align="center">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td><input type="button" onclick="CheckInput_Contact();" name="submit_contact" value="<?php echo $this->lang->line('button_send_defaults'); ?>" class="button_form" /></td>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_contact" value="<?php echo $this->lang->line('button_reset_defaults'); ?>" class="button_form" /></td>
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
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>">
                            <?php echo $this->lang->line('success_defaults'); ?>
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
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_left.png" height="16" ></td>
        </tr>
    </table>
</td>
<!--END LEFT-->
<?php $this->load->view('home/common/info'); ?>
<?php $this->load->view('home/common/footer'); ?>