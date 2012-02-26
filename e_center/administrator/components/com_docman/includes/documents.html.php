<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: documents.html.php 772 2009-01-08 15:55:10Z mathias $
 * @package DOCman_1.4
 * @copyright (C) 2003-2009 Joomlatools
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

if (defined('_DOCMAN_HTML_DOCUMENTS')) {
    return;
} else {
    define('_DOCMAN_HTML_DOCUMENTS', 1);
}

class HTML_DMDocuments
{
    function showDocuments($rows, $lists, $search, $pageNav, $number_pending, $number_unpublished, $view_type = 1)
    {
        global $database, $my, $_DOCMAN;
        global $mosConfig_live_site, $mosConfig_absolute_path;
        ?>

        <form action="index2.php" method="post" name="adminForm">

        <?php dmHTML::adminHeading( _DML_DOCS, 'documents' )?>

        <div class="dm_filters">
            <?php echo _DML_FILTER;?>
            <input class="text_area" type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
            <?php echo $lists['catid'];?>

            <span class="small">
                <?php if ($number_pending > 0) {
                    echo " [$number_pending " . _DML_DOCS_NOT_APPROVED . "] ";
                }
                if ($number_unpublished > 0) {
                    echo " [$number_unpublished " . _DML_DOCS_NOT_PUBLISHED . "] ";
                }
                if ($number_unpublished < 1 && $number_pending < 1) {
                    echo " [" . _DML_NO_PENDING_DOCS . "] ";
                }
                ?>
            </span>
        </div>

        <table class="adminlist">
          <thead>
          <tr>
            <th width="2%" align="left" >
            <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows);?>);" />
            </th>
            <th width="15%" align="left">
            <a href="index2.php?option=com_docman&section=documents&sort=name"><?php echo _DML_TENVB;?></a>
            </th>
            <th width="15%" align="left" >
            <a href="index2.php?option=com_docman&section=documents&sort=filename"><?php echo _DML_FILE;?></a>
            </th>
            <th width="15%" align="left">
            <a href="index2.php?option=com_docman&section=documents&sort=catsubcat"><?php echo _DML_CQBH;?></a>
            </th>
            <th width="10%" align="center">
            <a href="index2.php?option=com_docman&section=documents&sort=date"><?php echo _DML_NGAYKY;?></a>
            </th>
            <th width="10%" align="center">
            <a href="index2.php?option=com_docman&section=documents&sort=date"><?php echo _DML_NGUOIKY;?></a>
            </th>
            <th width="10%" align="center">
            <a href="index2.php?option=com_docman&section=documents&sort=date"><?php echo _DML_NGAYHIEULUC;?></a>
            </th>	
            <th width="10%">
            <?php echo _DML_OWNER;?>
            </th>
            <th width="5%">
            <?php echo _DML_PUBLISHED;?>
            </th>
            <th width="5%">
            <?php echo _DML_APPROVED;?>
            </th>
            <th width="5%">
            <?php echo _DML_SIZE;?>
            </th>
            <th width="5%">
            <?php echo _DML_HITS;?>
            </th>
            <th width="5%" nowrap="nowrap">
            <?php echo _DML_CHECKED_OUT;?>
            </th>
          </tr>
          </thead>

          <tfoot><tr><td colspan="13"><?php echo $pageNav->getListFooter();?></td></tr></tfoot>

          <tbody>
          <?php
        $k = 0;
        for ($i = 0, $n = count($rows);$i < $n;$i++) {
            $row = &$rows[$i];
            $task = $row->published ? 'unpublish' : 'publish';
            $img = $row->published ? 'publish_g.png' : 'publish_x.png';
            $alt = $row->published ? _DML_PUBLISHED : _DML_UNPUBLISH ;

            $file = new DOCMAN_File($row->dmfilename, $_DOCMAN->getCfg('dmpath'));

            ?><tr class="row<?php echo $k;?>">
                <td width="20">
				<?php echo mosHTML::idBox($i, $row->id, ($row->checked_out && $row->checked_out != $my->id));?>
				</td>
				<td width="15%">
			<?php
            if ($row->checked_out && ($row->checked_out != $my->id)) {
            ?>
					<?php echo $row->dmname;?>
					&nbsp;[ <i><?php echo _DML_CHECKED_OUT;?></i> ]
			<?php
            } else {
            ?>
	
					<a href="#edit" onclick="return listItemTask('cb<?php echo $i;?>','edit')">
					<?php echo $row->dmname;?>
					</a>
					<?php
            }
            ?>
				</td>
                <td>
                <?php if ($file->exists()) {?>
                    <a href="index2.php?option=com_docman&section=documents&task=download&bid=<?php echo $row->id;?>" target="_blank">
                    <?php echo DOCMAN_Utils::urlSnippet($row->dmfilename);?></a>
               	<?php
            } else {
                echo _DML_FILE_MISSING;
            }
            ?>
            	</td>
            	<td width="15%"><?php echo $row->category ?></td>
               	<td width="10%" align="center"><?php echo mosFormatDate($row->dmdate_published); ?></td>
               	<td width="10%" align="center"><?php echo $row->nguoi_ky; ?></td>
               	<td width="10%" align="center"><?php echo mosFormatDate($row->dmdate_published); ?></td>
               	<td align="center"><?php echo DOCMAN_Utils::getUserName($row->dmowner); ?></td>
                <td width="10%" align="center">
					<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
					<img src="images/<?php echo $img;?>" border="0" alt="<?php echo $alt;?>" />
					</a>
				</td>
			<?php
            if (!$row->approved) {
                ?>
	            	<td width="5%" align="center"><a href="#approve" onClick="return listItemTask('cb<?php echo $i;?>','approve')"><img src="images/publish_x.png" border=0 alt="approve" /></a></td>
	            <?php
            } else {
                ?>
	            	<td width="5%" align="center"><img src="images/tick.png" /></td>
	            <?php
            }
            ?>
	            <td width="5%" align="center">
	       	<?php
            if ($file->exists()) {
                echo $file->getSize();
            }
            ?>
            </td>
            <td width="5%" align="center"><?php echo $row->dmcounter;?></td>
			<?php
            if ($row->checked_out) {
                ?>
                	<td width="5%" align="center"><?php echo $row->editor;?></td>
            	<?php
            } else {
                ?>
                <td width="5%" align="center">---</td>
                <?php
            }

            ?></tr><?php
            $k = 1 - $k;
        }
        ?>
        </tbody>

      </table>


      <input type="hidden" name="option" value="com_docman" />
      <input type="hidden" name="section" value="documents" />
      <input type="hidden" name="task" value="" />
      <input type="hidden" name="boxchecked" value="0" />
      <?php echo DOCMAN_token::render();?>
      </form>

   	  <?php include_once($mosConfig_absolute_path."/components/com_docman/footer.php");
    }

    function editDocument(&$row, &$lists, $last, $created, &$params)
    {
        global $database, $mosConfig_offset, $mosConfig_live_site, $mosConfig_locale, $mosConfig_absolute_path;

        $tabs = new mosTabs(1);
        mosMakeHtmlSafe($row);

        DOCMAN_Compat::calendarJS();


        ?>
    	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
    	<script language="JavaScript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js" type="text/javascript"></script>
    	<script language="JavaScript" type="text/javascript">
    		<!--
    		function submitbutton(pressbutton) {
    		  var form = document.adminForm;
    		  if (pressbutton == 'cancel') {
    			submitform( pressbutton );
    			return;
    		  }
    		  // do field validation
			<?php //TUYEN remove this command: dmHTML::docEditFieldsJS();/* Include all edits at once */?>
			$msg = ""; //TUYEN create this command here
			if ( $msg != "" ){
					$msghdr = "<?php echo _DML_ENTRY_ERRORS;?>";
					$msghdr += '\n=================================';
					alert( $msghdr+$msg+'\n' );
			}else {
			<?php
        	getEditorContents('editor1', 'dmdescription');
        	?>
				submitform( pressbutton );
				}
			}
			//--> end submitbutton
    	</script>

    	<style>
			select option.label { background-color: #EEE; border: 1px solid #DDD; color : #333; }
		</style>

        <?php
        $tmp = ($row->id ? _DML_EDIT : _DML_ADD).' '._DML_DOCUMENT;
        dmHTML::adminHeading( $tmp, 'documents' )
        ?>

    	<form action="index2.php" method="post" name="adminForm" class="adminform" id="dm_formedit">
        <table class="adminform">
        <tr>
            <th colspan="3"><?php echo _DML_TITLE_DOCINFORMATION ?></th>
        </tr>

        <?php HTML_DMDocuments::_showTabBasic($row, $lists, $last, $created);?>

        <tr>
        <td colspan="2">
		<?php
		if ($lists['__doc_id'] != -1) {//Must have information about document -> display TABs: Document, Document Distribution, ...
			$tabs->startPane("content-pane");
			$tabs->startTab(_DML_DOC, "document-page");
	
			HTML_DMDocuments::_showTabDocument($row, $lists, $last, $created);
	
	
			$tabs->endTab();
	   
			$tabs->startTab(_DML_TAB_PERMISSIONS, "ownership-page");	
			HTML_DMDocuments::_showTabPermissions($row, $lists, $last, $created);	
			$tabs->endTab();

		   /* TUYEN removed here
			$tabs->startTab(_DML_TAB_LICENSE, "license-page");	
			
			HTML_DMDocuments::_showTabLicense($row, $lists, $last, $created);
	
			if(isset($params)) :
			$tabs->endTab();
			$tabs->startTab(_DML_TAB_DETAILS, "details-page");
	
			HTML_DMDocuments::_showTabDetails($row, $lists, $last, $created, $params);
			endif;
	
			$tabs->endTab();
			
			*/

			$tabs->startTab(_DML_DOC_DISTRIBUTION, "document-page");
			HTML_DMDocuments::_showTabDocumentDistribution($row, $lists, $last, $created);
			$tabs->endTab();
			
			$tabs->endPane();
		}
        ?>
        </td>
        </tr>
        </table>
		
		<script language="javascript" type="text/javascript">
			insertArrray ("lvbid");
			loopSelected ("catid", "lvbid");
		</script>
		
		<input type="hidden" name="original_dmfilename" value="<?php echo $lists['original_dmfilename'];?>" />
    	<input type="hidden" name="dmsubmitedby" value="<?php echo $row->dmsubmitedby;?>" />
    	<input type="hidden" name="id" value="<?php echo $row->id;?>" />

		<input type="hidden" name="option" value="com_docman" />
    	<input type="hidden" name="section" value="documents" />
    	<input type="hidden" name="task" value="" />
        <input type="hidden" name="dmcounter" value="<?php echo $row->dmcounter;?>" />
        <?php echo DOCMAN_token::render();?>
    	</form>
        <?php include_once($mosConfig_absolute_path."/components/com_docman/footer.php");
    }

    function _showTabBasic(&$row, &$lists, &$last, &$created)
    {
		
        ?>

        <tr>
            <td width="250" align="right"><?php echo _DML_NAME;?></td>
            <td colspan="2">
                <input class="inputbox" type="text" name="dmname" size="50" maxlength="100" value="<?php echo $row->dmname ?>" />
            </td>
        </tr>
		<tr>
            <td align="right"><?php echo _DML_CAT;?></td>
            <td><?php echo $lists['catid'];?></td>
        </tr>
        
		<tr>
            <td align="right"><?php echo _DML_LVB;?></td>
            <td><?php echo $lists['lvbid'];?></td>
        </tr>
        
		<tr>
            <td align="right"><?php echo _DML_CQBH;?></td>
            <td><?php echo $lists['cqbhid'];?></td>
        </tr>
		
		<tr>
            <td width="250" align="right"><?php echo _DML_NGAYKY;?></td>
            <td colspan="2">
                 <?php echo DOCMAN_Compat::calendar('ngay_ky', $row->ngay_ky==""?"":date("d-m-Y", strtotime($row->ngay_ky)));?>
            </td>
        </tr>
         <tr>
            <td width="250" align="right"><?php echo _DML_NGUOIKY;?></td>
            <td colspan="2">
                <input class="inputbox" type="text" name="nguoi_ky" size="50" maxlength="100" value="<?php echo $row->nguoi_ky ?>" />
            </td>
        </tr>
        <tr>
            <td width="250" align="right"><?php echo _DML_NGAYHIEULUC;?></td>
            <td colspan="2">
                 <?php echo DOCMAN_Compat::calendar('ngay_hieu_luc', $row->ngay_hieu_luc==""?"":date("d-m-Y", strtotime($row->ngay_hieu_luc)));?>
            </td>
        </tr>
         <tr>
            <td width="250" align="right"><?php echo _DML_NGAYHETHIEULUC;?></td>
            <td colspan="2">
                 <?php echo DOCMAN_Compat::calendar('ngay_het_hieu_luc', $row->ngay_het_hieu_luc==""?"":date("d-m-Y", strtotime($row->ngay_het_hieu_luc)));?>
            </td>
        </tr>					
        <?php if (!$row->approved) {?>
        <tr>
            <td valign="top" align="right"><?php echo _DML_APPROVED;?></td>
            <td><?php echo $lists['approved'];
            echo DOCMAN_Utils::mosToolTip(_DML_APPROVED_TOOLTIP . '.</span>',  _DML_APPROVED);
            ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td valign="top" align="right"><?php echo _DML_PUBLISHED; ?></td>
            <td>
            <?php echo $lists['published'];
            // echo DOCMAN_Utils::mosToolTip(_PUBLISHED_TOOLTIP.'.</span>', _DML_PUBLISHED);
            ?>
            </td>
        </tr>

        <tr>
        	<td valign="top" colspan="2"><?php echo _DML_DESCRIPTION;?></td>
        </tr>
        <tr>
			<td colspan="2">
            <?php
            // parameters : areaname, content, hidden field, width, height, rows, cols
            DOCMAN_Compat::editorArea('editor1', $row->dmdescription , 'dmdescription', '500', '200', '50', '5') ;
            ?>
            </td>
        </tr>

        <?php
    }
	
	//TUYEN: created this function
	function _showTabDocumentDistribution (&$row, &$lists, &$last, &$created) {
		?>
		<script type="text/javascript" language="javascript">			
			function getUsers(){
				url = "index2.php?option=com_docman&section=documents&task=getUsers&userIds=" + select_getValue("idUserGroup");
				ajaxRes (url, "contentUsers");
			}
			
			function addGroupIntoTable (tableId) {
				resetAgain();
				var strNameGroup  = select_getTitle ("idUserGroup");
				var checkBoxValue = select_getValue("idUserGroup");
				if (strNameGroup == "") {
					alert ("You must select a group");
				} else if (checkExistByValue_Title (document.adminForm.checkbox_User, checkBoxValue, "GROUP")) {
					alert ("This Group is selected");
				} else {
					cellArray = new Array();
					cellArray[0] = "";//First cell
					
					var checkbox = document.createElement('input');
					checkbox.type = "checkbox";
					checkbox.name = "checkbox_User";
					checkbox.value = checkBoxValue;
					checkbox.title = "GROUP";
					checkbox.id ="checkbox_UserId";
					cellArray[1] = checkbox;//Second cell
					
					cellArray[2] = strNameGroup;
					cellArray[3] = "";
					cellArray[4] = "";
					cellArray[5] = "";
					table_addRow (tableId, cellArray);
				}
			}
			
			function addUserIntoTable (tableId) {
				resetAgain();
				var strUser = select_getTitle ("idUser");
				var checkBoxValue = select_getValue("idUser");

				if (strUser == "") {
					alert ("You must select a user");
				} else if (checkExistByValue_Title (document.adminForm.checkbox_User, checkBoxValue, "USER")) {
					alert ("This Group is selected"); 
				} else {
					cellArray = new Array();
					cellArray[0] = "";//First cell
					
					var checkbox = document.createElement('input');
					checkbox.type = "checkbox";
					checkbox.name = "checkbox_User";
					checkbox.value = checkBoxValue;
					checkbox.title = "USER";
					checkbox.id ="checkbox_UserId";
					cellArray[1] = checkbox;//Second cell
								
					cellArray[2] = "";
					cellArray[3] = strUser;
					cellArray[4] = "";
					cellArray[5] = "";
					table_addRow (tableId, cellArray);
				}
			}
			
			function resetAgain () {
				document.getElementById("errorMessages").innerHTML = "";
			}
			
			function saveDistributedDocument() {
				resetAgain();			
				var cbUserId  = document.adminForm.checkbox_User;
				var requestId = document.getElementById("requestId").value;
				var subjectId = document.getElementById("subjectId").value;
				var versionId = document.getElementById("versionId").value;
				
				if (subjectId == "") {
					alert ("Please fill value into Subject");
					return false;
				}

				if (requestId == "") {
					alert ("Please fill value into Request");
					return false;
				}
				
				if (versionId == "") {
					alert ("Please select a appropriate version");
					return false;
				}
				
				var i = 0;
				var valueOfListCheckBox = "";
				for (i=0; i< cbUserId.length - 1; i++) {//because of having hidden object to avoid case: ONLY ELEMENT
					if (valueOfListCheckBox == "") valueOfListCheckBox = cbUserId[i].value;
					else valueOfListCheckBox = valueOfListCheckBox + "," + cbUserId[i].value;
				}
				
				if (valueOfListCheckBox == "") {
					alert ("Please select Users or Group");
					return false;
				}

				url = "index2.php?option=com_docman&section=documents&task=saveDistributedDocument" +
				      "&versionId=" + versionId + 
					  "&request=" + requestId +
					  "&subject=" + subjectId +
					  "&userIds=" + valueOfListCheckBox;
				ajaxRes (url, "errorMessages");
			}
		</script>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr> 
				<td width="60%" align="left" valign="top">
					<table width="100%" cellpadding="0" cellspacing="2">
						<tr><td colspan="2"><div id = "errorMessages"></div></td></tr>
						<tr>
							<td width="6%"><?php echo _DML_VERSION; ?></td>
							<td>
							<select	onchange="#" name="versions" id="versionId">								
		<?php		
						$__files = ($lists['__files']);
						if (!empty ($__files)) {
							foreach ($__files as $file) {				
		?>
								<option title="<?php echo $file->file_url ?>" value="<?php echo $file->id; ?>"><?php echo $file->file_url ?></option>
		<?php
							}//end for
						}//end if
		?>
							</select>
							</td>
						</tr>
						<tr>
							<td width="6%"><?php echo _DML_GROUP; ?></td>
							<td>
							<select	onchange="getUsers()" name="userGroup" id="idUserGroup">
								<option value="">&nbsp;</option>
		<?php
							$userGroup = $lists['user_group'];
							if (!empty($userGroup)) {
								foreach ($userGroup as $file) {
		?>
								<option title="<?php echo $file->groups_name ?>" value="<?php echo $file->groups_members; ?>"><?php echo $file->groups_name ?></option>
		<?php 
								}//End Foreach
							}//End If	
		?>
							</select>
							<input class="down" type="button" onclick="addGroupIntoTable('userGroupTableId')" value="Add" />
							</td>
						</tr>
						
						<tr>
							<td><?php echo _DML_USERS; ?></td>
							<td><spam id="contentUsers"><select id="idUser"><option value="">&nbsp;</option></select></spam>
								<input name="button" type="button" onclick="addUserIntoTable('userGroupTableId')" value="Add" />								
							</td>
						</tr>
					</table>

					<table id="userGroupTableId" border="0" class="adminlist" cellspacing="1">
						<tr>
							<th width="5">#</th>
							<th width="5">
								<input type="checkbox" onclick="checkAll(10);" value="" name="toggle">
							</th>
							<th class="title"><?php echo _DML_GROUP; ?></th>
							<th width="20%" nowrap="nowrap"><?php echo _DML_USERS; ?></th>
							<th width="20%" nowrap="nowrap"><?php echo _DML_REQUESTS; ?></th>
							<th width="20%" nowrap="nowrap"><?php echo _DML_SENDER; ?></th>	
							<th width="8%" nowrap="nowrap">&nbsp;</th>				
						</tr>
					</table>
				</td>
				
				<td valign="top"><!--REQUEST-->
					<?php echo _DML_SUBJECT; ?><br />
					<input type="text" size="100" id="subjectId" /><br />
					<?php echo _DML_REQUESTS; ?><br />
					<textarea style="width:100%" id="requestId" name="request" rows="13"></textarea><br />
					<input type="button" value="Send" onclick="saveDistributedDocument()" />
					
					<input type="hidden" name="checkbox_User" value="-1"  />
				</td>
			</tr>
		</table>
		<?php
	}
	
    function _showTabDocument(&$row, &$lists, &$last, &$created)
    {
		//BEGIN: TUYEN - fixed here
		global $mosConfig_live_site;
		?>
		
		<div align="right" style="width: 100%">
			<a class="toolbar" href="index2.php?option=com_docman&section=files&task=update&document_id=<?php echo $lists['__doc_id'];?>">
				<img border="0" src="<?php echo $mosConfig_live_site;?>/administrator/components/com_docman/images/upload.gif">
			</a>
		</div>
		
		<?php		
		$__files = ($lists['__files']);
		if (!empty ($__files)) {				
    	?>
		
		<table class="adminlist" cellspacing="1">
			<thead>
				<tr>
					<th width="5">#</th>
					<th width="5">
						<input type="checkbox" onclick="checkAll(10);" value="" name="toggle">
					</th>
					<th class="title"><?php echo _DML_CFG_FILENAMES; ?></th>
					<th width="4%" nowrap="nowrap"><?php echo _DML_UPLOADING_DATE; ?></th>
					<th width="3%" nowrap="nowrap"><?php echo _DML_NGAYHIEULUC; ?></th>
					<th width="3%" nowrap="nowrap"><?php echo _DML_NGAYHETHIEULUC; ?></th>
					<th width="5%"><?php echo _DML_FILETYPE; ?></th>
					<th width="2%"><?php echo _DML_SIZE; ?></th>
					<th width="10%" nowrap="nowrap" class="title"><?php echo _DML_USER; ?></th>
					<th width="13%" nowrap="nowrap" class="title"><?php echo _DML_REASON; ?></th>
					<th width="2%" nowrap="nowrap" class="title">#<?php echo _DML_DOWNLOADS; ?></th>
					<th width="2" align="center">#<?php echo _DML_READ; ?></th>
					<th width="1%" class="title"><?php echo _DML_VERSION; ?></th>
					<th width="5%" class="title"><?php echo _DML_STATUS; ?></th>
					<th width="10%" class="title"><?php echo _DML_TRACK; ?></th>
				</tr>
		<?php
			$__i = 1;
			$__k = 0;
			foreach($__files as $__item) {
				if ($__i == 0) $__i = 1;
				else $__i = 0;
				
				$__k = $__k + 1;
		?>
				<tr class="row<?php echo $__i?>">
					<td><?php echo $__k; ?></td>
					<td></td>
					<td><?php echo $__item->file_url; ?></td>
					<td><?php echo $__item->created_date; ?></td>
					<td><?php echo $__item->effective_date; ?></td>
					<td><?php echo $__item->expiration_date; ?></td>
					<td><?php echo $__item->file_type; ?></td>
					<td><?php echo $__item->size; ?></td>
					<td><?php echo $__item->creatorEmail; ?></td>
					<td><?php echo $__item->reason; ?></td>
					<td><?php echo $__item->sum_of_download; ?></td>
					<td><?php echo $__item->sum_of_read; ?></td>
					<td><?php echo $__item->license_name; ?></td>					
					<td>
						<script type="text/javascript">									
									function approvedButton (document_id, fileId) {
										document.location.href = "index2.php?option=com_docman&section=documents&task=approveFiles&document_id=" + document_id + "&fileId="+fileId;									
									} 
						</script>	
					<?php 
						if ($__item->status == 0) {//pending
					?>													
							<a href="javascript:approvedButton(<?php echo $lists['__doc_id'];?>, <?php echo $__item->id;?>);">
								<img width="16" border="0" height="16" alt="No" src="images/publish_x.png">
							</a>
					<?php
						} else {//Approve
					?>
							<a href="javascript:approvedButton(<?php echo $lists['__doc_id'];?>, <?php echo $__item->id;?>);">
								<img width="16" border="0" height="16" alt="Yes" src="images/tick.png">
							</a>
					<?php						
						}
					
					?>
					</td>
					
					<td><?php echo $__item->track; ?></td>
				</tr>		
		<?php	
			}
		?>
		
			</thead>
		</table>
		
		<?php
		}
		//END: TUYEN - fixed here
		?>		
		
    	<?php
    }

    function _showTabPermissions(&$row, &$lists, &$last, &$created)
    {
   		?>
    	<table class="adminform">
    	<tr>
			<th colspan="2"><?php echo _DML_TITLE_DOCPERMISSIONS ?></th>
		<tr>
    	<tr>
    		<td width="250" align="right"><?php echo _DML_OWNER;?></td>
    		<td>
    		<?php
    		echo $lists['viewer'];
        	echo DOCMAN_Utils::mosToolTip(_DML_OWNER_TOOLTIP . '</span>',  _DML_OWNER);
        	?>
        	</td>
    	</tr>
    	<tr>
    		<td valign="top" align="right"><?php echo _DML_MAINTAINER;?></td>
    		<td>
    		<?php
    		echo $lists['maintainer'];
        	echo DOCMAN_Utils::mosToolTip(_DML_MANT_TOOLTIP . '</span>',  _DML_MAINTAINER);
        	?>
        	</td>
    	</tr>
    	<tr>
    		<td valign="top" align="right"><?php echo _DML_CREATED_BY;?></td>
    		<td>[<?php echo $created[0]->name;?>] <i>on
    		<?php echo mosFormatDate($row->dmdate_published) ?>
    		</i> </td>
    	</tr>
    	<tr>
    		<td valign="top" align="right"><?php echo _DML_UPDATED_BY;?></td>
    		<td>[<?php echo $last[0]->name;?>]
    		<?php
        	if ($row->dmlastupdateon) {
            	echo " <i>on " . mosFormatDate($row->dmlastupdateon);
        	}
        	?>
    		</i>
    		</td>
    	</tr>
    	</table>
    	<?php
    }

    function _showTabLicense(&$row, &$lists, &$last, &$created)
    {
   		?>
    	<table class="adminform">
    	<tr>
			<th colspan="2"><?php echo _DML_TITLE_DOCLICENSES ?></th>
		<tr>
    	<tr>
    		<td width="250" ><?php echo _DML_LICENSE_TYPE;?></td>
    		<td>
    		<?php
    		echo $lists['licenses'];
        	echo DOCMAN_Utils::mosToolTip(_DML_LICENSE_TOOLTIP . '</span>',  _DML_LICENSE_TYPE);
        	?>
    		</td>
    	</tr>
    	<tr>
    		<td><?php echo _DML_DISPLAY_LICENSE;?></td>
    		<td>
    		<?php
    		echo $lists['licenses_display'];
        	echo DOCMAN_Utils::mosToolTip(_DML_DISPLAY_LIC_TOOLTIP . '</span>',  _DML_DISPLAY_LIC);
        	?>
    		</td>
    	</tr>
    	</table>
    	<?php
    }

    function _showTabDetails(&$row, &$lists, &$last, &$created, &$params)
	{
		?>
		<table class="adminform" >
		<tr>
			<th colspan="2"><?php echo _DML_TITLE_DOCDETAILS ?></th>
		<tr>
		<tr>
			<td>
				<?php echo $params->render();?>
			</td>
		</tr>
		</table>
        <?php
	}

    function moveDocumentForm($cid, &$lists, &$items)
    {
        global $mosConfig_absolute_path;
        ?>

        <?php dmHTML::adminHeading( _DML_MOVETOCAT, 'categories' )?>


		<form action="index2.php" method="post" name="adminForm" class="adminform" id="dm_moveform">
		<table class="adminform">
		<tr>
			<td align="left" valign="middle" width="10%">
			<strong><?php echo _DML_MOVETOCAT;?></strong>
			<?php echo $lists['categories'] ?>
			</td>
			<td align="left" valign="top" width="20%">
			<strong><?php echo _DML_DOCSMOVED;?></strong>
			<?php
        	echo "<ol>";
        	foreach ($items as $item) {
            	echo "<li>" . $item->dmname . "</li>";
        	}
        	echo "</ol>";?>
			</td>
		</tr>
		</table>
		<input type="hidden" name="option" value="com_docman" />
    	<input type="hidden" name="section" value="documents" />
    	<input type="hidden" name="task" value="move_process" />
		<input type="hidden" name="boxchecked" value="1" />
		<?php
        foreach ($cid as $id) {
            echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
        }
        ?>
        <?php echo DOCMAN_token::render();?>
		</form>
		<?php include_once($mosConfig_absolute_path."/components/com_docman/footer.php");
    }

    function copyDocumentForm($cid, &$lists, &$items)
    {
        global $mosConfig_absolute_path;
        ?>
        <?php dmHTML::adminHeading( _DML_COPYTOCAT, 'categories' )?>

        <form action="index2.php" method="post" name="adminForm" class="adminform" id="dm_moveform">
        <table class="adminform">
        <tr>
            <td align="left" valign="middle" width="10%">
            <strong><?php echo _DML_COPYTOCAT;?></strong>
            <?php echo $lists['categories'] ?>
            </td>
            <td align="left" valign="top" width="20%">
            <strong><?php echo _DML_DOCSCOPIED;?></strong>
            <?php
            echo "<ol>";
            foreach ($items as $item) {
                echo "<li>" . $item->dmname . "</li>";
            }
            echo "</ol>";?>
            </td>
        </tr>
        </table>
        <input type="hidden" name="option" value="com_docman" />
        <input type="hidden" name="section" value="documents" />
        <input type="hidden" name="task" value="copy_process" />
        <input type="hidden" name="boxchecked" value="1" />
        <?php
        foreach ($cid as $id) {
            echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
        }
        ?>
        <?php echo DOCMAN_token::render();?>
        </form>
        <?php include_once($mosConfig_absolute_path."/components/com_docman/footer.php");
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       