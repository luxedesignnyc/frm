<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: files.php 769 2009-01-08 15:01:15Z mathias $
 * @package DOCman_1.4
 * @copyright (C) 2003-2009 Joomlatools
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

include_once dirname(__FILE__) . '/files.html.php';

require_once($_DOCMAN->getPath('classes', 'file'));
require_once($_DOCMAN->getPath('classes', 'utils'));

// retrieve some expected url (or form) arguments
$old_filename = mosGetParam(DOCMAN_Utils::stripslashes($_REQUEST), 'old_filename', 1);

switch ($task)
{
    case "new": // make a new document using the selected file
        // modify the request and go to 'documents' view
        $_REQUEST['section']        = 'documents';
        $_REQUEST['uploaded_file']  = $cid[0];
        $GLOBALS['section']        = 'documents';
        $GLOBALS['uploaded_file']  = $cid[0];
        include_once($_DOCMAN -> getPath('includes', 'documents'));
        break;
    case "upload" :
    	{
            $step = mosGetParam($_REQUEST, 'step', 1);
            $method = mosGetParam($_POST, 'radiobutton', null);

            if (!$method) {
                $method = mosGetParam($_REQUEST, 'method', 'http');
            }

            uploadWizard($step, $method, $old_filename);
        }
        break;
    case "remove":
        removeFile($cid);
        break;
    case "update":
        uploadWizard(2, 'http', $old_filename);
        break;
    case "show" :
    default :
        showFiles();
}


function showFiles()
{
    global $database, $mainframe, $option, $section, $mosConfig_list_limit;
    global $_DOCMAN;

    $limit      = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$option}{$section}limitstart", 'limitstart', 0);
    $levellimit = $mainframe->getUserStateFromRequest("view{$option}{$section}limit", 'levellimit', 10);

    $filter = $mainframe->getUserStateFromRequest("filterarc{$option}{$section}", 'filter', 0);
    $search = $mainframe->getUserStateFromRequest( "search{$option}{$section}", 'search', '' );

    // read directory content
    $folder = new DOCMAN_Folder($_DOCMAN->getCfg('dmpath'));
    $files = $folder->getFiles($search);

    for ($i = 0, $n = count($files);$i < $n;$i++)
    {
        $file = &$files[$i];

        $database->setQuery("SELECT COUNT(dmfilename) FROM #__docman WHERE dmfilename='" . $database->getEscaped($file->name) . "'");
        $result = $database->loadResult();

        if ($database->getErrorNum()) {
            echo $database->stderr();
            return false;
        }

        $file->links = $result;
    }

    if ($filter == 2) {
        $files = array_filter($files, 'filterOrphans');
    }
    if ($filter == 3) {
        $files = array_filter($files, 'filterDocuments');
    }

    $total = count($files);

    require_once($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

     // slice out elements based on limits
    $rows = array_slice($files, $pageNav->limitstart, $pageNav->limit);

    $filters[] = mosHTML::makeOption('0', _DML_SELECT_FILE);
    $filters[] = mosHTML::makeOption('1', _DML_ALLFILES);
    $filters[] = mosHTML::makeOption('2', _DML_ORPHANS);
    $filters[] = mosHTML::makeOption('3', _DML_DOCFILES);
    $lists['filter'] = mosHTML::selectList($filters, 'filter',
        'class="inputbox" size="1" onchange="document.adminForm.submit( );"',
        'value', 'text', $filter);

    //$search = '';

    HTML_DMFiles::showFiles($rows, $lists, $search, $pageNav);
}

function removeFile($cid)
{
    DOCMAN_token::check() or die('Invalid Token');

    global $database, $_DOCMAN;

    foreach($cid as $name) {
        $database->setQuery("SELECT COUNT(dmfilename) FROM #__docman WHERE dmfilename='" . $database->getEscaped($name) . "'");
        $result = $database->loadResult();

        if ($database->getErrorNum()) {
            echo $database->stderr();
            return false;
        }

        if ($result != 0)
            mosRedirect("index2.php?option=com_docman&section=files", _DML_ORPHANS_LINKED);

        $file = $_DOCMAN->getCfg('dmpath') . DS . $name;

        if (!unlink($file)) {
            mosRedirect("index2.php?option=com_docman&section=files", _DML_ORPHANS_PROBLEM);
        }
    }

    mosRedirect("index2.php?option=com_docman&section=files", _DML_ORPHANS_DELETED);
}

