<?php

class Cache_Memcached extends Memcached implements Cache_Interface{

	/* (non-PHPdoc)
	 * @see Comm_Cache_Interface::configure()
	*/
	public function configure($config){
		if(is_string($config) && isset($_SERVER[$config])){
			$config = explode(' ', $_SERVER[$config]);
		}elseif (is_array($config)){//no need to do
		}else {
			throw new Exception('Config should be an array of "addr:port"s or a name of $_SERVER param');
		}
		foreach ($config as $server){
			list($addr, $port) = explode(':', $server, 2);
			$this->addServer($addr, $port);
		}

		$this->setOption(Memcached::OPT_NO_BLOCK, true);
		$this->setOption(Memcached::OPT_CONNECT_TIMEOUT, 200);
		$this->setOption(Memcached::OPT_POLL_TIMEOUT, 50);
	}

	/* (non-PHPdoc)
	 * @see Comm_Cache_Interface::get()
	*/
	public function get($key, $expire = 60) {
		if (empty($key)) {
			return false;
		}
		$result = parent::get($key);
		if ($result === false) {
			$result_code = $this->getResultCode();
			if ($result_code != Memcached::RES_SUCCESS && $result_code != Memcached::RES_NOTFOUND) {
				$params = array('act'=>'get','key'=>$key,'MCcode'=>parent::getResultCode(), 'MCmessage' => parent::getResultMessage());
				return false;
			}
		}
		return $result;
	}

	/* (non-PHPdoc)
	 * @see Comm_Cache_Interface::set()
	*/
	public function set($key, $value, $expire = 60){
		if (empty($key)) {
			return false;
		}
		$ret = parent::set($key, $value, $expire);
		if ($ret === false) {
			$ret = parent::set($key, $value, $expire);
			if ($ret === false) {
				$params = array('act'=>'set','key'=>$key,'MCcode'=>parent::getResultCode(), 'MCmessage' => parent::getResultMessage());
				return false;
			}
		}
		return true;
	}

	/* (non-PHPdoc)
	 * @see Comm_Cache_Interface::del()
	*/
	public function del($key){
		if (empty($key)) {
			return false;
		}
		$ret = parent::delete($key);
		if (false === $ret) {
			$result_code = $this->getResultCode();
			if ($result_code != Memcached::RES_SUCCESS && $result_code != Memcached::RES_NOTFOUND) {
				$ret = parent::delete($key);
				if ($ret === false) {
					$result_code = $this->getResultCode();
					if ($result_code != Memcached::RES_SUCCESS && $result_code != Memcached::RES_NOTFOUND) {
						$params = array('act'=>'del','key'=>$key,'MCcode'=>parent::getResultCode(), 'MCmessage' => parent::getResultMessage());
						return false;
					}
				}
			}
		}
		return true;
	}

	/* (non-PHPdoc)
	 * @see Comm_Cache_Interface::mget()
	*/
	public function mget(array $keys){
		$ret = parent::getMulti($keys);
		if (false === $ret) {
			$result_code = $this->getResultCode();
			if ($result_code != Memcached::RES_SUCCESS && $result_code != Memcached::RES_NOTFOUND) {
				$params = array('act'=>'mget','key'=>$keys,'MCcode'=>parent::getResultCode(), 'MCmessage' => parent::getResultMessage());
			}
			$ret = array();
		}

		foreach ($keys as $key){
			if(!isset($ret[$key])){
				$ret[$key] = false;
			}
		}
		return $ret;
	}

	/* (non-PHPdoc)
	 * @see Comm_Cache_Interface::mset()
	*/
	public function mset(array $values, $expire = 60){
		return parent::setMulti($values, $expire);
	}

	/* (non-PHPdoc)
	 * @see Comm_Cache_Interface::mdel()
	*/
	public function mdel(array $keys){
		foreach ($keys as $key){
			parent::delete($key);
		}
	}
	
	/**
	 * 
	 */
}
