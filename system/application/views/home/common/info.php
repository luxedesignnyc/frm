<!--BEGIN: RIGHT-->
<td width="402" valign="top">
    <table width="402" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung_right.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_info'); ?></div>
            </td>
        </tr>
        <?php if((trim(strtolower($this->uri->segment(1))) == 'product' || trim(strtolower($this->uri->segment(1))) == 'ads' || trim(strtolower($this->uri->segment(1))) == 'job' || trim(strtolower($this->uri->segment(1))) == 'employ') && trim(strtolower($this->uri->segment(2))) == 'post'){ ?>
        <tr>
            <td height="100%" class="global_info" align="left" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_right.jpg" valign="top">
            	<?php echo $this->lang->line('post_1_info'); ?>
            	<?php echo $this->lang->line('post_2_info'); ?>
            	<?php echo $this->lang->line('global_info'); ?>
            </td>
        </tr>
        <?php }elseif(trim(strtolower($this->uri->segment(1))) == 'login' || trim(strtolower($this->uri->segment(1))) == 'logout' || trim(strtolower($this->uri->segment(1))) == 'forgot'){ ?>
        <tr>
            <td height="100%" class="global_info" align="left" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_right.jpg" valign="top">
            	<?php echo $this->lang->line('login_1_info'); ?>
            	<?php echo $this->lang->line('login_2_info'); ?>
            	<?php echo $this->lang->line('global_info'); ?>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
            <td height="100%" class="global_info" align="left" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_right.jpg" valign="top">
            	<?php echo $this->lang->line('register_1_info'); ?>
            	<?php echo $this->lang->line('register_2_info'); ?>
            	<?php echo $this->lang->line('global_info'); ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_right.png" height="16" ></td>
        </tr>
    </table>
</td>
<!--END RIGHT-->