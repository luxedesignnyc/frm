<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_top_view_ads_right'); ?></td>
</tr>
<tr>
    <td align="left" style="padding:5px 5px 0px 5px;">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <?php foreach($topViewAds as $topViewAdsArray){ ?>
            <tr>
                <td valign="top" style="padding-top:4px;"><img src="<?php echo base_url(); ?>templates/home/images/list_dot.gif" border="0" /></td>
                <td class="list_1" valign="top">
                    <a class="menu_1" href="<?php echo base_url(); ?>ads/category/<?php echo $topViewAdsArray->ads_category; ?>/detail/<?php echo $topViewAdsArray->ads_id; ?>" onmouseover="ddrivetip('<?php echo $topViewAdsArray->ads_descr; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo $topViewAdsArray->ads_title; ?></a>&nbsp;<span class="number_view">(<?php echo $topViewAdsArray->ads_view; ?>)</span>&nbsp;
                    <?php if($topViewAdsArray->ads_begindate >= mktime(0, 0, 0, date('m'), date('d'), date('Y'))){ ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/icon_new.gif" height="14" border="0" />
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </td>
</tr>