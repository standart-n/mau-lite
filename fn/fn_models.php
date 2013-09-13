<?php class fn_models {
var $local="";
function loadModel($name) { $q=&$this->q; $model="";
    $mdl=$this->local.'models/'.$q->folder.'/mdl_'.$name.'.html';	
    if (file_exists($mdl)) { if (fopen($mdl,"r")) {
		$model=file_get_contents($mdl);
	}	}	return $model;
}
function loadTemplate($name) { $q=&$this->q; $tpl="";
    $mdl=$this->local.'templates/'.$q->folder.'/tpl_'.$name.'.php?params='.$params;	
    if (file_exists($mdl)) {
		$tpl=file_get_contents($mdl);
	}	return $tpl;
}
function loadStyle($name) { $q=&$this->q; $style="";
    $css=$this->local."style/".$q->folder."/css_".$name.".css";	
    if (file_exists($css)) {	
		$style='<link href="'.$css.'" rel="stylesheet" type="text/css">';
    }	return $style;
}
function loadScript($name) { $q=&$this->q; $script="";
    $js=$this->local."script/".$q->folder."/js_".$name.".js";
    if (file_exists($js)) {
        $script='<script src="'.$js.'" type="text/javascript"></script>';
    }	return $script;
}

} ?>
