<?php

namespace XoopsModules\Tdmcreate\Files\User;

use XoopsModules\Tdmcreate;
use XoopsModules\Tdmcreate\Files;

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
 * Class UserPrint.
 */
class UserPrint extends Files\CreateFile
{
    /**
     * @var mixed
     */
    private $uxc = null;

    /**
     * @var string
     */
    private $xc = null;
	
	/**
     * @var string
     */
    private $pc = null;

    /**
     * @public function constructor
     * @param null
     */
    public function __construct()
    {
        parent::__construct();
        $this->xc      = Tdmcreate\Files\CreateXoopsCode::getInstance();
        $this->pc = Tdmcreate\Files\CreatePhpCode::getInstance();
        $this->uxc      = UserXoopsCode::getInstance();
    }

    /**
     * @static function getInstance
     * @param null
     * @return UserPrint
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
     * @public function write
     * @param string $module
     * @param mixed  $table
     * @param string $filename
     */
    public function write($module, $table, $filename)
    {
        $this->setModule($module);
        $this->setTable($table);
        $this->setFileName($filename);
    }

    /**
     * @public function getUserPrint
     * @param string $moduleDirname
     * @param string $language
     *
     * @return string
     */
    public function getUserPrint($moduleDirname, $language)
    {
        $pc               = Tdmcreate\Files\CreatePhpCode::getInstance();
        $stuModuleDirname = mb_strtoupper($moduleDirname);
        $table            = $this->getTable();
        $tableName        = $table->getVar('table_name');
        $tableSoleName    = $table->getVar('table_solename');
        $fields           = $this->getTableFields($table->getVar('table_mid'), $table->getVar('table_id'));
        $fieldId          = '';
        $fieldMain        = '';
        $ucfFieldName     = '';
        foreach (array_keys($fields) as $f) {
            $fieldName   = $fields[$f]->getVar('field_name');
            if ((0 == $f) && (1 == $this->table->getVar('table_autoincrement'))) {
                $fieldId = $fieldName;
            } else {
                if (1 == $fields[$f]->getVar('field_main')) {
                    $fieldMain = $fieldName; // fieldMain = fields parameters main field
                }
            }
            $ucfFieldName = ucfirst($fieldName);
        }
        $ccFieldId      = $this->getCamelCase($fieldId, false, true);
        $stuLpFieldName = mb_strtoupper($ccFieldId);
        $ret            = $pc->getPhpCodeUseNamespace(['Xmf', 'Request'], '', '');
        $ret            .= $pc->getPhpCodeUseNamespace(['XoopsModules', $moduleDirname], '', '');
        $ret            .= $pc->getPhpCodeUseNamespace(['XoopsModules', $moduleDirname, 'Constants']);
        $ret            .= $this->getInclude();
        $ret            .= $this->xc->getXcXoopsRequest($ccFieldId, (string)$fieldId, '', 'Int');
        $ret            .= $this->pc->getPhpCodeCommentLine('Define Stylesheet');
        $ret            .= $this->xc->getXcXoThemeAddStylesheet();
        $redirectHeader = $this->xc->getXcRedirectHeader("{$stuModuleDirname}_URL . '/index.php'", '', '2', "{$language}NO{$stuLpFieldName}", false, "\t");
        $ret            .= $this->pc->getPhpCodeConditions("empty(\${$ccFieldId})", '', '', $redirectHeader);

        $ret            .= $this->pc->getPhpCodeCommentLine('Get Instance of Handler');
        $ret            .= $this->xc->getXcHandlerLine($tableName);

        $ret            .= $this->pc->getPhpCodeCommentLine('Verify that the article is published');
        if (false !== mb_strpos($fieldName, 'published')) {
            $ret            .= $this->pc->getPhpCodeCommentLine('Not yet', $fieldName);
            $redirectHeader .= $this->getSimpleString('exit();');
            $ret            .= $this->pc->getPhpCodeConditions("\${$tableName}Handler->getVar('{$fieldName}') == 0 || \${$tableName}Handler->getVar('{$fieldName}') > time()", '', '', $redirectHeader);
        }
        if (false !== mb_strpos($fieldName, 'expired')) {
            $ret            .= $this->pc->getPhpCodeCommentLine('Expired', $ucfFieldName);
            $redirectHeader .= $this->getSimpleString('exit();');
            $ret            .= $this->pc->getPhpCodeConditions("\${$tableName}Handler->getVar('{$fieldName}') != 0 && \${$tableName}Handler->getVar('{$fieldName}') < time()", '', '', $redirectHeader);
        }
        if (false !== mb_strpos($fieldName, 'date')) {
            $ret            .= $this->pc->getPhpCodeCommentLine('Date', $ucfFieldName);
            $redirectHeader .= $this->getSimpleString('exit();');
            $ret            .= $this->pc->getPhpCodeConditions("\${$tableName}Handler->getVar('{$fieldName}') != 0 && \${$tableName}Handler->getVar('{$fieldName}') < time()", '', '', $redirectHeader);
        }
        if (false !== mb_strpos($fieldName, 'time')) {
            $ret            .= $this->pc->getPhpCodeCommentLine('Time', $ucfFieldName);
            $redirectHeader .= $this->getSimpleString('exit();');
            $ret            .= $this->pc->getPhpCodeConditions("\${$tableName}Handler->getVar('{$fieldName}') != 0 && \${$tableName}Handler->getVar('{$fieldName}') < time()", '', '', $redirectHeader);
        }
        $ret            .= $this->xc->getXcHandlerGet($tableName, $ccFieldId, '', $tableName . 'Handler',false);
        $gperm          = $this->xc->getXcCheckRight('!$grouppermHandler', "{$moduleDirname}_view", "\${$ccFieldId}->getVar('{$fieldId}')", '$groups', "\$GLOBALS['xoopsModule']->getVar('mid')", true);
        $ret            .= $this->pc->getPhpCodeCommentLine('Verify permissions');
        $noPerm         = $this->xc->getXcRedirectHeader("{$stuModuleDirname}_URL . '/index.php'", '', '3', '_NOPERM', false, "\t");
        $noPerm         .= $this->getSimpleString('exit();', "\t");
        $ret            .= $this->pc->getPhpCodeConditions($gperm, '', '', $noPerm);
        $ret            .= $this->xc->getXcGetValues($tableName, $tableSoleName, '', true);
        $contentForeach = $this->xc->getXcXoopsTplAppend('"{$k}"', '$v', "\t");
        $ret            .= $this->pc->getPhpCodeForeach($tableSoleName, false, 'k', 'v', $contentForeach);
        $ret            .= $this->xc->getXcXoopsTplAssign('xoops_sitename', "\$GLOBALS['xoopsConfig']['sitename']");
        $getVar         = $this->xc->getXcGetVar('', $tableSoleName, $fieldMain, true);
        $stripTags      = $this->pc->getPhpCodeStripTags('', $getVar . ' - ' . "{$language}PRINT" . ' - ' . "\$GLOBALS['xoopsModule']->name()", true);
        $ret            .= $this->xc->getXcXoopsTplAssign('xoops_pagetitle', $stripTags);
        $ret            .= $this->xc->getXcXoopsTplDisplay($tableName . '_print.tpl', '', false);

        return $ret;
    }

    /**
     * @public function render
     * @param null
     * @return bool|string
     */
    public function render()
    {
        $module        = $this->getModule();
        $filename      = $this->getFileName();
        $moduleDirname = $module->getVar('mod_dirname');
        $language      = $this->getLanguage($moduleDirname, 'MA');
        $content       = $this->getHeaderFilesComments($module);
        $content       .= $this->getUserPrint($moduleDirname, $language);

        $this->create($moduleDirname, '/', $filename, $content, _AM_TDMCREATE_FILE_CREATED, _AM_TDMCREATE_FILE_NOTCREATED);

        return $this->renderFile();
    }
}
