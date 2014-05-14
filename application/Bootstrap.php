<?php 
class Bootstrap extends Yaf_Bootstrap_Abstract {
    /**
     * 初始化Loader
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initLoader(Yaf_Dispatcher $dispatcher){
        $localLibrary = array(
			'Tools',
        	'Cache',
        	'Comm',
        	'Db',
        );
        Yaf_Loader::getInstance()->registerLocalNameSpace($localLibrary);
    }
    /**
     * 初始化配置
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initConfig(Yaf_Dispatcher $dispatcher) {
        //Tools_Conf::loadConf(CONF_PATH);
    }
    /**
     * 初始化缓存池
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initCache(Yaf_Dispatcher $dispatcher) {
        Cache_Pool::auto_configure_pool();
    }
    /**
     * 初始化路由
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initRouter(Yaf_Dispatcher $dispatcher) {
        $router = Yaf_Dispatcher::getInstance()->getRouter();
        $router->addConfig(Tools_Conf::get('Yaf_Router'));
    }
    
    /**
     * 初始化多语言包，判断优先级：GET参数 > COOKIE > 浏览器ACCEPT_LANGUAGE > 默认zh_CN
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initI18n(Yaf_Dispatcher $dispatcher) {
        $lang_map = array(
        		'zh-hk' => 'zh_HK',
                'zh-tw' => 'zh_TW',
                'zh-cn' => 'zh_CN',
        		'en-us' => 'en_US',
                );
        //检查GET参数中的lang
        if (isset($_GET['lang']) && isset($lang_map[$_GET['lang']])) {
            $lang = $lang_map[$_GET['lang']];
            if ((isset($_COOKIE['lang']) && $_GET['lang'] != $_COOKIE['lang'])||!isset($_COOKIE['lang'])) {
                //若设置了lang，则写入cookie
                setcookie('lang',$_GET['lang'],time()+86400*365);
            }
        }
        //若没有，检查COOKIE中的lang
        if (!isset($lang) && isset($_COOKIE['lang'])) {
            $lang = $lang_map[$_COOKIE['lang']];
        }
        //若没有，检查浏览器传的ACCEPT_LANGUAGE中首选
        if (!isset($lang) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            //"zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3"
            $arr = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            foreach($arr as $item) {
                $temp = explode(';',$item);
                if (isset($temp[0]) && isset($lang_map[$temp[0]])) {
                    $lang = $lang_map[$temp[0]];
                }
                break;
            }
        }
        //没有则设置为zh_CN
        if (!isset($lang) || !in_array($lang, array_values($lang_map))) {
            $lang = 'zh_CN';
        }
     	Yaf_Registry::set('lang',$lang);
        
        //$domain = trim(file_get_contents(LANG_PATH."/{$lang}/LC_MESSAGES/current"));
        $domain = (empty($_GET['lang'])) ? $_COOKIE['lang'] : $_GET['lang'];
        if(empty($domain))
        	$domain = 'zh-cn';
        putenv("LANG={$lang}");
        setlocale(LC_MESSAGES, "en_US.UTF-8");
        bindtextdomain($domain, LANG_PATH);
        textdomain($domain);
        bind_textdomain_codeset($domain, 'UTF-8');
    }
    
    /**
     * 添加登录验证插件
     * @param Yaf_Dispatcher $dispatcher
     * @return unknown_type
     */
    public function _initPlugin(Yaf_Dispatcher $dispatcher) {
            //$dispatcher->registerPlugin ( new AuthPlugin () );
    }
    
    /**
     * 关闭自动渲染, 系统底层调用render
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initView(Yaf_Dispatcher $dispatcher){
        $dispatcher->disableView();
        $view = $dispatcher->initView(TPL_PATH);
        Yaf_Registry::set("view", $view);
    }
    
    /**
     * 初始化数据库池
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initDb(Yaf_Dispatcher $dispatcher) {
        Db_Db::auto_configure_pool();
    }
}
