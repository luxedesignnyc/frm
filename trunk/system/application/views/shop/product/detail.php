<?php $this->load->view('shop/common/header'); ?>
<?php $this->load->view('shop/common/left'); ?>
<?php if(isset($siteGlobal)){ ?>
<!--BEGIN: Center-->
<td width="602" valign="top" align="center">
<div id="DivContent">
    <?php $this->load->view('shop/common/top'); ?>
    <table width="594" class="table_module" style="margin-top:5px;" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td height="28" class="title_module"><?php echo $this->lang->line('title_detail_product_detail'); ?></td>
        </tr>
        <tr>
            <td class="main_module">
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="top">
                            <table width="100%" class="tbl_detail" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="image_view_detail_top">
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center">
                                                    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/css/slimbox.css" media="screen" />
													<script language="javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/mootools.js"></script>
													<script language="javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/slimbox.js"></script>
                                                    <a href="<?php echo base_url(); ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo show_image($product->pro_image); ?>" rel="lightbox[product]">
                                                        <img src="<?php echo base_url(); ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo show_thumbnail($product->pro_dir, $product->pro_image, 3); ?>" id="image_detail" />
                                                    </a>
                                                    <?php $firstImage = true; ?>
                                                    <?php $imageDetail = explode(',', $product->pro_image); ?>
                                                    <?php foreach($imageDetail as $imageDetailArray){ ?>
                                                    <?php if($firstImage == false && $imageDetailArray != 'none.gif'){ ?>
                                                    <a href="<?php echo base_url(); ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetailArray; ?>" rel="lightbox[product]"></a>
                                                    <?php } ?>
                                                    <?php $firstImage = false; ?>
                                                    <?php } ?>
                                                    <div id="click_view">
                                                        <?php if(count($imageDetail) > 1 && $product->pro_image != 'none.gif'){ ?>
                                                        (<?php echo $this->lang->line('click_1_view_detail_product_detail').'&nbsp;<font color="#FF0000"><b>'.count($imageDetail).'</b></font>&nbsp;'.$this->lang->line('click_2_view_detail_product_detail'); ?>)
                                                        <?php }elseif($product->pro_image != 'none.gif'){ ?>
                                                        (<?php echo $this->lang->line('click_1_view_detail_product_detail').'&nbsp;'.$this->lang->line('click_2_view_detail_product_detail'); ?>)
                                                        <?php }else{ ?>
                                                        (<?php echo $this->lang->line('none_view_detail_product_detail'); ?>)
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    <td width="7" valign="top"></td>
                                    <td rowspan="2" class="info_view_detail" valign="top">
                                        <div id="title_detail">
                                            <?php echo $product->pro_name; ?>
                                        </div>
                                        <table border="0" cellpadding="0" cellspacing="5" align="left">
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('cost_detail_product_detail'); ?>:</td>
                                                <td id="cost_detail">
                                                    <?php if((int)$product->pro_cost == 0){ ?>
						                            <?php echo $this->lang->line('call_main'); ?>
												    <?php }else{ ?>
													<b><span id="DivCostDetail"></span>&nbsp;<?php echo $product->pro_currency; ?></b>
													<font color="#666666">
                                                    	<?php if(strtoupper($product->pro_currency) == 'VND'){ ?>
														(<span id="DivCostExchange"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>)
														<script>FormatCost('<?php echo round((int)$product->pro_cost/Setting::settingExchange); ?>', 'DivCostExchange');</script>
														<?php }else{ ?>
														(<span id="DivCostExchange"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>)
														<script>FormatCost('<?php echo round((int)$product->pro_cost*Setting::settingExchange); ?>', 'DivCostExchange');</script>
														<?php } ?>
													</font>
                                                	<script>FormatCost('<?php echo $product->pro_cost; ?>', 'DivCostDetail');</script>
                                                    <?php if((int)$product->pro_hondle == 1 || (int)$product->pro_saleoff == 1){ ?><div id="nego_detail"><?php if((int)$product->pro_hondle == 1){ ?><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/hondle.gif" border="0" />&nbsp;&nbsp;&nbsp;<?php } ?><?php if((int)$product->pro_saleoff == 1){ ?><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/icon_mirror.gif" border="0" /><?php } ?></div><?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('category_detail_product_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><?php if((int)$category->cat_status == 1){ ?><a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $category->cat_id; ?>" title="<?php echo $category->cat_descr; ?>" target="_blank"><?php } ?><?php echo $category->cat_name; ?><?php if((int)$category->cat_status == 1){ ?></a><?php } ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('address_detail_product_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $product->pro_address; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('phone_detail_product_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><?php echo $product->pro_phone; ?><?php if(trim($product->pro_phone) != '' && trim($product->pro_mobile) != ''){echo ' - ';} ?><?php echo $product->pro_mobile; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" class="list_detail"><?php echo $this->lang->line('yahoo_detail_product_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="ymsgr:SendIM?<?php echo $product->pro_yahoo; ?>"><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/yahoo.gif" border="0" />&nbsp;<?php echo $product->pro_yahoo; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" class="list_detail"><?php echo $this->lang->line('skype_detail_product_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="skype:<?php echo $product->pro_skype; ?>?Chat"><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/skype.gif" border="0" />&nbsp;<?php echo $product->pro_skype; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('poster_detail_product_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $product->pro_poster; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('post_date_detail_product_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo date('d-m-Y', $product->pro_begindate); ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('vote_detail_product_detail'); ?>:</td>
                                                <td id="vote_detail">
                                                    <?php for($vote = 0; $vote < (int)$product->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/star1.gif" border="0" />
		                                            <?php } ?>
		                                            <?php for($vote = 0; $vote < 10-(int)$product->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/star0.gif" border="0" />
		                                            <?php } ?>
		                                            <b>[<?php echo $product->pro_vote; ?>]</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="100%">
                                    <td class="image_view_detail_bottom" valign="bottom">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td height="25" valign="middle" style="padding-right:3px;"><a onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" href="#Favorite" title="<?php echo $this->lang->line('favorite_tip_detail_product_detail'); ?>"><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/icon_favorite_detail.gif" border="0" /></a></td>
                                                <td align="left" valign="middle">
                                                    <div style="display:none;"><form name="frmOneFavorite" method="post"><input type="hidden" name="checkone[]" value="<?php echo $product->pro_id; ?>" /></form></div>
                                                    <a class="menu_1" onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" href="#Favorite" title="<?php echo $this->lang->line('favorite_tip_detail_product_detail'); ?>">
                                                        <?php echo $this->lang->line('favorite_detail_product_detail'); ?>
                                                    </a>
                                                </td>
                                                <td style="padding-left:10px;">
                                                    <div style="display:none;"><form name="frmShowcart" method="post" action="<?php echo base_url(); ?>showcart"><input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>" /></form></div>
                                                    <a onclick="Showcart('frmShowcart', '1')" title="<?php echo $this->lang->line('showcart_tip_detail_product_detail'); ?>">
                                                        <img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/buy_product.png" border="0" style="cursor:pointer;" />
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="7" valign="top"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <table border="0" width="580" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td height="30" class="header_detail"><?php echo $this->lang->line('detail_detail_product_detail'); ?></td>
                                </tr>
                                <tr>
                                    <td class="main_detail">
                                     <?php echo $this->bbcode->light($product->pro_detail); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="30" class="bottom_detail"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="10" class="bottom_module"></td>
        </tr>
    </table>
</div>
<div id="DivSearch">
    <?php $this->load->view('shop/common/search'); ?>
</div>
<script>OpenSearch(0);</script>
</td>
<!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/right'); ?>
<?php $this->load->view('shop/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_message_detail_product_detail'); ?>');</script>
<?php } ?>