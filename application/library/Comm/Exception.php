<?php
class Comm_Exception extends Yaf_Exception {
	public function __construct($message, $code = '', $previous = ''){
		throw new Exception($message);
		return true;
	}
}