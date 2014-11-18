<?php
class Tools_Ip {
    static public function getIp(){
        static $client_ip;
        if($client_ip!=NULL){
            return $client_ip;
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ips = array_reverse($ips);
            foreach ($ips as $ip){
                if(empty($ip)) {
                    continue;
                }
                $ip = trim($ip);
                $is_ip = preg_match('|^([0-9]{1,3}\.){3,3}[0-9]{1,3}|', $ip, $regs);
                if ($is_ip && (count($regs) > 0)) {
                    // True IP behind a proxy
                    $ip = $regs[0];
                    $isfind = true;
                    break;
                }
            }
            if ($isfind == true) {
                $client_ip = $ip;
            }
        }
        if ($client_ip ==NULL && !empty($_SERVER['REMOTE_ADDR'])){
            $client_ip = $_SERVER['REMOTE_ADDR'];
        }
        return $client_ip;
    }
    
    static public function getRandip(){
    	$a = rand(0,255);
    	$b = rand(0,255);
    	$c = rand(0,255);
    	$d = rand(0,255);
    	return $a.'.'.$b.'.'.$c.'.'.$d;
    }
    
    /**
     * 修正过的ip2long
     *
     * 可去除ip地址中的前导0。32位php兼容，若超出127.255.255.255，则会返回一个float
     *
     * for example: 02.168.010.010 => 2.168.10.10
     *
     * 处理方法有很多种，目前先采用这种分段取绝对值取整的方法吧……
     * @param string $ip
     * @return float 使用unsigned int表示的ip。如果ip地址转换失败，则会返回0
     */
    static public function ip2long($ip){
    	$ip_chunks = explode('.', $ip, 4);
    	foreach ($ip_chunks as $i => $v){
    		$ip_chunks[$i] = abs(intval($v));
    	}
    	return sprintf('%u', ip2long(implode('.', $ip_chunks)));
    }
    
    /**
     * 判断是否是内网ip
     * @param string $ip
     * @return boolean
     */
    public static function is_private_ip($ip){
    	$ip_value = self::ip2long($ip);
    	return ($ip_value & 0xFF000000) === 0x0A000000 //10.0.0.0-10.255.255.255
    	|| ($ip_value & 0xFFF00000) === 0xAC100000 //172.16.0.0-172.31.255.255
    	|| ($ip_value & 0xFFFF0000) === 0xC0A80000 //192.168.0.0-192.168.255.255
    	|| ($ip_value & 0xFFFFFF00) === 0x3D879800 //61.135.152.0-61.135.152.255
    	|| ($ip_value & 0xFFFFFFFF) === 0xCA6AA9F0 //202.106.169.240
    	;
    }
    
    public static function prov2id($prov_name) {
    	if(!isset($prov_name)) {
    		return false;
    	}
    	$prov_arr = Tools_Conf::get("Area.conf_province");
    	foreach($prov_arr as $k => $v) {
    		if(trim($v) == trim($prov_name)) {
    			return $k;
    		}
    	}
    	return false;
    }
    
    public static function city2id($prov_id, $city_name) {
    	if(!isset($prov_id) || !isset($city_name)) {
    		return false;
    	}
    	$city_arr = Tools_Conf::get("Area.conf_city.{$prov_id}");
    	foreach($city_arr as $k => $v) {
    		if(trim($v) == trim($city_name)) {
    			return $k;
    		}
    	}
    	return false;
    }
}