<!--BEGIN: RIGHT-->
<td width="195" bgcolor="#f3f3f3" valign="top">
    <table width="195" border="0" cellpadding="0" cellspacing="0">
        <?php if(trim($module) != '' && stristr($module, 'top_saleoff_product')){ ?>
        <?php $this->load->view('home/product/top_saleoff'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_lastest_product')){ ?>
        <?php $this->load->view('home/product/top_lastest'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_buyest_product')){ ?>
        <?php $this->load->view('home/product/top_buyest'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_shop_ads')){ ?>
        <?php $this->load->view('home/ads/top_shop'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_lastest_ads')){ ?>
        <?php $this->load->view('home/ads/top_lastest'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_view_ads')){ ?>
        <?php $this->load->view('home/ads/top_view'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_24h_job')){ ?>
        <?php $this->load->view('home/job/top_24h'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_24h_employ')){ ?>
        <?php $this->load->view('home/employ/top_24h'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_saleoff_shop')){ ?>
        <?php $this->load->view('home/shop/top_saleoff'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_lastest_shop')){ ?>
        <?php $this->load->view('home/shop/top_lastest'); ?>
        <?php } ?>
        <?php if(trim($module) != '' && stristr($module, 'top_productest_shop')){ ?>
        <?php $this->load->view('home/shop/top_productest'); ?>
        <?php } ?>
		
		<tr>
            <td class="tieude_trai"><?php echo $this->lang->line('title_advertise_right'); ?></td>
        </tr>
        <tr>
            <td height="5"></td>
        </tr>
        <?php $this->load->view('home/advertise/right'); ?>
    </table>
</td>
<!--END RIGHT-->