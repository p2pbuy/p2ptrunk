<?php
abstract class Cache_Abstract{
	abstract public function getKey($name,$keyName); //获得key
	abstract public function getLiveTime($name); //获得失效时间
}