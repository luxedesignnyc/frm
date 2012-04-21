<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_job_edit'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" >
                <?php if($successEditJobAccount == false){ ?>
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
                    <?php if($successEditJobAccount == false){ ?>
                    <form name="frmEditJob" method="post">
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_post_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($title_job)){echo $title_job;} ?>" name="title_job" id="title_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_job',1)" onblur="ChangeStyle('title_job',2)" />
                            <?php echo form_error('title_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="7" colspan="2"></td>
                    </tr>
                    <tr>
                        <td height="20" class="seperate_line"><?php echo $this->lang->line('require_title_job_edit'); ?></td>
                        <td height="20" class="seperate_line"></td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('field_job_edit'); ?>:</td>
                        <td>
                            <select name="field_job" id="field_job" class="selectcategory_formpost">
                                <?php foreach($field as $fieldArray){ ?>
                                <?php if(isset($field_job) && $field_job == $fieldArray->fie_id){ ?>
                                <option value="<?php echo $fieldArray->fie_id; ?>" selected="selected"><?php echo $fieldArray->fie_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $fieldArray->fie_id; ?>"><?php echo $fieldArray->fie_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('field_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('position_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($position_job)){echo $position_job;} ?>" name="position_job" id="position_job" maxlength="120" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('position_job',1)" onblur="ChangeStyle('position_job',2)" />
                            <?php echo form_error('position_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('level_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($level_job)){echo $level_job;} ?>" name="level_job" id="level_job" maxlength="120" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('level_job',1)" onblur="ChangeStyle('level_job',2)" />
                            <?php echo form_error('level_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('foreign_language_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($foreign_language_job)){echo $foreign_language_job;} ?>" name="foreign_language_job" id="foreign_language_job" maxlength="120" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('foreign_language_job',1)" onblur="ChangeStyle('foreign_language_job',2)" />
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('computer_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($computer_job)){echo $computer_job;} ?>" name="computer_job" id="computer_job" maxlength="120" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('computer_job',1)" onblur="ChangeStyle('computer_job',2)" />
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('age_job_edit'); ?>:</td>
                        <td>
                            <span class="age_post"><?php echo $this->lang->line('from_job_edit'); ?></span>
                            <select name="age1_job" id="age1_job" class="selectage_formpost">
                                <?php for($age1 = 15; $age1 <= 60; $age1++){ ?>
                                <?php if(isset($age1_job) && $age1_job == $age1){ ?>
                                <option value="<?php echo $age1; ?>" selected="selected"><?php echo $age1; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $age1; ?>"><?php echo $age1; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="age_post"><?php echo $this->lang->line('to_job_edit'); ?></span>
                            <select name="age2_job" id="age2_job" class="selectage_formpost">
                                <?php for($age2 = 15; $age2 <= 60; $age2++){ ?>
                                <?php if(isset($age2_job) && $age2_job == $age2){ ?>
                                <option value="<?php echo $age2; ?>" selected="selected"><?php echo $age2; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $age2; ?>"><?php echo $age2; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('age_tip_help_job_edit') ?>',410,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <?php echo form_error('age1_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('sex_job_edit'); ?>:</td>
                        <td>
                            <select name="sex_job" id="sex_job" class="selectsex_formpost">
                                <option value="2" <?php if(isset($sex_job) && $sex_job == '2'){echo 'selected="selected"';}elseif(!isset($sex_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('all_sex_job_edit'); ?></option>
                                <option value="1" <?php if(isset($sex_job) && $sex_job == '1'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('male_job_edit'); ?></option>
                                <option value="0" <?php if(isset($sex_job) && $sex_job == '0'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('female_job_edit'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('require_job_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($require_job)){echo $require_job;} ?>" name="require_job" id="require_job" maxlength="120" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('require_job',1)" onblur="ChangeStyle('require_job',2)" />
                            <?php echo form_error('require_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('require_exper_job_edit'); ?>:</td>
                        <td>
                            <select name="experience_job" id="experience_job" class="selectexper_formpost">
                                <option value="0" <?php if(!isset($experience_job)){ ?>selected="selected"<?php } ?>><?php echo $this->lang->line('none_job_edit'); ?></option>
                                <?php for($exper = 1; $exper <= 30; $exper++){ ?>
                                <?php if(isset($experience_job) && $experience_job == $exper){ ?>
                                <option value="<?php echo $exper; ?>" selected="selected"><?php echo $exper; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $exper; ?>"><?php echo $exper; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="exper_job"><?php echo $this->lang->line('year_exper_job_edit'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_job_edit'); ?>:</td>
                        <td>
                            <select name="province_job" id="province_job" class="selectprovince_formpost">
                                <?php foreach($province as $provinceArray){ ?>
                                <?php if(isset($province_job) && $province_job == $provinceArray->pre_id){ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('time_job_job_edit'); ?>:</td>
                        <td>
                            <select name="time_job" id="time_job" class="selecttime_formpost">
                                <option value="1" <?php if(isset($time_job) && $time_job == '1'){echo 'selected="selected"';}elseif(!isset($time_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('time_job_1_job_edit'); ?></option>
                                <option value="2" <?php if(isset($time_job) && $time_job == '2'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('time_job_2_job_edit'); ?></option>
                                <option value="3" <?php if(isset($time_job) && $time_job == '3'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('time_job_3_job_edit'); ?></option>
                                <option value="4" <?php if(isset($time_job) && $time_job == '4'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('time_job_4_job_edit'); ?></option>
                                <option value="5" <?php if(isset($time_job) && $time_job == '5'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('time_job_5_job_edit'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('salary_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($salary_job)){echo $salary_job;} ?>" name="salary_job" id="salary_job" maxlength="8" class="inputsalary_formpost" onkeyup="FormatCurrency('DivShowSalary','currency_job',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('salary_job',1)" onblur="ChangeStyle('salary_job',2)" />
                            <select name="currency_job" id="currency_job" class="selectcurrency_formpost" onchange="FormatCurrency('DivShowSalary','currency_job',document.getElementById('salary_job').value)">
                                <option value="VND" <?php if(isset($currency_job) && $currency_job == 'VND'){echo 'selected="selected"';}elseif(!isset($currency_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('vnd_job_edit'); ?></option>
                                <option value="USD" <?php if(isset($currency_job) && $currency_job == 'USD'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('usd_job_edit'); ?></option>
                            </select>
                            <font size="+1">/</font>
                            <select name="datesalary_job" id="datesalary_job" class="selectsalary_formpost">
                                <option value="1" <?php if(isset($datesalary_job) && $datesalary_job == '1'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('day_job_edit'); ?></option>
                                <option value="2" <?php if(isset($datesalary_job) && $datesalary_job == '2'){echo 'selected="selected"';}elseif(!isset($datesalary_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('month_job_edit'); ?></option>
                                <option value="3" <?php if(isset($datesalary_job) && $datesalary_job == '3'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('year_job_edit'); ?></option>
                            </select>
                            <span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                            <div id="DivShowSalary"></div>
                            <?php echo form_error('salary_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('try_time_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($try_job)){echo $try_job;} ?>" name="try_job" id="try_job" maxlength="3" class="inputtry_formpost" onkeyup="BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('try_job',1)" onblur="ChangeStyle('try_job',2)" />
                            <select name="datetry_job" id="datetry_job" class="selectdatetry_formpost">
                                <option value="1" <?php if(isset($datetry_job) && $datetry_job == '1'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('day_job_edit'); ?></option>
                                <option value="2" <?php if(isset($datetry_job) && $datetry_job == '2'){echo 'selected="selected"';}elseif(!isset($datetry_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('month_job_edit'); ?></option>
                                <option value="3" <?php if(isset($datetry_job) && $datetry_job == '3'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('year_job_edit'); ?></option>
                            </select>
                            <span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                            <?php echo form_error('try_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('interest_job_edit'); ?>:</td>
                        <td align="left">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <textarea name="interest_job" id="interest_job" rows="3" class="textarea_post" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('interest_job',1)" onblur="ChangeStyle('interest_job',2)" /><?php if(isset($interest_job)){echo $interest_job;} ?></textarea>
                                        <?php echo form_error('interest_job'); ?>
                                    </td>
                                    <td style="padding-top:7px;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('quantity_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($quantity_job)){echo $quantity_job;} ?>" name="quantity_job" id="quantity_job" maxlength="5" class="inputquantity_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('quantity_job',1)" onblur="ChangeStyle('quantity_job',2)" />
                            <span class="quantity_job"> <?php echo $this->lang->line('person_job_edit'); ?></span>
                            <span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                            <?php echo form_error('quantity_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('record_job_edit'); ?>:</td>
                        <td align="left">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <textarea name="record_job" id="record_job" rows="3" class="textarea_post" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('record_job',1)" onblur="ChangeStyle('record_job',2)" /><?php if(isset($record_job)){echo $record_job;} ?></textarea>
                                        <?php echo form_error('record_job'); ?>
                                    </td>
                                    <td style="padding-top:7px;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('time_surrend_job_edit'); ?>:</td>
                        <td>
                            <select name="day_job" id="day_job" class="selectdate_formpost">
                                <?php for($day = 1; $day <= 31; $day++){ ?>
                                <?php if(isset($day_job) && (int)$day_job == $day){ ?>
                                <option value="<?php echo $day; ?>" selected="selected"><?php echo $day; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="month_job" id="month_job" class="selectdate_formpost">
                                <?php for($month = 1; $month <= 12; $month++){ ?>
                                <?php if(isset($month_job) && (int)$month_job == $month){ ?>
                                <option value="<?php echo $month; ?>" selected="selected"><?php echo $month; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="year_job" id="year_job" class="selectdate_formpost">
                                <?php for($year = (int)date('Y'); $year < (int)date('Y')+2; $year++){ ?>
                                <?php if(isset($year_job) && (int)$year_job == $year){ ?>
                                <option value="<?php echo $year; ?>" selected="selected"><?php echo $year; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('time_currend_tip_help_job_edit') ?>',350,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('enddate_help'); ?>)</span>
                            <?php echo form_error('day_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('detail_job_edit'); ?>:</td>
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
                        <td height="7" colspan="2"></td>
                    </tr>
                    <tr>
                        <td height="20" class="seperate_line"><?php echo $this->lang->line('info_title_job_edit'); ?></td>
                        <td height="20" class="seperate_line"></td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($name_job)){echo $name_job;} ?>" name="name_job" id="name_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostJob','name_job');" onfocus="ChangeStyle('name_job',1)" onblur="ChangeStyle('name_job',2)" />
                            <?php echo form_error('name_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($address_job)){echo $address_job;} ?>" name="address_job" id="address_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostJob','address_job');" onfocus="ChangeStyle('address_job',1)" onblur="ChangeStyle('address_job',2)" />
                            <?php echo form_error('address_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_job_edit'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($phone_job)){echo $phone_job;} ?>" name="phone_job" id="phone_job" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_job',1)" onblur="ChangeStyle('phone_job',2)" />
                            <b>-</b>
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($mobile_job)){echo $mobile_job;} ?>" name="mobile_job" id="mobile_job" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_job',1)" onblur="ChangeStyle('mobile_job',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phone_job'); ?>
                            <?php echo form_error('mobile_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($email_job)){echo $email_job;} ?>" name="email_job" id="email_job" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_job',1)" onblur="ChangeStyle('email_job',2)" />
                            <?php echo form_error('email_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('website_job_edit'); ?>:</td>
                        <td>
                            <input type="text" name="website_job" id="website_job" value="<?php if(isset($website_job)){echo $website_job;} ?>" maxlength="100" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('website_job',1)" onblur="ChangeStyle('website_job',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('website_tip_help') ?>',165,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <?php echo form_error('website_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="7" colspan="2"></td>
                    </tr>
                    <tr>
                        <td height="20" class="seperate_line"><?php echo $this->lang->line('info_contact_title_job_edit'); ?></td>
                        <td height="20" class="seperate_line"></td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_contact_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($namecontact_job)){echo $namecontact_job;} ?>" name="namecontact_job" id="namecontact_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostJob','namecontact_job');" onfocus="ChangeStyle('namecontact_job',1)" onblur="ChangeStyle('namecontact_job',2)" />
                            <?php echo form_error('namecontact_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_contact_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($addresscontact_job)){echo $addresscontact_job;} ?>" name="addresscontact_job" id="addresscontact_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostJob','addresscontact_job');" onfocus="ChangeStyle('addresscontact_job',1)" onblur="ChangeStyle('addresscontact_job',2)" />
                            <?php echo form_error('addresscontact_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_contact_job_edit'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($phonecontact_job)){echo $phonecontact_job;} ?>" name="phonecontact_job" id="phonecontact_job" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phonecontact_job',1)" onblur="ChangeStyle('phonecontact_job',2)" />
                            <b>-</b>
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($mobilecontact_job)){echo $mobilecontact_job;} ?>" name="mobilecontact_job" id="mobilecontact_job" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobilecontact_job',1)" onblur="ChangeStyle('mobilecontact_job',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phonecontact_job'); ?>
                            <?php echo form_error('mobilecontact_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_contact_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($emailcontact_job)){echo $emailcontact_job;} ?>" name="emailcontact_job" id="emailcontact_job" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('emailcontact_job',1)" onblur="ChangeStyle('emailcontact_job',2)" />
                            <?php echo form_error('emailcontact_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_contact_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($yahoo_job)){echo $yahoo_job;} ?>" name="yahoo_job" id="yahoo_job" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_job',1)" onblur="ChangeStyle('yahoo_job',2)" />
                            <?php echo form_error('yahoo_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_contact_job_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($skype_job)){echo $skype_job;} ?>" name="skype_job" id="skype_job" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_job',1)" onblur="ChangeStyle('skype_job',2)" />
                            <?php echo form_error('skype_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('best_contact_job_edit'); ?>:</td>
                        <td>
                            <select name="bestcontact_job" id="bestcontact_job" class="selectbestcontact_formpost">
                                <option value="1" <?php if(isset($bestcontact_job) && $bestcontact_job == '1'){echo 'selected="selected"';}elseif(!isset($bestcontact_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('best_contact_1_contact_job_edit'); ?></option>
                                <option value="2" <?php if(isset($bestcontact_job) && $bestcontact_job == '2'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('best_contact_2_contact_job_edit'); ?></option>
                                <option value="3" <?php if(isset($bestcontact_job) && $bestcontact_job == '3'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('best_contact_3_contact_job_edit'); ?></option>
                                <option value="4" <?php if(isset($bestcontact_job) && $bestcontact_job == '4'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('best_contact_4_contact_job_edit'); ?></option>
                                <option value="5" <?php if(isset($bestcontact_job) && $bestcontact_job == '5'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('best_contact_5_contact_job_edit'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_job_edit'); ?>:</td>
                        <td>
                            <select name="endday_job" id="endday_job" class="selectdate_formpost">
                                <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                                <?php if(isset($endday_job) && (int)$endday_job == $endday){ ?>
                                <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="endmonth_job" id="endmonth_job" class="selectdate_formpost">
                                <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                                <?php if(isset($endmonth_job) && (int)$endmonth_job == $endmonth){ ?>
                                <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="endyear_job" id="endyear_job" class="selectdate_formpost">
                                <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+2; $endyear++){ ?>
                                <?php if(isset($endyear_job) && (int)$endyear_job == $endyear){ ?>
                                <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('enddate_tip_help') ?>',235,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('enddate_help'); ?>)</span>
                            <?php echo form_error('endday_job'); ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaEditJobAccount)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo base_url().$imageCaptchaEditJobAccount; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_job" id="captcha_job" value="" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_job',1);" onblur="ChangeStyle('captcha_job',2);" />
                            <?php echo form_error('captcha_job'); ?>
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
                                    <td><input type="button" onclick="CheckInput_EditJob();" name="submit_editjob" value="<?php echo $this->lang->line('button_agree_job_edit'); ?>" class="button_form" /></td>
                                    <td width="15"></td>
                                    <td><input type="button" onclick="ActionLink('<?php echo base_url(); ?>account/job');"  name="reset_editjob" value="<?php echo $this->lang->line('button_cancel_job_edit'); ?>" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post" style="padding-top:10px;">
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>account/job">
                            <?php echo $this->lang->line('success_job_edit'); ?>
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