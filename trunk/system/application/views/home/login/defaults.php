<?php $this->load->view('home/common/header'); ?>
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
                    <?php if(isset($successLogin) && $successLogin == false){ ?>
                    <?php if(isset($validLogin) && $validLogin == true){ ?>
                    <tr>
                        <td class="success_post">
                            <meta http-equiv=refresh content="10; url=<?php echo base_url(); ?>">
                            <?php echo $this->lang->line('valid_login_defaults'); ?>
						</td>
					</tr>
                    <?php }else{ ?>
                    <form name="frmLogin" method="post">
                    <tr>
                        <td valign="top">
                            <table border="0" width="100%" cellpadding="3" cellspacing="2">
                                <tr>
                                    <td colspan="2" height="15"></td>
                                </tr>
                                <tr>
                                    <td width="80" height="20"></td>
                                    <td height="20" class="div_errorpost" style="padding-left:26px;"><?php if(isset($errorLogin) && $errorLogin == true){echo $this->lang->line('error_message_defaults');} ?></td>
                                </tr>
                                <tr>
                                    <td width="80" class="list_formlogin"><?php echo $this->lang->line('username_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="text" name="UsernameLogin" id="UsernameLogin" maxlength="35" class="input_form" style="width:180px;" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('UsernameLogin',1)" onblur="ChangeStyle('UsernameLogin',2)" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="80" class="list_formlogin"><?php echo $this->lang->line('password_defaults'); ?>:</td>
                                    <td align="left">
                                        <input type="password" name="PasswordLogin" id="PasswordLogin" maxlength="35" class="input_form" style="width:180px;" onfocus="ChangeStyle('PasswordLogin',1)" onblur="ChangeStyle('PasswordLogin',2)" />
                                    </td>
                                </tr>
                                <tr>
                                    <td height="30"></td>
                                    <td height="30" valign="bottom" align="left" style="padding-left:45px;">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td><input type="button" onclick="CheckInput_Login();" name="submit_login" value="<?php echo $this->lang->line('button_login_defaults'); ?>" class="button_form" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="80"></td>
                                    <td style="padding-top:5px; text-align:left;"><a class="forgot_password" href="<?php echo base_url(); ?>forgot"><img src="<?php echo base_url(); ?>templates/home/images/forgot_password.gif" border="0">&nbsp;&nbsp;<?php echo $this->lang->line('forgot_defaults'); ?></a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php } ?>
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