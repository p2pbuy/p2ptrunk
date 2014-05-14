<?php
class AuthPlugin extends Yaf_Plugin_Abstract {
    
	public function routerStartup ($request,$response) {
		return true;
	}
	
	public function routerShutdown ($request,$response){
		//var_dump($request,$response);exit;
		return true;
	}
}