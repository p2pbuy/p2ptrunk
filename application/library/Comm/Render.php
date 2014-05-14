<?php
class Comm_Render{
	public static function renderAjax($code = 100000, $message = '', $data = NULL){
		$json_string = json_encode ( array ("code" => $code, "msg" => strval ( $message ), "data" => $data ) );
        echo $json_string;
        return true;
	}
}