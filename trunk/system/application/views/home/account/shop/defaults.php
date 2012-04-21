<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_shop_account'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" >
                <?php if($successEditShopAccount == false){ ?>
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
                    <?php if($successEditShopAccount == false){ ?>
                    <form name="frmEditShop" method="post" enctype="multipart/form-data">
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('logo_shop_account'); ?>:</td>
                        <td>
                            <input type="file" name="logo_shop" id="logo_shop" class="inputimage_formpost" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_view_logo.gif" onmouseover="ddrivetip_image('<img src=\'<?php echo base_url(); ?>media/shop/logos/<?php if(isset($dir_logo_shop)){echo $dir_logo_shop;} ?>/<?php if(isset($logo_shop)){echo $logo_shop;} ?>\' border=0>',1,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('logo_tip_help'); ?>',270,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('logo_help'); ?>)</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('link_shop_account'); ?>:</td>
                        <td style="color:#06F; font-weight:bold; text-align:left; padding-top:7px;">
                            <a class="menu_1" href="http://www.thitruong24gio.com" target="_blank">http://e360.vn/</a>
                            <input type="text" name="link_shop" id="link_shop" value="<?php if(isset($link_shop)){echo $link_shop;} ?>" maxlength="50" class="inputlinkshop_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('link_shop',1)" onblur="ChangeStyle('link_shop',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('link_tip_help'); ?>',375,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost" style="font-weight:normal;">(<?php echo $this->lang->line('link_help'); ?>)</span>
                            <span style="font-weight:normal;"><?php echo form_error('link_shop'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_shop_account'); ?>:</td>
                        <td>
                            <input type="text" name="name_shop" id="name_shop" value="<?php if(isset($name_shop)){echo $name_shop;} ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditShop','name_shop');" onfocus="ChangeStyle('name_shop',1)" onblur="ChangeStyle('name_shop',2)" />
                            <?php echo form_error('name_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('descr_shop_account'); ?>:</td>
                        <td>
                            <input type="text" name="descr_shop" id="descr_shop" value="<?php if(isset($descr_shop)){echo $descr_shop;} ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_shop',1)" onblur="ChangeStyle('descr_shop',2)" />
                            <?php echo form_error('descr_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_shop_account'); ?>:</td>
                        <td>
                            <input type="text" name="address_shop" id="address_shop" value="<?php if(isset($address_shop)){echo $address_shop;} ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditShop','address_shop');" onfocus="ChangeStyle('address_shop',1)" onblur="ChangeStyle('address_shop',2)" />
                            <?php echo form_error('address_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_shop_account'); ?>:</td>
                        <td>
                            <select name="province_shop" id="province_shop" class="selectprovince_formpost">
                                <?php foreach($province as $provinceArray){ ?>
								<?php if(isset($province_shop) && $province_shop == $provinceArray->pre_id){ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_shop_account'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" name="phone_shop" id="phone_shop" value="<?php if(isset($phone_shop)){echo $phone_shop;} ?>" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_shop',1)" onblur="ChangeStyle('phone_shop',2)" />
                            <b>-</b>
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" name="mobile_shop" id="mobile_shop" value="<?php if(isset($mobile_shop)){echo $mobile_shop;} ?>" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_shop',1)" onblur="ChangeStyle('mobile_shop',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phone_shop'); ?>
                            <?php echo form_error('mobile_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_shop_account'); ?>:</td>
                        <td>
                            <input type="text" name="email_shop" id="email_shop" value="<?php if(isset($email_shop)){echo $email_shop;} ?>" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_shop',1)" onblur="ChangeStyle('email_shop',2)" />
                            <?php echo form_error('email_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_shop_account'); ?>:</td>
                        <td>
                            <input type="text" name="yahoo_shop" id="yahoo_shop" value="<?php if(isset($yahoo_shop)){echo $yahoo_shop;} ?>" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_shop',1)" onblur="ChangeStyle('yahoo_shop',2)" />
                            <?php echo form_error('yahoo_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_shop_account'); ?>:</td>
                        <td>
                            <input type="text" name="skype_shop" id="skype_shop" value="<?php if(isset($skype_shop)){echo $skype_shop;} ?>" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_shop',1)" onblur="ChangeStyle('skype_shop',2)" />
                            <?php echo form_error('skype_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('website_shop_account'); ?>:</td>
                        <td>
                            <input type="text" name="website_shop" id="website_shop" maxlength="100" value="<?php if(isset($website_shop)){echo $website_shop;} ?>" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('website_shop',1)" onblur="ChangeStyle('website_shop',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('website_tip_help'); ?>',165,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <?php echo form_error('website_shop'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('style_shop_account'); ?>:</td>
                        <td>
                            <select name="style_shop" id="style_shop" class="selectstyle_formpost">
                                <?php foreach($style as $styleArray){ ?>
                               	<option value="<?php echo $styleArray; ?>" <?php if(isset($style_shop) && $styleArray == $style_shop){echo 'selected="selected"';}elseif(isset($style_shop) && $style_shop == '' && $styleArray == 'default'){echo 'selected="selected"';} ?>><?php echo ucfirst(strtolower($styleArray)); ?></option>
                               	<?php } ?>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('style_tip_help'); ?>',180,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                        </td>
                    </tr>
                    <tr>
                        <td width="150"></td>
                        <td>
                            <div class="saleoff_shop"><input type="checkbox" name="saleoff_shop" id="saleoff_shop" value="1" <?php if(isset($saleoff_shop) && (int)$saleoff_shop == 1){echo 'checked="checked"';} ?> /><?php echo $this->lang->line('saleoff_shop_account'); ?></div>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaEditShopAccount)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo base_url().$imageCaptchaEditShopAccount; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_shop" id="captcha_shop" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_shop',1);" onblur="ChangeStyle('captcha_shop',2);" />
                            <?php echo form_error('captcha_shop'); ?>
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
                                    <td><input type="button" onclick="CheckInput_EditShop();" name="submit_editshop" value="<?php echo $this->lang->line('button_update_shop_account'); ?>" class="button_form" /></td>
                                    <td width="15"></td>
                                    <td><input type="button" name="cancle_editshop" value="<?php echo $this->lang->line('button_cancle_shop_account'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account')" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <input type="hidden" name="isPostShopAccount" value="1" />
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post" style="padding-top: 10px;">
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>account">
                            <?php echo $this->lang->line('success_edit_shop_account'); ?>
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