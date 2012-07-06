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

    function getquotas_user($limit, $offset, $filter_field, $filter_value)
    {
        $where    = "";
        $arrParam = null;
        if(isset($filter_field) & $filter_field !=""){
            $where    = "where $filter_field like ?";
            $arrParam = array("$filter_value%");
        }

        $query   = "SELECT * FROM table $where LIMIT $limit OFFSET $offset";

        $result=$this->_DB->fetchTable($query, true, $arrParam);

        if($result==FALSE){
            $this->errMsg = $this->_DB->errMsg;
            return array();
        }
        return $result;
    }

    function getquotas_userById($id)
    {
        $query = "SELECT * FROM table WHERE id=?";

        $result=$this->_DB->getFirstRowQuery($query, true, array("$id"));

        if($result==FALSE){
            $this->errMsg = $this->_DB->errMsg;
            return null;
        }
        return $result;
    }
    
    function obtenerFormularios()
    {
    	$arrParam = null;
	    $query = "SELECT id, nombre FROM form";
	    $oDB = $this->obtenerConexion("call_center");
	    
	    $rs = $oDB->fetchTable($query, true, $arrParam);
	    if (!is_array($rs)) die('(internal) Cannot list agents - '.$oDB->errMsg);
        $listaFormularios = array();
        foreach ($rs as $tupla) {
            $listaFormularios[$tupla['id']] = $tupla['nombre'];
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
        $_DATA  = $_POST;
        unset($_DATA['save_new']);
        unset($_DATA['id']);
        $query_value = 'INSERT INTO quotas_user (form_id, sex_id, quotas_user_range_id, value) VALUES ';
        $query_value .= "{$_DATA['input_formulario']}, ";
        switch($_DATA){
		    case '1h':
		    			$query_value .= "1, ";
		    			$query_value .= $_DATA['1h'];
		    			break;
		    case '1m':
		    			$query_value .= $_DATA['1h'];
		    			break;        
		    case '2h':
		    			$query_value .= $_DATA['2h'];
		    			break;
		    case '2m':
		    			$query_value .= $_DATA['2m'];
		    			break;
		    case '3h':
		    			$query_value .= $_DATA['3h'];
		    			break;
		    case '3m':
		    			$query_value .= $_DATA['3m'];
		    			break;
		    case '4h':
		    			$query_value .= $_DATA['4h'];
		    			break;
		    case '4m':
		    			$query_value .= $_DATA['4m'];
		    			break;
		    case '5h':
		    			$query_value .= $_DATA['5h'];
		    			break;
		    case '5m':
		    			$query_value .= $_DATA['5m'];
		    			break;
		}
		
		$oD    
    }
}
?>