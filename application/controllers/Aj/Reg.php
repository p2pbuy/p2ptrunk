<?php
/**
 * 注册提交页面
 */
class Aj_RegController extends AbstractController{
	public function hookAction(){
		$info['email'] = Comm_Context::post('email');
		$info['nick'] = Comm_Context::post('nick');
		$info['passwd'] = Comm_Context::post('passwd');
		
		$result = Dw_User::regByApi($info);
		$this->renderAjax($result['code']);
		return true;
	}
}