<?php
class IndexController extends AbstractController{
	public $tpl = 'index.phtml';
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		
		$data = array();
		$this->renderPage($this->tpl,$data);
		return true;
	}
}
