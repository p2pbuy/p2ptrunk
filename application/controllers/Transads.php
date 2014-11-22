<?php
class TransadsController extends AbstractController{
	public $tpl = 'transads.phtml';
	public $authorize = self::NOTLOGIN;
	public function hookAction(){
		
		$data = array();
		$this->renderPage($this->tpl,$data);
		return true;
	}
}
