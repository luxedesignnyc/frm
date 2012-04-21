<?php $this->load->view('home/common/header'); ?>
<!--BEGIN: LEFT-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_left.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_logout'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_left.jpg" style="padding-left:4px;" valign="top" >
                <table width="500" class="form_main" border="0" style="margin-left:45px;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="20" class="form_top"></td>
                    </tr>
                    <tr>
                        <td class="success_post">
                            <meta http-equiv=refresh content="2; url=<?php echo base_url(); ?>">
                            <?php echo $this->lang->line('success_logout'); ?>
						</td>
					</tr>
                    <tr>
                        <td height="25" class="form_bottom"></td>
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
<?php $this->load->view('home/common/info'); ?>
<?php $this->load->view('home/common/footer'); ?>