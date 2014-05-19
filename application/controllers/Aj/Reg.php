<?php
/**
 * 注册提交页面
 */
class Aj_RegController extends AbstractController{
	public function hookAction(){
		$info['email'] = Comm_Context::get('email');
		$info['nick'] = Comm_Context::get('nick');
		$info['passwd'] = Comm_Context::get('passwd');
		
		$re = Dw_User::regByApi($info);
		var_dump($re);exit;
		return true;
	}
}