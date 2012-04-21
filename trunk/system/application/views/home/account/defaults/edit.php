<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_edit_account'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" >
                <?php if($successEditAccount == false){ ?>
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
                        <td colspan="2" height="30" class="post_top"></td>
                    </tr>
                    <?php if($successEditAccount == false){ ?>
                    <form name="frmEditAccount" method="post">
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('username_edit_account'); ?>:</td>
                        <td style="color:#06F; font-weight:bold; text-align:left; padding-top:7px;">
                            <?php if(isset($username_account)){echo $username_account;} ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_edit_account'); ?>:</td>
                        <td>
                            <input type="text" name="email_account" id="email_account" value="<?php if(isset($email_account)){echo $email_account;} ?>" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_account',1)" onblur="ChangeStyle('email_account',2)" />
                            <?php echo form_error('email_account'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('reemail_edit_account'); ?>:</td>
                        <td>
                            <input type="text" name="reemail_account" id="reemail_account" value="<?php if(isset($reemail_account)){echo $reemail_account;} ?>" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('reemail_account',1)" onblur="ChangeStyle('reemail_account',2)" />
                            <?php echo form_error('reemail_account'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('fullname_edit_account'); ?>:</td>
                        <td>
                            <input type="text" name="fullname_account" id="fullname_account" value="<?php if(isset($fullname_account)){echo $fullname_account;} ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditAccount','fullname_account');" onfocus="ChangeStyle('fullname_account',1)" onblur="ChangeStyle('fullname_account',2)" />
                            <?php echo form_error('fullname_account'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('birthday_edit_account'); ?>:</td>
                        <td>
                            <select name="day_account" id="day_account" class="selectdate_formpost">
                                <?php for($day = 1; $day <= 31; $day++){ ?>
                            	<?php if(isset($day_account) && (int)$day_account == $day){ ?>
	                            <option value="<?php echo $day; ?>" selected="selected"><?php echo $day; ?></option>
	                            <?php }else{ ?>
	                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
	                            <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="month_account" id="month_account" class="selectdate_formpost">
                                <?php for($month = 1; $month <= 12; $month++){ ?>
	                            <?php if(isset($month_account) && (int)$month_account == $month){ ?>
	                          	<option value="<?php echo $month; ?>" selected="selected"><?php echo $month; ?></option>
	                      		<?php }else{ ?>
	                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
	                            <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="year_account" id="year_account" class="selectdate_formpost">
                                <?php for($year = (int)date('Y')-70; $year <= (int)date('Y')-10; $year++){ ?>
	                          	<?php if(isset($year_account) && (int)$year_account == $year){ ?>
	                           	<option value="<?php echo $year; ?>" selected="selected"><?php echo $year; ?></option>
	                          	<?php }else{ ?>
	                          	<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
	                         	<?php } ?>
								<?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('sex_edit_account'); ?>:</td>
                        <td>
                            <select name="sex_account" id="sex_account" class="selectsex_formpost" style="width:60px;">
                                <option value="1" <?php if(isset($sex_account) && (int)$sex_account == 1){echo 'selected="selected"';} ?>><?php echo $this->lang->line('male_edit_account'); ?></option>
                                <option value="0" <?php if(isset($sex_account) && (int)$sex_account == 0){echo 'selected="selected"';} ?>><?php echo $this->lang->line('female_edit_account'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_edit_account'); ?>:</td>
                        <td>
                            <input type="text" name="address_account" id="address_account" value="<?php if(isset($address_account)){echo $address_account;} ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditAccount','address_account');" onfocus="ChangeStyle('address_account',1)" onblur="ChangeStyle('address_account',2)" />
                            <?php echo form_error('address_account'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_edit_account'); ?>:</td>
                        <td>
                            <select name="province_account" id="province_account" class="selectprovince_formpost">
                                <?php foreach($province as $provinceArray){ ?>
								<?php if(isset($province_account) && $province_account == $provinceArray->pre_id){ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province_account'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_edit_account'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" name="phone_account" id="phone_account" value="<?php if(isset($phone_account)){echo $phone_account;} ?>" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_account',1)" onblur="ChangeStyle('phone_account',2)" />
                            <b>-</b>
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" name="mobile_account" id="mobile_account" value="<?php if(isset($mobile_account)){echo $mobile_account;} ?>" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_account',1)" onblur="ChangeStyle('mobile_account',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span>
                            <?php echo form_error('phone_account'); ?>
                            <?php echo form_error('mobile_account'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_edit_account'); ?>:</td>
                        <td>
                            <input type="text" name="yahoo_account" id="yahoo_account" value="<?php if(isset($yahoo_account)){echo $yahoo_account;} ?>" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_account',1)" onblur="ChangeStyle('yahoo_account',2)" />
                            <?php echo form_error('yahoo_account'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_edit_account'); ?>:</td>
                        <td>
                            <input type="text" name="skype_account" id="skype_account" value="<?php if(isset($skype_account)){echo $skype_account;} ?>" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_account',1)" onblur="ChangeStyle('skype_account',2)" />
                            <?php echo form_error('skype_account'); ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaEditAccount)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo base_url().$imageCaptchaEditAccount; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_account" id="captcha_account" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_account',1);" onblur="ChangeStyle('captcha_account',2);" />
                            <?php echo form_error('captcha_account'); ?>
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
                                    <td><input type="button" onclick="CheckInput_EditAccount();" name="submit_editaccount" value="<?php echo $this->lang->line('button_update_edit_account'); ?>" class="button_form" /></td>
                                    <td width="15"></td>
                                    <td><input type="button" name="reset_editaccount" value="<?php echo $this->lang->line('button_cancle_edit_account'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account')" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <input type="hidden" name="isPostAccount" value="1" />
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post" style="padding-top: 10px;">
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>account">
                            <?php echo $this->lang->line('success_edit_account'); ?>
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