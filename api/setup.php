<?php
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(
    array(
        'Models' => 'models/',
        'Routes' => 'routes/',
    )
)
->registerPrefixes(
    array(
        'Google' => 'lib/google/apiclient/src/Google',
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
$di->set('session', function() {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();

    return $session;
});

$tokens = array(
    'client_id' => '229737568035-t0isieq89rkd65av2uvebo4iu2jrju43.apps.googleusercontent.com',
    'client_secret' => 'Kfy5Tj5KFho0N62Ykoc8dtt_',
);

return $di;
