<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
  /**
     * Init Autoloader
     */
    public static $_autoloader;
    //  public static $namespace = 'Tariq';
    public function _initAutoloader() {
        // add namespaces for libraries
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Custom_');

        //autoloading of modules is controlled via application.ini:
        //resources.modules[] = ""
        //+ be sure to include a Boostrap.php in every modules to autoload it!

        $autoloader->suppressNotFoundWarnings(false);
        
        if (is_null(self::$_autoloader)) {

            self::$_autoloader = new Zend_Application_Module_Autoloader(array(
                        'namespace' => '',
                        'basePath' => APPLICATION_PATH
                    ));

            self::$_autoloader->setResourceTypes(array(
                'plugin' => array(
                    'namespace' => 'Plugin',
                    'path' => 'plugin'
                ),
                'model' => array(
                    'namespace' => 'Model',
                    'path' => 'models'
                ),
                'core' => array(
                    'namespace' => 'Core',
                    'path' => 'core'
                ),
                'dbtable' => array(
                    'namespace' => 'DbTable',
                    'path' => 'models/DbTable'
                ),
                'dbrowset' => array(
                    'namespace' => 'DbRowset',
                    'path' => 'models/DbRowset'
                ),
                'dbrow' => array(
                    'namespace' => 'DbRow',
                    'path' => 'models/DbRow'
                ),
                'viewhelper' => array(
                    'namespace' => 'View_Helper',
                    'path' => 'views/helpers'
                ),
                'form' => array(
                    'namespace' => 'Form',
                    'path' => 'forms'
                )
            ));
            new Zend_Loader_PluginLoader();
        }


        return self::$_autoloader;
    }

    
    protected function _initDbugLoad() {
        //$this->bootstrap('')
         
      
        //$this->bootstrap('autoload');
        $view = new Zend_View();
        Zend_Dojo::enableView($view);
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->setView($view);
    }
    
    /**
     * Set up autoloading, auth and ACL
     * @return  
     */
    public function _initAccessChecks()
    {
        $auth = Zend_Auth::getInstance();
	
        // Model_Acl uses auth to load only appropriate ACL rules
        
        $acl = new Model_Acl($auth);
        $fc = Zend_Controller_Front::getInstance();
        $fc->registerPlugin( new Plugin_AccessCheck( $acl, $auth ) );
        Zend_Registry::set( 'roleInt', $acl->getRoleInt() );
	define('ACL_ROLE', $acl->role );
        return $acl;
    }
   

  

    /**
     * Auto-load modules.
     */
    protected function _initAppAutoload() {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => '',
                    'basePath' => dirname(__FILE__)));
    }

    public function _initErrorhandler() {
        $plugin = new Zend_Controller_Plugin_ErrorHandler();
        $plugin->setErrorHandler(array(
            'module' => '',
            'controller' => 'error',
            'action' => 'error'
        ));
        Zend_Controller_Front::getInstance()->registerPlugin($plugin);
    }

    /**
     * Init view and helper
     */
    public function _initView() {
        // make custom view helpers available
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->initView();

        $viewRenderer->view->addHelperPath(APPLICATION_PATH . '/views/helpers/', 'Custom_View_Helper_');

        // add default view scripts to path
        $viewRenderer->view->addScriptPath(APPLICATION_PATH . '/views/scripts/');

        // init doctype
        $viewRenderer->view->doctype('XHTML1_STRICT');
    }

    /**
     * Init Zend_Locale. Determine locale through the client's browser object.
     */
    protected function _initLocale() {
        $locale = null;

        try {
            $locale = new Zend_Locale(Zend_Locale::BROWSER);
        } catch (Zend_Locale_Exception $e) { //fallback to default locale
            $locale = new Zend_Locale('en_US');
        }

        Zend_Registry::set('Zend_Locale', $locale); //set default locale detected by browser
        Zend_Registry::set('Server_Locale', new Zend_Locale('en_US'));
    }


}


    require_once APPLICATION_PATH . '/debug.php';
    require_once APPLICATION_PATH . '/dBug.php';
