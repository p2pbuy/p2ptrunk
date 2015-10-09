<?php
/**
 * 删除SKU
 * @author liang
 * @version 2015-10-8
 */
class Aj_Sku_DelSkuController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		//如果不是管理员，返回false
		if($this->viewer['uid'] != Tools_Conf::get('Manager.uid')){
			$code = Tools_Conf::get('Show_Code.aj.fail');
			$msg = 'you are not manager';
			$this->renderAjax($code,$msg);
			return false;
		}

		$id = Comm_Context::post('id');
		
		if(empty($id)){
			return false;
		}
		
		$data['id'] = $id;
		
		$re = Dw_Sku::delSkuByApi($data);
		
		if($re == false){
			$code = Tools_Conf::get('Show_Code.aj.fail');
			$msg = 'fail';
		}else{
			$code = Tools_Conf::get('Show_Code.aj.succ');
			$msg = 'succ';
		}
		
		$this->renderAjax($code,$msg);
		
		return true;
	}
}