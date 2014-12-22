<?php
namespace Routes;

class Base
{
    /**
     * @var \Phalcon\Http\Request
     */
    public $request;
    /**
     * @var \Phalcon\Http\Response
     */
    public $response;
    /**
     * @var \Phalcon\Session\Adapter\Files
     */
    public $session;
    /**
     * @var \Phalcon\Config\Adapter\Ini
     */
    public $config;
    
    public function __construct(\Phalcon\DI\FactoryDefault $di)
    {
        $this->request = $di->getShared('request');
        $this->response = $di->getShared('response');
        $this->session = $di->getShared('session');
        $this->config = $di->getShared('config');

        $this->_init();
    }

    protected function _init() {}
}