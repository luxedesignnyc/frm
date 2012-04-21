<?php if(isset($siteGlobal)){ ?>
	</tr>
    <!--END Main-->
    <!--BEGIN: Footer-->
    <tr id="DivGlobalSiteBottom" style="display:none;">
    	<td colspan="3" style="padding-top:15px; padding-bottom:5px;" align="center" bgcolor="#f8e269">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="201" id="counter"><?php echo $this->lang->line('access_footer_detail_global'); ?>: <?php echo $siteGlobal->sho_view; ?></td>
                    <td id="footer" align="center">
                        <?php echo $this->lang->line('copyright_footer_detail_global'); ?><br />
                        <b><?php echo $siteGlobal->sho_name; ?></b><br />
                        <b><?php echo $this->lang->line('address_footer_detail_global'); ?>:</b> <?php echo $siteGlobal->sho_address; ?><br />
                        <b><?php echo $this->lang->line('phone_footer_detail_global'); ?>:</b> <?php echo $siteGlobal->sho_phone; ?><?php if(trim($siteGlobal->sho_phone) != '' && trim($siteGlobal->sho_mobile) != ''){echo ' - ';} ?><?php echo $siteGlobal->sho_mobile; ?> <b>&bull;</b> <b><?php echo $this->lang->line('email_footer_detail_global'); ?>:</b> <a class="menu_1" href="mailto:<?php echo $siteGlobal->sho_email; ?>"><?php echo $siteGlobal->sho_email; ?></a>
                        <?php if(trim($siteGlobal->sho_website) != ''){ ?><br /><b><?php echo $this->lang->line('website_footer_detail_global'); ?>:</b> <a class="menu" href="<?php echo prep_url($siteGlobal->sho_website); ?>" title="<?php echo prep_url($siteGlobal->sho_website); ?>" target="_blank"><?php echo prep_url($siteGlobal->sho_website); ?></a><?php } ?>
                    </td>
                    <td width="201" align="center">
                    	<script type="text/javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/bookmart.js"></script>
                    	
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!--END Footer-->
</table>
<script>WaitingLoadPage();</script>
</body>
</html>
<?php } ?>