<?php
class IndexController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		var_dump($this->uid,$this->viewer);
		return true;
	}
}
