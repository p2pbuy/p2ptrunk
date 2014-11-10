<?php
/**
 * 登录提交页面
 * @author liang
 * @version 2014-5-22
 */
class Aj_LoginController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		$info['email'] = Comm_Context::post('email');
		$info['passwd'] = Comm_Context::post('passwd');
		
		$user = Dr_Login::userpwdByApi($info);
		if($user['uid']){
			//$code = Tools_Conf::get('Show_Code.api.succ');
			$userCookie = Dr_Login::createCookieByUid($user['uid']);
			//种cookie
			Tools_Helper::setCookie(array('name'=>'PUCS','value'=>$userCookie['PUCS'],'expire'=>time()+36000,'path'=>'/','domain'=>'.'.Tools_Conf::get('Domain.domain.hostnowww')));
			Tools_Helper::setCookie(array('name'=>'PUCE','value'=>$userCookie['PUCE'],'expire'=>time()+36000,'path'=>'/','domain'=>'.'.Tools_Conf::get('Domain.domain.hostnowww')));
			$code = Tools_Conf::get('Show_Code.api.succ');
			$msg = 'login succ';
			//header('Location:/index');
			//return true;
		}else{
			$code = Tools_Conf::get('Show_Code.api.fail');
			$msg = 'login fail';
		}
		

		$this->renderAjax($code,$msg);
		return true;
	}
}