<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                    <!--BEGIN: Main-->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td>
                                <!--BEGIN: Item Menu-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" height="67" class="item_menu_left">
                                            <a href="<?php echo base_url(); ?>administ/user/inactive">
                                            	<img src="<?php echo base_url(); ?>templates/admin/images/item_noactuser.gif" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_inactive'); ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmInActUser')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_delete.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('delete_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/user/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                       		<img src="<?php echo base_url(); ?>templates/admin/images/icon_add.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="icon_item" id="icon_item_3" onclick="ActionLink('<?php echo base_url(); ?>administ/user/end')" onmouseover="ChangeStyleIconItem('icon_item_3',1)" onmouseout="ChangeStyleIconItem('icon_item_3',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                       		<img src="<?php echo base_url(); ?>templates/admin/images/icon_expiry.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('end_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <!--END Item Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td align="center">
                                <!--BEGIN: Search-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="160" align="left">
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="input_search" onfocus="ChangeStyle('keyword',1)" onblur="ChangeStyle('keyword',2)" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/user/inactive/',1)" class="select_search">
                                                <option value="0"><?php echo $this->lang->line('search_by_search'); ?></option>
                                                <option value="username"><?php echo $this->lang->line('username_inactive'); ?></option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/user/inactive/',1)" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                        <!---->
                                        <td width="115" align="left">
                                            <select name="filter" id="filter" onchange="ActionSearch('<?php echo base_url(); ?>administ/user/inactive/',2)" class="select_search">
                                               <option value="0"><?php echo $this->lang->line('filter_by_search'); ?></option>
                                                <option value="regisdate"><?php echo $this->lang->line('regisdate_search'); ?></option>
                                                <option value="enddate"><?php echo $this->lang->line('enddate_search'); ?></option>
                                                <option value="lastestlogin"><?php echo $this->lang->line('lastest_login_inactive'); ?></option>
                                                <option value="active"><?php echo $this->lang->line('active_search'); ?></option>
                                                <option value="deactive"><?php echo $this->lang->line('deactive_search'); ?></option>
                                                <option value="admin"><?php echo $this->lang->line('admin_inactive'); ?></option>
                                                <option value="saler"><?php echo $this->lang->line('saler_inactive'); ?></option>
                                                <option value="vip"><?php echo $this->lang->line('vip_inactive'); ?></option>
                                                <option value="normal"><?php echo $this->lang->line('normal_inactive'); ?></option>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_1" width="10" align="center"><b>:</b></td>
                                        <td id="DivDateSearch_2" width="60" align="left">
                                            <select name="day" id="day" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('day_search'); ?></option>
                                                <?php $this->load->view('admin/common/day'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_3" width="10" align="center"><b>-</b></td>
                                        <td id="DivDateSearch_4" width="60" align="left">
                                            <select name="month" id="month" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('month_search'); ?></option>
                                                <?php $this->load->view('admin/common/month'); ?>
                                            </select>
                                        </td>
                                        <td id="DivDateSearch_5" width="10" align="center"><b>-</b></td>
                                        <td id="DivDateSearch_6" width="60" align="left">
                                            <select name="year" id="year" class="select_datesearch">
                                                <option value="0"><?php echo $this->lang->line('year_search'); ?></option>
                                                <?php $this->load->view('admin/common/year'); ?>
                                            </select>
                                        </td>
                                        <script>OpenTabSearch('0',0);</script>
                                        <td width="25" align="right">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/user/inactive/',2)" title="<?php echo $this->lang->line('filter_tip'); ?>" />
                                        </td>
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmInActUser" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">#</td>
                                        <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmInActUser',0)" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('username_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('email_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>email/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>email/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="90" class="title_list">
                                            <?php echo $this->lang->line('group_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>group/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>group/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="60" class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>
                                        <td width="125" class="title_list">
                                            <?php echo $this->lang->line('regisdate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>regisdate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>regisdate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="125" class="title_list">
                                            <?php echo $this->lang->line('enddate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="210" class="title_list">
                                            <?php echo $this->lang->line('lastest_login_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>lastestlogin/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>lastestlogin/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                    </tr>
                                    <!---->
                                    <?php $idDiv = 1; ?>
                                    <?php foreach($user as $userArray){ ?>
                                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $userArray->use_id; ?>" <?php if($userLogined == $userArray->use_id){echo 'disabled="disabled"';} ?> onclick="DoCheckOne('frmInActUser')" />
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $userArray->use_id; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                                <?php echo $userArray->use_username; ?>
                                            </a>
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="mailto:<?php echo $userArray->use_email; ?>">
                                                <?php echo $userArray->use_email; ?>
                                            </a>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($userArray->use_group == 4){ ?>
											<span style="color:#F00; font-weight:bold;">
											<?php }elseif($userArray->use_group == 3){ ?>
											<span style="color:#009900; font-weight:bold;">
											<?php }elseif($userArray->use_group == 2){ ?>
											<span style="color:#06F; font-weight:bold;">
											<?php }else{ ?>
											<span style="font-weight:normal;">
											<?php } ?>
											<?php echo $userArray->gro_name; ?>
											</span>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($userArray->use_status == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" <?php if($userLogined != $userArray->use_id){ ?> onclick="ActionStatus('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $userArray->use_id; ?>')" style="cursor:pointer;" <?php } ?> border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" <?php if($userLogined != $userArray->use_id){ ?> onclick="ActionStatus('<?php echo $statusUrl; ?>/status/active/id/<?php echo $userArray->use_id; ?>')" style="cursor:pointer;" <?php } ?> border="0" title="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $userArray->use_regisdate); ?></b></td>
                                        <td class="detail_list" style="text-align:center;"><b><?php if($userArray->use_enddate == $userArray->use_regisdate){echo $this->lang->line('not_set_inactive');}else{echo date('d-m-Y', $userArray->use_enddate);} ?></b></td>
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $userArray->use_lastest_login); ?></b></td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php } ?>
                                    <!---->
                                    <tr>
                                        <td id="show_page" colspan="9"><?php echo $linkPage; ?></td>
                                    </tr>
                                </table>
                                <!--END Content-->
                            </td>
                        </tr>
                        </form>
                    </table>
                    <!--END Main-->
                </td>
                <td width="10" class="right_main" valign="top"></td>
                <td width="2"></td>
            </tr>
            <tr>
                <td width="2" height="11"></td>
                <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                <td height="11" class="middle_bottom_main"></td>
                <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                <td width="2" height="11"></td>
            </tr>
        </table>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>