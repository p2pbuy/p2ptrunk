<?php

class Api_HttpClient {
    const METHOD_POST = 1;
    const METHOD_GET = 2;
    
    private $_option = array();
    private $_cookie = array();

    /**
     * 构造函数，传入配置项数组作为参数
     * 
     * @param $option array           
     */
    public function __construct($option = array()) {
        $this->_option = array_merge($this->_option, array_intersect_key($option, $this->_option));
        //$this->_cookie['SUE'] = isset($_COOKIE["SUE"]) ? $_COOKIE["SUE"] : '';
        //$this->_cookie['SUP'] = isset($_COOKIE["SUP"]) ? $_COOKIE["SUP"] : '';
        //$this->_cookie['SUB'] = isset($_COOKIE["SUB"]) ? $_COOKIE["SUB"] : '';
    }

    public function get($url, $args, $options = array()) {
        return $this->_send($url, $args, self::METHOD_GET, array(), $options);
    }

    public function post($url, $args, $file = array(), $options = array()) {
    	return $this->_send($url, $args, self::METHOD_POST, $file, $options);
    }
    
    public function getByMutil($url,$params,$args,$options = array()){
    	$tmp = array();//并发的curl数组
    	//为每条curl添加不同的参数
    	foreach($params as $key=>$value){
    		foreach($value as $k => $v){
    			$tmp[$k][$key] = $v;
    		}
    	}
    	
    	//为每条curl添加相同的参数
   		foreach($tmp as $kk => $vv){
   			foreach($args as $name => $arg){
   				$tmp[$kk][$name] = $arg;
   			}
   		}

		foreach($tmp as $kk => $vv){
			$request = new Comm_HttpRequest($url);
			foreach($vv as $key => $value){
				$request->add_query_field($key, $value);
			}
			// timeout
			if(isset($options['timeout'])){
				$request->set_timeout($options['timeout']);
			}
			//connect_timeout
			if(isset($options['connect_timeout'])){
				$request->set_connect_timeout($options['connect_timeout']);
			}
			if (!empty($this->_option['username']) && !empty($this->_option['password'])) {
				$option = array('httpauth' => $this->_option['username'] . ':' . $this->_option['password'], 'httpauthtype' => HTTP_AUTH_BASIC);
				$request->add_userpsw($this->_option['username'],$this->_option['password']);
			}
			$requestArr[$kk] = $request;
			Comm_HttpRequestPool::attach($request);
		}
		Comm_HttpRequestPool::send();
		foreach($requestArr as $request){
			$data[] = Comm_Util::json_decode ( $request->response_content, true );
		}
		return $data;
    }
    
    private function _send($url, $args, $method = self::METHOD_GET, $file = array(), $options = array(),$urlencode=false) {
    	if ($method == self::METHOD_GET) {
            $request = new Comm_HttpRequest($url);
            $request->set_method("GET");
            foreach($args as $key => $value){
            	$request->add_query_field($key, $value,$urlencode);
            }
            /*if($url == 'http://relation.mobile.mcp.weibo.cn/get_users.php'){
                $option = array('httpauth' => 'relation_visitor_1:9210699591413','httpauthtype' => HTTP_AUTH_BASIC);
                $request->setOptions($option);
            }*/
        } else {
            $request = new Comm_HttpRequest($url);
            $request->set_method("POST");
            foreach($args as $key => $value){
                $request->add_post_field($key, $value,$urlencode);
            }
            if ($file) {
                $request->add_post_file($file['name'], $file['dir']);
            }
        }
        
        // timeout
        if(isset($options['timeout'])){
            $request->set_timeout($options['timeout']);
        }
        if(isset($options['connect_timeout'])){
            $request->set_connect_timeout($options['connect_timeout']);
        }
        if(isset($options['ip'])){
        	$request->set_actual_host($options['ip']);
        }
        // 添加outh的验证cookie
 		foreach($this->_cookie as $key => $value){
            $request->add_cookie($key, $value);
        }
        if (!empty($this->_option['username']) && !empty($this->_option['password'])) {
            $option = array('httpauth' => $this->_option['username'] . ':' . $this->_option['password'], 'httpauthtype' => HTTP_AUTH_BASIC);
            $request->add_userpsw($this->_option['username'],$this->_option['password']);
        }
        // http-referer
        if(isset($options['http_referer'])){
        	$request->set_http_referer($options['http_referer']);
        }
        // 发送请求
        $request->send();
        $response = $request->get_response_content();
        $result = $response;
        
        // 验证返回结果,报错
        if($method == 2){
        	$method = 'GET';
        	$fields = $request->query_fields;
        }else{
        	$method = 'POST';
        	$fields = $request->post_fields;
        }
        $uid = Yaf_Registry::get ( 'uid' );

        if ($request->get_response_info('http_code') != '200') {
            
            //throw new Api_HttpClient_Exception($result ['error'], $result ['error_code'], array($url));
        }
        return $result;
    }
    
}