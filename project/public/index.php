<?php

error_reporting(E_ALL);
use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;
try {
    class Application extends BaseApplication
    {
        private static $_moduleNames = array("admin", "client");
        /**
         * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
         */
        protected function _registerServices()
        {
            $di = new FactoryDefault();
            $loader = new Loader();
            $DEFAULT_MODULE = 'client';
            /**
             * We're a registering a set of directories taken from the configuration file
             */
            $loader->registerDirs(
                array(
                    __DIR__ . '/../apps/library/'
                )
            )->register();
            //Registering a router
            $di->set('router', function () use ($DEFAULT_MODULE) {
                $router = new Router();
                    $router->setDefaultModule($DEFAULT_MODULE);
                    //controlador default
                    $router->add('/:controller', array(
                       'module' =>  $DEFAULT_MODULE,
                       'controller' => 1,
                       'action' => 'index'
                    ));
                    $router->add('/:controller/', array(
                       'module' =>  $DEFAULT_MODULE,
                       'controller' => 1,
                       'action' => 'index'
                    ));
                    //action default
                    $router->add('/:controller/:action', array(
                        'module' => $DEFAULT_MODULE,
                        'controller' => 1,
                        'action' => 2
                    ));
                    $router->add('/:controller/:action/', array(
                        'module' => $DEFAULT_MODULE,
                        'controller' => 1,
                        'action' => 2
                    ));
                    $router->add('/:controller/:action/:params', array(
                        'module' => $DEFAULT_MODULE,
                        'controller' => 1,
                        'action' => 2,
                        'params' => 3
                    ));
                    //---------------------------router admin----------------------------//
                    //modulo admin
                    $router->add("/admin/", array(
                        'module' => 'admin',
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                    $router->add("/admin", array(
                        'module' => 'admin',
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                    //controlador admin
                    $router->add("/admin/:controller/", array(
                        'module' => 'admin',
                        'controller' => 1,
                        'action' => 'index'
                    ));
                    $router->add("/admin/:controller", array(
                        'module' => 'admin',
                        'controller' => 1,
                        'action' => 'index'
                    ));
                    //admin admin
                    $router->add("/admin/:controller/:action", array(
                        'module' => 'admin',
                        'controller' => 1,
                        'action' => 2,
                    ));
                    $router->add("/admin/:controller/:action/", array(
                        'module' => 'admin',
                        'controller' => 1,
                        'action' => 2,
                    ));
                    $router->add("/admin/:controller/:action/:params", array(
                        'module' => 'admin',
                        'controller' => 1,
                        'action' => 2,
                        'params' => 3
                    ));
                    //--------------------------router client---------------------------//
                    //modulo client
                    $router->add("/client/", array(
                        'module' => 'client',
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                    $router->add("/client", array(
                        'module' => 'client',
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                    //controlador client
                    $router->add("/client/:controller", array(
                        'module' => 'client',
                        'controller' => 1,
                        'action' => 'index'
                    ));
                    $router->add("/client/:controller/", array(
                        'module' => 'client',
                        'controller' => 1,
                        'action' => 'index'
                    ));
                    //action client
                    $router->add("/client/:controller/:action", array(
                        'module' => 'client',
                        'controller' => 1,
                        'action' => 2,
                    ));
                    $router->add("/client/:controller/:action/:params", array(
                        'module' => 'client',
                        'controller' => 1,
                        'action' => 2,
                        'params' => 3
                    ));
                return $router;
            });
            $this->setDI($di);
        }
        public function main()
        {
            $this->_registerServices();
            //Register the installed modules
            $this->registerModules(array(
                'client' => array(
                    'className' => 'Project\Client\Module',
                    'path' => '../apps/client/Module.php'
                ),
                'admin' => array(
                    'className' => 'Project\Admin\Module',
                    'path' => '../apps/admin/Module.php'
                )
            ));
            echo $this->handle()->getContent();
        }
    }
    $application = new Application();
    $application->main();

} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo "<pre>";
    print_r($e);
    echo "</pre>";
    echo $e->getMessage();
}