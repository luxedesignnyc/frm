<?php $this->load->view('home/common/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/jScrollPane.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/simplemodal.css" media='screen' />
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jquery.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jScrollPane.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/simplemodal.js"></script>
<!-- IE 6 "fixes" -->
<!--[if lt IE 7]>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/simplemodal_ie.css" media='screen' />
<![endif]-->
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
				<?php if($stopRegister == false){ ?>
				<?php if($successRegister == false){ ?>
                <div class="note_post">
                    <img src="<?php echo base_url(); ?>templates/home/images/note_post.gif" border="0" width="20" height="20" />&nbsp;
                    <b><font color="#FD5942"><?php echo $this->lang->line('note_help'); ?>:</font></b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="#FF0000"><b>*</b></font>&nbsp;&nbsp;<?php echo $this->lang->line('must_input_help'); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" />&nbsp;&nbsp;<?php echo $this->lang->line('input_help'); ?>
                </div>
                <?php } ?>
                <?php } ?>
                <table width="585" class="post_main" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2" height="20" class="post_top"></td>
                    </tr>
                    <?php if($stopRegister == false){ ?>
                    <?php if($successRegister == false){ ?>
                    <form name="frmRegister" method="post">
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('username_defaults'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($username_regis)){echo $username_regis;} ?>" name="username_regis" id="username_regis" maxlength="35" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('username_regis',1)" onblur="ChangeStyle('username_regis',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('username_tip_help') ?>',275,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('username_help'); ?>)</span>
                            <?php echo form_error('username_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('password_defaults'); ?>:</td>
                        <td>
                            <input type="password" value="" name="password_regis" id="password_regis" maxlength="35" class="input_formpost" onfocus="ChangeStyle('password_regis',1)" onblur="ChangeStyle('password_regis',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('password_tip_help') ?>',275,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('password_help'); ?>)</span>
                            <?php echo form_error('password_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('repassword_defaults'); ?>:</td>
                        <td>
                            <input type="password" value="" name="repassword_regis" id="repassword_regis" maxlength="35" class="input_formpost" onfocus="ChangeStyle('repassword_regis',1)" onblur="ChangeStyle('repassword_regis',2)" />
                            <?php echo form_error('repassword_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_defaults'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($email_regis)){echo $email_regis;} ?>" name="email_regis" id="email_regis" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_regis',1)" onblur="ChangeStyle('email_regis',2)" />
                            <?php echo form_error('email_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('reemail_defaults'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($reemail_regis)){echo $reemail_regis;} ?>" name="reemail_regis" id="reemail_regis" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('reemail_regis',1)" onblur="ChangeStyle('reemail_regis',2)" />
                            <?php echo form_error('reemail_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('fullname_defaults'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($fullname_regis)){echo $fullname_regis;} ?>" name="fullname_regis" id="fullname_regis" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmRegister','fullname_regis');" onfocus="ChangeStyle('fullname_regis',1)" onblur="ChangeStyle('fullname_regis',2)" />
                            <?php echo form_error('fullname_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('birthday_defaults'); ?>:</td>
                        <td>
                            <select name="day_regis" id="day_regis" class="selectdate_formpost">
                                <?php for($day = 1; $day <= 31; $day++){ ?>
                                <?php if(isset($day_regis) && $day_regis == $day){ ?>
                                <option value="<?php echo $day; ?>" selected="selected"><?php echo $day; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <b>-</b>
                            <select name="month_regis" id="month_regis" class="selectdate_formpost">
                                <?php for($month = 1; $month <= 12; $month++){ ?>
                                <?php if(isset($month_regis) && $month_regis == $month){ ?>
                                <option value="<?php echo $month; ?>" selected="selected"><?php echo $month; ?></option>
                                <?php }elseif($month == (int)date('m') && $month_regis == ''){ ?>
                                <option value="<?php echo $month; ?>" selected="selected"><?php echo $month; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <b>-</b>
                            <select name="year_regis" id="year_regis" class="selectdate_formpost">
                                <?php for($year = (int)date('Y')-70; $year <= (int)date('Y')-10; $year++){ ?>
                                <?php if(isset($year_regis) && $year_regis == $year){ ?>
                                <option value="<?php echo $year; ?>" selected="selected"><?php echo $year; ?></option>
                                <?php }elseif($year == (int)date('Y')-18 && $year_regis == ''){ ?>
                                <option value="<?php echo $year; ?>" selected="selected"><?php echo $year; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('sex_defaults'); ?>:</td>
                        <td>
                            <select name="sex_regis" id="sex_regis" class="selectsex_formpost" style="width:60px;">
                                <option value="1" <?php if(isset($sex_regis) && $sex_regis == '1'){echo 'selected="selected"';}elseif(!isset($sex_regis)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('male_defaults'); ?></option>
                                <option value="0" <?php if(isset($sex_regis) && $sex_regis == '0'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('female_defaults'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_defaults'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($address_regis)){echo $address_regis;} ?>" name="address_regis" id="address_regis" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmRegister','address_regis');" onfocus="ChangeStyle('address_regis',1)" onblur="ChangeStyle('address_regis',2)" />
                            <?php echo form_error('address_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_defaults'); ?>:</td>
                        <td>
                            <select name="province_regis" id="province_regis" class="selectprovince_formpost">
                                <?php foreach($province as $provinceArray){ ?>
                                <?php if(isset($province_regis) && $province_regis == $provinceArray->pre_id){ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_defaults'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($phone_regis)){echo $phone_regis;} ?>" name="phone_regis" id="phone_regis" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_regis',1)" onblur="ChangeStyle('phone_regis',2)" />
                            <b>-</b>
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($mobile_regis)){echo $mobile_regis;} ?>" name="mobile_regis" id="mobile_regis" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_regis',1)" onblur="ChangeStyle('mobile_regis',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phone_regis'); ?>
                            <?php echo form_error('mobile_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_defaults'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($yahoo_regis)){echo $yahoo_regis;} ?>" name="yahoo_regis" id="yahoo_regis" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_regis',1)" onblur="ChangeStyle('yahoo_regis',2)" />
                            <?php echo form_error('yahoo_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_defaults'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($skype_regis)){echo $skype_regis;} ?>" name="skype_regis" id="skype_regis" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_regis',1)" onblur="ChangeStyle('skype_regis',2)" />
                            <?php echo form_error('skype_regis'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"></td>
                        <td class="special_regis">
                        	<!--BEGIN: Guide Register-->
                            <div id="DivGuideRegisterVip" style="display:none; line-height:18px; text-align:justify; font-size:12px;"><?php echo $this->lang->line('guide_regis_vip_defaults'); ?></div>
                            <div id="DivGuideRegisterShop" style="display:none; line-height:18px; text-align:justify; font-size:12px;"><?php echo $this->lang->line('guide_regis_shop_defaults'); ?></div>
                            <script type='text/javascript'>
							function guideRegister(div, divContent)
							{
								if(document.getElementById(div).checked == true)
								{
									$("#" + divContent).modal({onOpen: function (dialog) {
										dialog.overlay.fadeIn('fast', function () {
											dialog.data.hide();
											dialog.container.fadeIn('fast', function () {
												dialog.data.slideDown('fast');
											});
										});
									}});
								}
							}
							</script>
                            <!--END Guide Register-->
                            <input type="checkbox" <?php if($stopRegisterVip == true){echo 'disabled="disabled"';} ?> name="vip_regis" id="vip_regis" value="1" <?php if(isset($vip_regis) && $vip_regis == '1'){echo 'checked="checked"';} ?> onclick="ChangeCheckBox('shop_regis'); ChangeLawRegister(this.checked,1); guideRegister('vip_regis', 'DivGuideRegisterVip');" />
                            <?php echo $this->lang->line('regis_vip_defaults'); ?><br /><br />
                            <input type="checkbox" <?php if($stopRegisterShop == true){echo 'disabled="disabled"';} ?> name="shop_regis" id="shop_regis" value="1" <?php if(isset($shop_regis) && $shop_regis == '1'){echo 'checked="checked"';} ?> onclick="ChangeCheckBox('vip_regis'); ChangeLawRegister(this.checked,2); guideRegister('shop_regis', 'DivGuideRegisterShop');" />
                            <?php echo $this->lang->line('regis_shop_defaults'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150"></td>
                        <td style="padding-top:13px;">
                            <table id="DivNormalRegister" style="border:1px #CCCCCC solid;" width="380" align="left" cellpadding="0" cellspacing="0">
                                <tr height="29">
                                    <td style="background:url(<?php echo base_url(); ?>templates/home/images/bg_titlelaw.jpg) repeat-x; color:#FF0000; font-weight:bold; text-align:center; border-bottom:1px #CCCCCC solid;">
                                        <?php echo $this->lang->line('title_role_normal_defaults'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:$666; text-align:justify;">
                                    <div class="osX">
	                                    <div id="Panel_1" style="width:100%; height:185px; font-size:12px; overflow:auto;">
	                                        <div style="padding:5px;">
	                                        <!--NOI DUNG QUY DINH-->
	                                        <?php echo $this->lang->line('role_normal_defaults'); ?>
	                                        <!---->
	                                        </div>
	                                    </div>
                                    </div>
                                    </td>
                                </tr>
                            </table>
                            <table id="DivVipRegister" style="border:1px #CCCCCC solid;" width="380" align="left" cellpadding="0" cellspacing="0">
                                <tr height="29">
                                    <td style="background:url(<?php echo base_url(); ?>templates/home/images/bg_titlelaw.jpg) repeat-x; color:#FF0000; font-weight:bold; text-align:center; border-bottom:1px #CCCCCC solid;">
                                        <?php echo $this->lang->line('title_role_vip_defaults'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:$666; text-align:justify;">
                                    <div class="osX">
	                                    <div id="Panel_2" style="width:100%; height:185px; font-size:12px; overflow:auto;">
	                                        <div style="padding:5px;">
	                                        <!--NOI DUNG QUY DINH-->
	                                       	<?php echo $this->lang->line('role_vip_defaults'); ?>
	                                        <!---->
	                                        </div>
	                                    </div>
                                    </div>
                                    </td>
                                </tr>
                            </table>
                            <table id="DivShopRegister" style="border:1px #CCCCCC solid;" width="380" align="left" cellpadding="0" cellspacing="0">
                                <tr height="29">
                                    <td style="background:url(<?php echo base_url(); ?>templates/home/images/bg_titlelaw.jpg) repeat-x; color:#FF0000; font-weight:bold; text-align:center; border-bottom:1px #CCCCCC solid;">
                                        <?php echo $this->lang->line('title_role_saler_defaults'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:$666; text-align:justify;">
                                    <div class="osX">
	                                    <div id="Panel_3" style="width:100%; height:185px; font-size:12px; overflow:auto;">
	                                        <div style="padding:5px;">
	                                        <!--NOI DUNG QUY DINH-->
	                                        <?php echo $this->lang->line('role_saler_defaults'); ?>
	                                        <!---->
	                                        </div>
	                                    </div>
                                    </div>
                                    </td>
                                </tr>
                            </table>
                            <?php if(isset($vip_regis) && $vip_regis == '1'){ ?>
                            <script>ChangeCheckBox('shop_regis'); ChangeLawRegister(true,1);</script>
                            <?php }elseif(isset($shop_regis) && $shop_regis == '1'){ ?>
                            <script>ChangeCheckBox('vip_regis'); ChangeLawRegister(true,2);</script>
                            <?php }else{ ?>
                            <script>ChangeLawRegister('false',0);</script>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaRegister)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo base_url().$imageCaptchaRegister; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_regis" id="captcha_regis" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_regis',1);" onblur="ChangeStyle('captcha_regis',2);" />
                            <?php echo form_error('captcha_regis'); ?>
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
                                    <td><input type="button" onclick="CheckInput_Register();" name="submit_register" value="<?php echo $this->lang->line('button_register_defaults'); ?>" class="button_form" /></td>
                                    <td width="15"></td>
                                    <td><input type="reset" name="reset_register" value="<?php echo $this->lang->line('button_reset_defaults'); ?>" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post">
                            <meta http-equiv=refresh content="10; url=<?php echo base_url(); ?>">
                            <?php echo $this->lang->line('success_register_defaults'); ?><br />
                            <?php if($isActivation == true){ ?>
                            <?php if($successSendActivation == true){ ?>
                            <?php echo $this->lang->line('success_register_success_send_activation_defaults'); ?>
                            <?php }else{ ?>
                            <?php echo $this->lang->line('success_register_not_send_activation_defaults'); ?>
                            <?php } ?>
                            <?php }else{ ?>
                            <?php echo $this->lang->line('success_normal_defaults'); ?>
                            <?php } ?>
						</td>
					</tr>
                    <?php } ?>
                    <?php }else{ ?>
                    <tr>
                        <td class="stop_register">
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>">
                            <?php echo $this->lang->line('stop_regis_defaults'); ?>
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
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_left.png" height="16" ></td>
        </tr>
    </table>
</td>
<!--END LEFT-->
<?php $this->load->view('home/common/info'); ?>
<?php $this->load->view('home/common/footer'); ?>