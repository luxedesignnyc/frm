<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_top_productest_shop_right'); ?></td>
</tr>
<tr>
    <td align="center" style="padding:5px;">
        <?php $idDiv = 1; ?>
        <?php foreach($topProductestShop as $topProductestShopArray){ ?>
        <div class="top_productest_shop" id="DivTopProductest_<?php echo $idDiv; ?>" onmouseover="ChangeStyleBox('DivTopProductest_<?php echo $idDiv; ?>',1)" onmouseout="ChangeStyleBox('DivTopProductest_<?php echo $idDiv; ?>',2)">
        	<a href="<?php echo base_url(); ?><?php echo $topProductestShopArray->sho_link; ?>" title="<?php echo $topProductestShopArray->sho_descr; ?>">
				<table align="center" width="59" height="50" cellpadding="0" cellspacing="0">
  				  	<tr>
        				<td align="center"><div><img src="<?php echo base_url(); ?>media/shop/logos/<?php echo $topProductestShopArray->sho_dir_logo; ?>/<?php echo $topProductestShopArray->sho_logo; ?>" class="image_top_productest_shop" /></div></td>
					</tr>
				</table>
			</a>
		</div>
		<?php $idDiv++; ?>
   		<?php } ?>
    </td>
</tr>