function uploadWizard($step = 1, $method = 'http', $old_filename)
{
    global $_DOCMAN, $database;

    switch ($step) {
        case 1:
            $lists['methods'] = dmHTML::uploadSelectList($method);
            HTML_DMFiles::uploadWizard($lists);
            break;

        case 2:
            switch ($method) {
                case 'http':
                    HTML_DMFiles::uploadWizard_http($old_filename);
                    break;
                case 'ftp':
                    HTML_DMFiles::uploadWizard_ftp();
                    break;
                case 'link':
                    mosRedirect("index2.php?option=com_docman&section=documents&task=new&makelink=1",_DML_CREATEALINK);
                    // HTML_DMFiles::uploadWizard_link();
                    break;
                case 'transfer':
                    HTML_DMFiles::uploadWizard_transfer();
                    break;
                default:
                    mosRedirect("index2.php?option=com_docman&section=files", _DML_SELECTMETHODFIRST);
            }
            break;
        case 3:
            DOCMAN_token::check() or die('Invalid Token');
            switch ($method) {
                
				case 'http':
					//TUYEN fixed here: get value from POST method when click submit action: STEP = 3, METHOD = 'http'
					
					//BEGIN: Get latest version
					$doc_id = JRequest::getVar('document_id', 0, 'get', 'string');
					/*$__query = " SELECT MAX(license_name) AS latest_license  FROM #__docman_files WHERE doc_id='". (int)$doc_id . "'";
					$database->setQuery($__query);
					
					$dbItem = $database->loadObject();
					
					$floatLatestLicense = (float) $dbItem->latest_license;
					$floatLatestLicense = ($floatLatestLicense == 0) ? 1.0 : $floatLatestLicense + 0.1;*/
					$floatLatestLicense = DOCMAN_utils::getLatesVersion($doc_id);
					//END: Get latest version
					
                    $path = $_DOCMAN->getCfg('dmpath');

                    $upload = new DOCMAN_FileUpload();
                    $file_upload = mosGetParam($_FILES, 'upload');
                    $result = &$upload->uploadHTTP_New($file_upload, $path, $floatLatestLicense, $doc_id, _DM_VALIDATE_ADMIN);
					

                    if (!$result) {
                        mosRedirect("index2.php?option=com_docman&section=files", _DML_ERROR_UPLOADING . " - " . $upload->_err);
                    } else {
                        $batch = mosGetParam($_POST, 'batch', null);

                        if ($batch && $old_filename <> null) {
                            require_once("includes/pcl/pclzip.lib.php");

                            if (!extension_loaded('zlib')) {
                                mosRedirect("index2.php?option=com_docman&section=files", _DML_ZLIB_ERROR);
                            }

                            $target_directory = $_DOCMAN->getCfg('dmpath');
                            $zip = new PclZip($target_directory . "/" . $result->name);
                            $file_to_unzip = preg_replace('/(.+)\..*$/', '$1', $target_directory . "/" . $result->name);

                            if (!$zip->extract($target_directory)) {
                                mosRedirect("index2.php?option=com_docman&section=files", _DML_UNZIP_ERROR);
                            }

                            @unlink ($target_directory . "/" . $result->name);
                        }

                        if ($old_filename) {

                            $file = $_DOCMAN->getCfg('dmpath') . "/" . $old_filename;
							@unlink($file);

                            //BEGIN: TUYEN - process DATABASE							
										
							//Create new file version
							$user		= & JFactory::getUser(); 														
							DOCMAN_utils::saveInFileTable ($doc_id, $floatLatestLicense, $result->name, $result->getSize(), $result->getExtension(), JRequest::getVar('reason', 0, 'get', 'string') , "0");
							//END: TUYEN - process DATABASE
							
							
							$database->setQuery("UPDATE #__docman SET dmfilename='". $database->getEscaped($result->name) ."' WHERE dmfilename='". $database->getEscaped($old_filename) ."'");

                            if (!$database->query()) {
                                echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1);</script>\n";
                                exit();
                            }
                        }

                        //HTML_DMFiles::uploadWizard_sucess($result, $batch, $old_filename);
						
						
                       // mosRedirect("index2.php?option=com_docman&section=files&task=upload&step=4" . "&result=" . urlencode($result->name) . "&batch=" . (0 + $batch) . "&old_filename=" . $old_filename, _DML_SUCCESS . ' &quot;' . $result->name . '&quot; - ' . _DML_FILEUPLOADED);

					   //BEGIN: Tuyen redirect this page to Document Screen
					   mosRedirect("index2.php?option=com_docman&section=documents&task=editAfterUpload&document_id=".$doc_id."&result=" . urlencode($result->name) . "&batch=" . (0 + $batch) . "&old_filename=" . $old_filename, _DML_SUCCESS . ' &quot;' . $result->name . '&quot; - ' . _DML_FILEUPLOADED);
					   //END: Tuyen redirect this page to Document Screen					   

                    }
                    break;

                case 'ftp': break;

                case 'link': break;

                case 'transfer':
					//TUYEN fixed here to  Upload files
                    $url  = stripslashes(mosGetParam($_POST, 'url', null));
                    $name = stripslashes(mosGetParam($_POST, 'localfile', null));
                    $path = $_DOCMAN->getCfg('dmpath') . "/";

                    $upload = new DOCMAN_FileUpload();
                    $result = $upload->uploadURL($url, $path, _DM_VALIDATE_ADMIN, $name);

                    if ($result) {
                        // HTML_DMFiles::uploadWizard_sucess($result, 0, 1);
                        mosredirect("index2.php?option=com_docman&section=files&task=upload&step=4" . "&result=" . urlencode($result->name) . "&batch=0&old_filename=1",
                            _DML_SUCCESS. ' &quot;' . $result->name . '&quot; - ' . _DML_FILEUPLOADED);
                    } else {
                        mosredirect("index2.php?option=com_docman&section=files", $upload->_err);
                    }
                    break;
            }
            break;

        case '4':/* New step that gives us a header completion message rather than
			   "in body" completion. For uniformity
			 */
            $file = new StdClass();
            $file->name = urlencode(stripslashes(mosGetParam($_REQUEST , 'result' , 'INTERNAL ERROR')));
            $batch = mosGetParam($_REQUEST , 'batch' , 0);
            $old_filename = mosGetParam($_REQUEST , 'old_filename' , null);

            HTML_DMFiles::uploadWizard_sucess($file, $batch, $old_filename, 0);
            break;
    } //End switch($step)
}

function filterOrphans($var)
{
    if ($var->links != 0) {
        return false;
    }
    return true;
}

function filterDocuments($var)
{
    if ($var->links == 0) {
        return false;
    }
    return true;
}

