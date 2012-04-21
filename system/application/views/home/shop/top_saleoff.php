<?php if(count($topSaleoffShop) > 0){ ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_top_saleoff_shop_right'); ?></td>
</tr>
<tr>
    <td align="left" style="padding:5px 5px 0px 5px;">
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <?php foreach($topSaleoffShop as $topSaleoffShopArray){ ?>
            <tr>
                <td valign="top" style="padding-top:4px;"><img src="<?php echo base_url(); ?>templates/home/images/list_dot.gif" border="0" /></td>
                <td class="list_1" valign="top">
                    <a class="menu_1" href="<?php echo base_url(); ?><?php echo $topSaleoffShopArray->sho_link; ?>" onmouseover="ddrivetip('<?php echo $topSaleoffShopArray->sho_descr; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo $topSaleoffShopArray->sho_name; ?></a>
                    <?php if($topSaleoffShopArray->sho_begindate >= mktime(0, 0, 0, date('m'), date('d'), date('Y'))){ ?>
                    <img src="<?php echo base_url(); ?>templates/home/images/icon_new.gif" height="14" border="0" />
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            <tr>
         		<td valign="top" class="view_all" colspan="2"><a class="menu_2" href="<?php echo base_url(); ?>shop/saleoff"><?php echo $this->lang->line('view_all_right'); ?></a></td>
        	</tr>
        </table>
    </td>
</tr>
<?php } ?>