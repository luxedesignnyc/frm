<?xml version="1.0"?>
<mosinstall type="module">
	<name>Unapproved Documents - admin module</name>
	<creationDate>February 2009</creationDate>
	<author>Joomlatools</author>
	<copyright>This module is released under the GNU/GPL License</copyright>
	<authorEmail>support@joomlatools.eu</authorEmail>
	<authorUrl>www.joomlatools.eu</authorUrl>
	<version>1.4.0</version>
	<description>Shows the latest unapproved documents in the DOCman admin control panel</description>
	<files>
		<filename module="mod_docman_approval">mod_docman_approval.php</filename>
	</files>
	<params>
		<param name="limit" type="text" default="10" label="Limit" description="The number of documents to display (default 10)" />
	</params>
</mosinstall>