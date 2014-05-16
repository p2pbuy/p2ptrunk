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
        $tpl = empty ( $tpl ) ? $this->tpl : $tpl;
        $data = empty ( $data ) ? $this->tpl_data : $data;
        $data ['g_tpl_css'] = $this->tpl_css;
        $data ['g_tpl_js'] = $this->tpl_js;
        $data ['g_version'] = Tools_Version::getJsVersion ();
        $data ['viewer'] = $this->viewer;
        $view = Yaf_Registry::get ( "view" );
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
        $tpl = empty ( $tpl ) ? $this->tpl : $tpl;
        $data = empty ( $data ) ? $this->tpl_data : $data;
        $data ['g_tpl_css'] = $this->tpl_css;
        $data ['g_tpl_js'] = $this->tpl_js;
        $data ['viewer'] = $this->viewer;
        $view = Yaf_Registry::get ( "view" );
        return $view->render ( $tpl, $data );
    }
    
    /**
     * 直接渲染ajax
     *
     * @return unknown_type
     */
    public function renderAjax($code = 100000, $message = '', $data = NULL) {
        if (! headers_sent ()) {
            // header('Content-type: application/json; charset=utf-8', TRUE);
        }
        $json_string = json_encode ( array ("code" => $code, "msg" => strval ( $message ), "data" => $data ) );
        echo $json_string;
    }
    
    public function render_single_pagelet_plainly(Comm_Bigpipe_Pagelet $pl, $return_string = false){
        $data = $pl->prepare_data();
        $tpl = new Yaf_View_Simple(TPL_PATH);
        $tpl->assign($data);
        $html = $tpl->render($pl->get_template());
    
        if($return_string){
            return $html;
        }else{
            echo $html;
        }
    }
}