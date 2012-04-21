<?php if(isset($siteGlobal)){ ?>
<!--BEGIN: Right-->
<td width="201" valign="top" bgcolor="#DFF3FE">
    <table width="201" border="0" cellpadding="0" cellspacing="0">
        <?php if(isset($module) && $module == 'top_lastest_ads'){ ?>
        <?php $this->load->view('shop/ads/top_lastest'); ?>
        <?php } ?>
        <?php if(isset($module) && $module == 'top_lastest_product'){ ?>
        <?php $this->load->view('shop/product/top_lastest'); ?>
        <?php } ?>
        <tr>
            <td class="title"><?php echo $this->lang->line('title_advertise_right_detail_global'); ?></td>
        </tr>
        <tr>
            <td height="5"></td>
        </tr>
        <?php $this->load->view('home/advertise/right'); ?>
    </table>
</td>
<!--END Right-->
<?php } ?>