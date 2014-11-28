<?php
class App
{
    public function init()
    {
        $app = new \Phalcon\Mvc\Micro($this->_setup());

        $app->get('/', function() {
            echo 'Hello world!';
        });
        $app->notFound(function() {
            echo '404 mon';
        });

        $routes = new \Routes();

        // Revisit regexp to avoid dual route
        $app->get('/pull', array($routes, 'pull'));
        $app->get('/pull/{id:\d+}', array($routes, 'pull'));

        $app->handle();
    }

    private function _setup()
    {
        return require_once 'setup.php';
    }
}

$app = new App();
$app->init();