<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * My Module 2 module for xoops
 *
 * @copyright     2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        mymodule2
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         TDM XOOPS - Email:<info@email.com> - Website:<http://xoops.org>
 */

$moduleDirName  = basename(dirname(__DIR__));
$moduleDirNameUpper  = mb_strtoupper($moduleDirName);
return (object)[
	'name'           => mb_strtoupper($moduleDirName) . ' Module Configurator',
	'paths'          => [
		'dirname'    => $moduleDirName,
		'admin'      => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/admin',
		'modPath'    => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName,
		'modUrl'     => XOOPS_URL . '/modules/' . $moduleDirName,
		'uploadPath' => XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
		'uploadUrl'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName,
	],
	'uploadFolders'  => [
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/categories',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/articles',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/testfields',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/categories',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/articles',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/testfields',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/files',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/files/categories',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/files/articles',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/files/testfields',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/temp',
	],
	'copyBlankFiles'  => [
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/categories',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/articles',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images/testfields',
	],
	'copyTestFolders'  => [
		XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/testdata/uploads',
		XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
	],
	'templateFolders'  => [
		'/templates/',
	],
	'oldFiles'  => [
	],
	'oldFolders'  => [
	],
	'renameTables'  => [
	],
	'moduleStats'  => [
	],
	'modCopyright' => "<a href='https://xoops.org' title='XOOPS Project' target='_blank'><img src='" . XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/assets/images/logo/logoModule.png' alt='XOOPS Project'></a>",
];