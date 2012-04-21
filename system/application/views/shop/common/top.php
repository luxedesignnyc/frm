<?php if(isset($siteGlobal)){ ?>
<table border="0" cellpadding="0" cellspacing="0" width="594">
  <tr>
      <td><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/bg_form1.gif" width="355" height="22" alt="" border="0"></td>
      <td><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/bg_form2.gif" width="239" height="22" alt="" border="0"></td>
  </tr>
  <tr>
      <td height="40" width="355" class="box_search_top" align="center">
          <input type="text" name="KeywordSearch" id="KeywordSearch" maxlength="80" class="input_search_top" onfocus="ChangeStyle('KeywordSearch',1)" onblur="ChangeStyle('KeywordSearch',2)">
          <input type="button" onclick="Search('<?php echo base_url().$siteGlobal->sho_link; ?>')" class="button_search_top" align="absbottom">
      </td>
      <td width="239" height="40" class="box_showcart">
          <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
              <tr align="center">
                  <td><div class="total_showcart"><b><?php echo $this->lang->line('have_top_showcart_detail_global'); ?>: <?php if($this->session->userdata('sessionProductShowcart')){echo count(explode(',', trim($this->session->userdata('sessionProductShowcart'), ',')));}else{echo '0';} ?></b></div></td>
                  <td><img src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/b_showcart.gif" onclick="ActionLink('<?php echo base_url(); ?>showcart')" style="cursor:pointer;" width="79" height="20" alt="" border="0"></td>
              </tr>
          </table>
      </td>
  </tr>
</table>
<?php } ?>