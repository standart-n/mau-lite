<?php class base {
function getBaseFromSite(&$q) { $q->settings_path="settings/config.ini"; $this->connect($q); $this->getSettings($q); }
function getBaseFromExternal(&$q) { $q->settings_path="../settings/config.ini"; $this->connect($q); $this->getSettings($q); }
function getBaseFromModule(&$q) { $q->settings_path="../../settings/config.ini"; $this->connect($q); $this->getSettings($q); }
function connect(&$q) {
	if (file_exists($q->settings_path)) {
		$q->config_ini=parse_ini_file($q->settings_path,true);
		while (list($option,$line)=each($q->config_ini)) {
			while (list($field,$value)=each($line)) {
				$q->$field=$value; $this->$field=$value;
			}
		}
	}
	$this->getDB($q);
}
function getDB(&$q) {
	if ((isset($q->host)) && (isset($q->login)) && (isset($q->password)) && (isset($q->dbname))) {
		$q->db=mysql_pconnect($q->host,$q->login,$q->password);
		$isok=mysql_select_db($q->dbname,$q->db);
		mysql_query("/*!40101 SET NAMES 'cp1251' */",$q->db);
	}
}
function getSettings(&$q) {
    if ((isset($q->db)) && (isset($q->prefix))) {
       $sql="SELECT * FROM `".$q->prefix."_dataSettings` WHERE (1=1)";
	   $res=mysql_query($sql,$q->db);
       if (isset($res)) { if ($res) {
			while ($row=mysql_fetch_object($res)) {
				if (isset($row->type)) {
					$type=$row->type; $name=$row->name;
					if (isset($row->$type)) {
						$q->$name=$row->$type;
					}
				}
			}
        }	}
    } 
}
function checkFN(&$q,$s,$p="") { $rtn=TRUE;
	foreach (explode("|",$s) as $key) { $fn="fn_".$key;
		if (!isset($q->$fn)) { 
			if (file_exists($p."fn/".$fn.".php")) { 
				include_once($p."fn/".$fn.".php"); 
				if (class_exists($fn)) {
					$q->$fn=new $fn; $q->$fn->q=$q;
				}
			}
		}
		if (!isset($q->$fn)) { $rtn=FALSE; }
	}
	return $rtn;
}
function checkTPL(&$q,$s,$p="") { $rtn=TRUE;
	foreach (explode("|",$s) as $key) { $tpl="tpl_".$key;
		if (!isset($q->$tpl)) { 
			if (file_exists($p."templates/".$q->folder."/".$tpl.".php")) { 
				include_once($p."templates/".$q->folder."/".$tpl.".php"); 
				if (class_exists($tpl)) {
					$q->$tpl=new $tpl; $q->$tpl->q=$q;
				}
			}
		}
		if (!isset($q->$tpl)) { $rtn=FALSE; }
	}
	return $rtn;
}
function alert($msg) { echo $msg; }
} ?>
