<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<td width="803" valign="top">
    <table width="803" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_ac.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_notify_detail'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_ac.jpg" valign="top" align="left" >
                <table width="780" border="0" style="margin-left:13px;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="5"></td>
                    </tr>
                    <tr>
                        <td height="50" class="header_communicate">
                            <div class="title_communicate"><?php echo $notify->not_title; ?></div>
                            <div class="time_communicate">(<?php echo $this->lang->line('date_notify_notify_detail'); ?>&nbsp;<?php echo date('d-m-Y', $notify->not_begindate); ?>)</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="content_communicate"><?php echo $this->bbcode->light($notify->not_detail); ?></td>
                    </tr>
                </table>
            </td>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_ac.png" height="16" ></td>
        </tr>
    </table>	
</td>					
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>