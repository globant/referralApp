<?php
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(
    array(
        'Models' => 'models/',
    )
)->registerClasses(
    array(
        'Routes' => 'Routes.php',
    )
)->register();

$di = new \Phalcon\DI\FactoryDefault();
$di->set('db', function(){
    return new \Phalcon\Db\Adapter\Pdo\Mysql(
        array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname' => 'micro'
        )
    );
});

return $di;
