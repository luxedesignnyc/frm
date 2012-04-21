<?php $this->load->view('shop/common/header'); ?>
<?php $this->load->view('shop/common/left'); ?>
<?php if(isset($siteGlobal)){ ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/jquery.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/ajax.js"></script>
<!--BEGIN: Center-->
<td width="602" valign="top" align="center">
<div id="DivContent">
    <?php $this->load->view('shop/common/top'); ?>
    <table width="594" class="table_module" style="margin-top:5px;" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td height="28" class="title_module"><?php echo $this->lang->line('title_interest_detail_defaults'); ?></td>
        </tr>
        <tr>
            <td class="main_module" valign="top" align="center" id="DivInterest"></td>
        </tr>
        <tr>
            <td height="10" class="bottom_module"></td>
        </tr>
    </table>
    <script>getProduct(1, 'DivInterest', 'DivInterestBox_', '<?php echo $this->hash->create($siteGlobal->sho_link, $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo $siteGlobal->sho_link; ?>', '<?php echo $siteGlobal->sho_style; ?>', '<?php echo base_url(); ?>');</script>
    <table width="594" class="table_module" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td height="28" class="title_module"><a class="menu_3" href="<?php echo base_url().$siteGlobal->sho_link; ?>/product"><?php echo $this->lang->line('title_new_detail_defaults'); ?> >></a></td>
        </tr>
        <tr>
            <td class="main_module" valign="top" align="center" id="DivNew"></td>
        </tr>
        <tr>
            <td height="10" class="bottom_module"></td>
        </tr>
    </table>
    <script>getProduct(2, 'DivNew', 'DivNewBox_', '<?php echo $this->hash->create($siteGlobal->sho_link, $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo $siteGlobal->sho_link; ?>', '<?php echo $siteGlobal->sho_style; ?>', '<?php echo base_url(); ?>');</script>
    <table id="TableSaleoff" width="594" class="table_module" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td height="28" class="title_module"><a class="menu_3" href="<?php echo base_url().$siteGlobal->sho_link; ?>/product/saleoff"><?php echo $this->lang->line('title_saleoff_detail_defaults'); ?> >></a></td>
        </tr>
        <tr>
            <td class="main_module" valign="top" align="center" id="DivSaleoff"></td>
        </tr>
        <tr>
            <td height="28" class="bottom_module"></td>
        </tr>
    </table>
    <script>getProduct(3, 'DivSaleoff', 'DivSaleoffBox_', '<?php echo $this->hash->create($siteGlobal->sho_link, $this->input->user_agent(), 'sha256md5'); ?>', '<?php echo $siteGlobal->sho_link; ?>', '<?php echo $siteGlobal->sho_style; ?>', '<?php echo base_url(); ?>');</script>
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