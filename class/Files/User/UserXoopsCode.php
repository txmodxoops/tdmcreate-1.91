<?php

namespace XoopsModules\Tdmcreate\Files\User;

use XoopsModules\Tdmcreate;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * tdmcreate module.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 *
 * @since           2.5.0
 *
 * @author          Txmod Xoops http://www.txmodxoops.org
 *
 */

/**
 * Class UserXoopsCode.
 */
class UserXoopsCode
{
    /*
    *  @static function getInstance
    *  @param null
    */

    /**
     * @return UserXoopsCode
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * @public function getUserTplMain
     *
     * @param        $moduleDirname
     * @param string $tableName
     *
     * @return string
     */
    public function getUserTplMain($moduleDirname, $tableName = 'index')
    {
        return "\$GLOBALS['xoopsOption']['template_main'] = '{$moduleDirname}_{$tableName}.tpl';\n";
    }

    /**
     * @public function getUserAddMeta
     *
     * @param string $type
     * @param        $language
     * @param        $tableName
     *
     * @param string $t
     * @return string
     */
    public function getUserAddMeta($type, $language, $tableName, $t = '')
    {
        $pCodeAddMeta = Tdmcreate\Files\CreatePhpCode::getInstance();
        $stuTableName = mb_strtoupper($tableName);
        $stripTags    = $pCodeAddMeta->getPhpCodeStripTags('', $language . $stuTableName, true);

        return "{$t}\$GLOBALS['xoTheme']->addMeta( 'meta', '{$type}', {$stripTags});\n";
    }

    /**
     * @public function getUserMetaKeywords
     *
     * @param $moduleDirname
     *
     * @return string
     */
    public function getUserMetaKeywords($moduleDirname)
    {
        $pCodeMetaKeywords = Tdmcreate\Files\CreatePhpCode::getInstance();
        $implode           = $pCodeMetaKeywords->getPhpCodeImplode(',', '$keywords');

        return "{$moduleDirname}MetaKeywords(\${$moduleDirname}->getConfig('keywords').', '. {$implode});\n";
    }

    /**
     * @public function getUserMetaDesc
     *
     * @param        $moduleDirname
     * @param        $language
     * @param string $file
     *
     * @return string
     */
    public function getUserMetaDesc($moduleDirname, $language, $file = 'INDEX')
    {
        return "{$moduleDirname}MetaDescription({$language}{$file}_DESC);\n";
    }

    /**
     * @public function getUserBreadcrumbs
     *
     * @param        $language
     * @param string $tableName
     * @param string $t
     *
     * @return string
     */
    public function getUserBreadcrumbs($language, $tableName = 'index', $t = '')
    {
        $stuTableName     = mb_strtoupper($tableName);
        $title            = ["'title'" => "{$language}{$stuTableName}"];
        $pCodeBreadcrumbs = Tdmcreate\Files\CreatePhpCode::getInstance();

        return $pCodeBreadcrumbs->getPhpCodeArray('xoBreadcrumbs[]', $title, false, $t);
    }

    /**
     * @public function getUserBreadcrumbs
     *
     * @param $moduleDirname
     *
     * @param $language
     * @return string
     */
    public function getUserBreadcrumbsHeaderFile($moduleDirname, $language)
    {
        $pCodeHeaderFile  = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xCodeHeaderFile  = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $stuModuleDirname = mb_strtoupper($moduleDirname);
        $ret              = $pCodeHeaderFile->getPhpCodeCommentLine('Breadcrumbs');
        $ret              .= $pCodeHeaderFile->getPhpCodeArray('xoBreadcrumbs', null, false, '');
        $titleLink        = ["'title'" => $language . 'TITLE', "'link'" => "{$stuModuleDirname}_URL . '/'"];
        $ret              .= $pCodeHeaderFile->getPhpCodeArray('xoBreadcrumbs[]', $titleLink, false, '');

        return $ret;
    }

    /**
     * @public function getUserBreadcrumbs
     *
     * @return string
     */
    public function getUserBreadcrumbsFooterFile()
    {
        $pCodeFooterFile = Tdmcreate\Files\CreatePhpCode::getInstance();
        $xCodeFooterFile = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $cond            = $xCodeFooterFile->getXcTplAssign('xoBreadcrumbs', '$xoBreadcrumbs');
        $ret             = $pCodeFooterFile->getPhpCodeConditions('count($xoBreadcrumbs)', ' > ', '1', $cond, false, "\t\t");

        return $ret;
    }

    /**
     * @public function getUserModVersion
     *
     * @param int    $eleArray
     * @param        $descriptions
     * @param null   $name
     * @param null   $index
     * @param bool   $num
     * @param string $t
     *
     * @return string
     */
    public function getUserModVersion($eleArray, $descriptions, $name = null, $index = null, $num = false, $t = '')
    {
        $ret = '';
        $mv  = $t . '$modversion';
        if (!is_array($descriptions)) {
            $descs = [$descriptions];
        } else {
            $descs = $descriptions;
        }
        foreach ($descs as $key => $desc) {
            $one = (null === $name) ? $key : $name;
            $two = (null === $index) ? $key : $index;
            if (1 === $eleArray) {
                $ret .= $mv . "['{$one}'] = {$desc};\n";
            } elseif (2 === $eleArray) {
                $ret .= $mv . "['{$one}'][{$two}] = {$desc};\n";
            } elseif (3 === $eleArray) {
                $ret .= $mv . "['{$one}'][{$two}]['{$key}'] = {$desc};\n";
            } elseif (4 === $eleArray) {
                $ret .= $mv . "['{$one}'][{$two}][{$num}]['{$key}'] = {$desc};\n";
            }
        }

        return $ret;
    }
}