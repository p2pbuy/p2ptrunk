<?php
class Comm_Context {
    protected static $context_data=array();
    public static function get($name, $type = 'str', $default = null, $is_filter = false){
    	return isset($_GET[$name]) ? self::filter($_GET[$name], $type, $is_filter) : $default;
    }
    
    public static function post($name, $type = 'str', $default = null, $is_filter = false){
        return isset($_POST[$name]) ? self::filter($_POST[$name], $type, $is_filter) : $default;
    }
    
    private static function filter($param, $type, $is_filter = false){
        $type = strtolower($type);
        switch($type) {
                case 'int':
                        $param = $param + 0;
                        break;
                case 'str':
                        $param = ($is_filter == true) ? htmlspecialchars((string)$param, ENT_QUOTES) : (string)$param;
                        break;
                default:
                        $param = NULL;
                        break;
        }
        return $param;
    }
}