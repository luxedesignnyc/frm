<?php $this->load->view('home/common/header'); ?>
<!--BEGIN: LEFT-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_left.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_activation'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_left.jpg" style="padding-left:4px;" valign="top" >
                <table width="585" class="post_main" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2" height="20" class="post_top"></td>
                    </tr>
                    <tr>
                        <td class="stop_register">
                            <meta http-equiv=refresh content="5; url=<?php echo base_url(); ?>">
                            <?php if(isset($vipOrSalerActivation) && $vipOrSalerActivation == true){ ?>
                            <?php echo $this->lang->line('vip_or_saler_activation'); ?>
                            <?php }elseif(isset($successActivation) && $successActivation == true){ ?>
                            <?php echo $this->lang->line('success_activation'); ?>
		                    <?php }else{ ?>
		                    <?php echo $this->lang->line('error_activation'); ?>
		                    <?php } ?>
						</td>
					</tr>
                    <tr>
                        <td colspan="2" height="30" class="post_bottom"></td>
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