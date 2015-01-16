<?php
$config = new \Phalcon\Config\Adapter\Ini('config/config.ini');
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
$di->set('config', $config);
$di->set('db', function() use ($config) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(
        array(
            'host' => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->name,
        )
    );
});
$di->set('session', function() {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();

    return $session;
});

 $di->set('modelsManager', function() {
      return new Phalcon\Mvc\Model\Manager();
 });
 
$tokens = array(
    'client_id' => '229737568035-t0isieq89rkd65av2uvebo4iu2jrju43.apps.googleusercontent.com',
    'client_secret' => 'Kfy5Tj5KFho0N62Ykoc8dtt_',
);

return $di;
