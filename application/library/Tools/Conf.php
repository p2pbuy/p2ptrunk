<?php
class Tools_Conf {
    /**
     * 配置数组
     * @var array
     */
    protected static $_conf = array();
    /**
     * 加载配置文件
     * @param string $path
     */
    static public function loadConf($path) {
        $files = glob($path.'/*.ini');
        foreach ($files as $file) {
            $key = substr(strrchr($file,'/'),1,-4);
            $conf = new Yaf_Config_Ini($file);
            self::$_conf[$key] = $conf->toArray();
        }
    }
    static public function get($path) {
        $keys = explode('.', $path);
        $key  = $keys[0];
        
        if(!isset(self::$_conf[$key])){
            $file = CONF_PATH.'/'.$key.'.ini';
            $conf = new Yaf_Config_Ini($file);
            self::$_conf[$key] = $conf->toArray();
        }
        $current = self::$_conf;
        foreach ($keys as $key ){
            if (isset($current[$key])) {
                $current = &$current[$key];
            } else {
                $current = array();
            }
        }
        return $current;
    }
}
