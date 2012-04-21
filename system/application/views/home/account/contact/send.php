<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_contact_send'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" >
                <?php if($successSendContactAccount == false){ ?>
                <div class="notepost_account">
                    <img src="<?php echo base_url(); ?>templates/home/images/note_post.gif" border="0" width="20" height="20" />&nbsp;
                    <b><font color="#FD5942"><?php echo $this->lang->line('note_help'); ?>:</font></b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="#FF0000"><b>*</b></font>&nbsp;&nbsp;<?php echo $this->lang->line('must_input_help'); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" />&nbsp;&nbsp;<?php echo $this->lang->line('input_help'); ?>
                </div>
                <?php } ?>
                <table width="585" class="post_main" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2" height="20" class="post_top"></td>
                    </tr>
                    <?php if($successSendContactAccount == false){ ?>
                    <form name="frmContactAccount" method="post">
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" cellpadding="3" cellspacing="2">
                                <tr>
                                    <td colspan="2" height="15"></td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_list_contact_send'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="title_contact" id="title_contact" value="<?php if(isset($title_contact)){echo $title_contact;} ?>" maxlength="80" class="input_form" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_contact',1);" onblur="ChangeStyle('title_contact',2);" />
                                        <?php echo form_error('title_contact'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('position_list_contact_send'); ?>:</td>
                                    <td align="left">
                                        <select name="position_contact" id="position_contact" class="selectposition_contact">
                                            <option value="1" <?php if(isset($position_contact) && $position_contact == '1'){echo 'selected="selected"';}elseif(!isset($position_contact)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('business_contact_send'); ?></option>
                                            <option value="2" <?php if(isset($position_contact) && $position_contact == '2'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('tech_contact_send'); ?></option>
                                        </select>
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip_help_contact_send') ?>',220,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('content_list_contact_send'); ?>:</td>
                                    <td align="left">
                                        <table border="0" align="left" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <?php $this->load->view('home/common/editor'); ?>
                                                    <?php echo form_error('txtContent'); ?>
                                                </td>
                                                <td style="padding-left:5px;">
                                                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('txtcontent_tip_help_contact_send') ?>',350,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php if(isset($imageCaptchaSendContactAccount)){ ?>
                                <tr>
                                    <td width="110" class="list_form"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                                    <td align="left">
                                        <img src="<?php echo base_url().$imageCaptchaSendContactAccount; ?>" width="151" height="30" /><br />
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
                                                <td><input type="button" onclick="CheckInput_ContactAccount();" name="submit_contact" value="<?php echo $this->lang->line('button_send_contact_send'); ?>" class="button_form" /></td>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_contact" value="<?php echo $this->lang->line('button_reset_contact_send'); ?>" class="button_form" /></td>
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
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>account/contact">
                            <?php echo $this->lang->line('success_contact_send'); ?>
						</td>
					</tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" height="30" class="post_bottom"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_ac.png" height="16" ></td>
        </tr>
    </table>	
</td>					
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>