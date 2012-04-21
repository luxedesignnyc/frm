<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/tabview.css" />
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/tabview.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/jquery.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
<!--BEGIN: CENTER-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="26">
                
				<div class="TabView" id="TabView">
                    <div class="Tabs" style="width: 592px;">
                      <a onclick="getProduct(<?php if(isset($tabIDCategoryProduct_1)){echo $tabIDCategoryProduct_1;} ?>, 1, 'DivProduct', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')"><?php if(isset($tabNameCategoryProduct_1)){echo $tabNameCategoryProduct_1;} ?></a>
                      <a onclick="getProduct(<?php if(isset($tabIDCategoryProduct_2)){echo $tabIDCategoryProduct_2;} ?>, 1, 'DivProduct', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')"><?php if(isset($tabNameCategoryProduct_2)){echo $tabNameCategoryProduct_2;} ?></a>
                      <a onclick="getProduct(<?php if(isset($tabIDCategoryProduct_3)){echo $tabIDCategoryProduct_3;} ?>, 1, 'DivProduct', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')"><?php if(isset($tabNameCategoryProduct_3)){echo $tabNameCategoryProduct_3;} ?></a>
                      <a onclick="getProduct(<?php if(isset($tabIDCategoryProduct_4)){echo $tabIDCategoryProduct_4;} ?>, 1, 'DivProduct', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')"><?php if(isset($tabNameCategoryProduct_4)){echo $tabNameCategoryProduct_4;} ?></a>
                    </div>
                </div>
                <script type="text/javascript">tabview_initialize('TabView');</script>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" id="DivProduct" style="padding-top:6px;"></td>
                        <script>getProduct(<?php if(isset($tabIDCategoryProduct_1)){echo $tabIDCategoryProduct_1;} ?>, 1, 'DivProduct', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>');</script>
                    </tr>
                </table>
            </td>
        </tr>							
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_reliable_product_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" id="DivReliable" style="padding-top:6px;"></td>
                        <script>getReliable(2, 'DivReliable', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>');</script>
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
        <!--BEGIN: Ads & Job-->
		<tr>
		    <td valign="top">
		        <table border="0" width="100%" cellpadding="0" cellspacing="0">
		            <tr>
		                <td width="370" valign="top">
		                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
		                        <tr>
		                            <td style="background:url(<?php echo base_url(); ?>templates/home/images/bg_topkhung_raovat_home.png) top no-repeat;" width="100%" height="35">
		                                <div class="tile_modules" style="float:left;">
		                                    <table border="0" cellpadding="0" cellspacing="0">
		                                        <tr>
		                                            <td valign="top" style="padding-top:10px;"><?php echo $this->lang->line('title_ads_defaults'); ?>:</td>
		                                            <td width="8"></td>
		                                            <td style="padding-top:5px;"><a class="menu_3" onclick="getAds(3, 4, 'DivAdsHome', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')" style="cursor:pointer;"><img src="<?php echo base_url(); ?>templates/home/images/icon_raovat_tincay_home.png" border="0" /></a></td>
		                                            <td valign="top" style="padding-top:10px;"><a id="DivMenuTabAds_1" class="menu_3_selected" onclick="getAds(3, 4, 'DivAdsHome', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')" style="cursor:pointer;"><?php echo $this->lang->line('sub_1_title_ads_defaults'); ?></a></td>
		                                        </tr>
		                                    </table>
		                                </div>
		                                <div class="tile_modules" style="float:left;">
		                                    <table border="0" cellpadding="0" cellspacing="0">
		                                        <tr>
		                                            <td style="padding-top:5px;"><a class="menu_3" onclick="getAds(2, 4, 'DivAdsHome', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')" style="cursor:pointer;"><img src="<?php echo base_url(); ?>templates/home/images/icon_raovat_moinhat_home.png" border="0" /></a></td>
		                                            <td valign="top" style="padding-top:10px;"><a id="DivMenuTabAds_2" class="menu_3" onclick="getAds(2, 4, 'DivAdsHome', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')" style="cursor:pointer;"><?php echo $this->lang->line('sub_2_title_ads_defaults'); ?></a></td>
		                                        </tr>
		                                    </table>
		                                </div>
		                                <div class="tile_modules" style="float:left;">
		                                    <table border="0" cellpadding="0" cellspacing="0">
		                                        <tr>
		                                            <td style="padding-top:5px;"><a class="menu_3" onclick="getAds(1, 4, 'DivAdsHome', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')" style="cursor:pointer;"><img src="<?php echo base_url(); ?>templates/home/images/icon_raovat_xemnhieunhat_home.png" border="0" /></a></td>
		                                            <td valign="top" style="padding-top:10px;"><a id="DivMenuTabAds_3" class="menu_3" onclick="getAds(1, 4, 'DivAdsHome', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>')" style="cursor:pointer;"><?php echo $this->lang->line('sub_3_title_ads_defaults'); ?></a></td>
		                                        </tr>
		                                    </table>
		                                </div>
		                            </td>
		                        </tr>
		                        <tr>
		                            <td valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_raovat_home.jpg" style="padding-left:15px; padding-right:5px;">
		                                <table border="0" width="100%" height="300" cellpadding="0" cellspacing="0">
		                                    <tr>
		                                        <td height="10"></td>
		                                    </tr>
		                                    <tr>
		                                        <td id="DivAdsHome" valign="top"></td>
											</tr>
		                                    <tr>
		                                        <td valign="top" class="view_all" colspan="2"><a class="menu_2" href="<?php echo base_url(); ?>ads"><?php echo $this->lang->line('view_all_defaults'); ?></a></td>
		                                    </tr>
		                                </table>
		                                <script>getAds(3, 4, 'DivAdsHome', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>');</script>
		                            </td>
		                        </tr>
		                        <tr>
		                            <td style="background:url(<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_raovat_home.png) bottom no-repeat;" height="10" ></td>
		                        </tr>
		                    </table>
		                </td>
		                <td width="232" valign="top">
		                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
		                        <tr>
		                            <td style="background:url(<?php echo base_url(); ?>templates/home/images/bg_topkhung_vieclam_home.png) top no-repeat;" width="100%" height="35">
		                                <div class="tile_modules" style="padding-bottom:2px;"><?php echo $this->lang->line('title_job_defaults'); ?></div>
		                            </td>
		                        </tr>
		                        <tr>
		                            <td valign="top" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung_vieclam_home.jpg" style="padding-left:10px; padding-right:5px;">
		                                <table border="0" width="100%" height="300" cellpadding="0" cellspacing="0">
		                                    <tr>
		                                        <td height="10"></td>
		                                    </tr>
		                                    <tr>
		                                        <td id="DivJobHome" valign="top"></td>
		                                    </tr>
		                                    <tr>
		                                        <td valign="top" class="view_all" colspan="2"><a class="menu_2" href="<?php echo base_url(); ?>job"><?php echo $this->lang->line('view_all_defaults'); ?></a></td>
		                                    </tr>
		                                </table>
		                                <script>getJob(5, 'DivJobHome', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>');</script>
		                            </td>
		                        </tr>
		                        <tr>
		                            <td style="background:url(<?php echo base_url(); ?>templates/home/images/bg_bottomkhung_vieclam_home.png) bottom no-repeat;" height="10" ></td>
		                        </tr>
		                    </table>
		                </td>
		            </tr>
		        </table>
		    </td>
		</tr>
		<!--END Ads & Job-->
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_interest_shop_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" id="DivInterestShop" style="padding-top:6px;"></td>
                        <script>getInterestShop(3, 'DivInterestShop', '<?php echo $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo base_url(); ?>');</script>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_favorite_product_defaults'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top">
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