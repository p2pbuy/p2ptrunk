<?php 
class ErrorController extends Yaf_Controller_Abstract {
	public function errorAction($exception) {
		error_log("Warning Uncaught Exception:" . $exception->getMessage());
	}
}
