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
  $Id: paloSantoquotas_user.class.php,v 1.1 2012-05-12 09:05:12 Ivan Zenteno ivan.zenteno@infapen.com Exp $ */
class paloSantoquotas_user{
    var $_DB;
    var $errMs;
    private $_oDB_call_center = NULL;
    private $_oDB_quotas_user = NULL;

    function paloSantoquotas_user(&$pDB)
    {
        // Se recibe como parámetro una referencia a una conexión paloDB
        if (is_object($pDB)) {
            $this->_DB =& $pDB;
            $this->errMsg = $this->_DB->errMsg;
        } else {
            $dsn = (string)$pDB;
            $this->_DB = new paloDB($dsn);

            if (!$this->_DB->connStatus) {
                $this->errMsg = $this->_DB->errMsg;
                // debo llenar alguna variable de error
            } else {
                // debo llenar alguna variable de error
            }
        }
    }

    /*HERE YOUR FUNCTIONS*/

    function getNumquotas_user($filter_field, $filter_value)
    {
        $where    = "";
        $arrParam = null;
        if(isset($filter_field) & $filter_field !=""){
            $where    = "where $filter_field like ?";
            $arrParam = array("$filter_value%");
        }

        $query   = "SELECT COUNT(*) FROM table $where";

        $result=$this->_DB->getFirstRowQuery($query, false, $arrParam);

        if($result==FALSE){
            $this->errMsg = $this->_DB->errMsg;
            return 0;
        }
        return $result[0];
    }

    function getQuotas_user($limit = 40, $offset = 0, $filter_field = NULL, $filter_value = NULL)
    {
	    $oDB = $this->obtenerConexion("quotas_user");
        $where    = "";
        $arrParam = null;
        if(isset($filter_field) & $filter_field !=""){
            $where    = "where $filter_field like ?";
            $arrParam = array("$filter_value%");
        }
        
        $oDB2 = $this->obtenerConexion("call_center");
        $query = "select id, nombre from form";
        $forms = $oDB2->fetchTable($query, true);
        $form = array();
        foreach($forms as $k => $v)
        {
	        $form[$k] = $v;
        }
        
        $query = "
        SELECT qu.form_id AS form_id, qu.status AS status
        FROM quotas_user AS qu
        group by form_id
        $where LIMIT $limit OFFSET $offset";

        $quotas = $oDB->fetchTable($query, true, $arrParam);

        if($quotas == FALSE){
            $this->errMsg = $oDB->errMsg;
            return array();
        }
        
        $quota = array();
                
        $c = 0;
        foreach($quotas as $key => $val)
        {
        	foreach($form as $k => $v)
        	{
        		if($quotas[$c]['form_id'] ==  $v['id'])
        		{
	        		$quota[$c]['form_id'] = $quotas[$c]['form_id'];
	        		$quota[$c]['form_name'] = $v['nombre'];
	        		$quota[$c]['status'] = $quotas[$c]['status'];
        		}
        	}
	        $c++;
        }
        $result = $quota;        
        return $result;
    }

    function getquotas_userById($id)
    {
        $query = "SELECT * FROM quotas_user WHERE form_id=?";
        $oDB = $this->obtenerConexion("quotas_user");
        $result=$oDB->fetchTable($query, true, array("$id"));

        if($result==FALSE){
            $this->errMsg = $oDB->errMsg;
            return null;
        }
        return $result;
    }
    
    function obtenerFormularios($id = 0)
    { 
    	$arrParam = null;
	    $where = "";
    	if($id != 0)
    	{
	    	$where = "WHERE id = {$id}";
    	}
	    $query = "SELECT id AS form_id, nombre FROM form $where";
	    $oDB = $this->obtenerConexion("call_center");	    
	    $rs = $oDB->fetchTable($query, true, $arrParam);
	    if (!is_array($rs)) die('(internal) Cannot list agents - '.$oDB->errMsg);
        $listaFormularios = array();
        foreach ($rs as $tupla) {
            $listaFormularios[$tupla['form_id']] = $tupla['nombre'];
        }
        return $listaFormularios;
    }
    
    private function obtenerConexion($sConn)
    {
    	global $arrConf;
    	switch($sConn)
    	{
        case 'call_center':
            if (!is_null($this->_oDB_call_center)) return $this->_oDB_call_center;
            $sDSN = $arrConf['cadena_dsn'];
            $oDB = new paloDB($sDSN);
            if ($oDB->connStatus) {
                $this->_errMsg = '(internal) Unable to create asterisk DB conn - '.$oDB->errMsg;
                die($this->_errMsg);
            }
            $this->_oDB_asterisk = $oDB;
            return $this->_oDB_asterisk;
            break;

        case 'quotas_user':
            if (!is_null($this->_oDB_quotas_user)) return $this->_oDB_quotas_user;
            $sDSN = $arrConf['dsn_conn_database'];
            $oDB = new paloDB($sDSN);
            if ($oDB->connStatus) {
                $this->_errMsg = '(internal) Unable to create asterisk DB conn - '.$oDB->errMsg;
                die($this->_errMsg);
            }
            $this->_oDB_asterisk = $oDB;
            return $this->_oDB_asterisk;
            break;

    	}
	 	return NULL;   
    }
    
    function saveInfo($arrParam)
    {
        $paramSQL = $arrParam;
        unset($paramSQL['save_new']);
        unset($paramSQL['id']);
        $paramSQL['form_id'] = $paramSQL['customer_id'];
        unset($paramSQL['customer_id']);
        $oDB = $this->obtenerConexion("quotas_user");
        if (!empty($paramSQL))
        {
	        $query = $oDB->construirInsert("quotas_user", $paramSQL);
	        $result = $oDB->genQuery($query);
	        if (!$result) 
	        {
	            $this->errMsg = $oDB->errMsg;
	            return false;
	        }
       	    return true;
	    }
	    return false;
	}
	
	function updateQuota($arrPost)
	{
		$paramSQL = $arrPost;
		$id = $paramSQL['customer_id'];
		unset($paramSQL['customer_id']);
		unset($paramSQL['submit_apply_changes']);
		unset($paramSQL['id']);
		$oDB = $this->obtenerConexion("quotas_user");
		if(!empty($paramSQL))
		{
			$query = $oDB->construirUpdate("quotas_user", $paramSQL, "form_id = $id");
			$result = $oDB->genQuery($query);
			if (!$result)
			{
				$this->errMsg = $oDB->errMsg;
				return false;
			}
			return true;
		}
		return false;
	}
	
	function deleteQuota($arrPost)
	{
		$paramSQL = $arrPost;
		$id = $paramSQL['customer_id'];
		unset($paramSQL['customer_id']);
		unset($paramSQL['delete_quota']);
		unset($paramSQL['id']);
		
		$oDB = $this->obtenerConexion("quotas_user");
		if(!empty($paramSQL))
		{
			$query = "DELETE FROM quotas_user WHERE form_id = ".$id;
			$rs = $oDB->genQuery($query);
			if(!$rs)
			{
				$this->errMsg = $oDB->errMsg;
				return false;
			}
			return true;
		}
		return false;
	}


}
?>