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
        $app->get('/pull', array(new \Routes\Base($di), 'pull'));
        $app->get('/pull/{id:\d+}', array(new \Routes\Base($di), 'pull'));
        $app->post('/login', array(new \Routes\Login($di), 'login'));
        $app->post('/login/logout', array(new \Routes\Login($di), 'logout'));

        $app->handle();
    }

    private function _setup()
    {
        return require_once 'setup.php';
    }
}

$app = new App();
$app->init();