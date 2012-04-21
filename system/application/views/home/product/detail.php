<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/slimbox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/tabview_detail.css" />
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/mootools.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/slimbox.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/tabview.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: CENTER-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/advertise/top'); ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_detail'); ?></div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="top">
                            <table width="99%" class="tbl_detail" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="image_view_detail_top">
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center">
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
                                                        (<?php echo $this->lang->line('click_1_image_detail').'&nbsp;<font color="#FF0000"><b>'.count($imageDetail).'</b></font>&nbsp;'.$this->lang->line('click_2_image_detail'); ?>)
                                                        <?php }elseif($product->pro_image != 'none.gif'){ ?>
                                                        (<?php echo $this->lang->line('click_1_image_detail').'&nbsp;'.$this->lang->line('click_2_image_detail'); ?>)
                                                        <?php }else{ ?>
                                                        (<?php echo $this->lang->line('none_image_detail'); ?>)
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
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('cost_detail'); ?>:</td>
                                                <td id="cost_detail">
                                                    <?php if((int)$product->pro_cost == 0){ ?>
						                            <?php echo $this->lang->line('call_main'); ?>
						                            <?php }else{ ?>
													<b><span id="DivCostDetail"></span>&nbsp;<?php echo $product->pro_currency; ?></b>
													<script>FormatCost('<?php echo $product->pro_cost; ?>', 'DivCostDetail');</script>
													<font color="#666666">
														<?php if(strtoupper($product->pro_currency) == 'VND'){ ?>
														(<span id="DivCostExchange"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>)
														<script>FormatCost('<?php echo round((int)$product->pro_cost/Setting::settingExchange); ?>', 'DivCostExchange');</script>
														<?php }else{ ?>
														(<span id="DivCostExchange"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>)
														<script>FormatCost('<?php echo round((int)$product->pro_cost*Setting::settingExchange); ?>', 'DivCostExchange');</script>
														<?php } ?>
													</font>
                                                    <?php if((int)$product->pro_hondle == 1 || (int)$product->pro_saleoff == 1){ ?><div id="nego_detail"><?php if((int)$product->pro_hondle == 1){ ?><img src="<?php echo base_url(); ?>templates/home/images/hondle.gif" border="0" />&nbsp;&nbsp;&nbsp;<?php } ?><?php if((int)$product->pro_saleoff == 1){ ?><img src="<?php echo base_url(); ?>templates/home/images/icon_mirror.gif" border="0" /><?php } ?></div><?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('place_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><?php if($placeSaleIsShop == true){ ?><a class="menu_1" href="<?php echo base_url(); ?><?php echo $shop->sho_link; ?>" target="_blank" title="<?php echo $shop->sho_descr; ?>"><?php echo $shop->sho_name; ?></a><?php }elseif(count($province) == 1){echo $province->pre_name;} ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('address_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $product->pro_address; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('phone_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><?php echo $product->pro_phone; ?><?php if(trim($product->pro_phone) != '' && trim($product->pro_mobile) != ''){echo ' - ';} ?><?php echo $product->pro_mobile; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" class="list_detail"><?php echo $this->lang->line('yahoo_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="ymsgr:SendIM?<?php echo $product->pro_yahoo; ?>"><img src="<?php echo base_url(); ?>templates/home/images/yahoo.gif" border="0" />&nbsp;<?php echo $product->pro_yahoo; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" class="list_detail"><?php echo $this->lang->line('skype_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="skype:<?php echo $product->pro_skype; ?>?Chat"><img src="<?php echo base_url(); ?>templates/home/images/skype.gif" border="0" />&nbsp;<?php echo $product->pro_skype; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('poster_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $product->pro_poster; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('post_date_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo date('d-m-Y', $product->pro_begindate); ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('vote_detail'); ?>:</td>
                                                <td id="vote_detail">
                                                    <?php for($vote = 0; $vote < (int)$product->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" />
		                                            <?php } ?>
		                                            <?php for($vote = 0; $vote < 10-(int)$product->pro_vote_total; $vote++){ ?>
		                                            <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" />
		                                            <?php } ?>
		                                            <b>[<?php echo $product->pro_vote; ?>]</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="100%">
                                    <td class="image_view_detail_bottom" valign="bottom">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td height="25" valign="middle" style="padding-right:3px;"><a onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" href="#Favorite"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite_detail.gif" border="0" title="<?php echo $this->lang->line('favorite_tip_detail'); ?>" /></a></td>
                                                <td align="left" valign="middle">
                                                    <div style="display:none;"><form name="frmOneFavorite" method="post"><input type="hidden" name="checkone[]" value="<?php echo $product->pro_id; ?>" /></form></div>
                                                    <a class="menu_1" onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" href="#Favorite" title="<?php echo $this->lang->line('favorite_tip_detail'); ?>">
                                                        <?php echo $this->lang->line('favorite_detail'); ?>
                                                    </a>
                                                </td>
                                                <td style="padding-left:10px;">
                                                    <div style="display:none;"><form name="frmShowcart" method="post" action="<?php echo base_url(); ?>showcart"><input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>" /></form></div>
                                                    <a onclick="Showcart('frmShowcart', '1')">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/buy_product.png" border="0" title="<?php echo $this->lang->line('buy_product_tip_detail'); ?>" style="cursor:pointer;" />
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
                        <td align="left" valign="top">
                            <table border="0" width="570" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" background="<?php echo base_url(); ?>templates/home/images/bg_detailtabpro.jpg" height="26">
                                       <div class="TabView" id="TabView">
                                           <div class="Tabs" style="width: 560px;">
                                               <a onclick="OpenTab(1);"><?php echo $this->lang->line('tab_detail_detail'); ?></a>
                                               <a onclick="OpenTab(2);"><?php echo $this->lang->line('tab_vote_detail'); ?></a>
                                               <a onclick="OpenTab(3);"><?php echo $this->lang->line('tab_comment_detail'); ?></a>
                                            </div>
                                        </div>
                                        <?php if((isset($isViewComment) && $isViewComment == true) || (isset($isReply) && $isReply == true) || (isset($successReplyProduct) && $successReplyProduct == true)){ ?>
                                        <script>
											function tabview_initialize_3(TabViewId) { tabview_aux(TabViewId,  3); }
											tabview_initialize_3('TabView');
										</script>
                                        <?php }else{ ?>
                                        <script type="text/javascript">tabview_initialize('TabView');</script>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                            <div id="DivContentDetail"><?php echo $this->bbcode->light($product->pro_detail); ?></div>
                            <div id="DivVoteDetail">
                                <table width="500" class="form_main" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="20" class="form_top"></td>
                                    </tr>
                                    <form name="frmVote" method="post">
                                    <tr>
                                        <td valign="top">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <table border="0" width="425" height="160" style="border:1px #B3D9FF solid;" align="center" cellpadding="0" cellspacing="3">
                                                            <tr height="25" style="color:#0AA2EB; font-size:11px; background:url(<?php echo base_url(); ?>templates/home/images/bg_titlevote.jpg);">
                                                                <th>&nbsp;</th>
                                                                <td align="center" colspan="4"><?php echo $this->lang->line('bad_vote_detail'); ?></td>
                                                                <td align="center" colspan="3"><?php echo $this->lang->line('normal_vote_detail'); ?></td>
                                                                <td align="center" colspan="3"><?php echo $this->lang->line('good_vote_detail'); ?></td>
                                                              </tr>
                                                              <tr style="color:#666; font-size:11px;">
                                                                <th style="color:#0066FF; text-align:left; padding-left:5px;"><?php echo $this->lang->line('info_vote_detail'); ?></th>
                                                                <td align="center" style="background:#CCCCCC;">1</td>
                                                                <td align="center" style="background:#CCCCCC;">2</td>
                                                                <td align="center" style="background:#CCCCCC;">3</td>
                                                                <td align="center" style="background:#CCCCCC;">4</td>
                                                                <td align="center" style="background:#C8D7E6;">5</td>
                                                                <td align="center" style="background:#C8D7E6;">6</td>
                                                                <td align="center" style="background:#C8D7E6;">7</td>
                                                                <td align="center" style="background:#A0DBFE;">8</td>
                                                                <td align="center" style="background:#A0DBFE;">9</td>
                                                                <td align="center" style="background:#A0DBFE;">10</td>
                                                              </tr>
                                                              <tr>
                                                                <th style="color:#666; text-align:left; padding-left:5px;">
                                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon_costvote.gif" border="0" />&nbsp;<?php echo $this->lang->line('cost_vote_detail'); ?>:
                                                                </th>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="cost" value="1"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="cost" value="2"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="cost" value="3"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="cost" value="4"></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="cost" value="5" checked></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="cost" value="6"></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="cost" value="7"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="cost" value="8"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="cost" value="9"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="cost" value="10"></td>
                                                              </tr>
                                                              <tr>
                                                                <th style="color:#666; text-align:left; padding-left:5px;">
                                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon_qualityvote.gif" border="0" />&nbsp;<?php echo $this->lang->line('quanlity_vote_detail'); ?>:
                                                                </th>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="quanlity" value="1"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="quanlity" value="2"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="quanlity" value="3"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="quanlity" value="4"></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="quanlity" value="5" checked></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="quanlity" value="6"></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="quanlity" value="7"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="quanlity" value="8"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="quanlity" value="9"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="quanlity" value="10"></td>
                                                              </tr>
                                                              <tr>
                                                                <th style="color:#666; text-align:left; padding-left:5px;">
                                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon_modelvote.gif" border="0" />&nbsp;<?php echo $this->lang->line('model_vote_detail'); ?>:
                                                                </th>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="model" value="1"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="model" value="2"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="model" value="3"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="model" value="4"></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="model" value="5" checked></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="model" value="6"></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="model" value="7"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="model" value="8"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="model" value="9"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="model" value="10"></td>
                                                              </tr>
                                                              <tr>
                                                                <th style="color:#666; text-align:left; padding-left:5px;">
                                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon_servicevote.gif" border="0" />&nbsp;<?php echo $this->lang->line('service_vote_detail'); ?>:
                                                                </th>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="service" value="1"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="service" value="2"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="service" value="3"></td>
                                                                <td style="background:#CCCCCC;"><input type="radio" name="service" value="4"></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="service" value="5" checked></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="service" value="6"></td>
                                                                <td style="background:#C8D7E6;"><input type="radio" name="service" value="7"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="service" value="8"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="service" value="9"></td>
                                                                <td style="background:#A0DBFE;"><input type="radio" name="service" value="10"></td>
                                                              </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30"></td>
                                                    <td height="30" valign="bottom" align="center">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td><input type="button" name="submit_vote" onclick="SubmitVote()" value="<?php echo $this->lang->line('button_vote_detail'); ?>" class="button_form" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    </form>
                                    <tr>
                                        <td height="25" class="form_bottom"></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="DivReplyDetail">
                                <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <?php foreach($comment as $commentArray){ ?>
                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td height="50" class="header_reply">
                                            <div class="title_reply"><?php echo $commentArray->prc_title; ?> <span class="time_reply">(<?php echo $this->lang->line('time_comment_detail'); ?> <?php echo date('H\h:i', $commentArray->prc_date); ?> <?php echo $this->lang->line('date_comment_detail'); ?> <?php echo date('d-m-Y', $commentArray->prc_date); ?>)</span></div>
                                            <div class="author_reply"><font color="#999999"><?php echo $this->lang->line('poster_comment_detail'); ?>:</font> <?php echo $commentArray->use_fullname; ?> <span class="email_reply"><a class="menu_1" href="mailto:<?php echo $commentArray->use_email; ?>">(<?php echo $commentArray->use_email; ?>)</a></span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content_reply"><?php echo nl2br($commentArray->prc_comment); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td id="show_page" style="padding-right:1px;"><?php echo $cLinkPage; ?></td>
                                    </tr>
                                </table>
                                <table width="500" class="form_main" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="20" class="form_top"></td>
                                    </tr>
                                    <form name="frmReply" method="post">
                                    <tr>
                                        <td valign="top">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('title_comment_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="title_reply" id="title_reply" value="<?php if(isset($title_reply)){echo $title_reply;} ?>" maxlength="40" class="input_form" onfocus="ChangeStyle('title_reply',1);" onblur="ChangeStyle('title_reply',2);" /><?php echo form_error('title_reply'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('content_comment_detail'); ?>:</td>
                                                    <td align="left"><textarea name="content_reply" id="content_reply" cols="50" rows="7" class="textarea_form" onfocus="ChangeStyle('content_reply',1);" onblur="ChangeStyle('content_reply',2);"><?php if(isset($content_reply)){echo $content_reply;} ?></textarea><?php echo form_error('content_reply'); ?></td>
                                                </tr>
                                                <?php if(isset($imageCaptchaReplyProduct)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo base_url().$imageCaptchaReplyProduct; ?>" width="151" height="30" /><br />
                                                        <input type="text" name="captcha_reply" id="captcha_reply" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_reply',1);" onblur="ChangeStyle('captcha_reply',2);" />
                                                        <?php echo form_error('captcha_reply'); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td height="30"></td>
                                                    <td height="30" valign="bottom" align="center">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td><input type="button" onclick="CheckInput_Reply('<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>');" name="submit_reply" value="<?php echo $this->lang->line('button_comment_comment_detail'); ?>" class="button_form" /></td>
                                                                <td width="15"></td>
                                                                <td><input type="reset" name="reset_reply" value="<?php echo $this->lang->line('button_reset_comment_detail'); ?>" class="button_form" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    </form>
                                    <tr>
                                        <td height="25" class="form_bottom"></td>
                                    </tr>
                                </table>
                            </div>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%" id="send_link">
                                        <a class="menu" onclick="OpenTab(4);" style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_link.png" border="0" /> <?php echo $this->lang->line('send_friend_detail'); ?>
                                        </a>
                                    </td>
                                    <td align="right" id="send_fail">
                                        <a class="menu" onclick="OpenTab(5);" style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_fail.png" border="0" /> <?php echo $this->lang->line('send_bad_detail'); ?>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <div id="DivSendLinkDetail">
                                <table width="500" class="sendlink_main" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="55" class="sendlink_top"></td>
                                    </tr>
                                    <form name="frmSendLink" method="post">
                                    <tr>
                                        <td valign="top">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('email_sender_send_friend_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="sender_sendlink" id="sender_sendlink" value="<?php if(isset($sender_sendlink)){echo $sender_sendlink;} ?>" maxlength="50" class="input_form" onfocus="ChangeStyle('sender_sendlink',1);" onblur="ChangeStyle('sender_sendlink',2);" /><?php echo form_error('sender_sendlink'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('email_receiver_send_friend_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="receiver_sendlink" id="receiver_sendlink" value="<?php if(isset($receiver_sendlink)){echo $receiver_sendlink;} ?>" maxlength="50" class="input_form" onfocus="ChangeStyle('receiver_sendlink',1);" onblur="ChangeStyle('receiver_sendlink',2);" /><?php echo form_error('receiver_sendlink'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('title_send_friend_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="title_sendlink" id="title_sendlink" value="<?php if(isset($title_sendlink)){echo $title_sendlink;} ?>" maxlength="80" class="input_form" onfocus="ChangeStyle('title_sendlink',1);" onblur="ChangeStyle('title_sendlink',2);" /><?php echo form_error('title_sendlink'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('message_send_friend_detail'); ?>:</td>
                                                    <td align="left"><textarea name="content_sendlink" id="content_sendlink" cols="50" rows="7" class="textarea_form" onfocus="ChangeStyle('content_sendlink',1);" onblur="ChangeStyle('content_sendlink',2);"><?php if(isset($content_sendlink)){echo $content_sendlink;} ?></textarea><?php echo form_error('content_sendlink'); ?></td>
                                                </tr>
                                                <?php if(isset($imageCaptchaSendFriendProduct)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo base_url().$imageCaptchaSendFriendProduct; ?>" width="151" height="30" /><br />
                                                        <input type="text" name="captcha_sendlink" id="captcha_sendlink" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_sendlink',1);" onblur="ChangeStyle('captcha_sendlink',2);" />
                                                        <?php echo form_error('captcha_sendlink'); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td height="30"></td>
                                                    <td height="30" valign="bottom" align="center">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td><input type="button" onclick="CheckInput_SendLink();" name="submit_sendlink" value="<?php echo $this->lang->line('button_send_send_friend_detail'); ?>" class="button_form" /></td>
                                                                <td width="15"></td>
                                                                <td><input type="reset" name="reset_sendlink" value="<?php echo $this->lang->line('button_reset_send_friend_detail'); ?>" class="button_form" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    </form>
                                    <tr>
                                        <td height="32" class="sendlink_bottom"></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="DivSendFailDetail">
                                <table width="500" class="sendfail_main" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="55" class="sendfail_top"></td>
                                    </tr>
                                    <form name="frmSendFail" method="post">
                                    <tr>
                                        <td valign="top">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('email_sender_send_bad_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="sender_sendfail" id="sender_sendfail" value="<?php if(isset($sender_sendfail)){echo $sender_sendfail;} ?>" maxlength="50" class="input_form" onfocus="ChangeStyle('sender_sendfail',1);" onblur="ChangeStyle('sender_sendfail',2);" /><?php echo form_error('sender_sendfail'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('title_send_bad_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="title_sendfail" id="title_sendfail" value="<?php if(isset($title_sendfail)){echo $title_sendfail;} ?>" maxlength="80" class="input_form" onfocus="ChangeStyle('title_sendfail',1);" onblur="ChangeStyle('title_sendfail',2);" /><?php echo form_error('title_sendfail'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('content_send_bad_detail'); ?>:</td>
                                                    <td align="left"><textarea name="content_sendfail" id="content_sendfail" cols="50" rows="7" class="textarea_form" onfocus="ChangeStyle('content_sendfail',1);" onblur="ChangeStyle('content_sendfail',2);"><?php if(isset($content_sendfail)){echo $content_sendfail;} ?></textarea><?php echo form_error('content_sendfail'); ?></td>
                                                </tr>
                                                <?php if(isset($imageCaptchaSendFailProduct)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo base_url().$imageCaptchaSendFailProduct; ?>" width="151" height="30" /><br />
                                                        <input type="text" name="captcha_sendfail" id="captcha_sendfail" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_sendfail',1);" onblur="ChangeStyle('captcha_sendfail',2);" />
                                                        <?php echo form_error('captcha_sendfail'); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td height="30"></td>
                                                    <td height="30" valign="bottom" align="center">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td><input type="button" onclick="CheckInput_SendFail('<?php if(isset($isSendedOneFail) && $isSendedOneFail == true){echo $this->lang->line('is_sended_one_message_detail');}else{echo 1;} ?>');" name="submit_sendfail" value="<?php echo $this->lang->line('button_send_send_bad_detail'); ?>" class="button_form" /></td>
                                                                <td width="15"></td>
                                                                <td><input type="reset" name="reset_sendfail" value="<?php echo $this->lang->line('button_reset_send_bad_detail'); ?>" class="button_form" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    </form>
                                    <tr>
                                        <td height="32" class="sendfail_bottom"></td>
                                    </tr>
                                </table>
                            </div>
                            <?php if(isset($isViewComment) && $isViewComment == true){ ?>
                            <script type="text/javascript">OpenTab(3);</script>
                            <?php }else{ ?>
                            <script type="text/javascript">OpenTab(1);</script>
                            <?php } ?>
                            <?php if((isset($isReply) && $isReply == true) || (isset($successReplyProduct) && $successReplyProduct == true)){ ?>
                            <script>OpenTab(3);</script>
                            <?php }elseif(isset($isSendFriend) && $isSendFriend == true){ ?>
                            <script>OpenTab(4);</script>
                            <?php }elseif(isset($isSendFail) && $isSendFail == true){ ?>
                            <script>OpenTab(5);</script>
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
        <?php if(count($userProduct) > 0){ ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_relate_user_product_detail'); ?></div>
            </td>
        </tr>
        <form name="frmListUserPro" method="post">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
                    <tr height="29">
                        <td width="28" align="center" class="title_boxpro_0"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmListUserPro',0)" /></td>
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
                    <?php foreach($userProduct as $userProductArray){ ?>
                    <tr>
                        <td width="28" align="center" class="line_boxpro_0"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $userProductArray->pro_id; ?>" onclick="DoCheckOne('frmListUserPro')" /></td>
                        <td width="110" class="line_boxpro_1">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $userProductArray->pro_category; ?>/detail/<?php echo $userProductArray->pro_id; ?>">
                                <img src="<?php echo base_url(); ?>media/images/product/<?php echo $userProductArray->pro_dir; ?>/<?php echo show_thumbnail($userProductArray->pro_dir, $userProductArray->pro_image); ?>" class="image_boxpro" onmouseover="ddrivetip_image('<img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $userProductArray->pro_dir; ?>/<?php echo show_image($userProductArray->pro_image); ?>\' border=0>',1,'#F0F8FF');" onmouseout="hideddrivetip();" />
                            </a>
                        </td>
                        <td valign="top" class="line_boxpro_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $userProductArray->pro_category; ?>/detail/<?php echo $userProductArray->pro_id; ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo $userProductArray->pro_name; ?>
                            </a>
                            <div class="descr_boxpro">
                                <?php echo $userProductArray->pro_descr; ?>
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" class="saleoff_boxpro">
                                        <?php if($userProductArray->pro_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff.gif" border="0" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxpro"><?php echo $this->lang->line('view_category'); ?>:&nbsp;<?php echo $userProductArray->pro_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('comment_category'); ?>:&nbsp;<?php echo $userProductArray->pro_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="105" class="line_boxpro_1">
                            <?php if((int)$userProductArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                            <?php }else{ ?>
                            <span id="DivCostUser_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $userProductArray->pro_currency; ?>
                            <div class="usd_boxpro">
                                <?php if(strtoupper($userProductArray->pro_currency) == 'VND'){ ?>
								<span id="DivCostExchangeUser_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>
								<script>FormatCost('<?php echo round($userProductArray->pro_cost/Setting::settingExchange); ?>', 'DivCostExchangeUser_<?php echo $idDiv; ?>');</script>
								<?php }else{ ?>
								<span id="DivCostExchangeUser_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
								<script>FormatCost('<?php echo round($userProductArray->pro_cost*Setting::settingExchange); ?>', 'DivCostExchangeUser_<?php echo $idDiv; ?>');</script>
								<?php } ?>
							</div>
                            <script>FormatCost('<?php echo $userProductArray->pro_cost; ?>', 'DivCostUser_<?php echo $idDiv; ?>');</script>
                            <?php if($userProductArray->pro_hondle == 1){ ?>
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
                        <td width="37%" id="favorite_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite.gif" onclick="Favorite('frmListUserPro', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxpro">
                            <select name="select_sort" id="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_detail'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_detail'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_detail'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_detail'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_detail'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begin_desc_detail'); ?></option>
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
        <?php } ?>
        <?php if(count($categoryProduct) > 0){ ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_relate_category_product_detail'); ?></div>
            </td>
        </tr>
        <form name="frmListCategoryPro" method="post">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
                    <tr height="29">
                        <td width="28" align="center" class="title_boxpro_0"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmListCategoryPro',0)" /></td>
                        <td width="110" class="title_boxpro_1"><?php echo $this->lang->line('image_list'); ?></td>
                        <td class="title_boxpro_2">
                            <?php echo $this->lang->line('product_list'); ?>
                        </td>
                        <td width="105" class="title_boxpro_1">
                            <?php echo $this->lang->line('cost_list'); ?>
                        </td>
                    </tr>
                    <?php $idDiv = 1; ?>
                    <?php foreach($categoryProduct as $categoryProductArray){ ?>
                    <tr>
                        <td width="28" align="center" class="line_boxpro_0"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $categoryProductArray->pro_id; ?>" onclick="DoCheckOne('frmListCategoryPro')" /></td>
                        <td width="110" class="line_boxpro_1">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $categoryProductArray->pro_category; ?>/detail/<?php echo $categoryProductArray->pro_id; ?>">
                                <img src="<?php echo base_url(); ?>media/images/product/<?php echo $categoryProductArray->pro_dir; ?>/<?php echo show_thumbnail($categoryProductArray->pro_dir, $categoryProductArray->pro_image); ?>" class="image_boxpro" onmouseover="ddrivetip_image('<img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $categoryProductArray->pro_dir; ?>/<?php echo show_image($categoryProductArray->pro_image); ?>\' border=0>',1,'#F0F8FF');" onmouseout="hideddrivetip();" />
                            </a>
                        </td>
                        <td valign="top" class="line_boxpro_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $categoryProductArray->pro_category; ?>/detail/<?php echo $categoryProductArray->pro_id; ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo $categoryProductArray->pro_name; ?>
                            </a>
                            <div class="descr_boxpro">
                                <?php echo $categoryProductArray->pro_descr; ?>
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" class="saleoff_boxpro">
                                        <?php if($categoryProductArray->pro_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff.gif" border="0" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxpro"><?php echo $this->lang->line('view_category'); ?>:&nbsp;<?php echo $categoryProductArray->pro_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('comment_category'); ?>:&nbsp;<?php echo $categoryProductArray->pro_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="105" class="line_boxpro_1">
                            <?php if((int)$categoryProductArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                            <?php }else{ ?>
                            <span id="DivCostCategory_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $categoryProductArray->pro_currency; ?>
                            <div class="usd_boxpro">
                                <?php if(strtoupper($categoryProductArray->pro_currency) == 'VND'){ ?>
								<span id="DivCostExchangeCategory_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>
								<script>FormatCost('<?php echo round($categoryProductArray->pro_cost/Setting::settingExchange); ?>', 'DivCostExchangeCategory_<?php echo $idDiv; ?>');</script>
								<?php }else{ ?>
								<span id="DivCostExchangeCategory_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
								<script>FormatCost('<?php echo round($categoryProductArray->pro_cost*Setting::settingExchange); ?>', 'DivCostExchangeCategory_<?php echo $idDiv; ?>');</script>
								<?php } ?>
							</div>
                            <script>FormatCost('<?php echo $categoryProductArray->pro_cost; ?>', 'DivCostCategory_<?php echo $idDiv; ?>');</script>
                            <?php if($categoryProductArray->pro_hondle == 1){ ?>
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
                        <td width="37%" id="favorite_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite.gif" onclick="Favorite('frmListCategoryPro', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxpro"></td>
                        <td width="37%" id="show_page"></td>
                    </tr>
                </table>
             </td>
        </tr>
        </form>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>
        <?php } ?>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_detail'); ?>');</script>
<?php }elseif(isset($successVote) && $successVote == true){ ?>
<script>alert('<?php echo $this->lang->line('success_vote_detail'); ?>');</script>
<?php }elseif(isset($successReplyProduct) && $successReplyProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_reply_detail'); ?>');</script>
<?php }elseif(isset($successSendFriendProduct) && $successSendFriendProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_send_friend_detail'); ?>');</script>
<?php }elseif(isset($successSendFailProduct) && $successSendFailProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_send_fail_detail'); ?>');</script>
<?php } ?>