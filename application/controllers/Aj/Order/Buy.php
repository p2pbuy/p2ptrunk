<?php
/**
 * 买家订单处理页面
 * @author liang5
 * @version 2014-5-25
 */
class Aj_Order_BuyController extends AbstractController{
	public $authorize = self::MUSTLOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			$this->renderAjax(Tools_Conf::get('Show_Code.api.fail'),'You must be a buyer');
			return true;
		}*/
		$info['title'] = Comm_Context::post('title');
		$info['description'] = Comm_Context::post('description');
		$info['price'] = Comm_Context::post('price');
		$info['quantity'] = Comm_Context::post('quantity');
		$info['additional'] = Comm_Context::post('additional');
		$info['uid'] = $this->uid;
		
		if(empty($info['title']) || empty($info['description']) || empty($info['price']) || empty($info['quantity']) || empty($info['uid'])){
			$result['code'] = Tools_Conf::get('Show_Code.aj.fail');
			$data = '0';
		}else{
			//上传图片
			$fileInfo = $_FILES;
			$fileInfo['filename'] = time().substr(md5(rand(0,99999)), 6, 8);
			$uploadFile = Dw_Upload::uploadImg($fileInfo);
			if($uploadFile['code'] != Tools_Conf::get('Show_Code.aj.succ')){
				echo "<script>window.". $_POST['cbkname'] ."={'code':{$uploadFile['code']},'msg':'{$uploadFile['msg']}','data':0}</script>";
				return true;
			}
			
			//创建订单
			if($uploadFile['code'] == Tools_Conf::get('Show_Code.api.succ')){
				$info['img'] = $uploadFile['data']['imgurl'];
			}
			$result = Dw_Order::createBuyOrderByApi($info);
			
			$result['code'] = Tools_Conf::get('Show_Code.aj.succ');
			$data = ($result['data']) ? $result['data'] : '0';
		}
		
		echo "<script>window.". $_POST['cbkname'] ."={'code':{$result['code']},'data':{$data}}</script>";
		return true;
	}
}