<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/advertise/top'); ?>
        <?php if(count($reliableProduct) > 0){ ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_reliable_category'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" style="margin-top:6px;" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top">
                            <?php $idDiv = 1; ?>
                            <?php foreach($reliableProduct as $reliableProductArray){ ?>
                            <div class="showbox_1" id="DivReliableProductBox_<?php echo $idDiv; ?>" onmouseover="ChangeStyleBox('DivReliableProductBox_<?php echo $idDiv; ?>',1)" onmouseout="ChangeStyleBox('DivReliableProductBox_<?php echo $idDiv; ?>',2)">
                                <a href="<?php echo base_url(); ?>product/category/<?php echo $reliableProductArray->pro_category; ?>/detail/<?php echo $reliableProductArray->pro_id; ?>" title="<?php echo $reliableProductArray->pro_descr; ?>">
                                    <img src="<?php echo base_url(); ?>media/images/product/<?php echo $reliableProductArray->pro_dir; ?>/<?php echo show_thumbnail($reliableProductArray->pro_dir, $reliableProductArray->pro_image, 2); ?>" class="image_showbox_1" />
                                    <div class="name_showbox_1">
                                        <?php echo sub($reliableProductArray->pro_name, 35); ?>
                                    </div>
                                </a>
                                    <div class="cost_showbox">
                                        <span id="DivCostReliable_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $reliableProductArray->pro_currency; ?>
                                    </div>
                                    <script>FormatCost('<?php echo $reliableProductArray->pro_cost; ?>', 'DivCostReliable_<?php echo $idDiv; ?>');</script>
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
        <form name="frmListPro" method="post">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
                    <tr height="29">
                        <td width="28" align="center" class="title_boxpro_0"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmListPro',0)" /></td>
                        <td width="110" class="title_boxpro_1"><?php echo $this->lang->line('image_list'); ?></td>
                        <td class="title_boxpro_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="105" class="title_boxpro_1">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </td>
                    </tr>
                    <?php $idDiv = 1; ?>
                    <?php foreach($newProduct as $newProductArray){ ?>
                    <tr>
                        <td width="28" align="center" class="line_boxpro_0"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $newProductArray->pro_id; ?>" onclick="DoCheckOne('frmListPro')" /></td>
                        <td width="110" class="line_boxpro_1">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $newProductArray->pro_category; ?>/detail/<?php echo $newProductArray->pro_id; ?>">
                                <img src="<?php echo base_url(); ?>media/images/product/<?php echo $newProductArray->pro_dir; ?>/<?php echo show_thumbnail($newProductArray->pro_dir, $newProductArray->pro_image); ?>" class="image_boxpro" onmouseover="ddrivetip_image('<img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $newProductArray->pro_dir; ?>/<?php echo show_image($newProductArray->pro_image); ?>\' border=0>',1,'#F0F8FF');" onmouseout="hideddrivetip();" />
                            </a>
                        </td>
                        <td valign="top" class="line_boxpro_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $newProductArray->pro_category; ?>/detail/<?php echo $newProductArray->pro_id; ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo $newProductArray->pro_name; ?>
                            </a>
                            <div class="descr_boxpro">
                                <?php echo $newProductArray->pro_descr; ?>
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" class="saleoff_boxpro">
                                        <?php if((int)$newProductArray->pro_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff.gif" border="0" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxpro"><?php echo $this->lang->line('view_category'); ?>:&nbsp;<?php echo $newProductArray->pro_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('comment_category'); ?>:&nbsp;<?php echo $newProductArray->pro_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="105" class="line_boxpro_1">
                            <?php if((int)$newProductArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                            <?php }else{ ?>
                            <span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $newProductArray->pro_currency; ?>
                            <div class="usd_boxpro">
                                <?php if(strtoupper($newProductArray->pro_currency) == 'VND'){ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>
								<script>FormatCost('<?php echo round($newProductArray->pro_cost/Setting::settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
								<?php }else{ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
								<script>FormatCost('<?php echo round($newProductArray->pro_cost*Setting::settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
								<?php } ?>
							</div>
                            <script>FormatCost('<?php echo $newProductArray->pro_cost; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                            <?php if($newProductArray->pro_hondle == 1){ ?>
                            <div class="nego_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/hondle.gif" border="0" /></div>
                            <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                 </table>
                 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="favorite_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite.gif" onclick="Favorite('frmListPro', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxpro">
                            <select name="select_sort" id="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_category'); ?></option>
                            </select>
                        </td>
                        <td width="37%" id="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
             </td>
        </tr>
        </form>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_favorite_category'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table align="center" style="margin-top:6px;" width="580" border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <?php $isCounter = 1; ?>
                                    <?php foreach($favoriteProduct as $favoriteProductArray){ ?>
                                    <td width="12%">
                                        <div class="img_bestvote">
                                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $favoriteProductArray->pro_category; ?>/detail/<?php echo $favoriteProductArray->pro_id; ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                            	<img src="<?php echo base_url(); ?>media/images/product/<?php echo $favoriteProductArray->pro_dir; ?>/<?php echo show_thumbnail($favoriteProductArray->pro_dir, $favoriteProductArray->pro_image); ?>" class="image_bestvote" />
                                            </a>
                                        </div>
                                    </td>
                                    <td width="38%" <?php if($isCounter % 2 != 0){ ?>style="border-right:1px #D4EDFF dotted;"<?php } ?>>
                                        <div class="title_bestvote">
                                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $favoriteProductArray->pro_category; ?>/detail/<?php echo $favoriteProductArray->pro_id; ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                            <?php echo sub($favoriteProductArray->pro_name, 80); ?>
                                            </a>
                                        </div>
                                        <div class="descr_bestvote">
                                            (<?php echo $favoriteProductArray->pro_descr; ?>)
                                        </div>
                                        <div class="vote_bestvote">
                                            <?php for($vote = 0; $vote < (int)$favoriteProductArray->pro_vote_total; $vote++){ ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" />
                                            <?php } ?>
                                            <?php for($vote = 0; $vote < 10-(int)$favoriteProductArray->pro_vote_total; $vote++){ ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" />
                                            <?php } ?>
                                            <font color="#004B7A"><b>[<?php echo $favoriteProductArray->pro_vote; ?>]</b></font>
                                        </div>
                                    </td>
                                    <?php if($isCounter % 2 == 0 && $isCounter < count($favoriteProduct)){ ?>
                                    </tr><tr valign="top">
                                    <?php } ?>
                                    <?php $isCounter++; ?>
                                    <?php } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_category'); ?>');</script>
<?php } ?>