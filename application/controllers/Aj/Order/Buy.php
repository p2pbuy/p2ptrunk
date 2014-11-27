<?php
/**
 * 买家订单处理页面
 * @author liang
 * @version 2014-5-25
 */
class Aj_Order_BuyController extends AbstractController{
	public $authorize = self::MAYBELOGIN;
	public function hookAction(){
		/*if($this->viewer['extends']['type'] != 1){
			$this->renderAjax(Tools_Conf::get('Show_Code.api.fail'),'You must be a buyer');
			return true;
		}*/
		$info['title'] = Comm_Context::post('title');
		$info['description'] = Comm_Context::post('description');
		$info['price'] = Comm_Context::post('price') ? Comm_Context::post('price') : 0;
		$info['quantity'] = Comm_Context::post('quantity');
		$info['additional'] = Comm_Context::post('additional');
		$info['img'] = Comm_Context::post('img');
		$info['thirdurl'] = Comm_Context::post('thirdurl');
		$info['uid'] = $this->uid;
		
		if(empty($info['uid'])){
			$result['code'] = Tools_Conf::get('Show_Code.aj.unlogin.fail');
			$data = '0';
			
			echo "<script>window.". $_POST['cbkname'] ."={'code':{$result['code']},'data':{$data}}</script>";
			return true;
		}
		
		if(empty($info['quantity'])){
			$result['code'] = Tools_Conf::get('Show_Code.aj.fail');
			$data = '0';
		}else{
			if(!empty($_FILES['file']['type']) && !empty($_FILES['file']['tmp_name']) && $_FILES['file']['size'] > 0){
				//上传图片
				$fileInfo = $_FILES;
				$fileInfo['filename'] = time().substr(md5(rand(0,99999)), 6, 8);
				$uploadFile = Dw_Upload::uploadImg($fileInfo);
				if($uploadFile['code'] != Tools_Conf::get('Show_Code.aj.succ')){
					echo "<script>window.". $_POST['cbkname'] ."={'code':{$uploadFile['code']},'msg':'{$uploadFile['msg']}','data':0}</script>";
					return true;
				}
			}
			
			//创建订单
			if($uploadFile['code'] == Tools_Conf::get('Show_Code.api.succ')){
				$info['img'] = $uploadFile['data']['imgurl'];
			}
			$result = Dw_Order::createBuyOrderByApi($info);
			
			$result['code'] = $result['code'];
			$data = ($result['data']) ? $result['data'] : '0';
			$data = json_encode($data);
		}
		
		//发送邮件
		$mail = new Tools_Mail();
		$mail->IsSMTP();
		//开启调试模式
		//$mail->SMTPDebug = true;
		//$mail->Timeout = 10;
		$mail->SMTPAuth = true;
		$mail->From = 'service@p2pbuy.net';
		$mail->FromName = 'service';
		$mail->IsHTML(true);
		$mail->Body = '订单号：'.$result['data']['boid'].'</br>'.'商品URL：'.$info['thirdurl'];
		$mail->ClearAddresses();
		$mail->AddAddress('leoncui57@hotmail.com');
		$mail->Subject = $this->viewer['nick'].'下单了';
		$mail->Send();
		echo "<script>window.". $_POST['cbkname'] ."={'code':{$result['code']},'data':{$data}}</script>";
		return true;
	}
}