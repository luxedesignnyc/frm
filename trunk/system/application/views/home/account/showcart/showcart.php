<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_showcart_defaults'); ?></div>
            </td>
        </tr>
        <?php if(count($showcart) > 0){ ?>
        <form name="frmAccountShowcart" method="post">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">#</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountShowcart',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="125" class="title_account_1">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="95" class="title_account_2">
                            <?php echo $this->lang->line('quantity_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>quantity/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>quantity/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="130" class="title_account_1">
							<?php echo $this->lang->line('saler_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>saler/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>saler/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
						</td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_buy_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>buydate/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>buydate/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="50" class="title_account_3"><?php echo $this->lang->line('process_list'); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" >
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($showcart as $showcartArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="46" height="32" class="line_account_0"><?php echo $sTT; ?></td>
                        <td width="30" height="32" class="line_account_1">
                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $showcartArray->shc_id; ?>" onclick="DoCheckOne('frmAccountShowcart')" />
                        </td>
                        <td height="32" class="line_account_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $showcartArray->pro_category; ?>/detail/<?php echo $showcartArray->pro_id; ?>" onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $showcartArray->pro_dir; ?>/<?php echo show_thumbnail($showcartArray->pro_dir, $showcartArray->pro_image); ?>\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'><?php echo $showcartArray->pro_descr; ?></td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();">
                                <?php echo sub($showcartArray->pro_name, 30); ?>
                            </a>
                            <span class="number_view">(<?php echo $showcartArray->pro_view; ?>)</span>
                        </td>
                        <td width="115" height="32" class="line_account_3" style="text-align:center;">
                            <?php if((int)$showcartArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                            <?php }else{ ?>
                            <div style="color:#F00; font-wieght:bold;"><span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $showcartArray->pro_currency; ?></div>
                            <div style="color:#999; font-weight:normal;">
	                            <?php if(strtoupper($showcartArray->pro_currency) == 'VND'){ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>
								<script>FormatCost('<?php echo round($showcartArray->pro_cost/Setting::settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
								<?php }else{ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
								<script>FormatCost('<?php echo round($showcartArray->pro_cost*Setting::settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
								<?php } ?>
							</div>
                            <script>FormatCost('<?php echo $showcartArray->pro_cost; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                            <?php } ?>
                        </td>
                        <td width="95" height="32" class="line_account_4">
                            <div class="quantity_account"><?php echo $showcartArray->shc_quantity; ?></div>
                        </td>
                        <td width="120" height="32" class="line_account_3" style="text-align:left;">
                            <div class="customer_account" style="text-align:left;"><span onmouseover="ddrivetip('<?php echo $this->lang->line('email_tip_showcart_defaults'); ?>&nbsp;<?php echo $showcartArray->use_email; ?><br><?php echo $this->lang->line('phone_tip_showcart_defaults'); ?>&nbsp;<?php echo $showcartArray->use_phone; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo $showcartArray->use_fullname; ?></span></div>
                        </td>
                        <td width="110" height="32" class="line_account_4">
                            <?php echo date('d-m-Y', $showcartArray->shc_buydate); ?>
                        </td>
                        <td width="44" height="32" class="line_account_5">
                            <?php if((int)$showcartArray->shc_process == 1){ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/public.png" border="0" title="<?php echo $this->lang->line('processed_tip'); ?>" />
                            <?php }else{ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" border="0" title="<?php echo $this->lang->line('not_processed_tip'); ?>" />
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deleteshowcart_account.gif" onclick="ActionSubmit('frmAccountShowcart')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                            <input type="hidden" name="search_account" id="search_account" value="name" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/showcart/', 0)" border="0" style="cursor:pointer;" title="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" id="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        </form>
        <?php }elseif(count($showcart) == 0 && trim($keyword) != ''){ ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">#</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountShowcart',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="125" class="title_account_1">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="95" class="title_account_2">
                            <?php echo $this->lang->line('quantity_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="130" class="title_account_1">
							<?php echo $this->lang->line('saler_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
						</td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_buy_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="50" class="title_account_3"><?php echo $this->lang->line('process_list'); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" >
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_showcart_defaults'); ?></td>
					</tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deleteshowcart_account.gif" onclick="" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                            <input type="hidden" name="search_account" id="search_account" value="name" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/showcart/', 0)" border="0" style="cursor:pointer;" title="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" id="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" align="center" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg"><?php echo $this->lang->line('none_record_showcart_defaults'); ?></td>
		</tr>
        <?php } ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_ac.png" height="16" ></td>
        </tr>
    </table>	
</td>					
<!--END RIGHT--> 
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successAddShowcart) && trim($successAddShowcart) != ''){ ?>
<script>alert('<?php echo $successAddShowcart; ?>');</script>
<?php } ?>