<?php
/**
 * DOCman 1.4.x - Joomla! Document Manager
 * @version $Id: DOCMAN_install.class.php 765 2009-01-05 20:55:57Z mathias $
 * @package DOCman_1.4
 * @copyright (C) 2003-2009 Joomlatools
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.joomlatools.eu/ Official website
 **/
defined('_VALID_MOS') or die('Restricted access');

if (defined('_DOCMAN_INSTALL')) {
    return true;
} else {
    define('_DOCMAN_INSTALL', 1);
}

require_once($_DOCMAN->getPath('classes', 'file'));


if(defined('_DM_J15')) {
    // do nothing, might need it later
} else {
    require_once ($mosConfig_absolute_path . '/administrator/components/com_installer/installer.class.php');
}




// map the element to the required derived class
$GLOBALS['classMap'] = array('mambot' => 'mosInstallerMambot',
    'module' => 'mosInstallerModule',
    'theme' => 'DOCMAN_InstallerTheme',
    );


if(!function_exists('cleanupInstall')) {
    function cleanupInstall( $userfile_name, $resultdir) {
        global $mosConfig_absolute_path;

        if (file_exists( $resultdir )) {
            deldir( $resultdir );
            unlink( mosPathName( $mosConfig_absolute_path . '/media/' . $userfile_name, false ) );
        }
    }
}

// mosInstaller
/**
* Installer class
* @package Joomla
* @subpackage Installer
* @abstract
*/
class DM_mosInstaller {
    // name of the XML file with installation information
    var $i_installfilename  = "";
    var $i_installarchive   = "";
    var $i_installdir       = "";
    var $i_iswin            = false;
    var $i_errno            = 0;
    var $i_error            = "";
    var $i_installtype      = "";
    var $i_unpackdir        = "";
    var $i_docleanup        = true;

    /** @var string The directory where the element is to be installed */
    var $i_elementdir       = '';
    /** @var string The name of the Joomla! element */
    var $i_elementname      = '';
    /** @var string The name of a special atttibute in a tag */
    var $i_elementspecial   = '';
    /** @var object A DOMIT XML document */
    var $i_xmldoc           = null;
    var $i_hasinstallfile   = null;
    var $i_installfile      = null;

