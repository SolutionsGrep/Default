<?php
namespace Project\Admin;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Db\Adapter\Pdo\Mysql as Database;
class Module
{
    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces(array(
            'Project\Admin\Controllers' => __DIR__ . '/controllers/',
            'Project\Models'             => __DIR__ . '../models/',
            'Project\Plugins'            => __DIR__ . '../plugins/',
        ));
        $loader->register();
    }
    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    public function registerServices(DiInterface $di)
    {
        $config = include __DIR__ . "/config/config.php";

        //Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Project\Admin\Controllers\\");
            return $dispatcher;
        });
        //Registering the view component
        $di->set('view', function () use ($config) {
            $view = new View();
            
            $view->setViewsDir($config->application->viewsDir);
            
			$view->registerEngines(array(
				'.volt' => function ($view, $di) use ($config) {

					$volt = new VoltEngine($view, $di);

					$volt->setOptions(array(
						'compiledPath' => $config->application->cacheDir,
						'compiledSeparator' => '_'
					));

					return $volt;
				},
				'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
			));

            return $view;
        });
        //Set a different connection in each module
        $di->set('db', function () use ($config) {
            return new Database(array(
                "host" => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname" => $config->database->dbname
            ));
        });
    }
}