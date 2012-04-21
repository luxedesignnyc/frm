<?php if(count($topSaleoffProduct) > 0){ ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_top_saleoff_product_right'); ?></td>
</tr>
<tr>
    <td align="left" style="padding:5px 5px 0px 5px;">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <?php foreach($topSaleoffProduct as $topSaleoffProductArray){ ?>
            <tr>
                <td valign="top" style="padding-top:4px;"><img src="<?php echo base_url(); ?>templates/home/images/list_dot.gif" border="0" /></td>
                <td class="list_1" valign="top">
                    <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $topSaleoffProductArray->pro_category; ?>/detail/<?php echo $topSaleoffProductArray->pro_id; ?>" onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $topSaleoffProductArray->pro_dir; ?>/<?php echo show_thumbnail($topSaleoffProductArray->pro_dir, $topSaleoffProductArray->pro_image); ?>\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'><?php echo $topSaleoffProductArray->pro_descr; ?></td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo $topSaleoffProductArray->pro_name; ?></a>
                    <?php if($topSaleoffProductArray->pro_begindate >= mktime(0, 0, 0, date('m'), date('d'), date('Y'))){ ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/icon_new.gif" height="14" border="0" />
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            <tr>
         		<td valign="top" class="view_all" colspan="2"><a class="menu_2" href="<?php echo base_url(); ?>product/saleoff"><?php echo $this->lang->line('view_all_right'); ?></a></td>
        	</tr>
        </table>
    </td>
</tr>
<?php } ?>