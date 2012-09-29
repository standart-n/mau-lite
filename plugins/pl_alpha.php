<?php class pl_alpha {
function engine() { $q=&$this->q;
	if ($q->base->checkFN($q,"models")) {
		$q->html=$q->fn_models->loadModel('alpha');
	}
	return $q;
}
} ?>
