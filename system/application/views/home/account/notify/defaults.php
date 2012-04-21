<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_notify_defaults'); ?></div>
            </td>
        </tr>
        <?php if(count($notify) > 0){ ?>
        <tr>
            <td valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                        <td width="50" class="title_account_0">#</td>
                        <td class="title_account_1">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="135" class="title_account_2">
                            <?php echo $this->lang->line('degree_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>degree/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>degree/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="135" class="title_account_1">
                            <?php echo $this->lang->line('date_notify_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="70" class="title_account_2">
                            <?php echo $this->lang->line('view_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg">
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($notify as $notifyArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="36" height="32" class="line_account_2" style="border-right:1px #D4EDFF solid; text-align:center;"><?php echo $sTT; ?></td>
                        <td height="32" class="line_account_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>account/notify/detail/<?php echo $notifyArray->not_id; ?>" title="<?php echo $this->lang->line('view_tip'); ?>">
                                <?php echo $notifyArray->not_title; ?>
                            </a>
                        </td>
                        <td width="125" height="32" class="line_account_3" style="text-align:center;">
                            <?php if((int)$notifyArray->not_degree == 1){ ?>
                            <span style="color:#009900; font-weight:normal;"><?php echo $this->lang->line('normal_degree_notify_defaults'); ?></span>
                            <?php }elseif((int)$notifyArray->not_degree == 2){ ?>
                            <span style="color:#06F; font-weight:bold;"><?php echo $this->lang->line('important_degree_notify_defaults'); ?></span>
                            <?php }else{ ?>
                            <span style="color:#FF0000; font-weight:bold;"><?php echo $this->lang->line('rushed_degree_notify_defaults'); ?></span>
                            <?php } ?>
                        </td>
                        <td width="135" height="32" class="line_account_4">
                            <?php echo date('d-m-Y', $notifyArray->not_begindate); ?>
                        </td>
                        <td width="64" height="32" class="line_account_5">
                            <?php if(trim($notifyArray->not_view) != '' && stristr($notifyArray->not_view, "[$userID]")){ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/public.png" border="0" title="<?php echo $this->lang->line('viewed_tip'); ?>" />
                            <?php }else{ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" border="0" title="<?php echo $this->lang->line('not_viewed_tip'); ?>" />
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="text-align:left; padding-left:14px;" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/notify/', 0)" border="0" style="cursor:pointer;" title="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="50%" id="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }elseif(count($notify) == 0 && trim($keyword) != ''){ ?>
        <tr>
            <td valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                        <td width="50" class="title_account_0">#</td>
                        <td class="title_account_1">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="135" class="title_account_2">
                            <?php echo $this->lang->line('degree_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="135" class="title_account_1">
                            <?php echo $this->lang->line('date_notify_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="70" class="title_account_2">
                            <?php echo $this->lang->line('view_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg">
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_notify_defaults'); ?></td>
					</tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="text-align:left; padding-left:14px;" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/notify/', 0)" border="0" style="cursor:pointer;" title="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="50%" id="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" align="center" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg"><?php echo $this->lang->line('none_record_notify_defaults'); ?></td>
		</tr>
		<?php } ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_ac.png" height="16" ></td>
        </tr>
    </table>	
</td>					
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>