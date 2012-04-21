<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_contact_defaults'); ?></div>
            </td>
        </tr>
        <?php if(count($contact) > 0){ ?>
        <form name="frmAccountSendContact" method="post">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">#</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountSendContact',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="135" class="title_account_1">
                            <?php echo $this->lang->line('position_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>position/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>position/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="90" class="title_account_1" style="border-left:none;">
                            <?php echo $this->lang->line('reply_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>reply/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>reply/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_send_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="main_list" valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" >
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($contact as $contactArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="46" height="32" class="line_account_0"><?php echo $sTT; ?></td>
                        <td width="30" height="32" class="line_account_1">
                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $contactArray->con_id; ?>" onclick="DoCheckOne('frmAccountSendContact')" />
                        </td>
                        <td height="32" class="line_account_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>account/contact/detail/<?php echo $contactArray->con_id; ?>" title="<?php echo $this->lang->line('view_tip'); ?>">
                                <?php echo $contactArray->con_title; ?>
                            </a>
                        </td>
                        <td width="125" height="32" class="line_account_3" style="text-align:center;">
                            <?php if((int)$contactArray->con_position == 1){ ?>
                            <font color="#0066FF"><b><?php echo $this->lang->line('business_contact_defaults'); ?></b></font>
                            <?php }else{ ?>
                            <font color="#00CC00"><b><?php echo $this->lang->line('tech_contact_defaults'); ?></b></font>
                            <?php } ?>
                        </td>
                        <td width="90" height="32" class="line_account_1" style="border-left: none; text-align:center;">
                            <?php if((int)$contactArray->con_reply == 1){ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/public.png" border="0" title="<?php echo $this->lang->line('replied_tip'); ?>" />
                            <?php }else{ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" border="0" title="<?php echo $this->lang->line('not_replied_tip'); ?>" />
                            <?php } ?>
                        </td>
                        <td width="104" height="32" class="line_account_4">
                            <?php echo date('d-m-Y', $contactArray->con_date_contact); ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletesendcontact_account.gif" onclick="ActionSubmit('frmAccountSendContact')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/contact/', 0)" border="0" style="cursor:pointer;" title="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" id="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        </form>
		<?php }elseif(count($contact) == 0 && trim($keyword) != ''){ ?>
		<tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_titleaccount.jpg" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">#</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountSendContact',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="135" class="title_account_1">
                            <?php echo $this->lang->line('position_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="90" class="title_account_1" style="border-left:none;">
                            <?php echo $this->lang->line('reply_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_send_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" >
                <table border="0" width="788" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_contact_defaults'); ?></td>
					</tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletesendcontact_account.gif" onclick="" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" />
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/contact/', 0)" border="0" style="cursor:pointer;" title="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" id="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
		<?php }else{ ?>
		<tr>
        	<td class="none_record" align="center" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg"><?php echo $this->lang->line('none_record_contact_defaults'); ?></td>
		</tr>
		<?php } ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_ac.png" height="16" ></td>
        </tr>
    </table>	
</td>					
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>