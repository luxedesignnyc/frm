<script language="javascript" src="<?php echo base_url(); ?>templates/editor/js/bbcode.js"></script>
<table style="border:1px solid #CCC;" width="365" height="230" cellpadding="0" cellspacing="0"><tbody><tr><td height="23" colspan="2" style="background:url(<?php echo base_url(); ?>templates/editor/images/bg_tab.gif) repeat-x; padding-left:2px;"><img onclick="addArticleCode('[b]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/bold.gif" style="CURSOR: pointer;" border="0" title="In đậm"/><img onclick="addArticleCode('[i]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/italic.gif" style="CURSOR: pointer;" border="0" title="In nghiêng" /><img onclick="addArticleCode('[u]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/underline.gif" style="CURSOR: pointer;" border="0" title="Gạch dưới" /><img onclick="addArticleCode('[left]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/left.gif" style="CURSOR: pointer;" border="0" title="Canh trái" /><img onclick="addArticleCode('[center]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/center.gif" style="CURSOR: pointer;" border="0" title="Canh giữa" /><img onclick="addArticleCode('[right]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/right.gif" style="CURSOR: pointer;" border="0" title="Canh phải" /><img onclick="addArticleCode('[justify]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/justify.gif" style="CURSOR: pointer;" border="0" title="Canh đều" /><img onclick="addArticleCode('[blockquote]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/blockquote.gif" style="CURSOR: pointer;" border="0" title="Lùi vào" /><img onclick="addArticleCode('[ul]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/ul.gif" style="CURSOR: pointer;" border="0" /><img onclick="addLink('txtContent')" src="<?php echo base_url(); ?>templates/editor/images/link.gif" title="Chèn link" style="CURSOR: pointer;" border="0" /><img onclick="addEmoticons('[hr]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/hr.gif" style="CURSOR: pointer;" border="0" title="Đường ngang" /><img onclick="addEmoticons('[sup]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/subscript.gif" style="CURSOR: pointer;" border="0" /><img onclick="addArticleCode('[green]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/green.gif" style="CURSOR: pointer;" border="0" title="Màu xanh lá" /><img onclick="addArticleCode('[blue]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/blue.gif" style="CURSOR: pointer;" border="0" title="Màu xanh" /><img onclick="addArticleCode('[red]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/red.gif" style="CURSOR: pointer;" border="0" title="Màu đỏ" /></td></tr><tr><td height="23" style="background:url(<?php echo base_url(); ?>templates/editor/images/bg_tab.gif) repeat-x; padding-top:1px; padding-left:5px;"><SELECT title="Font chữ" style="CURSOR: pointer; height:19px; font-size:11px;" onchange="addArticleCode(this.value,'txtContent')"><OPTION value="" selected>--[Font chữ]--</OPTION><OPTION title="Arial" value="[arial]">Arial</OPTION><OPTION title="Times New Roman" value="[time]">Times New Roman</OPTION><OPTION title="Tahoma" value="[tahoma]">Tahoma</OPTION></SELECT><SELECT title="Cỡ chữ" style="CURSOR: pointer; pointer; height:19px; font-size:11px;" onchange="addArticleCode(this.value,'txtContent')"><OPTION value="" selected>--[Cỡ chữ]--</OPTION><OPTION title="xx-small" value="[xx-small]">xx-small</OPTION><OPTION title="x-small" value="[x-small]">x-small</OPTION><OPTION title="small" value="[small]">small</OPTION><OPTION title="medium" value="[medium]">medium</OPTION><OPTION title="large" value="[large]">large</OPTION><OPTION title="x-large" value="[x-large]">x-large</OPTION><OPTION title="xx-large" value="[xx-large]">xx-large</OPTION></SELECT></td><td width="43%" style="background:url(<?php echo base_url(); ?>templates/editor/images/bg_tab.gif) repeat-x; padding-top:2px; padding-left:5px;"><img onclick="addEmoticons('[:)]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/yahoo_bigsmile.gif" style="CURSOR: pointer;" border="0" /><img onclick="addEmoticons('[:-)]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/yahoo_batting.gif" style="CURSOR: pointer;" border="0" /><img onclick="addEmoticons('[(:]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/yahoo_kiss.gif" style="CURSOR: pointer;" border="0" /><img onclick="addEmoticons('[(-:]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/yahoo_question.gif" style="CURSOR: pointer;" border="0" /><img onclick="addEmoticons('[(:)]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/yahoo_sad.gif" style="CURSOR: pointer;" border="0" /><img onclick="addEmoticons('[(-:)]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/yahoo_smiley.gif" style="CURSOR: pointer;" border="0" /><img onclick="addEmoticons('[(:-)]','txtContent')" src="<?php echo base_url(); ?>templates/editor/images/yahoo_wink.gif" style="CURSOR: pointer;" border="0" /></td></tr><tr><td colspan="2"><TEXTAREA class="txtContent" id="txtContent" name="txtContent" rows="11" cols="43" /><?php if(isset($txtContent)){echo $txtContent;} ?></TEXTAREA></td></tr></tbody></table>