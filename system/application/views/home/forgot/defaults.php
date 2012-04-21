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
                <table width="500" class="form_main" border="0" style="margin-left:45px;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="20" class="form_top"></td>
                    </tr>
                    <?php if($successForgot == false){ ?>
                    <form name="frmForgotPassword" method="post">
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" cellpadding="3" cellspacing="2">
                                <tr>
                                    <td colspan="2" height="15"></td>
                                </tr>
                                <tr>
                                    <td height="20"></td>
                                    <td height="20" align="left"><?php echo form_error('email_forgot'); ?></td>
								</tr>
                                <tr>
                                    <td width="80" class="list_formlogin"><?php echo $this->lang->line('username_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="username_forgot" id="username_forgot" value="<?php if(isset($username_forgot)){echo $username_forgot;} ?>" maxlength="35" class="input_form" style="width:180px;" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('username_forgot',1)" onblur="ChangeStyle('username_forgot',2)" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="80" class="list_formlogin"><?php echo $this->lang->line('email_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="email_forgot" id="email_forgot" value="<?php if(isset($email_forgot)){echo $email_forgot;} ?>" maxlength="50" class="input_form" style="width:180px;" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_forgot',1)" onblur="ChangeStyle('email_forgot',2)" />
                                    </td>
                                </tr>
                                <?php if(isset($imageCaptchaForgot)){ ?>
                                <tr>
                                    <td width="80" class="list_formlogin"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                    <td align="left">
                                        <img src="<?php echo base_url().$imageCaptchaForgot; ?>" width="151" height="30" /><br />
                                        <input type="text" name="captcha_forgot" id="captcha_forgot" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_forgot',1);" onblur="ChangeStyle('captcha_forgot',2);" />
                                        <?php echo form_error('captcha_forgot'); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td height="30"></td>
                                    <td height="30" valign="bottom" align="left" style="padding-left:45px;">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td><input type="button" onclick="CheckInput_Forgot();" name="submit_forgot" value="<?php echo $this->lang->line('button_agree_defaults'); ?>" class="button_form" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="70"></td>
                                    <td style="padding-top:5px; text-align:left;"><a class="re_login" href="<?php echo base_url(); ?>login"><img src="<?php echo base_url(); ?>templates/home/images/re_login.gif" border="0">&nbsp;&nbsp;<?php echo $this->lang->line('login_defaults'); ?></a></td>
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