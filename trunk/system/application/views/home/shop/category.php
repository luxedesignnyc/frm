<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/advertise/top'); ?>
        <?php if(count($interestShop) > 0){ ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_interest_category'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" style="margin-top:6px;" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top">
                            <?php $idDiv = 1; ?>
                            <?php foreach($interestShop as $interestShopArray){ ?>
                            <div class="showbox_2" id="DivInterestShopBox_<?php echo $idDiv; ?>" onmouseover="ChangeStyleBox('DivInterestShopBox_<?php echo $idDiv; ?>',1)" onmouseout="ChangeStyleBox('DivInterestShopBox_<?php echo $idDiv; ?>',2)">
                                <table height="91" align="center" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url(); ?><?php echo $interestShopArray->sho_link; ?>" title="<?php echo $interestShopArray->sho_descr; ?>">
                                                <img src="<?php echo base_url(); ?>media/shop/logos/<?php echo $interestShopArray->sho_dir_logo; ?>/<?php echo $interestShopArray->sho_logo; ?>" class="image_showbox_2" />
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php $idDiv++; ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <tr>
            <td height="5"></td>
		</tr>
        <?php $this->load->view('home/advertise/bottom'); ?>
        <?php } ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_new_category'); ?></div>
            </td>
        </tr>
        <?php if(count($shop) > 0){ ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg">
                <table align="center" width="580" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
                    <tr height="29">
                        <td width="110" class="title_boxshop_1"><?php echo $this->lang->line('logo_list'); ?></td>
                        <td class="title_boxshop_2">
                            <?php echo $this->lang->line('shop_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="150" class="title_boxshop_1">
                            <?php echo $this->lang->line('address_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>address/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>address/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                    </tr>
                    <?php foreach($shop as $shopArray){ ?>
                    <tr>
                        <td width="110" class="line_boxshop_1">
                            <a class="menu" href="<?php echo base_url(); ?><?php echo $shopArray->sho_link; ?>" title="<?php echo $this->lang->line('access_shop_tip'); ?>">
                                <img src="<?php echo base_url(); ?>media/shop/logos/<?php echo $shopArray->sho_dir_logo; ?>/<?php echo $shopArray->sho_logo; ?>" class="image_boxshop" />
                            </a>
                        </td>
                        <td valign="top" class="line_boxshop_2">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $shopArray->sho_link; ?>" title="<?php echo $this->lang->line('access_shop_tip'); ?>">
                                <?php echo $shopArray->sho_name; ?>
                            </a>
                            <div class="descr_boxshop">
                                <?php echo $shopArray->sho_descr; ?>
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="41%" class="saleoff_boxshop">
                                        <?php if($shopArray->sho_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff_shop.gif" border="0" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxshop"><?php echo $this->lang->line('access_category'); ?>:&nbsp;<?php echo $shopArray->sho_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('quantity_product_category'); ?>:&nbsp;<?php echo $shopArray->sho_quantity_product; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="150" class="line_boxshop_1">
                            <div class="address_boxshop"><?php echo $shopArray->sho_address; ?>, <?php echo $shopArray->pre_name; ?></div>
                            <div class="phone_boxshop">(<?php echo $this->lang->line('phone_category'); ?>: <?php echo $shopArray->sho_phone; ?>)</div>
                            <?php if(trim($shopArray->sho_yahoo) != ''){ ?>
                            <div class="status_yahoo"><a href="ymsgr:SendIM?<?php echo $shopArray->sho_yahoo; ?>"><img src="http://opi.yahoo.com/online?u=<?php echo $shopArray->sho_yahoo; ?>&m=g&t=1" border="0" /></a></div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                 </table>
                 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="regis_boxshop"><img src="<?php echo base_url(); ?>templates/home/images/icon_regisboxshop.gif" onclick="ActionLink('<?php echo base_url(); ?>register')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxshop">
                            <select name="select_sort" id="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>product/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_quantity_product_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>product/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_quantity_product_category'); ?></option>
                            </select>
                        </td>
                        <td width="37%" id="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
             </td>
        </tr>
        <?php }else{ ?>
        <tr>
	        <td class="none_record" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg">
				<?php echo $this->lang->line('none_shop_category'); ?>
			</td>
		</tr>
  		<?php } ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>