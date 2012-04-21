<?php if(isset($siteGlobal)){ ?>
<table width="594" class="table_module" style="margin-top:0px;" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td height="28" class="title_module"><?php echo $this->lang->line('title_search_detail_global'); ?></td>
    </tr>
    <tr>
        <td valign="top">
            <table width="585" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td height="20" class="search_top"></td>
                </tr>
                <form name="frmSearchPro" method="post">
                <tr>
                    <td valign="top">
                        <table border="0" class="search_main" width="100%" height="200" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2" height="12"></td>
                            </tr>
                            <tr>
                                <td width="85" valign="top" class="list_search"><?php echo $this->lang->line('name_product_search_detail_global'); ?>:</td>
                                <td align="left">
                                    <input type="text" name="name_search" id="name_search" value="<?php if(isset($nameKeyword)){echo $nameKeyword;} ?>" maxlength="80" class="input_search" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('name_search',1)" onblur="ChangeStyle('name_search',2)" />
                                </td>
                            </tr>
                            <tr>
                                <td width="85" valign="top" class="list_search"><?php echo $this->lang->line('cost_search_detail_global'); ?>:</td>
                                <td align="left">
                                    <font color="#666666"><b><?php echo $this->lang->line('from_search_detail_global'); ?></b></font>
                                    <input type="text" value="<?php if(isset($sCostKeyword)){echo $sCostKeyword;} ?>" name="cost_search1" id="cost_search1" maxlength="9" class="inputcost_search" onkeyup="FormatCurrency('DivShowCostSearch1','currency_search',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('cost_search1',1)" onblur="ChangeStyle('cost_search1',2)" />
                                    <font color="#666666"><b><?php echo $this->lang->line('to_search_detail_global'); ?></b></font>
                                    <input type="text" value="<?php if(isset($eCostKeyword)){echo $eCostKeyword;} ?>" name="cost_search2" id="cost_search2" maxlength="9" class="inputcost_search" onkeyup="FormatCurrency('DivShowCostSearch2','currency_search',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('cost_search2',1)" onblur="ChangeStyle('cost_search2',2)" />
                                    <select name="currency_search" id="currency_search" class="selectcurrency_search" onchange="FormatCurrency('DivShowCostSearch1','currency_search',document.getElementById('cost_search1').value); FormatCurrency('DivShowCostSearch2','currency_search',document.getElementById('cost_search2').value);">
                                        <option value="VND" <?php if(isset($currencyKeyword) && $currencyKeyword == 'VND'){echo 'selected="selected"';}elseif(!isset($currencyKeyword)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('vnd_search_detail_global'); ?></option>
                                        <option value="USD" <?php if(isset($currencyKeyword) && $currencyKeyword == 'USD'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('usd_search_detail_global'); ?></option>
                                    </select>
                                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('cost_search_tip_help') ?>',285,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                    <span class="div_helppost" style="padding-right:40px;">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                                    <span id="DivShowCostSearch1" style="padding-right:30px;"></span><span id="DivShowCostSearch2"></span>
                                    <div class="saleoff">
                                        <input type="checkbox" name="saleoff_search" id="saleoff_search" value="1" <?php if(isset($saleoffKeyword) && $saleoffKeyword == '1'){echo 'checked="checked"';} ?> />
                                        <?php echo $this->lang->line('saleoff_search_detail_global'); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="85" valign="top" class="list_search"><?php echo $this->lang->line('province_search_detail_global'); ?>:</td>
                                <td align="left">
                                    <select name="province_search" id="province_search" class="selectprovince_search">
                                        <option value="0" selected="selected"><?php echo $this->lang->line('select_province_search_detail_global'); ?></option>
                                        <?php foreach($province as $provinceArray){ ?>
                                        <?php if(isset($placeKeyword) && $placeKeyword == $provinceArray->pre_id){ ?>
                                        <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="85" valign="top" class="list_search"><?php echo $this->lang->line('begindate_search_detail_global'); ?>:</td>
                                <td align="left">
                                    <font color="#666666"><b><?php echo $this->lang->line('from_search_detail_global'); ?></b></font>
                                    <select name="beginday_search1" id="beginday_search1" class="selectdate_search">
                                        <option value="0"><?php echo $this->lang->line('day_search_detail_global'); ?></option>
                                        <?php for($beginday = 1; $beginday <= 31; $beginday++){ ?>
                                        <?php if(isset($sDayKeyword) && (int)$sDayKeyword == $beginday){ ?>
                                        <option value="<?php echo $beginday; ?>" selected="selected"><?php echo $beginday; ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $beginday; ?>"><?php echo $beginday; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <b>-</b>
                                    <select name="beginmonth_search1" id="beginmonth_search1" class="selectdate_search">
                                        <option value="0"><?php echo $this->lang->line('month_search_detail_global'); ?></option>
                                        <?php for($beginmonth = 1; $beginmonth <= 12; $beginmonth++){ ?>
                                        <?php if(isset($sMonthKeyword) && (int)$sMonthKeyword == $beginmonth){ ?>
                                        <option value="<?php echo $beginmonth; ?>" selected="selected"><?php echo $beginmonth; ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $beginmonth; ?>"><?php echo $beginmonth; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <b>-</b>
                                    <select name="beginyear_search1" id="beginyear_search1" class="selectdate_search">
                                        <option value="0"><?php echo $this->lang->line('year_search_detail_global'); ?></option>
                                        <?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
                                        <?php if(isset($sYearKeyword) && (int)$sYearKeyword == $beginyear){ ?>
                                        <option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <font color="#666666"><b><?php echo $this->lang->line('to_search_detail_global'); ?></b></font>
                                    <select name="beginday_search2" id="beginday_search2" class="selectdate_search">
                                        <option value="0"><?php echo $this->lang->line('day_search_detail_global'); ?></option>
                                        <?php for($beginday = 1; $beginday <= 31; $beginday++){ ?>
                                        <?php if(isset($eDayKeyword) && (int)$eDayKeyword == $beginday){ ?>
                                        <option value="<?php echo $beginday; ?>" selected="selected"><?php echo $beginday; ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $beginday; ?>"><?php echo $beginday; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <b>-</b>
                                    <select name="beginmonth_search2" id="beginmonth_search2" class="selectdate_search">
                                        <option value="0"><?php echo $this->lang->line('month_search_detail_global'); ?></option>
                                        <?php for($beginmonth = 1; $beginmonth <= 12; $beginmonth++){ ?>
                                        <?php if(isset($eMonthKeyword) && (int)$eMonthKeyword == $beginmonth){ ?>
                                        <option value="<?php echo $beginmonth; ?>" selected="selected"><?php echo $beginmonth; ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $beginmonth; ?>"><?php echo $beginmonth; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <b>-</b>
                                    <select name="beginyear_search2" id="beginyear_search2" class="selectdate_search">
                                        <option value="0"><?php echo $this->lang->line('year_search_detail_global'); ?></option>
                                        <?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
                                        <?php if(isset($eYearKeyword) && (int)$eYearKeyword == $beginyear){ ?>
                                        <option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
                                        <?php }else{ ?>
                                        <option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('date_search_tip_help') ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                </td>
                            </tr>
                            <tr>
                                <td width="85"></td>
                                <td height="30" valign="bottom" align="center">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td colspan="3" height="15"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="button" onclick="CheckInput_SearchPro('<?php echo base_url().$siteGlobal->sho_link; ?>/search/')" name="submit_searchpro" value="<?php echo $this->lang->line('button_search_search_detail_global'); ?>" class="button_search" /></td>
                                            <td width="15"></td>
                                            <td><input type="reset" name="reset_searchpro" value="<?php echo $this->lang->line('button_reset_search_detail_global'); ?>" class="button_search" /></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="10" colspan="2"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </form>
                <tr>
                    <td height="20" class="search_bottom"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="10" class="bottom_module"></td>
    </tr>
</table>
<?php } ?>