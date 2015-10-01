<?php
/*
################################################################################
#                              J! Module Creator                               #
################################################################################
# Class Name: JModuleCreator                                                   #
# File-Release-Date:  2015/09/04                                               #
#==============================================================================#
# Author: Max Stemplevski                                                      #
# Site:                                                                        #
# Twitter: @stemax                                                             #
# Copyright 2014-2015 - All Rights Reserved.                                   #
################################################################################
*/

/* Licence
 * #############################################################################
 * | This program is free software; you can redistribute it and/or             |
 * | modify it under the terms of the GNU General var License                  |
 * | as published by the Free Software Foundation; either version 2            |
 * | of the License, or (at your option) any later version.                    |
 * |                                                                           |
 * | This program is distributed in the hope that it will be useful,           |
 * | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
 * | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the              |
 * | GNU General var License for more details.                                 |
 * |                                                                           |
 * +---------------------------------------------------------------------------+
 */

class JModuleCreator
{

    public $msname = null;
    public $mname = null;
    public $mcreationdate = null;
    public $mversion = null;
    public $mdescr = null;
    public $mauthor = null;
    public $mauthoremail = null;
    public $mauthorurl = null;
    public $mcopyright = null;
    public $mlicense = null;
    public $mhelpername = null;
    public $zipfiles = array();

    function __construct()
    {
        $this->msname = isset($_POST['msname']) ? $_POST['msname'] : '';
        $this->mname = isset($_POST['mname']) ? $_POST['mname'] : '';
        $this->mcreationdate = isset($_POST['mcreationdate']) ? $_POST['mcreationdate'] : '';
        $this->mversion = isset($_POST['mversion']) ? $_POST['mversion'] : '';
        $this->mdescr = isset($_POST['mdescr']) ? $_POST['mdescr'] : '';
        $this->mauthor = isset($_POST['mauthor']) ? $_POST['mauthor'] : '';
        $this->mauthoremail = isset($_POST['mauthoremail']) ? $_POST['mauthoremail'] : '';
        $this->mauthorurl = isset($_POST['mauthorurl']) ? $_POST['mauthorurl'] : '';
        $this->mcopyright = isset($_POST['mcopyright']) ? $_POST['mcopyright'] : '';
        $this->mlicense = isset($_POST['mlicense']) ? $_POST['mlicense'] : '';
        $this->params_names = isset($_POST['params_names']) ? $_POST['params_names'] : '';
        $this->params_labels = isset($_POST['params_labels']) ? $_POST['params_labels'] : '';
        $this->mhelpername = ucfirst(trim(str_replace('_', '', $this->msname))) . 'Helper';
    }

    function generateMainPhp()
    {
        $php_content = array();
        $php_content [] = "<?php";
        $php_content [] = "defined('_JEXEC') or die;";
        $php_content [] = "require_once dirname(__FILE__).'/helper.php';";
        $php_content [] = '//$items = ' . $this->mhelpername . '::getItems($params);';
        $php_content [] = '//if (!count($items)) {return false;}';
        $php_content [] = '$moduleclass_sfx = htmlspecialchars($params->get("moduleclass_sfx"));';
        $php_content [] = 'require JModuleHelper::getLayoutPath("' . $this->msname . '",$params->get("layout", "default"));';
        $php_content [] = '';
        $php_str = implode("\r\n", $php_content);
        return $php_str;
    }

    function generateHelperPhp()
    {
        $php_content = array();
        $php_content [] = "<?php";
        $php_content [] = "defined('_JEXEC') or die;";
        $php_content [] = "class " . $this->mhelpername . " ";
        $php_content [] = '{';
        $php_content [] = 'public static function getItems($params)';
        $php_content [] = '{';
        $php_content [] = '/*$db = JFactory::getDbo();';
        $php_content [] = '$query = $db->getQuery(true);';
        $php_content [] = '$query->select("*");';
        $php_content [] = '$query->from("`#__content`");';
        $php_content [] = '$query->where("`id`<> 1");';
        $php_content [] = '$db->setQuery($query);';
        $php_content [] = 'return = $db->loadObjectList();*/';
        $php_content [] = 'return null;	';
        $php_content [] = '}';
        $php_content [] = '}';
        $php_str = implode("\r\n", $php_content);
        return $php_str;
    }

