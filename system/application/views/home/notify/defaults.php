<?php $this->load->view('home/common/header'); ?>
<!--BEGIN: LEFT-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_left.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_detail_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_left.jpg" style="padding-left:4px;" valign="top">
                <table width="585" class="post_main" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td height="20" class="post_top"></td>
                    </tr>
                    <tr>
                        <td class="title_notify_detail"><?php echo $notify->not_title; ?></td>
                    </tr>
                    <tr>
                        <td height="10" class="post_bottom"></td>
                    </tr>
                </table>
                <table width="585" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                        <td class="content_notify_detail"><?php echo $this->bbcode->light($notify->not_detail); ?></td>
                    </tr>
                    <tr>
                        <td width="585" height="30" style="background:url(<?php echo base_url(); ?>templates/home/images/bottom_notify_detail.png) no-repeat bottom;"></td>
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
<!--BEGIN: RIGHT-->
<td width="402" valign="top">
    <table width="402" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_right.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_list_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_right.jpg" valign="top" style="padding:10px;">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="25"><?php echo $this->lang->line('welcome_notify_defaults'); ?></td>
					</tr>
				</table>
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <?php foreach($listNotify as $listNotifyArray){ ?>
                    <tr>
                        <td width="5" valign="top" style="padding-top:4px;"><img src="<?php echo base_url(); ?>templates/home/images/list_ten.gif" border="0" /></td>
                        <td class="list_2" style="font-size:12px;" valign="top">
                            <a class="<?php if($listNotifyArray->not_id == $id){echo 'menu_2';}else{echo 'menu_1';} ?>" href="<?php echo base_url(); ?>notify/<?php echo $listNotifyArray->not_id; ?><?php if(isset($page) && (int)$page > 0){ ?>/page/<?php echo $page; ?><?php } ?>" title="<?php echo $this->lang->line('detail_tip'); ?>"><?php echo $listNotifyArray->not_title; ?></a>
                            <span class="date_view">(<?php echo date('d-m-Y', $listNotifyArray->not_begindate); ?>)</span>
                        </td>
                    </tr>
                    <?php } ?>
					<tr>
					    <td colspan="2" align="right" id="show_page" style="padding-right:0px;"><?php echo $linkPage; ?></td>
					</tr>
                </table>
                <table>
                    <tr>
                        <td valign="top"><?php echo $this->lang->line('global_info'); ?></td>
					</tr>
				</table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_right.png" height="16" ></td>
        </tr>
    </table>
</td>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>