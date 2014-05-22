<?php
/**
 * controll抽象类
 */
abstract class AbstractController extends Yaf_Controller_Abstract{
	public function hookAction(){}
	
	/**
	 * 默认程序action
	 * Enter description here ...
	 */
	public function indexAction(){
		$this->hookAction();
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