    function generateXml()
    {
        $xml_content = array();
        $xml_content [] = '<?xml version="1.0" encoding="utf-8"?>';
        $xml_content [] = '<extension type="module"	version="1.6.0"	client="site" method="upgrade">';
        $xml_content [] = '<name>' . $this->mname . '</name>';
        $xml_content [] = '<creationDate>' . $this->mcreationdate . '</creationDate>';
        $xml_content [] = '<author>' . $this->mauthor . '</author>';
        $xml_content [] = '<authorEmail>' . $this->mauthoremail . '</authorEmail>';
        $xml_content [] = '<authorUrl>' . $this->mauthorurl . '</authorUrl>';
        $xml_content [] = '<copyright>' . $this->mcopyright . ' [Generated by SMT JGenerator]</copyright>';
        $xml_content [] = '<license>' . $this->mlicense . '</license>';
        $xml_content [] = '<version>' . $this->mversion . '</version>';
        $xml_content [] = '<description>' . $this->mdescr . '</description>';
        $xml_content [] = '<files>';
        $xml_content [] = '<filename module="' . $this->msname . '">' . $this->msname . '.php</filename>';
        $xml_content [] = '<folder>tmpl</folder>';
        $xml_content [] = '<filename>helper.php</filename>';
        $xml_content [] = '<filename>index.html</filename>';
        $xml_content [] = '<filename>' . $this->msname . '.xml</filename>';
        $xml_content [] = '</files>';
        $xml_content [] = '<languages>
        <language tag="en-GB">language/en-GB/en-GB.' . $this->msname . '.ini</language>
        <language tag="en-GB">language/en-GB/en-GB.' . $this->msname . '.sys.ini</language>
	</languages>';
        if (sizeof($this->params_names)) {
            $xml_content [] = '<config>';
            $xml_content [] = '<fields name="params">';
            $xml_content [] = '<fieldset name="basic">';
            foreach ($this->params_names as $k => $param_name) {
                if ($param_name) {
                    $xml_content [] = '<field name="' . $param_name . '" type="text" default="" label="' . $this->params_labels[$k] . '" description="" />';
                }
            }
            $xml_content [] = '</fieldset>';
            $xml_content [] = '</fields>';
            $xml_content [] = '</config>';
        }

        $xml_content [] = '</extension>';
        $xml_str = implode("\r\n", $xml_content);
        return $xml_str;
    }

    function createFile($filename = '', $content = '')
    {
        $fp = fopen($filename, "w");
        $wresult = fwrite($fp, $content);
        fclose($fp);
        return $filename;
    }

    function addToZip($filename = '')
    {
        $this->zipfiles[] = $filename;
    }

