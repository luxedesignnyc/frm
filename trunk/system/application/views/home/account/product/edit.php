<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_product_edit'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" >
                <?php if($successEditProductAccount == false){ ?>
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
                    <?php if($successEditProductAccount == false){ ?>
                    <form name="frmEditPro" method="post" enctype="multipart/form-data">
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_product_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($name_pro)){echo $name_pro;} ?>" name="name_pro" id="name_pro" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('name_pro',1)" onblur="ChangeStyle('name_pro',2)" />
                            <?php echo form_error('name_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('descr_product_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($descr_pro)){echo $descr_pro;} ?>" name="descr_pro" id="descr_pro" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_pro',1)" onblur="ChangeStyle('descr_pro',2)" />
                            <?php echo form_error('descr_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('cost_product_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($cost_pro)){echo $cost_pro;} ?>" name="cost_pro" id="cost_pro" maxlength="9" class="inputcost_formpost" onkeyup="FormatCurrency('DivShowCost','currency_pro',this.value); BlockChar(this,'NotNumbers');" onclick="ChangeCheckBox('nonecost_pro'); ChangeStyleTextBox('cost_pro','DivShowCost',document.getElementById('nonecost_pro').checked);" onfocus="ChangeStyle('cost_pro',1)" onblur="ChangeStyle('cost_pro',2)" />
                            <select name="currency_pro" id="currency_pro" class="selectcurrency_formpost" onchange="FormatCurrency('DivShowCost','currency_pro',document.getElementById('cost_pro').value)">
                                <option value="VND" <?php if(isset($currency_pro) && $currency_pro == 'VND'){echo 'selected="selected"';}elseif(!isset($currency_pro)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('vnd_product_edit'); ?></option>
                                <option value="USD" <?php if(isset($currency_pro) && $currency_pro == 'USD'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('usd_product_edit'); ?></option>
                            </select>
                            <span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                            <div id="DivShowCost"></div>
                            <?php echo form_error('cost_pro'); ?>
                            <div class="none_cost">
                                <input type="checkbox" name="nonecost_pro" id="nonecost_pro" value="1" <?php if(isset($nonecost_pro) && $nonecost_pro == '1'){echo 'checked="checked"';} ?> onclick="ChangeStyleTextBox('cost_pro','DivShowCost',this.checked); ChangeCheckBox('nego_pro');" />
                                <?php echo $this->lang->line('none_cost_product_edit'); ?> <font color="#FF0000">(<?php echo $this->lang->line('call_product_edit'); ?>)</font>&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="nego_pro" id="nego_pro" value="1" <?php if(isset($nego_pro) && $nego_pro == '1'){echo 'checked="checked"';} ?> onclick="ChangeCheckBox('nonecost_pro')" />
                                <?php echo $this->lang->line('hondle_product_edit'); ?>
                            </div>
                            <div class="saleoff">
                                <input type="checkbox" name="saleoff_pro" id="saleoff_pro" value="1" <?php if(isset($saleoff_pro) && $saleoff_pro == '1'){echo 'checked="checked"';} ?> />
                                <?php echo $this->lang->line('saleoff_product_edit'); ?>&nbsp;&nbsp;<img src="<?php echo base_url(); ?>templates/home/images/saleoff.gif" border="0" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_product_edit'); ?>:</td>
                        <td>
                            <select name="province_pro" id="province_pro" class="selectprovince_formpost">
                                <?php foreach($province as $provinceArray){ ?>
                                <?php if(isset($province_pro) && $province_pro == $provinceArray->pre_id){ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('category_product_edit'); ?>:</td>
                        <td>
                            <select name="category_pro" id="category_pro" class="selectcategory_formpost">
                                <?php foreach($category as $categoryArray){ ?>
                                <?php if(isset($category_pro) && $category_pro == $categoryArray->cat_id){ ?>
                                <option value="<?php echo $categoryArray->cat_id; ?>" selected="selected"><?php echo $categoryArray->cat_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $categoryArray->cat_id; ?>"><?php echo $categoryArray->cat_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('category_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_product_edit'); ?>:</td>
                        <td>
                            <select name="day_pro" id="day_pro" class="selectdate_formpost">
                                <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                                <?php if(isset($day_pro) && (int)$day_pro == $endday){ ?>
                                <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="month_pro" id="month_pro" class="selectdate_formpost">
                                <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                                <?php if(isset($month_pro) && (int)$month_pro == $endmonth){ ?>
                                <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="year_pro" id="year_pro" class="selectdate_formpost">
                                <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+2; $endyear++){ ?>
                                <?php if(isset($year_pro) && (int)$year_pro == $endyear){ ?>
                                <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('enddate_tip_help') ?>',235,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('enddate_help'); ?>)</span>
                            <?php echo form_error('day_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('detail_product_edit'); ?>:</td>
                        <td style="padding-top:7px;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <?php $this->load->view('home/common/editor'); ?>
                                        <?php echo form_error('txtContent'); ?>
                                    </td>
                                    <td style="padding-top:7px;">
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('detail_tip_help') ?>',400,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
									</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('image_1_product_edit'); ?>:</td>
                        <td>
                            <input type="file" name="image_1_pro" id="image_1_pro" class="inputimage_formpost" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('image_tip_help') ?>',285,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('image_help'); ?>)</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('image_2_product_edit'); ?>:</td>
                        <td>
                            <input type="file" name="image_2_pro" id="image_2_pro" class="inputimage_formpost" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('image_tip_help') ?>',285,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('image_help'); ?>)</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('image_3_product_edit'); ?>:</td>
                        <td>
                            <input type="file" name="image_3_pro" id="image_3_pro" class="inputimage_formpost" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('image_tip_help') ?>',285,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('image_help'); ?>)</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('poster_product_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($fullname_pro)){echo $fullname_pro;} ?>" name="fullname_pro" id="fullname_pro" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostPro','fullname_pro');" onfocus="ChangeStyle('fullname_pro',1)" onblur="ChangeStyle('fullname_pro',2)" />
                            <?php echo form_error('fullname_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_product_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($address_pro)){echo $address_pro;} ?>" name="address_pro" id="address_pro" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostPro','address_pro');" onfocus="ChangeStyle('address_pro',1)" onblur="ChangeStyle('address_pro',2)" />
                            <?php echo form_error('address_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_product_edit'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($phone_pro)){echo $phone_pro;} ?>" name="phone_pro" id="phone_pro" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_pro',1)" onblur="ChangeStyle('phone_pro',2)" />
                            <b>-</b>
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($mobile_pro)){echo $mobile_pro;} ?>" name="mobile_pro" id="mobile_pro" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_pro',1)" onblur="ChangeStyle('mobile_pro',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phone_pro'); ?>
                            <?php echo form_error('mobile_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_product_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($email_pro)){echo $email_pro;} ?>" name="email_pro" id="email_pro" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_pro',1)" onblur="ChangeStyle('email_pro',2)" />
                            <?php echo form_error('email_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_product_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($yahoo_pro)){echo $yahoo_pro;} ?>" name="yahoo_pro" id="yahoo_pro" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_pro',1)" onblur="ChangeStyle('yahoo_pro',2)" />
                            <?php echo form_error('yahoo_pro'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_product_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($skype_pro)){echo $skype_pro;} ?>" name="skype_pro" id="skype_pro" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_pro',1)" onblur="ChangeStyle('skype_pro',2)" />
                            <?php echo form_error('skype_pro'); ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaEditProductAccount)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo base_url().$imageCaptchaEditProductAccount; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_pro" id="captcha_pro" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_pro',1);" onblur="ChangeStyle('captcha_pro',2);" />
                            <?php echo form_error('captcha_pro'); ?>
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
                                    <td><input type="button" onclick="CheckInput_EditPro();" name="submit_editpro" value="<?php echo $this->lang->line('button_agree_product_edit'); ?>" class="button_form" /></td>
                                    <td width="15"></td>
                                    <td><input type="button" onclick="ActionLink('<?php echo base_url(); ?>account/product');" name="reset_editpro" value="<?php echo $this->lang->line('button_cancel_product_edit'); ?>" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post" style="padding-top:10px;">
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>account/product">
                            <?php echo $this->lang->line('success_product_edit'); ?>
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