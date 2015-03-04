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
        $app->post('/local-login', array(new \Routes\Login($di), 'localLogin'));
        $app->get('/local-logout', array(new \Routes\Login($di), 'localLogout'));
        $app->get('/current-user', array(new \Routes\Login($di), 'getCurrentUser'));
        $app->get('/users', array(new \Routes\User($di), 'get'));
        $app->get('/positions', array(new \Routes\Positions($di), 'get'));
        $app->get('/locations', array(new \Routes\Location($di), 'get'));
        $app->get('/seniorities', array(new \Routes\Seniority($di), 'get'));
        $app->post('/referral', array(new \Routes\Referral($di), 'save'));


        $app->handle();
    }

    private function _setup()
    {
        return require_once 'setup.php';
    }
}

$app = new App();
$app->init();