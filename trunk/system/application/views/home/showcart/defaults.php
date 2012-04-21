<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td width="602" valign="top">
    <table width="602" border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/advertise/top'); ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_defaults'); ?></div>
            </td>
        </tr>
        <?php if(isset($productShowcart) && count($productShowcart) > 0){ ?>
        <form name="frmShowCart" method="post">
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_showcart.jpg" height="29">
                <table align="center" width="580" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="25" class="title_showcart_0">#</td>
                        <td width="30" class="title_showcart_1">
                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(document.frmShowCart.checkall.checked,'frmShowCart',0)">
                        </td>
                        <td class="title_showcart_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="130" class="title_showcart_3">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc')" border="0" style="cursor:pointer;" />
                        </td>
                        <td width="60" class="title_showcart_2">
                            <?php echo $this->lang->line('quantity_list'); ?>
                        </td>
                        <td width="145" class="title_showcart_4">
                            <?php echo $this->lang->line('equa_currency_list'); ?>
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" >
                <table align="center" width="580" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($productShowcart as $productShowcartArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowShowcart_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowShowcart_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowShowcart_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="25" height="32" class="line_showcart_0" ><?php echo $idDiv; ?></td>
                        <td width="30" height="32" class="line_showcart_1">
                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $productShowcartArray->pro_id; ?>" onclick="DoCheckOne('frmShowCart')">
                        </td>
                        <td height="32" class="line_showcart_2" style="padding-left:5px; padding-right:5px; font-weight:bold;">
                            <a class="menu_1" href="<?php echo base_url(); ?>product/category/<?php echo $productShowcartArray->pro_category; ?>/detail/<?php echo $productShowcartArray->pro_id; ?>" onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $productShowcartArray->pro_dir; ?>/<?php echo show_thumbnail($productShowcartArray->pro_dir, $productShowcartArray->pro_image); ?>\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'><?php echo $productShowcartArray->pro_descr; ?></td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();">
                                <?php echo sub($productShowcartArray->pro_name, 30); ?>
                            </a>
                        </td>
                        <td width="126" height="32" class="line_showcart_3">
                            <?php if(strtoupper($productShowcartArray->pro_currency) == 'VND'){ ?>
                            <input type="hidden" name="CostVNDShowCart<?php echo $idDiv; ?>" id="CostVNDShowCart<?php echo $idDiv; ?>" value="<?php echo $productShowcartArray->pro_cost; ?>" />
                            <span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $productShowcartArray->pro_currency; ?>
                            <script>FormatCost('<?php echo $productShowcartArray->pro_cost; ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                            <div id="CostUSDShowCart<?php echo $idDiv; ?>" class="cost_usdshowcart"><span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?></div>
                          	<script>FormatCost('<?php echo round((int)$productShowcartArray->pro_cost/Setting::settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
                            <?php }else{ ?>
                            <input type="hidden" name="CostVNDShowCart<?php echo $idDiv; ?>" id="CostVNDShowCart<?php echo $idDiv; ?>" value="<?php echo round((int)$productShowcartArray->pro_cost*Setting::settingExchange); ?>" />
                            <span id="DivCost_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
                            <script>FormatCost('<?php echo round((int)$productShowcartArray->pro_cost*Setting::settingExchange); ?>', 'DivCost_<?php echo $idDiv; ?>');</script>
                            <div id="CostUSDShowCart<?php echo $idDiv; ?>" class="cost_usdshowcart"><span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $productShowcartArray->pro_currency; ?></div>
                          	<script>FormatCost('<?php echo $productShowcartArray->pro_cost; ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>
                            <?php } ?>
                        </td>
                        <td width="60" height="32" align="center" valign="middle" class="line_showcart_2">
                            <input type="text" name="QuantityShowcart[]" id="Quantity<?php echo $idDiv; ?>" value="1" maxlength="4" class="input_showcart" onkeyup="BlockChar(this,'NotNumbers'); SumCost('CostVNDShowCart<?php echo $idDiv; ?>','Quantity<?php echo $idDiv; ?>','SumCostVNDShowCart<?php echo $idDiv; ?>','SumCostUSDShowCart<?php echo $idDiv; ?>',<?php echo Setting::settingExchange; ?>); TotalCost('CostVNDShowCart','Quantity','TotalVNDShowCart','TotalUSDShowCart',<?php echo count($productShowcart); ?>,<?php echo Setting::settingExchange; ?>);" />
                            <input type="hidden" name="IdProductShowcart[]" value="<?php echo $productShowcartArray->pro_id; ?>" />
                        </td>
                        <td width="141" height="32" class="line_showcart_4">
                        	<span id="SumCostVNDShowCart<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>
                          	<div id="SumCostUSDShowCart<?php echo $idDiv; ?>" class="cost_usdshowcart"></div>
                            <script>SumCost('CostVNDShowCart<?php echo $idDiv; ?>','Quantity<?php echo $idDiv; ?>','SumCostVNDShowCart<?php echo $idDiv; ?>','SumCostUSDShowCart<?php echo $idDiv; ?>',<?php echo Setting::settingExchange; ?>);</script>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $backCategory = $productShowcartArray->pro_category; ?>
                    <?php } ?>
                </table>
                <script>ResetQuantity('Quantity',2);</script>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="32%" id="delete_showcart"><img src="<?php echo base_url(); ?>templates/home/images/icon_deleteshowcart.gif" onclick="ActionDeleteShowcart()" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="submit_showcart">
                            <input type="button" name="submit_showcart" onclick="ActionEqual('<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" value="<?php echo $this->lang->line('button_cacul_defaults'); ?>" class="button_form" />
                        </td>
                        <td width="10" id="submit_showcart"></td>
                        <td align="center" id="submit_showcart">
                            <input type="button" name="conti_showcart" onclick="ActionLink('<?php echo base_url(); ?><?php if(isset($backCategory) && (int)$backCategory > 0){echo 'product/category/'.$backCategory;} ?>')" value="<?php echo $this->lang->line('button_next_buy_defaults'); ?>" class="button_form" />
                        </td>
                        <td width="32%" align="right" valign="bottom" id="total_showcart">
                            <?php echo $this->lang->line('total_cost_showcart_defaults'); ?>:&nbsp;&nbsp;
                            <span id="TotalVNDShowCart"></span><br />
                            <span id="TotalUSDShowCart"></span>
                            <script>TotalCost('CostVNDShowCart','Quantity','TotalVNDShowCart','TotalUSDShowCart',<?php echo count($productShowcart); ?>,<?php echo Setting::settingExchange; ?>);</script>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        </form>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" background="<?php echo base_url(); ?>templates/home/images/bg_mainkhung.jpg" ><?php echo $this->lang->line('none_record_showcart_defaults'); ?></td>
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
<?php if(isset($fullProductShowcart) && $fullProductShowcart == true){ ?>
<script>alert('<?php echo $this->lang->line('full_product_showcart_defaults'); ?>');</script>
<?php } ?>