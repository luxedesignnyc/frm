<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/advertise/top'); ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_product'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table width="585" class="post_main" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td height="20" class="post_top"></td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="2" height="12"></td>
                                </tr>
                                <form name="frmSearchPro" method="get">
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('name_product'); ?>:</td>
                                    <td>
                                        <input type="text" name="name_search" id="name_search" value="<?php if(isset($nameKeyword)){echo $nameKeyword;} ?>" maxlength="80" class="input_formpost" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('name_search',1)" onblur="ChangeStyle('name_search',2)" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('cost_product'); ?>:</td>
                                    <td>
                                        <font color="#666666"><b><?php echo $this->lang->line('from_product'); ?></b></font>
                                        <input type="text" value="<?php if(isset($sCostKeyword)){echo $sCostKeyword;} ?>" name="cost_search1" id="cost_search1" maxlength="9" class="inputcost_formpost" onkeyup="FormatCurrency('DivShowCostSearch1','currency_search',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('cost_search1',1)" onblur="ChangeStyle('cost_search1',2)" />
                                        <font color="#666666"><b><?php echo $this->lang->line('to_product'); ?></b></font>
                                        <input type="text" value="<?php if(isset($eCostKeyword)){echo $eCostKeyword;} ?>" name="cost_search2" id="cost_search2" maxlength="9" class="inputcost_formpost" onkeyup="FormatCurrency('DivShowCostSearch2','currency_search',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('cost_search2',1)" onblur="ChangeStyle('cost_search2',2)" />
                                        <select name="currency_search" id="currency_search" class="selectcurrency_formpost" onchange="FormatCurrency('DivShowCostSearch1','currency_search',document.getElementById('cost_search1').value); FormatCurrency('DivShowCostSearch2','currency_search',document.getElementById('cost_search2').value);">
                                            <option value="VND" <?php if(isset($currencyKeyword) && $currencyKeyword == 'VND'){echo 'selected="selected"';}elseif(!isset($currencyKeyword)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('vnd_main'); ?></option>
                                			<option value="USD" <?php if(isset($currencyKeyword) && $currencyKeyword == 'USD'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('usd_main'); ?></option>
                                        </select>
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('cost_search_tip_help') ?>',285,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                        <span class="div_helppost" style="padding-right:40px;">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                                        <span id="DivShowCostSearch1" style="padding-right:30px;"></span><span id="DivShowCostSearch2"></span>
                                        <div class="saleoff">
                                            <input type="checkbox" name="saleoff_search" id="saleoff_search" value="1" <?php if(isset($saleoffKeyword) && $saleoffKeyword == '1'){echo 'checked="checked"';} ?> />
                                            <?php echo $this->lang->line('saleoff_product'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('place_product'); ?>:</td>
                                    <td>
                                        <select name="province_search" id="province_search" class="selectprovince_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_place_product'); ?></option>
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
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('category_product'); ?>:</td>
                                    <td>
                                        <select name="category_search" id="category_search" class="selectcategory_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_category_product'); ?></option>
                                            <?php foreach($category as $categoryArray){ ?>
			                                <?php if(isset($categoryKeyword) && $categoryKeyword == $categoryArray->cat_id){ ?>
			                                <option value="<?php echo $categoryArray->cat_id; ?>" selected="selected"><?php echo $categoryArray->cat_name; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $categoryArray->cat_id; ?>"><?php echo $categoryArray->cat_name; ?></option>
			                                <?php } ?>
			                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('postdate_product'); ?>:</td>
                                    <td>
                                        <font color="#666666"><b><?php echo $this->lang->line('from_product'); ?></b></font>
                                        <select name="beginday_search1" id="beginday_search1" class="selectdate_formpost">
                                            <option value="0"><?php echo $this->lang->line('day_product'); ?></option>
                                            <?php for($beginday = 1; $beginday <= 31; $beginday++){ ?>
			                                <?php if(isset($sDayKeyword) && (int)$sDayKeyword == $beginday){ ?>
			                                <option value="<?php echo $beginday; ?>" selected="selected"><?php echo $beginday; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginday; ?>"><?php echo $beginday; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <b>-</b>
                                        <select name="beginmonth_search1" id="beginmonth_search1" class="selectdate_formpost">
                                            <option value="0"><?php echo $this->lang->line('month_product'); ?></option>
                                            <?php for($beginmonth = 1; $beginmonth <= 12; $beginmonth++){ ?>
			                                <?php if(isset($sMonthKeyword) && (int)$sMonthKeyword == $beginmonth){ ?>
			                                <option value="<?php echo $beginmonth; ?>" selected="selected"><?php echo $beginmonth; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginmonth; ?>"><?php echo $beginmonth; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <b>-</b>
                                        <select name="beginyear_search1" id="beginyear_search1" class="selectdate_formpost">
                                            <option value="0"><?php echo $this->lang->line('year_product'); ?></option>
                                            <?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
			                                <?php if(isset($sYearKeyword) && (int)$sYearKeyword == $beginyear){ ?>
			                                <option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <font color="#666666"><b><?php echo $this->lang->line('to_product'); ?></b></font>
                                        <select name="beginday_search2" id="beginday_search2" class="selectdate_formpost">
                                            <option value="0"><?php echo $this->lang->line('day_product'); ?></option>
                                            <?php for($beginday = 1; $beginday <= 31; $beginday++){ ?>
			                                <?php if(isset($eDayKeyword) && (int)$eDayKeyword == $beginday){ ?>
			                                <option value="<?php echo $beginday; ?>" selected="selected"><?php echo $beginday; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginday; ?>"><?php echo $beginday; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <b>-</b>
                                        <select name="beginmonth_search2" id="beginmonth_search2" class="selectdate_formpost">
                                            <option value="0"><?php echo $this->lang->line('month_product'); ?></option>
                                            <?php for($beginmonth = 1; $beginmonth <= 12; $beginmonth++){ ?>
			                                <?php if(isset($eMonthKeyword) && (int)$eMonthKeyword == $beginmonth){ ?>
			                                <option value="<?php echo $beginmonth; ?>" selected="selected"><?php echo $beginmonth; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginmonth; ?>"><?php echo $beginmonth; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <b>-</b>
                                        <select name="beginyear_search2" id="beginyear_search2" class="selectdate_formpost">
                                            <option value="0"><?php echo $this->lang->line('year_product'); ?></option>
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
                                                <td><input type="button" onclick="CheckInput_SearchPro('<?php echo base_url(); ?>search/product/')" name="submit_searchpro" value="<?php echo $this->lang->line('button_search_product'); ?>" class="button_form" /></td>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_searchpro" value="<?php echo $this->lang->line('button_reset_product'); ?>" class="button_form" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </form>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="30" class="post_bottom"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <?php if(isset($searchProduct)){ ?>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_result_search_main'); ?> <span class="result_number">(<?php if(isset($totalResult)){echo $totalResult;}else{echo '0';} ?>)</span></div>
            </td>
        </tr>
        <?php if(count($searchProduct) > 0){ ?>
        <form name="frmListPro" method="post">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg">
                <table align="center" width="580" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
                    <tr height="29">
                        <td width="28" align="center" class="title_boxpro_0"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmListPro',0)" /></td>
                        <td width="110" class="title_boxpro_1"><?php echo $this->lang->line('image_list'); ?></td>
                        <td class="title_boxpro_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>nameSort/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>nameSort/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="105" class="title_boxpro_1">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                    </tr>
                    <?php $idDiv = 1; ?>
                    <?php foreach($searchProduct as $searchProductArray){ ?>
                    <tr>
                        <td width="28" align="center" class="line_boxpro_0"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $searchProductArray->pro_id; ?>" onclick="DoCheckOne('frmListPro')" /></td>
                        <td width="110" class="line_boxpro_1">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $searchProductArray->pro_category; ?>/detail/<?php echo $searchProductArray->pro_id; ?>">
                                <img src="<?php echo base_url(); ?>media/images/product/<?php echo $searchProductArray->pro_dir; ?>/<?php echo show_thumbnail($searchProductArray->pro_dir, $searchProductArray->pro_image); ?>" class="image_boxpro" onmouseover="ddrivetip_image('<img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $searchProductArray->pro_dir; ?>/<?php echo show_image($searchProductArray->pro_image); ?>\' border=0>',1,'#F0F8FF');" onmouseout="hideddrivetip();" />
                            </a>
                        </td>
                        <td valign="top" class="line_boxpro_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $searchProductArray->pro_category; ?>/detail/<?php echo $searchProductArray->pro_id; ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo $searchProductArray->pro_name; ?>
                            </a>
                            <div class="descr_boxpro">
                                <?php echo $searchProductArray->pro_descr; ?>
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" class="saleoff_boxpro">
                                        <?php if((int)$searchProductArray->pro_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff.gif" border="0" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxpro"><?php echo $this->lang->line('view_product'); ?>:&nbsp;<?php echo $searchProductArray->pro_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('comment_product'); ?>:&nbsp;<?php echo $searchProductArray->pro_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="105" class="line_boxpro_1">
                            <?php if((int)$searchProductArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                            <?php }else{ ?>
                            <span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $searchProductArray->pro_currency; ?>
                            <div class="usd_boxpro">
                                <?php if(strtoupper($searchProductArray->pro_currency) == 'VND'){ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>
								<script>FormatCost('<?php echo round($searchProductArray->pro_cost/Setting::settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
								<?php }else{ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
								<script>FormatCost('<?php echo round($searchProductArray->pro_cost*Setting::settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
								<?php } ?>
							</div>
                            <script>FormatCost('<?php echo $searchProductArray->pro_cost; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                            <?php if($searchProductArray->pro_hondle == 1){ ?>
                            <div class="nego_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/hondle.gif" border="0" /></div>
                            <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                 </table>
                 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="favorite_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite.gif" onclick="Favorite('frmListPro', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxpro">
                            <select name="select_sort" id="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_product'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_product'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_product'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_product'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_product'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_product'); ?></option>
                            </select>
                        </td>
                        <td width="37%" id="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
             </td>
        </tr>
        </form>
        <?php }else{ ?>
        <tr>
        	<td class="none_record_search" style="padding-top: 10px;" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg">
           		<?php echo $this->lang->line('none_record_search_product'); ?>
			</td>
		</tr>
        <?php } ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <?php } ?>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_product'); ?>');</script>
<?php } ?>