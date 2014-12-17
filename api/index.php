<?php
class App
{
    public function init()
    {
        $di = $this->_setup();
        $app = new \Phalcon\Mvc\Micro($di);

        $app->notFound(function() {
            echo '404 mon';
        });

        // Revisit regexp to avoid dual route
        $app->post('/login', array(new \Routes\Login($di), 'login'));
        $app->post('/login/logout', array(new \Routes\Login($di), 'logout'));
        $app->post('/local-login', array(new \Routes\Login($di), 'local_login'));
        $app->get('/positions', array(new \Routes\Positions($di), 'get'));


        $app->handle();
    }

    private function _setup()
    {
        return require_once 'setup.php';
    }
}

$app = new App();
$app->init();