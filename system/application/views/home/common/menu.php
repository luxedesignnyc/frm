<?php switch($menuType){ ?>
<?php case 'product': ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_product_menu'); ?></td>
</tr>
<tr>
    <td background="<?php echo base_url(); ?>templates/home/images/bg_menu.jpg" >
        <table width="201" border="0" cellpadding="0" cellspacing="0">
            <?php foreach($menu as $menuArray){ ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/menu/<?php echo $menuArray->men_image; ?>" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>product/category/<?php echo $menuArray->men_category; ?>" class="<?php if($menuArray->men_category == $menuSelected){echo 'menu_selected';}else{echo 'menu';} ?>" title="<?php echo $menuArray->men_descr; ?>"><?php echo $menuArray->men_name; ?></a></div></td>
            </tr>
            <?php } ?>
        </table>
    </td>
</tr>
<?php break; ?>
<?php case 'ads': ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_ads_menu'); ?></td>
</tr>
<tr>
    <td background="<?php echo base_url(); ?>templates/home/images/bg_menu.jpg" >
        <table width="201" border="0" cellpadding="0" cellspacing="0">
            <?php foreach($menu as $menuArray){ ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/menu/<?php echo $menuArray->men_image; ?>" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>ads/category/<?php echo $menuArray->men_category; ?>" class="<?php if($menuArray->men_category == $menuSelected){echo 'menu_selected';}else{echo 'menu';} ?>" title="<?php echo $menuArray->men_descr; ?>"><?php echo $menuArray->men_name; ?></a></div></td>
            </tr>
            <?php } ?>
        </table>
    </td>
</tr>
<?php break; ?>
<?php case 'shop': ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_shop_menu'); ?></td>
</tr>
<tr>
    <td background="<?php echo base_url(); ?>templates/home/images/bg_menu.jpg" >
        <table width="201" border="0" cellpadding="0" cellspacing="0">
            <?php foreach($menu as $menuArray){ ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/menu/<?php echo $menuArray->men_image; ?>" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>shop/category/<?php echo $menuArray->men_category; ?>" class="<?php if($menuArray->men_category == $menuSelected){echo 'menu_selected';}else{echo 'menu';} ?>" title="<?php echo $menuArray->men_descr; ?>"><?php echo $menuArray->men_name; ?></a></div></td>
            </tr>
            <?php } ?>
        </table>
    </td>
</tr>
<?php break; ?>
<?php case 'job': ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_job_menu'); ?></td>
</tr>
<tr>
    <td background="<?php echo base_url(); ?>templates/home/images/bg_menu.jpg" >
        <table width="201" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_01.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>job" class="<?php if($menuSelected == 'job'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('job_job_menu'); ?></a></div></td>
            </tr>
            <?php if($menuFieldJob == true){ ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_02.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="#Field" onclick="OpenTabField()" class="menu"><?php echo $this->lang->line('field_job_job_menu'); ?></a></div></td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_03.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>job/post" class="<?php if($menuSelected == 'post_job'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('post_job_job_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_04.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>employ" class="<?php if($menuSelected == 'employ'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('employ_job_menu'); ?></a></div></td>
            </tr>
            <?php if($menuFieldEmploy == true){ ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_05.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="#Field" onclick="OpenTabField()" class="menu"><?php echo $this->lang->line('field_employ_job_menu'); ?></a></div></td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_06.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>employ/post" class="<?php if($menuSelected == 'post_employ'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('post_employ_job_menu'); ?></a></div></td>
            </tr>
        </table>
    </td>
</tr>
<?php break; ?>
<?php case 'account': ?>
<tr>
    <td class="tieude_trai"><?php echo $this->lang->line('title_account_menu'); ?></td>
</tr>
<tr>
    <td background="<?php echo base_url(); ?>templates/home/images/bg_menu.jpg" >
        <table width="201" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_01.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/edit" class="<?php if($menuSelected == 'edit'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('edit_account_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_02.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/changepassword" class="<?php if($menuSelected == 'changepassword'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('change_password_account_menu'); ?></a></div></td>
            </tr>
            <?php if((int)$this->session->userdata('sessionGroup') == 3){ ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_03.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/shop" class="<?php if($menuSelected == 'shop'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('edit_shop_account_menu'); ?></a></div></td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_04.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/notify" class="<?php if($menuSelected == 'notify'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('notify_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_05.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/contact" class="<?php if($menuSelected == 'contact'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('contact_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_06.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/contact/send" class="<?php if($menuSelected == 'send_contact'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('send_contact_account_menu'); ?></a></div></td>
            </tr>
            <?php if((int)$this->session->userdata('sessionGroup') != 1){ ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_07.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/product" class="<?php if($menuSelected == 'product'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('product_account_menu'); ?></a></div></td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_08.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/product/favorite" class="<?php if($menuSelected == 'favorite_product'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('favorite_product_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_09.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/ads" class="<?php if($menuSelected == 'ads'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('ads_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_10.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/ads/favorite" class="<?php if($menuSelected == 'favorite_ads'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('favorite_ads_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_11.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/job" class="<?php if($menuSelected == 'job'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('job_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_12.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/job/favorite" class="<?php if($menuSelected == 'favorite_job'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('favorite_job_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_13.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/employ" class="<?php if($menuSelected == 'employ'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('employ_account_menu'); ?></a></div></td>
            </tr>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_14.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/employ/favorite" class="<?php if($menuSelected == 'favorite_employ'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('favorite_employ_account_menu'); ?></a></div></td>
            </tr>
            <?php if((int)$this->session->userdata('sessionGroup') != 1){ ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_15.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/customer" class="<?php if($menuSelected == 'customer'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('customer_account_menu'); ?></a></div></td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30" height="30"><div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_account_16.gif" border="0" /></div></td>
                <td width="171" height="30"><div class="le_menu"><a href="<?php echo base_url(); ?>account/showcart" class="<?php if($menuSelected == 'showcart'){echo 'menu_selected';}else{echo 'menu';} ?>"><?php echo $this->lang->line('showcart_account_menu'); ?></a></div></td>
            </tr>
        </table>
    </td>
</tr>
<?php break; ?>
<?php } ?>