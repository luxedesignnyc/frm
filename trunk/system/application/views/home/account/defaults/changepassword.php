<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_change_password'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" >
                <?php if($successChangePasswordAccount == false){ ?>
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
                        <td colspan="2" height="35" class="post_top"></td>
                    </tr>
                    <?php if($successChangePasswordAccount == false){ ?>
                    <form name="frmChangePassword" method="post">
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('old_password_change_password'); ?>:</td>
                        <td>
                            <input type="password" value="" name="oldpassword_changepass" id="oldpassword_changepass" maxlength="35" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('oldpassword_changepass',1)" onblur="ChangeStyle('oldpassword_changepass',2)" />
                            <?php echo form_error('oldpassword_changepass'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('new_password_change_password'); ?>:</td>
                        <td>
                            <input type="password" value="" name="password_changepass" id="password_changepass" maxlength="35" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('password_changepass',1)" onblur="ChangeStyle('password_changepass',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('new_password_tip_help_change_password'); ?>',305,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <?php echo form_error('password_changepass'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('renew_password_change_password'); ?>:</td>
                        <td>
                            <input type="password" value="" name="repassword_changepass" id="repassword_changepass" maxlength="35" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('repassword_changepass',1)" onblur="ChangeStyle('repassword_changepass',2)" />
                            <?php echo form_error('repassword_changepass'); ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaChangePasswordAccount)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo base_url().$imageCaptchaChangePasswordAccount; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_changepass" id="captcha_changepass" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_changepass',1);" onblur="ChangeStyle('captcha_changepass',2);" />
                            <?php echo form_error('captcha_changepass'); ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td width="150"></td>
                        <td height="30" valign="bottom" align="center">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="3" height="25"></td>
                                </tr>
                                <tr>
                                    <td><input type="button" onclick="CheckInput_ChangePassword();" name="submit_changepass" value="<?php echo $this->lang->line('button_update_change_password'); ?>" class="button_form" /></td>
                                    <td width="15"></td>
                                    <td><input type="button" name="reset_changepass" value="<?php echo $this->lang->line('button_cancel_change_password'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account')" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post" style="padding-top: 10px;">
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>account">
                            <?php echo $this->lang->line('success_change_password'); ?>
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