<?php

class Db_Db{
	static protected $default_config_name = 'db_pool';
	static protected $dbs = array();
	
	static public function auto_configure_pool($config_name = NULL){
		if($config_name === NULL){
			$config_name = self::$default_config_name;
		}
		$configs = Tools_Conf::get($config_name);
		foreach ($configs as $type => $aliases){
			$class = "Db_$type";
			if(class_exists($class) && in_array('Db_Interface', class_implements($class))){
			}elseif(class_exists($type) && in_array('Db_Interface', class_implements($type))){
				$class = $type;
			}else{
				throw new Db_Exception("Db type \"$type\" must implements Db_Interface");
			}
			
			foreach ($aliases as $alias => $config){
				self::$dbs[$alias] = new $class();
				self::$dbs[$alias]->configure($alias, $config);
			}
		}
		return;
	}
	
	/**
	 * 
	 * @param unknown_type $db_alias
	 * @return Db_Interface
	 * @throws Db_Exception_Program
	 */
	static public function pool($db_alias){
		if(empty(self::$dbs[$db_alias])){
			throw new Db_Exception('Db alias "' . $db_alias . '" not exist');
		}
		
		return self::$dbs[$db_alias];
	}
	
	static public function clear_all(){
		$ret = self::$dbs;
		self::$dbs = array();
		return $ret;
	}
}