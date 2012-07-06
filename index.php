<?php
  /* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
  Codificación: UTF-8
  +----------------------------------------------------------------------+
  | Elastix version 2.3.0-6                                               |
  | http://www.elastix.org                                               |
  +----------------------------------------------------------------------+
  | Copyright (c) 2006 Palosanto Solutions S. A.                         |
  +----------------------------------------------------------------------+
  | Cdla. Nueva Kennedy Calle E 222 y 9na. Este                          |
  | Telfs. 2283-268, 2294-440, 2284-356                                  |
  | Guayaquil - Ecuador                                                  |
  | http://www.palosanto.com                                             |
  +----------------------------------------------------------------------+
  | The contents of this file are subject to the General Public License  |
  | (GPL) Version 2 (the "License"); you may not use this file except in |
  | compliance with the License. You may obtain a copy of the License at |
  | http://www.opensource.org/licenses/gpl-license.php                   |
  |                                                                      |
  | Software distributed under the License is distributed on an "AS IS"  |
  | basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See  |
  | the License for the specific language governing rights and           |
  | limitations under the License.                                       |
  +----------------------------------------------------------------------+
  | The Original Code is: Elastix Open Source.                           |
  | The Initial Developer of the Original Code is PaloSanto Solutions    |
  +----------------------------------------------------------------------+
  $Id: index.php,v 1.1 2012-05-12 09:05:11 Ivan Zenteno ivan.zenteno@infapen.com Exp $ */
//include elastix framework
include_once "libs/paloSantoGrid.class.php";
include_once "libs/paloSantoForm.class.php";

function _moduleContent(&$smarty, $module_name)
{
    //include module files
    include_once "modules/$module_name/configs/default.conf.php";
    include_once "modules/$module_name/libs/paloSantoquotas_user.class.php";

    //include file language agree to elastix configuration
    //if file language not exists, then include language by default (en)
    $lang=get_language();
    $base_dir=dirname($_SERVER['SCRIPT_FILENAME']);
    $lang_file="modules/$module_name/lang/$lang.lang";
    if (file_exists("$base_dir/$lang_file")) include_once "$lang_file";
    else include_once "modules/$module_name/lang/en.lang";

    //global variables
    global $arrConf;
    global $arrConfModule;
    global $arrLang;
    global $arrLangModule;
    $arrConf = array_merge($arrConf,$arrConfModule);
    $arrLang = array_merge($arrLang,$arrLangModule);

    //folder path for custom templates
    $templates_dir=(isset($arrConf['templates_dir']))?$arrConf['templates_dir']:'themes';
    $local_templates_dir="$base_dir/modules/$module_name/".$templates_dir.'/'.$arrConf['theme'];

    //conexion resource
    //$pDB = new paloDB($arrConf['dsn_conn_database']);
    $pDB = "";


    //actions
    $action = getAction();
    $content = "";

    switch($action){
        case "save_new":
            $content = saveNewquotas_user($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);
            break;
        default: // view_form
            $content = viewFormquotas_user($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);
            break;
    }
    return $content;
}

function viewFormquotas_user($smarty, $module_name, $local_templates_dir, &$pDB, $arrConf)
{
    $pquotas_user = new paloSantoquotas_user($pDB);
    $arrFormquotas_user = createFieldForm();
    $oForm = new paloForm($smarty,$arrFormquotas_user);

    //begin, Form data persistence to errors and other events.
    $_DATA  = $_POST;
    $action = getParameter("action");
    $id     = getParameter("id");
    $smarty->assign("ID", $id); //persistence id with input hidden in tpl
        
    if($action=="view")
        $oForm->setViewMode();
    else if($action=="view_edit" || getParameter("save_edit"))
        $oForm->setEditMode();
    //end, Form data persistence to errors and other events.

    if($action=="view" || $action=="view_edit"){ // the action is to view or view_edit.
        $dataquotas_user = $pquotas_user->getquotas_userById($id);
        if(is_array($dataquotas_user) & count($dataquotas_user)>0)
            $_DATA = $dataquotas_user;
        else{
            $smarty->assign("mb_title", _tr("Error get Data"));
            $smarty->assign("mb_message", $pquotas_user->errMsg);
        }
    }

    $formularios = $pquotas_user->obtenerFormularios();

    $smarty->assign("SAVE", _tr("Save"));
    $smarty->assign("EDIT", _tr("Edit"));
    $smarty->assign("CANCEL", _tr("Cancel"));
    $smarty->assign("REQUIRED_FIELD", _tr("Required field"));
    $smarty->assign("icon", "images/list.png");
    $smarty->assign("FORMULARIOS", $formularios);
    

    $htmlForm = $oForm->fetchForm("$local_templates_dir/form.tpl",_tr("quotas_user"), $_DATA);
    $content = "<form  method='POST' style='margin-bottom:0;' action='?menu=$module_name'>".$htmlForm."</form>";

    return $content;
}

