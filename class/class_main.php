<?php class main { 
var $fn=array();
var $pl=array();
function engine() {
	$this->q->author="standart-n.ru";
	$task=explode("|","plugins|settings|parsing|url|display");
	foreach ($task as $key) { $f="check_".$key; $this->$f(); }
}
function check_plugins() { $q=&$this->q; $q->pl=array();
	chdir("./plugins"); $dir=opendir(".");
	while ($d=readdir($dir)) {
        if (is_file($d)) { if (preg_match("/pl_[0-9a-z]+\.php/i",$d)) {
			include_once('../plugins/'.$d); $nm=str_replace('.php','',$d);
			if (class_exists($nm)) {
				$this->$nm=new $nm; $q->pl[]=$nm;
			}
		}   }
	}
	closedir($dir); chdir("..");	
}
function check_parsing() {	$q=&$this->q; $p="external/"; $f="simple_html_dom.php";
	if (file_exists($p.$f)) { 
		include_once($p.$f); $q->parsing=new simple_html_dom();
	}
}
function check_settings() { $q=&$this->q;
	if (class_exists("base")) {
		$q->base=new base; $q->base->getBaseFromSite($q);
	}
}
function check_url() { $q=&$this->q; $i=0;
	$GET=explode("|","id|page|category|action|task|node|subnode");
	foreach ($GET as $key) { if (isset($_GET[$key])) { $q->$key=strval(trim($_GET[$key])); } else { $q->$key=""; } }
	if ($q->id=="") { $q->id="0"; }
	if ($q->page=="") { $q->page="main"; }
	if ($q->category=="") { $q->category="page"; }
    for ($i=0;$i<20;$i++) { $level="level".($i+1);
        if (isset($_GET[$level])) { $q->$level=strval(trim($_GET[$level])); $q->level=$q->$level; } else { $q->$level="unset"; }
    }
    if (!isset($q->level)) { $q->level="main"; $q->level1="main"; }
}
function check_display() { $q=&$this->q;
    	asort($q->pl); reset($q->pl);
        foreach ($q->pl as $pl) { $this->$pl->q=$q; $q=$this->$pl->engine(); }
        $_SESSION['q']=$q;
}
} ?>
