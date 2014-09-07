<?php
/**
 * 退出登录
 * @author liang5
 * 2014-5-25
 */
class Login_LogoutController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		//清除cookie
		Tools_Helper::setCookie(array('name'=>'PUCS','value'=>'','expire'=>time()-3600,'path'=>'/','domain'=>Tools_Conf::get('Domain.domain.hostnowww')));
		Tools_Helper::setCookie(array('name'=>'PUCE','value'=>'','expire'=>time()-3600,'path'=>'/','domain'=>Tools_Conf::get('Domain.domain.hostnowww')));
		Tools_Redirect::index();
		return true;
	}
}