function saveNewquotas_user($smarty, $module_name, $local_templates_dir, &$pDB, $arrConf)
{
    $pquotas_user = new paloSantoquotas_user($pDB);
    $arrFormquotas_user = createFieldForm();
    $oForm = new paloForm($smarty,$arrFormquotas_user);

    if(!$oForm->validateForm($_POST)){
        // Validation basic, not empty and VALIDATION_TYPE 
        $smarty->assign("mb_title", _tr("Validation Error"));
        $arrErrores = $oForm->arrErroresValidacion;
        $strErrorMsg = "<b>"._tr("The following fields contain errors").":</b><br/>";
        if(is_array($arrErrores) && count($arrErrores) > 0){
            foreach($arrErrores as $k=>$v)
                $strErrorMsg .= "$k, ";
        }
        $smarty->assign("mb_message", $strErrorMsg);
        $content = viewFormquotas_user($smarty, $module_name, $local_templates_dir, $pDB, $arrConf);
    }
    else{
        //NO ERROR, HERE IMPLEMENTATION OF SAVE
        $content = "Code to save yet undefined.";


        exit(0);
    }
    return $content;
}

function createFieldForm()
{
    $arrFields = array(

            "1h"   => array(     	"LABEL"                  => _tr("18-24"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "1m"   => array(      	"LABEL"                  => _tr("18-24"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "2h"   => array(      "LABEL"                  => _tr("25-32"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "2m"   => array(      "LABEL"                  => _tr("25-32"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "3h"   => array(     "LABEL"                  => _tr("33-40"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),                                            
            "3m"   => array(     "LABEL"                  => _tr("33-40"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),                                            
            "4h"   => array(      "LABEL"                  => _tr("41-53"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "4m"   => array(     "LABEL"                  => _tr("41-53"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "5h"   => array( "LABEL"                  => _tr("54 y más"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "5m"   => array( "LABEL"                  => _tr("54 y más"),
                                            "REQUIRED"               => "yes",
                                            "INPUT_TYPE"             => "TEXT",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            "VALIDATION_TYPE"        => "text",
                                            "VALIDATION_EXTRA_PARAM" => ""
                                            ),
            "input_formulario" 	=>	array(	"LABEL"				=>	_tr("Formulario"),
            								"REQUIRED"				=>	"yes",
            								"INPUT_TYPE"			=>	"SELECT",
            								"VALIDATION_TYPE"		=> "numeric",
                                            "VALIDATION_EXTRA_PARAM" => "",
                                            "INPUT_EXTRA_PARAM"      => "",
                                            )
            );
    return $arrFields;
}

function getAction()
{
    if(getParameter("save_new")) //Get parameter by POST (submit)
        return "save_new";
    else if(getParameter("save_edit"))
        return "save_edit";
    else if(getParameter("delete")) 
        return "delete";
    else if(getParameter("new_open")) 
        return "view_form";
    else if(getParameter("action")=="view")      //Get parameter by GET (command pattern, links)
        return "view_form";
    else if(getParameter("action")=="view_edit")
        return "view_form";
    else
        return "report"; //cancel
}
?>