    /**
    * Constructor
    */
    function DM_mosInstaller() {
        $this->i_iswin = (substr(PHP_OS, 0, 3) == 'WIN');
    }
    /**
    * Uploads and unpacks a file
    * @param string The uploaded package filename or install directory
    * @param boolean True if the file is an archive file
    * @return boolean True on success, False on error
    */
    function upload($p_filename = null, $p_unpack = true) {
        $this->i_iswin = (substr(PHP_OS, 0, 3) == 'WIN');
        $this->installArchive( $p_filename );

        if ($p_unpack) {
            if ($this->extractArchive()) {
                return $this->findInstallFile();
            } else {
                return false;
            }
        }
    }
    /**
    * Extracts the package archive file
    * @return boolean True on success, False on error
    */
    function extractArchive() {
        global $mosConfig_absolute_path;

        $base_Dir       = mosPathName( $mosConfig_absolute_path . '/media' );

        $archivename    = $base_Dir . $this->installArchive();
        $tmpdir         = uniqid( 'install_' );

        $extractdir     = mosPathName( $base_Dir . $tmpdir );
        $archivename    = mosPathName( $archivename, false );

        $this->unpackDir( $extractdir );

        if (eregi( '.zip$', $archivename )) {
            // Extract functions
            require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pclzip.lib.php' );
            require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pclerror.lib.php' );
            //require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pcltrace.lib.php' );
            //require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pcltar.lib.php' );
            $zipfile = new PclZip( $archivename );
            if($this->isWindows()) {
                define('OS_WINDOWS',1);
            } else {
                define('OS_WINDOWS',0);
            }

            $ret = $zipfile->extract( PCLZIP_OPT_PATH, $extractdir );
            if($ret == 0) {
                $this->setError( 1, 'Unrecoverable error "'.$zipfile->errorName(true).'"' );
                return false;
            }
        } else {
            require_once( $mosConfig_absolute_path . '/includes/Archive/Tar.php' );
            $archive = new Archive_Tar( $archivename );
            $archive->setErrorHandling( PEAR_ERROR_PRINT );

            if (!$archive->extractModify( $extractdir, '' )) {
                $this->setError( 1, 'Extract Error' );
                return false;
            }
        }

        $this->installDir( $extractdir );

        // Try to find the correct install dir. in case that the package have subdirs
        // Save the install dir for later cleanup
        $filesindir = mosReadDirectory( $this->installDir(), '' );

        if (count( $filesindir ) == 1) {
            if (is_dir( $extractdir . $filesindir[0] )) {
                $this->installDir( mosPathName( $extractdir . $filesindir[0] ) );
            }
        }
        return true;
    }
    /**
    * Tries to find the package XML file
    * @return boolean True on success, False on error
    */
    function findInstallFile() {
        $found = false;
        // Search the install dir for an xml file
        $files = mosReadDirectory( $this->installDir(), '.xml$', true, true );

        if (count( $files ) > 0) {
            foreach ($files as $file) {
                $packagefile = $this->isPackageFile( $file );
                if (!is_null( $packagefile ) && !$found ) {
                    $this->xmlDoc( $packagefile );
                    return true;
                }
            }
            $this->setError( 1, 'ERROR: Could not find a Joomla! XML setup file in the package.' );
            return false;
        } else {
            $this->setError( 1, 'ERROR: Could not find a Joomla! XML setup file in the package.' );
            return false;
        }
    }
    /**
    * @param string A file path
    * @return object A DOMIT XML document, or null if the file failed to parse
    */
    function isPackageFile( $p_file ) {
        $xmlDoc = new DOMIT_Lite_Document();
        $xmlDoc->resolveErrors( true );

        if (!$xmlDoc->loadXML( $p_file, false, true )) {
            return null;
        }
        $root = &$xmlDoc->documentElement;

        if ($root->getTagName() != 'mosinstall') {
            return null;
        }
        // Set the type
        $this->installType( $root->getAttribute( 'type' ) );
        $this->installFilename( $p_file );
        return $xmlDoc;
    }
    /**
    * Loads and parses the XML setup file
    * @return boolean True on success, False on error
    */
    function readInstallFile() {

        if ($this->installFilename() == "") {
            $this->setError( 1, 'No filename specified' );
            return false;
        }

        $this->i_xmldoc = new DOMIT_Lite_Document();
        $this->i_xmldoc->resolveErrors( true );
        if (!$this->i_xmldoc->loadXML( $this->installFilename(), false, true )) {
            return false;
        }
        $root = &$this->i_xmldoc->documentElement;

        // Check that it's am installation file
        if ($root->getTagName() != 'mosinstall') {
            $this->setError( 1, 'File :"' . $this->installFilename() . '" is not a valid Joomla! installation file' );
            return false;
        }

        $this->installType( $root->getAttribute( 'type' ) );
        return true;
    }
    /**
    * Abstract install method
    */
    function install() {
        die( 'Method "install" cannot be called by class ' . strtolower(get_class( $this )) );
    }
    /**
    * Abstract uninstall method
    */
    function uninstall() {
        die( 'Method "uninstall" cannot be called by class ' . strtolower(get_class( $this )) );
    }
    /**
    * return to method
    */
    function returnTo( $option, $element ) {
        return "index2.php?option=$option&element=$element";
    }
    /**
    * @param string Install from directory
    * @param string The install type
    * @return boolean
    */
    function preInstallCheck( $p_fromdir, $type ) {

        if (!is_null($p_fromdir)) {
            $this->installDir($p_fromdir);
        }

        if (!$this->installfile()) {
            $this->findInstallFile();
        }

        if (!$this->readInstallFile()) {
            $this->setError( 1, 'Installation file not found:<br />' . $this->installDir() );
            return false;
        }

        if ($this->installType() != $type) {
            $this->setError( 1, 'XML setup file is not for a "'.$type.'".' );
            return false;
        }

        // In case there where an error doring reading or extracting the archive
        if ($this->errno()) {
            return false;
        }

        return true;
    }
    /**
    * @param string The tag name to parse
    * @param string An attribute to search for in a filename element
    * @param string The value of the 'special' element if found
    * @param boolean True for Administrator components
    * @return mixed Number of file or False on error
    */
    function parseFiles( $tagName='files', $special='', $specialError='', $adminFiles=0 ) {
        global $mosConfig_absolute_path;
        // Find files to copy
        $xmlDoc =& $this->xmlDoc();
        $root =& $xmlDoc->documentElement;

        $files_element =& $root->getElementsByPath( $tagName, 1 );
        if (is_null( $files_element )) {
            return 0;
        }

        if (!$files_element->hasChildNodes()) {
            // no files
            return 0;
        }
        $files = $files_element->childNodes;
        $copyfiles = array();
        if (count( $files ) == 0) {
            // nothing more to do
            return 0;
        }

        if ($folder = $files_element->getAttribute( 'folder' )) {
            $temp = mosPathName( $this->unpackDir() . $folder );
            if ($temp == $this->installDir()) {
                // this must be only an admin component
                $installFrom = $this->installDir();
            } else {
                $installFrom = mosPathName( $this->installDir() . $folder );
            }
        } else {
            $installFrom = $this->installDir();
        }

        foreach ($files as $file) {
            if (basename( $file->getText() ) != $file->getText()) {
                $newdir = dirname( $file->getText() );

                if ($adminFiles){
                    if (!mosMakePath( $this->componentAdminDir(), $newdir )) {
                        $this->setError( 1, 'Failed to create directory "' . ($this->componentAdminDir()) . $newdir . '"' );
                        return false;
                    }
                } else {
                    if (!mosMakePath( $this->elementDir(), $newdir )) {
                        $this->setError( 1, 'Failed to create directory "' . ($this->elementDir()) . $newdir . '"' );
                        return false;
                    }
                }
            }
            $copyfiles[] = $file->getText();

            // check special for attribute
            if ($file->getAttribute( $special )) {
                $this->elementSpecial( $file->getAttribute( $special ) );
            }
        }

        if ($specialError) {
            if ($this->elementSpecial() == '') {
                $this->setError( 1, $specialError );
                return false;
            }
        }

        if ($tagName == 'media') {
            // media is a special tag
            $installTo = mosPathName( $mosConfig_absolute_path . '/images/stories' );
        } else if ($adminFiles) {
            $installTo = $this->componentAdminDir();
        } else {
            $installTo = $this->elementDir();
        }
        $result = $this->copyFiles( $installFrom, $installTo, $copyfiles );

        return $result;
    }
    /**
    * @param string Source directory
    * @param string Destination directory
    * @param array array with filenames
    * @param boolean True is existing files can be replaced
    * @return boolean True on success, False on error
    */
    function copyFiles( $p_sourcedir, $p_destdir, $p_files, $overwrite=false ) {
        if (is_array( $p_files ) && count( $p_files ) > 0) {
            foreach($p_files as $_file) {
                $filesource = mosPathName( mosPathName( $p_sourcedir ) . $_file, false );
                $filedest   = mosPathName( mosPathName( $p_destdir ) . $_file, false );

                if (!file_exists( $filesource )) {
                    $this->setError( 1, "File $filesource does not exist!" );
                    return false;
                } else if (file_exists( $filedest ) && !$overwrite) {
                    $this->setError( 1, "There is already a file called $filedest - Are you trying to install the same CMT twice?" );
                    return false;
                } else {
                                        $path_info = pathinfo($_file);
                                        if (!is_dir( $path_info['dirname'] )){
                                                mosMakePath( $p_destdir, $path_info['dirname'] );
                                        }
                    if( !( copy($filesource,$filedest) && mosChmod($filedest) ) ) {
                        $this->setError( 1, "Failed to copy file: $filesource to $filedest" );
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
        return count( $p_files );
    }
    /**
    * Copies the XML setup file to the element Admin directory
    * Used by Components/Modules/Mambot Installer Installer
    * @return boolean True on success, False on error
    */
    function copySetupFile( $where='admin' ) {
        if ($where == 'admin') {
            return $this->copyFiles( $this->installDir(), $this->componentAdminDir(), array( basename( $this->installFilename() ) ), true );
        } else if ($where == 'front') {
            return $this->copyFiles( $this->installDir(), $this->elementDir(), array( basename( $this->installFilename() ) ), true );
        }
    }

    /**
    * @param int The error number
    * @param string The error message
    */
    function setError( $p_errno, $p_error ) {
        $this->errno( $p_errno );
        $this->error( $p_error );
    }
    /**
    * @param boolean True to display both number and message
    * @param string The error message
    * @return string
    */
    function getError($p_full = false) {
        if ($p_full) {
            return $this->errno() . " " . $this->error();
        } else {
            return $this->error();
        }
    }
    /**
    * @param string The name of the property to set/get
    * @param mixed The value of the property to set
    * @return The value of the property
    */
    function &setVar( $name, $value=null ) {
        if (!is_null( $value )) {
            $this->$name = $value;
        }
        return $this->$name;
    }

    function installFilename( $p_filename = null ) {
        if(!is_null($p_filename)) {
            if($this->isWindows()) {
                $this->i_installfilename = str_replace('/','\\',$p_filename);
            } else {
                $this->i_installfilename = str_replace('\\','/',$p_filename);
            }
        }
        return $this->i_installfilename;
    }

    function installType( $p_installtype = null ) {
        return $this->setVar( 'i_installtype', $p_installtype );
    }

    function error( $p_error = null ) {
        return $this->setVar( 'i_error', $p_error );
    }

    function &xmlDoc( $p_xmldoc = null ) {
        return $this->setVar( 'i_xmldoc', $p_xmldoc );
    }

    function installArchive( $p_filename = null ) {
        return $this->setVar( 'i_installarchive', $p_filename );
    }

    function installDir( $p_dirname = null ) {
        return $this->setVar( 'i_installdir', $p_dirname );
    }

    function unpackDir( $p_dirname = null ) {
        return $this->setVar( 'i_unpackdir', $p_dirname );
    }

    function isWindows() {
        return $this->i_iswin;
    }

    function errno( $p_errno = null ) {
        return $this->setVar( 'i_errno', $p_errno );
    }

    function hasInstallfile( $p_hasinstallfile = null ) {
        return $this->setVar( 'i_hasinstallfile', $p_hasinstallfile );
    }

    function installfile( $p_installfile = null ) {
        return $this->setVar( 'i_installfile', $p_installfile );
    }

    function elementDir( $p_dirname = null )    {
        return $this->setVar( 'i_elementdir', $p_dirname );
    }

    function elementName( $p_name = null )  {
        return $this->setVar( 'i_elementname', $p_name );
    }
    function elementSpecial( $p_name = null )   {
        return $this->setVar( 'i_elementspecial', $p_name );
    }
}


class DOCMAN_Installer extends DM_mosInstaller {
    var $i_uploaddir = "";

    function DOCMAN_Installer()
    {
        global $mosConfig_absolute_path;

        $uploaddir = $mosConfig_absolute_path . "/media/";
        $this->uploaddir($uploaddir);

        parent::DM_mosInstaller();
    }

    function uploadPackage($package)
    {
        $upload = new DOCMAN_FileUpload();

        $file = $upload->uploadHTTP($package, $this->uploaddir());
        if (!$file) {
            $this->setError(1, $upload->_err);
            return false;
        }

        $this->installArchive($file->name);
        return $file;
    }

    function uploadPackageURL($url)
    {
        $upload = new DOCMAN_FileUpload();

        $file = $upload->uploadURL($url, $this->uploaddir());
        if (!$file) {
            $this->setError(1, $upload->_err);
            return false;
        }

        $this->installArchive($file->name);
        return $file;
    }

    function extractPackage()
    {
        if (!$this->extractArchive()) {
            $this->setError(2, $this->getError());
            return false;
        }

        return true;
    }

    function unextractPackage()
    {
        cleanupInstall($this->installArchive(), $this->unpackDir());
        return true;
    }

    function installPackage($p_fromdir = null)
    {
        global $classMap;

        $this->installDir($p_fromdir);

        if (!$this->findInstallFile()) {
            $this->setError(3, $this->getError());
            return false;
        }

        if( !typecast($this, $classMap[$this->installType()]) ) {
        	mosRedirect( 'index2.php?option=com_docman', _DML_INSTALLER_ERROR.': Typecasting to '.$classMap[$this->installType()]);
        }

        if (!$this->install($p_fromdir)) {
            $this->setError(3, $this->getError());
            return false;
        }

        return true;
    }

    function uninstallPackage($package, $type)
    {
        global $mainframe, $classMap;

        $this->filename = $package;

        if( !typecast($this, $classMap[$type]) ) {
            mosRedirect( 'index2.php?option=com_docman', _DML_INSTALLER_ERROR.': Typecasting');
        }

        if (!$this->uninstall($package)) {
            $this->setError(4, $this->getError());
            return false;
        }

        return true;
    }

    function uploaddir($p_uploaddir = null)
    {
        return $this->setVar('i_uploaddir', $p_uploaddir);
    }
}

/**
* Template installer
*
* @package DOCMAN_1.4
*/
class DOCMAN_InstallerTheme extends DOCMAN_Installer {
    /**
    * Custom install method
    *
    * @param boolean $ True if installing from directory
    */
    function install($p_fromdir = null)
    {
        global $mosConfig_absolute_path, $database;

        if (!$this->preInstallCheck($p_fromdir, 'theme')) {
            return false;
        }

        $xml = &$this->xmlDoc();
        $mosinstall = &$xml->documentElement;
        // Set some vars
        $e = &$xml->getElementsByPath('name', 1);
        $this->elementName($e->getText());
        $this->elementDir(mosPathName($mosConfig_absolute_path
                 . '/components/com_docman/themes/' . strtolower(str_replace(" ", "_", $this->elementName())))
            );

        if (!file_exists($this->elementDir()) && !mkdir($this->elementDir(), 0777)) {
            $this->setError(1, _DML_FAILEDTOCREATEDIR . ' "' . $this->elementDir() . '"');
            return false;
        }

        if ($this->parseFiles('files') === false) {
            return false;
        }
        if ($this->parseFiles('images') === false) {
            return false;
        }
        if ($this->parseFiles('css') === false) {
            return false;
        }
        if ($this->parseFiles('media') === false) {
            return false;
        }
        // Are there parameters
        $params_element = &$xml->getElementsByPath('params', 1);
        if (!is_null($params_element)) {
            $params = &$this->parseParams($params_element);
            if ($this->writeConfigFile($params) === false) {
                return false;
            }
        }
        if ($e = &$xml->getElementsByPath('description', 1)) {
            $this->setError(0, $this->elementName() . '<p>' . $e->getText() . '</p>');
        }

        return $this->copySetupFile('front');
    }

    function parseParams(&$element)
    {
        $params = new StdClass();
        foreach ($element->childNodes as $param) {
            $name = $param->getAttribute('name');
            $default = $param->getAttribute('default');
            if ($name[0] != '@') {
                $params->$name = $default;
            }
        }

        return $params;
    }

    function writeConfigFile(&$params)
    {
        global $_DOCMAN;

        $theme = strtolower(str_replace(" ", "_", $this->elementName()));
        $path = $_DOCMAN->getPath('themes', $theme);

        require($_DOCMAN->getPath('classes', 'config'));
        $config = new DOCMAN_Config('themeConfig', $path . "themeConfig.php");
        $config->_config = $params;

        return $config->saveConfig();
    }
    /**
    * Custom install method
    *
    * @param int $ The id of the module
    * @param string $ The URL option
    * @param int $ The client id
    */
    function uninstall($id)
    {
        global $database, $mosConfig_absolute_path;
        // Delete directories
        $path = $mosConfig_absolute_path
         . '/components/com_docman/themes/' . $id;

        $id = str_replace('..', '', $id);
        if (trim($id)) {
            if (is_dir($path)) {
                return deldir(mosPathName($path));
            } else {
                $this->setError(4, _DML_DIRNOTEXISTS);
                return false;
            }
        } else {
            $this->setError(4, _DML_TEMPLATEEMPTY);
            return false;
        }
    }
}

/**
*
* @param string $ An existing base path
* @param string $ A path to create from the base path
* @param int $ Directory permissions
* @return boolean True if successful
*/
if ( !function_exists('mosMakePath') )
{
    //Function needed in Mambo 4.5.1
    function mosMakePath($base, $path = '', $mode = 0777)
    {
        // check if dir exists
        if (file_exists($base . $path)) {
            return true;
        }
        $path = str_replace('\\', '/', $path);
        $path = str_replace('//', '/', $path);
        $parts = explode('/', $path);

        $n = count($parts);
        if ($n < 1) {
            return mkdir($base, $mode);
        } else {
            $path = $base;
            for ($i = 0; $i < $n; $i++) {
                $path .= $parts[$i] . '/';
                if (!file_exists($path)) {
                    if (!mkdir($path, $mode)) {
                        return false;
                    }
                }
            }
            return true;
        }
    }
}

function typecast(&$old_object, $new_classname)
{
    if (class_exists($new_classname)) {
        $old_serialized_object = serialize($old_object);
        $old_classname = get_class($old_object);
        $new_serialized_object = 'O:' . strlen($new_classname) . ':"' . $new_classname . '":' .
        substr($old_serialized_object, $old_serialized_object[2] + strlen($old_classname) + 7);
        $old_object = @unserialize($new_serialized_object);
    } else {
        return false;
    }

    return true;
}

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   