<?php
/**
 * controll抽象类
 */
abstract class AbstractController extends Yaf_Controller_Abstract{
	// 登录状态
    const MUSTLOGIN = 0;
    // 未登录状态
    const NOTLOGIN = 1;
    // 无状态
    const MAYBELOGIN = 2;
    public $authorize = self::MUST_LOGIN;
    public $uid = null;
    public $viewer = array();
	public function hookAction(){}
	
	/**
	 * 默认程序action
	 * Enter description here ...
	 */
	public function indexAction(){
		$this->initViewer();
		$this->hookAction();
		return true;
	}
	
	/**
	 * 初始化viewer
	 */
	public function initViewer(){
		if ($this->authorize === self::NOTLOGIN || $this->authorize === self::MAYBELOGIN) {
            $viewerRequire = FALSE;
        } else {
            $viewerRequire = TRUE;
        }
        
        $isLogined = Dr_Login::isLogined();
        
        if($viewerRequire && !$isLogined){
        	Tools_Redirect::login_login();
        	return true;
        }
        
        $this->uid = Dr_User::getUidByCookie();
        $viewer = Dr_User::show($this->uid);
        $this->viewer = $viewer[$this->uid];

        return true;
	}
	
    /**
     * 直接渲染模板
     *
     * @param
     *            $tpl
     * @param
     *            $data
     * @return unknown_type
     */
    public function renderPage($tpl = '', $data = array()) {
    	$data['domain'] = Tools_Conf::get('Domain.domain');
    	$data['viewer'] = $this->viewer;
		$view = new Yaf_View_Simple(TPL_PATH);
        echo $view->render ( $tpl, $data );
    }
    
    /**
     * 返回模板html
     *
     * @param
     *            $tpl
     * @param
     *            $data
     * @return unknown_type
     */
    public function renderHtml($tpl = '', $data = array()) {
        $view = new Yaf_View_Simple(TPL_PATH);
        return $view->render ( $tpl, $data );
    }
    
    /**
     * 直接渲染ajax
     *
     * @return unknown_type
     */
    public function renderAjax($code = 100000, $message = '', $data = NULL) {
        $json_string = json_encode ( array ("code" => $code, "msg" => strval ( $message ), "data" => $data ) );
        echo $json_string;
    }
}