    function createAndSaveZip()
    {
        if (extension_loaded('zip')) {
            $zip = new ZipArchive();
            $zip_name = $this->msname . ".zip";
            if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== TRUE) {
                return false;
            }
            if (sizeof($this->zipfiles))
                foreach ($this->zipfiles as $zfile) {
                    $zip->addFile($zfile);
                }
            $zip->close();
            if (file_exists($zip_name)) {
                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename="' . $zip_name . '"');
                readfile($zip_name);
                unlink($zip_name);

                if (sizeof($this->zipfiles))
                    foreach ($this->zipfiles as $zfile) {
                        unlink($zfile);
                    }
            }
        } else
            return false;
    }

    function generateTmplFolder()
    {
        if (!file_exists("tmpl")) mkdir("tmpl");
        $php_content = array();
        $php_content [] = "<?php";
        $php_content [] = "defined('_JEXEC') or die;";
        $php_content [] = "?>";
        $php_content [] = '<div class="<?php echo $moduleclass_sfx ?>">';
        $php_content [] = "<?php";
        $php_content [] = '/*if (sizeof($items))';
        $php_content [] = '{';
        $php_content [] = '            foreach ($items as $item)';
        $php_content [] = '  {';
        $php_content [] = '        echo "<div>".$item->id."</div>';
        $php_content [] = '  }';
        $php_content [] = '}*/';
        $php_content [] = "?>";
        $php_content [] = "</div>";
        $php_str = implode("\r\n", $php_content);

        $this->addToZip($this->createFile('tmpl/default.php', $php_str));
        $this->addToZip($this->createFile('tmpl/index.html', '<html><body></body></html>'));
    }

    function generateLangFolder()
    {
        if (!file_exists("language")) {
            mkdir("language");
            mkdir("language/en-GB");
        }

        $this->addToZip($this->createFile('language/en-GB/index.html', '<html><body></body></html>'));
        $this->addToZip($this->createFile('language/index.html', '<html><body></body></html>'));
        $this->addToZip($this->createFile('language/en-GB/en-GB.' . $this->msname . '.ini', '; Note : All ini files need to be saved as UTF-8'));
        $this->addToZip($this->createFile('language/en-GB/en-GB.' . $this->msname . '.sys.ini', '; Note : All ini files need to be saved as UTF-8'));
    }

    function deleteTmpFolders()
    {
        if (file_exists("language/en-GB")) rmdir("language/en-GB");
        if (file_exists("language")) rmdir("language");
        if (file_exists("tmpl")) rmdir("tmpl");
    }

    function run()
    {
        if (isset($_POST['msname']) && $_POST['mname']) {
            $this->addToZip($this->createFile($this->msname . '.xml', $this->generateXml()));
            $this->addToZip($this->createFile($this->msname . '.php', $this->generateMainPhp()));
            $this->addToZip($this->createFile('helper.php', $this->generateHelperPhp()));
            $this->addToZip($this->createFile('index.html', '<html><body></body></html>'));
            $this->generateTmplFolder();
            $this->generateLangFolder();
            $this->createAndSaveZip();
            $this->deleteTmpFolders();
        } else {
            $this->showform();
        }
    }

    function showForm()
    {
        ?>
        <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
            <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
            <style>
                .header_3d {
                    color: #fffffc;
                    text-shadow: 0 1px 0 #999, 0 2px 0 #888, 0 3px 0 #777, 0 4px 0 #666, 0 5px 0 #555, 0 6px 0 #444, 0 7px 0 #333, 0 8px 7px #001135;
                }
            </style>
            <script>
                function add_additional_params() {
                    var content = '<div><input type="text" class="form-horizontal" name="params_names[]" placeholder="Param name" value=""/><input type="text" placeholder="Param value" class="form-horizontal" name="params_labels[]" value=""/></div>';
                    jQuery('#additional_params').append(content);
                }
            </script>
            <title>J! Module creator</title>
        </head>
        <body>
        <form method="post" action="index.php" name="subform" class="form"/>
        <div class="jumbotron navbar-form">

            <div class="container">
                <div class="page-header header_3d"><h1>J! module creator:</h1></div>
                <table width="50%" class="table table-striped table-hover">
                    <tr>
                        <td>System name of module:</td>
                        <td><input class="form-control" type="text" value="mod_" name="msname" size="45"/></td>
                    </tr>
                    <tr>
                        <td>Title(Name) of module:</td>
                        <td><input class="form-control" type="text" value="" name="mname" size="45"/></td>
                    </tr>
                    <tr>
                        <td>CreationDate:</td>
                        <td><input class="form-control" type="text" value="<?php echo date('F Y'); ?>"
                                   name="mcreationdate" size="45"/></td>
                    </tr>
                    <tr>
                        <td>Version:</td>
                        <td><input class="form-control" type="text" value="1.0.0" name="mversion" size="45"/></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea class="form-control" name="mdescr"></textarea></td>
                    </tr>
                    <tr>
                        <td>Author:</td>
                        <td><input class="form-control" type="text" value="" name="mauthor" size="45"/></td>
                    </tr>
                    <tr>
                        <td>AuthorEmail:</td>
                        <td><input class="form-control" type="text" value="" name="mauthoremail" size="45"/></td>
                    </tr>
                    <tr>
                        <td>AuthorUrl:</td>
                        <td><input class="form-control" type="text" value="" name="mauthorurl" size="45"/></td>
                    </tr>
                    <tr>
                        <td>Copyright:</td>
                        <td><input class="form-control" type="text" value="Copyright 2010 - 2014. All rights reserved"
                                   name="mcopyright" size="45"/></td>
                    </tr>
                    <tr>
                        <td>License:</td>
                        <td><input class="form-control" type="text" value="GNU" name="mlicense" size="45"/></td>
                    </tr>
                    <tr>
                        <td>
                            J! module params (text):
                        </td>
                        <td>
                            <div>
                                <input type="text" class="form-horizontal" name="params_names[]"
                                       value="moduleclass_sfx"/>
                                <input type="text" class="form-horizontal" name="params_labels[]" value="Module class"/>
                            </div>
                            <div id="additional_params"></div>
                            <button class="btn" onclick="add_additional_params();" type="button">+ Add param</button>
                        </td>
                    </tr>
                </table>
                <button class="btn btn-primary btn-lg" type="submit">Generate new module</button>
            </div>
        </div>
        </form>
        <div class="btn btn-primary btn-xs pull-right " disabled="true">Created by SMT</div>
        </body>
        </html>
    <?php
    }
}

?>
